<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;



use App\Models\Letter;

class LetterController extends Controller
{

     public function getData(Request $request)
    {
        $letters = Letter::select(['id', 'no', 'status','source', 'desc', 'created_at'])->get();
        return DataTables::of($letters)
            ->addColumn('action', function ($letter) {
                return '<a href="'.route('admin.letter.edit', $letter->id).'" class="btn btn-sm btn-primary">Edit</a>
                        <a href="'.route('admin.letter.show', $letter->id).'" class="btn btn-sm btn-info">View</a>
                        <form action="'.route('admin.letter.destroy', $letter->id).'" method="POST" style="display:inline;">
                            '.csrf_field().method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function index(): View
    {
        return view('backend.admin.letter.index', [
            // 'items' => Room::latest()->paginate(10),
            'title' => 'Surat',
        ]);
    }

    public function create(): View
    {
        return view('backend.admin.letter.create', [
            // 'charges' => ChargeType::all(),
            'title' => 'Tambah Surat',
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'no' => 'required|max:255',
            'source' => 'required|max:255',
            'desc' => '',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,heic|max:4096',
            'remark' => '',
        ]);
    
        // Upload & compress file
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $ext = strtolower($file->getClientOriginalExtension());
    
            // Tentukan nama file
            $filename = uniqid() . '.' . ($ext === 'heic' ? 'jpg' : $ext);
    
            // Path simpan
            $path = storage_path('app/public/letters/' . $filename);

    
            // === COMPRESS ALGORITMA ===
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'heic'])) {
    
                // Baca gambar
                $image = Image::make($file->getRealPath());
    
                // Resize HALUS jika terlalu besar (maks 2000px)
                $image->resize(2000, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
    
                // Simpan dengan kualitas 80 (aman, tidak blur)
                $image->save($path, 80); 
            } else {
                // File pdf or non-image → simpan langsung
                $file->storeAs('public/letters', $filename);

            }
    
            $validatedData['file'] = 'letters/' . $filename;
        }
    
        // Default status
        $validatedData['status'] = 'Proses Kabid';
    
        Letter::create($validatedData);
    
        return redirect('/dashboard/admin/letter')->with('success', 'Surat Baru Telah Ditambahkan');
    }
    
    public function edit(Letter $letter)
    {
        return view('backend.admin.letter.edit', [
            'item' => $letter,
            'title' => 'Edit Surat',
        ]);
    }

    public function update(Request $request, Letter $letter)
    {
        $validatedData = $request->validate([
            'no' => 'required|max:255',
            'source' => 'required|max:255',
            'desc' => '',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,heic|max:4096',
            'remark' => '',
        ]);
    
        // --- HANDLING FILE UPDATE ---
        if ($request->hasFile('file')) {
    
            // HAPUS FILE LAMA jika ada
            if ($letter->file && Storage::exists('public/' . $letter->file)) {
                Storage::delete('public/' . $letter->file);
            }
    
            $file = $request->file('file');
            $ext = strtolower($file->getClientOriginalExtension());
    
            // Tentukan nama file baru
            $filename = uniqid() . '.' . ($ext === 'heic' ? 'jpg' : $ext);
    
            // Path penyimpanan
            $path = storage_path('app/public/letters/' . $filename);
    
            // === COMPRESS IMAGE ===
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'heic'])) {
    
                $image = Image::make($file->getRealPath());
    
                // Resize halus
                $image->resize(2000, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
    
                $image->save($path, 80); // kualitas aman
            } else {
                // Untuk pdf/non-image
                $file->storeAs('public/letters', $filename);
            }
    
            // Simpan ke DB
            $validatedData['file'] = 'letters/' . $filename;
        }
    
        // Status **tidak diubah** (biarkan sesuai workflow)
        // $validatedData['status'] = $letter->status;
    
        // UPDATE DATA
        $letter->update($validatedData);
    
        return redirect('/dashboard/admin/letter')->with('success', 'Surat Berhasil Diupdate');
    }
    
    public function show(Letter $letter)
    {
        return view('backend.admin.letter.detail', [
            'item' => $letter,
            'title' => 'Detail Surat',
        ]);
    }
    public function destroy(Letter $letter)
    {
        $letter = Letter::findOrFail($letter->id);
        $letter->delete();

        return redirect('/dashboard/admin/letter')->with('success', 'Surat Telah Dihapus');

    }
}

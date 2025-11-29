<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;




use App\Models\Letter;
use App\Models\Log;

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
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,heic|max:10240',
            'remark' => '',
        ]);
    
        // Upload & compress file
        if ($request->hasFile('file')) {

            $file = $request->file('file');
            $ext = strtolower($file->getClientOriginalExtension());
        
            // convert HEIC → JPG
            $saveExt = ($ext === 'heic' ? 'jpg' : $ext);
        
            // nama file unik
            $filename = uniqid() . '.' . $saveExt;
        
            // folder tujuan relatif ke disk
            $folder = 'letters';
            $relativePath = $folder . '/' . $filename;
        
            // --- CHECK FOLDER DI DISK ---
            if (!Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->makeDirectory($folder);
            }
        
            // === COMPRESS IMAGE ===
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'heic'])) {
        
                // load image
                $image = Image::make($file->getRealPath());
        
                // resize max 2000px
                $image->resize(2000, null, function ($c) {
                    $c->aspectRatio();
                    $c->upsize();
                });
        
                // simpan sementara di memory
                $tempPath = sys_get_temp_dir() . '/' . $filename;
                $image->save($tempPath, 80);
        
                // upload file hasil compress
                Storage::disk('public')->put($relativePath, file_get_contents($tempPath));
        
                // hapus temp file
                unlink($tempPath);
        
            } else {
                // PDF atau non-image → disimpan langsung
                Storage::disk('public')->putFileAs($folder, $file, $filename);
            }
        
            // Simpan path ke database
            $validatedData['file'] = $relativePath;
        }
        
    
        // Default status
        $validatedData['status'] = 'Proses Kabid';
    
        Letter::create($validatedData);
        $nameUser = Auth::user()->name;
        $idUser = Auth::id();
        Log::create([
            'activity' => "$nameUser Membuat Surat Dengan Nomor $request->no",
            'created_by' => $idUser,
        ]);
    
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
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,heic|max:10240',
            'remark' => '',
        ]);
    
        // --- HANDLING FILE UPDATE ---
        if ($request->hasFile('file')) {

            // --- HAPUS FILE LAMA ---
            if ($letter->file && Storage::disk('public')->exists($letter->file)) {
                Storage::disk('public')->delete($letter->file);
            }
        
            $file = $request->file('file');
            $ext = strtolower($file->getClientOriginalExtension());
        
            // HEIC → JPG
            $saveExt = ($ext === 'heic' ? 'jpg' : $ext);
        
            // nama file baru
            $filename = uniqid() . '.' . $saveExt;
        
            // folder tujuan (di dalam disk public)
            $folder = 'letters';
            $relativePath = $folder . '/' . $filename;
        
            // pastikan folder ada
            if (!Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->makeDirectory($folder);
            }
        
            // === COMPRESS handling ===
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'heic'])) {
        
                $image = Image::make($file->getRealPath());
        
                // resize max width 2000px
                $image->resize(2000, null, function ($c) {
                    $c->aspectRatio();
                    $c->upsize();
                });
        
                // simpan sementara
                $tempPath = sys_get_temp_dir() . '/' . $filename;
                $image->save($tempPath, 80);
        
                // upload ke storage
                Storage::disk('public')->put($relativePath, file_get_contents($tempPath));
        
                // hapus temp
                unlink($tempPath);
        
            } else {
                // PDF atau non-image
                Storage::disk('public')->putFileAs($folder, $file, $filename);
            }
        
            // Simpan path ke DB
            $validatedData['file'] = $relativePath;
        }
        
    
        // Status **tidak diubah** (biarkan sesuai workflow)
        // $validatedData['status'] = $letter->status;
    
        // UPDATE DATA
        $letter->update($validatedData);
        $nameUser = Auth::user()->name;
        $idUser = Auth::id();
        Log::create([
            'activity' => "$nameUser Mengubah Surat Dengan Nomor $request->no",
            'created_by' => $idUser,
        ]);
    
    
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

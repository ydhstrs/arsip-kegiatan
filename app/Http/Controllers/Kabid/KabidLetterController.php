<?php

namespace App\Http\Controllers\Kabid;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;




use App\Models\Letter;
use App\Models\User;
use App\Models\Log;


class KabidLetterController extends Controller
{

    public function getData(Request $request)
    {
        $letters = Letter::select(['id', 'no', 'status','source', 'desc', 'created_at'])->get();
    
        return DataTables::of($letters)
            ->addColumn('action', function ($letter) {
    
                $btn = '';
    
                // tampilkan hanya jika status = Proses Kabid
                if ($letter->status === 'Proses Kabid') {
                    $btn .= '<a href="'.route('kabid.letter.edit', $letter->id).'" 
                                class="btn btn-sm btn-primary">Teruskan</a> ';
                }
    
                // Tombol lihat selalu tampil
                $btn .= '<a href="'.route('kabid.letter.show', $letter->id).'" 
                            class="btn btn-sm btn-info">Lihat</a>';
    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    
    public function index(): View
    {
        return view('backend.kabid.letter.index', [
            // 'items' => Room::latest()->paginate(10),
            'title' => 'Surat',
        ]);
    }

    public function create(): View
    {

    }

    public function store(Request $request)
    {
     
    }
    
    public function edit(Letter $letter)
    {   
        $kasis = User::role('Kasi')->get();
        // $kasi = User::select(['id', 'no', 'status','source', 'desc', 'created_at'])->where()->get();
        return view('backend.kabid.letter.edit', [
            'item' => $letter,
            'kasis' => $kasis,
            'title' => 'Teruskan Surat',
        ]);
    }

    public function update(Request $request, Letter $letter)
    {
        $validatedData = $request->validate([
            'kasi_user_id' => 'required|max:11',
            'remark_kabid' => '',
        ]);
        $validatedData['status'] = 'Proses Kasi';

        $letter->update($validatedData);
        $nameUser = Auth::user()->name;
        $idUser = Auth::id();
        $kasi = User::find($request->kasi_user_id);
        $kasiName = $kasi ? $kasi->name : 'Unknown User';
        Log::create([
            'activity' => "$nameUser Meneruskan Surat ke $kasiName Dengan Nomor $letter->no",
            'created_by' => $idUser,
        ]);
    
        return redirect('/dashboard/kabid/letter')->with('success', 'Surat Berhasil Diupdate');
    }
    
    public function show(Letter $letter)
    {
        return view('backend.kabid.letter.detail', [
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

<?php

namespace App\Http\Controllers\Kasat;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;



use App\Models\Letter;
use App\Models\User;

class KasatLetterController extends Controller
{

    public function getData(Request $request)
    {
        $letters = Letter::select(['id', 'no', 'status','source', 'desc', 'created_at'])->get();
    
        return DataTables::of($letters)
            ->addColumn('action', function ($letter) {
    
                $btn = '';
    
                // Tombol lihat selalu tampil
                $btn .= '<a href="'.route('kasat.letter.show', $letter->id).'" 
                            class="btn btn-sm btn-info">Lihat</a>';
    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    
    public function index(): View
    {
        return view('backend.kasat.letter.index', [
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

    }

    public function update(Request $request, Letter $letter)
    {

    }
    
    public function show(Letter $letter)
    {
        return view('backend.kasat.letter.detail', [
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

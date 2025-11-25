<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;


use App\Models\Letter;
use App\Models\User;

class StaffLetterController extends Controller
{

    public function getData(Request $request)
    {   
        $userId = Auth::id();
    
        // Filter surat khusus staff
        $letters = Letter::select(['id', 'no', 'status', 'source', 'desc', 'created_at'])
            ->whereNotIn('status', ['Proses Kabid', 'Proses Kasi'])
            ->where('staff_user_id', $userId)
            ->get();
    
        return DataTables::of($letters)
            ->addColumn('action', function ($letter) {
    
                $btn = '';
    
                // Jika status masih di Staff -> tampilkan Buat Laporan
                if ($letter->status === 'Proses Staff') {
    
                    // Route ke create laporan (bukan edit surat)
                    $btn .= '<a href="'.route('staff.report.create', $letter->id).'" 
                                class="btn btn-sm btn-primary">Buat Laporan</a> ';
                }
    
                // Tombol lihat selalu tampil
                $btn .= '<a href="'.route('staff.letter.show', $letter->id).'" 
                            class="btn btn-sm btn-info">Lihat</a>';
    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    
    
    public function index(): View
    {
        return view('backend.staff.letter.index', [
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
        return view('backend.staff.letter.detail', [
            'item' => $letter,
            'title' => 'Detail Surat',
        ]);
    }
    public function destroy(Letter $letter)
    {

    }
}

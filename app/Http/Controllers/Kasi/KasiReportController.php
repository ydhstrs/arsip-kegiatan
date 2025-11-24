<?php

namespace App\Http\Controllers\Kasi;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;


use App\Models\Letter;
use App\Models\Report;
use App\Models\User;

class KasiReportController extends Controller
{

    public function getData(Request $request)
    {   
        $userId = Auth::id();
    
        // include relasi letter agar bisa ambil 'no'
        $reports = Report::with('letter:id,no')
            ->select(['id', 'letter_id', 'title', 'status', 'desc', 'created_at'])
            ->where('kasi_user_id', $userId)
            ->get();
    
        return DataTables::of($reports)
    
            // Tambah kolom nomor surat
            ->addColumn('no_surat', function ($report) {
                return $report->letter->no ?? '-';
            })
    
            ->addColumn('action', function ($report) {
    
                $btn = '';
    
                // tampilkan hanya jika status = Proses Kabid
                if ($report->status === 'Proses Kasi') {
                    $btn .= '<a href="'.route('kasi.report.edit', $report->id).'" 
                                class="btn btn-sm btn-primary">Teruskan</a> ';
                }
    
                // Tombol lihat selalu tampil
                $btn .= '<a href="'.route('kasi.report.show', $report->id).'" 
                            class="btn btn-sm btn-info">Lihat</a>';
    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    
    public function index(): View
    {
        return view('backend.kasi.report.index', [
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
        $staffs = User::role('Staff')->get();
        // $kasi = User::select(['id', 'no', 'status','source', 'desc', 'created_at'])->where()->get();
        return view('backend.kasi.letter.edit', [
            'item' => $letter,
            'staffs' => $staffs,
            'title' => 'Teruskan Surat',
        ]);
    }

    public function update(Request $request, Letter $letter)
    {
        $validatedData = $request->validate([
            'staff_user_id' => 'required|max:11',
            'remark_kasi' => '',
        ]);
        $validatedData['status'] = 'Proses Staff';

        $letter->update($validatedData);
    
        return redirect('/dashboard/kasi/letter')->with('success', 'Surat Berhasil Diupdate');
    }
    
    public function show(Letter $letter)
    {
        return view('backend.kasi.letter.detail', [
            'item' => $letter,
            'title' => 'Detail Surat',
        ]);
    }
    public function destroy(Letter $letter)
    {

    }
}

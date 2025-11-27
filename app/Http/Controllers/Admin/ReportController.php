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
use App\Models\Report;
use App\Models\User;

class ReportController extends Controller
{

    public function getData(Request $request)
    {   
        $userId = Auth::id();
    
        // include relasi letter agar bisa ambil 'no'
        $reports = Report::with('letter:id,no')
        ->select(['id', 'letter_id', 'title', 'status', 'desc', 'created_at'])
        ->where('status', 'Disetujui')
        ->get();
    
        return DataTables::of($reports)
    
            // Tambah kolom nomor surat
            ->addColumn('no_surat', function ($report) {
                return $report->letter->no ?? '-';
            })
    
            ->addColumn('action', function ($report) {
    
                $btn = '';

                // Tombol lihat selalu tampil
                $btn .= '<a href="'.route('admin.report.show', $report->id).'" 
                            class="btn btn-sm btn-info">Lihat</a>';
                $btn .= '<a href="'.route('admin.report.print', $report->id).'" 
                            class="btn btn-sm btn-info">Print</a>';
    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    
    public function index(): View
    {
        return view('backend.admin.report.index', [
            // 'items' => Room::latest()->paginate(10),
            'title' => 'Laporan',
        ]);
    }

    public function create(): View
    {

    }

    public function store(Request $request)
    {
     
    }
    
    public function edit(Report $report)
    {   

    }

    public function update(Request $request, Report $report)
    {

    }

    
    public function show(Report $report)
    {
        return view('backend.admin.report.detail', [
            'item' => $report,
            'title' => 'Detail Laporan',
        ]);
    }
    public function print(Request $request, $id)
    {
        return view('backend.admin.report.print', [
            'item' => $report,
            'title' => 'Print Laporan',
        ]);
    }
}


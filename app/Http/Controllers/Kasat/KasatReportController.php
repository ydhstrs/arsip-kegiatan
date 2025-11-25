<?php

namespace App\Http\Controllers\Kasat;

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

class KasatReportController extends Controller
{

    public function getData(Request $request)
    {   
        $userId = Auth::id();
    
        // include relasi letter agar bisa ambil 'no'
        $reports = Report::with('letter:id,no')
        ->select(['id', 'letter_id', 'title', 'status', 'desc', 'created_at'])
        ->get();
    
        return DataTables::of($reports)
    
            // Tambah kolom nomor surat
            ->addColumn('no_surat', function ($report) {
                return $report->letter->no ?? '-';
            })
    
            ->addColumn('action', function ($report) {
    
                $btn = '';

                // Tombol lihat selalu tampil
                $btn .= '<a href="'.route('kasat.report.show', $report->id).'" 
                            class="btn btn-sm btn-info">Lihat</a>';
    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    
    public function index(): View
    {
        return view('backend.kasat.report.index', [
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
        return view('backend.kasat.report.detail', [
            'item' => $report,
            'title' => 'Detail Laporan',
        ]);
    }
}


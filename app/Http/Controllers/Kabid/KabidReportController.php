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
use App\Models\Report;
use App\Models\User;

class KabidReportController extends Controller
{

    public function getData(Request $request)
    {   
        $userId = Auth::id();
    
        // include relasi letter agar bisa ambil 'no'
        $reports = Report::with('letter:id,no')
            ->select(['id', 'letter_id', 'title', 'status', 'desc', 'created_at'])
            ->where('status', 'Proses Kabid')
            ->get();
    
        return DataTables::of($reports)
    
            // Tambah kolom nomor surat
            ->addColumn('no_surat', function ($report) {
                return $report->letter->no ?? '-';
            })
    
            ->addColumn('action', function ($report) {
    
                $btn = '';
    
                // tampilkan hanya jika status = Proses Kabid
                if ($report->status === 'Proses Kabid') {
                    $btn .= '
                    <form action="'.route('kabid.report.approve', $report->id).'" method="POST" style="display:inline;">
                        '.csrf_field().'
                        <button type="submit" class="btn btn-sm btn-primary"
                            onclick="return confirm(\'Yakin setujui laporan ini?\')">Disetujui</button>
                    </form>
                    ';
                    $btn .= '<a href="'.route('kabid.report.edit', $report->id).'" 
                                class="btn btn-sm btn-primary">Revisi</a> ';
                                
                }
    
                // Tombol lihat selalu tampil
                $btn .= '<a href="'.route('kabid.report.show', $report->id).'" 
                            class="btn btn-sm btn-info">Lihat</a>';
    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    
    public function index(): View
    {
        return view('backend.kabid.report.index', [
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
    
    public function edit(Report $report)
    {   
        $staffs = User::role('Staff')->get();
        // $kasi = User::select(['id', 'no', 'status','source', 'desc', 'created_at'])->where()->get();
        return view('backend.kabid.report.edit', [
            'item' => $report,
            'staffs' => $staffs,
            'title' => 'Revisi Laporan',
        ]);
    }

    public function update(Request $request, Report $report)
    {
        $validatedData = $request->validate([
            'remark_kabid' => '',
        ]);
        $validatedData['status'] = 'Revisi Kabid';

        $report->update($validatedData);
    
        return redirect('/dashboard/kabid/report')->with('success', 'Laporan Berhasil Direvisi');
    }

    public function approve(Request $request, $id)
    {
        $report = Report::findOrFail($id);
    
        // Update status ke Proses Kabid
        $report->update([
            'status' => 'Proses Kabid',
            // 'kasi_approved_at' => now(), // kalau mau
        ]);
    
    
        return redirect('/dashboard/kasi/report')->with('success', 'Surat Berhasil Disetujui');

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

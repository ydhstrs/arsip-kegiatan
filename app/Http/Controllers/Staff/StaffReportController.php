<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;



use App\Models\Report;
use App\Models\Letter;
use App\Models\User;

class StaffReportController extends Controller
{

    public function getData(Request $request)
    {   
        $userId = Auth::id();
    
        // include relasi letter agar bisa ambil 'no'
        $reports = Report::with('letter:id,no')
            ->select(['id', 'letter_id', 'title', 'status', 'desc', 'created_at'])
            ->where('staff_user_id', $userId)
            ->get();
    
        return DataTables::of($reports)
    
            // Tambah kolom nomor surat
            ->addColumn('no_surat', function ($report) {
                return $report->letter->no ?? '-';
            })
    
            ->addColumn('action', function ($report) {
    
                $btn = '';
    
                // tampilkan hanya jika status = Proses Kabid
                if ($report->status === 'zzz') {
                    $btn .= '<a href="'.route('staff.report.edit', $report->id).'" 
                                class="btn btn-sm btn-primary">Teruskan</a> ';
                }
    
                // Tombol lihat selalu tampil
                $btn .= '<a href="'.route('staff.report.show', $report->id).'" 
                            class="btn btn-sm btn-info">Lihat</a>';
    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    
    
    public function index(): View
    {
        return view('backend.staff.report.index', [
            // 'items' => Room::latest()->paginate(10),
            'title' => 'Laporan',
        ]);
    }

    public function create($letter_id): View
    {
        // Ambil data surat yang akan dibuat laporannya
        $letter = Letter::findOrFail($letter_id);
    
        // Kirim ke view create laporan
        return view('backend.staff.report.create', [
            'title' => 'Buat Laporan',
            'letter' => $letter,
        ]);
    }


public function store(Request $request)
{
    $validated = $request->validate([
        'letter_id' => 'required|exists:letters,id',
        'title'     => 'required|string|max:255',
        'desc'      => 'nullable|string',

        'file1'     => 'nullable|file|mimes:jpg,jpeg,png,heic|max:10240',
        'file2'     => 'nullable|file|mimes:jpg,jpeg,png,heic|max:10240',
        'video'     => 'nullable|mimes:mp4,mkv,avi,mov|max:51200',
    ]);
    $validated['status'] = 'Proses Kasi';


    // Path hasil
    $file1Path = null;
    $file2Path = null;
    $videoPath = null;

    /* ================================
       COMPRESS FILE 1
    =================================*/
    if ($request->hasFile('file1')) {

        $file = $request->file('file1');
        $ext = strtolower($file->getClientOriginalExtension());

        $filename = uniqid() . '.' . ($ext === 'heic' ? 'jpg' : $ext);
        $path = storage_path('app/public/report_images/' . $filename);

        // Jika image → compress
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'heic'])) {

            $image = Image::make($file->getRealPath());

            // resize max 2000px
            $image->resize(2000, null, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });

            // simpan kualitas 80
            $image->save($path, 80);
        } else {
            // fallback (harusnya ga mungkin)
            $file->storeAs('public/report_images', $filename);
        }

        $file1Path = 'report_images/' . $filename;
    }

    /* ================================
       COMPRESS FILE 2
    =================================*/
    if ($request->hasFile('file2')) {

        $file = $request->file('file2');
        $ext = strtolower($file->getClientOriginalExtension());

        $filename = uniqid() . '.' . ($ext === 'heic' ? 'jpg' : $ext);
        $path = storage_path('app/public/report_images/' . $filename);

        if (in_array($ext, ['jpg', 'jpeg', 'png', 'heic'])) {

            $image = Image::make($file->getRealPath());

            $image->resize(2000, null, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });

            $image->save($path, 80);
        } else {
            $file->storeAs('public/report_images', $filename);
        }

        $file2Path = 'report_images/' . $filename;
    }

    /* ================================
       SAVE VIDEO (TIDAK COMPRESS)
    =================================*/
    if ($request->hasFile('video')) {
        $videoPath = $request->file('video')->store('report_videos', 'public');
    }

    /* ================================
       INSERT DATABASE
    =================================*/
    $kasiId = Letter::where('id', $request->letter_id)
                ->value('kasi_user_id'); // langsung ambil 1 kolom
    Report::create([
        'letter_id'      => $request->letter_id,
        'title'          => $request->title,
        'desc'           => $request->desc,
        'file1'         => $file1Path,
        'file2'         => $file2Path,
        'video'          => $videoPath,
        'status'          => 'Proses Kasi',
        'staff_user_id'  => auth()->id(),
        'kasi_user_id'  => $kasiId,
    ]);

    // Update status pada Letter
    Letter::where('id', $request->letter_id)->update([
        'status' => 'Laporan Dibuat'
    ]);

    return redirect()
        ->route('staff.report.index')
        ->with('status', 'Laporan berhasil dibuat');
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
    
    public function show(Report $report)
    {
        return view('backend.staff.report.detail', [
            'report' => $report,
            'title' => 'Detail Laporan',
        ]);
    }
    public function destroy(Letter $letter)
    {

    }
}

<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use App\Models\Log;
use App\Models\Report;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

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
                if ($report->status === 'Revisi Kasi') {
                    $btn .= '<a href="'.route('staff.report.edit', $report->id).'" 
                                class="btn btn-sm btn-primary">Revisi</a> ';
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
            'title' => 'required|string|max:255',
            'desc' => 'nullable|string',

            'file1' => 'nullable|file|mimes:jpg,jpeg,png,heic|max:10240',
            'file2' => 'nullable|file|mimes:jpg,jpeg,png,heic|max:10240',
            'file3' => 'nullable|file|mimes:jpg,jpeg,png,heic|max:10240',
            'file4' => 'nullable|file|mimes:jpg,jpeg,png,heic|max:10240',
            'video' => 'nullable|mimes:mp4,mkv,avi,mov|max:51200',
            'video2' => 'nullable|mimes:mp4,mkv,avi,mov|max:51200',
        ]);
        $validated['status'] = 'Proses Kasi';

        // Path hasil
        $file1Path = null;
        $file2Path = null;
        $file3Path = null;
        $file4Path = null;
        $videoPath = null;
        $video2Path = null;

        /* ================================
           COMPRESS FILE 1
        =================================*/
        if ($request->hasFile('file1')) {

            $file = $request->file('file1');
            $ext = strtolower($file->getClientOriginalExtension());

            $filename = uniqid().'.'.($ext === 'heic' ? 'jpg' : $ext);
            $path = storage_path('app/public/report_images/'.$filename);

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

            $file1Path = 'report_images/'.$filename;
        }

        /* ================================
           COMPRESS FILE 2
        =================================*/
        if ($request->hasFile('file2')) {

            $file = $request->file('file2');
            $ext = strtolower($file->getClientOriginalExtension());

            $filename = uniqid().'.'.($ext === 'heic' ? 'jpg' : $ext);
            $path = storage_path('app/public/report_images/'.$filename);

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

            $file2Path = 'report_images/'.$filename;
        }
        if ($request->hasFile('file3')) {

            $file = $request->file('file3');
            $ext = strtolower($file->getClientOriginalExtension());

            $filename = uniqid().'.'.($ext === 'heic' ? 'jpg' : $ext);
            $path = storage_path('app/public/report_images/'.$filename);

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

            $file2Path = 'report_images/'.$filename;
        }

        if ($request->hasFile('file4')) {

            $file = $request->file('file4');
            $ext = strtolower($file->getClientOriginalExtension());

            $filename = uniqid().'.'.($ext === 'heic' ? 'jpg' : $ext);
            $path = storage_path('app/public/report_images/'.$filename);

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

            $file2Path = 'report_images/'.$filename;
        }

        /* ================================
           SAVE VIDEO (TIDAK COMPRESS)
        =================================*/
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('report_videos', 'public');
        }
        if ($request->hasFile('video2')) {
            $video2Path = $request->file('video2')->store('report_videos', 'public');
        }

        /* ================================
           INSERT DATABASE
        =================================*/
        $kasiId = Letter::where('id', $request->letter_id)
            ->value('kasi_user_id'); // langsung ambil 1 kolom
        Report::create([
            'letter_id' => $request->letter_id,
            'title' => $request->title,
            'desc' => $request->desc,
            'file1' => $file1Path,
            'file2' => $file2Path,
            'file3' => $file3Path,
            'file4' => $file4Path,
            'video' => $videoPath,
            'video2' => $video2Path,
            'status' => 'Proses Kasi',
            'staff_user_id' => auth()->id(),
            'kasi_user_id' => $kasiId,
        ]);

        // Update status pada Letter
        Letter::where('id', $request->letter_id)->update([
            'status' => 'Laporan Dibuat',
        ]);
        $nameUser = Auth::user()->name;
        $idUser = Auth::id();
        Log::create([
            'activity' => "$nameUser Membuat Laporan Dengan Judul $request->title",
            'created_by' => $idUser,
        ]);

        return redirect()
            ->route('staff.report.index')
            ->with('status', 'Laporan berhasil dibuat');
    }

    public function edit(Report $report)
    {
        // $kasi = User::select(['id', 'no', 'status','source', 'desc', 'created_at'])->where()->get();
        return view('backend.staff.report.edit', [
            'report' => $report,
            'title' => 'Revisi Laporan',
        ]);
    }

    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        // update data text
        $report->title = $request->title;
        $report->desc = $request->desc;

        /* ================================
           COMPRESS FILE 1
        =================================*/
        if ($request->hasFile('file1')) {
            // if ($request->old_file1) {
            //     Storage::disk('public')->delete($request->old_file1);
            // }
            if ($request->old_file1) {
                Storage::delete('public/'.$request->old_file1);
            }
            $file = $request->file('file1');
            $ext = strtolower($file->getClientOriginalExtension());

            $filename = uniqid().'.'.($ext === 'heic' ? 'jpg' : $ext);
            $path = storage_path('app/public/report_images/'.$filename);

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

            $file1Path = 'report_images/'.$filename;
            $report->file1 = $file1Path;
        }

        /* ================================
           COMPRESS FILE 2
        =================================*/
        if ($request->hasFile('file2')) {
            // if ($request->old_file2) {
            //     Storage::disk('public')->delete($request->old_file2);
            // }
            if ($request->old_file2) {
                Storage::delete('public/'.$request->old_file2);
            }

            $file = $request->file('file2');
            $ext = strtolower($file->getClientOriginalExtension());

            $filename = uniqid().'.'.($ext === 'heic' ? 'jpg' : $ext);
            $path = storage_path('app/public/report_images/'.$filename);

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

            $file2Path = 'report_images/'.$filename;
            $report->file2 = $file2Path;

        }
        if ($request->hasFile('file4')) {
            // if ($request->old_file2) {
            //     Storage::disk('public')->delete($request->old_file2);
            // }
            if ($request->old_file4) {
                Storage::delete('public/'.$request->old_file4);
            }

            $file = $request->file('file4');
            $ext = strtolower($file->getClientOriginalExtension());

            $filename = uniqid().'.'.($ext === 'heic' ? 'jpg' : $ext);
            $path = storage_path('app/public/report_images/'.$filename);

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

            $file4Path = 'report_images/'.$filename;
            $report->file4 = $file4Path;

        }
        
        if ($request->hasFile('file3')) {
            // if ($request->old_file2) {
            //     Storage::disk('public')->delete($request->old_file2);
            // }
            if ($request->old_file3) {
                Storage::delete('public/'.$request->old_file3);
            }

            $file = $request->file('file3');
            $ext = strtolower($file->getClientOriginalExtension());

            $filename = uniqid().'.'.($ext === 'heic' ? 'jpg' : $ext);
            $path = storage_path('app/public/report_images/'.$filename);

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

            $file3Path = 'report_images/'.$filename;
            $report->file3 = $file3Path;

        }

        // VIDEO
        if ($request->hasFile('video')) {
            if ($report->video) {
                Storage::delete($report->video);
            }
            $report->video = $request->file('video')->store('videos');
        }
        if ($request->hasFile('video2')) {
            if ($report->video2) {
                Storage::delete($report->video2);
            }
            $report->video2 = $request->file('video2')->store('videos');
        }
        $report->status = 'Proses Kasi';
        $report->save();
        $nameUser = Auth::user()->name;
        $idUser = Auth::id();
        Log::create([
            'activity' => "$nameUser Merevisi Laporan Dengan Judul $request->title",
            'created_by' => $idUser,
        ]);

        return redirect()
            ->route('staff.report.index')
            ->with('status', 'Laporan berhasil direvisi');
    }

    public function show(Report $report)
    {
        return view('backend.staff.report.detail', [
            'report' => $report,
            'title' => 'Detail Laporan',
        ]);
    }

    public function destroy(Letter $letter) {}
}

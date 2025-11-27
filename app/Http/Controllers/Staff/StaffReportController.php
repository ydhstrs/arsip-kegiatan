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
        $folder = 'reports';
        /* ================================
           COMPRESS FILE 1
        =================================*/
        
        if ($request->hasFile('file1')) {

            $file = $request->file('file1');
            $ext = strtolower($file->getClientOriginalExtension());
        
            // convert HEIC → JPG
            $saveExt = ($ext === 'heic' ? 'jpg' : $ext);
        
            // nama file unik
            $filename = uniqid() . '.' . $saveExt;
        
            // folder tujuan relatif ke disk
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
            $file1Path = $relativePath;
        }

        /* ================================
           COMPRESS FILE 2
        =================================*/
        if ($request->hasFile('file2')) {

            $file = $request->file('file2');
            $ext = strtolower($file->getClientOriginalExtension());
        
            // convert HEIC → JPG
            $saveExt = ($ext === 'heic' ? 'jpg' : $ext);
        
            // nama file unik
            $filename = uniqid() . '.' . $saveExt;
        
            // folder tujuan relatif ke disk
            
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
            $file2Path = $relativePath;
        }
        if ($request->hasFile('file3')) {

            $file = $request->file('file3');
            $ext = strtolower($file->getClientOriginalExtension());
        
            // convert HEIC → JPG
            $saveExt = ($ext === 'heic' ? 'jpg' : $ext);
        
            // nama file unik
            $filename = uniqid() . '.' . $saveExt;
        
            // folder tujuan relatif ke disk
            
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
            $file3Path = $relativePath;
        }

        if ($request->hasFile('file4')) {

            $file = $request->file('file4');
            $ext = strtolower($file->getClientOriginalExtension());
        
            // convert HEIC → JPG
            $saveExt = ($ext === 'heic' ? 'jpg' : $ext);
        
            // nama file unik
            $filename = uniqid() . '.' . $saveExt;
        
            // folder tujuan relatif ke disk
            
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
            $file4Path = $relativePath;
        }
        /* ================================
           SAVE VIDEO (TIDAK COMPRESS)
        =================================*/
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $filename = uniqid() . '.' . $saveExt;
            $relativePath = $folder . '/' . $filename;
        
            // --- CHECK FOLDER DI DISK ---
            if (!Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->makeDirectory($folder);
            }
            Storage::disk('public')->putFileAs($folder, $file, $filename);
        
            $videoPath = $relativePath;
        }
        if ($request->hasFile('video2')) {
            $file = $request->file('video2');
            $filename = uniqid() . '.' . $saveExt;
            $relativePath = $folder . '/' . $filename;
        
            // --- CHECK FOLDER DI DISK ---
            if (!Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->makeDirectory($folder);
            }
            Storage::disk('public')->putFileAs($folder, $file, $filename);
            $video2Path = $relativePath;
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

    public function update(Request $request, Report $report)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'nullable|string',
    
            'file1' => 'nullable|file|mimes:jpg,jpeg,png,heic|max:10240',
            'file2' => 'nullable|file|mimes:jpg,jpeg,png,heic|max:10240',
            'file3' => 'nullable|file|mimes:jpg,jpeg,png,heic|max:10240',
            'file4' => 'nullable|file|mimes:jpg,jpeg,png,heic|max:10240',
            'video' => 'nullable|mimes:mp4,mkv,avi,mov|max:51200',
            'video2' => 'nullable|mimes:mp4,mkv,avi,mov|max:51200',
        ]);
    
        $folder = 'reports';
    
        // ===== FILE 1 =====
        $file1Path = $report->file1;
        if ($request->hasFile('file1')) {
            $file = $request->file('file1');
            $ext = strtolower($file->getClientOriginalExtension());
            $saveExt = ($ext === 'heic' ? 'jpg' : $ext);
            $filename = uniqid() . '.' . $saveExt;
            $relativePath = $folder . '/' . $filename;
    
            if (!Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->makeDirectory($folder);
            }
    
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'heic'])) {
                $image = Image::make($file->getRealPath());
                $image->resize(2000, null, function ($c) {
                    $c->aspectRatio();
                    $c->upsize();
                });
                $tempPath = sys_get_temp_dir() . '/' . $filename;
                $image->save($tempPath, 80);
                Storage::disk('public')->put($relativePath, file_get_contents($tempPath));
                unlink($tempPath);
            } else {
                Storage::disk('public')->putFileAs($folder, $file, $filename);
            }
    
            if ($report->file1 && Storage::disk('public')->exists($report->file1)) {
                Storage::disk('public')->delete($report->file1);
            }
    
            $file1Path = $relativePath;
        }
    
        // ===== FILE 2 =====
        $file2Path = $report->file2;
        if ($request->hasFile('file2')) {
            $file = $request->file('file2');
            $ext = strtolower($file->getClientOriginalExtension());
            $saveExt = ($ext === 'heic' ? 'jpg' : $ext);
            $filename = uniqid() . '.' . $saveExt;
            $relativePath = $folder . '/' . $filename;
    
            if (!Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->makeDirectory($folder);
            }
    
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'heic'])) {
                $image = Image::make($file->getRealPath());
                $image->resize(2000, null, function ($c) {
                    $c->aspectRatio();
                    $c->upsize();
                });
                $tempPath = sys_get_temp_dir() . '/' . $filename;
                $image->save($tempPath, 80);
                Storage::disk('public')->put($relativePath, file_get_contents($tempPath));
                unlink($tempPath);
            } else {
                Storage::disk('public')->putFileAs($folder, $file, $filename);
            }
    
            if ($report->file2 && Storage::disk('public')->exists($report->file2)) {
                Storage::disk('public')->delete($report->file2);
            }
    
            $file2Path = $relativePath;
        }
    
        // ===== FILE 3 =====
        $file3Path = $report->file3;
        if ($request->hasFile('file3')) {
            $file = $request->file('file3');
            $ext = strtolower($file->getClientOriginalExtension());
            $saveExt = ($ext === 'heic' ? 'jpg' : $ext);
            $filename = uniqid() . '.' . $saveExt;
            $relativePath = $folder . '/' . $filename;
    
            if (!Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->makeDirectory($folder);
            }
    
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'heic'])) {
                $image = Image::make($file->getRealPath());
                $image->resize(2000, null, function ($c) {
                    $c->aspectRatio();
                    $c->upsize();
                });
                $tempPath = sys_get_temp_dir() . '/' . $filename;
                $image->save($tempPath, 80);
                Storage::disk('public')->put($relativePath, file_get_contents($tempPath));
                unlink($tempPath);
            } else {
                Storage::disk('public')->putFileAs($folder, $file, $filename);
            }
    
            if ($report->file3 && Storage::disk('public')->exists($report->file3)) {
                Storage::disk('public')->delete($report->file3);
            }
    
            $file3Path = $relativePath;
        }
    
        // ===== FILE 4 =====
        $file4Path = $report->file4;
        if ($request->hasFile('file4')) {
            $file = $request->file('file4');
            $ext = strtolower($file->getClientOriginalExtension());
            $saveExt = ($ext === 'heic' ? 'jpg' : $ext);
            $filename = uniqid() . '.' . $saveExt;
            $relativePath = $folder . '/' . $filename;
    
            if (!Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->makeDirectory($folder);
            }
    
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'heic'])) {
                $image = Image::make($file->getRealPath());
                $image->resize(2000, null, function ($c) {
                    $c->aspectRatio();
                    $c->upsize();
                });
                $tempPath = sys_get_temp_dir() . '/' . $filename;
                $image->save($tempPath, 80);
                Storage::disk('public')->put($relativePath, file_get_contents($tempPath));
                unlink($tempPath);
            } else {
                Storage::disk('public')->putFileAs($folder, $file, $filename);
            }
    
            if ($report->file4 && Storage::disk('public')->exists($report->file4)) {
                Storage::disk('public')->delete($report->file4);
            }
    
            $file4Path = $relativePath;
        }
    
        // ===== VIDEO =====
        $videoPath = $report->video;
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $ext = strtolower($file->getClientOriginalExtension());
            $saveExt = $ext;
            $filename = uniqid() . '.' . $saveExt;
            $relativePath = $folder . '/' . $filename;
    
            if (!Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->makeDirectory($folder);
            }
    
            Storage::disk('public')->putFileAs($folder, $file, $filename);
    
            if ($report->video && Storage::disk('public')->exists($report->video)) {
                Storage::disk('public')->delete($report->video);
            }
    
            $videoPath = $relativePath;
        }
    
        // ===== VIDEO 2 =====
        $video2Path = $report->video2;
        if ($request->hasFile('video2')) {
            $file = $request->file('video2');
            $ext = strtolower($file->getClientOriginalExtension());
            $saveExt = $ext;
            $filename = uniqid() . '.' . $saveExt;
            $relativePath = $folder . '/' . $filename;
    
            if (!Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->makeDirectory($folder);
            }
    
            Storage::disk('public')->putFileAs($folder, $file, $filename);
    
            if ($report->video2 && Storage::disk('public')->exists($report->video2)) {
                Storage::disk('public')->delete($report->video2);
            }
    
            $video2Path = $relativePath;
        }
    
        // ===== UPDATE DATABASE =====
        $report->update([
            'title' => $request->title,
            'desc' => $request->desc,
            'file1' => $file1Path,
            'file2' => $file2Path,
            'file3' => $file3Path,
            'file4' => $file4Path,
            'video' => $videoPath,
            'video2' => $video2Path,
        ]);
    
        $nameUser = Auth::user()->name;
        $idUser = Auth::id();
        Log::create([
            'activity' => "$nameUser Mengupdate Laporan Dengan Judul {$request->title}",
            'created_by' => $idUser,
        ]);
    
        return redirect()
            ->route('staff.report.index')
            ->with('status', 'Laporan berhasil diupdate');
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

@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <a href="/dashboard/staff/report" class="btn btn-primary mb-4">Kembali</a>

    <div class="bg-white block w-full overflow-x-auto p-8">

        <h4 class="mb-4">Detail Laporan</h4>

        <div class="mb-4">
            <label class="font-semibold">Nomor Surat Rujukan</label>
            <div class="border p-2 rounded bg-gray-50">
                {{ $report->letter->no ?? '-' }}
            </div>
        </div>

        <div class="mb-4">
            <label class="font-semibold">Judul Laporan</label>
            <div class="border p-2 rounded bg-gray-50">
                {{ $report->title }}
            </div>
        </div>

        <div class="mb-4">
            <label class="font-semibold">Deskripsi</label>
            <div class="border p-2 rounded bg-gray-50 whitespace-pre-line">
                {{ $report->desc }}
            </div>
        </div>
        @if ($report->remark_kabid)
        <div class="mb-4">
            <label class="font-semibold">Keterangan Revisi Kabid</label>
            <div class="border p-2 rounded bg-gray-50 whitespace-pre-line">
                {{ $report->remark_kabid }}
            </div>
        </div>
        @endif
        @if ($report->remark_kasi)
        <div class="mb-4">
            <label class="font-semibold">Keterangan Revisi Kasi</label>
            <div class="border p-2 rounded bg-gray-50 whitespace-pre-line">
                {{ $report->remark_kasi }}
            </div>
        </div>
        @endif

        {{-- FOTO 1 --}}
        <div class="mb-4">
            <label class="font-semibold">Foto 1</label><br>
            @if ($report->file1)
                <img src="{{ asset('storage/' . $report->file1) }}" 
                     class="w-56 rounded shadow mb-2">
                <br>
                <a href="{{ asset('storage/' . $report->file1) }}" target="_blank" class="btn btn-sm btn-info">
                    Lihat Full
                </a>
            @else
                <p class="text-gray-500">Tidak ada foto.</p>
            @endif
        </div>

        {{-- FOTO 2 --}}
        <div class="mb-4">
            <label class="font-semibold">Foto 2</label><br>
            @if ($report->file2)
                <img src="{{ asset('storage/' . $report->file2) }}" 
                     class="w-56 rounded shadow mb-2">
                <br>
                <a href="{{ asset('storage/' . $report->file2) }}" target="_blank" class="btn btn-sm btn-info">
                    Lihat Full
                </a>
            @else
                <p class="text-gray-500">Tidak ada foto.</p>
            @endif
        </div>
        <div class="mb-4">
            <label class="font-semibold">Foto 3</label><br>
            @if ($report->file3)
                <img src="{{ asset('storage/' . $report->file3) }}" 
                     class="w-56 rounded shadow mb-2">
                <br>
                <a href="{{ asset('storage/' . $report->file3) }}" target="_blank" class="btn btn-sm btn-info">
                    Lihat Full
                </a>
            @else
                <p class="text-gray-500">Tidak ada foto.</p>
            @endif
        </div>
        <div class="mb-4">
            <label class="font-semibold">Foto 4</label><br>
            @if ($report->file4)
                <img src="{{ asset('storage/' . $report->file4) }}" 
                     class="w-56 rounded shadow mb-2">
                <br>
                <a href="{{ asset('storage/' . $report->file4) }}" target="_blank" class="btn btn-sm btn-info">
                    Lihat Full
                </a>
            @else
                <p class="text-gray-500">Tidak ada foto.</p>
            @endif
        </div>

        {{-- VIDEO --}}
        <div class="mb-4">
            <label class="font-semibold">Video</label><br>
            @if ($report->video)
                <video class="w-72 rounded shadow mb-2" controls>
                    <source src="{{ asset('storage/' . $report->video) }}">
                </video>
                <br>
                <a href="{{ asset('storage/' . $report->video) }}" target="_blank" class="btn btn-sm btn-info">
                    Buka Video
                </a>
            @else
                <p class="text-gray-500">Tidak ada video.</p>
            @endif
        </div>
        <div class="mb-4">
            <label class="font-semibold">Video 2</label><br>
            @if ($report->video2)
                <video class="w-72 rounded shadow mb-2" controls>
                    <source src="{{ asset('storage/' . $report->video2) }}">
                </video>
                <br>
                <a href="{{ asset('storage/' . $report->video2) }}" target="_blank" class="btn btn-sm btn-info">
                    Buka Video
                </a>
            @else
                <p class="text-gray-500">Tidak ada video.</p>
            @endif
        </div>


    </div>

</div>
@endsection

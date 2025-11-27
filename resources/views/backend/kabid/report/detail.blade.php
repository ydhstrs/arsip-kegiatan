@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="bg-white block w-full overflow-x-auto p-8 shadow-md rounded-xl">
        <a href="/dashboard/kabid/report" class="btn btn-primary mb-4">Kembali</a>

        <h3 class="text-xl font-semibold mb-6">{{ $title }}</h3>

        {{-- Status Alert --}}
        @if (session('status'))
            <div class="alert alert-success mb-4">
                {{ session('status') }}
            </div>
        @endif

        {{-- Nomor Surat --}}
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900">Nomor Surat</label>
            <div class="p-3 bg-gray-50 border rounded-lg">
                {{ $item->letter->no }}
            </div>
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900">Judul Laporan</label>
            <div class="p-3 bg-gray-50 border rounded-lg">
                {{ $item->title }}
            </div>
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900">Keterangan Laporan Staff</label>
            <div class="p-3 bg-gray-50 border rounded-lg">
                {{ $item->desc }}
            </div>
        </div>

        {{-- Revisi Kasi (jika ada) --}}
        @if ($item->remark_kasi)
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900">Keterangan Revisi Kasi</label>
            <div class="p-3 bg-gray-50 border rounded-lg">
                {{ $item->remark_kasi }}
            </div>
        </div>
        @endif

        {{-- Revisi Kabid (jika ada) --}}
        @if ($item->remark_kabid)
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900">Keterangan Revisi Kabid</label>
            <div class="p-3 bg-gray-50 border rounded-lg">
                {{ $item->remark_kabid }}
            </div>
        </div>
        @endif

        {{-- FOTO 1 --}}
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900">Lampiran Foto 1</label>

            @if ($item->file1)
                <img src="{{ asset($item->file1) }}"
                     class="rounded max-h-96 mb-3 shadow">
            @else
                <p class="text-gray-500 italic">Tidak ada foto</p>
            @endif
        </div>

        {{-- FOTO 2 --}}
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900">Lampiran Foto 2</label>

            @if ($item->file2)
                <img src="{{ asset($item->file2) }}"
                     class="rounded max-h-96 mb-3 shadow">
            @else
                <p class="text-gray-500 italic">Tidak ada foto</p>
            @endif
        </div>
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900">Lampiran Foto 3</label>

            @if ($item->file3)
                <img src="{{ asset($item->file3) }}"
                     class="rounded max-h-96 mb-3 shadow">
            @else
                <p class="text-gray-500 italic">Tidak ada foto</p>
            @endif
        </div>
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900">Lampiran Foto 4</label>

            @if ($item->file4)
                <img src="{{ asset($item->file4) }}"
                     class="rounded max-h-96 mb-3 shadow">
            @else
                <p class="text-gray-500 italic">Tidak ada foto</p>
            @endif
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900">Lampiran Video</label>

            @if ($item->video)
                <video controls class="rounded max-h-96 shadow mb-3">
                    <source src="{{ asset($item->video) }}" type="video/mp4">
                </video>
            @else
                <p class="text-gray-500 italic">Tidak ada video</p>
            @endif
        </div>
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900">Lampiran Video 2</label>

            @if ($item->video2)
                <video controls class="rounded max-h-96 shadow mb-3">
                    <source src="{{ asset($item->video2) }}" type="video/mp4">
                </video>
            @else
                <p class="text-gray-500 italic">Tidak ada video</p>
            @endif
        </div>

        @if($item->status === 'Proses Kabid')
        <a href="{{route('kabid.report.edit', $item->id)}}" 
        class="btn btn btn-danger">Revisi</a>
        <form action="{{route('kabid.report.approve', $item->id) }}" method="POST" style="display:inline;">
            @csrf  
            <button type="submit" class="btn btn btn-primary"
                onclick="return confirm(\'Yakin setujui laporan ini?\')">Disetujui</button>
        </form>
        @endif
    </div>
</div>
@endsection

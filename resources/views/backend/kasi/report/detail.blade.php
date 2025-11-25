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

        {{-- Judul --}}
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900">Judul Laporan</label>
            <div class="p-3 bg-gray-50 border rounded-lg">
                {{ $item->title }}
            </div>
        </div>

        {{-- Deskripsi Staff --}}
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
                <img src="{{ Storage::url($item->file1) }}"
                     class="rounded max-h-96 mb-3 shadow">
            @else
                <p class="text-gray-500 italic">Tidak ada foto</p>
            @endif
        </div>

        {{-- FOTO 2 --}}
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900">Lampiran Foto 2</label>

            @if ($item->file2)
                <img src="{{ Storage::url($item->file2) }}"
                     class="rounded max-h-96 mb-3 shadow">
            @else
                <p class="text-gray-500 italic">Tidak ada foto</p>
            @endif
        </div>

        {{-- VIDEO --}}
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900">Lampiran Video</label>

            @if ($item->video)
                <video controls class="rounded max-h-96 shadow mb-3">
                    <source src="{{ Storage::url($item->video) }}" type="video/mp4">
                </video>
            @else
                <p class="text-gray-500 italic">Tidak ada video</p>
            @endif
        </div>

        {{-- Button Back --}}
        <a href="{{ url()->previous() }}"
           class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
            Kembali
        </a>

    </div>
</div>
@endsection

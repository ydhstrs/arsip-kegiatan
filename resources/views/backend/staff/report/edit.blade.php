@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <a href="/dashboard/staff/report" class="btn btn-primary mb-4">Kembali</a>

    <p class="mb-10">{{ $title }}</p>

    <form method="post" action="/dashboard/staff/report/{{ $report->id }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- NOMOR SURAT --}}
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900">Nomor Surat Rujukan</label>
            <input type="text" value="{{ $report->letter->no }}" class="form-control bg-gray-200" disabled>
            <input type="hidden" name="letter_id" value="{{ $report->letter_id }}">
        </div>

        {{-- JUDUL --}}
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900">Judul Laporan</label>
            <input type="text" id="title" name="title"
                value="{{ old('title', $report->title) }}"
                class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                required>
        </div>

        {{-- FOTO 1 --}}
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900">Upload Foto 1</label>

            @if ($report->file1)
                <img id="imgPreview1" class="w-56 mb-2 rounded"
                    src="{{ asset($report->file1) }}">
            @else
                <img id="imgPreview1" class="w-56 mb-2 rounded hidden">
            @endif
            <input type="hidden" name="old_file1" value="{{ $report->file1 }}">
            <input type="file" id="file1" name="file1" onchange="previewImage1()"
                class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer">
        </div>

        {{-- FOTO 2 --}}
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900">Upload Foto 2</label>

            @if ($report->file2)
                <img id="imgPreview2" class="w-56 mb-2 rounded"
                    src="{{ asset($report->file2) }}">
            @else
                <img id="imgPreview2" class="w-56 mb-2 rounded hidden">
            @endif
            <input type="hidden" name="old_file2" value="{{ $report->file2 }}">
            <input type="file" id="file2" name="file2" onchange="previewImage2()"
                class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer">
        </div>
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900">Upload Foto 3</label>

            @if ($report->file3)
                <img id="imgPreview3" class="w-56 mb-2 rounded"
                    src="{{ asset($report->file3) }}">
            @else
                <img id="imgPreview3" class="w-56 mb-2 rounded hidden">
            @endif
            <input type="hidden" name="old_file3" value="{{ $report->file3 }}">
            <input type="file" id="file3" name="file3" onchange="previewImage3()"
                class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer">
        </div>
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900">Upload Foto 4</label>

            @if ($report->file4)
                <img id="imgPreview4" class="w-56 mb-2 rounded"
                    src="{{ asset($report->file4) }}">
            @else
                <img id="imgPreview4" class="w-56 mb-2 rounded hidden">
            @endif
            <input type="hidden" name="old_file4" value="{{ $report->file4 }}">
            <input type="file" id="file4" name="file4" onchange="previewImage4()"
                class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer">
        </div>

        {{-- VIDEO --}}
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900">Upload Video</label>

            @if ($report->video)
                <video id="vidPreview" class="w-56 mb-2 rounded" controls>
                    <source src="{{ Storage::url($report->video) }}" type="video/mp4">
                </video>
            @else
                <video id="vidPreview" class="w-56 mb-2 rounded hidden" controls></video>
            @endif
            <input type="hidden" name="old_video" value="{{ $report->video }}">
            <input type="file" id="video" name="video" accept="video/*" onchange="previewVideo()"
                class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer">
        </div>
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900">Upload Video 2</label>

            @if ($report->video)
                <video id="vidPreview2" class="w-56 mb-2 rounded" controls>
                    <source src="{{ Storage::url($report->video2) }}" type="video/mp4">
                </video>
            @else
                <video id="vidPreview2" class="w-56 mb-2 rounded hidden" controls></video>
            @endif
            <input type="hidden" name="old_video2" value="{{ $report->video2 }}">
            <input type="file" id="video2" name="video2" accept="video/*" onchange="previewVideo2()"
                class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer">
        </div>

        {{-- DESKRIPSI --}}
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
            <textarea id="desc" name="desc"
                class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
            >{{ old('desc', $report->desc) }}</textarea>
        </div>

        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 rounded-lg text-sm px-5 py-2.5">
            Update
        </button>
    </form>
</div>

{{-- SCRIPT PREVIEW --}}
<script>
    function previewImage1() {
        const file = file1.files[0];
        const img = document.getElementById("imgPreview1");
        if (!file) return;
        img.src = URL.createObjectURL(file);
        img.classList.remove("hidden");
    }

    function previewImage2() {
        const file = file2.files[0];
        const img = document.getElementById("imgPreview2");
        if (!file) return;
        img.src = URL.createObjectURL(file);
        img.classList.remove("hidden");
    }
    function previewImage3() {
        const file = file1.files[0];
        const img = document.getElementById("imgPreview3");
        if (!file) return;
        img.src = URL.createObjectURL(file);
        img.classList.remove("hidden");
    }

    function previewImage4() {
        const file = file2.files[0];
        const img = document.getElementById("imgPreview4");
        if (!file) return;
        img.src = URL.createObjectURL(file);
        img.classList.remove("hidden");
    }

    function previewVideo() {
        const file = video.files[0];
        const vid = document.getElementById("vidPreview");
        if (!file) return;
        vid.src = URL.createObjectURL(file);
        vid.classList.remove("hidden");
    }
    function previewVideo2() {
        const file = video.files[0];
        const vid = document.getElementById("vidPreview2");
        if (!file) return;
        vid.src = URL.createObjectURL(file);
        vid.classList.remove("hidden");
    }
</script>
@endsection

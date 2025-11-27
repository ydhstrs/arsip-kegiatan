@extends('layouts.app')

@section('title', $title)

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @if (session('status'))
            <div class="card-body">
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            </div>
        @endif


        <div class="bg-white block w-full overflow-x-auto p-8">
            <a href="/dashboard/staff/report" class="btn btn-primary mb-4">Kembali</a>


            <P class="mb-10">{{ $title }}</P>
            <form method="post" action="/dashboard/staff/report" enctype="multipart/form-data">
                @csrf
                <div class="mb-6">
                    <label for="no" class="block mb-2 text-sm font-medium text-gray-900 ">Nomor Surat Rujukan</label>
                    <input type="text" id="no" name="no" value="{{ $letter->no }}"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" disabled>
                    <input type="hidden" name="letter_id" value="{{ $letter->id }}">
                </div>
                <div class="mb-6">
                    <label for="source" class="block mb-2 text-sm font-medium text-gray-900 ">Judul Laporan </label>
                    <input type="text" id="title" name="title"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" required>
                </div>
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-900" for="file">Upload Foto 1</label>
                    <img class="img-preview w-56 mb-2" id="imgPreview1">
                    <input
                        class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:placeholder-gray-400 @error('file') border-red-600 @enderror"
                        aria-describedby="file_input_help" id="file1" name="file1" type="file"
                        onchange="previewImage1()" value="{{ old('image') }}">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG</p>
                    @error('image')
                        <div class="text-red-600">
                            {{ $message }}
                        </div>
                    @enderror

                </div>
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-900" for="file">Upload Foto 2</label>
                    <img class="img-preview w-56 mb-2" id="imgPreview2">
                    <input
                        class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:placeholder-gray-400 @error('file') border-red-600 @enderror"
                        aria-describedby="file_input_help" id="file2" name="file2" type="file"
                        onchange="previewImage2()" value="{{ old('image') }}">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG.</p>
                    @error('image')
                        <div class="text-red-600">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-900" for="file">Upload Foto 3</label>
                    <img class="img-preview w-56 mb-2" id="imgPreview3">
                    <input
                        class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:placeholder-gray-400 @error('file') border-red-600 @enderror"
                        aria-describedby="file_input_help" id="file3" name="file3" type="file"
                        onchange="previewImage3()" value="{{ old('image') }}">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG</p>
                    @error('image')
                        <div class="text-red-600">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-900" for="file">Upload Foto 4</label>
                    <img class="img-preview w-56 mb-2" id="imgPreview4">
                    <input
                        class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:placeholder-gray-400 @error('file') border-red-600 @enderror"
                        aria-describedby="file_input_help" id="file4" name="file4" type="file"
                        onchange="previewImage4()" value="{{ old('image') }}">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG</p>
                    @error('image')
                        <div class="text-red-600">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-900" for="video">
                        Upload Video 1
                    </label>
                    <video id="vidPreview" class="hidden w-56 mb-2 rounded" controls></video>
                    <input
                        class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer @error('file') border-red-600 @enderror"
                        id="video" name="video" type="file" accept="video/*" onchange="previewVideo()">

                    <p class="mt-1 text-sm text-gray-500">
                        MP4, MKV, AVI, MOV (Max 50MB).
                    </p>

                    @error('video')
                        <div class="text-red-600">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-900" for="video">
                        Upload Video 2 (Jika Ada)
                    </label>
                    <video id="vidPreview2" class="hidden w-56 mb-2 rounded" controls></video>
                    <input
                        class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer @error('file') border-red-600 @enderror"
                        id="video2" name="video2" type="file" accept="video/*" onchange="previewVideo2()">

                    <p class="mt-1 text-sm text-gray-500">
                        MP4, MKV, AVI, MOV (Max 50MB).
                    </p>

                    @error('video')
                        <div class="text-red-600">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div class="mb-6">
                    <label for="desc" class="block mb-2 text-sm font-medium text-gray-900 ">Deskripsi</label>
                    <textarea type="text" id="desc" name="desc"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder=""> </textarea>
                </div>

                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
            </form>
        </div>

    </div>

    <script type="text/javascript">
        function previewImage1() {
            const fileInput = document.getElementById('file1');
            const imgPreview = document.getElementById('imgPreview1');
            const file = fileInput.files[0];

            if (!file) return;

            // Kalau PDF, jangan ditampilkan sebagai image
            if (file.type === "application/pdf") {
                imgPreview.classList.add("hidden");
                imgPreview.src = "";
                return;
            }

            const reader = new FileReader();

            reader.onload = function(e) {
                imgPreview.src = e.target.result;
                imgPreview.classList.remove("hidden");
            };

            reader.readAsDataURL(file);
        }

        function previewImage2() {
            const fileInput = document.getElementById('file2');
            const imgPreview = document.getElementById('imgPreview2');
            const file = fileInput.files[0];

            if (!file) return;

            // Kalau PDF, jangan ditampilkan sebagai image
            if (file.type === "application/pdf") {
                imgPreview.classList.add("hidden");
                imgPreview.src = "";
                return;
            }

            const reader = new FileReader();

            reader.onload = function(e) {
                imgPreview.src = e.target.result;
                imgPreview.classList.remove("hidden");
            };

            reader.readAsDataURL(file);
        }
        function previewImage3() {
            const fileInput = document.getElementById('file3');
            const imgPreview = document.getElementById('imgPreview3');
            const file = fileInput.files[0];

            if (!file) return;

            // Kalau PDF, jangan ditampilkan sebagai image
            if (file.type === "application/pdf") {
                imgPreview.classList.add("hidden");
                imgPreview.src = "";
                return;
            }

            const reader = new FileReader();

            reader.onload = function(e) {
                imgPreview.src = e.target.result;
                imgPreview.classList.remove("hidden");
            };

            reader.readAsDataURL(file);
        }
        function previewImage4() {
            const fileInput = document.getElementById('file4');
            const imgPreview = document.getElementById('imgPreview4');
            const file = fileInput.files[0];

            if (!file) return;

            // Kalau PDF, jangan ditampilkan sebagai image
            if (file.type === "application/pdf") {
                imgPreview.classList.add("hidden");
                imgPreview.src = "";
                return;
            }

            const reader = new FileReader();

            reader.onload = function(e) {
                imgPreview.src = e.target.result;
                imgPreview.classList.remove("hidden");
            };

            reader.readAsDataURL(file);
        }

        function previewVideo() {
            const fileInput = document.getElementById('video');
            const preview = document.getElementById('vidPreview');
            const file = fileInput.files[0];

            if (!file) return;

            // Validasi file harus video
            if (!file.type.startsWith("video/")) {
                preview.classList.add("hidden");
                preview.src = "";
                alert("File harus berupa video!");
                fileInput.value = "";
                return;
            }

            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove("hidden");
            };

            reader.readAsDataURL(file);
        }
        function previewVideo2() {
            const fileInput = document.getElementById('video2');
            const preview = document.getElementById('vidPreview2');
            const file = fileInput.files[0];

            if (!file) return;

            // Validasi file harus video
            if (!file.type.startsWith("video/")) {
                preview.classList.add("hidden");
                preview.src = "";
                alert("File harus berupa video!");
                fileInput.value = "";
                return;
            }

            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove("hidden");
            };

            reader.readAsDataURL(file);
        }
    </script>
@endsection

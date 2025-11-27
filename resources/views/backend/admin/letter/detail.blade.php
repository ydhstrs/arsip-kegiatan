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
            <a href="/dashboard/admin/letter" class="btn btn-primary mb-4">Kembali</a>
            <P class="mb-10">{{ $title }}</P>
            <div class="mb-6">
                <label for="no" class="block mb-2 text-sm font-medium text-gray-900 ">Nomor Surat</label>
                <input type="text" id="no" name="no"
                    class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                    placeholder="" value="{{ $item->no }}" disabled>
            </div>
            <div class="mb-6">
                <label for="source" class="block mb-2 text-sm font-medium text-gray-900 ">Asal Surat</label>
                <input type="text" id="source" name="source"
                    class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                    placeholder="" value="{{ $item->source }}" disabled>
            </div>
            <div class="mb-6">
                <label for="desc" class="block mb-2 text-sm font-medium text-gray-900 ">Keterangan</label>
                <textarea type="text" id="desc" name="desc"
                    class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                    placeholder="" disabled>{{ $item->desc }} </textarea>
            </div>
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-900" for="file_input">Lampiran file</label>
                @if ($item->file)
                    @php
                        $ext = strtolower(pathinfo($item->file, PATHINFO_EXTENSION));
                    @endphp

                    @if ($ext === 'pdf')
                        <a href="{{ Storage::url($item->file) }}" target="_blank" class="btn btn-secondary mb-3">
                            Lihat PDF
                        </a>
                    @else
                        {{-- <img src="{{ Storage::url($item->file) }}" class="rounded max-h-96 mb-3"> --}}
                        <img src="{{ asset('storage/' . $item->file) }}" class="rounded max-h-96 mb-3">
                    @endif
                @endif

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">PDF, PNG, JPG (MAX. 2MB).</p>

                @error('file')
                    <div class="text-red-600">
                        {{ $message }}
                    </div>
                @enderror
            </div>

        </div>

    </div>

    <script>
        function previewImage() {
            const fileInput = document.getElementById('file');
            const imgPreview = document.getElementById('imgPreview');
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
    </script>


@endsection

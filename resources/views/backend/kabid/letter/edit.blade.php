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
            <a href="/dashboard/kabid/letter" class="btn btn-primary mb-4">Kembali</a>
            <P class="mb-10">{{ $title }}</P>
            <form method="post" action="/dashboard/kabid/letter/{{ $item->id }}" enctype="multipart/form-data">
                @csrf
                @method('put')
            
                {{-- ===============================
                    SECTION 1 : EDITABLE (Atas)
                ================================ --}}
                <div class="bg-white border border-blue-300 shadow-md rounded-xl p-6 mb-8">
                    <h3 class="text-lg font-semibold mb-4 text-blue-700">Update Informasi</h3>
            
                    <div class="mb-6">
                        <label for="kasi_user_id" class="block mb-2 text-sm font-medium text-gray-900">Kepala Seksi</label>
                        <select id="kasi_user_id" name="kasi_user_id"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5">
                            @foreach ($kasis as $kasi)
                                <option value="{{ $kasi->id }}">{{ $kasi->name }}</option>
                            @endforeach
                        </select>
                    </div>
            
                    <div class="mb-6">
                        <label for="remark_kabid" class="block mb-2 text-sm font-medium text-gray-900">Keterangan Kabid</label>
                        <textarea id="remark_kabid" name="remark_kabid"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5">{{ $item->remark_kabid }}</textarea>
                    </div>
                </div>
            
                {{-- ===============================
                    SECTION 2 : READ ONLY (Bawah)
                ================================ --}}
                <div class="bg-gray-50 border border-gray-200 shadow-sm rounded-xl p-6 mb-8">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700">Detail Surat (Tidak Bisa Diubah)</h3>
            
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Nomor Surat</label>
                        <input type="text" value="{{ $item->no }}" disabled
                            class="form-control bg-gray-100 border border-gray-300 text-gray-700 text-sm rounded-lg block w-full p-2.5">
                    </div>
            
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Asal Surat</label>
                        <input type="text" value="{{ $item->source }}" disabled
                            class="form-control bg-gray-100 border border-gray-300 text-gray-700 text-sm rounded-lg block w-full p-2.5">
                    </div>
            
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Keterangan</label>
                        <textarea disabled
                            class="form-control bg-gray-100 border border-gray-300 text-gray-700 text-sm rounded-lg block w-full p-2.5">{{ $item->desc }}</textarea>
                    </div>
            
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900">File</label>
            
                        @if ($item->file)
                        @php
                            $ext = strtolower(pathinfo($item->file, PATHINFO_EXTENSION));
                        @endphp
    
                        @if ($ext === 'pdf')
                            <a href="{{ asset($item->file) }}" target="_blank" class="btn btn-secondary mb-3">
                                Lihat PDF
                            </a>
                        @else
                            <img src="{{ asset($item->file) }}" class="rounded max-h-96 mb-3">
                        @endif
                    @endif
                    </div>
                </div>
            
                {{-- SUBMIT --}}
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 
                    font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5">
                    Submit
                </button>
            </form>
            
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

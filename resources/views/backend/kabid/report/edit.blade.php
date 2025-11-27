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
            <P class="mb-10">{{ $title }}</P>
            <form method="post" action="/dashboard/kabid/report/{{ $item->id }}" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="bg-white border border-blue-300 shadow-md rounded-xl p-6 mb-8">
                    <h3 class="text-lg font-semibold mb-4 text-blue-700">Revisi Laporan</h3>

            
                    <div class="mb-6">
                        <label for="remark_kabid" class="block mb-2 text-sm font-medium text-gray-900">Keterangan Revisi Kabid</label>
                        <textarea id="remark_kabid" name="remark_kabid"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5">{{ $item->remark_kabid }}</textarea>
                    </div>
                </div>
                <div class="mb-6">
                    <label for="no" class="block mb-2 text-sm font-medium text-gray-900 ">Nomor Surat</label>
                    <input type="text" id="no" name="no"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" value="{{ $item->letter->no }}" disabled>
                </div>
                <div class="mb-6">
                    <label for="source" class="block mb-2 text-sm font-medium text-gray-900 ">Judul Laporan</label>
                    <input type="text" id="source" name="source"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" value="{{ $item->title }}" disabled>
                </div>
                
                <div class="mb-6">
                    <label for="floor" class="block mb-2 text-sm font-medium text-gray-900 ">Keterangan Laporan Staff</label>
                    <textarea type="text" id="remark" name="remark"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" disabled>{{ $item->desc  }} </textarea>
                </div>
                @if ($item->remark_kasi)
                <div class="mb-6">
                    <label for="floor" class="block mb-2 text-sm font-medium text-gray-900 ">Keterangan Revisi Kasi</label>
                    <textarea type="text" id="remark" name=""
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" disabled>{{ $item->remark_kasi  }} </textarea>
                </div>
                @endif

                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-900" for="file_input">Lampiran Foto 1</label>
                
                    @if ($item->file1)
                        <img src="{{ asset($item->file1) }}" 
                             alt="Preview" 
                             id="imgPreview" 
                             class="rounded max-h-96 mb-3">
                    @else
                        <img src="" id="imgPreview" class="rounded max-h-96 mb-3 hidden">
                    @endif
                
                </div>
                
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-900" for="file_input">Lampiran Foto 2</label>
                
                    @if ($item->file2)
                        <img src="{{ asset($item->file2) }}" 
                             alt="Preview" 
                             id="imgPreview" 
                             class="rounded max-h-96 mb-3">
                    @else
                        <img src="" id="imgPreview" class="rounded max-h-96 mb-3 hidden">
                    @endif
                
                </div>
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-900" for="video">Lampiran Video</label>
                
                    @if ($item->video)
                        <video controls 
                               id="vidPreview" 
                               class="rounded max-h-96 mb-3">
                            <source src="{{ asset($item->video) }}" type="video/mp4">
                            Browser Anda tidak mendukung video.
                        </video>
                    @else
                        <video controls 
                               id="vidPreview" 
                               class="rounded max-h-96 mb-3 hidden">
                            <source src="" type="video/mp4">
                        </video>
                    @endif
                </div>
                
                

                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
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

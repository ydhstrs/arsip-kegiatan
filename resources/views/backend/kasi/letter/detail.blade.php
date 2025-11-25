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
            <a href="/dashboard/kasi/letter" class="btn btn-primary mb-4">Kembali</a>
            <P class="mb-10">{{ $title }}</P>
            <form method="post" action="" enctype="multipart/form-data">
                @csrf
                @method('put')

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
                            class="form-control bg-gray-100 border border-gray-300 text-gray-700 text-sm rounded-lg block w-full p-2.5">{{ $item->remark }}</textarea>
                    </div>
                    <div class="mb-6">
                        <label for="kasi_user_id" class="block mb-2 text-sm font-medium text-gray-900">Kepala Seksi</label>
                        <input type="text" value="{{ $item->kasi->name }}" disabled
                            class="form-control bg-gray-100 border border-gray-300 text-gray-700 text-sm rounded-lg block w-full p-2.5">
                    </div>

                    <div class="mb-6">
                        <label for="remark_kabid" class="block mb-2 text-sm font-medium text-gray-900">Keterangan
                            Kabid</label>
                        <textarea id="remark_kabid" name="remark_kabid"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5" disabled>{{ $item->remark_kabid }}</textarea>
                    </div>
                    <div class="mb-6">
                        <label for="staff_user_id" class="block mb-2 text-sm font-medium text-gray-900">Staff</label>
                        <input type="text" value="{{ $item->staff->name }}" disabled
                            class="form-control bg-gray-100 border border-gray-300 text-gray-700 text-sm rounded-lg block w-full p-2.5">
                    </div>

                    <div class="mb-6">
                        <label for="remark_kasi" class="block mb-2 text-sm font-medium text-gray-900">Keterangan
                            Kasi</label>
                        <textarea id="remark_kasi" name="remark_kasi"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5" disabled>{{ $item->remark_kasi }}</textarea>
                    </div>
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900">File</label>

                        @if ($item->file)
                            <img src="{{ Storage::url($item->file) }}" class="rounded max-h-96 mb-3 border shadow">
                        @endif
                    </div>
                </div>

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

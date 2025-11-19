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
            <form method="post" action="/dashboard/room" enctype="multipart/form-data">
                @csrf
                <div class="mb-6">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Nama/Nomor Kamar</label>
                    <input type="text" id="name" name="name"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" required>
                </div>
                <div class="mb-6">
                    <label for="charge" class="block mb-2 text-sm font-medium text-gray-900 ">Tipe</label>
                    <input type="text" id="type" name="type"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" required>
                </div>
                <div class="mb-6">
                    <label for="charge" class="block mb-2 text-sm font-medium text-gray-900 ">Harga</label>
                    <input type="text" id="price" name="price"
                        class="form-control rupiah-input bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" required>
                </div>
                <div class="mb-6">
                    <label for="floor" class="block mb-2 text-sm font-medium text-gray-900 ">Lantai</label>
                    <input type="text" id="floor" name="floor"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" required>
                </div>
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-900" for="file_input">Upload file</label>
                    <img class="img-preview w-56 mb-2" id="imgPreview">
                    <input
                        class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:placeholder-gray-400 @error('image') border-red-600 @enderror"
                        aria-describedby="file_input_help" id="image" name="image_fake" type="file"
                        onchange="previewImage()" value="{{ old('image') }}">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG (MAX.
                        800x400px).</p>
                    @error('image')
                        <div class="text-red-600">
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Hidden input to store the Base64 string -->
                    <input type="hidden" name="image" id="imageBase64">
                </div>
                <div class="mb-6">
                    <label for="floor" class="block mb-2 text-sm font-medium text-gray-900 ">Keterangan</label>
                    <textarea type="text" id="remark" name="remark"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder=""> </textarea>
                </div>

                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
            </form>
        </div>

    </div>


    {{-- <script type="text/javascript">
function previewImage() {
const image = document.querySelector('#image');
const imgPreview = document.querySelector('.img-preview');

imgPreview.style.display = 'block';
const oFReader = new FileReader();
oFReader.readAsDataURL(image.files[0]);
oFReader.onload = function (oFREvent){
    imgPreview.src = oFREvent.target.result
}
} 
</script>    --}}
    <script type="text/javascript">
        function previewImage() {
            const imageInput = document.getElementById('image');
            const imgPreview = document.getElementById('imgPreview');
            const imageBase64 = document.getElementById('imageBase64');

            const file = imageInput.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Set the image preview
                    imgPreview.src = e.target.result;

                    // Store the Base64 string in the hidden input
                    imageBase64.value = e.target.result.split(',')[1]; // Remove data:image/...;base64, part
                };

                reader.readAsDataURL(file); // Convert the file to a Base64 string
            }
        }
    </script>
@endsection

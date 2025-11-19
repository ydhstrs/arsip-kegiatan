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
            <form method="post" action="/dashboard/user">
                @csrf
                <div class="mb-6">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Nama</label>
                    <input type="text" id="name" name="name"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" required>
                </div>
                <div class="mb-6">
                    <label for="username" class="block mb-2 text-sm font-medium text-gray-900 ">Username</label>
                    <input type="username" id="username" name="username"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" required>
                </div>
                <div class="mb-6">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">Email</label>
                    <input type="email" id="email" name="email"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" required>
                </div>
                <div class="mb-6">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 ">Password</label>
                    <input type="password" id="password" name="password"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" required>
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

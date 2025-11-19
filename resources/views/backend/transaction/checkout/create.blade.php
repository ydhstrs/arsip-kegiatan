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
            <form method="post" action="/dashboard/checkin" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col md:flex-row gap-4 mb-6">
                    <div class="w-full md:w-1/2">
                        <label for="guest_name" class="block mb-2 text-sm font-medium text-gray-900">Nama Penghuni</label>
                        <input type="text" id="guest_name" name="guest_name"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                            placeholder="" required>
                    </div>
                    <div class="w-full md:w-1/2">
                        <label for="idcard_no" class="block mb-2 text-sm font-medium text-gray-900">NIK Penghuni</label>
                        <input type="text" id="idcard_no" name="idcard_no"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                            placeholder="" required>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-4 mb-6">
                    <div class="w-full md:w-1/2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Pekerjaan
                            Penghuni</label>
                        <input type="text" id="guest_job" name="guest_job"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                            placeholder="" required>
                    </div>
                    <div class="w-full md:w-1/2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Status Pernikahan
                            Penghuni</label>
                        <input type="text" id="marital_status" name="marital_status"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                            placeholder="" required>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-4 mb-6">
                    <div class="w-full md:w-1/2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Tempat Lahir</label>
                        <input type="text" id="born_place" name="born_place"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                            placeholder="" required>
                    </div>
                    <div class="w-full md:w-1/2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Tanggal Lahir</label>
                        <input type="date" id="birth_date" name="birth_date"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                            placeholder="" required>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-4 mb-6">
                    <div class="w-full md:w-1/2">
                        <label for="charge" class="block mb-2 text-sm font-medium text-gray-900 ">Nomor Transaksi</label>
                        <input type="text" id="transaction_no" name="transaction_no"
                            value="CI/{{ date('m/Y') }}/{{ str_pad($counter, 4, '0', STR_PAD_LEFT) }}"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                            placeholder="" readonly>
                    </div>
                    <div class="w-full md:w-1/2">

                        <label for="charge" class="block mb-2 text-sm font-medium text-gray-900 ">Tanggal
                            Transaksi</label>
                        <input type="date" id="transaction_date" name="transaction_date"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                            placeholder="" required>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-4 mb-6">
                    <div class="w-full md:w-1/2">
                        <label for="charge" class="block mb-2 text-sm font-medium text-gray-900 ">Rencana Masuk</label>
                        <input type="date" id="checkin_date" name="checkin_date"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                            placeholder="" required>
                    </div>
                    <div class="w-full md:w-1/2">
                        <label for="charge" class="block mb-2 text-sm font-medium text-gray-900 ">Durasi (Bulan)</label>
                        <input type="text" id="duration" name="duration"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                            placeholder="" required>
                    </div>

                </div>
                <div class="flex flex-col md:flex-row gap-4 mb-6">

                    <div class="w-full md:w-1/2">
                        <label for="charge" class="block mb-2 text-sm font-medium text-gray-900 ">Kamar</label>
                        {{-- <input type="text" id="room_id" name="room_id"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" required> --}}
                        <select id="room_id" name="room_id" onchange="updateRoomPrice()"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5">
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" data-price="{{ $room->price }}">{{ $room->name }}
                                </option>
                            @endforeach
                        </select>

                    </div>
                    <div class="w-full md:w-1/2">

                        <label for="charge" class="block mb-2 text-sm font-medium text-gray-900 ">Harga Kamar</label>
                        <input type="text" id="room_price" name="room_price"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                            placeholder="" required>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-4 mb-6">
                    <div class="w-full md:w-1/2">
                        <label class="block mb-2 text-sm font-medium text-gray-900" for="file_input">Upload Foto
                            KTP</label>
                        <img class="img-preview w-56 mb-2" id="imgPreview">
                        <input
                            class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:placeholder-gray-400 @error('image') border-red-600 @enderror"
                            aria-describedby="file_input_help" id="image" name="image_fake" type="file"
                            onchange="previewImage()" value="{{ old('image') }}">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG
                            (MAX.
                            800x400px).</p>
                        @error('image')
                            <div class="text-red-600">
                                {{ $message }}
                            </div>
                        @enderror

                        <!-- Hidden input to store the Base64 string -->
                        <input type="hidden" name="idcard_image" id="imageBase64">
                    </div>
                    <div class="w-full md:w-1/2">
                        <label class="block mb-2 text-sm font-medium text-gray-900" for="file_input">Upload Foto
                            Penghuni</label>
                        <img class="img-preview h-56 mb-2" id="imgPreview2">
                        <input
                            class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:placeholder-gray-400 @error('image') border-red-600 @enderror"
                            aria-describedby="file_input_help" id="image2" name="image_fake2" type="file"
                            onchange="previewImage2()" value="{{ old('image2') }}">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG
                            (MAX.
                            800x400px).</p>
                        @error('image')
                            <div class="text-red-600">
                                {{ $message }}
                            </div>
                        @enderror

                        <!-- Hidden input to store the Base64 string -->
                        <input type="hidden" name="guest_image" id="imageBase642">
                    </div>
                </div>
                <div class="mb-6">
                    <label for="floor" class="block mb-2 text-sm font-medium text-gray-900 ">Keterangan</label>
                    <textarea type="text" id="remark" name="remark"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder=""> </textarea>
                </div>

                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">Submit</button>
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

        function previewImage2() {
            const imageInput = document.getElementById('image2');
            const imgPreview = document.getElementById('imgPreview2');
            const imageBase64 = document.getElementById('imageBase642');

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
        $(document).ready(function() {
            $('#room_id').select2({
                placeholder: "Select a room",
                allowClear: true
            });
        });

        function updateRoomPrice() {
            // Get the selected option from the dropdown
            const roomSelect = document.getElementById("room_id");
            const selectedOption = roomSelect.options[roomSelect.selectedIndex];

            // Get the price from the data-price attribute and convert it to an integer
            let price = selectedOption.getAttribute("data-price");
            price = price ? Math.floor(price) : ''; // Remove decimal part

            // Set the room_price input field to the integer value
            document.getElementById("room_price").value = price;
        }
    </script>
@endsection

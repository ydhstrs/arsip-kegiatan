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
            <form method="post" action="/dashboard/checkin/{{ $item->id }}" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="flex flex-col md:flex-row gap-4 mb-6">
                    <input hidden name="id" value="{{ $item->id }}">
                    <input hidden name="old_room_id" value="{{ $item->room_id }}">
                    <div class="w-full md:w-1/2">
                        <label for="guest_name" class="block mb-2 text-sm font-medium text-gray-900">Nama Penghuni</label>
                        <input type="text" id="guest_name" name="guest_name" value="{{ $item->guest_name }}"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                            placeholder="" required>
                    </div>
                    <div class="w-full md:w-1/2">
                        <label for="idcard_no" class="block mb-2 text-sm font-medium text-gray-900">NIK Penghuni</label>
                        <input type="text" id="idcard_no" name="idcard_no" value="{{ $item->idcard_no }}"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                            placeholder="" required>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-4 mb-6">
                    <div class="w-full md:w-1/2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Pekerjaan
                            Penghuni</label>
                        <input type="text" id="guest_job" name="guest_job" value="{{ $item->guest_job }}"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                            placeholder="" required>
                    </div>
                    <div class="w-full md:w-1/2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Status Pernikahan
                            Penghuni</label>
                        <input type="text" id="marital_status" name="marital_status" value="{{ $item->marital_status }}"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                            placeholder="" required>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-4 mb-6">
                    <div class="w-full md:w-1/2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Tempat Lahir</label>
                        <input type="text" id="born_place" name="born_place" value="{{ $item->born_place }}"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                            placeholder="" required>
                    </div>
                    <div class="w-full md:w-1/2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Tanggal Lahir</label>
                        <input type="date" id="birth_date" name="birth_date" value="{{ $item->birth_date }}"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                            placeholder="" required>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-4 mb-6">
                    <div class="w-full md:w-1/2">
                        <label for="charge" class="block mb-2 text-sm font-medium text-gray-900 ">Nomor Transaksi</label>
                        <input type="text" id="transaction_no" name="transaction_no" value="{{ $item->transaction_no }}"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                            placeholder="" required>
                    </div>
                    <div class="w-full md:w-1/2">

                        <label for="charge" class="block mb-2 text-sm font-medium text-gray-900 ">Tanggal
                            Transaksi</label>
                        <input type="date" id="transaction_date" name="transaction_date"
                            value="{{ $item->transaction_date }}"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                            placeholder="" required>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-4 mb-6">
                    <div class="w-full md:w-1/2">
                        <label for="charge" class="block mb-2 text-sm font-medium text-gray-900 ">Rencana Masuk</label>
                        <input type="date" id="checkin_date" name="checkin_date" value="{{ $item->checkin_date }}"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                            placeholder="" required>
                    </div>
                    <div class="w-full md:w-1/2">
                        <label for="charge" class="block mb-2 text-sm font-medium text-gray-900 ">Durasi (Bulan)</label>
                        <input type="text" id="duration" name="duration" value="{{ $item->duration }}"
                            onchange="updateRoomPrice()"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                            placeholder="" required>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-4 mb-6">
                    <div class="w-full md:w-1/2">
                        <label for="charge" class="block mb-2 text-sm font-medium text-gray-900 ">Kamar</label>
                        <select id="room_id" name="room_id" onchange="updateRoomPrice()"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5">
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" data-price="{{ $room->price }}"
                                    {{ old('room_id', $room->id) == $selectedRoomId ? 'selected' : '' }}>
                                    {{ $room->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full md:w-1/2">
                        <label for="charge" class="block mb-2 text-sm font-medium text-gray-900 ">Harga Kamar</label>
                        <input type="text" id="amount" name="amount" value="{{ 'Rp ' . number_format($item->amount, 0, ',', '.') }}"
                            class="form-control rupiah-input bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                            placeholder="" required>
                        <input type="hidden" id="room_price" name="room_price">
                    </div>
                </div>
                @if ($item->idcard_image)
                    <div class="grid m-6 place-items-center">
                        <label for="image" class="block mb-2 text-sm font-medium text-gray-900 ">Gambar KTP</label>
                        {{-- <img src="{{ asset('/storage/room-images' . $item->image) }}" class="rounded max-h-96"> --}}
                        <img src="data:image/png;base64,{{ $item->idcard_image }}" alt="Room Image"
                            class="rounded max-h-96">
                    </div>
                @endif
                @if ($item->guest_image)
                    <div class="grid m-6 place-items-center">
                        <label for="image" class="block mb-2 text-sm font-medium text-gray-900 ">Foto Penghuni</label>
                        {{-- <img src="{{ asset('/storage/room-images' . $item->image) }}" class="rounded max-h-96"> --}}
                        <img src="data:image/png;base64,{{ $item->guest_image }}" alt="Room Image"
                            class="rounded max-h-96">
                    </div>
                @endif
                <div class="flex flex-col md:flex-row gap-4 mb-6">
                    <div class="w-full md:w-1/2">
                        <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900 ">Pihak Pertama</label>
                        <select id="user_id" name="user_id"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" user
                                    {{ old('user_id', $user->id) == $selectedUserId ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="mb-6">
                    <label for="remark" class="block mb-2 text-sm font-medium text-gray-900 ">Keterangan</label>
                    <textarea type="text" id="remark" name="remark"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" disabled>{{ $item->remark }} </textarea>
                </div>
        </div>
        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </form>
    </div>

    </div>

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
            const duration = document.getElementById("duration").value; // Ensure to get the value of duration
            const selectedOption = roomSelect.options[roomSelect.selectedIndex];

            // Get the price from the data-price attribute and convert it to a number
            let amount = parseFloat(selectedOption.getAttribute("data-price")) * parseInt(duration);
            let price = parseFloat(selectedOption.getAttribute("data-price"));

            console.log(price);

            // Remove decimal part and ensure it's a valid number
            amount = !isNaN(amount) ? Math.floor(amount) : 0;
            price = !isNaN(price) ? Math.floor(price) : 0;

            // Set the room_price input field to the calculated price
            document.getElementById("amount").value = amount;
            document.getElementById("room_price").value = price;
        }
    </script>

@endsection

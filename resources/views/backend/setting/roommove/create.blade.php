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
            <form method="post" action="/dashboard/roommove" >
                @csrf
                <div class="flex flex-col md:flex-row gap-4 mb-6">
                    <div class="w-full md:w-1/2">
                        <label for="from_room_id" class="block mb-2 text-sm font-medium text-gray-900">Nama/Nomor
                            Kamar</label>
                        <select id="from_room_id" name="from_room_id" onchange="updateGuest()"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5">
                            @foreach ($occupiedRooms as $room)
                                <option value="{{ $room->id }}" data-guestName="{{ $room->bill->first()->guest_name ?? 'N/A' }}">{{ $room->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full md:w-1/2">
                        <label for="guest_name" class="block mb-2 text-sm font-medium text-gray-900">Nama Penghuni</label>
                        <input type="text" id="guest_name" name="guest_name"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                            placeholder="" readonly>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-4 mb-6">
                    <div class="w-full md:w-1/2">
                        <label for="to_room_id" class="block mb-2 text-sm font-medium text-gray-900 ">Pindah Ke
                            </label>
                        <select id="to_room_id" name="to_room_id"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5">
                            @foreach ($freeRooms as $room)
                                <option value="{{ $room->id }}">{{ $room->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full md:w-1/2">
                        <label for="move_date" class="block mb-2 text-sm font-medium text-gray-900 ">Tanggal
                            Pindah</label>
                        <input type="date" id="move_date" name="move_date"
                            class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                            placeholder="" required>
                    </div>                    </div>

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

    <script type="text/javascript">
        $(document).ready(function() {
            $('#from_room_id').select2({
                placeholder: "Select a room",
                allowClear: true
            });
            $('#to_room_id').select2({
                placeholder: "Select a room",
                allowClear: true
            });
             updateGuest()
        });

        function updateGuest() {
            // Get the selected option from the dropdown
            const roomSelect = document.getElementById("from_room_id");
            const selectedOption = roomSelect.options[roomSelect.selectedIndex];

            let guestName = selectedOption.getAttribute("data-guestName");

            // Set the room_price input field to the integer value
            document.getElementById("guest_name").value = guestName;
        }
    </script>
@endsection

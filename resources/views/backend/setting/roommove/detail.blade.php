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
            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <div class="w-full md:w-1/2">
                    <label for="guest_name" class="block mb-2 text-sm font-medium text-gray-900">Nama Penghuni</label>
                    <input type="text" id="guest_name" name="guest_name" value="{{ $item->guest_name }}"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" disabled>
                </div>
                <div class="w-full md:w-1/2">
                    <label for="idcard_no" class="block mb-2 text-sm font-medium text-gray-900">NIK Penghuni</label>
                    <input type="text" id="idcard_no" name="idcard_no" value="{{ $item->idcard_no }}"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" disabled>
                </div>
            </div>
            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <div class="w-full md:w-1/2">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Pekerjaan
                        Penghuni</label>
                    <input type="text" id="guest_job" name="guest_job" value="{{ $item->guest_job }}"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" disabled>
                </div>
                <div class="w-full md:w-1/2">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Status Pernikahan
                        Penghuni</label>
                    <input type="text" id="marital_status" name="marital_status" value="{{ $item->marital_status }}"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" disabled>
                </div>
            </div>
            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <div class="w-full md:w-1/2">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Tempat Lahir</label>
                    <input type="text" id="born_place" name="born_place" value="{{ $item->born_place }}"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" disabled>
                </div>
                <div class="w-full md:w-1/2">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Tanggal Lahir</label>
                    <input type="date" id="birth_date" name="birth_date" value="{{ $item->birth_date }}"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" disabled>
                </div>
            </div>
            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <div class="w-full md:w-1/2">
                    <label for="charge" class="block mb-2 text-sm font-medium text-gray-900 ">Nomor Transaksi</label>
                    <input type="text" id="transaction_no" name="transaction_no" value="{{ $item->transaction_no }}"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" readonly>
                </div>
                <div class="w-full md:w-1/2">

                    <label for="charge" class="block mb-2 text-sm font-medium text-gray-900 ">Tanggal
                        Transaksi</label>
                    <input type="date" id="transaction_date" name="transaction_date"
                        value="{{ $item->transaction_date }}"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" disabled>
                </div>
            </div>
            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <div class="w-full md:w-1/2">
                    <label for="charge" class="block mb-2 text-sm font-medium text-gray-900 ">Rencana Masuk</label>
                    <input type="date" id="checkin_date" name="checkin_date" value="{{ $item->checkin_date }}"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" disabled>
                </div>
                <div class="w-full md:w-1/2">
                    <label for="charge" class="block mb-2 text-sm font-medium text-gray-900 ">Durasi (Bulan)</label>
                    <input type="text" id="duration" name="duration" value="{{ $item->duration }}"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" disabled>
                </div>
            </div>
            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <div class="w-full md:w-1/2">
                    <label for="room_id" class="block mb-2 text-sm font-medium text-gray-900 ">Kamar</label>
                    <input type="text" id="duration" name="duration" value="{{ $item->room->name }}"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" disabled>

                </div>
                <div class="w-full md:w-1/2">
                    <label for="charge" class="block mb-2 text-sm font-medium text-gray-900 ">Harga Kamar</label>
                    <input type="text" id="room_price" name="room_price" value="{{ $item->room_price }}"
                        class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                        placeholder="" disabled>
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
                    <img src="data:image/png;base64,{{ $item->guest_image }}" alt="Room Image" class="rounded max-h-96">
                </div>
            @endif
            <div class="mb-6">
                <label for="remark" class="block mb-2 text-sm font-medium text-gray-900 ">Keterangan</label>
                <textarea type="text" id="remark" name="remark"
                    class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                    placeholder="" disabled>{{ $item->remark }} </textarea>
            </div>
        </div>
    </div>




@endsection

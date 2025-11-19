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
            <div class="mb-6">
                <label for="transaction_no" class="block mb-2 text-sm font-medium text-gray-900 ">Nomor Transaksi</label>
                <input type="text" id="transaction_no" name="transaction_no"
                    class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                    placeholder="" value="{{ $item->transaction_no }}" disabled>
            </div>
            <div class="mb-6">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Nama Pembayaran</label>
                <input type="text" id="name" name="name"
                    class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                    placeholder="" value="{{ $item->name }}" disabled>
            </div>
            <div class="mb-6">
                <label for="transaction_date" class="block mb-2 text-sm font-medium text-gray-900 ">Tanggal
                    Pembayaran</label>
                <input type="date" id="transaction_date" name="transaction_date"
                    class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                    placeholder="" value="{{ $item->transaction_date }}" disabled>
            </div>
            <div class="mb-6">
                <label for="amount" class="block mb-2 text-sm font-medium text-gray-900 ">Jumlah Harga</label>
                <input type="text" id="amount" name="amount"
                    class="form-control rupiah-input bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                    placeholder="" value="{{ 'Rp ' . number_format($item->amount, 0, ',', '.') }}" disabled>
            </div>
            @if ($item->image)
                <div class="grid m-6 place-items-center">
                    <label for="image" class="block mb-2 text-sm font-medium text-gray-900 ">Gambar</label>
                    {{-- <img src="{{ asset('/storage/room-images' . $item->image) }}" class="rounded max-h-96"> --}}
                    <img src="data:image/png;base64,{{ $item->image }}" alt="Room Image" class="rounded max-h-96">
                </div>
            @endif
            <div class="mb-6">
                <label for="floor" class="block mb-2 text-sm font-medium text-gray-900 ">Keterangan</label>
                <textarea type="text" id="remark" name="remark"
                    class="form-control bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                    placeholder="" disabled>{{ $item->remark }} </textarea>
            </div>

        </div>

    </div>



@endsection

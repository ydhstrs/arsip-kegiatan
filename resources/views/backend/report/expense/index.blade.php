@extends('layouts.app')

@section('title', $title)

@section('content')
    @php
        $user = Auth::user();
        $userh = $user->id_hotel;
        $isfinance = $user->isfinance;

        Auth::setUser($user);

    @endphp
    {{-- <div class="grid grid-rows-1 gap-2 grid-flow-col"> --}}
    <div class="container-xxl flex-grow-1 container-p-y">
        <h1 class="text-center text-3xl font-bold">{{ $title}}</h1>

        <div class="card">

            <form method="GET" action="expense">
                <div class="flex items-center mt-8 mx-2">

                    <div class="relative">
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input name="from" type="date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:border-gray-600  dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Select date start" value="{{ Request::old('from') }}">
                    </div>
                    <span class="mx-4 text-gray-500">to</span>

                    <div class="relative">
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input name="to" type="date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:border-gray-600  dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Select date end" name="to" value="{{ Request::old('to') }}">
                    </div>
                    <button type="submit"
                        class="bg-blue-900 text-white py-2 px-6 mx-4 hover:opacity-75 rounded-lg flex gap-2 place-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>Filter</button>

            </form>
            <form method="get" action="{{ route('expense.export') }}">
                <input type='hidden' name="from" value="{{ Request::old('from') }}">
                <input type='hidden' name="to" value="{{ Request::old('to') }}">
                <button type="submit"
                    class="bg-green-900 text-white py-2 px-6 mx-4 hover:opacity-75 rounded-lg flex gap-2 place-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    Export</button>

            </form>
        </div>

        <div class="text-right">
            <p class="text-right font-sans font-semibold text-red-700">Grand Uang Keluar :
                Rp{{ number_format($grandUangKeluar) }}</p>

        </div>



        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border border-gray-200 w-5/6 mx-auto">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border border-gray-200">No</th>
                        <th class="px-4 py-2 border border-gray-200">Nomor Transaksi</th>
                        <th class="px-4 py-2 border border-gray-200">Jenis Transaksi</th>
                        <th class="px-4 py-2 border border-gray-200">Tanggal</th>
                        <th class="px-4 py-2 border border-gray-200 text-center">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border">{{ $item->transaction_no }}</td>
                            <td class="px-4 py-2 border">{{ $item->transaction_type }}</td>
                            <td class="px-4 py-2 border">
                                {{ \Carbon\Carbon::parse($item->date)->translatedFormat('d F Y') }}</td>
                            <td class="px-4 py-2 border text-right">{{ 'Rp ' . number_format($item->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4">
            {{ $items->links() }}
        </div>
    </div>

    </div>
@endsection

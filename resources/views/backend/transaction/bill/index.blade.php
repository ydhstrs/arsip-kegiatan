@extends('layouts.app')

@section('title', $title)

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <h1 class="text-center">{{ $title }}</h1>

        {{-- <a href="/dashboard/bill/create" class="btn btn-primary mb-4">Tambah {{ $title }}</a> --}}

        <div class="card">
            <div class="card-body">
                <table id="billTable" class="table table-striped table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nomor Transaksi</th>
                            <th>Nama</th>
                            <th>Tanggal Bill</th>
                            <th>Tanggal Pembayaran</th>
                            <th class="text-center" >Jumlah</th>
                            <th>Kamar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#billTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                scrollX: $(window).width() < 768, // Aktifkan scrollX hanya untuk layar kecil
                ajax: "{{ route('dashboard.bill.data') }}",
                
                columns: [{
                        data: 'id',
                        name: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'transaction_no',
                        name: 'transaction_no'
                    },
                    {
                        data: 'guest_name',
                        name: 'guest_name'
                    },
                    {
                        data: 'bill_date',
                        name: 'bill_date',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            const date = new Date(data);
                            return date.toLocaleDateString('id-ID', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric'
                            });
                            return data; // Fallback if data is null or empty
                        }
                    },
                    {
                        data: 'payment_date',
                        name: 'payment_date',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            if (data) {
                                const date = new Date(data);
                                return date.toLocaleDateString('id-ID', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric',
                                    
                                });
                            }
                            return ''; // Fallback if data is null or empty
                        }
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                        className: 'text-right',
                        render: function(data, type, row) {
                            return parseFloat(data).toLocaleString('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                            });
                        }
                    },
                    {
                        data: 'room_name',
                        name: 'room_name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endsection

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

        <a href="/dashboard/paying/create" class="btn btn-primary mb-4">Tambah {{ $title }}</a>

        <div class="card">
            <div class="card-body">
                <table id="billTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Transaksi</th>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Tanggal Pembayaran</th>
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
                ajax: "{{ route('dashboard.paying.data') }}",
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { data: 'transaction_no', name: 'transaction_no' },
                    { data: 'name', name: 'name' },
                    { data: 'amount', name: 'amount',
                          render: function(data, type, row) {
                            return parseFloat(data).toLocaleString('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                            });

                        } },
                    { data: 'transaction_date', name: 'transaction_date', orderable: true, searchable: true  },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endsection

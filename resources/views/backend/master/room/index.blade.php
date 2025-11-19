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

        <a href="/dashboard/room/create" class="btn btn-primary mb-4">Tambah {{ $title }}</a>

        <div class="card">
            <div class="card-body"class="table table-striped table-bordered w-full">
                <table id="roomTable" class="table table-striped table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tipe</th>
                            <th>Lantai</th>
                            <th class="text-center">Harga</th>
                            <th >Status</th>
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
            $('#roomTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                scrollX: $(window).width() < 768, // Aktifkan scrollX hanya untuk layar kecil
// scrollX: true, // Menambahkan scroll horizontal
                ajax: "{{ route('dashboard.room.data') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'floor',
                        name: 'floor',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'price',
                        name: 'price',
                        orderable: true,
                        searchable: false,
                        className: 'text-right',
                        render: function(data, type, row) {
                            return parseFloat(data).toLocaleString('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                            });

                        }
                    },
                    {
                        data: 'is_available',
                        name: 'is_available',
                        orderable: true,
                        searchable: false,
                        className: 'text-center',

                        render: function(data, type, row) {
                            var status = data == 1 ? 'Kosong' : 'Terisi';
                            var bgColor = data == 1 ? 'bg-success' : 'bg-danger';
                            return '<span class="' + bgColor + ' text-white p-2 rounded">' +
                                status + '</span>';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: 'text-center',   
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endsection

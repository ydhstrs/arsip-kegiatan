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

        <a href="/dashboard/roommove/create" class="btn btn-primary mb-4">Tambah {{ $title }}</a>

        <div class="card">
            <div class="card-body">
                <table id="assetTable" class="table table-striped table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Penghuni</th>
                            <th>Asal Kamar</th>
                            <th>Kamar Tujuan</th>
                            <th>Tanggal Pindah</th>
                            {{-- <th>Aksi</th> --}}
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#assetTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                scrollX: $(window).width() < 768, // Aktifkan scrollX hanya untuk layar kecil
                ajax: "{{ route('dashboard.roommove.data') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'guest_name',
                        name: 'guest_name'
                    },
                    {
                        data: 'from_room',
                        name: 'from_room',
                        orderable: true,
                        searchable: true,

                    },
                    {
                        data: 'to_room',
                        name: 'to_room',
                        orderable: true,
                        searchable: true, // Fallback if no data
                    },
                    {
                        data: 'move_date',
                        name: 'move_date',
                        render: function(data, type, row) {
                            const date = new Date(data);
                            return date.toLocaleDateString('id-ID', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric'
                            });
                            return data; // Fallback if no data
                        }
                    },
                    // {
                    //     data: 'action',
                    //     name: 'action',
                    //     orderable: false,
                    //     searchable: false
                    // }
                ]
            });
        });
    </script>
@endsection

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

        <a href="/dashboard/admin/letter/create" class="btn btn-primary mb-4">Tambah {{ $title }}</a>

        <div class="card">
            <div class="card-body"class="table table-striped table-bordered w-full">
                <table id="roomTable" class="table table-striped table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nomor Surat</th>
                            <th>Asal Surat</th>
                            <th>Status</th>
                            <th>Deskripsi</th>
                            <th>Waktu Dibuat</th>
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
                ajax: "{{ route('admin.letter.data') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'no',
                        name: 'no'
                    },
                    {
                        data: 'source',
                        name: 'source'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                    data: 'desc',
                    name: 'desc',
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        if (!data) return '';
                        return data.length > 50 ? data.substring(0, 50) + '...' : data;
                    }
                },
                {
    data: 'created_at',
    name: 'created_at',
    render: function(data) {
        if (!data) return '';

        const d = new Date(data);

        // format dd/mm/yyyy
        const day = String(d.getDate()).padStart(2, '0');
        const month = String(d.getMonth() + 1).padStart(2, '0');
        const year = d.getFullYear();

        // format HH:MM
        const hours = String(d.getHours()).padStart(2, '0');
        const minutes = String(d.getMinutes()).padStart(2, '0');

        return `${day}/${month}/${year} ${hours}:${minutes}`;
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

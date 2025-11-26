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
                ajax: "{{ route('kasi.letter.data') }}",
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
    name: 'status',
    render: function(data, type, row) {
        if (data && data.toLowerCase().includes('disetujui')) {
            return `<span class="badge bg-success">${data}</span>`;
        }
        return data; // default tanpa warna
    }
},
                    {
                        data: 'desc',
                        name: 'desc',
                        orderable: true,
                        searchable: true
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

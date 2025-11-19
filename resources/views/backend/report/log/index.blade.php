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
            <div class="card-body">
                <table id="assetTable" class="table table-striped table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Aktivitas</th>
                            <th>Dibuat</th>
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
                ajax: "{{ route('dashboard.log.data') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'activity',
                        name: 'activity'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        orderable: true,
                        searchable: true,

                    },
                ]
            });
        });
    </script>
@endsection

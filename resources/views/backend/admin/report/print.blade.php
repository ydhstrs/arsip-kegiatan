<!-- resources/views/reports/preview.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>LAPORAN KEGIATAN</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1 { text-align: center; }
        h3 { text-align: center; color: gray; }
        p { margin: 15px 0; }
        .images { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 20px; }
        .images img { max-width: 48%; height: auto; border: 1px solid #ccc; padding: 5px; }
    </style>
</head>
<body>

    <h1>{{ $item->title }}</h1>
    <h3>oleh {{ $item->staff->name ?? 'Tidak Diketahui' }}</h3>

    <p>{{ $item->desc ?? '-' }}</p>

    <div class="images">
        @if($item->file1)
            <img src="{{ public_path( $item->file1) }}" alt="Foto 1">
        @endif
        @if($item->file2)
            <img src="{{ public_path( $item->file2) }}" alt="Foto 2">
        @endif
        @if($item->file3)
            <img src="{{ public_path( $item->file3) }}" alt="Foto 3">
        @endif
        @if($item->file4)
            <img src="{{ public_path( $item->file4) }}" alt="Foto 4">
        @endif
    </div>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>LAPORAN KEGIATAN</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 30px; }
        h1 { text-align: center; font-size: 24px; margin-bottom: 5px; }
        h3 { text-align: center; color: gray; margin-top: 0; font-weight: normal; }
        p { margin: 20px 0; line-height: 1.5; }
        .images { display: flex; flex-wrap: wrap; gap: 15px; margin-top: 25px; }
        .image-container { width: 48%; text-align: center; margin-bottom: 20px; }
        .image-container img { max-width: 100%; height: auto; border: 1px solid #ccc; padding: 5px; }
        .caption { margin-top: 5px; font-size: 12px; color: #555; }
    </style>
</head>
<body>

    <h1>{{ $item->title }}</h1>
    <h3>oleh {{ $item->staff->name ?? 'Tidak Diketahui' }}</h3>

    <p>{{ $item->desc ?? '-' }}</p>

    <div class="images">
        @if($item->file1)
        <div class="image-container">
            <img src="{{ asset($item->file1) }}" alt="Foto 1">
            <div class="caption">Lampiran 1</div>
        </div>
        @endif

        @if($item->file2)
        <div class="image-container">
            <img src="{{ asset($item->file2) }}" alt="Foto 2">
            <div class="caption">Lampiran 2</div>
        </div>
        @endif

        @if($item->file3)
        <div class="image-container">
            <img src="{{ asset($item->file3) }}" alt="Foto 3">
            <div class="caption">Lampiran 3</div>
        </div>
        @endif

        @if($item->file4)
        <div class="image-container">
            <img src="{{ asset($item->file4) }}" alt="Foto 4">
            <div class="caption">Lampiran 4</div>
        </div>
        @endif
    </div>

</body>
</html>

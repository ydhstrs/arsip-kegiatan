<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .kwitansi {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
        }
        .detail {
            margin-top: 40px;
        }
        .detail table {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }
        .detail th, .detail td {
            padding: 8px;
            text-align: left;
            border: 1px solid black;
        }
        .signature {
            margin-top: 40px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="kwitansi">
    <h2>Kwitansi Pembayaran</h2>
    <p>No. Kwitansi: {{ $no_kwitansi }}</p>
    <p>Tanggal: {{ $tanggal }}</p>
</div>

<div class="detail">
    <table>
        <tr>
            <th>Nama Penerima</th>
            <td>{{ $nama_penerima }}</td>
        </tr>
        <tr>
            <th>Nama Pemberi</th>
            <td>{{ $nama_pemberi }}</td>
        </tr>
        <tr>
            <th>Uraian</th>
            <td>{{ $uraian }}</td>
        </tr>
        <tr>
            <th>Jumlah</th>
            <td>{{ $jumlah }}</td>
        </tr>
    </table>
</div>

<div class="signature">
    <p>Mengetahui,</p>
    <p>PIHAK PERTAMA</p>
    <p>(……………………..)</p>
    <p>PIHAK KEDUA</p>
    <p>(……………………..)</p>
</div>

</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perjanjian Sewa Kamar Kos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            font-size: 13px;
            padding: 0;
        }

        .container {
            width: 100%;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h2 {
            margin: 0;
        }

        .section {
            margin-bottom: 20px;
        }

        .section p {
            margin: 5px 0;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
        }

        .footer small {
            font-size: 12px;
        }

        .signature {
            margin-top: 50px;
            text-align: center;
        }

        .signature p {
            margin: 0;
        }

    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>PERJANJIAN SEWA KAMAR KOS</h2>
            <p>No: {{ $checkin->transaction_no }}</p>
        </div>

        <div class="section">
            <p>Yang bertanda tangan di bawah ini:</p>
            <p>1. {{ $checkin->user->name }}</p>
            <p>2. {{ $checkin->guest_name }} dengan NIK {{ $checkin->idcard_no }}</p>

            <p>Para pihak menerangkan terlebih dahulu hal-hal sebagai berikut:</p>
            <ul>
                <li>Pihak Pertama merupakan pemilik dari rumah kos yang terletak di Jl. Ksatria</li>
                <li>Pihak Kedua merupakan pihak yang membutuhkan kamar kos untuk tempat tinggal bagi diri
                    sendiri/bersama keluarga (coret salah satu).</li>
                <li>Rumah kos yang disewakan oleh Pihak Pertama terdiri atas 40 (empat puluh) kamar, di mana Pihak Kedua
                    akan menempati kamar nomor {{ $checkin->room->name }}</li>
                <li>Pihak Kedua telah membayar biaya sewa sebesar
                    {{ 'Rp ' . number_format($checkin->amount, 0, ',', '.') }} sehingga Pihak Kedua berhak atas sewa
                    sejak tanggal {{ \Carbon\Carbon::parse($checkin->checkin_date)->translatedFormat('d F Y') }}
                    hingga tanggal {{ \Carbon\Carbon::parse($checkin->bill?->bill_date)->translatedFormat('d F Y') ?? '-' }}

                </li>
            </ul>
        </div>

        <div class="section">
            <p>Selanjutnya, para pihak menentukan klausul perjanjian sebagai berikut:</p>
            <ol>
                <li>Pihak Pertama menjamin bahwa kamar kos yang disediakannya didasarkan pada alas kepemilikan yang sah,
                    kamar kos tersebut tidak sedang berada dalam sita, tidak menjadi jaminan pelunasan utang, dan tidak
                    sedang berada dalam status sengketa.</li>
                @if ($checkin->room->remark)
                    <li>Pihak Pertama menyediakan fasilitas kamar kos, antara lain berupa:
                        {{ $checkin->room->remark }}
                    </li>
                @endif
                <li>Pihak Pertama memberikan hak sewa kepada Pihak Kedua dengan perhitungan Pihak Kedua wajib membayar
                    biaya sewa sebesar {{ 'Rp ' . number_format($checkin->room_price, 0, ',', '.') }} /bulan.</li>
                <li>Pembayaran biaya sewa harus dilakukan oleh Pihak Kedua setiap tanggal
                    {{ \Carbon\Carbon::parse($checkin->checkin_date)->translatedFormat('d') }} per bulannya.</li>
                <li>Selama menggunakan hak sewa, Pihak Kedua wajib mematuhi tata tertib kamar kos dan peraturan yang
                    berlaku pada RT/RW, serta peraturan perundang-undangan yang berlaku.</li>
                <li>Apabila Pihak Kedua terbukti melakukan pelanggaran, Pihak Pertama berhak mengeluarkan Pihak Kedua
                    dari kamar kos dan biaya sewa yang masih tersisa menjadi milik Pihak Pertama.</li>
                <li>Pihak Kedua tidak memiliki hak sewa apabila tidak melakukan pembayaran tepat waktu, meskipun telah
                    ada pemberitahuan/teguran.</li>
                <li>Pihak Pertama berhak meminta Pihak Kedua untuk mengosongkan kamar kos jika hak sewa telah berakhir.
                </li>
                <li>Apabila Pihak Kedua tidak mengosongkan kamar kos, Pihak Pertama berhak mengosongkannya kapan saja.
                </li>
                <li>Seluruh biaya pengosongan menjadi utang Pihak Kedua.</li>
                <li>Pihak Pertama tidak bertanggung jawab atas kerusakan atau kehilangan barang milik Pihak Kedua selama
                    pengosongan.</li>
                <li>Pihak Kedua tidak memiliki hak untuk mengajukan gugatan terkait pengosongan kamar kos.</li>
                <li>Apabila terjadi perselisihan terkait hak sewa, para pihak akan menempuh jalur musyawarah, dan jika
                    tidak berhasil, sepakat memilih Pengadilan Negeri sebagai forum hukum penyelesaian sengketa.
                </li>
                <li>Seluruh tata tertib yang dibuat oleh Pihak Pertama merupakan satu kesatuan yang tidak terpisahkan
                    dari perjanjian ini.</li>
                <li>Para pihak telah membaca, mengerti, dan memahami seluruh klausul dalam perjanjian ini.</li>
            </ol>
        </div>
        <p>Demikian perjanjian dibuat pada tanggal
                {{ \Carbon\Carbon::parse($checkin->transaction_date)->translatedFormat('d F Y') }} bertempat di Binjai,
                dengan ditandatangani oleh para pihak di
                atas meterai Rp10.000,- sehingga memiliki kekuatan hukum pembuktian yang sama bagi masing-masing pihak.
            </p>
<div style="width: 100%; display: table;">
    <div style="display: table-row;">
        <div style="display: table-cell; text-align: center; vertical-align: top; padding: 10px;">
            <p style="margin-top: 30px;">PIHAK PERTAMA</p>
            <p style="margin-top: 60px;">({{ $checkin->user->name }})</p>
        </div>
        <div style="display: table-cell; text-align: center; vertical-align: top; padding: 10px;">
            <p style="margin-top: 30px;">PIHAK KEDUA</p>
            <p style="margin-top: 60px;">({{ $checkin->guest_name }})</p>
        </div>
    </div>
</div>

    </div>
</body>

</html>

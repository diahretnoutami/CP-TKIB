<!DOCTYPE html>
<html>

<head>
    <title>Laporan Capaian Pembelajaran</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            position: relative;
        }

        .logo-bg {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.2;
            /* lebih soft agar isi tetap jelas */
            z-index: -1;
            width: 500px;
        }

        .header {
            text-align: center;
            z-index: 1;
            position: relative;
        }

        table.info-table {
            width: 100%;
            margin-bottom: 10px;
            border: none;
            border-collapse: collapse;
        }

        table.info-table td {
            border: none;
            padding: 0px 10px;
            vertical-align: top;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            z-index: 1;
            position: relative;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 10px;
            vertical-align: top;
        }

        .judul-materi {
            font-weight: bold;
            margin-top: 30px;
            font-size: 16px;
        }

        .foto {
            width: 200px;
            height: auto;
        }
    </style>
</head>

<body>

    {{-- Logo sebagai background di tiap halaman --}}
    <img src="{{ public_path('assets/img/logoooo.png') }}" class="logo-bg" alt="Logo Background">

    <div class="header">
        <h2 style="margin: 0; padding: 0;">LAPORAN CAPAIAN PEMBELAJARAN</h2>
        <h4 style="margin: 0; padding: 0;">Tahun Pelajaran 2024/2025</h4>
    </div>

    <table class="info-table">
        <tr>
            <td style="width: 50%;">
                <p style="margin: 0; line-height: 1.3; font-size: 12px;"><strong>Nama:</strong> {{ $siswa->nama }}</p>
                <p style="margin: 0; line-height: 1.3; font-size: 12px;"><strong>Nomor Induk:</strong>
                    {{ $siswa->noinduk }}</p>
            </td>
            <td style="width: 50%;">
                <p style="margin: 0; line-height: 1.3; font-size: 12px;"><strong>Kelas:</strong>
                    {{ $siswa->kelas->first()->nama_kelas ?? '-' }}</p>
                <p style="margin: 0; line-height: 1.3; font-size: 12px;"><strong>Semester:</strong>
                    {{ $laporan->first()->first()->semester ?? '1' }}</p>
            </td>
        </tr>
    </table>

    @foreach ($laporan as $materi => $items)
        @php
            $keterangan = $items->first()->keterangan ?? '-';
        @endphp
        <div style="page-break-inside: avoid;">
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 1px;">
                <tr>
                    <td colspan="2"
                        style="background-color: #d0f0c0; font-weight: bold; padding: 10px; font-size: 16px; text-align: center;">
                        {{ $materi ?? 'Tanpa Judul Materi' }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 65%; border: 1px solid #000; padding: 10px; vertical-align: top;">
                        {!! nl2br(e($keterangan)) !!}
                    </td>
                    <td style="width: 35%; border: 1px solid #000; padding: 10px; text-align: center;">
                        @forelse ($items as $item)
                            @if ($item->dokumentasi)
                                <div style="margin-bottom: 5px;">
                                    <img src="{{ public_path('storage/' . $item->dokumentasi) }}"
                                        style="max-width: 100%; height: auto;">
                                </div>
                            @endif
                        @empty
                            <em>Tidak ada dokumentasi</em>
                        @endforelse
                    </td>
                </tr>
            </table>
        </div>
    @endforeach


    <h3 style="margin-top: 20px; margin-bottom: 0px; text-align: center;">Ketidakhadiran</h3>

    <div style="page-break-inside: avoid;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <th style="width: 50%; border: 1px solid #000; padding: 3px; text-align: center;">Jenis</th>
                <th style="width: 50%; border: 1px solid #000; padding: 3px; text-align: center;">Jumlah</th>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 3px; text-align: left;">Sakit</td>
                <td style="border: 1px solid #000; padding: 3px; text-align: right;">{{ $sakit }} hari</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 3px; text-align: left;">Izin</td>
                <td style="border: 1px solid #000; padding: 3px; text-align: right;">
                    {{ $izin > 0 ? $izin . ' hari' : '' }}
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 3px; text-align: left;">Tanpa Keterangan</td>
                <td style="border: 1px solid #000; padding: 3px; text-align: right;">{{ $alfa }} hari</td>
            </tr>
        </table>
    </div>


    <h3 style="margin-top: 20px; margin-bottom: 0px; text-align: center;">Pertumbuhan Anak</h3>

    <div style="page-break-inside: avoid;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <th style="width: 50%; border: 1px solid #000; padding: 3px; text-align: center; font-size: 14px;">Jenis
                </th>
                <th style="width: 50%; border: 1px solid #000; padding: 3px; text-align: center; font-size: 14px;">
                    Jumlah</th>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 3px; text-align: left;">Tinggi Badan</td>
                <td style="border: 1px solid #000; padding: 3px; text-align: right;">{{ $tinggiBadan }} cm</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 3px; text-align: left;">Berat Badan</td>
                <td style="border: 1px solid #000; padding: 3px; text-align: right;">{{ $beratBadan }} kg</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 3px; text-align: left;">Lingkar Kepala</td>
                <td style="border: 1px solid #000; padding: 3px; text-align: right;">{{ $lingkarKpl }} cm</td>
            </tr>
        </table>
    </div>

    <p style="text-align: right;">
        Pekanbaru, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
    </p>

    <div style="width: 100%; margin-top: 5px;">
        <div style="width: 50%; float: left; text-align: center;">
            Orang Tua / Wali Murid<br><br><br><br>
            _________________________
        </div>
        <div style="width: 50%; float: right; text-align: center;">
            Wali Kelas<br><br><br><br>
            <u>{{ $waliKelas->namaguru ?? '-' }}</u>
        </div>
        <div style="clear: both;"></div>
    </div>

    <br><br>

    <div style="text-align: center; margin-top: 60px;">
        Mengetahui<br>
        Kepala TK Islam Baiturrahman<br><br><br><br>
        <u>{{ $kepsek->namaguru ?? '-' }}</u>
    </div>



</body>

</html>

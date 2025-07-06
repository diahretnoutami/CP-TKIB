@section('content')
    @include('layouts.header') {{-- Pastikan header ini sesuai untuk tampilan admin --}}


    <div class="main-content">
        <div class="container-fluid pt-7">
            <h1 class="text-success" style="margin-top: -100px; margin-bottom: 20px;">Data Hasil Penilaian Mingguan</h1>
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="mb-3">Siswa: {{ $kelasSiswa->siswa->nama }}</h4>
                    <h5 class="mb-4">Minggu ke-{{ $minggu }}</h5>
                    <div class="table-responsive">
                        {{-- Menghilangkan tag <form> dan semua isinya yang terkait dengan input --}}
                        {{-- Karena halaman ini sekarang murni untuk menampilkan data, bukan mengedit --}}

                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable">
                                <thead>
                                    <tr>
                                        <th style="text-align: center; font-size: 16px;">No</th>
                                        <th style="text-align: center; font-size: 16px; width: 15%;">NOMOR ALUR</th> {{-- Tambah kolom Nomor Alur --}}
                                        <th style="text-align: center; font-size: 16px; width: 45%;">ALUR</th>
                                        <th style="text-align: center; font-size: 16px; width: 10%;">NILAI</th>
                                        <th style="text-align: center; font-size: 16px;">KETERANGAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($nilaiPerAlur as $item)
                                        <tr>
                                            <td style="text-align: center;">{{ $loop->iteration }}</td>
                                            <td style="text-align: left; word-break: break-word; white-space: normal; overflow-wrap: break-word;">
                                                {{-- Akses properti nomoralur langsung dari objek $item --}}
                                                {{ $item->nomoralur ?? '-' }}
                                            </td>
                                            <td style="text-align: left; word-break: break-word; white-space: normal; overflow-wrap: break-word;">
                                                {{-- Akses properti alurp langsung dari objek $item --}}
                                                {{ $item->alurp ?? '-' }}
                                            </td>
                                            <td style="text-align: center;">
                                                {{-- Tampilkan nilai langsung dari objek $item --}}
                                                {{ $item->hasil }}
                                            </td>
                                            <td style="text-align: left; word-break: break-word; white-space: normal; overflow-wrap: break-word;">
                                                {{-- Tampilkan keterangan langsung dari objek $item --}}
                                                {{ $item->keterangan }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" style="text-align: center;">No data available in table</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://argon-dashboard-laravel-bs4.creative-tim.com/argon/vendor/jquery/dist/jquery.min.js"></script>
        <script src="https://argon-dashboard-laravel-bs4.creative-tim.com/argon/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable({
                    columnDefs: [{
                            width: "50px",
                            targets: 0
                        },
                        {
                            width: "15%", // Kolom NOMOR ALUR
                            targets: 1
                        },
                        {
                            width: "45%", // Kolom ALUR
                            targets: 2
                        },
                        {
                            width: "10%", // Kolom NILAI
                            targets: 3
                        },
                        {
                            width: "auto", // Kolom KETERANGAN (mengambil sisa ruang)
                            targets: 4
                        }
                    ],
                    autoWidth: false // Penting agar columnDefs berfungsi
                });
            });
        </script>

        </body>

        </html>

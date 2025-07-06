@section('content')
    @include('layouts.headerguru')

    <div class="main-content">
        <div class="container-fluid pt-7">
            <h1 class="text-success" style="margin-top: -100px; margin-bottom: 20px;">Data Laporan Hasil Belajar</h1>
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="text-align: center; font-size: 16px;">No</th>
                                    <th style="text-align: center; font-size: 16px;">Nama Siswa</th>
                                    <th style="text-align: center; font-size: 16px;">Jenis Kelamin</th>
                                    <th style="text-align: center; font-size: 16px;">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($data as $index => $row)
                                    <tr>
                                        <td style="text-align: center;">{{ $index + 1 }}</td>
                                        {{-- akses nama siswa dari relasi kelasSiswa → siswa --}}
                                        <td style="text-align: center">{{ $row->nama }}</td>
                                        <td style="text-align: center">
                                            {{ $row->jeniskelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                        <td style="text-align: center;">
                                            <a href="{{ route('lap.edit', $row->noinduk) }}"
                                                class="btn btn-primary btn-sm">Input</a>

                                            @php
                                                $kelasSiswa = $row->kelasSiswaAktif;
                                                $laporanAda = $kelasSiswa && $laporan->has($kelasSiswa->id_kelas_siswa);
                                            @endphp

                                            @if ($laporanAda)
                                                <a href="{{ route('lap.ekspor', $row->noinduk) }}"
                                                    class="btn btn-warning btn-sm">Cetak PDF</a>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>

                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://argon-dashboard-laravel-bs4.creative-tim.com/argon/vendor/jquery/dist/jquery.min.js"></script>
    <script
        src="https://argon-dashboard-laravel-bs4.creative-tim.com/argon/vendor/bootstrap/dist/js/bootstrap.bundle.min.js">
    </script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>

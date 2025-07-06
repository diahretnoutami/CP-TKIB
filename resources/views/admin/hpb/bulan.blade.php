@section('content')
    @include('layouts.header') {{-- Sesuaikan jika header berbeda untuk admin --}}

    <div class="main-content">
        <div class="container-fluid pt-7">
            <h1 class="text-success" style="margin-top: -100px; margin-bottom: 20px;">Daftar Bulan Penilaian</h1>
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="mb-3">Siswa: {{ $siswa->nama }}</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th style="text-align: center; font-size: 16px;">No</th>
                                    <th style="text-align: center; font-size: 16px;">Bulan</th>
                                    <th style="text-align: center; font-size: 16px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($hasilList as $bulan => $hasilBulan)
                                    <tr>
                                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                                        <td style="text-align: center;">{{ $bulan }}</td>
                                        <td style="text-align: center;">
                                            <a href="{{ route('hpbdetail', [$id_kelas_siswa, $bulan]) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align: center;">Tidak ada data penilaian bulanan.</td> {{-- Sesuaikan colspan --}}
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
            $('#dataTable').DataTable();
        });
    </script>
    </body>

    </html>
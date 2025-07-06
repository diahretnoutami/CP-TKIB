@section('content')
    @include('layouts.header')

      <div class="main-content">
        <div class="container-fluid pt-7">
            <h1 class="text-success" style="margin-top: -100px; margin-bottom: 20px;">Data Hasil Penilaian Mingguan</h1>
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="text-default">Pilih Minggu pada {{ $siswa->nama }}</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="text-align:center">No</th>
                                    <th style="text-align:center">Minggu</th>
                                    <th style="text-align:center">Semester</th>
                                    <th style="text-align:center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hasilList as $minggu => $items)
                                    <tr>
                                        <td style="text-align:center">{{ $loop->iteration }}</td>
                                        <td style="text-align:center">{{ $minggu }}</td>
                                        <td style="text-align:center">
                                            {{ $items->first()->alur->semester ?? '-' }}
                                        </td>
                                        <td style="text-align:center">
                                            <a href="{{ route('hpmdetail', [$id_kelas_siswa, $minggu]) }}"
                                                class="btn btn-warning btn-sm">Lihat Detail</a>
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
            $('#dataTable').DataTable(); // <--- ini bikin search & pagination aktif
        });
    </script>

    </body>

    </html>
@section('content')
    @include('layouts.headerguru')

    <div class="main-content">
        <div class="container-fluid pt-7">
            <h1 class="text-success mb-4" style="margin-top: -100px;">Data Penilaian Mingguan</h1>

            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">No</th>
                                    <th style="text-align: center;">Nama Siswa</th>
                                    <th style="text-align: center;">Jenis Kelamin</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $row)
                                    <tr>
                                        <td style="text-align: center;">{{ $index + 1 }}</td>
                                        <td style="text-align: center;">{{ $row->nama }}</td>
                                        <td style="text-align: center;">
                                            {{ $row->jeniskelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                        <td style="text-align: center;">
                                            <a href="{{ route('guru.hpminputmgg', $row->noinduk) }}"
                                                class="btn btn-primary btn-sm">Input Nilai</a>
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

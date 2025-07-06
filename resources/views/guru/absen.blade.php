@section('content')
    @include('layouts.headerguru')

    <div class="main-content">
        <div class="container-fluid pt-7">
            <h1 class="text-success" style="margin-top: -100px; margin-bottom: 20px;">Data Absensi</h1>
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <a href="{{ route('guru.inputabsen') }}" class="btn btn-success mb-3">
                            + Tambah Absensi
                        </a>
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="text-align: center; font-size: 16px;">Tanggal</th>
                                    <th style="text-align: center; font-size: 16px;">Total Absensi</th>
                                    <th style="text-align: center; font-size: 16px;">Total Hadir</th>
                                    <th style="text-align: center; font-size: 16px;">Total Izin</th>
                                    <th style="text-align: center; font-size: 16px;">Total Sakit</th>
                                    <th style="text-align: center; font-size: 16px;">Total Alpha</th>
                                    <th style="text-align: center; font-size: 16px;">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($data as $index => $row)
                                    <tr>
                                        <td style="text-align: center;">{{ $row->tanggal }}</td>
                                        <td style="text-align: center;">{{ $row->total }}</td>
                                        <td style="text-align: center;">{{ $row->hadir }}</td>
                                        <td style="text-align: center;">{{ $row->izin }}</td>
                                        <td style="text-align: center;">{{ $row->sakit }}</td>
                                        <td style="text-align: center;">{{ $row->alpha }}</td>
                                        <td style="text-align: center;">
                                            <a href="{{ route('guru.absendetail', ['tanggal' => $row->tanggal]) }}"
                                                class="btn btn-info btn-sm">
                                                Detail
                                            </a>
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

@section('content')
    @include('layouts.header')


    <div class="main-content">
        <div class="container-fluid pt-7">
            <h1 class="text-success" style="margin-top: -100px; margin-bottom: 20px;">Data Absensi Kelas
                </h1>
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="text-default">Pilih Tanggal pada Kelas {{ $kelas->nama_kelas }}</h4>
                    <div class="table-responsive">
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
                                @foreach ($data as $row)
                                    <tr>
                                        <td style="text-align: center;">
                                            {{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
                                        <td style="text-align: center;">{{ $row->total }}</td>
                                        <td style="text-align: center;">{{ $row->hadir }}</td>
                                        <td style="text-align: center;">{{ $row->izin }}</td>
                                        <td style="text-align: center;">{{ $row->sakit }}</td>
                                        <td style="text-align: center;">{{ $row->alpha }}</td>
                                        <td style="text-align: center;">
                                            <a href="{{ route('admin.absensi.detail', ['id_ta' => $tahunAjaran->id_ta, 'id_kelas' => $kelas->id_k, 'tanggal' => $row->tanggal]) }}"
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

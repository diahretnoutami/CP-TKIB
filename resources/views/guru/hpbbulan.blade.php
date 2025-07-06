@section('content')
    @include('layouts.headerguru')


    <div class="main-content">
        <div class="container-fluid pt-7">
            <h1 class="text-success mb-4" style="margin-top: -100px;">Input Penilaian Bulanan</h1>

            <div class="card shadow">
                <div class="card-body">
                    <h4>Siswa: {{ $kelasSiswa->siswa->nama }}</h4>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Bulan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bulan as $index => $b)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>Bulan {{ $b }}</td>
                                        <td>
                                            <a href="{{ route('guru.hpbinput', ['id_kelas_siswa' => $kelasSiswa->id_kelas_siswa, 'bulan' => $b]) }}"
                                                class="btn btn-primary btn-sm">Pilih</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('hpb.index') }}" class="btn btn-secondary mt-4">Kembali</a>
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
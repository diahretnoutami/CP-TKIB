a@section('content')
@include('layouts.headerguru')

<div class="main-content">
    <div class="container-fluid pt-7">
        <h1 class="text-success" style="margin-top: -100px; margin-bottom: 20px;">Pilih Tanggal Penilaian Harian
        </h1>
        <div class="card shadow">
            <div class="card-body">
                <h4 class="mb-4">Siswa: {{ $kelasSiswa->siswa->nama }}</h4>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="text-align: center; font-size: 16px; width: 50px;">No</th>
                                <th style="text-align: center; font-size: 16px;">Tanggal</th>
                                <th style="text-align: center; font-size: 16px;">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                                    <td style="text-align: center;">
                                        {{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('guru.hphinput', 
                                        ['tanggal' => $row->tanggal, 'id_kelas_siswa' => 
                                        $id_kelas_siswa]) }}" class="btn btn-primary btn-sm">Pilih</a>

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

    $('#dataTable').DataTable({
        autoWidth: false
    });
</script>

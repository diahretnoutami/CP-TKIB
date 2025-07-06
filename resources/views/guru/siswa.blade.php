@section('content')
    @include('layouts.headerguru')

    <div class="main-content">
        <div class="container-fluid pt-7">
            <h1 class="text-success" style="margin-top: -100px; margin-bottom: 20px;">Data Siswa</h1>
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="text-align: center; font-size: 16px;">No</th>
                                    <th style="text-align: center; font-size: 16px;">Nama Siswa</th>
                                    <th style="text-align: center; font-size: 16px;">Jenis Kelamin</th>
                                    <th style="text-align: center; font-size: 16px;">Tempat Lahir</th>
                                    <th style="text-align: center; font-size: 16px;">Tanggal Lahir</th>
                                    <th style="text-align: center; font-size: 16px;">Status</th>
                                    <th style="text-align: center; font-size: 16px;">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($data as $index => $row)
                                    <tr>
                                        <td style="text-align: center;">{{ $index + 1 }}</td>
                                        <td style="text-align: center">{{ $row->nama }}</td>
                                        <td style="text-align: center">
                                            {{ $row->jeniskelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                        <td style="text-align: center">{{ $row->tempatlahir }}</td>
                                        <td style="text-align: center">
                                            {{ \Carbon\Carbon::parse($row->tgllahir)->format('d-m-Y') }}</td>
                                        <td style="text-align: center">
                                            @if ($row->status == 'L')
                                                Lulus
                                            @elseif ($row->status == 'N')
                                                Non Aktif
                                            @elseif ($row->status == 'A')
                                                Aktif
                                            @else
                                                {{ $row->status }}
                                            @endif
                                        </td>
                                        <td style="text-align: center;">
                                            {{-- Aksi edit dan hapus biasanya tidak diberikan ke guru --}}
                                            <a href="{{ route('guru.siswaedit', $row->noinduk) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
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

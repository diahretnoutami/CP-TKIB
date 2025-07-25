@section('content')
    @include('layouts.header')

    <!-- Main content -->
    <div class="main-content">
        <div class="container-fluid pt-7">
            <h1 class="text-success" style="margin-top: -100px; margin-bottom: 20px;">Halaman Penilaian Harian</h1>
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <a href="{{ route('ph.create') }}" class="btn btn-success mb-3">
                            + Tambah Penilaian Harian
                        </a>
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <div class="col-md-4">
                            </div>

                            <thead>
                                <tr>
                                    <th style="text-align: center; font-size: 16px;">No</th>
                                    <th style="text-align: center; font-size: 16px;">Hari Tanggal</th>
                                    <th style="text-align: center; font-size: 16px;">Tema</th>
                                    <th style="text-align: center; font-size: 16px;">Nomor Alur</th>
                                    <th style="text-align: center; font-size: 16px;">Kegiatan</th>
                                    <th style="text-align: center; font-size: 16px;">Minggu</th>
                                    <th style="text-align: center; font-size: 16px;">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($data as $index => $row)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('l, j F Y') }}
                                        </td>

                                        <td
                                            style="text-align: left; word-break: break-word; white-space: normal; overflow-wrap: break-word; max-width: 100px;">
                                            {{ $row->tema->tema ?? '-' }}</td>
                                        <td style="text-align: center ">{{ $row->alur->nomor_alur }}</td>
                                        <td
                                            style="text-align: left; word-break: break-word; white-space: normal; overflow-wrap: break-word; max-width: 100px;">
                                            {{ $row->kegiatan }}</td>

                                        <td
                                            style="text-align: left; word-break: break-word; white-space: normal; overflow-wrap: break-word; max-width: 100px;">
                                            {{ $row->minggu }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('ph.edit', $row->id_ph) }}"
                                                class="btn btn-info btn-sm">Edit</a>
                                            <form action="{{ route('ph.destroy', $row->id_ph) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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

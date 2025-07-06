@section('content')
    @include('layouts.header')

    <!-- Main content -->
    <div class="main-content">
        <div class="container-fluid pt-7">
            <h1 class="text-success" style="margin-top: -100px; margin-bottom: 20px;">Halaman Tahun Ajaran</h1>
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <a href="{{ route('tahunajaran.create') }}" class="btn btn-success mb-3">
                            + Tambah Tahun Ajaran
                        </a>
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <div class="col-md-4">
                            </div>

                            <thead>
                                <tr>
                                    <th style="text-align: center; font-size: 16px;">No</th>
                                    <th style="text-align: center; font-size: 16px;">Tahun Ajaran</th>
                                    <th style="text-align: center; font-size: 16px;">Status</th>
                                    <th style="text-align: center; font-size: 16px;">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($data as $index => $row)
                                    <tr>
                                        <td style="text-align: center;">{{ $index + 1 }}</td>
                                        <td
                                            style="text-align: center; word-break: break-word; white-space: normal; overflow-wrap: break-word; max-width: 100px;">
                                            {{ $row->tahunajaran }}</td>
                                        <td class="text-center">
                                            @if ($row->is_active)
                                                <span class="badge bg-success text-white">Aktif</span>
                                            @else
                                                <form action="{{ route('tahunajaran.setAktif', $row->id_ta) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button class="btn btn-outline-primary btn-sm" type="submit">Jadikan
                                                        Aktif</button>
                                                </form>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('tahunajaran.edit', $row->id_ta) }}" class="btn btn-warning btn-sm">Edit</a>

                                            <form action="{{ route('tahunajaran.destroy', $row->id_ta) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
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

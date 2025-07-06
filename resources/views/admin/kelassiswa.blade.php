@section('content')
    @include('layouts.header')

    <!-- Main content -->
    <div class="main-content">
        <div class="container-fluid pt-7">
            <h1 class="text-success" style="margin-top: -100px; margin-bottom: 20px;">Kelola Kelas {{ $kelas->nama_kelas }}
            </h1>
            <div class="card shadow">
                <div class="card-body">

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <div class="col-md-4"></div>
                        <thead>
                            <tr>
                                <th style="text-align: center; font-size: 16px;">No</th>
                                <th style="text-align: center; font-size: 16px;">Nomor Induk</th>
                                <th style="text-align: center; font-size: 16px;">Nama Siswa</th>
                                <th style="text-align: center; font-size: 16px;">Jenis Kelamin</th>
                                <th style="text-align: center; font-size: 16px;">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data as $index => $row)
                                <tr>
                                    <td style="text-align: center;">{{ $index + 1 }}</td>
                                    <td style="text-align: center">{{ $row->noinduk }}</td>
                                    <td style="text-align: center">{{ $row->nama }}</td>
                                    <td style="text-align: center">{{ $row->jeniskelamin }}</td>
                                    <td style="text-align: center;">
                                        <form
                                            action="{{ route('kelas.siswa.delete', ['id_k' => $kelas->id_k, 'noinduk' => $row->noinduk]) }}"
                                            method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus siswa ini dari kelas?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="container-fluid pt-2">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="text-default">Tambah Siswa ke Kelas</h4>
                    <form action="{{ route('kelas.siswa.update', $kelas->id_k) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <input type="text" id="searchSiswa" class="form-control" placeholder="Cari siswa...">
                        </div>

                        <div style="max-height: 400px; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
                            @forelse($semuaSiswa as $siswa)
                                <div class="form-check">
                                    <input class="form-check-input siswa-checkbox" type="checkbox" name="siswa[]"
                                        value="{{ $siswa->noinduk }}">
                                    <label class="form-check-label">
                                        {{ $siswa->noinduk }} - {{ $siswa->nama }}
                                    </label>
                                </div>
                            @empty
                                <p class="text-muted">Tidak ada siswa ditemukan.</p>
                            @endforelse
                        </div>


                        <button type="submit" class="btn btn-success mt-3">Simpan Anggota Kelas</button>
                        <a href="{{ route('kelas.index') }}" class="btn btn-secondary mt-3">Kembali</a>

                    </form>
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

                $('#searchSiswa').on('keyup', function() {
                    let value = $(this).val().toLowerCase();
                    $('.form-check').each(function() {
                        let label = $(this).text().toLowerCase();
                        $(this).toggle(label.includes(value));
                    });
                });

            });
        </script>

        </body>

        </html>

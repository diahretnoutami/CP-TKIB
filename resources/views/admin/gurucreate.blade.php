@section('content')
    @include('layouts.header')

    <!-- Main content -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-success">Tambah Guru</h2>

                    <form action="{{ route('guru.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-2">
                            <label>Nama Guru</label>
                            <input type="text" name="namaguru" class="form-control" required>
                        </div>

                        <div class="form-group mb-2">
                            <label>Tempat Lahir</label>
                            <input type="text" name="tempatlahir" class="form-control" required>
                        </div>

                        <div class="form-group mb-2">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggallahir" class="form-control" required>
                        </div>

                        <div class="form-group mb-2">
                            <label>Jenis Kelamin</label>
                            <select name="jeniskelamin" class="form-control" required>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group mb-2">
                            <label>Jabatan</label>
                            <select name="jabatan" class="form-control" required>
                                <option value="guru">Guru</option>
                                <option value="kepala_sekolaha">Kepala Sekolah</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="id_user">Email User</label>
                            <select name="id_user" class="form-control" required>
                                <option value="">-- Pilih Email --</option>
                                @foreach ($users as $u)
                                    <option value="{{ $u->id }}">{{ $u->email }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group mb-2">
                            <label>Tanggal Mulai Bekerja</label>
                            <input type="date" name="tanggal_masuk" class="form-control" required>
                        </div>

                        <div class="form-group mb-2">
                            <label>Alamat</label>
                            <input type="text" name="alamat" class="form-control" required>
                        </div>

                        <div class="form-group mb-2">
                            <label>Nomor Hp</label>
                            <input type="text" name="nohp" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success mt-3">Simpan</button>
                        <a href="{{ route('guru.index') }}" class="btn btn-secondary mt-3">Kembali</a>
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
            });
        </script>

        </body>

        </html>

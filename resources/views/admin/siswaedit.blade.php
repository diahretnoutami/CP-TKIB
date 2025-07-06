@section('content')
    @include('layouts.header')

    <!-- Main content -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-success">Tambah Siswa</h2>
                    <hr>
                    <h4 class="text-default">Data Siswa</h4>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <form action="{{ route('siswa.update', $siswa->noinduk) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-2">
                            <label>Nomor Induk</label>
                            <input type="text" name="noinduk" value="{{ $siswa->noinduk }}" class="form-control"
                                required>
                        </div>

                        <div class="form-group mb-2">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama" value="{{ $siswa->nama }}" class="form-control" required>
                        </div>

                        <div class="form-group mb-2">
                            <label>Jenis Kelamin</label>
                            <select name="jeniskelamin" class="form-control" required>
                                <option value="L" {{ $siswa->jeniskelamin == 'L' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="P" {{ $siswa->jeniskelamin == 'P' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                        </div>

                        <div class="form-group mb-2">
                            <label>Tempat Lahir</label>
                            <input type="text" name="tempatlahir" value="{{ $siswa->tempatlahir }}" class="form-control"
                                required>
                        </div>

                        <div class="form-group mb-2">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tgllahir" value="{{ $siswa->tgllahir }}" class="form-control"
                                required>
                        </div>

                        <div class="form-group mb-2">
                            <label>Tinggi Badan (cm)</label>
                            <input type="number" name="tinggibadan" value="{{ $siswa->tinggibadan }}" class="form-control">
                        </div>

                        <div class="form-group mb-2">
                            <label>Berat Badan (kg)</label>
                            <input type="number" name="beratbadan" value="{{ $siswa->beratbadan }}" class="form-control">
                        </div>

                        <div class="form-group mb-2">
                            <label>Lingkar Kepala (kg)</label>
                            <input type="number" name="lingkarkpl" value="{{ $siswa->lingkarkpl }}" class="form-control">
                        </div>

                        <hr>
                        <h4 class="text-default">Data Orangtua</h4>

                        <!-- Area Pilih Ortu -->
                        <div id="pilih_ortu_area">
                            <div class="form-group mb-2">
                                <label>Pilih Orangtua</label>
                                <select name="id_ortu" class="form-control">
                                    <option value="">-- Pilih Orangtua --</option>
                                    @foreach ($orangtua as $ortu)
                                        <option value="{{ $ortu->id_ortu }}"
                                            {{ $ortu->id_ortu == $siswa->id_ortu ? 'selected' : '' }}>
                                            {{ $ortu->namaortu }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <!-- Tombol Tambah Ortu Baru -->
                            <div class="mb-3">
                                <button type="button" class="btn btn-outline-success btn-sm" id="btn_tambah_ortu">
                                    + Tambah Orangtua Baru
                                </button>
                            </div>
                        </div>

                        <!-- Form Input Ortu Baru -->
                        <div id="form_ortu_baru" style="display: none;">
                            <input type="hidden" name="is_new_ortu" id="is_new_ortu" value="">

                            <div class="form-group mb-2">
                                <label>Nama Orangtua</label>
                                <input type="text" name="namaortu" class="form-control">
                            </div>

                            <div class="form-group mb-2">
                                <label>Pekerjaan</label>
                                <input type="text" name="pekerjaan" class="form-control">
                            </div>

                            <div class="form-group mb-2">
                                <label>Alamat</label>
                                <input type="text" name="alamat" class="form-control">
                            </div>

                            <div class="form-group mb-2">
                                <label>Nomor HP</label>
                                <input type="text" name="nohp" class="form-control">
                            </div>
                        </div>

                        <!-- Tombol Batal (tampil hanya saat form ortu aktif) -->
                        <div class="mt-2" id="btn_batal_wrapper" style="display: none;">
                            <button type="button" class="btn btn-sm btn-secondary" id="btn_batal_ortu">
                                Batal
                            </button>
                        </div>


                        <button type="submit" class="btn btn-success mt-3">Simpan</button>
                        <a href="{{ route('siswa.index') }}" class="btn btn-secondary mt-3">Kembali</a>
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

                $('#btn_tambah_ortu').click(function() {
                    $('#pilih_ortu_area').hide(); // sembunyikan dropdown
                    $('#form_ortu_baru').show(); // tampilkan form ortu baru
                    $('#btn_batal_wrapper').show(); // tampilkan tombol batal
                    $('#is_new_ortu').val("1"); // set jika tambah ortu
                });

                // Klik tombol batal
                $('#btn_batal_ortu').click(function() {
                    $('#form_ortu_baru').hide(); // sembunyikan form ortu baru
                    $('#btn_batal_wrapper').hide(); // sembunyikan tombol batal
                    $('#pilih_ortu_area').show(); // tampilkan dropdown ortu lagi
                    $('input[name=is_new_ortu]').val(""); // reset input hidden
                });

            });
        </script>

        </body>

        </html>

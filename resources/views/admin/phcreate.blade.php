@section('content')
    @include('layouts.header')

    <!-- Main content -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-success">Tambah Penilaian Harian</h2>
                    <form action="{{ route('ph.store') }}" method="POST">
                        @csrf


                        <div class="form-group">
                            <label>Tahun Ajaran</label>
                            <select name="id_ta" class="form-control">
                                <option value="">Pilih Tahun Ajaran</option>
                                @foreach ($tahunajaran as $ta)
                                    <option value="{{ $ta->id_ta }}">{{ $ta->tahunajaran }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Tema Pembelajaran</label>
                            <select name="id_t" class="form-control">
                                <option value="">Pilih Tema Pembelajaran</option>
                                @foreach ($tema as $tema)
                                    <option value="{{ $tema->id_t }}">{{ $tema->tema }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Nomor Alur</label>
                            <select name="id_a" class="form-control">
                                <option value="">Pilih Nomor Alur</option>
                                @foreach ($alur as $alur)
                                    <option value="{{ $alur->id_a }}">{{ $alur->nomor_alur }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Minggu</label>
                            <input type="text" name="minggu" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Kegiatan</label>
                            <input type="text" name="kegiatan" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success mt-3">Simpan</button>
                        <a href="{{ route('ph.index') }}" class="btn btn-secondary mt-3">Kembali</a>
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

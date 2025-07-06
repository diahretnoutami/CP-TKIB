@section('content')
    @include('layouts.header')

    <div class="main-content">
        <div class="container-fluid">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-success">Ubah Deskripsi Laporan</h2>
                    <form action="{{ route('deslap.update', $data->id_dl) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Materi Pembelajaran</label>
                            <select name="id_c" class="form-control" required>
                                @foreach ($materis as $materi)
                                    <option value="{{ $materi->id_c }}"
                                        {{ $materi->id_c == $data->id_c ? 'selected' : '' }}>
                                        {{ $materi->materi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nilai Akhir</label>
                            <input type="text" name="nilaiakhir" class="form-control" value="{{ $data->nilaiakhir }}">
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" value="{{ $data->keterangan }}">
                        </div>

                        <button type="submit" class="btn btn-success mt-3">Simpan Perubahan</button>
                        <a href="{{ route('deslap.index') }}" class="btn btn-secondary mt-3">Kembali</a>
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

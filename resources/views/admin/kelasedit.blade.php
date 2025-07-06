@section('content')
    @include('layouts.header')

    <!-- Main content -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-success">Ubah Data Kelas</h2>
                    <form action="{{ route('kelas.update', $data->id_k) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-2">
                            <label>Nama Kelas</label>
                            <input type="text" name="nama_kelas" class="form-control" value="{{ $data->nama_kelas }}">
                        </div>

                        <div class="form-group">
                            <label>Tahun Ajaran</label>
                            <select name="id_ta" class="form-control" required>
                                @foreach ($tahunAjaran as $tahunAjaran)
                                    <option value="{{ $tahunAjaran->id_ta }}"
                                        {{ $tahunAjaran->id_ta == $data->id_ta ? 'selected' : '' }}>
                                        {{ $tahunAjaran->tahunajaran }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Nama Guru</label>
                            <select name="id_guru" class="form-control" required>
                                @foreach ($guru as $guru)
                                    <option value="{{ $guru->id_guru }}"
                                        {{ $guru->id_guru == $data->id_guru ? 'selected' : '' }}>
                                        {{ $guru->namaguru }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success mt-3">Simpan Perubahan</button>
                        <a href="{{ route('tahunajaran.index') }}" class="btn btn-secondary mt-3">Kembali</a>
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

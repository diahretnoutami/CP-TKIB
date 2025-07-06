@section('content')
    @include('layouts.headerguru')

    <!-- Main content -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-success">Edit Siswa</h2>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <form action="{{ route('siswa.update', $data->noinduk) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-2">
                            <label>Nomor Induk</label>
                            {{-- Tambahkan readonly --}}
                            <input type="text" name="noinduk" value="{{ $data->noinduk }}" class="form-control" required
                                readonly>
                        </div>

                        <div class="form-group mb-2">
                            <label>Nama Siswa</label>
                            {{-- Tambahkan readonly --}}
                            <input type="text" name="nama" value="{{ $data->nama }}" class="form-control" required
                                readonly>
                        </div>

                        <div class="form-group mb-2">
                            <label>Jenis Kelamin</label>
                            {{-- Tambahkan disabled dan readonly (disabled akan mencegah pengiriman nilai) --}}
                            <select name="jeniskelamin" class="form-control" required disabled>
                                <option value="L" {{ $data->jeniskelamin == 'L' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="P" {{ $data->jeniskelamin == 'P' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                            {{-- Jika ingin nilai jeniskelamin tetap terkirim, tambahkan hidden input --}}
                            <input type="hidden" name="jeniskelamin" value="{{ $data->jeniskelamin }}">
                        </div>

                        <div class="form-group mb-2">
                            <label>Tempat Lahir</label>
                            {{-- Tambahkan readonly --}}
                            <input type="text" name="tempatlahir" value="{{ $data->tempatlahir }}" class="form-control"
                                required readonly>
                        </div>

                        <div class="form-group mb-2">
                            <label>Tanggal Lahir</label>
                            {{-- Tambahkan readonly --}}
                            <input type="date" name="tgllahir" value="{{ $data->tgllahir }}" class="form-control"
                                required readonly>
                        </div>

                        <div class="form-group mb-2">
                            <label>Tinggi Badan (cm)</label>
                            <input type="number" name="tinggibadan" value="{{ $data->tinggibadan }}" class="form-control">
                        </div>

                        <div class="form-group mb-2">
                            <label>Berat Badan (kg)</label>
                            <input type="number" name="beratbadan" value="{{ $data->beratbadan }}" class="form-control">
                        </div>

                        <div class="form-group mb-2">
                            <label>Lingkar Kepala (cm)</label> {{-- Ganti (kg) menjadi (cm) jika itu maksudnya --}}
                            <input type="number" name="lingkarkpl" value="{{ $data->lingkarkpl }}" class="form-control">
                        </div>


                        <button type="submit" class="btn btn-success mt-3">Simpan</button>
                        <a href="{{ route('guru.siswa') }}" class="btn btn-secondary mt-3">Kembali</a>
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
                $('#dataTable').DataTable();
            });
        </script>

        </body>

        </html>

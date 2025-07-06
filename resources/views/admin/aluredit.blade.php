@section('content')
    @include('layouts.header')

    <div class="main-content">
        <div class="container-fluid">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-success">Ubah Alur Pembelajaran</h2>
                    <form action="{{ route('alur.update', $data->id_a) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Tujuan Pembelajaran</label>
                            <select name="id_c" class="form-control" required>
                                @foreach ($tujuans as $tujuan)
                                    <option value="{{ $tujuan->id_c }}"
                                        {{ $tujuan->id_c == $data->id_c ? 'selected' : '' }}>
                                        {{ $tujuan->tujuan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Nomor Alur</label>
                            <input type="text" name="nomor_alur" class="form-control" value="{{ $data->nomor_alur }}">
                        </div>

                        <div class="form-group">
                            <label>Alur Pembelajaran</label>
                            <input type="text" name="alur" class="form-control" value="{{ $data->alurp }}">
                        </div>
                        <div class="form-group">
                            <label>Semester</label>
                            <input type="text" name="semester" class="form-control" value="{{ $data->semester }}">
                        </div>

                        <button type="submit" class="btn btn-success mt-3">Simpan Perubahan</button>
                        <a href="{{ route('alur.index') }}" class="btn btn-secondary mt-3">Kembali</a>
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

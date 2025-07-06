@section('content')
    @include('layouts.header')

    <!-- Main content -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-success">Tambah Alur Pembelajaran</h2>
                    <form action="{{ route('alur.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Tujuan</label>
                            <select name="id_c" class="form-control select2">
                                <option value="">Pilih Tujuan Pembelajaran</option>
                                @foreach ($tujuans as $tujuan)
                                    <option value="{{ $tujuan->id_c }}">{{ $tujuan->tujuan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Nomor Alur</label>
                            <input type="text" name="nomor_alur" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Alur</label>
                            <input type="text" name="alurp" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Semester</label>
                            <input type="text" name="semester" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success mt-3">Simpan</button>
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
        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable(); // <--- ini bikin search & pagination aktif
            });
        </script>

        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    placeholder: "Pilih Tujuan Pembelajaran",
                    allowClear: true
                });
            });
        </script>

        <style>
            /* Fix agar Select2 lebar 100% sama dengan input lainnya */
            .select2-container {
                width: 100% !important;
            }

            .select2-container--default .select2-selection--single {
                height: 38px;
                padding: 6px 12px;
                font-size: 1rem;
                line-height: 1.5;
                border: 1px solid #ced4da;
                border-radius: 0.25rem;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                padding-left: 0;
                padding-right: 0;
                line-height: 24px;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 36px;
                right: 10px;
            }
        </style>


        </body>

        </html>

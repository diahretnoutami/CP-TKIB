@section('content')
    @include('layouts.header')

    <!-- Main content -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-success">Tambah Semester</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('semester.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Semester</label>
                            <select name="semester" class="form-control" required>
                                <option value="">-- Pilih Semester --</option>
                                <option value="1">Semester 1</option>
                                <option value="2">Semester 2</option>
                            </select>
                            @error('semester')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success mt-3">Simpan</button>
                        <a href="{{ route('semester.index') }}" class="btn btn-secondary mt-3">Kembali</a>
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

                $('.select2').select2({
                    placeholder: 'Pilih ',
                    allowClear: true
                });

                // Materi
                $('#btn_tambah_materi').click(function() {
                    $('#pilih_materi_area').hide();
                    $('#form_materi_baru').show();
                    $('#is_new_materi').val("1");
                });

                $('#btn_batal_materi').click(function() {
                    $('#form_materi_baru').hide();
                    $('#pilih_materi_area').show();
                    $('#is_new_materi').val("");
                });

                // Capaian
                $('#btn_tambah_capaian').click(function() {
                    $('#pilih_capaian_area').hide();
                    $('#form_capaian_baru').show();
                    $('#is_new_capaian').val("1");
                });

                $('#btn_batal_capaian').click(function() {
                    $('#form_capaian_baru').hide();
                    $('#pilih_capaian_area').show();
                    $('#is_new_capaian').val("");
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

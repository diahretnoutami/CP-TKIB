@section('content')
    @include('layouts.header')

    <!-- Main content -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-success">Tambah Capaian Pembelajaran</h2>
                    <form action="{{ route('cp.store') }}" method="POST">
                        @csrf

                        <!-- MATERI -->
                        <div id="pilih_materi_area" class="form-group">
                            <label>Materi</label>
                            <div class="row">
                                <div class="col-md-10">
                                    <select name="materi_dropdown" class="form-control select2">
                                        <option value="">-- Pilih Materi --</option>
                                        @foreach ($materis as $materi)
                                            <option value="{{ $materi }}"
                                                {{ old('materi_dropdown') == $materi ? 'selected' : '' }}>
                                                {{ $materi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <button type="button" class="btn btn-outline-success btn-block" id="btn_tambah_materi">
                                        + Baru
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="form_materi_baru" style="display: none;">
                            <input type="hidden" name="is_new_materi" id="is_new_materi" value="">
                            <div class="form-group">
                                <label>Materi Baru</label>
                                <input type="text" name="materi_baru" class="form-control"
                                    value="{{ old('materi_baru') }}">
                                <button type="button" class="btn btn-sm btn-secondary mt-2" id="btn_batal_materi">
                                    Batal
                                </button>
                            </div>
                        </div>

                        <!-- CAPAIAN -->
                        <div id="pilih_capaian_area" class="form-group">
                            <label>Capaian</label>
                            <div class="row">
                                <div class="col-md-10">
                                    <select name="capaian_dropdown" class="form-control select2">
                                    <option value="">-- Pilih --</option>
                                    @foreach ($capaians as $capaian)
                                        <option value="{{ $capaian }}" {{ old('capaian_dropdown') == $capaian ? 'selected' : '' }}>
                                            {{ $capaian }}
                                        </option>
                                    @endforeach
                                </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-outline-success btn-block"
                                        id="btn_tambah_capaian">
                                        + Baru
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="form_capaian_baru" style="display: none;">
                            <input type="hidden" name="is_new_capaian" id="is_new_capaian" value="">
                            <div class="form-group">
                                <label>Capaian Baru</label>
                                <input type="text" name="capaian_baru" class="form-control"
                                    value="{{ old('capaian_baru') }}">
                                <button type="button" class="btn btn-sm btn-secondary mt-2" id="btn_batal_capaian">
                                    Batal
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Tujuan</label>
                            <input type="text" name="tujuan" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success mt-3">Simpan</button>
                        <a href="{{ route('cp.index') }}" class="btn btn-secondary mt-3">Kembali</a>
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

@section('content')
    @include('layouts.headerguru')

    <div class="main-content">
        <div class="container-fluid pt-7">
            <h1 class="text-success" style="margin-top: -100px; margin-bottom: 20px;">Input Penilaian Harian</h1>

            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('guru.hphinput.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="text-align: center; width: 50px;">No</th>
                                        <th style="text-align: center">Alur</th>
                                        <th style="text-align: center">Kegiatan</th>
                                        <th style="text-align: center">Hasil</th>
                                        <th style="text-align: center">Dokumentasi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($penilaianPoin as $index => $poin)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $poin->alur->alurp ?? '-' }}</td>
                                            <td>{{ $poin->kegiatan }}</td>

                                            {{-- Kolom Nilai --}}
                                            <td>
                                                @for ($i = 1; $i <= 4; $i++)
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="hasil[{{ $poin->id_ph }}]" value="{{ $i }}"
                                                            {{ isset($existingNilai[$poin->id_ph]) && $existingNilai[$poin->id_ph] == $i ? 'checked' : '' }}
                                                            required>
                                                        <label class="form-check-label">{{ $i }}</label>
                                                    </div>
                                                @endfor
                                            </td>

                                            {{-- Kolom Dokumentasi --}}
                                            <td>
                                                @php
                                                    $existingFile = \App\Models\HasilPh::where('id_ph', $poin->id_ph)
                                                        ->where('id_kelas_siswa', $kelasSiswa->id_kelas_siswa)
                                                        ->first();
                                                @endphp

                                                @if ($existingFile && $existingFile->dokumentasi)
                                                    <div><a href="{{ asset('storage/' . $existingFile->dokumentasi) }}"
                                                            target="_blank">Lihat</a></div>
                                                @endif

                                                <input type="file" name="dokumentasi[{{ $poin->id_ph }}]"
                                                    accept="image/*" class="form-control mt-2">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            <input type="hidden" name="id_kelas_siswa" value="{{ $kelasSiswa->id_kelas_siswa }}">
                            <input type="hidden" name="noinduk" value="{{ $kelasSiswa->noinduk }}">
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-success">Simpan Penilaian</button>
                            <a href="{{ route('guru.absen') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
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
            $('#dataTable').DataTable({
                columnDefs: [{
                        width: "50px",
                        targets: 0
                    },
                    {
                        width: "500px", // kolom Status (atur sesuai kebutuhan)
                        targets: 2
                    }
                ],
                autoWidth: false // penting agar columnDefs berfungsi
            });
        });
    </script>

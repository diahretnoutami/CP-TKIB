@section('content')
    @include('layouts.header')

    <div class="main-content">
        <div class="container-fluid pt-7">
            <h1 class="text-success" style="margin-top: -100px; margin-bottom: 20px;">Data Penilaian Harian
                {{ $siswa->nama }}</h1>
            <div class="card shadow">
                <div class="card-body">
                    <h4>Tanggal: {{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y') }}</h4>


                    <form action="{{ route('detail.update', [$id_kelas_siswa, $tanggal]) }}" method="POST">
                        @csrf

                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">No</th>
                                        <th>Kegiatan</th>
                                        <th>Alur</th>
                                        <th>Semester</th>
                                        <th style="text-align: center;">Hasil</th>
                                        <th style="text-align: center">Dokumentasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hasil as $index => $row)
                                        <tr>
                                            <td style="text-align: center;">{{ $index + 1 }}</td>
                                            <td>{{ $row->penilaianHarian->kegiatan }}</td>
                                            <td>{{ $row->penilaianHarian->alur->alurp ?? '-' }}</td>
                                            <td>{{ $row->penilaianHarian->alur->semester ?? '-' }}</td>
                                            <td style="text-align: center;">
                                                @for ($i = 1; $i <= 4; $i++)
                                                    <label class="mr-2 text-primary">
                                                        <input type="radio" name="hasil[{{ $row->id_hph }}]"
                                                            value="{{ $i }}"
                                                            {{ $row->hasil == $i ? 'checked' : '' }}
                                                            style="accent-color: #007bff;"> {{ $i }}
                                                    </label>
                                                @endfor
                                            </td>

                                             <td>
                                                @php
                                                    $existingFile = \App\Models\HasilPh::where('id_ph', $row->id_ph)
                                                        ->where('id_kelas_siswa', $kelasSiswa->id_kelas_siswa)
                                                        ->first();
                                                @endphp

                                                @if ($existingFile && $existingFile->dokumentasi)
                                                    <div><a href="{{ asset('storage/' . $existingFile->dokumentasi) }}"
                                                            target="_blank">Lihat</a></div>
                                                @endif

                                                <input type="file" name="dokumentasi[{{ $row->id_ph }}]"
                                                    accept="image/*" class="form-control mt-2">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                            <a href="{{ route('tanggal', $row->id_kelas_siswa) }}" class="btn btn-secondary">Kembali</a>
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
            $('#dataTable').DataTable(); // <--- ini bikin search & pagination aktif
        });
    </script>

    </body>

    </html>

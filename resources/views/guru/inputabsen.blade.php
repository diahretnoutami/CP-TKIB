@section('content')
    @include('layouts.headerguru')

    <div class="main-content">
        <div class="container-fluid pt-7">
            <h1 class="text-success" style="margin-top: -100px; margin-bottom: 20px;">Input Absensi Siswa</h1>

            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route ('guru.inputabsen.store') }}" method="POST">
                        @csrf
                        <div class="d-flex align-items-center mb-3">
                            <label for="tanggal" class="mr-3 mb-0" style="white-space: nowrap;">Tanggal Absensi</label>
                            <div class="input-group" style="max-width: 250px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                            </div>
                        </div>


                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="text-align: center; width: 50px;">No</th>
                                        <th style="text-align: center">Nama Siswa</th>
                                        <th style="text-align: center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($kelasSiswa as $index => $siswa)
                                        <tr>
                                            <td style="text-align: center; width: 50px;">{{ $index + 1 }}</td>
                                            <td style="text-align: center;">{{ $siswa->siswa->nama ?? '-' }}</td>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <div class="form-check mr-2">
                                                        <input class="form-check-input" type="radio"
                                                            name="absen[{{ $siswa->id_kelas_siswa }}]" value="H"
                                                            required>
                                                        <label class="form-check-label">Hadir</label>
                                                    </div>
                                                    <div class="form-check mr-2">
                                                        <input class="form-check-input" type="radio"
                                                            name="absen[{{ $siswa->id_kelas_siswa }}]" value="S">
                                                        <label class="form-check-label">Sakit</label>
                                                    </div>
                                                    <div class="form-check mr-2">
                                                        <input class="form-check-input" type="radio"
                                                            name="absen[{{ $siswa->id_kelas_siswa }}]" value="I">
                                                        <label class="form-check-label">Izin</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="absen[{{ $siswa->id_kelas_siswa }}]" value="A">
                                                        <label class="form-check-label">Alfa</label>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Tidak ada siswa dalam kelas ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-success">Simpan Absensi</button>
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

@section('content')
    @include('layouts.header')

    <div class="main-content">
        <div class="container-fluid pt-7">
            <h1 class="text-success" style="margin-top: -100px; margin-bottom: 20px;">Detail Absensi</h1>

            <div class="card shadow">
                <div class="card-body">

                    {{-- Form untuk simpan data --}}
                    <form method="POST" action="{{ route('admin.absensi.update', [$id_ta, $kelas->id_k, $tanggal]) }}">
                        @csrf

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
                                    @foreach ($kelasSiswa as $index => $siswa)
                                        <tr>
                                            <td style="text-align: center;">{{ $index + 1 }}</td>
                                            <td style="text-align: center;">{{ $siswa->siswa->nama ?? '-' }}</td>
                                            <td>
                                                @php
                                                    $status = $absensi[$siswa->id_kelas_siswa]->status ?? null;
                                                @endphp
                                                <div class="d-flex justify-content-between">
                                                    <div class="form-check mr-2">
                                                        <input class="form-check-input" type="radio"
                                                            name="absen[{{ $siswa->id_kelas_siswa }}]" value="H"
                                                            {{ $status == 'H' ? 'checked' : '' }} required>
                                                        <label class="form-check-label">Hadir</label>
                                                    </div>
                                                    <div class="form-check mr-2">
                                                        <input class="form-check-input" type="radio"
                                                            name="absen[{{ $siswa->id_kelas_siswa }}]" value="S"
                                                            {{ $status == 'S' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Sakit</label>
                                                    </div>
                                                    <div class="form-check mr-2">
                                                        <input class="form-check-input" type="radio"
                                                            name="absen[{{ $siswa->id_kelas_siswa }}]" value="I"
                                                            {{ $status == 'I' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Izin</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="absen[{{ $siswa->id_kelas_siswa }}]" value="A"
                                                            {{ $status == 'A' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Alfa</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-success">Simpan Absensi</button>
                            <a href="{{ route('admin.absensi.absen', [$id_ta, $kelas->id_k]) }}"
                                class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- JS --}}
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
                        width: "500px",
                        targets: 2
                    }
                ],
                autoWidth: false
            });
        });
    </script>

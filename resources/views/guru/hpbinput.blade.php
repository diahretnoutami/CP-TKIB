@section('content')
    @include('layouts.headerguru')

    <div class="main-content">
        <div class="container-fluid pt-7">
            <h1 class="text-success mb-4" style="margin-top: -100px;">Input Penilaian Bulanan</h1>

            <div class="card shadow">
                <div class="card-body">
                    <h4 class="mb-3">Siswa: {{ $kelasSiswa->siswa->nama }}</h4>

                    @php
                        $rata = round(($rataRata ?? 0) / 4, 2); // tetap dibagi 4 meskipun hanya ada 1–2 minggu
                        if ($rata >= 4) {
                            $keterangan = 'Berkembang Sangat Baik';
                        } elseif ($rata >= 3) {
                            $keterangan = 'Berkembang Sesuai Harapan';
                        } elseif ($rata >= 2) {
                            $keterangan = 'Mulai Berkembang';
                        } else {
                            $keterangan = 'Belum Berkembang';
                        }
                    @endphp
                    <form action="{{ route('guru.hpbinput.store', [$kelasSiswa->id_kelas_siswa, $bulan]) }}" method="POST">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="text-align: center; font-size: 16px;">No</th>
                                        <th style="text-align: center; font-size: 16px; width: 50%;">Alur</th>
                                        <th style="text-align: center; font-size: 16px;">Nilai</th>
                                        <th style="text-align: center; font-size: 16px;">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($nilaiPerAlur as $index => $item)
                                        <tr>
                                            <td style="text-align: center;">{{ $index + 1 }}</td>
                                            <td>{{ $item['alur'] }}</td>
                                            <input type="hidden" name="id_a[]" value="{{ $item['id_a'] }}">
                                            <td style="text-align: center;">{{ $item['rata'] }}</td>
                                            <input type="hidden" name="rata[]" value="{{ $item['rata'] }}">
                                            <td>{{ $item['keterangan'] }}</td>
                                        </tr>
                                        
                                        
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">Simpan Nilai</button>
                            <a href="{{ route('guru.hpbinputbln', $bulan) }}" class="btn btn-secondary">Kembali</a>
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

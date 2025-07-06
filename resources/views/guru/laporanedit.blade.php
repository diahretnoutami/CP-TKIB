<style>
    textarea.form-control {
        width: 100%;
    }
</style>
@section('content')
    @include('layouts.headerguru')

    <div class="main-content">
        <form action="{{ route('lap.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="container-fluid pt-7">
                <h1 class="text-success mb-4" style="margin-top: -100px;">Edit Laporan Pembelajaran</h1>

                <div class="card shadow">
                    <div class="card-body">

                        <h4 class="text-default">Identitas Siswa</h4>
                        <div class="form-group mb-4">
                            <label>Nomor Induk</label>
                            <input type="text" name="noinduk" value="{{ $siswa->noinduk }}" class="form-control"
                                readonly>
                        </div>

                        <div class="form-group mb-4">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama" value="{{ $siswa->nama }}" class="form-control" readonly>
                        </div>

                        <div class="form-group mb-4">
                            <label>Kelas</label>
                            <input type="text" name="nama_kelas" value="{{ $kelasSiswa->kelas->nama_kelas }}"
                                class="form-control" readonly>
                        </div>

                        <div class="form-group mb-4">
                            <label>Tinggi Badan</label>
                            <input type="text" name="tinggibadan" value="{{ $siswa->tinggibadan }}" class="form-control"
                                readonly>
                        </div>

                        <div class="form-group mb-4">
                            <label>Berat Badan</label>
                            <input type="text" name="beratbadan" value="{{ $siswa->beratbadan }}" class="form-control"
                                readonly>
                        </div>

                    </div>
                </div>
            </div>

            <div class="container-fluid pt-2">
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="text-default">Penilaian</h4>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Materi</th>
                                    <th>Nilai Akhir</th>
                                    <th>Kalimat Deskriptif</th>
                                    <th>Dokumentasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($uniqueCps as $index => $cp)
                                    @php
                                        $id_c = $cp->id_c;
                                        $materi = $cp->materi;
                                        $nilai = $nilaiPerMateri[$materi] ?? 0;
                                        $keterangan =
                                            $laporanSebelumnya[$materi][0]->keterangan ??
                                            ($deskripsiList[$materi][$nilai]->keterangan ?? '-');
                                        $fotoTerpilih = $dokumentasiTerpilih[$materi] ?? collect();
                                        $fotoSemua = $dokumentasiLengkap[$materi] ?? collect();
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $materi }}</td>
                                        <td>
                                            <input type="number" name="nilaiakhir[{{ $id_c }}]"
                                                class="form-control" value="{{ $nilai }}" readonly>
                                        </td>
                                        <td>
                                            <textarea name="keterangan[{{ $id_c }}]" class="form-control" rows="2">{{ $keterangan }}</textarea>
                                        </td>
                                        <td>
                                            <!-- Dokumentasi terpilih -->
                                            <div id="dokumen-terpilih-{{ $id_c }}">
                                                @foreach ($fotoTerpilih as $foto)
                                                    <div class="d-flex align-items-center mb-1 dokumentasi-item">
                                                        <a href="{{ asset('storage/' . $foto->dokumentasi) }}"
                                                            target="_blank">
                                                            Lihat
                                                            ({{ \Carbon\Carbon::parse($foto->tanggal)->format('d/m/Y') }})
                                                        </a>
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger ms-2 btn-hapus-foto">&times;</button>
                                                        <input type="hidden" name="id_hph[{{ $id_c }}][]"
                                                            value="{{ $foto->id_hph }}">
                                                        <input type="hidden" name="id_c[{{ $id_c }}]"
                                                            value="{{ $id_c }}">
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Tombol toggle -->
                                            <button type="button" class="btn btn-sm btn-link text-primary px-0"
                                                onclick="tampilkanSemua({{ $id_c }})">
                                                Tampilkan Semua Dokumentasi
                                            </button>

                                            <!-- Semua dokumentasi -->
                                            <div id="dokumen-semua-{{ $id_c }}" class="mt-2"
                                                style="display: none;">
                                                @foreach ($fotoSemua as $foto)
                                                    @if (!$fotoTerpilih->pluck('id_hph')->contains($foto->id_hph))
                                                        <div
                                                            class="d-flex align-items-center mb-1 dokumentasi-item tambahan-{{ $id_c }}">
                                                            <a href="{{ asset('storage/' . $foto->dokumentasi) }}"
                                                                target="_blank">
                                                                Lihat
                                                                ({{ \Carbon\Carbon::parse($foto->tanggal)->format('d/m/Y') }})
                                                            </a>
                                                            <button type="button"
                                                                class="btn btn-sm btn-success ms-2 btn-tambah-foto"
                                                                data-id="{{ $foto->id_hph }}"
                                                                data-idc="{{ $id_c }}">+</button>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div id="undo-container" style="position: fixed; bottom: 20px; right: 20px; display: none;">
                            <button type="button" class="btn btn-sm btn-secondary" id="btn-undo"
                                title="Batalkan Penghapusan">
                                ↺
                            </button>
                        </div>
                        <button type="submit" class="btn btn-success mt-3">Simpan Laporan</button>
                        <a href="{{ route('lap.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                    </div>

                </div>
            </div>

        </form>
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

    <script>
        let removedItems = [];

        $(document).on('click', '.btn-hapus-foto', function() {
            const item = $(this).closest('.dokumentasi-item');
            const parent = item.parent(); // Simpan tempat asal

            removedItems.push({
                item: item,
                parent: parent
            }); // Masukkan ke stack
            item.detach(); // Hilangkan dari DOM

            $('#undo-container').show(); // Tampilkan tombol Undo
        });

        $('#btn-undo').on('click', function() {
            if (removedItems.length > 0) {
                const last = removedItems.pop(); // Ambil item terakhir yang dihapus
                last.parent.append(last.item); // Kembalikan ke tempat asal

                if (removedItems.length === 0) {
                    $('#undo-container').hide(); // Sembunyikan tombol kalau sudah kosong
                }
            }
        });
    </script>

    <script>
        function tampilkanSemua(id_c) {
            const blok = document.getElementById('dokumen-semua-' + id_c);
            if (blok) {
                blok.style.display = (blok.style.display === 'none') ? 'block' : 'none';
            }
        }

        // Tambah dokumentasi ke form
        $(document).on('click', '.btn-tambah-foto', function() {
            const id_hph = $(this).data('id');
            const id_c = $(this).data('idc');
            const link = $(this).siblings('a').attr('href');
            const tanggal = $(this).siblings('a').text();

            const newItem = $(`
        <div class="d-flex align-items-center mb-1 dokumentasi-item">
            <a href="${link}" target="_blank">${tanggal}</a>
            <button type="button" class="btn btn-sm btn-danger ms-2 btn-hapus-foto">&times;</button>
            <input type="hidden" name="id_hph[${id_c}][]" value="${id_hph}">
        </div>
    `);

            $('#dokumen-terpilih-' + id_c).append(newItem);
            $(this).closest('.dokumentasi-item').remove();
        });
    </script>

 @section('content')
     @include('layouts.header')

     <div class="main-content">
         <div class="container-fluid pt-7">
             {{-- Ubah judul dari Mingguan menjadi Bulanan --}}
             <h1 class="text-success" style="margin-top: -100px; margin-bottom: 20px;">Data Hasil Penilaian Bulanan</h1>
             <div class="card shadow">
                 <div class="card-body">
                     <h4 class="mb-3">Siswa: {{ $kelasSiswa->siswa->nama }}</h4>
                     {{-- Ubah "Minggu" menjadi "Bulan" dan gunakan variabel $bulan --}}
                     <h5 class="mb-4">Bulan ke-{{ $bulan }}</h5>
                     <div class="table-responsive">
                         {{-- Halaman ini murni untuk menampilkan data, bukan mengedit --}}
                         <div class="table-responsive">
                             <table class="table table-bordered" id="dataTable">
                                 <thead>
                                     <tr>
                                         <th style="text-align: center; font-size: 16px;">No</th>
                                         <th style="text-align: center; font-size: 16px; width: 15%;">NOMOR ALUR</th>
                                         <th style="text-align: center; font-size: 16px; width: 45%;">ALUR</th>
                                         {{-- Lebar disesuaikan --}}
                                         <th style="text-align: center; font-size: 16px; width: 10%;">NILAI</th>
                                         <th style="text-align: center; font-size: 16px;">KETERANGAN</th>
                                         {{-- Kolom DOKUMENTASI dihapus dari header --}}
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @forelse ($nilaiPerAlur as $item)
                                         <tr>
                                             <td style="text-align: center;">{{ $loop->iteration }}</td>
                                             <td
                                                 style="text-align: left; word-break: break-word; white-space: normal; overflow-wrap: break-word;">
                                                 {{ $item->nomoralur ?? '-' }}
                                             </td>
                                             <td
                                                 style="text-align: left; word-break: break-word; white-space: normal; overflow-wrap: break-word;">
                                                 {{ $item->alurp ?? '-' }}
                                             </td>
                                             <td style="text-align: center;">
                                                 {{ $item->hasil }}
                                             </td>
                                             <td
                                                 style="text-align: left; word-break: break-word; white-space: normal; overflow-wrap: break-word;">
                                                 {{ $item->keterangan }}
                                             </td>
                                             {{-- Kolom DOKUMENTASI dihapus dari body --}}
                                         </tr>
                                     @empty
                                         <tr>
                                             {{-- Colspan disesuaikan kembali menjadi 5 --}}
                                             <td colspan="5" style="text-align: center;">No data available in table</td>
                                         </tr>
                                     @endforelse
                                 </tbody>
                             </table>
                         </div>
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
                             width: "15%", // Kolom NOMOR ALUR
                             targets: 1
                         },
                         {
                             width: "35%", // Kolom ALUR (sedikit dikurangi untuk dokumentasi)
                             targets: 2
                         },
                         {
                             width: "10%", // Kolom NILAI
                             targets: 3
                         },
                         {
                             width: "auto", // Kolom KETERANGAN
                             targets: 4
                         },
                     ],
                     autoWidth: false
                 });
             });
         </script>

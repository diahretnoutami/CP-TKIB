

@section('content')
    @include('layouts.header') 

  <!-- Main content -->
  <div class="main-content">
      <div class="container-fluid pt-7">
        <h1 class="text-success" style="margin-top: -100px; margin-bottom: 20px;">Data Kelas</h1>
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <a href="{{ route('kelas.create') }}" class="btn btn-success mb-3">
                            + Tambah Kelas
                        </a>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <div class="col-md-4">
                            </div>

                        <thead>
                            <tr>
                                <th style="text-align: center; font-size: 16px;">No</th>
                                <th style="text-align: center; font-size: 16px;">Nama Kelas</th>
                                <th style="text-align: center; font-size: 16px;">Tahun Ajaran</th>
                                <th style="text-align: center; font-size: 16px;">Nama Guru</th>
                                <th style="text-align: center; font-size: 16px;">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data as $index => $row )
                                <tr>
                                    <td style="text-align: center;">{{ $index + 1 }}</td>
                                    <td style="text-align: center">{{ $row->nama_kelas }}</td>
                                    <td style="text-align: center">{{ $row->tahunAjaran->tahunajaran}}</td>
                                    <td style="text-align: center">{{ $row->guru->namaguru}}</td>
                                    <td style="text-align: center;">
                                      <a href="{{ route('kelas.kelola', $row->id_k) }}" class="btn btn-warning btn-sm">Kelola</a>
                                        <a href="{{ route('kelas.edit', $row->id_k) }}" class="btn btn-info btn-sm">Edit</a>
                                        <form action="{{ route('kelas.destroy', $row->id_k) }}" method="POST" style="display: inline">
                                          @csrf
                                          @method('DELETE')
                                          <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            Hapus
                                          </button>
                                        </form>
            </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

      </div>
    </div>

  

  <!-- JS -->
  <script src="https://argon-dashboard-laravel-bs4.creative-tim.com/argon/vendor/jquery/dist/jquery.min.js"></script>
  <script src="https://argon-dashboard-laravel-bs4.creative-tim.com/argon/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
  <script>
    $(document).ready(function() {
      $('#dataTable').DataTable(); // <--- ini bikin search & pagination aktif
    });
  </script>
  
</body>
</html>

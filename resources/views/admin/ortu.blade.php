

@section('content')
    @include('layouts.header') 

  <!-- Main content -->
  <div class="main-content">
      <div class="container-fluid pt-7">
        <h1 class="text-success" style="margin-top: -100px; margin-bottom: 20px;">Data Orang Tua</h1>
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <a href="{{ route('ortu.create') }}" class="btn btn-success mb-3">
                            + Tambah Orang Tua
                        </a>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <div class="col-md-4">
                            </div>

                        <thead>
                            <tr>
                                <th style="text-align: center; font-size: 16px;">No</th>
                                <th style="text-align: center; font-size: 16px;">Nama Orang Tua</th>
                                <th style="text-align: center; font-size: 16px;">Pekerjaan</th>
                                <th style="text-align: center; font-size: 16px;">Nomor HP</th>
                                <th style="text-align: center; font-size: 16px;">Alamat</th>
                                <th style="text-align: center; font-size: 16px;">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data as $index => $row )
                                <tr>
                                    <td style="text-align: center;">{{ $index + 1 }}</td>
                                    <td style="text-align: center">{{ $row->namaortu }}</td>
                                    <td style="text-align: center">{{ $row->pekerjaan }}</td>
                                    <td style="text-align: center">{{ $row->nohp }}</td>
                                    <td style="text-align: center">{{ $row->alamat }}</td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('ortu.edit', $row->id_ortu) }}" class="btn btn-info btn-sm">Edit</a>
                                        <form action="{{ route('ortu.destroy', $row->id_ortu) }}" method="POST" style="display: inline">
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

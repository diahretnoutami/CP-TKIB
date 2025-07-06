@section('content')
    @include('layouts.header') 

    <div class="main-content">
        <div class="container-fluid">
              <div class="card shadow">
                  <div class="card-body">
                      <h2 class="text-success">Ubah Data Capaian Pembelajaran</h2>
          <form action="{{ route('cp.update', $data->id_c) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="form-group">
                  <label>Materi</label>
                  <input type="text" name="materi" class="form-control" value="{{ $data->materi }}">
              </div>
              <div class="form-group">
                  <label>Capaian</label>
                  <input type="text" name="capaian" class="form-control" value="{{ $data->capaian }}">
              </div>
              <div class="form-group">
                  <label>Tujuan</label>
                  <input type="text" name="tujuan" class="form-control" value="{{ $data->tujuan }}">
              </div>
              <button type="submit" class="btn btn-success mt-3">Simpan Perubahan</button>
              <a href="{{ route('alur.index') }}" class="btn btn-secondary mt-3">Kembali</a>
          </form>
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
  
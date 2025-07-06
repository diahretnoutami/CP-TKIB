

@section('content')
    @include('layouts.header') 

  <!-- Main content -->
  <div class="main-content">
      <div class="container-fluid">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-success">Tambah Penilaian Mingguan</h2>
        <form action="{{ route('pm.store') }}" method="POST">
            @csrf

             <div class="form-group mb-2">
                <label>Minggu</label>
                <input type="text" name="minggu" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Alur Pembelajaran</label>
                <select name="id_a" class="form-control">
                <option value="">Pilih Alur Pembelajaran</option>
                @foreach ($alur as $alur )
                  <option value="{{ $alur->id_a }}">{{ $alur->alurp }}</option>
                @endforeach
              </select>
            </div>

            <button type="submit" class="btn btn-success mt-3">Simpan</button>
            <a href="{{ route('pm.index') }}" class="btn btn-secondary mt-3">Kembali</a>
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

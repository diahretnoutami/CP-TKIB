

@section('content')
    @include('layouts.header') 

  <!-- Main content -->
  <div class="main-content">
      <div class="container-fluid">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-success">Tambah Kelas</h2>
        <form action="{{ route('kelas.store') }}" method="POST">
            @csrf
            <div class="form-group mb-2">
                <label>Nama Kelas</label>
                <input type="text" name="nama_kelas" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label>Tahun Ajaran</label>
                <select name="id_ta" class="form-control">
                <option value="">Pilih Tahun Ajaran</option>
                @foreach ($tahunAjaran as $tahunAjaran )
                  <option value="{{ $tahunAjaran->id_ta }}">{{ $tahunAjaran->tahunajaran }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
                <label>Nama Guru</label>
                <select name="id_guru" class="form-control">
                <option value="">Pilih Guru</option>
                @foreach ($guru as $guru )
                  <option value="{{ $guru->id_guru }}">{{ $guru->namaguru }}</option>
                @endforeach
              </select>
            </div>



            <button type="submit" class="btn btn-success mt-3">Simpan</button>
            <a href="{{ route('guru.index') }}" class="btn btn-secondary mt-3">Kembali</a>
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

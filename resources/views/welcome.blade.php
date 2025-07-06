
@section('content')
    @include('layouts.header')

<!-- Main content -->
  <div class="main-content">
    <!-- Header Ungu -->
    <div class="header bg-white pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
        <h1 class="text-white" style="margin-top: -100px; margin-bottom: 20px;">Selamat Datang!</h1>

        <div class="row">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Jumlah Siswa Saat Ini</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">89
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-people-line text-success"
                                    style="font-size: 36px; margin-left: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Jumlah Siswa Lulus</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">88
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-fw fa-light fa-award text-warning"
                                    style="font-size: 36px; margin-left: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

      </div>
    </div>
  </div>

  

  <!-- JS -->
  <script src="https://argon-dashboard-laravel-bs4.creative-tim.com/argon/vendor/jquery/dist/jquery.min.js"></script>
  <script src="https://argon-dashboard-laravel-bs4.creative-tim.com/argon/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


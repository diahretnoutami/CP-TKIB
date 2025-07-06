<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TK Islam Baiturrahman</title>
    <link rel="stylesheet"
        href="https://argon-dashboard-laravel-bs4.creative-tim.com/argon/vendor/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://argon-dashboard-laravel-bs4.creative-tim.com/argon/css/argon.css?v=1.0.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.5.2/css/dataTables.dateTime.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />



    <style>
        <style>#sidenav-main .nav-link.active {
            background-color: #ffffff;
            /* warna teks hijau Bootstrap */
            font-weight: 800;
            border-radius: 0.375rem;
            /* biar rounded dikit */
        }
    </style>
</head>

<body>

    <!-- Top Navbar ala Argon Dashboard -->
    <nav class="navbar navbar-top navbar-expand navbar-dark bg-white mb-4 border-bottom shadow"
        style="margin-left: 250px">
        <div class="container-fluid">

            <!-- Judul atau Halaman Aktif -->
            <div class="d-flex align-items-center">
                <img src="/assets/img/logoooo.png" style="height: 45px;">
                <h1 class="h4 text-success mb-0">TK Islam Baiturrahman</h1>
            </div>

            <!-- Tombol Aksi -->
            <div class="ml-auto d-flex align-items-center">
                <!-- Documentation Button -->
                <a href="#" class="btn btn-sm btn-neutral mr-2">Documentation</a>

                <!-- Download Button -->
                <a href="#" class="btn btn-sm btn-neutral mr-3">Download</a>

                <!-- Search -->
                <form class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex">
                    <div class="form-group mb-0">
                        <input class="form-control" placeholder="Search" type="text">
                    </div>
                </form>

                <!-- Profile Dropdown -->
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item dropdown">
                        <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown">
                            <div class="media align-items-center">
                                <span class="avatar avatar-sm rounded-circle">
                                    <img src="/assets/img/rabbit.jpg">
                                </span>
                                <div class="media-body ml-2 d-none d-lg-block">
                                    <span class="mb-0 text-success font-weight-bold">{{ Auth::user()->name }}</span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="#" class="dropdown-item"><i class="ni ni-single-02"></i> My Profile</a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="ni ni-user-run"></i> Logout
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Sidebar -->
    <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-success" id="sidenav-main">

        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="d-flex justify-content-center align-items-center">
                <img src="/assets/img/logoreal.jpg" style="height: 100px; width: 100px; border-radius: 50%;">
            </a>

            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link text-white" href="/semester">
                            <i class="fa-solid fa-layer-group me-2"></i> Semester
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/cp') ? 'active' : '' }} text-white fw-bold"
                            href="/cp">
                            <i class="fa-solid fa-star me-2"></i> Capaian Belajar
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="/alur">
                            <i class="fa-solid fa-layer-group me-2"></i> Alur Pembelajaran
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="/tema">
                            <i class="fa-solid fa-layer-group me-2"></i> Tema
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="/ph">
                            <i class="fa-solid fa-file-signature me-2 text-white"></i> Penilaian Harian
                        </a>
                    </li>

                     <li class="nav-item">
                        <a class="nav-link text-white" data-toggle="collapse" href="#penilaianMenu" role="button"
                            aria-expanded="false" aria-controls="penilaianMenu">
                            <i class="fa-solid fa-file-signature me-2 text-white"></i> Hasil Penilaian
                        </a>
                        <div class="collapse" id="penilaianMenu">
                            <ul class="nav nav-sm flex-column ms-4">
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="/admin/hph">Penilaian Harian</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="/admin/hpm">Penilaian Mingguan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="/admin/hpm">Penilaian Bulanan</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="/guru">
                            <i class="fa-solid fa-chalkboard-user me-2"></i> Guru
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="/tahunajaran">
                            <i class="fa-solid fa-calendar-days me-2"></i> Tahun Ajaran
                        </a>
                    </li>

                     <li class="nav-item">
                        <a class="nav-link text-white" data-toggle="collapse" href="#laporanmenu" role="button"
                            aria-expanded="false" aria-controls="laporanmenu">
                            <i class="fa-solid fa-file-signature me-2 text-white"></i> Laporan
                        </a>
                        <div class="collapse" id="laporanmenu">
                            <ul class="nav nav-sm flex-column ms-4">
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="/deslap">Deskripsi Laporan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="/admin/lap">Data Laporan</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="/kelas">
                            <i class="fa-solid fa-people-roof me-2"></i> Kelas
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="/siswa">
                            <i class="fa-solid fa-children me-2"></i> Siswa
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="/ortu">
                            <i class="fa-solid fa-people-line me-2"></i> Orang Tua
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="/admin/absensi">
                            <i class="fa-solid fa-clipboard-list me-2"></i> Absen
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="/register">
                            <i class="fa-solid fa-clipboard-list me-2"></i> Register
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

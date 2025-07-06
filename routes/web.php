<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CpController;
use App\Http\Controllers\AlurController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Guru\AbsenController;
use App\Http\Controllers\Guru\AlurController as GuruAlurController;
use App\Http\Controllers\Guru\CpController as GuruCpController;
use App\Http\Controllers\Guru\GuruSiswaController;
use App\Http\Controllers\Guru\GuruDashboardController;
use App\Http\Controllers\Guru\HasilPhController;
use App\Http\Controllers\Guru\HasilPmController;
use App\Http\Controllers\PenilaianHarianController;
use App\Http\Controllers\PenilaianMingguanController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\TemaController;
use App\Http\Controllers\AdminAbsensiController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\AdminPhController;
use App\Http\Controllers\AdminPmController;
use App\Http\Controllers\AdminPbController;
use App\Http\Controllers\DeskripsiLaporanController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Guru\HasilPbController;
use App\Http\Controllers\Guru\LaporanController;
use App\Models\Laporan;

Auth::routes(['register' => false]);


// ✅ Route khusus admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');

    Route::get('/', function () {
        return view('welcome');
    });

    Route::resource('cp', CpController::class);
    Route::resource('alur', AlurController::class);
    Route::resource('guru', GuruController::class);
    Route::resource('tahunajaran', TahunAjaranController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('ortu', OrangTuaController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('tema', TemaController::class);
    Route::resource('ph', PenilaianHarianController::class);
    Route::resource('pm', PenilaianMingguanController::class);
    Route::resource('semester', SemesterController::class);
    Route::resource('deslap', DeskripsiLaporanController::class);
    Route::post('semester/setaktif/{id}', [SemesterController::class, 'setAktif'])->name('semester.setAktif');
    Route::post('tahunajaran/setaktif/{id}', [TahunAjaranController::class, 'setAktif'])->name('tahunajaran.setAktif');
    Route::post('/aktifkan-periode', [SettingController::class, 'aktifkanPeriode'])->name('aktifkan.periode');


    Route::get('/kelas/{id_k}/kelola', [KelasController::class, 'kelolaSiswa'])->name('kelas.kelola');
    Route::put('/kelas/{id_k}/siswa', [KelasController::class, 'updateSiswa'])->name('kelas.siswa.update');
    Route::delete('/kelas/{id_k}/siswa/{noinduk}', [KelasController::class, 'hapusSiswa'])->name('kelas.siswa.delete');

    Route::prefix('admin/absensi')->group(function () {
        Route::get('/', [AdminAbsensiController::class, 'index'])->name('admin.absensi.index');
        Route::get('/{id_ta}/kelas', [AdminAbsensiController::class, 'kelas'])->name('admin.absensi.kelas');
        Route::get('/{id_ta}/kelas/{id_kelas}/absen', [AdminAbsensiController::class, 'absen'])->name('admin.absensi.absen');
        Route::get('/{id_ta}/kelas/{id_kelas}/absen/{tanggal}', [AdminAbsensiController::class, 'detail'])->name('admin.absensi.detail');
        Route::post('/{id_ta}/kelas/{id_kelas}/absen/{tanggal}/update', [AdminAbsensiController::class, 'update'])->name('admin.absensi.update');
    });

     Route::prefix('admin/hph')->group(function () {
        Route::get('/', [AdminPhController::class, 'index'])->name('adminhphindex'); // Pilih Tahun Ajaran
        Route::get('/{id_ta}/kelas', [AdminPhController::class, 'kelas'])->name('kelas'); // Pilih kelas
        Route::get('/kelas/{id_k}/siswa', [AdminPhController::class, 'siswa'])->name('siswa'); // Pilih siswa
        Route::get('/siswa/{id_kelas_siswa}/tanggal', [AdminPhController::class, 'tanggal'])->name('tanggal'); // Pilih tanggal
        Route::get('/siswa/{id_kelas_siswa}/tanggal/{tanggal}', [AdminPhController::class, 'detail'])->name('detail'); // Lihat detail
        Route::post('/siswa/{id_kelas_siswa}/tanggal/{tanggal}/update', [AdminPhController::class, 'updateDetail'])->name('detail.update');
    });

    Route::prefix('admin/hpm')->group(function () {
        Route::get('/', [AdminPmController::class, 'index'])->name('adminhpmindex'); // Pilih Tahun Ajaran
        Route::get('/{id_ta}/kelas', [AdminPmController::class, 'kelas'])->name('hpmkelas'); // Pilih kelas
        Route::get('/kelas/{id_k}/siswa', [AdminPmController::class, 'siswa'])->name('hpmsiswa'); // Pilih siswa
        Route::get('/siswa/{id_kelas_siswa}/minggu', [AdminPmController::class, 'minggu'])->name('hpmminggu'); // Pilih minggu
        Route::get('/siswa/{id_kelas_siswa}/minggu/{minggu}', [AdminPmController::class, 'detail'])->name('hpmdetail'); // Lihat detail
    });

    Route::prefix('admin/hpb')->group(function () {
        Route::get('/', [AdminPbController::class, 'index'])->name('adminhpbindex'); // Pilih Tahun Ajaran
        Route::get('/{id_ta}/kelas', [AdminPbController::class, 'kelas'])->name('hpbkelas'); // Pilih kelas
        Route::get('/kelas/{id_k}/siswa', [AdminPbController::class, 'siswa'])->name('hpbsiswa'); // Pilih siswa
        Route::get('/siswa/{id_kelas_siswa}/bulan', [AdminPbController::class, 'bulan'])->name('hpbbulan'); // Pilih bulan
        Route::get('/siswa/{id_kelas_siswa}/bulan/{bulan}', [AdminPbController::class, 'detail'])->name('hpbdetail'); // Lihat detail
    });

    Route::prefix('admin/lap')->group(function () {
        Route::get('/', [AdminLaporanController::class, 'index'])->name('adminlapindex'); // Pilih Tahun Ajaran
        Route::get('/{id_ta}/kelas', [AdminLaporanController::class, 'kelas'])->name('lapkelas'); // Pilih kelas
        Route::get('/kelas/{id_k}/siswa', [AdminLaporanController::class, 'siswa'])->name('lapsiswa'); // Pilih siswa
        Route::get('/siswa/{id_kelas_siswa}/detail', [AdminLaporanController::class, 'detail'])->name('lapdetail'); // Lihat detail
        Route::post('/siswa/{id_kelas_siswa}/update', [AdminLaporanController::class, 'updateDetail'])->name('lapdetail.update');
    });

    Route::prefix('admin/lap')->group(function () {
        Route::get('/', [AdminLaporanController::class, 'index'])->name('adminlapindex'); // Pilih Tahun Ajaran
        Route::get('/{id_ta}/kelas', [AdminLaporanController::class, 'kelas'])->name('lapkelas'); // Pilih kelas
        Route::get('/kelas/{id_k}/siswa', [AdminLaporanController::class, 'siswa'])->name('lapsiswa'); // Pilih siswa
        Route::get('/siswa/{id_kelas_siswa}/detail', [AdminLaporanController::class, 'detail'])->name('lapdetail'); // Lihat detail
        Route::post('/siswa/{id_kelas_siswa}/update', [AdminLaporanController::class, 'updateDetail'])->name('lapdetail.update');
    });
});

// ✅ Route khusus guru
Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/d', [GuruDashboardController::class, 'index'])->name('guru.dashboard');
    
    Route::get('/gsiswa', [GuruSiswaController::class, 'index'])->name('guru.siswa.index');
    Route::get('/gsiswa/edit/{noinduk}', [GuruSiswaController::class, 'edit'])->name('guru.siswaedit');
    Route::put('/gsiswa/{noinduk}', [GuruSiswaController::class, 'update'])->name('guru.siswa.update'); 
    
    Route::get('/absen', [AbsenController::class, 'index'])->name('guru.absen');
    Route::get('/inputabsen', [AbsenController::class, 'create'])->name('guru.inputabsen');
    Route::post('/inputabsen', [AbsenController::class, 'store'])->name('guru.inputabsen.store');
    Route::get('guru/absen/{tanggal}', [AbsenController::class, 'detail'])->name('guru.absendetail');
    Route::put('guru/absen/{tanggal}/update', [AbsenController::class, 'updateDetail'])->name('guru.absen.update_detail');

    // Route untuk Capaian Belajar guru (read-only)
    Route::get('/gcp', [GuruCpController::class, 'index'])->name('capaian.index');
    Route::get('/galur', [GuruAlurController::class, 'index'])->name('alur');

    // penilaian harian 
    Route::get('/hph', [HasilPhController::class, 'index'])->name('hph.index');
    Route::get('/hph/input/{noinduk}', [HasilPhController::class, 'pilihTgl'])->name('guru.hphinputtgl');
    Route::get('/hph/input/{tanggal}/{id_kelas_siswa}', [HasilPhController::class, 'inputHarian'])->name('guru.hphinput');
    Route::post('/hphinput', [HasilPhController::class, 'storeHarian'])->name('guru.hphinput.store');

    // penilaian mingguan
    Route::get('/hpm', [HasilPmController::class, 'index'])->name('hpm.index');
    Route::get('/hpm/{noinduk}/minggu', [HasilPmController::class, 'pilihMinggu'])->name('guru.hpminputmgg');
    Route::get('/hpm/input/{id_kelas_siswa}/{minggu}', [HasilPmController::class, 'inputNilai'])->name('guru.hpminput');
    Route::post('/hpm/input/{id_kelas_siswa}/{minggu}', [HasilPmController::class, 'store'])->name('guru.hpminput.store');

    // penilaian bulanan
    Route::get('/hpb', [HasilPbController::class, 'index'])->name('hpb.index');
    Route::get('/hpb/{noinduk}/bulan', [HasilPbController::class, 'pilihBulan'])->name('guru.hpbinputbln');
    Route::get('/hpb/input/{id_kelas_siswa}/{bulan}', [HasilPbController::class, 'inputNilai'])->name('guru.hpbinput');
    Route::post('/hpb/input/{id_kelas_siswa}/{bulan}', [HasilPbController::class, 'store'])->name('guru.hpbinput.store');

    // laporan
    Route::get('/lap', [LaporanController::class, 'index'])->name('lap.index');
    Route::get('/lap/edit{noinduk}', [LaporanController::class, 'show'])->name('lap.edit');
    Route::post('/lap/store', [LaporanController::class, 'store'])->name('lap.store');
    Route::get('/lap/ekspor/{noinduk}', [LaporanController::class, 'ekspor'])->name('lap.ekspor');


});

// ✅ Route latihan (admin)
Route::get('/about', function () {
    return view('about');
})->middleware(['auth', 'role:admin']);


Route::get('/debug-role', function () {
    if (Auth::check()) {
        return response()->json([
            'user' => Auth::user(),
            'role' => Auth::user()->role,
        ]);
    } else {
        return response()->json([
            'message' => 'Belum login',
        ], 401);
    }
});

Route::get('/phpinfo', function () {
    phpinfo();
});
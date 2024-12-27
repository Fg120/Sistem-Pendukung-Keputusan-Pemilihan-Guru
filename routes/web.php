<?php

use App\Http\Controllers\Admin\AlternatifController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DataPerhitunganController;
use App\Http\Controllers\Admin\HasilAKhirController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\PenilaianController;
use App\Http\Controllers\Admin\SubKriteriaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\auth\SocialiteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\HasilController;
use App\Http\Controllers\Public\HomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     // return view('welcome');
//     return redirect(route('login'));
// });
Route::get('/', [HomeController::class, 'index'])->name('home.index');
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard', function () {
    return redirect(route('admin.dashboard'));
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('guest')->group(function () {
    Route::get('/auth/redirect', [SocialiteController::class, 'redirect'])->name('auth.redirect');
    Route::get('/auth/google/callback/', [SocialiteController::class, 'callback'])->name('auth.google.callback');
});
require __DIR__ . '/auth.php';

Route::middleware(['auth', 'verified',])->group(function () {
    Route::middleware(['role:Superadmin|Admin'])->group(function () {
        Route::name('admin.')->prefix('/admin')->group(function () {
            //DASHBOARD
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

            //USER
            Route::name('user.')->prefix('user')->group(function () {
                Route::get('/', [UserController::class, 'index'])->name('index');
                Route::get('/json', [UserController::class, 'data'])->name('data');
                Route::get('/create', [UserController::class, 'create'])->name('create');
                Route::post('/store', [UserController::class, 'store'])->name('store');
                Route::get('/edit/{enc_id}', [UserController::class, 'edit'])->name('edit');
                Route::post('/update/{enc_id}', [UserController::class, 'update'])->name('update');
                Route::post('/destroy/{id}', [UserController::class, 'destroy'])->name('destroy');
            });

            Route::name('kriteria.')->prefix('kriteria')->group(function () {
                Route::get('/', [KriteriaController::class, 'index'])->name('index');
                Route::get('/json', [KriteriaController::class, 'data'])->name('data');
                Route::get('/create', [KriteriaController::class, 'create'])->name('create');
                Route::post('/store', [KriteriaController::class, 'store'])->name('store');
                Route::get('/show', [KriteriaController::class, 'show'])->name('show');
                Route::get('/edit/{enc_id}', [KriteriaController::class, 'edit'])->name('edit');
                Route::post('/update/{enc_id}', [KriteriaController::class, 'update'])->name('update');
                Route::post('/destroy/{id}', [KriteriaController::class, 'destroy'])->name('destroy');
            });

            Route::name('subkriteria.')->prefix('subkriteria')->group(function () {
                Route::get('/', [SubKriteriaController::class, 'index'])->name('index');
                Route::get('/json', [SubKriteriaController::class, 'data'])->name('data');
                Route::get('/create', [SubKriteriaController::class, 'create'])->name('create');
                Route::post('/store', [SubKriteriaController::class, 'store'])->name('store');
                Route::get('/show', [SubKriteriaController::class, 'show'])->name('show');
                Route::get('/edit/{enc_id}', [SubKriteriaController::class, 'edit'])->name('edit');
                Route::post('/update/{enc_id}', [SubKriteriaController::class, 'update'])->name('update');
                Route::post('/destroy/{id}', [SubKriteriaController::class, 'destroy'])->name('destroy');
            });

            Route::name('alternatif.')->prefix('alternatif')->group(function () {
                Route::get('/', [AlternatifController::class, 'index'])->name('index');
                Route::get('/json', [AlternatifController::class, 'data'])->name('data');
                Route::get('/create', [AlternatifController::class, 'create'])->name('create');
                Route::post('/store', [AlternatifController::class, 'store'])->name('store');
                Route::get('/show', [AlternatifController::class, 'show'])->name('show');
                Route::get('/edit/{enc_id}', [AlternatifController::class, 'edit'])->name('edit');
                Route::post('/update/{enc_id}', [AlternatifController::class, 'update'])->name('update');
                Route::post('/destroy/{id}', [AlternatifController::class, 'destroy'])->name('destroy');
            });

            Route::name('penilaian.')->prefix('penilaian')->group(function () {
                Route::get('/', [PenilaianController::class, 'index'])->name('index');
                Route::get('/json', [PenilaianController::class, 'data'])->name('data');
                Route::get('/create/{enc_id}', [PenilaianController::class, 'create'])->name('create');
                Route::post('/store{enc_id}', [PenilaianController::class, 'store'])->name('store');
                Route::get('/show', [PenilaianController::class, 'show'])->name('show');
                Route::get('/edit/{enc_id}', [PenilaianController::class, 'edit'])->name('edit');
                Route::post('/update/{enc_id}', [PenilaianController::class, 'update'])->name('update');
                Route::post('/destroy/{id}', [PenilaianController::class, 'destroy'])->name('destroy');
            });

            Route::name('hasil_akhir.')->prefix('hasil-akhir')->group(function () {
                Route::get('/index', [HasilAKhirController::class, 'index'])->name('index');
                Route::get('/json', [HasilAKhirController::class, 'data'])->name('data');
            });

            Route::name('data_penilaian.')->prefix('data-penilaian')->group(function () {
                Route::get('/index', [DataPerhitunganController::class, 'index'])->name('index');
                Route::get('/json/{type}', [DataPerhitunganController::class, 'data'])->name('data');
            });
        });
    });


    Route::name('public.')->prefix('/public')->group(function () {
        //HASIL
        Route::name('hasil.')->prefix('hasil')->group(function () {
            Route::get('/', [HasilController::class, 'index'])->name('index');
            Route::get('/json', [HasilController::class, 'data'])->name('data');
        });
    });
});

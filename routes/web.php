<?php

use App\Http\Controllers\ClubController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Livewire\Test;
use App\Livewire\UpdateStandings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', function () {
        if (auth()->user()->role === 'admin') {
            return view('livewire.admin.dashboard');
        } else {
            return view('home');
        }
    })->name('dashboard');
});

Route::get('/storage-link', function () {
    if (file_exists(public_path('storage'))) {
        return 'The "public/storage" directory already exists.';
    }

    app('files')->link(
        storage_path('app/public'),
        public_path('storage')
    );

    return 'The [public/storage] directory has been linked.';
});

Route::get('/storage/logos/{filename}', function ($filename) {
    $allowed   = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    abort_unless(in_array(strtolower($extension), $allowed), 404, 'Invalid file type');

    $path = storage_path("app/public/logos/" . $filename);
    abort_unless(file_exists($path), 404);

    return response()->file($path);
})->name('logo.show');

Route::get('/storage/photos/{filename}', function ($filename) {
    $allowed   = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    abort_unless(in_array(strtolower($extension), $allowed), 404, 'Invalid file type');

    $path = storage_path("app/public/photos/" . $filename);
    abort_unless(file_exists($path), 404);

    return response()->file($path);
})->name('photo.show');

require __DIR__ . '/auth.php';

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/update-standings', UpdateStandings::class);
    Route::get('/clubs', [ClubController::class, 'index'])->name('clubs.index');
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/xeweta', [UserController::class, 'index']);

Route::get('/texawetimezgb', function () {
    return view('livewire.user-livewire');
});

Route::get('/test', Test::class);

Route::get('/privacy-policy', function () {
    return view('livewire.privacy-policy');
})->name('policy');

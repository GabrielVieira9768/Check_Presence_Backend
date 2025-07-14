<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect(route('dashboard'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas de gerenciamento
    Route::resource('subjects', SubjectController::class);
    Route::resource('classrooms', ClassroomController::class);
    Route::resource('presences', PresenceController::class);

    Route::get('/registers', [RegisterController::class, 'index'])->name('registers.index');

    Route::get('/registers/create/{subject}', [RegisterController::class, 'create'])->name('registers.create');
    Route::post('/registers', [RegisterController::class, 'store'])->name('registers.store');

    // Para deletar matrícula, você pode usar rota DELETE com model binding (precisa ajustar a rota)
    Route::delete('/registers/{register}', [RegisterController::class, 'destroy'])->name('registers.destroy');

    Route::get('subjects/{subject}/classrooms', [\App\Http\Controllers\SubjectController::class, 'classrooms'])->name('subjects.classrooms');
    Route::get('/classrooms/{classroom}/qrcode', [ClassroomController::class, 'generateQrCode'])->name('classrooms.qrcode');
});

require __DIR__.'/auth.php';

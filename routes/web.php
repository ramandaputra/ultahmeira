<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BirthdayController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ... rute lainnya (seperti breeze login)

Route::middleware(['auth'])->group(function () {
    // Halaman Quiz
    Route::get('/quiz', [BirthdayController::class, 'showQuiz'])->name('birthday.quiz');
    
    // RUTE YANG ERROR TADI:
    Route::post('/quiz', [BirthdayController::class, 'storeQuiz'])->name('birthday.store');
    
    // Halaman Slideshow
    Route::get('/slideshow', [BirthdayController::class, 'showSlideshow'])->name('birthday.slideshow');

    Route::middleware(['auth'])->group(function () {
    Route::get('/quiz', [BirthdayController::class, 'showQuiz'])->name('birthday.quiz');
    Route::post('/quiz', [BirthdayController::class, 'storeQuiz'])->name('birthday.store');
    
    // Halaman Slideshow
    Route::get('/slideshow', [BirthdayController::class, 'showSlideshow'])->name('birthday.slideshow');
    
    // Halaman Kue (TAMBAHKAN INI)
    Route::get('/cake', [BirthdayController::class, 'showCake'])->name('birthday.cake');
});
});
require __DIR__.'/auth.php';

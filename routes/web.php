<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC & GUEST ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES (Shared by Admin & Customer)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // THE SMART REDIRECTOR
    Route::get('/dashboard', function () {
        if (auth()->user()->role_id == 1) {
            return redirect()->route('admin.home');
        }
        return redirect()->route('home');
    })->name('dashboard');

    // Profile (Shared)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |----------------------------------------------------------------------
    | CUSTOMER ROUTES
    |----------------------------------------------------------------------
    */
    Route::get('/home', [MovieController::class, 'index'])->name('home');
    Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');

    /*
    |----------------------------------------------------------------------
    | ADMIN ROUTES NI SYA 
    |----------------------------------------------------------------------
    */
    Route::middleware(['can:admin-access'])->prefix('admin')->group(function () {
        
        // Admin Home 
        Route::get('/home', function () {
            return view('admin.home');
        })->name('admin.home');

        // Movie Management
        Route::get('/movies/create', [MovieController::class, 'create'])->name('admin.add_movies');
        Route::post('/movies', [MovieController::class, 'store'])->name('movies.store');
        Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
        Route::resource('movies', MovieController::class)->except(['index', 'show', 'create', 'store']);

        /* 
        |--- NEW CINEMA ROUTES ---
        */
        Route::get('/manage-cinemas', [CinemaController::class, 'index'])->name('cinemas.index');
        Route::post('/manage-cinemas', [CinemaController::class, 'store'])->name('cinemas.store');

        Route::get('/manage-cinemas/{cinema}/edit', [CinemaController::class, 'edit'])->name('cinemas.edit');
        Route::put('/manage-cinemas/{cinema}', [CinemaController::class, 'update'])->name('cinemas.update');
        Route::delete('/manage-cinemas/{cinema}', [CinemaController::class, 'destroy'])->name('cinemas.destroy');
        
        Route::resource('schedules', ScheduleController::class);
        // Ticket Management
        Route::get('/tickets', function() { return "Ticket Management"; })->name('admin.tickets');
    });
});

require __DIR__.'/auth.php';
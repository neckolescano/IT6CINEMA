<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController;
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
    // This route decides where to send the user based on their role
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
    | CUSTOMER ROUTES NAA DIRI
    |----------------------------------------------------------------------
    */
    Route::get('/home', [MovieController::class, 'index'])->name('home');
    Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');
    // Add other customer routes like 'my-tickets' here later

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

        // add movie 
        Route::get('/movies/create', [MovieController::class, 'create'])->name('admin.add_movies');
        Route::post('/movies', [MovieController::class, 'store'])->name('movies.store');

        // catalog for admin
        Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
        
        // Resource for Edit, Update, Delete
        Route::resource('movies', MovieController::class)->except(['index', 'show', 'create', 'store']);
        
        // Future Admin Routes
        Route::get('/tickets', function() { return "Ticket Management"; })->name('admin.tickets');
    });
});

require __DIR__.'/auth.php';
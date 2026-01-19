<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsViewController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\EventController;
use App\Http\Middleware\AdminMiddleware;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

/*
|--------------------------------------------------------------------------
| NEWS (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/news/{id}', [NewsViewController::class, 'show'])->name('news.show');
Route::get('/breaking-news', [NewsViewController::class, 'breaking'])->name('news.breaking');
Route::get('/news-of-the-day', [NewsViewController::class, 'day'])->name('news.day');
Route::get('/news-of-the-week', [NewsViewController::class, 'week'])->name('news.week');

/*
|--------------------------------------------------------------------------
| EVENTS (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');
Route::get('/events/past', [EventController::class, 'pastEvents'])->name('events.past');

/*
|--------------------------------------------------------------------------
| BOOKS (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/books', [BookController::class, 'index'])->name('books.index');

/*
|--------------------------------------------------------------------------
| LANGUAGE SWITCH (single global route)
|--------------------------------------------------------------------------
*/
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ps', 'fa'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return back();
})->name('lang.switch');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Breeze / Auth)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (PROTECTED)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Admin Dashboard
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // Users Management
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
        Route::put('/users/{id}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggleStatus');
        Route::put('/users/{id}/change-role', [AdminController::class, 'changeRole'])->name('users.changeRole');

        // Books Management
        Route::post('/books/store', [AdminController::class, 'storeBook'])->name('books.store');
        Route::delete('/books/{id}', [AdminController::class, 'destroyBook'])->name('books.destroy');

        // News Management
        Route::prefix('news')->name('news.')->group(function () {
            Route::get('/{type}', [NewsController::class, 'index'])->name('index');
            Route::get('/{type}/create', [NewsController::class, 'create'])->name('create');
            Route::post('/store', [NewsController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [NewsController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [NewsController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [NewsController::class, 'destroy'])->name('destroy');
        });

        // Events Management - FIXED: Changed all {event} to {id}
        Route::prefix('events')->name('events.')->group(function () {
            // Main routes - USING {id}
            Route::get('/', [EventController::class, 'adminIndex'])->name('index');
            Route::get('/create', [EventController::class, 'create'])->name('create');
            Route::post('/', [EventController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [EventController::class, 'edit'])->name('edit'); // Changed to {id}
            Route::put('/{id}', [EventController::class, 'update'])->name('update'); // Changed to {id}
            Route::delete('/{id}', [EventController::class, 'destroy'])->name('destroy'); // Changed to {id}
            
            // Toggle status - USING {id}
            Route::post('/{id}/toggle-status', [EventController::class, 'toggleStatus'])->name('toggle-status'); // Changed to {id}
        });
    });

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Comments
    Route::post('/news/{news}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comment/{id}', [CommentController::class, 'destroy'])->name('comment.destroy');

    // Likes / Dislikes
    Route::post('/news/{news}/like', [LikeController::class, 'toggle'])->name('news.like');

    // Books - Download route (auth required)
    Route::get('/books/download/{book}', [BookController::class, 'download'])->name('books.download');
    
    // OTP Verification
    Route::get('/otp', [OtpController::class, 'showForm'])->name('otp.form');
    Route::post('/otp', [OtpController::class, 'verify'])->name('otp.verify');
    
    // Book creation (auth required)
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD REDIRECT
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user && $user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('home');
})->middleware('auth')->name('dashboard');
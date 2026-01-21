<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsViewController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\OtpController;
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
| EVENTS (PUBLIC — SLUG BASED)
|--------------------------------------------------------------------------
*/
Route::prefix('events')->name('events.')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('index');          // latest 4 events
    Route::get('/past', [EventController::class, 'pastEvents'])->name('past');  // optional past events
    Route::get('/{event:slug}', [EventController::class, 'show'])->name('show'); // event details by slug
});

/*
|--------------------------------------------------------------------------
| BOOKS (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/books', [BookController::class, 'index'])->name('books.index');

/*
|--------------------------------------------------------------------------
| LANGUAGE SWITCH
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
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (PROTECTED — SLUG BASED EVENTS)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // Users Management
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
        Route::put('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggleStatus');
        Route::put('/users/{user}/change-role', [AdminController::class, 'changeRole'])->name('users.changeRole');

        // Books Management
        Route::post('/books', [AdminController::class, 'storeBook'])->name('books.store');
        Route::delete('/books/{book}', [AdminController::class, 'destroyBook'])->name('books.destroy');

        // News Management
        Route::prefix('news')->name('news.')->group(function () {
            Route::get('/{type}', [NewsController::class, 'index'])->name('index');
            Route::get('/{type}/create', [NewsController::class, 'create'])->name('create');
            Route::post('/', [NewsController::class, 'store'])->name('store');
            Route::get('/{news}/edit', [NewsController::class, 'edit'])->name('edit');
            Route::put('/{news}', [NewsController::class, 'update'])->name('update');
            Route::delete('/{news}', [NewsController::class, 'destroy'])->name('destroy');
        });

        // EVENTS Management (ADMIN — SLUG BASED)
        Route::prefix('events')->name('events.')->group(function () {

            // List all events
            Route::get('/', [AdminEventController::class, 'index'])->name('index');

            // Create new event
            Route::get('/create', [AdminEventController::class, 'create'])->name('create');
            Route::post('/', [AdminEventController::class, 'store'])->name('store');

            // Edit existing event by slug
            Route::get('/edit/{event:slug}', [AdminEventController::class, 'edit'])->name('edit');
            Route::put('/update/{event:slug}', [AdminEventController::class, 'update'])->name('update');

            // Delete event by slug
            Route::delete('/delete/{event:slug}', [AdminEventController::class, 'destroy'])->name('destroy');

            // Toggle event status (publish/unpublish) by slug
            Route::patch('/toggle-status/{event:slug}', [AdminEventController::class, 'toggleStatus'])->name('toggle-status');
        });
    });

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER ROUTES (NORMAL USERS)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Comments
    Route::post('/news/{news}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Likes
    Route::post('/news/{news}/like', [LikeController::class, 'toggle'])->name('news.like');

    // Books
    Route::get('/books/download/{book}', [BookController::class, 'download'])->name('books.download');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');

    // OTP (only for normal users)
    Route::get('/otp', [OtpController::class, 'showForm'])->name('otp.form');
    Route::post('/otp', [OtpController::class, 'verify'])->name('otp.verify');

    // Events (User Actions — SLUG BASED)
    Route::post('/events/{event:slug}/register', [EventController::class, 'register'])->name('events.register');
    Route::post('/events/{event:slug}/save', [EventController::class, 'save'])->name('events.save');
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

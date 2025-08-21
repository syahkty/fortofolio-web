<?php
use Illuminate\Support\Facades\Storage;
use App\Models\Portfolio;
use App\Models\Post;
use App\Http\Controllers\Dashboard\PortfolioController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/blog/{post}', [PostController::class, 'show'])->name('posts.show');

Route::get('/', function () {
    // Ambil 3 proyek portofolio terbaru yang sudah di-publish
    $portfolios = Portfolio::whereNotNull('published_at')
        ->latest('published_at')
        ->take(3)
        ->get();

    // Ambil 3 artikel blog terbaru yang sudah di-publish
    $posts = Post::whereNotNull('published_at')
        ->latest('published_at')
        ->take(3)
        ->get();

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'portfolios' => $portfolios, // Kirim data portofolio
        'posts' => $posts,           // Kirim data blog
    ]);
})->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 'prefix' akan membuat URL menjadi /dashboard/portfolios
    // 'name' akan membuat nama rute menjadi dashboard.portfolios.index, dll.
    Route::resource('portfolios', PortfolioController::class);
    Route::resource('posts', PostController::class);
});

require __DIR__.'/auth.php';

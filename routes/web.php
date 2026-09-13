<?php

use App\Http\Controllers\ContentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| روت‌های عمومی (قابل مشاهده برای همه کاربران بدون نیاز به لاگین یا IP خاص)
|--------------------------------------------------------------------------
*/
Route::get('/', [ContentController::class, 'publicHome'])->name('home');
Route::get('/article/{content:slug}', [ContentController::class, 'publicShow'])->name('public.articles.show');

/*
|--------------------------------------------------------------------------
| روت‌های اختصاصی ادمین (نیازمند لاگین + محدود به آی‌پی‌های مجاز)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin.ip'])->group(function () {
    Route::get('/dashboard', fn () => redirect()->route('contents.index'))->name('dashboard');

    // روت تولید مقاله با هوش مصنوعی
    Route::post('contents/generate', [ContentController::class, 'generate'])->name('contents.generate');

    // مدیریت مقالات (پنل ادمین)
    Route::resource('contents', ContentController::class);
});

require __DIR__ . '/auth.php';

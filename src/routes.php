<?php

/**
 * Blog
 */

use Airdev\Blog\App\Controllers\PostController;

Route::get('/blog', [PostController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [PostController::class, 'post'])->name('blog.post');

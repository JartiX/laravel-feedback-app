<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

Route::get('/feedback/list', [FeedbackController::class, 'index'])->name('feedback.index');

Route::get('/about', [PageController::class, 'about'])->name('about');
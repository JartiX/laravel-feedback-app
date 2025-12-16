<?php

use App\Http\Controllers\Api\FeedbackApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\CommentApiController;
use App\Http\Controllers\Api\TagApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::apiResource('feedbacks', FeedbackApiController::class);
    Route::prefix('feedbacks')->group(function () {
        Route::get('trashed', [FeedbackApiController::class, 'trashed']);
        Route::post('{id}/restore', [FeedbackApiController::class, 'restore']);
        Route::delete('{id}/force-delete', [FeedbackApiController::class, 'forceDelete']);
    });

    Route::apiResource('categories', CategoryApiController::class);
    Route::post('categories/{id}/restore', [CategoryApiController::class, 'restore']);

    Route::apiResource('tags', TagApiController::class);
    Route::get('tags-popular', [TagApiController::class, 'popular']);

    Route::apiResource('comments', CommentApiController::class)->only(['index', 'store', 'destroy']);
    Route::post('comments/{comment}/approve', [CommentApiController::class, 'approve']);
    Route::get('comments/{type}/{id}', [CommentApiController::class, 'forEntity']);
});

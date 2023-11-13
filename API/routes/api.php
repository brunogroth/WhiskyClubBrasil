<?php

// use Illuminate\Http\Request;

use App\Http\Controllers\Website\CommonQuestionController;
use Illuminate\Support\Facades\Route;

Route::prefix('/common-questions')->group(function () {
    Route::get('/', [CommonQuestionController::class, 'index'])->name('common-questions.index');
    Route::post('/create', [CommonQuestionController::class, 'create'])->name('common-questions.create');
});

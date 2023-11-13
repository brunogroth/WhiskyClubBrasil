<?php

// use Illuminate\Http\Request;

use App\Http\Controllers\Website\CommonQuestionController;
use Illuminate\Support\Facades\Route;

Route::prefix('/common-questions')->group(function () {
    Route::get('/', [CommonQuestionController::class, 'index'])->name('common-questions.index');
    Route::get('/{id}', [CommonQuestionController::class, 'show'])->name('common-questions.show');
    Route::post('/create', [CommonQuestionController::class, 'store'])->name('common-questions.create');
    Route::patch('/edit/{id}', [CommonQuestionController::class, 'update'])->name('common-questions.edit');
    Route::delete('/{id}', [CommonQuestionController::class, 'destroy'])->name('common-questions.destroy');
});

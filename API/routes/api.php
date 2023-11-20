<?php

// use Illuminate\Http\Request;

use App\Http\Controllers\Website\AdvantageController;
use App\Http\Controllers\Website\BannerController;
use App\Http\Controllers\Website\CommonQuestionController;
use App\Http\Controllers\Website\WorkingStepController;
use Illuminate\Support\Facades\Route;

Route::prefix('/common-questions')->group(function () {
    Route::get('/', [CommonQuestionController::class, 'index'])->name('common-question.index');
    Route::post('/create', [CommonQuestionController::class, 'store'])->name('common-question.create');
    Route::patch('/edit/{id}', [CommonQuestionController::class, 'update'])->name('common-question.edit');
    Route::get('/{id}', [CommonQuestionController::class, 'show'])->name('common-question.show');
    Route::delete('/{id}', [CommonQuestionController::class, 'destroy'])->name('common-question.delete');
});

Route::prefix('/working-steps')->group(function () {
    Route::get('/', [WorkingStepController::class, 'index'])->name('working-step.index');
    Route::post('/create', [WorkingStepController::class, 'store'])->name('working-step.create');
    Route::patch('/edit/{id}', [WorkingStepController::class, 'update'])->name('working-step.edit');
    Route::get('/{id}', [WorkingStepController::class, 'show'])->name('working-step.show');
    Route::delete('/{id}', [WorkingStepController::class, 'destroy'])->name('working-step.delete');
});

Route::prefix('/advantages')->group(function () {
    Route::get('/', [AdvantageController::class, 'index'])->name('advantage.index');
    Route::post('/create', [AdvantageController::class, 'store'])->name('advantage.create');
    Route::patch('/edit/{id}', [AdvantageController::class, 'update'])->name('advantage.edit');
    Route::get('/{id}', [AdvantageController::class, 'show'])->name('advantage.show');
    Route::delete('/{id}', [AdvantageController::class, 'destroy'])->name('advantage.delete');
});

Route::prefix('banners')->group(function () {
    Route::get('/', [BannerController::class, 'index'])->name('banner.index');
    Route::post('/create', [BannerController::class, 'store'])->name('banner.create');
});

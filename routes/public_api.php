<?php

use App\Http\Controllers\Api\ConfigController;
use App\Http\Controllers\Api\HealthController;
use App\Http\Controllers\Api\TranslationController;

Route::get('health', HealthController::class)->name('health');
Route::get('config', ConfigController::class)->name('config');
Route::get('translations', TranslationController::class)->name('translations');

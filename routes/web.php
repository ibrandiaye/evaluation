<?php

use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// Public Evaluation Routes
Route::get('/', [EvaluationController::class, 'index'])->name('evaluation.index');
Route::post('/start', [EvaluationController::class, 'start'])->name('evaluation.start');
Route::get('/form', [EvaluationController::class, 'form'])->name('evaluation.form');
Route::post('/submit', [EvaluationController::class, 'submit'])->name('evaluation.submit');
Route::get('/result/{evaluation}', [EvaluationController::class, 'result'])->name('evaluation.result');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Protected Routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/questions', [AdminController::class, 'questions'])->name('questions');
    Route::get('/evaluations/{evaluation}', [AdminController::class, 'show'])->name('show');
});

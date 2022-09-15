<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\QuizController as UserQuizController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'authenticate'])->name('authenticate');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::middleware(['auth', 'is_admin'])->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');

        Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
        Route::resource('users', UserController::class);

        Route::post('/quizzes/{id}/restore', [QuizController::class, 'restore'])->name('quizzes.restore');
        Route::resource('quizzes', QuizController::class)->parameters([
            'quiz' => 'id'
        ]);
    });
});

Route::group(['as' => 'user.'], function () {
    Route::middleware(['auth', 'is_user'])->group(function () {
        Route::get('/', UserDashboardController::class)->name('dashboard');
        Route::get('/quiz', [UserQuizController::class, 'index'])->name('quiz.index');
        Route::post('/quiz', [UserQuizController::class, 'store'])->name('quiz.store');
    });
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin;

Route::get('/', [HomeController::class,'index'])->name('home');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function(){
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

    Route::resource('incidents', IncidentController::class);
    Route::patch('incidents/{incident}/status', [IncidentController::class,'updateStatus'])->name('incidents.updateStatus');

    Route::post('incidents/{incident}/comments', [CommentController::class,'store'])->name('comments.store');
    Route::delete('comments/{comment}', [CommentController::class,'destroy'])->name('comments.destroy');

    Route::resource('announcements', AnnouncementController::class);

    Route::get('/notifications', [NotificationController::class,'index'])->name('notifications.index');
    Route::patch('/notifications/{id}/read', [NotificationController::class,'markRead'])->name('notifications.markRead');
    Route::patch('/notifications/read-all', [NotificationController::class,'markAllRead'])->name('notifications.markAllRead');

    Route::middleware('can:admin-access')->prefix('admin')->name('admin.')->group(function(){
        Route::get('/dashboard', [Admin\DashboardController::class,'index'])->name('dashboard');
        Route::resource('users', Admin\UserController::class);
        Route::patch('users/{user}/approve', [Admin\UserController::class,'approve'])->name('users.approve');
        Route::patch('users/{user}/role', [Admin\UserController::class,'updateRole'])->name('users.updateRole');
        Route::resource('zones', Admin\ZoneController::class);
    });
});

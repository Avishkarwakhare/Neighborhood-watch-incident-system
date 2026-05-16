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

Route::get('/setup-database', function() {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        
        // Only seed if no users exist to prevent duplication
        if (\App\Models\User::count() === 0) {
            \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        }
        
        return "Database migration and seeding completed successfully! <a href='/'>Go to Home</a>";
    } catch (\Exception $e) {
        return "Error setting up database: " . $e->getMessage();
    }
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function(){
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/location', [\App\Http\Controllers\ProfileController::class, 'updateLocation'])->name('profile.location.update');

    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

    Route::get('/my-incidents', [IncidentController::class, 'myIncidents'])->name('incidents.my');
    Route::resource('incidents', IncidentController::class);
    Route::patch('incidents/{incident}/status', [IncidentController::class,'updateStatus'])->name('incidents.updateStatus');
    Route::patch('incidents/{incident}/verify', [IncidentController::class, 'verify'])->name('incidents.verify');
    Route::patch('incidents/{incident}/reject', [IncidentController::class, 'reject'])->name('incidents.reject');

    Route::post('incidents/{incident}/comments', [CommentController::class,'store'])->name('comments.store');
    Route::delete('comments/{comment}', [CommentController::class,'destroy'])->name('comments.destroy');

    Route::resource('announcements', AnnouncementController::class);

    Route::post('/polls/{poll}/vote', [\App\Http\Controllers\PollController::class, 'vote'])->name('polls.vote');

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

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\DashboardController;

/* Page d'accueil */
Route::get('/', function () {
    return view('welcome');
    
});

/* Routes protégées */
Route::middleware(['auth', 'verified'])->group(function () {

    /* Dashboard */
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    /* Missions */
    Route::resource('missions', MissionController::class);

    /* Actions missions */
    Route::post('/missions/{id}/vehicule', [MissionController::class, 'affecter'])->name('missions.affecter');
    Route::post('/missions/{id}/decision', [MissionController::class, 'decision'])->name('missions.decision');
    Route::post('/missions/{id}/send', [MissionController::class, 'sendToValidateur'])->name('missions.send');
    Route::post('/missions/{id}/notify-agent', [MissionController::class, 'notifyAgent'])->name('missions.notifyAgent');

    /* API Routes (Internes) */
    Route::get('/api/accompagnateurs', [MissionController::class, 'getAccompanists'])->name('api.accompagnateurs');

    /* Notifications */
    Route::post('/notifications/{id}/read', function ($id) {
        $notification = auth()->user()->unreadNotifications->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
        }
        return back();
    })->name('notifications.read');
});

/* Profil */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
<?php

use App\Http\Controllers\ActivityLogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\RelationshipController;
use App\Http\Controllers\FamilyEventController;
use App\Http\Controllers\FamilyRelationshipController;
use App\Http\Controllers\ProfileController;

// Authentication Routes (if using Breeze)
require __DIR__.'/auth.php';
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Dashboard


// Family Members
Route::resource('family-members', FamilyMemberController::class);

// Relationships
Route::prefix('family-members/{familyMember}/relationships')->group(function () {
    Route::get('/create', [RelationshipController::class, 'create'])->name('relationships.create');
    Route::post('/', [RelationshipController::class, 'store'])->name('relationships.store');
    Route::delete('/{relationship}', [RelationshipController::class, 'destroy'])->name('relationships.destroy');
});

// Family Events
Route::resource('family-events', FamilyEventController::class);

// Additional Routes
Route::get('/upcoming-birthdays', [FamilyMemberController::class, 'upcomingBirthdays'])->name('family-members.upcoming-birthdays');
Route::get('/family-tree', [FamilyMemberController::class, 'showTree'])->name('family-members.tree');
Route::get('/search', [FamilyMemberController::class, 'search'])->name('family-members.search');

// Export/Import Routes
Route::get('/family-members/export', [FamilyMemberController::class, 'export'])->name('family-members.export');
Route::post('/family-members/import', [FamilyMemberController::class, 'import'])->name('family-members.import');

Route::get('/', function () {
    return view('welcome');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/activity', [ActivityLogController::class, 'index'])->name('activity.index');
Route::get('/activity/{activity}', [ActivityLogController::class, 'show'])->name('activity.show');

// routes/web.php

// Add this to the auth group
Route::resource('family-relationships', FamilyRelationshipController::class)->only(['store', 'destroy']);

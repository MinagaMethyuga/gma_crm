<?php

use App\Http\Middleware\EnsureTeamMembership;
use Illuminate\Support\Facades\Route;

// Public pages
Route::view('/', 'welcome')->name('home');
Route::get('/about', fn () => view('about'))->name('about');
Route::get('/who-we-serve', fn () => view('who-we-serve'))->name('who-we-serve');
Route::get('/committees', fn () => view('committees'))->name('committees');
Route::get('/research-insights', fn () => view('research-insights'))->name('research-insights');
Route::get('/events', fn () => view('events'))->name('events');

// Authenticated routes
Route::middleware(['auth'])->group(function () {

    // Admin-only routes
    Route::middleware(['role:admin'])->group(function () {
        Route::view('dashboard', 'dashboard')->name('dashboard');
        Route::view('members', 'members')->name('members');
    });

    // Member dashboard (any authenticated user with member role)
    Route::view('/member/dashboard', 'member_dashboard')->name('member.dashboard');

    // Team invitation acceptance
    Route::livewire('invitations/{invitation}/accept', 'pages::teams.accept-invitation')->name('invitations.accept');
});

require __DIR__.'/settings.php';

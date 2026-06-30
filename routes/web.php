<?php

use App\Http\Middleware\EnsureTeamMembership;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

// Temporary simple dashboard route without middleware
Route::view('dashboard', 'dashboard')->name('dashboard');

/*
Route::prefix('{current_team}')
    ->middleware(['auth', 'verified', EnsureTeamMembership::class])
    ->group(function () {
        Route::view('dashboard', 'dashboard')->name('dashboard');
    });

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function (Illuminate\Http\Request $request) {
        $team = $request->user()->currentTeam ?? $request->user()->personalTeam();
        if ($team) {
            return redirect()->route('dashboard', ['current_team' => $team->slug]);
        }
        return abort(404);
    });
});
*/

Route::middleware(['auth'])->group(function () {
    Route::livewire('invitations/{invitation}/accept', 'pages::teams.accept-invitation')->name('invitations.accept');
});

require __DIR__.'/settings.php';

// FIX: Changed 'aboutus' to 'about' to match your actual filename
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/who-we-serve', function () {
    return view('who-we-serve');
})->name('who-we-serve');

Route::get('/committees', function () {
    return view('committees');
})->name('committees');

Route::get('/research-insights', function () {
    return view('research-insights');
})->name('research-insights');

Route::get('/events', function () {
    return view('events');
})->name('events');
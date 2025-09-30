<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    //return view('welcome');
    return redirect('login');
})->name('home');

Route::get('/app/siswa/logout', function () {
    session()->forget(['siswa']); // Hapus session
    return redirect()->route('app.login');

})->name('app.siswa.logout');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified','adminAuth'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';

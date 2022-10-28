<?php

use App\Http\Livewire\Event;
use App\Http\Livewire\UsersReport;
use App\Http\Livewire\Participant;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/',Event::class)->name('dashboard');
    Route::get('/participants',Participant::class)->middleware(['admin'])->name('participants');
    Route::get('/users-report', UsersReport::class)->middleware(['admin'])->name('report');
});

Route::get('/inactive', function (){
    return view('inactive');
})->name('inactive');

require __DIR__.'/auth.php';

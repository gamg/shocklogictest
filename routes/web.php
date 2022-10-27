<?php

use App\Http\Livewire\Event;
use Illuminate\Support\Facades\Route;

Route::get('/',Event::class)->middleware(['auth'])->name('dashboard');
//Route::get('/users',User::class)->middleware(['auth'])->name('users');

require __DIR__.'/auth.php';

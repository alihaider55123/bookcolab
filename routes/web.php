<?php

use App\Livewire\LiveBookComponent;
use App\Livewire\LiveDashboardComponent;
use App\Livewire\LiveEditBookComponent;
use App\Livewire\LiveHomeComponent;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', LiveHomeComponent::class)->name('home');
Route::get('book/view/{book}', LiveBookComponent::class)->name('book');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session')
])->group(function () {
    Route::get('/dashboard', LiveDashboardComponent::class)->name('dashboard');
    Route::get('/book/edit/{book?}', LiveEditBookComponent::class)->name('edit-book');
    Route::get('/book/add', LiveEditBookComponent::class)->name('add-book');
});

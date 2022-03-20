<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(auth()->check()){ 
        return  redirect('login');
    }

    return view('welcome');
});

Route::middleware(['auth'])->group(function(){ 
    Route::get('/dashboard', function() { return view('dashboard'); })->name('dashboard'); 
    Route::resource('gadplans', App\Http\Controllers\GadplanController::class);
    Route::resource('gadplans/{id}/items', App\Http\Controllers\GadplanListController::class);
    Route::resource('campus', App\Http\Controllers\CampusController::class);
    Route::resource('agencies', App\Http\Controllers\AgencyController::class);
    Route::resource('budget-sources', App\Http\Controllers\BudgetController::class);
    Route::resource('proposals', App\Http\Controllers\ProposalController::class);
    Route::resource('manage-users', App\Http\Controllers\UserController::class);
});

require __DIR__.'/auth.php';

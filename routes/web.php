<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/foods', [FoodController::class, 'index'])->name('foods.index');
Route::get('/foods/create', [FoodController::class, 'create'])->name('foods.create');
Route::post('/foods', [FoodController::class, 'store'])->name('foods.store');
Route::get('/foods/{id}', [FoodController::class, 'show'])->name('foods.show');
Route::get('/foods/{id}/edit', [FoodController::class, 'edit'])->name('foods.edit');
Route::put('/foods/{id}', [FoodController::class, 'update'])->name('foods.update');
Route::delete('/foods/{id}', [FoodController::class, 'destroy'])->name('foods.destroy');
Route::get('/search', [FoodController::class, 'search'])->name('foods.search');


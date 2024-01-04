<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/students', [StudentController::class, 'index'])->name('student.index');
Route::post('/students', [StudentController::class, 'store'])->name('student.store');
Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('student.edit');
Route::put('/students/{id}', [StudentController::class, 'update'])->name('student.update');
Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
Route::get('/getstudents', [StudentController::class, 'get_students']);
Route::get('/skills', [StudentController::class, 'skills']);
Route::get('/states', [StudentController::class, 'states']);
Route::get('/city/{id}', [StudentController::class, 'city']);


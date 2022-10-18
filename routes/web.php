<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\TaskController;

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
    return redirect('/admin');
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);
});

// Route::group(['middleware' => ['auth', 'verified']], function () {
//     Route::get('/dashboard', function () {
//         return Inertia::render('Dashboard');
//     })->name('dashboard');

//     Route::resource('tasks', TaskController::class);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::resource('tasks', TaskController::class);
// // Route::get('/tasks', function () {
// //     return Inertia::render('Tasks/List', [
// //         'tasks' => \App\Models\Task::all(),
// //     ]);
// // })->middleware(['auth', 'verified'])->name('tasks');

// Route::get('/invoices', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('invoices');

require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\UsersController;

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


/*
|--------------------------------------------------------------------------
| Auth User Routes
|--------------------------------------------------------------------------
|*/


Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect('/dashboard');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/activities', [ActivitiesController::class, 'index'])
        ->name('activities');

    Route::controller(ActivityLogController::class)
        ->name('log')
        ->group(function () {
            Route::get('/log', 'viewLog');
            Route::get('/log/{activity}', 'logActivity')
                ->name('.activity');
        });

    Route::get('/profile', [UsersController::class, 'edit'])
        ->name('users.edit');

    Route::get('/teams', [TeamsController::class, 'index'])
        ->name('teams');
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|*/
Route::middleware(['auth', 'admin'])->group(function () {

    Route::controller(ActivitiesController::class)
        ->name('activities')
        ->group(function () {
            Route::get('/activities/create', 'create')
                ->name('.create');
            Route::post('/activities/create', 'store')
                ->name('.store');
        });

    Route::get('/users/{user}/log', [ActivityLogController::class, 'viewUserLog'])
        ->name('users.log');

    Route::controller(UsersController::class)
        ->name('users')
        ->group(function () {
            Route::get('/users', 'index');
            Route::get('/users/{user}/edit', 'editUser')
                ->name('.editUser');
            Route::get('/users/{user}/confirm', 'confirm')
                ->name('.confirm')
                ->withTrashed();
            Route::get('/users/{user}/delete', 'delete')
                ->name('.delete');
        });

    Route::controller(TeamsController::class)
        ->name('teams')
        ->group(function () {
            Route::get('/teams/create', 'create')
                ->name('.create');
            Route::post('/teams/create', 'store')
                ->name('.store');
            Route::get('/teams/{team}/edit', 'edit')
                ->name('.edit');
            Route::put('/teams/{team}/update', 'update')
                ->name('.update');
        });
});

// Route::get('/activities', function () {
//     return view('activities.index');
// })->middleware(['auth'])->name('activities');

require __DIR__ . '/auth.php';

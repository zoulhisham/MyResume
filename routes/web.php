<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\ResumeController;
use App\Models\State;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return redirect()->route('resumes.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('resumes', ResumeController::class);
    Route::get('r/{code}', [ResumeController::class, 'display'])->name('resumes.display');
    Route::post('update/{id}', [ResumeController::class, 'update'])->name('resumes.update');

    Route::group(['prefix' => 'files'], function() {
        Route::post('upload', [FileController::class, 'upload'])->name('files.upload');
    });
});

Route::get('states', function(Request $request) {
    return State::where('country_id', $request->query('country_id'))->get(['id', 'name']);
})->name('states.list');

require __DIR__.'/auth.php';

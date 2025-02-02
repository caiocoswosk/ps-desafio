<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\SiteController;

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

// Rota troca de tema
Route::get('toggle-theme', [SessionController::class, 'toggle'])->name('toggleTheme');

// Rota principal do site
Route::get('/', [SiteController::class, 'index'])->name('siteIndex');
// Rota de busca de produto
Route::get('/search/{query?}', [SiteController::class, 'search'])->name('siteSearch');
// Rota de visualição única de produto
Route::get('/product/{id?}', [SiteController::class, 'produto'])->name('siteProduto');
// Rota de compra de produto
Route::post('/buy', [SiteController::class, 'buy'])->name('siteBuy');

Route::middleware('locale')->group(function () {

    Route::put('/locale', [LocaleController::class, 'setLocale'])->name('locale');

    // Route::get('/', function () {
    //     return redirect()->route('dashboard');
    // });

    Auth::routes();

    Route::middleware('auth')->group(function () {

        //Rota para dashboard
        Route::any('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        //Rotas para log
        Route::any('log', [LogController::class, 'index'])->name('log.index');

        //Rotas para CRUD usuário
        Route::resource('user', UserController::class, ['except' => ['show']]);
        Route::resource('categoria', CategoriaController::class, ['except' => ['show']]);
        Route::resource('produto', ProdutoController::class);


        //Rotas para perfil do usuário
        Route::controller(ProfileController::class)->name('profile.')->group(function () {
            Route::get('profile', 'edit')->name('edit');
            Route::put('profile', 'update')->name('update');
            Route::put('profile/password', 'password')->name('password');
        });
    });
});

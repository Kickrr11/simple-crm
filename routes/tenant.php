<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    /*
    Route::get('/', function () {

        $account = \App\Models\Account::all()->first();
        $account->name = "tenant-edited";
        $account->save();

        $accountNew = \App\Models\Account::create(
            ['name' => 'second one', 'description' => 'second one']
        );

        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });
    */
    Route::get('/', 'App\Http\Controllers\DashboardController@index')->name('dashboard');
    Route::resource('accounts', 'App\Http\Controllers\AccountsController');
});

Route::middleware([
    'api',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::group([
        'prefix' => 'auth'
    ], function () {
        Route::post('login', 'App\Http\Controllers\Auth\ApiController@login')->name('login');
        Route::post('register', 'App\Http\Controllers\Auth\ApiController@register');
        Route::group([
            'middleware' => 'auth:api'
        ], function() {
            Route::get('logout', 'App\Http\Controllers\Auth\ApiController@logout');
            Route::get('user', 'App\Http\Controllers\Auth\ApiController@user');
        });
    });

});


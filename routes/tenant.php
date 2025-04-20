<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Illuminate\Http\Request;
require base_path('routes/auth.php');


/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Aqui você pode registrar as rotas do tenant para sua aplicação.
| Essas rotas são carregadas pelo TenantRouteServiceProvider.
|
| Sinta-se à vontade para personalizá-las como quiser. Boa sorte!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        // dd(\App\Models\User::all());
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });
});

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    'auth:sanctum',
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/user', fn(Request $req) => $req->user());
});

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/login', function () {
        return \Inertia\Inertia::render('auth/Login', [
            'canResetPassword' => true,
            'errors' => session('errors') ? session('errors')->getBag('default')->getMessages() : [],
            'name' => 'Multi Tenant Store',
            'quote' => [
                'message' => 'The whole future lies in uncertainty: live immediately.',
                'author' => 'Seneca',
            ],
        ]);
    });
});

Route::get('/', function () {
    return view('welcome');
})->name('home');

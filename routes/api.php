<?php

use App\Http\Controllers\Api\Params_contact_general_siteController;
use App\Http\Controllers\Api\Params_contact_mail_siteController;
use App\Http\Controllers\Api\Params_contact_phone_siteController;
use App\Http\Controllers\Api\Prix_baseController;
use App\Http\Controllers\Api\Reseaux_sociosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register/client',[UserController::class, 'create_client'] );
Route::post('register/livreur',[UserController::class, 'create_professionnel'] );
Route::post('register/admin',[UserController::class, 'create_admin'] );
Route::post('login',[UserController::class, 'login'] );

Route::group(['middleware'=> ['auth:sanctum'] ], function(){

    Route::get('profile',[UserController::class, 'profile'] );
    Route::get('logout',[UserController::class, 'logout'] );

});


Route::post('params/general',[Params_contact_general_siteController::class, 'create'] );
Route::post('contact/mail',[Params_contact_mail_siteController::class, 'create'] );
Route::post('contact/phone',[Params_contact_phone_siteController::class, 'create'] );
Route::post('params/prix_de_base',[Prix_baseController::class, 'create'] );
Route::post('params/reseaux_socios',[Reseaux_sociosController::class, 'create'] );

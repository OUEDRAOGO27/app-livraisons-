<?php

use App\Http\Controllers\Api\Params_contact_general_siteController;
use App\Http\Controllers\Api\Params_contact_mail_siteController;
use App\Http\Controllers\Api\Params_contact_phone_siteController;
use App\Http\Controllers\Api\Prix_baseController;
use App\Http\Controllers\Api\Reseaux_sociosController;
use App\Http\Controllers\Api\Type_pieceController;
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

Route::post('register/client', [UserController::class, 'create_client']);
Route::post('register/livreur', [UserController::class, 'create_professionnel']);
Route::post('register/admin', [UserController::class, 'create_admin']);
Route::post('login', [UserController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('profile', [UserController::class, 'profile']);
    Route::get('logout', [UserController::class, 'logout']);

});

/**
 * Toutes les routes pour les paramettres des titres, slogan et logo du site
 *
 *@package paramettres des titres, slogan et logo du site
 */
//==================== CREATE ==========================================
Route::post('params/insert/general', [Params_contact_general_siteController::class, 'create']);

/**
 * Toutes les routes pour les contacts emails
 *
 *@package contacts emails
 */
//==================== CREATE ==========================================
Route::post('params/insert/contact/mail', [Params_contact_mail_siteController::class, 'create']);
//==================== READ ==========================================
Route::get('params/show/all/contact/mail', [Params_contact_mail_siteController::class, 'showAll']);
Route::get('params/show/one/contact/mail/{id}', [Params_contact_mail_siteController::class, 'showOne']);
Route::get('params/show/all/active/contact/mail', [Params_contact_mail_siteController::class, 'showAllActive']);
Route::get('params/show/one/active/contact/mail/{id}', [Params_contact_mail_siteController::class, 'showOneActive']);
Route::get('params/show/all/desactive/contact/mail', [Params_contact_mail_siteController::class, 'showAllDesactive']);
Route::get('params/show/one/desactive/contact/mail/{id}', [Params_contact_mail_siteController::class, 'showOneDesactive']);
//==================== UPDATE ==========================================
Route::put('params/update/contact/mail/{id}', [Params_contact_mail_siteController::class, 'edite']);
//==================== DELETE ==========================================
Route::get('params/delete/contact/mail/{id}', [Params_contact_mail_siteController::class, 'delete']);
//==================== ACTIVE ACTION ==========================================
Route::get('params/active/contact/mail/{id}', [Params_contact_mail_siteController::class, 'active']);
Route::get('params/desactive/contact/mail/{id}', [Params_contact_mail_siteController::class, 'desactive']);
/**
 *Toutes les routes pour les contacts téléphones
 *
 *@package contacts téléphones
 */
//==================== CREATE ==========================================
Route::post('params/insert/contact/phone', [Params_contact_phone_siteController::class, 'create']);
//==================== READ ==========================================
Route::get('params/show/all/contact/phone', [Params_contact_phone_siteController::class, 'showAll']);
Route::get('params/show/one/contact/phone/{id}', [Params_contact_phone_siteController::class, 'showOne']);
Route::get('params/show/all/active/contact/phone', [Params_contact_phone_siteController::class, 'showAllActive']);
Route::get('params/show/one/active/contact/phone/{id}', [Params_contact_phone_siteController::class, 'showOneActive']);
Route::get('params/show/all/desactive/contact/phone', [Params_contact_phone_siteController::class, 'showAllDesactive']);
Route::get('params/show/one/desactive/contact/phone/{id}', [Params_contact_phone_siteController::class, 'showOneDesactive']);
//==================== UPDATE ==========================================
Route::put('params/update/contact/phone/{id}', [Params_contact_phone_siteController::class, 'edite']);
//==================== DELETE ==========================================
Route::get('params/delete/contact/phone/{id}', [Params_contact_phone_siteController::class, 'delete']);
//==================== ACTIVE ACTION ==========================================
Route::get('params/active/contact/phone/{id}', [Params_contact_phone_siteController::class, 'active']);
Route::get('params/desactive/contact/phone/{id}', [Params_contact_phone_siteController::class, 'desactive']);

/**
 * Toutes les routes pour les prix de base
 *
 *@package prix de base
 */

//==================== CREATE ==========================================
Route::post('params/insert/prix_de_base', [Prix_baseController::class, 'create']);
//==================== READ ==========================================
Route::get('params/show/all/prix_de_base', [Prix_baseController::class, 'showAll']);
Route::get('params/show/one/prix_de_base/{id}', [Prix_baseController::class, 'showOne']);
Route::get('params/show/all/active/prix_de_base', [Prix_baseController::class, 'showAllActive']);
Route::get('params/show/one/active/prix_de_base/{id}', [Prix_baseController::class, 'showOneActive']);
Route::get('params/show/all/desactive/prix_de_base', [Prix_baseController::class, 'showAllDesactive']);
Route::get('params/show/one/desactive/prix_de_base/{id}', [Prix_baseController::class, 'showOneDesactive']);
//==================== UPDATE ==========================================
Route::put('params/update/prix_de_base/{id}', [Prix_baseController::class, 'edite']);
//==================== DELETE ==========================================
Route::get('params/delete/prix_de_base/{id}', [Prix_baseController::class, 'delete']);
//==================== ACTIVE ACTION ==========================================
Route::get('params/active/prix_de_base/{id}', [Prix_baseController::class, 'active']);

/**
 * Toutes les routes pour les paramettres des réseaux socios
 *
 *@package réseaux socios
 */
Route::post('params/reseaux_socios', [Reseaux_sociosController::class, 'create']);

/**
 * Toutes les routes pour les types de pièce
 *
 *@package types de pièce
 */

//==================== CREATE ==========================================
Route::post('params/insert/type/piece', [Type_pieceController::class, 'create']);
//==================== READ ==========================================
Route::get('params/show/all/type/piece', [Type_pieceController::class, 'showAll']);
Route::get('params/show/one/type/piece/{id}', [Type_pieceController::class, 'showOne']);
Route::get('params/show/all/active/type/piece', [Type_pieceController::class, 'showAllActive']);
Route::get('params/show/one/active/type/piece/{id}', [Type_pieceController::class, 'showOneActive']);
Route::get('params/show/all/desactive/type/piece', [Type_pieceController::class, 'showAllDesactive']);
Route::get('params/show/one/desactive/type/piece/{id}', [Type_pieceController::class, 'showOneDesactive']);
//==================== UPDATE ==========================================
Route::put('params/update/type/piece/{id}', [Type_pieceController::class, 'edite']);
//==================== DELETE ==========================================
Route::get('params/delete/type/piece/{id}', [Type_pieceController::class, 'delete']);
//==================== ACTIVE ACTION ==========================================
Route::get('params/active/type/piece/{id}', [Type_pieceController::class, 'active']);
Route::get('params/desactive/type/piece/{id}', [Type_pieceController::class, 'desactive']);

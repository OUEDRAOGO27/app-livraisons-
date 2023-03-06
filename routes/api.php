<?php

use App\Http\Controllers\Api\AbonnementController;
use App\Http\Controllers\Api\Expiration_abonnementController;
use App\Http\Controllers\Api\Params_contact_general_siteController;
use App\Http\Controllers\Api\Params_contact_mail_siteController;
use App\Http\Controllers\Api\Params_contact_phone_siteController;
use App\Http\Controllers\Api\Prix_baseController;
use App\Http\Controllers\Api\Reseaux_sociosController;
use App\Http\Controllers\Api\Type_abonnementController;
use App\Http\Controllers\Api\Type_livraisonController;
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
 * Toutes les expirations abonnement
 *
 *@package expirations abonnement
 */
//==================== CREATE ==========================================
Route::get('expirations/abonnement/{id}', [Expiration_abonnementController::class, 'verifiExpirationAbonnement']);

/**
 * Toutes les abonnementS
 *
 *@package abonnement
 */
//==================== CREATE ==========================================
Route::post('params/insert/abonnement', [AbonnementController::class, 'create']);
//==================== READ ==========================================
Route::get('params/show/all/abonnement', [AbonnementController::class, 'showAll']);
Route::get('params/show/one/abonnement/{id}', [AbonnementController::class, 'showOne']);
Route::get('params/show/all/active/abonnement', [AbonnementController::class, 'showAllActive']);
Route::get('params/show/one/active/abonnement/{id}', [AbonnementController::class, 'showOneActive']);
Route::get('params/show/all/desactive/abonnement', [AbonnementController::class, 'showAllDesactive']);
Route::get('params/show/one/desactive/abonnement/{id}', [AbonnementController::class, 'showOneDesactive']);
//==================== UPDATE ==========================================
Route::put('params/update/abonnement/{id}', [AbonnementController::class, 'edite']);
//==================== DELETE ==========================================
Route::get('params/delete/abonnement/{id}', [AbonnementController::class, 'delete']);
//==================== ACTIVE ACTION ==========================================
Route::get('params/active/abonnement/{id}', [AbonnementController::class, 'active']);
Route::get('params/desactive/abonnement/{id}', [AbonnementController::class, 'desactive']);


/**
 * Toutes les routes pour les paramettres des titres, slogan et logo du site
 *
 *@package paramettres des titres, slogan et logo du site
 */
//==================== CREATE ==========================================
Route::post('params/insert/generalNomSite', [Params_contact_general_siteController::class, 'create']);
//==================== READ ==========================================
Route::get('params/show/all/generalNomSite', [Params_contact_general_siteController::class, 'showAll']);
Route::get('params/show/one/generalNomSite/{id}', [Params_contact_general_siteController::class, 'showOne']);
Route::get('params/show/all/active/generalNomSite', [Params_contact_general_siteController::class, 'showAllActive']);
Route::get('params/show/one/active/generalNomSite/{id}', [Params_contact_general_siteController::class, 'showOneActive']);
Route::get('params/show/all/desactive/generalNomSite', [Params_contact_general_siteController::class, 'showAllDesactive']);
Route::get('params/show/one/desactive/generalNomSite/{id}', [Params_contact_general_siteController::class, 'showOneDesactive']);
//==================== UPDATE ==========================================
Route::post('params/update/generalNomSite/{id}', [Params_contact_general_siteController::class, 'edite']);
//==================== DELETE ==========================================
Route::get('params/delete/generalNomSite/{id}', [Params_contact_general_siteController::class, 'delete']);
//==================== ACTIVE ACTION ==========================================
Route::get('params/active/generalNomSite/{id}', [Params_contact_general_siteController::class, 'active']);
/* Route::get('params/desactive/generalNomSite/{id}', [Params_contact_general_siteController::class, 'desactive']); */


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
Route::post('params/insert/reseaux_socios', [Reseaux_sociosController::class, 'create']);
//==================== READ ==========================================
Route::get('params/show/all/reseaux_socios', [Reseaux_sociosController::class, 'showAll']);
Route::get('params/show/one/reseaux_socios/{id}', [Reseaux_sociosController::class, 'showOne']);
Route::get('params/show/all/active/reseaux_socios', [Reseaux_sociosController::class, 'showAllActive']);
Route::get('params/show/one/active/reseaux_socios/{id}', [Reseaux_sociosController::class, 'showOneActive']);
Route::get('params/show/all/desactive/reseaux_socios', [Reseaux_sociosController::class, 'showAllDesactive']);
Route::get('params/show/one/desactive/reseaux_socios/{id}', [Reseaux_sociosController::class, 'showOneDesactive']);
//==================== UPDATE ==========================================
Route::post('params/update/reseaux_socios/{id}', [Reseaux_sociosController::class, 'edite']);
//==================== DELETE ==========================================
Route::get('params/delete/reseaux_socios/{id}', [Reseaux_sociosController::class, 'delete']);
//==================== ACTIVE ACTION ==========================================
Route::get('params/active/reseaux_socios/{id}', [Reseaux_sociosController::class, 'active']);
Route::get('params/desactive/reseaux_socios/{id}', [Reseaux_sociosController::class, 'desactive']);

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

/**
 * Toutes les routes pour les types de livraison
 *
 *@package types de livraison
 */

//==================== CREATE ==========================================
Route::post('params/insert/type/livraison', [Type_livraisonController::class, 'create']);
//==================== READ ==========================================
Route::get('params/show/all/type/livraison', [Type_livraisonController::class, 'showAll']);
Route::get('params/show/one/type/livraison/{id}', [Type_livraisonController::class, 'showOne']);
Route::get('params/show/all/active/type/livraison', [Type_livraisonController::class, 'showAllActive']);
Route::get('params/show/one/active/type/livraison/{id}', [Type_livraisonController::class, 'showOneActive']);
Route::get('params/show/all/desactive/type/livraison', [Type_livraisonController::class, 'showAllDesactive']);
Route::get('params/show/one/desactive/type/livraison/{id}', [Type_livraisonController::class, 'showOneDesactive']);
//==================== UPDATE ==========================================
Route::put('params/update/type/livraison/{id}', [Type_livraisonController::class, 'edite']);
//==================== DELETE ==========================================
Route::get('params/delete/type/livraison/{id}', [Type_livraisonController::class, 'delete']);
//==================== ACTIVE ACTION ==========================================
Route::get('params/active/type/livraison/{id}', [Type_livraisonController::class, 'active']);
Route::get('params/desactive/type/livraison/{id}', [Type_livraisonController::class, 'desactive']);

/**
 * Toutes les routes pour les types de abonnement
 *
 *@package types de abonnement
 */

//==================== CREATE ==========================================
Route::post('params/insert/type/abonnement', [Type_abonnementController::class, 'create']);
//==================== READ ==========================================
Route::get('params/show/all/type/abonnement', [Type_abonnementController::class, 'showAll']);
Route::get('params/show/one/type/abonnement/{id}', [Type_abonnementController::class, 'showOne']);
Route::get('params/show/all/active/type/abonnement', [Type_abonnementController::class, 'showAllActive']);
Route::get('params/show/one/active/type/abonnement/{id}', [Type_abonnementController::class, 'showOneActive']);
Route::get('params/show/all/desactive/type/abonnement', [Type_abonnementController::class, 'showAllDesactive']);
Route::get('params/show/one/desactive/type/abonnement/{id}', [Type_abonnementController::class, 'showOneDesactive']);
//==================== UPDATE ==========================================
Route::put('params/update/type/abonnement/{id}', [Type_abonnementController::class, 'edite']);
//==================== DELETE ==========================================
Route::get('params/delete/type/abonnement/{id}', [Type_abonnementController::class, 'delete']);
//==================== ACTIVE ACTION ==========================================
Route::get('params/active/type/abonnement/{id}', [Type_abonnementController::class, 'active']);
Route::get('params/desactive/type/abonnement/{id}', [Type_abonnementController::class, 'desactive']);
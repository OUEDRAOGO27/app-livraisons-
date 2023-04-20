<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Abonnement;
use App\Models\Admin_droit_delete;
use App\Models\Admin_droit_insert;
use App\Models\Admin_droit_select;
use App\Models\Admin_droit_update;
use App\Models\Expiration_abonnement;
use App\Models\Livreur;
use App\Models\Paiement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_client(Request $request)
    {
        //validation
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'avatar' => 'image|mimes:png,jpg,jpeg,svg|max:2048',
            'telephone' => 'required|max:12|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6|max:8',
        ]);

        // traitement des données
        $users = new User();
        $users->nom = strtoupper($request->nom);
        $users->prenom = ucwords(strtolower($request->prenom));
        $users->avatar = Empty($request->avatar)?   '': 
        $path = $request->file('avatar')->store('public/assets/images/user/client');
        $path ;
        $users->role = 'client';
        $users->telephone = $request->telephone;
        $users->email = $request->email;
        $users->password = Hash::make($request->password);
        $users->isConnect =  0;
        $users->isNotify_1 = 1;
        $users->isNotify_2 = 1;
        $users->isActive =  0;
        $users->isDelete =  0;
        $users->save();
        // reponse 
        return response()->json([
            "Status" => 1,
         "Alert" => 'Compte créer avec succès',
         "description"=> 'Création du compte client'
        ]);
    }

    public function create_livreur(Request  $request)
    {
        //validation
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'avatar' => 'required|image|mimes:png,jpg,jpeg,svg|max:2048',
            'telephone' => 'required|max:12|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6|max:8',
  
            'ident_front_photo' => 'required|image|mimes:png,jpg,jpeg,svg|max:2048',
            'ident_back_photo' => 'image|mimes:png,jpg,jpeg,svg|max:2048',
            'id_type_piece' => 'required',
            'date_expiration_piece' => 'required|date'
        ]); 
        $path = $request->file('avatar')->store('public/assets/images/user/livreur');
       
        // traitement des données
        $users = new User();
        $users->nom = strtoupper($request->nom);
        $users->prenom = ucwords(strtolower($request->prenom));
        $users->avatar = $path ;
        $users->role = 'livreur';
        $users->telephone = $request->telephone;
        $users->email = $request->email;
        $users->password = Hash::make($request->password);
        $users->isConnect =  0;
        $users->isActive =  0;
        $users->isDelete =  0;
        $users->save();

      $users_infos = User::where('email', $request->email)->first(); 

    //  $user_id = Auth::user()->id; 
       $path_ident_front_pho = $request->file('ident_front_photo')->store('public/assets/images/user/livreur/ident_front_photo');
      //dd( $user_id );
     $livreur = new Livreur();
      $livreur->id_user  = $users_infos->id; 
      $livreur->ident_front_photo = $path_ident_front_pho;
      $livreur->ident_back_photo =  empty($request->ident_back_photo)?  '':
      $path_ident_back_pho = $request->file('ident_back_photo')->store('public/assets/images/user/livreur/ident_back_photo');
      $path_ident_back_pho ; 
      $livreur->id_type_piece =  $request->id_type_piece ;               
      $livreur->date_expiration_piece = $request->date_expiration_piece ;
      $livreur->save(); 
        // reponse 
        return response()->json([
            "Status" => 1,
         "Alert" => 'Compte créer avec succès',
         "description"=> 'Création du compte livreur'
        ]); 
    }
    public function create_admin(Request $request)
    {
         //validation
         $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'avatar' => 'image|mimes:png,jpg,jpeg,svg|max:2048',
            'telephone' => 'required|max:12|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6|max:8',
        ]);

        // traitement des données
        $users = new User();
        $users->nom = strtoupper($request->nom);
        $users->prenom = ucwords(strtolower($request->prenom));
        $users->avatar = Empty($request->avatar)?   '': 
        $path = $request->file('avatar')->store('public/assets/images/user/admin');
        $path ;
        $users->role = 'admin';
        $users->telephone = $request->telephone;
        $users->email = $request->email;
        $users->password = Hash::make($request->password);
        $users->isConnect =  0;
        $users->isActive =  0;
        $users->isDelete =  0;
        $users->save();
        $users_infos = User::where('email', $request->email)->first(); 
        $id_admin =  $users_infos->id;
        /**début Admin droit select */
                 //  traitement des données 1  Admin_droit_select "abonnements"
                 $admin_droit_select = new  Admin_droit_select();
                 $admin_droit_select->id_admin  =  $id_admin;
                 $admin_droit_select->droit_select = ucfirst(trim("abonnements")) ;
                 $admin_droit_select->isActive = 0;
                 $admin_droit_select->isDelete = 0;
                 $admin_droit_select->save();
         
         
                  //  traitement des données 1  Admin_droit_select "demande_executions"
                  $admin_droit_select = new  Admin_droit_select();
                 $admin_droit_select->id_admin  =  $id_admin;
                 $admin_droit_select->droit_select = ucfirst(trim("demande_executions")) ;
                 $admin_droit_select->isActive = 0;
                 $admin_droit_select->isDelete = 0;
                 $admin_droit_select->save();
         
         
                  //  traitement des données 1  Admin_droit_select "demande_livraisons"
                  $admin_droit_select = new  Admin_droit_select();
                 $admin_droit_select->id_admin  =  $id_admin;
                 $admin_droit_select->droit_select = ucfirst(trim("demande_livraisons")) ;
                 $admin_droit_select->isActive = 0;
                 $admin_droit_select->isDelete = 0;
                 $admin_droit_select->save();
         
         
                  //  traitement des données 1  Admin_droit_select "expiration_abonnements"
                  $admin_droit_select = new  Admin_droit_select();
                 $admin_droit_select->id_admin  =  $id_admin;
                 $admin_droit_select->droit_select = ucfirst(trim("expiration_abonnements")) ;
                 $admin_droit_select->isActive = 0;
                 $admin_droit_select->isDelete = 0;
                 $admin_droit_select->save();
         
         
                  //  traitement des données 1  Admin_droit_select "	note_livreurs"
                  $admin_droit_select = new  Admin_droit_select();
                 $admin_droit_select->id_admin  =  $id_admin;
                 $admin_droit_select->droit_select = ucfirst(trim("	note_livreurs")) ;
                 $admin_droit_select->isActive = 0;
                 $admin_droit_select->isDelete = 0;
                 $admin_droit_select->save();
         
         
                  //  traitement des données 1  Admin_droit_select "paiements"
                  $admin_droit_select = new  Admin_droit_select();
                 $admin_droit_select->id_admin  =  $id_admin;
                 $admin_droit_select->droit_select = ucfirst(trim("paiements")) ;
                 $admin_droit_select->isActive = 0;
                 $admin_droit_select->isDelete = 0;
                 $admin_droit_select->save();
         
         
                  //  traitement des données 1  Admin_droit_select "params_contact_mail_sites"
                  $admin_droit_select = new  Admin_droit_select();
                 $admin_droit_select->id_admin  =  $id_admin;
                 $admin_droit_select->droit_select = ucfirst(trim("params_contact_mail_sites")) ;
                 $admin_droit_select->isActive = 0;
                 $admin_droit_select->isDelete = 0;
                 $admin_droit_select->save();
         
         
                  //  traitement des données 1  Admin_droit_select "params_contact_phone_sites"
                  $admin_droit_select = new  Admin_droit_select();
                 $admin_droit_select->id_admin  =  $id_admin;
                 $admin_droit_select->droit_select = ucfirst(trim("params_contact_phone_sites")) ;
                 $admin_droit_select->isActive = 0;
                 $admin_droit_select->isDelete = 0;
                 $admin_droit_select->save();
         
         
                  //  traitement des données 1  Admin_droit_select "params_general_sites"
                  $admin_droit_select = new  Admin_droit_select();
                 $admin_droit_select->id_admin  =  $id_admin;
                 $admin_droit_select->droit_select = ucfirst(trim("params_general_sites")) ;
                 $admin_droit_select->isActive = 0;
                 $admin_droit_select->isDelete = 0;
                 $admin_droit_select->save();
         
         
                  //  traitement des données 1  Admin_droit_select "poids_colis"
                  $admin_droit_select = new  Admin_droit_select();
                 $admin_droit_select->id_admin  =  $id_admin;
                 $admin_droit_select->droit_select = ucfirst(trim("poids_colis")) ;
                 $admin_droit_select->isActive = 0;
                 $admin_droit_select->isDelete = 0;
                 $admin_droit_select->save();
         
         
                  //  traitement des données 1  Admin_droit_select "prix_bases"
                  $admin_droit_select = new  Admin_droit_select();
                 $admin_droit_select->id_admin  =  $id_admin;
                 $admin_droit_select->droit_select = ucfirst(trim("prix_bases")) ;
                 $admin_droit_select->isActive = 0;
                 $admin_droit_select->isDelete = 0;
                 $admin_droit_select->save();
         
         
                  //  traitement des données 1  Admin_droit_select "reseaux_socios"
                  $admin_droit_select = new  Admin_droit_select();
                 $admin_droit_select->id_admin  =  $id_admin;
                 $admin_droit_select->droit_select = ucfirst(trim("reseaux_socios")) ;
                 $admin_droit_select->isActive = 0;
                 $admin_droit_select->isDelete = 0;
                 $admin_droit_select->save();
         
         
                  //  traitement des données 1  Admin_droit_select "taille_colis"
                  $admin_droit_select = new  Admin_droit_select();
                 $admin_droit_select->id_admin  =  $id_admin;
                 $admin_droit_select->droit_select = ucfirst(trim("taille_colis")) ;
                 $admin_droit_select->isActive = 0;
                 $admin_droit_select->isDelete = 0;
                 $admin_droit_select->save();
         
         
                  //  traitement des données 1  Admin_droit_select "type_abonnements"
                  $admin_droit_select = new  Admin_droit_select();
                 $admin_droit_select->id_admin  =  $id_admin;
                 $admin_droit_select->droit_select = ucfirst(trim("type_abonnements")) ;
                 $admin_droit_select->isActive = 0;
                 $admin_droit_select->isDelete = 0;
                 $admin_droit_select->save();
         
         
                  //  traitement des données 1  Admin_droit_select "type_livraisons"
                  $admin_droit_select = new  Admin_droit_select();
                 $admin_droit_select->id_admin  =  $id_admin;
                 $admin_droit_select->droit_select = ucfirst(trim("type_livraisons")) ;
                 $admin_droit_select->isActive = 0;
                 $admin_droit_select->isDelete = 0;
                 $admin_droit_select->save();
         
         
                  //  traitement des données 1  Admin_droit_select "type_pieces"
                  $admin_droit_select = new  Admin_droit_select();
                 $admin_droit_select->id_admin  =  $id_admin;
                 $admin_droit_select->droit_select = ucfirst(trim("type_pieces")) ;
                 $admin_droit_select->isActive = 0;
                 $admin_droit_select->isDelete = 0;
                 $admin_droit_select->save();
         
         
                  //  traitement des données 1  Admin_droit_select "users"
                  $admin_droit_select = new  Admin_droit_select();
                 $admin_droit_select->id_admin  =  $id_admin;
                 $admin_droit_select->droit_select = ucfirst(trim("users")) ;
                 $admin_droit_select->isActive = 0;
                 $admin_droit_select->isDelete = 0;
                 $admin_droit_select->save();
         
         /**fin Admin droit select */
          /**début Admin droit inserer */
                 //  traitement des données 1 Admin_droit_insert "abonnements"
                 $admin_droit_insert = new Admin_droit_insert();
                 $admin_droit_insert->id_admin  =  $id_admin;
                 $admin_droit_insert->droit_insert = ucfirst(trim("abonnements")) ;
                 $admin_droit_insert->isActive = 0;
                 $admin_droit_insert->isDelete = 0;
                 $admin_droit_insert->save();
         
         
                  //  traitement des données 1 Admin_droit_insert "demande_executions"
                  $admin_droit_insert = new Admin_droit_insert();
                 $admin_droit_insert->id_admin  =  $id_admin;
                 $admin_droit_insert->droit_insert = ucfirst(trim("demande_executions")) ;
                 $admin_droit_insert->isActive = 0;
                 $admin_droit_insert->isDelete = 0;
                 $admin_droit_insert->save();
         
         
                  //  traitement des données 1 Admin_droit_insert "demande_livraisons"
                  $admin_droit_insert = new Admin_droit_insert();
                 $admin_droit_insert->id_admin  =  $id_admin;
                 $admin_droit_insert->droit_insert = ucfirst(trim("demande_livraisons")) ;
                 $admin_droit_insert->isActive = 0;
                 $admin_droit_insert->isDelete = 0;
                 $admin_droit_insert->save();
         
         
                  //  traitement des données 1 Admin_droit_insert "expiration_abonnements"
                  $admin_droit_insert = new Admin_droit_insert();
                 $admin_droit_insert->id_admin  =  $id_admin;
                 $admin_droit_insert->droit_insert = ucfirst(trim("expiration_abonnements")) ;
                 $admin_droit_insert->isActive = 0;
                 $admin_droit_insert->isDelete = 0;
                 $admin_droit_insert->save();
         
         
                  //  traitement des données 1 Admin_droit_insert "	note_livreurs"
                  $admin_droit_insert = new Admin_droit_insert();
                 $admin_droit_insert->id_admin  =  $id_admin;
                 $admin_droit_insert->droit_insert = ucfirst(trim("	note_livreurs")) ;
                 $admin_droit_insert->isActive = 0;
                 $admin_droit_insert->isDelete = 0;
                 $admin_droit_insert->save();
         
         
                  //  traitement des données 1 Admin_droit_insert "paiements"
                  $admin_droit_insert = new Admin_droit_insert();
                 $admin_droit_insert->id_admin  =  $id_admin;
                 $admin_droit_insert->droit_insert = ucfirst(trim("paiements")) ;
                 $admin_droit_insert->isActive = 0;
                 $admin_droit_insert->isDelete = 0;
                 $admin_droit_insert->save();
         
         
                  //  traitement des données 1 Admin_droit_insert "params_contact_mail_sites"
                  $admin_droit_insert = new Admin_droit_insert();
                 $admin_droit_insert->id_admin  =  $id_admin;
                 $admin_droit_insert->droit_insert = ucfirst(trim("params_contact_mail_sites")) ;
                 $admin_droit_insert->isActive = 0;
                 $admin_droit_insert->isDelete = 0;
                 $admin_droit_insert->save();
         
         
                  //  traitement des données 1 Admin_droit_insert "params_contact_phone_sites"
                  $admin_droit_insert = new Admin_droit_insert();
                 $admin_droit_insert->id_admin  =  $id_admin;
                 $admin_droit_insert->droit_insert = ucfirst(trim("params_contact_phone_sites")) ;
                 $admin_droit_insert->isActive = 0;
                 $admin_droit_insert->isDelete = 0;
                 $admin_droit_insert->save();
         
         
                  //  traitement des données 1 Admin_droit_insert "params_general_sites"
                  $admin_droit_insert = new Admin_droit_insert();
                 $admin_droit_insert->id_admin  =  $id_admin;
                 $admin_droit_insert->droit_insert = ucfirst(trim("params_general_sites")) ;
                 $admin_droit_insert->isActive = 0;
                 $admin_droit_insert->isDelete = 0;
                 $admin_droit_insert->save();
         
         
                  //  traitement des données 1 Admin_droit_insert "poids_colis"
                  $admin_droit_insert = new Admin_droit_insert();
                 $admin_droit_insert->id_admin  =  $id_admin;
                 $admin_droit_insert->droit_insert = ucfirst(trim("poids_colis")) ;
                 $admin_droit_insert->isActive = 0;
                 $admin_droit_insert->isDelete = 0;
                 $admin_droit_insert->save();
         
         
                  //  traitement des données 1 Admin_droit_insert "prix_bases"
                  $admin_droit_insert = new Admin_droit_insert();
                 $admin_droit_insert->id_admin  =  $id_admin;
                 $admin_droit_insert->droit_insert = ucfirst(trim("prix_bases")) ;
                 $admin_droit_insert->isActive = 0;
                 $admin_droit_insert->isDelete = 0;
                 $admin_droit_insert->save();
         
         
                  //  traitement des données 1 Admin_droit_insert "reseaux_socios"
                  $admin_droit_insert = new Admin_droit_insert();
                 $admin_droit_insert->id_admin  =  $id_admin;
                 $admin_droit_insert->droit_insert = ucfirst(trim("reseaux_socios")) ;
                 $admin_droit_insert->isActive = 0;
                 $admin_droit_insert->isDelete = 0;
                 $admin_droit_insert->save();
         
         
                  //  traitement des données 1 Admin_droit_insert "taille_colis"
                  $admin_droit_insert = new Admin_droit_insert();
                 $admin_droit_insert->id_admin  =  $id_admin;
                 $admin_droit_insert->droit_insert = ucfirst(trim("taille_colis")) ;
                 $admin_droit_insert->isActive = 0;
                 $admin_droit_insert->isDelete = 0;
                 $admin_droit_insert->save();
         
         
                  //  traitement des données 1 Admin_droit_insert "type_abonnements"
                  $admin_droit_insert = new Admin_droit_insert();
                 $admin_droit_insert->id_admin  =  $id_admin;
                 $admin_droit_insert->droit_insert = ucfirst(trim("type_abonnements")) ;
                 $admin_droit_insert->isActive = 0;
                 $admin_droit_insert->isDelete = 0;
                 $admin_droit_insert->save();
         
         
                  //  traitement des données 1 Admin_droit_insert "type_livraisons"
                  $admin_droit_insert = new Admin_droit_insert();
                 $admin_droit_insert->id_admin  =  $id_admin;
                 $admin_droit_insert->droit_insert = ucfirst(trim("type_livraisons")) ;
                 $admin_droit_insert->isActive = 0;
                 $admin_droit_insert->isDelete = 0;
                 $admin_droit_insert->save();
         
         
                  //  traitement des données 1 Admin_droit_insert "type_pieces"
                  $admin_droit_insert = new Admin_droit_insert();
                 $admin_droit_insert->id_admin  =  $id_admin;
                 $admin_droit_insert->droit_insert = ucfirst(trim("type_pieces")) ;
                 $admin_droit_insert->isActive = 0;
                 $admin_droit_insert->isDelete = 0;
                 $admin_droit_insert->save();
         
         
                  //  traitement des données 1 Admin_droit_insert "users"
                  $admin_droit_insert = new Admin_droit_insert();
                 $admin_droit_insert->id_admin  =  $id_admin;
                 $admin_droit_insert->droit_insert = ucfirst(trim("users")) ;
                 $admin_droit_insert->isActive = 0;
                 $admin_droit_insert->isDelete = 0;
                 $admin_droit_insert->save();
         
         /**fin Admin droit inserer */
         /**début Admin droit update */
                 //  traitement des données 1  Admin_droit_update "abonnements"
                 $admin_droit_update = new  Admin_droit_update();
                 $admin_droit_update->id_admin  =  $id_admin;
                 $admin_droit_update->droit_update = ucfirst(trim("abonnements")) ;
                 $admin_droit_update->isActive = 0;
                 $admin_droit_update->isDelete = 0;
                 $admin_droit_update->save();
         
         
                  //  traitement des données 1  Admin_droit_update "demande_executions"
                  $admin_droit_update = new  Admin_droit_update();
                 $admin_droit_update->id_admin  =  $id_admin;
                 $admin_droit_update->droit_update = ucfirst(trim("demande_executions")) ;
                 $admin_droit_update->isActive = 0;
                 $admin_droit_update->isDelete = 0;
                 $admin_droit_update->save();
         
         
                  //  traitement des données 1  Admin_droit_update "demande_livraisons"
                  $admin_droit_update = new  Admin_droit_update();
                 $admin_droit_update->id_admin  =  $id_admin;
                 $admin_droit_update->droit_update = ucfirst(trim("demande_livraisons")) ;
                 $admin_droit_update->isActive = 0;
                 $admin_droit_update->isDelete = 0;
                 $admin_droit_update->save();
         
         
                  //  traitement des données 1  Admin_droit_update "expiration_abonnements"
                  $admin_droit_update = new  Admin_droit_update();
                 $admin_droit_update->id_admin  =  $id_admin;
                 $admin_droit_update->droit_update = ucfirst(trim("expiration_abonnements")) ;
                 $admin_droit_update->isActive = 0;
                 $admin_droit_update->isDelete = 0;
                 $admin_droit_update->save();
         
         
                  //  traitement des données 1  Admin_droit_update "	note_livreurs"
                  $admin_droit_update = new  Admin_droit_update();
                 $admin_droit_update->id_admin  =  $id_admin;
                 $admin_droit_update->droit_update = ucfirst(trim("	note_livreurs")) ;
                 $admin_droit_update->isActive = 0;
                 $admin_droit_update->isDelete = 0;
                 $admin_droit_update->save();
         
         
                  //  traitement des données 1  Admin_droit_update "paiements"
                  $admin_droit_update = new  Admin_droit_update();
                 $admin_droit_update->id_admin  =  $id_admin;
                 $admin_droit_update->droit_update = ucfirst(trim("paiements")) ;
                 $admin_droit_update->isActive = 0;
                 $admin_droit_update->isDelete = 0;
                 $admin_droit_update->save();
         
         
                  //  traitement des données 1  Admin_droit_update "params_contact_mail_sites"
                  $admin_droit_update = new  Admin_droit_update();
                 $admin_droit_update->id_admin  =  $id_admin;
                 $admin_droit_update->droit_update = ucfirst(trim("params_contact_mail_sites")) ;
                 $admin_droit_update->isActive = 0;
                 $admin_droit_update->isDelete = 0;
                 $admin_droit_update->save();
         
         
                  //  traitement des données 1  Admin_droit_update "params_contact_phone_sites"
                  $admin_droit_update = new  Admin_droit_update();
                 $admin_droit_update->id_admin  =  $id_admin;
                 $admin_droit_update->droit_update = ucfirst(trim("params_contact_phone_sites")) ;
                 $admin_droit_update->isActive = 0;
                 $admin_droit_update->isDelete = 0;
                 $admin_droit_update->save();
         
         
                  //  traitement des données 1  Admin_droit_update "params_general_sites"
                  $admin_droit_update = new  Admin_droit_update();
                 $admin_droit_update->id_admin  =  $id_admin;
                 $admin_droit_update->droit_update = ucfirst(trim("params_general_sites")) ;
                 $admin_droit_update->isActive = 0;
                 $admin_droit_update->isDelete = 0;
                 $admin_droit_update->save();
         
         
                  //  traitement des données 1  Admin_droit_update "poids_colis"
                  $admin_droit_update = new  Admin_droit_update();
                 $admin_droit_update->id_admin  =  $id_admin;
                 $admin_droit_update->droit_update = ucfirst(trim("poids_colis")) ;
                 $admin_droit_update->isActive = 0;
                 $admin_droit_update->isDelete = 0;
                 $admin_droit_update->save();
         
         
                  //  traitement des données 1  Admin_droit_update "prix_bases"
                  $admin_droit_update = new  Admin_droit_update();
                 $admin_droit_update->id_admin  =  $id_admin;
                 $admin_droit_update->droit_update = ucfirst(trim("prix_bases")) ;
                 $admin_droit_update->isActive = 0;
                 $admin_droit_update->isDelete = 0;
                 $admin_droit_update->save();
         
         
                  //  traitement des données 1  Admin_droit_update "reseaux_socios"
                  $admin_droit_update = new  Admin_droit_update();
                 $admin_droit_update->id_admin  =  $id_admin;
                 $admin_droit_update->droit_update = ucfirst(trim("reseaux_socios")) ;
                 $admin_droit_update->isActive = 0;
                 $admin_droit_update->isDelete = 0;
                 $admin_droit_update->save();
         
         
                  //  traitement des données 1  Admin_droit_update "taille_colis"
                  $admin_droit_update = new  Admin_droit_update();
                 $admin_droit_update->id_admin  =  $id_admin;
                 $admin_droit_update->droit_update = ucfirst(trim("taille_colis")) ;
                 $admin_droit_update->isActive = 0;
                 $admin_droit_update->isDelete = 0;
                 $admin_droit_update->save();
         
         
                  //  traitement des données 1  Admin_droit_update "type_abonnements"
                  $admin_droit_update = new  Admin_droit_update();
                 $admin_droit_update->id_admin  =  $id_admin;
                 $admin_droit_update->droit_update = ucfirst(trim("type_abonnements")) ;
                 $admin_droit_update->isActive = 0;
                 $admin_droit_update->isDelete = 0;
                 $admin_droit_update->save();
         
         
                  //  traitement des données 1  Admin_droit_update "type_livraisons"
                  $admin_droit_update = new  Admin_droit_update();
                 $admin_droit_update->id_admin  =  $id_admin;
                 $admin_droit_update->droit_update = ucfirst(trim("type_livraisons")) ;
                 $admin_droit_update->isActive = 0;
                 $admin_droit_update->isDelete = 0;
                 $admin_droit_update->save();
         
         
                  //  traitement des données 1  Admin_droit_update "type_pieces"
                  $admin_droit_update = new  Admin_droit_update();
                 $admin_droit_update->id_admin  =  $id_admin;
                 $admin_droit_update->droit_update = ucfirst(trim("type_pieces")) ;
                 $admin_droit_update->isActive = 0;
                 $admin_droit_update->isDelete = 0;
                 $admin_droit_update->save();
         
         
                  //  traitement des données 1  Admin_droit_update "users"
                  $admin_droit_update = new  Admin_droit_update();
                 $admin_droit_update->id_admin  =  $id_admin;
                 $admin_droit_update->droit_update = ucfirst(trim("users")) ;
                 $admin_droit_update->isActive = 0;
                 $admin_droit_update->isDelete = 0;
                 $admin_droit_update->save();
         
         /**fin Admin droit update */
         /**début Admin droit delete */
                 //  traitement des données 1  Admin_droit_delete "abonnements"
                 $admin_droit_delete = new  Admin_droit_delete();
                 $admin_droit_delete->id_admin  =  $id_admin;
                 $admin_droit_delete->droit_delete = ucfirst(trim("abonnements")) ;
                 $admin_droit_delete->isActive = 0;
                 $admin_droit_delete->isDelete = 0;
                 $admin_droit_delete->save();
         
         
                  //  traitement des données 1  Admin_droit_delete "demande_executions"
                  $admin_droit_delete = new  Admin_droit_delete();
                 $admin_droit_delete->id_admin  =  $id_admin;
                 $admin_droit_delete->droit_delete = ucfirst(trim("demande_executions")) ;
                 $admin_droit_delete->isActive = 0;
                 $admin_droit_delete->isDelete = 0;
                 $admin_droit_delete->save();
         
         
                  //  traitement des données 1  Admin_droit_delete "demande_livraisons"
                  $admin_droit_delete = new  Admin_droit_delete();
                 $admin_droit_delete->id_admin  =  $id_admin;
                 $admin_droit_delete->droit_delete = ucfirst(trim("demande_livraisons")) ;
                 $admin_droit_delete->isActive = 0;
                 $admin_droit_delete->isDelete = 0;
                 $admin_droit_delete->save();
         
         
                  //  traitement des données 1  Admin_droit_delete "expiration_abonnements"
                  $admin_droit_delete = new  Admin_droit_delete();
                 $admin_droit_delete->id_admin  =  $id_admin;
                 $admin_droit_delete->droit_delete = ucfirst(trim("expiration_abonnements")) ;
                 $admin_droit_delete->isActive = 0;
                 $admin_droit_delete->isDelete = 0;
                 $admin_droit_delete->save();
         
         
                  //  traitement des données 1  Admin_droit_delete "    note_livreurs"
                  $admin_droit_delete = new  Admin_droit_delete();
                 $admin_droit_delete->id_admin  =  $id_admin;
                 $admin_droit_delete->droit_delete = ucfirst(trim("    note_livreurs")) ;
                 $admin_droit_delete->isActive = 0;
                 $admin_droit_delete->isDelete = 0;
                 $admin_droit_delete->save();
         
         
                  //  traitement des données 1  Admin_droit_delete "paiements"
                  $admin_droit_delete = new  Admin_droit_delete();
                 $admin_droit_delete->id_admin  =  $id_admin;
                 $admin_droit_delete->droit_delete = ucfirst(trim("paiements")) ;
                 $admin_droit_delete->isActive = 0;
                 $admin_droit_delete->isDelete = 0;
                 $admin_droit_delete->save();
         
         
                  //  traitement des données 1  Admin_droit_delete "params_contact_mail_sites"
                  $admin_droit_delete = new  Admin_droit_delete();
                 $admin_droit_delete->id_admin  =  $id_admin;
                 $admin_droit_delete->droit_delete = ucfirst(trim("params_contact_mail_sites")) ;
                 $admin_droit_delete->isActive = 0;
                 $admin_droit_delete->isDelete = 0;
                 $admin_droit_delete->save();
         
         
                  //  traitement des données 1  Admin_droit_delete "params_contact_phone_sites"
                  $admin_droit_delete = new  Admin_droit_delete();
                 $admin_droit_delete->id_admin  =  $id_admin;
                 $admin_droit_delete->droit_delete = ucfirst(trim("params_contact_phone_sites")) ;
                 $admin_droit_delete->isActive = 0;
                 $admin_droit_delete->isDelete = 0;
                 $admin_droit_delete->save();
         
         
                  //  traitement des données 1  Admin_droit_delete "params_general_sites"
                  $admin_droit_delete = new  Admin_droit_delete();
                 $admin_droit_delete->id_admin  =  $id_admin;
                 $admin_droit_delete->droit_delete = ucfirst(trim("params_general_sites")) ;
                 $admin_droit_delete->isActive = 0;
                 $admin_droit_delete->isDelete = 0;
                 $admin_droit_delete->save();
         
         
                  //  traitement des données 1  Admin_droit_delete "poids_colis"
                  $admin_droit_delete = new  Admin_droit_delete();
                 $admin_droit_delete->id_admin  =  $id_admin;
                 $admin_droit_delete->droit_delete = ucfirst(trim("poids_colis")) ;
                 $admin_droit_delete->isActive = 0;
                 $admin_droit_delete->isDelete = 0;
                 $admin_droit_delete->save();
         
         
                  //  traitement des données 1  Admin_droit_delete "prix_bases"
                  $admin_droit_delete = new  Admin_droit_delete();
                 $admin_droit_delete->id_admin  =  $id_admin;
                 $admin_droit_delete->droit_delete = ucfirst(trim("prix_bases")) ;
                 $admin_droit_delete->isActive = 0;
                 $admin_droit_delete->isDelete = 0;
                 $admin_droit_delete->save();
         
         
                  //  traitement des données 1  Admin_droit_delete "reseaux_socios"
                  $admin_droit_delete = new  Admin_droit_delete();
                 $admin_droit_delete->id_admin  =  $id_admin;
                 $admin_droit_delete->droit_delete = ucfirst(trim("reseaux_socios")) ;
                 $admin_droit_delete->isActive = 0;
                 $admin_droit_delete->isDelete = 0;
                 $admin_droit_delete->save();
         
         
                  //  traitement des données 1  Admin_droit_delete "taille_colis"
                  $admin_droit_delete = new  Admin_droit_delete();
                 $admin_droit_delete->id_admin  =  $id_admin;
                 $admin_droit_delete->droit_delete = ucfirst(trim("taille_colis")) ;
                 $admin_droit_delete->isActive = 0;
                 $admin_droit_delete->isDelete = 0;
                 $admin_droit_delete->save();
         
         
                  //  traitement des données 1  Admin_droit_delete "type_abonnements"
                  $admin_droit_delete = new  Admin_droit_delete();
                 $admin_droit_delete->id_admin  =  $id_admin;
                 $admin_droit_delete->droit_delete = ucfirst(trim("type_abonnements")) ;
                 $admin_droit_delete->isActive = 0;
                 $admin_droit_delete->isDelete = 0;
                 $admin_droit_delete->save();
         
         
                  //  traitement des données 1  Admin_droit_delete "type_livraisons"
                  $admin_droit_delete = new  Admin_droit_delete();
                 $admin_droit_delete->id_admin  =  $id_admin;
                 $admin_droit_delete->droit_delete = ucfirst(trim("type_livraisons")) ;
                 $admin_droit_delete->isActive = 0;
                 $admin_droit_delete->isDelete = 0;
                 $admin_droit_delete->save();
         
         
                  //  traitement des données 1  Admin_droit_delete "type_pieces"
                  $admin_droit_delete = new  Admin_droit_delete();
                 $admin_droit_delete->id_admin  =  $id_admin;
                 $admin_droit_delete->droit_delete = ucfirst(trim("type_pieces")) ;
                 $admin_droit_delete->isActive = 0;
                 $admin_droit_delete->isDelete = 0;
                 $admin_droit_delete->save();
         
         
                  //  traitement des données 1  Admin_droit_delete "users"
                  $admin_droit_delete = new  Admin_droit_delete();
                 $admin_droit_delete->id_admin  =  $id_admin;
                 $admin_droit_delete->droit_delete = ucfirst(trim("users")) ;
                 $admin_droit_delete->isActive = 0;
                 $admin_droit_delete->isDelete = 0;
                 $admin_droit_delete->save();
         
         /**fin Admin droit delete */
        // reponse 
        return response()->json([
            "Status" => 1,
         "Alert" => 'Compte créer avec succès',
         "description"=> 'Création du compte admin'
        ]);
    }

    public function login(Request $request)
    {
  
        // validation 
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed',

        ]);
           // verification de l'existence
           $users = User::where('email', '=', $request->email)->first();
           if ($users)
           {// if email
           
            if (Hash::check($request->password, $users->password))
            {// if de password

                // création de token
                $token = $users->createToken('auth_token')->plainTextToken;

               
                $verifi = $this->verifiExpirationAbonnement($users->id);
                return response()->json([
                    "Status" => 1,
                    "Alert" => 'Utilisateur connecté',
                    "Token" => $token ,
                    "Data" => $users 
                   ]);
                  
            }
           else{

            return response()->json([
                "Status" => 0,
                "Alert" => 'Mot de passe incorrect'
               ]);


           }// else de password



           }
           else{
         
            return response()->json([
             "Status" => 0,
             "Alert" => 'Email incorrect'
            ]);

           }// else email

    }


      /**
     * verifiExpirationAbonnement
     *
     * @return \Illuminate\Http\Response
     */
    public function verifiExpirationAbonnement($id)
    {
        /** verification abonne */
        //$id  =  $users->id;
        // traitement des données 2 paiement
if (Abonnement::where(['id_liv' => $id,'status_abon' => 'en_cours' , 'isActive' => 1,'isDelete' => 0 ])->first()) {

$abonnement = Abonnement::where(['id_liv' => $id,'status_abon' => 'en_cours' , 'isActive' => 1,'isDelete' => 0 ])->first(); 

   $expiration_abonnement = Expiration_abonnement::where(['id_abon' => $abonnement->id, 'isActive' => 1,'isDelete' => 0 ])->first();
      
   if (now() > $expiration_abonnement->date_expire) {
       
        // traitement des données 3 expiration abonnement
   $expiration_abonnement = Expiration_abonnement::where(['id_abon' => $abonnement->id, 'isActive' => 1,'isDelete' => 0 ])->first();
          
       $expiration_abonnement->update([
           "isNotify_abon_exp_1" => 1,
           "isNotify_abon_exp_2" => 1,
           "isActive" => 0,
           "status" => 0,
       ]);
   
        // traitement des données 1 abonnement
   $abonnement = Abonnement::where(['id' => $abonnement->id,'status_abon' => 'en_cours' , 'isActive' => 1,'isDelete' => 0 ])->first(); 
      
   $abonnement->update([
       "isNotify_abon_exp_1" => 1,
       "isNotify_abon_exp_2" => 1,
       "isActive" => 0,
       "status_abon" => "expirer"
   ]);

   // traitement des données 2 paiement
   $paiement = Paiement::where(['id_abon' => $abonnement->id, 'isActive' => 1,'isDelete' => 0 ])->first();
   
   $paiement->update([
       "isNotify_paie_exp_1" => 1,
       "isNotify_paie_exp_2" => 1,
       "isActive" => 0,
   ]);
   
    return response()->json([
           "Status" => 1,
           "Alert" => 'abonnement expirer',
           "description" => 'verification expiration abonnement et mise à jours  '
       ]); 



   }else{
    
       return response()->json([
           "Status" => 1,
           "Alert" => 'abonnement en cours ',
           "description" => 'abonnement en cours '
       ]);
   }
  

}else{
   return response()->json([
       "Status" => 0,
       "Alert" => 'Aucun abonnement en cours existe pour cet identifiant ',
       "description" => 'abonnement inexistant '
   ]);
}

   /** en verification abonne */
   
       
    }

}

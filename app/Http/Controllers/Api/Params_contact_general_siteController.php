<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Params_general_site;
use Illuminate\Http\Request;

class Params_contact_general_siteController extends Controller
{
    /**
     * Création de titre , slogan et logo de l\'app
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        /* $imgName = Str::random(32).".".$request->logo->getClientOriginalExtension(); */
        //validation
        $request->validate([
            'titre' => 'required|max:50|unique:Params_general_sites',
            'slogan' => 'required|max:50',
            'logo' => 'required|image|mimes:png,jpg,jpeg,svg|max:2048'
        ]);

        $path = $request->file('logo')->store('public/assets/images/paramsGeneralNomSite');
        // traitement des données
        $params_params_general_site = new Params_general_site();
        $params_params_general_site->titre = $request->titre;
        $params_params_general_site->slogan = $request->slogan;
        $params_params_general_site->logo = $path;
        $params_params_general_site->isActive =  0;
        $params_params_general_site->isDelete =  0;
        $params_params_general_site->save();
         // enregistrer image dans un dossier
    
        // reponse 
        return response()->json([
         "Status" => 1,
         "Alert" => 'Titre , slogan et logo de l\'app enregistré avec succès',
         "description"=> 'Création de  titre , slogan et logo de l\'app pour la partie nos réseaux socios sur l\'apps '
        ]);
    }

     /**
     * afficher tous les titre , slogan et logo de l\'app  pour les contacts
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {
        
        if (Params_general_site::where('isDelete', 0 )->exists()) {

            $params_general_site = Params_general_site::where('isDelete', 0)->get();
            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les  titre , slogan et logo de l\'app   affichés  avec succès',
                "description"=> 'Details de tous les  titre , slogan et logo de l\'app ',
                "data" => $params_general_site
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun titre , slogan et logo de l\'app  trouvé',
               ]);
           }



    }


    /**
        * afficher un titre , slogan et logo de l\'app 
        *
        * @return \Illuminate\Http\Response
        */
       public function showOne($id)
       {
           
           if (Params_general_site::where(['id' => $id, 'isDelete' => 0 ])->exists()) {

            $params_general_site = Params_general_site::where([
                'id' => $id,
                'isDelete' => 0
            ])->get();

            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Titre , slogan et logo de l\'app  trouvé avec succès',
                "description"=> 'Details du titre , slogan et logo de l\'app  ',
                "data" => $params_general_site
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun titre , slogan et logo de l\'app  trouvé',
               ]);
           }

       }

       /**
        * mise à jour du titre , slogan et logo de l\'app 
        *
        * @return \Illuminate\Http\Response
        */
        public function edite(Request $request ,$id)
        {
            
            if (Params_general_site::where(['id' => $id, 'isDelete' => 0 ])->exists()) {
                //validation
              $request->validate([
                'titre' => 'required|max:50|unique:Params_general_sites',
            'slogan' => 'required|max:50',
            'logo' => 'required|image|mimes:png,jpg,jpeg,svg|max:2048'
                  ]);
                 
             $params_general_site = Params_general_site::where(['id' => $id, 'isDelete' => 0 ])->first();
             $path = $request->file('logo')->store('public/assets/images/paramsGeneralNomSite');
              // traitement des données 
              $params_general_site->update([
                   "titre"=> $request->titre,
                   "slogan"=> $request->slogan ,
                   "logo"=> $path
              ]);
             return response()->json([
                 "Status" => 1,
                 "Alert" => 'Titre , slogan et logo de l\'app  mise à jours avec succès',
                ]);
 
 
            }else{
             return response()->json([
                 "Status" => 0,
                 "Alert" => 'Aucun titre , slogan et logo de l\'app  trouvé',
                ]);
            }
 
 
        }

         /**
        * activer un titre , slogan et logo de l\'app 
        *
        * @return \Illuminate\Http\Response
        */
        public function active($id)
        {
            
            if (Params_general_site::where(['id' => $id, 'isDelete' => 0 ])->exists()) {

                   
                $tous_params_general_site = Params_general_site::where('isDelete', 0 );
                // traitement 1 des données 
                $tous_params_general_site->update([
               "isActive"=> 0
          ]);


            $params_general_site = Params_general_site::where(['id' => $id, 'isDelete' => 0 ])->first();

             // traitement des données 
             $params_general_site->update([
                  "isActive"=> 1
             ]);
                    
      
                   return response()->json([
                       "Status" => 1,
                       "Alert" => 'Titre , slogan et logo de l\'app  activé avec succès',
                      ]);
 
            }else{
             return response()->json([
                 "Status" => 0,
                 "Alert" => 'Aucun titre , slogan et logo de l\'app  trouvé',
                ]);
            }
 
 
        }
         /**
        * désactiver un titre , slogan et logo de l\'app 
        *
        * @return \Illuminate\Http\Response
        */
       /*  public function desactive($id)
        {
            
            if (Params_general_site::where(['id' => $id, 'isDelete' => 0 ])->exists()) {

                $params_general_site = Params_general_site::where(['id' => $id, 'isDelete' => 0 ])->first();

                // traitement des données 
                $params_general_site->update([
                     "isActive"=> 0
                ]);
  
               return response()->json([
                   "Status" => 1,
                   "Alert" => 'titre , slogan et logo de l\'app  désactivé avec succès',
                  ]);
 
 
            }else{
             return response()->json([
                 "Status" => 0,
                 "Alert" => 'Aucun titre , slogan et logo de l\'app  trouvé',
                ]);
            }
 
 
        } */
        
 /**
     * afficher tous les titre , slogan et logo de l\'app  activé
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllActive()
    {
        
        if (Params_general_site::where(['isActive' => 1, 'isDelete' => 0 ])->exists()) {

            $params_general_site = Params_general_site::where(['isActive' => 1, 'isDelete' => 0 ])->get();
            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les titre , slogan et logo de l\'app  activé affichés  avec succès',
                "description"=> 'Details de tous les titre , slogan et logo de l\'app  activé',
                "data" => $params_general_site
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun titre , slogan et logo de l\'app  activé trouvé',
               ]);
           }



    }


    /**
        * afficher un titre , slogan et logo de l\'app  activé
        *
        * @return \Illuminate\Http\Response
        */
       public function showOneActive($id)
       {
           
           if (Params_general_site::where(['id' => $id, 'isActive' => 1, 'isDelete' => 0 ])->exists()) {

            $params_general_site = Params_general_site::where(['id' => $id, 'isActive' => 1, 'isDelete' => 0 ])->get();

            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Titre , slogan et logo de l\'app  activé trouvé avec succès',
                "description"=> 'Details du titre , slogan et logo de l\'app  activé',
                "data" => $params_general_site
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun titre , slogan et logo de l\'app  activé trouvé',
               ]);
           }

       }

       /**
     * afficher tous les titre , slogan et logo de l\'app  désactivé
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllDesactive()
    {
        
        if (Params_general_site::where(['isActive' => 0, 'isDelete' => 0 ])->exists()) {

            $params_general_site = Params_general_site::where(['isActive' => 0, 'isDelete' => 0 ])->get();
            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les titre , slogan et logo de l\'app  désactivé affichés  avec succès',
                "description"=> 'Details de tous les titre , slogan et logo de l\'app  désactivé',
                "data" => $params_general_site
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun titre , slogan et logo de l\'app  désactivé trouvé',
               ]);
           }



    }


    /**
        * afficher un titre , slogan et logo de l\'app  désactivé
        *
        * @return \Illuminate\Http\Response
        */
       public function showOneDesactive($id)
       {
           
           if (Params_general_site::where(['id' => $id, 'isActive' => 0, 'isDelete' => 0 ])->exists()) {

            $params_general_site = Params_general_site::where(['id' => $id, 'isActive' => 0, 'isDelete' => 0 ])->get();

            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Titre , slogan et logo de l\'app  désactivé trouvé avec succès',
                "description"=> 'Details du titre , slogan et logo de l\'app  désactivé',
                "data" => $params_general_site
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun titre , slogan et logo de l\'app  désactivé trouvé',
               ]);
           }

       }
        /**
        * supprimer un titre , slogan et logo de l\'app 
        *
        * @return \Illuminate\Http\Response
        */
        public function delete($id)
        {
            
            if (Params_general_site::where(['id' => $id, 'isDelete' => 0 ])->exists()) {
             $params_general_site = Params_general_site::where(['id' => $id, 'isDelete' => 0 ])->first();

              // traitement des données 
              $params_general_site->update([
                   "isDelete"=> 1
              ]);
             return response()->json([
                 "Status" => 1,
                 "Alert" => 'Titre , slogan et logo de l\'app supprimé avec succès',
                ]);
 
 
            }else{
             return response()->json([
                 "Status" => 0,
                 "Alert" => 'Aucun titre , slogan et logo de l\'app  trouvé',
                ]);
            }
 
 
        }




}

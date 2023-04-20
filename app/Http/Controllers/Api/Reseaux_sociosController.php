<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reseaux_socios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Reseaux_sociosController extends Controller
{
    /**
     * Création de réseau social
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        /* $imgName = Str::random(32).".".$request->logo->getClientOriginalExtension(); */
        //validation
        $request->validate([
            'titre' => 'required|max:50|unique:reseaux_socios',
            'logo' => 'required|image|mimes:png,jpg,jpeg,svg|max:2048',
            'lien_url' => 'required|url|unique:reseaux_socios',
        ]);

        $path = $request->file('logo')->store('public/assets/images/paramsReseauxSocios');
        $Reseaux_socios_count = Reseaux_socios::where(['isActive' => 1, 'isDelete' => 0 ])->get()->count();
        // count
 if ($Reseaux_socios_count >= 1) {
            // traitement des données
        $params_Reseaux_socios = new Reseaux_socios();
        $params_Reseaux_socios->titre = $request->titre;
        $params_Reseaux_socios->logo = $path;
        $params_Reseaux_socios->lien_url = $request->lien_url;
       $params_Reseaux_socios->isNotify_1 = 1;
       $params_Reseaux_socios->isNotify_2 = 1;
        $params_Reseaux_socios->isActive =  0;
        $params_Reseaux_socios->isDelete =  0;
        $params_Reseaux_socios->save();
         // enregistrer image dans un dossier
    
        // reponse 
        return response()->json([
         "Status" => 1,
         "Alert" => 'Contact réseau social enregistré avec succès',
         "description"=> 'Création de  réseau social pour la partie nos réseaux socios sur l\'apps '
        ]);
        }else{
             // traitement des données
        $params_Reseaux_socios = new Reseaux_socios();
        $params_Reseaux_socios->titre = $request->titre;
        $params_Reseaux_socios->logo = $path;
        $params_Reseaux_socios->lien_url = $request->lien_url;
        $params_Reseaux_socios->isNotify_1 = 1;
        $params_Reseaux_socios->isNotify_2 = 1;
        $params_Reseaux_socios->isActive =  1;
        $params_Reseaux_socios->isDelete =  0;
        $params_Reseaux_socios->save();
         // enregistrer image dans un dossier
    
        // reponse 
        return response()->json([
         "Status" => 1,
         "Alert" => 'Contact réseau social enregistré avec succès',
         "description"=> 'Création de  réseau social pour la partie nos réseaux socios sur l\'apps '
        ]); 
        }
       
    }

     /**
     * afficher tous les réseau social  pour les contacts
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {
        
        if (Reseaux_socios::where('isDelete', 0 )->exists()) {

            $reseaux_socios = Reseaux_socios::where('isDelete', 0)->get();
            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les  réseau social   affichés  avec succès',
                "description"=> 'Details de tous les  réseau social ',
                "data" => $reseaux_socios
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun réseau social  trouvé',
               ]);
           }



    }


    /**
        * afficher un réseau social 
        *
        * @return \Illuminate\Http\Response
        */
       public function showOne($id)
       {
           
           if (Reseaux_socios::where(['id' => $id, 'isDelete' => 0 ])->exists()) {

            $reseaux_socios = Reseaux_socios::where([
                'id' => $id,
                'isDelete' => 0
            ])->get();

            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Réseau social  trouvé avec succès',
                "description"=> 'Details du réseau social  ',
                "data" => $reseaux_socios
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun réseau social  trouvé',
               ]);
           }

       }

       /**
        * mise à jour du réseau social 
        *
        * @return \Illuminate\Http\Response
        */
        public function edite(Request $request ,$id)
        {
            
            if (Reseaux_socios::where(['id' => $id, 'isDelete' => 0 ])->exists()) {
                //validation
              $request->validate([
                'titre' => 'required|max:50|unique:reseaux_socios',
                'logo' => 'required|image|mimes:png,jpg,jpeg,svg|max:2048',
                'lien_url' => 'required|url|unique:reseaux_socios',
                  ]);
                 
             $reseaux_socios = Reseaux_socios::where(['id' => $id, 'isDelete' => 0 ])->first();
             $path = $request->file('logo')->store('public/assets/images/paramsReseauxSocios');
              // traitement des données 
              $reseaux_socios->update([
                   "titre"=> $request->titre,
                   "logo"=> $path,
                   "lien_url"=> $request->lien_url
              ]);
             return response()->json([
                 "Status" => 1,
                 "Alert" => 'Réseau social  mise à jours avec succès',
                ]);
 
 
            }else{
             return response()->json([
                 "Status" => 0,
                 "Alert" => 'Aucun réseau social  trouvé',
                ]);
            }
 
 
        }

         /**
        * activer un réseau social 
        *
        * @return \Illuminate\Http\Response
        */
        public function active($id)
        {
            
            if (Reseaux_socios::where(['id' => $id, 'isDelete' => 0 ])->exists()) {

                $reseaux_socios = Reseaux_socios::where(['id' => $id, 'isDelete' => 0 ])->first();

                    // traitement des données 
                    $reseaux_socios->update([
                         "isActive"=> 1
                    ]);
      
                   return response()->json([
                       "Status" => 1,
                       "Alert" => 'Réseau social  activé avec succès',
                      ]);
 
            }else{
             return response()->json([
                 "Status" => 0,
                 "Alert" => 'Aucun réseau social  trouvé',
                ]);
            }
 
 
        }
         /**
        * désactiver un réseau social 
        *
        * @return \Illuminate\Http\Response
        */
        public function desactive($id)
        {
            
            if (Reseaux_socios::where(['id' => $id, 'isDelete' => 0 ])->exists()) {

                $reseaux_socios = Reseaux_socios::where(['id' => $id, 'isDelete' => 0 ])->first();

                // traitement des données 
                $reseaux_socios->update([
                     "isActive"=> 0
                ]);
  
               return response()->json([
                   "Status" => 1,
                   "Alert" => 'Réseau social  désactivé avec succès',
                  ]);
 
 
            }else{
             return response()->json([
                 "Status" => 0,
                 "Alert" => 'Aucun réseau social  trouvé',
                ]);
            }
 
 
        }
        
 /**
     * afficher tous les réseau social  activé
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllActive()
    {
        
        if (Reseaux_socios::where(['isActive' => 1, 'isDelete' => 0 ])->exists()) {

            $reseaux_socios = Reseaux_socios::where(['isActive' => 1, 'isDelete' => 0 ])->get();
            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les réseau social  activé affichés  avec succès',
                "description"=> 'Details de tous les réseau social  activé',
                "data" => $reseaux_socios
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun réseau social  activé trouvé',
               ]);
           }



    }


    /**
        * afficher un réseau social  activé
        *
        * @return \Illuminate\Http\Response
        */
       public function showOneActive($id)
       {
           
           if (Reseaux_socios::where(['id' => $id, 'isActive' => 1, 'isDelete' => 0 ])->exists()) {

            $reseaux_socios = Reseaux_socios::where(['id' => $id, 'isActive' => 1, 'isDelete' => 0 ])->get();

            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Réseau social  activé trouvé avec succès',
                "description"=> 'Details du réseau social  activé',
                "data" => $reseaux_socios
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun réseau social  activé trouvé',
               ]);
           }

       }

       /**
     * afficher tous les réseau social  désactivé
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllDesactive()
    {
        
        if (Reseaux_socios::where(['isActive' => 0, 'isDelete' => 0 ])->exists()) {

            $reseaux_socios = Reseaux_socios::where(['isActive' => 0, 'isDelete' => 0 ])->get();
            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les réseau social  désactivé affichés  avec succès',
                "description"=> 'Details de tous les réseau social  désactivé',
                "data" => $reseaux_socios
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun réseau social  désactivé trouvé',
               ]);
           }



    }


    /**
        * afficher un réseau social  désactivé
        *
        * @return \Illuminate\Http\Response
        */
       public function showOneDesactive($id)
       {
           
           if (Reseaux_socios::where(['id' => $id, 'isActive' => 0, 'isDelete' => 0 ])->exists()) {

            $reseaux_socios = Reseaux_socios::where(['id' => $id, 'isActive' => 0, 'isDelete' => 0 ])->get();

            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Réseau social  désactivé trouvé avec succès',
                "description"=> 'Details du réseau social  désactivé',
                "data" => $reseaux_socios
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun réseau social  désactivé trouvé',
               ]);
           }

       }
        /**
        * supprimer un réseau social 
        *
        * @return \Illuminate\Http\Response
        */
        public function delete($id)
        {
            
            if (Reseaux_socios::where(['id' => $id, 'isDelete' => 0 ])->exists()) {
             $reseaux_socios = Reseaux_socios::where(['id' => $id, 'isDelete' => 0 ])->first();

              // traitement des données 
              $reseaux_socios->update([
                   "isDelete"=> 1
              ]);
             return response()->json([
                 "Status" => 1,
                 "Alert" => 'Réseau social supprimé avec succès',
                ]);
 
 
            }else{
             return response()->json([
                 "Status" => 0,
                 "Alert" => 'Aucun réseau social trouvé',
                ]);
            }
 
 
        }










}

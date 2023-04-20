<?php

namespace App\Http\Controllers\Api;

use App\Models\Params_contact_phone_site;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Params_contact_phone_siteController extends Controller
{
    /**
     * Création de numéro de téléphone pour les contacts à appeler de l'apps
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //validation
        $request->validate([
            'titre' => 'required|max:50|unique:params_contact_phone_sites',
            'numero' => 'required|max:20|unique:params_contact_phone_sites',
        ]);
        $Params_contact_phone_site_count = Params_contact_phone_site::where(['isActive' => 1, 'isDelete' => 0 ])->get()->count();
        // count
 if ($Params_contact_phone_site_count >= 1) {
            // traitement des données
        $params_phone = new Params_contact_phone_site();
        $params_phone->titre = $request->titre;
        $params_phone->numero = $request->numero;
        $params_phone->isNotify_1 = 1;
        $params_phone->isNotify_2 = 1;
        $params_phone->isActive =  0;
        $params_phone->isDelete =  0;
        $params_phone->save();
        // reponse 
        return response()->json([
         "Status" => 1,
         "Alert" => 'Contact téléphone enregistré avec succès',
         "description"=> 'Création de contact téléphone pour la partie nos contacts sur l\'apps '
        ]);
        }else{
              // traitement des données
        $params_phone = new Params_contact_phone_site();
        $params_phone->titre = $request->titre;
        $params_phone->numero = $request->numero;
        $params_phone->isNotify_1 = 1;
        $params_phone->isNotify_2 = 1;
        $params_phone->isActive =  1;
        $params_phone->isDelete =  0;
        $params_phone->save();
        // reponse 
        return response()->json([
         "Status" => 1,
         "Alert" => 'Contact téléphone enregistré avec succès',
         "description"=> 'Création de contact téléphone pour la partie nos contacts sur l\'apps '
        ]);
        }
       
    }
   
     
 /**
     * afficher tous les numéro de téléphone  pour les contacts
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {
        
        if (Params_contact_phone_site::where('isDelete', 0 )->exists()) {

            $params_contact_phone_site = Params_contact_phone_site::where('isDelete', 0)->get();
            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les  numéro de téléphone   affichés  avec succès',
                "description"=> 'Details de tous les  numéro de téléphone ',
                "data" => $params_contact_phone_site
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun numéro de téléphone  trouvé',
               ]);
           }



    }


    /**
        * afficher un numéro de téléphone 
        *
        * @return \Illuminate\Http\Response
        */
       public function showOne($id)
       {
           
           if (Params_contact_phone_site::where(['id' => $id, 'isDelete' => 0 ])->exists()) {

            $params_contact_phone_site = Params_contact_phone_site::where([
                'id' => $id,
                'isDelete' => 0
            ])->get();

            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Numéro de téléphone  trouvé avec succès',
                "description"=> 'Details du numéro de téléphone  ',
                "data" => $params_contact_phone_site
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun numéro de téléphone  trouvé',
               ]);
           }

       }

       /**
        * mise à jour du numéro de téléphone 
        *
        * @return \Illuminate\Http\Response
        */
        public function edite(Request $request ,$id)
        {
            
            if (Params_contact_phone_site::where(['id' => $id, 'isDelete' => 0 ])->exists()) {
                //validation
              $request->validate([
                'titre' => 'required|max:50|unique:params_contact_phone_sites',
            'numero' => 'required|max:20|unique:params_contact_phone_sites',
                  ]);
             $params_contact_phone_site = Params_contact_phone_site::where(['id' => $id, 'isDelete' => 0 ])->first();
            
              // traitement des données 
              $params_contact_phone_site->update([
                   "titre"=> $request->titre,
                   "numero"=> $request->numero
              ]);
             return response()->json([
                 "Status" => 1,
                 "Alert" => 'Numéro de téléphone  mise à jours avec succès',
                ]);
 
 
            }else{
             return response()->json([
                 "Status" => 0,
                 "Alert" => 'Aucun numéro de téléphone  trouvé',
                ]);
            }
 
 
        }

         /**
        * activer un numéro de téléphone 
        *
        * @return \Illuminate\Http\Response
        */
        public function active($id)
        {
            
            if (Params_contact_phone_site::where(['id' => $id, 'isDelete' => 0 ])->exists()) {

                $params_contact_phone_site_count = Params_contact_phone_site::where(['isActive' => 1, 'isDelete' => 0 ])->get()->count();
                if ($params_contact_phone_site_count >= 2) {
                    return response()->json([
                        "Status" => 1,
                        "Alert" => 'Il ne peut avoir plus de deux (02) numéros de téléphone activé . Donc veillez désactiver un numéro de téléphone avant de pouvoir activer ce numéro'
                        
                       ]);
                }else{
                    $params_contact_phone_site = Params_contact_phone_site::where(['id' => $id, 'isDelete' => 0 ])->first();

                    // traitement des données 
                    $params_contact_phone_site->update([
                         "isActive"=> 1
                    ]);
      
                   return response()->json([
                       "Status" => 1,
                       "Alert" => 'Numéro de téléphone  activé avec succès',
                      ]);
                }
 
 
            }else{
             return response()->json([
                 "Status" => 0,
                 "Alert" => 'Aucun numéro de téléphone  trouvé',
                ]);
            }
 
 
        }
         /**
        * désactiver un numéro de téléphone 
        *
        * @return \Illuminate\Http\Response
        */
        public function desactive($id)
        {
            
            if (Params_contact_phone_site::where(['id' => $id, 'isDelete' => 0 ])->exists()) {

                $params_contact_phone_site = Params_contact_phone_site::where(['id' => $id, 'isDelete' => 0 ])->first();

                // traitement des données 
                $params_contact_phone_site->update([
                     "isActive"=> 0
                ]);
  
               return response()->json([
                   "Status" => 1,
                   "Alert" => 'Numéro de téléphone  désactivé avec succès',
                  ]);
 
 
            }else{
             return response()->json([
                 "Status" => 0,
                 "Alert" => 'Aucun numéro de téléphone  trouvé',
                ]);
            }
 
 
        }
        
 /**
     * afficher tous les numéros de téléphone  activé
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllActive()
    {
        
        if (Params_contact_phone_site::where(['isActive' => 1, 'isDelete' => 0 ])->exists()) {

            $params_contact_phone_site = Params_contact_phone_site::where(['isActive' => 1, 'isDelete' => 0 ])->get();
            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les numéros de téléphone  activé affichés  avec succès',
                "description"=> 'Details de tous les numéros de téléphone  activé',
                "data" => $params_contact_phone_site
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun numéro de téléphone  activé trouvé',
               ]);
           }



    }


    /**
        * afficher un numéro de téléphone  activé
        *
        * @return \Illuminate\Http\Response
        */
       public function showOneActive($id)
       {
           
           if (Params_contact_phone_site::where(['id' => $id, 'isActive' => 1, 'isDelete' => 0 ])->exists()) {

            $params_contact_phone_site = Params_contact_phone_site::where(['id' => $id, 'isActive' => 1, 'isDelete' => 0 ])->get();

            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Numéro de téléphone  activé trouvé avec succès',
                "description"=> 'Details du numéro de téléphone  activé',
                "data" => $params_contact_phone_site
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun numéros de téléphone  activé trouvé',
               ]);
           }

       }

       /**
     * afficher tous les numéros de téléphone  désactivé
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllDesactive()
    {
        
        if (Params_contact_phone_site::where(['isActive' => 0, 'isDelete' => 0 ])->exists()) {

            $params_contact_phone_site = Params_contact_phone_site::where(['isActive' => 0, 'isDelete' => 0 ])->get();
            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les numéros de téléphone  désactivé affichés  avec succès',
                "description"=> 'Details de tous les numéros de téléphone  désactivé',
                "data" => $params_contact_phone_site
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun numéro de téléphone  désactivé trouvé',
               ]);
           }



    }


    /**
        * afficher un numéro de téléphone  désactivé
        *
        * @return \Illuminate\Http\Response
        */
       public function showOneDesactive($id)
       {
           
           if (Params_contact_phone_site::where(['id' => $id, 'isActive' => 0, 'isDelete' => 0 ])->exists()) {

            $params_contact_phone_site = Params_contact_phone_site::where(['id' => $id, 'isActive' => 0, 'isDelete' => 0 ])->get();

            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Numéro de téléphone  désactivé trouvé avec succès',
                "description"=> 'Details du numéro de téléphone  désactivé',
                "data" => $params_contact_phone_site
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun numéro de téléphone  désactivé trouvé',
               ]);
           }

       }
        /**
        * supprimer un numéro de téléphone 
        *
        * @return \Illuminate\Http\Response
        */
        public function delete($id)
        {
            
            if (Params_contact_phone_site::where(['id' => $id, 'isDelete' => 0 ])->exists()) {
             $params_contact_phone_site = Params_contact_phone_site::where(['id' => $id, 'isDelete' => 0 ])->first();

              // traitement des données 
              $params_contact_phone_site->update([
                   "isDelete"=> 1
              ]);
             return response()->json([
                 "Status" => 1,
                 "Alert" => 'Numéro de téléphone supprimé avec succès',
                ]);
 
 
            }else{
             return response()->json([
                 "Status" => 0,
                 "Alert" => 'Aucun numéro de téléphone trouvé',
                ]);
            }
 
 
        }



















    
}

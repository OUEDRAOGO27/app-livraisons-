<?php

namespace App\Http\Controllers\Api;

use App\Models\Type_livraison;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Type_livraisonController extends Controller
{
    /**
     * Création de type de livraison 
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //validation
        $request->validate([
            'libelle' => 'required|max:50|unique:Type_livraisons'
        ]);
        // traitement des données
        $type_livraison = new Type_livraison();
        $type_livraison->libelle = $request->libelle;
        $type_livraison->isActive =  0;
        $type_livraison->isDelete =  0;
        $type_livraison->save();
        // reponse 
        return response()->json([
         "Status" => 1,
         "Alert" => 'Type livraison enregistré avec succès',
         "description"=> 'Création de type de livraison pour la partie nos contacts sur l\'apps '
        ]);
    }
   
     
 /**
     * afficher tous les type de livraison  pour les contacts
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {
        
        if (Type_livraison::where('isDelete', 0 )->exists()) {

            $type_livraison = Type_livraison::where('isDelete', 0)->get();
            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les  type de livraison   affichés  avec succès',
                "description"=> 'Details de tous les  type de livraison ',
                "data" => $type_livraison
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun type de livraison  trouvé',
               ]);
           }



    }


    /**
        * afficher un type de livraison 
        *
        * @return \Illuminate\Http\Response
        */
       public function showOne($id)
       {
           
           if (Type_livraison::where(['id' => $id, 'isDelete' => 0 ])->exists()) {

            $type_livraison = Type_livraison::where([
                'id' => $id,
                'isDelete' => 0
            ])->get();

            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Type de livraison  trouvé avec succès',
                "description"=> 'Details du type de livraison  ',
                "data" => $type_livraison
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun type de livraison  trouvé',
               ]);
           }

       }

       /**
        * mise à jour du type de livraison 
        *
        * @return \Illuminate\Http\Response
        */
        public function edite(Request $request ,$id)
        {
            
            if (Type_livraison::where(['id' => $id, 'isDelete' => 0 ])->exists()) {
                //validation
              $request->validate([
                'libelle' => 'required|max:50|unique:Type_livraisons'
                  ]);
             $type_livraison = Type_livraison::where(['id' => $id, 'isDelete' => 0 ])->first();
            
              // traitement des données 
              $type_livraison->update([
                   "libelle"=> $request->libelle
              ]);
             return response()->json([
                 "Status" => 1,
                 "Alert" => 'Type de livraison  mise à jours avec succès',
                ]);
 
 
            }else{
             return response()->json([
                 "Status" => 0,
                 "Alert" => 'Aucun type de livraison  trouvé',
                ]);
            }
 
 
        }

         /**
        * activer un type de livraison 
        *
        * @return \Illuminate\Http\Response
        */
        public function active($id)
        {
            
            if (Type_livraison::where(['id' => $id, 'isDelete' => 0 ])->exists()) {

                $type_livraison_count = Type_livraison::where(['isActive' => 1, 'isDelete' => 0 ])->get()->count();
                if ($type_livraison_count >= 2) {
                    return response()->json([
                        "Status" => 1,
                        "Alert" => 'Il ne peut avoir plus de deux (02) type de livraison activé . Donc veillez désactiver un type de livraison avant de pouvoir activer ce numéro'
                        
                       ]);
                }else{
                    $Type_livraison = Type_livraison::where(['id' => $id, 'isDelete' => 0 ])->first();

                    // traitement des données 
                    $Type_livraison->update([
                         "isActive"=> 1
                    ]);
      
                   return response()->json([
                       "Status" => 1,
                       "Alert" => 'Type de livraison  activé avec succès',
                      ]);
                }
 
 
            }else{
             return response()->json([
                 "Status" => 0,
                 "Alert" => 'Aucun type de livraison  trouvé',
                ]);
            }
 
 
        }
         /**
        * désactiver un type de livraison 
        *
        * @return \Illuminate\Http\Response
        */
        public function desactive($id)
        {
            
            if (Type_livraison::where(['id' => $id, 'isDelete' => 0 ])->exists()) {

                $type_livraison = Type_livraison::where(['id' => $id, 'isDelete' => 0 ])->first();

                // traitement des données 
                $type_livraison->update([
                     "isActive"=> 0
                ]);
  
               return response()->json([
                   "Status" => 1,
                   "Alert" => 'Type de livraison  désactivé avec succès',
                  ]);
 
 
            }else{
             return response()->json([
                 "Status" => 0,
                 "Alert" => 'Aucun type de livraison  trouvé',
                ]);
            }
 
 
        }
        
 /**
     * afficher tous les type de livraison  activé
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllActive()
    {
        
        if (Type_livraison::where(['isActive' => 1, 'isDelete' => 0 ])->exists()) {

            $type_livraison = Type_livraison::where(['isActive' => 1, 'isDelete' => 0 ])->get();
            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les types de livraison  activé affichés  avec succès',
                "description"=> 'Details de tous les type de livraison  activé',
                "data" => $type_livraison
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun type de livraison  activé trouvé',
               ]);
           }



    }


    /**
        * afficher un type de livraison  activé
        *
        * @return \Illuminate\Http\Response
        */
       public function showOneActive($id)
       {
           
           if (Type_livraison::where(['id' => $id, 'isActive' => 1, 'isDelete' => 0 ])->exists()) {

            $type_livraison = Type_livraison::where(['id' => $id, 'isActive' => 1, 'isDelete' => 0 ])->get();

            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Type de livraison  activé trouvé avec succès',
                "description"=> 'Details du type de livraison  activé',
                "data" => $type_livraison
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun type de livraison  activé trouvé',
               ]);
           }

       }

       /**
     * afficher tous les type de livraison  désactivé
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllDesactive()
    {
        
        if (Type_livraison::where(['isActive' => 0, 'isDelete' => 0 ])->exists()) {

            $type_livraison = Type_livraison::where(['isActive' => 0, 'isDelete' => 0 ])->get();
            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les type de livraison  désactivé affichés  avec succès',
                "description"=> 'Details de tous les type de livraison  désactivé',
                "data" => $type_livraison
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun type de livraison  désactivé trouvé',
               ]);
           }



    }


    /**
        * afficher un type de livraison  désactivé
        *
        * @return \Illuminate\Http\Response
        */
       public function showOneDesactive($id)
       {
           
           if (Type_livraison::where(['id' => $id, 'isActive' => 0, 'isDelete' => 0 ])->exists()) {

            $type_livraison = Type_livraison::where(['id' => $id, 'isActive' => 0, 'isDelete' => 0 ])->get();

            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Type de livraison  désactivé trouvé avec succès',
                "description"=> 'Details du type de livraison  désactivé',
                "data" => $type_livraison
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun type de livraison  désactivé trouvé',
               ]);
           }

       }
        /**
        * supprimer un type de livraison 
        *
        * @return \Illuminate\Http\Response
        */
        public function delete($id)
        {
            
            if (Type_livraison::where(['id' => $id, 'isDelete' => 0 ])->exists()) {
             $type_livraison = Type_livraison::where(['id' => $id, 'isDelete' => 0 ])->first();

              // traitement des données 
              $type_livraison->update([
                   "isDelete"=> 1
              ]);
             return response()->json([
                 "Status" => 1,
                 "Alert" => 'Type de livraison supprimé avec succès',
                ]);
 
 
            }else{
             return response()->json([
                 "Status" => 0,
                 "Alert" => 'Aucun type de livraison trouvé',
                ]);
            }
 
 
        }





}

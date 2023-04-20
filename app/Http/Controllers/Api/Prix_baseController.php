<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prix_base;
use Illuminate\Http\Request;

class Prix_baseController extends Controller
{
    /**
     * Création du prix de base 
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //validation
        $request->validate([
            'prix' => 'required|digitsbetween:1,4|unique:prix_bases',
        ]);
        $Prix_base_count = Prix_base::where(['isActive' => 1, 'isDelete' => 0 ])->get()->count();
        // count
 if ($Prix_base_count >= 1) {
            // traitement des données
        $params_prix_base = new Prix_base();
        $params_prix_base->prix = $request->prix;
        $params_prix_base->isNotify_1 = 1;
        $params_prix_base->isNotify_2 = 1;
        $params_prix_base->isActive =  0;
        $params_prix_base->isDelete =  0;
        $params_prix_base->save();
        // reponse 
        return response()->json([
         "Status" => 1,
         "Alert" => 'Prix de base  enregistré avec succès',
         "description"=> 'Création du prix de base pour les opérations dans l\'app '
        ]);
        }else{
             // traitement des données
        $params_prix_base = new Prix_base();
        $params_prix_base->prix = $request->prix;
        $params_prix_base->isNotify_1 = 1;
        $params_prix_base->isNotify_2 = 1;
        $params_prix_base->isActive =  1;
        $params_prix_base->isDelete =  0;
        $params_prix_base->save();
        // reponse 
        return response()->json([
         "Status" => 1,
         "Alert" => 'Prix de base  enregistré avec succès',
         "description"=> 'Création du prix de base pour les opérations dans l\'app '
        ]); 
        }
       
    }


 /**
     * afficher tous les prix de base 
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {
        
        if (Prix_base::where('isDelete', 0 )->exists()) {

            $prix_base = Prix_base::where('isDelete', 0)->get();
            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les prix de base  affichés  avec succès',
                "description"=> 'Details de tous les prix de base',
                "data" => $prix_base
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun prix de base trouvé',
               ]);
           }



    }


    /**
        * afficher un prix de base 
        *
        * @return \Illuminate\Http\Response
        */
       public function showOne($id)
       {
           
           if (Prix_base::where(['id' => $id, 'isDelete' => 0 ])->exists()) {

            $prix_base = Prix_base::where([
                'id' => $id,
                'isDelete' => 0
            ])->get();

            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Prix de base trouvé avec succès',
                "description"=> 'Details du prix de base',
                "data" => $prix_base
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun prix de base trouvé',
               ]);
           }

       }

       /**
        * mise à jour du prix de base 
        *
        * @return \Illuminate\Http\Response
        */
        public function edite(Request $request ,$id)
        {
            
            if (Prix_base::where(['id' => $id, 'isDelete' => 0 ])->exists()) {
                //validation
              $request->validate([
                'prix' => 'required|digitsbetween:1,4|unique:prix_bases',
                  ]);
             $prix_base = Prix_base::where(['id' => $id, 'isDelete' => 0 ])->first();
            
              // traitement des données 
              $prix_base->update([
                   "prix"=> $request->prix
              ]);
             return response()->json([
                 "Status" => 1,
                 "Alert" => 'Prix de base mise à jours avec succès',
                ]);
 
 
            }else{
             return response()->json([
                 "Status" => 0,
                 "Alert" => 'Aucun prix de base trouvé',
                ]);
            }
 
 
        }

         /**
        * activer un prix de base 
        *
        * @return \Illuminate\Http\Response
        */
        public function active($id)
        {
            
            if (Prix_base::where(['id' => $id, 'isDelete' => 0 ])->exists()) {

                $tous_prix_base = Prix_base::where('isDelete', 0 );
                 // traitement 1 des données 
                 $tous_prix_base->update([
                "isActive"=> 0
           ]);


             $prix_base = Prix_base::where(['id' => $id, 'isDelete' => 0 ])->first();

              // traitement des données 
              $prix_base->update([
                   "isActive"=> 1
              ]);

             return response()->json([
                 "Status" => 1,
                 "Alert" => 'Prix de base activé avec succès',
                ]);
 
 
            }else{
             return response()->json([
                 "Status" => 0,
                 "Alert" => 'Aucun prix de base trouvé',
                ]);
            }
 
 
        }
        
 /**
     * afficher tous les prix de base activé
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllActive()
    {
        
        if (Prix_base::where(['isActive' => 1, 'isDelete' => 0 ])->exists()) {

            $prix_base = Prix_base::where(['isActive' => 1, 'isDelete' => 0 ])->get();
            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les prix de base activé affichés  avec succès',
                "description"=> 'Details de tous les prix de base activé',
                "data" => $prix_base
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun prix de base activé trouvé',
               ]);
           }



    }


    /**
        * afficher un prix de base activé
        *
        * @return \Illuminate\Http\Response
        */
       public function showOneActive($id)
       {
           
           if (Prix_base::where(['id' => $id, 'isActive' => 1, 'isDelete' => 0 ])->exists()) {

            $prix_base = Prix_base::where(['id' => $id, 'isActive' => 1, 'isDelete' => 0 ])->get();

            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Prix de base activé trouvé avec succès',
                "description"=> 'Details du prix de base activé',
                "data" => $prix_base
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun prix de base activé trouvé',
               ]);
           }

       }

       /**
     * afficher tous les prix de base désactivé
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllDesactive()
    {
        
        if (Prix_base::where(['isActive' => 0, 'isDelete' => 0 ])->exists()) {

            $prix_base = Prix_base::where(['isActive' => 0, 'isDelete' => 0 ])->get();
            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les prix de base désactivé affichés  avec succès',
                "description"=> 'Details de tous les prix de base désactivé',
                "data" => $prix_base
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun prix de base désactivé trouvé',
               ]);
           }



    }


    /**
        * afficher un prix de base désactivé
        *
        * @return \Illuminate\Http\Response
        */
       public function showOneDesactive($id)
       {
           
           if (Prix_base::where(['id' => $id, 'isActive' => 0, 'isDelete' => 0 ])->exists()) {

            $prix_base = Prix_base::where(['id' => $id, 'isActive' => 0, 'isDelete' => 0 ])->get();

            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Prix de base désactivé trouvé avec succès',
                "description"=> 'Details du prix de base désactivé',
                "data" => $prix_base
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun prix de base désactivé trouvé',
               ]);
           }

       }
        /**
        * supprimer un prix de base 
        *
        * @return \Illuminate\Http\Response
        */
        public function delete($id)
        {
            
            if (Prix_base::where(['id' => $id, 'isDelete' => 0 ])->exists()) {
             $prix_base = Prix_base::where(['id' => $id, 'isDelete' => 0 ])->first();

              // traitement des données 
              $prix_base->update([
                   "isDelete"=> 1
              ]);
             return response()->json([
                 "Status" => 1,
                 "Alert" => 'Prix de base supprimé avec succès',
                ]);
 
 
            }else{
             return response()->json([
                 "Status" => 0,
                 "Alert" => 'Aucun prix de base trouvé',
                ]);
            }
 
 
        }














}
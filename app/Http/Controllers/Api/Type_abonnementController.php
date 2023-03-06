<?php

namespace App\Http\Controllers\Api;

use App\Models\Type_abonnement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Type_abonnementController extends Controller
{
/**
    * Création de type abonnement 
    *
    * @return \Illuminate\Http\Response
    */
   public function create(Request $request)
   {
       //validation
       $request->validate([
           'libelle' => 'required|max:50|unique:Type_abonnements',
           'nbr_jours' => 'required|digitsbetween:1,4',
           'tarif' => 'required|digitsbetween:1,5',
           'titre_plan' => 'required|max:20|unique:Type_abonnements',
           'description_plan' => 'required|max:5000',
           'avantage_plan' => 'required'
       ]);
       // traitement des données
       $type_abonnement = new Type_abonnement();
       $type_abonnement->libelle = $request->libelle;
       $type_abonnement->nbr_jours = $request->nbr_jours;
       $type_abonnement->tarif = $request->tarif;
       $type_abonnement->titre_plan = $request->titre_plan;
       $type_abonnement->description_plan = $request->description_plan;
       $type_abonnement->avantage_plan = $request->avantage_plan;
       $type_abonnement->isActive =  0;
       $type_abonnement->isDelete =  0;
       $type_abonnement->save();
       // reponse 
       return response()->json([
        "Status" => 1,
        "Alert" => 'Types abonnement enregistré avec succès',
        "description"=> 'Création de types abonnement pour la partie nos contacts sur l\'apps '
       ]);
   }
  
    
/**
    * afficher tous les type abonnement  pour les contacts
    *
    * @return \Illuminate\Http\Response
    */
   public function showAll()
   {
       
       if (Type_abonnement::where('isDelete', 0 )->exists()) {

           $Type_abonnement = Type_abonnement::where('isDelete', 0)->get();
           // reponse 
           return response()->json([
               "Status" => 1,
               "Alert" => 'Tous les  type abonnement   affichés  avec succès',
               "description"=> 'Details de tous les  type abonnement ',
               "data" => $Type_abonnement
              ]);


          }else{
           // reponse 
           return response()->json([
               "Status" => 0,
               "Alert" => 'Aucun type abonnement  trouvé',
              ]);
          }



   }


   /**
       * afficher un type abonnement 
       *
       * @return \Illuminate\Http\Response
       */
      public function showOne($id)
      {
          
          if (Type_abonnement::where(['id' => $id, 'isDelete' => 0 ])->exists()) {

           $type_abonnement = Type_abonnement::where([
               'id' => $id,
               'isDelete' => 0
           ])->get();

           // reponse 
           return response()->json([
               "Status" => 1,
               "Alert" => 'type abonnement  trouvé avec succès',
               "description"=> 'Details du type abonnement  ',
               "data" => $type_abonnement
              ]);


          }else{
           // reponse 
           return response()->json([
               "Status" => 0,
               "Alert" => 'Aucun type abonnement  trouvé',
              ]);
          }

      }

      /**
       * mise à jour du type abonnement 
       *
       * @return \Illuminate\Http\Response
       */
       public function edite(Request $request ,$id)
       {
           
           if (Type_abonnement::where(['id' => $id, 'isDelete' => 0 ])->exists()) {
               //validation
             $request->validate([
                'libelle' => 'required|max:50|unique:Type_abonnements',
                'nbr_jours' => 'required|digitsbetween:1,4',
                'tarif' => 'required|digitsbetween:1,5',
                'titre_plan' => 'required|max:20|unique:Type_abonnements',
                'description_plan' => 'required|max:5000',
                'avantage_plan' => 'required',
                 ]);
            $type_abonnement = Type_abonnement::where(['id' => $id, 'isDelete' => 0 ])->first();
           
             // traitement des données 
             $type_abonnement->update([
                  "libelle"=> $request->libelle,
                  "nbr_jours"=> $request->nbr_jours,
                  "tarif"=> $request->tarif,
                  "titre_plan"=> $request->titre_plan,
                  "description_plan"=> $request->description_plan,
                  "avantage_plan"=> $request->avantage_plan
             ]);
            return response()->json([
                "Status" => 1,
                "Alert" => 'type abonnement  mise à jours avec succès',
               ]);


           }else{
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun type abonnement  trouvé',
               ]);
           }


       }

        /**
       * activer un type abonnement 
       *
       * @return \Illuminate\Http\Response
       */
       public function active($id)
       {
           
           if (Type_abonnement::where(['id' => $id, 'isDelete' => 0 ])->exists()) {

               $type_abonnement_count = Type_abonnement::where(['isActive' => 1, 'isDelete' => 0 ])->get()->count();
               if ($type_abonnement_count >= 2) {
                   return response()->json([
                       "Status" => 1,
                       "Alert" => 'Il ne peut avoir plus de deux (02) numéros de téléphone activé . Donc veillez désactiver un type abonnement avant de pouvoir activer ce numéro'
                       
                      ]);
               }else{
                   $type_abonnement = Type_abonnement::where(['id' => $id, 'isDelete' => 0 ])->first();

                   // traitement des données 
                   $type_abonnement->update([
                        "isActive"=> 1
                   ]);
     
                  return response()->json([
                      "Status" => 1,
                      "Alert" => 'type abonnement  activé avec succès',
                     ]);
               }


           }else{
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun type abonnement  trouvé',
               ]);
           }


       }
        /**
       * désactiver un type abonnement 
       *
       * @return \Illuminate\Http\Response
       */
       public function desactive($id)
       {
           
           if (Type_abonnement::where(['id' => $id, 'isDelete' => 0 ])->exists()) {

               $type_abonnement = Type_abonnement::where(['id' => $id, 'isDelete' => 0 ])->first();

               // traitement des données 
               $type_abonnement->update([
                    "isActive"=> 0
               ]);
 
              return response()->json([
                  "Status" => 1,
                  "Alert" => 'type abonnement  désactivé avec succès',
                 ]);


           }else{
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun type abonnement  trouvé',
               ]);
           }


       }
       
/**
    * afficher tous les types abonnement  activé
    *
    * @return \Illuminate\Http\Response
    */
   public function showAllActive()
   {
       
       if (Type_abonnement::where(['isActive' => 1, 'isDelete' => 0 ])->exists()) {

           $type_abonnement = Type_abonnement::where(['isActive' => 1, 'isDelete' => 0 ])->get();
           // reponse 
           return response()->json([
               "Status" => 1,
               "Alert" => 'Tous les types abonnement  activé affichés  avec succès',
               "description"=> 'Details de tous les types abonnement  activé',
               "data" => $type_abonnement
              ]);


          }else{
           // reponse 
           return response()->json([
               "Status" => 0,
               "Alert" => 'Aucun type abonnement  activé trouvé',
              ]);
          }



   }


   /**
       * afficher un type abonnement  activé
       *
       * @return \Illuminate\Http\Response
       */
      public function showOneActive($id)
      {
          
          if (Type_abonnement::where(['id' => $id, 'isActive' => 1, 'isDelete' => 0 ])->exists()) {

           $type_abonnement = Type_abonnement::where(['id' => $id, 'isActive' => 1, 'isDelete' => 0 ])->get();

           // reponse 
           return response()->json([
               "Status" => 1,
               "Alert" => 'type abonnement  activé trouvé avec succès',
               "description"=> 'Details du type abonnement  activé',
               "data" => $type_abonnement
              ]);


          }else{
           // reponse 
           return response()->json([
               "Status" => 0,
               "Alert" => 'Aucun types abonnement  activé trouvé',
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
       
       if (Type_abonnement::where(['isActive' => 0, 'isDelete' => 0 ])->exists()) {

           $type_abonnement = Type_abonnement::where(['isActive' => 0, 'isDelete' => 0 ])->get();
           // reponse 
           return response()->json([
               "Status" => 1,
               "Alert" => 'Tous les types abonnement  désactivé affichés  avec succès',
               "description"=> 'Details de tous les types abonnement  désactivé',
               "data" => $type_abonnement
              ]);


          }else{
           // reponse 
           return response()->json([
               "Status" => 0,
               "Alert" => 'Aucun type abonnement  désactivé trouvé',
              ]);
          }



   }


   /**
       * afficher un type abonnement  désactivé
       *
       * @return \Illuminate\Http\Response
       */
      public function showOneDesactive($id)
      {
          
          if (Type_abonnement::where(['id' => $id, 'isActive' => 0, 'isDelete' => 0 ])->exists()) {

           $type_abonnement = Type_abonnement::where(['id' => $id, 'isActive' => 0, 'isDelete' => 0 ])->get();

           // reponse 
           return response()->json([
               "Status" => 1,
               "Alert" => 'Type abonnement  désactivé trouvé avec succès',
               "description"=> 'Details du type abonnement  désactivé',
               "data" => $type_abonnement
              ]);


          }else{
           // reponse 
           return response()->json([
               "Status" => 0,
               "Alert" => 'Aucun type abonnement  désactivé trouvé',
              ]);
          }

      }
       /**
       * supprimer un type abonnement 
       *
       * @return \Illuminate\Http\Response
       */
       public function delete($id)
       {
           
           if (Type_abonnement::where(['id' => $id, 'isDelete' => 0 ])->exists()) {
            $type_abonnement = Type_abonnement::where(['id' => $id, 'isDelete' => 0 ])->first();

             // traitement des données 
             $type_abonnement->update([
                  "isDelete"=> 1
             ]);
            return response()->json([
                "Status" => 1,
                "Alert" => 'type abonnement supprimé avec succès',
               ]);


           }else{
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun type abonnement trouvé',
               ]);
           }


       }





}

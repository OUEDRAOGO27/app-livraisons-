<?php

namespace App\Http\Controllers\Api;

use App\Models\Params_contact_mail_site;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Params_contact_mail_siteController extends Controller
{
    /**
     * Création de mail pour les contacts à appeler de l'apps
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //validation
        $request->validate([
            'titre' => 'required|max:50|unique:params_contact_mail_sites',
            'mail' => 'required|email|unique:params_contact_mail_sites',
        ]);
        $Params_contact_mail_site_count = Params_contact_mail_site::where(['isActive' => 1, 'isDelete' => 0 ])->get()->count();
        // count
 if ($Params_contact_mail_site_count >= 1) {
            // traitement des données
        $params_mail = new Params_contact_mail_site();
        $params_mail->titre = $request->titre;
        $params_mail->mail = $request->mail;
        $params_mail->isNotify_1 = 1;
        $params_mail->isNotify_2 = 1;
        $params_mail->isActive =  0;
        $params_mail->isDelete =  0;
        $params_mail->save();
        // reponse 
        return response()->json([
         "Status" => 1,
         "Alert" => 'Contact email enregistré avec succès',
         "description"=> 'Création de contact email pour la partie nos contacts sur l\'apps '
        ]);
        }else{
             // traitement des données
        $params_mail = new Params_contact_mail_site();
        $params_mail->titre = $request->titre;
        $params_mail->mail = $request->mail;
        $params_mail->isNotify_1 = 1;
        $params_mail->isNotify_2 = 1;
        $params_mail->isActive =  1;
        $params_mail->isDelete =  0;
        $params_mail->save();
        // reponse 
        return response()->json([
         "Status" => 1,
         "Alert" => 'Contact email enregistré avec succès',
         "description"=> 'Création de contact email pour la partie nos contacts sur l\'apps '
        ]); 
        }
       
    }
   

    
 /**
     * afficher tous les emails pour les contacts
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {
        
        if (Params_contact_mail_site::where('isDelete', 0 )->exists()) {

            $params_contact_mail_site = Params_contact_mail_site::where('isDelete', 0)->get();
            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les  emails  affichés  avec succès',
                "description"=> 'Details de tous les  emails',
                "data" => $params_contact_mail_site
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun email trouvé',
               ]);
           }



    }


    /**
        * afficher un email 
        *
        * @return \Illuminate\Http\Response
        */
       public function showOne($id)
       {
           
           if (Params_contact_mail_site::where(['id' => $id, 'isDelete' => 0 ])->exists()) {

            $params_contact_mail_site = Params_contact_mail_site::where([
                'id' => $id,
                'isDelete' => 0
            ])->get();

            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Emails trouvé avec succès',
                "description"=> 'Details de l\'emails ',
                "data" => $params_contact_mail_site
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun email trouvé',
               ]);
           }

       }

       /**
        * mise à jour de l'emails
        *
        * @return \Illuminate\Http\Response
        */
        public function edite(Request $request ,$id)
        {
            
            if (Params_contact_mail_site::where(['id' => $id, 'isDelete' => 0 ])->exists()) {
                //validation
              $request->validate([
                'titre' => 'required|max:50|unique:params_contact_mail_sites',
                'mail' => 'required|email|unique:params_contact_mail_sites',
                  ]);
             $params_contact_mail_site = Params_contact_mail_site::where(['id' => $id, 'isDelete' => 0 ])->first();
            
              // traitement des données 
              $params_contact_mail_site->update([
                   "titre"=> $request->titre,
                   "mail"=> $request->mail
              ]);
             return response()->json([
                 "Status" => 1,
                 "Alert" => 'Emails mise à jours avec succès',
                ]);
 
 
            }else{
             return response()->json([
                 "Status" => 0,
                 "Alert" => 'Aucun email trouvé',
                ]);
            }
 
 
        }

         /**
        * activer un email 
        *
        * @return \Illuminate\Http\Response
        */
        public function active($id)
        {
            
            if (Params_contact_mail_site::where(['id' => $id, 'isDelete' => 0 ])->exists()) {

                $params_contact_mail_site_count = Params_contact_mail_site::where(['isActive' => 1, 'isDelete' => 0 ])->get()->count();
                if ($params_contact_mail_site_count >= 2) {
                    return response()->json([
                        "Status" => 1,
                        "Alert" => 'Il ne peut avoir plus de deux (02) numéros de téléphone activé . Donc veillez désactiver un numéro de téléphone avant de pouvoir activer ce numéro'
                        
                       ]);
                }else{
                    $params_contact_mail_site = Params_contact_mail_site::where(['id' => $id, 'isDelete' => 0 ])->first();

                    // traitement des données 
                    $params_contact_mail_site->update([
                         "isActive"=> 1
                    ]);
      
                   return response()->json([
                       "Status" => 1,
                       "Alert" => 'Email  activé avec succès',
                      ]);
                }
 
 
            }else{
             return response()->json([
                 "Status" => 0,
                 "Alert" => 'Aucun email  trouvé',
                ]);
            }
 
 
        }
        
 /**
     * afficher tous les emails activé
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllActive()
    {
        
        if (Params_contact_mail_site::where(['isActive' => 1, 'isDelete' => 0 ])->exists()) {

            $params_contact_mail_site = Params_contact_mail_site::where(['isActive' => 1, 'isDelete' => 0 ])->get();
            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les emails activé affichés  avec succès',
                "description"=> 'Details de tous les emails activé',
                "data" => $params_contact_mail_site
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun email activé trouvé',
               ]);
           }



    }

 /**
        * désactiver un emails
        *
        * @return \Illuminate\Http\Response
        */
        public function desactive($id)
        {
            
            if (Params_contact_mail_site::where(['id' => $id, 'isDelete' => 0 ])->exists()) {

                $params_contact_mail_site = Params_contact_mail_site::where(['id' => $id, 'isDelete' => 0 ])->first();

                // traitement des données 
                $params_contact_mail_site->update([
                     "isActive"=> 0
                ]);
  
               return response()->json([
                   "Status" => 1,
                   "Alert" => 'Emails désactivé avec succès',
                  ]);
 
 
            }else{
             return response()->json([
                 "Status" => 0,
                 "Alert" => 'Aucun emails  trouvé',
                ]);
            }
 
 
        }
    /**
        * afficher un email activé
        *
        * @return \Illuminate\Http\Response
        */
       public function showOneActive($id)
       {
           
           if (Params_contact_mail_site::where(['id' => $id, 'isActive' => 1, 'isDelete' => 0 ])->exists()) {

            $params_contact_mail_site = Params_contact_mail_site::where(['id' => $id, 'isActive' => 1, 'isDelete' => 0 ])->get();

            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Emails activé trouvé avec succès',
                "description"=> 'Details de l\'email activé',
                "data" => $params_contact_mail_site
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun email activé trouvé',
               ]);
           }

       }

       /**
     * afficher tous les emails désactivé
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllDesactive()
    {
        
        if (Params_contact_mail_site::where(['isActive' => 0, 'isDelete' => 0 ])->exists()) {

            $params_contact_mail_site = Params_contact_mail_site::where(['isActive' => 0, 'isDelete' => 0 ])->get();
            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les emails désactivé affichés  avec succès',
                "description"=> 'Details de tous les emails désactivé',
                "data" => $params_contact_mail_site
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun email désactivé trouvé',
               ]);
           }



    }


    /**
        * afficher un email désactivé
        *
        * @return \Illuminate\Http\Response
        */
       public function showOneDesactive($id)
       {
           
           if (Params_contact_mail_site::where(['id' => $id, 'isActive' => 0, 'isDelete' => 0 ])->exists()) {

            $params_contact_mail_site = Params_contact_mail_site::where(['id' => $id, 'isActive' => 0, 'isDelete' => 0 ])->get();

            // reponse 
            return response()->json([
                "Status" => 1,
                "Alert" => 'Email désactivé trouvé avec succès',
                "description"=> 'Details de l\'email désactivé',
                "data" => $params_contact_mail_site
               ]);


           }else{
            // reponse 
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun emails désactivé trouvé',
               ]);
           }

       }
        /**
        * supprimer un email 
        *
        * @return \Illuminate\Http\Response
        */
        public function delete($id)
        {
            
            if (Params_contact_mail_site::where(['id' => $id, 'isDelete' => 0 ])->exists()) {
             $params_contact_mail_site = Params_contact_mail_site::where(['id' => $id, 'isDelete' => 0 ])->first();

              // traitement des données 
              $params_contact_mail_site->update([
                   "isDelete"=> 1
              ]);
             return response()->json([
                 "Status" => 1,
                 "Alert" => 'Email supprimé avec succès',
                ]);
 
 
            }else{
             return response()->json([
                 "Status" => 0,
                 "Alert" => 'Aucun email trouvé',
                ]);
            }
 
 
        }



































    
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Abonnement;
use App\Models\Expiration_abonnement;
use App\Models\Paiement;

//use Illuminate\Http\Request;

class Expiration_abonnementController extends Controller
{
    /**
     * Création d\'Expiration abonnement
     *
     * @return \Illuminate\Http\Response
     */
    public function verifiExpirationAbonnement($id)
    {
       
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
        
       
    }

















}

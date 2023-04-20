<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prix_base;
use Illuminate\Http\Request;

class CalculController extends Controller
{
    /**
     * afficher tous les Demande_livraison  pour les contacts
     *
     * @return \Illuminate\Http\Response
     */

     public function tarifsClient()
     {
 
         if (Prix_base::where(['isActive' => 1, 'isDelete' => 0])->exists()) {
 
             $prix_base = Prix_base::where(['isActive' => 1, 'isDelete' => 0])->first();
            $prixbase = $prix_base->prix;
          $distance = $this->getDistanceFromLatLonInKm(6.355327, 2.405325, 6.367806, 2.419478);
            // $totalprix = round($prix *  $distance );
             /* le prix au kilometre egal 350 fcfa */
            $prix_Kilom = 350 ;
if($distance <= 1){
   
    $totalprix =  $prix_Kilom;//round(100 *  $distance )
 // reponse
 return response()->json([
    "Status" => 1,
    "Alert" => 'Tous les tarifs    affichés  avec succès',
    "description" => 'Details de tous les   tarifs  ',
    "data" => $totalprix,
]);

}else{
    
    $distance_2  = $distance - 1;
    $totalprix = round($distance_2 * $prixbase + $prix_Kilom) ;
 // reponse
 return response()->json([
    "Status" => 1,
    "Alert" => 'Tous les tarifs    affichés  avec succès',
    "description" => 'Details de tous les   tarifs  ',
    "data" => $totalprix,
    "devise" => "XOF",
]);

}



            
 
         } else {
             // reponse
             return response()->json([
                 "Status" => 0,
                 "Alert" => 'Aucun tarifs activé ou trouvé',
             ]);
         }
 
     }

      /**
     * get Distance From Lat Lon In Km
     *
     * @return \Illuminate\Http\Response
     */

     public function  getDistanceFromLatLonInKm($lat1, $lon1, $lat2, $lon2)
     {
 
        $R = 6371; 
        $dLat = deg2rad($lat2-$lat1); 
        $dLon = deg2rad($lon2-$lon1);  
        $a =  
        sin($dLat/2) * sin($dLat/2) + 
        cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *  
        sin($dLon/2) * sin($dLon/2) 
        ;  
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));  
        $d = $R * $c; // Distance en km 
        return round($d,2); 
     }    



}

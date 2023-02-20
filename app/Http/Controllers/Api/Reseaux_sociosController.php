<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reseaux_socios;
use Illuminate\Http\Request;

class Reseaux_sociosController extends Controller
{
    /**
     * Création de réseau social
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //validation
        $request->validate([
            'titre' => 'required|max:50|unique:reseaux_socios',
            'logo' => 'required|',
            'lien_url' => 'required|active_url|unique:reseaux_socios',
        ]);
        // traitement des données
        $params_Reseaux_socios = new Reseaux_socios();
        $params_Reseaux_socios->titre = $request->titre;
        $params_Reseaux_socios->logo = $request->logo;
        $params_Reseaux_socios->lien_url = $request->lien_url;
        $params_Reseaux_socios->isActive =  0;
        $params_Reseaux_socios->isDelete =  0;
        $params_Reseaux_socios->save();
        // reponse 
        return response()->json([
         "Status" => 1,
         "Alert" => 'Contact réseau social enregistré avec succès',
         "description"=> 'Création de  réseau social pour la partie nos réseaux socios sur l\'apps '
        ]);
    }
}

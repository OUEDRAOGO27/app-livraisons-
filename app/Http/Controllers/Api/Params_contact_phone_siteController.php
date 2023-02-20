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
        // traitement des données
        $params_phone = new Params_contact_phone_site();
        $params_phone->titre = $request->titre;
        $params_phone->numero = $request->numero;
        $params_phone->isActive =  0;
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

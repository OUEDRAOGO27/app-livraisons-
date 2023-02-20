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
        // traitement des données
        $params_prix_base = new Prix_base();
        $params_prix_base->prix = $request->prix;
        $params_prix_base->isActive =  0;
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

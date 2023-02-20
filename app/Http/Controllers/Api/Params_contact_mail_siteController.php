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
        // traitement des données
        $params_mail = new Params_contact_mail_site();
        $params_mail->titre = $request->titre;
        $params_mail->mail = $request->mail;
        $params_mail->isActive =  0;
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

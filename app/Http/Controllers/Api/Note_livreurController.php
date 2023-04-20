<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note_livreur;
use Illuminate\Http\Request;

class Note_livreurController extends Controller
{
    
     /**
     * Création de Notes du livreur pour les contacts à appeler de l'apps
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //validation
        $request->validate([
        'id_liv'  => 'required|integer',
        'id_client' => 'required|integer',
        'notes' => 'required|integer'
        ]);

        $Note_livreur_site_count1 = Note_livreur::where(['id_liv' => $request->id_liv, 'id_client' => $request->id_client, 'isActive' => 1,  'isDelete' => 0 ])->get()->count();
        // count
 if ($Note_livreur_site_count1 < 1) {


        $Note_livreur_site_count2 = Note_livreur::where(['id_liv' => $request->id_liv,  'isActive' => 1,  'isDelete' => 0 ])->get()->count();
        // count
 if ($Note_livreur_site_count2 > 0) {
    
         //  traitement des données 1 Note_livreur
         $Note_livreur = new Note_livreur();
         $Note_livreur->id_liv = $request->id_liv;
         $Note_livreur->id_client = $request->id_client;
         $Note_livreur->notes = $request->notes;
         $Note_livreur->commentaire = isset($request->commentaire)? $request->commentaire :   '';
         $Note_livreur->isNotify_1 = 1;
         $Note_livreur->isNotify_2 = 1;
         $Note_livreur->isActive = 1;
         $Note_livreur->isDelete = 0;
         $Note_livreur->save();
        // reponse
        return response()->json([
            "Status" => 1,
            "Alert" => 'Notes du livreur effectuée avec succès',
            "description" => 'Notes du livreur effectuée par le client',
        ]);
        
        }else{
            //  traitement des données 1 Note_livreur
        $Note_livreur = new Note_livreur();
        $Note_livreur->id_liv = $request->id_liv;
        $Note_livreur->id_client = $request->id_client;
        $Note_livreur->notes = $request->notes;
        $Note_livreur->commentaire = isset($request->commentaire)? $request->commentaire :   '';
        $Note_livreur->isNotify_1 = 1;
        $Note_livreur->isNotify_2 = 1;
        $Note_livreur->isActive = 1;
        $Note_livreur->isDelete = 0;
        $Note_livreur->save();
        
        // reponse
        return response()->json([
            "Status" => 1,
            "Alert" => 'Notes du livreur effectuée avec succès',
            "description" => 'Notes du livreur effectuée par le client',
        ]);
        }
        
        
        }else{
            // reponse
        return response()->json([
            "Status" => 0,
            "Alert" => 'Vous avez déjà noté ce livreur',
            "description" => 'Client déjà noté',
        ]);
        }
        
    }

    /**
     * afficher tous les Note_livreur  activé
     *
     * @return \Illuminate\Http\Response
     */
    public function showNoteOneUser($id)
    {

        if (Note_livreur::where(['id_liv' => $id,'isActive' => 1, 'isDelete' => 0])->exists()) {

            $Note_livreur = Note_livreur::where(['id_liv' => $id, 'isActive' => 1, 'isDelete' => 0])->sum("notes");
            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les Notes du livreur  activée affichées  avec succès',
                "description" => 'Details de tous les Note_livreur  activé',
                "data" => $Note_livreur,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun Notes du livreur  activée trouvée',
            ]);
        }

    }
    /**
     * afficher tous les Note_livreur  activé
     *
     * @return \Illuminate\Http\Response
     */
    public function showNoteOneUsercomment($id)
    {

        if (Note_livreur::where(['id_liv' => $id,'isActive' => 1, 'isDelete' => 0])->exists()) {

            $Note_livreur = Note_livreur::where(['id_liv' => $id, 'isActive' => 1, 'isDelete' => 0])->first();
            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les Notes du livreur  activée affichées  avec succès',
                "description" => 'Details de tous les Note_livreur  activé',
                "data" => $Note_livreur,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun Notes du livreur  activée trouvée',
            ]);
        }

    }
    /**
     * afficher tous les Note_livreur  pour les contacts
     *
     * @return \Illuminate\Http\Response
     */

    public function showAll()
    {

        if (Note_livreur::where('isDelete', 0)->exists()) {

            $Note_livreur = Note_livreur::where('isDelete', 0)->get();
            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Toutes les  Notes du livreur   affichés  avec succès',
                "description" => 'Details de toutes les  Notes du livreur ',
                "data" => $Note_livreur,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun Notes du livreur  trouvé',
            ]);
        }

    }

    /**
     * afficher une Note_livreur
     *
     * @return \Illuminate\Http\Response
     */
    public function showOne($id)
    {

        if (Note_livreur::where(['id' => $id, 'isDelete' => 0])->exists()) {

            $Note_livreur = Note_livreur::where([
                'id' => $id,
                'isDelete' => 0,
            ])->get();

            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Notes du livreur  trouvé avec succès',
                "description" => 'Details du Notes du livreur  ',
                "data" => $Note_livreur,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun Notes du livreur  trouvé',
            ]);
        }

    }

    /**
     * mise à jour du Note_livreur
     *
     * @return \Illuminate\Http\Response
     */
    public function edite(Request $request, $id)
    {

        if (Note_livreur::where(['id' => $id, 'isDelete' => 0])->exists()) {
            //validation
            $request->validate([
                'libelle' => 'required|max:50|unique:Note_livreurs',
                'nbr_face_img' => 'required|digitsbetween:1,2|max:20',
            ]);
            $Note_livreur = Note_livreur::where(['id' => $id, 'isDelete' => 0])->first();

            // traitement des données
            $Note_livreur->update([
                "libelle" => $request->libelle,
                "nbr_face_img" => $request->nbr_face_img,
            ]);
            return response()->json([
                "Status" => 1,
                "Alert" => 'Notes du livreur  mise à jours avec succès',
            ]);

        } else {
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucune  Notes du livreur  trouvée',
            ]);
        }

    }

    /**
     * activer un Note_livreur
     *
     * @return \Illuminate\Http\Response
     */
    public function active($id)
    {

        if (Note_livreur::where(['id' => $id, 'isDelete' => 0])->exists()) {

            $Note_livreur = Note_livreur::where(['id' => $id, 'isDelete' => 0])->first();

                // traitement des données
                $Note_livreur->update([
                    "isActive" => 1,
                ]);

                return response()->json([
                    "Status" => 1,
                    "Alert" => 'Notes du livreur  activée avec succès',
                ]);

        } else {
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucune  Notes du livreur  trouvé',
            ]);
        }

    }
    /**
     * désactiver un Note_livreur
     *
     * @return \Illuminate\Http\Response
     */
    public function desactive($id)
    {

        if (Note_livreur::where(['id' => $id, 'isDelete' => 0])->exists()) {

            $Note_livreur = Note_livreur::where(['id' => $id, 'isDelete' => 0])->first();

            // traitement des données
            $Note_livreur->update([
                "isActive" => 0,
            ]);

            return response()->json([
                "Status" => 1,
                "Alert" => 'Notes du livreur  désactivée avec succès',
            ]);

        } else {
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucune Notes du livreur  trouvée',
            ]);
        }

    }

    /**
     * afficher tous les Note_livreur  activé
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllActive()
    {

        if (Note_livreur::where(['isActive' => 1, 'isDelete' => 0])->exists()) {

            $Note_livreur = Note_livreur::where(['isActive' => 1, 'isDelete' => 0])->get();
            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les Notes du livreur  activée affichées  avec succès',
                "description" => 'Details de tous les Note_livreur  activé',
                "data" => $Note_livreur,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun Notes du livreur  activée trouvée',
            ]);
        }

    }

    /**
     * afficher un Note_livreur  activé
     *
     * @return \Illuminate\Http\Response
     */
    public function showOneActive($id)
    {

        if (Note_livreur::where(['id' => $id, 'isActive' => 1, 'isDelete' => 0])->exists()) {

            $Note_livreur = Note_livreur::where(['id' => $id, 'isActive' => 1, 'isDelete' => 0])->get();

            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Notes du livreur  activée trouvée avec succès',
                "description" => 'Details du Notes du livreur  activée',
                "data" => $Note_livreur,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucune Notes du livreur  activée trouvé',
            ]);
        }

    }

    /**
     * afficher tous les Note_livreur désactivé
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllDesactive()
    {

        if (Note_livreur::where(['isActive' => 0, 'isDelete' => 0])->exists()) {

            $Note_livreur = Note_livreur::where(['isActive' => 0, 'isDelete' => 0])->get();
            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les Notes du livreur  désactivée affichées  avec succès',
                "description" => 'Details de tous les demandes de livraison  désactivée',
                "data" => $Note_livreur,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucune Notes du livreur  désactivée trouvé',
            ]);
        }

    }

    /**
     * afficher un Note_livreur  désactivé
     *
     * @return \Illuminate\Http\Response
     */
    public function showOneDesactive($id)
    {

        if (Note_livreur::where(['id' => $id, 'isActive' => 0, 'isDelete' => 0])->exists()) {

            $Note_livreur = Note_livreur::where(['id' => $id, 'isActive' => 0, 'isDelete' => 0])->get();

            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Notes du livreur  désactivé trouvée avec succès',
                "description" => 'Details du Notes du livreur  désactivée',
                "data" => $Note_livreur,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucune Notes du livreur  désactivée trouvée',
            ]);
        }

    }
    /**
     * supprimer un Note_livreur
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        if (Note_livreur::where(['id' => $id, 'isDelete' => 0])->exists()) {
            $Note_livreur = Note_livreur::where(['id' => $id, 'isDelete' => 0])->first();

            // traitement des données
            $Note_livreur->update([
                "isDelete" => 1,
            ]);
            return response()->json([
                "Status" => 1,
                "Alert" => 'Notes du livreur supprimée avec succès',
            ]);

        } else {
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucune Notes du livreur trouvée',
            ]);
        }

    }
}

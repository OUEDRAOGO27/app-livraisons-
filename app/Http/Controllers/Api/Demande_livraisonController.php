<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Demande_livraison;
use Illuminate\Http\Request;

class Demande_livraisonController extends Controller
{
     /**
     * Création de Demande de livraison pour les contacts à appeler de l'apps
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //validation
        $request->validate([
        'id_client'  => 'required|integer',
        'id_type_liv'  => 'required|integer',
        'long_depart' => 'required',
        'lat_depart' => 'required',
        'libelle_depart' => 'required',
        'long_arrive' => 'required',
        'lat_arrive' => 'required',
        'libelle_arrive' => 'required',
        'poids_colis' => 'required',
        'quantite_colis' => 'required',
        'taille_colis' => 'required',
        'tarifs' => 'required',
        'date_livraison' => 'date'
        ]);
        //  traitement des données 1 Demande_livraison
        $demande_livraison = new Demande_livraison();
        $demande_livraison->id_client = $request->id_client;
        $demande_livraison->id_type_liv = $request->id_type_liv;
        $demande_livraison->long_depart = $request->long_depart;
        $demande_livraison->lat_depart = $request->lat_depart;
        $demande_livraison->libelle_depart = $request->libelle_depart;
        $demande_livraison->long_arrive = $request->long_arrive;
        $demande_livraison->lat_arrive = $request->lat_arrive;
        $demande_livraison->libelle_arrive = $request->libelle_arrive;
        $demande_livraison->poids_colis = $request->poids_colis;
        $demande_livraison->quantite_colis = $request->quantite_colis;
        $demande_livraison->taille_colis = $request->taille_colis;
        $demande_livraison->tarifs = $request->tarifs;
        $demande_livraison->date_livraison = isset($request->date_livraison)? $request->date_livraison : now();
        $demande_livraison->isNotify_1 = 1;
        $demande_livraison->isNotify_2 = 1;
        $demande_livraison->isActive = 1;
        $demande_livraison->isDelete = 0;
        $demande_livraison->save();
        
        // reponse
        return response()->json([
            "Status" => 1,
            "Alert" => 'Demande de livraison effectuée avec succès',
            "description" => 'Demande de livraison effectuée par le client',
        ]);
    }

    /**
     * afficher tous les Demande_livraison  pour les contacts
     *
     * @return \Illuminate\Http\Response
     */

    public function showAll()
    {

        if (Demande_livraison::where('isDelete', 0)->exists()) {

            $demande_livraison = Demande_livraison::where('isDelete', 0)->get();
            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les  Demande de livraison   affichés  avec succès',
                "description" => 'Details de tous les   demandes de livraison ',
                "data" => $demande_livraison,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun demande de livraison  trouvé',
            ]);
        }

    }

    /**
     * afficher un Demande_livraison
     *
     * @return \Illuminate\Http\Response
     */
    public function showOne($id)
    {

        if (Demande_livraison::where(['id' => $id, 'isDelete' => 0])->exists()) {

            $demande_livraison = Demande_livraison::where([
                'id' => $id,
                'isDelete' => 0,
            ])->get();

            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Demande de livraison  trouvé avec succès',
                "description" => 'Details du Demande de livraison  ',
                "data" => $demande_livraison,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun Demande de livraison  trouvé',
            ]);
        }

    }

    /**
     * mise à jour du Demande_livraison
     *
     * @return \Illuminate\Http\Response
     */
    public function edite(Request $request, $id)
    {

        if (Demande_livraison::where(['id' => $id, 'isDelete' => 0])->exists()) {
            //validation
            $request->validate([
                'libelle' => 'required|max:50|unique:Demande_livraisons',
                'nbr_face_img' => 'required|digitsbetween:1,2|max:20',
            ]);
            $demande_livraison = Demande_livraison::where(['id' => $id, 'isDelete' => 0])->first();

            // traitement des données
            $demande_livraison->update([
                "libelle" => $request->libelle,
                "nbr_face_img" => $request->nbr_face_img,
            ]);
            return response()->json([
                "Status" => 1,
                "Alert" => 'Demande de livraison  mise à jours avec succès',
            ]);

        } else {
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucune  demande de livraison  trouvée',
            ]);
        }

    }

    /**
     * activer un Demande_livraison
     *
     * @return \Illuminate\Http\Response
     */
    public function active($id)
    {

        if (Demande_livraison::where(['id' => $id, 'isDelete' => 0])->exists()) {

            $demande_livraison = Demande_livraison::where(['id' => $id, 'isDelete' => 0])->first();

                // traitement des données
                $demande_livraison->update([
                    "isActive" => 1,
                ]);

                return response()->json([
                    "Status" => 1,
                    "Alert" => 'Demande de livraison  activée avec succès',
                ]);

        } else {
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucune  demande de livraison  trouvé',
            ]);
        }

    }
    /**
     * désactiver un Demande_livraison
     *
     * @return \Illuminate\Http\Response
     */
    public function desactive($id)
    {

        if (Demande_livraison::where(['id' => $id, 'isDelete' => 0])->exists()) {

            $demande_livraison = Demande_livraison::where(['id' => $id, 'isDelete' => 0])->first();

            // traitement des données
            $demande_livraison->update([
                "isActive" => 0,
            ]);

            return response()->json([
                "Status" => 1,
                "Alert" => 'Demande de livraison  désactivée avec succès',
            ]);

        } else {
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucune demande de livraison  trouvée',
            ]);
        }

    }

    /**
     * afficher tous les Demande_livraison  activé
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllActive()
    {

        if (Demande_livraison::where(['isActive' => 1, 'isDelete' => 0])->exists()) {

            $Demande_livraison = Demande_livraison::where(['isActive' => 1, 'isDelete' => 0])->get();
            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les demande de livraison  activée affichées  avec succès',
                "description" => 'Details de tous les demande_livraison  activé',
                "data" => $Demande_livraison,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun demande de livraison  activée trouvée',
            ]);
        }

    }

    /**
     * afficher un Demande_livraison  activé
     *
     * @return \Illuminate\Http\Response
     */
    public function showOneActive($id)
    {

        if (Demande_livraison::where(['id' => $id, 'isActive' => 1, 'isDelete' => 0])->exists()) {

            $demande_livraison = Demande_livraison::where(['id' => $id, 'isActive' => 1, 'isDelete' => 0])->get();

            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Demande de livraison  activée trouvée avec succès',
                "description" => 'Details du demande de livraison  activée',
                "data" => $demande_livraison,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucune demande de livraison  activée trouvé',
            ]);
        }

    }

    /**
     * afficher tous les Demande_livraison désactivé
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllDesactive()
    {

        if (Demande_livraison::where(['isActive' => 0, 'isDelete' => 0])->exists()) {

            $demande_livraison = Demande_livraison::where(['isActive' => 0, 'isDelete' => 0])->get();
            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les demande de livraison  désactivée affichées  avec succès',
                "description" => 'Details de tous les demandes de livraison  désactivée',
                "data" => $demande_livraison,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucune demande de livraison  désactivée trouvé',
            ]);
        }

    }

    /**
     * afficher un Demande_livraison  désactivé
     *
     * @return \Illuminate\Http\Response
     */
    public function showOneDesactive($id)
    {

        if (Demande_livraison::where(['id' => $id, 'isActive' => 0, 'isDelete' => 0])->exists()) {

            $demande_livraison = Demande_livraison::where(['id' => $id, 'isActive' => 0, 'isDelete' => 0])->get();

            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Demande de livraison  désactivé trouvée avec succès',
                "description" => 'Details du demande de livraison  désactivée',
                "data" => $demande_livraison,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucune demande de livraison  désactivée trouvée',
            ]);
        }

    }
    /**
     * supprimer un Demande_livraison
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        if (Demande_livraison::where(['id' => $id, 'isDelete' => 0])->exists()) {
            $demande_livraison = Demande_livraison::where(['id' => $id, 'isDelete' => 0])->first();

            // traitement des données
            $demande_livraison->update([
                "isDelete" => 1,
            ]);
            return response()->json([
                "Status" => 1,
                "Alert" => 'Demande de livraison supprimée avec succès',
            ]);

        } else {
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucune demande de livraison trouvée',
            ]);
        }

    }
}

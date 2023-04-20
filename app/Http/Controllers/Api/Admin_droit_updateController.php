<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin_droit_update;
use Illuminate\Http\Request;

class Admin_droit_updateController extends Controller
{
  

    /**
     * afficher tous les Admin_droit_update  pour les contacts
     *
     * @return \Illuminate\Http\Response
     */

    public function showAll()
    {

        if (Admin_droit_update::where('isDelete', 0)->exists()) {

            $Admin_droit_update = Admin_droit_update::where('isDelete', 0)->get();
            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les  Demande de livraison   affichés  avec succès',
                "description" => 'Details de tous les   demandes de livraison ',
                "data" => $Admin_droit_update,
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
     * afficher un Admin_droit_update
     *
     * @return \Illuminate\Http\Response
     */
    public function showOne($id)
    {

        if (Admin_droit_update::where(['id' => $id, 'isDelete' => 0])->exists()) {

            $Admin_droit_update = Admin_droit_update::where([
                'id' => $id,
                'isDelete' => 0,
            ])->get();

            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Demande de livraison  trouvé avec succès',
                "description" => 'Details du Demande de livraison  ',
                "data" => $Admin_droit_update,
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
     * mise à jour du Admin_droit_update
     *
     * @return \Illuminate\Http\Response
     */
    public function edite(Request $request, $id)
    {

        if (Admin_droit_update::where(['id' => $id, 'isDelete' => 0])->exists()) {
            //validation
            $request->validate([
                'libelle' => 'required|max:50|unique:Admin_droit_updates',
                'nbr_face_img' => 'required|digitsbetween:1,2|max:20',
            ]);
            $Admin_droit_update = Admin_droit_update::where(['id' => $id, 'isDelete' => 0])->first();

            // traitement des données
            $Admin_droit_update->update([
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
     * activer un Admin_droit_update
     *
     * @return \Illuminate\Http\Response
     */
    public function active($id)
    {

        if (Admin_droit_update::where(['id' => $id, 'isDelete' => 0])->exists()) {

            $Admin_droit_update = Admin_droit_update::where(['id' => $id, 'isDelete' => 0])->first();

                // traitement des données
                $Admin_droit_update->update([
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
     * désactiver un Admin_droit_update
     *
     * @return \Illuminate\Http\Response
     */
    public function desactive($id)
    {

        if (Admin_droit_update::where(['id' => $id, 'isDelete' => 0])->exists()) {

            $Admin_droit_update = Admin_droit_update::where(['id' => $id, 'isDelete' => 0])->first();

            // traitement des données
            $Admin_droit_update->update([
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
     * afficher tous les Admin_droit_update  activé
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllActive()
    {

        if (Admin_droit_update::where(['isActive' => 1, 'isDelete' => 0])->exists()) {

            $Admin_droit_update = Admin_droit_update::where(['isActive' => 1, 'isDelete' => 0])->get();
            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les demande de livraison  activée affichées  avec succès',
                "description" => 'Details de tous les Admin_droit_update  activé',
                "data" => $Admin_droit_update,
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
     * afficher un Admin_droit_update  activé
     *
     * @return \Illuminate\Http\Response
     */
    public function showOneActive($id)
    {

        if (Admin_droit_update::where(['id' => $id, 'isActive' => 1, 'isDelete' => 0])->exists()) {

            $Admin_droit_update = Admin_droit_update::where(['id' => $id, 'isActive' => 1, 'isDelete' => 0])->get();

            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Demande de livraison  activée trouvée avec succès',
                "description" => 'Details du demande de livraison  activée',
                "data" => $Admin_droit_update,
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
     * afficher tous les Admin_droit_update désactivé
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllDesactive()
    {

        if (Admin_droit_update::where(['isActive' => 0, 'isDelete' => 0])->exists()) {

            $Admin_droit_update = Admin_droit_update::where(['isActive' => 0, 'isDelete' => 0])->get();
            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les demande de livraison  désactivée affichées  avec succès',
                "description" => 'Details de tous les demandes de livraison  désactivée',
                "data" => $Admin_droit_update,
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
     * afficher un Admin_droit_update  désactivé
     *
     * @return \Illuminate\Http\Response
     */
    public function showOneDesactive($id)
    {

        if (Admin_droit_update::where(['id' => $id, 'isActive' => 0, 'isDelete' => 0])->exists()) {

            $Admin_droit_update = Admin_droit_update::where(['id' => $id, 'isActive' => 0, 'isDelete' => 0])->get();

            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Demande de livraison  désactivé trouvée avec succès',
                "description" => 'Details du demande de livraison  désactivée',
                "data" => $Admin_droit_update,
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
     * supprimer un Admin_droit_update
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        if (Admin_droit_update::where(['id' => $id, 'isDelete' => 0])->exists()) {
            $Admin_droit_update = Admin_droit_update::where(['id' => $id, 'isDelete' => 0])->first();

            // traitement des données
            $Admin_droit_update->update([
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

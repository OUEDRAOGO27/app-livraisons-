<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Demande_execution;
use Illuminate\Http\Request;

class Demande_executionController extends Controller
{
     /**
     * Création de Demande de execution pour les contacts à appeler de l'apps
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //validation
        $request->validate([
        'id_liv'  => 'required|integer',
        'id_dem_liv' => 'required|integer',
        'accord_client' => 'required|string'
        ]);
        //  traitement des données 1 Demande_execution
        $Demande_execution = new Demande_execution();
        $Demande_execution->id_liv = $request->id_liv;
        $Demande_execution->id_dem_liv = $request->id_dem_liv;
        $Demande_execution->accord_client = $request->accord_client;
        $Demande_execution->isNotify_1 = 1;
        $Demande_execution->isNotify_2 = 1;
        $Demande_execution->isActive = 1;
        $Demande_execution->isDelete = 0;
        $Demande_execution->save();
        
        // reponse
        return response()->json([
            "Status" => 1,
            "Alert" => 'Demande de execution effectuée avec succès',
            "description" => 'Demande de execution effectuée par le client',
        ]);
    }

    /**
     * afficher tous les Demande_execution  pour les contacts
     *
     * @return \Illuminate\Http\Response
     */

    public function showAll()
    {

        if (Demande_execution::where('isDelete', 0)->exists()) {

            $Demande_execution = Demande_execution::where('isDelete', 0)->get();
            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les  Demande de execution   affichés  avec succès',
                "description" => 'Details de tous les   demandes de livraison ',
                "data" => $Demande_execution,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun Demande de execution  trouvé',
            ]);
        }

    }

    /**
     * afficher une Demande_execution
     *
     * @return \Illuminate\Http\Response
     */
    public function showOne($id)
    {

        if (Demande_execution::where(['id' => $id, 'isDelete' => 0])->exists()) {

            $Demande_execution = Demande_execution::where([
                'id' => $id,
                'isDelete' => 0,
            ])->get();

            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Demande de execution  trouvé avec succès',
                "description" => 'Details du Demande de execution  ',
                "data" => $Demande_execution,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun Demande de execution  trouvé',
            ]);
        }

    }

    /**
     * mise à jour du Demande_execution
     *
     * @return \Illuminate\Http\Response
     */
    public function edite(Request $request, $id)
    {

        if (Demande_execution::where(['id' => $id, 'isDelete' => 0])->exists()) {
            //validation
            $request->validate([
                'libelle' => 'required|max:50|unique:Demande_executions',
                'nbr_face_img' => 'required|digitsbetween:1,2|max:20',
            ]);
            $Demande_execution = Demande_execution::where(['id' => $id, 'isDelete' => 0])->first();

            // traitement des données
            $Demande_execution->update([
                "libelle" => $request->libelle,
                "nbr_face_img" => $request->nbr_face_img,
            ]);
            return response()->json([
                "Status" => 1,
                "Alert" => 'Demande de execution  mise à jours avec succès',
            ]);

        } else {
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucune  Demande de execution  trouvée',
            ]);
        }

    }

    /**
     * activer un Demande_execution
     *
     * @return \Illuminate\Http\Response
     */
    public function active($id)
    {

        if (Demande_execution::where(['id' => $id, 'isDelete' => 0])->exists()) {

            $Demande_execution = Demande_execution::where(['id' => $id, 'isDelete' => 0])->first();

                // traitement des données
                $Demande_execution->update([
                    "isActive" => 1,
                ]);

                return response()->json([
                    "Status" => 1,
                    "Alert" => 'Demande de execution  activée avec succès',
                ]);

        } else {
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucune  Demande de execution  trouvé',
            ]);
        }

    }
    /**
     * désactiver un Demande_execution
     *
     * @return \Illuminate\Http\Response
     */
    public function desactive($id)
    {

        if (Demande_execution::where(['id' => $id, 'isDelete' => 0])->exists()) {

            $Demande_execution = Demande_execution::where(['id' => $id, 'isDelete' => 0])->first();

            // traitement des données
            $Demande_execution->update([
                "isActive" => 0,
            ]);

            return response()->json([
                "Status" => 1,
                "Alert" => 'Demande de execution  désactivée avec succès',
            ]);

        } else {
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucune Demande de execution  trouvée',
            ]);
        }

    }

    /**
     * afficher tous les Demande_execution  activé
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllActive()
    {

        if (Demande_execution::where(['isActive' => 1, 'isDelete' => 0])->exists()) {

            $Demande_execution = Demande_execution::where(['isActive' => 1, 'isDelete' => 0])->get();
            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les Demande de execution  activée affichées  avec succès',
                "description" => 'Details de tous les Demande_execution  activé',
                "data" => $Demande_execution,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun Demande de execution  activée trouvée',
            ]);
        }

    }

    /**
     * afficher un Demande_execution  activé
     *
     * @return \Illuminate\Http\Response
     */
    public function showOneActive($id)
    {

        if (Demande_execution::where(['id' => $id, 'isActive' => 1, 'isDelete' => 0])->exists()) {

            $Demande_execution = Demande_execution::where(['id' => $id, 'isActive' => 1, 'isDelete' => 0])->get();

            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Demande de execution  activée trouvée avec succès',
                "description" => 'Details du Demande de execution  activée',
                "data" => $Demande_execution,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucune Demande de execution  activée trouvé',
            ]);
        }

    }

    /**
     * afficher tous les Demande_execution désactivé
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllDesactive()
    {

        if (Demande_execution::where(['isActive' => 0, 'isDelete' => 0])->exists()) {

            $Demande_execution = Demande_execution::where(['isActive' => 0, 'isDelete' => 0])->get();
            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les Demande de execution  désactivée affichées  avec succès',
                "description" => 'Details de tous les demandes de livraison  désactivée',
                "data" => $Demande_execution,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucune Demande de execution  désactivée trouvé',
            ]);
        }

    }

    /**
     * afficher un Demande_execution  désactivé
     *
     * @return \Illuminate\Http\Response
     */
    public function showOneDesactive($id)
    {

        if (Demande_execution::where(['id' => $id, 'isActive' => 0, 'isDelete' => 0])->exists()) {

            $Demande_execution = Demande_execution::where(['id' => $id, 'isActive' => 0, 'isDelete' => 0])->get();

            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Demande de execution  désactivé trouvée avec succès',
                "description" => 'Details du Demande de execution  désactivée',
                "data" => $Demande_execution,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucune Demande de execution  désactivée trouvée',
            ]);
        }

    }
    /**
     * supprimer un Demande_execution
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        if (Demande_execution::where(['id' => $id, 'isDelete' => 0])->exists()) {
            $Demande_execution = Demande_execution::where(['id' => $id, 'isDelete' => 0])->first();

            // traitement des données
            $Demande_execution->update([
                "isDelete" => 1,
            ]);
            return response()->json([
                "Status" => 1,
                "Alert" => 'Demande de execution supprimée avec succès',
            ]);

        } else {
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucune Demande de execution trouvée',
            ]);
        }

    }
}

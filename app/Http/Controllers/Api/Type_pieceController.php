<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Type_piece;
use Illuminate\Http\Request;

class Type_pieceController extends Controller
{
    /**
     * Création de type de pièce pour les contacts à appeler de l'apps
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //validation
        $request->validate([
            'libelle' => 'required|max:50|unique:Type_pieces',
            'nbr_face_img' => 'required|digitsbetween:1,2',
        ]);
        $Type_piece_count = Type_piece::where(['isActive' => 1, 'isDelete' => 0 ])->get()->count();
        // count
        if ($Type_piece_count >= 1) {
            // traitement des données
        $type_piece = new Type_piece();
        $type_piece->libelle = $request->libelle;
        $type_piece->nbr_face_img = $request->nbr_face_img;
        $type_piece->isNotify_1 = 1;
        $type_piece->isNotify_2 = 1;
        $type_piece->isActive = 0;
        $type_piece->isDelete = 0;
        $type_piece->save();
        // reponse
        return response()->json([
            "Status" => 1,
            "Alert" => 'Type de pièce enregistré avec succès',
            "description" => 'Création du type de pièce pour la partie nos contacts sur l\'apps ',
        ]);

        }else{
              // traitement des données
        $type_piece = new Type_piece();
        $type_piece->libelle = $request->libelle;
        $type_piece->nbr_face_img = $request->nbr_face_img;
        $type_piece->isActive = 1;
        $type_piece->isDelete = 0;
        $type_piece->save();
        // reponse
        return response()->json([
            "Status" => 1,
            "Alert" => 'Type de pièce enregistré avec succès',
            "description" => 'Création du type de pièce pour la partie nos contacts sur l\'apps ',
        ]);
        }
       
    }

    /**
     * afficher tous les type de pièce  pour les contacts
     *
     * @return \Illuminate\Http\Response
     */

    public function showAll()
    {

        if (Type_piece::where('isDelete', 0)->exists()) {

            $type_piece = Type_piece::where('isDelete', 0)->get();
            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les  type de pièce   affichés  avec succès',
                "description" => 'Details de tous les  type de pièce ',
                "data" => $type_piece,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun type de pièce  trouvé',
            ]);
        }

    }

    /**
     * afficher un type de pièce
     *
     * @return \Illuminate\Http\Response
     */
    public function showOne($id)
    {

        if (Type_piece::where(['id' => $id, 'isDelete' => 0])->exists()) {

            $type_piece = Type_piece::where([
                'id' => $id,
                'isDelete' => 0,
            ])->get();

            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'type de pièce  trouvé avec succès',
                "description" => 'Details du type de pièce  ',
                "data" => $type_piece,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun type de pièce  trouvé',
            ]);
        }

    }

    /**
     * mise à jour du type de pièce
     *
     * @return \Illuminate\Http\Response
     */
    public function edite(Request $request, $id)
    {

        if (Type_piece::where(['id' => $id, 'isDelete' => 0])->exists()) {
            //validation
            $request->validate([
                'libelle' => 'required|max:50|unique:Type_pieces',
                'nbr_face_img' => 'required|digitsbetween:1,2|max:20',
            ]);
            $type_piece = Type_piece::where(['id' => $id, 'isDelete' => 0])->first();

            // traitement des données
            $type_piece->update([
                "libelle" => $request->libelle,
                "nbr_face_img" => $request->nbr_face_img,
            ]);
            return response()->json([
                "Status" => 1,
                "Alert" => 'Type de pièce  mise à jours avec succès',
            ]);

        } else {
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun type de pièce  trouvé',
            ]);
        }

    }

    /**
     * activer un type de pièce
     *
     * @return \Illuminate\Http\Response
     */
    public function active($id)
    {

        if (Type_piece::where(['id' => $id, 'isDelete' => 0])->exists()) {

            $type_piece = Type_piece::where(['id' => $id, 'isDelete' => 0])->first();

                // traitement des données
                $type_piece->update([
                    "isActive" => 1,
                ]);

                return response()->json([
                    "Status" => 1,
                    "Alert" => 'Type de pièce  activé avec succès',
                ]);

        } else {
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun type de pièce  trouvé',
            ]);
        }

    }
    /**
     * désactiver un type de pièce
     *
     * @return \Illuminate\Http\Response
     */
    public function desactive($id)
    {

        if (Type_piece::where(['id' => $id, 'isDelete' => 0])->exists()) {

            $type_piece = Type_piece::where(['id' => $id, 'isDelete' => 0])->first();

            // traitement des données
            $type_piece->update([
                "isActive" => 0,
            ]);

            return response()->json([
                "Status" => 1,
                "Alert" => 'Type de pièce  désactivé avec succès',
            ]);

        } else {
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun type de pièce  trouvé',
            ]);
        }

    }

    /**
     * afficher tous les type de pièce  activé
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllActive()
    {

        if (Type_piece::where(['isActive' => 1, 'isDelete' => 0])->exists()) {

            $type_piece = Type_piece::where(['isActive' => 1, 'isDelete' => 0])->get();
            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les type de pièce  activé affichés  avec succès',
                "description" => 'Details de tous les type de pièce  activé',
                "data" => $type_piece,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun type de pièce  activé trouvé',
            ]);
        }

    }

    /**
     * afficher un type de pièce  activé
     *
     * @return \Illuminate\Http\Response
     */
    public function showOneActive($id)
    {

        if (Type_piece::where(['id' => $id, 'isActive' => 1, 'isDelete' => 0])->exists()) {

            $type_piece = Type_piece::where(['id' => $id, 'isActive' => 1, 'isDelete' => 0])->get();

            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Type de pièce  activé trouvé avec succès',
                "description" => 'Details du type de pièce  activé',
                "data" => $type_piece,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun type de pièce  activé trouvé',
            ]);
        }

    }

    /**
     * afficher tous les type de pièce désactivé
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllDesactive()
    {

        if (Type_piece::where(['isActive' => 0, 'isDelete' => 0])->exists()) {

            $type_piece = Type_piece::where(['isActive' => 0, 'isDelete' => 0])->get();
            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les type de pièce  désactivé affichés  avec succès',
                "description" => 'Details de tous les type de pièce  désactivé',
                "data" => $type_piece,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun type de pièce  désactivé trouvé',
            ]);
        }

    }

    /**
     * afficher un type de pièce  désactivé
     *
     * @return \Illuminate\Http\Response
     */
    public function showOneDesactive($id)
    {

        if (Type_piece::where(['id' => $id, 'isActive' => 0, 'isDelete' => 0])->exists()) {

            $type_piece = Type_piece::where(['id' => $id, 'isActive' => 0, 'isDelete' => 0])->get();

            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Type de pièce  désactivé trouvé avec succès',
                "description" => 'Details du type de pièce  désactivé',
                "data" => $type_piece,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun type de pièce  désactivé trouvé',
            ]);
        }

    }
    /**
     * supprimer un type de pièce
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        if (Type_piece::where(['id' => $id, 'isDelete' => 0])->exists()) {
            $type_piece = Type_piece::where(['id' => $id, 'isDelete' => 0])->first();

            // traitement des données
            $type_piece->update([
                "isDelete" => 1,
            ]);
            return response()->json([
                "Status" => 1,
                "Alert" => 'Type de pièce supprimé avec succès',
            ]);

        } else {
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun type de pièce trouvé',
            ]);
        }

    }

}

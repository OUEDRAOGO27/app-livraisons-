<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Abonnement;
use App\Models\Expiration_abonnement;
use App\Models\Paiement;
use App\Models\Type_abonnement;
use Illuminate\Http\Request;
use IlluminateSupportCarbon;

class AbonnementController extends Controller
{
    /**
     * Création de abonnement pour les contacts à appeler de l'apps
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //validation
        $request->validate([
            'id_liv' => 'required|integer',
            'id_type_abon' => 'required|integer'
        ]);
        // traitement des données 1 abonnement
        $abonnement = new Abonnement();
        $abonnement->id_liv = $request->id_liv;
        $abonnement->id_type_abon = $request->id_type_abon;
        $abonnement->status_abon = "en_cours";
        $abonnement->isNotify_abon_val_1 = 1;
        $abonnement->isNotify_abon_val_2 = 1;
        $abonnement->isActive = 1;
        $abonnement->isDelete = 0;
        $abonnement->save();
        // traitement des données 2 paiement
        
        $abonnement = Abonnement::where(['id_liv' => $request->id_liv, 'id_type_abon' => $request->id_type_abon,'status_abon' => 'en_cours' , 'isActive' => 1,'isDelete' => 0 ])->first(); 
        $type_abonnement = Type_abonnement::where(['id' => $request->id_type_abon, 'isActive' => 1, 'isDelete' => 0 ])->first();
        $paiement = new Paiement();
        $paiement->id_abon = $abonnement->id;
        $paiement->montant = $type_abonnement->tarif;
        $paiement->status_paiement = "payer";
        $paiement->isNotify_paie_val_1 = 1;
        $paiement->isNotify_paie_val_2 = 1;
        $paiement->isActive = 1;
        $paiement->isDelete = 0;
        $paiement->save();
        // traitement des données 3 expiration abonnement
        $expiration_abonnement = new Expiration_abonnement();
        $expiration_abonnement->id_abon = $abonnement->id;
        $expiration_abonnement->status = 1;
        $expiration_abonnement->date_expire = now()->addDays($type_abonnement->nbr_jours);
        $expiration_abonnement->isNotify_abon_val_1 = 1;
        $expiration_abonnement->isNotify_abon_val_2 = 1;
        $expiration_abonnement->isActive = 1;
        $expiration_abonnement->isDelete = 0;
        $expiration_abonnement->save();
        // reponse
        return response()->json([
            "Status" => 1,
            "Alert" => 'Abonnement payé avec succès',
            "description" => 'paiement d\'abonnement pour la partie nos contacts sur l\'apps ',
        ]);
    }

    /**
     * afficher tous les abonnement  pour les contacts
     *
     * @return \Illuminate\Http\Response
     */

    public function showAll()
    {

        if (Abonnement::where('isDelete', 0)->exists()) {

            $abonnement = Abonnement::where('isDelete', 0)->get();
            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les  abonnement   affichés  avec succès',
                "description" => 'Details de tous les  abonnement ',
                "data" => $abonnement,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun abonnement  trouvé',
            ]);
        }

    }

    /**
     * afficher un abonnement
     *
     * @return \Illuminate\Http\Response
     */
    public function showOne($id)
    {

        if (Abonnement::where(['id' => $id, 'isDelete' => 0])->exists()) {

            $abonnement = Abonnement::where([
                'id' => $id,
                'isDelete' => 0,
            ])->get();

            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'abonnement  trouvé avec succès',
                "description" => 'Details du abonnement  ',
                "data" => $abonnement,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun abonnement  trouvé',
            ]);
        }

    }

    /**
     * mise à jour du abonnement
     *
     * @return \Illuminate\Http\Response
     */
    public function edite(Request $request, $id)
    {

        if (Abonnement::where(['id' => $id, 'isDelete' => 0])->exists()) {
            //validation
            $request->validate([
                'libelle' => 'required|max:50|unique:Abonnements',
                'nbr_face_img' => 'required|digitsbetween:1,2|max:20',
            ]);
            $abonnement = Abonnement::where(['id' => $id, 'isDelete' => 0])->first();

            // traitement des données
            $abonnement->update([
                "libelle" => $request->libelle,
                "nbr_face_img" => $request->nbr_face_img,
            ]);
            return response()->json([
                "Status" => 1,
                "Alert" => 'abonnement  mise à jours avec succès',
            ]);

        } else {
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun abonnement  trouvé',
            ]);
        }

    }

    /**
     * activer un abonnement
     *
     * @return \Illuminate\Http\Response
     */
    public function active($id)
    {

        if (Abonnement::where(['id' => $id, 'isDelete' => 0])->exists()) {

            $abonnement = Abonnement::where(['id' => $id, 'isDelete' => 0])->first();

                // traitement des données
                $abonnement->update([
                    "isActive" => 1,
                ]);

                return response()->json([
                    "Status" => 1,
                    "Alert" => 'abonnement  activé avec succès',
                ]);

        } else {
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun abonnement  trouvé',
            ]);
        }

    }
    /**
     * désactiver un abonnement
     *
     * @return \Illuminate\Http\Response
     */
    public function desactive($id)
    {

        if (Abonnement::where(['id' => $id, 'isDelete' => 0])->exists()) {

            $abonnement = Abonnement::where(['id' => $id, 'isDelete' => 0])->first();

            // traitement des données
            $abonnement->update([
                "isActive" => 0,
            ]);

            return response()->json([
                "Status" => 1,
                "Alert" => 'Abonnement  désactivé avec succès',
            ]);

        } else {
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun abonnement  trouvé',
            ]);
        }

    }

    /**
     * afficher tous les abonnement  activé
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllActive()
    {

        if (Abonnement::where(['isActive' => 1, 'isDelete' => 0])->exists()) {

            $abonnement = Abonnement::where(['isActive' => 1, 'isDelete' => 0])->get();
            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les abonnement  activé affichés  avec succès',
                "description" => 'Details de tous les abonnement  activé',
                "data" => $abonnement,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun abonnement  activé trouvé',
            ]);
        }

    }

    /**
     * afficher un abonnement  activé
     *
     * @return \Illuminate\Http\Response
     */
    public function showOneActive($id)
    {

        if (Abonnement::where(['id' => $id, 'isActive' => 1, 'isDelete' => 0])->exists()) {

            $abonnement = Abonnement::where(['id' => $id, 'isActive' => 1, 'isDelete' => 0])->get();

            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'abonnement  activé trouvé avec succès',
                "description" => 'Details du abonnement  activé',
                "data" => $abonnement,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun abonnement  activé trouvé',
            ]);
        }

    }

    /**
     * afficher tous les abonnement désactivé
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllDesactive()
    {

        if (Abonnement::where(['isActive' => 0, 'isDelete' => 0])->exists()) {

            $abonnement = Abonnement::where(['isActive' => 0, 'isDelete' => 0])->get();
            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'Tous les abonnement  désactivé affichés  avec succès',
                "description" => 'Details de tous les abonnement  désactivé',
                "data" => $abonnement,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun abonnement  désactivé trouvé',
            ]);
        }

    }

    /**
     * afficher un abonnement  désactivé
     *
     * @return \Illuminate\Http\Response
     */
    public function showOneDesactive($id)
    {

        if (Abonnement::where(['id' => $id, 'isActive' => 0, 'isDelete' => 0])->exists()) {

            $abonnement = Abonnement::where(['id' => $id, 'isActive' => 0, 'isDelete' => 0])->get();

            // reponse
            return response()->json([
                "Status" => 1,
                "Alert" => 'abonnement  désactivé trouvé avec succès',
                "description" => 'Details du abonnement  désactivé',
                "data" => $abonnement,
            ]);

        } else {
            // reponse
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun abonnement  désactivé trouvé',
            ]);
        }

    }
    /**
     * supprimer un abonnement
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        if (Abonnement::where(['id' => $id, 'isDelete' => 0])->exists()) {
            $abonnement = Abonnement::where(['id' => $id, 'isDelete' => 0])->first();

            // traitement des données
            $abonnement->update([
                "isDelete" => 1,
            ]);
            return response()->json([
                "Status" => 1,
                "Alert" => 'abonnement supprimé avec succès',
            ]);

        } else {
            return response()->json([
                "Status" => 0,
                "Alert" => 'Aucun abonnement trouvé',
            ]);
        }

    }

}

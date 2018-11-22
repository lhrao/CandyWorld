<?php

namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\Session;
use App\metier\Frais;
use App\metier\FraisHorsForfait;

class FraisHorsForfaitController extends Controller {

    /**
     * Affiche la liste de tous les Frais Hors Forfait
     * d'un fiche de Frais
     * @param type $id_frais Id de la fiche de Frais dont
     * on veut la liste des FHF
     * @return type Vue listeFraisHorsForfait
     */
    public function getAllFHF($id_frais) {
        $erreur = "";
        $unFHF = new FraisHorsForfait();
        // On récupère la liste de tous les mangas
        $mesFraisHorsForfait = $unFHF->getAllFHF($id_frais);
        // On affiche la liste des Frais Hors Forfait       
        $montantTotal = 0;
        foreach ($mesFraisHorsForfait as $fhf){
            $montantTotal = $montantTotal + $fhf->montant_fraishorsforfait;
        }
        return view('listeFraisHorsForfait', compact('mesFraisHorsForfait', 'id_frais', 'erreur', 'montantTotal'));
    }

    /**
     * Initialise le formulaire d'un Frais Hors Forfait pour la modification
     * Lit le FHF surson id passé en paramètre
     * Initialise le titre du formulaire
     * @param type $id Id du FHF à modifier
     * @return type Vue formFraisHorsForfait
     */
    public function updateFHF($id_fraishorsforfait) {
        $erreur = '';
        $unFHF = new FraisHorsForfait();
        $unFHF = $unFHF->getById($id_fraishorsforfait);
        $titreVue = "Modification d'une fiche de Frais Hors Forfait";
        // Affiche le formulaire en lui fournissant les données à afficher
        return view('formFraisHorsForfait', compact('unFHF', 'titreVue', 'erreur'));
    }

    /**
     * Initialise le formulaire d'un Frais Hors Forfait pour un ajout
     * Instancie un FHF et lui affecte l'id de la fiche de Frais
     * dont il dépend. Cet id sera placé dans un INPUT HIDDEN
     * Initialise le titre du formulaire
     * @param type $id Id de la fiche de Frais
     * @return type Vue formFraisHorsForfait
     */
    public function addFHF($id_frais) {
        $erreur = '';
        $unFHF = new FraisHorsForfait();
        $unFHF->id_frais = $id_frais;
        $titreVue = "Ajout d'une fiche de Frais Hors Forfait";
        // Affiche le formulaire en lui fournissant les données à afficher
        return view('formFraisHorsForfait', compact('unFHF', 'titreVue', 'erreur'));
    }

    /**
     * Enregistre une modification ou un ajout
     * Récupère les données saisies dans les INPUT
     * Si l'id > 0 c'est une modification, sinon c'est un ajout
     * Réaffiche la liste des FHF de la fiche de Frais
     * @return type route /getListeFraisHorsForfait
     */
    public function validateFHF() {
        $id_frais = Request::input('id_frais');
        $unFrais = new Frais();
        $id_fraishorsforfait = Request::input('id_fraishorsforfait');
        $lib_fraishorsforfait = Request::input('lib_fraishorsforfait');
        $date_fraishorsforfait = Request::input('date_fraishorsforfait');
        $montant_fraishorsforfait = Request::input('montant_fraishorsforfait');
        $unFHF = new FraisHorsForfait();
        if ($id_fraishorsforfait > 0) {
            $unFHF->updateFHF($id_fraishorsforfait, $lib_fraishorsforfait, $date_fraishorsforfait, $montant_fraishorsforfait);
        } else {
            $unFHF->insertFHF($lib_fraishorsforfait, $date_fraishorsforfait, $montant_fraishorsforfait, $id_frais);
        }
        // Affiche la liste des FHF de la fiche de Frais en cours
        return redirect('/getListeFraisHorsForfait/' . $id_frais);
    }

    /**
     * Supression d'un frais hors forfait sur son Id
     * On passe aussi l'id de la fiche de Frais pour pouvoir
     * retourner à la liste des FHF de la fiche Frais après suppression
     * On utilise le gestionnaire d'exception même si on n'en a pas besoin
     * car il n'y a pas de contrainte, mais simplement pour illuster let
     * fonctionnemende la gestion du retour
     * @param type $id_fraishorsforfait Id du FHF à supprimer
     * @return type Vue getListeFraisHorsForfait ou getErrors
     */
    public function deleteFHF($id_fraishorsforfait, $id_frais) {
        $unFHF = new FraisHorsForfait();
        try {
            $unFHF->deleteFHF($id_fraishorsforfait);
            return redirect('/getListeFraisHorsForfait/'.$id_frais);
        } catch (Exception $ex) {
            Session::put('erreur', $ex->getMessage());
            $retour = 'getListeFraisHorsForfait/'.$id_frais;
            return redirect()->route('/getErrors', ['retour' => $retour]);
        }
    }    
    
}

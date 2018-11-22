<?php

namespace App\Http\Controllers;

use App\Exceptions\MonException;
use Request;
use Illuminate\Support\Facades\Session;
use App\metier\Frais;
use Exception;

class FraisController extends Controller {

    /**
     * Affiche la liste de toutes les fiches
     * de Frais du visiteur connecté
     * @return type Vue listeFrais
     */
    public function getFraisVisiteur() {
        try {
            $erreur = Session::get('erreur');
            Session::forget('erreur');
            $unFrais = new Frais();
            $id_visiteur = Session::get('id');
            // On récupère la liste de tous les frais
            $mesFrais = $unFrais->getFrais($id_visiteur);
            // On affiche la liste de ces frais
            return view('listeFrais', compact('mesFrais', 'erreur'));
        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact ('monErreur'));
        } catch (Exception $e) {
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        }
    }
/**
    /**
     * Initialise le formulaire de Frais pour une modification
     * Lit la fiche de Frais
     * Initialise le titre de la vue
     * @param type $id Id de la fiche de Frais à modifier
     * @return type Vue formFrais
     */
    public function updateFrais($id_frais) {
        try {
            $erreur = "";
            $unFrais = new Frais();
            $unFrais = $unFrais->getById($id_frais);
            $titreVue = "Modification d'une fiche de Frais";
            // Affiche le formulaire en lui fournissant les données à afficher
            return view('formFrais', compact('unFrais', 'titreVue', 'erreur'));
        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        } catch (Exception $e) {
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        }

    }

    /**
     * Initialise le formulaire de Frais pour un ajout
     * @return type Vue formFrais
     */
    public function addFrais() {
        try {
            $unFrais = new Frais();
            $titreVue = "Ajout d'une fiche de Frais";
            // Affiche le formulaire en lui fournissant les données à afficher
            return view('formFrais', compact('unFrais', 'titreVue'));
        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return  view ('vues/pageErreur', compact('monErreur'));
        } catch (Exception $e) {
            $monErreur = $e->getMessage();
            return view ('vues/pageErreur', compact('monErreur'));
        }

    }

    /**
     * Enregistre un ajout ou une modification d'une fiche de Frais
     * Si id_frais > 0 c'est une modification, sinon
     * c'est un ajout. Id_frais est dans un INPUT HIDDEN
     * @return type route /getListeFrais 
     */
    public function validateFrais() {
        try {
            $id_frais = Request::input('id_frais');
            $anneemois = Request::input('anneemois');
            $nbjustificatifs = Request::input('nbjustificatifs');
            $unFrais = new Frais();
            if ($id_frais > 0) {
                $unFrais->updateFrais($id_frais, $anneemois, $nbjustificatifs);
            } else {
                $id_visiteur = Session::get('id');
                $unFrais->insertFrais($anneemois, $nbjustificatifs, $id_visiteur);
            }
            // Retourne à la liste des des Frais
            return redirect('/getListeFrais');
        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        } catch (Exception $e) {
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        }
    }

    /**
     * Supression d'une fiche de frais sur son Id
     * Si la fiche de Frais a des lignes, cela produira une erreur
     * à cause de la contrainte d'intégrité référentielle, on 
     * fournria alors à la vue errors le message et l'url de retour
     * @param type $id_frais Id d e la fiche de Frais à supprimer
     * @return type Vue getListeFrais ou getErrors
     */
    public function deleteFrais($id_frais) {
        $unFrais = new Frais();
        try {
            $unFrais->deleteFrais($id_frais);
        } catch (Exception $ex) {
            Session::put('erreur', $ex->getMessage());
        } finally {
            return redirect('/getListeFrais');
        }
    }
}

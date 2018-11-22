<?php

namespace App\metier;

use App\Exceptions\MonException;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\QueryException;

class Frais extends Model {

    //On déclare la table Frais
    protected $table = 'frais';
    public $timestamps = false;
    private $id_frais;
    protected $fillable = [
        'id_frais',
        'id_etat',
        'anneemois',
        'id_visiteur',
        'nbjustificatifs',
        'datemodification',
        'montant_valide'
    ];

    public function __construct() {
        $this->id_frais = 0;
    }

    /**
     * Lecture de toutes les fiches de Frais 
     * d'un visiteur dont l'id est passé en paramètre
     * @param type $id_visiteur id du visiteur
     * @return type Collection de Frais
     */
    public function getFraisVisiteur($id_visiteur) {
        try {
            $lesFrais = DB::table('frais')
                ->Select()
                ->where('frais.id_visiteur', '=', $id_visiteur)
                ->get();
            return $lesFrais;
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(),5);
        }
    }

    /**
     * Lecture d'une fiche de Frais dont 
     * on a passé l'Id en paramètre
     * @param type $id_frais : Id de la fiche de Frais à lire
     * @return type : objet Frais
     */
    public function getById($id_frais) {
        $unFrais = DB::table('frais')
                ->Select()
                ->where('frais.id_frais', '=', $id_frais)
                ->first();
        return $unFrais;
    }

    /**
     * Mise à jour d'une fiche de Frais
     * @param type $id_frais : id de la fiche de Frais à modifier
     * @param type $anneemois : période de la fiche de Frais à modifier
     * @param type $nbjustificatifs : Nb justificatifs de la fiche de Frais à modifier
     */
    public function updateFrais($id_frais, $anneemois, $nbjustificatifs) {
        try {
            $dateJour = date("Y-m-d");
            DB::table('frais')->where('id_frais', '=', $id_frais)
                ->update(['anneemois' => $anneemois, 'nbjustificatifs' => $nbjustificatifs,
                    'datemodification' => $dateJour]);
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }

    }
    
    /**
     * Ajout d'une fiche de Frais
     * @param type $anneemois : période de la fiche de Frais à ajouter
     * @param type $nbjustificatifs : Nb justificatifs de la fiche de Frais à ajouter
     * @param type $id_visiteur : id du visiteur de la fiche de Frais à ajouter
     */    
    public function insertFrais($anneemois, $nbjustificatifs, $id_visiteur){
        $dateJour = date("Y-m-d");
        DB::table('frais')->insert(
                ['id_etat' => 1, 'anneemois' => $anneemois,
                'nbjustificatifs' => $nbjustificatifs, 
                'datemodification' => $dateJour, 'id_visiteur'=> $id_visiteur,
                'montantvalide'=> 0]
        );        
    }   
    
    /**
     * Suppression d'une fiche de Frais
     * @param type $id_frais : Id de la fiche de frais à supprimer
     */
    public function deleteFrais($id_frais){
        try {
            DB::table('frais')->where('id_frais', '=', $id_frais)->delete();
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(),5);
        }

    }

    /**
     * Ajoute le montant d'un FHF au montant validé
     * @param type $id_frais
     * @param type $newMontant
     * @param type $oldMontant
     */
    public function majMontant($id_frais, $newMontant, $oldMontant = 0){
        $montant = $newMontant;
        if ($oldMontant > 0){
            $montant = $oldMontant + $newMontant;
        }
        DB::table('frais')->where('id_frais', '=', $id_frais)
            ->update(['montantvalide' => $montant]);
    }
}

?>

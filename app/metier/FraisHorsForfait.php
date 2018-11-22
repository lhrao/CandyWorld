<?php

namespace App\metier;

use Illuminate\Database\Eloquent\Model;
use DB;

class FraisHorsForfait extends Model {

    protected $table = 'fraishorsforfait';
    private $id_fraishorsforfait;
    public $timestamps = false;
    protected $fillable = [
        'id_fraishorsforfait',
        'id_frais',
        'date_fraishorsforfait',
        'montant_fraishorsforfait',
        'lib_fraishorsforfait'
    ];

    /**
     * Constructeur : initialise la clé primaire à 0
     * Utilisé lors de l'ajout d'un FHF
     */
    public function __construct() {
        $this->id_fraishorsforfait = 0;
    }

    /**
     * Lecture d'un FHF sur son Id
     * @param type $id_fraishorsforfait : Id du FHF à lire
     * @return type : Objet FraisHorsForfait
     */
    public function getById($id_fraishorsforfait) {
        $unFHF = DB::table('fraishorsforfait')
                ->select()
                ->where('id_fraishorsforfait', '=', $id_fraishorsforfait)
                ->first();
        return $unFHF;
    }

    /**
     * Lecture de tous les FHF d'une fiche de Frais
     * dont on a passé l'Id en paramètre
     * @return type Collection de FHF
     */
    public function getAllFHF($id_frais) {
        $mesFHFs = DB::table('fraishorsforfait')
                ->Select()
                ->where('id_frais', '=', $id_frais)
                ->get();
        return $mesFHFs;
    }


    /**
     * Mise à jour d'un FHF
     * @param type $id_fraishorsforfait : id du FHF à modifier
     * @param type $lib_fraishorsforfait : libellé du FHF à modifier
     * @param type $date_fraishorsforfait : date du FHF à modifier
     * @param type $montant_fraishorsforfait : montant du FHF à modifier
     */
    public function updateFHF($id_fraishorsforfait, $lib_fraishorsforfait, $date_fraishorsforfait, $montant_fraishorsforfait) {
        DB::table('fraishorsforfait')->where('id_fraishorsforfait', '=', $id_fraishorsforfait)
                ->update(['lib_fraishorsforfait' => $lib_fraishorsforfait, 'date_fraishorsforfait' => $date_fraishorsforfait,
                    'montant_fraishorsforfait' => $montant_fraishorsforfait]);
    }

    /**
     * Suppression d'un FHF sur son Id
     * @param type $id_fraishorsforfait : Id du FHF à supprimer
     */
    public function deleteFHF($id_fraishorsforfait) {
        DB::table('fraishorsforfait')->where('id_fraishorsforfait', '=', $id_fraishorsforfait)
                ->delete();
    }

    /**
     * Insertion d'un FHF
     * @param type $lib_fraishorsforfait : libellé du FHF à ajouter
     * @param type $date_fraishorsforfait : date du FHF à ajouter
     * @param type $montant_fraishorsforfait : montant du FHF à ajouter
     * @param type $id_frais: Id de la fiche de Frais du FHF à ajouter
     */
    public function insertFHF( $lib_fraishorsforfait, $date_fraishorsforfait, $montant_fraishorsforfait, $id_frais) {
        DB::table('fraishorsforfait')->insert(
                ['lib_fraishorsforfait' => $lib_fraishorsforfait, 'date_fraishorsforfait' => $date_fraishorsforfait,
                    'montant_fraishorsforfait' => $montant_fraishorsforfait, 'id_frais' => $id_frais]
        );
    }

}

<?php

namespace App\metier;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Exceptions\MonException;

class Client extends Model {

    //On déclare la table visiteur
    protected $table = 'client';
    public $timestamps = false;
    protected $fillable = [
        'idcli',
        'nomcli',
        'prenomcli',
        'adrcli',
        'telcli',
        'cpcli',
        'logincli',
        'mailcli',
        'mdpcli',
    ];

    public function login($logincli, $mdpcli) {
        $connected = false;
        $client = DB::table('client')
                ->select()
                ->where('logincli', '=', $logincli)
                ->first();
        if ($client) {
            if ($client->mdpcli == md5($mdpcli)) {
                Session::put('id', $client->idcli);
                $connected = true;
            }
        }
        return $connected;
    }

    public function logout(){
        Session::put('id', 0);
    }

    public function ajoutClient($nomcli,$prenomcli,$adrcli,$telcli,$cpcli,$logincli,$mailcli,$mdpcli){
        try{
            DB::table('client')->insert(
                [
                    'nomcli'=>$nomcli,
                    'prenomcli'=>$prenomcli,
                    'adrcli'=>$adrcli,
                    'telcli'=>$telcli,
                    'cpcli'=>$cpcli,
                    'logincli'=>$logincli,
                    'mailcli'=>$mailcli,
                    'mdpcli'=>md5($mdpcli),
                ]);
        }catch(\Illuminate\Database\QueryException $e){
            throw new MonException($e->getMessage(),5);
        }
    }
}
?>


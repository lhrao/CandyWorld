<?php

namespace App\Http\Controllers;
use Request;

use App\metier\Client;
use App\Exceptions\MonException;

class ClientController extends Controller
{

    /**
     * Authentifie le visiteur
     * @return type Vue formLogin ou home
     */
    public function login()
    {
        $logincli = Request::input('logincli');
        $mdpcli = Request::input('mdpcli');
        $unClient = new Client();
        $connected = $unClient->login($logincli, $mdpcli);
        if ($connected) {
            return view('home');
        } else {
            $erreur = "Login ou mot de passe inconnu !";
            return view('formLogin', compact('erreur'));
        }
    }

    /**
     * Déconnecte le visiteur authentifié
     * @return type Vue home
     */
    public function logout()
    {
        $unClient = new Client();
        $unClient->logout();
        return view('home');
    }

    /**
     * Initialise le formulaire d'authentification
     * @return type Vue formLogin
     */
    public function getLogin()
    {
        $erreur = "";
        return view('formLogin', compact('erreur'));
    }

    public function getPostClient()
    {
        $erreur = "";
        return view('formClient', compact('erreur'));
    }

    public function postClient()
    {
        try {
            $nomcli = Request::input("nom");
            $prenomcli = Request::input("prenom");
            $adrcli = Request::input("adr");
            $cpcli = Request::input("cp");
            $telcli = Request::input("tel");
            $logincli = Request::input("login");
            $mailcli = Request::input("mail");
            $mdpcli = Request::input("mdp");
            $unClient = new Client();
            $unClient->ajoutClient($nomcli, $prenomcli, $adrcli, $telcli, $cpcli, $logincli, $mailcli, $mdpcli);
        } catch (MonException $e) {
            $erreur = $e->getMessage();
            return view('error', compact('erreur'));
        }
    }
}


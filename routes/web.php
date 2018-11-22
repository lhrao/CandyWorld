<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('home');
});

// Afficher le formulaire d'authentification 
Route::get('/getLogin', 'ClientController@getLogin');

// Authentifie le visiteur à partir du login et mdp saisis
Route::post('/login', 'ClientController@login');

// Déloguer le visiteur
Route::get('/logout', 'ClientController@logout');

Route::get('/getPostClient', 'ClientController@getPostClient');

Route::post('/postClient', 'ClientController@postClient');

// Rediriger vers une vue qui affichera une erreur.
// Important : il faut renommer la route avec as => nomRoute pour que
// le redirect()->route() fonctionne (voir la méthode getErreurs())
Route::get('/getErrors/{retour}', ['as' => '/getErrors', 'uses' => 'ErrorsController@getErreurs']);






// Afficher la liste des fiches de Frais du visiteur connecté
Route::get('/getListeFrais', 'FraisController@getFraisVisiteur');

// Afficher le formulaire d'une fiche de Frais pour une modification
Route::get('/modifierFrais/{id_frais}', 'FraisController@updateFrais');

// Afficher le formulaire d'une fiche de Frais pour un ajout
Route::get('/ajouterFrais/', 'FraisController@addFrais');

// Enregistrer une modification ou un ajout d'une fiche de Frais
Route::post('/validerFrais', 'FraisController@validateFrais');

// Supprimer une fiche de Frais
Route::get('/supprimerFrais/{id_frais}', 'FraisController@deleteFrais');

// Afficher la liste des frais hors forfait d'une fiche de Frais
Route::get('/getListeFraisHorsForfait/{id_frais}', 'FraisHorsForfaitController@getAllFHF');

// Afficher le formulaire d'un Frais Hors Forfait pour une modification
Route::get('/modifierFraisHorsForfait/{id_fraishorsforfait}', 'FraisHorsForfaitController@updateFHF');

// Afficher le formulaire d'un Frais Hors Forfait pour un ajout
Route::get('/ajouterFraisHorsForfait/{id_frais}', 'FraisHorsForfaitController@addFHF');

// Enregistrer une modification ou un ajout d'un Frais Hors Forfait
Route::post('/validerFraisHorsForfait', 'FraisHorsForfaitController@validateFHF');

// Supprimer un Frais Hors Forfait
Route::get('/supprimerFraisHorsForfait/{id_fraishorsforfait}/{id_frais}', 'FraisHorsForfaitController@deleteFHF');

// Retourner à une vue dont on passe le nom en paramètre
Route::get('getRetour/{retour}', function($retour){
    return redirect("/".$retour);
});



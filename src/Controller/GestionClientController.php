<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace APP\Controller;

use APP\Model\GestionClientModel;
use ReflectionClass;
use Exception;
use Tools\MyTwig;

/**
 * Description of GestionClientController
 *
 * @author dussart.luke
 */
class GestionClientController
{

  public function chercheUn(array $params): void
  {
    // appel de la méthode find($id) de la classe Model adequate 
    $model = new GestionClientModel();
    $id = filter_var(intval($params['id']), FILTER_VALIDATE_INT);
    $unClient = $model->find($id);
    if ($unClient) {
      $r = new ReflectionClass($this);
      $vue = str_replace('Controller', 'View', $r->getShortName()) . "/unClient.html.twig";
      MyTwig::afficheVue($vue, array('unClient' => $unClient));
    } else {
      throw new Exception("Client" . $id . " inconnu");
    }
  }

  public function chercheTous()
  {
    // appel de la méthode findAll() de la classe Model adequate
    $model = new GestionClientModel();
    $clients = $model->FindAll();
    if ($clients) {
      $r = new ReflectionClass($this);
      include_once PATH_VIEW . str_replace('Controller', 'View', $r->getShortName()) . "/plusieursClients.php";
    } else {
      throw new Exception("Aucun client à afficher");
    }
  }
  
  public function creerClient(array $params){
    $vue = "GestionClientView\\creerClient.html.twig";
    MyTwig::afficheVue($vue, array());
  }
  
  public function enregistreClient(array $params){
    // creation de l'objet Client
    $client = new Client($params);
    $modele = new GestionClientModel();
    $modele->enregistreClient($client);
  }
}

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
use Tools\Repository;
use APP\Entity\Client;

/**
 * Description of GestionClientController
 *
 * @author dussart.luke
 */
class GestionClientController {

  public function chercheUn(array $params): void {
    $repository = Repository::getRepository("APP\Entity\Client");
    $ids = $repository->findIds();
    // on place ces ids dans le tableau de paramètres que l'on va envoyer à la vue
    $params['lesId'] = $ids;
    // on teste si l'id du client à chercher a été passé dans l'URL
    if (array_key_exists('id', $params)) {
      $id = filter_var(intval($params['id']), FILTER_VALIDATE_INT);
      $unClient = $repository->find($id);
      // on place le client trouvé dans le tableau de paramètres que l'on va envoyer à la vue
      $params['unClient'] = $unClient;
    }
    $r = new ReflectionClass($this);
    $vue = str_replace('Controller', 'View', $r->getShortName()) . "/unClient.html.twig";
    MyTwig::afficheVue($vue, $params);
  }

  public function chercheTous() {
    // appel de la méthode findAll() de la classe Model adequate
    $repository = Repository::getRepository("APP\Entity\Client");
    $clients = $repository->FindAll();
    if ($clients) {
      $r = new ReflectionClass($this);
      $vue = str_replace('Controller', 'View', $r->getShortName()) . "/plsClients.html.twig";
      MyTwig::afficheVue($vue, array('clients' => $clients));
      //include_once PATH_VIEW . str_replace('Controller', 'View', $r->getShortName()) . "/plusieursClients.php";
    } else {
      throw new Exception("Aucun client à afficher");
    }
  }

  public function creerClient(array $params) {
    if(empty($params)){
    $vue = "GestionClientView\\creerClient.html.twig";
    MyTwig::afficheVue($vue, array());
    } else {
      // creation de l'objet client
      $client = new Client($params);
      $repository = Repository::getRepository("APP\Entity\Client");
      $repository->insert($client);
      $this->chercheTous();
    }
    
  }

  public function enregistreClient(array $params) {
    // creation de l'objet Client
    $client = new Client($params);
    $modele = new GestionClientModel();
    $modele->enregistreClient($client);
  }

  public function testFindBy($params){
    $repository = Repository::getRepository("APP\Entity\Client");
    $params = array("titreCli" => "Monsieur", "villeCli" => "Toulon");
    $clients = $repository->findBytitreCli_and_villeCli($params);
    $r = new ReflectionClass($this);
    $vue = str_replace('Controller', 'View', $r->getShortName()) . "/tousClients.html.twig";
    MyTwig::afficheVue($vue, array('lesClients' => $clients));
  }
  
  public function rechercheClients($params){
    $repository = Repository::getRepository("APP\Entity\Client");
    $titres = $repository->findColumnDistinctValues('titreCli');
    $cps = $repository->findColumnDistinctValues('cpCli');
    $villes = $repository->findColumnDistinctValues('villeCli');
    $params["titres"] = $titres;
    $params["cps"] = $cps;
    $params["villes"] = $villes;
    if(isset($params['titreCli']) || isset($params['cpCli']) || isset($params['villeCli'])){
      // c'est le retour du formulaire de choix de filtre
      $element = "Choisir ...";
      while(in_array($element, $params)){
        unset($params[array_search($element,$params)]);
      }
      if(count($params) > 0){
        $clients = $repository->findBy($params);
        $paramsVue['lesClients'] = $clients;
        foreach($_POST as $valeur){
          ($valeur != "Choisir ...") ? ($criteres[] = $valeur) : (null);
        }
        $paramsVue['criteres'] = $criteres;
      }
    }
    $vue = "GestionClientView\\filtreClients.html.twig";
    MyTwig::afficheVue($vue, $params);
  }
  
  public function recupereDesClients($params){
    $repository = Repository::getRepository("APP\Entity\Client");
    $clients = $repository->findBy($params);
    $r = new ReflectionClass($this);
    $vue = str_replace('Controller', 'View', $r->getShortName()) . "/tousClients.html.twig";
    MyTwig::afficheVue($vue, array('lesClients' => $clients));
  }
}

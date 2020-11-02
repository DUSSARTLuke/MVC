<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace APP\Controller;

use APP\Model\GestionCommandeModel;
use ReflectionClass;
use Exception;
use Tools\MyTwig;
use Tools\Repository;

class GestionCommandeController {

  public function chercheUne($params) {
    $repository = Repository::getRepository("APP\Entity\Commande");
    $ids = $repository->findIds();
    // on place ces ids dans le tableau de paramètres que l'on va envoyer à la vue
    $params['lesId'] = $ids;
    // on teste si l'id du client à chercher a été passé dans l'URL
    if (array_key_exists('id', $params)) {
      $id = filter_var(intval($params['id']), FILTER_VALIDATE_INT);
      $uneCommande = $repository->find($id);
      // on place le client trouvé dans le tableau de paramètres que l'on va envoyer à la vue
      $params['unCommande'] = $uneCommande;
    }
    $r = new ReflectionClass($this);
    $vue = str_replace('Controller', 'View', $r->getShortName()) . "/uneCommande.html.twig";
    MyTwig::afficheVue($vue, $params);
  }

  public function chercheToutes() {
    $model = new GestionCommandeModel();
    $commandes = $model->findAllCommande();
    if ($commandes) {
      $r = new ReflectionClass($this);
      include_once PATH_VIEW . str_replace('Controller', 'View', $r->getShortName()) . "/plusieursCommandes.php";
    } else {
      throw new Exception("Aucune Commande a afficher");
    }
  }

}

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

class GestionCommandeController {

    public function chercheUne($param) 
    {
        $model = new GestionCommandeModel();
        $id = filter_var(intval($param["id"]), FILTER_VALIDATE_INT);
        $uneCommande = $model->findCommande($id);
        if ($uneCommande)
        {
            $r = new ReflectionClass($this);
            include_once PATH_VIEW . str_replace('Controller', 'View', $r->getShortName()) . "/uneCommande.php";
        }
        else
        {
            throw new Exception("Commande " . $id . " inconnu"); 
        }  
    }
    
    public function chercheToutes()
    {
        $model = new GestionCommandeModel();
        $commandes = $model->findAllCommande();
        if($commandes)
        {
            $r = new ReflectionClass($this);
            include_once PATH_VIEW . str_replace('Controller', 'View', $r->getShortName()) . "/plusieursCommandes.php";
        }
        else
        {
            throw new Exception("Aucune Commande a afficher");
        }
    }
    
}
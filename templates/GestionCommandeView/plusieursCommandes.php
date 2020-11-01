<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//include_once PATH_VIEW . "header.html";
echo "<p>Nombre de commandes trouvés" . count($commandes) . "</p>";
foreach ($commandes as $commande)
{
    echo $commande->getId() . " " . $commande->getTitreCli() . " " . $commande->getPrenomCli() . " " . $ccommande->getNomCLi() . "<br>"; 
}
//include_once PATH_VIEW . "footer.html";
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tools;

use Tools\Connexion;
use PDO;

/**
 * Description of Repository
 *
 * @author asus
 */
class Repository {
  
  private $classeNameLong;
  private $classeNamespace;
  private $table;
  private $connexion;
  
  public function __construct(string $entity) {
    $tablo = explode("\\", $entity);
    $this->table = array_pop($tablo);
    $this->classeNamespace = implode("\\", $tablo);
    $this->classeNameLong = $entity;
    $this->connexion = Connexion::getConnexion();
  }
  
  public static function getRepository(string $entity){
    $repositoryName = str_replace('Entity', 'Repository', $entity) . 'Repository';
    $repository = new $repositoryName($entity);
    return $repository;
  }
  
  public function findAll(){
    $sql = "select * from " .$this->table;
    $lignes = $this->connexion->query($sql);
    $lignes->setFetchMode(PDO::FETCH_CLASS, $this->classeNameLong, null);
    return $lignes->fetchAll();
  }
  
  public function find(int $id){
    $sql = "select * from " .$this->table . "where id= :id";
    $ligne = $this->connexion->uqery($sql);
    $ligne->bindValue(':id', $id, PDO::PARAM_INT);
    $ligne->execute();
    return $ligne->fetchObject($this->classeNameLong);
    return self::pdo_debugStrParams($ligne);
  }
}

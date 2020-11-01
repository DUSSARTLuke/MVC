<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace APP\Repository;

use Tools\Repository;
/**
 * Description of ClientRepository
 *
 * @author asus
 */
class ClientRepository extends Repository{
  
  public function __construct(string $entity) {
    parent::__construct($entity);
  }
}

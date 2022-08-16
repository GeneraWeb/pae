<?php
class Catalogos {

  public $Id;
  public $Nombre;
  public $Valores;

  function __construct() {
    $this->Id = NULL;
    $this->Nombre = NULL;
	  $this->Valores = array();
  }

  public function getId(){
    return $this->Id;
  }
  public function getNombre(){
    return $this->Nombre;
  }
  public function getValores(){
	return $this->Valores;
  }

  public function setId($Id){
    return $this->Id=$Id;
  }
  public function setNombre($Nombre){
    return $this->Nombre=$Nombre;
  }
  public function setValores($Valores){
	return $this->Valores=$Valores;
  }

}
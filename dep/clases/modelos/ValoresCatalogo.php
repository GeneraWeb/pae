<?php
class ValoresCatalogo {

  public $Id;
  public $Catalogo;
  public $Valor;
  public $Orden;

  function __construct() {
    $this->Id = NULL;
    $this->Catalogo = NULL;
    $this->Valor = NULL;
    $this->Orden = NULL;
  }

  public function getId(){
    return $this->Id;
  }
  public function getCatalogo(){
    return $this->Catalogo;
  }
  public function getValor(){
    return $this->Valor;
  }
  public function getOrden(){
    return $this->Orden;
  }

  public function setId($Id){
    return $this->Id=$Id;
  }
  public function setCatalogo($Catalogo){
    return $this->Catalogo=$Catalogo;
  }
  public function setValor($Valor){
    return $this->Valor=$Valor;
  }
  public function setOrden($Orden){
    return $this->Orden=$Orden;
  }

}
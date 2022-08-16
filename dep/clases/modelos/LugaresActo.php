<?php
class LugaresActo {

  public $Id;
  public $Acto;
  public $Pais;
  public $Estado;
  public $Municipio;
  public $Colonia;
  public $Localidad;
  public $Direccion;
  public $CodPostal;
  public $FechaLugarActo;
  public $Comentarios;
  public $Data;

  function __construct() {
    $this->Id = NULL;
    $this->Acto = NULL;
    $this->Pais = NULL;
    $this->Estado = NULL;
    $this->Municipio = NULL;
    $this->Colonia = NULL;
    $this->Localidad = NULL;
    $this->Direccion = NULL;
    $this->CodPostal = NULL;
    $this->FechaLugarActo = NULL;
    $this->Comentarios = NULL;
    $this->Data = NULL;
  }

  public function getId(){
    return $this->Id;
  }
  public function getActo(){
    return $this->Acto;
  }
  public function getPais(){
    return $this->Pais;
  }
  public function getEstado(){
    return $this->Estado;
  }
  public function getMunicipio(){
    return $this->Municipio;
  }
  public function getColonia(){
    return $this->Colonia;
  }
  public function getLocalidad(){
    return $this->Localidad;
  }
  public function getDireccion(){
    return $this->Direccion;
  }
  public function getCodPostal(){
    return $this->CodPostal;
  }
  public function getFechaLugarActo(){
    return $this->FechaLugarActo;
  }
  public function getComentarios(){
    return $this->Comentarios;
  }
  public function getData(){
    return $this->Data;
  }

  public function setId($Id){
    return $this->Id=$Id;
  }
  public function setActo($Acto){
    return $this->Acto=$Acto;
  }
  public function setPais($Pais){
    return $this->Pais=$Pais;
  }
  public function setEstado($Estado){
    return $this->Estado=$Estado;
  }
  public function setMunicipio($Municipio){
    return $this->Municipio=$Municipio;
  }
  public function setColonia($Colonia){
    return $this->Colonia=$Colonia;
  }
  public function setLocalidad($Localidad){
    return $this->Localidad=$Localidad;
  }
  public function setDireccion($Direccion){
    return $this->Direccion=$Direccion;
  }
  public function setCodPostal($CodPostal){
    return $this->CodPostal=$CodPostal;
  }
  public function setFechaLugarActo($FechaLugarActo){
    return $this->FechaLugarActo=$FechaLugarActo;
  }
  public function setComentarios($Comentarios){
    return $this->Comentarios=$Comentarios;
  }
  public function setData($Data){
    return $this->Data=$Data;
  }

}
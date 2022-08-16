<?php
class Personas {

  public $Id;
  public $Caso;
  public $RelacionCaso;
  public $Nombre;
  public $Sexo;
  public $Contacto;
  public $RelacionDesaparecido;
  public $AutorizacionDeFamiliares;
  public $Edad;
  public $FechaNac;
  public $Data;
  public $Fotos;

  function __construct() {
    $this->Id = NULL;
    $this->Caso = NULL;
    $this->RelacionCaso = NULL;
    $this->Nombre = NULL;
    $this->Sexo = NULL;
    $this->Contacto = array();
    $this->RelacionDesaparecido = NULL;
    $this->AutorizacionDeFamiliares = NULL;
    $this->Edad = NULL;
    $this->FechaNac = NULL;
    $this->Data = NULL;
    $this->Fotos = array();
  }

  public function getId(){
    return $this->Id;
  }
  public function getCaso(){
    return $this->Caso;
  }
  public function getRelacionCaso(){
    return $this->RelacionCaso;
  }
  public function getNombre(){
    return $this->Nombre;
  }
  public function getSexo(){
    return $this->Sexo;
  }
  public function getContacto(){
    return $this->Contacto;
  }
  public function getRelacionDesaparecido(){
    return $this->RelacionDesaparecido;
  }
  public function getAutorizacionDeFamiliares(){
    return $this->AutorizacionDeFamiliares;
  }
  public function getEdad(){
    return $this->Edad;
  }
  public function getFechaNac(){
    return $this->FechaNac;
  }
  public function getData(){
    return $this->Data;
  }
  public function getFotos(){
    return $this->Fotos;
  }

  public function setId($Id){
    return $this->Id=$Id;
  }
  public function setCaso($Caso){
    return $this->Caso=$Caso;
  }
  public function setRelacionCaso($RelacionCaso){
    return $this->RelacionCaso=$RelacionCaso;
  }
  public function setNombre($Nombre){
    return $this->Nombre=$Nombre;
  }
  public function setSexo($Sexo){
    return $this->Sexo=$Sexo;
  }
  public function setContacto($Contacto){
    return $this->Contacto=$Contacto;
  }
  public function setRelacionDesaparecido($RelacionDesaparecido){
    return $this->RelacionDesaparecido=$RelacionDesaparecido;
  }
  public function setAutorizacionDeFamiliares($AutorizacionDeFamiliares){
    return $this->AutorizacionDeFamiliares=$AutorizacionDeFamiliares;
  }
  public function setEdad($Edad){
    return $this->Edad=$Edad;
  }
  public function setFechaNac($FechaNac){
    return $this->FechaNac=$FechaNac;
  }
  public function setData($Data){
    return $this->Data=$Data;
  }
  public function setFotos($Fotos){
    return $this->Fotos=$Fotos;
  }

}
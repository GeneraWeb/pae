<?php
class Denuncia {

  public $Id;
  public $Caso;
  public $Tipo;
  public $Autoridad;
  public $Realizada;
  public $Fecha;
  public $RazonNoDenuncia;
  public $ObjRelaciona;
  public $IdObjRelaciona;
  public $IdsPersonas;

  function __construct() {
    $this->Id = NULL;
    $this->Caso = NULL;
    $this->Tipo = NULL;
    $this->Autoridad = NULL;
    $this->Realizada = NULL;
    $this->Fecha = NULL;
    $this->RazonNoDenuncia = NULL;
    $this->ObjRelaciona = NULL;
    $this->IdObjRelaciona = NULL;
    $this->IdsPersonas=array();
  }

  public function getId(){
    return $this->Id;
  }
  public function getCaso(){
    return $this->Caso;
  }
  public function getTipo(){
    return $this->Tipo;
  }
  public function getAutoridad(){
    return $this->Autoridad;
  }
  public function getRealizada(){
    return $this->Realizada;
  }
  public function getFecha(){
    return $this->Fecha;
  }
  public function getRazonNoDenuncia(){
    return $this->RazonNoDenuncia;
  }
  public function getObjRelaciona(){
    return $this->ObjRelaciona;
  }
  public function getIdObjRelaciona(){
    return $this->IdObjRelaciona;
  }
  public function getIdsPersonas(){
    return $this->IdsPersonas;
  }

  public function setId($Id){
    return $this->Id=$Id;
  }
  public function setCaso($Caso){
    return $this->Caso=$Caso;
  }
  public function setTipo($Tipo){
    return $this->Tipo=$Tipo;
  }
  public function setAutoridad($Autoridad){
    return $this->Autoridad=$Autoridad;
  }
  public function setRealizada($Realizada){
    return $this->Realizada=$Realizada;
  }
  public function setFecha($Fecha){
    return $this->Fecha=$Fecha;
  }
  public function setRazonNoDenuncia($RazonNoDenuncia){
    return $this->RazonNoDenuncia=$RazonNoDenuncia;
  }
  public function setObjRelaciona($ObjRelaciona){
    return $this->ObjRelaciona=$ObjRelaciona;
  }
  public function setIdObjRelaciona($IdObjRelaciona){
    return $this->IdObjRelaciona=$IdObjRelaciona;
  }
  public function setIdsPersonas($IdsPersonas){
    return $this->IdsPersonas=$IdsPersonas;
  }
}
<?php
class Logs {

  public $Id;
  public $Sesion;
  public $Fecha;
  public $Accion;
  public $Data;
  public $TipoObjeto;
  public $IdObjeto;

  function __construct() {
    $this->Id = NULL;
    $this->Sesion = NULL;
    $this->Fecha = NULL;
    $this->Accion = NULL;
    $this->Data = NULL;
    $this->TipoObjeto = NULL;
    $this->IdObjeto = NULL;
  }

  public function getId(){
    return $this->Id;
  }
  public function getSesion(){
    return $this->Sesion;
  }
  public function getFecha(){
    return $this->Fecha;
  }
  public function getAccion(){
    return $this->Accion;
  }
  public function getData(){
    return $this->Data;
  }
  public function getTipoObjeto(){
    return $this->TipoObjeto;
  }
  public function getIdObjeto(){
    return $this->IdObjeto;
  }

  public function setId($Id){
    return $this->Id=$Id;
  }
  public function setSesion($Sesion){
    return $this->Sesion=$Sesion;
  }
  public function setFecha($Fecha){
    return $this->Fecha=$Fecha;
  }
  public function setAccion($Accion){
    return $this->Accion=$Accion;
  }
  public function setData($Data){
    return $this->Data=$Data;
  }
  public function setTipoObjeto($TipoObjeto){
    return $this->TipoObjeto=$TipoObjeto;
  }
  public function setIdObjeto($IdObjeto){
    return $this->IdObjeto=$IdObjeto;
  }

}
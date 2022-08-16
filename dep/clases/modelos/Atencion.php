<?php
class Atencion {

  public $Id;
  public $Caso;
  public $Canal;
  public $FechaAtencion;
  public $Atendio;
  public $AccionRealizada;
  public $Descripcion;
  public $Canalizacion;

  function __construct() {
    $this->Id = NULL;
    $this->Caso = NULL;
    $this->Canal = NULL;
    $this->FechaAtencion = NULL;
    $this->Atendio = NULL;
    $this->AccionRealizada = NULL;
    $this->Descripcion = NULL;
    $this->Canalizacion = NULL;
  }

  public function getId(){
    return $this->Id;
  }
  public function getCaso(){
    return $this->Caso;
  }
  public function getCanal(){
    return $this->Canal;
  }
  public function getFechaAtencion(){
    return $this->FechaAtencion;
  }
  public function getAtendio(){
    return $this->Atendio;
  }
  public function getAccionRealizada(){
    return $this->AccionRealizada;
  }
  public function getDescripcion(){
    return $this->Descripcion;
  }
  public function getCanalizacion(){
    return $this->Canalizacion;
  }

  public function setId($Id){
    return $this->Id=$Id;
  }
  public function setCaso($Caso){
    return $this->Caso=$Caso;
  }
  public function setCanal($Canal){
    return $this->Canal=$Canal;
  }
  public function setFechaAtencion($FechaAtencion){
    return $this->FechaAtencion=$FechaAtencion;
  }
  public function setAtendio($Atendio){
    return $this->Atendio=$Atendio;
  }
  public function setAccionRealizada($AccionRealizada){
    return $this->AccionRealizada=$AccionRealizada;
  }
  public function setDescripcion($Descripcion){
    return $this->Descripcion=$Descripcion;
  }
  public function setCanalizacion($Canalizacion){
    return $this->Canalizacion=$Canalizacion;
  }

}
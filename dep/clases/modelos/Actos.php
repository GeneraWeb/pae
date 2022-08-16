<?php
class Actos {

  public $Id;
  public $Folio;
  public $Caso;
  public $TipoActo;
  public $FechaActoIni;
  public $ExactitudFechaActoIni;
  public $DetalleFechaActoIni;
  public $FechaActoFin;
  public $ExactitudFechaActoFin;
  public $DetalleFechaActoFin;
  public $Data;
  public $Lugares;
  public $IdsPersonas;

  function __construct() {
    $this->Id = NULL;
    $this->Folio = NULL;
    $this->Caso = NULL;
    $this->TipoActo = NULL;
    $this->FechaActoIni = NULL;
    $this->ExactitudFechaActoIni=NULL;
    $this->DetalleFechaActoIni = NULL;
    $this->FechaActoFin = NULL;
    $this->ExactitudFechaActoFin=NULL;
    $this->DetalleFechaActoFin = NULL;
    $this->Data = array();
    $this->Lugares = array();
    $this->IdsPersonas=array();
  }

  public function getId(){
    return $this->Id;
  }
  public function getFolio(){
    return $this->Folio;
  }
  public function getCaso(){
    return $this->Caso;
  }
  public function getTipoActo(){
    return $this->TipoActo;
  }
  public function getFechaActoIni(){
    return $this->FechaActoIni;
  }
  public function getExactitudFechaActoIni(){
    return $this->ExactitudFechaActoIni;
  }
  public function getDetalleFechaActoIni(){
    return $this->DetalleFechaActoIni;
  }
  public function getFechaActoFin(){
    return $this->FechaActoFin;
  }
  public function getExactitudFechaActoFin(){
    return $this->ExactitudFechaActoFin;
  }
  public function getDetalleFechaActoFin(){
    return $this->DetalleFechaActoFin;
  }
  public function getData(){
    return $this->Data;
  }
  public function getLugares(){
    return $this->Lugares;
  }
  public function getIdsPersonas(){
    return $this->IdsPersonas;
  }

  public function setId($Id){
    return $this->Id=$Id;
  }
  public function setFolio($Folio){
    return $this->Folio=$Folio;
  }
  public function setCaso($Caso){
    return $this->Caso=$Caso;
  }
  public function setTipoActo($TipoActo){
    return $this->TipoActo=$TipoActo;
  }
  public function setFechaActoIni($FechaActoIni){
    return $this->FechaActoIni=$FechaActoIni;
  }
  public function setExactitudFechaActoIni($ExactitudFechaActoIni){
    return $this->ExactitudFechaActoIni=$ExactitudFechaActoIni;
  }
  public function setDetalleFechaActoIni($DetalleFechaActoIni){
    return $this->DetalleFechaActoIni=$DetalleFechaActoIni;
  }
  public function setFechaActoFin($FechaActoFin){
    return $this->FechaActoFin=$FechaActoFin;
  }
  public function setExactitudFechaActoFin($ExactitudFechaActoFin){
    return $this->ExactitudFechaActoFin=$ExactitudFechaActoFin;
  }
  public function setDetalleFechaActoFin($DetalleFechaActoFin){
    return $this->DetalleFechaActoFin=$DetalleFechaActoFin;
  }
  public function setData($Data){
    return $this->Data=$Data;
  }
  public function setLugares($Lugares){
    return $this->Lugares=$Lugares;
  }
  public function setIdsPersonas($IdsPersonas){
    return $this->IdsPersonas=$IdsPersonas;
  }
}
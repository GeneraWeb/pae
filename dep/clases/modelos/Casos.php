<?php
class Casos {

  public $Id;
  public $Folio;
  public $Nombre;
  public $CantidadDesaparecidos;
  public $ParteDelColectivo;
  public $Nonce;
  public $ComoSeEntero;
  public $Data;
  public $LastUpdate;
  public $Personas;
  public $Actos;
  public $Denuncias;
  public $Atenciones;

  function __construct() {
    $this->Id = NULL;
    $this->Folio = NULL;
    $this->Nombre = NULL;
    $this->CantidadDesaparecidos = NULL;
    $this->ParteDelColectivo = NULL;
    $this->Nonce = NULL;
    $this->ComoSeEntero = NULL;
    $this->Data = array();
    $this->LastUpdate = NULL;
    $this->Personas = array();
    $this->Actos = array();
    $this->Denuncias = array();
    $this->Atenciones = array();
  }

  public function getId(){
    return $this->Id;
  }
  public function getFolio(){
    return $this->Folio;
  }
  public function getNombre(){
    return $this->Nombre;
  }
  public function getCantidadDesaparecidos(){
    return $this->CantidadDesaparecidos;
  }
  public function getParteDelColectivo(){
    return $this->ParteDelColectivo;
  }
  public function getNonce(){
    return $this->Nonce;
  }
  public function getComoSeEntero(){
    return $this->ComoSeEntero;
  }
  public function getData(){
    return $this->Data;
  }
  public function getLastUpdate(){
    return $this->LastUpdate;
  }
  public function getPersonas(){
    return $this->Personas;
  }
  public function getActos(){
    return $this->Actos;
  }
  public function getDenuncias(){
    return $this->Denuncias;
  }
  public function getAtenciones(){
    return $this->Atenciones;
  }

  public function setId($Id){
    return $this->Id=$Id;
  }
  public function setFolio($Folio){
    return $this->Folio=$Folio;
  }
  public function setNombre($Nombre){
    return $this->Nombre=$Nombre;
  }
  public function setCantidadDesaparecidos($CantidadDesaparecidos){
    return $this->CantidadDesaparecidos=$CantidadDesaparecidos;
  }
  public function setParteDelColectivo($ParteDelColectivo){
    return $this->ParteDelColectivo=$ParteDelColectivo;
  }
  public function setNonce($Nonce){
    return $this->Nonce=$Nonce;
  }
  public function setComoSeEntero($ComoSeEntero){
    return $this->ComoSeEntero=$ComoSeEntero;
  }
  public function setData($Data){
    return $this->Data=$Data;
  }
  public function setLastUpdate($LastUpdate){
    return $this->LastUpdate=$LastUpdate;
  }
  public function setPersonas($Personas){
    return $this->Personas=$Personas;
  }
  public function setActos($Actos){
    return $this->Actos=$Actos;
  }
  public function setDenuncias($Denuncias){
    return $this->Denuncias=$Denuncias;
  }
  public function setAtenciones($Atenciones){
    return $this->Atenciones=$Atenciones;
  }
}
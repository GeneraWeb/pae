<?php
class Binarios {

  public $Id;
  public $DateBorn;
  public $UsuarioRegistra;
  public $NombreFile;
  public $Nonce;
  public $MimeType;
  public $GoogleUID;
  public $Objeto;
  public $IdObjeto;
  public $Data;

  function __construct() {
    $this->Id = NULL;
    $this->DateBorn = NULL;
    $this->UsuarioRegistra = NULL;
    $this->NombreFile = NULL;
    $this->Nonce = NULL;
    $this->MimeType=NULL;
    $this->GoogleUID = NULL;
    $this->Objeto = NULL;
    $this->IdObjeto = NULL;
    $this->Data = NULL;
  }

  public function getId(){
    return $this->Id;
  }
  public function getDateBorn(){
    return $this->DateBorn;
  }
  public function getUsuarioRegistra(){
    return $this->UsuarioRegistra;
  }
  public function getNombreFile(){
    return $this->NombreFile;
  }
  public function getNonce(){
    return $this->Nonce;
  }
  public function getMimeType(){
    return $this->MimeType;
  }
  public function getGoogleUID(){
    return $this->GoogleUID;
  }
  public function getObjeto(){
    return $this->Objeto;
  }
  public function getIdObjeto(){
    return $this->IdObjeto;
  }
  public function getData(){
    return $this->Data;
  }

  public function setId($Id){
    return $this->Id=$Id;
  }
  public function setDateBorn($DateBorn){
    return $this->DateBorn=$DateBorn;
  }
  public function setUsuarioRegistra($UsuarioRegistra){
    return $this->UsuarioRegistra=$UsuarioRegistra;
  }
  public function setNombreFile($NombreFile){
    return $this->NombreFile=$NombreFile;
  }
  public function setNonce($Nonce){
    return $this->Nonce=$Nonce;
  }
  public function setMimeType($MimeType){
    return $this->MimeType=$MimeType;
  }
  public function setGoogleUID($GoogleUID){
    return $this->GoogleUID=$GoogleUID;
  }
  public function setObjeto($Objeto){
    return $this->Objeto=$Objeto;
  }
  public function setIdObjeto($IdObjeto){
    return $this->IdObjeto=$IdObjeto;
  }
  public function setData($Data){
    return $this->Data=$Data;
  }

}
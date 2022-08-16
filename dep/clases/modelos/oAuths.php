<?php
class oAuths {

  public $Id;
  public $Usuario;
  public $DateBorn;
  public $Servicio;
  public $UID;
  public $AccessKey;
  public $RefreshKey;
  public $NeedsReauthorization;
  public $DateDeath;

  function __construct() {
    $this->Id = NULL;
    $this->Usuario = NULL;
    $this->DateBorn = NULL;
    $this->Servicio = NULL;
    $this->UID = NULL;
    $this->AccessKey = NULL;
    $this->RefreshKey = NULL;
    $this->NeedsReauthorization = NULL;
    $this->DateDeath = NULL;
  }

  public function getId(){
    return $this->Id;
  }
  public function getUsuario(){
    return $this->Usuario;
  }
  public function getDateBorn(){
    return $this->DateBorn;
  }
  public function getServicio(){
    return $this->Servicio;
  }
  public function getUID(){
    return $this->UID;
  }
  public function getAccessKey(){
    return $this->AccessKey;
  }
  public function getRefreshKey(){
    return $this->RefreshKey;
  }
  public function getNeedsReauthorization(){
    return $this->NeedsReauthorization;
  }
  public function getDateDeath(){
    return $this->DateDeath;
  }

  public function setId($Id){
    return $this->Id=$Id;
  }
  public function setUsuario($Usuario){
    return $this->Usuario=$Usuario;
  }
  public function setDateBorn($DateBorn){
    return $this->DateBorn=$DateBorn;
  }
  public function setServicio($Servicio){
    return $this->Servicio=$Servicio;
  }
  public function setUID($UID){
    return $this->UID=$UID;
  }
  public function setAccessKey($AccessKey){
    return $this->AccessKey=$AccessKey;
  }
  public function setRefreshKey($RefreshKey){
    return $this->RefreshKey=$RefreshKey;
  }
  public function setNeedsReauthorization($NeedsReauthorization){
    return $this->NeedsReauthorization=$NeedsReauthorization;
  }
  public function setDateDeath($DateDeath){
    return $this->DateDeath=$DateDeath;
  }

}
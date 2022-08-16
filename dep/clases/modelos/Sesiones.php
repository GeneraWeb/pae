<?php
class Sesiones {

  public $Id;
  public $Usuario;
  public $DateBorn;
  public $DateDeath;
  public $IP;
  public $Location;
  public $Client;
  public $Nonce;

  function __construct() {
    $this->Id = NULL;
    $this->Usuario = NULL;
    $this->DateBorn = NULL;
    $this->DateDeath = NULL;
    $this->IP = NULL;
    $this->Location = NULL;
    $this->Client = NULL;
    $this->Nonce = NULL;
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
  public function getDateDeath(){
    return $this->DateDeath;
  }
  public function getIP(){
    return $this->IP;
  }
  public function getLocation(){
    return $this->Location;
  }
  public function getClient(){
    return $this->Client;
  }
  public function getNonce(){
    return $this->Nonce;
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
  public function setDateDeath($DateDeath){
    return $this->DateDeath=$DateDeath;
  }
  public function setIP($IP){
    return $this->IP=$IP;
  }
  public function setLocation($Location){
    return $this->Location=$Location;
  }
  public function setClient($Client){
    return $this->Client=$Client;
  }
  public function setNonce($Nonce){
    return $this->Nonce=$Nonce;
  }

}
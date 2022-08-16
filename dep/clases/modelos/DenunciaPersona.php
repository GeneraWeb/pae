<?php
class DenunciaPersona {

  public $Id;
  public $Denuncia;
  public $Persona;

  function __construct() {
    $this->Id = NULL;
    $this->Denuncia = NULL;
    $this->Persona = NULL;
  }

  public function getId(){
    return $this->Id;
  }
  public function getDenuncia(){
    return $this->Denuncia;
  }
  public function getPersona(){
    return $this->Persona;
  }

  public function setId($Id){
    return $this->Id=$Id;
  }
  public function setDenuncia($Denuncia){
    return $this->Denuncia=$Denuncia;
  }
  public function setPersona($Persona){
    return $this->Persona=$Persona;
  }

}
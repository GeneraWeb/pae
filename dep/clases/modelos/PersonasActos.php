<?php
class PersonasActos {

  public $Id;
  public $Persona;
  public $Acto;

  function __construct() {
    $this->Id = NULL;
    $this->Persona = NULL;
    $this->Acto = NULL;
  }

  public function getId(){
    return $this->Id;
  }
  public function getPersona(){
    return $this->Persona;
  }
  public function getActo(){
    return $this->Acto;
  }

  public function setId($Id){
    return $this->Id=$Id;
  }
  public function setPersona($Persona){
    return $this->Persona=$Persona;
  }
  public function setActo($Acto){
    return $this->Acto=$Acto;
  }

}
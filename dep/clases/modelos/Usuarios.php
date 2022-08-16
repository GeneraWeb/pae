<?php
class Usuarios {

  public $Id;
  public $Nombre;
  public $Apellidos;
  public $Seudonimo;
  public $Email;
  public $Telefono;
  public $Imagen;
  public $Password;
  public $Tipo;
  public $Estatus;
  public $DateBorn;
  public $BornBy;
  public $ResetLink;
  public $Nonce;
  public $Activo;

  function __construct() {
    $this->Id = NULL;
    $this->Nombre = NULL;
    $this->Apellidos = NULL;
    $this->Seudonimo = NULL;
    $this->Email = NULL;
    $this->Telefono = NULL;
    $this->Imagen = NULL;
    $this->Password = NULL;
    $this->Tipo = NULL;
    $this->Estatus = NULL;
    $this->DateBorn = NULL;
    $this->BornBy = NULL;
    $this->ResetLink = NULL;
    $this->Nonce = NULL;
    $this->Activo = NULL;
  }

  public function getId(){
    return $this->Id;
  }
  public function getNombre(){
    return $this->Nombre;
  }
  public function getApellidos(){
    return $this->Apellidos;
  }
  public function getSeudonimo(){
    return $this->Seudonimo;
  }
  public function getEmail(){
    return $this->Email;
  }
  public function getTelefono(){
    return $this->Telefono;
  }
  public function getImagen(){
    return $this->Imagen;
  }
  public function getPassword(){
    return $this->Password;
  }
  public function getTipo(){
    return $this->Tipo;
  }
  public function getEstatus(){
    return $this->Estatus;
  }
  public function getDateBorn(){
    return $this->DateBorn;
  }
  public function getBornBy(){
    return $this->BornBy;
  }
  public function getResetLink(){
    return $this->ResetLink;
  }
  public function getNonce(){
    return $this->Nonce;
  }
  public function getActivo(){
    return $this->Activo;
  }

  public function setId($Id){
    return $this->Id=$Id;
  }
  public function setNombre($Nombre){
    return $this->Nombre=$Nombre;
  }
  public function setApellidos($Apellidos){
    return $this->Apellidos=$Apellidos;
  }
  public function setSeudonimo($Seudonimo){
    return $this->Seudonimo=$Seudonimo;
  }
  public function setEmail($Email){
    return $this->Email=$Email;
  }
  public function setTelefono($Telefono){
    return $this->Telefono=$Telefono;
  }
  public function setImagen($Imagen){
    return $this->Imagen=$Imagen;
  }
  public function setPassword($Password){
    return $this->Password=$Password;
  }
  public function setTipo($Tipo){
    return $this->Tipo=$Tipo;
  }
  public function setEstatus($Estatus){
    return $this->Estatus=$Estatus;
  }
  public function setDateBorn($DateBorn){
    return $this->DateBorn=$DateBorn;
  }
  public function setBornBy($BornBy){
    return $this->BornBy=$BornBy;
  }
  public function setResetLink($ResetLink){
    return $this->ResetLink=$ResetLink;
  }
  public function setNonce($Nonce){
    return $this->Nonce=$Nonce;
  }
  public function setActivo($Activo){
    return $this->Activo=$Activo;
  }

}
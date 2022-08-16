<?php
require_once 'modelos/pae_base.php';
require_once 'modelos/Usuarios.php';

class DaoUsuarios extends pae_base{

  public function add(Usuarios $Usuarios){
    $sql="INSERT INTO Usuarios (Nombre,Apellidos,Seudonimo,Email,Telefono,Imagen,Password,Tipo,Estatus,DateBorn,BornBy,ResetLink,Nonce,Activo) VALUES (:Nombre,:Apellidos,:Seudonimo,:Email,:Telefono,:Imagen,:Password,:Tipo,:Estatus,:DateBorn,:BornBy,:ResetLink,:Nonce,:Activo);";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Nombre' => $Usuarios->getNombre(), ':Apellidos' => $Usuarios->getApellidos(), ':Seudonimo' => $Usuarios->getSeudonimo(), ':Email' => $Usuarios->getEmail(), ':Telefono' => $Usuarios->getTelefono(), ':Imagen' => $Usuarios->getImagen(), ':Password' => $Usuarios->getPassword(), ':Tipo' => $Usuarios->getTipo(), ':Estatus' => $Usuarios->getEstatus(), ':DateBorn' => $Usuarios->getDateBorn(), ':BornBy' => $Usuarios->getBornBy(), ':ResetLink' => $Usuarios->getResetLink(), ':Nonce' => $Usuarios->getNonce(), ':Activo' => $Usuarios->getActivo()));
      $Usuarios->setId($this->_dbh->lastInsertId());
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Usuarios;
  }

  public function update(Usuarios $Usuarios){
    $sql="UPDATE Usuarios SET Nombre=:Nombre, Apellidos=:Apellidos, Seudonimo=:Seudonimo, Email=:Email, Telefono=:Telefono, Imagen=:Imagen, Password=:Password, Tipo=:Tipo, Estatus=:Estatus, DateBorn=:DateBorn, BornBy=:BornBy, ResetLink=:ResetLink, Nonce=:Nonce, Activo=:Activo WHERE  Id=:Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Id' => $Usuarios->getId(), ':Nombre' => $Usuarios->getNombre(), ':Apellidos' => $Usuarios->getApellidos(), ':Seudonimo' => $Usuarios->getSeudonimo(), ':Email' => $Usuarios->getEmail(), ':Telefono' => $Usuarios->getTelefono(), ':Imagen' => $Usuarios->getImagen(), ':Password' => $Usuarios->getPassword(), ':Tipo' => $Usuarios->getTipo(), ':Estatus' => $Usuarios->getEstatus(), ':DateBorn' => $Usuarios->getDateBorn(), ':BornBy' => $Usuarios->getBornBy(), ':ResetLink' => $Usuarios->getResetLink(), ':Nonce' => $Usuarios->getNonce(), ':Activo' => $Usuarios->getActivo()));
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Usuarios;
  }

  public function addOrUpdate(Usuarios $Usuarios){
    if($Usuarios->getId()>0){
      $Usuarios=$this->update($Usuarios);
    }else{
      $Usuarios=$this->add($Usuarios);
    }
    return $Usuarios;
  }

  public function delete($Id){
    $sql="DELETE FROM Usuarios  WHERE  Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return true;
  }

  public function show($Id){
    $sql="SELECT * FROM Usuarios WHERE Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $Usuarios=new Usuarios();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $Usuarios=$this->createObject($result[0]);
    }
    return $Usuarios;
  }

  public function showAll(){
    $sql="SELECT * FROM Usuarios";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $resp=array();
    foreach($sth->fetchAll() as $row){
      array_push($resp,$this->createObject($row));
    }
    return $resp;
  }

  public function advancedQuery($sql){
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $resp=array();
    foreach($sth->fetchAll() as $row){
      array_push($resp,$this->createObject($row));
    }
    return $resp;
  }

  public function createObject($row){
    $Usuarios=new Usuarios();
    $Usuarios->setId($row['Id']);
    $Usuarios->setNombre($row['Nombre']);
    $Usuarios->setApellidos($row['Apellidos']);
    $Usuarios->setSeudonimo($row['Seudonimo']);
    $Usuarios->setEmail($row['Email']);
    $Usuarios->setTelefono($row['Telefono']);
    $Usuarios->setImagen($row['Imagen']);
    $Usuarios->setPassword($row['Password']);
    $Usuarios->setTipo($row['Tipo']);
    $Usuarios->setEstatus($row['Estatus']);
    $Usuarios->setDateBorn($row['DateBorn']);
    $Usuarios->setBornBy($row['BornBy']);
    $Usuarios->setResetLink($row['ResetLink']);
    $Usuarios->setNonce($row['Nonce']);
    $Usuarios->setActivo($row['Activo']);
    return $Usuarios;
  }

  public function getByEmail($Email){
    $sql="SELECT * FROM Usuarios WHERE Email='$Email';";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $Usuarios=new Usuarios();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $Usuarios=$this->createObject($result[0]);
    }
    return $Usuarios;
  }

}
<?php
require_once 'modelos/pae_base.php';
require_once 'modelos/LugaresActo.php';

class DaoLugaresActo extends pae_base{

  public function add(LugaresActo $LugaresActo){
    $sql="INSERT INTO LugaresActo (Acto,Pais,Estado,Municipio,Colonia,Localidad,Direccion,CodPostal,FechaLugarActo,Comentarios,Data) VALUES (:Acto,:Pais,:Estado,:Municipio,:Colonia,:Localidad,:Direccion,:CodPostal,:FechaLugarActo,:Comentarios,:Data);";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Acto' => $LugaresActo->getActo(), ':Pais' => $LugaresActo->getPais(), ':Estado' => $LugaresActo->getEstado(), ':Municipio' => $LugaresActo->getMunicipio(), ':Colonia' => $LugaresActo->getColonia(), ':Localidad' => $LugaresActo->getLocalidad(), ':Direccion' => $LugaresActo->getDireccion(), ':CodPostal' => $LugaresActo->getCodPostal(), ':FechaLugarActo' => $LugaresActo->getFechaLugarActo(), ':Comentarios' => $LugaresActo->getComentarios(), ':Data' => json_encode($LugaresActo->getData())));
      $LugaresActo->setId($this->_dbh->lastInsertId());
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $LugaresActo;
  }

  public function update(LugaresActo $LugaresActo){
    $sql="UPDATE LugaresActo SET Acto=:Acto, Pais=:Pais, Estado=:Estado, Municipio=:Municipio, Colonia=:Colonia, Localidad=:Localidad, Direccion=:Direccion, CodPostal=:CodPostal, FechaLugarActo=:FechaLugarActo, Comentarios=:Comentarios, Data=:Data WHERE  Id=:Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Id' => $LugaresActo->getId(), ':Acto' => $LugaresActo->getActo(), ':Pais' => $LugaresActo->getPais(), ':Estado' => $LugaresActo->getEstado(), ':Municipio' => $LugaresActo->getMunicipio(), ':Colonia' => $LugaresActo->getColonia(), ':Localidad' => $LugaresActo->getLocalidad(), ':Direccion' => $LugaresActo->getDireccion(), ':CodPostal' => $LugaresActo->getCodPostal(), ':FechaLugarActo' => $LugaresActo->getFechaLugarActo(), ':Comentarios' => $LugaresActo->getComentarios(), ':Data' => json_encode($LugaresActo->getData())));
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $LugaresActo;
  }

  public function addOrUpdate(LugaresActo $LugaresActo){
    if($LugaresActo->getId()>0){
      $LugaresActo=$this->update($LugaresActo);
    }else{
      $LugaresActo=$this->add($LugaresActo);
    }
    return $LugaresActo;
  }

  public function delete($Id){
    $sql="DELETE FROM LugaresActo  WHERE  Id=$Id;";
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
    $sql="SELECT * FROM LugaresActo WHERE Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $LugaresActo=new LugaresActo();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $LugaresActo=$this->createObject($result[0]);
    }
    return $LugaresActo;
  }

  public function showAll(){
    $sql="SELECT * FROM LugaresActo";
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
    $LugaresActo=new LugaresActo();
    $LugaresActo->setId($row['Id']);
    $LugaresActo->setActo($row['Acto']);
    $LugaresActo->setPais($row['Pais']);
    $LugaresActo->setEstado($row['Estado']);
    $LugaresActo->setMunicipio($row['Municipio']);
    $LugaresActo->setColonia($row['Colonia']);
    $LugaresActo->setLocalidad($row['Localidad']);
    $LugaresActo->setDireccion($row['Direccion']);
    $LugaresActo->setCodPostal($row['CodPostal']);
    $LugaresActo->setFechaLugarActo($row['FechaLugarActo']);
    $LugaresActo->setComentarios($row['Comentarios']);
    $LugaresActo->setData(json_decode($row['Data']));
    return $LugaresActo;
  }

  public function getByActo($Acto){
    $sql="SELECT * FROM LugaresActo WHERE Acto=$Acto";
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
}
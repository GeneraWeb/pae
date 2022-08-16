<?php
require_once 'modelos/pae_base.php';
require_once 'modelos/Atencion.php';

class DaoAtencion extends pae_base{

  public function add(Atencion $Atencion){
    $sql="INSERT INTO Atencion (Caso,Canal,FechaAtencion,Atendio,AccionRealizada,Descripcion,Canalizacion) VALUES (:Caso,:Canal,:FechaAtencion,:Atendio,:AccionRealizada,:Descripcion,:Canalizacion);";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Caso' => $Atencion->getCaso(), ':Canal' => $Atencion->getCanal(), ':FechaAtencion' => $Atencion->getFechaAtencion(), ':Atendio' => $Atencion->getAtendio(), ':AccionRealizada' => $Atencion->getAccionRealizada(), ':Descripcion' => $Atencion->getDescripcion(), ':Canalizacion' => $Atencion->getCanalizacion()));
      $Atencion->setId($this->_dbh->lastInsertId());
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Atencion;
  }

  public function update(Atencion $Atencion){
    $sql="UPDATE Atencion SET Caso=:Caso, Canal=:Canal, FechaAtencion=:FechaAtencion, Atendio=:Atendio, AccionRealizada=:AccionRealizada, Descripcion=:Descripcion, Canalizacion=:Canalizacion WHERE  Id=:Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Id' => $Atencion->getId(), ':Caso' => $Atencion->getCaso(), ':Canal' => $Atencion->getCanal(), ':FechaAtencion' => $Atencion->getFechaAtencion(), ':Atendio' => $Atencion->getAtendio(), ':AccionRealizada' => $Atencion->getAccionRealizada(), ':Descripcion' => $Atencion->getDescripcion(), ':Canalizacion' => $Atencion->getCanalizacion()));
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Atencion;
  }

  public function addOrUpdate(Atencion $Atencion){
    if($Atencion->getId()>0){
      $Atencion=$this->update($Atencion);
    }else{
      $Atencion=$this->add($Atencion);
    }
    return $Atencion;
  }

  public function delete($Id){
    $sql="DELETE FROM Atencion  WHERE  Id=$Id;";
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
    $sql="SELECT * FROM Atencion WHERE Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $Atencion=new Atencion();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $Atencion=$this->createObject($result[0]);
    }
    return $Atencion;
  }

  public function showAll(){
    $sql="SELECT * FROM Atencion";
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
    $Atencion=new Atencion();
    $Atencion->setId($row['Id']);
    $Atencion->setCaso($row['Caso']);
    $Atencion->setCanal($row['Canal']);
    $Atencion->setFechaAtencion($row['FechaAtencion']);
    $Atencion->setAtendio($row['Atendio']);
    $Atencion->setAccionRealizada($row['AccionRealizada']);
    $Atencion->setDescripcion($row['Descripcion']);
    $Atencion->setCanalizacion($row['Canalizacion']);
    return $Atencion;
  }

  public function getByCaso($Caso){
    $sql="SELECT * FROM Atencion WHERE Caso=$Caso";
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
  public function listAtendio(){
    $sql="SELECT DISTINCT Atendio FROM Atencion";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $resp=array();
    foreach($sth->fetchAll() as $row){
      array_push($resp,$row["Atendio"]);
    }
    return $resp;
  }
}
<?php
require_once 'modelos/pae_base.php';
require_once 'modelos/Logs.php';

class DaoLogs extends pae_base{

  public function add(Logs $Logs){
    $sql="INSERT INTO Logs (Sesion,Fecha,Accion,Data,TipoObjeto,IdObjeto) VALUES (:Sesion,:Fecha,:Accion,:Data,:TipoObjeto,:IdObjeto);";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Sesion' => $Logs->getSesion(), ':Fecha' => $Logs->getFecha(), ':Accion' => $Logs->getAccion(), ':Data' => $Logs->getData(), ':TipoObjeto' => $Logs->getTipoObjeto(), ':IdObjeto' => $Logs->getIdObjeto()));
      $Logs->setId($this->_dbh->lastInsertId());
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Logs;
  }

  public function update(Logs $Logs){
    $sql="UPDATE Logs SET Sesion=:Sesion, Fecha=:Fecha, Accion=:Accion, Data=:Data, TipoObjeto=:TipoObjeto, IdObjeto=:IdObjeto WHERE  Id=:Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Id' => $Logs->getId(), ':Sesion' => $Logs->getSesion(), ':Fecha' => $Logs->getFecha(), ':Accion' => $Logs->getAccion(), ':Data' => $Logs->getData(), ':TipoObjeto' => $Logs->getTipoObjeto(), ':IdObjeto' => $Logs->getIdObjeto()));
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Logs;
  }

  public function addOrUpdate(Logs $Logs){
    if($Logs->getId()>0){
      $Logs=$this->update($Logs);
    }else{
      $Logs=$this->add($Logs);
    }
    return $Logs;
  }

  public function delete($Id){
    $sql="DELETE FROM Logs  WHERE  Id=$Id;";
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
    $sql="SELECT * FROM Logs WHERE Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $Logs=new Logs();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $Logs=$this->createObject($result[0]);
    }
    return $Logs;
  }

  public function showAll(){
    $sql="SELECT * FROM Logs";
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
    $Logs=new Logs();
    $Logs->setId($row['Id']);
    $Logs->setSesion($row['Sesion']);
    $Logs->setFecha($row['Fecha']);
    $Logs->setAccion($row['Accion']);
    $Logs->setData($row['Data']);
    $Logs->setTipoObjeto($row['TipoObjeto']);
    $Logs->setIdObjeto($row['IdObjeto']);
    return $Logs;
  }

  public function compareObject($ObjIni,$ObjFin){
    $resp=array();
    $keysIni=array();
    $updated=array();
    $added=array();
    foreach($ObjIni as $key => $value) {
      if(isset($ObjFin->{$key})){
        if($ObjFin->{$key}!==$value && $value!==NULL){
          $update=array();
          $update["from"]=$value;
          $update["to"]=$ObjFin->{$key};
          $updated[$key]=$update;
          array_push($keysIni, $key);
        }
        if($ObjFin->{$key}==$value){
          array_push($keysIni, $key);
        }
      }else{
        if($value!==NULL){
          $update=array();
          $update["from"]=$value;
          $update["to"]=$ObjFin->{$key};
          $updated[$key]=$update;
          array_push($keysIni, $key);
        }
      }
    }
    foreach($ObjFin as $key => $value) {
      if(!in_array($key, $keysIni)){
        if($value!==NULL){
          $added[$key]=$value;
        }
      }
    }
    $resp["object"]=get_class($ObjIni);
    if(isset($ObjFin->{"Id"})){
      $resp["Id"]=$ObjFin->getId();
    }
    $resp["updated"]=$updated;
    $resp["added"]=$added;
    return $resp;
  } 
  
  public function compareObjectAndAdd($ObjIni,$ObjFin,$Sesion){
    $compare=$this->compareObject($ObjIni,$ObjFin);
    $Logs=new Logs();
    $Logs->setSesion($Sesion->getId());
    $Logs->setFecha(date("Y-m-d H:i:s"));
    $Logs->setAccion("add");
    if(count($compare["updated"])>0){
      $Logs->setAccion("update");
    }
    $Logs->setData(json_encode($compare));
    $Logs->setTipoObjeto($compare['object']);
    $Logs->setIdObjeto($compare['Id']);
    $Logs=$this->add($Logs);
  }
}
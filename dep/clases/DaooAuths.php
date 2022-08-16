<?php
require_once 'modelos/pae_base.php';
require_once 'modelos/oAuths.php';

class DaooAuths extends pae_base{

  public function add(oAuths $oAuths){
    $sql="INSERT INTO oAuths (Usuario,DateBorn,Servicio,UID,AccessKey,RefreshKey,NeedsReauthorization,DateDeath) VALUES (:Usuario,:DateBorn,:Servicio,:UID,:AccessKey,:RefreshKey,:NeedsReauthorization,:DateDeath);";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Usuario' => $oAuths->getUsuario(), ':DateBorn' => $oAuths->getDateBorn(), ':Servicio' => $oAuths->getServicio(), ':UID' => $oAuths->getUID(), ':AccessKey' => $oAuths->getAccessKey(), ':RefreshKey' => $oAuths->getRefreshKey(), ':NeedsReauthorization' => $oAuths->getNeedsReauthorization(), ':DateDeath' => $oAuths->getDateDeath()));
      $oAuths->setId($this->_dbh->lastInsertId());
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $oAuths;
  }

  public function update(oAuths $oAuths){
    $sql="UPDATE oAuths SET Usuario=:Usuario, DateBorn=:DateBorn, Servicio=:Servicio, UID=:UID, AccessKey=:AccessKey, RefreshKey=:RefreshKey, NeedsReauthorization=:NeedsReauthorization, DateDeath=:DateDeath WHERE  Id=:Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Id' => $oAuths->getId(), ':Usuario' => $oAuths->getUsuario(), ':DateBorn' => $oAuths->getDateBorn(), ':Servicio' => $oAuths->getServicio(), ':UID' => $oAuths->getUID(), ':AccessKey' => $oAuths->getAccessKey(), ':RefreshKey' => $oAuths->getRefreshKey(), ':NeedsReauthorization' => $oAuths->getNeedsReauthorization(), ':DateDeath' => $oAuths->getDateDeath()));
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $oAuths;
  }

  public function addOrUpdate(oAuths $oAuths){
    if($oAuths->getId()>0){
      $oAuths=$this->update($oAuths);
    }else{
      $oAuths=$this->add($oAuths);
    }
    return $oAuths;
  }

  public function delete($Id){
    $sql="DELETE FROM oAuths  WHERE  Id=$Id;";
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
    $sql="SELECT * FROM oAuths WHERE Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $oAuths=new oAuths();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $oAuths=$this->createObject($result[0]);
    }
    return $oAuths;
  }

  public function showAll(){
    $sql="SELECT * FROM oAuths";
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
    $oAuths=new oAuths();
    $oAuths->setId($row['Id']);
    $oAuths->setUsuario($row['Usuario']);
    $oAuths->setDateBorn($row['DateBorn']);
    $oAuths->setServicio($row['Servicio']);
    $oAuths->setUID($row['UID']);
    $oAuths->setAccessKey($row['AccessKey']);
    $oAuths->setRefreshKey($row['RefreshKey']);
    $oAuths->setNeedsReauthorization($row['NeedsReauthorization']);
    $oAuths->setDateDeath($row['DateDeath']);
    return $oAuths;
  }

  public function getByServicioUID($Servicio,$UID){
	  $sql="SELECT * FROM oAuths WHERE Servicio='$Servicio' AND UID='$UID';";
	  try {
		$sth=$this->_dbh->prepare($sql);
		$sth->execute();
	  } catch (Exception $e) {
		var_dump($e);
		echo($sql);
	  }
	  $oAuths=new oAuths();
	  $result=$sth->fetchAll();
	  if(count($result)>0){
		$oAuths=$this->createObject($result[0]);
	  }
	  return $oAuths;
	}
}
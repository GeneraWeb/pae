<?php
require_once 'modelos/pae_base.php';
require_once 'modelos/DenunciaPersona.php';

class DaoDenunciaPersona extends pae_base{

  public function add(DenunciaPersona $DenunciaPersona){
    $sql="INSERT INTO DenunciaPersona (Denuncia,Persona) VALUES (:Denuncia,:Persona);";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Denuncia' => $DenunciaPersona->getDenuncia(), ':Persona' => $DenunciaPersona->getPersona()));
      $DenunciaPersona->setId($this->_dbh->lastInsertId());
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $DenunciaPersona;
  }

  public function update(DenunciaPersona $DenunciaPersona){
    $sql="UPDATE DenunciaPersona SET Denuncia=:Denuncia, Persona=:Persona WHERE  Id=:Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Id' => $DenunciaPersona->getId(), ':Denuncia' => $DenunciaPersona->getDenuncia(), ':Persona' => $DenunciaPersona->getPersona()));
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $DenunciaPersona;
  }

  public function addOrUpdate(DenunciaPersona $DenunciaPersona){
    if($DenunciaPersona->getId()>0){
      $DenunciaPersona=$this->update($DenunciaPersona);
    }else{
      $DenunciaPersona=$this->add($DenunciaPersona);
    }
    return $DenunciaPersona;
  }

  public function delete($Id){
    $sql="DELETE FROM DenunciaPersona  WHERE  Id=$Id;";
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
    $sql="SELECT * FROM DenunciaPersona WHERE Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $DenunciaPersona=new DenunciaPersona();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $DenunciaPersona=$this->createObject($result[0]);
    }
    return $DenunciaPersona;
  }

  public function showAll(){
    $sql="SELECT * FROM DenunciaPersona";
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
    $DenunciaPersona=new DenunciaPersona();
    $DenunciaPersona->setId($row['Id']);
    $DenunciaPersona->setDenuncia($row['Denuncia']);
    $DenunciaPersona->setPersona($row['Persona']);
    return $DenunciaPersona;
  }
  
  public function getIdsPersonasDenuncia($Denuncia){
	$sql="SELECT * FROM DenunciaPersona WHERE Denuncia=$Denuncia";
	try {
	  $sth=$this->_dbh->prepare($sql);
	  $sth->execute();
	} catch (Exception $e) {
	  var_dump($e);
	  echo($sql);
	}
	$resp=array();
	foreach($sth->fetchAll() as $row){
	  array_push($resp,$row["Persona"]);
	}
	return $resp;
  }
  
  public function deletePersonaDenuncia($Persona,$Denuncia){
	$sql="DELETE FROM DenunciaPersona WHERE Persona=$Persona AND Denuncia=$Denuncia;";
	try {
	  $sth=$this->_dbh->prepare($sql);
	  $sth->execute();
	} catch (Exception $e) {
	  var_dump($e);
	  echo($sql);
	}
	return true;
  }

}
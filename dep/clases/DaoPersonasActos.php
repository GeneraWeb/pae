<?php
require_once 'modelos/pae_base.php';
require_once 'modelos/PersonasActos.php';

class DaoPersonasActos extends pae_base{

  public function add(PersonasActos $PersonasActos){
    $sql="INSERT INTO PersonasActos (Persona,Acto) VALUES (:Persona,:Acto);";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Persona' => $PersonasActos->getPersona(), ':Acto' => $PersonasActos->getActo()));
      $PersonasActos->setId($this->_dbh->lastInsertId());
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $PersonasActos;
  }

  public function update(PersonasActos $PersonasActos){
    $sql="UPDATE PersonasActos SET Persona=:Persona, Acto=:Acto WHERE  Id=:Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Id' => $PersonasActos->getId(), ':Persona' => $PersonasActos->getPersona(), ':Acto' => $PersonasActos->getActo()));
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $PersonasActos;
  }

  public function addOrUpdate(PersonasActos $PersonasActos){
    if($PersonasActos->getId()>0){
      $PersonasActos=$this->update($PersonasActos);
    }else{
      $PersonasActos=$this->add($PersonasActos);
    }
    return $PersonasActos;
  }

  public function delete($Id){
    $sql="DELETE FROM PersonasActos  WHERE  Id=$Id;";
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
    $sql="SELECT * FROM PersonasActos WHERE Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $PersonasActos=new PersonasActos();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $PersonasActos=$this->createObject($result[0]);
    }
    return $PersonasActos;
  }

  public function showAll(){
    $sql="SELECT * FROM PersonasActos";
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
    $PersonasActos=new PersonasActos();
    $PersonasActos->setId($row['Id']);
    $PersonasActos->setPersona($row['Persona']);
    $PersonasActos->setActo($row['Acto']);
    return $PersonasActos;
  }
  
  public function getIdsPersonasActo($Acto){
	  $sql="SELECT * FROM PersonasActos WHERE Acto=$Acto";
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
	
	public function deletePersonaActo($Persona,$Acto){
		  $sql="DELETE FROM PersonasActos  WHERE Persona=$Persona AND Acto=$Acto;";
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
<?php
require_once 'modelos/pae_base.php';
require_once 'modelos/Denuncia.php';

class DaoDenuncia extends pae_base{

  public function add(Denuncia $Denuncia){
    $sql="INSERT INTO Denuncia (Caso,Tipo,Realizada,Autoridad,Fecha,RazonNoDenuncia,ObjRelaciona,IdObjRelaciona) VALUES (:Caso,:Tipo,:Realizada,:Autoridad,:Fecha,:RazonNoDenuncia,:ObjRelaciona,:IdObjRelaciona);";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Caso' => $Denuncia->getCaso(), ':Tipo' => $Denuncia->getTipo(), ':Realizada' => $Denuncia->getRealizada(), ':Autoridad' => $Denuncia->getAutoridad(), ':Fecha' => $Denuncia->getFecha(), ':RazonNoDenuncia' => $Denuncia->getRazonNoDenuncia(), ':ObjRelaciona' => $Denuncia->getObjRelaciona(), ':IdObjRelaciona' => $Denuncia->getIdObjRelaciona()));
      $Denuncia->setId($this->_dbh->lastInsertId());
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Denuncia;
  }

  public function update(Denuncia $Denuncia){
    $sql="UPDATE Denuncia SET Caso=:Caso, Tipo=:Tipo, Realizada=:Realizada, Autoridad=:Autoridad, Fecha=:Fecha, RazonNoDenuncia=:RazonNoDenuncia, ObjRelaciona=:ObjRelaciona, IdObjRelaciona=:IdObjRelaciona WHERE  Id=:Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Id' => $Denuncia->getId(), ':Caso' => $Denuncia->getCaso(), ':Tipo' => $Denuncia->getTipo(), ':Realizada' => $Denuncia->getRealizada(), ':Autoridad' => $Denuncia->getAutoridad(), ':Fecha' => $Denuncia->getFecha(), ':RazonNoDenuncia' => $Denuncia->getRazonNoDenuncia(), ':ObjRelaciona' => $Denuncia->getObjRelaciona(), ':IdObjRelaciona' => $Denuncia->getIdObjRelaciona()));
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Denuncia;
  }

  public function addOrUpdate(Denuncia $Denuncia){
    if($Denuncia->getId()>0){
      $Denuncia=$this->update($Denuncia);
    }else{
      $Denuncia=$this->add($Denuncia);
    }
    return $Denuncia;
  }

  public function delete($Id){
    $sql="DELETE FROM Denuncia  WHERE  Id=$Id;";
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
    $sql="SELECT * FROM Denuncia WHERE Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $Denuncia=new Denuncia();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $Denuncia=$this->createObject($result[0]);
    }
    return $Denuncia;
  }

  public function showAll(){
    $sql="SELECT * FROM Denuncia";
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
    $Denuncia=new Denuncia();
    $Denuncia->setId($row['Id']);
    $Denuncia->setCaso($row['Caso']);
    $Denuncia->setTipo($row['Tipo']);
    $Denuncia->setAutoridad($row['Autoridad']);
    $Denuncia->setRealizada($row['Realizada']);
    $Denuncia->setFecha($row['Fecha']);
    $Denuncia->setRazonNoDenuncia($row['RazonNoDenuncia']);
    $Denuncia->setObjRelaciona($row['ObjRelaciona']);
    $Denuncia->setIdObjRelaciona($row['IdObjRelaciona']);
    return $Denuncia;
  }
  
  public function getByCaso($Caso){
	  $sql="SELECT * FROM Denuncia WHERE Caso=$Caso";
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
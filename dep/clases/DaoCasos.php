<?php
require_once 'modelos/pae_base.php';
require_once 'modelos/Casos.php';

class DaoCasos extends pae_base{

  public function add(Casos $Casos){
    $sql="INSERT INTO Casos (Folio,Nombre,CantidadDesaparecidos,ParteDelColectivo,Nonce,ComoSeEntero,Data,LastUpdate) VALUES (:Folio,:Nombre,:CantidadDesaparecidos,:ParteDelColectivo,:Nonce,:ComoSeEntero,:Data,:LastUpdate);";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Folio' => $Casos->getFolio(), ':Nombre' => $Casos->getNombre(), ':CantidadDesaparecidos' => $Casos->getCantidadDesaparecidos(),':ParteDelColectivo' => $Casos->getParteDelColectivo(), ':Nonce' => $Casos->getNonce(), ':ComoSeEntero' => $Casos->getComoSeEntero(), ':Data' => json_encode($Casos->getData()), ':LastUpdate' => $Casos->getLastUpdate()));
       // echo "\nPDO::errorInfo():\n";
       // print_r($sth->errorInfo());
       // exit();
      $Casos->setId($this->_dbh->lastInsertId());
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Casos;
  }

  public function update(Casos $Casos){
    $sql="UPDATE Casos SET Folio=:Folio, Nombre=:Nombre, CantidadDesaparecidos=:CantidadDesaparecidos, Nonce=:Nonce, ParteDelColectivo=:ParteDelColectivo, ComoSeEntero=:ComoSeEntero, Data=:Data, LastUpdate=:LastUpdate WHERE  Id=:Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Id' => $Casos->getId(), ':Folio' => $Casos->getFolio(), ':Nombre' => $Casos->getNombre(), ':CantidadDesaparecidos' => $Casos->getCantidadDesaparecidos(), ':Nonce' => $Casos->getNonce(),':ParteDelColectivo' => $Casos->getParteDelColectivo(), ':ComoSeEntero' => $Casos->getComoSeEntero(), ':Data' => json_encode($Casos->getData()), ':LastUpdate' => $Casos->getLastUpdate()));
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Casos;
  }

  public function addOrUpdate(Casos $Casos){
    if($Casos->getId()>0){
      $Casos=$this->update($Casos);
    }else{
      $Casos=$this->add($Casos);
    }
    return $Casos;
  }

  public function delete($Id){
    $sql="DELETE FROM Casos  WHERE  Id=$Id;";
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
    $sql="SELECT * FROM Casos WHERE Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $Casos=new Casos();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $Casos=$this->createObject($result[0]);
    }
    return $Casos;
  }

  public function showAll(){
    $sql="SELECT * FROM Casos";
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
    $Casos=new Casos();
    $Casos->setId($row['Id']);
    $Casos->setFolio($row['Folio']);
    $Casos->setNombre($row['Nombre']);
    $Casos->setCantidadDesaparecidos($row['CantidadDesaparecidos']);
    $Casos->setParteDelColectivo($row['ParteDelColectivo']);
    $Casos->setNonce($row['Nonce']);
    $Casos->setComoSeEntero($row['ComoSeEntero']);
	if(isset($row['Data'])){
		$Casos->setData(json_decode($row['Data'],true));
	}
    $Casos->setLastUpdate($row['LastUpdate']);
    return $Casos;
  }
  public function buscar($Buscar){
    $sql="SELECT DISTINCT Casos.* FROM Casos LEFT JOIN Personas ON Personas.Caso=Casos.Id WHERE Casos.Nombre LIKE '%$Buscar%' OR Casos.Id='$Buscar' OR Personas.Nombre LIKE '%$Buscar%'";
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
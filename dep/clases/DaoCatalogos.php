<?php
require_once 'modelos/pae_base.php';
require_once 'modelos/Catalogos.php';
require_once 'DaoValoresCatalogo.php';

class DaoCatalogos extends pae_base{

  public function add(Catalogos $Catalogos){
    $sql="INSERT INTO Catalogos (Nombre) VALUES (:Nombre);";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Nombre' => $Catalogos->getNombre()));
      $Catalogos->setId($this->_dbh->lastInsertId());
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Catalogos;
  }

  public function update(Catalogos $Catalogos){
    $sql="UPDATE Catalogos SET Nombre=:Nombre WHERE  Id=:Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Id' => $Catalogos->getId(), ':Nombre' => $Catalogos->getNombre()));
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Catalogos;
  }

  public function addOrUpdate(Catalogos $Catalogos){
    if($Catalogos->getId()>0){
      $Catalogos=$this->update($Catalogos);
    }else{
      $Catalogos=$this->add($Catalogos);
    }
    return $Catalogos;
  }

  public function delete($Id){
    $sql="DELETE FROM Catalogos  WHERE  Id=$Id;";
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
    $sql="SELECT * FROM Catalogos WHERE Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $Catalogos=new Catalogos();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $Catalogos=$this->createObject($result[0]);
    }
    return $Catalogos;
  }

  public function showAll(){
    $sql="SELECT * FROM Catalogos";
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
    $Catalogos=new Catalogos();
    $Catalogos->setId($row['Id']);
    $Catalogos->setNombre($row['Nombre']);
    return $Catalogos;
  }
  
  public function getByNombre($Nombre){
    $DaoValoresCatalogo=new DaoValoresCatalogo();
    $sql="SELECT * FROM Catalogos WHERE Nombre='$Nombre';";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $Catalogos=new Catalogos();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $Catalogos=$this->createObject($result[0]);
      $Catalogos->setValores($DaoValoresCatalogo->getByCatalogo($Catalogos->getId()));
    }
    return $Catalogos;
  }

}
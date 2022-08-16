<?php
require_once 'modelos/pae_base.php';
require_once 'modelos/ValoresCatalogo.php';

class DaoValoresCatalogo extends pae_base{

  public function add(ValoresCatalogo $ValoresCatalogo){
    $sql="INSERT INTO ValoresCatalogo (Catalogo,Valor,Orden) VALUES (:Catalogo,:Valor,:Orden);";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Catalogo' => $ValoresCatalogo->getCatalogo(), ':Valor' => $ValoresCatalogo->getValor(), ':Orden' => $ValoresCatalogo->getOrden()));
      $ValoresCatalogo->setId($this->_dbh->lastInsertId());
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $ValoresCatalogo;
  }

  public function update(ValoresCatalogo $ValoresCatalogo){
    $sql="UPDATE ValoresCatalogo SET Catalogo=:Catalogo, Valor=:Valor, Orden=:Orden WHERE  Id=:Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Id' => $ValoresCatalogo->getId(), ':Catalogo' => $ValoresCatalogo->getCatalogo(), ':Valor' => $ValoresCatalogo->getValor(), ':Orden' => $ValoresCatalogo->getOrden()));
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $ValoresCatalogo;
  }

  public function addOrUpdate(ValoresCatalogo $ValoresCatalogo){
    if($ValoresCatalogo->getId()>0){
      $ValoresCatalogo=$this->update($ValoresCatalogo);
    }else{
      $ValoresCatalogo=$this->add($ValoresCatalogo);
    }
    return $ValoresCatalogo;
  }

  public function delete($Id){
    $sql="DELETE FROM ValoresCatalogo  WHERE  Id=$Id;";
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
    $sql="SELECT * FROM ValoresCatalogo WHERE Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $ValoresCatalogo=new ValoresCatalogo();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $ValoresCatalogo=$this->createObject($result[0]);
    }
    return $ValoresCatalogo;
  }

  public function showAll(){
    $sql="SELECT * FROM ValoresCatalogo";
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
    $ValoresCatalogo=new ValoresCatalogo();
    $ValoresCatalogo->setId($row['Id']);
    $ValoresCatalogo->setCatalogo($row['Catalogo']);
    $ValoresCatalogo->setValor($row['Valor']);
    $ValoresCatalogo->setOrden($row['Orden']);
    return $ValoresCatalogo;
  }
  
  public function getByCatalogo($Catalogo){
    $sql="SELECT * FROM ValoresCatalogo WHERE Catalogo=$Catalogo ORDER BY Orden";
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
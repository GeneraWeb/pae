<?php
require_once 'modelos/pae_base.php';
require_once 'modelos/Personas.php';
require_once 'DaoBinarios.php';

class DaoPersonas extends pae_base{

  public function add(Personas $Personas){
    $sql="INSERT INTO Personas (Caso,RelacionCaso,Nombre,Sexo,Contacto,RelacionDesaparecido,AutorizacionDeFamiliares,Edad,FechaNac,Data) VALUES (:Caso,:RelacionCaso,:Nombre,:Sexo,:Contacto,:RelacionDesaparecido,:AutorizacionDeFamiliares,:Edad,:FechaNac,:Data);";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Caso' => $Personas->getCaso(), ':RelacionCaso' => $Personas->getRelacionCaso(), ':Nombre' => $Personas->getNombre(), ':Sexo' => $Personas->getSexo(), ':Contacto' => json_encode($Personas->getContacto()), ':RelacionDesaparecido' => $Personas->getRelacionDesaparecido(), ':AutorizacionDeFamiliares' => $Personas->getAutorizacionDeFamiliares(), ':Edad' => $Personas->getEdad(), ':FechaNac' => $Personas->getFechaNac(), ':Data' => json_encode($Personas->getData())));
      $Personas->setId($this->_dbh->lastInsertId());
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Personas;
  }

  public function update(Personas $Personas){
    $sql="UPDATE Personas SET Caso=:Caso, RelacionCaso=:RelacionCaso, Nombre=:Nombre, Sexo=:Sexo, Contacto=:Contacto, RelacionDesaparecido=:RelacionDesaparecido, AutorizacionDeFamiliares=:AutorizacionDeFamiliares, Edad=:Edad, FechaNac=:FechaNac, Data=:Data WHERE  Id=:Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Id' => $Personas->getId(), ':Caso' => $Personas->getCaso(), ':RelacionCaso' => $Personas->getRelacionCaso(), ':Nombre' => $Personas->getNombre(), ':Sexo' => $Personas->getSexo(), ':Contacto' => json_encode($Personas->getContacto()), ':RelacionDesaparecido' => $Personas->getRelacionDesaparecido(), ':AutorizacionDeFamiliares' => $Personas->getAutorizacionDeFamiliares(), ':Edad' => $Personas->getEdad(), ':FechaNac' => $Personas->getFechaNac(), ':Data' => json_encode($Personas->getData())));
      //echo "\nPDO::errorInfo():\n";
      //print_r($sth->errorInfo());
      //exit();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Personas;
  }

  public function addOrUpdate(Personas $Personas){
    if($Personas->getId()>0){
      $Personas=$this->update($Personas);
    }else{
      $Personas=$this->add($Personas);
    }
    return $Personas;
  }

  public function delete($Id){
    $sql="DELETE FROM Personas  WHERE  Id=$Id;";
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
    $sql="SELECT * FROM Personas WHERE Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $Personas=new Personas();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $Personas=$this->createObject($result[0]);
    }
    return $Personas;
  }

  public function showAll(){
    $sql="SELECT * FROM Personas";
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
    $DaoBinarios=new DaoBinarios();
    
    $Personas=new Personas();
    $Personas->setId($row['Id']);
    $Personas->setCaso($row['Caso']);
    $Personas->setRelacionCaso($row['RelacionCaso']);
    $Personas->setNombre($row['Nombre']);
    $Personas->setSexo($row['Sexo']);
    $Personas->setContacto(json_decode($row['Contacto'],true));
    $Personas->setRelacionDesaparecido($row['RelacionDesaparecido']);
    $Personas->setAutorizacionDeFamiliares($row['AutorizacionDeFamiliares']);
    $Personas->setEdad($row['Edad']);
    $Personas->setFechaNac($row['FechaNac']);
    $Personas->setData($row['Data']);
    if($row['Id']>0){
      $Personas->setFotos($DaoBinarios->getByObjeto("Persona",$row['Id']));
    }
    return $Personas;
  }

  public function getByCaso($Caso){
    $sql="SELECT * FROM Personas WHERE Caso=$Caso";
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
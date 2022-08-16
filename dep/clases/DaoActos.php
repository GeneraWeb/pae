<?php
require_once 'modelos/pae_base.php';
require_once 'modelos/Actos.php';
require_once 'DaoPersonasActos.php';
require_once 'DaoLugaresActo.php';

class DaoActos extends pae_base{

  public function add(Actos $Actos){
    $sql="INSERT INTO Actos (Folio,Caso,TipoActo,FechaActoIni,ExactitudFechaActoIni,DetalleFechaActoIni,FechaActoFin,ExactitudFechaActoFin,DetalleFechaActoFin,Data) VALUES (:Folio,:Caso,:TipoActo,:FechaActoIni,:ExactitudFechaActoIni,:DetalleFechaActoIni,:FechaActoFin,:ExactitudFechaActoFin,:DetalleFechaActoFin,:Data);";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Folio' => $Actos->getFolio(), ':Caso' => $Actos->getCaso(), ':TipoActo' => $Actos->getTipoActo(), ':FechaActoIni' => $Actos->getFechaActoIni(), ':ExactitudFechaActoIni' => $Actos->getExactitudFechaActoIni(), ':DetalleFechaActoIni' => $Actos->getDetalleFechaActoIni(), ':FechaActoFin' => $Actos->getFechaActoFin(), ':ExactitudFechaActoFin' => $Actos->getExactitudFechaActoFin(), ':DetalleFechaActoFin' => $Actos->getDetalleFechaActoFin(), ':Data' => json_encode($Actos->getData())));
      $Actos->setId($this->_dbh->lastInsertId());
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Actos;
  }

  public function update(Actos $Actos){
    $sql="UPDATE Actos SET Folio=:Folio, Caso=:Caso, TipoActo=:TipoActo, FechaActoIni=:FechaActoIni, ExactitudFechaActoIni=:ExactitudFechaActoIni, DetalleFechaActoIni=:DetalleFechaActoIni, FechaActoFin=:FechaActoFin, ExactitudFechaActoFin=:ExactitudFechaActoFin, DetalleFechaActoFin=:DetalleFechaActoFin, Data=:Data WHERE  Id=:Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Id' => $Actos->getId(), ':Folio' => $Actos->getFolio(), ':Caso' => $Actos->getCaso(), ':TipoActo' => $Actos->getTipoActo(), ':FechaActoIni' => $Actos->getFechaActoIni(), ':ExactitudFechaActoIni' => $Actos->getExactitudFechaActoIni(), ':DetalleFechaActoIni' => $Actos->getDetalleFechaActoIni(), ':FechaActoFin' => $Actos->getFechaActoFin(), ':ExactitudFechaActoFin' => $Actos->getExactitudFechaActoFin(), ':DetalleFechaActoFin' => $Actos->getDetalleFechaActoFin(), ':Data' => json_encode($Actos->getData())));
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Actos;
  }

  public function addOrUpdate(Actos $Actos){
    if($Actos->getId()>0){
      $Actos=$this->update($Actos);
    }else{
      $Actos=$this->add($Actos);
    }
    return $Actos;
  }

  public function delete($Id){
    $sql="DELETE FROM Actos  WHERE  Id=$Id;";
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
    $sql="SELECT * FROM Actos WHERE Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $Actos=new Actos();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $Actos=$this->createObject($result[0]);
    }
    return $Actos;
  }

  public function showAll(){
    $sql="SELECT * FROM Actos";
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
    $DaoPersonasActos=new DaoPersonasActos();
    $DaoLugaresActo=new DaoLugaresActo();
    
    $Actos=new Actos();
    $Actos->setId($row['Id']);
    $Actos->setFolio($row['Folio']);
    $Actos->setCaso($row['Caso']);
    $Actos->setTipoActo($row['TipoActo']);
    $Actos->setFechaActoIni($row['FechaActoIni']);
    $Actos->setExactitudFechaActoIni($row['ExactitudFechaActoIni']);
    $Actos->setDetalleFechaActoIni($row['DetalleFechaActoIni']);
    $Actos->setFechaActoFin($row['FechaActoFin']);
    $Actos->setExactitudFechaActoFin($row['ExactitudFechaActoFin']);
    $Actos->setDetalleFechaActoFin($row['DetalleFechaActoFin']);
    $Actos->setData(json_decode($row['Data'],true));
    if($row['Id']){
      $Actos->setLugares($DaoLugaresActo->getByActo($row['Id']));
      $Actos->setIdsPersonas($DaoPersonasActos->getIdsPersonasActo($row['Id']));
    }
    return $Actos;
  }

  public function getByCaso($Caso){
	  $sql="SELECT * FROM Actos WHERE Caso=$Caso ORDER BY FechaActoIni";
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
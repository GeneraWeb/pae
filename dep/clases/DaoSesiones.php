<?php
require_once 'modelos/pae_base.php';
require_once 'modelos/Sesiones.php';

class DaoSesiones extends pae_base{

  public function add(Sesiones $Sesiones){
    $url="https://api.whatismybrowser.com/api/v2/user_agent_parse";
  	$addData=array();
  	array_push($addData, 'X-API-KEY: '.$this->getParam('whatsmybrowserAPIKey'));
  	$data=array();
  	$data["user_agent"]=$_SERVER["HTTP_USER_AGENT"];
  	$data=json_encode($data);
  	$result=$this->gweb_curl('POST', $addData, $url, $data);
  	$result=json_decode($result);
  	if($result->result->code="success"){
  		$Agent=$result->parse->simple_software_string;
  	}else{
  		$Agent=$_SERVER["HTTP_USER_AGENT"];
  	}
  	$Sesiones->setClient($Agent);
	
  	$IP=$_SERVER["REMOTE_ADDR"];
  	if($_SERVER["REMOTE_ADDR"]!=="::1"){
  		$addData=array();
  		$url="http://api.ipstack.com/".$_SERVER["REMOTE_ADDR"]."?access_key=".$this->getParam("ipstackAPIKey");
  		$result=$this->gweb_curl('GET', $addData, $url);
  		$result=json_decode($result);
  		if(isset($result->city)){
  			$IP.=". ".$result->city;
  		}
  		if(isset($result->region_code)){
  			$IP.=", ".$result->region_code;
  		}
  		if(isset($result->country_code)){
  			$IP.=", ".$result->country_code;
  		}
  		if(isset($result->latitude)){
  			$IP.=" latlng:".$result->latitude.",".$result->longitude;
  		}
  	}
  	$Sesiones->setIP($IP);
	
	$sql="INSERT INTO Sesiones (Usuario,DateBorn,DateDeath,IP,Location,Client,Nonce) VALUES (:Usuario,:DateBorn,:DateDeath,:IP,:Location,:Client,:Nonce);";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Usuario' => $Sesiones->getUsuario(), ':DateBorn' => $Sesiones->getDateBorn(), ':DateDeath' => $Sesiones->getDateDeath(), ':IP' => $Sesiones->getIP(), ':Location' => $Sesiones->getLocation(), ':Client' => $Sesiones->getClient(), ':Nonce' => $Sesiones->getNonce()));
      $Sesiones->setId($this->_dbh->lastInsertId());
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Sesiones;
  }

  public function update(Sesiones $Sesiones){
    $sql="UPDATE Sesiones SET Usuario=:Usuario, DateBorn=:DateBorn, DateDeath=:DateDeath, IP=:IP, Location=:Location, Client=:Client, Nonce=:Nonce WHERE  Id=:Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Id' => $Sesiones->getId(), ':Usuario' => $Sesiones->getUsuario(), ':DateBorn' => $Sesiones->getDateBorn(), ':DateDeath' => $Sesiones->getDateDeath(), ':IP' => $Sesiones->getIP(), ':Location' => $Sesiones->getLocation(), ':Client' => $Sesiones->getClient(), ':Nonce' => $Sesiones->getNonce()));
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Sesiones;
  }

  public function addOrUpdate(Sesiones $Sesiones){
    if($Sesiones->getId()>0){
      $Sesiones=$this->update($Sesiones);
    }else{
      $Sesiones=$this->add($Sesiones);
    }
    return $Sesiones;
  }

  public function delete($Id){
    $sql="DELETE FROM Sesiones  WHERE  Id=$Id;";
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
    $sql="SELECT * FROM Sesiones WHERE Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $Sesiones=new Sesiones();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $Sesiones=$this->createObject($result[0]);
    }
    return $Sesiones;
  }

  public function showAll(){
    $sql="SELECT * FROM Sesiones";
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
    $Sesiones=new Sesiones();
    $Sesiones->setId($row['Id']);
    $Sesiones->setUsuario($row['Usuario']);
    $Sesiones->setDateBorn($row['DateBorn']);
    $Sesiones->setDateDeath($row['DateDeath']);
    $Sesiones->setIP($row['IP']);
    $Sesiones->setLocation($row['Location']);
    $Sesiones->setClient($row['Client']);
    $Sesiones->setNonce($row['Nonce']);
    return $Sesiones;
  }

  public function getSession($Nonce){
  	$sql="SELECT * FROM Sesiones WHERE Nonce='$Nonce';";
  	try {
  	  $sth=$this->_dbh->prepare($sql);
  	  $sth->execute();
  	} catch (Exception $e) {
  	  var_dump($e);
  	  echo($sql);
  	}
  	$Sesiones=new Sesiones();
  	$result=$sth->fetchAll();
  	if(count($result)>0){
  	  $Sesiones=$this->createObject($result[0]);
  	}
  	return $Sesiones;
  }
  
  public function getByUsuarioId($Usuario,$soloActivas=true){
    $sql="SELECT * FROM Sesiones WHERE Usuario=$Usuario";
    if($soloActivas){
      $sql.=" AND DateDeath>'".date("Y-m-d H:i:s")."'";
    }
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
<?php
require_once 'modelos/pae_base.php';
require_once 'modelos/Binarios.php';

class DaoBinarios extends pae_base{
  private $iss;
  private $bucket;
  
  function __construct() {
    parent::__construct();
    $this->iss = $this->getParam('storageServiceAccount');
    $this->bucket = $this->getParam('storageBucket');
  }
  
  public function add(Binarios $Binarios){
    $sql="INSERT INTO Binarios (DateBorn,UsuarioRegistra,NombreFile,Nonce,MimeType,GoogleUID,Objeto,IdObjeto,Data) VALUES (:DateBorn,:UsuarioRegistra,:NombreFile,:Nonce,:MimeType,:GoogleUID,:Objeto,:IdObjeto,:Data);";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':DateBorn' => $Binarios->getDateBorn(), ':UsuarioRegistra' => $Binarios->getUsuarioRegistra(), ':NombreFile' => $Binarios->getNombreFile(), ':Nonce' => $Binarios->getNonce(), ':MimeType' => $Binarios->getMimeType(), ':GoogleUID' => $Binarios->getGoogleUID(), ':Objeto' => $Binarios->getObjeto(), ':IdObjeto' => $Binarios->getIdObjeto(), ':Data' => $Binarios->getData()));
      $Binarios->setId($this->_dbh->lastInsertId());
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Binarios;
  }

  public function update(Binarios $Binarios){
    $sql="UPDATE Binarios SET DateBorn=:DateBorn, UsuarioRegistra=:UsuarioRegistra, NombreFile=:NombreFile, Nonce=:Nonce, MimeType=:MimeType, GoogleUID=:GoogleUID, Objeto=:Objeto, IdObjeto=:IdObjeto, Data=:Data WHERE  Id=:Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Id' => $Binarios->getId(), ':DateBorn' => $Binarios->getDateBorn(), ':UsuarioRegistra' => $Binarios->getUsuarioRegistra(), ':NombreFile' => $Binarios->getNombreFile(), ':Nonce' => $Binarios->getNonce(), ':MimeType' => $Binarios->getMimeType(), ':GoogleUID' => $Binarios->getGoogleUID(), ':Objeto' => $Binarios->getObjeto(), ':IdObjeto' => $Binarios->getIdObjeto(), ':Data' => $Binarios->getData()));
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Binarios;
  }

  public function addOrUpdate(Binarios $Binarios){
    if($Binarios->getId()>0){
      $Binarios=$this->update($Binarios);
    }else{
      $Binarios=$this->add($Binarios);
    }
    return $Binarios;
  }

  public function delete($Id){
    $sql="DELETE FROM Binarios  WHERE  Id=$Id;";
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
    $sql="SELECT * FROM Binarios WHERE Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $Binarios=new Binarios();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $Binarios=$this->createObject($result[0]);
    }
    return $Binarios;
  }

  public function showAll(){
    $sql="SELECT * FROM Binarios";
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
    $Binarios=new Binarios();
    $Binarios->setId($row['Id']);
    $Binarios->setDateBorn($row['DateBorn']);
    $Binarios->setUsuarioRegistra($row['UsuarioRegistra']);
    $Binarios->setNombreFile($row['NombreFile']);
    $Binarios->setNonce($row['Nonce']);
    $Binarios->setMimeType($row['MimeType']);
    $Binarios->setGoogleUID($row['GoogleUID']);
    $Binarios->setObjeto($row['Objeto']);
    $Binarios->setIdObjeto($row['IdObjeto']);
    $Binarios->setData($row['Data']);
    return $Binarios;
  }
  
  public function getByObjeto($Objeto,$IdObjeto){
    $sql="SELECT * FROM Binarios WHERE Objeto='$Objeto' AND IdObjeto=$IdObjeto";
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
  
  function getGCPAccessToken(){
    $json=json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/../.config/gcp-storage.json'));
    $iss=$json->client_email;
    $private_key=$json->private_key;
    // Create and sign JWT : https://developers.google.com/identity/protocols/OAuth2ServiceAccount#creatingjwt
    $header=array();
    $header["alg"]="RS256";
    $header["typ"]="JWT";
    $header=rtrim(strtr(base64_encode(json_encode($header)), '+/', '-_'), '=');
    
    // Create Claim
    $claim=array();
    $claim["iss"]=$iss;
    $claim["scope"]="https://www.googleapis.com/auth/devstorage.read_write";
    $claim["aud"]="https://www.googleapis.com/oauth2/v4/token";
    $claim["exp"]=time()+60*60;
    $claim["iat"]=time();
    $claim=rtrim(strtr(base64_encode(json_encode($claim)), '+/', '-_'), '=');
    
    // Create a signature
    $data = "$header.$claim";
    $binary_signature = "";
    $algo = "SHA256";
    openssl_sign($data, $binary_signature, $private_key, $algo);
    $signature=rtrim(strtr(base64_encode($binary_signature), '+/', '-_'), '=');
    
    // Request a token
    $url="https://www.googleapis.com/oauth2/v4/token";		
    $addData=array();
    array_push($addData, "Content-Type: application/x-www-form-urlencoded");
    
    $data="grant_type=".urlencode("urn:ietf:params:oauth:grant-type:jwt-bearer")."&assertion=".urlencode("$header.$claim.$signature");
    $result=$this->gweb_curl("POST", $addData, $url,$data);
    $result=json_decode($result);
    $accessToken=false;
    if(isset($result->access_token)){
    $accessToken=$result->access_token;
    }
    return $accessToken;
  }
  
  function saveToGoogleStorage($bin,$filename, $mimeType="application/octet-stream"){
	  $access_token=$this->getGCPAccessToken();
    
	  $url="https://storage.googleapis.com/upload/storage/v1/b/".$this->bucket."/o?uploadType=media&name=$filename";
	  $addData=array();
	  array_push($addData, "Authorization: Bearer ".$access_token);
	  array_push($addData, "Content-Type: $mimeType");
	  array_push($addData, "Content-Length: ".strlen($bin));
	  
	  $result=$this->gweb_curl("POST", $addData, $url,$bin);
	  $result=json_decode($result);
    return $result;
    // $result->id
  }
  
  
  
  
  public function readFromGoogleStorage($filename){
	  $access_token=$this->getGCPAccessToken();
	  $url="https://".$this->bucket.".storage.googleapis.com/$filename";
	  $addData=array();
	  array_push($addData, "Authorization: Bearer ".$access_token);
	  
	  $result=$this->gweb_curl("GET", $addData, $url);
	  return $result;
	  
  }
  
  
  public function delFromGoogleStorage($filename){
	  $access_token=$this->getGCPAccessToken();
	  $url="https://storage.googleapis.com/storage/v1/b/".$this->bucket."/o/$filename";
	  $addData=array();
	  array_push($addData, "Authorization: Bearer ".$access_token);
	  
	  $result=$this->gweb_curl("DELETE", $addData, $url);
	  return $result;
	  
  }
}
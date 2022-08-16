<?php
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include_once("../dep/clases/DaoSesiones.php");
include_once("../dep/clases/DaoUsuarios.php");

$DaoSesiones= new DaoSesiones();
$DaoUsuarios=new DaoUsuarios();

$noSessionPages=array();
array_push($noSessionPages, "logout");
array_push($noSessionPages, "login");

$file_script=$_SERVER['SCRIPT_FILENAME'];
$file_script=substr($file_script,0, strpos($file_script,".php"));
while(strpos($file_script,"/")!== false){
	$file_script=substr($file_script, strpos($file_script,"/")+1);
}

$Sesion=new Sesiones();
if(isset($_COOKIE["SessionUID"])){
	$Sesion=$DaoSesiones->getSession($_COOKIE["SessionUID"]);
	if(!$Sesion->getId()>0){
		if(!in_array($file_script, $noSessionPages)){
			header("Location: ../login?reason=sessionNotFound");
			exit();
		}
	}
	$deathSession=strtotime($Sesion->getDateDeath());
	if($deathSession<time()){
		$Sesion=new Sesiones();
		if(!in_array($file_script, $noSessionPages)){
			header("Location: ../login?reason=sessionDeath");
			exit();
		}
	}
}

$Usuario=new Usuarios();
if($Sesion->getUsuario()>0){
	$Usuario=$DaoUsuarios->show($Sesion->getUsuario());
}

if(!$Sesion->getUsuario()>0){
	$Sesion=new Sesiones();
	if(!in_array($file_script, $noSessionPages)){
		header("Location: ../login?reason=userNotFound");
		exit();
	}
}
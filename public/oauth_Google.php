<?php
require_once("../dep/clases/DaoUsuarios.php");
require_once("../dep/clases/DaoSesiones.php");
require_once("../dep/clases/DaooAuths.php");
$DaoUsuarios=new DaoUsuarios();
$DaoSesiones= new DaoSesiones();
$DaooAuths=new DaooAuths();

if(isset($_GET["code"])){
	$url="https://www.googleapis.com/oauth2/v3/token";
	$addData=array();

	$data=array();
	array_push($data, "code=".$_GET["code"]);
	array_push($data, "client_id=".$DaoUsuarios->getParam("Google_ClientID"));
	array_push($data, "client_secret=".$DaooAuths->getParam("Google_ClientSecret"));
	array_push($data, "redirect_uri=".$DaooAuths->getParam("protocolo")."://".$DaooAuths->getParam("dominio")."/oauth/Google");
	array_push($data, "grant_type=authorization_code");
	$tokens=$DaoUsuarios->gweb_curl("POST", $addData, $url, $data);
	$tokens=json_decode($tokens);
	
	if(isset($tokens->error)){
		if(strlen($tokens->error)>0){
			header("Location: login.php?error=".$tokens->error);
			exit();
		}
	}
	
	$url="https://people.googleapis.com/v1/people/me?personFields=emailAddresses,names,photos&access_token=".$tokens->access_token;
	$addData=array();
	array_push($addData, "Authorization: Bearer ".$tokens->access_token);

	$data=array();
	$user_info=$DaoUsuarios->gweb_curl("GET", $addData, $url,false);
	$user_info=json_decode($user_info);
	if(isset($user_info->error)){
		var_dump($user_info);
		exit();
	}
	$userId=str_replace("people/", "", $user_info->resourceName);
	$oAuths=$DaooAuths->getByServicioUID('Google',$userId);
	if($oAuths->getId()>0){
		$Usuario=$DaoUsuarios->show($oAuths->getUsuario());
		if(intval($Usuario->getActivo())!==1){
			header("Location: /login?error=userNotActive");
			exit();
		}
		// Actualizar tokens
		$oAuths->setAccessKey($tokens->access_token);
		if(isset($tokens->refresh_token)){
			if(strlen($tokens->refresh_token)>0){
				$oAuths->setRefreshKey($tokens->refresh_token);
			}
		}
		$oAuths->setNeedsReauthorization(0);
		$DaooAuths->update($oAuths);
		
		$Session = new Sesiones();

		if(isset($_COOKIE["SessionUID"])){
			$Session=$DaoSesiones->getSession($_COOKIE["SessionUID"]);
			if($Session->getId()>0){
				// renovar por 48 horas
				$Session->setDateDeath(date("Y-m-d H:i:s",strtotime("+48 hours")));
				$DaoSesiones->update($Session);
			}else{
				header("Location: /logout");
				exit();
			}
		}
		if(!$Session->getId()>0){
			$Session->setNonce($DaoSesiones->nonce(),25);
			$Session->setUsuario($Usuario->getId());
			$Session->setDateBorn(date("Y-m-d H:i:s"));
			$Session->setDateDeath(date("Y-m-d H:i:s",strtotime("+48 hours")));
			$Session=$DaoSesiones->add($Session);
		}
	}else{
		if(isset($_COOKIE["SessionUID"])){
			$Session=$DaoSesiones->getSession($_COOKIE["SessionUID"]);
			// renovar por 48 horas
			if($Session->getId()>0){
				$Session->setDateDeath(date("Y-m-d H:i:s",strtotime("+48 hours")));
				$DaoSesiones->update($Session);
				$Usuario=$DaoUsuarios->show($Session->getUsuario());
			}else{
				header("Location: /logout");
				exit();
			}
		}else{
			$Usuario = new Usuarios();
			// Buscar por email al usuario
			foreach($user_info->emailAddresses as $emailObj){
				$SearchUsuario=$DaoUsuarios->getByEmail($emailObj->value);
				if($SearchUsuario->getId()>0){
					$Usuario=$SearchUsuario;
				}
			}
			if(!$Usuario->getId()>0){
				header("Location: /login??error=userNotFound");
				exit();
			}
			// Crear sessión nueva
			$Session = new Sesiones();
			$Session->setNonce($DaoSesiones->nonce("",25));
			$Session->setUsuario($Usuario->getId());
			$Session->setDateBorn(date("Y-m-d H:i:s"));
			$Session->setDateDeath(date("Y-m-d H:i:s",strtotime("+48 hours")));
			$Session=$DaoSesiones->add($Session);
		}
		
		// poner tokens
		$oAuths=new oAuths();
		$oAuths->setUsuario($Usuario->getId());
		$oAuths->setServicio("Google");
		$oAuths->setUID($userId);
		$oAuths->setAccessKey($tokens->access_token);
		if(isset($tokens->refresh_token)){
			$oAuths->setRefreshKey($tokens->refresh_token);
		}
		$oAuths->setDateBorn(date("Y-m-d H:i:s"));
		$oAuths->setNeedsReauthorization(0);
		$oAuths=$DaooAuths->add($oAuths);
	}
	if(intval($Usuario->getActivo())!==1){
		header("Location: /login?error=userNotActive-newoAuth");
		exit();
	}
	// poner cookie de sesión
	setcookie("SessionUID", $Session->getNonce(), time() + (86400 * 2), "/"); 
	
	/*if($_GET["state"]=="syncFolders"){
		header("Location: ../../cloud/sync_folders.php");
		exit();
	}*/
	header("Location: /");
	exit();

}
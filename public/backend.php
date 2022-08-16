<?php
require_once("assets/interface.php");
require_once("../dep/clases/DaoLogs.php");
$DaoLogs=new DaoLogs();
$resp=array();
if(strpos($_SERVER["HTTP_REFERER"], $DaoSesiones->getParam("dominio"))!==false){
	if(isset($_POST["action"])){
		if($_POST["action"]=="checarSesion"){
			if(!in_array($file_script, $noSessionPages)){
				if($Sesion->getId()>0){
					$resp["result"]=true;
					if(strtotime($Sesion->getDateDeath()<=time())){
						$resp["result"]=false;
					}
				}else{
					$resp["result"]=false;
				}
			}else{
				$resp["result"]=true;
			}
			echo(json_encode($resp));	
		}
		if($_POST['action']=="guardarUsuario"){
			require_once("../dep/clases/DaoUsuarios.php");
			$DaoUsuarios=new DaoUsuarios();
			$Usuarios_m=new Usuarios();
			//$Usuarios_m->setEstatus($row['Estatus']);
			$Usuarios_m->setDateBorn(date("Y-m-d H:i:s"));
			$Usuarios_m->setBornBy($Usuario->getId());
			$Usuarios_m->setNonce($DaoUsuarios->nonce());
			$Usuarios_m->setActivo(1);
			if($_POST['Id']>0){
				$Usuarios_m=$DaoUsuarios->show($_POST['Id']);
			}
			$Usuarios_m->setNombre($_POST['Nombre']);
			$Usuarios_m->setApellidos($_POST['Apellidos']);
			$Usuarios_m->setSeudonimo($_POST['Seudonimo']);
			$Usuarios_m->setEmail($_POST['Email']);
			$Usuarios_m->setTipo($_POST['Tipo']);
			$DaoUsuarios->addOrUpdate($Usuarios_m);
			echo(json_encode($Usuarios_m));
		}
		if($_POST['action']=="cerrarSesiones"){
			$dateDeath=strtotime("- 2 minutes");
			foreach($DaoSesiones->getByUsuarioId($Usuario->getId()) as $SesionAbierta){
				$SesionAbierta->setDateDeath(date("Y-m-d H:s:i",$dateDeath));
				$DaoSesiones->update($SesionAbierta);
			}
			setcookie("SessionUID", "", time() - (86400 * 2), "/");
			$resp["result"]=true;
			echo(json_encode($resp));
		}
		if($_POST['action']=="cerrarSesion"){
			$SesionAbierta=$DaoSesiones->show($_POST['Id']);
			$dateDeath=strtotime("- 2 minutes");
			$SesionAbierta->setDateDeath(date("Y-m-d H:s:i",$dateDeath));
			$DaoSesiones->update($SesionAbierta);
			$resp["result"]=true;
			echo(json_encode($resp));
		}
		
		if($_POST['action']=="buscarCaso"){
			require_once("../dep/clases/DaoCasos.php");
			$DaoCasos=new DaoCasos();
			
			$resp=array();
			$resp["busqueda"]=$_POST['buscar'];
			$resp["casos"]=$DaoCasos->buscar($_POST['buscar']);
			echo(json_encode($resp));
		}
		
		if($_POST['action']=="getFullCaso"){
			require_once("../dep/clases/DaoCasos.php");
			require_once("../dep/clases/DaoPersonas.php");
			require_once("../dep/clases/DaoActos.php");
			require_once("../dep/clases/DaoDenuncia.php");
			require_once("../dep/clases/DaoAtencion.php");
			$DaoCasos=new DaoCasos();
			$DaoPersonas=new DaoPersonas();
			$DaoActos=new DaoActos();
			$DaoDenuncia=new DaoDenuncia();
			$DaoAtencion=new DaoAtencion();
			$Caso=$DaoCasos->show($_POST['Id']);
			$Caso->setPersonas($DaoPersonas->getByCaso($_POST['Id']));
			$Caso->setActos($DaoActos->getByCaso($_POST['Id']));
			$Caso->setDenuncias($DaoDenuncia->getByCaso($_POST['Id']));
			$Caso->setAtenciones($DaoAtencion->getByCaso($_POST['Id']));
			echo(json_encode($Caso));
		}
		
		if($_POST['action']=="guardarCaso"){
			require_once("../dep/clases/DaoCasos.php");
			require_once("../dep/clases/DaoPersonas.php");
			require_once("../dep/clases/DaoBinarios.php");
			require_once("../dep/clases/DaoActos.php");
			require_once("../dep/clases/DaoPersonasActos.php");
			require_once("../dep/clases/DaoLugaresActo.php");
			require_once("../dep/clases/DaoDenuncia.php");
			require_once("../dep/clases/DaoAtencion.php");
			$DaoCasos=new DaoCasos();
			$DaoPersonas=new DaoPersonas();
			$DaoBinarios=new DaoBinarios();
			$DaoActos=new DaoActos();
			$DaoPersonasActos=new DaoPersonasActos();
			$DaoLugaresActo=new DaoLugaresActo();
			$DaoDenuncia=new DaoDenuncia();
			$DaoAtencion=new DaoAtencion();
			
			$Casos_o=new Casos();
			$Casos=new Casos();
			$Casos->setNonce($DaoCasos->nonce());
			//$Casos->setFolio($row['Folio']);
			if($_POST['Caso']['Id']>0){
				$Casos_o=$DaoCasos->show($_POST['Caso']['Id']);
				$Casos=$DaoCasos->show($_POST['Caso']['Id']);
			}
			$Casos->setNombre($_POST['Caso']['Nombre']);
			$Casos->setCantidadDesaparecidos($_POST['Caso']['CantidadDesaparecidos']);
			$Casos->setComoSeEntero($_POST['Caso']['ComoSeEntero']);
			//$Casos->setData(json_decode($row['Data'],true));
			$Casos=$DaoCasos->addOrUpdate($Casos);
			
			$IdsPersonasCaso_o=array();
			foreach($DaoPersonas->getByCaso($Casos->getId()) as $Persona){
				array_push($IdsPersonasCaso_o, $Persona->getId());
			}
			$IdsPersonasCaso_f=array();
			
			foreach($_POST['Caso']['Personas'] as $ObjPersona){
				$Personas_o=new Personas();
				$Personas=new Personas();
				if($ObjPersona["Id"]>0){
					$Personas_o=$DaoPersonas->show($ObjPersona["Id"]);
					$Personas=$DaoPersonas->show($ObjPersona["Id"]);
				}
				$Personas->setCaso($Casos->getId());
				$Personas->setRelacionCaso($ObjPersona['RelacionCaso']);
				$Personas->setNombre($ObjPersona['Nombre']);
				$Personas->setSexo($ObjPersona['Sexo']);
				if(isset($ObjPersona['Contacto'])){
					$Personas->setContacto($ObjPersona['Contacto']);
				}
				$Personas->setRelacionDesaparecido($ObjPersona['RelacionDesaparecido']);
				$Personas->setAutorizacionDeFamiliares($ObjPersona['AutorizacionDeFamiliares']);
				if(isset($ObjPersona['Edad'])){
					if(floatval($ObjPersona['Edad'])>0){
						$Personas->setEdad($ObjPersona['Edad']);
					}
				}
				if(isset($ObjPersona['FechaNac'])){
					$Personas->setFechaNac($ObjPersona['FechaNac']);
				}
				$Personas->setData($ObjPersona['Data']);

				$cambios_p=$DaoLogs->compareObject($Personas_o, $Personas);
				if(count($cambios_p["updated"])+count($cambios_p["added"])>0){
					$Casos->setLastUpdate(date("Y-m-d H:i:s"));
					$Personas=$DaoPersonas->addOrUpdate($Personas);
					$DaoLogs->compareObjectAndAdd($Personas_o, $Personas,$Sesion);
				}
				array_push($IdsPersonasCaso_f, $Personas->getId());
				$IdFotos=array();
				$IdFotos_o=array();
				$IdFotos_new=array();
				$IdFotos_delete=array();
				foreach($Personas_o->getFotos() as $Foto){
					array_push($IdFotos_o, $Foto->getId());
				}
				
				if(isset($ObjPersona['Fotos'])){
					foreach($ObjPersona['Fotos'] as $FotoPersona){
						$Binario=$DaoBinarios->show($FotoPersona["Id"]);
						$Binario->setObjeto("persona");
						$Binario->setIdObjeto($Personas->getId());
						$Binario=$DaoBinarios->update($Binario);
						array_push($IdFotos, $FotoPersona["Id"]);
						if(!in_array($FotoPersona["Id"], $IdFotos_o)){
							array_push($IdFotos_new, $FotoPersona["Id"]);
						}
					}
				}
				foreach($DaoBinarios->getByObjeto("persona", $Personas->getId()) as $Binario){
					if(!in_array($Binario->getId(), $IdFotos)){
						$DaoBinarios->delFromGoogleStorage($Binario->getNonce());
						$DaoBinarios->delete($Binario->getId());
						array_push($IdFotos_delete, $Binario->getId());
					}
				}
				if(count($IdFotos_new)+count($IdFotos_delete)>0){
					$compare=array();
					if(count($IdFotos_new)>0){
						$compare["added"]=$IdFotos_new;
					}
					if(count($IdFotos_delete)>0){
						$compare["deleted"]=$IdFotos_delete;
					}
					$Logs=new Logs();
					$Logs->setSesion($Sesion->getId());
					$Logs->setFecha(date("Y-m-d H:i:s"));
					$Logs->setAccion("update");
					$Logs->setData(json_encode($compare));
					$Logs->setTipoObjeto("Personas.Fotos");
					$Logs->setIdObjeto($Personas->getId());
					$Logs=$DaoLogs->add($Logs);
				}
			}
			foreach(array_diff($IdsPersonasCaso_o, $IdsPersonasCaso_f) as $delIdPer){
				$DaoPersonas->delete($delIdPer);
			}
			foreach($_POST['Caso']['Actos'] as $ObjActo){
				$Actos_o=new Actos();
				$Actos=new Actos();
				if($ObjActo["Id"]>0){
					$Actos_o=$DaoActos->show($ObjActo["Id"]);
					$Actos=$DaoActos->show($ObjActo["Id"]);
				}
				//$Actos->setFolio($row['Folio']);
				$Actos->setCaso($Casos->getId());
				$Actos->setTipoActo($ObjActo['TipoActo']);
				$Actos->setFechaActoIni($ObjActo['FechaActoIni']);
				$Actos->setExactitudFechaActoIni($ObjActo['ExactitudFechaActoIni']);
				$Actos->setDetalleFechaActoIni($ObjActo['DetalleFechaActoIni']);
				$Actos->setFechaActoFin($ObjActo['FechaActoFin']);
				$Actos->setExactitudFechaActoFin($ObjActo['ExactitudFechaActoFin']);
				$Actos->setDetalleFechaActoFin($ObjActo['DetalleFechaActoFin']);
				$Actos->setData($ObjActo['Data']);
				
				$cambios_a=$DaoLogs->compareObject($Actos_o, $Actos);
				if(count($cambios_a["updated"])+count($cambios_a["added"])>0){
					$Casos->setLastUpdate(date("Y-m-d H:i:s"));
					$Actos=$DaoActos->addOrUpdate($Actos);
					$DaoLogs->compareObjectAndAdd($Actos_o, $Actos,$Sesion);
				}
				$IdsLugares=array();
				foreach($ObjActo["Lugares"] as $ObjLugar){
					$LugaresActo=new LugaresActo();
					$LugaresActo_o=new LugaresActo();
					if($ObjLugar["Id"]>0){
						$LugaresActo=$DaoLugaresActo->show($ObjLugar["Id"]);
						$LugaresActo_o=$DaoLugaresActo->show($ObjLugar["Id"]);
					}
					$LugaresActo->setActo($Actos->getId());
					$LugaresActo->setPais($ObjLugar['Pais']);
					$LugaresActo->setEstado($ObjLugar['Estado']);
					$LugaresActo->setMunicipio($ObjLugar['Municipio']);
					$LugaresActo->setColonia($ObjLugar['Colonia']);
					$LugaresActo->setLocalidad($ObjLugar['Localidad']);
					$LugaresActo->setDireccion($ObjLugar['Direccion']);
					$LugaresActo->setCodPostal($ObjLugar['CodPostal']);
					$LugaresActo->setFechaLugarActo($ObjLugar['FechaLugarActo']);
					$LugaresActo->setComentarios($ObjLugar['Comentarios']);
					$LugaresActo->setData($ObjLugar['Data']);
					
					$cambios_la=$DaoLogs->compareObject($LugaresActo_o, $LugaresActo);
					if(count($cambios_la["updated"])+count($cambios_la["added"])>0){
						$Casos->setLastUpdate(date("Y-m-d H:i:s"));
						$LugaresActo=$DaoLugaresActo->addOrUpdate($LugaresActo);
						$DaoLogs->compareObjectAndAdd($LugaresActo_o, $LugaresActo,$Sesion);
					}
				}
				foreach($ObjActo["IdsPersonas"] as $IdPersona){
					if(!in_array($IdPersona, $Actos_o->getIdsPersonas())){
						$PersonasActos=new PersonasActos();
						$PersonasActos->setPersona($IdPersona);
						$PersonasActos->setActo($Actos->getId());
						$DaoPersonasActos->add($PersonasActos);
					}
				}
				foreach(array_diff($Actos_o->getIdsPersonas(),$ObjActo["IdsPersonas"]) as $IdPersonaDel){
					$DaoPersonasActos->deletePersonaActo($IdPersonaDel,$Actos->getId());
				}
			}
			foreach($_POST['Caso']['Denuncias'] as $ObjDenuncia){
				$Denuncia=new Denuncia();
				$Denuncia_o=new Denuncia();
				if($ObjDenuncia["Id"]>0){
					$Denuncia=$DaoDenuncia->show($ObjDenuncia["Id"]);
					$Denuncia_o=$DaoDenuncia->show($ObjDenuncia["Id"]);
				}
				$Denuncia->setCaso($Casos->getId());
				$Denuncia->setTipo($ObjDenuncia['Tipo']);
				$Denuncia->setAutoridad($ObjDenuncia['Autoridad']);
				$Denuncia->setRealizada($ObjDenuncia['Realizada']);
				///$Denuncia->setFecha($row['Fecha']);
				$Denuncia->setRazonNoDenuncia($ObjDenuncia['RazonNoDenuncia']);
				//$Denuncia->setObjRelaciona($row['ObjRelaciona']);
				//$Denuncia->setIdObjRelaciona($row['IdObjRelaciona']);
				$cambios_d=$DaoLogs->compareObject($Denuncia_o, $Denuncia);
				if(count($cambios_d["updated"])+count($cambios_d["added"])>0){
					$Casos->setLastUpdate(date("Y-m-d H:i:s"));
					$Denuncia=$DaoDenuncia->addOrUpdate($Denuncia);
					$DaoLogs->compareObjectAndAdd($Denuncia_o, $Denuncia,$Sesion);
				}
			}
			foreach($_POST['Caso']['Atenciones'] as $ObjAtencion){
				$Atencion=new Atencion();
				$Atencion_o=new Atencion();
				if($ObjAtencion["Id"]>0){
					$Atencion=$DaoAtencion->show($ObjAtencion["Id"]);
					$Atencion_o=$DaoAtencion->show($ObjAtencion["Id"]);
				}
				$Atencion->setCaso($Casos->getId());
				//$Atencion->setCanal($row['Canal']);
				$Atencion->setFechaAtencion($ObjAtencion['FechaAtencion']);
				$Atencion->setAtendio($ObjAtencion['Atendio']);
				$Atencion->setAccionRealizada($ObjAtencion['AccionRealizada']);
				$Atencion->setDescripcion($ObjAtencion['Descripcion']);
				$Atencion->setCanalizacion($ObjAtencion['Canalizacion']);
				$cambios_a=$DaoLogs->compareObject($Atencion_o, $Atencion);
				if(count($cambios_a["updated"])+count($cambios_a["added"])>0){
					$Casos->setLastUpdate(date("Y-m-d H:i:s"));
					$Atencion=$DaoAtencion->addOrUpdate($Atencion);
					$DaoLogs->compareObjectAndAdd($Atencion_o, $Atencion,$Sesion);
				}
			}
			$cambios=$DaoLogs->compareObject($Casos_o, $Casos);
			if(count($cambios["updated"])+count($cambios["added"])>0){
				$Casos->setLastUpdate(date("Y-m-d H:i:s"));
				$Casos=$DaoCasos->addOrUpdate($Casos);
				$DaoLogs->compareObjectAndAdd($Casos_o, $Casos,$Sesion);
			}
			$cambios["Id"]=$Casos->getId();
			echo(json_encode($cambios));
		}
		if($_POST['action']=="geoLocate"){
			$addData=array();
			$url="https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($_POST["direccion"])."&region=mx&country=mx&language=es-419&key=".$DaoLogs->getParam("Google_APIKey_server");
			$result=$DaoLogs->gweb_curl("GET", $addData, $url);
			echo($result);
		}
		if($_POST['action']=="getBinario"){
			require_once("../dep/clases/DaoBinarios.php");
			$DaoBinarios=new DaoBinarios();
			$Binario=$DaoBinarios->show($_POST['Id']);
			echo(json_encode($Binario));
			$Result=$DaoBinarios->readFromGoogleStorage($Binario->getNonce());
			echo('------Data-----');
			echo($Result);
		}
		if($_POST['action']=="getBinarioBase64"){
			require_once("../dep/clases/DaoBinarios.php");
			$DaoBinarios=new DaoBinarios();
			$Binario=$DaoBinarios->show($_POST['Id']);
			echo(json_encode($Binario));
			$Result=$DaoBinarios->readFromGoogleStorage($Binario->getNonce());
			echo('------Data-----');
			echo(base64_encode($Result));
		}
	}
	if(isset($_GET['action'])){
		if($_GET['action']=="uploadFile"){
			$resp=array();
			if(isset($_GET['base64'])) {
				// If the browser does not support sendAsBinary ()
				$dataFile=file_get_contents('php://input');
				if(isset($_POST['fileExplorer'])){
					//If the browser support readAsArrayBuffer ()
					//PHP handles spaces in base64 encoded string differently
					//so to prevent corruption of data, convert spaces to +
					$dataFile=$_POST['fileExplorer'];
					$dataFile = str_replace(' ', '+', $dataFile);
				}
				$bin = base64_decode($dataFile);
				$nombre=$_GET["filename"];
				$tipo=$_GET["TypeFile"];
				$resp["nonce"]=$_GET['nonce'];
				$resp["metodo"]="GET";
			}else{
				$nombre=$_FILES["upload"]["filename"];
				$tipo=mime_content_type($_FILES["upload"]["tmp_name"]);
				$bin=file_get_contents($_FILES["upload"]["tmp_name"]);
				$resp["metodo"]="FILES";
				$resp["nonce"]=$_POST['nonce'];
			}
			require_once("../dep/clases/DaoBinarios.php");
			$DaoBinarios=new DaoBinarios();
			
			$nonceBin=$DaoBinarios->nonce();
			$resultGoogle=$DaoBinarios->saveToGoogleStorage($bin,$nonceBin);
			$resp["resultGoogle"]=$resultGoogle;
			if(isset($resultGoogle->error)){
				$resp["error"]=$resultGoogle->error->message;
			}else{
				$Binarios=new Binarios();
				$Binarios->setDateBorn(date("Y-m-d H:i:s"));
				$Binarios->setUsuarioRegistra($Usuario->getId());
				$Binarios->setNombreFile($nombre);
				$Binarios->setNonce($nonceBin);
				$Binarios->setMimeType($tipo);
				$Binarios->setGoogleUID($resultGoogle->id);
				//$Binarios->setObjeto("Persona");
				//$Binarios->setIdObjeto($row['IdObjeto']);
				$Binarios=$DaoBinarios->add($Binarios);
				$resp["binario"]=$Binarios;
			}
			echo(json_encode($resp));
		}
	}
}else{
	var_dump($_SERVER);
}
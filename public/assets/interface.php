<?php
include_once "includes.php";
include_once "../dep/clases/DaoCatalogos.php";
$DaoCatalogos=new DaoCatalogos();
/*
if($Sesion->getId()>0){
	$DaoSesiones->updateDeath($Sesion);
}
*/
function interface_header($title="",$description=""){
	global $file_script, $Usuario;
	?><!doctype html>
<html class="no-js" lang="es">
  <head>
	<meta charset="utf-8">
	<title><?php echo($title); ?></title>
	<meta name="description" content="<?php echo($description); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<meta property="og:title" content="<?php echo($title); ?>">
	<meta property="og:type" content="website">
	<meta property="og:url" content="">
	<meta property="og:image" content="">
	
	<link rel="manifest" href="site.webmanifest">
	<link rel="apple-touch-icon" href="icon.png">
	<!-- Place favicon.ico in the root directory -->
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<link rel="stylesheet" href="assets/css/style.css?v=2021.11.11.20.51">
	<?php if(file_exists("assets/css/$file_script.css")){ ?>
	<link rel="stylesheet" href="assets/css/<?php echo($file_script); ?>.css?v=2021.11.11.20.51">
	<?php } ?>
	<meta name="theme-color" content="#E21F23">
  </head>
  
  <body>
  	<?php if($Usuario->getId()>0){ ?>
  	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container-fluid">
			<a class="navbar-brand" href="/"><img src="/assets/img/logo.svg" /></a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="menuPrincipal">
				<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo($Usuario->getSeudonimo()); ?></a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
							<li><a class="dropdown-item" href="cuenta"><i class="fas fa-user-circle"></i> Mi cuenta</a></li>
							<li><a class="dropdown-item" href="configuracion"><i class="fas fa-cog"></i> Configuración</a></li>
							<li><hr class="dropdown-divider"></li>
							<li><a class="dropdown-item" href="logout"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></li>
						</ul>
					</li>
				</ul>
				<form class="d-flex" id="buscadorForm">
					<input id="buscadorInput" class="form-control me-2" type="search" placeholder="Buscar…" aria-label="Buscar">
					<i id="toggleSearch" onclick="toggleSearch()" class="fas fa-search" aria-label="Mostrar buscador"></i>
				</form>
				<ul id="resultados_buscadorForm"></ul>
			</div>
		</div>
	  </nav>
	<?php
	}
}

function interface_footer(){
	global $file_script, $Usuario;;
	?>
	<div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;" id="toastContainer">
		<div style="position: absolute; top: 0; right: 0;" id="toastList">
			<div class="toast" id="toastEx" role="alert" aria-live="assertive" aria-atomic="true">
				  <div class="toast-header">
					<strong class="mr-auto">Bootstrap</strong>
					<button type="button" class="ml-2 mb-1 close" data-bs-dismiss="toast" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="toast-body">
					See? Just like this.
				  </div>
				</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
	<script src="https://kit.fontawesome.com/aa45a4623b.js" crossorigin="anonymous"></script>
	<?php if($Usuario->getId()>0){ ?>
	<script src="assets/js/app.js?v=2021.11.11.20.51"></script>
	<?php } ?>
	<?php if(file_exists("assets/js/$file_script.js")){ ?>
	<script src="assets/js/<?php echo($file_script); ?>.js?v=2021.11.11.20.51"></script>
	<?php } ?>
  </body>
</html>
	<?php
}
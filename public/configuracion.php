<?php
require_once("assets/interface.php");
$title="Configuración del sistema";
$description="Configuración del sistema.";
interface_header($title,$description); ?>
<div class="container">
	<h1>Configuraciones</h1>
	<ul id="configuraciones">
		<a href="usuarios"><li><i class="fas fa-users-cog"></i> <span>Usuarios y permisos</span></li></a>
		<a href="usuarios"><li><i class="fas fa-server"></i> <span>Configuración del servidor</span></li></a>
	</ul>
</div>
<?php
interface_footer();
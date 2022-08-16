<?php
require_once("assets/interface.php");
$title="Mi cuenta";
$description="Configuración de tu cuenta de usuario.";
interface_header($title,$description); ?>
<div class="container">
	<h1>Mi cuenta</h1>
	<div class="row">
		<div class="col-12 col-lg-6">
			<h2><i class="fas fa-user-circle"></i> Mis datos</h2>
			<form>
				<div class="row">
					<div class="mb-3 col-12">
						<label for="nombreUsuario" class="form-label">Nombre(s)</label>
						<input type="text" class="form-control" id="nombreUsuario" value="<?php echo($Usuario->getNombre()); ?>">
					</div>
					<div class="mb-3 col-12">
						<label for="apellidosUsuario" class="form-label">Apellidos</label>
						<input type="text" class="form-control" id="apellidosUsuario" value="<?php echo($Usuario->getApellidos()); ?>">
					</div>
					<div class="mb-3 col-12">
						<label for="seudonimoUsuario" class="form-label">Seudónimo</label>
						<input type="text" class="form-control" id="seudonimoUsuario" value="<?php echo($Usuario->getSeudonimo()); ?>">
					</div>
					<div class="mb-3 col-12">
						<label for="emailUsuario" class="form-label">Correo electrónico</label>
						<input type="text" class="form-control" id="emailUsuario" value="<?php echo($Usuario->getEmail()); ?>">
					</div>
				</div>
			</form>
		</div>
		<div class="col-12 col-lg-6">
			<h2><i class="fas fa-desktop"></i> Sesiones abiertas</h2>
			<p>Si no reconoces una sesión da clic en el botón de eliminar y se cerrará de manera automática.</p>
			<ul class="list-group mb-3" id="sesionesAbiertas">
				<?php foreach($DaoSesiones->getByUsuarioId($Usuario->getId()) as $SesionAbierta){ ?>
				<li class="list-group-item <?php if($SesionAbierta->getId()==$Sesion->getId()){ echo("actual"); } ?>" data-id="<?php echo($SesionAbierta->getId()); ?>">
					<span class="dateBorn"><?php echo($DaoSesiones->formatFecha($SesionAbierta->getDateBorn(), true)); ?>, <?php echo(substr($SesionAbierta->getDateBorn(), -8)); ?> horas</span>
					<span class="location"><?php echo($SesionAbierta->getLocation()); ?> (IP: <?php echo($SesionAbierta->getIP()); ?>)</span>
					<span class="dispositivo"><?php echo($SesionAbierta->getClient()); ?>, <?php if($SesionAbierta->getId()==$Sesion->getId()){ echo(", <b>dispositivo actual</b>."); } ?></span>
					<i class="far fa-trash-alt" onclick="cerrarSesion(this)"></i>
				</li>
				<?php } ?>
			</ul>
			<p class="text-center"><a onclick="cerrarSesiones()" class="btn btn-outline-danger btn-sm">Cerrar todas</a></p>
		</div>
	</div>
</div>
<?php
interface_footer();
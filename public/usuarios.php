<?php
require_once("assets/interface.php");
$title="Usuarios y permisos";
$description="Administración de usuarios y permisos.";
$tiposUsuario=array();
$tiposUsuario["superAdmin"]="Super administrador";
$tiposUsuario["atencionCasos"]="Atención a casos";
$tiposUsuario["reportesGenerales"]="Reportes generales";
$tiposUsuario["accesoCasos"]="Acceso a casos específicos";
interface_header($title,$description); ?>
<div class="container">
	<h1>Usuarios y permisos
		<button class="btn btn-primary floatAdd" type="button" title="Añadir usuario" onclick="modalUsuarios()"><i class="fas fa-plus"></i></button>
	</h1>
	
	<div class="row">
		<div class="col-12">
			
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Nombre</th>
						<th>Email</th>
						<th>Tipo</th>
						<th>Creado</th>
						<th>Activo</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($DaoUsuarios->showAll() as $Usuario){ ?>
					<tr data-id="<?php echo($Usuario->getId()); ?>" data-activo="<?php echo($Usuario->getActivo()); ?>">
						<td><?php echo($Usuario->getNombre()." ".$Usuario->getApellidos()); ?></td>
						<td><a href="mailto:<?php echo($Usuario->getEmail()); ?>"><i class="far fa-envelope"></i></a> <?php echo($Usuario->getEmail()); ?></td>
						<td><?php echo($tiposUsuario[$Usuario->getTipo()]); ?></td>
						<td><?php echo($DaoUsuarios->formatFecha($Usuario->getDateBorn(), 1)); ?></td>
						<td><i class="fas fa-user-check text-success"></i><i class="fas fa-user-slash text-danger"></i></td>
						<td><i class="far fa-file-alt" title="Reporte de actividad"></i></td>
						<td><i class="fas fa-edit text-primary" title="Editar usuario"></i></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row justify-content-md-center">
		<div class="col-12 col-lg-8">
			<hr>
			<h2>Tipos de usuario</h2>
			<div class="tipo" data-tipo="superAdmin">
				<h6>Super administrador</h6>
				<p>Acceso total a leer, administrar y editar todos los datos del sistema, casos y reportes.</p>
				<ul class="list-group"></ul>
			</div>
			<div class="tipo" data-tipo="atencionCasos">
				<h6>Atención a casos</h6>
				<p>Puede acceder para dar de alta un caso o modificar la información de los existentes.</p>
				<ul class="list-group"></ul>
			</div>
			<div class="tipo" data-tipo="reportesGenerales">
				<h6>Reportes generales</h6>
				<p>Sólo puede acceder a ver reportes agregados que no contienen datos identificadores.</p>
				<ul class="list-group"></ul>
			</div>
			<div class="tipo" data-tipo="accesoCasos">
				<h6>Acceso a casos específicos</h6>
				<p>Sólo puede acceder a ver o editar la información de casos específicos a los que se les haya dado acceso.</p>
				<ul class="list-group"></ul>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
	<div class="modal fade" id="modalUsuarios" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  <div class="modal-body">
			  <form>
				  <div class="row">
					  <div class="form-group col-12 col-lg-6 mb-3">
						  <label for="emailUsuario">Email *</label>
						  <input type="email" class="form-control" id="emailUsuario" aria-describedby="emailUsuarioHelp" required/>
						  <small id="emailUsuarioHelp" class="form-text text-muted">Un correo registrado con Google, como cualquiera @gmail.com</small>
					  </div>
					  <div class="form-group col-12 col-lg-6 mb-3">
						  <label for="tipoUsuario">Tipo *</label>
						  <select class="form-control" id="tipoUsuario" aria-describedby="tipoUsuarioHelp" required>
							  <option value=""></option>
							  <option value="superAdmin">Super administrador</option>
							  <option value="atencionCasos">Atención a casos</option>
							  <option value="reportesGenerales">Reportes generales</option>
							  <option value="accesoCasos">Acceso a casos específicos</option>
						  </select>
						  <small id="tipoUsuarioHelp" class="form-text text-muted">Selecciona un tipo de usuario</small>
					  </div>
					  <div class="form-group col-12 col-lg-6 mb-3">
						  <label for="nombreUsuario">Nombre</label>
						  <input type="text" class="form-control" id="nombreUsuario" />
					  </div>
					  <div class="form-group col-12 col-lg-6 mb-3">
							<label for="apellidosUsuario">Apellidos</label>
							<input type="text" class="form-control" id="apellidosUsuario" />
						</div>
						<div class="form-group col-12 col-lg-6 mb-3">
							<label for="seudonimoUsuario">Pseudónimo</label>
							<input type="text" class="form-control" id="seudonimoUsuario" />
						</div>
						<div class="detalles col-12 col-lg-6 mb-3"></div>
				  </div>
			  </form>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
			<button type="button" class="btn btn-primary" id="guardarUsuario" onclick="guardarUsuario()">Crear</button>
		  </div>
		</div>
	  </div>
	</div>
<?php
interface_footer();
<?php
require_once("assets/interface.php");
require_once("../dep/clases/DaoCasos.php");
require_once("../dep/clases/DaoAtencion.php");
$DaoCasos=new DaoCasos();
$DaoAtencion=new DaoAtencion();
$Caso=new Casos();
if(isset($_GET["id"])){
	$Caso=$DaoCasos->show($_GET["id"]);
}
$title=$Caso->getId()." - ".$Caso->getNombre();
$description="Caso de atención: ".$Caso->getNombre();
if(!$Caso->getId()>0){
	$title="Nueva ficha de atención";
	$description="Nueva ficha de atención";
	if(strpos($_SERVER["REQUEST_URI"], "caso")!==false){
		$title="Nuevo caso";
		$description="Nuevo caso del colectivo";
	}
}
interface_header($title,$description); ?>
<div class="container" data-updated="<?php echo($Caso->getLastUpdate()); ?>">
	<h1><span><?php echo($Caso->getId()); ?></span> <?php echo($Caso->getNombre()); if(!$Caso->getId()>0){ echo($title); }?></h1>
	<ul id="tabs">
		<li data-target="infoGeneral">Información general</li>
		<li data-target="personasDesaparecidas">Personas desaparecidas</li>
		<li data-target="actos"><span class="hide-on-atencion">Actos</span><span class="hide-on-caso">Estatus</span></li>
		<li data-target="denunciasReportes">Denuncias y reportes</li>
		<li data-target="atencion">Atención</li>
	</ul>
	<div id="contenidos">
		<div class="tab readonly" data-tab="infoGeneral">
			<div class="row">
				<div class="col-12 mb-3">
					<label for="nombreCaso">Nombre del caso:</label>
					<input type="text" readonly class="form-control-plaintext first-focus" id="nombreCaso" value="<?php echo($Caso->getNombre()); ?>" />
				</div>
				<div class="col-12">
					<div class="row">
						<div class="col-12 col-md-6 comoSeEntero">
							<p class="label">¿Cómo se enteró de la organización?</p>
							<?php 
							$ComoSeEntero=$DaoCatalogos->getByNombre("ComoSeEntero");
							foreach($ComoSeEntero->getValores() as $Valor){ ?>
							<div class="form-check">
								<input class="form-check-input" type="checkbox" value="<?php echo($Valor->getValor()); ?>" id="valorCatalogo_<?php echo($Valor->getId()); ?>">
								<label class="form-check-label" for="valorCatalogo_<?php echo($Valor->getId()); ?>"><?php echo($Valor->getValor()); ?></label>
							</div>
							<?php } ?>
							<div class="sugerenciasInput autoridadEnteroCaso">
								<label for="autoridadEnteroCaso">Especificar la autoridad:</label>
								<input type="text" readonly class="form-control-plaintext" id="autoridadEnteroCaso" value="<?php if(isset($Caso->getData()["autoridadEnteroCaso"])){ echo($Caso->getData()["autoridadEnteroCaso"]); } ?>" />
								<ul class="listaSugerencias">
									<?php $AutoridadesComoSeEntero=$DaoCatalogos->getByNombre("AutoridadesComoSeEntero");foreach($AutoridadesComoSeEntero->getValores() as $Valor){ ?>
									<li><?php echo($Valor->getValor()); ?></li>
									<?php } ?>
								</ul>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<p>Personas de contacto <i class="fas fa-plus" id="addPersonaContacto" onclick="modalPersonaContacto()"></i></p>
							<ul id="personaContacto"></ul>
						</div>
					</div>
					<div class="row">
						<div class="col-12 text-end mt-3">
							<button type="button" class="btn btn-outline-danger" id="guardarInfoGeneral" onclick="guardarInfoGeneral()">Guardar</button>
							<button type="button" class="btn btn-outline-danger" id="editarInfoGeneral" onclick="habilitarEdicionTab('infoGeneral')">Editar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="tab readonly" data-tab="personasDesaparecidas">
			<div class="row">
				<div class="col-12 mb-3">
					<p for="personasDesaparecidas_cantidad">Número de personas desaparecidas: <b id="personasDesaparecidas_cantidad"></b> <i class="fas fa-plus-circle" onclick="addPersonaDesaparecida()" title="Añadir nuevo" id="addPersonaDesaparecida"></i></p>
				</div>
			</div>
			<div class="row">
				<div class="col-12" id="listadoPersonasDesaparecidas">
					<div class="personaDesaparecida" data-id="" data-nonce="" >
						<p class="contador">Persona 1</p>
						<p class="nombre"><span>Sin dato</span></p>
						<p class="datos"><span class="sexo">Sin dato</span>, <span class="edad">Sin dato</span>.</p>
						<i class="fas fa-user-edit" onclick="modalPersonaDesaparecida(this)"></i>
						<i class="fas fa-trash-alt" onclick="delPersonaDesaparecida(this)"></i>
						<textarea class="objeto">{}</textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 text-end mt-3">
					<button type="button" class="btn btn-outline-danger" id="guardarPersonasDesaparecidas" onclick="deshabilitarEdicionTab('personasDesaparecidas');">Dejar de editar</button>
					<button type="button" class="btn btn-outline-danger" id="editarPersonasDesaparecidas" onclick="habilitarEdicionTab('personasDesaparecidas')">Editar</button>
				</div>
			</div>
		</div>
		<div class="tab readonly" data-tab="actos">
			<div class="row">
				<div class="col-12">
					<p class="hide-on-atencion">Añadir acto <i class="fas fa-plus" onclick="modalSeleccionarActo()" title="Añadir nuevo" id="addActo"></i></p>
					<p class="hide-on-caso">Actualizar estatus <i class="fas fa-plus" onclick="modalSeleccionarActo()" title="Añadir nuevo" id="addActo"></i></p>
					<div id="listadoActos">
						
					</div>
				</div>
				<div class="col-12 text-end mt-3">
					<button type="button" class="btn btn-outline-danger" id="guardarActos" onclick="guardarCaso()">Guardar</button>
					<button type="button" class="btn btn-outline-danger" id="editarActos" onclick="habilitarEdicionTab('actos')">Editar</button>
				</div>
			</div>
		</div>
		<div class="tab readonly" data-tab="denunciasReportes">
			<div class="row">
				<div class="col-12 col-md-6 ministerioPublico">
					<h5>Denuncia en ministerio público</h5>
					<p>¿Cuenta con denuncia? <b class="realizada"></b></p>
					<p>Nivel de gobierno: <b class="autoridad"></b></p>
					<p class="motivo"></p>
					<button type="button" class="btn btn-outline-danger" id="editarActos" onclick="modalDenunciaMP()">Editar</button>
				</div>
				<div class="col-12 col-md-6 comisionBusqueda">
					<h5>Reporte en Comisión de Búsqueda</h5>
					<p>¿Cuenta con reporte? <b class="realizada"></b></p>
					<p>Nivel de gobierno: <b class="autoridad"></b></p>
					<p class="motivo"></p>
					<button type="button" class="btn btn-outline-danger" id="editarActos" onclick="modalReporteCB()">Editar</button>
				</div>
				<div class="col-12 text-end mt-3">
					<button type="button" class="btn btn-outline-danger" id="guardarDenuncias" onclick="guardarCaso()">Guardar</button>
				</div>
			</div>
		</div>
		<div class="tab readonly" data-tab="atencion">
			<div class="row">
				<div class="col-12">
					<p>Registrar atención <i class="fas fa-plus" onclick="modalAtencion()" title="Añadir nuevo" id="addAtencion"></i></p>
					<ul id="listadoAtenciones"></ul>
				</div>
				<div class="col-12 text-end mt-3">
					<button type="button" class="btn btn-outline-danger" id="guardarAtencion" onclick="guardarCaso()">Guardar</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalPersonaContacto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Nuevo timeline</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="form-group col-12 mb-3">
						<label for="nombrePersonaContacto">Nombre *</label>
						<input type="text" class="form-control" id="nombrePersonaContacto"  required/>
					</div>
					<div class="col-12 col-md-6  mb-3">
						<p>Sexo:</p>
						<div class="form-check mb-3 sexoPersonaContacto">
							<input class="form-check-input" type="radio" name="sexoPersonaContacto" id="sexoPersonaContacto_hombre" value="Hombre">
							  <label class="form-check-label" for="sexoPersonaContacto_hombre">
								Hombre
							  </label>
						</div>
						<div class="form-check mb-3 sexoPersonaContacto">
							<input class="form-check-input" type="radio" name="sexoPersonaContacto" id="sexoPersonaContacto_mujer" value="Mujer">
							  <label class="form-check-label" for="sexoPersonaContacto_mujer">
								Mujer
							  </label>
						</div>
						<div class="input-group">
							<div class="input-group-text">
								<input class="form-check-input mt-0" type="radio" name="sexoPersonaContacto" value="Otro" aria-label="Otro">
							</div>
							<input type="text" class="form-control" placeholder="Otro" aria-label="Otro" id="sexoPersonaContacto_otro">
						</div>
						<div class="form-check mb-3 sexoPersonaContacto">
							<input class="form-check-input" type="radio" name="sexoPersonaContacto" id="sexoPersonaContacto_sinDato" value="Sin dato">
							  <label class="form-check-label" for="sexoPersonaContacto_sinDato">
								Sin dato
							  </label>
						</div>
					</div>
					<div class="col-12 col-md-6  mb-3">
						<p>Relación de la persona que reporta con la persona desaparecida:</p>
						<?php 
						$RelacionConDesaparecido=$DaoCatalogos->getByNombre("RelacionConDesaparecido");
						foreach($RelacionConDesaparecido->getValores() as $Valor){ ?>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="RelacionConDesaparecidoContacto" value="<?php echo($Valor->getValor()); ?>" id="valorCatalogo_<?php echo($Valor->getId()); ?>">
							<label class="form-check-label" for="valorCatalogo_<?php echo($Valor->getId()); ?>"><?php echo($Valor->getValor()); ?></label>
						</div>
						<?php } ?>
						<div class="input-group">
							<div class="input-group-text">
								<input class="form-check-input mt-0" type="radio" name="RelacionConDesaparecidoContacto" value="Otro" aria-label="Otro">
							</div>
							<input type="text" class="form-control" placeholder="Otro" aria-label="Otro" id="RelacionConDesaparecidoContacto_otro">
						</div>
					</div>
					<div class="col-12 mb-3">
						<p>En caso de no ser familiar directo de la persona desaparecida: ¿Cuenta con autorización de la familia?</p>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="autorizacionDeLaFamiliaContacto" id="autorizacionDeLaFamiliaContacto_si" value="1">
						  <label class="form-check-label" for="autorizacionDeLaFamiliaContacto_si">Sí</label>
						</div>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="autorizacionDeLaFamiliaContacto" id="autorizacionDeLaFamiliaContacto_no" value="0">
						  <label class="form-check-label" for="autorizacionDeLaFamiliaContacto_no">No</label>
						</div>
					</div>
					<div class="col-12 mb-3">
						<p>Datos de contacto:</p>
						<div class="datosContactoContacto">
							<div class="input-group mb-3 datoContactoContacto nuevo">
								<input type="text" class="form-control tipoDato" placeholder="Tipo dato" aria-label="Tipo dato" onkeyup="toggle_datoContactoContacto(this)">
								<span class="input-group-text">:</span>
								<input type="text" class="form-control valorDato" placeholder="Dato" aria-label="Dato" onkeyup="toggle_datoContactoContacto(this)">
								<i class="fas fa-minus-circle delete_datoContactoContacto" onclick="delete_datoContactoContacto(this)"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary" id="savePersonaContacto" onclick="savePersonaContacto()">Crear</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modalPersonaDesaparecida" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Persona desaparecida</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="form-group col-12 mb-3">
						<label for="nombrePersonaContacto">Nombre *</label>
						<input type="text" class="form-control" id="nombrePersonaDesaparecida"  required/>
					</div>
					<div class="col-12">
						<p class="label_p">Sexo:</p>
						<div class="form-check form-check-inline mb-3 sexoPersonaContacto">
							<input class="form-check-input" type="radio" name="sexoPersonaDesaparecida" id="sexoPersonaDesaparecida_hombre" value="Hombre">
							  <label class="form-check-label" for="sexoPersonaDesaparecida_hombre">
								Hombre
							  </label>
						</div>
						<div class="form-check form-check-inline mb-3 sexoPersonaContacto">
							<input class="form-check-input" type="radio" name="sexoPersonaDesaparecida" id="sexoPersonaDesaparecida_mujer" value="Mujer">
							  <label class="form-check-label" for="sexoPersonaDesaparecida_mujer">
								Mujer
							  </label>
						</div>
						<div class="input-group otroSexoPersonaDesaparecida">
							<div class="input-group-text">
								<input class="form-check-input mt-0" type="radio" name="sexoPersonaDesaparecida" value="Otro" aria-label="Otro">
							</div>
							<input type="text" class="form-control" placeholder="Otro" aria-label="Otro" id="sexoPersonaDesaparecida_otro">
						</div>
						<div class="form-check mb-3 form-check-inline sexoPersonaContacto">
							<input class="form-check-input" type="radio" name="sexoPersonaDesaparecida" id="sexoPersonaDesaparecida_sinDato" value="Sin dato">
							  <label class="form-check-label" for="sexoPersonaDesaparecida_sinDato">
								Sin dato
							  </label>
						</div>
					</div>
					<div class="col-12 col-md-6 mb-3">
						<p class="label_p">Edad:</p>
						<div class="row">
							<div class="col-12 col-md-6">
								<label for="edadPersonaDesaparecida">Edad</label>
								<input type="number" class="form-control" id="edadPersonaDesaparecida"  required/>
							</div>
							<div class="col-12 col-md-6 mt-2">
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="edadPersonaDesaparecida_tipo" id="edadPersonaDesaparecida_anios" value="Anios" checked="">
									<label class="form-check-label" for="edadPersonaDesaparecida_anios">
										Años
									</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="edadPersonaDesaparecida_tipo" id="edadPersonaDesaparecida_meses" value="Meses">
									<label class="form-check-label" for="edadPersonaDesaparecida_meses">
										Meses
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12">
						<p>Fotografías:</p>
						<div class="mb-3">
							  <label for="archivosFotosPersonasDesaparecidas" class="form-label">Selecciona las fotografías a subir<span class="d-none d-md-inline-block"> o arrástralas al cuadro</span>:</label>
							  <input class="form-control" type="file" id="archivosFotosPersonasDesaparecidas" accept="image/*" multiple>
							</div>
						<div id="fotografiasPersonaDesaparecida">
							<p>Sin fotografías</p>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary" id="savePersonaDesaparecida" onclick="savePersonaDesaparecida()">Guardar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modalDeletePersonaDesaparecida" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Eliminar persona desaparecida</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="form-group col-12 mb-3">
						<p>El registro de persona desaparecida que intentas borrar contiene datos, ¿Quieres realmente borrarlo?</p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary" id="savePersonaDesaparecida" onclick="confirmDeletePersonaDesaparecida()">Guardar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modalSeleccionarActo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5	class="modal-title">Selecciona el tipo de acto</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<p>
							<button type="button" class="btn btn-primary" id="modalActoDesaparicion" onclick="modalActo()">Desaparición</button>
						</p>
						<p>
							<button type="button" class="btn btn-primary" id="modalActoDesaparicion" onclick="modalLocalizadaConVida()">Localización con vida</button>
						</p>
						<p>
							<button type="button" class="btn btn-primary" id="modalActoDesaparicion" onclick="modalLocalizadaSinVida()">Localización sin vida</button>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modalActo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Acto</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="form-group col-12 mb-3">
						<h6>1. Personas desaparecidas</h6>
						<div id="modalActo_personasDesaparecidas"></div>
					</div>
					<div class="form-group col-12 mb-3">
						<h6>2. Tipo de registro</h6>
						<div class="hide-on-caso">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="tipoActo" id="tipoActo_desaparicion" value="Desaparición">
								<label class="form-check-label" for="tipoActo_desaparicion">Persona desaparecida</label>
							</div>
						</div>
						<div class="hide-on-atencion">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="tipoActo" id="tipoActo_desaparicionForzada" value="Desaparición forzada de personas">
								<label class="form-check-label" for="tipoActo_desaparicionForzada">Desaparición forzada de personas</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="tipoActo" id="tipoActo_desaparicionPorParticulares" value="Desaparición cometida por particulares">
								<label class="form-check-label" for="tipoActo_desaparicionPorParticulares">Desaparición cometida por particulares</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="tipoActo" id="tipoActo_PrivacionIlegal" value="Privación ilegal a la libertad">
								<label class="form-check-label" for="tipoActo_PrivacionIlegal">Privación ilegal a la libertad</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="tipoActo" id="tipoActo_Secuestro" value="Secuestro">
								<label class="form-check-label" for="tipoActo_Secuestro">Secuestro</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="tipoActo" id="tipoActo_Trata" value="Trata de personas">
								<label class="form-check-label" for="tipoActo_Trata">Trata de personas</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="tipoActo" id="tipoActo_Otro" value="Otro">
								<label class="form-check-label" for="tipoActo_Otro">Otro</label>
							</div>
						</div>
					</div>
					<div class="form-group col-6 mb-3 tipoActo_OtroOtro">
						<label for="tipoActo_OtroOtro">Otro tipo de acto:</label>
						<input type="text" class="form-control" id="tipoActo_OtroOtro" required/>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-12 mb-3">
						<h6>3. Fecha de la desaparición:</h6>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="tipoFechaActo" id="tipoFechaActo_rango" value="Rango" onchange="toggle_tipoFechaActo_rango()">
							<label class="form-check-label" for="tipoFechaActo_rango">Rango de fechas u horas</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="tipoFechaActo" id="tipoFechaActo_puntual" value="Puntual" onchange="toggle_tipoFechaActo_rango()">
							<label class="form-check-label" for="tipoFechaActo_puntual">Fecha puntual o aproximada</label>
						</div>
					</div>
					<div class="form-group col-12 tipoFechaActo_rango">
						<p class="tipoFechaActo_rango">Entre el:</p>
					</div>
					<div class="form-group col-2 mb-3">
						<label for="fechaIniActo_anio">Año</label>
						<input type="number" class="form-control" id="fechaIniActo_anio"  required/>
					</div>
					<div class="form-group col-4 mb-3">
						<label for="fechaIniActo_mes">Mes</label>
						<select class="form-select" id="fechaIniActo_mes">
							<option selected  value="">Sin especificar</option>
							<option value="01">Enero</option>
							<option value="02">Febrero</option>
							<option value="03">Marzo</option>
							<option value="04">Abril</option>
							<option value="05">Mayo</option>
							<option value="06">Junio</option>
							<option value="07">Julio</option>
							<option value="08">Agosto</option>
							<option value="09">Septiembre</option>
							<option value="10">Octubre</option>
							<option value="11">Noviembre</option>
							<option value="12">Diciembre</option>
						</select>
					</div>
					<div class="form-group col-2 mb-3">
						<label for="fechaIniActo_dia">Día</label>
						<input type="number" class="form-control" id="fechaIniActo_dia" placeholder="Sin especificar" required/>
					</div>
					<div class="form-group col-4 mb-3">
						<div class="row">
							<div class="form-group col-5">
								<label for="fechaIniActo_hora">Hora</label>
								<select class="form-select" id="fechaIniActo_hora">
									<option selected  value="">Sin especificar</option>
									<option value="00">00</option>
									<option value="01">01</option>
									<option value="02">02</option>
									<option value="03">03</option>
									<option value="04">04</option>
									<option value="05">05</option>
									<option value="06">06</option>
									<option value="07">07</option>
									<option value="08">08</option>
									<option value="09">09</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
									<option value="13">13</option>
									<option value="14">14</option>
									<option value="15">15</option>
									<option value="16">16</option>
									<option value="17">17</option>
									<option value="18">18</option>
									<option value="19">19</option>
									<option value="20">20</option>
									<option value="21">21</option>
									<option value="22">22</option>
									<option value="23">23</option>
								</select>
							</div>
							<div class="form-group col-1 mt-4">:</div>
							<div class="form-group col-5">
								<label for="fechaIniActo_minuto">Min</label>
								<select class="form-select" id="fechaIniActo_minuto">
									<option selected  value="">Sin especificar</option>
									<option value="00">00</option>
									<option value="01">01</option>
									<option value="02">02</option>
									<option value="03">03</option>
									<option value="04">04</option>
									<option value="05">05</option>
									<option value="06">06</option>
									<option value="07">07</option>
									<option value="08">08</option>
									<option value="09">09</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
									<option value="13">13</option>
									<option value="14">14</option>
									<option value="15">15</option>
									<option value="16">16</option>
									<option value="17">17</option>
									<option value="18">18</option>
									<option value="19">19</option>
									<option value="20">20</option>
									<option value="21">21</option>
									<option value="22">22</option>
									<option value="23">23</option>
									<option value="24">24</option>
									<option value="25">25</option>
									<option value="26">26</option>
									<option value="27">27</option>
									<option value="28">28</option>
									<option value="29">29</option>
									<option value="30">30</option>
									<option value="31">31</option>
									<option value="32">32</option>
									<option value="33">33</option>
									<option value="34">34</option>
									<option value="35">35</option>
									<option value="36">36</option>
									<option value="37">37</option>
									<option value="38">38</option>
									<option value="39">39</option>
									<option value="40">40</option>
									<option value="41">41</option>
									<option value="42">42</option>
									<option value="43">43</option>
									<option value="44">44</option>
									<option value="45">45</option>
									<option value="46">46</option>
									<option value="47">47</option>
									<option value="48">48</option>
									<option value="49">49</option>
									<option value="50">50</option>
									<option value="51">51</option>
									<option value="52">52</option>
									<option value="53">53</option>
									<option value="54">54</option>
									<option value="55">55</option>
									<option value="56">56</option>
									<option value="57">57</option>
									<option value="58">58</option>
									<option value="59">59</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-6 offset-6 mb-3">
						<label for="fechaIniActo_detalle">Exactitud de la hora</label>
						<select class="form-select" id="fechaIniActo_detalle">
							<option>Selecciona una opción</option>
							<option value="month">Cercano al día especificado</option>
							<option value="day">Durante el día</option>
							<option value="hour">Hora aproximada</option>
							<option value="minute">Minuto aproximado</option>
							<option value="second">Minuto exacto</option>
						</select>
					</div>
					<div class="form-group col-12 tipoFechaActo_rango">
						<p>y el:</p>
					</div>
					<div class="form-group col-2 mb-3 tipoFechaActo_rango">
						<label for="fechaFinActo_anio">Año</label>
						<input type="number" class="form-control" id="fechaFinActo_anio"  required/>
					</div>
					<div class="form-group col-4 mb-3 tipoFechaActo_rango">
						<label for="fechaFinActo_mes">Mes</label>
						<select class="form-select" id="fechaFinActo_mes">
							<option selected value="">Sin especificar</option>
							<option value="01">Enero</option>
							<option value="02">Febrero</option>
							<option value="03">Marzo</option>
							<option value="04">Abril</option>
							<option value="05">Mayo</option>
							<option value="06">Junio</option>
							<option value="07">Julio</option>
							<option value="08">Agosto</option>
							<option value="09">Septiembre</option>
							<option value="10">Octubre</option>
							<option value="11">Noviembre</option>
							<option value="12">Diciembre</option>
						</select>
					</div>
					<div class="form-group col-2 mb-3 tipoFechaActo_rango">
						<label for="fechaFinActo_dia">Día</label>
						<input type="number" class="form-control" id="fechaFinActo_dia" placeholder="Sin especificar" required/>
					</div>
					<div class="form-group col-4 mb-3 tipoFechaActo_rango">
						<div class="row">
							<div class="form-group col-5">
								<label for="fechaFinActo_hora">Hora</label>
								<select class="form-select" id="fechaFinActo_hora">
									<option selected  value="">Sin especificar</option>
									<option value="00">00</option>
									<option value="01">01</option>
									<option value="02">02</option>
									<option value="03">03</option>
									<option value="04">04</option>
									<option value="05">05</option>
									<option value="06">06</option>
									<option value="07">07</option>
									<option value="08">08</option>
									<option value="09">09</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
									<option value="13">13</option>
									<option value="14">14</option>
									<option value="15">15</option>
									<option value="16">16</option>
									<option value="17">17</option>
									<option value="18">18</option>
									<option value="19">19</option>
									<option value="20">20</option>
									<option value="21">21</option>
									<option value="22">22</option>
									<option value="23">23</option>
								</select>
							</div>
							<div class="form-group col-1 mt-4">:</div>
							<div class="form-group col-5">
								<label for="fechaFinActo_minuto">Min</label>
								<select class="form-select" id="fechaFinActo_minuto">
									<option selected value="">Sin especificar</option>
									<option value="00">00</option>
									<option value="01">01</option>
									<option value="02">02</option>
									<option value="03">03</option>
									<option value="04">04</option>
									<option value="05">05</option>
									<option value="06">06</option>
									<option value="07">07</option>
									<option value="08">08</option>
									<option value="09">09</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
									<option value="13">13</option>
									<option value="14">14</option>
									<option value="15">15</option>
									<option value="16">16</option>
									<option value="17">17</option>
									<option value="18">18</option>
									<option value="19">19</option>
									<option value="20">20</option>
									<option value="21">21</option>
									<option value="22">22</option>
									<option value="23">23</option>
									<option value="24">24</option>
									<option value="25">25</option>
									<option value="26">26</option>
									<option value="27">27</option>
									<option value="28">28</option>
									<option value="29">29</option>
									<option value="30">30</option>
									<option value="31">31</option>
									<option value="32">32</option>
									<option value="33">33</option>
									<option value="34">34</option>
									<option value="35">35</option>
									<option value="36">36</option>
									<option value="37">37</option>
									<option value="38">38</option>
									<option value="39">39</option>
									<option value="40">40</option>
									<option value="41">41</option>
									<option value="42">42</option>
									<option value="43">43</option>
									<option value="44">44</option>
									<option value="45">45</option>
									<option value="46">46</option>
									<option value="47">47</option>
									<option value="48">48</option>
									<option value="49">49</option>
									<option value="50">50</option>
									<option value="51">51</option>
									<option value="52">52</option>
									<option value="53">53</option>
									<option value="54">54</option>
									<option value="55">55</option>
									<option value="56">56</option>
									<option value="57">57</option>
									<option value="58">58</option>
									<option value="59">59</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-6 offset-6 tipoFechaActo_rango">
						<label for="fechaFinActo_detalle">Exactitud de la hora</label>
						<select class="form-select" id="fechaFinActo_detalle">
							<option>Selecciona una opción</option>
							<option value="month">Cercano al día especificado</option>
							<option value="day">Durante el día</option>
							<option value="hour">Hora aproximada</option>
							<option value="minute">Minuto aproximado</option>
							<option value="second">Minuto exacto</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<h6>4. Lugar de la desaparición:</h6>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="tipoLugarActo" id="tipoLugarActo_Puntual" value="Puntual" onchange="toggle_tipoLugarActo()">
							<label class="form-check-label" for="tipoLugarActo_Puntual">Lugar puntual o aproximado</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="tipoLugarActo" id="tipoLugarActo_EnTransito" value="EnTransito" onchange="toggle_tipoLugarActo()">
							<label class="form-check-label" for="tipoLugarActo_EnTransito">En tránsito</label>
						</div>
					</div>
					<div class="form-group col-10 mb-3">
						<label for="direccion_acto">Dirección o lugar de los hechos</label>
						<input type="text" class="form-control" id="direccion_acto" required/>
					</div>
					<div class="col-2 mt-4">
						<p>
							<button type="button" class="btn btn-danger" id="buscarDireccionActo" onclick="buscarDireccionActo()"><i class="fas fa-search"></i></button>
						</p>
					</div>
					<div class="col-4" id="resultadosDireccionActo">
						<div class="seleccionaResultadoDireccionActo">
						</div>
						<div class="componentesDireccionActo">
							<p>Marca las cajas que apliquen:</p>
							<p class="tipoLugarActo_EnTransito"><b>Desde:</b></p>
							<label for="valorPais_direccionActo">País</label>
							<div class="input-group mb-3">
								<div class="input-group-text">
									<input class="form-check-input mt-0" type="checkbox" value="" aria-label="Guardar el país" id="checkPais_direccionActo">
								</div>
								<input type="text" class="form-control" aria-label="País capturado" id="valorPais_direccionActo" placeholder="Sin especificar">
							</div>
							<label for="valorEstado_direccionActo">Estado</label>
							<div class="input-group mb-3">
								<div class="input-group-text">
									<input class="form-check-input mt-0" type="checkbox" value="" aria-label="Guardar el estado" id="checkEstado_direccionActo">
								</div>
								<input type="text" class="form-control" aria-label="Estado capturado" id="valorEstado_direccionActo" placeholder="Sin especificar">
							</div>
							<label for="valorMunicipio_direccionActo">Municipio</label>
							<div class="input-group mb-3">
								<div class="input-group-text">
									<input class="form-check-input mt-0" type="checkbox" value="" aria-label="Guardar el municipio" id="checkMunicipio_direccionActo" placeholder="Sin especificar">
								</div>
								<input type="text" class="form-control" aria-label="Municipio capturado" id="valorMunicipio_direccionActo" placeholder="Sin especificar">
							</div>
							<label for="valorLocalidad_direccionActo">Localidad</label>
							<div class="input-group mb-3">
								<div class="input-group-text">
									<input class="form-check-input mt-0" type="checkbox" value="" aria-label="Guardar la localidad" id="checkLocalidad_direccionActo" placeholder="Sin especificar">
								</div>
								<input type="text" class="form-control" aria-label="Localidad capturado" id="valorLocalidad_direccionActo" placeholder="Sin especificar">
							</div>
							<label for="valorColonia_direccionActo">Colonia</label>
							<div class="input-group mb-3">
								<div class="input-group-text">
									<input class="form-check-input mt-0" type="checkbox" value="" aria-label="Guardar la colonia" id="checkColonia_direccionActo">
								</div>
								<input type="text" class="form-control" aria-label="Colonia capturada" id="valorColonia_direccionActo" placeholder="Sin especificar">
							</div>
							<label for="valorCP_direccionActo">Código Postal</label>
							<div class="input-group mb-3">
								<div class="input-group-text">
									<input class="form-check-input mt-0" type="checkbox" value="" aria-label="Guardar el código postal" id="checkCP_direccionActo" placeholder="Sin especificar">
								</div>
								<input type="text" class="form-control" aria-label="Código postal capturado" id="valorCP_direccionActo" placeholder="Sin especificar">
							</div>
							<label for="valorDireccion_direccionActo">Dirección</label>
							<div class="input-group mb-3">
								<div class="input-group-text">
									<input class="form-check-input mt-0" type="checkbox" value="" aria-label="Guardar la dirección" id="checkDireccion_direccionActo" placeholder="Sin especificar">
								</div>
								<input type="text" class="form-control" aria-label="Dirección capturada" id="valorDireccion_direccionActo" placeholder="Sin especificar">
							</div>
						</div>
					</div>
					<div class="col-8">
						<p>Ubica un marcador o dibuja un área en el mapa: 
							<button type="button" class="btn btn-secondary" id="dropMarcadorMapaActo" onclick="dropMarcadorMapaActo()"><i class="fas fa-map-marker-alt"></i></button>
							<button type="button" class="btn btn-secondary" id="dibujarMapaActo" onclick="dibujarMapaActo()"><i class="fas fa-draw-polygon"></i></button>
						</p>
						<div id="mapaActo"></div>
						<div class="mb-3 mt-3 ">
							<label for="comentarios_direccionActo" class="form-label">Comentarios a la ubicación:</label>
							<textarea class="form-control" id="comentarios_direccionActo" rows="3"></textarea>
						</div>
					</div>
				</div>
				<div class="row tipoLugarActo_EnTransito componentesDireccionActo">
					<div class="col-12">
						<p><b>Hacia:</b></p>
					</div>
					<div class="form-group col-10 mb-3">
						<label for="direccion_actoTransito">Dirección o lugar de destino</label>
						<input type="text" class="form-control" id="direccion_actoTransito" required/>
					</div>
					<div class="col-2 mt-4">
						<p>
							<button type="button" class="btn btn-danger" id="buscarDireccionActoTransito" onclick="buscarDireccionActo('Transito')"><i class="fas fa-search"></i></button>
						</p>
					</div>
					<div class="col-4">
						<label for="valorPais_direccionActoTransito">País</label>
						<div class="input-group mb-3">
							<div class="input-group-text">
								<input class="form-check-input mt-0" type="checkbox" value="" aria-label="Guardar el país" id="checkPais_direccionActoTransito">
							</div>
							<input type="text" class="form-control" aria-label="País capturado" id="valorPais_direccionActoTransito" placeholder="Sin especificar">
						</div>
					</div>
					<div class="col-4">
						<label for="valorEstado_direccionActoTransito">Estado</label>
						<div class="input-group mb-3">
							<div class="input-group-text">
								<input class="form-check-input mt-0" type="checkbox" value="" aria-label="Guardar el estado" id="checkEstado_direccionActoTransito">
							</div>
							<input type="text" class="form-control" aria-label="Estado capturado" id="valorEstado_direccionActoTransito" placeholder="Sin especificar">
						</div>
					</div>
					<div class="col-4">
						<label for="valorMunicipio_direccionActoTransito">Municipio</label>
						<div class="input-group mb-3">
							<div class="input-group-text">
								<input class="form-check-input mt-0" type="checkbox" value="" aria-label="Guardar el municipio" id="checkMunicipio_direccionActoTransito" placeholder="Sin especificar">
							</div>
							<input type="text" class="form-control" aria-label="Municipio capturado" id="valorMunicipio_direccionActoTransito" placeholder="Sin especificar">
						</div>
					</div>
					<div class="col-4">
						<label for="valorLocalidad_direccionActoTransito">Localidad</label>
						<div class="input-group mb-3">
							<div class="input-group-text">
								<input class="form-check-input mt-0" type="checkbox" value="" aria-label="Guardar la localidad" id="checkLocalidad_direccionActoTransito" placeholder="Sin especificar">
							</div>
							<input type="text" class="form-control" aria-label="Localidad capturado" id="valorLocalidad_direccionActoTransito" placeholder="Sin especificar">
						</div>
					</div>
					<div class="col-4">
						<label for="valorColonia_direccionActoTransito">Colonia</label>
						<div class="input-group mb-3">
							<div class="input-group-text">
								<input class="form-check-input mt-0" type="checkbox" value="" aria-label="Guardar la colonia" id="checkColonia_direccionActoTransito">
							</div>
							<input type="text" class="form-control" aria-label="Colonia capturada" id="valorColonia_direccionActoTransito" placeholder="Sin especificar">
						</div>
					</div>
					<div class="col-4">
						<label for="valorCP_direccionActoTransito">Código Postal</label>
						<div class="input-group mb-3">
							<div class="input-group-text">
								<input class="form-check-input mt-0" type="checkbox" value="" aria-label="Guardar el código postal" id="checkCP_direccionActoTransito" placeholder="Sin especificar">
							</div>
							<input type="text" class="form-control" aria-label="Código postal capturado" id="valorCP_direccionActoTransito" placeholder="Sin especificar">
						</div>
					</div>
					<div class="col-4">
						<label for="valorDireccion_direccionActoTransito">Dirección</label>
						<div class="input-group mb-3">
							<div class="input-group-text">
								<input class="form-check-input mt-0" type="checkbox" value="" aria-label="Guardar la dirección" id="checkDireccion_direccionActoTransito" placeholder="Sin especificar">
							</div>
							<input type="text" class="form-control" aria-label="Dirección capturada" id="valorDireccion_direccionActoTransito" placeholder="Sin especificar">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary" id="guardarActo" onclick="guardarActo()">Guardar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modalDenunciaMP" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5	class="modal-title">Denuncia en Ministerio Público</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<p>¿Cuenta con denuncia en el Ministerio Público?</p>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="DenunciaMP_Si" value="option1">
							<label class="form-check-label" for="DenunciaMP_Si">Sí</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="DenunciaMP_No" value="option1">
							<label class="form-check-label" for="DenunciaMP_No">No</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="DenunciaMP_SinDato" value="option1">
							<label class="form-check-label" for="DenunciaMP_SinDato">Sin dato</label>
						</div>
					</div>
					<div class="col-12 DenunciaMP_Si">
						<p>¿En qué nivel de gobierno?</p>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="DenunciaMP_NivelFederal" value="option1">
							<label class="form-check-label" for="DenunciaMP_NivelFederal">Federal</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="DenunciaMP_NivelLocal" value="option1">
							<label class="form-check-label" for="DenunciaMP_NivelLocal">Local</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="DenunciaMP_NivelSinDato" value="option1">
							<label class="form-check-label" for="DenunciaMP_NivelSinDato">Sin dato</label>
						</div>
					</div>
					<div class="col-12 DenunciaMP_No">
						<label for="DenunciaMP_Motivo" class="form-label">¿Cuál es el motivo en caso de que no tenga denuncia?</label>
						<textarea class="form-control" id="DenunciaMP_Motivo" rows="3"></textarea>
						<span class="chip" onclick="defaultMotivo(this)">Por miedo a denunciar</span>
						<span class="chip" onclick="defaultMotivo(this)">No sabía que existía</span>
						<span class="chip" onclick="defaultMotivo(this)">Le dijeron que esperara 72 horas</span>
						<span class="chip" onclick="defaultMotivo(this)">Otro</span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary" id="guardarDenunciaMP" onclick="guardarDenunciaMP()">Guardar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modalReporteCB" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5	class="modal-title">Reporte en Comisión de Búsqueda</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<p>¿Cuenta con reporte en la Comisión de Búsqueda?</p>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="ReporteCB_Si" value="option1">
							<label class="form-check-label" for="ReporteCB_Si">Sí</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="ReporteCB_No" value="option1">
							<label class="form-check-label" for="ReporteCB_No">No</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="ReporteCB_SinDato" value="option1">
							<label class="form-check-label" for="ReporteCB_SinDato">Sin dato</label>
						</div>
					</div>
					<div class="col-12 ReporteCB_Si">
						<p>¿En qué nivel de gobierno?</p>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="ReporteCB_NivelFederal" value="option1">
							<label class="form-check-label" for="ReporteCB_NivelFederal">Nacional</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="ReporteCB_NivelLocal" value="option1">
							<label class="form-check-label" for="ReporteCB_NivelLocal">Local</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="ReporteCB_NivelSinDato" value="option1">
							<label class="form-check-label" for="ReporteCB_NivelSinDato">Sin dato</label>
						</div>
					</div>
					<div class="col-12 ReporteCB_No">
						<label for="ReporteCB_Motivo" class="form-label">¿Cuál es el motivo en caso de que no tenga denuncia?</label>
						<textarea class="form-control" id="ReporteCB_Motivo" rows="3"></textarea>
						<span class="chip" onclick="defaultMotivo(this)">Por miedo a denunciar</span>
						<span class="chip" onclick="defaultMotivo(this)">No sabía que existía</span>
						<span class="chip" onclick="defaultMotivo(this)">Le dijeron que esperara 72 horas</span>
						<span class="chip" onclick="defaultMotivo(this)">Otro</span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary" id="guardarDenunciaCB" onclick="guardarReporteCB()">Guardar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modalAtencion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5	class="modal-title">Registro de atención</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<p>Fecha de la atención</p>
					<div class="form-group col-3 mb-3">
						<label for="atencionAnio">Año</label>
						<input type="number" class="form-control" id="atencionAnio"  required/>
					</div>
					<div class="form-group col-6 mb-3">
						<label for="atencionMes">Mes</label>
						<select class="form-select" id="atencionMes">
							<option selected  value="">Sin especificar</option>
							<option value="01">Enero</option>
							<option value="02">Febrero</option>
							<option value="03">Marzo</option>
							<option value="04">Abril</option>
							<option value="05">Mayo</option>
							<option value="06">Junio</option>
							<option value="07">Julio</option>
							<option value="08">Agosto</option>
							<option value="09">Septiembre</option>
							<option value="10">Octubre</option>
							<option value="11">Noviembre</option>
							<option value="12">Diciembre</option>
						</select>
					</div>
					<div class="form-group col-3 mb-3">
						<label for="atencionDia">Día</label>
						<input type="number" class="form-control" id="atencionDia" placeholder="Sin especificar" required/>
					</div>
					<div class="col-12 mb-3">
						<label for="atencionRealiza">Persona que le atendió</label>
						<input type="text" class="form-control" id="atencionRealiza" required onfocus="showListAtendio()" onchange="hideListAtendio()"/>
						<ul id="listAtendio">
							<?php 
							foreach($DaoAtencion->listAtendio() as $atendio){ 
								if(strlen($atendio)>0){
								?>
							<li onclick="setAtendio(this)"><?php echo($atendio); ?></li><?php 
								}
							} ?>
						</ul>
					</div>
					<div class="col-12 mb-3">
						<label for="descripcionAtencion" class="form-label">Descripción de la asesoría</label>
						<textarea class="form-control" id="descripcionAtencion" rows="3"></textarea>
					</div>
					<div class="col-12 mb-3 AccionRealizada">
						<p>Acción realizada</p>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="AtencionAsesoro" value="Asesoro">
							<label class="form-check-label" for="AtencionAsesoro">Se asesoró</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="AtencionAcompanio" value="Acompaño">
							<label class="form-check-label" for="AtencionAcompanio">Se acompañó</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="AtencionIntervencion" value="Intervencion">
							<label class="form-check-label" for="AtencionIntervencion">Se realizó una intervención</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="AtencionCanalizoAlColectivo" value="CanalizoAlColectivo">
							<label class="form-check-label" for="AtencionCanalizoAlColectivo">Se canalizó dentro del colectivo</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="AtencionCanalizoAbogadaColectivo" value="CanalizoAbogadaColectivo">
							<label class="form-check-label" for="AtencionCanalizoAbogadaColectivo">Se canalizó a la abogada del colectivo</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="AtencionCanalizoONG" value="CanalizoONG">
							<label class="form-check-label" for="AtencionCanalizoONG">Se canalizó a una ONG</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="AtencionCanalizoOtroColectivo" value="CanalizoOtroColectivo">
							<label class="form-check-label" for="AtencionCanalizoOtroColectivo">Se canalizó a un colectivo</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="AtencionCanalizoInstitucion" value="CanalizoInstitucion">
							<label class="form-check-label" for="AtencionCanalizoInstitucion">Se canalizó a una institución</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="AtencionFichaRedes" value="FichaRedes">
							<label class="form-check-label" for="AtencionFichaRedes">Se publicó ficha en redes sociales</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="AtencionOtra" value="Otra">
							<label class="form-check-label" for="AtencionOtra">Otra</label>
						</div>
					</div>
					<div class="col-12  mb-3 Canalizacion">
						<p>Institución a la que se canalizó</p>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="InstitucionFiscaliaDesaparecidosJal" value="FiscaliaDesaparecidosJal">
							<label class="form-check-label" for="InstitucionFiscaliaDesaparecidosJal">Fiscalía Especial en Personas Desaparecidas del Estado de Jalisco</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="InstitucionFiscaliaDDHHJal" value="FiscaliaDDHHJal">
							<label class="form-check-label" for="InstitucionFiscaliaDDHHJal">Fiscal de Derechos Humanos del Estado de Jalisco</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="InstitucionComisionBusquedaJal" value="ComisionBusquedaJal">
							<label class="form-check-label" for="InstitucionComisionBusquedaJal">Comisión de Búsqueda del Estado de Jalisco</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="InstitucionCienciasForenses" value="CienciasForenses">
							<label class="form-check-label" for="InstitucionCienciasForenses">Instituto de Ciencias Forenses</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="InstitucionFiscaliaRepublica" value="FiscaliaRepublica">
							<label class="form-check-label" for="InstitucionFiscaliaRepublica">Fiscalía General de la República</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="InstitucionComisionNacionalBusqueda" value="ComisionNacionalBusqueda">
							<label class="form-check-label" for="InstitucionComisionNacionalBusqueda">Comisión Nacional de Búsqueda</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="InstitucionComisionVictimasJal" value="ComisionVictimasJal">
							<label class="form-check-label" for="InstitucionComisionVictimasJal">Comisión Ejecutiva Estatal de Atención a Víctimas de Jalisco</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="InstitucionComisionVictimas" value="ComisionVictimas">
							<label class="form-check-label" for="InstitucionComisionVictimas">Comisión Ejecutiva Estatal de Atención a Víctimas</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="InstitucionOtra" value="OtraAutoridad">
							<label class="form-check-label" for="InstitucionOtra">Otra autoridad</label>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary" id="saveAtencion" onclick="saveAtencion()">Guardar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modalLocalizadaConVida" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5	class="modal-title">Localización con vida</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="form-group col-12 mb-3">
						<h6>1. Personas localizadas</h6>
						<div id="modalLocalizadaConVida_personasDesaparecidas"></div>
					</div>
					<div class="col-12">
						<h6>2. Fecha de la localización</h6>
						<div class="row">
							<div class="form-group col-3 mb-3">
								<label for="fechaLocalizacionVida_anio">Año</label>
								<input type="number" class="form-control" id="fechaLocalizacionVida_anio"  required/>
							</div>
							<div class="form-group col-6 mb-3">
								<label for="fechaLocalizacionVida_mes">Mes</label>
								<select class="form-select" id="fechaLocalizacionVida_mes">
									<option selected  value="">Sin especificar</option>
									<option value="01">Enero</option>
									<option value="02">Febrero</option>
									<option value="03">Marzo</option>
									<option value="04">Abril</option>
									<option value="05">Mayo</option>
									<option value="06">Junio</option>
									<option value="07">Julio</option>
									<option value="08">Agosto</option>
									<option value="09">Septiembre</option>
									<option value="10">Octubre</option>
									<option value="11">Noviembre</option>
									<option value="12">Diciembre</option>
								</select>
							</div>
							<div class="form-group col-3 mb-3">
								<label for="fechaLocalizacionVida_dia">Día</label>
								<input type="number" class="form-control" id="fechaLocalizacionVida_dia" placeholder="Sin especificar" required/>
							</div>
						</div>
					</div>
					<div class="col-12">
						<label for="localizaconConVida_Comentario" class="form-label">Información adicional</label>
						<textarea class="form-control" id="localizaconConVida_Comentario" rows="3"></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary" id="saveLocalizacionConVida" onclick="saveLocalizacionConVida()">Guardar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modalLocalizadaSinVida" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5	class="modal-title">Localización sin vida</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="form-group col-12 mb-3">
						<h6>1. Personas localizadas</h6>
						<div id="modalLocalizadaSinVida_personasDesaparecidas"></div>
					</div>
					<div class="col-12">
						<h6>2. Fecha de la localización</h6>
						<div class="row">
							<div class="form-group col-3 mb-3">
								<label for="fechaLocalizacionSinVida_anio">Año</label>
								<input type="number" class="form-control" id="fechaLocalizacionSinVida_anio"  required/>
							</div>
							<div class="form-group col-6 mb-3">
								<label for="fechaLocalizacionSinVida_mes">Mes</label>
								<select class="form-select" id="fechaLocalizacionSinVida_mes">
									<option selected  value="">Sin especificar</option>
									<option value="01">Enero</option>
									<option value="02">Febrero</option>
									<option value="03">Marzo</option>
									<option value="04">Abril</option>
									<option value="05">Mayo</option>
									<option value="06">Junio</option>
									<option value="07">Julio</option>
									<option value="08">Agosto</option>
									<option value="09">Septiembre</option>
									<option value="10">Octubre</option>
									<option value="11">Noviembre</option>
									<option value="12">Diciembre</option>
								</select>
							</div>
							<div class="form-group col-3 mb-3">
								<label for="fechaLocalizacionSinVida_dia">Día</label>
								<input type="number" class="form-control" id="fechaLocalizacionSinVida_dia" placeholder="Sin especificar" required/>
							</div>
						</div>
					</div>
					<div class="col-12">
						<label for="localizaconSinVida_Comentario" class="form-label">Información adicional</label>
						<textarea class="form-control" id="localizaconSinVida_Comentario" rows="3"></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary" id="saveLocalizacionSinVida" onclick="saveLocalizacionSinVida()">Guardar</button>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="IdCaso" value="<?php echo($Caso->getId()); ?>" />
<input type="hidden" id="LastUpdateCaso" value="" />
<script>
	function initMap() {
	  mapActo = new google.maps.Map(document.getElementById("mapaActo"), {
		center: { lat: 20.6737776, lng: -103.4056259 },
		zoom: 8,
	  });
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo($DaoCasos->getParam("Google_APIKeyJS")); ?>&callback=initMap&v=weekly" async></script>
<?php
interface_footer();
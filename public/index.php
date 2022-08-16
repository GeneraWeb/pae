<?php
require_once("assets/interface.php");
$title="Inicio";
$description="Dashboard de inicio";
interface_header($title,$description); ?>
<div class="container">
	<div class="row">
		<div class="col-12 mb-3">
			<p>Bienvenidx <?php echo($Usuario->getSeudonimo()); ?></p>
			<p><a href="atencion" class="btn btn-primary btn-lg">Nueva ficha de atención</a> <a href="caso" class="btn btn-primary btn-lg colectivo">Nuevo caso del colectivo</a></p>
		</div>
	</div>
	<div class="row">
		<div class="col-12 mb-3">
			<p>Reportes:</p>
			<ul>
				<li><a href="listado">Listado general</a></li>
				<li><a href="reporte_atencion">Reporte atención</a></li>
			</ul>
		</div>
	</div>
</div>
<?php
interface_footer();
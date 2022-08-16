<?php
require_once("assets/interface.php");
require_once("../dep/clases/DaoCasos.php");
require_once("../dep/clases/DaoPersonas.php");
$DaoCasos=new DaoCasos();
$DaoPersonas=new DaoPersonas();
$title="Listado general";
$description="Listado general de casos y fichas de atención";
interface_header($title,$description); ?>
<div class="container">
	<div class="row">
		<div class="col-12 mb-3">
			<table class="table">
				<thead>
					<tr>
						<th>Id</th>
						<th>Nombre</th>
						<th>Personas desaparecidas</th>
						<th>Colectivo?</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($DaoCasos->showAll() as $Caso){ ?>
					<tr data-id="<?php echo($Caso->getId()); ?>">
						<td><?php echo($Caso->getId()); ?></td>
						<td><?php echo($Caso->getNombre()); ?></td>
						<td><?php $personas=array();
						foreach($DaoPersonas->getByCaso($Caso->getId()) as $Persona){
							if($Persona->getRelacionCaso()=="Desaparecida"){
								array_push($personas, $Persona->getNombre());
							}
						}
						echo(implode(", ", $personas));
						 ?></td>
						<td><?php 
						if($Caso->getParteDelColectivo()==1){
							echo("Sí");
							$url="caso";
						}else{
							echo("No");
							$url="atencion";
						}
						 ?></td>
						 <td>
							 <a href="<?php echo($url); ?>?id=<?php echo($Caso->getId()); ?>"><i class="fas fa-chevron-circle-right"></i></a>
						 </td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php
interface_footer();
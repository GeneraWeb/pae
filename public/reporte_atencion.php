<?php
require_once("assets/interface.php");
require_once("../dep/clases/DaoCasos.php");
$DaoCasos=new DaoCasos();
$title="Reporte de atención";
$description="Reporte sobre fichas de atención";
$fechaIni=strtotime(date("Y-m-")."01");
$fechaFin=strtotime("Last day of ".date("Y-m"));
if(isset($_GET["Ini"])){
	$fechaIni=strtotime($_GET["Ini"]);
}
if(isset($_GET["Fin"])){
	$fechaFin=strtotime($_GET["Fin"]);
}
interface_header($title,$description); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.0/dist/chart.min.js"></script>
<script>
	var colores=new Array();
	colores[0]="rgba(0, 0, 0, 1)";
	colores[1]="rgba(242, 49, 73, 1)";
	colores[2]="rgba(255, 189, 83, 1)";
	colores[3]="rgba(255,182,192,1)";
	colores[4]="rgba(248, 139, 78, 1)";
	colores[5]="rgba(242, 229, 105, 1)";
	colores[6]="rgba(214, 115, 168, 1)";
	colores[7]="rgba(49, 126, 242, 1)";
	colores[8]="rgba(204, 190, 63, 1)";
	colores[9]="rgba(74, 227, 154, 1)";
	colores[10]="rgba(104, 120, 108, 1)";
</script>
<div class="container">
	<div class="row">
		<div class="col-12 mb-3">
			<p>Selecciona el rango de fechas a reportar:</p>
			<div class="row">
				<div class="col-1 text-center mb-3"><br/>Del</div>
				<div class="col-5 mb-3">
					<div class="row">
						<div class="form-group col-3 mb-3">
							<label for="fechaIni_anio">Año</label>
							<input type="number" class="form-control" id="fechaIni_anio" value="<?php echo(date("Y",$fechaIni)); ?>"  required/>
						</div>
						<div class="form-group col-6 mb-3">
							<label for="fechaIni_mes">Mes</label>
							<select class="form-select" id="fechaIni_mes">
								<option value="01" <?php if(date("m",$fechaIni)=="01"){ echo("selected"); }?>>Enero</option>
								<option value="02" <?php if(date("m",$fechaIni)=="02"){ echo("selected"); }?>>Febrero</option>
								<option value="03" <?php if(date("m",$fechaIni)=="03"){ echo("selected"); }?>>Marzo</option>
								<option value="04" <?php if(date("m",$fechaIni)=="04"){ echo("selected"); }?>>Abril</option>
								<option value="05" <?php if(date("m",$fechaIni)=="05"){ echo("selected"); }?>>Mayo</option>
								<option value="06" <?php if(date("m",$fechaIni)=="06"){ echo("selected"); }?>>Junio</option>
								<option value="07" <?php if(date("m",$fechaIni)=="07"){ echo("selected"); }?>>Julio</option>
								<option value="08" <?php if(date("m",$fechaIni)=="08"){ echo("selected"); }?>>Agosto</option>
								<option value="09" <?php if(date("m",$fechaIni)=="09"){ echo("selected"); }?>>Septiembre</option>
								<option value="10" <?php if(date("m",$fechaIni)=="10"){ echo("selected"); }?>>Octubre</option>
								<option value="11" <?php if(date("m",$fechaIni)=="11"){ echo("selected"); }?>>Noviembre</option>
								<option value="12" <?php if(date("m",$fechaIni)=="12"){ echo("selected"); }?>>Diciembre</option>
							</select>
						</div>
						<div class="form-group col-3 mb-3">
							<label for="fechaIni_dia">Día</label>
							<input type="number" class="form-control" id="fechaIni_dia" placeholder="Sin especificar" value="<?php echo(date("d",$fechaIni)); ?>" required/>
						</div>
					</div>
				</div>
				<div class="col-1 text-center mb-3"><br/>al</div>
				<div class="col-5 mb-3">
					<div class="row">
						<div class="form-group col-3 mb-3">
							<label for="fechaFin_anio">Año</label>
							<input type="number" class="form-control" id="fechaFin_anio"  value="<?php echo(date("Y",$fechaFin)); ?>" required/>
						</div>
						<div class="form-group col-6 mb-3">
							<label for="fechaFin_mes">Mes</label>
							<select class="form-select" id="fechaFin_mes">
								<option value="01" <?php if(date("m",$fechaFin)=="01"){ echo("selected"); }?>>Enero</option>
								<option value="02" <?php if(date("m",$fechaFin)=="02"){ echo("selected"); }?>>Febrero</option>
								<option value="03" <?php if(date("m",$fechaFin)=="03"){ echo("selected"); }?>>Marzo</option>
								<option value="04" <?php if(date("m",$fechaFin)=="04"){ echo("selected"); }?>>Abril</option>
								<option value="05" <?php if(date("m",$fechaFin)=="05"){ echo("selected"); }?>>Mayo</option>
								<option value="06" <?php if(date("m",$fechaFin)=="06"){ echo("selected"); }?>>Junio</option>
								<option value="07" <?php if(date("m",$fechaFin)=="07"){ echo("selected"); }?>>Julio</option>
								<option value="08" <?php if(date("m",$fechaFin)=="08"){ echo("selected"); }?>>Agosto</option>
								<option value="09" <?php if(date("m",$fechaFin)=="09"){ echo("selected"); }?>>Septiembre</option>
								<option value="10" <?php if(date("m",$fechaFin)=="10"){ echo("selected"); }?>>Octubre</option>
								<option value="11" <?php if(date("m",$fechaFin)=="11"){ echo("selected"); }?>>Noviembre</option>
								<option value="12" <?php if(date("m",$fechaFin)=="12"){ echo("selected"); }?>>Diciembre</option>
							</select>
						</div>
						<div class="form-group col-3 mb-3">
							<label for="fechaFin_dia">Día</label>
							<input type="number" class="form-control" id="fechaFin_dia" placeholder="Sin especificar" value="<?php echo(date("d",$fechaFin)); ?>" required/>
						</div>
					</div>
				</div>
				<div class="col12 text-end">
					<button type="button" class="btn btn-primary" id="cambiarFechasReporte" onclick="cambiarFechasReporte()">Ejecutar</button>
				</div>
			</div>
		</div>
		<?php if(isset($_GET["Ini"])){ 
			$arrayMeses=array();
			$fechaRef=strtotime(substr($_GET["Ini"],0,7)."-01");
			$fechaRefFin=date("Ym",$fechaFin);
			$i=0;
			do{
				$mes=strtotime(substr($_GET["Ini"],0,7)."-01 + $i months");
				array_push($arrayMeses, date("Y-m",$mes));
				$i+=1;
			}while(date("Ym",$mes)<$fechaRefFin);
		?>
		<div class="col-12 mb-3">
			<h5>Atenciones</h5>
			<p>Por fecha de la atención</p>
			<?php 
			$atenciones=array();
			$labels=array();
			foreach($arrayMeses as $mes){
				$atenciones[$mes]=0;
				array_push($labels,$mes);
			}
			$consulta=$DaoCasos->_query("SELECT DATE_FORMAT(`FechaAtencion`,'%Y-%m') AS Mes, COUNT(Id) AS Cantidad FROM Atencion WHERE FechaAtencion>='".$_GET["Ini"]."' AND FechaAtencion<='".$_GET["Fin"]."' GROUP BY Mes");
			foreach($consulta as $row){
				$atenciones[$row["Mes"]]=$row["Cantidad"];
			}
			$values=array();
			foreach($arrayMeses as $mes){
				array_push($values,$atenciones[$mes]);
			}
			?>
			<canvas id="chartAtenciones" class="mb3"></canvas>
			<script>
				const canvasAtenciones = document.getElementById('chartAtenciones').getContext('2d');
				const chartAtenciones = new Chart(canvasAtenciones, {
					type: 'bar',
					data: {
						labels: ['<?php echo(implode("', '", $labels)); ?>'],
						datasets: [{
							label: 'Atenciones',
							data: [<?php echo(implode(", ",$values)); ?>],
							backgroundColor: [
								colores[1]
							],
							borderColor: [
								colores[1]
							],
							borderWidth: 1
						}]
					},
					options: {
						scales: {
							y: {
								beginAtZero: true,
								ticks: {
									stepSize: 1
								}
							}
						}
					}
				});
			</script>
		</div>
		<div class="col-12 mb-3">
			<table class="table">
				<thead>
					<tr>
						<th>Mes</th>
						<?php foreach($atenciones as $mes=>$cantidad){ ?>
						<th><?php echo($mes); ?></th>
						<?php } ?>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Atenciones</td>
						<?php 
						$count=0;
						foreach($atenciones as $mes=>$cantidad){ ?>
						<td><?php 
						echo($cantidad); 
						$count+=$cantidad;
						?></td>
						<?php } ?>
						<td class="total"><?php echo($count); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<?php } ?>
		<?php 
		$consulta=$DaoCasos->_query("SELECT Frecuencia, DATE_FORMAT(`FechaAtencion`,'%Y-%m') AS Mes, COUNT(Caso) AS Atenciones FROM (
			SELECT Id,Caso,FechaAtencion, COUNT(IdCumm) AS Frecuencia FROM (SELECT * FROM Atencion LEFT JOIN (SELECT Id AS IdCumm, Caso AS CasoCumm, FechaAtencion AS FechaAtencionCumm FROM Atencion ORDER BY Caso,FechaAtencion) AS Acumulativo ON Acumulativo.FechaAtencionCumm<=Atencion.FechaAtencion AND Atencion.Caso=Acumulativo.CasoCumm WHERE Atencion.FechaAtencion>='".$_GET["Ini"]."' AND Atencion.FechaAtencion<='".$_GET["Fin"]."' ORDER BY Atencion.Caso,Atencion.Id,Atencion.FechaAtencion) AS Datos GROUP BY Id) AS DatosAgrupados GROUP BY Mes, Frecuencia");
		$atenciones=array();
		$frecuenciaMax=0;
		foreach($consulta as $row){
			if(!isset($atenciones[$row["Mes"]])){
				$atenciones[$row["Mes"]]=array();
			}
			$atenciones[$row["Mes"]][$row["Frecuencia"]]=$row["Atenciones"];
			if($row["Frecuencia"]>$frecuenciaMax){
				$frecuenciaMax=$row["Frecuencia"];
			}
		}
		foreach($arrayMeses as $mes){
			if(!isset($atenciones[$mes])){
				$atenciones[$mes]=array();
			}
			$i=1;
			do{
				if(!isset($atenciones[$mes][$i])){
					$atenciones[$mes][$i]=0;
				}
				$i+=1;
			}while($i<=$frecuenciaMax);
		}
		?>
		<div class="col-12 mb-3">
			<h5>Frecuencia</h5>
			<p>Por fecha de la atención</p>
			<canvas id="chartFrecuencia" class="mb3"></canvas>
			<script>
				const canvasFrecuencia = document.getElementById('chartFrecuencia').getContext('2d');
				const chartFrecuencia = new Chart(canvasFrecuencia, {
					type: 'bar',
					data: {
						labels: ['<?php echo(implode("', '", $labels)); ?>'],
						datasets: [<?php 
							$i=1;
							do{ ?>{
							label: '<?php echo($i); ?>ª vez',
							data: [<?php 
								$values=array();
								foreach($arrayMeses as $mes){
									array_push($values,$atenciones[$mes][$i]);
								}
								echo(implode(", ",$values)); 
							?>],
							backgroundColor: [
								colores[<?php echo($i); ?>]
							],
							borderColor: [
								colores[<?php echo($i); ?>]
							],
							borderWidth: 1
						},<?php 
							$i+=1;
						}while($i<=$frecuenciaMax); ?>]
					},
					options: {
						scales: {
							y: {
								stacked: true,
								beginAtZero: true,
								ticks: {
									stepSize: 1
								}
							},
							x:{
								stacked: true,
							}
						}
					}
				});
			</script>
		</div>
		<div class="col-12 mb-3">
			<table class="table">
				<thead>
					<tr>
						<th>Frecuencia</th>
						<?php foreach($arrayMeses as $mes){ ?>
						<th><?php echo($mes); ?></th>
						<?php } ?>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=1;
					do{ ?>
					<tr>
						<td><?php echo($i); ?></td>
						<?php 
						$count=0;
						foreach($arrayMeses as $mes){ ?>
						<td><?php 
						echo($atenciones[$mes][$i]); 
						$count+=$atenciones[$mes][$i];
						?></td>
						<?php } ?>
						<td class="total"><?php echo($count); ?></td>
					</tr>
					<?php 
						$i+=1;
					}while($i<=$frecuenciaMax); ?>
				</tbody>
			</table>
		</div>
		<?php 
		$consulta=$DaoCasos->_query("SELECT COUNT(Personas.Id) AS Contador, DATE_FORMAT(FechaActoIni,'%Y-%m') AS Mes ,Sexo FROM Personas JOIN PersonasActos ON PersonasActos.Persona=Personas.Id JOIN Actos ON Actos.Id=PersonasActos.Acto WHERE RelacionCaso='Desaparecida' AND TipoActo='Desaparición' AND FechaActoIni>='".$_GET["Ini"]."' AND FechaActoIni<='".$_GET["Fin"]."' GROUP BY Sexo, Mes");
		$personasSexo=array();
		$contadorMax=0;
		foreach($consulta as $row){
			if(!isset($personasSexo[$row["Mes"]])){
				$personasSexo[$row["Mes"]]=array();
				$personasSexo[$row["Mes"]]["Mujer"]=0;
				$personasSexo[$row["Mes"]]["Hombre"]=0;
				$personasSexo[$row["Mes"]]["Sin dato"]=0;
			}
			if($row["Sexo"]=="Mujer" || $row["Sexo"]=="Hombre"){
				$personasSexo[$row["Mes"]][$row["Sexo"]]=$row["Contador"];
			}else{
				$personasSexo[$row["Mes"]]["Sin dato"]+=$row["Contador"];
			}
			if($row["Contador"]>$contadorMax){
				$contadorMax=$row["Frecuencia"];
			}
		}
		foreach($arrayMeses as $mes){
			if(!isset($personasSexo[$mes])){
				$personasSexo[$mes]=array();
				$personasSexo[$mes]["Mujer"]=0;
				$personasSexo[$mes]["Hombre"]=0;
				$personasSexo[$mes]["Sin dato"]=0;
			}
		}
		?>	
		<div class="col-12 mb-3">
			<h5>Personas desaparecidas por sexo</h5>
			<p>Por fecha de desaparición</p>
			<canvas id="chartPersonasSexo" class="mb3"></canvas>
			<script>
				const canvasPersonasSexo = document.getElementById('chartPersonasSexo').getContext('2d');
				const chartPersonasSexo = new Chart(canvasPersonasSexo, {
					type: 'bar',
					data: {
						labels: ['<?php echo(implode("', '", $labels)); ?>'],
						datasets: [
							{
							label: 'Hombre',
							data: [<?php 
								$values=array();
								foreach($arrayMeses as $mes){
									array_push($values,$personasSexo[$mes]["Hombre"]);
								}
								echo(implode(", ",$values)); 
							?>],
							backgroundColor: [
								colores[1]
							],
							borderColor: [
								colores[1]
							],
							borderWidth: 1
						},
						{
							label: 'Mujer',
							data: [<?php 
								$values=array();
								foreach($arrayMeses as $mes){
									array_push($values,$personasSexo[$mes]["Mujer"]);
								}
								echo(implode(", ",$values)); 
							?>],
							backgroundColor: [
								colores[2]
							],
							borderColor: [
								colores[2]
							],
							borderWidth: 1
						},
						{
							label: 'Sin dato',
							data: [<?php 
								$values=array();
								foreach($arrayMeses as $mes){
									array_push($values,$personasSexo[$mes]["Sin dato"]);
								}
								echo(implode(", ",$values)); 
							?>],
							backgroundColor: [
								colores[3]
							],
							borderColor: [
								colores[3]
							],
							borderWidth: 1
						},
						]
					},
					options: {
						scales: {
							y: {
								stacked: false,
								beginAtZero: true,
								ticks: {
									stepSize: 1
								}
							},
							x:{
								stacked: false,
							}
						}
					}
				});
			</script>
		</div>
		<div class="col-12 mb-3">
			<table class="table">
				<thead>
					<tr>
						<th>Sexo</th>
						<?php foreach($arrayMeses as $mes){ ?>
						<th><?php echo($mes); ?></th>
						<?php } ?>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Hombre</td>
						<?php 
						$count=0;
						foreach($arrayMeses as $mes){ ?>
						<td><?php 
						echo($personasSexo[$mes]["Hombre"]); 
						$count+=$personasSexo[$mes]["Hombre"];
						?></td>
						<?php } ?>
						<td class="total"><?php echo($count); ?></td>
					</tr>
					<tr>
						<td>Mujer</td>
						<?php 
						$count=0;
						foreach($arrayMeses as $mes){ ?>
						<td><?php 
						echo($personasSexo[$mes]["Mujer"]); 
						$count+=$personasSexo[$mes]["Mujer"];
						?></td>
						<?php } ?>
						<td class="total"><?php echo($count); ?></td>
					</tr>
					<tr>
						<td>Sin dato</td>
						<?php 
						$count=0;
						foreach($arrayMeses as $mes){ ?>
						<td><?php 
						echo($personasSexo[$mes]["Sin dato"]); 
						$count+=$personasSexo[$mes]["Sin dato"];
						?></td>
						<?php } ?>
						<td class="total"><?php echo($count); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<?php 
		$consulta=$DaoCasos->_query("SELECT COUNT(Personas.Id) AS Contador, DATE_FORMAT(FechaActoIni,'%Y-%m') AS Mes ,Edad, Sexo FROM Personas JOIN PersonasActos ON PersonasActos.Persona=Personas.Id JOIN Actos ON Actos.Id=PersonasActos.Acto WHERE RelacionCaso='Desaparecida' AND TipoActo='Desaparición' AND FechaActoIni>='".$_GET["Ini"]."' AND FechaActoIni<='".$_GET["Fin"]."' GROUP BY Edad, Mes, Sexo");
		$personasEdad=array();
		$personasEdad["0 - 11"]=array();
		$personasEdad["0 - 11"]["Hombre"]=0;
		$personasEdad["0 - 11"]["Mujer"]=0;
		$personasEdad["0 - 11"]["Sin dato"]=0;
		$personasEdad["12 - 17"]=array();
		$personasEdad["12 - 17"]["Hombre"]=0;
		$personasEdad["12 - 17"]["Mujer"]=0;
		$personasEdad["12 - 17"]["Sin dato"]=0;
		$personasEdad["18 - 25"]=array();
		$personasEdad["18 - 25"]["Hombre"]=0;
		$personasEdad["18 - 25"]["Mujer"]=0;
		$personasEdad["18 - 25"]["Sin dato"]=0;
		$personasEdad["26 - 29"]=array();
		$personasEdad["26 - 29"]["Hombre"]=0;
		$personasEdad["26 - 29"]["Mujer"]=0;
		$personasEdad["26 - 29"]["Sin dato"]=0;
		$personasEdad["30 - 39"]=array();
		$personasEdad["30 - 39"]["Hombre"]=0;
		$personasEdad["30 - 39"]["Mujer"]=0;
		$personasEdad["30 - 39"]["Sin dato"]=0;
		$personasEdad["40 - 49"]=array();
		$personasEdad["40 - 49"]["Hombre"]=0;
		$personasEdad["40 - 49"]["Mujer"]=0;
		$personasEdad["40 - 49"]["Sin dato"]=0;
		$personasEdad["50 - 59"]=array();
		$personasEdad["50 - 59"]["Hombre"]=0;
		$personasEdad["50 - 59"]["Mujer"]=0;
		$personasEdad["50 - 59"]["Sin dato"]=0;
		$personasEdad["60 - 69"]=array();
		$personasEdad["60 - 69"]["Hombre"]=0;
		$personasEdad["60 - 69"]["Mujer"]=0;
		$personasEdad["60 - 69"]["Sin dato"]=0;
		$personasEdad["70 y mas"]=array();
		$personasEdad["70 y mas"]["Hombre"]=0;
		$personasEdad["70 y mas"]["Mujer"]=0;
		$personasEdad["70 y mas"]["Sin dato"]=0;
		$personasEdad["Sin dato"]=array();
		$personasEdad["Sin dato"]["Hombre"]=0;
		$personasEdad["Sin dato"]["Mujer"]=0;
		$personasEdad["Sin dato"]["Sin dato"]=0;
		$contadorMax=0;
		foreach($consulta as $row){
			if(strlen($row["Edad"])==0){
				if($row["Sexo"]=="Hombre" || $row["Sexo"]=="Mujer"){
					$personasEdad["Sin dato"][$row["Sexo"]]+=$row["Contador"];
				}else{
					$personasEdad["Sin dato"]["Sin dato"]+=$row["Contador"];
				}
			}else if($row["Edad"]<12){
				if($row["Sexo"]=="Hombre" || $row["Sexo"]=="Mujer"){
					$personasEdad["0 - 11"][$row["Sexo"]]+=$row["Contador"];
				}else{
					$personasEdad["0 - 11"]["Sin dato"]+=$row["Contador"];
				}
			}else if($row["Edad"]<18){
				if($row["Sexo"]=="Hombre" || $row["Sexo"]=="Mujer"){
					$personasEdad["12 - 17"][$row["Sexo"]]+=$row["Contador"];
				}else{
					$personasEdad["12 - 17"]["Sin dato"]+=$row["Contador"];
				}
			}else if($row["Edad"]<26){
				if($row["Sexo"]=="Hombre" || $row["Sexo"]=="Mujer"){
					$personasEdad["18 - 25"][$row["Sexo"]]+=$row["Contador"];
				}else{
					$personasEdad["18 - 25"]["Sin dato"]+=$row["Contador"];
				}
			}else if($row["Edad"]<30){
				if($row["Sexo"]=="Hombre" || $row["Sexo"]=="Mujer"){
					$personasEdad["26 - 29"][$row["Sexo"]]+=$row["Contador"];
				}else{
					$personasEdad["26 - 29"]["Sin dato"]+=$row["Contador"];
				}
			}else if($row["Edad"]<40){
				if($row["Sexo"]=="Hombre" || $row["Sexo"]=="Mujer"){
					$personasEdad["30 - 39"][$row["Sexo"]]+=$row["Contador"];
				}else{
					$personasEdad["30 - 39"]["Sin dato"]+=$row["Contador"];
				}
			}else if($row["Edad"]<50){
				if($row["Sexo"]=="Hombre" || $row["Sexo"]=="Mujer"){
					$personasEdad["40 - 49"][$row["Sexo"]]+=$row["Contador"];
				}else{
					$personasEdad["40 - 49"]["Sin dato"]+=$row["Contador"];
				}
			}else if($row["Edad"]<60){
				if($row["Sexo"]=="Hombre" || $row["Sexo"]=="Mujer"){
					$personasEdad["50 - 59"][$row["Sexo"]]+=$row["Contador"];
				}else{
					$personasEdad["50 - 59"]["Sin dato"]+=$row["Contador"];
				}
			}else if($row["Edad"]<70){
				if($row["Sexo"]=="Hombre" || $row["Sexo"]=="Mujer"){
					$personasEdad["60 - 69"][$row["Sexo"]]+=$row["Contador"];
				}else{
					$personasEdad["60 - 69"]["Sin dato"]+=$row["Contador"];
				}
			}else{
				if($row["Sexo"]=="Hombre" || $row["Sexo"]=="Mujer"){
					$personasEdad["70 y mas"][$row["Sexo"]]+=$row["Contador"];
				}else{
					$personasEdad["70 y mas"]["Sin dato"]+=$row["Contador"];
				}
			}
			
		}
		?>	
		<div class="col-12 mb-3">
			<h5>Personas desaparecidas por edad</h5>
			<p>De acuerdo a la fecha de desaparición</p>
			<canvas id="chartPersonasEdad" class="mb3"></canvas>
			<script>
				const canvasPersonasEdad = document.getElementById('chartPersonasEdad').getContext('2d');
				const chartPersonasEdad = new Chart(canvasPersonasEdad, {
					type: 'bar',
					data: {
						labels: ['0 -11','12 - 17','18 - 25','26 - 29','30 - 39','40 - 49','50 - 59','60 - 69','70 y más','Sin dato'],
						datasets: [
							{
							label: 'Hombre',
							data: [<?php 
								$values=array();
								foreach($personasEdad as $Edad=>$valor){
									array_push($values,$valor["Hombre"]);
								}
								echo(implode(", ",$values)); 
							?>],
							backgroundColor: [
								colores[1]
							],
							borderColor: [
								colores[1]
							],
							borderWidth: 1
						},
						{
							label: 'Mujer',
							data: [<?php 
								$values=array();
								foreach($personasEdad as $Edad=>$valor){
									array_push($values,$valor["Mujer"]);
								}
								echo(implode(", ",$values)); 
							?>],
							backgroundColor: [
								colores[2]
							],
							borderColor: [
								colores[2]
							],
							borderWidth: 1
						},
						{
							label: 'Sin dato',
							data: [<?php 
								$values=array();
								foreach($personasEdad as $Edad=>$valor){
									array_push($values,$valor["Sin dato"]);
								}
								echo(implode(", ",$values)); 
							?>],
							backgroundColor: [
								colores[3]
							],
							borderColor: [
								colores[3]
							],
							borderWidth: 1
						},
						]
					},
					options: {
						scales: {
							y: {
								stacked: false,
								beginAtZero: true,
								ticks: {
									stepSize: 1
								}
							},
							x:{
								stacked: false,
							}
						}
					}
				});
			</script>
		</div>
		<div class="col-12 mb-3">
			<table class="table">
				<thead>
					<tr>
						<th>Sexo</th>
						<?php foreach($personasEdad as $Edad=>$valor){ ?>
						<th><?php echo($Edad); ?></th>
						<?php } ?>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Hombre</td>
						<?php 
						$count=0;
						foreach($personasEdad as $Edad=>$valor){ ?>
						<td><?php 
						echo($valor["Hombre"]); 
						$count+=$valor["Hombre"];
						?></td>
						<?php } ?>
						<td class="total"><?php echo($count); ?></td>
					</tr>
					<tr>
						<td>Mujer</td>
						<?php 
						$count=0;
						foreach($personasEdad as $Edad=>$valor){ ?>
						<td><?php 
						echo($valor["Mujer"]); 
						$count+=$valor["Mujer"];
						?></td>
						<?php } ?>
						<td class="total"><?php echo($count); ?></td>
					</tr>
					<tr>
						<td>Hombre</td>
						<?php 
						$count=0;
						foreach($personasEdad as $Edad=>$valor){ ?>
						<td><?php 
						echo($valor["Sin dato"]); 
						$count+=$valor["Sin dato"];
						?></td>
						<?php } ?>
						<td class="total"><?php echo($count); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<?php 
		$consulta=$DaoCasos->_query("SELECT COUNT(Casos.Id) AS Contador, IFNULL(Denuncia.Realizada,-1) AS Denuncia, IFNULL(Reporte.Realizada,-1) AS Reporte FROM Casos LEFT JOIN (SELECT * FROM Denuncia WHERE Tipo='MinisterioPublico') AS Denuncia ON Casos.Id=Denuncia.Caso LEFT JOIN (SELECT * FROM Denuncia WHERE Tipo='ComisionBusqueda') AS Reporte ON Casos.Id=Reporte.Caso JOIN (SELECT Caso, MAX(FechaActoIni) AS FechaActo FROM Actos WHERE TipoActo='Desaparición' GROUP BY Caso) AS Actos ON Actos.Caso=Casos.Id WHERE FechaActo>='".$_GET["Ini"]."' AND FechaActo<='".$_GET["Fin"]."' GROUP BY Denuncia,Reporte");
		$casosReporte=array();
		$casosReporte["Si"]=array();
		$casosReporte["Si"]["Denuncia"]=0;
		$casosReporte["Si"]["Reporte"]=0;
		$casosReporte["Si"]["Ambas"]=0;
		$casosReporte["No"]=array();
		$casosReporte["No"]["Denuncia"]=0;
		$casosReporte["No"]["Reporte"]=0;
		$casosReporte["No"]["Ambas"]=0;
		$casosReporte["Sin dato"]=array();
		$casosReporte["Sin dato"]["Denuncia"]=0;
		$casosReporte["Sin dato"]["Reporte"]=0;
		$casosReporte["Sin dato"]["Ambas"]=0;
		$contadorMax=0;
		foreach($consulta as $row){
			if($row["Denuncia"]==1 && $row["Reporte"]==1){
				$casosReporte["Si"]["Ambas"]=$row["Contador"];
			}elseif($row["Denuncia"]==0 && $row["Reporte"]==0){
				$casosReporte["Si"]["Ambas"]=$row["Contador"];
			}elseif($row["Denuncia"]==-1 && $row["Reporte"]==-1){
				$casosReporte["Sin dato"]["Ambas"]=$row["Contador"];
			}else{
				if($row["Denuncia"]==1){
					$casosReporte["Si"]["Denuncia"]=$row["Contador"];
				}
				if($row["Denuncia"]==0){
					$casosReporte["No"]["Denuncia"]=$row["Contador"];
				}
				if($row["Denuncia"]==-1){
					$casosReporte["Sin dato"]["Denuncia"]=$row["Contador"];
				}
				if($row["Reporte"]==1){
					$casosReporte["Si"]["Reporte"]=$row["Contador"];
				}
				if($row["Reporte"]==0){
					$casosReporte["No"]["Reporte"]=$row["Contador"];
				}
				if($row["Reporte"]==-1){
					$casosReporte["Sin dato"]["Reporte"]=$row["Contador"];
				}
			}
		}
		?>	
		<div class="col-12 mb-3">
			<h5>Reporte y denuncias de casos</h5>
			<p>De acuerdo a la fecha de desaparición</p>
			<canvas id="chartDenunciasCaso" class="mb3"></canvas>
			<script>
				const canvasDenunciasCaso = document.getElementById('chartDenunciasCaso').getContext('2d');
				const chartDenunciasCaso = new Chart(canvasDenunciasCaso, {
					type: 'bar',
					data: {
						labels: ['Sí','No','Sin dato'],
						datasets: [
							{
							label: 'Ambas',
							data: [<?php echo($casosReporte["Si"]["Ambas"]); ?>,<?php echo($casosReporte["No"]["Ambas"]); ?>,<?php echo($casosReporte["Sin dato"]["Ambas"]); ?>],
							backgroundColor: [
								colores[1]
							],
							borderColor: [
								colores[1]
							],
							borderWidth: 1
						},
						{
							label: 'Denuncia',
							data: [<?php echo($casosReporte["Si"]["Denuncia"]); ?>,<?php echo($casosReporte["No"]["Denuncia"]); ?>,<?php echo($casosReporte["Sin dato"]["Denuncia"]); ?>],
							backgroundColor: [
								colores[2]
							],
							borderColor: [
								colores[2]
							],
							borderWidth: 1
						},
						{
							label: 'Reporte',
							data: [<?php echo($casosReporte["Si"]["Reporte"]); ?>,<?php echo($casosReporte["No"]["Reporte"]); ?>,<?php echo($casosReporte["Sin dato"]["Reporte"]); ?>],
							backgroundColor: [
								colores[3]
							],
							borderColor: [
								colores[3]
							],
							borderWidth: 1
						},
						]
					},
					options: {
						scales: {
							y: {
								stacked: false,
								beginAtZero: true,
								ticks: {
									stepSize: 1
								}
							},
							x:{
								stacked: false,
							}
						}
					}
				});
			</script>
		</div>
		<div class="col-12 mb-3">
			<table class="table">
				<thead>
					<tr>
						<th></th>
						<th>Sí</th>
						<th>No</th>
						<th>Sin dato</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Ambas</td>
						<td><?php echo $casosReporte["Si"]["Ambas"]; ?></td>
						<td><?php echo $casosReporte["No"]["Ambas"]; ?></td>
						<td><?php echo $casosReporte["Sin dato"]["Ambas"]; ?></td>
						<td class="total"><?php echo($casosReporte["Si"]["Ambas"]+$casosReporte["No"]["Ambas"]+$casosReporte["Sin dato"]["Ambas"]); ?></td>
					</tr>
					<tr>
						<td>Denuncia</td>
						<td><?php echo $casosReporte["Si"]["Denuncia"]; ?></td>
						<td><?php echo $casosReporte["No"]["Denuncia"]; ?></td>
						<td><?php echo $casosReporte["Sin dato"]["Denuncia"]; ?></td>
						<td class="total"><?php echo($casosReporte["Si"]["Denuncia"]+$casosReporte["No"]["Denuncia"]+$casosReporte["Sin dato"]["Denuncia"]); ?></td>
					</tr>
					<tr>
						<td>Reporte</td>
						<td><?php echo $casosReporte["Si"]["Reporte"]; ?></td>
						<td><?php echo $casosReporte["No"]["Reporte"]; ?></td>
						<td><?php echo $casosReporte["Sin dato"]["Reporte"]; ?></td>
						<td class="total"><?php echo($casosReporte["Si"]["Reporte"]+$casosReporte["No"]["Reporte"]+$casosReporte["Sin dato"]["Reporte"]); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<?php 
		$consulta=$DaoCasos->_query("SELECT SUM(Desaparecida) AS Desaparecidas, SUM(LocalizadaConVida) AS LocalizadaConVida, SUM(LocalizadaSinVida) AS LocalizadaSinVida FROM (SELECT Personas.Id, Sexo,FechaActoIni,Desaparecida, LocalizadaConVida, LocalizadaSinVida FROM Personas JOIN (SELECT Persona, Acto, FechaActoIni, 1 AS Desaparecida FROM Actos JOIN PersonasActos ON PersonasActos.Acto=Actos.Id  WHERE TipoActo='Desaparición') AS Desaparecidas ON Desaparecidas.Persona=Personas.Id LEFT JOIN (SELECT Persona, Acto, 1 AS LocalizadaConVida FROM Actos JOIN PersonasActos ON PersonasActos.Acto=Actos.Id  WHERE TipoActo='Localización con vida') AS LocalizadasConVida ON LocalizadasConVida.Persona=Personas.Id LEFT JOIN (SELECT Persona, Acto, 1 AS LocalizadaSinVida FROM Actos JOIN PersonasActos ON PersonasActos.Acto=Actos.Id  WHERE TipoActo='Localización sin vida') AS LocalizadasSinVida ON LocalizadasSinVida.Persona=Personas.Id WHERE RelacionCaso='Desaparecida' AND FechaActoIni<='".$_GET["Ini"]."' AND FechaActoIni<='".$_GET["Fin"]."' ORDER BY Id) AS Datos");
		foreach($consulta as $row){
			
		}
		?>	
		<div class="col-12 mb-3">
			<h5>Estatus de la víctima</h5>
			<p>De acuerdo a la fecha de desaparición</p>
			<div class="row">
				<div class="col-6">
					<table class="table">
						<thead>
							<tr>
								<th>Estatus</th>
								<th>Personas</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Desaparecida</td>
								<td><?php echo($row["Desaparecidas"]); ?></td>
							</tr>
							<tr>
								<td>Localizada con vida</td>
								<td><?php echo($row["LocalizadaConVida"]); ?></td>
							</tr>
							<tr>
								<td>Localizada sin vida</td>
								<td><?php echo($row["LocalizadaSinVida"]); ?></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="col-6">
					<canvas id="chartEstatusVictima" class="mb3"></canvas>
				</div>
			</div>
			
			<script>
				const canvasEstatusVictima = document.getElementById('chartEstatusVictima').getContext('2d');
				const chartEstatusVictima = new Chart(canvasEstatusVictima, {
					type: 'doughnut',
					data: {
						labels: ['Desaparecida','Localizada con vida','Localizada sin vida'],
						datasets: [
							{
							label: 'Datos',
							data: [<?php echo($row["Desaparecidas"]); ?>,<?php echo($row["LocalizadaConVida"]); ?>,<?php echo($row["LocalizadaSinVida"]); ?>],
							backgroundColor: [
								colores[1], colores[2], colores[3]
							],
							hoverOffset: 4
						},
						]
					},
				});
			</script>
		</div>
		<div class="col-12 mb-3">
			<h5>Municipio de desaparición</h5>
			<p>Por fecha de la desaparición</p>
			<?php 
			$lugares=array();
			$otrosJalisco=0;
			$otrosNoJalisco=0;
			$consulta=$DaoCasos->_query("SELECT COUNT(LugaresActo.Id) AS Eventos, IFNULL(Estado,'Sin dato') AS Estado, IFNULL(IF(Municipio='No aplica','Sin dato',Municipio),'Sin dato') AS Municipio FROM LugaresActo JOIN Actos ON Actos.Id=LugaresActo.Acto WHERE TipoActo='Desaparicion' AND FechaActoIni>='".$_GET["Ini"]."' AND FechaActoIni<='".$_GET["Fin"]."' GROUP BY Pais, Estado, Municipio ORDER BY Eventos DESC");
			foreach($consulta as $row){
				if($row["Eventos"]>1){
					$lugares[$row["Municipio"]]=$row["Eventos"];
				}else{
					if($row["Estado"]=="Jalisco"){
						$otrosJalisco+=$row["Eventos"];
					}else{
						$otrosNoJalisco+=$row["Eventos"];
					}
				}
				
			}
			$labels=array();
			$values=array();
			foreach($lugares as $municipio=>$Eventos){
				array_push($labels,$municipio);
				array_push($values,$Eventos);
			}
			if($otrosJalisco>0){
				array_push($labels,'Otros Jalisco');
				array_push($values,$otrosJalisco);
			}
			if($$otrosNoJalisco>0){
				array_push($labels,'Otros fuera de Jalisco');
				array_push($values,$otrosNoJalisco);
			}
			?>
			<canvas id="chartDesaparicionesMunicipios" class="mb3"></canvas>
			<script>
				const canvasDesaparicionesMunicipios = document.getElementById('chartDesaparicionesMunicipios').getContext('2d');
				const chartDesaparicionesMunicipios = new Chart(canvasDesaparicionesMunicipios, {
					type: 'bar',
					data: {
						labels: ['<?php echo(implode("', '", $labels)); ?>'],
						datasets: [{
							label: 'Actos de desaparición',
							data: [<?php echo(implode(", ",$values)); ?>],
							backgroundColor: [
								colores[1]
							],
							borderColor: [
								colores[1]
							],
							borderWidth: 1
						}]
					},
					options: {
						indexAxis: 'y',
						scales: {
							y: {
								beginAtZero: true,
								ticks: {
									stepSize: 1
								}
							}
						}
					}
				});
			</script>
		</div>
		<div class="col-12 mb-3">
			<table class="table">
				<thead>
					<tr>
						<th>Municipio</th>
						<th>Desapariciones</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$total=0;
					foreach($lugares as $municipio=>$Eventos){ 
						$total+=$Eventos; ?>
					<tr>
						<td><?php echo($municipio); ?></td>
						<td><?php echo(number_format($Eventos,0)); ?></td>
					</tr>
					<?php } ?>
					<?php 
					if($otrosJalisco>0){ 
						$total+=$otrosJalisco; ?>
					<tr>
						<td>Otros Jalisco</td>
						<td><?php echo(number_format($otrosJalisco,0)); ?></td>
					</tr>
					<?php } ?>
					<?php 
					if($otrosNoJalisco>0){ 
						$total+=$otrosNoJalisco; ?>
					<tr>
						<td>Otros fuera de Jalisco</td>
						<td><?php echo(number_format($otrosNoJalisco,0)); ?></td>
					</tr>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td>Total</td>
						<td><?php echo(number_format($total,0)); ?></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<?php
interface_footer();
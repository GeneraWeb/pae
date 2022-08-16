function cambiarFechasReporte(){
	window.location.href="reporte_atencion?Ini="+$("#fechaIni_anio").val()+"-"+$("#fechaIni_mes").val()+"-"+$("#fechaIni_dia").val()+"&Fin="+$("#fechaFin_anio").val()+"-"+$("#fechaFin_mes").val()+"-"+$("#fechaFin_dia").val();
}
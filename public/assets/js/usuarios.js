function modalUsuarios(Obj){
	$("#modalUsuarios .modal-title").html("Nuevo usuario");
	$("#guardarUsuario").html("Crear");
	$('#modalUsuarios').attr('data-id',"");
	if(Obj){
		
	}else{
		$('#modalUsuarios').modal('show');
	}
}

function guardarUsuario(){
	$("#guardarUsuario").html("Guardando...");
	var params=new Object();
	params.action="guardarUsuario";
	params.Id=$('#modalUsuarios').attr('data-id');
	params.Email=$("#emailUsuario").val();
	params.Tipo=$("#tipoUsuario").val();
	params.Nombre=$("#nombreUsuario").val();
	params.Apellidos=$("#apellidosUsuario").val();
	params.Seudonimo=$("#seudonimoUsuario").val();
	$.post("/backend",params,function(resp){
		window.location.reload();
	},"json")
}
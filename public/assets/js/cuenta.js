function cerrarSesiones(){
	var params=new Object();
	params.action="cerrarSesiones";
	$.post("backend",params,function(resp){
		
	},"json")
}

function cerrarSesion(Obj){
	var params=new Object();
	params.action="cerrarSesion";
	params.Id=$(Obj).closest("li").attr("data-id")
	$.post("backend",params,function(resp){
		$(Obj).closest("li").remove();
		show_toast('Eliminar sesión','Sesión finalizada remotamente');
	},"json")
}
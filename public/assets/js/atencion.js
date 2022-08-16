var datoContactoContacto, personaDesaparecida, mapActo, marcadorMapaActo,poligonoMapaActo,poligonoMapaActo_paths;
$(document).ready(function(){
	if(window.location.href.indexOf("caso")<0){
		$("body").addClass("atencion");
	}else{
		$("body").addClass("caso");
	}
	$("input").attr("autocomplete","off");
	$("#tabs li").click(function(){
		showTab($(this).attr("data-target"));
	});
	showTab("infoGeneral");
	$("#tabs li").each(function(){
		deshabilitarEdicionTab($(this).attr("data-target"));
	})
	if(!$("#IdCaso").val()>0){
		$("#tabs li").each(function(){
			habilitarEdicionTab($(this).attr("data-target"));
		})
		$("#contenidos .tab[data-tab='infoGeneral'] .first-focus").focus();
	}
	
	$(".comoSeEntero input.form-check-input[value='Autoridades']").change(function(){
		toggleEnteroAutoridad();
	});
	$("#sexoPersonaContacto_otro").keyup(function(){
		if($("#sexoPersonaContacto_otro").val().trim().length>0){
			if(!$("#modalPersonaContacto input[name='sexoPersonaContacto'][value='Otro']").prop("checked")){
				$("#modalPersonaContacto input[name='sexoPersonaContacto'][value='Otro']").prop("checked",true);
			}
		}
	})
	$("#RelacionConDesaparecidoContacto_otro").keyup(function(){
		if($("#RelacionConDesaparecidoContacto_otro").val().trim().length>0){
			if(!$("#modalPersonaContacto input[name='RelacionConDesaparecidoContacto'][value='Otro']").prop("checked")){
				$("#modalPersonaContacto input[name='RelacionConDesaparecidoContacto'][value='Otro']").prop("checked",true);
			}
		}
	})
	$("#modalActo input[name='tipoActo']").change(function(){
		toggle_tipoActo_Otro();
	})
	datoContactoContacto=$("#modalPersonaContacto .datoContactoContacto").clone();
	personaDesaparecida=$("#listadoPersonasDesaparecidas .personaDesaparecida").clone();
	$("#listadoPersonasDesaparecidas").html("");
	$("#modalActo #resultadosDireccionActo .componentesDireccionActo input[type='text']").keyup(function(){
		if($(this).val().trim().length>0){
			if(!$(this).closest(".input-group").find(".form-check-input").is(":checked")){
				$(this).closest(".input-group").find(".form-check-input").prop("checked",true);
			}
		}
	})
	$('body').on('dragover',function(e) {
		e.preventDefault();
		e.stopPropagation();
		$("#fotografiasPersonaDesaparecida").addClass("dropping")
	})
	$('body').on('dragenter',function(e) {
		e.preventDefault();
		e.stopPropagation();
	})
	$('body').on('dragleave',function(e) {
		e.preventDefault();
		e.stopPropagation();
		$("#fotografiasPersonaDesaparecida").removeClass("dropping")
	})
	var dropZone = document.getElementById('fotografiasPersonaDesaparecida');
	dropZone.addEventListener('drop', handleDroppedFotoPersonaDesaparecida, false);
	$("#archivosFotosPersonasDesaparecidas").on("change",function(evt){
		var tgt = evt.target || window.event.srcElement,
		files = tgt.files;

		// FileReader support
		if (FileReader && files && files.length) {
			for (i = 0; i < files.length; i++) {
				previewFotoPersonaDesaparecida(files[i]);
				readFotoPersonaDesaparecida(files[i]);
			}
			setTimeout(function(){
				uploadQueueFotos();
			}, 500);
		}else{
			show_toast('Error','Tu navegador no soporta procesamiento de archivos, te recomendamos utilizar Chrome');
		}
		$("#archivosFotosPersonasDesaparecidas").val("");
	})
	verificarUpdate();
})


function showTab(tab){
	if($("#IdCaso").val()>0 || tab=="infoGeneral"){
		seguir=true;
		if(tab=="actos"){
			if($("#listadoPersonasDesaparecidas .personaDesaparecida").length==0){
				seguir=false;
			}
		}
		if(seguir){
			$("#contenidos .tab").hide();
			$("#contenidos .tab[data-tab='"+tab+"']").show();
			$("#tabs li").removeClass("selected");
			$("#tabs li[data-target='"+tab+"']").addClass("selected");
		}else{
			show_toast("Sin personas desaparecidas", "Para seguir primero captura las personas desaparecidas");
		}
	}else{
		show_toast("Caso nuevo", "Nombra el caso y da clic en \"Guardar\" para poder acceder a las demás funciones");
	}
}

function habilitarEdicionTab(tab){
	$("#contenidos .tab[data-tab='"+tab+"']").removeClass("readonly");
	$("#contenidos .tab[data-tab='"+tab+"'] .form-control-plaintext").prop("readonly",false);
	$("#contenidos .tab[data-tab='"+tab+"'] .form-control-plaintext").addClass("form-control");
	$("#contenidos .tab[data-tab='"+tab+"'] .form-control-plaintext").removeClass("form-control-plaintext");
	$("#contenidos .tab[data-tab='"+tab+"'] .form-check input").prop("disabled",false);
	$("#contenidos .tab[data-tab='"+tab+"'] .form-check").show();
	$("#contenidos .tab[data-tab='"+tab+"'] .first-focus").focus();
}

function deshabilitarEdicionTab(tab){
	$("#contenidos .tab[data-tab='"+tab+"']").addClass("readonly");
	$("#contenidos .tab[data-tab='"+tab+"'] .form-control").prop("readonly",true);
	$("#contenidos .tab[data-tab='"+tab+"'] .form-control").addClass("form-control-plaintext");
	$("#contenidos .tab[data-tab='"+tab+"'] .form-control").removeClass("form-control");
	$("#contenidos .tab[data-tab='"+tab+"'] .form-check input").prop("disabled",true);
	$("#contenidos .tab[data-tab='"+tab+"'] .form-check").each(function(){
		$(this).hide();
		if($(this).find("input").is(":checked")){
			$(this).show();
		}
	})
}

function toggleEnteroAutoridad(){
	if($(".comoSeEntero input.form-check-input[value='Autoridades']").is(":checked")){
		$('div[data-tab="infoGeneral"] .autoridadEnteroCaso').show();
	}else{
		$('div[data-tab="infoGeneral"] .autoridadEnteroCaso').hide();
	}
}

function modalPersonaContacto(Obj){
	$("#modalPersonaContacto .modal-title").html("Nueva persona de contacto");
	$("#modalPersonaContacto").attr("data-nonce","");
	$("#modalPersonaContacto").attr("data-id","");
	$("#nombrePersonaContacto").val("");
	$("#sexoPersonaContacto_sinDato").prop("checked",true);
	$("#sexoPersonaContacto_otro").val("");
	$("#modalPersonaContacto input[name='RelacionConDesaparecidoContacto']").prop("checked",false);
	$("#RelacionConDesaparecidoContacto_otro").val("");
	$("#modalPersonaContacto input[name='autorizacionDeLaFamiliaContacto']").prop("checked",false);
	$("#modalPersonaContacto .datosContactoContacto").html("");
	$("#modalPersonaContacto .datosContactoContacto").append(datoContactoContacto.clone());
	$("#savePersonaContacto").html("Añadir");
	if(Obj){
		var contacto=JSON.parse($(Obj).closest("li").find(".objeto").val());
		$("#modalPersonaContacto").attr("data-nonce",$(Obj).closest("li").attr("data-nonce"));
		$("#modalPersonaContacto").attr("data-id",contacto.Id);
		$("#modalPersonaContacto .modal-title").html("Editar contacto");
		$("#nombrePersonaContacto").val(contacto.Nombre);
		if(contacto.Sexo){
			$("#modalPersonaContacto input[value='"+contacto.Sexo+"']").prop("checked",true);
			if(contacto.Sexo.indexOf("Otro.")==0){
				$("#modalPersonaContacto input[name='sexoPersonaContacto'][value='Otro']").prop("checked",true);
				$("#sexoPersonaContacto_otro").val(contacto.Sexo.replace("Otro.",""));
			}
		}
		if(contacto.RelacionDesaparecido){
			$("#modalPersonaContacto input[value='"+contacto.RelacionDesaparecido+"']").prop("checked",true);
			if($("#modalPersonaContacto input[name='RelacionConDesaparecidoContacto']:checked").length==0){
				$("#modalPersonaContacto input[name='RelacionConDesaparecidoContacto'][value='Otro']").prop("checked",true);
				$("#RelacionConDesaparecidoContacto_otro").val(contacto.RelacionDesaparecido);
			}
		}
		if(contacto.AutorizacionDeFamiliares){
			if(contacto.AutorizacionDeFamiliares==1){
				$("#autorizacionDeLaFamiliaContacto_si").prop("checked",true);
			}else{
				$("#autorizacionDeLaFamiliaContacto_no").prop("checked",true);
			}
		}
		if(contacto.Contacto){
			for (i = 0; i < contacto.Contacto.length; i++) {
				var obContacto=datoContactoContacto.clone();
				obContacto.find(".tipoDato").val(contacto.Contacto[i].Tipo);
				obContacto.find(".valorDato").val(contacto.Contacto[i].Valor);
				$("#modalPersonaContacto .datosContactoContacto").prepend(obContacto);
			}
		}
		$("#savePersonaContacto").html("Guardar");
	}
	$("#modalPersonaContacto").modal("toggle");
}

function toggle_datoContactoContacto(Obj){
	if($(Obj).closest(".datoContactoContacto").find(".tipoDato").val().length>0 || $(Obj).closest(".datoContactoContacto").find(".tipoDato").val().length>0){
		$(Obj).closest(".datoContactoContacto").removeClass("nuevo");
	}else{
		$(Obj).closest(".datoContactoContacto").addClass("nuevo");
	}
	if($("#modalPersonaContacto .datosContactoContacto .datoContactoContacto.nuevo").length==0){
		$("#modalPersonaContacto .datosContactoContacto").append(datoContactoContacto.clone());
	}
}

function delete_datoContactoContacto(Obj){
	$(Obj).closest(".datoContactoContacto").remove();
	if($("#modalPersonaContacto .datosContactoContacto .datoContactoContacto.nuevo").length==0){
		$("#modalPersonaContacto .datosContactoContacto").append(datoContactoContacto.clone());
	}
}

function savePersonaContacto(){
	if($("#modalPersonaContacto").attr("data-nonce").length>0){
		$("#personaContacto li[data-nonce='"+$("#modalPersonaContacto").attr("data-nonce")+"']").remove();
	}
	var contacto=new Object();
	contacto.Id=$("#modalPersonaContacto").attr("data-id");
	contacto.RelacionCaso="Contacto";
	contacto.Nombre=$("#nombrePersonaContacto").val();
	contacto.Sexo=$("#modalPersonaContacto input[name='sexoPersonaContacto']:checked").val();
	if(contacto.Sexo=="Otro"){
		contacto.Sexo="Otro."+$("#sexoPersonaContacto_otro").val();
	}
	contacto.Contacto=new Array();
	$("#modalPersonaContacto .datosContactoContacto .datoContactoContacto").each(function(){
		if(!$(this).hasClass("nuevo")){
			var datoContacto=new Object();
			datoContacto.Tipo=$(this).find(".tipoDato").val();
			datoContacto.Valor=$(this).find(".valorDato").val();
			contacto.Contacto.push(datoContacto);
		}
	})
	contacto.RelacionDesaparecido=$("#modalPersonaContacto input[name='RelacionConDesaparecidoContacto']:checked").val();
	if(contacto.RelacionDesaparecido=="Otro"){
		contacto.RelacionDesaparecido=$("#RelacionConDesaparecidoContacto_otro").val();
	}
	contacto.AutorizacionDeFamiliares=$("#modalPersonaContacto input[name='autorizacionDeLaFamiliaContacto']:checked").val();
	contacto.Data=new Object();
	if(contacto.Nombre.length>2){
		$("#modalPersonaContacto").modal("toggle");
		parseContacto(contacto)
	}else{
		show_toast('Error', 'Añade el nombre del contacto');
	}
}

function parseContacto(Contacto){
	var nonce_c=nonce();
	if(Contacto.Id){
		if($("#personaContacto li[data-id='"+Contacto.Id+"']").length==0){
			$("#personaContacto").append('<li data-nonce="'+nonce_c+'" data-id="'+Contacto.Id+'">'
			+'</li>');
		}
	}else{
		$("#personaContacto").append('<li data-nonce="'+nonce_c+'" data-id="'+Contacto.Id+'">'
		+'</li>');
	}
	$("#personaContacto li[data-nonce='"+nonce_c+"']").html('<p class="nombre">'+Contacto.Nombre+'</p>'
	+'<p class="relacion">'+Contacto.RelacionDesaparecido+'</p>'
	+'<textarea class="objeto">'+JSON.stringify(Contacto)+'</textarea>'
	+'<i class="fas fa-edit editContacto" onclick="modalPersonaContacto(this)"></i>'
	+'<i class="fas fa-minus-circle deleteContacto" onclick="deleteContacto()"></i>');
}

function parseDesaparecida(Desaparecida){
	var nonce_c=nonce();
	if(Desaparecida.Nonce){
		nonce_c=$("#listadoPersonasDesaparecidas .personaDesaparecida[data-id='"+Desaparecida.Id+"']").attr("data-nonce");
	}else if(Desaparecida.Id){
		if($("#listadoPersonasDesaparecidas .personaDesaparecida[data-id='"+Desaparecida.Id+"']").length==0){
			var ObjDesaparecida=personaDesaparecida.clone();
			ObjDesaparecida.attr("data-id",Desaparecida.Id)
			ObjDesaparecida.attr("data-nonce",nonce_c)
			$("#listadoPersonasDesaparecidas").append(ObjDesaparecida);
		}else{
			nonce_c=$("#listadoPersonasDesaparecidas .personaDesaparecida[data-id='"+Desaparecida.Id+"']").attr("data-nonce");
		}
	}else{
		var ObjDesaparecida=personaDesaparecida.clone();
		ObjDesaparecida.attr("data-nonce",nonce_c)
		$("#listadoPersonasDesaparecidas").append(ObjDesaparecida);
	}
	if(Desaparecida.Nombre){
		$("#listadoPersonasDesaparecidas .personaDesaparecida[data-nonce='"+nonce_c+"'] .nombre").html(Desaparecida.Nombre);
	}
	if(Desaparecida.Sexo){
		$("#listadoPersonasDesaparecidas .personaDesaparecida[data-nonce='"+nonce_c+"'] .sexo").html(Desaparecida.Sexo);
	}
	if(Desaparecida.Edad){
		if(Desaparecida.Edad<1){
			$("#listadoPersonasDesaparecidas .personaDesaparecida[data-nonce='"+nonce_c+"'] .edad").html(Math.round(Desaparecida.Edad*12)+" meses");
		}else{
			$("#listadoPersonasDesaparecidas .personaDesaparecida[data-nonce='"+nonce_c+"'] .edad").html(Desaparecida.Edad+" años");
		}
		
	}
	if(Desaparecida.Fotos){
		if(Desaparecida.Fotos.length>0){
			var params=new Object();
			params.action="getBinarioBase64";
			params.Id=Desaparecida.Fotos[0].Id;
			$.post("/backend",params,function(resp){
				var Binario=resp.substr(0,resp.indexOf('------Data-----'));
				Binario=JSON.parse(Binario);
				var Data=resp.substr(resp.indexOf('------Data-----')+15);
				var img = document.createElement('img');
				img.src = 'data:'+Binario.MimeType+';base64,' + Data;
	
				$("#listadoPersonasDesaparecidas .personaDesaparecida[data-nonce='"+nonce_c+"']").append('<div class="foto"></div>');
				$("#listadoPersonasDesaparecidas .personaDesaparecida[data-nonce='"+nonce_c+"'] .foto").append(img);
			});
			
		}
	}
	Desaparecida.Nonce=nonce_c;
	$("#listadoPersonasDesaparecidas .personaDesaparecida[data-nonce='"+nonce_c+"'] .objeto").html(JSON.stringify(Desaparecida));
	$("#personasDesaparecidas_cantidad").html($("#listadoPersonasDesaparecidas .personaDesaparecida").length);
	renumerarPersonaDesaparecida();
}

function crearObjeto(){
	var Caso=new Object();
	Caso.Id=$("#IdCaso").val();
	// Caso.Folio=
	Caso.Nombre=$("#nombreCaso").val();
	//Caso.CantidadDesaparecidos=
	var ComoSeEntero=new Array();
	$(".comoSeEntero .form-check-input:checked").each(function(){
		if($(this).val()=="Autoridades" && $("#autoridadEnteroCaso").val().length>0){
			ComoSeEntero.push("Autoridades."+$("#autoridadEnteroCaso").val());
		}else{
			ComoSeEntero.push($(this).val());
		}
	});
	Caso.ComoSeEntero=ComoSeEntero.join(",");
	// Caso.Data=
	// Caso.Nonce=
	// Caso.LastUpdate=
	Caso.CantidadDesaparecidos=$("#listadoPersonasDesaparecidas .personaDesaparecida").length;
	Caso.ParteDelColectivo=1;
	if($("body").hasClass("atencion")){
		Caso.ParteDelColectivo=0;
	}
	Caso.Personas=new Array();
	$("#personaContacto li").each(function(){
		var Persona=new Object();
		Persona=JSON.parse($(this).find(".objeto").val());
		Persona.RelacionCaso="Contacto";
		Caso.Personas.push(Persona);
	});
	$("#listadoPersonasDesaparecidas .personaDesaparecida").each(function(){
		var Persona=new Object();
		Persona=JSON.parse($(this).find(".objeto").val());
		Persona.RelacionCaso="Desaparecida";
		Caso.Personas.push(Persona);
	});
	
	Caso.Actos=new Array();
	$("#listadoActos .acto").each(function(){
		var Acto=new Object();
		Acto=JSON.parse($(this).find(".Objeto").val());
		Caso.Actos.push(Acto);
	});
	Caso.Denuncias=new Array();
	
	var Denuncia=new Object();
	Denuncia.Id=$("div[data-tab='denunciasReportes'] .ministerioPublico").attr("data-id");
	Denuncia.Tipo="MinisterioPublico";
	Denuncia.Realizada=$("div[data-tab='denunciasReportes'] .ministerioPublico .realizada").attr("data-valor");
	Denuncia.Autoridad=$("div[data-tab='denunciasReportes'] .ministerioPublico .autoridad").text();
	Denuncia.RazonNoDenuncia=$("div[data-tab='denunciasReportes'] .ministerioPublico .motivo").text();
	Caso.Denuncias.push(Denuncia);
	
	var Denuncia=new Object();
	Denuncia.Id=$("div[data-tab='denunciasReportes'] .comisionBusqueda").attr("data-id");
	Denuncia.Tipo="ComisionBusqueda";
	Denuncia.Realizada=$("div[data-tab='denunciasReportes'] .comisionBusqueda .realizada").attr("data-valor");
	Denuncia.Autoridad=$("div[data-tab='denunciasReportes'] .comisionBusqueda .autoridad").text();
	Denuncia.RazonNoDenuncia=$("div[data-tab='denunciasReportes'] .comisionBusqueda .motivo").text();
	Caso.Denuncias.push(Denuncia);
	
	Caso.Atenciones=new Array();
	$("#listadoAtenciones li").each(function(){
		var Atencion=new Object();
		Atencion=JSON.parse($(this).find(".Objeto").val());
		Caso.Atenciones.push(Atencion);
	})
	return Caso;
}
var caso=null;
function verificarUpdate(){
	if($("#IdCaso").val()>0){
		var params=new Object();
		params.action="getFullCaso";
		params.Id=$("#IdCaso").val();
		$.post("/backend",params,function(resp){
			if(caso==null){
				caso=resp;
			}
			if($("#LastUpdateCaso").val()!==resp.LastUpdate){
				console.log(resp);

				caso=resp;
				$("#nombreCaso").val(resp.Nombre);
				$("#LastUpdateCaso").val(resp.LastUpdate);
				if(resp.ComoSeEntero){
					ComoSeEntero=resp.ComoSeEntero.split(",");
					for (let i = 0; i < ComoSeEntero.length; i++) {
						$(".comoSeEntero .form-check-input[value='"+ComoSeEntero[i]+"']").prop("checked",true);
						$(".comoSeEntero .form-check-input[value='"+ComoSeEntero[i]+"']").show();
						if(ComoSeEntero[i].indexOf("Autoridades")>=0){
							$(".comoSeEntero .form-check-input[value='Autoridades']").prop("checked",true);
							$("#autoridadEnteroCaso").val(ComoSeEntero[i].replace("Autoridades.",""));
							$("#autoridadEnteroCaso").show();
						}
					}
				}
				for (let i = 0; i < resp.Personas.length; i++) {
					if(resp.Personas[i].RelacionCaso=="Contacto"){
						parseContacto(resp.Personas[i]);
					}
					if(resp.Personas[i].RelacionCaso=="Desaparecida"){
						parseDesaparecida(resp.Personas[i]);
					}
				}
				$("#listadoPersonasDesaparecidas .personaDesaparecida[data-id='']").remove();
				/*if($("#listadoPersonasDesaparecidas .personaDesaparecida").length<resp.CantidadDesaparecidos){
					for (i = $("#listadoPersonasDesaparecidas .personaDesaparecida").length; i < resp.CantidadDesaparecidos; i++) {
						parseDesaparecida(new Object());
					}
				}*/
				renumerarPersonaDesaparecida();
				if(resp.Actos){
					for (let i = 0; i < resp.Actos.length; i++) {
						parseActo(resp.Actos[i]);
					}
					$("#listadoActos .acto[data-id='']").remove();
					$("#listadoActos .acto[data-id='undefined']").remove();
					$("#tabs li[data-target='actos']").html('<span class="hide-on-atencion">Actos</span><span class="hide-on-caso">Estatus</span> <span class="numero">'+resp.Actos.length+'</span>');
				}
				if(resp.Denuncias){
					for (let i = 0; i < resp.Denuncias.length; i++) {
						parseDenuncia(resp.Denuncias[i]);
					}
				}
				if(resp.Atenciones){
					for (let i = 0; i < resp.Atenciones.length; i++) {
						parseAtencion(resp.Atenciones[i]);
					}
					$("#listadoAtenciones li[data-id='']").remove();
					$("#listadoAtenciones li[data-id='undefined']").remove();
					$("#tabs li[data-target='atencion']").html('Atención <span class="numero">'+resp.Atenciones.length+'</span>');
				}
			}
			setTimeout(function(){
				verificarUpdate()
			},2000)
		},"json")
	}
}

function guardarInfoGeneral(){
	if(!$("#guardarInfoGeneral").hasClass("disabled")){
		var errores=new Array();
		if($("#nombreCaso").val().length<6){
			errores.push("Proporciona un nombre descriptivo del caso");
		}
		if(errores.length>0){
			show_toast('Error', 'Corrige los siguientes errores: '+errores.join(", "));
		}else{
			$("#guardarInfoGeneral").addClass("disabled");
			$("#guardarInfoGeneral").html("Guardando...");
			$("#guardarActos").addClass("disabled");
			$("#guardarActos").html("Guardando...");
			var params=new Object();
			params.action="guardarCaso";
			params.Caso=crearObjeto();
			$.post("/backend?guardarInfoGeneral",params,function(resp){
				$("#guardarInfoGeneral").removeClass("disabled");
				$("#guardarInfoGeneral").html("Guardar");
				$("#guardarActos").removeClass("disabled");
				$("#guardarActos").html("Guardar");
				if($("#IdCaso").val().length==0){
					show_toast('Guardar', 'Caso creado con éxito');
					window.location.href="/atencion?id="+resp.Id;
				}else if((Object.keys(resp.updated).length+Object.keys(resp.added).length)>0){
					show_toast('Guardar', 'Cambios guardados con éxito');
					deshabilitarEdicionTab('infoGeneral');
					deshabilitarEdicionTab('actos');
				}else{
					show_toast('Guardar', 'No se localizaron cambios');
					deshabilitarEdicionTab('infoGeneral');
					deshabilitarEdicionTab('actos');
				}
			},"json")
		}
	}
}

function guardarCaso(deshabilitarEdicion){
	$("#guardarInfoGeneral").removeClass("disabled");
	$("#guardarInfoGeneral").html("Guardar");
	$("#guardarActos").addClass("disabled");
	$("#guardarActos").html("Guardando...");
	var params=new Object();
	params.action="guardarCaso";
	params.Caso=crearObjeto();
	console.log(params);
	$.post("/backend?guardarCaso",params,function(resp){
		$("#guardarInfoGeneral").removeClass("disabled");
		$("#guardarInfoGeneral").html("Guardar");
		$("#guardarActos").removeClass("disabled");
		$("#guardarActos").html("Guardar");
		if((Object.keys(resp.updated).length+Object.keys(resp.added).length)>0){
			show_toast('Guardar', 'Cambios guardados con éxito');
		}else{
			show_toast('Guardar', 'No se localizaron cambios');
		}
		if(deshabilitarEdicion!==false){
			deshabilitarEdicionTab('infoGeneral');
			deshabilitarEdicionTab('actos');
			deshabilitarEdicionTab('personasDesaparecidas');
		}
	},"json")
}

function addPersonaDesaparecida(){
	var Desaparecida=new Object();
	parseDesaparecida(Desaparecida);
	guardarCaso(false);
}

function delPersonaDesaparecida(Obj){
	var seguir=true;
	if($(Obj).closest(".personaDesaparecida").find(".nombre").html()!=="<span>Sin dato</span>"){
		seguir=false;
	}
	if($(Obj).closest(".personaDesaparecida").find(".datos").html()!=='<span class="sexo">Sin dato</span>, <span class="edad">Sin dato</span>.'){
		seguir=false;
	}
	if(seguir){
		$(Obj).closest(".personaDesaparecida").remove();
		renumerarPersonaDesaparecida();
		guardarCaso(false);
	}else{
		$("#modalDeletePersonaDesaparecida").attr("data-nonce",$(Obj).closest(".personaDesaparecida").attr("data-nonce"));
		$("#modalDeletePersonaDesaparecida").modal("toggle");
	}
}

function renumerarPersonaDesaparecida(){
	var count=0;
	$("#listadoPersonasDesaparecidas .personaDesaparecida").each(function(){
		count=count+1;
		$(this).find(".contador").html("Persona "+count);
	});
	$("#personasDesaparecidas_cantidad").html($("#listadoPersonasDesaparecidas .personaDesaparecida").length);
	$("#tabs li[data-target='personasDesaparecidas']").html('Personas desaparecidas <span class="numero">'+$("#listadoPersonasDesaparecidas .personaDesaparecida").length+'</span>');
}

function modalPersonaDesaparecida(Obj){
	$("#modalPersonaDesaparecida").attr("data-nonce",$(Obj).closest(".personaDesaparecida").attr("data-nonce"));
	$("#modalPersonaDesaparecida").attr("data-id",$(Obj).closest(".personaDesaparecida").attr("data-id"));
	$("#nombrePersonaDesaparecida").val("");
	$("#sexoPersonaDesaparecida_sinDato").prop("checked",true);
	$("#sexoPersonaContacto_otro").val("");
	$("#edadPersonaDesaparecida").val("");
	$("#edadPersonaDesaparecida_anios").prop("checked",true);
	$("#fotografiasPersonaDesaparecida").html('<p>Sin fotografías</p>');
	Desaparecida=JSON.parse($(Obj).closest(".personaDesaparecida").find(".objeto").val());
	if(Desaparecida.Nombre){
		$("#nombrePersonaDesaparecida").val(Desaparecida.Nombre);
	}
	if(Desaparecida.Sexo){
		if(Desaparecida.Sexo=="Hombre"){
			$("#sexoPersonaDesaparecida_hombre").prop("checked",true);
		}
		if(Desaparecida.Sexo=="Mujer"){
			$("#sexoPersonaDesaparecida_mujer").prop("checked",true);
		}
		if(Desaparecida.Sexo.indexOf("Otro.")==0){
			$("input[name='sexoPersonaDesaparecida'][value='Otro']").prop("checked",true);	
			$("#sexoPersonaDesaparecida_otro").val(Desaparecida.Sexo.replace("Otro.",""));
		}
	}
	if(Desaparecida.Edad){
		if(Desaparecida.Edad<1){
			$("#edadPersonaDesaparecida").val(Math.round(Desaparecida.Edad*12));
			$("#edadPersonaDesaparecida_meses").prop("checked",true);
		}else{
			$("#edadPersonaDesaparecida").val(Desaparecida.Edad);
			$("#edadPersonaDesaparecida_anios").prop("checked",true);
		}
	}
	if(Desaparecida.Fotos){
		if(Desaparecida.Fotos.length>0){
			$("#fotografiasPersonaDesaparecida").html('');
			for (let i = 0; i < Desaparecida.Fotos.length; i++) {
				$("#fotografiasPersonaDesaparecida").append('<div class="foto" data-id="'+Desaparecida.Fotos[i].Id+'"></div>');
				var params=new Object();
				params.action="getBinarioBase64";
				params.Id=Desaparecida.Fotos[i].Id;
				$.post("/backend",params,function(resp){
					var Binario=resp.substr(0,resp.indexOf('------Data-----'));
					Binario=JSON.parse(Binario);
					var Data=resp.substr(resp.indexOf('------Data-----')+15);
					var img = document.createElement('img');
					img.src = 'data:'+Binario.MimeType+';base64,' + Data;
					$("#fotografiasPersonaDesaparecida .foto[data-id='"+Binario.Id+"']").append(img);
				})
			}
		}
	}
	$("#modalPersonaDesaparecida").modal("toggle");
}

function savePersonaDesaparecida(){
	if($("#fotografiasPersonaDesaparecida .pendienteSubir").length>0){
		if(!$("#savePersonaDesaparecida").hasClass("disabled")){
			$("#savePersonaDesaparecida").html('Subiendo fotos <i class="fas fa-circle-notch fa-spin"></i>');
			$("#savePersonaDesaparecida").addClass("disabled");
		}
		setTimeout(function(){
			savePersonaDesaparecida();
		},500)
	}else{
		var Desaparecida=new Object();
		Desaparecida.Id=$("#modalPersonaDesaparecida").attr("data-id");
		Desaparecida.Nonce=$("#modalPersonaDesaparecida").attr("data-nonce");
		Desaparecida.Nombre=$("#nombrePersonaDesaparecida").val();
		Desaparecida.Sexo=$("input[name='sexoPersonaDesaparecida']:checked").val();
		if(Desaparecida.Sexo=="Otro"){
			Desaparecida.Sexo="Otro."+$("#sexoPersonaDesaparecida_otro").val();
		}
		Desaparecida.Edad=$("#edadPersonaDesaparecida").val();
		if($("#edadPersonaDesaparecida_meses").is(":checked")){
			Desaparecida.Edad=$("#edadPersonaDesaparecida").val()/12;
		}
		Desaparecida.Fotos=new Array();
		$("#fotografiasPersonaDesaparecida .foto").each(function(){
			if($(this).attr("data-id")>0){
				var Binario=new Object();
				Binario.Id=$(this).attr("data-id");
				Desaparecida.Fotos.push(Binario);
			}
		})
		parseDesaparecida(Desaparecida);
		$("#savePersonaDesaparecida").html('Guardar');
		$("#savePersonaDesaparecida").removeClass("disabled");
		$("#modalPersonaDesaparecida").modal("toggle");
		guardarCaso(false);
	}
}

function confirmDeletePersonaDesaparecida(){
	$("#modalDeletePersonaDesaparecida").modal("toggle");
	$("#listadoPersonasDesaparecidas .personaDesaparecida[data-nonce='"+$("#modalDeletePersonaDesaparecida").attr("data-nonce")+"']").remove();
	renumerarPersonaDesaparecida();
}

function modalSeleccionarActo(){
	$("#modalSeleccionarActo").modal("toggle");
}

function modalActo(Obj){
	var today = new Date();
	$("#modalActo h5").html("Registrar desaparición");
	$("#modalActo").attr("data-id","");
	$("#modalActo").attr("data-nonce","");
	$("#modalActo_personasDesaparecidas").html("");
	if($("div[data-tab='actos']").hasClass("readonly")){
		$("#modalActo .modal-footer").hide();
	}else{
		$("#modalActo .modal-footer").show();
	}
	for (let i = 0; i < caso.Personas.length; i++) {
		if(caso.Personas[i].RelacionCaso=="Desaparecida"){
			nombre="Sin Dato (Nombre persona desaparecida)";
			if(caso.Personas[i].Nombre){
				nombre=caso.Personas[i].Nombre;
			}
			$("#modalActo_personasDesaparecidas").append('<div class="form-check form-check-inline">'
				+'<input class="form-check-input" type="checkbox" id="modalActo_personaDesaparecida_'+caso.Personas[i].Id+'" value="'+caso.Personas[i].Id+'">'
				+'<label class="form-check-label" for="modalActo_personaDesaparecida_'+caso.Personas[i].Id+'">'+nombre+'</label></div>');
		}
	}
	$("#modalActo_personasDesaparecidas input").prop("checked",true);
	$("#modalActo input[name='tipoActo']").prop("checked",false);
	if($("body").hasClass("atencion")){
		$("#modalActo input[value='Desaparición']").prop("checked",true);
	}
	$("#tipoActo_OtroOtro").val("");
	toggle_tipoActo_Otro();
	$("#modalActo input[name='tipoFechaActo']").prop("checked",false);
	$("#tipoFechaActo_puntual").prop("checked",true);
	toggle_tipoFechaActo_rango();
	$("#fechaIniActo_anio").val(today.getFullYear());
	$("#fechaIniActo_mes option").prop("selected",false);
	$("#fechaIniActo_dia").val("");
	$("#fechaIniActo_hora option").prop("selected",false);
	$("#fechaIniActo_minuto option").prop("selected",false);
	$("#fechaIniActo_detalle option").prop("selected",false);
	$("#fechaFinActo_anio").val(today.getFullYear());
	$("#fechaFinActo_mes option").prop("selected",false);
	$("#fechaFinActo_dia").val("");
	$("#fechaFinActo_hora option").prop("selected",false);
	$("#fechaFinActo_minuto option").prop("selected",false);
	$("#fechaFinActo_detalle option").prop("selected",false);
	$("#direccion_acto").val("");
	mapActo.setCenter({ lat: 20.6737776, lng: -103.4056259 });
	mapActo.setZoom(8);
	$("#tipoLugarActo_Puntual").prop("checked",true);
	toggle_tipoLugarActo();
	$("#resultadosDireccionActo .seleccionaResultadoDireccionActo").hide();
	$("#resultadosDireccionActo .seleccionaResultadoDireccionActo").html("");
	$("#checkPais_direccionActo").prop("checked",false);
	$("#checkEstado_direccionActo").prop("checked",false);
	$("#checkMunicipio_direccionActo").prop("checked",false);
	$("#checkLocalidad_direccionActo").prop("checked",false);
	$("#checkColonia_direccionActo").prop("checked",false);
	$("#checkCP_direccionActo").prop("checked",false);
	$("#checkDireccion_direccionActo").prop("checked",false);
	$("#valorPais_direccionActo").val("");
	$("#valorEstado_direccionActo").val("");
	$("#valorMunicipio_direccionActo").val("");
	$("#valorLocalidad_direccionActo").val("");
	$("#valorColonia_direccionActo").val("");
	$("#valorCP_direccionActo").val("");
	$("#valorDireccion_direccionActo").val("");
	$("#comentarios_direccionActo").val("");
	$("#direccion_actoTransito").val("");
	$("#checkPais_direccionActoTransito").prop("checked",false);
	$("#checkEstado_direccionActoTransito").prop("checked",false);
	$("#checkMunicipio_direccionActoTransito").prop("checked",false);
	$("#checkLocalidad_direccionActoTransito").prop("checked",false);
	$("#checkColonia_direccionActoTransito").prop("checked",false);
	$("#checkCP_direccionActoTransito").prop("checked",false);
	$("#checkDireccion_direccionActoTransito").prop("checked",false);
	$("#valorPais_direccionActoTransito").val("");
	$("#valorEstado_direccionActoTransito").val("");
	$("#valorMunicipio_direccionActoTransito").val("");
	$("#valorLocalidad_direccionActoTransito").val("");
	$("#valorColonia_direccionActoTransito").val("");
	$("#valorCP_direccionActoTransito").val("");
	$("#valorDireccion_direccionActoTransito").val("");
	$("#comentarios_direccionActo").val("");
	if(Obj){
		Acto=$(Obj).find(".Objeto").val();
		Acto=JSON.parse(Acto);
		$("#modalActo").attr("data-nonce",$(Obj).attr("data-nonce"));
		$("#modalActo h5").html("Modificar desaparición");
		$("#modalActo").attr("data-id",Acto.Id);
		$("#modalActo_personasDesaparecidas input").prop("checked",false);
		for (let i = 0; i < Acto.IdsPersonas.length; i++) {
			$("#modalActo_personasDesaparecidas input[value='"+Acto.IdsPersonas[i]+"']").prop("checked",true);
		}
		$("#modalActo input[value='"+Acto.TipoActo+"']").prop("checked",true);
		if(Acto.TipoActo.indexOf("Otro")>=0){
			$("#modalActo input[value='Otro']").prop("checked",true);
			$("#tipoActo_OtroOtro").val(Acto.TipoActo.substr(5));
		}
		toggle_tipoActo_Otro();
		if(Acto.FechaActoFin){
			$("#modalActo #tipoFechaActo_rango").prop("checked",true);
		}
		toggle_tipoFechaActo_rango();
		$("#fechaIniActo_anio").val(Acto.FechaActoIni.substr(0,4));
		if(Acto.ExactitudFechaActoIni=="month"){
			$("#fechaIniActo_mes option[value='"+Acto.FechaActoIni.substr(5,2)+"']").prop("selected",true);
		}
		if(Acto.ExactitudFechaActoIni=="day"){
			$("#fechaIniActo_mes option[value='"+Acto.FechaActoIni.substr(5,2)+"']").prop("selected",true);
			$("#fechaIniActo_dia").val(Acto.FechaActoIni.substr(8,2));
		}
		if(Acto.ExactitudFechaActoIni=="hour"){
			$("#fechaIniActo_mes option[value='"+Acto.FechaActoIni.substr(5,2)+"']").prop("selected",true);
			$("#fechaIniActo_dia").val(Acto.FechaActoIni.substr(8,2));
			$("#fechaIniActo_hora option['"+Acto.FechaActoIni.substr(11,2)+"']").prop("selected",true);
		}
		if(Acto.ExactitudFechaActoIni=="minute"){
			$("#fechaIniActo_mes option[value='"+Acto.FechaActoIni.substr(5,2)+"']").prop("selected",true);
			$("#fechaIniActo_dia").val(Acto.FechaActoIni.substr(8,2));
			$("#fechaIniActo_hora option[value='"+Acto.FechaActoIni.substr(11,2)+"']").prop("selected",true);
			$("#fechaIniActo_minuto option[value='"+Acto.FechaActoIni.substr(14,2)+"']").prop("selected",true);
		}
		$("#fechaIniActo_detalle option[value='"+Acto.DetalleFechaActoIni+"']").prop("selected",true);
		if(Acto.FechaActoFin){
			$("#fechaFinActo_anio").val(Acto.FechaActoFin.substr(0,4));
			if(Acto.ExactitudFechaActoFin=="month"){
				$("#fechaFinActo_mes option[value='"+Acto.FechaActoFin.substr(5,2)+"']").prop("selected",true);
			}
			if(Acto.ExactitudFechaActoFin=="day"){
				$("#fechaFinActo_mes option[value='"+Acto.FechaActoFin.substr(5,2)+"']").prop("selected",true);
				$("#fechaFinActo_dia").val(Acto.FechaActoFin.substr(8,2));
			}
			if(Acto.ExactitudFechaActoFin=="hour"){
				$("#fechaFinActo_mes option[value='"+Acto.FechaActoFin.substr(5,2)+"']").prop("selected",true);
				$("#fechaFinActo_dia").val(Acto.FechaActoFin.substr(8,2));
				$("#fechaFinActo_hora option['"+Acto.FechaActoFin.substr(11,2)+"']").prop("selected",true);
			}
			if(Acto.ExactitudFechaActoFin=="minute"){
				$("#fechaFinActo_mes option[value='"+Acto.FechaActoFin.substr(5,2)+"']").prop("selected",true);
				$("#fechaFinActo_dia").val(Acto.FechaActoFin.substr(8,2));
				$("#fechaFinActo_hora option[value='"+Acto.FechaActoFin.substr(11,2)+"']").prop("selected",true);
				$("#fechaFinActo_minuto option[value='"+Acto.FechaActoFin.substr(14,2)+"']").prop("selected",true);
			}
			$("#fechaFinActo_detalle option[value='"+Acto.DetalleFechaActoFin+"']").prop("selected",true);
		}
		LugarInicio=null;
		for (let i = 0; i < Acto.Lugares.length; i++) {
			if(Acto.Lugares[i].Data.Tipo=="Puntual"){
				LugarInicio=Acto.Lugares[i];
			}
			if(Acto.Lugares[i].Data.Tipo=="Transito"){
				if(Acto.Lugares[i].Data.Transito=="Inicio"){
					LugarInicio=Acto.Lugares[i];
				}
				if(Acto.Lugares[i].Data.Transito=="Final"){
					LugarFinal=Acto.Lugares[i];
				}
			}
		}
		if(LugarInicio!==null){
			$("#mapaActo").attr("data-id",LugarInicio.Id);
			if(LugarInicio.Pais){
				$("#checkPais_direccionActo").prop("checked",true);
				$("#valorPais_direccionActo").val(LugarInicio.Pais);
			}
			if(LugarInicio.Estado){
				$("#checkEstado_direccionActo").prop("checked",true);
				$("#valorEstado_direccionActo").val(LugarInicio.Estado);
			}
			if(LugarInicio.Municipio){
				$("#checkMunicipio_direccionActo").prop("checked",true);
				$("#valorMunicipio_direccionActo").val(LugarInicio.Municipio);
			}
			if(LugarInicio.Localidad){
				$("#checkLocalidad_direccionActo").prop("checked",true);
				$("#valorLocalidad_direccionActo").val(LugarInicio.Localidad);
			}
			if(LugarInicio.Colonia){
				$("#checkColonia_direccionActo").prop("checked",true);
				$("#valorColonia_direccionActo").val(LugarInicio.Colonia);
			}
			if(LugarInicio.Direccion){
				$("#checkDireccion_direccionActo").prop("checked",true);
				$("#valorDireccion_direccionActo").val(LugarInicio.Direccion);
			}
			if(LugarInicio.CodPostal){
				$("#checkCP_direccionActo").prop("checked",true);
				$("#valorCP_direccionActo").val(LugarInicio.CodPostal);
			}
			$("#comentarios_direccionActo").val(LugarInicio.Comentarios);
			if(LugarInicio.Data.Marcador){
				$("#dropMarcadorMapaActo").addClass("activo");
				LugarInicio.Data.Marcador.lat=parseFloat(LugarInicio.Data.Marcador.lat);
				LugarInicio.Data.Marcador.lng=parseFloat(LugarInicio.Data.Marcador.lng);
				/*
				marcadorMapaActo = new google.maps.Marker({
					map: mapActo,
					draggable: true,
					animation: google.maps.Animation.DROP
				  });
				 markerpos=new google.maps.LatLng(LugarInicio.Data.Marcador.lat, LugarInicio.Data.Marcador.lng);
				 marcadorMapaActo.setPosition(markerpos);*/
			}
			if(LugarInicio.Data.Path){
				
			}
			if(LugarInicio.Data.Mapa){
				/*var bounds=new google.maps.LatLngBounds();
				bounds.union(LugarInicio.Data.Mapa);
				mapActo.setCenter(bounds.getCenter());
				mapActo.fitBounds(bounds);*/
			}
			$("#direccion_acto").val(LugarInicio.Data.Busqueda);
			if(LugarInicio.Data.Tipo=="Transito"){
				$("#tipoLugarActo_EnTransito").prop("checked",true);
				toggle_tipoLugarActo();
				$("#mapaActo").attr("data-id-transito",LugarFinal.Id);
				if(LugarFinal.Pais){
					$("#checkPais_direccionActoTransito").prop("checked",true);
					$("#valorPais_direccionActoTransito").val(LugarFinal.Pais);
				}
				if(LugarFinal.Estado){
					$("#checkEstado_direccionActoTransito").prop("checked",true);
					$("#valorEstado_direccionActoTransito").val(LugarFinal.Estado);
				}
				if(LugarFinal.Municipio){
					$("#checkMunicipio_direccionActoTransito").prop("checked",true);
					$("#valorMunicipio_direccionActoTransito").val(LugarFinal.Municipio);
				}
				if(LugarFinal.Localidad){
					$("#checkLocalidad_direccionActoTransito").prop("checked",true);
					$("#valorLocalidad_direccionActoTransito").val(LugarFinal.Localidad);
				}
				if(LugarFinal.Colonia){
					$("#checkColonia_direccionActoTransito").prop("checked",true);
					$("#valorColonia_direccionActoTransito").val(LugarFinal.Colonia);
				}
				if(LugarFinal.Direccion){
					$("#checkDireccion_direccionActoTransito").prop("checked",true);
					$("#valorDireccion_direccionActoTransito").val(LugarFinal.Direccion);
				}
				if(LugarFinal.CodPostal){
					$("#checkCP_direccionActoTransito").prop("checked",true);
					$("#valorCP_direccionActoTransito").val(LugarFinal.CodPostal);
				}
				$("#direccion_actoTransito").val(LugarFinal.Data.Busqueda);
			}
		}
		$("#modalActo").modal("toggle");
	}else{
		$("#modalSeleccionarActo").modal("toggle");
		$("#modalActo").modal("toggle");
	}
}

function toggle_tipoActo_Otro(){
	if($("#tipoActo_Otro").is(":checked")){
		$("#modalActo .tipoActo_OtroOtro").show();
	}else{
		$("#modalActo .tipoActo_OtroOtro").hide();
	}
}
function toggle_tipoFechaActo_rango(){
	if($("#tipoFechaActo_rango").is(":checked")){
		$("#modalActo .tipoFechaActo_rango").show();
	}else{
		$("#modalActo .tipoFechaActo_rango").hide();
	}
}

function toggle_tipoLugarActo(){
	if($("#tipoLugarActo_EnTransito").is(":checked")){
		$("#modalActo .tipoLugarActo_EnTransito").show();
	}else{
		$("#modalActo .tipoLugarActo_EnTransito").hide();
	}
}

var geocodeResultsActo;
var _arrayTypesGeocoding=new Array();
_arrayTypesGeocoding["street_address"]="Dirección";
_arrayTypesGeocoding["route"]="Ruta";
_arrayTypesGeocoding["intersection"]="Intersección";
_arrayTypesGeocoding["political"]="Delimitación geográfica";
_arrayTypesGeocoding["neighborhood"]="Colonia";
_arrayTypesGeocoding["premise"]="Lugar conocido";
_arrayTypesGeocoding["postal_code"]="Código postal";
_arrayTypesGeocoding["natural_feature"]="Parque natural";
_arrayTypesGeocoding["airport"]="Aeropuerto";
_arrayTypesGeocoding["park"]="Parque";
_arrayTypesGeocoding["point_of_interest"]="Punto de interés";

function buscarDireccionActo(Modificador){
	if(!Modificador){
		Modificador="";
	}
	if($("#direccion_acto"+Modificador).val().trim().length>5){
		if(!$("#buscarDireccionActo"+Modificador).hasClass("disabled")){
			$("#buscarDireccionActo"+Modificador).addClass("disabled");
			$("#seleccionaResultadoDireccionActo").html("<p>Selecciona uno de los resultados:</p>")
			var params=new Object();
			params.action="geoLocate";
			params.direccion=$("#direccion_acto"+Modificador).val();
			$.post("/backend",params,function(resp){
				console.log(resp);
				if(resp.results){
					geocodeResultsActo=resp.results;
					if(geocodeResultsActo.length>0){
						if(geocodeResultsActo.length==1){
							parseResultadoGeolocate(geocodeResultsActo[0],Modificador);
						}else{
							$("#modalActo .seleccionaResultadoDireccionActo").show();
							for (let i = 0; i < geocodeResultsActo.length; i++) {
								tipoDireccion="";
								for (let j = 0; j < geocodeResultsActo[i].types.length; j++) {
									if(_arrayTypesGeocoding[geocodeResultsActo[i].types[j]]){
										tipoDireccion=_arrayTypesGeocoding[geocodeResultsActo[i].types[j]];
									}
								}
								$("#seleccionaResultadoDireccionActo").append('<div class="resultado" onclick="seleccionarResultadoGeolocate(this)"><span class="consecutivo">'+(i+1)+'</span><p class="direccion">'+geocodeResultsActo[i].formatted_address+'</p><p class="tipoResultado">'+tipoDireccion+'</p><textarea class="Objeto">'+JSON.stringify(geocodeResultsActo[i])+'</textarea></div>');
							}
						}
					}else{
						show_toast("Error", "No se localizó el lugar, por favor revisa.");
					}
				}else{
					show_toast("Error", "No se localizó el lugar, por favor revisa.");
				}
				$("#buscarDireccionActo"+Modificador).removeClass("disabled");
			},"json");
		}
	}else{
		show_toast("Error", "Especifica una dirección o lugar");
	}
}

function seleccionarResultadoGeolocate(Obj){
	parseResultadoGeolocate(JSON.parse($(Obj).find("textarea.Objeto").val()));
	$("#seleccionaResultadoDireccionActo").html();
}
function parseResultadoGeolocate(result,Modificador){
	$("#modalActo .seleccionaResultadoDireccionActo"+Modificador).hide();
	var Pais,Estado,Municipio,Localidad,Colonia,CP,Direccion,Numero;
	$("#valorPais_direccionActo"+Modificador).val("");
	$("#valorEstado_direccionActo"+Modificador).val("");
	$("#valorMunicipio_direccionActo"+Modificador).val("");
	$("#valorLocalidad_direccionActo"+Modificador).val("");
	$("#valorColonia_direccionActo"+Modificador).val("");
	$("#valorCP_direccionActo"+Modificador).val("");
	$("#valorDireccion_direccionActo"+Modificador).val("");
	$("#comentarios_direccionActo"+Modificador).val("");
	$("#checkPais_direccionActo"+Modificador).prop("checked",false);
	$("#checkEstado_direccionActo"+Modificador).prop("checked",false);
	$("#checkMunicipio_direccionActo"+Modificador).prop("checked",false);
	$("#checkLocalidad_direccionActo"+Modificador).prop("checked",false);
	$("#checkColonia_direccionActo"+Modificador).prop("checked",false);
	$("#checkCP_direccionActo"+Modificador).prop("checked",false);
	$("#checkDireccion_direccionActo"+Modificador).prop("checked",false);
	
	$("#resultadosDireccionActo .seleccionaResultadoDireccionActo").hide();
	
	for (let i = 0; i < result.address_components.length; i++) {
		procesar=false;
		for (let j = 0; j < result.address_components[i].types.length; j++) {
			if(result.address_components[i].types[j]=="political" || result.address_components[i].types[j]=="route" || result.address_components[i].types[j]=="street_number" || result.address_components[i].types[j]=="postal_code"){
				procesar=true;
			}
		}
		if(procesar){
			for (let j = 0; j < result.address_components[i].types.length; j++) {
				if(result.address_components[i].types[j]=="country"){
					Pais=result.address_components[i].long_name;
				}
				if(result.address_components[i].types[j]=="administrative_area_level_1"){
					Estado=result.address_components[i].long_name;
				}
				if(result.address_components[i].types[j]==""){
					Municipio=result.address_components[i].long_name;
				}
				if(result.address_components[i].types[j]=="neighborhood" || result.address_components[i].types[j]=='sublocality' || result.address_components[i].types[j]=='sublocality_level_1'){
					Colonia=result.address_components[i].long_name;
				}
				if(result.address_components[i].types[j]=="locality"){
					Localidad=result.address_components[i].long_name;
				}
				if(result.address_components[i].types[j]=="postal_code"){
					CP=result.address_components[i].long_name;
				}
				if(result.address_components[i].types[j]=="route"){
					Direccion=result.address_components[i].long_name;
				}
				if(result.address_components[i].types[j]=="street_number"){
					Numero=result.address_components[i].long_name;
				}
			}
		}
	}
	zoomMapa=14;
	if(Pais){
		$("#valorPais_direccionActo"+Modificador).val(Pais);
		$("#checkPais_direccionActo"+Modificador).prop("checked",true);
	}
	if(Estado){
		$("#valorEstado_direccionActo"+Modificador).val(Estado);
		$("#checkEstado_direccionActo"+Modificador).prop("checked",true);
	}
	if(Municipio){
		$("#valorMunicipio_direccionActo"+Modificador).val(Municipio);
		$("#checkMunicipio_direccionActo"+Modificador).prop("checked",true);
		zoomMapa=12;
		
	}
	if(Localidad){
		$("#valorLocalidad_direccionActo"+Modificador).val(Localidad);
		$("#checkLocalidad_direccionActo"+Modificador).prop("checked",true);
		zoomMapa=12;
	}
	if(Colonia){
		$("#valorColonia_direccionActo"+Modificador).val(Colonia);
		$("#checkColonia_direccionActo"+Modificador).prop("checked",true);
		zoomMapa=14;
	}
	if(CP){
		$("#valorCP_direccionActo"+Modificador).val(CP);
		$("#checkCP_direccionActo"+Modificador).prop("checked",true);
		zoomMapa=14;
	}
	if(Direccion){
		zoomMapa=16;
		if(Numero){
			Direccion=Direccion+" "+Numero;
		}
		$("#valorDireccion_direccionActo"+Modificador).val(Direccion);
		$("#checkDireccion_direccionActo"+Modificador).prop("checked",true);
	}
	var bounds=new google.maps.LatLngBounds(result.geometry.viewport.southwest,result.geometry.viewport.northeast);
	if(Modificador=="Transito"){
		if(marcadorMapaActo){
			bounds.extend(marcadorMapaActo.getPosition());
		}
	}
	mapActo.setCenter(bounds.getCenter());
	mapActo.fitBounds(bounds);
	if(Modificador=="Transito"){
		turnOff_marcadorMapaActo();
	}else if(Direccion){
		dropMarcadorMapaActo();
	}
	
}

function dropMarcadorMapaActo(){
	if($("#dropMarcadorMapaActo").hasClass("activo")){
		turnOff_marcadorMapaActo();
	}else{
		crearMarcadorMapaActo();
		turnOff_dibujarMapaActo();
	}
}

function crearMarcadorMapaActo(){
	$("#dropMarcadorMapaActo").addClass("activo");
	marcadorMapaActo = new google.maps.Marker({
		map: mapActo,
		draggable: true,
		animation: google.maps.Animation.DROP,
		position: mapActo.getCenter(),
	  });
}
function turnOff_marcadorMapaActo(){
	$("#dropMarcadorMapaActo").removeClass("activo");
	marcadorMapaActo.setMap(null);
}

function dibujarMapaActo(){
	if($("#dibujarMapaActo").hasClass("activo")){
		turnOff_dibujarMapaActo();
	}else{
		habilitarDibujarMapaActo();
		turnOff_marcadorMapaActo();
	}
}

function habilitarDibujarMapaActo(){
	$("#dibujarMapaActo").addClass("activo");
	poligonoMapaActo_paths=new Array();
	mapActo.addListener("click",(mapsMouseEvent) => {
		poligonoMapaActo_paths.push(mapsMouseEvent.latLng.toJSON());
		updatePoligonoMapaActo()
	});
	poligonoMapaActo = new google.maps.Polygon({
		paths: poligonoMapaActo_paths,
		strokeColor: "#FF0000",
		strokeOpacity: 0.8,
		strokeWeight: 2,
		fillColor: "#FF0000",
		fillOpacity: 0.35,
		editable: true
	  });
	  poligonoMapaActo.setMap(mapActo);
}

function updatePoligonoMapaActo(){
	poligonoMapaActo.setPath(poligonoMapaActo_paths);
}

function turnOff_dibujarMapaActo(){
	$("#dibujarMapaActo").removeClass("activo");
	google.maps.event.clearListeners(mapActo, 'click');
	if(poligonoMapaActo){
		poligonoMapaActo.setMap(null);
	}
}

function guardarActo(){
	var Acto=new Object();
	Acto.Id=$("#modalActo").attr("data-id");
	Acto.Nonce=$("#modalActo").attr("data-nonce");
	Acto.TipoActo=$("#modalActo input[name='tipoActo']:checked").val();
	if(Acto.TipoActo=="Otro"){
		Acto.TipoActo="Otro."+$("#tipoActo_OtroOtro").val();
	}
	Mes="01";
	Dia="01";
	Hora="00";
	Minutos="00";
	Detalle="month";
	ExactitudFechaActoIni="year";
	if($("#fechaIniActo_mes").val().length>0){
		Mes=$("#fechaIniActo_mes").val();
		ExactitudFechaActoIni="month";
	}
	if($("#fechaIniActo_dia").val().length>0){
		Dia=$("#fechaIniActo_dia").val();
		ExactitudFechaActoIni="day";
	}
	if($("#fechaIniActo_hora").val().length>0){
		Hora=$("#fechaIniActo_hora").val();
		ExactitudFechaActoIni="hour";
	}
	if($("#fechaIniActo_minuto").val().length>0){
		Minuto=$("#fechaIniActo_minuto").val();
		ExactitudFechaActoIni="minute";
	}
	if($("#fechaIniActo_detalle").val().length>0){
		Detalle=$("#fechaIniActo_detalle").val();
	}
	Acto.FechaActoIni=$("#fechaIniActo_anio").val()+"-"+Mes+"-"+Dia+" "+Hora+":"+Minutos+":00";
	Acto.ExactitudFechaActoIni=ExactitudFechaActoIni;
	Acto.DetalleFechaActoIni=Detalle;
	
	if($("#tipoFechaActo_rango").is(":checked")){
		Mes="01";
		Dia="01";
		Hora="00";
		Minutos="00";
		Detalle="month";
		ExactitudFechaActoFin="year";
		if($("#fechaFinActo_mes").val().length>0){
			Mes=$("#fechaFinActo_mes").val();
			ExactitudFechaActoFin="month";
		}
		if($("#fechaFinActo_dia").val().length>0){
			Dia=$("#fechaFinActo_dia").val();
			ExactitudFechaActoFin="day";
		}
		if($("#fechaFinActo_hora").val().length>0){
			Hora=$("#fechaFinActo_hora").val();
			ExactitudFechaActoFin="hour";
		}
		if($("#fechaFinActo_minuto").val().length>0){
			Minuto=$("#fechaFinActo_minuto").val();
			ExactitudFechaActoFin="minute";
		}
		if($("#fechaFinActo_detalle").val().length>0){
			Detalle=$("#fechaFinActo_detalle").val();
		}
		Acto.FechaActoFin=$("#fechaFinActo_anio").val()+"-"+Mes+"-"+Dia+" "+Hora+":"+Minutos+":00";
		Acto.ExactitudFechaActoFin=ExactitudFechaActoFin;
		Acto.DetalleFechaActoFin=Detalle;
	}
	
	Acto.Lugares=new Array();
	
	var LugarActo=new Object();
	LugarActo.Id=$("#mapaActo").attr("data-id");
	if($("#checkPais_direccionActo").is(":checked")){
		LugarActo.Pais=$("#valorPais_direccionActo").val();
	}
	if($("#checkEstado_direccionActo").is(":checked")){
		LugarActo.Estado=$("#valorEstado_direccionActo").val();
	}
	if($("#checkMunicipio_direccionActo").is(":checked")){
		LugarActo.Municipio=$("#valorMunicipio_direccionActo").val();
	}
	if($("#checkLocalidad_direccionActo").is(":checked")){
		LugarActo.Localidad=$("#valorLocalidad_direccionActo").val();
	}
	if($("#checkColonia_direccionActo").is(":checked")){
		LugarActo.Colonia=$("#valorColonia_direccionActo").val();
	}
	if($("#checkDireccion_direccionActo").is(":checked")){
		LugarActo.Direccion=$("#valorDireccion_direccionActo").val();
	}
	if($("#checkCP_direccionActo").is(":checked")){
		LugarActo.CodPostal=$("#valorCP_direccionActo").val();
	}
	LugarActo.Comentarios=$("#comentarios_direccionActo").val();
	LugarActo.Data=new Object();
	if($("#dropMarcadorMapaActo").hasClass("activo")){
		if(marcadorMapaActo){
			LugarActo.Data.Marcador=marcadorMapaActo.getPosition().toJSON();
		}
	}
	if($("#dibujarMapaActo").hasClass("activo")){
		LugarActo.Data.Path=new Array();
		poligonoMapaActo.getPath().getArray().forEach(function(T){
			LugarActo.Data.Path.push(T.toJSON());
		});
	}
	LugarActo.Data.Mapa=mapActo.getBounds().toJSON();
	LugarActo.Data.Busqueda=$("#direccion_acto").val();
	LugarActo.Data.Tipo="Puntual";
	if($("#tipoLugarActo_EnTransito").is(":checked")){
		LugarActo.Data.Tipo="Transito";
		LugarActo.Data.Transito="Inicio";
	}
	Acto.Lugares.push(LugarActo);
	if($("#tipoLugarActo_EnTransito").is(":checked")){
		var LugarActo=new Object();
		LugarActo.Id=$("#mapaActo").attr("data-id-transito");
		if($("#checkPais_direccionActoTransito").is(":checked")){
			LugarActo.Pais=$("#valorPais_direccionActoTransito").val();
		}
		if($("#checkEstado_direccionActoTransito").is(":checked")){
			LugarActo.Estado=$("#valorEstado_direccionActoTransito").val();
		}
		if($("#checkMunicipio_direccionActoTransito").is(":checked")){
			LugarActo.Municipio=$("#valorMunicipio_direccionActoTransito").val();
		}
		if($("#checkLocalidad_direccionActoTransito").is(":checked")){
			LugarActo.Localidad=$("#valorLocalidad_direccionActoTransito").val();
		}
		if($("#checkColonia_direccionActoTransito").is(":checked")){
			LugarActo.Colonia=$("#valorColonia_direccionActoTransito").val();
		}
		if($("#checkDireccion_direccionActoTransito").is(":checked")){
			LugarActo.Direccion=$("#valorDireccion_direccionActoTransito").val();
		}
		if($("#checkCP_direccionActoTransito").is(":checked")){
			LugarActo.CodPostal=$("#valorCP_direccionActoTransito").val();
		}
		LugarActo.Data=new Object();
		LugarActo.Data.Tipo="Transito";
		LugarActo.Data.Transito="Final";
		LugarActo.Data.Busqueda=$("#direccion_actoTransito").val();
		Acto.Lugares.push(LugarActo);
	}
	Acto.IdsPersonas=new Array();
	$("#modalActo_personasDesaparecidas input:checked").each(function(){
		Acto.IdsPersonas.push($(this).val());
	});
	parseActo(Acto);
	$("#modalActo").modal("toggle");
}

function parseActo(Acto){
	var nonce_c=nonce();
	if(Acto.Nonce){
		nonce_c=Acto.Nonce;
		if(!Acto.Id){
			Acto.Id=null;
		}
		if($("#listadoActos .acto[data-nonce='"+Acto.Nonce+"']").length>0){
			Acto.Id=$("#listadoActos .acto[data-nonce='"+Acto.Nonce+"']").attr("data-id")
		}else{
			$("#listadoActos").append('<div class="acto" data-nonce="'+nonce_c+'" data-id="'+Acto.Id+'" onclick="showModalActo(this)"></div>');
		}
	}else if(Acto.Id>0){
		if($("#listadoActos .acto[data-id='"+Acto.Id+"']").length==0){
			$("#listadoActos").append('<div class="acto" data-nonce="'+nonce_c+'" data-id="'+Acto.Id+'" onclick="showModalActo(this)"></div>');
		}
	}else{
		$("#listadoActos").append('<div class="acto" data-nonce="'+nonce_c+'" data-id="'+Acto.Id+'" onclick="showModalActo(this)"></div>');
	}
	strPersonas="";
	for (let i = 0; i < caso.Personas.length; i++) {
		if(Acto.IdsPersonas.includes(caso.Personas[i].Id)){
			nombre="Sin Dato (Nombre persona desaparecida)";
			if(caso.Personas[i].Nombre){
				nombre=caso.Personas[i].Nombre;
			}
			strPersonas+='<li>'+nombre+'</li>';
		}
	}
	strLugar="";
	if(Acto.Lugares){
		if(Acto.Lugares.length>0){
			strLugar=Acto.Lugares[0].Localidad+' '+Acto.Lugares[0].Municipio+', '+Acto.Lugares[0].Estado;
		}
	}
	$("#listadoActos .acto[data-nonce='"+nonce_c+"']").html('<p class="tipo">'+Acto.TipoActo+'</p>'
	+'<ul class="personas">'+strPersonas+'</ul>'
	+'<p class="fecha">'+Acto.FechaActoIni+'</p>'
	+'<p class="lugar">'+strLugar+'</p>'
	+'<textarea class="Objeto">'+JSON.stringify(Acto)+'</textarea>')
}

var filesToUpload=new Array()

function handleDroppedFotoPersonaDesaparecida(evt) {
	evt.stopPropagation();
	evt.preventDefault();

	$("#fotografiasPersonaDesaparecida").removeClass("dropping")
	//Check for the various File API support.
	if (window.File && window.FileReader && window.FileList && window.Blob) {
		// Great success! All the File APIs are supported.
		// FileList object
		var files = evt.dataTransfer.files
		
		for (var i = 0, f; f = files[i]; i++) {
			var nonceFoto=nonce();
			// Only process image files.
			previewFotoPersonaDesaparecida(f,nonceFoto);
			readFotoPersonaDesaparecida(f,nonceFoto);
		}
		setTimeout(function(){
			uploadQueueFotos();
		}, 500);
	}else{
		show_toast('Error','Tu navegador no soporta procesamiento de archivos, te recomendamos utilizar Chrome');
	}
}

function confirmExit() {
	return "Se están subiendo las fotos!";
}

function uploadQueueFotos(){
	var name, type, size, bin, nonce;
	window.onbeforeunload = confirmExit;
	if($("#fotografiasPersonaDesaparecida .foto.pendienteSubir").length>0 && $("#fotografiasPersonaDesaparecida .foto.subiendo").length<3){
		var fila=$("#fotografiasPersonaDesaparecida .foto.pendienteSubir").first();
		fila.removeClass("pendienteSubir");
		fila.addClass("subiendo");
		fila.find("i").addClass("fa-spin");
		$("#fotografiasPersonaDesaparecida").prepend(fila);
		
		for (i = 0; i < filesToUpload.length; i++){
			if(filesToUpload[i].nonce==fila.attr("data-nonce")){
				name=filesToUpload[i].name;
				type=filesToUpload[i].type;
				size=filesToUpload[i].size;
				bin=filesToUpload[i].bin;
				nonce=filesToUpload[i].nonce;
			}
		}
		if(nonce.length>0){
			var xhr
			var reader = new FileReader();
			
			if(window.XMLHttpRequest){
				 xhr = new XMLHttpRequest();
			}else if(window.ActiveXObject){
				 xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
				
			// progress bar loadend
			var eventSource = xhr.upload || xhr;
				eventSource.addEventListener("progress", function(e) {  
				var pc = parseInt((e.loaded / e.total * 100));  
				//$('#mascara_img span').html(pc+'%') 
			}, false); 
							
			xhr.onreadystatechange=function(){
				if(xhr.readyState==4 && xhr.status==200){
					resp=JSON.parse(xhr.responseText);
					console.log(resp);
					if(resp.error){
						show_toast('Error','Ocurrió un error al subir la fotografía: '+resp.error);
						$("#fotografiasPersonaDesaparecida .foto[data-nonce='"+resp.nonce+"']").addClass("uploadError");
					}else{
						$("#fotografiasPersonaDesaparecida .foto[data-nonce='"+resp.nonce+"']").addClass("done");
						$("#fotografiasPersonaDesaparecida .foto[data-nonce='"+resp.nonce+"']").attr('data-id',resp.binario.Id);
					}
					$("#fotografiasPersonaDesaparecida .foto[data-nonce='"+resp.nonce+"']").removeClass("subiendo");
					$("#fotografiasPersonaDesaparecida .foto[data-nonce='"+resp.nonce+"'] i").remove();
					$("#fotografiasPersonaDesaparecida .foto[data-nonce='"+resp.nonce+"'] i").append('<i class="fas fa-trash-alt eliminarFoto"></i>');
					$("#fotografiasPersonaDesaparecida .foto[data-nonce='"+resp.nonce+"'] i").append('<i class="fas fa-search-plus zoomFoto"></i>');
					// quitar del array filesToUpload
					returnUploadQueueFotos();
				}else if(xhr.readyState==4){
					show_toast('Error','Ocurrió un error en el servidor al subir la fotografía');
					$("#fotografiasPersonaDesaparecida .foto[data-nonce='"+nonce+"']").addClass("uploadError");
					$("#fotografiasPersonaDesaparecida .foto[data-nonce='"+nonce+"']").removeClass("subiendo");
					$("#fotografiasPersonaDesaparecida .foto[data-nonce='"+resp.nonce+"'] i").remove();
					// quitar del array filesToUpload
					returnUploadQueueFotos();
				}
			}
			xhr.open('POST', '/backend.php?action=uploadFile', true);
			var boundary = 'xxxxxxxxx';
			var body = '--' + boundary + "\r\n";  
			body += "Content-Disposition: form-data; name='" + name + "\r\n";  
			body += "Content-Type: application/octet-stream\r\n\r\n";  
			body += bin + "\r\n";  
			body += '--' + boundary + '--';      
			xhr.setRequestHeader('content-type', 'multipart/form-data; boundary=' + boundary);
			// Firefox 3.6 provides a feature sendAsBinary ()
			if(xhr.sendAsBinary != null) { 
				xhr.sendAsBinary(body); 
				// Chrome 7 sends data but you must use the base64_decode on the PHP side
			} else {
				xhr.open('POST', 'backend.php?action=uploadFile&base64=ok&filename='+encodeURIComponent(name)+'&nonce='+nonce+'&TypeFile='+encodeURIComponent(type), true);
				xhr.setRequestHeader('UP-FILENAME', utf8_encode (name));
				xhr.setRequestHeader('UP-SIZE', size);
				xhr.setRequestHeader('UP-TYPE', type);
				//Encode BinaryString to base64
				if(reader.readAsBinaryString){
				   xhr.send(window.btoa(bin));
				}else{
				   xhr.send("fileExplorer="+window.btoa(bin));
				}
			}
		}
	}
}

function previewFotoPersonaDesaparecida(file, nonceFoto){
	// Preview
	var preview = new FileReader();
	preview.onloadend = function(){
		if(!$("#fotografiasPersonaDesaparecida").hasClass('procesando')){
			  $("#fotografiasPersonaDesaparecida").addClass("procesando");
			  $("#fotografiasPersonaDesaparecida").addClass("shown");
		  }
		  $("#fotografiasPersonaDesaparecida").find("p").remove();
		  $("#fotografiasPersonaDesaparecida").append('<div data-nonce="'+nonceFoto+'" class="foto pendienteSubir"><img src="'+preview.result+'"/><i class="fas fa-circle-notch"></i></div>');
	}
	preview.readAsDataURL(file);	
}
function readFotoPersonaDesaparecida(file, nonceFoto){
	var reader = new FileReader();
	var bin,name,type,size;
	
	reader.onload = (function(theFile) {
		return function(e) {
			name=theFile.name
			type=theFile.type
			size=theFile.size   
			
			if(reader.readAsBinaryString){
			   bin =e.target.result
			}else{
			   //Explorer
			   //Convert ArrayBuffer to BinaryString
				bin = "";
				bytes = new Uint8Array(reader.result);
				var length = bytes.byteLength;
				for(var i = 0; i < length; i++){
					bin += String.fromCharCode(bytes[i]);
				}	
			}
		};
	})(file);
	
	var loadEndFiles=function(e) {
		if(type.indexOf("image")<0){
			show_toast('Error','El archivo seleccionado no es una fotografía');
			$("#fotografiasPersonaDesaparecida .foto[data-nonce='"+nonceFoto+"']").remove();
		}else{
			fileObj=new Object();
			fileObj.name=name;
			fileObj.type=type;
			fileObj.size=size;
			fileObj.bin=bin;
			fileObj.nonce=nonceFoto;
			filesToUpload.push(fileObj);
		}
	}
	
	var loadErrorFiles=function(evt) {
		switch(evt.target.error.code) {
		  case evt.target.error.NOT_FOUND_ERR:
			  show_toast('Error','No se encontró el archivo!', 4000)
			break;
		  case evt.target.error.NOT_READABLE_ERR:
			  show_toast('Error','El archivo no es legible', 4000)
			break;
		  case evt.target.error.ABORT_ERR:
			break; // noop
		  default:
			  show_toast('Error','Ocurrió un error al leer el archivo', 4000)
		};
	}
	
	if(reader.readAsBinaryString){
		//Read in the image file as a binary string.
		reader.readAsBinaryString(file); 
	 }else{
		//Explorer
		//Contendrá los datos del archivo/objeto BLOB como un objeto ArrayBuffer.
		reader.readAsArrayBuffer(file)
	 }
	// Firefox 3.6, WebKit
	if(reader.addEventListener) { 
		//IE 10
		reader.addEventListener('loadend', loadEndFiles, false);
		// reader.addEventListener('loadstart', loadStartImg, false);
		if(status != null) {
			reader.addEventListener('error', loadErrorFiles, false);
		}
	// Chrome 7
	}else{ 
		reader.onloadend = loadEndFiles;
		// reader.onloadend = loadStartImg;
		if (status != null) {
			reader.onerror = loadErrorFiles;
		}
	}
}

function returnUploadQueueFotos(){
	if($("#fotografiasPersonaDesaparecida .foto.pendienteSubir").length>0){
		uploadQueueFotos();
	}else{
		if($("#fotografiasPersonaDesaparecida .foto.subiendo").length==0){
			window.onbeforeunload = null;
		}
	}
}

function showModalActo(Obj){
	Acto=$(Obj).find(".Objeto").val();
	Acto=JSON.parse(Acto);
	if(Acto.TipoActo=="Localización con vida"){
		modalLocalizadaConVida(Obj);
	}else if(Acto.TipoActo=="Localización sin vida"){
		modalLocalizadaSinVida(Obj);
	}else{
		modalActo(Obj);
	}
}

function modalLocalizadaConVida(Obj){
	var today = new Date();
	$("#modalLocalizadaConVida").modal("toggle");
	$("#modalLocalizadaConVida_personasDesaparecidas").html("");
	if($("div[data-tab='actos']").hasClass("readonly")){
		$("#modalLocalizadaConVida .modal-footer").hide();
	}else{
		$("#modalLocalizadaConVida .modal-footer").show();
	}
	for (let i = 0; i < caso.Personas.length; i++) {
		if(caso.Personas[i].RelacionCaso=="Desaparecida"){
			nombre="Sin Dato (Nombre persona desaparecida)";
			if(caso.Personas[i].Nombre){
				nombre=caso.Personas[i].Nombre;
			}
			$("#modalLocalizadaConVida_personasDesaparecidas").append('<div class="form-check form-check-inline">'
				+'<input class="form-check-input" type="checkbox" id="modalLocalizadaConVida_personaDesaparecida_'+caso.Personas[i].Id+'" value="'+caso.Personas[i].Id+'">'
				+'<label class="form-check-label" for="modalLocalizadaConVida_personaDesaparecida_'+caso.Personas[i].Id+'">'+nombre+'</label></div>');
		}
	}
	$("#fechaLocalizacionVida_anio").val(today.getFullYear());
	$("#fechaLocalizacionVida_mes opgion").prop("selected",false);
	$("#fechaLocalizacionVida_dia").val("");
	$("#localizaconConVida_Comentario").val("")
	if(Obj){
		Acto=$(Obj).find(".Objeto").val();
		Acto=JSON.parse(Acto);
		$("#modalLocalizadaConVida").attr("data-id",Acto.Id);
		$("#modalLocalizadaConVida").attr("data-nonce",$(Obj).attr("data-nonce"));
		for (let i = 0; i < Acto.IdsPersonas.length; i++) {
			$("#modalLocalizadaConVida_personasDesaparecidas input[value='"+Acto.IdsPersonas[i]+"']").prop("checked",true);
		}
		$("#fechaLocalizacionVida_anio").val(Acto.FechaActoIni.substr(0,4));
		if(Acto.ExactitudFechaActoIni=="month"){
			$("#fechaLocalizacionVida_mes option[value='"+Acto.FechaActoIni.substr(5,2)+"']").prop("selected",true);
		}
		if(Acto.ExactitudFechaActoIni=="day"){
			$("#fechaLocalizacionVida_mes option[value='"+Acto.FechaActoIni.substr(5,2)+"']").prop("selected",true);
			$("#fechaLocalizacionVida_dia").val(Acto.FechaActoIni.substr(8,2));
		}
		if(Acto.Data.Comentarios){
			$("#localizaconConVida_Comentario").val(Acto.Data.Comentarios);
		}
	}else{
		$("#modalSeleccionarActo").modal("toggle");
	}
}

function saveLocalizacionConVida(){
	var Acto=new Object();
	Acto.Id=$("#modalLocalizadaConVida").attr("data-id");
	Acto.Nonce=$("#modalLocalizadaConVida").attr("data-nonce");
	Acto.TipoActo="Localización con vida";
	Mes="01";
	Dia="01";
	Hora="00";
	Minutos="00";
	Detalle="month";
	ExactitudFechaActoIni="year";
	if($("#fechaLocalizacionVida_mes").val().length>0){
		Mes=$("#fechaLocalizacionVida_mes").val();
		ExactitudFechaActoIni="month";
	}
	if($("#fechaLocalizacionVida_dia").val().length>0){
		Dia=$("#fechaLocalizacionVida_dia").val();
		ExactitudFechaActoIni="day";
	}
	Acto.FechaActoIni=$("#fechaLocalizacionVida_anio").val()+"-"+Mes+"-"+Dia+" "+Hora+":"+Minutos+":00";
	Acto.ExactitudFechaActoIni=ExactitudFechaActoIni;
	Acto.IdsPersonas=new Array();
	$("#modalLocalizadaConVida_personasDesaparecidas input:checked").each(function(){
		Acto.IdsPersonas.push($(this).val());
	});
	Acto.Data=new Object();
	Acto.Data.Comentarios=$("#localizaconConVida_Comentario").val();
	parseActo(Acto);
	$("#modalLocalizadaConVida").modal("toggle");
}

function modalLocalizadaSinVida(Obj){
	var today = new Date();
	
	$("#modalLocalizadaSinVida").modal("toggle");
	$("#modalLocalizadaSinVida_personasDesaparecidas").html("");
	if($("div[data-tab='actos']").hasClass("readonly")){
		$("#modalLocalizadaSinVida .modal-footer").hide();
	}else{
		$("#modalLocalizadaSinVida .modal-footer").show();
	}
	for (let i = 0; i < caso.Personas.length; i++) {
		if(caso.Personas[i].RelacionCaso=="Desaparecida"){
			nombre="Sin Dato (Nombre persona desaparecida)";
			if(caso.Personas[i].Nombre){
				nombre=caso.Personas[i].Nombre;
			}
			$("#modalLocalizadaSinVida_personasDesaparecidas").append('<div class="form-check form-check-inline">'
				+'<input class="form-check-input" type="checkbox" id="modalLocalizadaSinVida_personaDesaparecida_'+caso.Personas[i].Id+'" value="'+caso.Personas[i].Id+'">'
				+'<label class="form-check-label" for="modalLocalizadaSinVida_personaDesaparecida_'+caso.Personas[i].Id+'">'+nombre+'</label></div>');
		}
	}
	$("#fechaLocalizacionSinVida_anio").val(today.getFullYear());
	$("#fechaLocalizacionSinVida_mes opgion").prop("selected",false);
	$("#fechaLocalizacionSinVida_dia").val("");
	$("#localizaconSinVida_Comentario").val("")
	if(Obj){
		Acto=$(Obj).find(".Objeto").val();
		Acto=JSON.parse(Acto);
		$("#modalLocalizadaSinVida").attr("data-id",Acto.Id);
		$("#modalLocalizadaSinVida").attr("data-nonce",$(Obj).attr("data-nonce"));
		for (let i = 0; i < Acto.IdsPersonas.length; i++) {
			$("#modalLocalizadaSinVida_personasDesaparecidas input[value='"+Acto.IdsPersonas[i]+"']").prop("checked",true);
		}
		$("#fechaLocalizacionSinVida_anio").val(Acto.FechaActoIni.substr(0,4));
		if(Acto.ExactitudFechaActoIni=="month"){
			$("#fechaLocalizacionSinVida_mes option[value='"+Acto.FechaActoIni.substr(5,2)+"']").prop("selected",true);
		}
		if(Acto.ExactitudFechaActoIni=="day"){
			$("#fechaLocalizacionSinVida_mes option[value='"+Acto.FechaActoIni.substr(5,2)+"']").prop("selected",true);
			$("#fechaLocalizacionSinVida_dia").val(Acto.FechaActoIni.substr(8,2));
		}
		if(Acto.Data.Comentarios){
			$("#localizaconSinVida_Comentario").val(Acto.Data.Comentarios);
		}
	}else{
		$("#modalSeleccionarActo").modal("toggle");
	}
}

function saveLocalizacionSinVida(){
	var Acto=new Object();
	Acto.Id=$("#modalLocalizadaSinVida").attr("data-id");
	Acto.Nonce=$("#modalLocalizadaSinVida").attr("data-nonce");
	Acto.TipoActo="Localización sin vida";
	Mes="01";
	Dia="01";
	Hora="00";
	Minutos="00";
	Detalle="month";
	ExactitudFechaActoIni="year";
	if($("#fechaLocalizacionSinVida_mes").val().length>0){
		Mes=$("#fechaLocalizacionSinVida_mes").val();
		ExactitudFechaActoIni="month";
	}
	if($("#fechaLocalizacionSinVida_dia").val().length>0){
		Dia=$("#fechaLocalizacionSinVida_dia").val();
		ExactitudFechaActoIni="day";
	}
	Acto.FechaActoIni=$("#fechaLocalizacionSinVida_anio").val()+"-"+Mes+"-"+Dia+" "+Hora+":"+Minutos+":00";
	Acto.ExactitudFechaActoIni=ExactitudFechaActoIni;
	Acto.IdsPersonas=new Array();
	$("#modalLocalizadaSinVida_personasDesaparecidas input:checked").each(function(){
		Acto.IdsPersonas.push($(this).val());
	});
	Acto.Data=new Object();
	Acto.Data.Comentarios=$("#localizaconSinVida_Comentario").val();
	parseActo(Acto);
	$("#modalLocalizadaSinVida").modal("toggle");
}


function modalDenunciaMP(){
	$("#modalDenunciaMP").modal("toggle");
	$("#modalDenunciaMP").attr("data-id",$("div[data-tab='denunciasReportes'] .ministerioPublico").attr("data-id"));
	$("#modalDenunciaMP input").prop("checked",false);
	if($("div[data-tab='denunciasReportes'] .ministerioPublico .realizada").attr("data-valor")==-1){
		$("#DenunciaMP_SinDato").prop("checked",true);
	}
	if($("div[data-tab='denunciasReportes'] .ministerioPublico .realizada").attr("data-valor")==0){
		$("#DenunciaMP_No").prop("checked",true);
	}
	if($("div[data-tab='denunciasReportes'] .ministerioPublico .realizada").attr("data-valor")==1){
		$("#DenunciaMP_Si").prop("checked",true);
	}
	autoridades=$("div[data-tab='denunciasReportes'] .ministerioPublico .autoridad").text();
	if(autoridades.length>0){
		autoridades=autoridades.split(",");
		for (let i = 0; i < autoridades.length; i++) {
			if(autoridades[i]=="federal"){
				$("#DenunciaMP_NivelFederal").prop("checked",true);
			}
			if(autoridades[i]=="local"){
				$("#DenunciaMP_NivelLocal").prop("checked",true);
			}
			if(autoridades[i]=="sinDato"){
				$("#DenunciaMP_NivelSinDato").prop("checked",true);
			}
		}
	}
	$("#DenunciaMP_Motivo").val($("div[data-tab='denunciasReportes'] .ministerioPublico .motivo").text());
}

function defaultMotivo(Obj){
	$(Obj).closest("div").find("textarea").val($(Obj).text());
}

function guardarDenunciaMP(){
	var Denuncia=new Object();
	Denuncia.Id=$("#modalDenunciaMP").attr("data-id");
	Denuncia.Tipo="MinisterioPublico";
	Denuncia.Realizada=-1;
	if($("#DenunciaMP_No").is(":checked")){
		Denuncia.Realizada=0;
	}
	if($("#DenunciaMP_Si").is(":checked")){
		Denuncia.Realizada=1;
	}
	Denuncia.Autoridad=new Array();
	if($("#DenunciaMP_NivelFederal").is(":checked")){
		Denuncia.Autoridad.push("federal");
	}
	if($("#DenunciaMP_NivelLocal").is(":checked")){
		Denuncia.Autoridad.push("local");
	}
	if($("#DenunciaMP_NivelSinDato").is(":checked")){
		Denuncia.Autoridad.push("sinDato");
	}
	Denuncia.Autoridad=Denuncia.Autoridad.join(",");
	Denuncia.RazonNoDenuncia=$("#DenunciaMP_Motivo").val();
	parseDenuncia(Denuncia);
	$("#modalDenunciaMP").modal("toggle");
}
function parseDenuncia(Denuncia){
	if(Denuncia.Tipo=="MinisterioPublico"){
		$("div[data-tab='denunciasReportes'] .ministerioPublico").attr("data-id",Denuncia.Id);
		$("div[data-tab='denunciasReportes'] .ministerioPublico .realizada").attr("data-valor",Denuncia.Realizada);
		$("div[data-tab='denunciasReportes'] .ministerioPublico .realizada").html("Sin dato");
		if(Denuncia.Realizada==0){
			$("div[data-tab='denunciasReportes'] .ministerioPublico .realizada").html("No");
		}
		if(Denuncia.Realizada==1){
			$("div[data-tab='denunciasReportes'] .ministerioPublico .realizada").html("Sí");
		}
		$("div[data-tab='denunciasReportes'] .ministerioPublico .autoridad").html(Denuncia.Autoridad);
		$("div[data-tab='denunciasReportes'] .ministerioPublico .motivo").html(Denuncia.RazonNoDenuncia);
	}
	if(Denuncia.Tipo=="ComisionBusqueda"){
		$("div[data-tab='denunciasReportes'] .comisionBusqueda").attr("data-id",Denuncia.Id);
		$("div[data-tab='denunciasReportes'] .comisionBusqueda .realizada").attr("data-valor",Denuncia.Realizada);
		$("div[data-tab='denunciasReportes'] .comisionBusqueda .realizada").html("Sin dato");
		if(Denuncia.Realizada==0){
			$("div[data-tab='denunciasReportes'] .comisionBusqueda .realizada").html("No");
		}
		if(Denuncia.Realizada==1){
			$("div[data-tab='denunciasReportes'] .comisionBusqueda .realizada").html("Sí");
		}
		$("div[data-tab='denunciasReportes'] .comisionBusqueda .autoridad").html(Denuncia.Autoridad);
		$("div[data-tab='denunciasReportes'] .comisionBusqueda .motivo").html(Denuncia.RazonNoDenuncia);
	}
}
function modalReporteCB(){
	$("#modalReporteCB").modal("toggle");
	$("#modalReporteCB").attr("data-id",$("div[data-tab='denunciasReportes'] .comisionBusqueda").attr("data-id"));
	$("#modalReporteCB input").prop("checked",false);
	if($("div[data-tab='denunciasReportes'] .comisionBusqueda .realizada").attr("data-valor")==-1){
		$("#ReporteCB_SinDato").prop("checked",true);
	}
	if($("div[data-tab='denunciasReportes'] .comisionBusqueda .realizada").attr("data-valor")==0){
		$("#ReporteCB_No").prop("checked",true);
	}
	if($("div[data-tab='denunciasReportes'] .comisionBusqueda .realizada").attr("data-valor")==1){
		$("#ReporteCB_Si").prop("checked",true);
	}
	autoridades=$("div[data-tab='denunciasReportes'] .comisionBusqueda .autoridad").text();
	if(autoridades.length>0){
		autoridades=autoridades.split(",");
		for (let i = 0; i < autoridades.length; i++) {
			if(autoridades[i]=="federal"){
				$("#ReporteCB_NivelFederal").prop("checked",true);
			}
			if(autoridades[i]=="local"){
				$("#ReporteCB_NivelLocal").prop("checked",true);
			}
			if(autoridades[i]=="sinDato"){
				$("#ReporteCB_NivelSinDato").prop("checked",true);
			}
		}
	}
	$("#ReporteCB_Motivo").val($("div[data-tab='denunciasReportes'] .comisionBusqueda .motivo").text());
}
function guardarReporteCB(){
	var Denuncia=new Object();
	Denuncia.Id=$("#modalReporteCB").attr("data-id");
	Denuncia.Tipo="ComisionBusqueda";
	Denuncia.Realizada=-1;
	if($("#ReporteCB_No").is(":checked")){
		Denuncia.Realizada=0;
	}
	if($("#ReporteCB_Si").is(":checked")){
		Denuncia.Realizada=1;
	}
	Denuncia.Autoridad=new Array();
	if($("#ReporteCB_NivelFederal").is(":checked")){
		Denuncia.Autoridad.push("federal");
	}
	if($("#ReporteCB_NivelLocal").is(":checked")){
		Denuncia.Autoridad.push("local");
	}
	if($("#ReporteCB_NivelSinDato").is(":checked")){
		Denuncia.Autoridad.push("sinDato");
	}
	Denuncia.Autoridad=Denuncia.Autoridad.join(",");
	Denuncia.RazonNoDenuncia=$("#ReporteCB_Motivo").val();
	parseDenuncia(Denuncia);
	$("#modalReporteCB").modal("toggle");
}
function modalAtencion(Obj){
	var today = new Date();
	$("#modalAtencion").modal("toggle");
	$("#modalAtencion").attr("data-id","");
	$("#modalAtencion").attr("data-nonce","");
	$("#atencionAnio").val(today.getFullYear());
	$("#atencionMes option").prop("selected",false);
	mes=today.getMonth()+1;
	mes=""+mes;
	if(mes.length<2){
		mes="0"+mes;
	}
	$("#atencionMes option[value='"+mes+"']").prop("selected",true);
	$("#atencionDia").val(today.getDay());
	$("#atencionRealiza").val("");
	$("#descripcionAtencion").val("");
	$("#modalAtencion input[type='checkbox']").prop("checked",false);
	if(Obj){
		Atencion=$(Obj).find(".Objeto").val();
		Atencion=JSON.parse(Atencion);
		$("#modalAtencion").attr("data-id",Atencion.Id);
		$("#modalAtencion").attr("data-nonce",$(Obj).attr("data-nonce"));
		$("#atencionAnio").val(Atencion.FechaAtencion.substr(0,4));
		$("#atencionMes option[value='"+Atencion.FechaAtencion.substr(5,2)+"']").prop("selected",true);
		$("#atencionDia").val(Atencion.FechaAtencion.substr(8,2));
		$("#atencionRealiza").val(Atencion.Atendio);
		$("#descripcionAtencion").val(Atencion.Descripcion);
		canalizacion=Atencion.Canalizacion.split(",");
		for (let i = 0; i < canalizacion.length; i++) {
			$("#modalAtencion input[value='"+canalizacion[i]+"']").prop("checked",true);
		}
		accion=Atencion.AccionRealizada.split(",");
		for (let i = 0; i < accion.length; i++) {
			$("#modalAtencion input[value='"+accion[i]+"']").prop("checked",true);
		}
	}
}
function saveAtencion(){
	var atencion=new Object();
	atencion.Id=$("#modalAtencion").attr("data-id");
	atencion.Nonce=$("#modalAtencion").attr("data-nonce");
	//atencion.Canal=
	Mes="01";
	Dia="01";
	if($("#atencionMes").val().length>0){
		Mes=$("#atencionMes").val();
	}
	if($("#atencionDia").val().length>0){
		Dia=$("#atencionDia").val();
	}
	atencion.FechaAtencion=$("#atencionAnio").val()+"-"+Mes+"-"+Dia;
	atencion.Atendio=$("#atencionRealiza").val();
	AccionRealizada=new Array();
	$("#modalAtencion .AccionRealizada input:checked").each(function(){
		AccionRealizada.push($(this).val());
	});
	atencion.AccionRealizada=AccionRealizada.join(",");
	atencion.Descripcion=$("#descripcionAtencion").val();
	Canalizacion=new Array();
	$("#modalAtencion .Canalizacion input:checked").each(function(){
		Canalizacion.push($(this).val());
	});
	atencion.Canalizacion=Canalizacion.join(",");
	$("#modalAtencion").modal("toggle");
	parseAtencion(atencion);
}

function parseAtencion(atencion){
	if(!atencion.Nonce){
		atencion.Nonce=nonce();
	}
	if(atencion.Id>0){
		if($("#listadoAtenciones li[data-id='"+atencion.Id+"']").length>0){
			atencion.Nonce=$("#listadoAtenciones li[data-id='"+atencion.Id+"']").attr("data-nonce");
		}
	}
	if($("#listadoAtenciones li[data-nonce='"+atencion.Nonce+"']").length==0){
		$("#listadoAtenciones").append('<li data-nonce="'+atencion.Nonce+'" data-id="'+atencion.Id+'" onclick="modalAtencion(this)"></li>');
	}
	str='';
	var atenciones=new Array();
	acciones=atencion.AccionRealizada.split(",");
	for (let i = 0; i < acciones.length; i++) {
		atenciones.push($("#modalAtencion .AccionRealizada input[value='"+acciones[i]+"']").closest(".form-check").find("label").text());
	}
	str+='<p class="accion">'+atenciones.join(", ")+'</p>';
	str+='<p class="fecha">'+atencion.FechaAtencion.substr(0,10)+'</p>';
	str+='<textarea class="Objeto">'+JSON.stringify(atencion)+'</textarea>'
	$("#listadoAtenciones li[data-nonce='"+atencion.Nonce+"']").html(str);
}

function showListAtendio(){
	$("#listAtendio").show();
}

function hideListAtendio(){
	$("#listAtendio").hide();
}

function setAtendio(Obj){
	$("#atencionRealiza").val($(Obj).text());
	$("#listAtendio").hide();
	$("#descripcionAtencion").focus();
}
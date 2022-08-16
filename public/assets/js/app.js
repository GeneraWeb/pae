var toastObj
$(document).ready(function(){
	checarSesion();
	toastObj=$('#toastList .toast').clone();
	$('#toastList').html("");
	$(".sugerenciasInput input").focus(function(){
		if(!$(this).prop("readonly")){
			$(this).closest(".sugerenciasInput").find(".listaSugerencias").show();
			filtrarSugerenciasInput($(this));
		}
	});
	$(".sugerenciasInput input").change(function(){
		$(this).closest(".sugerenciasInput").find(".listaSugerencias").hide();
	});
	$(".sugerenciasInput input").keyup(function(){
		filtrarSugerenciasInput($(this));
	});
	$(".sugerenciasInput .listaSugerencias li").click(function(){
		$(this).closest(".sugerenciasInput").find("input").val($(this).text());
		$(this).closest(".sugerenciasInput").find(".listaSugerencias").hide();
	})
	$("#buscadorInput").keyup(function(){
		buscarCaso();
	});
})

function nonce(length=13) {
	var result           = '';
	var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	var charactersLength = characters.length;
	for ( var i = 0; i < length; i++ ) {
	  result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   return result;
}

function filtrarSugerenciasInput(Input){
	if($(Input).val().length>0){
		$(Input).closest(".sugerenciasInput").find(".listaSugerencias li").each(function(){
			if($(this).text().toUpperCase().indexOf($(Input).val().toUpperCase())>=0){
				$(this).show();
			}else{
				$(this).hide();
			}
		});
	}else{
		$(Input).closest(".sugerenciasInput").find(".listaSugerencias li").show();
	}
}

function show_toast(titulo,texto){
	var clonedToast=$("#toastList").append(toastObj.clone());
	clonedToast.find(".mr-auto").html(titulo);
	clonedToast.find(".toast-body").html(texto);
	clonedToast.find(".toast").toast('show').on('hidden.bs.toast', function () {
		$(this).remove();
	})
}

function checarSesion(){
	var params=new Object();
	params.action="checarSesion";
	$.post("backend",params,function(resp){
		if(!resp.result){
			window.location.href="login?noSession";
		}else{
			setTimeout(function(){
				checarSesion()
			},2000);
		}
	},"json")
	.fail(function(){
		window.location.href="login?failAuth";
	})
}

function toggleSearch(){
	$("#buscadorForm").toggleClass("activo")
}

function buscarCaso(){
	if($("#buscadorInput").val().trim().length>0){
		var params=new Object();
		params.action="buscarCaso";
		params.buscar=$("#buscadorInput").val().trim();
		$.post("/backend",params,function(resp){
			if(resp.busqueda.toUpperCase()==$("#buscadorInput").val().trim().toUpperCase()){
				if(resp.casos.length>0){
					$("#resultados_buscadorForm").html("");
					for (let i = 0; i < resp.casos.length; i++) {
						liga='/atencion?id='+resp.casos[i].Id;
						if(resp.casos[i].ParteDelColectivo==1){
							liga='/caso?id='+resp.casos[i].Id;
						}
						$("#resultados_buscadorForm").append('<a href="'+liga+'"><li>'+resp.casos[i].Id+' - '+resp.casos[i].Nombre+'</li></a>');
					}
				}else{
					$("#resultados_buscadorForm").html('<li class="nota">No se encontraron casos.</li>');
				}
				$("#resultados_buscadorForm").show();
			}
		},"json")
	}else{
		$("#resultados_buscadorForm").html("");
		$("#resultados_buscadorForm").hide();
	}
}
function utf8_encode(argString) {
	//  discuss at: http://phpjs.org/functions/utf8_encode/
	// original by: Webtoolkit.info (http://www.webtoolkit.info/)
	// improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// improved by: sowberry
	// improved by: Jack
	// improved by: Yves Sucaet
	// improved by: kirilloid
	// bugfixed by: Onno Marsman
	// bugfixed by: Onno Marsman
	// bugfixed by: Ulrich
	// bugfixed by: Rafal Kukawski
	// bugfixed by: kirilloid
	//   example 1: utf8_encode('Kevin van Zonneveld');
	//   returns 1: 'Kevin van Zonneveld'
	
	if (argString === null || typeof argString === 'undefined') {
		return '';
	}
	
	var string = (argString + ''); // .replace(/\r\n/g, "\n").replace(/\r/g, "\n");
	var utftext = '',
	start, end, stringl = 0;
	
	start = end = 0;
	stringl = string.length;
	for (var n = 0; n < stringl; n++) {
		var c1 = string.charCodeAt(n);
		var enc = null;
		
		if (c1 < 128) {
			end++;
		} else if (c1 > 127 && c1 < 2048) {
			enc = String.fromCharCode(
				(c1 >> 6) | 192, (c1 & 63) | 128
			);
		} else if ((c1 & 0xF800) != 0xD800) {
			enc = String.fromCharCode(
				(c1 >> 12) | 224, ((c1 >> 6) & 63) | 128, (c1 & 63) | 128
			);
		} else { // surrogate pairs
			if ((c1 & 0xFC00) != 0xD800) {
				throw new RangeError('Unmatched trail surrogate at ' + n);
			}
			var c2 = string.charCodeAt(++n);
			if ((c2 & 0xFC00) != 0xDC00) {
				throw new RangeError('Unmatched lead surrogate at ' + (n - 1));
			}
			c1 = ((c1 & 0x3FF) << 10) + (c2 & 0x3FF) + 0x10000;
			enc = String.fromCharCode(
				(c1 >> 18) | 240, ((c1 >> 12) & 63) | 128, ((c1 >> 6) & 63) | 128, (c1 & 63) | 128
			);
		}
		if (enc !== null) {
			if (end > start) {
			utftext += string.slice(start, end);
			}
			utftext += enc;
			start = end = n + 1;
		}
	}
	
	if (end > start) {
		utftext += string.slice(start, stringl);
	}
	
	return utftext;
}
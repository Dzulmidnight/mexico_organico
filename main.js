$(document).on('ready', funcPrincipal);

function funcPrincipal(){
	$('#miForm').on('submit', ejecutarAjax);
}
function funcVerificar(){
	var valorEscrito = $('#correo_electronico').val();
	var id_capacitacion = $('#id_capacitacion').val();

	$.post("verificarCorreo.php", function(data){
		var respuesta;
		if(data == "0"){
			respuesta = "ESTE CORREO YA ESTA EN USO";
		}else{
			respuesta = "este correo esta disponible"
		}

		$('#divMostrar').text(respuesta);
	})
}

function ejecutarAjax(event){

	var datosEnviados = 
	{
		'correo_electronico': $('#correo_electronico').val(),
		'lada': $('#lada').val(),
		'telefono': $('#telefono').val(),
		'nombre': $('#nombre').val(),
		'apellido_paterno': $('#apellido_paterno').val(),
		'apellido_materno': $('#apellido_materno').val(),
		'empresa': $('#empresa').val(),
		'comentario': $('#comentario').val(),
		'correo_capacitacion': $('#correo_capacitacion').val(),
		'telefono_capacitacion': $('#correo_electronico').val(),
		'fecha_registro': $('#fecha_registro').val(),
		'id_capacitacion': $('#id_capacitacion').val(),
		'titulo': $('#titulo').val()

	}

	$.ajax({
		type: 'POST',
		url: 'registrarUsuario.php',
		data: datosEnviados,
		dataType: 'json',
		encode: true
	})
	.done(function(datos){
		// Especificar como actuar con los datos recibidos
		if( datos.exito){
			alert( datos.mensaje)
		}else{
			if(datos.errores.correo_electronico){
				document.getElementById('divMostrar').innerHTML = datos.errores.correo_electronico
			}
		}
	});
	event.preventDefault();
}
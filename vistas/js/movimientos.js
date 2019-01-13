$(document).ready(function() {
	
		setInterval(function() {
		var notificacion="";
		var datos = new FormData();
		datos.append("nuemroNotificacion", notificacion);
		$.ajax({
			url:"ajax/movimientos.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(respuesta){
					$("#numero").attr('notificacion', respuesta["id"]);

					var notificacionAntigua= $(this).attr('notificacion');
					var notificacionActual=respuesta["id"];

				if (notificacionActual==notificacionAntigua){
					console.log(notificacionActual);
					console.log(notificacionAntigua);
					console.log("no hay nueva notificacion");

				}else{
					console.log("actual "+notificacionActual);
					console.log("antigua "+notificacionAntigua);
					
					// $("#numero").append(respuesta["id"]);
					
					
				}

				
			}
	
		});
			
		},"30000");
		
		
	
});
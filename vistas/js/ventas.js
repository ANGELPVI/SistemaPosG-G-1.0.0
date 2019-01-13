/*=============================================
MOSTRAR LOS PRODUCTOS A VENDER
=============================================*/
$(document).ready(function() {
	var item=1;
	var datos=new FormData();
	datos.append('valor',item);

	$.ajax({

	  url: 'ajax/datatable-ventas.ajax.php',
	  type: 'POST',
	  data:datos,
	  cache:'false',
	  contentType:false,
	  processData:false,
	  dataType: 'json',
	  success: function(respuesta) {
	  	console.log(respuesta["id_carrito_producto"]);
	  }
	});

});

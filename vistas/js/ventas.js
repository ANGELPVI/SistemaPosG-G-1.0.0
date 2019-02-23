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

/*=============================================
MOSTRAR LAS VENTANAS MODALES POR COMBINACIÓN DE TECLAS
=============================================*/
document.addEventListener("keydown", function(e){
	 if (e.ctrlKey && (e.which===66)){
		$("#modalCopiasBN").modal("toggle");
	 }else if (e.ctrlKey && (e.which===67)){
	 	$("#modalCopiasColor").modal("toggle");
	 }else if (e.ctrlKey && (e.which===112)){
	 	$("#modalImpresionBN").modal("toggle");
	 }else if(e.ctrlKey && (e.which===113)){
	 	$("#modalImpresionColor").modal("toggle");
	 }else if (e.ctrlKey && (e.which===114)) {
	 	$("#modalProductoExtenso").modal("toggle");
	 }
});

/*=============================================
VALIDAR EL FORMULARIO DE COPIAS BLANCO Y NEGRO
=============================================*/
$("#formCopiasBN").submit(function(e){
	console.log("hola");
	e.preventDefault();
});

$("#formCopiasColor").submit(function(e){
	console.log("Hola del formulario copias color");
	e.preventDefault();
});

$("#formImprecionBN").submit(function(e){
	console.log("Hola del formulario imprecion B/N");
	e.preventDefault();
});

$("#formImprecionColor").submit(function(e){
	console.log("Hola del formulario imprecion color");
	e.preventDefault();
});

$("#formProductoExtenso").submit(function(e){
	console.log("Hola del formulario producto extenso");
	e.preventDefault();
});


/*=============================================
BUSCAR PRODUCTO POR NOMBRE O CODIGO CON EL PANEL DE CONTROL
=============================================*/
$("#busquedaProducto").keyup(function(e){
	var buscar=$("#busquedaProducto").val();
	if (buscar!=""){
		var codigo=e.which;
		var letras=String.fromCharCode(codigo);	
		var datos=new FormData();
		datos.append('letras',letras);
		$.ajax({
			  url:"ajax/crearVenta.ajax.php",
		      method: "POST",
		      data: datos,
		      cache: false,
		      contentType: false,
		      processData: false,
		      dataType:"json",
		      success:function(respuesta){
		      		for(var i in respuesta){
		      			$(".productos").html(respuesta[i].descripcion);
		      		}

		      }
		});

	}else{
		$(".productos").html("");
	}
	
});


 
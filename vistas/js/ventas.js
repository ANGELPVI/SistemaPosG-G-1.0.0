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
								if (respuesta[i].stock==="0"){
									$(".list-group").append('<li class="list-group-item disabled">'+respuesta[i].descripcion+'<span class="badge badge-danger badge-pill">'+respuesta[i].stock+'</span></li>');
								}else{
									$(".list-group").append('<a href="#" class="list-group-item list-group-item-action active" data-co="'+respuesta[i].id+'">'+respuesta[i].descripcion+'<span class="badge badge-primary badge-pill">'+respuesta[i].stock+'</span></a>');
								}

							}
		      }
		});

	}else{
		$("a").remove(".list-group-item-action");
		$("li").remove(".list-group-item");
	}

});


/*=============================================
AGREGAR PRODUCTO AL CARRITO DE COMPRA
=============================================*/
$(".list-group").on('click',"a",function(){
	var id_usua=$("#id_usuario_venta").val();
	var codigo=$(this).attr('data-co');

	var datos=new FormData();
	datos.append('codigoProdu', codigo);
	datos.append('idUsua',id_usua);
	$.ajax({
			url:"ajax/crearVenta.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType:"text",
			success:function(resp){
					//console.log(resp);
					$("#busquedaProducto").val('');
					$("a").remove(".list-group-item-action");
					$("li").remove(".list-group-item");
					datos_venta();
			}

	});

});


/*=============================================
MOSTRAR LOS PRODUCTOS A VENDER
=============================================*/
function datos_venta(){
	var idUsuaVenta=$("#id_usuario_venta").val();
	var datos=new FormData();
	datos.append('idUsuaVenta',idUsuaVenta);
	$.ajax({
			url:"ajax/crearVenta.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success:function(resp){
				$("#productosVentas").html(resp);

			}
	});
}
datos_venta();

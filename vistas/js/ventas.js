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
									$(".list-group").append('<a href="#" style="border-top:2px solid #ffffff" class="list-group-item list-group-item-action active" data-co="'+respuesta[i].id+'">'+respuesta[i].descripcion+'<span class="badge badge-primary badge-pill">'+respuesta[i].stock+'</span></a>');
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
					totalVenta();
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

/*=============================================
MOSTRAR EL TOTAL DE VENTA
=============================================*/
function totalVenta(){
	var idUsuaVenta=$("#id_usuario_venta").val();
	var datos=new FormData();
	datos.append('totalVenta',idUsuaVenta);
	$.ajax({
			url:"ajax/crearVenta.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success:function(resp){
				$("#totalVenta").html(resp);

			}
	});
}
totalVenta();
/*=============================================
ELIMINAR PRODUCTO DEL CARRITO DE COMPRA
=============================================*/
$("#productosVentas").on('click','.btn-danger', function(){
	var pregunta="eliminar";
	var producto=$(this).attr('data-idProduc');
	var vendedor=$(this).attr('data-idVendedor');

	var datos=new FormData();
	datos.append('producto',producto);
	datos.append('vendedor',vendedor);
	datos.append('pregunta',pregunta);
	$.ajax({
			url:"ajax/crearVenta.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success:function(resp){
				datos_venta();
				totalVenta();

			}
	});

});

/*=============================================
AGREGAR PRODUCTO CON EL BOTÓN
=============================================*/
$("#productosVentas").on('click','.btn-success', function(){
	var pregunta="agregar";
	var producto=$(this).attr('data-agreIdProduc');
	var vendedor=$(this).attr('data-agreIdVendedor');

	var datos=new FormData();
	datos.append('producto',producto);
	datos.append('vendedor',vendedor);
	datos.append('pregunta',pregunta);
	$.ajax({
			url:"ajax/crearVenta.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success:function(resp){
				datos_venta();
				totalVenta();

			}
	});

});

/*=============================================
AGREGAR PRODUCTO POR CODIGO DE BARRA
=============================================*/
$("#formCodigo").submit(function(e){
	var codigo=$("#porCodigo").val();
	var vendedor=$("#id_usuario_venta").val();
	var datos=new FormData();
	datos.append("codi", codigo);
	datos.append("ven", vendedor);
	$.ajax({
			url:"ajax/crearVenta.ajax.php",
			method:"POST",
			data:datos,
			cache:false,
			contentType:false,
			processData:false,
			success:function(resp){
				if (resp=="ok") {
					datos_venta();
					totalVenta();
					$("#porCodigo").val('');
				}else{
					$("#porCodigo").val('');
					$(".text-danger").removeAttr("style");
					$(".text-danger").hide(10000);

				}

			}

	});
e.preventDefault();
});

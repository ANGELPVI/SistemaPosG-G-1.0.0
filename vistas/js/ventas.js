/*=============================================
MOSTRAR LAS VENTANAS MODALES POR COMBINACIÓN DE TECLAS
=============================================*/
document.addEventListener("keydown", function(e){
		 if (e.ctrlKey && (e.which===112)){
			$("#modalCopiasBN").modal("toggle");
		}

		if (e.ctrlKey && (e.which===113)){
		 $("#modalMenbrecias").modal("toggle");
	 }

});

/*=============================================
VENTA POR MAYOREO
=============================================*/
$("#formCopiasBN").submit(function(e){
	var codigoMayoreo=$("#producto").val();
	var id_usua=$("#id_usuario_venta").val();
	var cantidad=$("#inputCantidad").val();
	var total=$("#inputTotal").val();
	var descuentosPorMembrecia=$("#inputMembreciaAplicado").val();
	var datos=new FormData();
	datos.append('codigoProduMayoreo',codigoMayoreo);
	datos.append('idUsuaMayoreo',id_usua);
	datos.append('cantidad',cantidad);
	datos.append('total',total);
	datos.append('ventaMayoreoMem',descuentosPorMembrecia);

	$.ajax({
			url:"ajax/crearVenta.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success:function(resp){
					if (resp==="ok"){
						$("#producto").val('');
						$("#inputCantidad").val('');
						$("#inputTotal").val('');
						$(".alertaMayoreo").css("displey","none");
						datos_venta();
						totalVenta();
					}else if(resp==="insuficiente"){
					$("#producto").val('');
					$("#inputCantidad").val('');
					$("#inputTotal").val('');
					$(".alertaMayoreo").show(1000);
				}
		}
	});

	e.preventDefault();
});
/*=============================================
QUITAR ALERTA DE ERROR EN VENTA POR MAYOREO
=============================================*/
$("#producto").change(function(){
	$(".alertaMayoreo").hide(1000);
	$(".alerDeseleccion").hide(1000);
});

/*=============================================
SACAR EL TOTAL A PAGAR POR PRODUCTO POR MAYOREO
=============================================*/
$("#inputCantidad").change(function(){
	var multipicar=0;
	var producto=$("#producto").val();
	var cantidadMayoreo=$("#inputCantidad").val();
	var descuentosPorMembrecia=$("#inputMembreciaAplicado").val();
	var total=$("#inputTotal").val('');
	var dato=new FormData();
	dato.append('mayoreoProducto',producto);
	$.ajax({
			url:"ajax/crearVenta.ajax.php",
			method: "POST",
			data: dato,
			cache: false,
			contentType: false,
			processData: false,
			success:function(resp){
				if (cantidadMayoreo!=""&&/^([0-9])*$/.test(cantidadMayoreo)&&producto!=null){
					if (descuentosPorMembrecia!=""){
						  var totalSinMem=resp*cantidadMayoreo;
							var porcentaje=mem/100;
							var mult=totalSinMem*porcentaje;
							var totalMenbre=totalSinMem-mult;
							$("#inputTotal").val(totalMenbre);
					}else{
						multipicar=parseFloat(cantidadMayoreo)*parseFloat(resp);
						$("#inputTotal").val(Math.round(multipicar));
					}

				}else{
					$("#inputCantidad").val('');
					$("#inputTotal").val('');
					$(".alerDeseleccion").show(1000);
				}

			}
	});
});
/*=============================================
RESETIAR EL FORMULARIO DE VENTA POR MAYOREO
=============================================*/
$(".btn-defaul").click(function(){
	$("#producto").val('');
	$("#inputCantidad").val('');
	$("#inputTotal").val('');
	$(".alertaMayoreo").hide();
	$(".alerDeseleccion").hide();
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
	var descuentosPorMembrecia=$("#inputMembreciaAplicado").val();
	var datos=new FormData();
	datos.append('codigoProdu', codigo);
	datos.append('idUsua',id_usua);
	datos.append('membreciaPorBusqueda',descuentosPorMembrecia);
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
					console.log(resp);
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
$("#productosVentas").on('click','.btn-warning', function(){
	var pregunta="eliminar";
	var producto=$(this).attr('data-idProduc');
	var vendedor=$(this).attr('data-idVendedor');
	var descuentosPorMembrecia=$("#inputMembreciaAplicado").val();
	var datos=new FormData();
	datos.append('producto',producto);
	datos.append('vendedor',vendedor);
	datos.append('pregunta',pregunta);
	datos.append('pregunta',pregunta);
	datos.append('agregarBotonMen',descuentosPorMembrecia);
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
ELIMINAR PRODUCTO DEL CARRITO DE COMPRA POR MAYOREO
=============================================*/
$("#productosVentas").on('click','.btn-danger', function(){
	var vendedor=$(this).attr('data-vendedor');
	var producto=$(this).attr('data-producto');
	var cantidad=$(this).attr('data-cantidad');
	datos=new FormData();
	datos.append('eliminarVendedorMayoreo',vendedor);
	datos.append('eliminarProductoMayoreo',producto);
	datos.append('eliminarCantidadMayoreo',cantidad);
	$.ajax({
			url:"ajax/crearVenta.ajax.php",
			method:"POST",
			data:datos,
			cache:false,
			contentType:false,
			processData:false,
			dataType:'text',
			success:function(resp){
				console.log(resp);
				datos_venta();
				totalVenta();
			}
	});



})

/*=============================================
AGREGAR PRODUCTO CON EL BOTÓN
=============================================*/
$("#productosVentas").on('click','.btn-success', function(){
	var pregunta="agregar";
	var producto=$(this).attr('data-agreIdProduc');
	var vendedor=$(this).attr('data-agreIdVendedor');
	var descuentosPorMembrecia=$("#inputMembreciaAplicado").val();
	var datos=new FormData();
	datos.append('producto',producto);
	datos.append('vendedor',vendedor);
	datos.append('pregunta',pregunta);
	datos.append('agregarBotonMen',descuentosPorMembrecia);
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
	var descuentosPorMembrecia=$("#inputMembreciaAplicado").val();
	var vendedor=$("#id_usuario_venta").val();
	var datos=new FormData();
	datos.append("codi", codigo);
	datos.append("ven", vendedor);
	datos.append("descuentoMembre",descuentosPorMembrecia);
	console.log(descuentosPorMembrecia);
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
					console.log(resp);
				}

			}

	});
e.preventDefault();
});


/*=============================================
CONCRETAR VENTA
=============================================*/
document.addEventListener("keydown", function(e){
	var vendedor=$("#id_usuario_venta").val();
	var cobrar=$("#cobrarVenta").val();
	var productos='';
	var datos=new FormData();
	datos.append("concretarVendedor",vendedor);
	if ((e.which===120)){
		if (cobrar!=""&&/^([0-9])*$/.test(cobrar)){
			$("#cobrarVenta").val('');
			$("#porCodigo").val('')
			$("#busquedaProducto").val('');
			$("#cambio").text("Cambio:");
			$("#cobrarVenta").attr('disabled',"true");
			$("#porCodigo").attr('disabled',"true");
			$("#busquedaProducto").attr('disabled','true');
			$.ajax({
			    url:"ajax/crearVenta.ajax.php",
			    method:"POST",
			    data:datos,
			    cache:false,
			    contentType:false,
			    processData:false,
			    dataType:"json",
			    success:function(resp){
			      // Otro ajax para insertar
			      productos=JSON.stringify(resp);
			      var datosV=new FormData();
			      datosV.append("cV",vendedor);
			      datosV.append("coleccion",productos);
			      $.ajax({
			        url:"ajax/crearVenta.ajax.php",
			        method:"POST",
			        data:datosV,
			        cache:false,
			        contentType:false,
			        processData:false,
			        success:function(respuestas){
			            if (respuestas==="ok") {
			              $(".progress").show();
			              $(".progress-bar").css("transition","all 2s ease .5s");
			              $(".progress-bar").css("width","100%");
			                setTimeout(function(){
			                  $(".progress").hide();
			                  datos_venta();
			                  totalVenta();
			                  $(".progress-bar").css("width","0%");
			                  $("#cobrarVenta").removeAttr("disabled");
			                  $("#porCodigo").removeAttr("disabled");
			                  $("#busquedaProducto").removeAttr("disabled");
			                }, 3000);
			            }else{
			              $(".alert").show(1000);
			              $("#cobrarVenta").removeAttr("disabled");
			              $("#porCodigo").removeAttr("disabled");
			              $("#busquedaProducto").removeAttr("disabled");

			            }
			        }

			      });
			      // -------------------
			    }
			});

		}else{
				$(".alert").show(1000);
				$("#cobrarVenta").css("border","solid 1px red");

		}
	}
});
/*=============================================
QUITAR ERROR POR NO REGUISTRAR PRODUCTOS
=============================================*/
$("#cobrarVenta").click(function(){
	$(".alert-danger").hide(1000);
	 $("#cobrarVenta").removeAttr("style");
});


/*=============================================
OPERACIONES DE COBRO Y CAMBIO DE LA VENTA
=============================================*/
$("#cobrarVenta").change(function(){
	var cobrar=$("#cobrarVenta").val();
	var total=$("#totalV").text();
		if (/^([0-9])*$/.test(cobrar)&&cobrar!=""){
				var resta=0;
				var resta=parseFloat(resta);
				var totalV=parseFloat(total);
				var cobrar=parseFloat(cobrar);
				if (cobrar>=totalV){
					resta=parseFloat(cobrar)-parseFloat(totalV);
					var resultado=parseFloat(resultado);
					$("#cambio").text("Cambio: $"+resta);
				}else{
					console.log("Es mallor lo que estas vendiendo");
				}

		}else{
		$("#cambio").text("Cambio:");
		}
});

/*=============================================
OBTENER DATOS DE LA MEMBRECIA
=============================================*/
var mem=0;
var ifeMenbrecia=0;
$("#inputMembrecia").change(function(){
	var membrecia=$("#inputMembrecia").val();
	if (/^([0-9])*$/.test(membrecia) && membrecia!=''){
		var datos=new FormData();
		datos.append("membrecia", membrecia);
		$.ajax({
				url:"ajax/crearVenta.ajax.php",
				method:"POST",
				data:datos,
				cache:false,
				contentType:false,
				processData:false,
				dataType:"json",
				success:function(resp){
					mem= resp['descuento'];
					ifeMenbrecia=resp["ife"];
					if (resp['ife']===undefined) {
					$(".alertaErrorMembrecia").show(1000);
						$("#inputMembrecia").val('');
					}else{
						$("#inputMembrecia").val('');
						$('.nombre').text('NOMBRE: '+resp['nombre']);
						$('.ife').text('IFE: '+resp['ife']);
						$('.correo').text('CORREO: '+resp['email']);
						$('.tel').text('TEL: '+resp['telefono']);
						$(".descuento").text('DESCUENTOS: %'+ resp['descuento']);
					}

				}
		});
	}else{
		$(".alertaError").show(1000);
		$("#inputMembrecia").val('');
	}
});
/*=============================================
QUITAR ALERTAS DE ERROR EN BUSQUEDA DE MEMBRECIA
=============================================*/
$("#inputMembrecia").click(function(){
	$(".alertaError").hide(1000);
	$(".alertaErrorMembrecia").hide(1000);
});

/*=============================================
REMOVER LOS DATOS DE LA VENTA MODAL DE MENBRECIA
=============================================*/
$(".salirMenbrecia").click(function(){
	$("#inputMembrecia").val('');
	$('.nombre').text('NOMBRE: ');
	$('.ife').text('IFE: ');
	$('.correo').text('CORREO: ');
	$('.tel').text('TEL: ');
	$(".descuento").text('DESCUENTOS: ');
});
/*=============================================
APLICAR LA MENBRECIA
=============================================*/
$(".membreciaAplicada").click(function(){
	var ife=$("#inputMembrecia").val();
	$("#mebreciaDesc").text("Descuento: %"+ mem);
	$("#inputMembreciaAplicado").attr("value",ifeMenbrecia);
	$("#modalMenbrecias").modal("hide");
	$("#inputMembrecia").val('');
 	$('.nombre').text('NOMBRE: ');
 	$('.ife').text('IFE: ');
 	$('.correo').text('CORREO: ');
 	$('.tel').text('TEL: ');
 	$(".descuento").text('DESCUENTOS: ');
});

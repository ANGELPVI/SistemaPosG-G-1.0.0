/*=============================================
VARIABLE LOCAL STORAGE
=============================================*/
if(localStorage.getItem("capturarRango") != null){
	$("#daterange-btn span").html(localStorage.getItem("capturarRango"));
}else{
	$("#daterange-btn span").html('<i class="fa fa-calendar"></i> Rango de fecha')
}

/*=============================================
CARGAR LA TABLA DINÁMICA
=============================================*/
var table3 = $('.tablaCompras').DataTable({
	"ajax":"ajax/datatable-compras.ajax.php",
	"columnDefs": [
		{
			"targets": -5,
			 "data": null,
			 "defaultContent": '<img class="img-thumbnail imgTabla2Compra2" width="40px">'
		},

		{
			"targets": -2,
			 "data": null,
			 "defaultContent": '<div class="btn-group"><button class="btn btn-success limiteStock2"></button></div>'
		},

		{
			"targets": -1,
			 "data": null,
			 "defaultContent": '<div class="btn-group"><button class="btn btn-primary agregarProducto recuperarBoton" idProducto>Agregar</button></div>'
		}

	],

	"language": {

		"sProcessing":     "Procesando...",
		"sLengthMenu":     "Mostrar _MENU_ registros",
		"sZeroRecords":    "No se encontraron resultados",
		"sEmptyTable":     "Ningún dato disponible en esta tabla",
		"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
		"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
		"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
		"sInfoPostFix":    "",
		"sSearch":         "Buscar:",
		"sUrl":            "",
		"sInfoThousands":  ",",
		"sLoadingRecords": "Cargando...",
		"oPaginate": {
		"sFirst":    "Primero",
		"sLast":     "Último",
		"sNext":     "Siguiente",
		"sPrevious": "Anterior"
		},
		"oAria": {
			"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			"sSortDescending": ": Activar para ordenar la columna de manera descendente"
		}

	}

})

/*=============================================
ACTIVAR LOS BOTONES CON LOS ID CORRESPONDIENTES
=============================================*/
$(".tablaCompras tbody").on( 'click', 'button.agregarProducto', function () {
	var data = table3.row( $(this).parents('tr') ).data();
	$(this).attr("idProducto",data[5]);
})

/*=============================================
FUNCIÓN PARA CARGAR LAS IMÁGENES CON EL PAGINADOR Y EL FILTRO
=============================================*/
function cargarImagenesProductos2(){
	 var imgTabla2 = $(".imgTabla2Compra2");
	 var limiteStock2 = $(".limiteStock2");
	 for(var i = 0; i < imgTabla2.length; i ++){
	    var data = table3.row( $(imgTabla2[i]).parents('tr') ).data();	   
	    $(imgTabla2[i]).attr("src",data[1]);

	    var exi = parseInt(data[4]);
		var min = parseInt(data[6]);

	    if(exi <= min){
	    	$(limiteStock2[i]).addClass("btn-danger");
	    	$(limiteStock2[i]).html(data[4]);
	    }else if(exi > min && exi <= min+4){
	    	$(limiteStock2[i]).addClass("btn-warning");
	    	$(limiteStock2[i]).html(data[4]);   
	    }else{
	    	$(limiteStock2[i]).addClass("btn-success");
	    	$(limiteStock2[i]).html(data[4]);
	    }
  	}
}

$('.tablaCompras').on( 'draw.dt', function () {
  cargarImagenesProductos2()
})

/*=============================================
CARGAMOS LAS IMÁGENES CUANDO INTERACTUAMOS CON EL PAGINADOR
=============================================*/
$(".dataTables_paginate").click(function(){
	cargarImagenesProductos2()
})

/*=============================================
CARGAMOS LAS IMÁGENES CUANDO INTERACTUAMOS CON EL BUSCADOR
=============================================*/
$("input[aria-controls='DataTables_Table_0']").focus(function(){

	$(document).keyup(function(event){

		event.preventDefault();

		cargarImagenesProductos2()

		if(localStorage.getItem("quitarProducto") != null){

			var listaIdProductos = JSON.parse(localStorage.getItem("quitarProducto"));
			
			for(var i = 0; i < listaIdProductos.length; i++){

				$("button.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").removeClass('btn-default');

				$("button.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").addClass('btn-primary agregarProducto');

			}
			
		}

	})


})

/*=============================================
CARGAMOS LAS IMÁGENES CUANDO INTERACTUAMOS CON EL FILTRO DE CANTIDAD
=============================================*/
$("select[name='DataTables_Table_0_length']").change(function(){

	cargarImagenesProductos2()

	if(localStorage.getItem("quitarProducto") != null){

		var listaIdProductos = JSON.parse(localStorage.getItem("quitarProducto"));
		
		for(var i = 0; i < listaIdProductos.length; i++){

			$("button.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").removeClass('btn-default');

			$("button.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").addClass('btn-primary agregarProducto');

		}
		
	}

})

/*=============================================
CARGAMOS LAS IMÁGENES CUANDO INTERACTUAMOS CON EL FILTRO DE ORDENAR
=============================================*/
$(".sorting").click(function(){

	cargarImagenesProductos2()

	if(localStorage.getItem("quitarProducto") != null){

		var listaIdProductos = JSON.parse(localStorage.getItem("quitarProducto"));
		
		for(var i = 0; i < listaIdProductos.length; i++){

			$("button.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").removeClass('btn-default');

			$("button.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").addClass('btn-primary agregarProducto');

		}
		
	}

})

/*=============================================
AGREGANDO PRODUCTOS A LA COMPRA DESDE LA TABLA
=============================================*/
$(".tablaCompras tbody").on("click", "button.agregarProducto", function(){

	var idProducto = $(this).attr("idProducto");

	$(this).removeClass("btn-primary agregarProducto");

	$(this).addClass("btn-default");

	var datos = new FormData();
    datos.append("idProducto", idProducto);

     $.ajax({

     	url:"ajax/productos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){

      	    var descripcion = respuesta["descripcion"];
          	var stock = respuesta["stock_almacen"];
          	var precio = respuesta["precio_compra"];

	          	$(".nuevoProducto").append(

	          	'<div class="row" style="padding:5px 15px">'+

				  '<!-- Descripción del producto -->'+
		          
		          '<div class="col-xs-6" style="padding-right:0px">'+
		          
		            '<div class="input-group">'+
		              
		              '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'+idProducto+'"><i class="fa fa-times"></i></button></span>'+

		              '<input type="text" class="form-control nuevaDescripcionProducto" idProducto="'+idProducto+'" name="agregarProducto" value="'+descripcion+'" readonly required>'+

		            '</div>'+

		          '</div>'+

		          '<!-- Cantidad del producto -->'+

		          '<div class="col-xs-3">'+
		            
		             '<input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="1" stock="'+stock+'" nuevoStock="'+(Number(stock)+1)+'" required>'+

		          '</div>' +

		          '<!-- Precio del producto -->'+

		          '<div class="col-xs-3 ingresoPrecio" style="padding-left:0px">'+

		            '<div class="input-group">'+

		              '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
		                 
		              '<input type="text" class="form-control nuevoPrecioProducto" precioReal="'+precio+'" name="nuevoPrecioProducto" value="'+precio+'" readonly required>'+
		 
		            '</div>'+
		             
		          '</div>'+

		        '</div>') 


	        // SUMAR TOTAL DE PRECIOS

	        sumarTotalPrecios2()

	        // AGREGAR IMPUESTO

	        agregarImpuesto()

	        // AGRUPAR PRODUCTOS EN FORMATO JSON

	        listarProductos()

	        // PONER FORMATO AL PRECIO DE LOS PRODUCTOS

	        $(".nuevoPrecioProducto").number(true, 2);

      	}

     })

});

/*=============================================
QUITAR PRODUCTOS DE LA COMPRA Y RECUPERAR BOTÓN
=============================================*/
localStorage.removeItem("quitarProducto");
$(".formularioCompra").on("click", "button.quitarProducto", function(){

	$(this).parent().parent().parent().parent().remove();

	var idProducto = $(this).attr("idProducto");

	/*=============================================
	ALMACENAR EN EL LOCALSTORAGE EL ID DEL PRODUCTO A QUITAR
	=============================================*/

	if(localStorage.getItem("quitarProducto")==null){

		idQuitarProducto = [];

	}else{

		idQuitarProducto.concat(localStorage.getItem("quitarProducto"));
	}

	idQuitarProducto.push({"idProducto":idProducto});

	localStorage.setItem("quitarProducto", JSON.stringify(idQuitarProducto));
	
	$("button.recuperarBoton[idProducto='"+idProducto+"']").removeClass('btn-default');

	$("button.recuperarBoton[idProducto='"+idProducto+"']").addClass('btn-primary agregarProducto');

	if($(".nuevoProducto").children().length == 0){

		$("#nuevoImpuestoCompra").val(0);
		$("#nuevoTotalCompra").val(0);
		$("#totalCompra").val(0);
		$("#nuevoTotalCompra").attr("total",0);

	}else{

		// SUMAR TOTAL DE PRECIOS

    	sumarTotalPrecios2()

    	// AGREGAR IMPUESTO
	        
        agregarImpuesto()

        // AGRUPAR PRODUCTOS EN FORMATO JSON

        listarProductos()

	}

})

/*=============================================
AGREGANDO PRODUCTOS DESDE EL BOTÓN PARA DISPOSITIVOS
=============================================*/
$(".btnAgregarProducto").click(function(){
	var datos = new FormData();
	datos.append("traerProductos", "ok");
	$.ajax({

		url:"ajax/productos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){
      	    
      	    $(".nuevoProducto").append(

          	'<div class="row" style="padding:5px 15px">'+

			  '<!-- Descripción del producto -->'+
	          
	          '<div class="col-xs-6" style="padding-right:0px">'+
	          
	            '<div class="input-group">'+
	              
	              '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto><i class="fa fa-times"></i></button></span>'+

	              '<select class="form-control nuevaDescripcionProducto" idProducto name="nuevaDescripcionProducto" required>'+

	              '<option>Seleccione el producto</option>'+

	              '</select>'+  

	            '</div>'+

	          '</div>'+

	          '<!-- Cantidad del producto -->'+

	          '<div class="col-xs-3 ingresoCantidad">'+
	            
	             '<input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="1" stock nuevoStock required>'+

	          '</div>' +

	          '<!-- Precio del producto -->'+

	          '<div class="col-xs-3 ingresoPrecio" style="padding-left:0px">'+

	            '<div class="input-group">'+

	              '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
	                 
	              '<input type="text" class="form-control nuevoPrecioProducto" precioReal="" name="nuevoPrecioProducto" readonly required>'+
	 
	            '</div>'+
	             
	          '</div>'+

	        '</div>');


	        // AGREGAR LOS PRODUCTOS AL SELECT 

	         respuesta.forEach(funcionForEach);

	         function funcionForEach(item, index){

	         	$(".nuevaDescripcionProducto").append(

					'<option idProducto="'+item.id+'" value="'+item.descripcion+'">'+item.descripcion+'</option>'
	         	)

	         }

	         // SUMAR TOTAL DE PRECIOS

    		sumarTotalPrecios2()

    		// AGREGAR IMPUESTO
	        
	        agregarImpuesto()

	        // PONER FORMATO AL PRECIO DE LOS PRODUCTOS

	        $(".nuevoPrecioProducto").number(true, 2);

      	}


	})

})

/*=============================================
SELECCIONAR PRODUCTO
=============================================*/
$(".formularioCompra").on("change", "select.nuevaDescripcionProducto", function(){
	var nombreProducto = $(this).val();
	var nuevaDescripcionProducto = $(this).parent().parent().parent().children().children().children(".nuevaDescripcionProducto");
	var nuevoPrecioProducto = $(this).parent().parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");
	var nuevaCantidadProducto = $(this).parent().parent().parent().children(".ingresoCantidad").children(".nuevaCantidadProducto");
	var datos = new FormData();
    datos.append("nombreProducto", nombreProducto);
	  $.ajax({
     	url:"ajax/productos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){
      	    $(nuevaDescripcionProducto).attr("idProducto", respuesta["id"]);
      	    $(nuevaCantidadProducto).attr("stock", respuesta["stock_almacen"]);
      	    $(nuevaCantidadProducto).attr("nuevoStock", Number(respuesta["stock_almacen"])+1);
      	    $(nuevoPrecioProducto).val(respuesta["precio_compra"]);
      	    $(nuevoPrecioProducto).attr("precioReal", respuesta["precio_compra"]);
  	      	// AGRUPAR PRODUCTOS EN FORMATO JSON
	    	listarProductos()
      	}
      })
})

/*=============================================
MODIFICAR LA CANTIDAD
=============================================*/
$(".formularioCompra").on("change", "input.nuevaCantidadProducto", function(){
	var precio = $(this).parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");
	var precioFinal = $(this).val() * precio.attr("precioReal");
	precio.val(precioFinal);
	var nuevoStock = parseInt($(this).attr("stock")) + parseInt($(this).val()); /***** Aqui se mofica el Stock ++***/
	$(this).attr("nuevoStock", nuevoStock);
	// SUMAR TOTAL DE PRECIOS
	sumarTotalPrecios2()
	// AGREGAR IMPUESTO      
    agregarImpuesto()
    // AGRUPAR PRODUCTOS EN FORMATO JSON
    listarProductos()
})

/*=============================================
SUMAR TODOS LOS PRECIOS
=============================================*/
function sumarTotalPrecios2(){
	var precioItem = $(".nuevoPrecioProducto");
	var arraySumaPrecio = [];  
	for(var i = 0; i < precioItem.length; i++){
		 arraySumaPrecio.push(Number($(precioItem[i]).val()));		 
	}
	function sumaArrayPrecios(total, numero){
		return total + numero;
	}
	var sumaTotalPrecio = arraySumaPrecio.reduce(sumaArrayPrecios);	
	$("#nuevoTotalCompra").val(sumaTotalPrecio);
	$("#totalCompra").val(sumaTotalPrecio);
	$("#nuevoTotalCompra").attr("total",sumaTotalPrecio);
}

/*=============================================
FUNCIÓN AGREGAR IMPUESTO
=============================================*/
function agregarImpuesto(){
	var impuesto = 0;
	var precioTotal = $("#nuevoTotalCompra").attr("total");
	var precioImpuesto = Number(precioTotal * impuesto/100);
	var totalConImpuesto = Number(precioImpuesto) + Number(precioTotal);	
	$("#nuevoTotalCompra").val(totalConImpuesto);
	$("#totalCompra").val(totalConImpuesto);
	$("#nuevoPrecioImpuesto").val(precioImpuesto);
	$("#nuevoPrecioNeto").val(precioTotal);
}

/*=============================================
CUANDO CAMBIA EL IMPUESTO
=============================================*/
$("#nuevoImpuestoCompra").change(function(){
	agregarImpuesto();
});

/*=============================================
FORMATO AL PRECIO FINAL
=============================================*/
$("#nuevoTotalCompra").number(true, 2);

/*=============================================
SELECCIONAR MÉTODO DE PAGO
=============================================*/
$("#nuevoMetodoPago").change(function(){
	var metodo = $(this).val();
	if(metodo == "Efectivo"){
		$(this).parent().parent().removeClass("col-xs-6");
		$(this).parent().parent().addClass("col-xs-4");
		$(this).parent().parent().parent().children(".cajasMetodoPago").html(
			 '<div class="col-xs-4">'+ 
			 	'<div class="input-group">'+ 
			 		'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+ 
			 		'<input type="text" class="form-control" id="nuevoValorEfectivo" placeholder="000000" required>'+
			 	'</div>'+
			 '</div>'+
			 '<div class="col-xs-4" id="capturarCambioEfectivo" style="padding-left:0px">'+
			 	'<div class="input-group">'+
			 		'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
			 		'<input type="text" class="form-control" id="nuevoCambioEfectivo" placeholder="000000" readonly required>'+
			 	'</div>'+
			 '</div>'
		)
		// Agregar formato al precio
		$('#nuevoValorEfectivo').number( true, 2);
      	$('#nuevoCambioEfectivo').number( true, 2);
      	// Listar método en la entrada
      	listarMetodos()
	}else{
		$(this).parent().parent().removeClass('col-xs-4');
		$(this).parent().parent().addClass('col-xs-6');
		 $(this).parent().parent().parent().children('.cajasMetodoPago').html(
		 	'<div class="col-xs-6" style="padding-left:0px">'+                       
                '<div class="input-group">'+                    
                  '<input type="number" min="0" class="form-control" id="nuevoCodigoTransaccion" placeholder="Código transacción"  required>'+                   
                  '<span class="input-group-addon"><i class="fa fa-lock"></i></span>'+                  
                '</div>'+
              '</div>')
	}
})

/*=============================================
CAMBIO EN EFECTIVO
=============================================*/
$(".formularioCompra").on("change", "input#nuevoValorEfectivo", function(){
	var efectivo = $(this).val();
	var cambio =  Number(efectivo) - Number($('#nuevoTotalCompra').val());
	var nuevoCambioEfectivo = $(this).parent().parent().parent().children('#capturarCambioEfectivo').children().children('#nuevoCambioEfectivo');
	nuevoCambioEfectivo.val(cambio);
})

/*=============================================
CAMBIO TRANSACCIÓN
=============================================*/
$(".formularioCompra").on("change", "input#nuevoCodigoTransaccion", function(){
	// Listar método en la entrada
    listarMetodos()
})


/*=============================================
LISTAR TODOS LOS PRODUCTOS
=============================================*/
function listarProductos(){
	var listaProductos = [];
	var descripcion = $(".nuevaDescripcionProducto");
	var cantidad = $(".nuevaCantidadProducto");
	var precio = $(".nuevoPrecioProducto");
	for(var i = 0; i < descripcion.length; i++){
		listaProductos.push({ "id" : $(descripcion[i]).attr("idProducto"), 
							  "descripcion" : $(descripcion[i]).val(),
							  "cantidad" : $(cantidad[i]).val(),
							  "stock" : $(cantidad[i]).attr("nuevoStock"),
							  "precio" : $(precio[i]).attr("precioReal"),
							  "total" : $(precio[i]).val()})
	}
	$("#listaProductos").val(JSON.stringify(listaProductos)); 
}

/*=============================================
LISTAR MÉTODO DE PAGO
=============================================*/
function listarMetodos(){
	var listaMetodos = "";
	if($("#nuevoMetodoPago").val() == "Efectivo"){
		$("#listaMetodoPago").val("Efectivo");
	}else{
		$("#listaMetodoPago").val($("#nuevoMetodoPago").val()+"-"+$("#nuevoCodigoTransaccion").val());
	}
}

/*=============================================
BOTON EDITAR COMPRA
=============================================*/
$(".tablas").on("click", ".btnEditarCompra", function(){
	var idCompra = $(this).attr("idCompra");
	console.log("idCompra", idCompra);
	window.location = "index.php?ruta=editar-compra&idCompra="+idCompra;
})


/*=============================================
BORRAR COMPRA
=============================================*/
$(".tablas").on("click", ".btnEliminarCompra", function(){
  var idCompra = $(this).attr("idCompra");
  swal({
        title: '¿Está seguro de borrar la compra?',
        text: "¡Si no lo está puede cancelar la accíón!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar compra!'
      }).then(function(result) {
        if (result.value) {
            window.location = "index.php?ruta=compras&idCompra="+idCompra;
        }
  })
})

/*=============================================
IMPRIMIR FACTURA
=============================================*/
$(".tablas").on("click", ".btnImprimirFactura2", function(){
	var codigoCompra = $(this).attr("codigoCompra");
	window.open("extensiones/tcpdf/pdf/factura2.php?codigo="+codigoCompra, "_blank");
})

/*=============================================
RANGO DE FECHAS
=============================================*/
$('#daterange-btn').daterangepicker(
  {
    ranges   : {
      'Hoy'       : [moment(), moment()],
      'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
      'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
      'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
      'Último mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment(),
    endDate  : moment()
  },
  function (start, end) {
    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    var fechaInicial = start.format('YYYY-MM-DD');
    var fechaFinal = end.format('YYYY-MM-DD');
    var capturarRango = $("#daterange-btn span").html();
   	localStorage.setItem("capturarRango", capturarRango);
   	window.location = "index.php?ruta=compras&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
  }
)

/*=============================================
CANCELAR RANGO DE FECHAS
=============================================*/
$(".daterangepicker.opensleft .range_inputs .cancelBtn").on("click", function(){
	localStorage.removeItem("capturarRango");
	localStorage.clear();
	window.location = "Compras";
})

/*=============================================
CAPTURAR HOY
=============================================*/
$(".daterangepicker.opensleft .ranges li").on("click", function(){
	var textoHoy = $(this).attr("data-range-key");
	if(textoHoy == "Hoy"){
		var d = new Date();		
		var dia = d.getDate();
		var mes = d.getMonth()+1;
		var año = d.getFullYear();
		if(mes < 10){
			var fechaInicial = año+"-0"+mes+"-"+dia;
    		var fechaFinal = año+"-0"+mes+"-"+dia;
		}else if(dia < 10){
			var fechaInicial = año+"-"+mes+"-0"+dia;
    		var fechaFinal = año+"-"+mes+"-0"+dia;
		}else if(mes < 10 && dia < 10){
			var fechaInicial = año+"-0"+mes+"-0"+dia;
    		var fechaFinal = año+"-0"+mes+"-0"+dia;
		}else{
			var fechaInicial = año+"-"+mes+"-"+dia;
    		var fechaFinal = año+"-"+mes+"-"+dia;
		}
    	localStorage.setItem("capturarRango", "Hoy");
    	window.location = "index.php?ruta=compras&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
	}
})
/*=============================================
CARGAR LA TABLA DINÁMICA
=============================================*/
if($(".perfilUsuario").val() != "Super Administrador"){
	if($(".perfilUsuario").val() != "Administrador"){
		var botonesTabla = '<div class="btn-group"><button class="btn btn-warning btnEditarProducto" idProducto data-toggle="modal" data-target="#modalEditarProducto"><i class="fa fa-pencil"></i></button></div>';
	}
}else{
	var botonesTabla = '<div class="btn-group"><button class="btn btn-warning btnEditarProducto" idProducto data-toggle="modal" data-target="#modalEditarProducto"><i class="fa fa-pencil"></i></button><button class="btn btn-danger btnEliminarProducto" idProducto codigo imagen><i class="fa fa-times"></i></button></div>';
}

// $.ajax({
// 	url: "ajax/datatable-productos.ajax.php",
// 	success: function(respuesta){
// 		console.log(respuesta);
// 	}
// })

var tabla= $('.tablaProductos').DataTable( {
       "ajax": "ajax/datatable-productos.ajax.php",

       
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


    } );


/*=============================================
ACTIVAR LOS BOTONES CON LOS ID CORRESPONDIENTES
=============================================*/
// $('.tablaProductos tbody').on( 'click', 'button', function () {
// 	if(window.matchMedia("(min-width:992px)").matches){
// 		/*var data = table.row( $(this).parents('tr') ).data();*/
// 		var data = table.row( $(this).parents('tbody tr ul li')).data();
// 	}else{
// 		var data = table.row( $(this).parents('tbody tr ul li')).data();
// 	}
// 	$(this).attr("idProducto", data[14]);	
// 	$(this).attr("codigo", data[4]);
// 	$(this).attr("imagen", data[3]);
// } );

/*=============================================
FUNCIÓN PARA CARGAR LAS IMÁGENES
=============================================*/
function cargarImagenes(){

	var imgTabla = $(".imgTabla");

	var limiteStock = $(".limiteStock");

	var limiteStock2 = $(".limiteStock2");

	for(var i = 0; i < imgTabla.length; i ++){
		var data = table.row( $(imgTabla[i]).parents("tr")).data();	
		$(imgTabla[i]).attr("src", data[3]);

		var exi = parseInt(data[10]);
		var min = parseInt(data[15]);

		var exiA = parseInt(data[11]);
		var minA = parseInt(data[16]);

		if(exi < min){
	    	$(limiteStock[i]).addClass("btn-danger");
	    	$(limiteStock[i]).html(data[10]);
	    }else if(exi > min && exi <= min+4){
	    	$(limiteStock[i]).addClass("btn-warning");
	    	$(limiteStock[i]).html(data[10]);
	    }else{
	    	$(limiteStock[i]).addClass("btn-success");
	    	$(limiteStock[i]).html(data[10]);
	    }

	   	if(exiA < minA){
	    	$(limiteStock2[i]).addClass("btn-danger");
	    	$(limiteStock2[i]).html(data[11]);
	    }else if(exiA > minA && exiA <= minA+4){
	    	$(limiteStock[i]).addClass("btn-warning");
	    	$(limiteStock[i]).html(data[11]);
	    }else{
	    	$(limiteStock2[i]).addClass("btn-success");
	    	$(limiteStock2[i]).html(data[11]);
	    }

	}

}

/*=============================================
CARGAMOS LAS IMÁGENES CUANDO ENTRAMOS A LA PÁGINA POR PRIMERA VEZ
=============================================*/
$('.tablaProductos').on( 'draw.dt', function () {

	cargarImagenes();

	if($(".perfilUsuario").val() != "Super Administrador"){

		$('.btnEliminarProducto').remove();

	}

})

/*=============================================
CARGAMOS LAS IMÁGENES CUANDO INTERACTUAMOS CON EL PAGINADOR
=============================================*/
$(".dataTables_paginate").click(function(){

	cargarImagenes();

	if($(".perfilUsuario").val() != "Super Administrador"){

		$('.btnEliminarProducto').remove();

	}

})

/*=============================================
CARGAMOS LAS IMÁGENES CUANDO INTERACTUAMOS CON EL BUSCADOR
=============================================*/
$("input[aria-controls='DataTables_Table_0']").focus(function(){

	$(document).keyup(function(event){

		event.preventDefault();

		cargarImagenes();

		if($(".perfilUsuario").val() != "Super Administrador"){

			$('.btnEliminarProducto').remove();

		}


	})

})

/*=============================================
CARGAMOS LAS IMÁGENES CUANDO INTERACTUAMOS CON EL FILTRO DE CANTIDAD
=============================================*/
$("select[name='DataTables_Table_0_length']").change(function(){

	cargarImagenes();

	if($(".perfilUsuario").val() != "Super Administrador"){

		$('.btnEliminarProducto').remove();

	}

})

/*=============================================
CARGAMOS LAS IMÁGENES CUANDO INTERACTUAMOS CON EL FILTRO DE ORDENAR
=============================================*/
$(".sorting").click(function(){

	cargarImagenes();

	if($(".perfilUsuario").val() != "Super Administrador"){

		$('.btnEliminarProducto').remove();

	}

})

/*=============================================
CAPTURANDO LA CATEGORIA PARA ASIGNAR CÓDIGO
=============================================*/
$("#nuevaCategoria").change(function(){

	var idCategoria = $(this).val();

	var datos = new FormData();
  	datos.append("idCategoria", idCategoria);

  	$.ajax({

      url:"ajax/productos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){

      	if(!respuesta){

      		var nuevoCodigo = idCategoria+"001";
      		$("#nuevoCodigo").val(nuevoCodigo);

      	}else{

      		var nuevoCodigo = Number(respuesta["codigo"]) + 1;
          	$("#nuevoCodigo").val(nuevoCodigo);

      	}
                
      }

  	})

})

/*=============================================
AGREGANDO PRECIO DE VENTA
=============================================*/
$("#nuevoPrecioCompra, #editarPrecioCompra").change(function(){

	if($(".porcentaje").prop("checked")){

		var valorPorcentaje = $(".nuevoPorcentaje").val();
		
		var porcentaje = Number(($("#nuevoPrecioCompra").val()*valorPorcentaje/100))+Number($("#nuevoPrecioCompra").val());

		var editarPorcentaje = Number(($("#editarPrecioCompra").val()*valorPorcentaje/100))+Number($("#editarPrecioCompra").val());

		$("#nuevoPrecioVenta").val(porcentaje);
		$("#nuevoPrecioVenta").prop("readonly",true);

		$("#editarPrecioVenta").val(editarPorcentaje);
		$("#editarPrecioVenta").prop("readonly",true);

	}

})

/*=============================================
CAMBIO DE PORCENTAJE
=============================================*/
$(".nuevoPorcentaje").change(function(){

	if($(".porcentaje").prop("checked")){

		var valorPorcentaje = $(this).val();
		
		var porcentaje = Number(($("#nuevoPrecioCompra").val()*valorPorcentaje/100))+Number($("#nuevoPrecioCompra").val());

		var editarPorcentaje = Number(($("#editarPrecioCompra").val()*valorPorcentaje/100))+Number($("#editarPrecioCompra").val());

		$("#nuevoPrecioVenta").val(porcentaje);
		$("#nuevoPrecioVenta").prop("readonly",true);

		$("#editarPrecioVenta").val(editarPorcentaje);
		$("#editarPrecioVenta").prop("readonly",true);

	}

})

$(".porcentaje").on("ifUnchecked",function(){

	$("#nuevoPrecioVenta").prop("readonly",false);
	$("#editarPrecioVenta").prop("readonly",false);

})

$(".porcentaje").on("ifChecked",function(){

	$("#nuevoPrecioVenta").prop("readonly",true);
	$("#editarPrecioVenta").prop("readonly",true);

})

/*=============================================
SUBIENDO LA FOTO DEL PRODUCTO
=============================================*/
$(".nuevaImagen").change(function(){

	var imagen = this.files[0];
	
	/*=============================================
  	VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
  	=============================================*/

  	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){

  		$(".nuevaImagen").val("");

  		 swal({
		      title: "Error al subir la imagen",
		      text: "¡La imagen debe estar en formato JPG o PNG!",
		      type: "error",
		      confirmButtonText: "¡Cerrar!"
		    });

  	}else if(imagen["size"] > 2000000){

  		$(".nuevaImagen").val("");

  		 swal({
		      title: "Error al subir la imagen",
		      text: "¡La imagen no debe pesar más de 2MB!",
		      type: "error",
		      confirmButtonText: "¡Cerrar!"
		    });

  	}else{

  		var datosImagen = new FileReader;
  		datosImagen.readAsDataURL(imagen);

  		$(datosImagen).on("load", function(event){

  			var rutaImagen = event.target.result;

  			$(".previsualizar").attr("src", rutaImagen);

  		})

  	}
})

/*=============================================
EDITAR PRODUCTO
=============================================*/
$(".tablaProductos tbody").on("click", "button.btnEditarProducto", function(){
	var idProducto = $(this).attr("idProducto");
	console.log("Este es el id "+idProducto);

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
  			$("#editarId").val(respuesta["id"]);
			
  	// 		var datosSucursal = new FormData();
   //  		datosSucursal.append("idSucursal",respuesta["id_sucursal"]);
			// $.ajax({
			// 	url:"ajax/sucursales2.ajax.php",
			// 	method: "POST",
			// 	data: datosSucursal,
			// 	cache: false,
			// 	contentType: false,
			// 	processData: false,
			// 	dataType:"json",
			// 	success:function(respuesta){
			// 	  	$("#editarSucursal").val(respuesta["id"]);
			// 	  	$("#editarSucursal").html(respuesta["nombre"]);
			// 	}
   //        	})

          	var datosProveedor = new FormData();
      		datosProveedor.append("idProveedor",respuesta["id_proveedor"]);
           	$.ajax({
              	url:"ajax/proveedores.ajax.php",
              	method: "POST",
              	data: datosProveedor,
              	cache: false,
              	contentType: false,
              	processData: false,
              	dataType:"json",
              	success:function(respuesta){
                  	$("#editarProveedor").val(respuesta["id"]);
                  	$("#editarProveedor").html(respuesta["nombre"]);
              	}
          	})
      
      		var datosCategoria = new FormData();
      		datosCategoria.append("idCategoria",respuesta["id_categoria"]);
           	$.ajax({
              	url:"ajax/categorias.ajax.php",
              	method: "POST",
              	data: datosCategoria,
              	cache: false,
              	contentType: false,
              	processData: false,
              	dataType:"json",
              	success:function(respuesta){
                  	$("#editarCategoria").val(respuesta["id"]);
                  	$("#editarCategoria").html(respuesta["categoria"]);
              	}
          	})

       		$("#editarCodigo").val(respuesta["codigo"]);
       		$("#editarDescripcion").val(respuesta["descripcion"]);
       		$("#editarStock_almacen").val(respuesta["stock"]);
       		$("#editarPrecioCompra").val(respuesta["precio_compra"]);
       		$("#editarPrecioVenta").val(respuesta["precio_venta"]);
           
       		if(respuesta["imagen"] != ""){

       			$("#imagenActual").val(respuesta["imagen"]);
       			$(".previsualizar").attr("src",  respuesta["imagen"]);

       		}

      	}

  	})
})

/*=============================================
ELIMINAR PRODUCTO
=============================================*/
$(".tablaProductos tbody").on("click", "button.btnEliminarProducto", function(){
	var idProducto = $(this).attr("idProducto");
	var codigo = $(this).attr("codigo");
	var imagen = $(this).attr("imagen");
	swal({
		title: '¿Está seguro de borrar el producto?',
		text: "¡Si no lo está puede cancelar la accíón!",
		type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar producto!'
        }).then(function(result) {
        if (result.value) {
        	window.location = "index.php?ruta=productos&idProducto="+idProducto+"&imagen="+imagen+"&codigo="+codigo;
        }
	})
})
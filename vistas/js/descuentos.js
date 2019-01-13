/*=============================================
EDITAR DESCUENTO
=============================================*/
$(".tablas").on("click", ".btnEditarDescuento", function(){

	var idDescuento = $(this).attr("idDescuento");

	var datos = new FormData();
    datos.append("idDescuento", idDescuento);

    $.ajax({

      url:"ajax/descuentos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
      	 $("#editarId").val(respuesta["id"]);
	       $("#editarNombre").val(respuesta["nombre"]);
	       $("#editarDescuento").val(respuesta["descuento"]);
	    }

  	})

})

/*=============================================
REVISAR SI EL DESCUENTO YA ESTÁ REGISTRADO
=============================================*/

$("#nuevoNombre").change(function(){
  $(".alert").remove();
  var descuento = $(this).val();
  var datos = new FormData();
  datos.append("validarDescuento", descuento);
   $.ajax({
      url:"ajax/descuentos.ajax.php",
      method:"POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(respuesta){
        console.log(respuesta);
        if(respuesta){

          $("#nuevoDescuento").parent().after('<div class="alert alert-warning">Este descuento ya existe en la base de datos</div>');

          $("#nuevoDescuento").val("");

        }

      }

  })
})
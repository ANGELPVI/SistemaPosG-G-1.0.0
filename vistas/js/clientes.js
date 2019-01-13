/*=============================================
EDITAR CLIENTE
=============================================*/
$(".tablas").on("click", ".btnEditarCliente", function(){

	var idCliente = $(this).attr("idCliente");

	var datos = new FormData();
    datos.append("idCliente", idCliente);

    $.ajax({

      url:"ajax/clientes.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
        $("#editarId").val(respuesta["id"]);
        $("#editarDescuento").html(respuesta["descuento"]);
        $("#editarNombre").val(respuesta["nombre"]);
	      $("#editarTelefono").val(respuesta["telefono"]);
	      $("#editarEmail").val(respuesta["email"]);
	      $("#editarDireccion").val(respuesta["direccion"]);
        $("#editarTipo").html(respuesta["tipo"]);
        $("#editarRfc").val(respuesta["rfc"]);
	  }

  	})

})

/*=============================================
ELIMINAR CLIENTE
=============================================*/
$(".tablas").on("click", ".btnEliminarCliente", function(){

	var idCliente = $(this).attr("idCliente");
	
	swal({
        title: '¿Está seguro de borrar el cliente?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar cliente!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?ruta=clientes&idCliente="+idCliente;
        }

  })

})

/*=============================================
REVISAR SI EL CLIENTE YA ESTÁ REGISTRADO
=============================================*/

$("#nuevoNombre").change(function(){
  $(".alert").remove();
  var cliente = $(this).val();
  var datos = new FormData();
  datos.append("validarCliente", cliente);
   $.ajax({
      url:"ajax/clientes.ajax.php",
      method:"POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(respuesta){
        console.log(respuesta);
        if(respuesta){

          $("#nuevoNombre").parent().after('<div class="alert alert-warning">Este cliente ya existe en la base de datos</div>');

          $("#nuevoNombre").val("");

        }

      }

  })
})
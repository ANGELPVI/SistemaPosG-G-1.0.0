// Formato de teléfono al registrar sucursal
$("#phone").inputmask({"mask": "(999) 999-9999"});


// Editar Sucursales

$(".tablas").on('click', '.ediatarSucursal', function() {
	document.getElementById('id').value = $(this).attr('edtarId');
	document.getElementById('rfc').value = $(this).attr('editarRc');
	document.getElementById('sucursal').value = $(this).attr('editarNombre');
	document.getElementById('sucursalDireccion').value = $(this).attr('editarDireccion');
	document.getElementById('nuevophone').value = $(this).attr('editarTel');
	document.getElementById('sucursalEmail').value = $(this).attr('editarEmail');
	
});


// Eliminar sucursal
// $(".eliminarSucursal").click(function() {
// 	document.getElementById('eliminarid').value = $(this).attr('eliminarId');	
// });


// Eliminar sucursal con SWeeteAlert
$(".tablas").on("click",".eliminarSucursal",function() {
	var idEliminar=$(this).attr('eliminarId');
	

	swal({
	title: 'Eliminar Sucursal?',
	text: "Está apunto de eliminar todos los datos de la sucursal seleccionada,¿está seguro de eliminarlos?",
	type: 'warning',
	showCancelButton: true,
	confirmButtonColor: '#3085d6',
	cancelButtonColor: '#d33',
	confirmButtonText: 'Eliminar'
	}).then((result) => {

	if (result.value) {

	// Enviar id para eliminar sucursal
	var datos = new FormData();
	datos.append("idSucursal", idEliminar);

	$.ajax({
		url:"ajax/sucursal.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
				
			if (respuesta=="eliminarok"){
				swal({
					type:"success",
					title:"!La sucursal fue eliminada correctamente¡",
					showConfirmButton:true,
					confirmButtonText:"Cerrar",
					closeOnConfirm:false
				
					}).then((result)=>{
						if(result.value){
						window.location="sucursales";
						}
				
					});
				

			}else{
				swal({
					type:"error",
					title:"!Error¡, comuníquese con soporte tecnico",
					showConfirmButton:true,
					confirmButtonText:"Cerrar",
					closeOnConfirm:false
					
					}).then((result)=>{
					if(result.value){
					window.location="sucursales";
					
					}
					
					});				
			}

			}

	});


	}
	})	
});
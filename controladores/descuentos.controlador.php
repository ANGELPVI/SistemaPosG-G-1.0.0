<?php
class ControladorDescuentos{
	/*=============================================
	REGISTRO DE DESCUENTO
	=============================================*/
	static public function ctrCrearDescuento(){
		if(isset($_POST["nuevoDescuento"])){
			$tabla = "descuentos";
			$datos = array("nombre" => $_POST["nuevoNombre"],
				"descuento" => $_POST["nuevoDescuento"]);
			$respuesta = ModeloDescuentos::mdlIngresarDescuento($tabla, $datos);
			if($respuesta == "ok"){
				echo '<script>
				swal({
					type: "success",
					title: "¡El descuento ha sido guardado correctamente!",
					showConfirmButton: true,
					confirmButtonText: "Cerrar"

				}).then(function(result){

					if(result.value){
					
						window.location = "descuentos";

					}

				});
			

				</script>';
	
			}else{

				echo '<script>

					swal({

						type: "error",
						title: "¡El descuento no puede ir vacío o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"

					}).then(function(result){

						if(result.value){
						
							window.location = "descuentos";

						}

					});
				

				</script>';

			}

		}
	}


	/*=============================================
	MOSTRAR DESCUENTO
	=============================================*/

	static public function ctrMostrarDescuentos($item, $valor){
		$tabla = "descuentos";
		$respuesta = ModeloDescuentos::mdlMostrarDescuentos($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	EDITAR DESCUENTO
	=============================================*/

	static public function ctrEditarDescuento(){

		if(isset($_POST["editarDescuento"])){

			$tabla = "descuentos";

			$datos = array("id"=>$_POST["editarId"],
				"nombre" => $_POST["editarNombre"],
				"descuento" => $_POST["editarDescuento"]);

			$respuesta = ModeloDescuentos::mdlEditarDescuento($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El descuento ha sido editado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result) {
								if (result.value) {

								window.location = "descuentos";

								}
							})

				</script>';
			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El nombre no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
							if (result.value) {

							window.location = "descuentos";

							}
						})

			  	</script>';

			}
		}

	}
}
<?php date_default_timezone_set('America/Monterrey');
// código ausente (NO SE OCUPA EN ESTE SISTEMA) sucursales vista
/**
* 
Angel Piña
*/
class ControladorSucursal{

	// Registro sucursal
	static public function ctrRegistroSucursal(){
		if (isset($_POST["nuvoRfc"])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuvaSucursal"])&&
				preg_match('/^[a-zA-Z0-9 ]+$/',$_POST["nuvoRfc"])) {

				$tabla="sucursales";
				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$dia=$fecha.' '.$hora;

				$datos=array("rfc"=>$_POST["nuvoRfc"],
							 "sucursal"=>$_POST["nuvaSucursal"],
							 "direccion"=>$_POST["nuvaDireccion"],
							 "telefono"=>$_POST["nuevoTelefono"],
							 "email"=>$_POST["nuevoEmail"],
							 "dia"=>$dia);

				$respusta=ModeloSucursales::mdlRegistroSucursal($tabla,$datos);

				if ($respusta=="ok") {
					echo '  
						<script>
							swal({
								type:"success",
								title:"!La sucursal fue registrada correctamente¡",
								showConfirmButton:true,
								confirmButtonText:"Cerrar",
								closeOnConfirm:false
							
								}).then((result)=>{
									if(result.value){
									window.location="sucursales";
									}
							
								});
						</script>';
				}else{
						echo '  
					<script>
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
					</script>';

				}


			}else{
				echo '  
				<script>
					swal({
						type:"error",
						title:"!Rellene Correctamente los campos, no se admiten cárteres extraños o que los campos vayan vacíos¡",
						showConfirmButton:true,
						confirmButtonText:"Cerrar",
						closeOnConfirm:false

					}).then((result)=>{
						if(result.value){
							window.location="sucursales";

						}

					});
				</script>';
			}


		}
		
	}

	// Mostrar sucursales
	static public function ctrMostrarSucursal(){
		$tabla="sucursales";
		$sucursales=ModeloSucursales::mdlMostrarSucursales($tabla);

		if ($sucursales !="error") {
			return $sucursales;
			
		}else{
			echo '  
				<script>
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
				</script>';
		}
		
	}

	// Editar sucursales
	static public function ctrEditarSucursal(){
		if (isset($_POST["editarRfc"])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarSucursal"])&&
				preg_match('/^[a-zA-Z0-9 ]+$/',$_POST["editarRfc"])) {

				
				$tabla="sucursales";
				$datos=array("rfc"=>$_POST["editarRfc"],
							 "sucursal"=>$_POST["editarSucursal"],
							 "direccion"=>$_POST["editarDireccion"],
							 "telefono"=>$_POST["editarTelefono"],
							 "email"=>$_POST["editarEmail"],
							 "id"=>$_POST["id"]);

			$respustaEditar=ModeloSucursales::mdlEditarSucursal($tabla, $datos);

				if ($respustaEditar=="editarok") {
					echo '  
						<script>
							swal({
								type:"success",
								title:"!Los cambios fueron guardados correctamente ¡",
								showConfirmButton:true,
								confirmButtonText:"Cerrar",
								closeOnConfirm:false
							
								}).then((result)=>{
									if(result.value){
									window.location="sucursales";
									}
							
								});
						</script>';
					
				}else{
					echo '  
					<script>
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
					</script>';
					

				}


			}else{
				echo '  
				<script>
					swal({
						type:"error",
						title:"!Rellene Correctamente los campos, no se admiten cárteres extraños o que los campos vayan vacíos¡",
						showConfirmButton:true,
						confirmButtonText:"Cerrar",
						closeOnConfirm:false

					}).then((result)=>{
						if(result.value){
							window.location="sucursales";

						}

					});
				</script>';
			}


		}

		
	}

	
}




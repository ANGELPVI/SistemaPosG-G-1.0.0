<?php 
/**
* Ángel Piña 
*/
class ControladorMovimientos{
	// Mostrar Movimientos
	static public function ctrMostrarMovimientos(){
		$respuesta=ModeloMovimientos::mdlMostrarMovimiento();

		if($respuesta!="error"){

			return $respuesta;

		}else{

			return "error de conexión";
		
		}
	}


	
}
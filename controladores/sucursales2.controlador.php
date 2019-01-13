<?php
class ControladorSucursales2{
	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/
	static public function ctrMostrarSucursales2($item, $valor){
		$tabla = "sucursales";
		$respuesta = ModeloSucursales2::mdlMostrarSucursales2($tabla, $item, $valor);
		return $respuesta;
	}

}

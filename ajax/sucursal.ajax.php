<?php 
/**
* Ángel Piña
*/
require_once '../controladores/sucursales.controlador.php';
require_once '../modelos/sucursales.modelo.php';

class AjaxSucursal{

	public $idSucursal;

	public function eliminarSucursal(){
		$tabla="sucursales";
		$eliminarSucursal=$this->idSucursal;

		$respustaEliminar=ModeloSucursales::mdlEliminarSucursal($tabla,$eliminarSucursal);
		echo json_encode($respustaEliminar);
		
	}
	
	
}


if (isset($_POST["idSucursal"])) {
	$eliminar=new  AjaxSucursal();
	$eliminar->idSucursal=$_POST["idSucursal"];
	$eliminar->eliminarSucursal();
}


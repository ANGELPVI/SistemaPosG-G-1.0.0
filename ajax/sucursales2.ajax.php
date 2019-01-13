<?php
require_once "../controladores/sucursales2.controlador.php";
require_once "../modelos/sucursales2.modelo.php";
class AjaxSucursales2{
	/*=============================================
	EDITAR SUCURSAL
	=============================================*/	
	public $idSucursal;
	public function ajaxEditarSucursales2(){
		$item = "id";
		$valor = $this->idSucursal;
		$respuesta = ControladorSucursales2::ctrMostrarSucursales2($item, $valor);
		echo json_encode($respuesta);
	}
}

/*=============================================
EDITAR SUCURSAL
=============================================*/	
if(isset($_POST["idSucursal"])){
	$sucursal = new AjaxSucursales2();
	$sucursal -> idSucursal = $_POST["idSucursal"];
	$sucursal -> ajaxEditarSucursales2();
}
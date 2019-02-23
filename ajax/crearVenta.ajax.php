<?php 
require_once '../controladores/crearVenta.controlador.php';
require_once '../modelos/crearVenta.modelo.php';

/**
 * Buscar productos para vender
 */
class BuscarProductoVenta{

	public $codigoProducto;
	public function venderProducto(){
		$valor = $this->codigoProducto;
		
		$p=ControlCrearVenta::ctlBuscarProducto($valor);
			
			echo json_encode($p);
		

		
	}
	
}



if (isset($_POST["letras"])){
	$buscarProducto=new BuscarProductoVenta();
	$buscarProducto -> codigoProducto = $_POST["letras"];
	$buscarProducto -> venderProducto();
}
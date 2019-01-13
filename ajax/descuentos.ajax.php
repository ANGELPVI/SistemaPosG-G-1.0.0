<?php

require_once "../controladores/descuentos.controlador.php";
require_once "../modelos/descuentos.modelo.php";

class AjaxDescuentos{

	/*=============================================
	EDITAR DESCUENTO
	=============================================*/	

	public $idDescuento;

	public function ajaxEditarDescuento(){

		$item = "id";
		$valor = $this->idDescuento;

		$respuesta = ControladorDescuentos::ctrMostrarDescuentos($item, $valor);

		echo json_encode($respuesta);


	}

	/*=============================================
	VALIDAR NO REPETIR DESCUENTO
	=============================================*/	

	public $validarDescuento;

	public function ajaxValidarDescuento(){

		$item = "nombre";
		$valor = $this->validarDescuento;

		$respuesta = ControladorDescuentos::ctrMostrarDescuentos($item, $valor);

		echo json_encode($respuesta);

	}


}

/*=============================================
EDITAR DESCUENTO
=============================================*/	

if(isset($_POST["idDescuento"])){

	$descuento = new AjaxDescuentos();
	$descuento -> idDescuento = $_POST["idDescuento"];
	$descuento -> ajaxEditarDescuento();

}

/*=============================================
VALIDAR NO REPETIR DESCUENTO
=============================================*/

if(isset( $_POST["validarDescuento"])){

	$valDescuento= new AjaxDescuentos();
	$valDescuento -> validarDescuento = $_POST["validarDescuento"];
	$valDescuento -> ajaxValidarDescuento();

}
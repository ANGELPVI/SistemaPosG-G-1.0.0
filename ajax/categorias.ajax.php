<?php
require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";
class AjaxCategorias{
	/*=============================================
	EDITAR CATEGORÍA
	=============================================*/	
	public $idCategoria;
	public function ajaxEditarCategoria(){
		$item = "id";
		$valor = $this->idCategoria;
		$respuesta = ControladorCategorias::ctrMostrarCategorias($item, $valor);
		echo json_encode($respuesta);
	}

	/*=============================================
	VALIDAR NO REPETIR CATEGORIA
	=============================================*/	
	public $validarCategoria;
	public function ajaxValidarCategoria(){
		$item = "categoria";
		$valor = $this->validarCategoria;
		$respuesta = ControladorCategorias::ctrMostrarCategorias($item, $valor);
		echo json_encode($respuesta);
	}
}

/*=============================================
EDITAR CATEGORÍA
=============================================*/	
if(isset($_POST["idCategoria"])){
	$categoria = new AjaxCategorias();
	$categoria -> idCategoria = $_POST["idCategoria"];
	$categoria -> ajaxEditarCategoria();
}

/*=============================================
VALIDAR NO REPETIR CATEGORIA
=============================================*/
if(isset( $_POST["validarCategoria"])){
	$valCategoria= new AjaxCategorias();
	$valCategoria -> validarCategoria = $_POST["validarCategoria"];
	$valCategoria -> ajaxValidarCategoria();
}
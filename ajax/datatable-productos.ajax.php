<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";


require_once "../controladores/proveedores.controlador.php";
require_once "../modelos/proveedores.modelo.php";

class TablaProductos{

  /*=============================================
  MOSTRAR LA TABLA DE PRODUCTO
  =============================================*/ 
  public function mostrarTabla(){ 
  	$item=null;
  	$valor=null;

  	$productos = ControladorProductos::ctrMostrarProductos($item, $valor);

  	

  	$datosJson = '{
	  "data": [';

	  for ($i=0; $i < count($productos); $i++) { 

		$item = "id";
		$valor = $productos[$i]["id_categoria"];
		$categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);

		$item3="id";
		$valor3 = $productos[$i]["id_proveedor"];
		$proveedores = ControladorProveedores::ctrMostrarProveedores($item3, $valor3);
  		// Imagen de los productos
  		$imagen="<img src='".$productos[$i]["imagen"]."' width='40px'>";

  		// Botones de acciones
  		$botones="<div class='btn-group'><button class='btn btn-warning btnEditarProducto' idProducto='".$productos[$i]["id"]."' data-toggle='modal' data-target='#modalEditarProducto'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarProducto' idProducto='".$productos[$i]["id"]."' codigo='".$productos[$i]["codigo"]."' imagen='".$productos[$i]["imagen"]."'><i class='fa fa-times'></i></button></div>";

  		// Definir el color del stock
  		if ($productos[$i]["stock"]<=5) {
  			$stock="<button class='btn btn-danger'>".$productos[$i]["stock"]."</buton>";
  		}else if ($productos[$i]["stock"]>11 && $productos[$i]["stock"]<=15) {
  			$stock="<button class='btn btn-warning'>".$productos[$i]["stock"]."</buton>";
  		}else{
  			$stock="<button class='btn btn-success'>".$productos[$i]["stock"]."</buton>";
  			
  		}
	  	
	  	$datosJson.= '[
	      "'.($i+1).'",
	      "'.$productos[$i]["descripcion"].'",
	      "'.$proveedores["nombre"].'",
	      "'.$categorias["categoria"].'",
	      "'.$imagen.'",
	      "'.$productos[$i]["codigo"].'",
	      "<strong>$'.number_format($productos[$i]["precio_compra"],2).'</strong>",
	      "<strong>$'.number_format($productos[$i]["precio_venta"],2).'</strong>",
	      "'.$stock.'",
	      "'.$botones.'"

	    ],';
	  }

	  	$datosJson=substr($datosJson, 0, -1);

	    $datosJson.=' ]
	   	}';

	   	echo $datosJson;

  }

}
/*=============================================
ACTIVAR TABLA DE PRODUCTOS
=============================================*/ 
$activar = new TablaProductos();
$activar -> mostrarTabla();
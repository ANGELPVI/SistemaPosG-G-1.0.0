<?php

require_once '../controladores/ventas.controlador.php';
require_once '../modelos/ventas.modelo.php';

class TablaProductos{

  /*=============================================
  MOSTRAR LA TABLA DE PRODUCTO A VENDER
  =============================================*/

 static public function mostrarTabla(){
  	$respuesta=ControladorVentas::ctrMostrarVenta();

  	echo json_encode($respuesta);

  }
}

/*=============================================
ACTIVAR TABLA DE PRODUCTOS A VENDER
=============================================*/

$activar = new TablaProductos();
$activar -> mostrarTabla();

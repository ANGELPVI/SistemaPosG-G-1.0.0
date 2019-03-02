<?php


/**
 * Clase de crear ventas
 */
class ControlCrearVenta{

// Buscar productos a vender
	static public function ctlBuscarProducto($valor){

		$productoVenta=ModeloCrearVenta::mdlBuscarProducto($valor);

		 return $productoVenta;

	}
// Agregar los productos al carrito
	static public function ctlagregarProductoCarrito($idProducto,$idUsua){
		$agregarProduc=ModeloCrearVenta::mdlagregarProducto($idProducto,$idUsua);
		return $agregarProduc;
	}

	//Mostrar productos a vender
	static public function ctlmostrarProductos($idU){
		$mostrarProduc=ModeloCrearVenta::mdlmostrarProductosVenta($idU);
		return $mostrarProduc;
	}

}

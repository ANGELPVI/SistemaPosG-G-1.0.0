<?php 


/**
 * Clase de crear ventas
 */
class ControlCrearVenta{

	static public function ctlBuscarProducto($valor){

		$productoVenta=ModeloCrearVenta::mdlBuscarProducto($valor);

		 return $productoVenta;
		
	}
	
}




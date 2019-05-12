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
	static public function ctlagregarProductoCarrito($cP,$idU,$membreciaPorBusqueda){
		$agregarProduc=ModeloCrearVenta::mdlagregarProducto($cP,$idU,$membreciaPorBusqueda);
		return $agregarProduc;
	}

	//Mostrar productos a vender
	static public function ctlmostrarProductos($idU){
		$mostrarProduc=ModeloCrearVenta::mdlmostrarProductosVenta($idU);
		return $mostrarProduc;
	}
	//Eliminar productos del carrito de compras
	static public function ctlEliminarProducto($eliminarProducto,$eliminarVendedor,$pregunta,$agregarBotonMen){
		$eliminarProducto=ModeloCrearVenta::mdlEliminarProductoCarrito($eliminarProducto,$eliminarVendedor,$pregunta,$agregarBotonMen);
		return $eliminarProducto;
	}
	// Agregar producto al carrito de compra por lector de barra
	static public function ctlAgregarProductoPorCodigo($codigo,$vendedor,$descuentoMembre){
		$agregarProductoCodigo=ModeloCrearVenta::mdlAgregarProductoPorCodigo($codigo,$vendedor,$descuentoMembre);
		return $agregarProductoCodigo;

	}

	//COLECCION DE CONCRETAR VENTA
	static public function ctlColeccion($idU){
		$mostrarProduc=ModeloCrearVenta::mdlColeccion($idU);
		return $mostrarProduc;
	}

	//FINALIZAR LA VENTA DE Productos
	static public function ctlFinalizarVenta($cV,$coleccion,$membre){

		if ($membre>0){
				$carri=ModeloCrearVenta::mdlColeccion($cV);
				foreach ($carri as $key => $value) {
					$catualizarVentaPro=ModeloCrearVenta::mdlActualizaCampoVentaPro($value["cantidad"],$value["codigo"]);
				}
				 $finalizarVenta=ModeloCrearVenta::mdlFinalizarVenta($cV,$coleccion,$membre);
		}else{
			$carri=ModeloCrearVenta::mdlColeccion($cV);
			foreach ($carri as $key => $value) {
				$catualizarVentaPro=ModeloCrearVenta::mdlActualizaCampoVentaPro($value["cantidad"],$value["codigo"]);
			}
			 $finalizarVenta=ModeloCrearVenta::mdlFinalizarVenta($cV,$coleccion,$membre);
		}
			return $finalizarVenta;
	}

	//Vender productos por mayoreo
	static public function ctlVentaPorMayoreo(){
		$verProductoMayoreo=ModeloCrearVenta:: mdlVentaPorMayoreo();
		return $verProductoMayoreo;
	}
	//Sacar total por mayoreo de los productos
	static public function ctlmayoreoProducto($idPro){
		$mayoreoVenta=ModeloCrearVenta::mdlMayoreoVenta($idPro);
		return $mayoreoVenta;
	}
	// agregar al carrito de compra por mayoreo
	static public function ctlVentaM($codigoProduMayoreo,$cantidad,$total,$idUsuaMayoreo,$ventaMayoreoMem){
		$ventaMayor=ModeloCrearVenta::mdlVentaMayor($codigoProduMayoreo,$cantidad,$total,$idUsuaMayoreo,$ventaMayoreoMem);
		return $ventaMayor;

	}
	// Eliminar productos del carrito de compra por mayoreo
	static public function ctlEliminarMayoreo($eliminarVendedorMayoreo,$eliminarProductoMayoreo,$eliminarCantidadMayoreo){
		$eliminarMayoreo=ModeloCrearVenta::mdlEliminarProductoMayoreo($eliminarVendedorMayoreo,$eliminarProductoMayoreo,$eliminarCantidadMayoreo);
		return $eliminarMayoreo;
	}
	//Buscar membrecia
	static public function ctlBuscarMembrecia($membrecia){
		$ctlBuscarMembrecia=ModeloCrearVenta::mdlBuscarMembrecia($membrecia);
		return $ctlBuscarMembrecia;
	}
}

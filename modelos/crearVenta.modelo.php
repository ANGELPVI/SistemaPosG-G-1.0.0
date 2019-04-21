<?php
// Crear ventas
require_once "conexion.php";
class ModeloCrearVenta{

	/*=============================================
	BUSCAR PRODUCTO PARA VENDER
	=============================================*/

	static public function mdlBuscarProducto($valor){

		$stmt = Conexion::conectar()->prepare("SELECT id,descripcion, codigo,stock FROM productos WHERE descripcion LIKE '$valor%' OR codigo LIKE '$valor%'
		ORDER BY descripcion ASC");

		if($stmt->execute()){

			return $stmt->fetchAll();

		}else{

			return "error";

		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	AGREGAR PRODUCTO AL CARRITO DE COMPRAS
	=============================================*/
	static public function mdlagregarProducto($cp,$idusu){
		$stmt=Conexion::conectar()->prepare("CALL carrito_compra(:idpro,:idusu);");
		$stmt->bindParam(":idpro",$cp,PDO::PARAM_INT);
		$stmt->bindParam(":idusu",$idusu,PDO::PARAM_INT);
		if ($stmt->execute()) {
			return "ok";
		}else{
			return "error";
		}

		$stmt->close();
		$stmt=null;

	}

	/*=============================================
	MOSTRAR PRODUCTOS A VENDER
	=============================================*/
	static public function mdlmostrarProductosVenta($idUsua){
		$stmt=Conexion::conectar()->prepare("CALL MostrarProducto(:idU)");
		$stmt->bindParam(":idU",$idUsua,PDO::PARAM_INT);
			 if ($stmt->execute()) {
			 	return $stmt;
			}else{
				return "Error de consulta";
			}
			$stmt->close();
			$stmt=null;
	}
	/*=============================================
	ELIMINAR PRODUCTOS DEL CARRITO DE COMPRAS
	=============================================*/
	static public function mdlEliminarProductoCarrito($eliminarProducto,$eliminarVendedor,$pregunta){
		$stmt=conexion::conectar()->prepare("CALL elimina_agregar(:produc,:vendedor,:pregunta)");
		$stmt->bindParam(":produc",$eliminarProducto,PDO::PARAM_INT);
		$stmt->bindParam(":vendedor",$eliminarVendedor,PDO::PARAM_INT);
		$stmt->bindParam(":pregunta",$pregunta,PDO::PARAM_STR);
		if ($stmt->execute()) {
			return; 'ok';
		}else{
			return "error";
		}
		$stmt->close();
		$stmt=null;
	}

	/*=============================================
	AGREGAR PRODUCTO AL CARRITO POR LECTOR DE BARRA
	=============================================*/
	static public function mdlAgregarProductoPorCodigo($codigo,$vendedor){
		$stmt=Conexion::conectar()->prepare("CALL agregarPorLector(:producto,:vendedor)");
		$stmt->bindParam(":producto",$codigo,PDO::PARAM_INT);
		$stmt->bindParam(":vendedor",$vendedor,PDO::PARAM_STR);
		if ($stmt->execute()) {
			return $stmt->fetch();
		}else{
			return 'Error de conexion con la base de datos, llamar a servicio técnico';
		}
		$stmt->close();
		$stmt=null;

	}

	/*=============================================
	Coleccion de datos concretarVenta
	=============================================*/
	static public function mdlColeccion($idUsua){
		$stmt=Conexion::conectar()->prepare("CALL coleccionDeVenta(:idU)");
		$stmt->bindParam(":idU",$idUsua,PDO::PARAM_INT);
			 if ($stmt->execute()) {
			 	return $stmt->fetchAll();
			}else{
				return "Error de consulta";
			}
			$stmt->close();
			$stmt=null;
	}

	/*=============================================
	Finalizar la venta
	=============================================*/
	static public function mdlFinalizarVenta($idVendedor,$produc){
		$stmt=Conexion::conectar()->prepare("CALL ConcretarVenta(:idVendedor,:productos)");
		$stmt->bindParam(":idVendedor",$idVendedor,PDO::PARAM_INT);
		$stmt->bindParam(":productos",$produc,PDO::PARAM_STR);
		if ($stmt->execute()){
					return $stmt->fetch();
		}else{
			return "Error de conexion, consulte a soporte tecnico";
		}
		$stmt->close();
		$stmt=null;

	}

	/*=============================================
	Sacar las copias e impresiones para veder por mayoreo
	=============================================*/
	static public function mdlVentaPorMayoreo(){
		$stmt=Conexion::conectar()->prepare("SELECT * FROM productos");
		if ($stmt->execute()){
					return $stmt->fetchAll();
		}else{
			return "Error de conexion, consulte a soporte tecnico";
		}
		$stmt->close();
		$stmt=null;
	}
	/*=============================================
	Sacar el total por mayoreo de productos
	=============================================*/
	static public function mdlMayoreoVenta($idPro){
		$stmt=Conexion::conectar()->prepare("SELECT precio_venta FROM productos WHERE codigo=:producto");
		$stmt->bindParam(":producto",$idPro,PDO::PARAM_INT);
		if ($stmt->execute()){
					return $stmt->fetch();
		}else{
			return "Error de conexion, consulte a soporte tecnico";
		}
		$stmt->close();
		$stmt=null;
	}
	/*=============================================
	Agregar al carrito venta por mayoreo
	=============================================*/
	static public function mdlVentaMayor($codigoProduMayoreo,$cantidad,$total,$idUsuaMayoreo){
		$stmt=Conexion::conectar()->prepare("CALL ventaPorMayoreo(:producto,:cantidad,:total,:vendedor)");
		$stmt->bindParam(":producto",$codigoProduMayoreo,PDO::PARAM_STR);
		$stmt->bindParam(":cantidad",$cantidad,PDO::PARAM_INT);
		$stmt->bindParam(":total",$total,PDO::PARAM_INT);
		$stmt->bindParam(":vendedor",$idUsuaMayoreo,PDO::PARAM_INT);
		if ($stmt->execute()){
					return $stmt->fetch();
		}else{
			return "Error de conexion, consulte a soporte tecnico";
		}
		$stmt->close();
		$stmt=null;
	}
	/*=============================================
	ELIMINAR PRODUCTOS DEL CARRITO POR MAYOREO
	=============================================*/
	static public function mdlEliminarProductoMayoreo($eliminarVendedorMayoreo,$eliminarProductoMayoreo,$eliminarCantidadMayoreo){
	$stmt=Conexion::conectar()->prepare("CALL eliminatPorMayoreo(:producto,:vendedor,:cantidad)");
		$stmt->bindParam(":producto",$eliminarProductoMayoreo,PDO::PARAM_STR);
	$stmt->bindParam(":vendedor",$eliminarVendedorMayoreo,PDO::PARAM_INT);
	$stmt->bindParam(":cantidad",$eliminarCantidadMayoreo,PDO::PARAM_INT);
	if ($stmt->execute()){
				return $stmt->fetch();
	}else{
		return "Error de conexion, consulte a soporte tecnico";
	}
	$stmt->close();
	$stmt=null;
}
}

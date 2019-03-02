<?php
// Crear ventas
require_once "conexion.php";
class ModeloCrearVenta{

	/*=============================================
	BUSCAR PRODUCTO PARA VENDER
	=============================================*/

	static public function mdlBuscarProducto($valor){

		$stmt = Conexion::conectar()->prepare("SELECT id,descripcion, codigo,stock FROM productos WHERE descripcion LIKE '$valor%' OR codigo LIKE '$valor%'");

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
}

<?php 
// Crear ventas
require_once "conexion.php";
class ModeloCrearVenta{

	/*=============================================
	BUSCAR PRODUCTO PARA VENDER
	=============================================*/

	static public function mdlBuscarProducto($valor){

		$stmt = Conexion::conectar()->prepare("SELECT descripcion FROM productos WHERE descripcion LIKE '$valor%'");

		// $stmt->bindParam(":id",$datos, PDO::PARAM_STR);

		if($stmt->execute()){

			return $stmt->fetchAll();

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}
}




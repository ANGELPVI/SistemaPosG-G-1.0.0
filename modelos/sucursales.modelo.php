<?php 
// código ausente (NO SE OCUPA EN ESTE SISTEMA) sucursales vista
require_once "conexion.php";
/**
* Ángel Piña
*/
class ModeloSucursales{

	// registrar Sucursales
	static public function mdlRegistroSucursal($tabla,$datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(rfc,nombre,direccion,telefono,email,fecha) VALUES (:rfc,:nombre,:direccion,:tel,:email,:fecha)");
		$stmt->bindParam(":rfc", $datos["rfc"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["sucursal"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":tel", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["dia"], PDO::PARAM_STR);
		
		if($stmt->execute()){

			return "ok";	

		}else{

			return "error";
		
		}

		$stmt->close();
		
		$stmt = null;
	}


	// mostrar sucursales
	static public function mdlMostrarSucursales($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
				
		if($stmt->execute()){

			return $stmt->fetchAll();	

		}else{

			return "error";
		
		}

		$stmt->close();
		
		$stmt = null;

	}


	// Editar Sucursales
	static public function mdlEditarSucursal($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET rfc=:rfc,nombre=:nombre,direccion=:direccion,telefono=:tel,email=:email WHERE id=:id");

		$stmt->bindParam(":rfc", $datos["rfc"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["sucursal"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":tel", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_STR);
		
		if($stmt->execute()){

			return "editarok";	

		}else{

			return "error";
		
		}

		$stmt->close();
		
		$stmt = null;
		
	}

	// Eliminar Sucursales
	static public function mdlEliminarSucursal($tablas,$id){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tablas  WHERE id=:id");
		$stmt->bindParam(":id",$id,PDO::PARAM_STR);
		
		if($stmt->execute()){

			return "eliminarok";	

		}else{

			return "error";
		
		}

		$stmt->close();
		
		$stmt = null;
		
	}


	
	
}

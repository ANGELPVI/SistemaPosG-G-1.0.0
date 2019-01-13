<?php 

/**
* Ángel Piña
*/
require_once 'conexion.php';

class ModeloMovimientos{

	// Visualizar los movimientos
	static public function mdlMostrarMovimiento(){
	$stmt = Conexion::conectar()->prepare("SELECT m.id AS id,m.estado AS estado,m.cantidad,p.descripcion,s.nombre 
										   AS sucursal,u.nombre AS usuario,m.fecha_movimiento FROM productos p 
										   JOIN movimientso m ON m.id_producto=p.id
										   JOIN sucursales s ON s.id=m.id_sucursal
										   JOIN usuarios u ON u.id=m.id_vendedor");

		if($stmt->execute()){

			return $stmt->fetchAll();

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;


	}

	// Alerta de movimientos
	static public function mdlAlertaMovimiento(){
		$stmt = Conexion::conectar()->prepare("SELECT COUNT(id) AS id FROM movimientso WHERE estado='En proceso'");

		if($stmt->execute()){

			return $stmt->fetch();

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;
		
	}

	
}
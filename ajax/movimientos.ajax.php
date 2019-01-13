<?php 

/**
* Ángel Piña
*/
require_once '../controladores/movimientos.controlador.php';
require_once '../modelos/movimientos.modelo.php';

class AjaxMovimientso{

	public $notificacion;

	// Alerta de Movimientos
	static public function ajaxMovimiento(){
		// $dato=$this->notificacion;
		$respuesta=ModeloMovimientos::mdlAlertaMovimiento();

		if($respuesta=="error"){

			echo "error de conexión";

		}else{
			echo json_encode($respuesta);

		
		}
	}
	
}


if (isset($_POST["nuemroNotificacion"])) {
	$numeroDeNotificacion=new AjaxMovimientso();
	$numeroDeNotificacion->notificacion=$_POST["nuemroNotificacion"];
	$numeroDeNotificacion->ajaxMovimiento();
}
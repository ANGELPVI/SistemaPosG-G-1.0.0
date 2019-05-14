<?php
class ControladorVentas{
	/*=============================================
	MOSTRAR VENTAS
	=============================================*/
	static public function ctrMostrarVentas($item, $valor){
		$tabla = "ventas";
		$respuesta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);
		return $respuesta;
	}



	/*=============================================
	EDITAR VENTA
	=============================================*/
	static public function ctrEditarVenta(){
		if(isset($_POST["editarVenta"])){
			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
			=============================================*/
			$tabla = "ventas";
			$item = "codigo";
			$valor = $_POST["editarVenta"];
			$traerVenta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);
			$productos =  json_decode($traerVenta["productos"], true);
			$totalProductosComprados = array();
			foreach ($productos as $key => $value) {
				array_push($totalProductosComprados, $value["cantidad"]);
				$tablaProductos = "productos";
				$item = "id";
				$valor = $value["id"];
				$orden = "id";
				$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);
				$item1a = "ventas";
				$valor1a = $traerProducto["ventas"] - $value["cantidad"];
				$nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);

				$item1b = "stock";
				$valor1b = $value["cantidad"] + $traerProducto["stock"];

				$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);

			}

			$tablaClientes = "clientes";
			$itemCliente = "id";
			$valorCliente = $_POST["seleccionarCliente"];

			$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $itemCliente, $valorCliente);

			$item1a = "compras";
			$valor1a = $traerCliente["compras"] - array_sum($totalProductosComprados);
			$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valorCliente);

			/*=============================================
			ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
			=============================================*/
			$listaProductos_2 = json_decode($_POST["listaProductos"], true);
			$totalProductosComprados_2 = array();
			foreach ($listaProductos_2 as $key => $value) {
				array_push($totalProductosComprados_2, $value["cantidad"]);
				$tablaProductos_2 = "productos";
				$item_2 = "id";
				$valor_2 = $value["id"];
				$orden = "id";
				$traerProducto_2 = ModeloProductos::mdlMostrarProductos($tablaProductos_2, $item_2, $valor_2, $orden);
				$item1a_2 = "ventas";
				$valor1a_2 = $value["cantidad"] + $traerProducto_2["ventas"];
				$nuevasVentas_2 = ModeloProductos::mdlActualizarProducto($tablaProductos_2, $item1a_2, $valor1a_2, $valor_2);
				$item1b_2 = "stock";
				$valor1b_2 = $value["stock"];
				$nuevoStock_2 = ModeloProductos::mdlActualizarProducto($tablaProductos_2, $item1b_2, $valor1b_2, $valor_2);
			}

			$tablaClientes_2 = "clientes";

			$item_2 = "id";
			$valor_2 = $_POST["seleccionarCliente"];
			$traerCliente_2 = ModeloClientes::mdlMostrarClientes($tablaClientes_2, $item_2, $valor_2);
			$item1a_2 = "compras";
			$valor1a_2 = array_sum($totalProductosComprados_2) + $traerCliente_2["compras"];
			$comprasCliente_2 = ModeloClientes::mdlActualizarCliente($tablaClientes_2, $item1a_2, $valor1a_2, $valor_2);
			$item1b_2 = "ultima_compra";
			date_default_timezone_set('America/Bogota');
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$valor1b_2 = $fecha.' '.$hora;
			$fechaCliente_2 = ModeloClientes::mdlActualizarCliente($tablaClientes_2, $item1b_2, $valor1b_2, $valor_2);

			/*=============================================
			GUARDAR CAMBIOS DE LA COMPRA
			=============================================*/
			$datos = array("id_vendedor"=>$_POST["idVendedor"],
						   "id_cliente"=>$_POST["seleccionarCliente"],
						   "codigo"=>$_POST["editarVenta"],
						   "productos"=>$_POST["listaProductos"],
						   "impuesto"=>$_POST["nuevoPrecioImpuesto"],
						   "neto"=>$_POST["nuevoPrecioNeto"],
						   "total"=>$_POST["totalVenta"],
						   "metodo_pago"=>$_POST["listaMetodoPago"]);

			$respuesta = ModeloVentas::mdlEditarVenta($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
				localStorage.removeItem("rango");
				swal({
					  type: "success",
					  title: "La venta ha sido editada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
								window.location = "ventas";
								}
							})
				</script>';
			}

		}

	}

	/*=============================================
	ELIMINAR VENTA
	=============================================*/
	static public function ctrEliminarVenta(){
		if (isset($_GET["idVenta"])&&isset($_GET["cliente"])) {
			//desformatiar el json de la base de datos
			$tabla="ventas";
			$item="id";
			$valor=$_GET["idVenta"];
			$cliente=$_GET["cliente"];
			$ProductosVendidos = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);
			$ProductosVendidos["productos"];
			$productos = json_decode($ProductosVendidos["productos"], true);
			if (isset($productos)&&$cliente==0){

				foreach (	$productos as $key => $value) {
					$respuestaEliminar=ModeloVentas::mdlEliminarVenta($valor,$value["cantidad"],$value["codigo"]);
				}
				$eliminarTablaVenta=ModeloVentas::mdlEliminarTablaVenta($valor);
			}else{

				foreach (	$productos as $key => $value) {
					$respuestaEliminar=ModeloVentas::mdlEliminarVenta($valor,$value["cantidad"],$value["codigo"]);
				}
					$actualizarVentaCliente=ModeloVentas::mdlActualizarClienteVenta($cliente);
					$eliminarTablaVenta=ModeloVentas::mdlEliminarTablaVenta($valor);
			}

			if (isset($respuestaEliminar)) {
							echo'<script>
							swal({
									type: "success",
									title: "La venta ha sido borrada correctamente",
									showConfirmButton: true,
									confirmButtonText: "Cerrar"
									}).then(function(result){
											if (result.value){
											window.location = "ventas";
											}
										})

							</script>';
		}else {
		}

		}
	}

	/*=============================================
	RANGO FECHAS
	=============================================*/

	static public function ctrRangoFechasVentas($fechaInicial, $fechaFinal){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;

	}

	/*=============================================
	DESCARGAR EXCEL
	=============================================*/

	public function ctrDescargarReporte(){

		if(isset($_GET["reporte"])){

			$tabla = "ventas";

			if(isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])){

				$ventas = ModeloVentas::mdlRangoFechasVentas($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);

			}else{

				$item = null;
				$valor = null;

				$ventas = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

			}


			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/

			$Name = $_GET["reporte"].'.xls';

			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate");
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public");
			header('Content-Disposition:; filename="'.$Name.'"');
			header("Content-Transfer-Encoding: binary");

			echo utf8_decode("<table border='0'>

					<tr>
					<td style='font-weight:bold; border:1px solid #eee;'>CÓDIGO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CLIENTE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>VENDEDOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PRODUCTOS</td>
					<td style='font-weight:bold; border:1px solid #eee;'>IMPUESTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NETO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>
					<td style='font-weight:bold; border:1px solid #eee;'>METODO DE PAGO</td
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>
					</tr>");

			foreach ($ventas as $row => $item){

				$cliente = ControladorClientes::ctrMostrarClientes("id", $item["id_cliente"]);
				$vendedor = ControladorUsuarios::ctrMostrarUsuarios("id", $item["id_vendedor"]);

			 echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>".$item["codigo"]."</td>
			 			<td style='border:1px solid #eee;'>".$cliente["nombre"]."</td>
			 			<td style='border:1px solid #eee;'>".$vendedor["nombre"]."</td>
			 			<td style='border:1px solid #eee;'>");

			 	$productos =  json_decode($item["productos"], true);

			 	foreach ($productos as $key => $valueProductos) {

			 			echo utf8_decode($valueProductos["cantidad"]."<br>");
			 		}

			 	echo utf8_decode("</td><td style='border:1px solid #eee;'>");

		 		foreach ($productos as $key => $valueProductos) {

		 			echo utf8_decode($valueProductos["descripcion"]."<br>");

		 		}

		 		echo utf8_decode("</td>
					<td style='border:1px solid #eee;'>$ ".number_format($item["impuesto"],2)."</td>
					<td style='border:1px solid #eee;'>$ ".number_format($item["neto"],2)."</td>
					<td style='border:1px solid #eee;'>$ ".number_format($item["total"],2)."</td>
					<td style='border:1px solid #eee;'>".$item["metodo_pago"]."</td>
					<td style='border:1px solid #eee;'>".substr($item["fecha"],0,10)."</td>
		 			</tr>");


			}


			echo "</table>";

		}

	}


	/*=============================================
	SUMA TOTAL VENTAS
	=============================================*/

	static public function ctrSumaTotalVentas(){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlSumaTotalVentas($tabla);

		return $respuesta;

	}

}

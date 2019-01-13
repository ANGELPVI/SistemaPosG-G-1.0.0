<?php
class ControladorCompras{
	/*=============================================
	MOSTRAR COMPRAS
	=============================================*/
	static public function ctrMostrarCompras($item, $valor){
		$tabla = "compras";
		$respuesta = ModeloCompras::mdlMostrarCompras($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	CREAR COMPRA
	=============================================*/
	static public function ctrCrearCompra(){
		if(isset($_POST["nuevaCompra"])){
			/*=============================================
			ACTUALIZAR LAS VENTAS DEL PROVEEDOR Y AUMENTAR EL STOCK 
			=============================================*/
			$listaProductos = json_decode($_POST["listaProductos"], true);
			$totalProductosComprados = array();
			foreach ($listaProductos as $key => $value) {
			   	array_push($totalProductosComprados, $value["cantidad"]);		
			   	$tablaProductos = "productos";
			    $item = "id";
			    $valor = $value["id"];
			    $orden = "id";

			    $traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);

				$item1b = "stock_almacen";
				$valor1b = $value["stock"];

				$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);

			}

			$tablaProveedores = "proveedores";

			$item = "id";
			$valor = $_POST["seleccionarProveedor"];

			$traerProveedor = ModeloProveedores::mdlMostrarProveedores($tablaProveedores, $item, $valor);

			$item1a = "ventas";
			$valor1a = array_sum($totalProductosComprados) + $traerProveedor["ventas"];

			$comprasPr = ModeloProveedores::mdlActualizarProveedor($tablaProveedores, $item1a, $valor1a, $valor);

			$item1b = "ultima_venta";

			date_default_timezone_set('America/Monterrey');

			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$valor1b = $fecha.' '.$hora;

			$fechaProveedor = ModeloProveedores::mdlActualizarProveedor($tablaProveedores, $item1b, $valor1b, $valor);

			/*=============================================
			GUARDAR LA COMPRA
			=============================================*/	

			$tabla = "compras";

			$datos = array("id_proveedor"=>$_POST["seleccionarProveedor"],
						   "id_comprador"=>$_POST["nuevoComprador"],
						   "codigo"=>$_POST["nuevaCompra"],
						   "productos"=>$_POST["listaProductos"],
						   "total"=>$_POST["totalCompra"]);

			$respuesta = ModeloCompras::mdlIngresarCompra($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "La compra ha sido guardada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "compras";

								}
							})

				</script>';

			}

		}

	}

	/*=============================================
	EDITAR COMPRA
	=============================================*/
	static public function ctrEditarCompra(){
		if(isset($_POST["editarCompra"])){
			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE PROVEEDORES
			=============================================*/
			$tabla = "compras";
			$item = "codigo";
			$valor = $_POST["editarCompra"];
			$traerCompra = ModeloCompras::mdlMostrarCompras($tabla, $item, $valor);
			$productos =  json_decode($traerCompra["productos"], true);
			$totalProductosComprados = array();
			foreach ($productos as $key => $value) {
				array_push($totalProductosComprados, $value["cantidad"]);				
				$tablaProductos = "productos";
				$item = "id";
				$valor = $value["id"];
				$orden = "id";
				$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);
				$item1b = "stock_almacen";
				$valor1b = $value["cantidad"] - $traerProducto["stock_almacen"];
				$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);
			}
			$tablaProveedores = "proveedores";
			$itemProveedor = "id";			
			$valorProveedor = $_POST["seleccionarProveedor"];
			$traerProveedor = ModeloProveedores::mdlMostrarProveedores($tablaProveedores, $itemProveedor, $valorProveedor);

			$item1a = "ventas";
			$valor1a = $traerProveedor["ventas"] - array_sum($totalProductosComprados);
			$comprasProveedor = ModeloProveedores::mdlActualizarProveedor($tablaProveedores, $item1a, $valor1a, $valorProveedor);

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

				$item1b_2 = "stock_almacen";
				$valor1b_2 = $value["stock"];
				$nuevoStock_2 = ModeloProductos::mdlActualizarProducto($tablaProductos_2, $item1b_2, $valor1b_2, $valor_2);
			}

			$tablaProveedores_2 = "proveedores";
			$item_2 = "id";
			$valor_2 = $_POST["seleccionarProveedor"];
			$traerProveedor_2 = ModeloProveedores::mdlMostrarProveedores($tablaProveedores_2, $item_2, $valor_2);
			$item1a_2 = "ventas";
			$valor1a_2 = array_sum($totalProductosComprados_2) + $traerProveedor_2["ventas"];
			$comprasProveedor_2 = ModeloProveedores::mdlActualizarProveedor($tablaProveedores_2, $item1a_2, $valor1a_2, $valor_2);
			$item1b_2 = "ultima_venta";
			date_default_timezone_set('America/Monterrey');
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$valor1b_2 = $fecha.' '.$hora;
			$fechaCliente_2 = ModeloProveedores::mdlActualizarProveedor($tablaProveedores_2, $item1b_2, $valor1b_2, $valor_2);

			/*=============================================
			GUARDAR CAMBIOS DE LA COMPRA
			=============================================*/	
			$datos = array("id_proveedor"=>$_POST["seleccionarProveedor"],
						   "id_comprador"=>$_POST["nuevoComprador"],
						   "codigo"=>$_POST["editarCompra"],
						   "productos"=>$_POST["listaProductos"],
						   "total"=>$_POST["totalVenta"]);
			$respuesta = ModeloCompras::mdlEditarCompra($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
				localStorage.removeItem("rango");
				swal({
					  type: "success",
					  title: "La compra ha sido editada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
								window.location = "compras";
								}
							})

				</script>';
			}
		}
	}
	/*=============================================
	ELIMINAR COMPRA
	=============================================*/
	static public function ctrEliminarCompra(){

		if(isset($_GET["idCompra"])){

			$tabla = "compras";

			$item = "id";
			$valor = $_GET["idCompra"];

			$traerCompra = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

			/*=============================================
			ACTUALIZAR FECHA ÚLTIMA COMPRA
			=============================================*/

			$tablaProveedores = "proveedores";
			$itemCompras = null;
			$valorCompras = null;
			$traerCompras = ModeloVentas::mdlMostrarVentas($tabla, $itemCompras, $valorCompras);

			$guardarFechas = array();

			foreach ($traerCompras as $key => $value) {
				
				if($value["id_proveedor"] == $traerCompra["id_proveedor"]){

					array_push($guardarFechas, $value["fecha"]);

				}

			}

			if(count($guardarFechas) > 1){

				if($traerCompra["fecha"] > $guardarFechas[count($guardarFechas)-2]){

					$item = "ultima_compra";
					$valor = $guardarFechas[count($guardarFechas)-2];
					$valorIdProveedor = $traerCompra["id_proveedor"];

					$ventasProveedor = ModeloProveedores::mdlActualizarProveedor($tablaproveedores, $item, $valor, $$traerCompra);

				}else{

					$item = "ultima_compra";
					$valor = $guardarFechas[count($guardarFechas)-1];
					$valorIdProveedor = $traerCompra["id_proveedor"];

					$ventasProveedor = ModeloProveedores::mdlActualizarProveedor($tablaProveedores, $item, $valor, $valorIdProveedor);

				}


			}else{

				$item = "ultima_compra";
				$valor = "0000-00-00 00:00:00";
				$valorIdProveedor = $traerCompra["id_proveedor"];

				$ventasProveedor = ModeloProveedores::mdlActualizarProveedor($tablaProveedores, $item, $valor, $valorIdProveedor);

			}

			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE PROVEEDORES
			=============================================*/

			$productos =  json_decode($traerCompra["productos"], true);

			$totalProductosComprados = array();

			foreach ($productos as $key => $value) {

				array_push($totalProductosComprados, $value["cantidad"]);
				
				$tablaProductos = "productos";

				$item = "id";
				$valor = $value["id"];
				$orden = "id";

				$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);



				$item1b = "stock_almacen";
				$valor1b = $value["cantidad"] - $traerProducto["stock_almacen"];

				$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);

			}

			$tablaProveedores = "proveedores";

			$itemProveedor = "id";
			$valorProveedor = $traerCompra["id_proveedor"];

			$traerCliente = ModeloProveedores::mdlMostrarProveedores($tablaProveedores, $itemProveedor, $valorProveedor);

			$item1a = "ventas";
			$valor1a = $traerCliente["ventas"] - array_sum($totalProductosComprados);

			$ventasProveedor = ModeloProveedores::mdlActualizarProveedor($tablaProveedores, $item1a, $valor1a, $valorProveedor);

			/*=============================================
			ELIMINAR VENTA
			=============================================*/

			$respuesta = ModeloCompras::mdlEliminarCompra($tabla, $_GET["idCompra"]);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "La compra ha sido borrada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "compras";

								}
							})

				</script>';

			}		
		}

	}

	/*=============================================
	RANGO FECHAS
	=============================================*/	
	static public function ctrRangoFechasCompras($fechaInicial, $fechaFinal){

		$tabla = "compras";

		$respuesta = ModeloCompras::mdlRangoFechasCompras($tabla, $fechaInicial, $fechaFinal);

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
					<td style='font-weight:bold; border:1px solid #eee;'>PROVEEDOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PRODUCTOS</td>
					<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
					</tr>");

			foreach ($ventas as $row => $item){

				$proveedor = ControladorProveedores::ctrMostrarProveedores("id", $item["id_proveedor"]);

			 echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>".$item["codigo"]."</td> 
			 			<td style='border:1px solid #eee;'>".$proveedor["nombre"]."</td>
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
					<td style='border:1px solid #eee;'>$ ".number_format($item["total"],2)."</td>
					<td style='border:1px solid #eee;'>".substr($item["fecha"],0,10)."</td>		
		 			</tr>");


			}


			echo "</table>";

		}

	}

	/*=============================================
	SUMA TOTAL VENTAS
	=============================================*/
	static public function ctrSumaTotalCompras(){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlSumaTotalVentas($tabla);

		return $respuesta;

	}

}
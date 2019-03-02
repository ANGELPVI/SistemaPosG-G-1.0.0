<?php
require_once '../controladores/crearVenta.controlador.php';
require_once '../modelos/crearVenta.modelo.php';

/**
 * Buscar productos para vender
 */
class BuscarProductoVenta{

	public $codigoProducto;
	public $cP;
	public $idU;
	public $idUsuaVenta;
	public $totalVenta;

	public $eliminarProducto;
	public $eliminarVendedor;
	public $pregunta;


	public function venderProducto(){
		$valor = $this->codigoProducto;
		$p=ControlCrearVenta::ctlBuscarProducto($valor);
			echo json_encode($p);
	}

	public function agregarProductoCarrito(){
		$cP=$this->cP;
		$idU=$this->idU;
		$agregar=ControlCrearVenta::ctlagregarProductoCarrito($cP,$idU);
		echo $agregar;

	}

	public function mostrarProduvtoVenta(){
		$ventaTotal=0;
		$idUsuaVenta=$this->idUsuaVenta;
		 $mostraProductos=ControlCrearVenta::ctlmostrarProductos($idUsuaVenta);
		while ($row=$mostraProductos->fetch(PDO::FETCH_ASSOC)){
			if ($row["stock"]==0) {
				echo '
				<tr>
					<td>'.$row["codigo"].'</td>
					<td>'.$row["descripcion"].'</td>
					<td>$'.$row["precio_venta"].'</td>
					<td>'.$row["cantidad"].'</td>
					<td>$'.$row["Total"].'</td>
					<td>
					<div class="btn-group">
					<button disabled class="btn btn-success" data-agreIdVendedor="'.$row["id_carrito_vendedor"].'" data-agreIdProduc="'.$row["id_carrito_producto"].'"><i class="fa fa-plus"></i></button>
					<button class="btn btn-danger" data-idVendedor="'.$row["id_carrito_vendedor"].'" data-idProduc="'.$row["id_carrito_producto"].'"><i class="fa fa-times"></i></button>
					</div>
					</td>
				</tr>';

			}else{
				echo '
				<tr>
					<td>'.$row["codigo"].'</td>
					<td>'.$row["descripcion"].'</td>
					<td>$'.$row["precio_venta"].'</td>
					<td>'.$row["cantidad"].'</td>
					<td>$'.$row["Total"].'</td>
					<td>
					<div class="btn-group">
					<button class="btn btn-success" data-agreIdVendedor="'.$row["id_carrito_vendedor"].'" data-agreIdProduc="'.$row["id_carrito_producto"].'"><i class="fa fa-plus"></i></button>
					<button class="btn btn-danger" data-idVendedor="'.$row["id_carrito_vendedor"].'" data-idProduc="'.$row["id_carrito_producto"].'"><i class="fa fa-times"></i></button>
					</div>
					</td>
				</tr>';

			}

		}

	}

	public function totalVentaProductos(){
		$sumaTotalVenta=0;
		$totalVenta=$this->totalVenta;
		 $mostraProductos=ControlCrearVenta::ctlmostrarProductos($totalVenta);
		while ($row=$mostraProductos->fetch(PDO::FETCH_ASSOC)){
					$sumaTotalVenta+=$row["Total"];
		}
		echo '<strong>Total: $'.$sumaTotalVenta.'</strong>';

	}

	public function eliminarProducto(){
		 $eliminarProducto=$this->eliminarProducto;
		 $eliminarVendedor=$this->eliminarVendedor;
		 $pregunta=$this->pregunta;
		 $eliminarProductosTabla=ControlCrearVenta::ctlEliminarProducto($eliminarProducto,$eliminarVendedor,$pregunta);
		 echo $eliminarProductosTabla;

	}

}


/*=============================================
BUSCA EL PRODUCTO PARA VENDER
=============================================*/
if (isset($_POST["letras"])){
	$buscarProducto=new BuscarProductoVenta();
	$buscarProducto -> codigoProducto = $_POST["letras"];
	$buscarProducto -> venderProducto();
}
/*=============================================
AGREGA EL PRODUCTO AL CARRITO DE COMPRAS
=============================================*/
if (isset($_POST["codigoProdu"])&&isset($_POST["idUsua"])) {
	$agregarProducto=new BuscarProductoVenta();
	$agregarProducto->cP=$_POST["codigoProdu"];
	$agregarProducto->idU=$_POST["idUsua"];
	$agregarProducto->agregarProductoCarrito();

}

/*=============================================
MUESTRA LOS PRODUCTOS QUE ESTAN EN EL CARRITO DE COMPRAS
=============================================*/
if (isset($_POST["idUsuaVenta"])) {
	$mostrarProductos=new BuscarProductoVenta();
	$mostrarProductos->idUsuaVenta=$_POST["idUsuaVenta"];
	$mostrarProductos->mostrarProduvtoVenta();

}
/*=============================================
MOSTRAR EL TOTAL DE LA VENTA
=============================================*/
if (isset($_POST["totalVenta"])) {
	$mostrarProductos=new BuscarProductoVenta();
	$mostrarProductos->totalVenta=$_POST["totalVenta"];
	$mostrarProductos->totalVentaProductos();
}

/*=============================================
ELIMINAR PRODUCTO DEL CARRITO DE COMPRAS
=============================================*/
if (isset($_POST["producto"])&&isset($_POST["vendedor"])&&isset($_POST["pregunta"])){
	$eliminarProductoCarrito=new BuscarProductoVenta();
	$eliminarProductoCarrito->eliminarProducto=$_POST["producto"];
	$eliminarProductoCarrito->eliminarVendedor=$_POST["vendedor"];
	$eliminarProductoCarrito->pregunta=$_POST["pregunta"];
	$eliminarProductoCarrito->eliminarProducto();
}

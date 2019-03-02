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
		$idUsuaVenta=$this->idUsuaVenta;
		 $mostraProductos=ControlCrearVenta::ctlmostrarProductos($idUsuaVenta);
		while ($row=$mostraProductos->fetch(PDO::FETCH_ASSOC)){
			echo '
			<tr>
				<td>'.$row["codigo"].'</td>
				<td>'.$row["descripcion"].'</td>
				<td>$'.$row["precio_venta"].'</td>
				<td>'.$row["cantidad"].'</td>
				<td>$'.$row["Total"].'</td>
				<td><div class="btn-group"><button class="btn btn-success"><i class="fa fa-plus"></i></button><button class="btn btn-danger"><i class="fa fa-times"></i></button></div></td>
			</tr>';
		}
	}

}



if (isset($_POST["letras"])){
	$buscarProducto=new BuscarProductoVenta();
	$buscarProducto -> codigoProducto = $_POST["letras"];
	$buscarProducto -> venderProducto();
}

if (isset($_POST["codigoProdu"])&&isset($_POST["idUsua"])) {
	$agregarProducto=new BuscarProductoVenta();
	$agregarProducto->cP=$_POST["codigoProdu"];
	$agregarProducto->idU=$_POST["idUsua"];
	$agregarProducto->agregarProductoCarrito();

}


if (isset($_POST["idUsuaVenta"])) {
	$mostrarProductos=new BuscarProductoVenta();
	$mostrarProductos->idUsuaVenta=$_POST["idUsuaVenta"];
	$mostrarProductos->mostrarProduvtoVenta();

}

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

	public $codigo;
	public $vendedor;

	public $concretarVen;

	public $cV;
	public $coleccion;
	public $membre;

	public $mayoreoProduc;

	public $codigoProduMayoreo;
	public $idUsuaMayoreo;
	public $cantidad;
	public $total;

	public $eliminarVendedorMayoreo;
	public $eliminarProductoMayoreo;
	public $eliminarCantidadMayoreo;

	public $membrecia;

	// variables la cuales definen si hay descuento
	public $descuentoMembre;
	public $membreciaPorBusqueda;
	public $ventaMayoreoMem;
	public $agregarBotonMen;

	public function venderProducto(){
		$valor = $this->codigoProducto;
		$p=ControlCrearVenta::ctlBuscarProducto($valor);
		while ($row=$p->fetch(PDO::FETCH_ASSOC)) {
			if ($row["stock"]==="0") {
					echo '<li class="list-group-item disabled">'.$row["descripcion"].'<span class="badge badge-danger badge-pill">'.$row["stock"].'</span></li>';
			}else{
					echo '<a href="#" style="border-top:2px solid #ffffff" class="list-group-item list-group-item-action active" data-co="'.$row["id"].'">'.$row["descripcion"].'<span class="badge badge-primary badge-pill">'.$row["stock"].'</span></a>';

			}
		}
			//echo json_encode($p);
	}

	public function agregarProductoCarrito(){
		$cP=$this->cP;
		$idU=$this->idU;
		$membreciaPorBusqueda=$this->membreciaPorBusqueda;
		$agregar=ControlCrearVenta::ctlagregarProductoCarrito($cP,$idU,$membreciaPorBusqueda);
		echo $agregar["msj"];


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
					<td>$'.number_format($row["carrito_costo"],2).'</td>
					<td>'.$row["cantidad"].'</td>
					<td>$'.$row["carrito_total"].'</td>
					<td>
					<div class="btn-group">
					<button disabled class="btn btn-success" data-agreIdVendedor="'.$row["carrito_vendedor"].'" data-agreIdProduc="'.$row["carrito_id_producto"].'"><i class="fa fa-plus"></i></button>
					<button class="btn btn-warning" data-idVendedor="'.$row["carrito_vendedor"].'" data-idProduc="'.$row["carrito_id_producto"].'"><i class="fa fa-minus"></i></button>
					<button class="btn btn-danger" data-cantidad="'.$row["cantidad"].'" data-vendedor="'.$row["carrito_vendedor"].'" data-producto="'.$row["codigo"].'"><i class="fa fa-trash-o"></i></button>
					</div>
					</td>
				</tr>';

			}else{
				echo '
				<tr>
					<td>'.$row["codigo"].'</td>
					<td>'.$row["descripcion"].'</td>
					<td>$'.number_format($row["carrito_costo"],2).'</td>
					<td>'.$row["cantidad"].'</td>
					<td>$'.$row["carrito_total"].'</td>
					<td>
					<div class="btn-group">
					<button class="btn btn-success" data-agreIdVendedor="'.$row["carrito_vendedor"].'" data-agreIdProduc="'.$row["carrito_id_producto"].'"><i class="fa fa-plus"></i></button>
					<button class="btn btn-warning" data-idVendedor="'.$row["carrito_vendedor"].'" data-idProduc="'.$row["carrito_id_producto"].'"><i class="fa fa-minus"></i></button>
					<button class="btn btn-danger" data-cantidad="'.$row["cantidad"].'" data-vendedor="'.$row["carrito_vendedor"].'" data-producto="'.$row["codigo"].'"><i class="fa fa-trash-o"></i></button>
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
					$sumaTotalVenta+=$row["carrito_total"];
		}
		echo '<strong>Total: $<span id="totalV">'.$sumaTotalVenta.'</span></strong>';

	}

	public function eliminarProducto(){
		 $eliminarProducto=$this->eliminarProducto;
		 $eliminarVendedor=$this->eliminarVendedor;
		 $pregunta=$this->pregunta;
		 $agregarBotonMen=$this->agregarBotonMen;
		 $eliminarProductosTabla=ControlCrearVenta::ctlEliminarProducto($eliminarProducto,$eliminarVendedor,$pregunta,$agregarBotonMen);
		 echo $eliminarProductosTabla;

	}

	public function ventaProducto(){
		$codigo=$this->codigo;
		$vendedor=$this->vendedor;
		$descuentoMembre=$this->descuentoMembre;
		$agregarProductoPorCodigo=ControlCrearVenta::ctlAgregarProductoPorCodigo($codigo,$vendedor,$descuentoMembre);
		echo $agregarProductoPorCodigo["msj"];


	}

	public function concretarVenta(){
		$idU=$this->concretarVen;
		$terminarVenta=ControlCrearVenta::ctlColeccion($idU);
		echo json_encode($terminarVenta);
	}

	public function finDeVenta(){
		$cV=$this->cV;
		$coleccion=$this->coleccion;
		$membre=$this->membre;
		$finalizarVenta=ControlCrearVenta::ctlFinalizarVenta($cV,$coleccion,$membre);
		echo $finalizarVenta["msj"];
		//echo $finalizarVenta;

	}

	public function totalPorMayoreo(){
		$mayoreoProduc=$this->mayoreoProduc;
		$mayoreoProducto=ControlCrearVenta::ctlmayoreoProducto($mayoreoProduc);
		echo $mayoreoProducto["precio_venta"];
	}

	public function FunctionName(){
		$codigoProduMayoreo=$this->codigoProduMayoreo;
		$idUsuaMayoreo=$this->idUsuaMayoreo;
		$cantidad=$this->cantidad;
		$total=$this->total;
		$ventaMayoreoMem=$this->ventaMayoreoMem;
		$ventaM=ControlCrearVenta::ctlVentaM($codigoProduMayoreo,$cantidad,$total,$idUsuaMayoreo,$ventaMayoreoMem);
		echo $ventaM["msj"];
	}

	public function eliminarCarritoProductoMayoreo(){
		$eliminarVendedorMayoreo=$this->eliminarVendedorMayoreo;
		$eliminarProductoMayoreo=$this->eliminarProductoMayoreo;
		$eliminarCantidadMayoreo=$this->eliminarCantidadMayoreo;
		$repustaEliminarMayoreo=ControlCrearVenta::ctlEliminarMayoreo($eliminarVendedorMayoreo,$eliminarProductoMayoreo,$eliminarCantidadMayoreo);
		echo $repustaEliminarMayoreo["msj"];

	}
	public function buscarDatosMemnrecia(){
		$membrecia=$this->membrecia;
		$ajaxBuscarMembrecia=ControlCrearVenta::ctlBuscarMembrecia($membrecia);
		echo json_encode($ajaxBuscarMembrecia);

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
if (isset($_POST["codigoProdu"])&&isset($_POST["idUsua"])&&isset($_POST["membreciaPorBusqueda"])) {
	$agregarProducto=new BuscarProductoVenta();
	$agregarProducto->cP=$_POST["codigoProdu"];
	$agregarProducto->idU=$_POST["idUsua"];
	$agregarProducto->membreciaPorBusqueda=$_POST["membreciaPorBusqueda"];
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
ELIMINAR O AGREGAR PRODUCTO DEL CARRITO DE COMPRAS
=============================================*/
if (isset($_POST["producto"])&&isset($_POST["vendedor"])&&isset($_POST["pregunta"])&&isset($_POST["agregarBotonMen"])){
	$eliminarProductoCarrito=new BuscarProductoVenta();
	$eliminarProductoCarrito->eliminarProducto=$_POST["producto"];
	$eliminarProductoCarrito->eliminarVendedor=$_POST["vendedor"];
	$eliminarProductoCarrito->pregunta=$_POST["pregunta"];
	$eliminarProductoCarrito->agregarBotonMen=$_POST["agregarBotonMen"];
	$eliminarProductoCarrito->eliminarProducto();
}

/*=============================================
AGREGAR PRODUCTOS POR CÓDIGO DE BARRA
=============================================*/
if (isset($_POST["codi"])&&isset($_POST["ven"])&&isset($_POST["descuentoMembre"])){
		$agreagarProductoPorCodigo=new BuscarProductoVenta();
		$agreagarProductoPorCodigo->codigo=$_POST["codi"];
		$agreagarProductoPorCodigo->vendedor=$_POST["ven"];
		$agreagarProductoPorCodigo->descuentoMembre=$_POST["descuentoMembre"];
		$agreagarProductoPorCodigo->ventaProducto();
}

/*=============================================
COLECCION DE CONCRETAR VENTA
=============================================*/
if (isset($_POST["concretarVendedor"])) {
$terminarLaVenta=new BuscarProductoVenta();
$terminarLaVenta->concretarVen=$_POST["concretarVendedor"];
$terminarLaVenta->concretarVenta();
}

/*=============================================
CONCRETAR VENTA
=============================================*/
if (isset($_POST["cV"])&&isset($_POST["coleccion"])&&isset($_POST["membre"])){
	$finalizarVenta=new BuscarProductoVenta();
	$finalizarVenta->cV=$_POST["cV"];
	$finalizarVenta->coleccion=$_POST["coleccion"];
	$finalizarVenta->membre=$_POST["membre"];
	$finalizarVenta->finDeVenta();
}
/*=============================================
SACAR TOTAL POR MAYOREO DE PRODUCTO
=============================================*/
if (isset($_POST["mayoreoProducto"])) {
	$mayoreoVentaProducto=new BuscarProductoVenta();
	$mayoreoVentaProducto->mayoreoProduc=$_POST["mayoreoProducto"];
	$mayoreoVentaProducto->totalPorMayoreo();
}
/*=============================================
IGRESAR DATOS AL CARRITO POR MAYOREO
=============================================*/
if(isset($_POST["codigoProduMayoreo"])&&isset($_POST["idUsuaMayoreo"])&&isset($_POST["cantidad"])&&isset($_POST["total"])&&isset($_POST["ventaMayoreoMem"])){
	$ventaMayoreo=new BuscarProductoVenta();
	$ventaMayoreo->codigoProduMayoreo=$_POST["codigoProduMayoreo"];
	$ventaMayoreo->idUsuaMayoreo=$_POST["idUsuaMayoreo"];
	$ventaMayoreo->cantidad=$_POST["cantidad"];
	$ventaMayoreo->total=$_POST["total"];
	$ventaMayoreo->ventaMayoreoMem=$_POST["ventaMayoreoMem"];
	$ventaMayoreo->FunctionName();
}
/*=============================================
ELIMINAR PRODUCTOS DEL CARRITO POR MAYOREO
=============================================*/
if (isset($_POST["eliminarVendedorMayoreo"])&&isset($_POST["eliminarProductoMayoreo"])&&isset($_POST["eliminarCantidadMayoreo"])){
	$eliminarMayoreo=new BuscarProductoVenta();
	$eliminarMayoreo->eliminarVendedorMayoreo=$_POST["eliminarVendedorMayoreo"];
	$eliminarMayoreo->eliminarProductoMayoreo=$_POST["eliminarProductoMayoreo"];
	$eliminarMayoreo->eliminarCantidadMayoreo=$_POST["eliminarCantidadMayoreo"];
	$eliminarMayoreo->eliminarCarritoProductoMayoreo();
}

/*=============================================
BUSCAR MEMBRECIA
=============================================*/
if (isset($_POST["membrecia"])){
	$buscarMembrecia=new BuscarProductoVenta();
	$buscarMembrecia->membrecia=$_POST["membrecia"];
	$buscarMembrecia->buscarDatosMemnrecia();
}

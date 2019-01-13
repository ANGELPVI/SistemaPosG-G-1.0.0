<div class="content-wrapper">
  <section class="content-header">
    <h1> 
      Administrar compras (En proceso)
    </h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>      
      <li class="active">Administrar compras</li>
    </ol>
  </section>
  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <a href="crear-compra">
          <button class="btn btn-success">
            <i class="fa fa-plus"></i> Agregar compra
          </button>
        </a>
         <button type="button" class="btn btn-default pull-right" id="daterange-btn">
            <span>
              <i class="fa fa-calendar"></i> Rango de fecha
            </span>
            <i class="fa fa-caret-down"></i>
         </button>
      </div>
      <div class="box-body">
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
        <thead>
         <tr>           
           <th style="width:10px">#</th>
           <th>Código factura</th>
           <th>Proveedor</th>
           <th>Metodo de pago</th>
           <th>Total</th> 
           <th>Fecha</th>
           <th>Acciones</th>
         </tr> 
        </thead>
        <tbody>
        <?php
          if(isset($_GET["fechaInicial"])){
            $fechaInicial = $_GET["fechaInicial"];
            $fechaFinal = $_GET["fechaFinal"];
          }else{
            $fechaInicial = null;
            $fechaFinal = null;
          }
          $respuesta = ControladorCompras::ctrRangoFechasCompras($fechaInicial, $fechaFinal);
          foreach ($respuesta as $key => $value) {
           echo '<tr>
                  <td>'.($key+1).'</td>
                  <td>'.$value["codigo"].'</td>';
                  $itemProveedor = "id";
                  $valorProveedor = $value["id_proveedor"];
                  $respuestaProveedor = ControladorProveedores::ctrMostrarProveedores($itemProveedor, $valorProveedor);
                  echo '<td>'.$respuestaProveedor["nombre"].'</td>
                  <td>$ '.number_format($value["total"],2).'</td>
                  <td>'.$value["fecha"].'</td>
                  <td>
                    <div class="btn-group">                      
                      <button class="btn btn-info btnImprimirFactura2" codigoCompra="'.$value["codigo"].'">
                        <i class="fa fa-print"></i>
                      </button>';
                      if($_SESSION["perfil"] == "Super Administrador"){
                      echo '<button class="btn btn-warning btnEditarCompra" idCompra="'.$value["id"].'"><i class="fa fa-pencil"></i></button>
                      <button class="btn btn-danger btnEliminarCompra" idCompra="'.$value["id"].'"><i class="fa fa-times"></i></button>';
                    }
                    echo '</div>  
                  </td>
                </tr>';
            }
        ?>     
        </tbody>
       </table>
       <?php
      $eliminarCompra = new ControladorCompras();
      $eliminarCompra -> ctrEliminarCompra();
      ?> 
      </div>
    </div>
  </section>
</div>

<script type="text/javascript">
  //Mostrar acivos el menú y submenús.
  var elemento = document.getElementById("liCompras");
  var elemento1 = document.getElementById("liCompras1");
  elemento.className += " active";
  elemento1.className += " active";
</script>
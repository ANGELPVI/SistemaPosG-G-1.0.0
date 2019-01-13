<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Administrar Movimientso   
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Movimientos</li>
    
    </ol>

  </section>

  <section class="content">
    
    <div class="box">
      <div class="box-header whth-border">
 
      </div>
      <!-- inicio del cuerpo -->
      <div class="box-body">
      <table class="table table-bordered table-striped dt-responsive tablas" width="100%"">
      	<thead>
      		<tr>
      			<th style="width: 10px;">#</th>
      			<th>Sucursal</th>
      			<th>Vendedor</th>
      			<th>Producto</th>
      			<th>Cantidad</th>
      			<th>Fecha</th>
      			<th>Estado</th>
      		</tr>
      	</thead>
      	<tbody>
      		<?php
      		$datos=ControladorMovimientos::ctrMostrarMovimientos();

      		foreach ($datos as $key => $value) {
      			echo '

      			<tr>
	      			<td>'.$value["id"].'</td>
	      			<td>'.$value["sucursal"].'</td>
	      			<td>'.$value["usuario"].'</td>
	      			<td>'.$value["descripcion"].'</td>
	      			<td>'.$value["cantidad"].'</td>
	      			<td>'.$value["fecha_movimiento"].'</td>
	      			<td><button type="button" class="btn btn-default btn-xs b" >'.$value["estado"].'</button></td>
      			</tr>';
      		}

      		 ?>
      		
      	</tbody>
      </table>        
      </div>
    </div>
  </section>
</div>

<script type="text/javascript">
  //Mostrar acivos el menú y submenús.
  var elemento = document.getElementById("liMovimientos");
  elemento.className += " active";
</script>
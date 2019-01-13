<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Administrar Descuentos
    </h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar Descuentos</li>
    </ol>
  </section>
  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-success" data-toggle="modal" data-target="#modalAgregarDescuento">        
          <i class="fa fa-plus"></i> Agregar Descuento
        </button>
      </div>
      <div class="box-body">
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">  
        <thead> 
        <?php
          $item = null;
          $valor = null;
          $usuarios = ControladorDescuentos::ctrMostrarDescuentos($item, $valor); 
          echo '<tr> 
            <th style="width:10px">#</th>
            <th>Nombre</th>
            <th>Porcentaje de Descuento</th>
            <th>Acciones</th>
          </tr> 
        </thead>
        <tbody>';
        foreach ($usuarios as $key => $value){
          echo '<tr>
            <td>'.($key+1).'</td>
            <td>'.$value["nombre"].'</td>
            <td>'.$value["descuento"].'</td>';          
              echo '<td>
                <div class="btn-group">              
                  <button class="btn btn-warning btnEditarDescuento" idDescuento="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarDescuento"><i class="fa fa-pencil"></i></button>
                </div>  
              </td>
          </tr>';
        }
        ?> 
        </tbody>
       </table>
      </div>
    </div>
  </section>
</div>

<!--=====================================
MODAL AGREGAR DESCUENTO
======================================-->
<div id="modalAgregarDescuento" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar descuento</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA EL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-tag"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoNombre" id="nuevoNombre" placeholder="Ingresar nombre" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL DESCUENTO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-percent"></i></span> 
                <input type="number" class="form-control input-lg" name="nuevoDescuento" id="nuevoDescuento" placeholder="Ingresar descuento en porcentaje" required>
              </div>
            </div>
          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar descuento</button>
        </div>
        <?php
          $crearDescuento = new ControladorDescuentos();
          $crearDescuento -> ctrCrearDescuento();
        ?>
      </form>
    </div>
  </div>
</div>

<!--=====================================
MODAL EDITAR DESCUENTO
======================================-->
<div id="modalEditarDescuento" class="modal fade" role="dialog">  
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar usuario</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <input type="hidden" name="editarId" id="editarId">
            <!-- ENTRADA PARA EL NOMBRE -->            
            <div class="form-group">              
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-tag"></i></span> 
                <input type="text" class="form-control input-lg" id="editarNombre" name="editarNombre" value="" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL DESCUENTO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-percent"></i></span> 
                <input type="number" class="form-control input-lg" id="editarDescuento" name="editarDescuento" placeholder="Ingresar descuento en Porcentaje" required>
              </div>
            </div>
          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Modificar descuento</button>
        </div>
      <?php
          $editarDescuento = new ControladorDescuentos();
          $editarDescuento -> ctrEditarDescuento();
      ?> 
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  //Mostrar acivos el menú y submenús.
  var elemento = document.getElementById("liClientes");
  var elemento2 = document.getElementById("liClientes1");
  elemento.className += " active";
  elemento2.className += " active";
</script>
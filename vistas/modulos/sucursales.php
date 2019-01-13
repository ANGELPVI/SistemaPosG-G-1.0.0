<!-- código ausente (NO SE OCUPA EN ESTE SISTEMA) sucursales vista-->
<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Administrar Sucursales    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Sucursales</li>
    
    </ol>

  </section>

  <section class="content">
    
    <div class="box">
      <div class="box-header whth-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarSucursal">
          Agregar Sucursal
        </button>
      </div>
      <!-- inicio del cuerpo -->
      <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
          <thead>
            <tr>
              <th style="width: 10px">#</th>
              <th >RFC</th>
              <th >Sucursal</th>
              <th >Dirección</th>
              <th>Teléfono</th>
              <th >Email</th>
              <th >Fecha</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>

          <?php 

         

          $sucursales=ControladorSucursal::ctrMostrarSucursal();

          foreach ($sucursales as $key => $value) {
            echo' 

                  <tr>
                  <td>'.$value["id"].'</td>
                  <td>'.$value["rfc"].'</td>
                  <td>'.$value["nombre"].'</td>
                  <td>'.$value["direccion"].'</td>
                  <td>'.$value["telefono"].'</td>
                  <td>'.$value["email"].'</td>
                  <td>'.$value["fecha"].'</td>
                  <td>
                  <div class="btn-group">
                  <button class="btn btn-warning ediatarSucursal" data-toggle="modal" data-target="#editarSucursal"
                  edtarId="'.$value["id"].'"
                  editarRc="'.$value["rfc"].'"
                  editarNombre="'.$value["nombre"].'"
                  editarDireccion="'.$value["direccion"].'"
                  editarTel="'.$value["telefono"].'"
                  editarEmail="'.$value["email"].'"><i class="fa fa-pencil"></i></button>

                  <button class="btn btn-danger eliminarSucursal" eliminarId="'.$value["id"].'"><i class="fa fa-times"></i></button>
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

<!-- ventana modal que permite el registro de nuevas sucursales -->
<!-- Modal -->
<div id="modalAgregarSucursal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" method="post">
      <div class="modal-header" style="background:#3c8dbc; color:white">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agregar Sucursal</h4>
      </div>

      <div class="modal-body">
       <div class="box-body">
         <!-- entrdra para el rfc -->
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
            <input type="text" class="form-control input-lg" name="nuvoRfc" placeholder="Ingresar Rfc" required maxlength="13">
          </div>
        </div>
        <!-- fin entrdra para el rfc -->

        <!-- entrdra para el nombre de la sucursal -->
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-building"></i></span>
            <input type="text" class="form-control input-lg" name="nuvaSucursal" placeholder="Ingresar Nombre De Sucursal" required>
          </div>
        </div>
        <!-- fin entrdra para el nombre de la sucursal -->

        <!-- entrdra para la dirección -->
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
            <input type="text" class="form-control input-lg" name="nuvaDireccion" placeholder="Ingresar Dirección" required>
          </div>
        </div>
        <!-- fin entrdra para la dirección -->

        <!-- entrdra para el teléfono -->
        <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
              <input type="phone" id="phone" class="form-control input-lg" name="nuevoTelefono" placeholder="Ingresar número de telefono o celular" data-inputmask="'mask':'(999) 999-9999'" data-mask required>
            </div>
        </div>
        <!-- fin entrdra para el teléfono -->
        
        <!-- entrdra para el email -->
        <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 
                <input type="email" class="form-control input-lg" name="nuevoEmail" placeholder="Ingresar Correo Electrónico" required>
              </div>
        </div>
         <!-- fin email -->
       </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>

      <?php 
        $crearSucuarsal=new ControladorSucursal();
        $crearSucuarsal-> ctrRegistroSucursal();
      ?>
      </form>
    </div>

  </div>
</div>
<!-- Fin ventana modal de regstro de nuevas sucursales -->


<!-- ventana modal que permite editar las sucursales -->
<!-- Modal -->
<div id="editarSucursal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" method="post">
      <div class="modal-header" style="background:#3c8dbc; color:white">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Editar Sucursal</h4>
      </div>

      <div class="modal-body">
       <div class="box-body">

         <!-- entrdra para el id -->
            <input type="hidden" class="form-control input-lg" id="id" name="id">
        <!-- fin entrdra para el id -->

         <!-- entrdra para el rfc -->
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
            <input type="text" class="form-control input-lg" id="rfc" name="editarRfc" required maxlength="13">
          </div>
        </div>
        <!-- fin entrdra para el rfc -->

        <!-- entrdra para el nombre de la sucursal -->
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-building"></i></span>
            <input type="text" class="form-control input-lg" id="sucursal" name="editarSucursal" required>
          </div>
        </div>
        <!-- fin entrdra para el nombre de la sucursal -->

        <!-- entrdra para la dirección -->
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
            <input type="text" class="form-control input-lg" id="sucursalDireccion" name="editarDireccion" required>
          </div>
        </div>
        <!-- fin entrdra para la dirección -->

        <!-- entrdra para el teléfono -->
        <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
              <input type="phone" id="nuevophone" class="form-control input-lg"  name="editarTelefono" data-inputmask="'mask':'(999) 999-9999'" data-mask required>
            </div>
        </div>
        <!-- fin entrdra para el teléfono -->
        
        <!-- entrdra para el email -->
        <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 
                <input type="email" class="form-control input-lg" id="sucursalEmail" name="editarEmail" required>
              </div>
        </div>
         <!-- fin email -->
       </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
      </div>

      <?php 
         $editarSucursal=new ControladorSucursal();
         $editarSucursal->ctrEditarSucursal();
      ?>
      </form>
    </div>

  </div>
</div>
<!-- Fin ventana modal editar sucursles -->

<script type="text/javascript">
  //Mostrar acivos el menú y submenús.
  var elemento = document.getElementById("liSucursales");
  elemento.className += " active";
</script>
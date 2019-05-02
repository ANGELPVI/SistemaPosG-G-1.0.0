<div class="content-wrapper">

  <section class="content-header">

    <h1>

      venta

    </h1>

    <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Crear venta</li>

    </ol>

  </section>

  <section class="content">
  <!--=========================================
      Panel que muestra los productos a vender
  =============================================-->
    <div class="row">
      <div class="col-lg-8 col-xs-12">
        <div class="box box-success">
          <div class="box-header">Productos</div>
            <!--=========================================
              Tabla que muetra los productos a vender
            =============================================-->
          <div class="box-body">
            <table class="table dt-responsive">
              <thead>
                <tr>
                  <th>Código</th>
                  <th>Producto</th>
                  <th>Costo</th>
                  <th>Cantidad</th>
                  <th>Total</th>
                  <th>Acción</th>
                </tr>
              </thead>

              <tbody id="productosVentas"></tbody>

            </table>
          </div>

          <div class="box-footer">
            <h4><strong id="mebreciaDesc">Descuento:</strong></h4>
            <h4 id="totalVenta"></h4>
            <h4><strong id="cambio">Cambio:</strong></h4>
          </div>
          <!-- Barra de progreso de la venta -->
          <div class="progress" style="display: none;">
            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
              <span class="sr-only">40% Complete (success)</span>
            </div>
          </div>

          <!-- Alerta de error de venta -->
          <div class="alert alert-danger" role="alert" style="display:none;">
              <strong>Error!</strong> no está registrando productos para vender o no está cobrando la venta.
          </div>
        </div>
      </div>

      <div class="col-lg-4 hidden-md hidden-sm hidden-xs">
         <div class="box box-danger">

          <div class="box-header">Panel De Venta</div>
          <div class="box-body">

              <form class="" method="post" id="formCodigo">
                <div class="form-group">
                    <label for="producto">Código del proucto</label>
                     <input type="text" class="form-control" name="producto" id="porCodigo" placeholder="Ejemplo: 1030" pattern="[0-9]*" required="true">
                     <p class="text-danger" style="display:none;">Error, <strong>el producto está agotado o no exite</strong></p>
                </div>
              </form>
                <!-- Input de entraca para cobrar la venta -->
              <div class="form-group">
                   <label for="producto">Cobrar Venta</label>
                   <input type="text" class="form-control" name="producto" id="cobrarVenta" placeholder="Ejemplo: $100" pattern="[0-9]*" required="true">
              </div>

              <div class="form-group">
                <label for="">Buscar Producto</label>
                <input type="text" class="form-control" name="buscarProduct" id="busquedaProducto" placeholder="Ejemplo: 0912 o Libreta" required="true">
              </div>

              <?php echo '<input id="id_usuario_venta" type="hidden" value="'.$_SESSION["id"].'">'; ?>
              <input type="hidden" id="inputMembreciaAplicado" value="0">
            <!-- <div class="productos"></div> -->
            <div class="list-group"></div>

          </div>

        </div>

      </div>

    </div>

  </section>

</div>


<!--=====================================
MODAL VERDER POR MAYOREO
======================================-->
<div class="modal fade" id="modalCopiasBN" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <!--=====================================
         ENCABEZADO DEL MODAL
       ======================================-->
      <div class="modal-header" style="background:#080808; color:#ffffff">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Venta Por Mayoreo</h4>
      </div>

      <!--=====================================
         CUERPO DELMODAL
       ======================================-->
      <div class="modal-body">
        <div class="form-group">
          <form method="post" id="formCopiasBN">


               <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-th"></i></span>
                  <select class="form-control input-lg" name="copiasImpresion" required id="producto">
                     <option value="" selected disabled>Selecionar Producto</option>
                     <?php
                     $productoMayoreo = ControlCrearVenta::ctlVentaPorMayoreo();
                     foreach ($productoMayoreo as $key => $value) {
                        echo '<option value="'.$value["codigo"].'">'.$value["descripcion"].'</option>';
                     }
                     ?>
                  </select>
               </div><br>


            <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-shopping-cart"></i></span>
              <input id="inputCantidad" type="text" class="form-control" placeholder="Cantidad" autofocus="true" required="true" pattern="[0-9]*">
            </div><br>

            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-money"></i></span>
              <input id="inputTotal" type="text" class="form-control" placeholder="Total" autofocus="true" required="true" pattern="[0-9]*">
            </div>

        </div>
        <div class="alert alert-danger alertaMayoreo" role="alert" style="display:none"><strong>Error!</strong> no hay suficiente stock para concretar la venta.</div>
        <div class="alert alert-danger alerDeseleccion" role="alert" style="display:none"><strong>Error!</strong> verifique que esté seleccionando un producto.</div>
      </div>
      <!--=====================================
         FONDO DEL MODAL
       ======================================-->
      <div class="modal-footer">
          <button type="button" class="btn btn-defaul pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-success" >Ok</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!--=====================================
MODAL VENTA POR MENBRECIA
======================================-->
<div class="modal fade" id="modalMenbrecias" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <!--=====================================
         ENCABEZADO DEL MODAL
       ======================================-->
      <div class="modal-header" style="background:#3d5afe; color:#ffffff">
        <h4 class="modal-title">MEMBRECIA</h4>
      </div>

      <!--=====================================
         CUERPO DELMODAL
       ======================================-->
      <div class="modal-body">
        <div class="form-group">

            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
              <input id="inputMembrecia" type="text" name="membrecia"class="form-control" placeholder="Ingresa la Membrecia" autofocus="true" required="true" pattern="[0-9]*">
            </div><br>
        </div>
        <div class="row">
          <div class="col-lg-7">
            <h4 class="nombre">NOMBRE:</h4>
          </div>
          <div class="col-lg-5">
              <h4 class="ife">IFE:</h4>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-7">
            <h4 class="correo">CORREO:</h4>
          </div>
          <div class="col-lg-5">
            <h4 class="tel">TEL:</h4>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-7">
            <h4 class="descuento">DESCUENTO:</h4>
          </div>
        </div>

      </div>
      <div class="alert alert-danger alertaError" role="alert" style="margin:10px;display:none;"><strong>¡Error!</strong> no está ingresando datos validos. </div>
      <div class="alert alert-danger alertaErrorMembrecia" role="alert" style="margin:10px;display:none;"><strong>¡Error!</strong> no se encontró la membrecía. </div>
      <!--=====================================
         FONDO DEL MODAL
       ======================================-->
      <div class="modal-footer">
          <button type="button" class="btn btn-defaul pull-left salirMenbrecia" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-success membreciaAplicada">Ok</button>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">
  //Mostrar acivos el menú y submenús.
  var elemento = document.getElementById("liVentas");
  var elemento2 = document.getElementById("liVentas2");
  elemento.className += " active";
  elemento2.className += " active";
</script>

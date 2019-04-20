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
            <!-- <h5><strong>Descuento: %0</strong></h5> -->
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
              <strong>Error!</strong> no está registrando productos para vender o fallaron las conexiones del sistema.
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

            <!-- <div class="productos"></div> -->
            <div class="list-group"></div>

          </div>

        </div>

      </div>

    </div>

  </section>

</div>


<!--=====================================
MODAL COPIAS A BLANCO Y NEGRO
======================================-->
<div class="modal fade" id="modalCopiasBN" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <!--=====================================
         ENCABEZADO DEL MODAL
       ======================================-->
      <div class="modal-header" style="background:#33313b; color:#fff">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Copias a B/N</h4>
      </div>

      <!--=====================================
         CUERPO DELMODAL
       ======================================-->
      <div class="modal-body">
        <div class="form-group">
          <form method="post" id="formCopiasBN">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
              <input type="text" class="form-control" placeholder="Código De Producto" autofocus="true" required="true">
            </div>
        </div>
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
MODAL COPIAS A COLOR
======================================-->
<div class="modal fade" id="modalCopiasColor" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <!--=====================================
         ENCABEZADO DEL MODAL
       ======================================-->
      <div class="modal-header" style="background:blue; color:#fff">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Copias a Color</h4>
      </div>

      <!--=====================================
         CUERPO DELMODAL
       ======================================-->
      <div class="modal-body">
        <div class="form-group">
          <form method="post" id="formCopiasColor">

            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
              <input type="text" class="form-control" placeholder="Código De Producto" autofocus="true" required="true">
            </div>

            <div class="input-group" style="margin-top: 1em">
              <span class="input-group-addon"><i class="fa fa-usd"></i></span>
              <input type="text" class="form-control" placeholder="Costo Total" autofocus="true" required="true">
            </div>

        </div>
      </div>

      <!--=====================================
         FONDO DEL MODAL
       ======================================-->
      <div class="modal-footer">
        <button type="button" class="btn btn-defaul pull-left" data-dismiss="modal">Salir</button>
        <button type="submit" class="btn btn-success">Ok</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!--=====================================
MODAL IMPRESIÓN BLANCO Y NEGRO
======================================-->
<div class="modal fade" id="modalImpresionBN" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <!--=====================================
         ENCABEZADO DEL MODAL
       ======================================-->
      <div class="modal-header" style="background:#ff0000; color:#fff">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Impresión B/N</h4>
      </div>

      <!--=====================================
         CUERPO DELMODAL
       ======================================-->
      <div class="modal-body">
        <div class="form-group">
          <form method="post" id="formImprecionBN">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
              <input type="text" class="form-control" placeholder="Código De Producto" autofocus="true" required="true">
            </div>
        </div>
      </div>

      <!--=====================================
         FONDO DEL MODAL
       ======================================-->
      <div class="modal-footer">
        <button type="button" class="btn btn-defaul pull-left" data-dismiss="modal">Salir</button>
        <button type="submit" class="btn btn-success">Ok</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!--=====================================
MODAL IMPRESIÓN  A COLOR
======================================-->
<div class="modal fade" id="modalImpresionColor" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <!--=====================================
         ENCABEZADO DEL MODAL
       ======================================-->
      <div class="modal-header" style="background:#7d7d7d; color:#fff">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Impresión a Color</h4>
      </div>

      <!--=====================================
         CUERPO DELMODAL
       ======================================-->
      <div class="modal-body">
        <div class="form-group">
          <form method="post" id="formImprecionColor">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
              <input type="text" name="impreColor" class="form-control" placeholder="Código De Producto" autofocus="true" required="true">
            </div>
            <div class="input-group" style="margin-top: 1em">
                <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                <input type="text" name="impresionColorPrecio" class="form-control" placeholder="Costo Total" autofocus="true" required="true">
            </div>
        </div>
      </div>

      <!--=====================================
         FONDO DEL MODAL
       ======================================-->
      <div class="modal-footer">
        <button type="button" class="btn btn-defaul pull-left" data-dismiss="modal">Salir</button>
        <button type="submit" class="btn btn-success">Ok</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!--=====================================
MODAL PARA VENTA DE PRODUCTOS EXTENSOS
======================================-->
<div class="modal fade" id="modalProductoExtenso" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <!--=====================================
         ENCABEZADO DEL MODAL
       ======================================-->
      <div class="modal-header" style="background:#fdb44b; color:#fff">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Producto Extenso</h4>
      </div>

      <!--=====================================
         CUERPO DELMODAL
       ======================================-->
      <div class="modal-body">
        <div class="form-group">
          <form method="post" id="formProductoExtenso">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
              <input type="text" name="codigoProducto" class="form-control" placeholder="Código De Producto" autofocus="true" required="true">
            </div>
            <div class="input-group" style="margin-top: 1em">
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
                <input type="text" name="totalCantidad" class="form-control" placeholder="Cantidad Total de Producto" autofocus="true" required="true">
            </div>
        </div>
      </div>

      <h3 style="margin: 1em">Total:$</h3>
      <!--=====================================
         FONDO DEL MODAL
       ======================================-->
      <div class="modal-footer">
        <button type="button" class="btn btn-defaul pull-left" data-dismiss="modal">Salir</button>
        <button type="submit" class="btn btn-success">Ok</button>
      </div>
      </form>
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

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Editar Compra
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Editar compra</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <!--=====================================
      EL FORMULARIO
      ======================================-->
      <div class="col-lg-5 col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border"></div>
          <form role="form" method="post" class="formularioCompra">
            <div class="box-body">
              <div class="box">
                <?php
                    $item = "id";
                    $valor = $_GET["idCompra"];
                    $compra = ControladorCompras::ctrMostrarCompras($item, $valor);

                    $itemUsuario = "id";
                    $valorUsuario = $compra["id_comprador"];
                    $comprador = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                    $itemProveedor = "id";
                    $valorProveedor = $compra["id_proveedor"];
                    $proveedor = ControladorProveedores::ctrMostrarProveedores($itemProveedor, $valorProveedor);
                ?>

                <!--=====================================
                ENTRADA DEL COMPRADOR
                ======================================-->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $comprador["nombre"]; ?>" readonly>
                    <input type="hidden" name="idVendedor" value="<?php echo $comprador["id"]; ?>">
                  </div>
                </div> 

                <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================--> 
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                   <input type="text" class="form-control" id="nuevaVenta" name="editarVenta" value="<?php echo $compra["codigo"]; ?>" readonly>
                  </div>
                </div>

                <!--=====================================
                ENTRADA DEL PROVEEDOR
                ======================================--> 
                <div class="form-group">
                  <div class="input-group">                    
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>                  
                    <select class="form-control" id="seleccionarProveedor" name="seleccionarProveedor" required>
                      <option value="<?php echo $proveedor["id"]; ?>"><?php echo $proveedor["nombre"]; ?></option>
                      <?php
                        $item = null;
                        $valor = null;
                        $categorias = ControladorProveedores::ctrMostrarProveedores($item, $valor);
                        foreach ($categorias as $key => $value) {
                           echo '<option value="'.$value["id"].'">'.$value["nombre"].'</option>';
                         }
                      ?>
                    </select>
                    <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAgregarProveedor" data-dismiss="modal">Agregar Proveedor</button></span>
                  </div>
                </div>

                <!--=====================================
                ENTRADA PARA AGREGAR PRODUCTO
                ======================================--> 
                <div class="form-group row nuevoProducto">
                <?php
                $listaProducto = json_decode($compra["productos"], true);
                foreach ($listaProducto as $key => $value) {
                  $item = "id";
                  $valor = $value["id"];
                  $orden = "id";
                  $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
                  $stockAntiguo = $respuesta["stock"] + $value["cantidad"];
                  echo '<div class="row" style="padding:5px 15px">
                        <div class="col-xs-6" style="padding-right:0px">            
                          <div class="input-group">                
                            <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'.$value["id"].'"><i class="fa fa-times"></i></button></span>
                            <input type="text" class="form-control nuevaDescripcionProducto" idProducto="'.$value["id"].'" name="agregarProducto" value="'.$value["descripcion"].'" readonly required>
                          </div>
                        </div>
                        <div class="col-xs-3">            
                          <input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="'.$value["cantidad"].'" stock="'.$stockAntiguo.'" nuevoStock="'.$value["stock"].'" required>
                        </div>
                        <div class="col-xs-3 ingresoPrecio" style="padding-left:0px">
                          <div class="input-group">
                            <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>                  
                            <input type="text" class="form-control nuevoPrecioProducto" precioReal="'.$respuesta["precio_compra"].'" name="nuevoPrecioProducto" value="'.$value["total"].'" readonly required>   
                          </div>               
                        </div>
                      </div>';
                }
                ?>
                </div>
                <input type="hidden" id="listaProductos" name="listaProductos">

                <!--=====================================
                BOTÓN PARA AGREGAR PRODUCTO
                ======================================-->
                <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar producto</button>
                <hr>
                <div class="row">
                  <!--=====================================
                  ENTRADA IMPUESTOS Y TOTAL
                  ======================================-->                
                  <div class="col-xs-8 pull-right">                    
                    <table class="table">
                      <thead>
                        <tr>                         
                          <th>Total</th>      
                        </tr>
                      </thead>
                      <tbody>                      
                        <tr>                  
                          <td style="width: 50%">
                            <div class="input-group">                          
                              <input type="hidden" class="form-control input-lg" min="0" id="nuevoImpuestoCompra" name="nuevoImpuestoCompra" value="0" required>
                               <input type="hidden" name="nuevoPrecioImpuesto" id="nuevoPrecioImpuesto" required>
                               <input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto" required>                        
                            </div>                            
                            <div class="input-group">                           
                              <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                              <input type="text" class="form-control input-lg" id="nuevoTotalVenta" name="nuevoTotalVenta" total="" value="<?php echo $compra["total"]; ?>" readonly required>
                              <input type="hidden" name="totalVenta" value="<?php echo $compra["total"]; ?>" id="totalVenta">
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <hr>

                <!--=====================================
                ENTRADA MÉTODO DE PAGO
                ======================================-->
                <div class="form-group row">              
                  <div class="col-xs-6" style="padding-right:0px">                    
                     <div class="input-group">                  
                      <select class="form-control" id="nuevoMetodoPago" name="nuevoMetodoPago" required>
                        <option value="">Seleccione método de pago</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="TC">Tarjeta Crédito</option>
                        <option value="TD">Tarjeta Débito</option>                  
                      </select>    
                    </div>
                  </div>
                  <div class="cajasMetodoPago"></div>
                  <input type="hidden" id="listaMetodoPago" name="listaMetodoPago">
                </div>
                <br>
              </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-primary pull-right">Guardar cambios</button>
          </div>
        </form>
        <?php
          $editarVenta = new ControladorCompras();
          $editarVenta -> ctrEditarCompra(); 
        ?>
        </div>    
      </div>

      <!--=====================================
      LA TABLA DE PRODUCTOS
      ======================================-->
      <div class="col-lg-7 hidden-md hidden-sm hidden-xs">    
        <div class="box box-warning">
          <div class="box-header with-border"></div>
          <div class="box-body">            
            <table class="table table-bordered table-striped dt-responsive tablaCompras">              
               <thead>
                 <tr>
                  <th style="width: 10px">#</th>
                  <th>Imagen</th>
                  <th>Código</th>
                  <th>Descripcion</th>
                  <th>Stock</th>
                  <th>Acciones</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!--=====================================
MODAL AGREGAR PROVEEDOR
======================================-->
<div id="modalAgregarProveedor" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar proveedor</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA EL NOMBRE -->          
            <div class="form-group">              
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoNombre" placeholder="Ingresar nombre" required>
              </div>
            </div>

            <!-- ENTRADA PARA EL RFC -->          
            <div class="form-group">            
              <div class="input-group">            
                <span class="input-group-addon"><i class="fa fa-registered"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoRfc" placeholder="Ingresar RFC">
              </div>
            </div>

            <!-- ENTRADA PARA EL TELÉFONO -->                      
            <div class="form-group">              
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoTelefono" placeholder="Ingresar teléfono">
              </div>
            </div>

            <!-- ENTRADA PARA EL EMAIL -->          
            <div class="form-group">              
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 
                <input type="email" class="form-control input-lg" name="nuevoEmail" placeholder="Ingresar email">
              </div>
            </div>

            <!-- ENTRADA PARA LA DIRECCIÓN -->          
            <div class="form-group">              
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoDireccion" placeholder="Ingresar dirección">
              </div>
            </div>
          </div>
        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar proveedor</button>
        </div>
      </form>
      <?php
        $crearCliente = new ControladorProveedores();
        $crearCliente -> ctrCrearProveedor();
      ?>
    </div>
  </div>
</div>
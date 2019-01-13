<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Administrar productos
    </h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar productos</li>
    </ol>
  </section>
  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-success" data-toggle="modal" data-target="#modalAgregarProducto">
          <i class="fa fa-plus"></i> Agregar producto
        </button>
      </div>
      <div class="box-body">
       <table class="table table-bordered table-striped dt-responsive tablaProductos" width="100%">
        <thead>         
         <tr>

            <th style="width:10px">#</th>
            <th>Descripción</th>
            <th>Proveedor</th>
            <th>Categoria</th>
            <th>Imagen</th>
            <th>Código</th>
            <th>Precio de compra</th>
            <th>Precio de venta</th>
            <th>Stock</th>
            <th>Acciones</th>
         
         </tr> 
        </thead>
       </table>

       <input type="hidden" value="<?php echo $_SESSION['perfil']; ?>" class="perfilUsuario">

      </div>

    </div>
  </section>
</div>

<!--=====================================
MODAL AGREGAR PRODUCTO
======================================-->
<div id="modalAgregarProducto" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <form role="form" method="post" enctype="multipart/form-data">
            <!--=====================================
            CABEZA DEL MODAL
            ======================================-->
            <div class="modal-header" style="background:#3c8dbc; color:white">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Agregar producto</h4>
            </div>
            <!--=====================================
            CUERPO DEL MODAL
            ======================================-->
            <div class="modal-body">
               <div class="box-body">
               
                  <!-- ENTRADA PARA SELECCIONAR PROVEEDOR -->
                  <div class="form-group">
                     <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-cubes"></i></span> 
                        <select class="form-control input-lg" name="nuevoProveedor" required>
                           <option value="" selected disabled>Selecionar Proveedor</option>
                           <?php
                           $proveedores = ControladorProveedores::ctrMostrarProveedores(null, null);
                           foreach ($proveedores as $key => $value) {
                              echo '<option value="'.$value["id"].'">'.$value["nombre"].'</option>';
                           }
                           ?>
                        </select>
                     </div>
                  </div>

                  <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->
                  <div class="form-group">
                     <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                        <select class="form-control input-lg" name="nuevaCategoria" required>
                           <option value="" selected disabled>Selecionar categoría</option>
                           <?php
                           $item = null;
                           $valor = null;
                           $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
                           foreach ($categorias as $key => $value) {
                              echo '<option value="'.$value["id"].'">'.$value["categoria"].'</option>';
                           }
                           ?>
                        </select>
                     </div>
                  </div>

                  <!-- ENTRADA PARA EL CÓDIGO -->
                  <div class="form-group">  
                     <div class="input-group"> 
                        <span class="input-group-addon"><i class="fa fa-barcode"></i></span> 
                        <!--<input type="text" class="form-control input-lg" id="nuevoCodigo" name="nuevoCodigo" placeholder="Código" readonly required>-->
                        <input type="text" class="form-control input-lg" name="nuevoCodigo" placeholder="Código" placeholder="Código del producto" required>
                     </div>
                  </div>

                  <!-- ENTRADA PARA LA DESCRIPCIÓN -->
                  <div class="form-group">
                     <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 
                        <input type="text" class="form-control input-lg" name="nuevaDescripcion" placeholder="Descripcion" required>
                     </div>
                  </div>

                  <!-- ENTRADA PARA STOCK MOSTRADOR-->
                  <div class="form-group">
                     <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-check"></i></span> 
                        <input type="number" class="form-control input-lg" name="nuevoStock" min="0" placeholder="Stock" required>
                    </div>
                  </div>
                     

                 
                  <div class="form-group row">
                     <div class="col-xs-6">
                        <!-- ENTRADA PARA PRECIO COMPRA -->
                        <div class="input-group">
                           <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 
                           <input type="number" step="0.01" class="form-control input-lg" id="nuevoPrecioCompra" name="nuevoPrecioCompra" min="0" placeholder="Precio de compra" required>
                        </div>
                     </div>
                     <div class="col-xs-6">
                        <!-- ENTRADA PARA PRECIO VENTA -->
                        <div class="input-group">
                           <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 
                           <input type="number" step="0.01" class="form-control input-lg" id="nuevoPrecioVenta" name="nuevoPrecioVenta" min="0" placeholder="Precio de venta" required>
                        </div>
                        <br>

                        <!-- CHECKBOX PARA PORCENTAJE -->
                        <div class="col-xs-6">
                           <div class="form-group">
                              <label>
                                 <input type="checkbox" class="minimal porcentaje" checked>
                                 Utilizar procentaje
                              </label>
                           </div>
                        </div>

                        <!-- ENTRADA PARA PORCENTAJE -->
                        <div class="col-xs-6" style="padding:0">
                           <div class="input-group">
                              <input type="number" class="form-control input-lg nuevoPorcentaje" min="0" value="40" required>
                              <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                           </div>
                        </div>

                     </div>
                  </div>

                  
                  <!-- ENTRADA PARA SUBIR FOTO -->
                  <div class="form-group">
                     <div class="panel">SUBIR IMAGEN</div>
                        <input type="file" class="nuevaImagen" name="nuevaImagen">
                        <p class="help-block">Peso máximo de la imagen 2MB</p>
                        <img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
                  </div>
               </div>
            </div>

            <!--=====================================
            PIE DEL MODAL
            ======================================-->
            <div class="modal-footer">
               <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
               <button type="submit" class="btn btn-primary">Guardar producto</button>
            </div>
         </form>
         <?php
            $crearProducto = new ControladorProductos();
            $crearProducto -> ctrCrearProducto();
         ?>  
      </div>

   </div>

</div>

<!--=====================================
MODAL EDITAR PRODUCTO
======================================-->
<div id="modalEditarProducto" class="modal fade" role="dialog">  
   <div class="modal-dialog">
      <div class="modal-content">
         <form role="form" method="post" enctype="multipart/form-data">
            <!--=====================================
            CABEZA DEL MODAL
            ======================================-->
            <div class="modal-header" style="background:#3c8dbc; color:white">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Editar producto</h4>
            </div>
            <!--=====================================
            CUERPO DEL MODAL
            ======================================-->
            <div class="modal-body">
               <div class="box-body">
                  <!-- ENTRADA PARA ID -->
                  <input type="hidden" name="editarId" id="editarId">
                 
                  <!-- ENTRADA PARA SELECCIONAR PPROVEEDOR -->
                  <div class="form-group">              
                     <div class="input-group">             
                        <span class="input-group-addon"><i class="fa fa-cubes"></i></span> 
                        <select class="form-control input-lg" name="editarProveedor" readonly required>        
                           <option id="editarProveedor"></option>
                        </select>
                     </div>
                  </div>
   
                  <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->
                  <div class="form-group">              
                     <div class="input-group">             
                        <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                        <select class="form-control input-lg" name="editarCategoria" readonly required>                  
                           <option id="editarCategoria"></option>
                        </select>
                     </div>
                  </div>

                  <!-- ENTRADA PARA EL CÓDIGO -->            
                  <div class="form-group">              
                     <div class="input-group">              
                        <span class="input-group-addon"><i class="fa fa-barcode"></i></span> 
                        <input type="text" class="form-control input-lg" id="editarCodigo" name="editarCodigo" readonly required>
                     </div>
                  </div>

                  <!-- ENTRADA PARA LA DESCRIPCIÓN -->
                  <div class="form-group">              
                     <div class="input-group">              
                        <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 
                        <input type="text" class="form-control input-lg" id="editarDescripcion" name="editarDescripcion" required>
                     </div>
                  </div>

                   <!-- ENTRADA PARA STOCK ALMACÉN-->
                        <div class="form-group">
                           <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-check"></i></span> 
                              <input type="number" class="form-control input-lg" id="editarStock_almacen" name="editarStock_almacen" min="0" placeholder="Stock Almacén" required>
                          </div>
                        </div>

                  <!-- ENTRADA PARA PRECIO COMPRA y PRECIO VENTA LINEAL 2 OBJ. Y 1 CHECKBOX -->
                  <div class="form-group row">
                     <div class="col-xs-6">
                        <!-- ENTRADA PARA PRECIO COMPRA -->
                        <div class="input-group">
                           <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 
                           <input type="number" step="0.01" class="form-control input-lg" id="editarPrecioCompra" name="editarPrecioCompra" min="0" placeholder="Precio de compra" required>
                        </div>
                     </div>
                     <div class="col-xs-6">
                        <!-- ENTRADA PARA PRECIO VENTA -->
                        <div class="input-group">
                           <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 
                           <input type="number" step="0.01" class="form-control input-lg" id="editarPrecioVenta" name="editarPrecioVenta" min="0" placeholder="Precio de venta" required>
                        </div>
                        <br>

                        <!-- CHECKBOX PARA PORCENTAJE -->
                        <div class="col-xs-6">
                           <div class="form-group">
                              <label>
                                 <input type="checkbox" class="minimal porcentaje" checked>
                                 Utilizar procentaje
                              </label>
                           </div>
                        </div>

                        <!-- ENTRADA PARA PORCENTAJE -->
                        <div class="col-xs-6" style="padding:0">
                           <div class="input-group">
                              <input type="number" class="form-control input-lg nuevoPorcentaje" min="0" value="40" required>
                              <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                           </div>
                        </div>

                     </div>
                  </div>
                 
                  <!-- ENTRADA PARA SUBIR FOTO -->
                  <div class="form-group">              
                     <div class="panel">SUBIR IMAGEN</div>
                     <input type="file" class="nuevaImagen" name="editarImagen">
                     <p class="help-block">Peso máximo de la imagen 2MB</p>
                     <img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
                     <input type="hidden" name="imagenActual" id="imagenActual">
                  </div>

               </div>
            </div>

            <!--=====================================
            PIE DEL MODAL
            ======================================-->
            <div class="modal-footer">
               <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
               <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>

         </form>
         <?php
            $editarProducto = new ControladorProductos();
            $editarProducto -> ctrEditarProducto();
         ?>  
      </div>    
   </div>
</div>

<?php
  $eliminarProducto = new ControladorProductos();
  $eliminarProducto -> ctrEliminarProducto();
?>    

<script type="text/javascript">
  //Mostrar acivos el menú y submenús.
  var elemento = document.getElementById("liProductos");
  var elemento2 = document.getElementById("liProductos2");
  elemento.className += " active";
  elemento2.className += " active";
</script>  
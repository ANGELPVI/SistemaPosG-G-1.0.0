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
                  <th>Codigo</th>
                  <th>Producto</th>
                  <th>Costo</th>
                  <th>Cantidad</th>
                  <th>Total</th>
                  <th>Acción</th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  <td>1</td>
                  <td>Lapiz del #2</td>
                  <td>$5.00</td>
                  <td>1</td>
                  <td>$5.00</td>
                  <td><div class='btn-group'><button class='btn btn-success'> <i class='fa fa-plus'></i></button><button class='btn btn-danger'><i class='fa fa-times'></i></button></div></td>
                </tr>

                <tr>
                  <td>2</td>
                  <td>Rsistol liquido</td>
                  <td>$8.00</td>
                  <td>1</td>
                  <td>$8.00</td>
                  <td><div class='btn-group'><button class='btn btn-success'> <i class='fa fa-plus'></i></button><button class='btn btn-danger'><i class='fa fa-times'></i></button></div></td>
                </tr>
              </tbody>
              
            </table>
          </div>

          <div class="box-footer">
            <h5><strong>Descuento: %0</strong></h5>
            <h5><strong>Total: $13.00</strong></h5>
          </div>
          
        </div>
      </div>

      <div class="col-lg-4 hidden-md hidden-sm hidden-xs">
         <div class="box box-danger">

          <div class="box-header">Panel De Venta</div>
          <div class="box-body">
            <form method="post">
              <div class="form-group">
                  <label for="producto">Código del proucto</label>
                   <input type="text" class="form-control" name="producto">
              </div>
            </form>

            <button type="button" class="btn btn-warning btn-block">Cantidad Bruta</button>
            <br>
            <form method="post">
              <div class="form-group">
                  <label for="menbresia">Membresía</label>
                   <input type="text" class="form-control" name="menbresia">
              </div>
            </form>

          </div>
          
        </div>
        
      </div>
      
    </div>

  
   
  </section>

</div>





<script type="text/javascript">
  //Mostrar acivos el menú y submenús.
  var elemento = document.getElementById("liVentas");
  var elemento2 = document.getElementById("liVentas2");
  elemento.className += " active";
  elemento2.className += " active";
</script>
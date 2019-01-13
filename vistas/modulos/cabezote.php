 <header class="main-header">
 	
	<!--=====================================
	LOGOTIPO
	======================================-->
	<a href="inicio" class="logo">
		
		<!-- logo mini -->
		<span class="logo-mini">
			
			<img src="vistas/img/plantilla/icono-blanco.png" class="img-responsive" style="padding:10px">

		</span>

		<!-- logo normal -->

		<span class="logo-lg">
			
			<img src="vistas/img/plantilla/logo-blanco-lineal.png" class="img-responsive" style="padding:10px 0px">

		</span>

	</a>

	<!--=====================================
	BARRA DE NAVEGACIÓN
	======================================-->
	<nav class="navbar navbar-static-top" role="navigation">
		
		<!-- Botón de navegación -->

	 	<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        	
        	<span class="sr-only">Toggle navigation</span>
      	
      	</a>

		<!-- perfil de usuario -->

		<div class="navbar-custom-menu">
				
			<ul class="nav navbar-nav">

				  <!-- Notifications: style can be found in dropdown.less -->
		          <?php
		          if ($_SESSION["perfil"] == "Almacen") {
		          	

		           		echo '
		           <li class="dropdown notifications-menu">
		            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
		              <i class="fa fa-bell-o"></i>
		              <span class="label label-warning" id="numero"></span>
		            </a>
		            <ul class="dropdown-menu">
		              <li class="header">Hay 10 solisitudes de movimientos</li>
		              <li>
		                <!-- inner menu: contains the actual data -->
		                <ul class="menu">
		                  <li>
		                    <a href="#">
		                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
		                    </a>
		                  </li>
		                  <li>
		                    <a href="#">
		                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
		                      page and may cause design problems
		                    </a>
		                  </li>
		                  <li>
		                    <a href="#">
		                      <i class="fa fa-users text-red"></i> 5 new members joined
		                    </a>
		                  </li>
		                  <li>
		                    <a href="#">
		                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made
		                    </a>
		                  </li>
		                  <li>
		                    <a href="#">
		                      <i class="fa fa-user text-red"></i> You changed your username
		                    </a>
		                  </li>
		                </ul>
		              </li>
		              <li class="footer"><a href="#">View all</a></li>
		            </ul>
		          </li>';
		           } 


		           ?>

								
				<li class="dropdown user user-menu">
					
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">

					<?php

					if($_SESSION["foto"] != ""){

						echo '<img src="'.$_SESSION["foto"].'" class="user-image">';

					}else{


						echo '<img src="vistas/img/usuarios/default/anonymous.png" class="user-image">';

					}


					?>
						
						<span class="hidden-xs"><?php  echo $_SESSION["nombre"]; ?></span>

					</a>

					<!-- Dropdown-toggle -->

					<ul class="dropdown-menu">
						
						<li class="user-body">
							
							<div class="pull-right">
								
								<a href="salir" class="btn btn-default btn-flat">Salir</a>

							</div>

						</li>

					</ul>

				</li>

			</ul>

		</div>

	</nav>

 </header>
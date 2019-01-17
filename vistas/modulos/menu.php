<aside class="main-sidebar">
	<section class="sidebar">
		<ul class="sidebar-menu">

		<?php

		if($_SESSION["perfil"] != "Vendedor"){
			echo '<li id="liInicio">
				<a href="inicio">
					<i class="fa fa-home"></i>
					<span>Inicio</span>
				</a>
			</li>';
		}


		if($_SESSION["perfil"] == "Super Administrador" || $_SESSION["perfil"] == "Administrador"){
			echo '<li id="liUsuarios">
				<a href="usuarios">
					<i class="fa fa-user"></i>
					<span>Usuarios</span>
				</a>
			</li>';
		}

		if($_SESSION["perfil"] == "Super Administrador" || $_SESSION["perfil"] == "Administrador" ){
			echo '<li class="treeview" id="liClientes">
				<a href="#">
					<i class="fa fa-users"></i>
					<span>Clientes</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li id="liClientes1">
						<a href="descuentos">
							<i class="fa fa-circle-o"></i>
							<span>Descuentos</span>
						</a>
					</li>';
				if($_SESSION["perfil"] == "Super Administrador"){
					echo '<li id="liClientes2">
						<a href="clientes">
							<i class="fa fa-circle-o"></i>
							<span>Clientes</span>
						</a>
					</li>
					</ul>
				</li>';
				}

		}

		if($_SESSION["perfil"] == "Super Administrador" || $_SESSION["perfil"] == "Administrador"){
			echo '<li class="treeview" id="liProductos">
				<a href="#">
					<i class="fa fa-product-hunt"></i>
					<span>Productos</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li id="liCategorias">
						<a href="categorias">
							<i class="fa fa-th"></i>
							<span>Categorías</span>
						</a>
					</li>
					<li id="liProductos2">
						<a href="productos">
							<i class="fa fa-product-hunt"></i>
							<span>Productos</span>
						</a>
					</li>
				</ul>
			</li>';
		}

		if($_SESSION["perfil"] == "Super Administrador" || $_SESSION["perfil"] == "Administrador"){
			echo '<li class="treeview" id="liCompras">
				<a href="#">
					<i class="fa fa-shopping-bag"></i>
					<span>Compras</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li id="liCompras1">
						<a href="compras">
							<i class="fa fa-circle-o"></i>
							<span>Administrar compras</span>
						</a>
					</li>
					<li id="liCompras2">
						<a href="crear-compra">
							<i class="fa fa-circle-o"></i>
							<span>Crear compra</span>
						</a>
					</li>';
				echo '</ul>
			</li>';
		}

		if($_SESSION["perfil"] == "Super Administrador" || $_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Vendedor"){
			echo '<li class="treeview" id="liVentas">
				<a href="#">
					<i class="fa fa-list-ul"></i>
					<span>Ventas</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li id="liVentas1">
						<a href="ventas">
							<i class="fa fa-circle-o"></i>
							<span>Administrar ventas</span>
						</a>
					</li>
					<li id="liVentas2">
						<a href="crear-venta">
							<i class="fa fa-circle-o"></i>
							<span>Crear venta</span>
						</a>
					</li>';

				echo '</ul>
			</li>';
		} ?>*/

		</ul>

	</section>

</aside>

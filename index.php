<?php

require_once "controladores/plantilla.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/categorias.controlador.php";
require_once "controladores/proveedores.controlador.php";
require_once "controladores/productos.controlador.php";
require_once "controladores/descuentos.controlador.php";
require_once "controladores/clientes.controlador.php";
require_once "controladores/ventas.controlador.php";
require_once 'controladores/sucursales.controlador.php';
require_once 'controladores/sucursales2.controlador.php';
require_once 'controladores/movimientos.controlador.php';

require_once "modelos/usuarios.modelo.php";
require_once "modelos/categorias.modelo.php";
require_once "modelos/proveedores.modelo.php";
require_once "modelos/productos.modelo.php";
require_once "modelos/descuentos.modelo.php";
require_once "modelos/clientes.modelo.php";
require_once "modelos/ventas.modelo.php";
require_once 'modelos/sucursales.modelo.php';
require_once 'modelos/sucursales2.modelo.php';
require_once 'modelos/movimientos.modelo.php';
$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();

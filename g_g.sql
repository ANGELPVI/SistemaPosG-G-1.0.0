-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-05-2019 a las 01:56:18
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `g&g`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizarProductoCampoVen` (IN `cantidad` INT, IN `codi` TEXT)  NO SQL
BEGIN
/*Ing. Ángel PV
Actualizar los productos en el campo de venta
*/
START TRANSACTION;
UPDATE productos SET ventas=ventas+cantidad WHERE codigo=codi;
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizarVentaCliente` (IN `membrecia` INT)  NO SQL
BEGIN
/*Ing. Ánge PV*/
START TRANSACTION;
UPDATE clientes SET compras=compras-1 WHERE ife=membrecia;
COMMIT;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `agregarPorLector` (IN `idpro` TEXT, IN `idusu` INT, IN `membrecia` INT)  NO SQL
BEGIN
/*
Ing. Ángel Piña Viveros
Agregar productos al carrito de compras*/
SET @stock=0;
set @precio=0;
set @id=0;
set @idproduc=0;
set @descu=0;
SELECT stock INTO @stock FROM productos WHERE codigo=idpro;
SELECT precio_venta INTO @precio FROM productos WHERE codigo=idpro;
SELECT id INTO @idproduc FROM productos WHERE codigo=idpro;
SELECT MAX(id) INTO @id FROM carrito_compra;
SELECT (SELECT descuento FROM descuentos WHERE id=id_descuento) INTO @desc FROM clientes WHERE ife=membrecia;

START TRANSACTION;
IF(membrecia>0)THEN
IF (@stock=0)THEN
SELECT 'No hay producto' AS msj;
ROLLBACK;
ELSE
IF EXISTS(SELECT carrito_id_producto FROM carrito_compra WHERE carrito_id_producto=@idproduc AND carrito_vendedor=idusu)THEN
IF(idpro='1' OR idpro='1000' OR idpro='1002' OR idpro='1003' OR idpro='1004')THEN
SET @porcentaje=@desc/100;
SET @multiplicacion= @precio*@porcentaje;
SET @precioDes=@precio-@multiplicacion; 
UPDATE carrito_compra SET cantidad=cantidad+1, carrito_total=carrito_total+@precioDes WHERE carrito_id_producto=@idproduc AND carrito_vendedor=idusu;
UPDATE productos SET stock=stock-1 WHERE codigo='1';
UPDATE productos SET stock=stock-1 WHERE codigo='1000';
UPDATE productos SET stock=stock-1 WHERE codigo='1002';
UPDATE productos SET stock=stock-1 WHERE codigo='1003';
UPDATE productos SET stock=stock-1 WHERE codigo='1004';
SELECT 'ok' AS msj;
COMMIT;
ELSE
SET @porcentaje=@desc/100;
SET @multiplicacion= @precio*@porcentaje;
SET @precioDes=@precio-@multiplicacion; 
UPDATE carrito_compra SET cantidad=cantidad+1, carrito_total=carrito_total+@precioDes WHERE carrito_id_producto=@idproduc AND carrito_vendedor=idusu;
UPDATE productos SET stock=stock-1 WHERE id=@idproduc;
SELECT 'ok' AS msj;
COMMIT;
END IF;

ELSE
IF(idpro='1' OR idpro='1000' OR idpro='1002' OR idpro='1003' OR idpro='1004')THEN
SET @porcentaje=@desc/100;
SET @multiplicacion= @precio*@porcentaje;
SET @precioDes=@precio-@multiplicacion; 
INSERT INTO carrito_compra VALUES(@id+1,@idproduc,@precioDes,1,@precioDes,idusu);
UPDATE productos SET stock=stock-1 WHERE codigo='1';
UPDATE productos SET stock=stock-1 WHERE codigo='1000';
UPDATE productos SET stock=stock-1 WHERE codigo='1002';
UPDATE productos SET stock=stock-1 WHERE codigo='1003';
UPDATE productos SET stock=stock-1 WHERE codigo='1004';
SELECT 'ok' AS msj;
COMMIT;
ELSE
SET @porcentaje=@desc/100;
SET @multiplicacion= @precio*@porcentaje;
SET @precioDes=@precio-@multiplicacion; 
INSERT INTO carrito_compra VALUES(@id+1,@idproduc,@precioDes,1,@precioDes,idusu);
UPDATE productos SET stock=stock-1 WHERE id=@idproduc;
SELECT 'ok' AS msj;
COMMIT;
END IF;
END IF;
END IF;

/*Sin membrecia*/
ELSE
IF (@stock=0)THEN
SELECT 'No hay producto' AS msj;
ROLLBACK;
ELSE
IF EXISTS(SELECT carrito_id_producto FROM carrito_compra WHERE carrito_id_producto=@idproduc AND carrito_vendedor=idusu)THEN
IF(idpro='1' OR idpro='1000' OR idpro='1002' OR idpro='1003' OR idpro='1004')THEN
UPDATE carrito_compra SET cantidad=cantidad+1, carrito_total=carrito_total+@precio WHERE carrito_id_producto=@idproduc AND carrito_vendedor=idusu;
UPDATE productos SET stock=stock-1 WHERE codigo='1';
UPDATE productos SET stock=stock-1 WHERE codigo='1000';
UPDATE productos SET stock=stock-1 WHERE codigo='1002';
UPDATE productos SET stock=stock-1 WHERE codigo='1003';
UPDATE productos SET stock=stock-1 WHERE codigo='1004';
SELECT 'ok' AS msj;
COMMIT;
ELSE
UPDATE carrito_compra SET cantidad=cantidad+1, carrito_total=carrito_total+@precio WHERE carrito_id_producto=@idproduc AND carrito_vendedor=idusu;
UPDATE productos SET stock=stock-1 WHERE id=@idproduc;
SELECT 'ok' AS msj;
COMMIT;
END IF;

ELSE
IF(idpro='1' OR idpro='1000' OR idpro='1002' OR idpro='1003' OR idpro='1004')THEN
INSERT INTO carrito_compra VALUES(@id+1,@idproduc,@precio,1,@precio,idusu);
UPDATE productos SET stock=stock-1 WHERE codigo='1';
UPDATE productos SET stock=stock-1 WHERE codigo='1000';
UPDATE productos SET stock=stock-1 WHERE codigo='1002';
UPDATE productos SET stock=stock-1 WHERE codigo='1003';
UPDATE productos SET stock=stock-1 WHERE codigo='1004';
SELECT 'ok' AS msj;
COMMIT;
ELSE
INSERT INTO carrito_compra VALUES(@id+1,@idproduc,@precio,1,@precio,idusu);
UPDATE productos SET stock=stock-1 WHERE id=@idproduc;
SELECT 'ok' AS msj;
COMMIT;
END IF;
END IF;
END IF;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `carrito_compra` (IN `idpro` INT, IN `idusu` INT, IN `membrecia` INT)  NO SQL
BEGIN
/*
Ing. Ángel Piña Viveros
Agregar productos al carrito de compras*/
SET @stock=0;
set @precio=0;
set @id=0;
SET @codigo=0;
set @descu=0;
SET @desc=0;
SELECT stock INTO @stock FROM productos WHERE id=idpro;
SELECT precio_venta INTO @precio FROM productos WHERE id=idpro;
SELECT MAX(id) INTO @id FROM carrito_compra;
SELECT codigo INTO @codigo FROM productos WHERE id=idpro;
SELECT (SELECT descuento FROM descuentos WHERE id=id_descuento) INTO @desc FROM clientes WHERE ife=membrecia;

START TRANSACTION;
IF(membrecia>0)THEN
IF (@stock=0)THEN
SELECT 'No hay productooo' AS msj;
ROLLBACK;
ELSE
IF EXISTS(SELECT carrito_id_producto FROM carrito_compra WHERE carrito_id_producto=idpro)THEN
IF(@codigo='1' OR @codigo='1000' OR @codigo='1002' OR @codigo='1003' OR @codigo='1004')THEN
SET @porcentaje=@desc/100;
SET @multiplicacion= @precio*@porcentaje;
SET @precioDes=@precio-@multiplicacion; 
UPDATE carrito_compra SET cantidad=cantidad+1, carrito_total=carrito_total+@precioDes WHERE carrito_id_producto=idpro AND carrito_vendedor=idusu;
UPDATE productos SET stock=stock-1 WHERE codigo='1';
UPDATE productos SET stock=stock-1 WHERE codigo='1000';
UPDATE productos SET stock=stock-1 WHERE codigo='1002';
UPDATE productos SET stock=stock-1 WHERE codigo='1003';
UPDATE productos SET stock=stock-1 WHERE codigo='1004';
SELECT 'ok 1' AS msj;
COMMIT;

ELSE
SET @porcentaje=@desc/100;
SET @multiplicacion= @precio*@porcentaje;
SET @precioDes=@precio-@multiplicacion;
UPDATE carrito_compra SET cantidad=cantidad+1, carrito_total=carrito_total+@precioDes WHERE carrito_id_producto=idpro AND carrito_vendedor=idusu;
UPDATE productos SET stock=stock-1 WHERE id=idpro;
COMMIT;
SELECT 'ok' AS msj;
END IF;

ELSE
IF(@codigo='1' OR @codigo='1000' OR @codigo='1002' OR @codigo='1003' OR @codigo='1004')THEN
SET @porcentaje=@desc/100;
SET @multiplicacion= @precio*@porcentaje;
SET @precioDes=@precio-@multiplicacion;
INSERT INTO carrito_compra VALUES(@id+1,idpro,@precioDes,1,@precioDes,idusu);
UPDATE productos SET stock=stock-1 WHERE codigo='1';
UPDATE productos SET stock=stock-1 WHERE codigo='1000';
UPDATE productos SET stock=stock-1 WHERE codigo='1002';
UPDATE productos SET stock=stock-1 WHERE codigo='1003';
UPDATE productos SET stock=stock-1 WHERE codigo='1004';
SELECT 'ok' AS msj;
COMMIT;
ELSE
SET @porcentaje=@desc/100;
SET @multiplicacion= @precio*@porcentaje;
SET @precioDes=@precio-@multiplicacion;
INSERT INTO carrito_compra VALUES(@id+1,idpro,@precioDes,1,@precioDes,idusu);
UPDATE productos SET stock=stock-1 WHERE id=idpro;
SELECT 'ok' AS msj;
COMMIT;
END IF;
END IF;
END IF;

/*Sin membrecia*/
ELSE
IF (@stock=0)THEN
SELECT 'No hay product' AS msj;
ROLLBACK;
ELSE
IF EXISTS(SELECT carrito_id_producto FROM carrito_compra WHERE carrito_id_producto=idpro)THEN
IF(@codigo='1' OR @codigo='1000' OR @codigo='1002' OR @codigo='1003' OR @codigo='1004')THEN
UPDATE carrito_compra SET cantidad=cantidad+1, carrito_total=carrito_total+@precio WHERE carrito_id_producto=idpro AND carrito_vendedor=idusu;
UPDATE productos SET stock=stock-1 WHERE codigo='1';
UPDATE productos SET stock=stock-1 WHERE codigo='1000';
UPDATE productos SET stock=stock-1 WHERE codigo='1002';
UPDATE productos SET stock=stock-1 WHERE codigo='1003';
UPDATE productos SET stock=stock-1 WHERE codigo='1004';
COMMIT;

ELSE
UPDATE carrito_compra SET cantidad=cantidad+1, carrito_total=carrito_total+@precio WHERE carrito_id_producto=idpro AND carrito_vendedor=idusu;
UPDATE productos SET stock=stock-1 WHERE id=idpro;
COMMIT;
END IF;

ELSE
IF(@codigo='1' OR @codigo='1000' OR @codigo='1002' OR @codigo='1003' OR @codigo='1004')THEN
INSERT INTO carrito_compra VALUES(@id+1,idpro,@precio,1,@precio,idusu);
UPDATE productos SET stock=stock-1 WHERE codigo='1';
UPDATE productos SET stock=stock-1 WHERE codigo='1000';
UPDATE productos SET stock=stock-1 WHERE codigo='1002';
UPDATE productos SET stock=stock-1 WHERE codigo='1003';
UPDATE productos SET stock=stock-1 WHERE codigo='1004';
COMMIT;
ELSE
INSERT INTO carrito_compra VALUES(@id+1,idpro,@precio,1,@precio,idusu);
UPDATE productos SET stock=stock-1 WHERE id=idpro;
COMMIT;
END IF;
END IF;
END IF;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `coleccionDeVenta` (IN `idU` INT)  NO SQL
BEGIN
/*Ing. Ángel Piña Viveros
Mostrar los productos a vender*/

START TRANSACTION;
SELECT c.carrito_costo,p.codigo,p.descripcion,c.cantidad,c.carrito_total FROM productos p JOIN carrito_compra c ON c.carrito_id_producto=p.id WHERE c.carrito_vendedor=idU;

COMMIT;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConcretarVenta` (IN `vendedor` INT, IN `produc` TEXT, IN `membrecia` INT)  NO SQL
BEGIN
/*Ing. Ángel PV
Concretar venta de los productos
*/
set @id=0;
set @cliente=0;
set @codigo=0;
SET @total=0;
set @fecha=NOW();
SET @idCli=0;

SELECT MAX(id) INTO @id FROM ventas;
SELECT MAX(codigo) INTO @codigo FROM ventas;
SELECT SUM(carrito_total) INTO @total FROM carrito_compra WHERE carrito_vendedor=vendedor;
SELECT id INTO @idCli FROM clientes WHERE ife=membrecia;

START TRANSACTION;
IF(membrecia>0)THEN
IF EXISTS(SELECT * FROM ventas)THEN
INSERT INTO ventas VALUES(@id+1,@codigo+1,@idCli,vendedor,produc,@total,@fecha);
UPDATE clientes SET compras=compras+1 WHERE id=@idCli;
DELETE FROM carrito_compra WHERE carrito_vendedor=vendedor;
SELECT 'ok' AS msj;
COMMIT;
ELSE
INSERT INTO ventas VALUES(@id+1,1000,@idCli,vendedor,produc,@total,@fecha);
UPDATE clientes SET compras=compras+1 WHERE id=@idCli;
DELETE FROM carrito_compra WHERE carrito_vendedor=vendedor;
SELECT 'ok' AS msj;
COMMIT;
END IF;

/*Sin Membrecia*/
ELSE
IF EXISTS(SELECT * FROM ventas)THEN
INSERT INTO ventas VALUES(@id+1,@codigo+1,@cliente,vendedor,produc,@total,@fecha);
DELETE FROM carrito_compra WHERE carrito_vendedor=vendedor;
SELECT 'ok' AS msj;
COMMIT;
ELSE
INSERT INTO ventas VALUES(@id+1,1000,@cliente,vendedor,produc,@total,@fecha);
DELETE FROM carrito_compra WHERE carrito_vendedor=vendedor;
SELECT 'ok' AS msj;
COMMIT;
END IF;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminarVenta` (IN `idVenta` INT, IN `eliminarProdVen` INT, IN `producCodi` TEXT)  NO SQL
BEGIN
/*Ing Ángel Piña Viveros 
Eliminar venta*/
SET @idCliente=0;
SELECT id_cliente INTO @idCliente FROM ventas WHERE id=idVenta;

START TRANSACTION;
IF(@idCliente=0)THEN
UPDATE productos SET ventas=ventas-eliminarProdVen, stock=stock+eliminarProdVen WHERE codigo=producCodi;
SELECT 'ok' msj;
COMMIT;
ELSE
UPDATE productos SET ventas=ventas-eliminarProdVen, stock=stock+eliminarProdVen WHERE codigo=producCodi;
SELECT 'ok' msj;
COMMIT;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminatPorMayoreo` (IN `idProducto` TEXT, IN `vendedor` INT, IN `cantidad` INT)  NO SQL
BEGIN
/*
Ing. Ángel Piña Viveros
Eliminar producto por mayoreo
*/
set @id=0;
SELECT id INTO @id FROM productos WHERE codigo=idProducto;
START TRANSACTION;
IF(idProducto='1000' OR idProducto='1002' OR  idProducto='1003' OR  idProducto='1004' OR  idProducto='1')THEN 
UPDATE productos SET stock=stock+cantidad WHERE codigo='1000';
UPDATE productos SET stock=stock+cantidad WHERE codigo='1';
UPDATE productos SET stock=stock+cantidad WHERE codigo='1002';
UPDATE productos SET stock=stock+cantidad WHERE codigo='1003';
UPDATE productos SET stock=stock+cantidad WHERE codigo='1004';
DELETE FROM carrito_compra WHERE carrito_id_producto=@id AND carrito_vendedor=vendedor;
SELECT 'elimina hojas' AS msj;
COMMIT;
ELSE

UPDATE productos SET stock=stock+cantidad WHERE id=@id; 
DELETE FROM carrito_compra WHERE carrito_id_producto=@id AND carrito_vendedor=vendedor;
SELECT 'eliminado' AS msj;
COMMIT;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `elimina_agregar` (IN `produc` INT, IN `vendedor` INT, IN `pregunta` TEXT, IN `membrecia` INT)  NO SQL
BEGIN
/*
Ing. Ángel Piña Viveros
Eliminar o agregar al carrito de compras
*/
SET @precio=0;
SET @catidad=0;
SET @codi=0;
SET @desc=0;
SELECT precio_venta INTO @precio FROM productos WHERE id=produc;
SELECT cantidad INTO @cantidad FROM carrito_compra WHERE carrito_id_producto=produc AND carrito_vendedor=vendedor;
SELECT codigo INTO @codi FROM productos WHERE id=produc;
SELECT (SELECT descuento FROM descuentos WHERE id=id_descuento) INTO @desc FROM clientes WHERE ife=membrecia;

START TRANSACTION;
IF(pregunta='eliminar')THEN
IF(membrecia>0)THEN
IF(@codi='1000' OR @codi='1002' OR @codi='1003' OR @codi='1004' OR @codi='1')THEN
SET @porcentaje=@desc/100;
SET @multiplicacion= @precio*@porcentaje;
SET @precioDes=@precio-@multiplicacion;
UPDATE carrito_compra SET cantidad=cantidad-1, carrito_total=carrito_total-@precioDes WHERE carrito_id_producto=produc AND carrito_vendedor=vendedor;
UPDATE productos SET stock=stock+1 WHERE codigo='1';
UPDATE productos SET stock=stock+1 WHERE codigo='1000';
UPDATE productos SET stock=stock+1 WHERE codigo='1002';
UPDATE productos SET stock=stock+1 WHERE codigo='1003';
UPDATE productos SET stock=stock+1 WHERE codigo='1004';
COMMIT;
ELSE
SET @porcentaje=@desc/100;
SET @multiplicacion= @precio*@porcentaje;
SET @precioDes=@precio-@multiplicacion;
UPDATE carrito_compra SET cantidad=cantidad-1, carrito_total=carrito_total-@precioDes WHERE carrito_id_producto=produc AND carrito_vendedor=vendedor;
UPDATE productos SET stock=stock+1 WHERE id=produc;
COMMIT;
END IF;

IF(@cantidad=1)THEN
DELETE FROM carrito_compra WHERE carrito_id_producto=produc AND carrito_vendedor=vendedor;
COMMIT;
ELSE
SELECT 'No se hace nada' AS msj;
COMMIT;
END IF;
/*Sin membrecia*/
ELSE
IF(@codi='1000' OR @codi='1002' OR @codi='1003' OR @codi='1004' OR @codi='1')THEN
UPDATE carrito_compra SET cantidad=cantidad-1, carrito_total=carrito_total-@precio WHERE carrito_id_producto=produc AND carrito_vendedor=vendedor;
UPDATE productos SET stock=stock+1 WHERE codigo='1';
UPDATE productos SET stock=stock+1 WHERE codigo='1000';
UPDATE productos SET stock=stock+1 WHERE codigo='1002';
UPDATE productos SET stock=stock+1 WHERE codigo='1003';
UPDATE productos SET stock=stock+1 WHERE codigo='1004';
COMMIT;
ELSE
UPDATE carrito_compra SET cantidad=cantidad-1, carrito_total=carrito_total-@precio WHERE carrito_id_producto=produc AND carrito_vendedor=vendedor;
UPDATE productos SET stock=stock+1 WHERE id=produc;
COMMIT;
END IF;

IF(@cantidad=1)THEN
DELETE FROM carrito_compra WHERE carrito_id_producto=produc AND carrito_vendedor=vendedor;
COMMIT;
ELSE
SELECT 'No se hace nada' AS msj;
COMMIT;
END IF;
END IF;

ELSE
IF(membrecia>0)THEN
IF(@codi='1000' OR @codi='1002' OR @codi='1003' OR @codi='1004' OR @codi='1')THEN
SET @porcentaje=@desc/100;
SET @multiplicacion= @precio*@porcentaje;
SET @precioDes=@precio-@multiplicacion;
UPDATE carrito_compra SET cantidad=cantidad+1, carrito_total=carrito_total+@precioDes WHERE carrito_id_producto=produc AND carrito_vendedor=vendedor;
UPDATE productos SET stock=stock-1 WHERE codigo='1';
UPDATE productos SET stock=stock-1 WHERE codigo='1000';
UPDATE productos SET stock=stock-1 WHERE codigo='1002';
UPDATE productos SET stock=stock-1 WHERE codigo='1003';
UPDATE productos SET stock=stock-1 WHERE codigo='1004';
COMMIT;
ELSE
SET @porcentaje=@desc/100;
SET @multiplicacion= @precio*@porcentaje;
SET @precioDes=@precio-@multiplicacion;
UPDATE carrito_compra SET cantidad=cantidad+1, carrito_total=carrito_total+@precioDes WHERE carrito_id_producto=produc AND carrito_vendedor=vendedor;
UPDATE productos SET stock=stock-1 WHERE id=produc;
COMMIT;
END IF;

/*Sin Membrecia*/
ELSE
IF(@codi='1000' OR @codi='1002' OR @codi='1003' OR @codi='1004' OR @codi='1')THEN
UPDATE carrito_compra SET cantidad=cantidad+1, carrito_total=carrito_total+@precio WHERE carrito_id_producto=produc AND carrito_vendedor=vendedor;
UPDATE productos SET stock=stock-1 WHERE codigo='1';
UPDATE productos SET stock=stock-1 WHERE codigo='1000';
UPDATE productos SET stock=stock-1 WHERE codigo='1002';
UPDATE productos SET stock=stock-1 WHERE codigo='1003';
UPDATE productos SET stock=stock-1 WHERE codigo='1004';
COMMIT;
ELSE
UPDATE carrito_compra SET cantidad=cantidad+1, carrito_total=carrito_total+@precio WHERE carrito_id_producto=produc AND carrito_vendedor=vendedor;
UPDATE productos SET stock=stock-1 WHERE id=produc;
COMMIT;
END IF;
END IF;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MostrarProducto` (IN `idU` INT)  NO SQL
BEGIN
/*Ing. Ángel Piña Viveros
Mostrar los productos a vender*/

START TRANSACTION;
SELECT p.stock,p.codigo,p.descripcion,c.carrito_costo,c.cantidad,c.carrito_total, c.carrito_vendedor,c.carrito_id_producto FROM productos p JOIN carrito_compra c ON c.carrito_id_producto=p.id WHERE c.carrito_vendedor=idU;

COMMIT;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ventaPorMayoreo` (IN `idpro` TEXT, IN `cantidadPro` INT, IN `total` FLOAT, IN `idusu` INT, IN `membrecia` INT)  NO SQL
BEGIN 
/*Ing. Ángel PV
Vender Producto por mayoreo*/
SET @stock=0;
SET @precioV=0;
SET @id=0;
SET @idproduc=0;
SET @desc=0;
SELECT id INTO @idproduc FROM productos WHERE codigo=idpro;
SELECT stock INTO @stock FROM productos WHERE codigo=idpro;
SELECT precio_venta INTO @precio FROM productos WHERE codigo=idpro;
SELECT MAX(id) INTO @id FROM carrito_compra;
SELECT (SELECT descuento FROM descuentos WHERE id=id_descuento) INTO @desc FROM clientes WHERE ife=membrecia;

START TRANSACTION;
IF(membrecia>0)THEN
IF(cantidadPro>@stock)THEN
SELECT 'insuficiente' AS msj;
ROLLBACK;
ELSE
IF(SELECT carrito_id_producto FROM carrito_compra WHERE carrito_id_producto=@idproduc AND carrito_vendedor=idusu)THEN
IF(idpro='1000' OR idpro='1002' OR idpro='1003' OR idpro='1004' OR idpro='1')THEN
SET @porcentaje=@desc/100;
SET @multiplicacion= @precio*@porcentaje;
SET @precioDes=@precio-@multiplicacion;
set @descuTotal=@precioDes*cantidadPro;
UPDATE carrito_compra SET cantidad=cantidad+cantidadPro, carrito_total=carrito_total+@descuTotal WHERE carrito_id_producto=@idproduc AND carrito_vendedor=idusu;
UPDATE productos SET stock=stock-cantidadPro WHERE codigo='1';
UPDATE productos SET stock=stock-cantidadPro WHERE codigo='1000';
UPDATE productos SET stock=stock-cantidadPro WHERE codigo='1002';
UPDATE productos SET stock=stock-cantidadPro WHERE codigo='1003';
UPDATE productos SET stock=stock-cantidadPro WHERE codigo='1004';
SELECT 'ok' AS msj;
COMMIT;
ELSE
SET @porcentaje=@desc/100;
SET @multiplicacion= @precio*@porcentaje;
SET @precioDes=@precio-@multiplicacion;
set @descuTotal=@precioDes*cantidadPro;
UPDATE carrito_compra SET cantidad=cantidad+cantidadPro, carrito_total=carrito_total+@descuTotal WHERE carrito_id_producto=@idproduc AND carrito_vendedor=idusu;
SELECT 'ok' AS msj;
COMMIT;
END IF;

ELSE
IF(idpro='1000' OR idpro='1002' OR idpro='1003' OR idpro='1004' OR idpro='1')THEN
SET @porcentaje=@desc/100;
SET @multiplicacion= @precio*@porcentaje;
SET @precioDes=@precio-@multiplicacion;
set @descuTotal=@precioDes*cantidadPro;
INSERT INTO carrito_compra VALUES(@id+1,@idproduc,@precioDes,cantidadPro,@descuTotal,idusu);
UPDATE productos SET stock=stock-cantidadPro WHERE codigo='1000';
UPDATE productos SET stock=stock-cantidadPro WHERE codigo='1';
UPDATE productos SET stock=stock-cantidadPro WHERE codigo='1002';
UPDATE productos SET stock=stock-cantidadPro WHERE codigo='1003';
UPDATE productos SET stock=stock-cantidadPro WHERE codigo='1004';
SELECT 'ok' AS msj;
COMMIT;
ELSE
SET @porcentaje=@desc/100;
SET @multiplicacion= @precio*@porcentaje;
SET @precioDes=@precio-@multiplicacion;
set @descuTotal=@precioDes*cantidadPro;
INSERT INTO carrito_compra VALUES(@id+1,@idproduc,@precioDes,cantidadPro,@descuTotal,idusu);
UPDATE productos SET stock=stock-cantidadPro WHERE id=@idproduc;
SELECT 'ok' AS msj;
COMMIT;
END IF;
END IF;
END IF;
/*Sin Membrecia*/
ELSE
IF(cantidadPro>@stock)THEN
SELECT 'insuficiente' AS msj;
ROLLBACK;
ELSE
IF(SELECT carrito_id_producto FROM carrito_compra WHERE carrito_id_producto=@idproduc AND carrito_vendedor=idusu)THEN
IF(idpro='1000' OR idpro='1002' OR idpro='1003' OR idpro='1004' OR idpro='1')THEN
UPDATE carrito_compra SET cantidad=cantidad+cantidadPro, carrito_total=carrito_total+total WHERE carrito_id_producto=@idproduc AND carrito_vendedor=idusu;
UPDATE productos SET stock=stock-cantidadPro WHERE codigo='1';
UPDATE productos SET stock=stock-cantidadPro WHERE codigo='1000';
UPDATE productos SET stock=stock-cantidadPro WHERE codigo='1002';
UPDATE productos SET stock=stock-cantidadPro WHERE codigo='1003';
UPDATE productos SET stock=stock-cantidadPro WHERE codigo='1004';
SELECT 'ok' AS msj;
COMMIT;
ELSE
UPDATE carrito_compra SET cantidad=cantidad+cantidadPro, carrito_total=carrito_total+total WHERE carrito_id_producto=@idproduc AND carrito_vendedor=idusu;
SELECT 'ok' AS msj;
COMMIT;
END IF;

ELSE
IF(idpro='1000' OR idpro='1002' OR idpro='1003' OR idpro='1004' OR idpro='1')THEN
SET @rebajaPrecio=total/cantidadPro;
INSERT INTO carrito_compra VALUES(@id+1,@idproduc,@rebajaPrecio,cantidadPro,total,idusu);
UPDATE productos SET stock=stock-cantidadPro WHERE codigo='1000';
UPDATE productos SET stock=stock-cantidadPro WHERE codigo='1';
UPDATE productos SET stock=stock-cantidadPro WHERE codigo='1002';
UPDATE productos SET stock=stock-cantidadPro WHERE codigo='1003';
UPDATE productos SET stock=stock-cantidadPro WHERE codigo='1004';
SELECT 'ok' AS msj;
COMMIT;
ELSE
SET @rebajaPrecio=total/cantidadPro;
INSERT INTO carrito_compra VALUES(@id+1,@idproduc,@rebajaPrecio,cantidadPro,total,idusu);
UPDATE productos SET stock=stock-cantidadPro WHERE id=@idproduc;
SELECT 'ok' AS msj;
COMMIT;
END IF;
END IF;
END IF;

END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_compra`
--

CREATE TABLE `carrito_compra` (
  `id` int(11) NOT NULL,
  `carrito_id_producto` int(11) NOT NULL,
  `carrito_costo` float NOT NULL,
  `cantidad` int(11) NOT NULL,
  `carrito_total` float NOT NULL,
  `carrito_vendedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categoria` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`, `fecha`) VALUES
(7, 'Libretas', '2019-04-18 23:54:24'),
(8, 'Lapiceros', '2019-04-18 23:54:33'),
(9, 'Hojas Blancas', '2019-04-20 23:08:27'),
(10, 'Hojas De Colores', '2019-04-20 23:23:43'),
(11, 'Copias', '2019-04-21 00:48:48'),
(12, 'Impresiones', '2019-04-21 00:49:16'),
(13, 'reglas', '2019-05-02 20:25:15'),
(14, 'plumon', '2019-05-02 20:30:16'),
(15, 'Marcador', '2019-05-02 20:35:55'),
(16, 'Lapiz', '2019-05-02 20:39:54'),
(17, 'notas adhesivas', '2019-05-02 21:03:00'),
(18, 'Pintura Acrilica', '2019-05-02 21:07:15'),
(19, 'pincel', '2019-05-02 21:24:37'),
(20, 'puntillas', '2019-05-02 21:29:53'),
(21, 'clip', '2019-05-02 21:34:55'),
(22, 'resistol ', '2019-05-02 21:52:05'),
(23, 'Borrador', '2019-05-02 22:17:11'),
(24, 'Calculadora', '2019-05-02 22:26:12'),
(25, 'Gises', '2019-05-02 22:26:34'),
(26, 'Diamantina', '2019-05-02 23:45:17'),
(27, 'Colores', '2019-05-02 23:42:32'),
(28, 'Grapas', '2019-05-03 00:15:33'),
(29, 'Cuter', '2019-05-03 00:22:04'),
(30, 'Tintas', '2019-05-03 00:24:23'),
(31, 'Sellos', '2019-05-03 00:28:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `ife` int(11) NOT NULL,
  `id_descuento` int(11) NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `email` text COLLATE utf8_spanish_ci NOT NULL,
  `telefono` text COLLATE utf8_spanish_ci NOT NULL,
  `compras` int(11) NOT NULL,
  `ultima_compra` datetime NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `ife`, `id_descuento`, `nombre`, `email`, `telefono`, `compras`, `ultima_compra`, `fecha`) VALUES
(15, 95046074, 1, 'Juan Villega', 'angelpiviveros@gmai.com', '(755) 117-7573', 0, '2019-05-05 19:11:18', '2019-05-12 19:36:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descuentos`
--

CREATE TABLE `descuentos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descuento` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `descuentos`
--

INSERT INTO `descuentos` (`id`, `nombre`, `descuento`) VALUES
(1, 'plata', 40);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `codigo` text COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `imagen` text COLLATE utf8_spanish_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `precio_compra` float NOT NULL,
  `precio_venta` float NOT NULL,
  `ventas` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `id_categoria`, `codigo`, `descripcion`, `imagen`, `stock`, `precio_compra`, `precio_venta`, `ventas`, `fecha`) VALUES
(63, 9, '1', 'Hojas blancas', 'vistas/img/productos/default/anonymous.png', 16, 0.5, 1, 0, '2019-05-03 19:37:37'),
(65, 11, '1000', 'Copias B/N', 'vistas/img/productos/default/anonymous.png', 16, 0.18, 1, 0, '2019-05-03 19:37:37'),
(66, 11, '1002', 'Copias Color', 'vistas/img/productos/default/anonymous.png', 16, 1.18, 3, 0, '2019-05-03 19:37:37'),
(67, 12, '1003', 'Imprecion B/N', 'vistas/img/productos/default/anonymous.png', 16, 0.18, 1, 0, '2019-05-03 19:37:37'),
(68, 12, '1004', 'Imprecion Color', 'vistas/img/productos/default/anonymous.png', 16, 1.18, 3, 0, '2019-05-03 19:37:37'),
(71, 8, '7501014511054', 'Escritura fina azul', 'vistas/img/productos/default/anonymous.png', 130, 3, 5, 0, '2019-05-12 19:36:15'),
(72, 8, '7501014511061', 'Escritura fina Negro', 'vistas/img/productos/default/anonymous.png', 25, 3, 5, 0, '2019-05-12 19:59:03'),
(73, 8, '7501014511078', 'Escritura fina Rojo', 'vistas/img/productos/default/anonymous.png', 225, 3, 5, 0, '2010-12-15 19:55:32'),
(74, 8, '7703486035315', 'Boligrafo Paper Mate azul', 'vistas/img/productos/default/anonymous.png', 1, 3, 4, 0, '2019-05-02 20:21:51'),
(75, 8, '070330198937', 'Escritura Ultra Fina Azul', 'vistas/img/productos/default/anonymous.png', 78, 4, 6, 0, '2010-12-15 20:03:05'),
(76, 8, '070330198920', 'Escritura Ultra Fina Negro', 'vistas/img/productos/default/anonymous.png', 155, 4, 6, 0, '2010-12-15 19:57:43'),
(77, 8, '7703486035551', 'Boligrafo Paper Mate Verde', 'vistas/img/productos/default/anonymous.png', 1, 3, 4, 0, '2019-05-02 20:34:45'),
(78, 13, '7503002648049', 'Regla de 30 cm', 'vistas/img/productos/default/anonymous.png', 29, 1, 6, 0, '2019-05-12 19:28:46'),
(80, 13, '7501174990805', 'Escalimetro', 'vistas/img/productos/default/anonymous.png', 4, 31, 44, 0, '2019-05-12 19:36:00'),
(81, 13, '7501214963165', 'Regla de 30 cm Barrilito', 'vistas/img/productos/default/anonymous.png', 5, 1, 7, 0, '2019-05-02 20:28:17'),
(82, 13, '7503002648865', 'Transportadores', 'vistas/img/productos/default/anonymous.png', 5, 2, 8, 0, '2019-05-12 17:38:04'),
(83, 14, '5401178076388', 'Sharpie punta fina rojo', 'vistas/img/productos/default/anonymous.png', 2, 10, 13, 0, '2019-05-02 20:31:30'),
(84, 14, '5401178076364', 'Sharpie punta fina Azul', 'vistas/img/productos/default/anonymous.png', 5, 10, 13, 0, '2019-05-02 21:43:32'),
(85, 14, '5401178324311', 'Sharpie punta fina Negro twin', 'vistas/img/productos/default/anonymous.png', 5, 10, 22, 0, '2019-05-02 20:33:37'),
(86, 15, '7501030665670', 'Marcador de cera sharpie negro', 'vistas/img/productos/default/anonymous.png', 5, 10, 13, 0, '2019-05-02 20:37:17'),
(87, 15, '7501147480104', 'Marcador de cera dixon Azul', 'vistas/img/productos/default/anonymous.png', 19, 10, 13, 0, '2019-05-12 18:42:44'),
(88, 15, '7501147475100', 'Marcador de cera dixon Rojo', 'vistas/img/productos/default/anonymous.png', 20, 10, 13, 0, '2019-05-02 21:45:22'),
(89, 16, '7502265163085', 'llapiz duo mae', 'vistas/img/productos/default/anonymous.png', 100, 5, 8, 0, '2019-05-02 20:56:16'),
(90, 16, '3154148517214', 'lapiz blackpeps', 'vistas/img/productos/default/anonymous.png', 126, 2, 5, 0, '2010-12-15 15:59:47'),
(91, 16, '3086123275317', 'lápiz evolution', 'vistas/img/productos/default/anonymous.png', 24, 4, 6, 0, '2010-12-15 16:02:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `telefono` text COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text COLLATE utf8_spanish_ci NOT NULL,
  `email` text COLLATE utf8_spanish_ci NOT NULL,
  `usuario` text COLLATE utf8_spanish_ci NOT NULL,
  `password` text COLLATE utf8_spanish_ci NOT NULL,
  `perfil` text COLLATE utf8_spanish_ci NOT NULL,
  `foto` text COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `ultimo_login` datetime NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `telefono`, `direccion`, `email`, `usuario`, `password`, `perfil`, `foto`, `estado`, `ultimo_login`, `fecha`) VALUES
(60, 'angel piña viveros', '(755) 117-7573', 'null', 'angel@gmail.com', 'angel', '$2a$07$asxx54ahjppf45sd87a5auI.w1Ked9scYx2Nf.LKXcqEaa6/D8OoG', 'Super Administrador', '', 1, '2019-05-12 20:14:49', '2019-05-13 01:14:49'),
(61, 'JUAN', '(758) 100 2195', 'null', 'JUAN@gmail.com', 'juanito', '$2a$07$asxx54ahjppf45sd87a5auwRi.z6UsW7kVIpm0CUEuCpmsvT2sG6O', 'Vendedor', '', 1, '2019-05-01 10:54:35', '2019-05-01 15:54:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `productos` text COLLATE utf8_spanish_ci NOT NULL,
  `total` float NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito_compra`
--
ALTER TABLE `carrito_compra`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito_compra`
--
ALTER TABLE `carrito_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

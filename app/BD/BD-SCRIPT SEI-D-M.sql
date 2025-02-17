-- MySQL Script generated by MySQL Workbench
-- Mon Feb 17 04:27:59 2025
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema seid
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema seid
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `seid` DEFAULT CHARACTER SET utf8 ;
SHOW WARNINGS;
USE `seid` ;

-- -----------------------------------------------------
-- Table `seid`.`empresas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `seid`.`empresas` (
  `id_empresa` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre_empresa` VARCHAR(80) NOT NULL,
  `razon_social_empresa` VARCHAR(80) NOT NULL,
  `telefono_empresa` VARCHAR(15) NOT NULL,
  `correo_electronico_empresa` VARCHAR(50) NOT NULL,
  `sitio_web_empresa` VARCHAR(150) NULL,
  `logo_empresa` VARCHAR(80) NOT NULL,
  `direccion_empresa` VARCHAR(80) NOT NULL,
  `codigo_postal_empresa` SMALLINT NOT NULL,
  `status_empresa` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_empresa`),
  UNIQUE INDEX `nombre_empresa_UNIQUE` (`nombre_empresa` ASC) VISIBLE,
  UNIQUE INDEX `telefono_empresa_UNIQUE` (`telefono_empresa` ASC) VISIBLE,
  UNIQUE INDEX `correo_electronico_empresa_UNIQUE` (`correo_electronico_empresa` ASC) VISIBLE,
  UNIQUE INDEX `sitio_web_empresa_UNIQUE` (`sitio_web_empresa` ASC) VISIBLE,
  UNIQUE INDEX `direccion_empresa_UNIQUE` (`direccion_empresa` ASC) VISIBLE)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `seid`.`sucursales`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `seid`.`sucursales` (
  `id_sucursal` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_empresa_fk_sucursal` INT UNSIGNED NULL,
  `nombre_sucursal` VARCHAR(45) NOT NULL,
  `direccion_sucursal` VARCHAR(80) NOT NULL,
  `telefono_sucursal` VARCHAR(15) NOT NULL,
  `status_sucursal` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_sucursal`),
  UNIQUE INDEX `nombre_sucursal_UNIQUE` (`nombre_sucursal` ASC) VISIBLE,
  UNIQUE INDEX `direccion_sucursal_UNIQUE` (`direccion_sucursal` ASC) VISIBLE,
  UNIQUE INDEX `telefono_UNIQUE` (`telefono_sucursal` ASC) VISIBLE,
  INDEX `id_empresa_fk_sucursal_idx` (`id_empresa_fk_sucursal` ASC) VISIBLE,
  CONSTRAINT `id_empresa_fk_sucursal`
    FOREIGN KEY (`id_empresa_fk_sucursal`)
    REFERENCES `seid`.`empresas` (`id_empresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `seid`.`credenciales`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `seid`.`credenciales` (
  `id_credencial` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_sucursal_fk_credencial` INT UNSIGNED NOT NULL,
  `nivel_usuario` VARCHAR(70) NOT NULL,
  `nombres_credencial` VARCHAR(70) NOT NULL,
  `apellidos_credencial` VARCHAR(70) NOT NULL,
  `curp_credencial` VARCHAR(70) NOT NULL,
  `telefono_credencial` VARCHAR(18) NOT NULL,
  `correo_inicio` VARCHAR(70) NOT NULL,
  `pass_inicio` VARCHAR(80) NOT NULL,
  `token_verificacion` VARCHAR(70) NOT NULL,
  `status_credencial` TINYINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_credencial`),
  UNIQUE INDEX `curp_credencial_UNIQUE` (`curp_credencial` ASC) VISIBLE,
  UNIQUE INDEX `telefono_credencial_UNIQUE` (`telefono_credencial` ASC) VISIBLE,
  UNIQUE INDEX `correo_inicio_UNIQUE` (`correo_inicio` ASC) VISIBLE,
  CONSTRAINT `id_sucursal_fk_credencial`
    FOREIGN KEY (`id_sucursal_fk_credencial`)
    REFERENCES `seid`.`sucursales` (`id_sucursal`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `seid`.`qr_codes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `seid`.`qr_codes` (
  `id_qr_code` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_credencial_fk_qr_code` INT UNSIGNED NOT NULL,
  `file_path` VARCHAR(60) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_qr_code`),
  UNIQUE INDEX `id_credencial_qr_codes_UNIQUE` (`id_credencial_fk_qr_code` ASC) VISIBLE,
  CONSTRAINT `id_credencial_fk_qr_code`
    FOREIGN KEY (`id_credencial_fk_qr_code`)
    REFERENCES `seid`.`credenciales` (`id_credencial`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `seid`.`registros`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `seid`.`registros` (
  `id_registro` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_credencial_fk_registro` INT UNSIGNED NOT NULL,
  `fecha` DATE NOT NULL,
  `hora_entrada` DATETIME NOT NULL,
  `hora_salida` DATETIME NULL,
  PRIMARY KEY (`id_registro`),
  INDEX `id_credencial_registros_idx` (`id_credencial_fk_registro` ASC) VISIBLE,
  CONSTRAINT `id_credencial_fk_registro`
    FOREIGN KEY (`id_credencial_fk_registro`)
    REFERENCES `seid`.`credenciales` (`id_credencial`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `seid`.`categorias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `seid`.`categorias` (
  `id_categoria` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre_categoria` VARCHAR(50) NOT NULL,
  `descripcion_categoria` VARCHAR(100) NOT NULL,
  `imagen_marca` VARCHAR(80) NOT NULL,
  `status_marca` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_categoria`),
  UNIQUE INDEX `nombre_categoria_UNIQUE` (`nombre_categoria` ASC) VISIBLE)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `seid`.`marcas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `seid`.`marcas` (
  `id_marca` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre_marca` VARCHAR(45) NOT NULL,
  `descripcion_marca` VARCHAR(100) NOT NULL,
  `imagen_marca` VARCHAR(80) NOT NULL,
  `status_marca` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_marca`),
  UNIQUE INDEX `nombre_marca_UNIQUE` (`nombre_marca` ASC) VISIBLE)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `seid`.`productos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `seid`.`productos` (
  `id_producto` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_categoria_fk_producto` INT UNSIGNED NULL,
  `id_marca_fk_producto` INT UNSIGNED NULL,
  `codigo_barras_producto` BIGINT NOT NULL,
  `nombre_producto` VARCHAR(250) NOT NULL,
  `unidad_compra` ENUM('pieza', 'paquete', 'caja') NOT NULL,
  `unidad_venta` ENUM('pieza', 'paquete', 'caja') NOT NULL,
  `stock_producto` INT UNSIGNED NOT NULL,
  `factor_conversion` INT UNSIGNED NOT NULL,
  `precio_costo_producto` DECIMAL(10,2) UNSIGNED NOT NULL,
  `precio_venta_producto` DECIMAL(10,2) UNSIGNED NOT NULL,
  `aplica_mayoreo` TINYINT NOT NULL DEFAULT 0,
  `precio_mayoreo_producto` DECIMAL(10,2) UNSIGNED NULL,
  `cantidad_minima_mayoreo_producto` INT NULL,
  `imagen_producto` VARCHAR(70) NOT NULL,
  `slug_producto` VARCHAR(55) NOT NULL,
  `status_producto` TINYINT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_producto`),
  UNIQUE INDEX `nombre_UNIQUE` (`nombre_producto` ASC) VISIBLE,
  UNIQUE INDEX `slug_UNIQUE` (`slug_producto` ASC) VISIBLE,
  INDEX `id_categoria_idx` (`id_categoria_fk_producto` ASC) VISIBLE,
  INDEX `id_marca_idx` (`id_marca_fk_producto` ASC) VISIBLE,
  UNIQUE INDEX `codigo_barras_producto_UNIQUE` (`codigo_barras_producto` ASC) VISIBLE,
  CONSTRAINT `id_categoria_fk_producto`
    FOREIGN KEY (`id_categoria_fk_producto`)
    REFERENCES `seid`.`categorias` (`id_categoria`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `id_marca_fk_producto`
    FOREIGN KEY (`id_marca_fk_producto`)
    REFERENCES `seid`.`marcas` (`id_marca`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `seid`.`productos_sucursales`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `seid`.`productos_sucursales` (
  `id_producto_sucursal` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_producto_fk_producto_sucursal` INT UNSIGNED NOT NULL,
  `id_sucursal_fk_producto_sucursal` INT UNSIGNED NOT NULL,
  `cantidad_producto` INT UNSIGNED NOT NULL,
  `precio_venta` DECIMAL(10,2) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_producto_sucursal`),
  INDEX `id_producto_idx` (`id_producto_fk_producto_sucursal` ASC) VISIBLE,
  INDEX `id_sucursal_idx` (`id_sucursal_fk_producto_sucursal` ASC) VISIBLE,
  CONSTRAINT `id_producto_fk_producto_sucursal`
    FOREIGN KEY (`id_producto_fk_producto_sucursal`)
    REFERENCES `seid`.`productos` (`id_producto`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `id_sucursal_fk_producto_sucursal`
    FOREIGN KEY (`id_sucursal_fk_producto_sucursal`)
    REFERENCES `seid`.`sucursales` (`id_sucursal`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `seid`.`ventas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `seid`.`ventas` (
  `id_venta` INT UNSIGNED NOT NULL,
  `id_sucursal_fk_venta` INT UNSIGNED NOT NULL,
  `id_credencial_fk_venta` INT UNSIGNED NOT NULL,
  `folio_venta` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `total_venta` DECIMAL(10,2) UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_venta`),
  INDEX `id_sucursal_idx` (`id_sucursal_fk_venta` ASC) VISIBLE,
  INDEX `id_credencial_idx` (`id_credencial_fk_venta` ASC) VISIBLE,
  UNIQUE INDEX `folio_venta_UNIQUE` (`folio_venta` ASC) VISIBLE,
  CONSTRAINT `id_sucursal_fk_venta`
    FOREIGN KEY (`id_sucursal_fk_venta`)
    REFERENCES `seid`.`sucursales` (`id_sucursal`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `id_credencial_fk_venta`
    FOREIGN KEY (`id_credencial_fk_venta`)
    REFERENCES `seid`.`credenciales` (`id_credencial`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `seid`.`incidencias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `seid`.`incidencias` (
  `id_incidencias` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_credencial_fk_incidencia` INT UNSIGNED NOT NULL,
  `tipo_incidencia` ENUM('producto', 'sistema', 'seguridad', 'otro') NOT NULL,
  `descripcion_incidencia` VARCHAR(250) NOT NULL,
  `status_incidencia` ENUM('pendiente', 'en proceso', 'resuelta') NOT NULL,
  `fecha_resolucion_incidencia` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `comentario_incidencia` VARCHAR(250) NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_incidencias`),
  INDEX `id_credencial_idx` (`id_credencial_fk_incidencia` ASC) VISIBLE,
  CONSTRAINT `id_credencial_fk_incidencia`
    FOREIGN KEY (`id_credencial_fk_incidencia`)
    REFERENCES `seid`.`credenciales` (`id_credencial`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `seid`.`ventas_detalles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `seid`.`ventas_detalles` (
  `id_venta_detalle` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_venta_fk_venta_detalle` INT UNSIGNED NOT NULL,
  `id_producto_sucursal_fk_venta_detalle` INT UNSIGNED NOT NULL,
  `cantidad_producto` INT UNSIGNED NOT NULL,
  `subtotal` DECIMAL(10,2) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_venta_detalle`),
  INDEX `id_venta_idx` (`id_venta_fk_venta_detalle` ASC) VISIBLE,
  INDEX `id_producto_sucursal_idx` (`id_producto_sucursal_fk_venta_detalle` ASC) VISIBLE,
  CONSTRAINT `id_venta_fk_venta_detalle`
    FOREIGN KEY (`id_venta_fk_venta_detalle`)
    REFERENCES `seid`.`ventas` (`id_venta`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `id_producto_sucursal_fk_venta_detalle`
    FOREIGN KEY (`id_producto_sucursal_fk_venta_detalle`)
    REFERENCES `seid`.`productos_sucursales` (`id_producto_sucursal`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `seid`.`proveedores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `seid`.`proveedores` (
  `id_proveedor` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre_proveedor` VARCHAR(100) NOT NULL,
  `contacto_proveedor` VARCHAR(40) NULL,
  `telefono_proveedor` VARCHAR(20) NULL,
  `correo_proveedor` VARCHAR(60) NULL,
  `status_proveedor` TINYINT UNSIGNED NULL,
  PRIMARY KEY (`id_proveedor`),
  UNIQUE INDEX `nombre_proveedor_UNIQUE` (`nombre_proveedor` ASC) VISIBLE,
  UNIQUE INDEX `correo_proveedor_UNIQUE` (`correo_proveedor` ASC) VISIBLE,
  UNIQUE INDEX `telefono_proveedor_UNIQUE` (`telefono_proveedor` ASC) VISIBLE,
  UNIQUE INDEX `status_proveedor_UNIQUE` (`status_proveedor` ASC) VISIBLE)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `seid`.`egresos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `seid`.`egresos` (
  `id_egresos` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_proveedor_fk_egreso` INT UNSIGNED NULL,
  `id_venta_fk_egreso` INT UNSIGNED NULL,
  `descripcion_egreso` VARCHAR(250) NOT NULL,
  `categoria_egreso` ENUM('Compra Inventario', 'Gasto Operativo', 'Devolucion Cliente') NOT NULL,
  `monto_egreso` DECIMAL(10,2) UNSIGNED NOT NULL,
  `fecha_egreso` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_egresos`),
  INDEX `id_proveedor_idx` (`id_proveedor_fk_egreso` ASC) VISIBLE,
  INDEX `id_venta_idx` (`id_venta_fk_egreso` ASC) VISIBLE,
  CONSTRAINT `id_proveedor_fk_egreso`
    FOREIGN KEY (`id_proveedor_fk_egreso`)
    REFERENCES `seid`.`proveedores` (`id_proveedor`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `id_venta_fk_egreso`
    FOREIGN KEY (`id_venta_fk_egreso`)
    REFERENCES `seid`.`ventas` (`id_venta`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `seid`.`pedidos_sucursales`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `seid`.`pedidos_sucursales` (
  `id_pedido_sucursal` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `status_pedido_sucursal` ENUM('recibido', 'aprobado', 'rechazado') NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pedido_sucursal`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `seid`.`pedidos_sucursales_detalles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `seid`.`pedidos_sucursales_detalles` (
  `id_pedido_sucursal_detalle` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_pedido_sucursal_fk_pedido_sucursal_detalle` INT UNSIGNED NOT NULL,
  `id_producto_sucursal_fk_pedido_sucursal_detalle` INT UNSIGNED NOT NULL,
  `cantidad_producto` INT UNSIGNED NOT NULL,
  `precio_venta_producto` DECIMAL(10,2) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_pedido_sucursal_detalle`),
  INDEX `id_pedido_sucursal_idx` (`id_pedido_sucursal_fk_pedido_sucursal_detalle` ASC) VISIBLE,
  INDEX `id_producto_sucursal_idx` (`id_producto_sucursal_fk_pedido_sucursal_detalle` ASC) VISIBLE,
  CONSTRAINT `id_pedido_sucursal_fk_pedido_sucursal_detalle`
    FOREIGN KEY (`id_pedido_sucursal_fk_pedido_sucursal_detalle`)
    REFERENCES `seid`.`pedidos_sucursales` (`id_pedido_sucursal`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `id_producto_sucursal_fk_detalle`
    FOREIGN KEY (`id_producto_sucursal_fk_pedido_sucursal_detalle`)
    REFERENCES `seid`.`productos_sucursales` (`id_producto_sucursal`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `seid`.`lotes_vencimientos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `seid`.`lotes_vencimientos` (
  `id_lote_vencimiento` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_producto_fk_lote_vencimiento` INT UNSIGNED NOT NULL,
  `fecha_vencimiento` DATE NULL,
  PRIMARY KEY (`id_lote_vencimiento`),
  INDEX `id_producto_fk_lote_vencimiento_idx` (`id_producto_fk_lote_vencimiento` ASC) VISIBLE,
  CONSTRAINT `id_producto_fk_lote_vencimiento`
    FOREIGN KEY (`id_producto_fk_lote_vencimiento`)
    REFERENCES `seid`.`productos` (`id_producto`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

SHOW WARNINGS;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

<?php
require_once "conexionf2.php";

class datosInventario
{
    const TABLA = 'inventario';

    public function __construct(
        private $codinventario = null,
        private $nom_inventario = "",
        private $costoinventario = 0.00,
        private $porc_ventainv = 0,
        private $precio_ventainv = 0.00,
        private $imageninv = "",
        private $stockinv = 0,
        private $fechainv = null
    ) {
    }

    // Getters
    public function get_codinventario() {
        return $this->codinventario;
    }

    public function get_nom_inventario() {
        return $this->nom_inventario;
    }

    public function get_costoinventario() {
        return $this->costoinventario;
    }

    public function get_porc_ventainv() {
        return $this->porc_ventainv;
    }

    public function get_precio_ventainv() {
        return $this->precio_ventainv;
    }

    public function get_imageninv() {
        return $this->imageninv;
    }

    public function get_stockinv() {
        return $this->stockinv;
    }

    public function get_fechainv() {
        return $this->fechainv;
    }

    // Setters
    public function set_codinventario($codinventario) {
        $this->codinventario = $codinventario;
    }

    public function set_nom_inventario($nom_inventario) {
        $this->nom_inventario = $nom_inventario;
    }

    public function set_costoinventario($costoinventario) {
        $this->costoinventario = $costoinventario;
    }

    public function set_porc_ventainv($porc_ventainv) {
        $this->porc_ventainv = $porc_ventainv;
    }

    public function set_precio_ventainv($precio_ventainv) {
        $this->precio_ventainv = $precio_ventainv;
    }

    public function set_imageninv($imageninv) {
        $this->imageninv = $imageninv;
    }

    public function set_stockinv($stockinv) {
        $this->stockinv = $stockinv;
    }

    public function set_fechainv($fechainv) {
        $this->fechainv = $fechainv;
    }

    // Métodos CRUD
    public function guardarInventario()
    {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('INSERT INTO ' . self::TABLA . '
            (nom_producto, costo, porc_venta, precio_venta, imagen, fecha)
            VALUES(:pinventario, :pcosto, :pporc_venta, :pprecio_venta, :pImagen, :pFecha)');

        $consulta->bindParam(':pinventario', $this->nom_inventario);
        $consulta->bindParam(':pcosto', $this->costoinventario);
        $consulta->bindParam(':pporc_venta', $this->porc_ventainv);
        $consulta->bindParam(':pprecio_venta', $this->precio_ventainv);
        $consulta->bindParam(':pImagen', $this->imageninv);
        $consulta->bindParam(':pFecha', $this->fechainv);
        $consulta->execute();

        $conexion = null;
    }

    public function actualizarInventario()
    {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('UPDATE ' . self::TABLA . ' SET nom_producto = :pinventario, 
            costo = :pcosto, porc_venta = :pporc_venta, precio_venta = :pprecio_venta, 
            imagen = :pImagen, fecha = :pFecha WHERE codigo = :codinv');

        $consulta->bindParam(':pinventario', $this->nom_inventario);
        $consulta->bindParam(':pcosto', $this->costoinventario);
        $consulta->bindParam(':pporc_venta', $this->porc_ventainv);
        $consulta->bindParam(':pprecio_venta', $this->precio_ventainv);
        $consulta->bindParam(':pImagen', $this->imageninv);
        $consulta->bindParam(':pFecha', $this->fechainv);
        $consulta->bindParam(':codinv', $this->codinventario);
        $consulta->execute();

        $conexion = null;
    }

    public static function actualizarStock($v_idinv, $canstock, $nuevacant)
    {
        if (isset($v_idinv, $canstock, $nuevacant)) {
            $nuevo_stock = $canstock + $nuevacant;
        } else {
            exit;
        }

        $conexion = new Conexion();
        $consulta = $conexion->prepare('UPDATE ' . self::TABLA . ' SET stock = :p_stock WHERE codigo = :codinv');
        $consulta->bindParam(':p_stock', $nuevo_stock);
        $consulta->bindParam(':codinv', $v_idinv);
        $consulta->execute();

        $conexion = null;
        return $consulta;
    }

    public static function totalInventario()
    {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT COUNT(*) FROM ' . self::TABLA);
        $consulta->execute();
        $registros = $consulta->fetchColumn();
        $conexion = null;
        return $registros;
    }

    public static function consultarInventarioCod($codinventario)
    {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' WHERE codigo = :codinv');
        $consulta->bindParam(':codinv', $codinventario);
        $consulta->execute();
        $registros = $consulta->fetchAll(PDO::FETCH_OBJ);
        $conexion = null;
        return $registros;
    }

    public function eliminarInventario()
    {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('DELETE FROM ' . self::TABLA . ' WHERE codigo = :codinv');
        $consulta->bindParam(':codinv', $this->codinventario);
        $consulta->execute();
        $conexion = null;
    }
}
<?php
require_once 'conexionf2.php';
require_once 'fclases.php';

class modificarcliente extends datospersona
{
    const TABLA = 'clientes';

    public function guardar()
    {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('INSERT INTO ' . self::TABLA . ' (nomcli, direccli, telres_cli, telcel_cli, email_cli) VALUES (:nombre, :direccion, :telresidencial, :telcelular, :email)');

        $consulta->bindParam(':nombre', $this->dnombre);
        $consulta->bindParam(':direccion', $this->ddireccion);
        $consulta->bindParam(':telresidencial', $this->dtelresi);
        $consulta->bindParam(':telcelular', $this->dtelcel);
        $consulta->bindParam(':email', $this->demail);

        $resultado = $consulta->execute();
        $conexion = null;
        return $resultado;
    }

    public static function ConsultarClientes()
    {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT idcli, nomcli, telres_cli FROM ' . self::TABLA . ' ORDER BY nomcli');
        $consulta->execute();
        $registros = $consulta->fetchAll(PDO::FETCH_OBJ);
        return $registros;
    }

    public function ConsultarClientesId()
    {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' WHERE idcli = :codcli');
        $consulta->bindParam(':codcli', $this->dcodigo);
        $consulta->execute();
        $registros = $consulta->fetchAll(PDO::FETCH_OBJ);
        return $registros;
    }

    public function actualizar()
    {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('UPDATE ' . self::TABLA . ' SET nomcli = :nombre, direccli = :direccion, telres_cli = :telresidencial, telcel_cli = :telcelular, email_cli = :email WHERE idcli = :codcli');

        $consulta->bindParam(':nombre', $this->dnombre);
        $consulta->bindParam(':direccion', $this->ddireccion);
        $consulta->bindParam(':telresidencial', $this->dtelresi);
        $consulta->bindParam(':telcelular', $this->dtelcel);
        $consulta->bindParam(':email', $this->demail);
        $consulta->bindParam(':codcli', $this->dcodigo);

        $consulta->execute();
        $conexion = null;
    }

    public function eliminar()
    {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('DELETE FROM ' . self::TABLA . ' WHERE idcli = :codcli');
        $consulta->bindParam(':codcli', $this->dcodigo);
        $consulta->execute();
        $conexion = null;
    }

    public static function totalRegistros()
    {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT COUNT(*) FROM ' . self::TABLA);
        $consulta->execute();
        $registros = $consulta->fetchColumn();
        return $registros;
    }

    // Método de paginación corregido
    public static function limitRegistros($inicio, $hasta)
    {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' ORDER BY nomcli LIMIT :inicio, :hasta');
        $consulta->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $consulta->bindValue(':hasta', (int)$hasta, PDO::PARAM_INT);
        $consulta->execute();
        $registros = $consulta->fetchAll(PDO::FETCH_OBJ);
        return $registros;
    }
}
?>
<?php
// Activar reporte de errores visuales en pantalla
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "conexionf2.php";

class datosInventario
{
    const TABLA = 'inventario';

    public static function listarTodo()
    {
        try {
            $conexion = new Conexion();
            $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            echo "<p style='color:red;'><strong>Error en la consulta:</strong> " . $e->getMessage() . "</p>";
            return [];
        }
    }
}

// Obtener los datos
$listaInventario = datosInventario::listarTodo();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>inventario-fares</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>

    <h1>inventario-fares</h1>

    <?php if (!empty($listaInventario)): ?>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Costo</th>
                    <th>% Venta</th>
                    <th>Precio Venta</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaInventario as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item->codigo ?? $item->codproducto ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($item->nom_producto ?? 'Sin nombre') ?></td>
                        <td>$<?= htmlspecialchars($item->costo ?? 0) ?></td>
                        <td><?= htmlspecialchars($item->porc_venta ?? 0) ?>%</td>
                        <td>$<?= htmlspecialchars($item->precio_venta ?? 0) ?></td>
                        <td><?= htmlspecialchars($item->stock ?? 0) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p><strong>Nota:</strong> Se conectó a la base de datos, pero la tabla <em>'inventario'</em> está vacía o no tiene registros guardados.</p>
    <?php endif; ?>

</body>
</html>

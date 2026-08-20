<?php
require_once 'conexionf2.php';

class datosProductos
{
    const TABLA = 'inventario';

    public function __construct(
        private $codproducto = null,
        private $nom_producto = "",
        private $costoproducto = 0.00,
        private $porc_ventapro = 0,
        private $precio_ventapro = 0.00,
        private $imagenpro = "",
        private $stockpro = 0,
        private $fechapro = null
    ) {}

    public function guardarProducto() {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('INSERT INTO ' . self::TABLA . ' (nom_producto, costo, porc_venta, precio_venta, Imagen, stock, Fecha) VALUES (:producto, :pcosto, :pporc_venta, :pprecio_venta, :pImagen, :pstock, :pFecha)');
        $consulta->bindParam(':producto', $this->nom_producto);
        $consulta->bindParam(':pcosto', $this->costoproducto);
        $consulta->bindParam(':pporc_venta', $this->porc_ventapro);
        $consulta->bindParam(':pprecio_venta', $this->precio_ventapro);
        $consulta->bindParam(':pImagen', $this->imagenpro);
        $consulta->bindParam(':pstock', $this->stockpro);
        $consulta->bindParam(':pFecha', $this->fechapro);
        $res = $consulta->execute();
        $conexion = null;
        return $res;
    }

    public function actualizarProducto() {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('UPDATE ' . self::TABLA . ' SET nom_producto = :producto, costo = :pcosto, porc_venta = :pporc_venta, precio_venta = :pprecio_venta, Imagen = :pImagen, stock = :pstock, Fecha = :pFecha WHERE codigo = :codpro');
        $consulta->bindParam(':producto', $this->nom_producto);
        $consulta->bindParam(':pcosto', $this->costoproducto);
        $consulta->bindParam(':pporc_venta', $this->porc_ventapro);
        $consulta->bindParam(':pprecio_venta', $this->precio_ventapro);
        $consulta->bindParam(':pImagen', $this->imagenpro);
        $consulta->bindParam(':pstock', $this->stockpro);
        $consulta->bindParam(':pFecha', $this->fechapro);
        $consulta->bindParam(':codpro', $this->codproducto);
        $consulta->execute();
        $conexion = null;
    }

    public function eliminarproducto() {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('DELETE FROM ' . self::TABLA . ' WHERE codigo = :codpro');
        $consulta->bindParam(':codpro', $this->codproducto);
        $consulta->execute();
        $conexion = null;
    }

    public static function todosProductos() {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT COUNT(*) FROM ' . self::TABLA);
        $consulta->execute();
        $res = $consulta->fetchColumn();
        $conexion = null;
        return $res;
    }

    public static function limitRegistros($inicio, $hasta) {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' ORDER BY nom_producto LIMIT :inicio, :hasta');
        $consulta->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $consulta->bindValue(':hasta', (int)$hasta, PDO::PARAM_INT);
        $consulta->execute();
        $res = $consulta->fetchAll(PDO::FETCH_OBJ);
        $conexion = null;
        return $res;
    }

    public static function consultarProductoCod($codproducto) {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' WHERE codigo = :codpro');
        $consulta->bindParam(':codpro', $codproducto);
        $consulta->execute();
        $res = $consulta->fetchAll(PDO::FETCH_OBJ);
        $conexion = null;
        return $res;
    }
}


function filtrofares($dat_fares) {
    $datos = trim($dat_fares);
    $datos = stripslashes($datos);
    return htmlspecialchars($datos);
}

if (isset($_POST["cguardarprod"])) {
    $vnombre = filtrofares($_POST["cnomproducto"]);
    $vcosto  = filtrofares($_POST["ccostoproducto"]);
    $vporc   = filtrofares($_POST["cporc_ventapro"]);
    $vprecio = filtrofares($_POST["cprecio_ventapro"]);
    $vstock  = (int)filtrofares($_POST["cstockpro"]);
    $vimagen = isset($_POST["cimagenpro"]) ? filtrofares($_POST["cimagenpro"]) : "";
    $vfecha  = filtrofares($_POST["cfechapro"]);

    $prod = new datosProductos(null, $vnombre, $vcosto, $vporc, $vprecio, $vimagen, $vstock, $vfecha);
    $prod->guardarProducto();
    header("Location: cproductos.php");
    exit();
}


if (isset($_POST["cactualizarprod"])) {
    $vcodigo = filtrofares($_POST["ccodigo"]);
    $vnombre = filtrofares($_POST["cnomproducto"]);
    $vcosto  = filtrofares($_POST["ccostoproducto"]);
    $vporc   = filtrofares($_POST["cporc_ventapro"]);
    $vprecio = filtrofares($_POST["cprecio_ventapro"]);
    $vstock  = (int)filtrofares($_POST["cstockpro"]);
    $vimagen = isset($_POST["cimagenpro"]) ? filtrofares($_POST["cimagenpro"]) : "";
    $vfecha  = filtrofares($_POST["cfechapro"]);

    $prod = new datosProductos($vcodigo, $vnombre, $vcosto, $vporc, $vprecio, $vimagen, $vstock, $vfecha);
    $prod->actualizarProducto();
    header("Location: cproductos.php");
    exit();
}


if (isset($_GET['accion']) && $_GET['accion'] == 'eliminar' && isset($_GET['id'])) {
    $prod = new datosProductos($_GET['id']);
    $prod->eliminarproducto();
    header("Location: cproductos.php");
    exit();
}


$editando = false;
$edit_id = ""; $edit_nom = ""; $edit_costo = ""; $edit_porc = ""; $edit_precio = ""; $edit_stock = 0; $edit_img = ""; $edit_fecha = "";

if (isset($_GET['accion']) && $_GET['accion'] == 'editar' && isset($_GET['id'])) {
    $item = datosProductos::consultarProductoCod($_GET['id']);
    if (!empty($item)) {
        $editando = true;
        $edit_id     = $item[0]->codigo;
        $edit_nom    = $item[0]->nom_producto;
        $edit_costo  = $item[0]->costo;
        $edit_porc   = $item[0]->porc_venta;
        $edit_precio = $item[0]->precio_venta;
        $edit_stock  = isset($item[0]->stock) ? $item[0]->stock : 0;
        $edit_img    = isset($item[0]->Imagen) ? $item[0]->Imagen : "";
        $edit_fecha  = $item[0]->Fecha;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="style.css">
    <title>Inventario - Ediciones Fares</title>
</head>
<body>

<div class="w3-container">
    <header class="w3-container fcolor-d5">
        <h1>Ediciones Fares</h1>
    </header>
    
    <nav class="w3-bar fcolor-14">
        <a href="frmcliente.php" class="w3-bar-item w3-button w3-mobile">Principal</a>
        <a href="cproductos.php" class="w3-bar-item w3-button w3-mobile">Inventario</a>
        <a href="frmcliente.php" class="w3-bar-item w3-button w3-mobile">Clientes</a>
    </nav>
</div>

<main class="w3-row-padding w3-container w3-section">
    
    <div class="w3-col m5 s12">
        <div class="w3-container fcolor-d2">
            <h2><?php echo $editando ? 'Editar Producto' : 'Inventario'; ?></h2>
        </div>
        
        <form class="w3-card w3-padding" action="cproductos.php" method="post">
            <?php if ($editando): ?>
                <input type="hidden" name="ccodigo" value="<?php echo $edit_id; ?>">
            <?php endif; ?>

            <label for="pnom" class="w3-label f-color-texto"><b>Nombre del Producto</b></label>
            <input class="w3-input w3-border fcolor-l5" type="text" id="pnom" name="cnomproducto" value="<?php echo $edit_nom; ?>" required>
            
            
            <div class="w3-row-padding w3-section" style="margin: 0 -16px;">
                <div class="w3-half">
                    <label for="pcosto" class="w3-label f-color-texto"><b>Costo</b></label>
                    <input class="w3-input w3-border fcolor-l5" type="number" step="0.01" id="pcosto" name="ccostoproducto" value="<?php echo $edit_costo; ?>" required>
                </div>
                <div class="w3-half">
                    <label for="pstock" class="w3-label f-color-texto"><b>Stock (Cantidad)</b></label>
                    <input class="w3-input w3-border fcolor-l5" type="number" id="pstock" name="cstockpro" value="<?php echo $editando ? $edit_stock : 0; ?>" required>
                </div>
            </div>

            
            <div class="w3-row-padding w3-section" style="margin: 0 -16px;">
                <div class="w3-half">
                    <label for="pprecio" class="w3-label f-color-texto"><b>Precio Venta</b></label>
                    <input class="w3-input w3-border fcolor-l5" type="number" step="0.01" id="pprecio" name="cprecio_ventapro" value="<?php echo $edit_precio; ?>" required>
                </div>
                <div class="w3-half">
                    <label for="pfecha" class="w3-label f-color-texto"><b>Fecha</b></label>
                    <input class="w3-input w3-border fcolor-l5" type="date" id="pfecha" name="cfechapro" value="<?php echo $editando ? $edit_fecha : date('Y-m-d'); ?>" required>
                </div>
            </div>

            
            <input type="hidden" name="cporc_ventapro" value="<?php echo $editando ? $edit_porc : 0; ?>">

            
            <?php if ($editando): ?>
                <button type="submit" class="w3-btn w3-teal w3-section w3-block" name="cactualizarprod">Actualizar Producto</button>
                <a href="cproductos.php" class="w3-btn w3-gray w3-block">Cancelar</a>
            <?php else: ?>
                <button type="submit" class="w3-btn w3-blue-gray w3-section w3-block" name="cguardarprod">Guardar Producto</button>
            <?php endif; ?>
        </form>
    </div>

    
    <div class="w3-col m7 s12">
        <div class="w3-container fcolor-d2">
            <h2>Lista de Productos</h2>
        </div>

        <?php
        $porPagina = 5;
        $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        if ($paginaActual < 1) $paginaActual = 1;

        $totalProductos = datosProductos::todosProductos();
        $totalPaginas = ceil($totalProductos / $porPagina);

        $inicio = ($paginaActual - 1) * $porPagina;
        $listaProductos = datosProductos::limitRegistros($inicio, $porPagina);
        ?>

        <table class="w3-table w3-table-all w3-hoverable w3-striped w3-card">
            <thead>
                <tr class="fcolor-d2">
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($listaProductos)): ?>
                <?php foreach ($listaProductos as $prod): ?>
                    <tr>
                        <td><?php echo $prod->codigo; ?></td>
                        <td><?php echo $prod->nom_producto; ?></td>
                        <td><?php echo isset($prod->stock) ? $prod->stock : 0; ?></td>
                        <td>
                            <a href="cproductos.php?accion=editar&id=<?php echo $prod->codigo; ?>" class="w3-btn w3-teal" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="cproductos.php?accion=eliminar&id=<?php echo $prod->codigo; ?>" class="w3-btn w3-red" onclick="return confirm('¿Desea eliminar este producto?');" title="Eliminar">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="w3-center">No hay registros de inventario.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

        <?php if ($totalPaginas > 1): ?>
            <div class="w3-center w3-section">
                <div class="w3-bar w3-border w3-round">
                    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                        <a href="cproductos.php?pagina=<?php echo $i; ?>" class="w3-button <?php echo ($i == $paginaActual) ? 'fcolor-d2' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<footer class="w3-container fcolor-14" style="position:relative; top: 20px;">
    <p>Todos los derechos reservados Ediciones Fares</p>
</footer>

</body>
</html>
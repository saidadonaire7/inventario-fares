<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="style.css">
    <title>Ediciones Fares</title>
</head>
<body>

<div class="w3-container">
    <header class="w3-container fcolor-d5">
        <h1>Ediciones Fares</h1>
    </header>
    
    <nav class="w3-bar fcolor-14">
        <a href="#" class="w3-bar-item w3-button w3-mobile">Principal</a>
        
        <div class="w3-dropdown-hover w3-mobile">
            <button class="w3-button">Libros▼</button>
            <div class="w3-dropdown-content w3-bar-block ftema">
                <a href="#" class="w3-bar-item w3-button w3-mobile">Educación Básica</a>
                <a href="#" class="w3-bar-item w3-button w3-mobile">I BTP y I BCH</a>
                <a href="#" class="w3-bar-item w3-button w3-mobile">II BTP</a>
                <a href="#" class="w3-bar-item w3-button w3-mobile">III BTP</a>
            </div>
        </div>
        
        <div class="w3-dropdown-hover w3-mobile">
            <button class="w3-button">Inventario▼</button>
            <div class="w3-dropdown-content w3-bar-block ftema">
                <a href="cproductos.php" class="w3-bar-item w3-button w3-mobile">Crear producto</a>
                <a href="cproductos.php" class="w3-bar-item w3-button w3-mobile">Consultar y modificar producto</a>
                <a href="frmcliente.php" class="w3-bar-item w3-button w3-mobile">Clientes</a>
                <a href="#" class="w3-bar-item w3-button w3-mobile">Agregar inventario</a>
                <a href="#" class="w3-bar-item w3-button w3-mobile">Facturar</a>
                <a href="#" class="w3-bar-item w3-button w3-mobile">Información libros</a>
            </div>
        </div>
        
        <a href="#" class="w3-bar-item w3-button w3-mobile">Contacto</a>
    </nav>
</div>

<main class="w3-row-padding w3-container">
    <!-- Formulario con menor ancho (s4 en lugar de s6) -->
    <div class="w3-col s4 w3-mobile w3-section">
        <div class="w3-container fcolor-d2">
            <h2>Ingresar datos del cliente</h2>
        </div>
        
        <form id="clienteForm" class="w3-card w3-padding" action="guardarcli.php" method="post">
            <div class="w3-section">
                <label for="nalum" class="w3-label f-color-texto"><b>Nombre</b></label>
                <input class="w3-input w3-border fcolor-l5" type="text" id="nalum" name="cnomcliente" placeholder="Nombre del cliente" required>
            </div>
            
            <div class="w3-section">
                <label for="cdirec" class="w3-label f-color-texto"><b>Dirección</b></label>
                <textarea class="w3-input w3-border fcolor-l5" id="cdirec" name="cdireccion" placeholder="Dirección"></textarea>
            </div>
            
            <div class="w3-row-padding w3-section" style="margin: 0 -16px;">
                <div class="w3-half">
                    <label for="ctel" class="w3-label f-color-texto"><b>Teléfono residencial</b></label>
                    <input class="w3-input w3-border fcolor-l5" type="tel" id="ctel" name="ctelcasa" placeholder="Teléfono residencial" required>
                </div>
                
                <div class="w3-half">
                    <label for="ccel" class="w3-label f-color-texto"><b>Celular</b></label>
                    <input class="w3-input w3-border fcolor-l5" type="tel" id="ccel" name="ccelular" placeholder="Teléfono celular">
                </div>
            </div>
            
            <div class="w3-section">
                <label for="cemail" class="w3-label f-color-texto"><b>Email</b></label>
                <input class="w3-input w3-border fcolor-l5" type="email" id="cemail" name="cemail" placeholder="Correo electrónico">
            </div>

            <button type="submit" class="w3-btn w3-blue-gray w3-section w3-block" name="cguardar">Guardar</button>
        </form>
    </div>

    <!-- Tabla ocupando el resto del espacio (s8 en lugar de s6) -->
    <div class="w3-col s8 w3-mobile w3-section">
        <div class="w3-container fcolor-d2">
            <h2>Lista de clientes</h2>
        </div>

        <?php
        require_once 'manipularcli.php';

        $porPagina = 5;
        $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        if ($paginaActual < 1) $paginaActual = 1;

        $totalClientes = modificarcliente::totalRegistros();
        $totalPaginas = ceil($totalClientes / $porPagina);

        $inicio = ($paginaActual - 1) * $porPagina;
        $listaclientes = modificarcliente::limitRegistros($inicio, $porPagina);
        ?>

        <table class="w3-table w3-table-all w3-hoverable w3-striped w3-card">
            <thead>
                <tr class="fcolor-d2">
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($listaclientes)) {
                foreach ($listaclientes as $cliente) { ?>
                    <tr>
                        <td><?php echo $cliente->idcli; ?></td>
                        <td><?php echo $cliente->nomcli; ?></td>
                        <td><?php echo $cliente->telres_cli; ?></td>
                        <td>
                            <a href="editcli.php?idcli=<?php echo $cliente->idcli ?>" class="w3-btn w3-teal">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="eliminacli.php?id=<?php echo $cliente->idcli ?>" class="w3-btn w3-red" onclick="return confirm('¿Desea eliminar este cliente?');">
                                <i class="fas fa-user-times"></i>
                            </a>
                        </td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="4" class="w3-center">No hay clientes registrados.</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

        <?php if ($totalPaginas > 1): ?>
            <div class="w3-center w3-section">
                <div class="w3-bar w3-border w3-round">
                    <?php if ($paginaActual > 1): ?>
                        <a href="frmcliente.php?pagina=<?php echo $paginaActual - 1; ?>" class="w3-button">&lt;&lt;</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                        <a href="frmcliente.php?pagina=<?php echo $i; ?>" class="w3-button <?php echo ($i == $paginaActual) ? 'fcolor-d2' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($paginaActual < $totalPaginas): ?>
                        <a href="frmcliente.php?pagina=<?php echo $paginaActual + 1; ?>" class="w3-button">&gt;&gt;</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<footer class="w3-container fcolor-14" style="position:relative; top: 20px;">
    <p>Todos los derechos reservados Ediciones Fares 2026</p>
</footer>

</body>
</html>
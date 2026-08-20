<!-- Agregar el menú -->
<?php require 'menu.php'; ?>

<main class="w3-content" style="max-width:400px">
    <!-- Crear el formulario -->
    <div class="w3-mobile w3-section">
        <!-- Encabezado del formulario -->
        <div class="w3-container w3-teal w3-hover-red">
            <h2>Cargar inventario</h2>
        </div>
        
        <!-- Diseño del formulario -->
        <form class="w3-card" action="insertarMovimiento.php" method="post">
            <div class="w3-row-padding">
                <div class="w3-row-padding">
                    <label for="codpro" class="w3-label f-color-texto"><b>Id del producto:</b></label>
                    <input class="w3-input w3-border fcolor-l5" type="text" placeholder="Id producto" id="codpro" name="codpro" required>
                </div>

                <div class="w3-row-padding">
                    <label for="nompro" class="w3-label f-color-texto"><b>Producto:</b></label>
                    <input class="w3-input w3-border fcolor-l5" type="text" id="nompro" name="nompro" placeholder="Nombre del producto" readonly>
                </div>

                <div class="w3-row-padding">
                    <label for="fechmovi" class="w3-label f-color-texto"><b>Fecha:</b></label>
                    <input class="w3-input w3-border fcolor-l5" type="date" id="fechmovi" name="fechmovi" required>
                </div>

                <div class="w3-row-padding">
                    <label for="cantpro" class="w3-label f-color-texto"><b>Cantidad:</b></label>
                    <input class="w3-input w3-border fcolor-l5" type="text" id="cantpro" name="cantpro" placeholder="Cantidad producto" required>
                </div>

                <button class="w3-btn w3-blue-grey w3-section" name="cguardar">Guardar</button>
            </div>
        </form>
    </div>
</main>

<?php require 'pie_pagina.php'; ?>
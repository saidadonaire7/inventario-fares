<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="style.css">
    <title>Ingresar datos del cliente</title>
</head>
<body>

<div class="w3-container">
    <header class="w3-container fcolor-d5">
        <h1>Ediciones Fares</h1>  
    </header>
    
    <nav class="w3-bar fcolor-14">
        <a href="frmcliente.php" class="w3-bar-item w3-button w3-mobile">Regresar a Clientes</a>
    </nav>
</div>

<?php require_once 'ConsultarCliente.php'; ?>

<main class="w3-row-padding w3-container">
    <div class="w3-mobile w3-section" style="width: 80%; margin: auto;">
        <div class="w3-container fcolor-d2">
            <h2>Editar datos del cliente</h2>
        </div>

        <form class="w3-card" action="actualizarcli.php" method="post">
            <div class="w3-row-padding">
                <div class="w3-third">
                    <label for="ccod" class="w3-label f-color-texto"><b>Código</b></label>
                    <input class="w3-input w3-border fcolor-l5" type="text" id="ccod" name="ccodigo" value="<?php echo $codid; ?>" readonly>
                </div>

                <div class="w3-twothird">
                    <label for="nalum" class="w3-label f-color-texto"><b>Nombre</b></label>
                    <input class="w3-input w3-border fcolor-l5" type="text" id="nalum" name="cnomcliente" value="<?php echo $nombreCli; ?>" required autofocus>
                </div>
            </div>

            <div class="w3-row-padding">
                <label for="cdirec" class="w3-label f-color-texto"><b>Dirección</b></label>
                <textarea class="w3-input w3-border fcolor-l5" id="cdirec" name="cdireccion"><?php echo $direccioncli; ?></textarea>
            </div>

            <div class="w3-row-padding" style="display: flex; gap: 10px; margin-top: 10px;">
                <div style="flex: 1;">
                    <label for="ctel" class="w3-label f-color-texto"><b>Teléfono residencial</b></label>
                    <input class="w3-input w3-border fcolor-l5" type="tel" id="ctel" name="ctelcasa" value="<?php echo $telefonosres; ?>" required>
                </div>

                <div style="flex: 1;">
                    <label for="ccel" class="w3-label f-color-texto"><b>Celular</b></label>
                    <input class="w3-input w3-border fcolor-l5" type="tel" id="ccel" name="ccelular" value="<?php echo $telefonocel; ?>">
                </div>
            </div>

            <div class="w3-row-padding">
                <label for="cemail" class="w3-label f-color-texto"><b>Email</b></label>
                <input class="w3-input w3-border fcolor-l5" type="email" id="cemail" name="cemail" value="<?php echo $correocli; ?>">

                <button class="w3-btn w3-blue-gray w3-section" name="cactualizar">Actualizar cliente</button>
            </div>
        </form>
    </div>
</main>

<footer class="w3-container fcolor-14" style="position:relative; top: 20px;">
    <p>Ediciones Fares</p>
</footer>

</body>
</html>
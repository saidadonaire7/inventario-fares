<?php
require_once 'manipularcli.php';

function filtrofares($dat_fares)
{
    $datos = trim($dat_fares);
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos);
    return $datos;
}

if (isset($_POST["cactualizar"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $vcodigo    = !empty($_POST["ccodigo"])     ? filtrofares($_POST["ccodigo"])     : "";
    $vnombre    = !empty($_POST["cnomcliente"]) ? filtrofares($_POST["cnomcliente"]) : "";
    $vdireccion = !empty($_POST["cdireccion"])  ? filtrofares($_POST["cdireccion"])  : "";
    $vtelresi   = !empty($_POST["ctelcasa"])    ? filtrofares($_POST["ctelcasa"])    : "";
    $vtelcel    = !empty($_POST["ccelular"])    ? filtrofares($_POST["ccelular"])    : "";
    $vemail     = !empty($_POST["cemail"])      ? filtrofares($_POST["cemail"])      : "";

    $guardarcliente = new modificarcliente($vcodigo, $vnombre, $vdireccion, $vtelresi, $vtelcel, $vemail);
    $guardarcliente->actualizar();

    header('Location: frmcliente.php');
    die();
}
?>
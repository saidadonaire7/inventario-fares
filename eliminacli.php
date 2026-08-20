<?php
require_once 'manipularcli.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $eliminarCliente = new modificarcliente($id, null, null, null, null, null);
    $eliminarCliente->eliminar();

    header('Location: frmcliente.php');
    die();
}
?>
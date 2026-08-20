<?php 
require "manipularcli.php";
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$cantRegistros = 5; 

$inicio = ($pagina > 1) ? (($pagina * $cantRegistros) - $cantRegistros) : 0;
$totalregistros = modificarcliente::totalRegistros();
$totalregistros = modificarcliente::limitRegistros($inicio, $cantRegistros);
$numeropaginas = ceil($totalregistros / $cantRegistros)

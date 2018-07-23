<?php

include('./conexion.php');
include('./consultas.php');

print_r($_POST);

$opcion = $_POST['seleccion'];
$inicio = $_POST['inicio'];
$final = $_POST['final'];

$query = primaryQuery($opcion,$inicio,$final);
$prep = sqlsrv_prepare($conn,$query);
$resultado = sqlsrv_execute($prep);

while ( $fila = sqlsrv_fetch_object($prep) ){
	echo("<br/>");
	print_r($fila);
}
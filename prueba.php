<?php

include('./conexion.php');
include('./consultas.php');


$opcion = $_POST['seleccion'];
$inicio = $_POST['inicio'];
$final = $_POST['final'];

$query = primaryQuery($opcion,$inicio,$final);
$prep = sqlsrv_prepare($conn,$query);
$resultado = sqlsrv_execute($prep);


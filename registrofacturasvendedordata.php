<?php
session_start();

include 'conexion.php';
//require 'index.php';
$idusuario = $_SESSION['id'];


$query = "SELECT ev.id,ev.numero,ev.fecha,v.nombre_vendedor,concat(c.nombre1_cliente,'',c.apellido1_cliente) as nombre_cliente,ev.estado from enc_venta ev inner join vendedor v on ev.id_vendedor = v.id
inner join cliente c on ev.id_cliente = c.id WHERE v.id = $idusuario;";

$resultado = mysqli_query($cnn, $query);

while ($data = mysqli_fetch_assoc($resultado)) {
    $arreglo["data"][] = $data;
}

echo json_encode($arreglo);

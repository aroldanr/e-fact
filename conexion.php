<?php
header('Content-Type: text/html; charset=utf-8');

$EMPRESA = 'eFact :: DISTRIBUIDORA JAZM&Iacute;N';
$DB_HOST = 'localhost';
$DB_NAME = 'donaldo_inventory';
$DB_USER = 'root';
$DB_PASS = "";
//$DB_NAME = 'inventory';
//$DB_USER = 'root';
//$DB_PASS = 'mysql3000';

$cnn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($cnn->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $cnn->connect_errno . ") " . $cnn->
        connect_error;
}
<?php

session_start();


$servidor = "sql308.infinityfree.com"; 
$usuario_db = "if0_40249400";     
$password_db = "35A7f5f181"; 
$nombre_db = "if0_40249400_proyectos"; 

// Crear la conexión
$conexion = new mysqli($servidor, $usuario_db, $password_db, $nombre_db);

// Verificar si hay errores en la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>

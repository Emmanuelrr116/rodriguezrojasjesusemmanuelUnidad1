<?php
// Iniciar sesión. Esto debe estar en todas las páginas que usan sesiones.
session_start();

// Datos de conexión a la base de datos
$servidor = "localhost";
$usuario_db = "root";
$password_db = "";
$nombre_db = "cointrack_db";

// Crear la conexión
$conexion = new mysqli($servidor, $usuario_db, $password_db, $nombre_db);

// Verificar si hay errores en la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>
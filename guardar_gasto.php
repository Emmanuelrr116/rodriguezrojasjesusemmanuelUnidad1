<?php
require 'db.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_SESSION['id_usuario'];
    $descripcion = $_POST['descripcion'];
    $monto = $_POST['monto'];
    $categoria = $_POST['categoria'];
    $fecha_gasto = $_POST['fecha_gasto'];

    $stmt = $conexion->prepare("INSERT INTO gastos (id_usuario, descripcion, monto, categoria, fecha_gasto) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isdss", $id_usuario, $descripcion, $monto, $categoria, $fecha_gasto);
    $stmt->execute();
    $stmt->close();
    $conexion->close();

    header("Location: dashboard.php");
    exit();
}
?>
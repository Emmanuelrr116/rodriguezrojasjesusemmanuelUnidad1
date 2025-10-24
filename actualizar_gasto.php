<?php
require 'db.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_gasto = $_POST['id'];
    $id_usuario = $_SESSION['id_usuario'];
    $descripcion = $_POST['descripcion'];
    $monto = $_POST['monto'];
    $categoria = $_POST['categoria'];
    $fecha_gasto = $_POST['fecha_gasto'];

    $stmt = $conexion->prepare("UPDATE gastos SET descripcion = ?, monto = ?, categoria = ?, fecha_gasto = ? WHERE id = ? AND id_usuario = ?");
    $stmt->bind_param("sdssii", $descripcion, $monto, $categoria, $fecha_gasto, $id_gasto, $id_usuario);
    $stmt->execute();
    $stmt->close();
    $conexion->close();

    header("Location: dashboard.php");
    exit();
}
?>
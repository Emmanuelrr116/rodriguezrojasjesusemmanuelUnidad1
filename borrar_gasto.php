<?php
require 'db.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$id_gasto = $_GET['id'];
$id_usuario = $_SESSION['id_usuario'];

$stmt = $conexion->prepare("DELETE FROM gastos WHERE id = ? AND id_usuario = ?");
$stmt->bind_param("ii", $id_gasto, $id_usuario);
$stmt->execute();
$stmt->close();
$conexion->close();

header("Location: dashboard.php");
exit();
?>
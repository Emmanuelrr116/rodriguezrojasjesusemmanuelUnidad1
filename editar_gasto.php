<?php
require 'db.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$id_gasto = $_GET['id'];
$id_usuario = $_SESSION['id_usuario'];

$stmt = $conexion->prepare("SELECT descripcion, monto, categoria, fecha_gasto FROM gastos WHERE id = ? AND id_usuario = ?");
$stmt->bind_param("ii", $id_gasto, $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();
$gasto = $resultado->fetch_assoc();

if (!$gasto) {
    // Si el gasto no existe o no pertenece al usuario, lo mandamos al dashboard
    header("Location: dashboard.php");
    exit();
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Gasto - CoinTrack</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">
        <h1>Editar Gasto</h1>
        <form action="actualizar_gasto.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id_gasto; ?>">
            <input type="text" name="descripcion" value="<?php echo htmlspecialchars($gasto['descripcion']); ?>" required>
            <input type="number" step="0.01" name="monto" value="<?php echo htmlspecialchars($gasto['monto']); ?>" required>
            <input type="text" name="categoria" value="<?php echo htmlspecialchars($gasto['categoria']); ?>">
            <input type="date" name="fecha_gasto" value="<?php echo htmlspecialchars($gasto['fecha_gasto']); ?>" required>
            <button type="submit">Actualizar Gasto</button>
        </form>
    </div>
</body>
</html>
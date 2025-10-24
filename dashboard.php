<?php
require 'db.php';

// Protección de la página: si no hay sesión, se redirige al login
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - CoinTrack</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">
        <h1>Dashboard de Gastos de <?php echo htmlspecialchars($_SESSION['usuario']); ?></h1>
        <a href="logout.php">Cerrar Sesión</a>

        <h2>Registrar Nuevo Gasto</h2>
        <form action="guardar_gasto.php" method="post">
            <input type="text" name="descripcion" placeholder="Descripción del gasto" required>
            <input type="number" step="0.01" name="monto" placeholder="Monto (ej: 50.00)" required>
            <input type="text" name="categoria" placeholder="Categoría (ej: Comida)">
            <input type="date" name="fecha_gasto" required>
            <button type="submit">Guardar Gasto</button>
        </form>

        <h2>Historial de Gastos</h2>
        <table>
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Monto</th>
                    <th>Categoría</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $conexion->prepare("SELECT id, descripcion, monto, categoria, fecha_gasto FROM gastos WHERE id_usuario = ? ORDER BY fecha_gasto DESC");
                $stmt->bind_param("i", $id_usuario);
                $stmt->execute();
                $resultado = $stmt->get_result();

                if ($resultado->num_rows > 0) {
                    while($fila = $resultado->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($fila['descripcion']) . "</td>";
                        echo "<td>$" . number_format($fila['monto'], 2) . "</td>";
                        echo "<td>" . htmlspecialchars($fila['categoria']) . "</td>";
                        echo "<td>" . htmlspecialchars($fila['fecha_gasto']) . "</td>";
                        echo "<td class='acciones'>
                                <a href='editar_gasto.php?id=" . $fila['id'] . "' class='editar'>Editar</a>
                                <a href='borrar_gasto.php?id=" . $fila['id'] . "' onclick='return confirm(\"¿Estás seguro de que quieres borrar este gasto?\")' class='borrar'>Borrar</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No has registrado ningún gasto todavía.</td></tr>";
                }
                $stmt->close();
                $conexion->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
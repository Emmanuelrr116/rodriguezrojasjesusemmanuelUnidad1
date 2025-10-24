<?php
require 'db.php';
$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password_plana = $_POST['password'];

    $stmt = $conexion->prepare("SELECT id, usuario, password FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $nombre_usuario, $password_hash);
        $stmt->fetch();

        // Verificar la contraseña (¡punto clave de seguridad!)
        if (password_verify($password_plana, $password_hash)) {
            $_SESSION['id_usuario'] = $id;
            $_SESSION['usuario'] = $nombre_usuario;
            header("Location: dashboard.php");
            exit();
        } else {
            $mensaje = '<div class="mensaje-error">Contraseña incorrecta.</div>';
        }
    } else {
        $mensaje = '<div class="mensaje-error">El usuario no existe.</div>';
    }
    $stmt->close();
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - CoinTrack</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">
        <h1>Iniciar Sesión en CoinTrack</h1>
        <?php echo $mensaje; ?>
        <form action="login.php" method="post">
            <input type="text" name="usuario" placeholder="Nombre de Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Entrar</button>
        </form>
        <div class="link-formulario">
            <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
        </div>
    </div>
</body>
</html>
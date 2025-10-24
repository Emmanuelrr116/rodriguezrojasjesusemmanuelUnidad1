<?php
require 'db.php';
$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST['usuario']);
    $password_plana = trim($_POST['password']);

    if (empty($usuario) || empty($password_plana)) {
        $mensaje = '<div class="mensaje-error">Por favor, completa todos los campos.</div>';
    } else {
        // Encriptar la contraseña (¡punto clave de seguridad!)
        $password_hash = password_hash($password_plana, PASSWORD_BCRYPT);

        $stmt = $conexion->prepare("INSERT INTO usuarios (usuario, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $usuario, $password_hash);

        if ($stmt->execute()) {
            $mensaje = '<div class="mensaje-exito">¡Usuario registrado con éxito!</div>';
        } else {
            $mensaje = '<div class="mensaje-error">Error: El nombre de usuario ya existe.</div>';
        }
        $stmt->close();
    }
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - CoinTrack</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">
        <h1>Crear una Cuenta en CoinTrack</h1>
        <?php echo $mensaje; ?>
        <form action="registro.php" method="post">
            <input type="text" name="usuario" placeholder="Nombre de Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Registrarse</button>
        </form>
        <div class="link-formulario">
            <p>¿Ya tienes una cuenta? <a href="login.php">Inicia Sesión</a></p>
        </div>
    </div>
</body>
</html>
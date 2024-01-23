<!DOCTYPE html>
<html>
<head>
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Formulario de Inicio de Sesión</h2>
    <form method="post">
        <div class="form-group">
            <label for="correo">Correo:</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
        </div>
        <div class="form-group">
            <label for="contrasena">Contraseña:</label>
            <input type="password" class="form-control" id="contrasena" name="contrasena" required>
        </div>
        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
    </form>
</div>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Iniciar sesión
    session_start();

    // Crear conexión
    $conn = new mysqli('localhost', 'root', '', 'test');

    // Verificar conexión
    if ($conn->connect_error) {
        die("La conexión ha fallado: " . $conn->connect_error);
    }

    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Verificar las credenciales
    $sql = "SELECT * FROM usuarios WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Las credenciales son correctas
        $usuario = $resultado->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($contrasena, $usuario['contrasena'])) {
            // Guardar el usuario en la sesión
            $_SESSION['usuario'] = $usuario;

            echo "Credenciales válidas.";
        } else {
            echo "Credenciales no válidas.";
        }
    } else {
        // Las credenciales son incorrectas
        echo "Credenciales no válidas.";
    }
}
?>

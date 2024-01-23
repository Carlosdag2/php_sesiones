<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Formulario de Registro</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="correo">Correo:</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
        </div>
        <div class="form-group">
            <label for="contrasena">Contraseña:</label>
            <input type="password" class="form-control" id="contrasena" name="contrasena" required>
        </div>
        <div class="form-group">
            <label for="archivo">Archivo:</label>
            <input type="file" class="form-control-file" id="archivo" name="archivo" accept=".jpg,.pdf" required>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Crear conexión
    $conn = new mysqli('localhost', 'root', '', 'test');

    // Verificar conexión
    if ($conn->connect_error) {
        die("La conexión ha fallado: " . $conn->connect_error);
    }

    // Recoger los datos del formulario
    $correo = $_POST['correo'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); // Usar password_hash
    $archivo = $_FILES['archivo'];

    // Validar el archivo
    $permitidos = array('jpg', 'pdf');
    $ext = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    if (!in_array($ext, $permitidos)) {
        die("Tipo de archivo no válido.");
    }

    // Guardar el archivo (asegúrate de que el directorio de destino sea seguro)
    move_uploaded_file($archivo['tmp_name'], '/ruta/a/destino/' . $archivo['name']);

    // Insertar en la base de datos
    $sql = "INSERT INTO usuarios (correo, contrasena, archivo) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $correo, $contrasena, $archivo['name']);
    $stmt->execute();

    // Redirigir al usuario a la página de inicio de sesión
    header("Location: inicioSesion.php");
}
?>

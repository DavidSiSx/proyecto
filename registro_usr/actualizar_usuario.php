<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "denthub";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$apellido_paterno = $_POST['apellido_paterno'];
$apellido_materno = $_POST['apellido_materno'];
$usuario = $_POST['usuario'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$estado = $_POST['estado'];

$stmt = $conn->prepare("CALL ActualizarUsuario(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssssssss", $id, $nombre, $apellido_paterno, $apellido_materno, $usuario, $correo, $telefono, $contrasena, $fecha_nacimiento, $estado);

if ($stmt->execute()) {
    echo "Actualización exitosa";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

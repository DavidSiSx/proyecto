<?php
session_start();
include('../../../connection/connection.php');

// Obtener el id del paciente desde la sesión
$id_paciente = $_SESSION['id_paciente'];  

// Consulta para obtener las citas del paciente
$sql = "SELECT pacientes.nombre, pacientes.telefono, citas.fecha_hora, citas.motivo, citas.comentarios
    FROM citas
    INNER JOIN pacientes ON citas.id_paciente = pacientes.id_paciente
    WHERE citas.id_paciente = ?";
    
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_paciente);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Citas</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <header>
        <nav>
            <div class="arriba">
                <a class="navbar-brand" href="#">
                    <img src="../../img/logo.png" width="100" height="50" alt="">
                </a>
                <div class="navbar_items">
                    <li><a href="../index.html">Home</a></li>
                    <li><a href="../info/index.html">Informacion</a></li>
                    <li><a href="#">Citas</a></li>
                    <li><a href="../servicios/index.html">Servicios</a></li>
                    <div class="contenedor_icons">
                        <a class="navbar-brand" href="../registro/index.html">
                            <img src="../../img/usuario (1).png" alt="" width="30" height="24">
                        </a>
                        <a class="navbar-brand" href="https://www.google.com.mx/maps/preview">
                            <img src="../../img/marcador (2).png" alt="" width="30" height="24">
                        </a>
                        <a class="navbar-brand" href="#">
                            <img src="../../img/hogar (2).png" alt="" width="30" height="24">
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div class="xd">
        <h1>Administrar Citas</h1>
    </div>
    <main>
        <section class="appointment-list">
            <h2>Mis Citas</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Motivo</th>
                        <th>Comentarios</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): 
                        $fecha_hora = new DateTime($row['fecha_hora']);
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nombre']) ?></td>
                        <td><?= htmlspecialchars($row['telefono']) ?></td>
                        <td><?= $fecha_hora->format('Y-m-d') ?></td>
                        <td><?= $fecha_hora->format('H:i') ?></td>
                        <td><?= htmlspecialchars($row['motivo']) ?></td>
                        <td><?= htmlspecialchars($row['comentarios']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>
    <div class="citabtn">
        <a href="./agendar_cita.php"><button class="cancel-btn">Agendar nueva cita</button></a>
    </div>
    <footer class="bg_footer">
        <div class="footer-container">
            <ul>
                <li><a href="#aviso-privacidad">Aviso de privacidad</a></li>
                <li><a href="#terminos-y-condiciones">Términos y condiciones</a></li>
                <li><a href="#mapa-de-sitio">Mapa de sitio</a></li>
            </ul>
            <p>&copy; 2023 Dentavida. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>

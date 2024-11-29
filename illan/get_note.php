<?php
// Conexión a la base de datos
$servername = "lldn292.servidoresdns.net";
$username = "qalb859";
$password = "Illan2024%";
$dbname = "qalb859";

$conexion = new mysqli($servername, $username, $password, $dbname);

if ($conexion->connect_error) {
    die("Error en la conexion: " . $conexion->connect_error); 
}

if (isset($_GET['date'])) {
    $date = $_GET['date'];

    // Consulta para obtener todas las notas asociadas a una fecha específica
    $stmt = $conexion->prepare("SELECT id, nota FROM notas WHERE fecha = ?");
    $stmt->bind_param('s', $date);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $nota);

    $notes = [];
    while ($stmt->fetch()) {
        $notes[] = ['id' => $id, 'nota' => $nota];
    }

    $stmt->close();
    
    // Devolver todas las notas en formato JSON
    echo json_encode($notes);
}

$conexion->close();
?>

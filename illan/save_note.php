<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexión a la base de datos
$servername = "lldn292.servidoresdns.net";
$username = "qalb859";
$password = "Illan2024%";
$dbname = "qalb859";

// Crear conexión
$conexion = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST["date"];
    $note = $_POST["note"];

    // Verificamos si los campos están vacíos en el servidor
    if (empty($date) || empty($note)) {
        header('Location: index.php?error=empty_fields');
        exit;
    }

    // Insertamos una nueva nota
    $stmt = $conexion->prepare("INSERT INTO notas (fecha, nota) VALUES (?, ?)");
    $stmt->bind_param('ss', $date, $note);
    if ($stmt->execute()) {
        header('Location: index.php?success=true');
    } else {
        header('Location: index.php?error=insert_failed');
    }

    $stmt->close();
    $conexion->close();
}
?>

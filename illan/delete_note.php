<?php
// delete_note.php

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

if (isset($_POST['note_id'])) {
    $note_id = $_POST['note_id'];

    // Verificar si el ID es válido (un número entero)
    if (is_numeric($note_id) && $note_id > 0) {
        // Eliminar la nota de la base de datos
        $sql = "DELETE FROM notas WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $note_id);

        if ($stmt->execute()) {
            header("Location: index.php?success=true");
        } else {
            echo "Error al eliminar la nota: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "ID inválido.";
    }
} else {
    echo "No se recibió un ID de nota.";
}

// Cerrar la conexión
$conexion->close();
?>

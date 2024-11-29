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

// Obtener las notas
$sql = "SELECT id, fecha, nota FROM notas";
$result = $conexion->query($sql);

echo "<h2 class='h2Notas' style='text-align:center; color: #4CAF50;'>Lista de notas:</h2>";

if ($result->num_rows > 0) {
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>";
        echo "<strong>ID:</strong> " . $row["id"] . " <br>";
        echo "<strong>Fecha:</strong> " . $row["fecha"] . " <br>";
        echo "<strong>Nota:</strong> " . $row["nota"] . " <br>";
        // Formulario para eliminar la nota
        echo "<form action='delete_note.php' method='POST' style='display:inline;'>";
        echo "<input type='hidden' name='note_id' value='" . $row["id"] . "'>"; // Campo oculto con el ID
        echo "<input type='submit' value='Eliminar' class='eliminarLi'>";
        echo "</form>";
        echo "</li><br>";
    }
    echo "</ul>";
} else {
    echo "No se encontraron notas en la base de datos.";
}

$conexion->close();
?>

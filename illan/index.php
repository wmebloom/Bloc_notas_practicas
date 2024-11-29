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

// Obtención de la fecha actual
$currentDate = date("Y-m-d");

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloc de notas</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="css/calendar.png">
</head>
<body>
    <div class="contenedor">
        <!-- Botón para cargar las notas -->
        <button id="toggleNotasBtn" onclick="toggleNotas()">Ver Notas</button>

        <!-- Boton modo noche -->
        <button class="modo_noche">🌙</button>

        <!-- Mostrar mensajes de éxito -->
        <?php if (isset($_GET['success'])): ?>
            <p style="color: #4CAF50;">¡Nota guardada con éxito!</p>
        <?php endif; ?>

        <!-- Mostrar mensaje de error -->
        <?php if (isset($_GET['error'])): ?>
            <?php if ($_GET['error'] == 'empty_fields'): ?>
                <p style="color: red;">¡Por favor, completa todos los campos!</p>
            <?php elseif ($_GET['error'] == 'insert_failed'): ?>
                <p style="color: red;"> ¡Hubo un error al guardar la nota!</p>
            <?php endif; ?>
        <?php endif; ?>

        <h1>Bloc de notas</h1>
        <form action="save_note.php" method="post">
            <fieldset>
                <label for="date">Selecciona la fecha:</label>
                <input type="date" id="date" name="date" value="<?php echo $currentDate; ?>" required>
                <br><br>
                <label for="note">Escribe tu nota:</label><br>
                <textarea name="note" id="note" rows="10" cols="30" required></textarea>
                <br><br>
                <input type="submit" value="Guardar Nota">
            </fieldset>

            <!-- Contenedor para las notas existentes -->
            <div id="notesContainer"></div>
            <br><br>
        </form>
    </div>
    <div id="get_all_notes_container"></div>

    <script src="script1.js?v=<?php echo time(); ?>"></script>
</body>
</html>

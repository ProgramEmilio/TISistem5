<?php
include('../BD/ConexionBD.php');

// Recoger las respuestas
if (isset($_POST['facilidad']) && isset($_POST['rendimiento']) && isset($_POST['precision'])) {
    $facilidad = $_POST['facilidad'];
    $rendimiento = $_POST['rendimiento'];
    $precisi = $_POST['precision'];  

    // Guardar las respuestas en la base de datos
    $sql = "INSERT INTO respuestas (facilidad, rendimiento, precisi) VALUES ('$facilidad', '$rendimiento', '$precisi')";
    
    if ($conn->query($sql) === TRUE) {
        // Redirigir a la página de inicio
        header("Location: Revisar.php"); 
        exit(); 
    } else {
        echo "Error al guardar las respuestas: " . $conn->error;
    }
} else {
    echo "No se respondieron todas las preguntas.";
}

$conn->close();
?>

<?php
include('../BD/ConexionBD.php');

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $Id_problema = $_POST['Id_problema'];
    $problema = $_POST['problema'];
    $causa_raiz = $_POST['causa_raiz'];
    $error_conocido = $_POST['error_conocido'];
    $solucion = $_POST['solucion'];
    $Id_usuario = $_POST['Id_usuario']; // Asegúrate de que el formulario tiene este campo

    // Asegurarse de que todos los datos necesarios están definidos
    if (isset($problema, $causa_raiz, $error_conocido, $solucion, $Id_usuario)) {
        // Consulta SQL para actualizar el problema
        $sql = "UPDATE Problemas 
                SET problema = '$problema', 
                    causa_raiz = '$causa_raiz', 
                    error_conocido = '$error_conocido', 
                    solucion = '$solucion', 
                    usuario = '$Id_usuario' 
                WHERE Id_problema = '$Id_problema'";
       
        if ($conn->query($sql) === TRUE) {
            // Redirigir a la página de problemas después de actualizar los datos
            header("Location: problema.php");
            exit;
        } else {
            echo "Error al actualizar: " . $conn->error;
        }
    } else {
        echo "Por favor completa todos los campos.";
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
}
?>

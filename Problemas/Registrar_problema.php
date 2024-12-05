<?php
include('../BD/ConexionBD.php');

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $problema = $_POST['problema'];
    $causa_raiz = $_POST['causa_raiz'];
    $error_conocido = $_POST['error_conocido'];
    $solucion = $_POST['solucion'];
    $usuario = $_POST['Id_usuario']; // Este debe ser el ID del usuario

    // Preparar la consulta SQL
    $sql = "INSERT INTO Problemas (problema, causa_raiz, error_conocido, solucion, usuario) 
            VALUES ('$problema', '$causa_raiz', '$error_conocido', '$solucion', '$usuario')";

    // Ejecutar la consulta SQL
    if (mysqli_query($conn, $sql)) {
        header("Location: problema.php"); // Redirigir a la página de problemas
        exit();
    } else {
        echo "Error al registrar el problema: " . mysqli_error($conn);
    }
} else {
    echo 'El formulario no ha sido enviado correctamente.';
}

// Cerrar la conexión
$conn->close();
?>
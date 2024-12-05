<?php
include('../../../BD/ConexionBD.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $Id_edificio = $conn->real_escape_string($_POST['Id_edificio']);
    $Id_edificio1 = isset($_POST['Id_edificio']) ? $conn->real_escape_string($_POST['Id_edificio']) : '';
    $Id_departamento = isset($_POST['Id_departamento']) ? $conn->real_escape_string($_POST['Id_departamento']) : '';

    if (!$conn) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    // SQL para actualizar los datos del salon
    $sql = "UPDATE edificio 
            SET Id_departamento = '$Id_departamento'
            WHERE Id_edificio = '$Id_edificio'";

    if ($conn->query($sql) === TRUE) {
        // Redirigir a la página de catálogo después de actualizar los datos
        header("Location: ../Edificio.php");
        exit;
    } else {
        echo "Error al actualizar la información: " . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
}
?>
<?php
include('../../../BD/ConexionBD.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $Id_salon = $conn->real_escape_string($_POST['Id_salon']);
    $Id_edificio = isset($_POST['Id_edificio']) ? $conn->real_escape_string($_POST['Id_edificio']) : '';
    $tipo = isset($_POST['tipo']) ? $conn->real_escape_string($_POST['tipo']) : '';
    $descripcion = isset($_POST['descripcion']) ? $conn->real_escape_string($_POST['descripcion']) : '';

    if (!$conn) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    // SQL para actualizar los datos del salon
    $sql = "UPDATE salon 
            SET Id_edificio = '$Id_edificio', 
                tipo = '$tipo', 
                descripcion = '$descripcion'
            WHERE Id_salon = '$Id_salon'";

    if ($conn->query($sql) === TRUE) {
        // Redirigir a la página de catálogo después de actualizar los datos
        header("Location: ../salon.php");
        exit;
    } else {
        echo "Error al actualizar la información: " . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
}
?>
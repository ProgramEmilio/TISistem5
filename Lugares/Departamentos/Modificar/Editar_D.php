<?php
include('../../../BD/ConexionBD.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $Id_departamento = $conn->real_escape_string($_POST['Id_departamento']);
    $nombre = isset($_POST['nombre']) ? $conn->real_escape_string($_POST['nombre']) : '';
    $J_departamento = isset($_POST['J_departamento']) ? $conn->real_escape_string($_POST['J_departamento']) : '';

    if (!$conn) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    // SQL para actualizar los datos del salon
    $sql = "UPDATE departamento
            SET Id_departamento = '$Id_departamento',
            nombre = '$nombre',
            J_departamento = '$J_departamento'
            WHERE Id_departamento = '$Id_departamento'";

    if ($conn->query($sql) === TRUE) {
        // Redirigir a la página de catálogo después de actualizar los datos
        header("Location: ../Departamentos.php");
        exit;
    } else {
        echo "Error al actualizar la información: " . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
}
?>
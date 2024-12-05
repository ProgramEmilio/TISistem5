<?php
include("../../BD/ConexionBD.php");

// Comprobar si se recibió el parámetro por la URL
if (isset($_GET['id_ts']) && !empty($_GET['id_ts'])) {
    $id_ts = mysqli_real_escape_string($conn, $_GET['id_ts']);

    // Ejecutar la consulta de eliminación
    $sql = "DELETE FROM tipo_salon WHERE id_ts = '$id_ts'";        
    
    if (mysqli_query($conn, $sql)) {
        header("Location: salon.php");
        exit();
    } else {
        echo "Error al eliminar el registro: " . mysqli_error($conn);
    }
} else {
    echo "No se proporcionó un ID válido.";
}

// Cerrar conexión
$conn->close();
?>
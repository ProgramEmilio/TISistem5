<?php
include("../BD/ConexionBD.php");

// Comprobar si se recibió el parámetro por la URL
if (isset($_GET['Id_Utipo']) && !empty($_GET['Id_Utipo'])) {
    $Id_Utipo = mysqli_real_escape_string($conn, $_GET['Id_Utipo']);

    // Ejecutar la consulta de eliminación
    $sql = "DELETE FROM Tipo_Usuarios WHERE Id_Utipo = '$Id_Utipo'";        
    
    if (mysqli_query($conn, $sql)) {
        header("Location: Usuario.php");
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
<?php
    include('../BD/ConexionBD.php');

        // Obtener los datos del formulario
        // Verificar si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $catalogo = $_POST['catalogo'];
        $Id_especial = $_POST['Id_especial'];
        } else {
            echo 'El formulario no ha sido enviado correctamente.';
        }
    
        // Preparar la consulta SQL
        $sql = "INSERT INTO catalogo_servicios (catalogo,Id_especial) VALUES ('$catalogo', '$Id_especial')";

        // Ejecutar la consulta SQL
        if(mysqli_query($conn, $sql)) {
            header("Location: soli_edi.php");
            exit();
        } else {
            echo "Error al registrar el servicio: " . mysqli_error($conn);
        }

        // Cerrar la consulta y la conexión
        $conn->close();
?>
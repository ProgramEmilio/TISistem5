<?php
    include('../../../BD/ConexionBD.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Escapar valores para prevenir inyección SQL
        $Id_edificio = mysqli_real_escape_string($conn, $_POST['Id_edificio']);
        $Id_departamento = mysqli_real_escape_string($conn, $_POST['Id_departamento']);

        // Consulta SQL para insertar datos en la tabla 'edificio'
        $sql = "INSERT INTO edificio (Id_edificio, Id_departamento) 
                VALUES ('$Id_edificio', '$Id_departamento')";

        // Ejecutar la consulta SQL
        if (mysqli_query($conn, $sql)) {
            header("Location: ../Edificio.php");
            exit();
        } else {
            echo "Error al registrar el Edificio: " . mysqli_error($conn);
        }

        // Cerrar la conexión
        $conn->close();
    } else {
        echo 'El formulario no ha sido enviado correctamente.';
    }
?>


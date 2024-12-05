<?php
    include('../../../BD/ConexionBD.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Escapar valores para prevenir inyección SQL
        $Id_departamento = mysqli_real_escape_string($conn, $_POST['Id_departamento']);
        $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
        $J_departamento = mysqli_real_escape_string($conn, $_POST['J_departamento']);

        // Consulta SQL para insertar datos en la tabla 'edificio'
        $sql = "INSERT INTO departamento (Id_departamento, nombre, J_departamento) 
                VALUES ('$Id_departamento', '$nombre', '$J_departamento')";

        // Ejecutar la consulta SQL
        if (mysqli_query($conn, $sql)) {
            header("Location: ../Departamentos.php");
            exit();
        } else {
            echo "Error al registrar el departamento: " . mysqli_error($conn);
        }

        // Cerrar la conexión
        $conn->close();
    } else {
        echo 'El formulario no ha sido enviado correctamente.';
    }
?>
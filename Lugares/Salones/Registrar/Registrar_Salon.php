<?php
    include('../../../BD/ConexionBD.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $Id_salon = $_POST['Id_salon'];
        $Id_edificio = $_POST['Id_edificio'];
        $tipo = $_POST['tipo'];
        $Id_usuario = $_POST['Id_usuario'];
        $descripcion = $_POST['descripcion'];
        } else {
            echo 'El formulario no ha sido enviado correctamente.';
        }
    
        $sql = "INSERT INTO salon (Id_salon, Id_edificio, tipo, Id_usuario,descripcion) 
        VALUES ('$Id_salon', '$Id_edificio', '$tipo','$Id_usuario', '$descripcion')";

        // Ejecutar la consulta SQL
        if(mysqli_query($conn, $sql)) {
            header("Location: ../salon.php");
            exit();
        } else {
            echo "Error al registrar el Salon: " . mysqli_error($conn);
        }

        // Cerrar la consulta y la conexión
        $conn->close();
?>

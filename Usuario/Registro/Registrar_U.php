<?php
    include('../../BD/ConexionBD.php');

        // Obtener los datos del formulario
        // Verificar si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $Id_Utipo = $_POST['Id_Utipo'];
        $Id_departamento = $_POST['Id_departamento'];
        $contraseña = $_POST['contraseña'];
        } else {
            echo 'El formulario no ha sido enviado correctamente.';
        }
    
        // Preparar la consulta SQL
        $sql = "INSERT INTO Usuarios (Id_Utipo, nombre, apellido, Id_departamento, contraseña) 
        VALUES ('$Id_Utipo', '$nombre','$apellido', '$Id_departamento', '$contraseña')";

        // Ejecutar la consulta SQL
        if(mysqli_query($conn, $sql)) {
            header("Location: ../Usuario.php");
            exit();
        } else {
            echo "Error al registrar el Usuario: " . mysqli_error($conn);
        }

        // Cerrar la consulta y la conexión
        $conn->close();
?>

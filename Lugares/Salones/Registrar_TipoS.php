<?php
    include('../../BD/ConexionBD.php');

        // Obtener los datos del formulario
        // Verificar si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $tipo = $_POST['tipo'];
        } else {
            echo 'El formulario no ha sido enviado correctamente.';
        }
    
        // Preparar la consulta SQL
        $sql = "INSERT INTO tipo_salon (tipo) VALUES ('$tipo')";

        // Ejecutar la consulta SQL
        if(mysqli_query($conn, $sql)) {
            header("Location: salon.php");
            exit();
        } else {
            echo "Error al registrar el salon: " . mysqli_error($conn);
        }

        // Cerrar la consulta y la conexión
        $conn->close();
?>
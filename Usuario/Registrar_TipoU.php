<?php
    include('../BD/ConexionBD.php');

        // Obtener los datos del formulario
        // Verificar si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $Utipo = $_POST['Utipo'];
        } else {
            echo 'El formulario no ha sido enviado correctamente.';
        }
    
        // Preparar la consulta SQL
        $sql = "INSERT INTO Tipo_Usuarios (Utipo) VALUES ('$Utipo')";

        // Ejecutar la consulta SQL
        if(mysqli_query($conn, $sql)) {
            header("Location: Usuario.php");
            exit();
        } else {
            echo "Error al registrar el Usuario: " . mysqli_error($conn);
        }

        // Cerrar la consulta y la conexión
        $conn->close();
?>

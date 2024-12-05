<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar</title>
</head>
<body>
    <?php
        include("../../BD/ConexionBD.php");

        if (isset($_POST['Id_usuario']) && !empty($_POST['Id_usuario'])) {
            $Id_usuario = mysqli_real_escape_string($conn, $_POST['Id_usuario']);

        $sql = "DELETE FROM Usuarios WHERE Id_usuario = '$Id_usuario'";        
        
        if (mysqli_query($conn, $sql)) {
            header("Location: ../Usuario.php");
            exit();
        } else {
            echo "Error al eliminar el registro: " . mysqli_error($conn);
        }
    } else {
        echo "No se proporcionó un ID de usuario válido.";
    }

    // Cerrar conexión
    $conn->close();
        
    ?>
    <p><a href='../Usuario.php'>Regresar</a></p>
</body>
</html>
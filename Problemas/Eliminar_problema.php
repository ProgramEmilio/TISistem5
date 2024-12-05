<?php
        include("../BD/ConexionBD.php");

        if (isset($_GET['Id_problema']) && !empty($_GET['Id_problema'])) {
            $Id_problema = mysqli_real_escape_string($conn, $_GET['Id_problema']);

        $sql = "DELETE FROM Problemas WHERE Id_problema = '$Id_problema'";        
        
        if (mysqli_query($conn, $sql)) {
            header("Location: problema.php");
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
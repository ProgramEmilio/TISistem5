<?php
        include("../../../BD/ConexionBD.php");

        if (isset($_POST['Id_edificio']) && !empty($_POST['Id_edificio'])) {
            $Id_edificio = mysqli_real_escape_string($conn, $_POST['Id_edificio']);

        $sql = "DELETE FROM edificio WHERE Id_edificio = '$Id_edificio'";        
        
        if (mysqli_query($conn, $sql)) {
            header("Location: ../Edificio.php");
            exit();
        } else {
            echo "Error al eliminar el registro: " . mysqli_error($conn);
        }
    } else {
        echo "No se proporcionó un ID de salon válido.";
    }

    // Cerrar conexión
    $conn->close();
        
    ?>
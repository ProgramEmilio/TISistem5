    <?php
        include("../../../BD/ConexionBD.php");

        if (isset($_POST['Id_salon']) && !empty($_POST['Id_salon'])) {
            $Id_salon = mysqli_real_escape_string($conn, $_POST['Id_salon']);

        $sql = "DELETE FROM salon WHERE Id_salon = '$Id_salon'";        
        
        if (mysqli_query($conn, $sql)) {
            header("Location: ../salon.php");
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

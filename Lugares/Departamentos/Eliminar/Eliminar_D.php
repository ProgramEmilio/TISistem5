<?php
        include("../../../BD/ConexionBD.php");

        if (isset($_POST['Id_departamento']) && !empty($_POST['Id_departamento'])) {
            $Id_departamento = mysqli_real_escape_string($conn, $_POST['Id_departamento']);

        $sql = "DELETE FROM departamento WHERE Id_departamento = '$Id_departamento'";        
        
        if (mysqli_query($conn, $sql)) {
            header("Location: ../Departamentos.php");
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
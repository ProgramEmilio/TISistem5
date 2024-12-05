<?php
include('../../BD/ConexionBD.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $Id_usuario = $_POST["Id_usuario"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $Id_departamento = $_POST["Id_departamento"];
    $Id_Utipo = $_POST["Id_Utipo"];
    $Id_especial = $_POST["Id_especial"];
    $contraseña = $_POST["contraseña"];

    // Verificar si la conexión a la base de datos es exitosa
    if (!$conn) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    // SQL para actualizar los datos del usuario
    $sql = "UPDATE Usuarios 
            SET nombre = '$nombre', 
                apellido = '$apellido', 
                Id_departamento = '$Id_departamento', 
                Id_Utipo = '$Id_Utipo',
                Id_especial = '$Id_especial', 
                contraseña = '$contraseña' 
            WHERE Id_usuario = $Id_usuario";
   
    if ($conn->query($sql) === TRUE) {
        // Redirigir a la página de catálogo después de actualizar los datos
        header("Location: Editar_Usuario.php");
        exit;
    } else {
        echo "Error al actualizar el usuario: " . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
}
?>

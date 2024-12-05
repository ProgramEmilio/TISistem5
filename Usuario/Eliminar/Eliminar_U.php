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
        class GestorUsuarios {
            private $conn;
        
            // Usamos el archivo de conexión ya incluido
            public function __construct() {
                global $conn;  // Usamos la variable global de la conexión
                $this->conn = $conn;
            }
        
            // Método para eliminar un usuario y sus dependencias
            public function eliminarUsuario($Id_usuario) {
                // Validar y sanitizar el ID de usuario
                $Id_usuario = mysqli_real_escape_string($this->conn, $Id_usuario);
        
                // Iniciar una transacción
                $this->conn->begin_transaction();
        
                try {
                    // Eliminar dependencias en el orden adecuado
                    // Primero, eliminar registros de las tablas que dependen de salon
                    $this->conn->query("DELETE FROM PC WHERE Id_salon IN (SELECT Id_salon FROM salon WHERE Id_usuario = '$Id_usuario')");
                    $this->conn->query("DELETE FROM Impresoras WHERE Id_salon IN (SELECT Id_salon FROM salon WHERE Id_usuario = '$Id_usuario')");
                    $this->conn->query("DELETE FROM Proyector WHERE Id_salon IN (SELECT Id_salon FROM salon WHERE Id_usuario = '$Id_usuario')");
        
                    // Eliminar los registros de la tabla salon
                    $this->conn->query("DELETE FROM salon WHERE Id_usuario = '$Id_usuario'");
        
                    // Eliminar dependencias en otras tablas relacionadas con Usuarios
                    $this->conn->query("DELETE FROM Hallazgo WHERE Id_trabajador = '$Id_usuario'");
                    $this->conn->query("DELETE FROM Reporte WHERE Id_usuario = '$Id_usuario' OR Id_trabajador = '$Id_usuario'");
                    $this->conn->query("DELETE FROM Peticion WHERE Id_trabajador = '$Id_usuario'");
                    $this->conn->query("DELETE FROM Problemas WHERE usuario = '$Id_usuario'");
        
                    // Finalmente, eliminar el usuario
                    $this->conn->query("DELETE FROM Usuarios WHERE Id_usuario = '$Id_usuario'");
        
                    // Confirmar los cambios
                    $this->conn->commit();
                    return true;
                } catch (Exception $e) {
                    // Revertir la transacción en caso de error
                    $this->conn->rollback();
                    return "Error al eliminar el usuario: " . $e->getMessage();
                }
            }
        
            // Método para manejar la eliminación a través de un formulario
            public function procesarEliminacion() {
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Id_usuario']) && !empty($_POST['Id_usuario'])) {
                    $Id_usuario = $_POST['Id_usuario'];
        
                    // Llamar al método para eliminar el usuario
                    $resultado = $this->eliminarUsuario($Id_usuario);
        
                    // Verificar el resultado
                    if ($resultado === true) {
                        header("Location: ../Usuario.php");
                        exit();
                    } else {
                        echo $resultado; // Mostrar mensaje de error
                    }
                } else {
                    echo "No se proporcionó un ID de usuario válido.";
                }
            }
        }
        
        // Uso de la clase
        include("../../BD/ConexionBD.php");  // Incluir la conexión a la base de datos
        
        $gestorUsuarios = new GestorUsuarios();
        $gestorUsuarios->procesarEliminacion();
        ?>
<p><a href='../Usuario.php'>Regresar</a></p>

</body>
</html>
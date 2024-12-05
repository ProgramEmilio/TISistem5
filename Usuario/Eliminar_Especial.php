<?php
include("../BD/ConexionBD.php");

class EliminarEspecialidad {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function eliminarEspecialidad($idEspecial) {
        // Verificar si la especialidad está en uso antes de eliminarla
        $sqlCheck = "SELECT * FROM Usuarios WHERE Id_especial = ?";
        $stmt = $this->conn->prepare($sqlCheck);
        $stmt->bind_param("i", $idEspecial);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // La especialidad está en uso, no se puede eliminar
            return "No se puede eliminar la especialidad porque está en uso.";
        }

        // Eliminar la especialidad si no está en uso
        $sqlDelete = "DELETE FROM catalogo_especial WHERE Id_especial = ?";
        $stmtDelete = $this->conn->prepare($sqlDelete);
        $stmtDelete->bind_param("i", $idEspecial);

        if ($stmtDelete->execute()) {
            //return "Especialidad eliminada correctamente.";
            header("Location: Usuario.php");
        } else {
            return "Error al eliminar la especialidad: " . $this->conn->error;
        }
    }
}

// Instanciar la clase y ejecutar la eliminación
if (isset($_GET['Id_especial'])) {
    $idEspecial = $_GET['Id_especial'];
    $eliminarEspecialidad = new EliminarEspecialidad($conn);
    $mensaje = $eliminarEspecialidad->eliminarEspecialidad($idEspecial);
    echo "<p>$mensaje</p>";
}
?>

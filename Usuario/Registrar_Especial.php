<?php
include("../BD/ConexionBD.php");

class RegistrarEspecialidad {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function agregarEspecialidad($especial) {
        // Verificar si la especialidad ya existe
        $sqlCheck = "SELECT * FROM catalogo_especial WHERE Especial = ?";
        $stmtCheck = $this->conn->prepare($sqlCheck);
        $stmtCheck->bind_param("s", $especial);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();
        
        if ($result->num_rows > 0) {
            // La especialidad ya existe
            return "La especialidad ya existe.";
        }

        // Insertar la nueva especialidad
        $sqlInsert = "INSERT INTO catalogo_especial (Especial) VALUES (?)";
        $stmtInsert = $this->conn->prepare($sqlInsert);
        $stmtInsert->bind_param("s", $especial);

        if ($stmtInsert->execute()) {
            //return "Especialidad registrada correctamente.";
            header("Location: Usuario.php");
        } else {
            return "Error al registrar la especialidad: " . $this->conn->error;
        }
    }
}

// Instanciar la clase y ejecutar el registro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Especial'])) {
    $especial = $_POST['Especial'];
    $registrarEspecialidad = new RegistrarEspecialidad($conn);
    $mensaje = $registrarEspecialidad->agregarEspecialidad($especial);
    echo "<p>$mensaje</p>";
}
?>

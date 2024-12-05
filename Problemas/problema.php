<?php
session_start();
if (!isset($_SESSION['nombre'])) {
    header("Location: Login.php");
    exit;
}

include('../BD/ConexionBD.php');

// Obtener el nombre del usuario de la sesión
$nombre = $_SESSION['nombre'];

// Obtener los detalles del usuario (nombre y apellido)
$sql_select = "SELECT Id_usuario,nombre, apellido FROM usuarios WHERE nombre = '$nombre'";
$result = $conn->query($sql_select);
$Usu = $result->fetch_assoc();

// Asignar variables para el nombre y apellido
$id_usuario = $Usu['Id_usuario']; 
$nombre_usuario = $Usu['nombre'];
$apellido_usuario = $Usu['apellido'];

$nombre = $_SESSION['nombre'];

// Obtener los detalles del usuario
$sql_select = "SELECT * FROM usuarios WHERE nombre = '$nombre'";
$result = $conn->query($sql_select);
$Usu = $result->fetch_assoc(); // Obtener el registro como un array asociativo
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Problemas</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="../CSS/menu.css" type="text/css">
    <link rel="stylesheet" href="../CSS/cabecera.css" type="text/css">
    <link rel="stylesheet" href="../CSS/pie_pagina.css" type="text/css">
    <link rel="stylesheet" href="../CSS/tablas_boton.css" type="text/css">
    <link rel="stylesheet" href="../CSS/formularios.css" type="text/css">
    <link rel="stylesheet" href="../CSS/departamentos.css" type="text/css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,
    700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

        <link
          rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
          integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
          crossorigin="anonymous"
          referrerpolicy="no-referrer"
        />

        <!--Iconos-->
        <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
</head>

<header class="cabecera_p">
    <div class="cabecera">
        <h1 class="nom_sis">Gestor de Recursos</h1>
        <a href="../Menu.php"><img src="../Imagenes/logo.png" class="img-logo" alt="Logo"></a>
        <a href="#"><img src="../Imagenes/avatar.png" class="img-avatar" alt="Avatar"></a>
    </div>

    <div class="header">
        <ul class="nav">
            <?php if ($Usu['Id_Utipo'] == 1 || $Usu['Id_Utipo'] == 4): ?>
                <!-- Usuarios -->
                <li><a href="../Usuario/Usuario.php">Usuarios</a>
                    <ul class="submenu">
                        <li><a href="../Usuario/Registro/Registro_Usuario.php">Alta</a></li>
                        <li><a href="../Usuario/Editar/Editar_Usuario.php">Modificar</a></li>
                        <li><a href="../Usuario/Eliminar/Eliminar_Usuario.php">Baja</a></li>
                    </ul>
                </li>
                <!-- Control -->
                <li><a href="../Lugares/InicioEdificios.php">Control</a>
                    <ul class="submenu">
                        <li><a href="../Lugares/Departamentos/Departamentos.php">Departamentos</a></li>
                        <li><a href="../Lugares/Edificios/Edificio.php">Edificios</a></li>
                        <li><a href="../Lugares/Salones/salon.php">Salones</a></li>
                    </ul>
                </li>
                <!-- Equipos -->
                <li><a href="#">Equipos</a>
                    <ul class="submenu">
                        <li><a href="../Equipos/Alta.php">Agregar</a></li>
                        <li><a href="../Equipos/Baja.php">Eliminar y Modificar</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($Usu['Id_Utipo'] == 3): ?>
                <!-- Equipos -->
                <li><a href="#">Equipos</a>
                    <ul class="submenu">
                        <li><a href="../Equipos/Baja.php">Modificar</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($Usu['Id_Utipo'] == 1 || $Usu['Id_Utipo'] == 2 || $Usu['Id_Utipo'] == 3 || $Usu['Id_Utipo'] == 4): ?>
                <!-- Solicitudes -->
                <li><a href="#">Solicitudes</a>
                    <ul class="submenu">
                        <li><a href="../Solicitudes/soli_edi.php">Levantar</a></li>
                        <li><a href="../Solicitudes/Revisar.php">Revisar</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($Usu['Id_Utipo'] == 1 || $Usu['Id_Utipo'] == 3 || $Usu['Id_Utipo'] == 4 || $Usu['Id_Utipo'] == 5): ?>
                <!-- Peticiones -->
                <li><a href="#">Peticiones</a>
                    <ul class="submenu">
                        <li><a href="../Peticiones/Revisar.php">Revisar</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($Usu['Id_Utipo'] == 1 || $Usu['Id_Utipo'] == 4): ?>
                <!-- Estadísticas -->
                <li><a href="../Estadisticas/graficas.php">Estadísticas</a>
                    <ul class="submenu">
                        <li><a href="problema.php">Problemas</a></li>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</header>
<body>

    <h1 class="titulo">Problemas</h1>
    <br>
    <?php
	include('../BD/ConexionBD.php');

    $sql = "SELECT 
    Problemas.Id_problema, 
    Problemas.problema, 
    Problemas.causa_raiz,
    Problemas.error_conocido, 
    Problemas.solucion, 
    Usuarios.Id_usuario AS id_usuario, 
    Usuarios.nombre AS nom_usuario,
    Usuarios.apellido AS apellido_usu       
    FROM Problemas
    JOIN Usuarios ON Usuarios.Id_usuario = Problemas.usuario";

	$result = $conn->query($sql);

	echo "<table class='tabla'>";
	echo "<thead>";
	echo "<tr class='cont'>";
	echo "<th scope='col'>ID</th>";
	echo "<th scope='col'>Problema</th>";
	echo "<th scope='col'>Causa Raiz</th>";
	echo "<th scope='col'>Error</th>";
	echo "<th scope='col'>Solución</th>";
    echo "<th scope='col'>Usuario</th>";
    echo "<th scope='col'>Editar</th>";
    echo "<th scope='col'>Eliminar</th>";
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
	while ($fila = $result->fetch_assoc()) {
		echo "<tr>";
		echo "<th scope='row'>".$fila['Id_problema']."</th>";	
		echo "<td>". $fila['problema']."</td>";
        echo "<td>". $fila['causa_raiz']."</td>";
        echo "<td>". $fila['error_conocido']."</td>";
        echo "<td>". $fila['solucion']."</td>";
        echo "<td>" . $fila['nom_usuario'] . " " . $fila['apellido_usu'] . "</td>";
        echo "<td><a href='Modificar_problema.php?Id_problema=".$fila['Id_problema']."' class='editar'> Editar </td>";
        echo "<td><a href='Eliminar_problema.php?Id_problema=".$fila['Id_problema']."'>Eliminar</a></td>";
		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";
?>

<div class="botones">
    <button class="btn_edi" onclick="toggleVisibility()"><p class="tx">Agregar</p></button>
</div>

<!-- Tabla y formulario para tipos de usuario -->
<div id="toggleSection" style="display: none;">
    <?php
    $sql = "SELECT * FROM Problemas";
    $result = $conn->query($sql);
    ?>

    <form class="form_problema" id="form_problema" action="Registrar_problema.php" method="POST">
        <label for="problema">Problema:</label>
        <input type="text" id="problema" name="problema" required><br><br>

        <label for="causa_raiz">Causa raíz:</label>
        <input type="text" id="causa_raiz" name="causa_raiz" required><br><br>

        <label for="error_conocido">Error conocido:</label>
        <input type="text" id="error_conocido" name="error_conocido" required><br><br>

        <label for="solucion">Solución:</label>
        <input type="text" id="solucion" name="solucion" required><br><br>

        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" value="<?php echo htmlspecialchars($nombre_usuario . ' ' . $apellido_usuario); ?>" readonly><br><br>
        <input type="hidden" name="Id_usuario" value="<?php echo $id_usuario; ?>">

        <input type="submit" value="Registrar">
    </form>

</div>

<script>
function toggleVisibility() {
    // Selecciona el contenedor que agrupa la tabla y el formulario
    var toggleSection = document.getElementById("toggleSection");

    // Alterna la visibilidad del contenedor
    toggleSection.style.display = (toggleSection.style.display === "none" || toggleSection.style.display === "") ? "block" : "none";
}
</script>


	<a href="../Menu.php" class="regresar">Regresar</a>

</body>

<footer class="pie-pagina">
        <div class="grupo-1">
            <div class="box">
                <figure>
                    <a href="Menu.php">
                        <img src="../Imagenes/logo.png" alt="Logo Institucional">
                    </a>
                </figure>
            </div>
            <div class="box">
                <h2>SOBRE NOSOTROS</h2>
                <p>Grupo CEB</p>
                <p>Enfocados en desarrollar el mejor sistema</p>
            </div>
            <div class="box">
                <h2>SIGUENOS!</h2>
                <div class="red-social">
                    <a href="#" class="fa fa-facebook"></a>
                    <a href="#" class="fa fa-instagram"></a>
                    <a href="#" class="fa fa-twitter"></a>
                    <a href="#" class="fa fa-youtube"></a>
                </div>
            </div>
        </div>
        <div class="grupo-2">
            <small>&copy; 2024 <b>Grupo CEB</b> - Todos los Derechos Reservados.</small>
        </div>
    </footer>
</html>
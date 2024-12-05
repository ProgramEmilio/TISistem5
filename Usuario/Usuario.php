<?php
include('../BD/ConexionBD.php'); // Incluir el archivo de conexión
session_start(); // Iniciar la sesión

// Verificar si hay una sesión activa
if (!isset($_SESSION['nombre'])) {
    // Si no hay sesión, redirigir al inicio de sesión
    header("Location: ../Login.php");
    exit;
}

// Función para cerrar sesión
if (isset($_GET['logout'])) {
    // Eliminar todas las variables de sesión
    session_unset();
    session_destroy();
    header("Location: ../Login.php");
    exit;
}

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
    <title>Usuario</title>
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
                <li><a href="Usuario.php">Usuarios</a>
                    <ul class="submenu">
                        <li><a href="Registro/Registro_Usuario.php">Alta</a></li>
                        <li><a href="Editar/Editar_Usuario.php">Modificar</a></li>
                        <li><a href="Eliminar/Eliminar_Usuario.php">Baja</a></li>
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
                        <li><a href="../Problemas/problema.php">Problemas</a></li>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</header>
</head>
<body>

    <h1 class="titulo">Información del Usuario</h1>
    <br>
    <?php
	include('../BD/ConexionBD.php');

	$sql = "SELECT 
        Usuarios.Id_usuario, 
        Tipo_Usuarios.Utipo AS Utipo, 
        Usuarios.nombre, 
        Usuarios.apellido, 
        departamento.nombre AS nombre_departamento, 
        catalogo_especial.Especial AS especial
    FROM Usuarios
    JOIN Tipo_Usuarios ON Usuarios.Id_Utipo = Tipo_Usuarios.Id_Utipo
    JOIN departamento ON Usuarios.Id_departamento = departamento.Id_departamento
    JOIN catalogo_especial ON Usuarios.Id_especial = catalogo_especial.Id_especial";

	$result = $conn->query($sql);

	echo "<table class='tabla'>";
	echo "<thead>";
	echo "<tr class='cont'>";
	echo "<th scope='col'>ID</th>";
	echo "<th scope='col'>Puesto</th>";
	echo "<th scope='col'>Nombre</th>";
	echo "<th scope='col'>Apellido</th>";
	echo "<th scope='col'>Departamento</th>";
    echo "<th scope='col'>Especialidad</th>";
    echo "<th scope='col'>Contraseña</th>";
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
	while ($fila = $result->fetch_assoc()) {
		echo "<tr>";
		echo "<th scope='row'>".$fila['Id_usuario']."</th>";	
		echo "<td>". $fila['Utipo']."</td>";
        echo "<td>". $fila['nombre']."</td>";
        echo "<td>". $fila['apellido']."</td>";
        echo "<td>". $fila['nombre_departamento']."</td>";
        echo "<td>". $fila['especial']."</td>";
        echo "<td>********</td>";
		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";
?>

<div class="botones">
    <button class="btn_edi" onclick="toggleVisibility('toggleSection')"><p class="tx">Tipo usuario</p></button>
</div>

<div class="botones">
    <button class="btn_edi" onclick="toggleVisibility('toggleSection2')"><p class="tx">Especialidades</p></button>
</div>

<!-- Tabla y formulario para tipos de usuario -->
<div id="toggleSection" style="display: none;">
    <?php
    $sql = "SELECT * FROM Tipo_Usuarios";
    $result = $conn->query($sql);

    echo "<table class='tabla'>";
    echo "<thead>";
    echo "<tr class='cont'>";
    echo "<th scope='col'>ID</th>";
    echo "<th scope='col'>Tipo Usuario</th>";
    echo "<th scope='col'>Eliminar</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    while ($fila = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<th scope='row'>".$fila['Id_Utipo']."</th>";    
        echo "<td>". $fila['Utipo']."</td>";
        echo "<td><a href='Eliminar_TipoUsuario.php?Id_Utipo=".$fila['Id_Utipo']."' onclick=\"return confirm('¿Estás seguro de que deseas eliminar este tipo de usuario?');\">Eliminar</a></td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    ?>
    <form id="form_tipoUsuario" class="form_tipoUsuario" action="Registrar_TipoU.php" method="POST" enctype="multipart/form-data">
            <label for="Utipo">Tipo Usuario:</label>
            <input type="text" id="Utipo" name="Utipo"><br><br>

            <input type="submit" value="Registrar">
        </form>
    <br>
    </div>

    

    <!-- Tabla y formulario para Especialidades -->
    <div id="toggleSection2" style="display: none;">
        <?php
        $sql = "SELECT * FROM catalogo_especial";
        $result = $conn->query($sql);

        echo "<table class='tabla'>";
        echo "<thead>";
        echo "<tr class='cont'>";
        echo "<th scope='col'>ID</th>";
        echo "<th scope='col'>Especialidad</th>";
        echo "<th scope='col'>Eliminar</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($fila = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<th scope='row'>".$fila['Id_especial']."</th>";    
            echo "<td>". $fila['Especial']."</td>";
            echo "<td><a href='Eliminar_Especial.php?Id_especial=".$fila['Id_especial']."' onclick=\"return confirm('¿Estás seguro de que deseas eliminar esta especialidad?');\">Eliminar</a></td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        ?>

        <br>

        <form id="form_especial" class="form_tipoUsuario" action="Registrar_Especial.php" method="POST" enctype="multipart/form-data">
            <label for="Especial">Especialidad:</label>
            <input type="text" id="Especial" name="Especial"><br><br>

            <input type="submit" value="Registrar">
        </form>

    </div>

    <script>
        function toggleVisibility(sectionId) {
            // Selecciona el contenedor que agrupa la tabla y el formulario
            var toggleSection = document.getElementById(sectionId);

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
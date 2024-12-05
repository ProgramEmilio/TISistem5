<?php
include('../../BD/ConexionBD.php'); // Incluir el archivo de conexión
session_start(); // Iniciar la sesión

// Verificar si hay una sesión activa
if (!isset($_SESSION['nombre'])) {
    // Si no hay sesión, redirigir al inicio de sesión
    header("Location: ../../Login.php");
    exit;
}

// Función para cerrar sesión
if (isset($_GET['logout'])) {
    // Eliminar todas las variables de sesión
    session_unset();
    session_destroy();
    header("Location: ../../Login.php");
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="../../CSS/menu.css" type="text/css">
    <link rel="stylesheet" href="../../CSS/diseño.css" type="text/css">
    <link rel="stylesheet" href="../../CSS/cabecera.css" type="text/css">
    <link rel="stylesheet" href="../../CSS/pie_pagina.css" type="text/css">
    <link rel="stylesheet" href="../../CSS/formularios.css" type="text/css">

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

    <title>Registro_Usuario</title>
</head>

<header class="cabecera_p">
    <div class="cabecera">
        <h1 class="nom_sis">Gestor de Recursos</h1>
        <a href="../../Menu.php"><img src="../../Imagenes/logo.png" class="img-logo" alt="Logo"></a>
        <a href="#"><img src="../../Imagenes/avatar.png" class="img-avatar" alt="Avatar"></a>
    </div>

    <div class="header">
        <ul class="nav">
            <?php if ($Usu['Id_Utipo'] == 1 || $Usu['Id_Utipo'] == 4): ?>
                <!-- Usuarios -->
                <li><a href="../Usuario.php">Usuarios</a>
                    <ul class="submenu">
                        <li><a href="Registro_Usuario.php">Alta</a></li>
                        <li><a href="../Editar/Editar_Usuario.php">Modificar</a></li>
                        <li><a href="../Eliminar/Eliminar_Usuario.php">Baja</a></li>
                    </ul>
                </li>
                <!-- Control -->
                <li><a href="../../Lugares/InicioEdificios.php">Control</a>
                    <ul class="submenu">
                        <li><a href="../../Lugares/Departamentos/Departamentos.php">Departamentos</a></li>
                        <li><a href="../../Lugares/Edificios/Edificio.php">Edificios</a></li>
                        <li><a href="../../Lugares/Salones/salon.php">Salones</a></li>
                    </ul>
                </li>
                <!-- Equipos -->
                <li><a href="#">Equipos</a>
                    <ul class="submenu">
                        <li><a href="../../Equipos/Alta.php">Agregar</a></li>
                        <li><a href="../../Equipos/Baja.php">Eliminar y Modificar</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($Usu['Id_Utipo'] == 3): ?>
                <!-- Equipos -->
                <li><a href="#">Equipos</a>
                    <ul class="submenu">
                        <li><a href="../../Equipos/Baja.php">Modificar</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($Usu['Id_Utipo'] == 1 || $Usu['Id_Utipo'] == 2 || $Usu['Id_Utipo'] == 3 || $Usu['Id_Utipo'] == 4): ?>
                <!-- Solicitudes -->
                <li><a href="#">Solicitudes</a>
                    <ul class="submenu">
                        <li><a href="../../Solicitudes/soli_edi.php">Levantar</a></li>
                        <li><a href="../../Solicitudes/Revisar.php">Revisar</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($Usu['Id_Utipo'] == 1 || $Usu['Id_Utipo'] == 3 || $Usu['Id_Utipo'] == 4 || $Usu['Id_Utipo'] == 5): ?>
                <!-- Peticiones -->
                <li><a href="#">Peticiones</a>
                    <ul class="submenu">
                        <li><a href="../../Peticiones/Revisar.php">Revisar</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($Usu['Id_Utipo'] == 1 || $Usu['Id_Utipo'] == 4): ?>
                <!-- Estadísticas -->
                <li><a href="../../Estadisticas/graficas.php">Estadísticas</a>
                    <ul class="submenu">
                        <li><a href="../../Problemas/problema.php">Problemas</a></li>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</header>
<body>

<div class="Registrar_Usuario">

    <h1 class="titulo">Registro de Usuario</h1>

    <form class="form_reg_usuario" action="Registrar_U.php" method="POST" enctype="multipart/form-data">
    
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required><br><br>
        
        <label for="apellido">Apellido:</label><br>
        <input type="text" id="apellido" name="apellido" required><br><br>
        
        <label for="Id_Utipo">Tipo de Usuario:</label><br>
        <select name="Id_Utipo" id="Utipo">
        <?php
                
            // Consulta para obtener los tipos de usuarios
            $sql = "SELECT Id_Utipo, Utipo FROM Tipo_Usuarios";
            $result = $conn->query($sql);

            // Verificar si hay resultados
            if ($result->num_rows > 0) {
                // Generar las opciones dinámicamente
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['Id_Utipo'] . '">' . $row['Utipo'] . '</option>';
                }
            } else {
                echo '<option value="">No hay tipos de usuario disponibles</option>';
            }
                
        ?>
        </select><br><br>
        
        <label for="Id_departamento">Departamento:</label><br>
        <select name="Id_departamento" id="Id_departamento">
        <?php
        
            // Consulta para obtener los departamentos
            $sql = "SELECT Id_departamento, nombre FROM departamento";
            $result = $conn->query($sql);

            // Verificar si hay resultados
            if ($result->num_rows > 0) {
                // Generar las opciones dinámicamente
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['Id_departamento'] . '">' . $row['nombre'] . '</option>';
                }
            } else {
                echo '<option value="">No hay departamentos disponibles</option>';
            }

            // Cerrar la conexión
            $conn->close();
            
        ?>
        </select><br><br>
        
        <label for="contraseña">Contraseña:</label><br>
        <input type="password" id="contraseña" name="contraseña" required><br><br>

        <input type="submit" value="Registrar Usuario">
    </form>
    
    <a href="../Usuario.php" class="regresar">Regresar</a> 

</div>


</body>
<footer class="pie-pagina">
        <div class="grupo-1">
            <div class="box">
                <figure>
                    <a href="Menu.php">
                        <img src="../../Imagenes/logo.png" alt="Logo Institucional">
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

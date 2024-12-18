<?php

include('../BD/ConexionBD.php'); // Incluir el archivo de conexión
session_start(); // Iniciar la sesión

// Verificar si el Id_usuario está en la sesión, ya que es único
if (!isset($_SESSION['id_usuario'])) {
    // Si no hay sesión válida, redirigir al inicio de sesión
    header("Location: ../Login.php");
    exit;
}

// Obtener los datos del usuario actual desde la sesión
$id_usuario_actual = $_SESSION['id_usuario'];

// Obtener el Id_reporte desde el parámetro GET
if (!isset($_GET['Id_hallazgo'])) {
    echo "Error: No se recibió el Id_reporte.";
    exit;
}
$id_hallazgo = $_GET['Id_hallazgo'];

// Obtener el Id_equipo desde la tabla Reporte utilizando el Id_reporte
$sql_reporte = "SELECT Id_equipo FROM Reporte WHERE Id_reporte = '$id_hallazgo'";
$result_reporte = $conn->query($sql_reporte);

if ($result_reporte->num_rows == 0) {
    echo "Error: No se encontró un reporte con el Id_reporte proporcionado.";
    exit;
}
$row_reporte = $result_reporte->fetch_assoc();
$id_equipo = $row_reporte['Id_equipo'];

// Obtener el Id_equipo desde la tabla Reporte utilizando el Id_reporte
$sql_reporte2 = "SELECT * FROM Reporte WHERE Id_reporte = '$id_hallazgo'";
$reportin = $conn->query($sql_reporte2);

if ($reportin->num_rows == 0) {
    echo "Error: No se encontró un reporte con el Id_reporte proporcionado.";
    exit;
}
$row_reportin = $reportin->fetch_assoc();

// Verificar si se ha enviado el formulario
if (isset($_POST['Levantar_Reporte'])) {
    // Registrar la fecha actual
    date_default_timezone_set('America/Mazatlan');
    $fecha_hora_actual = date("Y-m-d H:i:s");

    // Obtener los datos del formulario
    $peticion = $_POST['peticion'];
    $requiere = $_POST['requiere'];
    // Insertar la petición en la tabla Peticion
    $sql_peticion = "INSERT INTO Hallazgo (Id_reporte, Id_trabajador, descripcion, requiere, Fecha)
                 VALUES ('$id_hallazgo', '$row_reportin[Id_trabajador]', '$peticion', '$requiere', '$fecha_hora_actual')";

    // Ejecutar la consulta
    if ($conn->query($sql_peticion) === TRUE) {
        echo "Petición registrada exitosamente.";
        header("Location: Revisar.php");
        exit;
    } else {
        echo "Error al registrar la petición: " . $conn->error;
    }
}

// Obtener los detalles del Usuario
$sql_select = "SELECT * FROM usuarios WHERE Id_usuario = '$id_usuario_actual'";
$result = $conn->query($sql_select);
$Usu = $result->fetch_assoc(); // Obtener el registro como un array asociativo
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Levantar Solicitudes</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="../CSS/menu.css" type="text/css">
    <link rel="stylesheet" href="../CSS/cabecera.css" type="text/css">
    <link rel="stylesheet" href="../CSS/pie_pagina.css" type="text/css">
    <link rel="stylesheet" href="../CSS/tablas_boton.css" type="text/css">
    <link rel="stylesheet" href="../CSS/formularios.css" type="text/css">
    <link rel="stylesheet" href="../CSS/Alta.css" type="text/css">

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
                        <li><a href="Revisar.php">Revisar</a></li>
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
    <div class="cuerpo">
        <h1 class="titulo">Realizar Diagnóstico:</h1>
        <form class="form_reg_usuario" method="POST">
            <label for="Id_reporte">ID de Reporte de Procedencia:</label>
            <br>
            <input type="text" name="Id_reporte" value="<?php echo $row_reportin['Id_reporte']; ?>" readonly>
            <br><br>

            <label for="Id_PC">ID Equipo:</label>
            <br>
            <input type="text" name="Id_PC" value="<?php echo $id_equipo; ?>" readonly>
            <br><br>

            <label for="Id_trabajador">ID Tecnico:</label>
            <br>
            <input type="text" name="Id_trabajador" value="<?php echo $row_reportin['Id_trabajador']; ?>" readonly>
            <br><br>

            <label for="peticion">Descripción del diagnostico:</label>
            <br>
            <textarea name="peticion" rows="4" cols="50" required></textarea>
            <br><br>

            <label for="requiere">¿Es requerida una peticion de cambio?</label>
            <br>
            <select name="requiere" id="accion">
                <option value="1">Se requiere hacer una Petición de cambio</option>
                <option value="0">No se necesita</option>
            </select>


            <input type="submit" value="Levantar Hallazgo" name="Levantar_Reporte">
        </form>
        <a href="Revisar.php" class="regresar">Regresar</a>
    </div>
</body>

<footer class="pie-pagina">
<div class="grupo-1">
    <div class="box">
        <figure>
            <a href="../Menu.php">
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
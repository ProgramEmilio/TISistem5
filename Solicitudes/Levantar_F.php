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
$nombre_usuario_actual = $_SESSION['nombre']; // Esto sigue siendo opcional, para compatibilidad

// Obtener los detalles del Usuario
$sql_select = "SELECT * FROM usuarios WHERE Id_usuario = '$id_usuario_actual'";
$result = $conn->query($sql_select);
$Usu = $result->fetch_assoc(); // Obtener el registro como un array asociativo

// Obtener los detalles del Usuario Predeterminado
$sql_Pre = "SELECT* FROM usuarios WHERE Id_Utipo = 1 LIMIT 1;";
$result_Pre = $conn->query($sql_Pre);
$Pre = $result_Pre->fetch_assoc(); // Obtener el registro como un array asociativo

// Obtener el id del equipo a través de GET
$id_equipo = $_GET['id']; // ID del equipo

// Inicializar variables
$id_salon = null;
$id_edificio = null;

// Buscar el equipo en las tablas PC, Impresoras y Proyector
// Tabla PC
$sql_pc = "SELECT Id_salon FROM PC WHERE Id_PC = '$id_equipo'";
$result_pc = $conn->query($sql_pc);
if ($result_pc->num_rows > 0) {
    $row_pc = $result_pc->fetch_assoc();
    $id_salon = $row_pc['Id_salon'];
}

// Tabla Impresoras
$sql_impresoras = "SELECT Id_salon FROM Impresoras WHERE Id_Impresoras = '$id_equipo'";
$result_impresoras = $conn->query($sql_impresoras);
if ($result_impresoras->num_rows > 0) {
    $row_impresoras = $result_impresoras->fetch_assoc();
    $id_salon = $row_impresoras['Id_salon'];
}

// Tabla Proyector
$sql_proyector = "SELECT Id_salon FROM Proyector WHERE Id_Proyector = '$id_equipo'";
$result_proyector = $conn->query($sql_proyector);
if ($result_proyector->num_rows > 0) {
    $row_proyector = $result_proyector->fetch_assoc();
    $id_salon = $row_proyector['Id_salon'];
}

// Si encontramos el salón, buscamos el edificio en la tabla salón
if ($id_salon) {
    $sql_salon = "SELECT Id_edificio FROM salon WHERE Id_salon = '$id_salon'";
    $result_salon = $conn->query($sql_salon);
    if ($result_salon->num_rows > 0) {
        $row_salon = $result_salon->fetch_assoc();
        $id_edificio = $row_salon['Id_edificio'];
    }
}

// Obtener los trabajadores con Id_Utipo = 3 (solo trabajadores)
$sql_trabajadores = "SELECT Id_usuario, nombre, apellido FROM Usuarios WHERE Id_Utipo = 3";
$result_trabajadores = $conn->query($sql_trabajadores);

// Obtener los trabajadores con Id_Utipo = 3 (solo trabajadores)
$sql_usuarios = "SELECT Id_usuario, nombre, apellido FROM Usuarios WHERE Id_Utipo = 2";
$result_usuarios = $conn->query($sql_usuarios);

// SELECT* FROM usuarios WHERE Id_Utipo = 2 LIMIT 1;

// Verificar si se ha enviado el formulario
if (isset($_POST['Levantar_Reporte'])) {
    date_default_timezone_set('America/Mazatlan');
    $fecha_hora_actual = date("Y-m-d H:i:s");

    // Obtener los datos del formulario
    $catalogo = $_POST['catalogo'];
    
    // Verificar si se envió el campo correcto según el tipo de usuario
    if ($Usu['Id_Utipo'] !=2) {
        if (isset($_POST['Usuarios'])) {
            $id_usuario_ayudar = $_POST['Usuarios'];
        } else {
            echo "Error: No se seleccionó ningún usuario.";
            exit;
        }
    }

    // Insertar el reporte según el tipo de usuario
    if ($Usu['Id_Utipo'] == 2) {
        $sql_reporte = "INSERT INTO Reporte (Id_usuario, Id_trabajador, Id_equipo, Estado, Fecha, Id_catalogo, Prioridad)
                        VALUES ('$id_usuario_actual', '$Pre[Id_usuario]', '$id_equipo', 'Por Asignar', '$fecha_hora_actual', '$catalogo','Por Asignar' )";
    } else {
        $sql_reporte = "INSERT INTO Reporte (Id_usuario, Id_trabajador, Id_equipo, Estado, Fecha, Id_catalogo, Prioridad)
                        VALUES ('$id_usuario_ayudar', '$id_usuario_actual', '$id_equipo', 'Por Asignar', '$fecha_hora_actual', '$catalogo','Por Asignar')";
    }

    // Ejecutar la consulta
    if ($conn->query($sql_reporte) === TRUE) {
        header("Location: soli_edi.php");
    } else {
        echo "Error al registrar el reporte: " . $conn->error;
    }
}

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
                        <li><a href="soli_edi.php">Levantar</a></li>
                        <li><a href="Revisar.php">Revisar</a></li>
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
    <div class="cuerpo">
        <H1 class="titulo">Levantamiento del Reporte:</H1>
        <form class="form_reg_usuario" method="POST">
            <label for="Id_PC">ID Equipo:</label>
            <br>
            <input type="text" name="Id_PC" value="<?php echo $id_equipo; ?>" readonly>
            <br><br>

            <label for="Ubicacion">Ubicación</label>
            <br>
            <label for="Id_edificio">Edificio:</label>
            <input type="text" name="Id_edificio" value="<?php echo $id_edificio; ?>" readonly>
            <br>
            <label for="Id_salon">Salón:</label>
            <input type="text" name="Id_salon" value="<?php echo $id_salon; ?>" readonly>
            <br><br>

            <label for="catalogo">Catalogo de servicios:</label>
            <br>
            <select name="catalogo" required>
             <?php
                $sql = "SELECT cs.Id_catalogo, cs.catalogo, ce.Especial 
                        FROM catalogo_servicios cs
                        JOIN catalogo_especial ce ON cs.Id_especial = ce.Id_especial";

                $result_catalogo = $conn->query($sql);

                if ($result_catalogo->num_rows > 0) {
                    while ($row_catalogo = $result_catalogo->fetch_assoc()) {
                        // Mostrar el nombre del servicio y la especialidad separados por un guion
                        echo "<option value='{$row_catalogo['Id_catalogo']}'>
                                {$row_catalogo['catalogo']} - {$row_catalogo['Especial']}
                            </option>";
                    }
                } else {
                    echo "<option value=''>No hay catálogos de servicios disponibles</option>";
                }
                ?>
            </select>

         <br><br>

            <?php if ($Usu['Id_Utipo']!=2): ?>
                <label for="Usuarios">Seleccione al Usuario deseado:</label>
                <br>
                <select name="Usuarios" required>
                    <?php
                    if ($result_usuarios->num_rows > 0) {
                        while ($row_usuarios = $result_usuarios->fetch_assoc()) {
                            echo "<option value='{$row_usuarios['Id_usuario']}'>{$row_usuarios['nombre']} {$row_usuarios['apellido']}</option>";
                        }
                    } else {
                        echo "<option value=''>No hay Usuarios disponibles</option>";
                    }
                    ?>
                </select>
                <br><br>
            <?php endif; ?>

            <input type="submit" value="Levantar Reporte" name="Levantar_Reporte">
        </form>
        <a href="Levantar.php" class="regresar">Regresar</a>

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
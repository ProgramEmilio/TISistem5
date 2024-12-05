<?php
session_start(); // Iniciar sesión para manejar la redirección
include("../BD/ConexionBD.php");

// Verificar si se ha enviado un edificio seleccionado
$edificio = isset($_SESSION['edificio']) ? $_SESSION['edificio'] : '';
$salonSeleccionado = isset($_POST['Id_salon']) ? $_POST['Id_salon'] : '';

// Manejo del envío del formulario
if (isset($_POST['levantar'])) {
    if (!empty($salonSeleccionado)) {
        // Redirigir a Levantar.php con el ID del salón
        header("Location: Levantar.php?salon=" . urlencode($salonSeleccionado));
        exit();
    } else {
        // Si no se ha seleccionado un salón, puedes manejarlo aquí
    }
}

// Manejar la selección del edificio
if (isset($_POST['edificio'])) {
    $_SESSION['edificio'] = $_POST['edificio'];
}

// Verificar si se ha seleccionado un edificio para obtener los salones
if (!empty($edificio)) {
    // Preparar y ejecutar la consulta SQL para obtener los salones del edificio
    $sql = "SELECT Id_salon FROM salon WHERE Id_edificio = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $edificio);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = null;
}

//MOSTRAR EDIFICIOS.
$id_usuario_actual = $_SESSION['id_usuario']; // Obtenemos el id del usuario de la sesión actual.

$edificios = []; // Inicializamos el array para almacenar los edificios.

if (isset($id_usuario_actual)) {
    // Primero obtenemos el tipo de usuario y el departamento del usuario.
    $sql_usuario = "SELECT Id_Utipo, Id_departamento FROM Usuarios WHERE Id_usuario = ?";
    $stmt = $conn->prepare($sql_usuario);
    $stmt->bind_param("i", $id_usuario_actual);
    $stmt->execute();
    $result_usuario = $stmt->get_result();

    if ($result_usuario->num_rows > 0) {
        $usuario = $result_usuario->fetch_assoc();
        $tipo_usuario = $usuario['Id_Utipo'];
        $id_departamento_usuario = $usuario['Id_departamento'];

        // Construimos la consulta SQL en función del tipo de usuario.
        if ($tipo_usuario == 2) {
            // Si es de tipo 1, mostrar todos los edificios.
            $sql_edificios = "SELECT Id_edificio FROM edificio WHERE Id_departamento = ?";
        } else {
            // Si no es de tipo 1 y 3, mostrar solo los edificios que pertenecen a su departamento.
            $sql_edificios = "SELECT Id_edificio FROM edificio";
        }

        // Ejecutamos la consulta correspondiente.
        if ($tipo_usuario == 2) {
            $stmt_edificios = $conn->prepare($sql_edificios);
            $stmt_edificios->bind_param("i", $id_departamento_usuario); // Filtramos por el departamento del usuario.
            
        } else {
            $stmt_edificios = $conn->prepare($sql_edificios);
        }

        $stmt_edificios->execute();
        $result_edificios = $stmt_edificios->get_result();

        // Guardamos los edificios en el array $edificios.
        if ($result_edificios->num_rows > 0) {
            while ($row = $result_edificios->fetch_assoc()) {
                $edificios[] = $row['Id_edificio'];
            }
        }
    }
}

// Obtener los detalles del Usuario
$sql_select = "SELECT * FROM usuarios WHERE Id_usuario = '$id_usuario_actual'";
$result = $conn->query($sql_select);
$Usu = $result->fetch_assoc(); // Obtener el registro como un array asociativo

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <link rel="stylesheet" href="../CSS/menu.css" type="text/css">
    <link rel="stylesheet" href="../CSS/diseño.css" type="text/css">
    <link rel="stylesheet" href="../CSS/cabecera.css" type="text/css">
    <link rel="stylesheet" href="../CSS/pie_pagina.css" type="text/css">
    <link rel="stylesheet" href="../CSS/formularios.css" type="text/css">
    <link rel="stylesheet" href="../CSS/Alta.css" type="text/css">
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
    
    <title>Alta de Equipos</title>
</head>

<body>
<header class="cabecera_p">
    <div class="cabecera">
        <h1 class="nom_sis">Gestor de Recursos</h1>
        <a href="../Menu.php"><img src="../Imagenes/logo.png" class="img-logo" alt="Logo"></a>
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

<div class="cuerpo">
    <h1 class="titulo">Generar una Solicitud</h1>

    <form method="post" action="" class="form_solicitud">
        <label for="edificio">Selecciona un edificio:</label>
        <select name="edificio" id="edificio" onchange="this.form.submit()">
            <?php
                // Iteramos sobre el array de edificios para crear las opciones del dropdown.
                if (!empty($edificios)) {
                    echo '<option value="">Seleccionar Edificio...</option>';
                    foreach ($edificios as $edificio) {
                        $selected = (isset($_POST['edificio']) && $_POST['edificio'] == $edificio) ? 'selected' : '';
                        echo '<option value="' . $edificio . '" ' . $selected . '>' . htmlspecialchars($edificio) . '</option>';
                    }
                } else {
                    echo '<option value="">No hay edificios disponibles</option>';
                }
            ?>
        </select>
        <br><br>

        <?php
        // Verificar si se ha seleccionado un edificio
        if (isset($_POST['edificio']) && $_POST['edificio'] != '') {
            $edificio_seleccionado = $_POST['edificio'];

            // Obtener los salones del edificio seleccionado
            $sql_salones = "SELECT Id_salon, descripcion FROM salon WHERE Id_edificio = '$edificio_seleccionado'";
            $result_salones = $conn->query($sql_salones);
            if ($result_salones && $result_salones->num_rows > 0) {
                echo '<label for="Id_salon">Salones del edificio:</label>';
                echo '<select name="Id_salon" id="Id_salon">';
                echo '<option value="">Seleccionar Salón...</option>';
                while ($row = $result_salones->fetch_assoc()) {
                    echo '<option value="' . htmlspecialchars($row['Id_salon']) . '">';
                    echo 'Salón ' . htmlspecialchars($row['Id_salon']);
                    echo '</option>';
                }
                echo '</select>';
                echo '<br><br>';
            } else {
                echo '<p>No hay salones registrados en este edificio.</p>';
            }
        }
        ?>

        <input type="submit" value="Enviar" name="levantar">
    </form>

    <?php if ($Usu['Id_Utipo'] == 1 || $Usu['Id_Utipo'] == 4): ?>
    <div class="botones">
    <button class="btn_edi" onclick="toggleVisibility()"><p class="tx">Agregar Catalogo</p></button>
    </div>
    <?php endif; ?>

    <form id="form_reg_servicio" class="form_reg_servicio" action="Registrar_Servicio.php" method="POST" enctype="multipart/form-data" style="display: none;">
    
    <label for="catalogo">Cartalogo de Servicios:</label><br>
    <input type="text" id="catalogo" name="catalogo" required><br><br>

    <label for="Id_especial">Especialidad a la que pertenece:</label><br>
        <select name="Id_especial" id="Id_especial">
        <?php
        
            // Consulta para obtener los departamentos
            $sql = "SELECT Id_especial, Especial FROM catalogo_especial";
            $result = $conn->query($sql);

            // Verificar si hay resultados
            if ($result->num_rows > 0) {
                // Generar las opciones dinámicamente
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['Id_especial'] . '">' . $row['Especial'] . '</option>';
                }
            } else {
                echo '<option value="">No hay especialidades disponibles</option>';
            }

            // Cerrar la conexión
            $conn->close();
            
        ?>
        </select><br><br>

    <input type="submit" value="Registrar Servicio" name="levantar">
    </form>

    <script>
    function toggleVisibility() {
        var form = document.getElementById("form_reg_servicio");
        form.style.display = (form.style.display === "none" || form.style.display === "") ? "block" : "none";
    }
    </script>

    <a href="../Menu.php" class="regresar">Regresar</a>

</div>

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

<?php
include('../BD/ConexionBD.php');
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../Login.php");
    exit;
}

$id_usuario_actual = $_SESSION['id_usuario'];
// Obtener los detalles del Usuario
$sql_select = "SELECT * FROM usuarios WHERE Id_usuario = '$id_usuario_actual'";
$result = $conn->query($sql_select);
$Usu = $result->fetch_assoc(); // Obtener el registro como un array asociativo

$id_utipo = $Usu['Id_Utipo']; // Tipo de usuario logueado

if (isset($_POST['Id_reporte']) && isset($_POST['accion'])) {
    $id_reporte = $_POST['Id_reporte'];
    $accion = $_POST['accion'];

    // Obtener el estado actual del reporte
    $query = "SELECT Estado, Fecha, Fecha_Liberado FROM Reporte WHERE Id_reporte = $id_reporte";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $estado_actual = $row['Estado'];

    // Cambiar el estado según la acción y tipo de usuario
    if ($id_utipo == 1) {
        if ($accion == 'completar' && $estado_actual == 'Levantado') {
            $nuevo_estado = 'Completado';
        } elseif ($accion == 'liberar' && $estado_actual == 'Completado') {
            $nuevo_estado = 'Liberado';
            $fecha_liberado = date('Y-m-d H:i:s'); // Obtener la fecha actual
            header("Location: encuesta.php");
        }
    } elseif ($id_utipo == 2 && $accion == 'liberar' && $estado_actual == 'Completado') {
        $nuevo_estado = 'Liberado';
        $fecha_liberado = date('Y-m-d H:i:s'); // Obtener la fecha actual
        header("Location: encuesta.php");
    } elseif ($id_utipo == 3 && $accion == 'completar' && $estado_actual == 'Levantado') {
        $nuevo_estado = 'Completado';
    }

    if (isset($nuevo_estado)) {
        // Si es "Liberado", actualizar también la fecha de liberación
        if ($nuevo_estado == 'Liberado') {
            $update_query = "UPDATE Reporte SET Estado = '$nuevo_estado', Fecha_Liberado = '$fecha_liberado' WHERE Id_reporte = $id_reporte";
        } else {
            $update_query = "UPDATE Reporte SET Estado = '$nuevo_estado' WHERE Id_reporte = $id_reporte";
        }

        if (mysqli_query($conn, $update_query)) {
            //echo "Estado actualizado a $nuevo_estado";
        } else {
            //echo "Error al actualizar el estado.";
        }
    } else {
        // echo "Acción no permitida o estado inválido.";
    }
}

// Verificar si se ha enviado el formulario
if (isset($_POST['Asignar'])) {
    // Obtener y convertir variables
    $id_trabajador = (int)$_POST['Trabajadores'];
    $prioridad = $_POST['Nivel'];
    $id_reporte = (int)$_POST['Id_reporte'];

    // Actualizar el estado
    $stmt_estado = $conn->prepare("UPDATE Reporte SET Estado = ? WHERE Id_reporte = ?");
    $estado = 'Levantado';
    $stmt_estado->bind_param("si", $estado, $id_reporte);
    $stmt_estado->execute();
    $stmt_estado->close();

    // Actualizar el resto de los campos
    $stmt_reporte = $conn->prepare("UPDATE Reporte SET Id_trabajador = ?, Prioridad = ? WHERE Id_reporte = ?");
    $stmt_reporte->bind_param("isi", $id_trabajador, $prioridad, $id_reporte);
    $stmt_reporte->execute();
    $stmt_reporte->close();

    // Mensaje de éxito
    //echo "Reporte actualizado correctamente.";
}

// Definir el estado predeterminado como 'Todos'
$Estados_Acual = isset($_POST['Estados_Acual']) ? $_POST['Estados_Acual'] : 'Todos';

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
    <link rel="stylesheet" href="../CSS/diseño.css" type="text/css">
    <link rel="stylesheet" href="../CSS/cabecera.css" type="text/css">
    <link rel="stylesheet" href="../CSS/pie_pagina.css" type="text/css">
    <link rel="stylesheet" href="../CSS/formularios.css" type="text/css">
    <link rel="stylesheet" href="../Equipos/Alta.css" type="text/css">
    <link rel="stylesheet" href="../CSS/Revisar.css" type="text/css">


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
        <!-- Filtros para seleccionar el estado -->
        <div class="div_boton">
            <form method="POST">
                <input type="hidden" name="Estados_Acual" value="Todos">
                <button class='button -blue center' type="submit">Todos</button>
            </form>
            <form method="POST">
                <input type="hidden" name="Estados_Acual" value="Por_Asignar">
                <button class='button -blue center' type="submit">Por Asignar</button>
            </form>
            <form method="POST">
                <input type="hidden" name="Estados_Acual" value="Levantado">
                <button class='button -blue center' type="submit">Levantados</button>
            </form>
            <form method="POST">
                <input type="hidden" name="Estados_Acual" value="Completado">
                <button class='button -blue center' type="submit">Completados</button>
            </form>
            <form method="POST">
                <input type="hidden" name="Estados_Acual" value="Liberado">
                <button class='button -blue center' type="submit">Liberados</button>
            </form>
        </div>

        <?php
        // Consultar reportes según el tipo de usuario y el estado seleccionado
        if ($id_utipo == 1 ||$id_utipo == 4) {
            // Para administradores
            if ($Estados_Acual == 'Todos') {
                $query = "SELECT * FROM Reporte";
            } elseif ($Estados_Acual == 'Por_Asignar') {
                $query = "SELECT * FROM Reporte WHERE Estado = 'Por Asignar'"; 
            } elseif ($Estados_Acual == 'Levantado') {
                $query = "SELECT * FROM Reporte WHERE Estado = 'Levantado'";
            } elseif ($Estados_Acual == 'Completado') {
                $query = "SELECT * FROM Reporte WHERE Estado = 'Completado'";
            } elseif ($Estados_Acual == 'Liberado') {
                $query = "SELECT * FROM Reporte WHERE Estado = 'Liberado'";
            }
        } else {
            // Para usuarios no administradores
            if ($Estados_Acual == 'Todos') {
                $query = "SELECT * FROM Reporte WHERE Id_usuario = $id_usuario_actual OR Id_trabajador = $id_usuario_actual";
            } elseif ($Estados_Acual == 'Por_Asignar') {
                $query = "SELECT * FROM Reporte WHERE (Id_usuario = $id_usuario_actual OR Id_trabajador = $id_usuario_actual) AND Estado = 'Por Asignar'";
            } elseif ($Estados_Acual == 'Levantado') {
                $query = "SELECT * FROM Reporte WHERE (Id_usuario = $id_usuario_actual OR Id_trabajador = $id_usuario_actual) AND Estado = 'Levantado'";
            } elseif ($Estados_Acual == 'Completado') {
                $query = "SELECT * FROM Reporte WHERE (Id_usuario = $id_usuario_actual OR Id_trabajador = $id_usuario_actual) AND Estado = 'Completado'";
            } elseif ($Estados_Acual == 'Liberado') {
                $query = "SELECT * FROM Reporte WHERE (Id_usuario = $id_usuario_actual OR Id_trabajador = $id_usuario_actual) AND Estado = 'Liberado'";
            }
        }

        // Ejecutar la consulta y mostrar los reportes
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Obtener información adicional del equipo
                $id_equipo = $row['Id_equipo'];
                $id_salon = null;
                $id_edificio = null;

                // Buscar el equipo en las tablas PC, Impresoras y Proyector
                $sql_pc = "SELECT Id_salon FROM PC WHERE Id_PC = '$id_equipo'";
                $result_pc = $conn->query($sql_pc);
                if ($result_pc->num_rows > 0) {
                    $row_pc = $result_pc->fetch_assoc();
                    $id_salon = $row_pc['Id_salon'];
                }

                // Buscar edificio y salón si se encontró el equipo
                if ($id_salon) {
                    $sql_salon = "SELECT Id_edificio FROM salon WHERE Id_salon = '$id_salon'";
                    $result_salon = $conn->query($sql_salon);
                    if ($result_salon->num_rows > 0) {
                        $row_salon = $result_salon->fetch_assoc();
                        $id_edificio = $row_salon['Id_edificio'];
                    }
                }

                $sql_usus = "SELECT nombre, apellido FROM Usuarios WHERE Id_usuario = " . $row['Id_usuario'];
                $result_usus = $conn->query($sql_usus);
                if ($result_usus->num_rows > 0) {
                    $row_usus = $result_usus->fetch_assoc();
                }

                $sql_tras = "SELECT nombre, apellido FROM Usuarios WHERE Id_usuario = " . $row['Id_trabajador'];
                $result_tras = $conn->query($sql_tras);
                if ($result_tras->num_rows > 0) {
                    $row_tras = $result_tras->fetch_assoc();

                    
                }


                echo "<div class='reporte-container'>";
                
                // Lado derecho: Información del reporte
                echo '<div class="reporte-info" style="text-align: justify;"  >';
                echo '<div style="display: flex; justify-content: space-between;">';
                echo '<p><strong>Reporte ID:</strong> ' . $row['Id_reporte'] . '</p>';
                echo '<p>' . $row['Fecha'] . '</p>';
                echo '</div>';
                echo "<p><strong>Equipo en Cuestion:</strong></p>";
                echo "<p>" . $id_equipo . " Ubicado en el edificio ".($id_edificio ?? 'N/A') .", Salon ".($id_salon ?? 'N/A')."</p>";
                echo "<p><strong>Levantado por:</strong> " . $row_usus['nombre'] .' '.$row_usus['apellido']. "</p>";
                
                if($row['Estado'] != "Por Asignar") {
                    echo "<p><strong>Trabajador Asignado:</strong> " . $row_tras['nombre'] .' '.$row_tras['apellido']. "</p>";
                    echo "<p><strong> Nivel de prioridad:</strong> " . $row['Prioridad'] ."</p>";
                }

                // Obtener el nombre del catálogo
                $id_catalogo = $row['Id_catalogo'];
                $sql_catalogo = "SELECT catalogo FROM catalogo_servicios WHERE Id_catalogo = '$id_catalogo'";
                $result_catalogo = $conn->query($sql_catalogo);

                if ($result_catalogo->num_rows > 0) {
                    $row_catalogo = $result_catalogo->fetch_assoc();
                    $nombre_catalogo = $row_catalogo['catalogo'];
                } else {
                    $nombre_catalogo = 'N/A'; // Si no se encuentra un catálogo
                }

                // Mostrar el nombre del catálogo en lugar del ID
                echo "<p><strong>Servicio:</strong> " . $nombre_catalogo . "</p>";
                
                
                $id_repo = $row['Id_reporte']; // Id del reporte actual
                $sql_repo = "SELECT * FROM Peticion WHERE Id_reporte = '$id_repo'";
                $result_repo = $conn->query($sql_repo);

                if ($result_repo->num_rows > 0) {
                    // Variables para almacenar los estados
                    $estado_en_proceso = false;
                    $estado_aprobado = false;
                    $estado_denegado = false;
                    $tiempo_total = 0;

                    // Recorrer las peticiones asociadas al reporte
                    while ($row_repo = $result_repo->fetch_assoc()) {
                        $estado = $row_repo['Estado'];

                        if ($estado === 'En Proceso') {
                            $estado_en_proceso = true;
                        } elseif ($estado === 'Aprobado') {
                            $estado_aprobado = true;

                            // Obtener el tiempo de la reparación correspondiente
                            $id_reparacion = $row_repo['Id_reparacion'];
                            $sql_reparacion = "SELECT timepo FROM catalogo_reparacion WHERE Id_reparacion = '$id_reparacion'";
                            $result_reparacion = $conn->query($sql_reparacion);

                            if ($result_reparacion->num_rows > 0) {
                                $row_reparacion = $result_reparacion->fetch_assoc();
                                $tiempo_total += $row_reparacion['timepo'];
                            }
                        } elseif ($estado === 'Denegado') {
                            $estado_denegado = true;
                        }
                    }

                    // Determinar el mensaje a mostrar
                    if ($estado_en_proceso) {
                        echo "Petición en proceso, Espera indeterminada.";
                    } elseif ($estado_aprobado) {
                        echo "El tiempo de espera aproximado es de $tiempo_total Horas.";
                    } elseif ($estado_denegado) {
                        echo "Tiempo de espera Indefinido.";
                    }
                }

                if (($id_utipo == 1 || $id_utipo == 4) && $row['Estado'] == "Por Asignar") {
                    // Suponiendo que ya tienes el valor de 'Id_reporte' en la variable $row
                    $id_reporte = $row['Id_reporte']; // Obtener el Id del reporte

                    // Consulta para obtener el 'Id_catalogo' asociado con el reporte
                    $sql_reporte_catalogo = "SELECT Id_catalogo 
                                            FROM Reporte 
                                            WHERE Id_reporte = '$id_reporte'";

                    $result_reporte_catalogo = $conn->query($sql_reporte_catalogo);

                    // Comprobar si se obtuvo el Id_catalogo
                    if ($result_reporte_catalogo->num_rows > 0) {
                        $row_reporte = $result_reporte_catalogo->fetch_assoc();
                        $id_catalogo_servicio = $row_reporte['Id_catalogo']; // Obtener el Id_catalogo
                    } else {
                        $id_catalogo_servicio = ''; // Si no se encuentra el reporte, vaciar la variable
                    }

                    // Obtener la especialidad del servicio asociado al catálogo
                    $sql_servicio_especialidad = "SELECT ce.Especial
                                                FROM catalogo_servicios cs
                                                JOIN catalogo_especial ce ON cs.Id_especial = ce.Id_especial
                                                WHERE cs.Id_catalogo = '$id_catalogo_servicio'";

                    $result_servicio_especialidad = $conn->query($sql_servicio_especialidad);

                    // Comprobar si se obtuvo la especialidad del servicio
                    if ($result_servicio_especialidad->num_rows > 0) {
                        $row_servicio_especialidad = $result_servicio_especialidad->fetch_assoc();
                        $especialidad_requerida = $row_servicio_especialidad['Especial']; // Obtener la especialidad
                    } else {
                        $especialidad_requerida = ''; // Si no hay especialidad, vaciar la variable
                    }

                    // Consulta para obtener los trabajadores que tengan la misma especialidad
                    $sql_trabajadores = "SELECT u.Id_usuario, u.nombre, u.apellido 
                                        FROM Usuarios u
                                        JOIN catalogo_especial ce ON u.Id_especial = ce.Id_especial
                                        WHERE u.Id_Utipo = 3 AND ce.Especial = '$especialidad_requerida'";

                    $result_trabajadores = $conn->query($sql_trabajadores);

                    // Formulario para seleccionar trabajador
                    echo '<form class="form_reg_usuario" method="POST">';

                    echo '<input type="hidden" name="Id_reporte" value="' . $id_reporte . '">'; // Agregar Id_reporte al formulario

                    echo '<label for="Trabajadores"><strong>Seleccione al Trabajador Designado:</strong></label>';
                    echo '<br>';
                    echo '<select name="Trabajadores" required>';

                    if ($result_trabajadores->num_rows > 0) {
                        while ($row_trabajador = $result_trabajadores->fetch_assoc()) {
                            echo "<option value='{$row_trabajador['Id_usuario']}'>{$row_trabajador['nombre']} {$row_trabajador['apellido']} - {$especialidad_requerida}</option>";
                        }
                    } else {
                        echo "<option value=''>No hay trabajadores disponibles con la especialidad requerida</option>";
                    }

                    echo '</select>';
                    echo '<br>';
                    echo '<br>';
                    

                    echo '<label for="Nivel"><strong>Seleccione el nivel de prioridad:</strong></label>';
                    echo '<br>';
                    echo '<select name="Nivel" required>';
                    
                    echo "<option value='Alto'>Alto</option>";
                    echo "<option value='Medio'>Medio</option>";
                    echo "<option value='Bajo'>Bajo</option>";
                    
                    echo '</select>';
                    
                    echo '<input type="submit" value="Asignar" name="Asignar">';
                    
                    echo '</form>';

                }
                echo "</div>";

                // Lado izquierdo: Estado y botón
                echo "<div class='reporte-accion'>";
                echo "<p><strong>Estado:</strong> " . $row['Estado'] . "</p>";

                // Fecha en la que se liberó la solicitud
                echo "<p> <strong>Fecha de liberación:</strong> ". $row['Fecha_Liberado'] . '</p>';

                // Botón para cambiar estado
                if ($id_utipo == 1) {
                    if ($row['Estado'] == 'Levantado') {
                        echo "<form method='POST'>
                                <input type='hidden' name='Id_reporte' value='" . $row['Id_reporte'] . "'>
                                <button type='submit' name='accion' value='completar'>Completar</button>
                              </form>";
                    } elseif ($row['Estado'] == 'Completado') {
                        echo "<form method='POST'>
                                <input type='hidden' name='Id_reporte' value='" . $row['Id_reporte'] . "'>
                                <button type='submit' name='accion' value='liberar'>Liberar</button>
                              </form>";
                    }
                } elseif ($id_utipo == 2 && $row['Estado'] == 'Completado') {
                    echo "<form method='POST'>
                            <input type='hidden' name='Id_reporte' value='" . $row['Id_reporte'] . "'>
                            <button type='submit' name='accion' value='liberar'>Liberar</button>
                          </form>";
                } elseif ($id_utipo == 3 && $row['Estado'] == 'Levantado') {
                    echo "<form method='POST'>
                            <input type='hidden' name='Id_reporte' value='" . $row['Id_reporte'] . "'>
                            <button type='submit' name='accion' value='completar'>Completar</button>
                          </form>";
                }

                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "No hay reportes disponibles.";
        }
        ?>
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
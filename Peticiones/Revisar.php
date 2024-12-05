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

// Definir el estado predeterminado como 'Todos'
$Estados_Acual = isset($_POST['Estados_Acual']) ? $_POST['Estados_Acual'] : 'Todos';

// Obtener los detalles del Usuario
$sql_select = "SELECT * FROM usuarios WHERE Id_usuario = '$id_usuario_actual'";
$result = $conn->query($sql_select);
$Usu = $result->fetch_assoc(); // Obtener el registro como un array asociativo

// Manejo del envío del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['Id_reporte'])) {
        $idReporte = $_POST['Id_reporte'];
        // Redirigir a Levantar.php con el ID del reporte
        header("Location: Levantar.php?Id_reporte=" . urlencode($idReporte));
        exit();
    } elseif (isset($_POST['Id_hallazgo'])) {
        $idHallazgo = $_POST['Id_hallazgo'];
        // Redirigir a Hallazgo.php con el ID del hallazgo
        header("Location: Hallazgo.php?Id_hallazgo=" . urlencode($idHallazgo));
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Id_peticion']) && isset($_POST['accion'])) {
    $id_peticion = intval($_POST['Id_peticion']); // Convertir a entero para seguridad
    $accion = $_POST['accion'];

    // Determinar el nuevo estado
    $nuevo_estado = ($accion === 'Aprobar') ? 'Aprobado' : (($accion === 'Denegar') ? 'Denegado' : null);

    if ($nuevo_estado) {
        // Preparar y ejecutar la consulta
        $stmt = $conn->prepare("UPDATE Peticion SET Estado = ? WHERE Id_peticion = ?");
        $stmt->bind_param('si', $nuevo_estado, $id_peticion);

        if ($stmt->execute()) {
            echo "El estado de la petición con ID $id_peticion ha sido actualizado a '$nuevo_estado'.";
        } else {
            echo "Error al actualizar el estado: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Acción no válida.";
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
    <link rel="stylesheet" href="../CSS/diseño.css" type="text/css">
    <link rel="stylesheet" href="../CSS/cabecera.css" type="text/css">
    <link rel="stylesheet" href="../CSS/pie_pagina.css" type="text/css">
    <link rel="stylesheet" href="../CSS/formularios.css" type="text/css">
    <link rel="stylesheet" href="../Equipos/Alta.css" type="text/css">
    <link rel="stylesheet" href="../CSS/Revisar.css" type="text/css">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

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
        <!-- Filtros para seleccionar el estado -->
        <div class="div_boton">
            <form method="POST">
                <input type="hidden" name="Estados_Acual" value="Todos">
                <button class='button -blue center' type="submit">Todos</button>
            </form>
            <form method="POST">
                <input type="hidden" name="Estados_Acual" value="Reportes">
                <button class='button -blue center' type="submit">Reportes</button>
            </form>
            <form method="POST">
                <input type="hidden" name="Estados_Acual" value="Hallazgos">
                <button class='button -blue center' type="submit">Hallazgos</button>
            </form>
            <form method="POST">
                <input type="hidden" name="Estados_Acual" value="En_Proceso">
                <button class='button -blue center' type="submit">En Proceso</button>
            </form>
            <form method="POST">
                <input type="hidden" name="Estados_Acual" value="Aprobado">
                <button class='button -blue center' type="submit">Aprobado</button>
            </form>
            <form method="POST">
                <input type="hidden" name="Estados_Acual" value="Denegado">
                <button class='button -blue center' type="submit">Denegados</button>
            </form>
        </div>
        <div>
            <?php
            // Consultar reportes según el tipo de usuario y el estado seleccionado
            // Revisar los estados
            if ($id_utipo == 1 || $id_utipo == 4 ) {
                // Para administradores
                if ($Estados_Acual == 'Todos') {
                    $query = "SELECT * FROM Reporte WHERE Estado = 'Levantado'";
                    // Ejecutar la consulta y mostrar los reportes
                    $result = mysqli_query($conn, $query);
                } elseif ($Estados_Acual == 'Reportes') {
                    $query = "SELECT * FROM Reporte WHERE Estado = 'Levantado'";
                    // Ejecutar la consulta y mostrar los reportes
                    $result = mysqli_query($conn, $query);
                }
            } else {
                // Para usuarios no administradores
                if ($Estados_Acual == 'Todos') {
                    $query = "SELECT * FROM Reporte WHERE (Id_usuario = $id_usuario_actual OR Id_trabajador = $id_usuario_actual) AND Estado = 'Levantado'";
                    // Ejecutar la consulta y mostrar los reportes
                    $result = mysqli_query($conn, $query);
                } elseif ($Estados_Acual == 'Reportes') {
                    $query = "SELECT * FROM Reporte WHERE (Id_usuario = $id_usuario_actual OR Id_trabajador = $id_usuario_actual) AND Estado = 'Levantado'";
                    // Ejecutar la consulta y mostrar los reportes
                    $result = mysqli_query($conn, $query);
                }
            }

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

                    if($row['Estado'] == "Por Asignar") {
                        // Obtener los trabajadores con Id_Utipo = 3 (solo trabajadores)
                        $sql_trabajadores = "SELECT Id_usuario, nombre, apellido FROM Usuarios WHERE Id_Utipo = 3";
                        $result_trabajadores = $conn->query($sql_trabajadores);
                    
                        echo '<form class="form_reg_usuario" method="POST">';

                        echo '<input type="hidden" name="Id_reporte" value="' . $row['Id_reporte'] . '">';

                        echo '<label for="Trabajadores"><strong>Seleccione al Trabajador Designado:</strong></label>';
                        echo '<br>';
                        echo '<select name="Trabajadores" required>';
                        
                        if ($result_trabajadores->num_rows > 0) {
                            while ($row_trabajador = $result_trabajadores->fetch_assoc()) {
                                echo "<option value='{$row_trabajador['Id_usuario']}'>{$row_trabajador['nombre']} {$row_trabajador['apellido']}</option>";
                            }
                        } else {
                            echo "<option value=''>No hay trabajadores disponibles</option>";
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

                    // Botón para cambiar estado
                    if ($row['Estado'] == 'Levantado') {
                        echo "<form method='POST'>
                        <input type='hidden' name='Id_reporte' value='" . htmlspecialchars($row['Id_reporte'], ENT_QUOTES, 'UTF-8') . "'>
                        <button type='submit'>Realizar peticion</button>
                        </form>";
                    }
                    
                    if ($row['Estado'] == 'Levantado') {
                        echo "<form method='POST'>
                        <input type='hidden' name='Id_hallazgo' value='" . htmlspecialchars($row['Id_reporte'], ENT_QUOTES, 'UTF-8') . "'>
                        <button type='submit'>Realizar Diagnóstico</button>
                        </form>";
                    }
                    

                    echo "</div>";
                    echo "</div>";
                }
            }else {
                echo "No hay reportes disponibles.";
            }
            ?>
        </div>

        <!--Manejo de peticiones -->
        <div>
            <?php
            $result2 = null;
            // Consultar reportes según el tipo de usuario y el estado seleccionado
            // Revisar los estados
            if ($id_utipo == 1) {
                // Para administradores
                if ($Estados_Acual == 'Todos') {
                    $query2 = "SELECT * FROM Peticion";
                    // Ejecutar la consulta y mostrar los reportes
                    $result2 = mysqli_query($conn, $query2);
                } elseif ($Estados_Acual == 'En_Proceso') {
                    $query2 = "SELECT * FROM Peticion WHERE Estado = 'En Proceso'";
                    // Ejecutar la consulta y mostrar los reportes
                    $result2 = mysqli_query($conn, $query2);
                } elseif ($Estados_Acual == 'Aprobado') {
                    $query2 = "SELECT * FROM Peticion WHERE Estado = 'Aprobado'";
                    // Ejecutar la consulta y mostrar los reportes
                    $result2 = mysqli_query($conn, $query2);
                } elseif ($Estados_Acual == 'Denegado') {
                    $query2 = "SELECT * FROM Peticion WHERE Estado = 'Denegado'";
                    // Ejecutar la consulta y mostrar los reportes
                    $result2 = mysqli_query($conn, $query2);
                }
            } elseif ($id_utipo == 3) {
                // Para usuarios no administradores
                if ($Estados_Acual == 'Todos') {
                    $query2 = "SELECT * FROM Peticion WHERE Id_trabajador = $id_usuario_actual";
                    // Ejecutar la consulta y mostrar los reportes
                    $result2 = mysqli_query($conn, $query2);
                } elseif ($Estados_Acual == 'En_Proceso') {
                    $query2 = "SELECT * FROM Peticion WHERE Id_trabajador = $id_usuario_actual AND Estado = 'En Proceso'";
                    // Ejecutar la consulta y mostrar los reportes
                    $result2 = mysqli_query($conn, $query2);
                } elseif ($Estados_Acual == 'Aprobado') {
                    $query2 = "SELECT * FROM Peticion WHERE Id_trabajador = $id_usuario_actual AND Estado = 'Aprobado'";
                    // Ejecutar la consulta y mostrar los reportes
                    $result2 = mysqli_query($conn, $query2);
                } elseif ($Estados_Acual == 'Denegado') {
                    $query2 = "SELECT * FROM Peticion WHERE Id_trabajador = $id_usuario_actual AND Estado = 'Denegado'";
                    // Ejecutar la consulta y mostrar los reportes
                    $result2 = mysqli_query($conn, $query2);
                }
            } elseif ($id_utipo == 4) {
                // Para usuarios no administradores
                if ($Estados_Acual == 'Todos') {
                    $query2 = "SELECT * FROM Peticion WHERE presupuesto < 1000;";
                    // Ejecutar la consulta y mostrar los reportes
                    $result2 = mysqli_query($conn, $query2);
                } elseif ($Estados_Acual == 'En_Proceso') {
                    $query2 = "SELECT * FROM Peticion WHERE presupuesto < 1000 AND Estado = 'En Proceso'";
                    // Ejecutar la consulta y mostrar los reportes
                    $result2 = mysqli_query($conn, $query2);
                } elseif ($Estados_Acual == 'Aprobado') {
                    $query2 = "SELECT * FROM Peticion WHERE presupuesto < 1000 AND Estado = 'Aprobado'";
                    // Ejecutar la consulta y mostrar los reportes
                    $result2 = mysqli_query($conn, $query2);
                } elseif ($Estados_Acual == 'Denegado') {
                    $query2 = "SELECT * FROM Peticion WHERE presupuesto < 1000; AND Estado = 'Denegado'";
                    // Ejecutar la consulta y mostrar los reportes
                    $result2 = mysqli_query($conn, $query2);
                }
            } elseif ($id_utipo == 5) {
                // Para usuarios no administradores
                if ($Estados_Acual == 'Todos') {
                    $query2 = "SELECT * FROM Peticion WHERE presupuesto >  1000;";
                    // Ejecutar la consulta y mostrar los reportes
                    $result2 = mysqli_query($conn, $query2);
                } elseif ($Estados_Acual == 'En_Proceso') {
                    $query2 = "SELECT * FROM Peticion WHERE presupuesto > 1000 AND Estado = 'En Proceso'";
                    // Ejecutar la consulta y mostrar los reportes
                    $result2 = mysqli_query($conn, $query2);
                } elseif ($Estados_Acual == 'Aprobado') {
                    $query2 = "SELECT * FROM Peticion WHERE presupuesto > 1000 AND Estado = 'Aprobado'";
                    // Ejecutar la consulta y mostrar los reportes
                    $result2 = mysqli_query($conn, $query2);
                } elseif ($Estados_Acual == 'Denegado') {
                    $query2 = "SELECT * FROM Peticion WHERE presupuesto > 1000 AND Estado = 'Denegado'";
                    // Ejecutar la consulta y mostrar los reportes
                    $result2 = mysqli_query($conn, $query2);
                }
            }
            if (!$result2 == null) {
                if (mysqli_num_rows($result2) > 0) {
                while ($row2 = mysqli_fetch_assoc($result2)) {
                    // Obtener información adicional del equipo
                    $id_equipo2 = $row2['Id_equipo'];
                    $id_salon2 = null;
                    $id_edificio2 = null;

                    // Buscar el equipo en las tablas PC, Impresoras y Proyector
                    $sql_pc2 = "SELECT Id_salon FROM PC WHERE Id_PC = '$id_equipo2'";
                    $result_pc2 = $conn->query($sql_pc2);
                    if ($result_pc2->num_rows > 0) {
                        $row_pc2 = $result_pc2->fetch_assoc();
                        $id_salon2 = $row_pc2['Id_salon'];
                    }

                    // Buscar edificio y salón si se encontró el equipo
                    if ($id_salon2) {
                        $sql_salon2 = "SELECT Id_edificio FROM salon WHERE Id_salon = '$id_salon2'";
                        $result_salon2 = $conn->query($sql_salon2);
                        if ($result_salon2->num_rows > 0) {
                            $row_salon2 = $result_salon2->fetch_assoc();
                            $id_edificio2 = $row_salon2['Id_edificio'];
                        }
                    }

                    $sql_tras2 = "SELECT nombre, apellido FROM Usuarios WHERE Id_usuario = " . $row2['Id_trabajador'];
                    $result_tras2 = $conn->query($sql_tras2);
                    if ($result_tras2->num_rows > 0) {
                        $row_tras2 = $result_tras2->fetch_assoc();
                    }


                    echo "<div class='reporte-container'>";
                    
                    // Lado derecho: Información del reporte
                    echo '<div class="reporte-info" style="text-align: justify;"  >';
                    echo '<div style="display: flex; justify-content: space-between;">';
                    echo '<p><strong>Peticion ID:</strong> ' . $row2['Id_peticion'] . '</p>';
                    echo '<p>' . $row2['Fecha'] . '</p>';
                    echo '</div>';
                    echo "<p><strong>Equipo en Cuestion:</strong></p>";
                    echo "<p>" . $id_equipo2 . " Ubicado en el edificio ".($id_edificio2 ?? 'N/A') .", Salon ".($id_salon2 ?? 'N/A')."</p>";                       
                    echo "<p><strong>Realizado por:</strong> " . $row_tras2['nombre'] .' '.$row_tras2['apellido']. "</p>";
                    echo "<p><strong>Descripcion:</strong> " . $row2['peticion'] . "</p>";
                    echo "<p><strong>Presupuesto Solicitado:</strong> " . $row2['presupuesto'] . "</p>";

                    echo "</div>";

                    // Lado izquierdo: Estado y botón
                    echo "<div class='reporte-accion'>";
                    echo "<p><strong>Estado:</strong> " . $row2['Estado'] . "</p>";

                    // Botón para cambiar estado
                    if ($id_utipo == 1) {
                        if ($row2['Estado'] == 'En Proceso') {
                            echo "<form method='POST'>
                                    <input type='hidden' name='Id_peticion' value='" . $row2['Id_peticion'] . "'>
                                    <button type='submit' name='accion' value='Aprobar'>Aprobar</button>
                                    <button type='submit' name='accion' value='Denegar'>Denegar</button>
                                </form>";
                        }
                    } elseif ($id_utipo == 4 && $row2['Estado'] == 'En Proceso') {
                        echo "<form method='POST'>
                                    <input type='hidden' name='Id_peticion' value='" . $row2['Id_peticion'] . "'>
                                    <button type='submit' name='accion' value='Aprobar'>Aprobar</button>
                                    <button type='submit' name='accion' value='Denegar'>Denegar</button>
                                </form>";
                    } elseif ($id_utipo == 5 && $row2['Estado'] == 'En Proceso') {
                        echo "<form method='POST'>
                                    <input type='hidden' name='Id_peticion' value='" . $row2['Id_peticion'] . "'>
                                    <button type='submit' name='accion' value='Aprobar'>Aprobar</button>
                                    <button type='submit' name='accion' value='Denegar'>Denegar</button>
                                </form>";
                    }

                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "No hay Peticiones disponibles.";
            }
        }else {
            // Mostrar el error de la consulta
            echo mysqli_error($conn);
        }
            ?>
        </div>

        <!--Manejo de Hallazgos -->
        <div>
            <?php
            $result3 = null;
            // Consultar reportes según el tipo de usuario y el estado seleccionado
            // Revisar los estados
            if ($id_utipo == 1 || $id_utipo == 4 ) {
                // Para administradores
                if ($Estados_Acual == 'Todos') {
                    $query3 = "SELECT * FROM Hallazgo";
                    // Ejecutar la consulta y mostrar los reportes
                    $result3 = mysqli_query($conn, $query3);
                } elseif ($Estados_Acual == 'Hallazgo') {
                    $query3 = "SELECT * FROM Hallazgo";
                    // Ejecutar la consulta y mostrar los reportes
                    $result3 = mysqli_query($conn, $query3);
                }
            } else {
                // Para usuarios no administradores
                if ($Estados_Acual == 'Todos') {
                    $query3 = "SELECT * FROM Hallazgo WHERE Id_trabajador = $id_usuario_actual";
                    // Ejecutar la consulta y mostrar los reportes
                    $result3 = mysqli_query($conn, $query3);
                } elseif ($Estados_Acual == 'Hallazgo') {
                    $query3 = "SELECT * FROM Hallazgo WHERE Id_trabajador = $id_usuario_actual";
                    // Ejecutar la consulta y mostrar los reportes
                    $result3 = mysqli_query($conn, $query3);
                }
            }
            
            if (!$result3 == null) {
            if (mysqli_num_rows($result3) > 0) {
                while ($row3 = mysqli_fetch_assoc($result3)) {
                   $repor = $row3['Id_reporte']; // Id del reporte actual

                    // Consulta para obtener el Id_equipo del reporte
                    $sql_equipo3 = "SELECT Id_equipo FROM Reporte WHERE Id_reporte = $repor";
                    $result_equipo3 = $conn->query($sql_equipo3);

                    if ($result_equipo3 && $result_equipo3->num_rows > 0) {
                        $row_equipo3 = $result_equipo3->fetch_assoc();
                        $id_equipo3 = $row_equipo3['Id_equipo'];
                    } else {
                        echo "No se encontró un equipo para el reporte $repor.";
                    }

                    // Obtener información adicional del equipo
                
                   $id_salon3 = null;
                   $id_edificio3 = null;

                   // Buscar el equipo en las tablas PC, Impresoras y Proyector
                   $sql_pc3 = "SELECT Id_salon FROM PC WHERE Id_PC = '$id_equipo3'";
                   $result_pc3 = $conn->query($sql_pc3);
                   if ($result_pc3->num_rows > 0) {
                       $row_pc3 = $result_pc3->fetch_assoc();
                       $id_salon3 = $row_pc3['Id_salon'];
                   }

                   // Buscar edificio y salón si se encontró el equipo
                   if ($id_salon3) {
                       $sql_salon3 = "SELECT Id_edificio FROM salon WHERE Id_salon = '$id_salon3'";
                       $result_salon3 = $conn->query($sql_salon3);
                       if ($result_salon3->num_rows > 0) {
                           $row_salon3 = $result_salon3->fetch_assoc();
                           $id_edificio3 = $row_salon3['Id_edificio'];
                       }
                   }

                   $sql_tras3 = "SELECT nombre, apellido FROM Usuarios WHERE Id_usuario = " . $row3['Id_trabajador'];
                    $result_tras3 = $conn->query($sql_tras3);
                    if ($result_tras3->num_rows > 0) {
                        $row_tras3 = $result_tras3->fetch_assoc();
                    }

                    echo "<div class='reporte-container'>";
                    
                    // Lado derecho: Información del reporte
                    echo '<div class="reporte-info" style="text-align: justify;"  >';
                    echo '<div style="display: flex; justify-content: space-between;">';
                    echo '<p><strong>Diagnostico ID:</strong> ' . $row3['Id_hallazgo'] . '</p>';
                    echo '<p>' . $row3['Fecha'] . '</p>';
                    echo '</div>';
                    echo "<p><strong>Equipo en Cuestion:</strong></p>";
                    echo "<p>" . $id_equipo3 . " Ubicado en el edificio ".($id_edificio3 ?? 'N/A') .", Salon ".($id_salon3 ?? 'N/A')."</p>";                       
                    echo "<p><strong>Realizado por:</strong> " . $row_tras3['nombre'] .' '.$row_tras3['apellido']. "</p>";
                    echo "<p><strong>Descripcion:</strong> " . $row3['descripcion'] . "</p>";
                    // Verificar si se necesitaba cambio
                    if ($row3['requiere'] == 1) {
                        echo "<p><strong>Se requería un cambio:</strong> Sí</p>";
                    } else {
                        echo "<p><strong>Se requería un cambio:</strong> No</p>";
                    }

                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "No hay Peticiones disponibles.";
            }
        }else {
            // Mostrar el error de la consulta
            echo mysqli_error($conn);
        }
            ?>
        </div>
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
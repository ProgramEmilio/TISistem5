<?php
include('../BD/ConexionBD.php'); // Incluir el archivo de conexión
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

// Procesar la eliminación de un PC
if (isset($_POST['id_pc'])) {
    $id_pc = $_POST['id_pc'];

    // Obtener los detalles del PC antes de eliminarlo
    $sql_select = "SELECT * FROM PC WHERE Id_PC = '$id_pc'";
    $result = $conn->query($sql_select);
    $pc = $result->fetch_assoc(); // Obtener el registro como un array asociativo

    if ($pc) {
        // Eliminar el PC de la tabla PC
        $sql_eliminar = "DELETE FROM PC WHERE Id_PC = '$id_pc'";
        if ($conn->query($sql_eliminar) === TRUE) {
            // Aquí generamos el pop-up con los datos del PC eliminado
            echo "
                <script>
                    alert('El PC con ID: " . $pc['Id_PC'] . " ha sido eliminado.\\n" .
                         "Tipo: " . $pc['PCtipo'] . "\\n" .
                         "Procesador: " . $pc['procesador'] . "\\n" .
                         "RAM: " . $pc['ram'] . "');
                    window.location.href = 'Baja.php'; // Redirigir después de la confirmación
                </script>";
        } else {
            echo "Error al eliminar el registro: " . $conn->error;
        }
    } else {
        echo "Error: PC no encontrado.";
    }
}

// Procesar la eliminación de una impresora
if (isset($_POST['id_impresora'])) {
    $id_impresora = $_POST['id_impresora'];

    // Obtener los detalles de la impresora antes de eliminarla
    $sql_select = "SELECT * FROM Impresoras WHERE Id_Impresoras = '$id_impresora'";
    $result = $conn->query($sql_select);
    $impresora = $result->fetch_assoc(); // Obtener el registro como un array asociativo

    if ($impresora) {
        // Eliminar la impresora de la tabla
        $sql_eliminar = "DELETE FROM Impresoras WHERE Id_Impresoras = '$id_impresora'";
        if ($conn->query($sql_eliminar) === TRUE) {
            // Aquí generamos el pop-up con los datos de la impresora eliminada
            echo "
                <script>
                    alert('La impresora con ID: " . $impresora['Id_Impresoras'] . " ha sido eliminada.\\n" .
                         "Tipo: " . $impresora['Imtipo'] . "\\n" .
                         "Marca: " . $impresora['marca'] . "');
                    window.location.href = 'Baja.php'; // Redirigir después de la confirmación
                </script>";
        } else {
            echo "Error al eliminar el registro: " . $conn->error;
        }
    } else {
        echo "Error: Impresora no encontrada.";
    }
}

// Procesar la eliminación de un proyector
if (isset($_POST['id_proyector'])) {
    $id_proyector = $_POST['id_proyector'];

    // Obtener los detalles del proyector antes de eliminarlo
    $sql_select = "SELECT * FROM Proyector WHERE Id_Proyector = '$id_proyector'";
    $result = $conn->query($sql_select);
    $proyector = $result->fetch_assoc(); // Obtener el registro como un array asociativo

    if ($proyector) {
        // Eliminar el proyector de la tabla
        $sql_eliminar = "DELETE FROM Proyector WHERE Id_Proyector = '$id_proyector'";
        if ($conn->query($sql_eliminar) === TRUE) {
            // Aquí generamos el pop-up con los datos del proyector eliminado
            echo "
                <script>
                    alert('El proyector con ID: " . $proyector['Id_Proyector'] . " ha sido eliminado.\\n" .
                         "Tipo: " . $proyector['Protipo'] . "\\n" .
                         "Marca: " . $proyector['marca'] . "');
                    window.location.href = 'Baja.php'; // Redirigir después de la confirmación
                </script>";
        } else {
            echo "Error al eliminar el registro: " . $conn->error;
        }
    } else {
        echo "Error: Proyector no encontrado.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <link rel="stylesheet" href="../CSS/menu.css" type="text/css">
    <link rel="stylesheet" href="../CSS/diseño.css" type="text/css">
    <link rel="stylesheet" href="../CSS/cabecera.css" type="text/css">
    <link rel="stylesheet" href="../CSS/pie_pagina.css" type="text/css">
    <link rel="stylesheet" href="../CSS/formularios.css" type="text/css">
    <link rel="stylesheet" href="../CSS/tablas_boton.css" type="text/css">
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
    
    <title>Modificar, Eliminar Equipos</title>
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
                        <li><a href="Alta.php">Agregar</a></li>
                        <li><a href="Baja.php">Eliminar y Modificar</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($Usu['Id_Utipo'] == 3): ?>
                <!-- Equipos -->
                <li><a href="#">Equipos</a>
                    <ul class="submenu">
                        <li><a href="Baja.php">Modificar</a></li>
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
        <body>
            <div class="cuerpo">
            <h1 class="titulo">Edición y Elimianción de Equipos</h1>
                <div class="div_boton">
                    <button class='button -blue center' id="add-card-button" onclick="toggleCardForm()">Mostrar PC´s</button>
                    <button class='button -blue center' id="toggle-cards-button" onclick="toggleCardList()">Mostrar Impresoras</button>
                    <button class='button -blue center' id="add-projector-button" onclick="toggleProjectorForm()">Mostrar Proyectores</button>
                </div>

                <div id="card-form" style="display:none;">
                    <?php
                        include('../BD/ConexionBD.php'); // Incluir el archivo de conexión
                        
                        // Consulta para seleccionar todos los registros de la tabla PC
                        $sql = "SELECT * FROM PC";
                        $result = $conn->query($sql);
                        
                        // Desplegar los resultados en una tabla HTML
                        echo "<table class='tabla'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th scope='col'>ID PC</th>";
                        echo "<th scope='col'>ID Salón</th>";
                        echo "<th scope='col'>Tipo de PC</th>";
                        echo "<th scope='col'>Procesador</th>";
                        echo "<th scope='col'>Disco de almacenamiento</th>";
                        echo "<th scope='col'>RAM</th>";
                        echo "<th scope='col'>Serie de Tarjeta Madre</th>";
                        echo "<th scope='col'>MAC</th>";
                        echo "<th scope='col'>Fecha de Compra</th>";
                        echo "<th scope='col'>Editar</th>";
                        if ($Usu['Id_Utipo']==1):{
                            echo "<th scope='col'>Eliminar</th>";
                            }endif;
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        
                        // Recorre cada fila obtenida de la consulta
                        while ($fila = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<th scope='row'>" . $fila['Id_PC'] . "</th>";
                            echo "<td>" . $fila['Id_salon'] . "</td>";
                            echo "<td>" . $fila['PCtipo'] . "</td>";
                            echo "<td>" . $fila['procesador'] . "</td>";
                            echo "<td>" . $fila['rom'] . "</td>";
                            echo "<td>" . $fila['ram'] . "</td>";
                            echo "<td>" . $fila['serie'] . "</td>";
                            echo "<td>" . $fila['MAC'] . "</td>";
                            echo "<td>" . $fila['fechacompra'] . "</td>";
                        
                            // Botones de editar y eliminar para cada fila
                            echo "<td><a href='Modificacion.php?id=" . $fila['Id_PC']. "&tipo=PC'>Editar</a></td>";
                            if ($Usu['Id_Utipo']==1):{
                                // Botón de eliminar usando un formulario oculto y confirmación
                                echo "<td>
                                        <form id='eliminar_pc_" . $fila['Id_PC'] . "' method='POST' action='Baja.php'>
                                            <input type='hidden' name='id_pc' value='" . $fila['Id_PC'] . "'>
                                            <a href='javascript:void(0);' onclick='confirmarEliminacion(\"" . $fila['Id_PC'] . "\", \"" . $fila['PCtipo'] . "\")'>Eliminar</a>
                                        </form>
                                    </td>";
                            }endif;

                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                    ?>
                

                </div>
                
                <div id="card-list" style="display: none;">
                <?php
                    include('../BD/ConexionBD.php'); // Incluir el archivo de conexión

                    // Consulta para seleccionar todos los registros de la tabla Impresoras
                    $sql = "SELECT * FROM Impresoras";
                    $result = $conn->query($sql);

                    // Desplegar los resultados en una tabla HTML
                    echo "<table class='tabla'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th scope='col'>ID Impresora</th>";
                    echo "<th scope='col'>ID Salón</th>";
                    echo "<th scope='col'>Tipo de Impresora</th>";
                    echo "<th scope='col'>Serie</th>";
                    echo "<th scope='col'>Marca</th>";
                    echo "<th scope='col'>Descripción</th>";
                    echo "<th scope='col'>Fecha de Compra</th>";
                    echo "<th scope='col'>Editar</th>";
                    if ($Usu['Id_Utipo']==1):{
                        echo "<th scope='col'>Eliminar</th>";
                    }endif;
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    // Recorre cada fila obtenida de la consulta
                    while ($fila = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<th scope='row'>" . $fila['Id_Impresoras'] . "</th>";
                        echo "<td>" . $fila['Id_salon'] . "</td>";
                        echo "<td>" . $fila['Imtipo'] . "</td>";
                        echo "<td>" . $fila['serie'] . "</td>";
                        echo "<td>" . $fila['marca'] . "</td>";
                        echo "<td>" . $fila['descripcion'] . "</td>";
                        echo "<td>" . $fila['fechacompra'] . "</td>";

                        // Botones de editar y eliminar para cada fila
                        echo "<td><a href='Modificacion.php?id=" . $fila['Id_Impresoras'] . "&tipo=Impresora'>Editar</a></td>";
                        if ($Usu['Id_Utipo']==1):{
                            // Botón de eliminar usando un formulario oculto y confirmación
                            echo "<td>
                                    <form id='eliminar_impresora_" . $fila['Id_Impresoras'] . "' method='POST' action='Baja.php'>
                                        <input type='hidden' name='id_impresora' value='" . $fila['Id_Impresoras'] . "'>
                                        <a href='javascript:void(0);' onclick='confirmarEliminacionIM(\"" . $fila['Id_Impresoras'] . "\", \"" . $fila['Imtipo'] . "\")'>Eliminar</a>
                                    </form>
                                </td>";
                        }endif;    
                        
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                ?>

                </div>
                
                <div id="projector-form" style="display: none;">
                <?php
                    include('../BD/ConexionBD.php'); // Incluir el archivo de conexión

                    // Consulta para seleccionar todos los registros de la tabla Proyector
                    $sql = "SELECT * FROM Proyector";
                    $result = $conn->query($sql);

                    // Desplegar los resultados en una tabla HTML
                    echo "<table class='tabla'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th scope='col'>ID Proyector</th>";
                    echo "<th scope='col'>ID Salón</th>";
                    echo "<th scope='col'>Tipo de Proyector</th>";
                    echo "<th scope='col'>Serie</th>";
                    echo "<th scope='col'>Marca</th>";
                    echo "<th scope='col'>Descripción</th>";
                    echo "<th scope='col'>Fecha de Compra</th>";
                    echo "<th scope='col'>Editar</th>";
                    if ($Usu['Id_Utipo']==1):{
                        echo "<th scope='col'>Eliminar</th>";
                    }endif;
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    // Recorre cada fila obtenida de la consulta
                    while ($fila = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<th scope='row'>" . $fila['Id_Proyector'] . "</th>";
                        echo "<td>" . $fila['Id_salon'] . "</td>";
                        echo "<td>" . $fila['Protipo'] . "</td>";
                        echo "<td>" . $fila['serie'] . "</td>";
                        echo "<td>" . $fila['marca'] . "</td>";
                        echo "<td>" . $fila['descripcion'] . "</td>";
                        echo "<td>" . $fila['fechacompra'] . "</td>";

                        // Botones de editar y eliminar para cada fila
                        echo "<td><a href='Modificacion.php?id=" . $fila['Id_Proyector']. "&tipo=Proyector'>Editar</a></td>";
                        if ($Usu['Id_Utipo']==1):{
                            // Botón de eliminar usando un formulario oculto y confirmación
                            echo "<td>
                                    <form id='eliminar_proyector_" . $fila['Id_Proyector'] . "' method='POST' action='Baja.php'>
                                        <input type='hidden' name='id_proyector' value='" . $fila['Id_Proyector'] . "'>
                                        <a href='javascript:void(0);' onclick='confirmarEliminacionProyector(\"" . $fila['Id_Proyector'] . "\", \"" . $fila['Protipo'] . "\")'>Eliminar</a>
                                    </form>
                                </td>";
                        }endif;
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                ?>

            </div>

<script>
    function toggleCardForm() {
        var cardForm = document.getElementById('card-form');
        var cardList = document.getElementById('card-list');
        var projectorForm = document.getElementById('projector-form');
        
        // Mostrar formulario de tarjetas y ocultar los demás
        if (cardForm.style.display === 'block') {
            cardForm.style.display = 'none';
        } else {
            cardForm.style.display = 'block';
            cardList.style.display = 'none';
            projectorForm.style.display = 'none';
        }
    }

    function toggleCardList() {
        var cardList = document.getElementById('card-list');
        var cardForm = document.getElementById('card-form');
        var projectorForm = document.getElementById('projector-form');
        
        // Mostrar lista de tarjetas y ocultar los demás
        if (cardList.style.display === 'block') {
            cardList.style.display = 'none';
        } else {
            cardList.style.display = 'block';
            cardForm.style.display = 'none';
            projectorForm.style.display = 'none';
        }
    }

    function toggleProjectorForm() {
        var projectorForm = document.getElementById('projector-form');
        var cardForm = document.getElementById('card-form');
        var cardList = document.getElementById('card-list');
        
        // Mostrar formulario de proyector y ocultar los demás
        if (projectorForm.style.display === 'block') {
            projectorForm.style.display = 'none';
        } else {
            projectorForm.style.display = 'block';
            cardForm.style.display = 'none';
            cardList.style.display = 'none';
        }
    }

    function confirmarEliminacion(id, tipo) {
        var confirmar = confirm("¿Estás seguro de que deseas eliminar el PC con ID: " + id + " y Tipo: " + tipo + "?");
        if (confirmar) {
            // Enviar el formulario oculto asociado al PC
            document.getElementById('eliminar_pc_' + id).submit();
        }
    }

    function confirmarEliminacionIM(id, tipo) {
        var confirmar = confirm("¿Estás seguro de que deseas eliminar la impresora con ID: " + id + " y Tipo: " + tipo + "?");
        if (confirmar) {
            // Enviar el formulario oculto asociado a la impresora
            document.getElementById('eliminar_impresora_' + id).submit();
        }
    }

    function confirmarEliminacionProyector(id, tipo) {
        var confirmar = confirm("¿Estás seguro de que deseas eliminar el proyector con ID: " + id + " y Tipo: " + tipo + "?");
        if (confirmar) {
            // Enviar el formulario oculto asociado al proyector
            document.getElementById('eliminar_proyector_' + id).submit();
        }
    }

    </script>
            
            </div>

            <div class="menu">

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
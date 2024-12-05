<?php

include('../BD/ConexionBD.php'); 
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

// Registro de PC
if (isset($_POST['Registrar_PC'])) {
    // Obtener los datos del formulario
    $Id_PC = $_POST['Id_PC'];
    $Id_salon = $_POST['Id_salon'];
    $PCtipo = $_POST['PCtipo'];
    $procesador = $_POST['procesador'];
    $rom = $_POST['rom'];
    $ram = $_POST['ram'];
    $serie = $_POST['serie'];
    $MAC = $_POST['MAC'];
    $fechacompra = $_POST['fechacompra'];

    // Consulta SQL para insertar los datos en la tabla
    $sql = "INSERT INTO PC (Id_PC, Id_salon, PCtipo, procesador, rom, ram, serie, MAC, fechacompra)
            VALUES ('$Id_PC', '$Id_salon', '$PCtipo', '$procesador', '$rom', '$ram', '$serie', '$MAC', '$fechacompra')";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        /*echo "PC registrada exitosamente.";*/
    } else {
        echo "Error al registrar la PC: " . $conn->error;
    }
}

// Registro de Impresora
if (isset($_POST['Registrar_Im'])) {
    // Obtener los datos del formulario
    $Id_Impresoras = $_POST['Id_Impresoras'];
    $Id_salon = $_POST['Id_salon'];
    $Imtipo = $_POST['Imtipo'];
    $serie = $_POST['serie'];
    $marca = $_POST['marca'];
    $descripcion = $_POST['descripcion'];
    $fechacompra = $_POST['fechacompra'];

    // Consulta SQL para insertar los datos en la tabla Impresoras
    $sql = "INSERT INTO Impresoras (Id_Impresoras, Id_salon, Imtipo, serie, marca, descripcion, fechacompra)
            VALUES ('$Id_Impresoras', '$Id_salon', '$Imtipo', '$serie', '$marca', '$descripcion', '$fechacompra')";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        //echo "Impresora registrada exitosamente.";
    } else {
        echo "Error al registrar la impresora: " . $conn->error;
    }
}

// Registro de Proyector
if (isset($_POST['Registrar_Pro'])) {
    // Obtener los datos del formulario
    $Id_Proyector = $_POST['Id_Proyector'];
    $Id_salon = $_POST['Id_salon'];
    $Protipo = $_POST['Protipo'];
    $serie = $_POST['serie'];
    $marca = $_POST['marca'];
    $descripcion = $_POST['descripcion'];
    $fechacompra = $_POST['fechacompra'];

    // Consulta SQL para insertar los datos en la tabla Proyector
    $sql = "INSERT INTO Proyector (Id_Proyector, Id_salon, Protipo, serie, marca, descripcion, fechacompra)
            VALUES ('$Id_Proyector', '$Id_salon', '$Protipo', '$serie', '$marca', '$descripcion', '$fechacompra')";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        //echo "Proyector registrado exitosamente.";
    } else {
        echo "Error al registrar el proyector: " . $conn->error;
    }
}
$nombre = $_SESSION['nombre'];

// Obtener los detalles del PC antes de eliminarlo
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
    
    <link rel="stylesheet" href="../CSS/menu.css" type="text/css">
    <link rel="stylesheet" href="../CSS/diseño.css" type="text/css">
    <link rel="stylesheet" href="../CSS/cabecera.css" type="text/css">
    <link rel="stylesheet" href="../CSS/pie_pagina.css" type="text/css">
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
    
    <title>Alta de Equipos</title>
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
    <h1 class="titulo">Agregar Equipos</h1>

    <div class="cuerpo">
    <div class="div_boton">
        <button class='button -blue center' id="add-card-button" onclick="toggleCardForm()">Añadir PC</button>
        <button class='button -blue center' id="toggle-cards-button" onclick="toggleCardList()">Añadir Impresora</button>
        <button class='button -blue center' id="add-projector-button" onclick="toggleProjectorForm()">Añadir Proyector</button>
    </div>
    
    <div id="card-form" class="Registrar_Usuario" style="display:none;">
        <form class="form_reg_usuario" method="POST" enctype="multipart/form-data">
            <label for="Id_PC">ID PC:</label>
            <br>
            <?php
            include('../BD/ConexionBD.php'); 

                // Consulta para obtener el siguiente ID de PC en el formato 'Pc-001', 'Pc-002', etc.
                $sql = "SELECT CONCAT('Pc-', LPAD(COUNT(*) + 1, 3, '0')) AS pc_id FROM PC;";
                $result = $conn->query($sql);

                // Verificar si la consulta fue exitosa y si hay resultados
                if ($result && $result->num_rows > 0) {
                    // Obtener el valor generado
                    $row = $result->fetch_assoc();
                    $pc_id = $row['pc_id']; // Guardar el ID generado

                    // Imprimir el input con el ID de PC
                    echo '<input type="text" id="Id_PC" name="Id_PC" value="' . $pc_id . '" required readonly>';
                } else {
                    echo '<p>No se pudo generar el ID del PC.</p>';
                }

                // Cerrar la conexión
                $conn->close();
            ?>
            <br>
            <br>

            <label for="Id_salon">ID Salon:</label><br>
            <select name="Id_salon" id="Id_salon">
                <?php
                    include('../BD/ConexionBD.php'); 

                    // Consulta para obtener los departamentos
                    $sql = "SELECT Id_salon FROM salon";
                    $result = $conn->query($sql);

                    // Verificar si hay resultados
                    if ($result->num_rows > 0) {
                        // Generar las opciones dinámicamente
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['Id_salon'] . '">' . $row['Id_salon'] . '</option>';
                        }
                    } else {
                        echo '<option value="">No hay departamentos disponibles</option>';
                    }

                    // Cerrar la conexión
                    $conn->close();
                    
                ?>
            </select><br><br>

            <label for="PCtipo">Tipo de PC:</label>
            <br>
            <select name="PCtipo" id="" require>
                <option value="Escritorio">Escritorio</option>
                <option value="Laptop">Laptop</option>
                <option value="Todo en uno">Todo en uno</option>
            </select>
            <br>
            <br>

            <label for="procesador">Procesador:</label>
            <br>
            <input type="text" id="procesador" name="procesador" required>
            <br>
            <br>
            
            <label for="rom">Disco de almacenamiento:</label>
            <br>
            <input type="text" id="rom" name="rom" required>
            <br>
            <br>
            
            <label for="ram">Tarjeta Ram:</label>
            <br>
            <input type="text" id="ram" name="ram" required>
            <br>
            <br>
            
            <label for="serie">Serie de Tarjeta madre:</label>
            <br>
            <input type="text" id="serie" name="serie" required>
            <br>
            <br>
            
            <label for="MAC">MAC:</label>
            <br>
            <input type="text" id="MAC" name="MAC" required>
            <br>
            <br>
            
            <label for="fechacompra">Fecha de compra:</label>
            <br>
            <input type="text" id="fechacompra" name="fechacompra" required>
            <br>
            <br>
            <input type="submit" value="Registrar PC" name="Registrar_PC">
            <!--<button type="submit" name="Registrar_PC" >Añadir</button>-->
        </form>
    </div>

    <div id="card-list" style="display: none;">
        <form id="card" method="POST" class="form_reg_usuario">
            <label for="Id_Impresoras">ID Impresora:</label>
            <br>
            <?php
            include('../BD/ConexionBD.php'); 

                // Consulta para obtener el siguiente ID de PC en el formato 'Pc-001', 'Pc-002', etc.
                $sql = "SELECT CONCAT('Im-', LPAD(COUNT(*) + 1, 3, '0')) AS im_id FROM Impresoras;";
                $result = $conn->query($sql);

                // Verificar si la consulta fue exitosa y si hay resultados
                if ($result && $result->num_rows > 0) {
                    // Obtener el valor generado
                    $row = $result->fetch_assoc();
                    $im_id = $row['im_id']; // Guardar el ID generado

                    // Imprimir el input con el ID de PC
                    echo '<input type="text" id="Id_Impresoras" name="Id_Impresoras" value="' . $im_id . '" required readonly>';
                } else {
                    echo '<p>No se pudo generar el ID de la Impresora.</p>';
                }

                // Cerrar la conexión
                $conn->close();
            ?>
            <br>
            <br>
            
            <label for="Id_salon">ID Salon:</label>
            <br>
            <select name="Id_salon" id="Id_salon">
                <?php
                    include('../BD/ConexionBD.php'); 

                    // Consulta para obtener los departamentos
                    $sql = "SELECT Id_salon FROM salon";
                    $result = $conn->query($sql);

                    // Verificar si hay resultados
                    if ($result->num_rows > 0) {
                        // Generar las opciones dinámicamente
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['Id_salon'] . '">' . $row['Id_salon'] . '</option>';
                        }
                    } else {
                        echo '<option value="">No hay departamentos disponibles</option>';
                    }

                    // Cerrar la conexión
                    $conn->close();
                    
                ?>
            </select><br><br>
            
            <label for="Imtipo">Tipo de Impresora:</label>
            <br>
            <select name="Imtipo" id="" require>
                <option value="Inyeccion">Inyeccion</option>
                <option value="3D">3D</option>
                <option value="Lacer">Lacer</option>
            </select>
            <br>
            <br>
            
            <label for="serie">Serie de la Impresora:</label>
            <br>
            <input type="text" id="serie" name="serie" required>
            <br>
            <br>

            <label for="marca">Marca de la Impresora:</label>
            <br>
            <input type="text" id="marca" name="marca" required>
            <br>
            <br>

            <label for="descripcion">Informacion relevante:</label>
            <br>
            <textarea name="descripcion" id="descripcion"></textarea>
            <br>
            <br>

            <label for="fechacompra">Fecha de compra:</label>
            <br>
            <input type="text" id="fechacompra" name="fechacompra" required>
            <br>
            <br>
            <!--button type="submit" name="Registrar_Im">Agregar</button-->
            <input type="submit" value="Registrar Impresora" name="Registrar_Im">
        </form>
    </div>

    <div id="projector-form" style="display: none;">
        <form method="POST" class="form_reg_usuario">
            <label for="Id_Proyector">ID Proyector:</label>
            <br>
            <?php
            include('../BD/ConexionBD.php'); 

                // Consulta para obtener el siguiente ID de PC en el formato 'Pc-001', 'Pc-002', etc.
                $sql = "SELECT CONCAT('Pro-', LPAD(COUNT(*) + 1, 3, '0')) AS pr_id FROM Proyector;";
                $result = $conn->query($sql);

                // Verificar si la consulta fue exitosa y si hay resultados
                if ($result && $result->num_rows > 0) {
                    // Obtener el valor generado
                    $row = $result->fetch_assoc();
                    $pr_id = $row['pr_id']; // Guardar el ID generado

                    // Imprimir el input con el ID de PC
                    echo '<input type="text" id="Id_Proyector" name="Id_Proyector" value="' . $pr_id . '" required readonly>';
                } else {
                    echo '<p>No se pudo generar el ID de la Impresora.</p>';
                }

                // Cerrar la conexión
                $conn->close();
            ?>
            <br>
            <br>

            <label for="Id_salon">ID Salon:</label>
            <br>
            <select name="Id_salon" id="Id_salon">
                <?php
                    include('../BD/ConexionBD.php'); 

                    // Consulta para obtener los departamentos
                    $sql = "SELECT Id_salon FROM salon";
                    $result = $conn->query($sql);

                    // Verificar si hay resultados
                    if ($result->num_rows > 0) {
                        // Generar las opciones dinámicamente
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['Id_salon'] . '">' . $row['Id_salon'] . '</option>';
                        }
                    } else {
                        echo '<option value="">No hay departamentos disponibles</option>';
                    }

                    // Cerrar la conexión
                    $conn->close();
                    
                ?>
            </select><br><br>

            <label for="Protipo">Tipo de Proyector:</label>
            <br>
            <select name="Protipo" id="Protipo" require>
                <option value="Inyeccion">Inyeccion</option>
                <option value="3D">3D</option>
                <option value="Lacer">Lacer</option>
            </select>
            <br>
            <br>

            <label for="serie">Serie de la Impresora:</label>
            <br>
            <input type="text" id="serie" name="serie" required>
            <br>
            <br>

            <label for="marca">Marca de la Impresora:</label>
            <br>
            <input type="text" id="marca" name="marca" required>
            <br>
            <br>

            <label for="descripcion">Informacion relevante:</label>
            <br>
            <textarea name="descripcion" id="descripcion"></textarea>
            <br>
            <br>
            
            <label for="fechacompra">Fecha de compra:</label>
            <br>
            <input type="text" id="fechacompra" name="fechacompra" required>
            <br>
            <br>
            
            <input type="submit" value="Registrar Proyector" name="Registrar_Pro">
        </form>
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
    </script>
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
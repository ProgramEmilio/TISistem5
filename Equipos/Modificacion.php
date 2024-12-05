<?php
include('../BD/ConexionBD.php'); // Incluir el archivo de conexión
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../Login.php");
    exit;
}

$id = $_GET['id']; // ID del equipo
$tipo = $_GET['tipo']; // Tipo de equipo (PC, Impresora, Proyector)

$id_usuario_actual = $_SESSION['id_usuario'];
// Obtener los detalles del Usuario
$sql_select = "SELECT * FROM usuarios WHERE Id_usuario = '$id_usuario_actual'";
$result = $conn->query($sql_select);
$Usu = $result->fetch_assoc(); // Obtener el registro como un array asociativo

$id_utipo = $Usu['Id_Utipo']; // Tipo de usuario logueado

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($tipo == "PC") {
        // Actualizar la tabla PC
        $query = "UPDATE PC SET Id_salon = ?, PCtipo = ?, procesador = ?, rom = ?, ram = ?, serie = ?, MAC = ?, fechacompra = ? WHERE Id_PC = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssssss", $_POST['Id_salon'], $_POST['PCtipo'], $_POST['procesador'], $_POST['rom'], $_POST['ram'], $_POST['serie'], $_POST['MAC'], $_POST['fechacompra'], $id);
        $stmt->execute();
        //echo "PC actualizada correctamente";
        header("Location: Baja.php");
    } elseif ($tipo == "Impresora") {
        // Actualizar la tabla Impresoras
        $query = "UPDATE Impresoras SET Id_salon = ?, Imtipo = ?, serie = ?, marca = ?, descripcion = ?, fechacompra = ? WHERE Id_Impresoras = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssss", $_POST['Id_salon'], $_POST['Imtipo'], $_POST['serie'], $_POST['marca'], $_POST['descripcion'], $_POST['fechacompra'], $id);
        $stmt->execute();
        //echo "Impresora actualizada correctamente";
        header("Location: Baja.php");
    } elseif ($tipo == "Proyector") {
        // Actualizar la tabla Proyector
        $query = "UPDATE Proyector SET Id_salon = ?, Protipo = ?, serie = ?, marca = ?, descripcion = ?, fechacompra = ? WHERE Id_Proyector = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssss", $_POST['Id_salon'], $_POST['Protipo'], $_POST['serie'], $_POST['marca'], $_POST['descripcion'], $_POST['fechacompra'], $id);
        $stmt->execute();
        //echo "Proyector actualizado correctamente";
        header("Location: Baja.php");
    }
}

// Recuperar los datos actuales del equipo
if ($tipo == "PC") {
    $query = "SELECT * FROM PC WHERE Id_PC = ?";
} elseif ($tipo == "Impresora") {
    $query = "SELECT * FROM Impresoras WHERE Id_Impresoras = ?";
} elseif ($tipo == "Proyector") {
    $query = "SELECT * FROM Proyector WHERE Id_Proyector = ?";
}

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc(); // Obtener los datos





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
    <link rel="stylesheet" href="Alta.css" type="text/css">


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
    
    <title>Modificar Equipo</title>
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
        <h3 class="titulo">Modificación del equipo: <?php echo $id; ?></h3>

        <?php if ($tipo == "PC"): ?>
            <form class="form_reg_usuario" method="POST" enctype="multipart/form-data">
                <label for="Id_PC">ID PC:</label>
                <br>
                <input type="text" id="Id_PC" readonly name="Id_PC" value="<?php echo $data['Id_PC']; ?>" required>
                <br><br>

                <label for="Id_salon">ID Salón:</label>
                <br>
                <input type="text" id="Id_salon" name="Id_salon" value="<?php echo $data['Id_salon']; ?>" required>
                <br><br>

                <label for="PCtipo">Tipo de PC:</label>
                <br>
                <select name="PCtipo" id="PCtipo" required>
                    <option value="Escritorio" <?php echo ($data['PCtipo'] == 'Escritorio') ? 'selected' : ''; ?>>Escritorio</option>
                    <option value="Laptop" <?php echo ($data['PCtipo'] == 'Laptop') ? 'selected' : ''; ?>>Laptop</option>
                    <option value="Todo en uno" <?php echo ($data['PCtipo'] == 'Todo en uno') ? 'selected' : ''; ?>>Todo en uno</option>
                </select>
                <br><br>

                <label for="procesador">Procesador:</label>
                <br>
                <input type="text" id="procesador" name="procesador" value="<?php echo $data['procesador']; ?>" required>
                <br><br>

                <label for="rom">Disco de almacenamiento:</label>
                <br>
                <input type="text" id="rom" name="rom" value="<?php echo $data['rom']; ?>" required>
                <br><br>

                <label for="ram">Tarjeta RAM:</label>
                <br>
                <input type="text" id="ram" name="ram" value="<?php echo $data['ram']; ?>" required>
                <br><br>

                <label for="serie">Serie de Tarjeta madre:</label>
                <br>
                <input type="text" id="serie" name="serie" value="<?php echo $data['serie']; ?>" required>
                <br><br>

                <label for="MAC">MAC:</label>
                <br>
                <input type="text" id="MAC" name="MAC" value="<?php echo $data['MAC']; ?>" required>
                <br><br>

                <label for="fechacompra">Fecha de compra:</label>
                <br>
                <input type="text" id="fechacompra" name="fechacompra" value="<?php echo $data['fechacompra']; ?>" required>
                <br><br>

                <input type="submit" value="Actualizar PC" name="Actualizar_PC">
            </form>
        <?php endif; ?>

        <?php if ($tipo == "Impresora"): ?>
            <form class="form_reg_usuario" method="POST">
                <label for="Id_Impresoras">ID Impresora:</label>
                <br>
                <input type="text" id="Id_Impresoras" name="Id_Impresoras" value="<?php echo $data['Id_Impresoras']; ?>" required>
                <br><br>

                <label for="Id_salon">ID Salón:</label>
                <br>
                <input type="text" id="Id_salon" name="Id_salon" value="<?php echo $data['Id_salon']; ?>" required>
                <br><br>

                <label for="Imtipo">Tipo de Impresora:</label>
                <br>
                <select name="Imtipo" id="Imtipo" required>
                    <option value="Inyeccion" <?php echo ($data['Imtipo'] == 'Inyeccion') ? 'selected' : ''; ?>>Inyección</option>
                    <option value="3D" <?php echo ($data['Imtipo'] == '3D') ? 'selected' : ''; ?>>3D</option>
                    <option value="Lacer" <?php echo ($data['Imtipo'] == 'Lacer') ? 'selected' : ''; ?>>Láser</option>
                </select>
                <br><br>

                <label for="serie">Serie de la Impresora:</label>
                <br>
                <input type="text" id="serie" name="serie" value="<?php echo $data['serie']; ?>" required>
                <br><br>

                <label for="marca">Marca de la Impresora:</label>
                <br>
                <input type="text" id="marca" name="marca" value="<?php echo $data['marca']; ?>" required>
                <br><br>

                <label for="descripcion">Información relevante:</label>
                <br>
                <textarea name="descripcion" id="descripcion"><?php echo $data['descripcion']; ?></textarea>
                <br><br>

                <label for="fechacompra">Fecha de compra:</label>
                <br>
                <input type="text" id="fechacompra" name="fechacompra" value="<?php echo $data['fechacompra']; ?>" required>
                <br><br>

                <input type="submit" value="Actualizar Impresora" name="Actualizar_Im">
            </form>
        <?php endif; ?>

        <?php if ($tipo == "Proyector"): ?>
            <form class="form_reg_usuario" method="POST">
                <label for="Id_Proyector">ID Proyector:</label>
                <br>
                <input type="text" id="Id_Proyector" name="Id_Proyector" value="<?php echo $data['Id_Proyector']; ?>" required>
                <br><br>

                <label for="Id_salon">ID Salón:</label>
                <br>
                <input type="text" id="Id_salon" name="Id_salon" value="<?php echo $data['Id_salon']; ?>" required>
                <br><br>

                <label for="Protipo">Tipo de Proyector:</label>
                <br>
                <select name="Protipo" id="Protipo" required>
                    <option value="Inyeccion" <?php echo ($data['Protipo'] == 'Inyeccion') ? 'selected' : ''; ?>>Inyección</option>
                    <option value="3D" <?php echo ($data['Protipo'] == '3D') ? 'selected' : ''; ?>>3D</option>
                    <option value="Lacer" <?php echo ($data['Protipo'] == 'Lacer') ? 'selected' : ''; ?>>Láser</option>
                </select>
                <br><br>

                <label for="serie">Serie del Proyector:</label>
                <br>
                <input type="text" id="serie" name="serie" value="<?php echo $data['serie']; ?>" required>
                <br><br>

                <label for="marca">Marca del Proyector:</label>
                <br>
                <input type="text" id="marca" name="marca" value="<?php echo $data['marca']; ?>" required>
                <br><br>

                <label for="descripcion">Información relevante:</label>
                <br>
                <textarea name="descripcion" id="descripcion"><?php echo $data['descripcion']; ?></textarea>
                <br><br>

                <label for="fechacompra">Fecha de compra:</label>
                <br>
                <input type="text" id="fechacompra" name="fechacompra" value="<?php echo $data['fechacompra']; ?>" required>
                <br><br>

                <input type="submit" value="Actualizar Proyector" name="Actualizar_Pro">
            </form>
        <?php endif; ?>
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
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
    <title>Estadisticas</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="../CSS/menu.css" type="text/css">
    <link rel="stylesheet" href="../CSS/cabecera.css" type="text/css">
    <link rel="stylesheet" href="../CSS/pie_pagina.css" type="text/css">
    <link rel="stylesheet" href="../CSS/tablas_boton.css" type="text/css">
    <link rel="stylesheet" href="../CSS/formularios.css" type="text/css">
    <link rel="stylesheet" href="../CSS/departamentos.css" type="text/css">
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
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
                        <li><a href="../Peticiones/Revisar.php">Revisar</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($Usu['Id_Utipo'] == 1 || $Usu['Id_Utipo'] == 4): ?>
                <!-- Estadísticas -->
                <li><a href="graficas.php">Estadísticas</a>
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
        <h1 class="titulo">Estadísticas</h1>
        <br>
        <h2 class="sub_titulo">Reporte de Estadísticas</h2>
        <?php
    
    include("../BD/ConexionBD.php");

    // Consultas SQL para obtener los conteos
    $query_levantado = "SELECT COUNT(*) AS total FROM Reporte WHERE Estado = 'Levantado'";
    $query_completado = "SELECT COUNT(*) AS total FROM Reporte WHERE Estado = 'Completado'";
    $query_liberado = "SELECT COUNT(*) AS total FROM Reporte WHERE Estado = 'Liberado'";

    $result_levantado = $conn->query($query_levantado);
    $result_completado = $conn->query($query_completado);
    $result_liberado = $conn->query($query_liberado);

    $levantado = $result_levantado->fetch_assoc()['total'];
    $completado = $result_completado->fetch_assoc()['total'];
    $liberado = $result_liberado->fetch_assoc()['total'];

    echo "<div class='cuerpo'>";
        echo "<div class='div_boton'>";
        echo "<button class='button -blue center'>Levantado:  <span style='font-weight: normal;'>" . $levantado . "</span></button>";
        echo "<button class='button -blue center'>Completado:  <span style='font-weight: normal;'>" . $completado . "</span></button>";
        echo "<button class='button -blue center'>Liberado:  <span style='font-weight: normal;'>" . $liberado . "</span></button>";
        echo "</div>";
    echo "</div>";  

    $conn->close();
    ?>

        <div style="width: 50%; margin: auto;">
            <canvas id="myChart"></canvas>
        </div>
        <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Levantado', 'Completado', 'Liberado'], // Etiquetas para las barras
            datasets: [{
                // Quitar el label general
                data: [<?php echo $levantado; ?>, <?php echo $completado; ?>, <?php echo $liberado; ?>],
                backgroundColor: [
                    'rgba(93, 166, 173, 0.6)', // Color para Levantado
                    'rgba(54, 162, 235, 0.6)', // Color para Completado
                    'rgba(75, 192, 192, 0.6)'  // Color para Liberado
                ],
                borderColor: [
                    'rgba(107, 197, 206, 1)',   // Borde para Levantado
                    'rgba(54, 162, 235, 1)',    // Borde para Completado
                    'rgba(75, 192, 192, 1)'     // Borde para Liberado
                ],
                borderWidth: 3
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false // Oculta la leyenda
                },
                datalabels: {
                    color: 'black',
                    align: 'end',
                    anchor: 'end'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,   // Iniciar desde cero
                    min: 0,              // Valor mínimo del eje Y
                    max: 30,            // Valor máximo del eje Y
                    ticks: {
                        stepSize: 5,      // Incremento entre los valores de la escala
                        color: 'black'
                    }
                }
            }
        }
    });
</script>

            
        <h2 class="sub_titulo">Reporte de Trabajadores</h2>
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

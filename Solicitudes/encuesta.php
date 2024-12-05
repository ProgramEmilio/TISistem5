<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta de Satisfacción</title>
    <link rel="stylesheet" href="encu.css"> 
</head>
<body>
    <h1>Encuesta de Satisfacción del Sistema Gestor de Datos</h1>

    <form action="procesar_encuesta.php" method="POST">
        <h3>1. ¿Qué tan fácil te resultó navegar y utilizar el sistema?</h3>
        <label><input type="radio" name="facilidad" value="Muy fácil" required> Muy fácil</label><br>
        <label><input type="radio" name="facilidad" value="Fácil"> Fácil</label><br>
        <label><input type="radio" name="facilidad" value="Algo complicado"> Algo complicado</label><br>
        <label><input type="radio" name="facilidad" value="Difícil"> Difícil</label><br><br>

        <h3>2. ¿El sistema cumple con tus expectativas en cuanto a rendimiento?</h3>
        <label><input type="radio" name="rendimiento" value="Supera mis expectativas" required> Supera mis expectativas</label><br>
        <label><input type="radio" name="rendimiento" value="Cumple con mis expectativas"> Cumple con mis expectativas</label><br>
        <label><input type="radio" name="rendimiento" value="Está por debajo de mis expectativas"> Está por debajo de mis expectativas</label><br>
        <label><input type="radio" name="rendimiento" value="No cumple con mis expectativas"> No cumple con mis expectativas</label><br><br>

        <h3>3. ¿Cómo calificarías la precisión de los datos gestionados por el sistema?</h3>
        <label><input type="radio" name="precision" value="Excelente" required> Excelente</label><br>
        <label><input type="radio" name="precision" value="Buena"> Buena</label><br>
        <label><input type="radio" name="precision" value="Regular"> Regular</label><br>
        <label><input type="radio" name="precision" value="Deficiente"> Deficiente</label><br><br>

        <input type="submit" value="Enviar Respuestas">
    </form>
</body>
</html>

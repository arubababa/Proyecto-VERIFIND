<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidencias</title>
    <style>
        body {
		    height: 10px;
            background-image: url('portada.jpeg');
            background-size: cover;
        }
        div {
            color: white;
            text-align: center;
            font-size:20px;
            font-family:'Times New Roman', Times, serif Haettenschweiler, 'Arial Narrow Bold', sans-serif;
            position: relative;
            top: 100px;
            background-color: #40533F;
            padding: 10px 10px;
        }
        h1 {
            color: white;
            text-align: center;
            font-size:60px;
            font-family:'Times New Roman', Times, serif Haettenschweiler, 'Arial Narrow Bold', sans-serif;
            position: relative;
            top: 100px;
        }
        .menu {
            background-color: #333;
            overflow: hidden;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1;
        }
        .menu a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .menu a:hover {
            background-color: #111;
        }
        .pie-pagina .copy {
            background-color: #0a1a2a;
            padding: 15px 10px;
            text-align: center;
            color: #fff;
            bottom: 0;
            width: 100%;
        }
        .pie-pagina .copy small {
            font-size: 15px;
        }
    </style>
</head>

<body>

<div class="menu">
    <a href="">Incidencias</a>
    <a href="">Reportes</a>
    <a href="./pagina_explora.html">Explora</a>
    <a href="./pagina_usuarios">Usuarios</a>
</div>

<h1>Reporte de Incidencias</h1>

<div>
    <form name="form1" action="" method="post">
        <p>Tipo de delito:
        <input type="radio" name="tipo_delito" value="estafa" checked> Estafa
        <input type="radio" name="tipo_delito" value="publicidad"> Publicidad
        <input type="radio" name="tipo_delito" value="otros"> Otros</p>
        <p>Tipo de incidencia:
        <input type="radio" name="tipo_reporte" value="email" checked> Email
        <input type="radio" name="tipo_reporte" value="ip"> IP
        <input type="radio" name="tipo_reporte" value="telefono">Teléfono</p>
        <p>Reporte: <input type="text" name="reporte"/></p>
        <textarea name="comentario" rows="12" cols="35" placeholder="Explíquenos los detalles de la incidencia."></textarea><br>
        <input type="submit" value="Enviar">
    </form>
</div>
<footer class="pie-pagina">
    <div class="copy">
        <small>&copy; 2024 <b>Verifind</b> - Todos los Derechos Reservados.</small>
    </div>
</footer>

<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se ha enviado el formulario
    if (isset($_POST['tipo_delito'], $_POST['tipo_reporte'], $_POST['reporte'], $_POST['comentario'])) {
        // Obtener los valores del formulario y limpiarlos
        $tipo_delito = mysqli_real_escape_string($conexion, $_POST['tipo_delito']);
        $tipo_incidencia = mysqli_real_escape_string($conexion, $_POST['tipo_reporte']);
        $reporte = mysqli_real_escape_string($conexion, $_POST['reporte']);
        $comentario = mysqli_real_escape_string($conexion, $_POST['comentario']);
        
        // Establecer conexión con la base de datos
        $conexion = mysqli_connect("localhost", "root", "", "verifind") or 
            die("Error: No se pudo conectar a la base de datos. " . mysqli_connect_error());

        // Ejecutar la consulta SQL para insertar los datos en la base de datos
        $insertar = "INSERT INTO incidencias (TIPO_DELITO, TIPO_INCIDENCIA, REPORTE, COMENTARIO) VALUES ('$tipo_delito', '$tipo_incidencia', '$reporte', '$comentario')";
        if (mysqli_query($conexion, $insertar)) {
            echo "Los datos se han insertado correctamente en la base de datos.";
        } else {
            echo "Error al insertar los datos: " . mysqli_error($conexion);
        }

        // Cerrar la conexión con la base de datos
        mysqli_close($conexion);
    } else {
        echo "Por favor, complete todos los campos del formulario.";
    }
}
?>
</body>
</html>

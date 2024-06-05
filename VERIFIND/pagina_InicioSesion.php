<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesion</title>
    <link rel="icon" type="image/x-icon" href="./favi.ico">
    <style>
        body {
            height: 10px; 
            background-image:url(portada2.JPG);
        }
        div {
            color: black;
            text-align: center;
            font-size:20px;
            font-family:'Times New Roman', Times, serif Haettenschweiler, 'Arial Narrow Bold', sans-serif;
            position: relative;
            top: 100px;
        }
        h1 {
            color: #AED6F1;
            text-align: center;
            font-size:60px;
            font-family:'Times New Roman', Times, serif Haettenschweiler, 'Arial Narrow Bold', sans-serif;
            position: relative;
            top: 100px;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .menu {
            background-color: white;
            overflow: hidden;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
        }
        .menu a {
            float: left;
            display: block;
            color: #40533F;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .menu a:hover {
            background-color: #AED6F1;
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
    <a href="./pagina_principal.php">Home</a>
    <a href="./pagina_explora.html">Explora</a>
    <a style="float:right";  href="./pagina_InicioSesion.php">Iniciar Sesion | Registrarse</a>
</div>

<script>    
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
 }
</script>

<h1>Inicio de Sesión</h1>
<div>
    <form action="" method="post">
        Email:
        <input type="text" name="email" required><br>
        <br>
        Contraseña:
        <input type="password" name="pass" required><br><br>
        <input type="submit" name="LOGIN" value="LOGIN">
    </form> 
    <p>En caso de no tener cuenta, pueda crear una aqui<a href="./pagina_creacioncuenta.php" class="button">Crear cuenta</a></p>
</div>



<?php

// Verificar si se ha enviado el formulario
if(isset($_POST['LOGIN'])) {
    // Obtener los datos del formulario
    $email = $_REQUEST['email'];
    $password = $_REQUEST['pass'];

    // Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "verifind") or 
        die ("Error: No se pudo conectar a la base de datos. " . mysqli_connect_error());


    // Consulta SQL para obtener la contraseña hasheada del usuario
    $result = mysqli_query($conexion, "SELECT NOMBRE, PASS FROM usuarios WHERE EMAIL='$email'");

    
    // Verificar si se encontró el usuario en la base de datos
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $nombre = $row['NOMBRE'];
        $hash = $row['PASS'];

        // Verificar si la contraseña coincide
        if (password_verify($password, $hash)) {
            // Guardar los datos del usuario en la sesión
            $_SESSION['nombre'] = $nombre;
            $_SESSION['email'] = $email;
            //Redirigir a la pagina de incidencias
            header("Location: ./pagina_usuarios.php");
            exit();
        } else {
            // Contraseña incorrecta, mostrar mensaje de error
            echo "</br></br></br></br></br></br>";
            echo "<center>";
            echo "<table style='background-color: white;'><tr><td>ERROR: Contraseña incorrecta, vuelva a intentarlo</td></tr></table>";
        }


            // Cerrar la conexión
            mysqli_close($conexion);
        }
    }
?>

</body>

<footer class="pie-pagina">
    <div class="copy">
        <small>&copy; 2024 <b>Verifind</b> - Todos los Derechos Reservados.</small>
    </div>
</footer>

</html>
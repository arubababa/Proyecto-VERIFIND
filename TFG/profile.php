<?php
    require_once('./header.php');
    require_once('./functions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del usuario</title>
    <link rel="icon" type="image/x-icon" href="./favi.ico">
    <style>
        body {
            height: 10px;
            background-image:url(portada2.JPG);
            background-size: cover;
            background-repeat: no-repeat; 
        }
        .Buscador2 {
            color: white;
            text-align: center;
            font-size:20px;
            font-family:'Times New Roman', Times, serif Haettenschweiler, 'Arial Narrow Bold', sans-serif;
            top: 100px;

            position: absolute;
            top: 40%;
            left: 5%;
            border-radius: 10px;
        }
        h1 {
            color: #AED6F1;
            text-align: center;
            font-size: 60px;
            font-family: 'Times New Roman', Times, serif, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
            margin-top: 150px;
            position: relative;
            text-align: center;
            margin-left: auto;
            margin-right: auto;
        }
        .menu {
            background-color: white;
            overflow: hidden;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 10;
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

        .table-container {
            position: absolute;
            top: 60%;
            left: 5%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border-style:solid;
            border-color: #96D4D4;
            padding: 8px;
            text-align: left;
        }
        footer.pie-pagina {
            width: 100%;
            background-color: #AED6F1;
            color: #40533F;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
        }
        .copy small {
            color: #FFFFFF;
        }
        .perfil {
            width: 80%;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-left: auto;
            margin-right: auto;
        }
        .perfil-container {
            width: 33%;
            display: block;
            top: 60%;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>

    <div class="menu">
        <a href="./pagina_principal2.php">Home</a>
        <a href="./pagina_incidencias.php">Incidencias</a>
        <a href="./pagina_principal1.php" style="float:right;">Cerrar sesion</a>
    </div>

    <h1>Información de tu perfil</h1>

    <?php
        if(isset($_SESSION['email'])) {
            // Conexión a la base de datos
            $conexion=mysqli_connect("localhost","root","","verifind") or 
                die("Error: No se pudo conectar a la base de datos. " . mysqli_connect_error());

            // Consulta a la base de datos
            $correo=$_SESSION['email'];
            $consulta=mysqli_query($conexion,"SELECT id_usuario,nombre,email,tlf FROM USUARIOS WHERE email='$correo';");
            $row = mysqli_fetch_array($consulta);
            $id_usuario = $row['id_usuario'];
            $nombre = $row['nombre'];
            $email = $row['email'];
            $telefono = $row['tlf'];
            echo "<div class='perfil-container'>";
            echo "<div class='perfil'>";
            echo "<p>Bienvenido, $nombre</p>";
            echo "<p>Tu id de usuario es: $id_usuario</p>";
            echo "<p>Tu email es: $email</p>";
            if (isset($telefono)) {
                echo "<p>Tu telefono es: $telefono</p>";
            }
            echo "</div>";
            echo "</div>";
            
            // Cerrar la conexión
            mysqli_close($conexion);
        }
    ?>

<footer class="pie-pagina">
    <div class="copy">
        <small style='color:#FFFFFF'>&copy; 2024 <b>Verifind</b> - Todos los Derechos Reservados.</small>
    </div>
</footer>
</body>
</html>
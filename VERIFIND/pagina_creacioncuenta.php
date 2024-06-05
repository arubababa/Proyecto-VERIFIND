<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Incidencias</title>
    <link rel="icon" type="image/x-icon" href="./favi.ico">
    <style>
        body {
            height: 10px;
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
            padding: 10px 10px;
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

<h1>Creacion de cuenta</h1>
<div>
    <form action="" method="post">
        Nombre: <input type="text" name="nombre" required/><br>  
        <br>
        Email: <input type="text" name="email" required/><br>
        <br>
        Telefono: <input type="number" name="telefono" required/></br>
        <br>
        Contraseña: <input type="password" name="pass" required/></br>
        </br>
        <input type="submit" name='ENVIAR' value="ENVIAR">
    </form> 
</div>

<script>
        if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
        }
</script>


<?php
if (isset($_POST['ENVIAR'])) {

        // Conexión a la base de datos
        $conexion = mysqli_connect("localhost","root","", "verifind");
        
        // Verificar si el email ya está registrado
        $email = mysqli_real_escape_string($conexion, $_POST['email']);
        $existe = mysqli_query($conexion, "SELECT COUNT(*) AS cantidad FROM usuarios WHERE EMAIL='$email'");
        $fila = mysqli_fetch_assoc($existe);
        
        if ($fila['cantidad'] == 0) {
            // Obtener la fecha actual
            $fecha_actual = date("Y-m-d"); 
            
            // Convertir la contraseña en un hash
            $contrasena_hash = password_hash($_POST['pass'], PASSWORD_DEFAULT);
            
            // Preparar los valores para la inserción en la base de datos
            $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
            $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
            
            // Insertar los datos en la base de datos
            $query = "INSERT INTO USUARIOS  (NOMBRE, EMAIL, TLF, PASS, FECHA_ALTA) 
                      VALUES ('$nombre', '$email', '$telefono', '$contrasena_hash', '$fecha_actual')";
            
            if (mysqli_query($conexion, $query)) {
                echo "</br></br></br></br></br></br>";
                echo "<center>";
                echo "<table style='background-color: white;'><tr><td>Alta de $nombre realizada con éxito</td></tr></table>";
            } else {
                echo "Problemas con el insert: " . mysqli_error($conexion);
            }
        } else {
            echo "</br></br></br></br></br></br>";
            echo "<center>";
            echo "<table style='background-color: white;'><tr><td>El email $email ya está asociado a una cuenta, intente con otro</td></tr></table>";
        }

        mysqli_close($conexion);
    
}
?>
</body>

<footer class="pie-pagina">
    <div class="copy">
        <small>&copy; 2024 <b>Verifind</b> - Todos los Derechos Reservados.</small>
    </div>
</footer>
</html>
<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['nombre']) || !isset($_SESSION['email'])) {
    echo "Por favor, inicie sesión primero.";
    exit();
}
?>

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
    <a href="./pagina_usuarios.php">Incidencias</a>
    <a href="./pagina_explora.html">Explora</a>
    <a style="float:right"; href="./pagina_InicioSesion.php">Iniciar Sesion | Registrarse</a>
</div>

<h1>Reporte de Incidencias</h1>

<div>
    <form action="" method="post">
        Tipo de reporte:
        <input type="radio" name="tipo_reporte" value="mail"> Mail
        <input type="radio" name="tipo_reporte" value="ip"> IP
        <input type="radio" name="tipo_reporte" value="telefono"> Teléfono<br>
        <br>
        Email_malicioso: <input type="text" name="email_m"/><br>
        <br>
        Telefono_malicioso: <input type="text" name="telefono_m"/><br>
        <br>
        IP_malicioso: <input type="text" name="ip_m"/><br>
        <br>
        <input type="submit" name="ENVIAR" value="ENVIAR">
    </form> 
</div>

<script>
        if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
        }

</script>

<?php
// Verificar si se ha enviado el formulario
if (isset($_POST['ENVIAR'])) {
        // Conexión a la base de datos
        $conexion = mysqli_connect("localhost", "root", "", "verifind") 
            or die("Error: No se pudo conectar a la base de datos. " . mysqli_connect_error());
        
        
        // Obtener los datos del usuario del incio de sesion
        $nombre_usuario = $_SESSION['nombre'];
        $email_usuario = $_SESSION['email'];

        //obtener ID del usuario con su mail
        $result= mysqli_query($conexion,"SELECT ID_USUARIO FROM USUARIOS WHERE EMAIL LIKE '$email_usuario'");
        $row= mysqli_fetch_array($result);
        $id_user = $row['ID_USUARIO'];
        
        // Insertar la incidencia en la tabla de incidencias
        $tipo_reporte =  $_REQUEST['tipo_reporte'];

        
        if ($tipo_reporte == "mail") {

            $email_malicioso =  $_REQUEST['email_m'];
            // Verificar si el mail ya existe para este usuario
            $comprobador_query = "SELECT * FROM INCIDENCIAS WHERE ID_USUARIO = $id_user AND MAIL_MALICIOSO = '$email_malicioso'";
            $resultado = mysqli_query($conexion, $comprobador_query);

            if (mysqli_num_rows($resultado) > 0) {
                echo "</br></br></br></br></br></br>";
                echo "<center>";
                echo "<table style='background-color: white;'><tr><td>ERROR: El mail ya ha sido registrado.</td></tr></table>";
            } else {
                $insert_incidencia = "INSERT INTO INCIDENCIAS (ID_USUARIO, TIPO_INC, MAIL_MALICIOSO) VALUES ('$id_user', 'mail', '$email_malicioso')";
            }
            
        
        } elseif ($tipo_reporte == "telefono") {
        
            $telefono_malicioso =  $_REQUEST['telefono_m'];
            // Verificar si el mail ya existe para este usuario
            $comprobador_query = "SELECT * FROM INCIDENCIAS WHERE ID_USUARIO = $id_user AND TELEFONO_MALICIOSO = '$email_malicioso'";
            $resultado = mysqli_query($conexion,$comprobador_query);

            if (mysqli_num_rows($resultado) > 0) {
                echo "</br></br></br></br></br></br>";
                echo "<center>";
                echo "<table style='background-color: white;'><tr><td>ERROR: El telefono ya ha sido registrado.</td></tr></table>";
            } else {
                $insert_incidencia = "INSERT INTO INCIDENCIAS (ID_USUARIO, TIPO_INC, TELEFONO_MALICIOSO) VALUES ('$id_user', 'mail', '$telefono_malicioso')";
            }
        
        } else {
        
            $ip_malicioso = $_REQUEST['ip_m'];
            // Verificar si el mail ya existe para este usuario
            $comprobador_query = "SELECT * FROM INCIDENCIAS WHERE ID_USUARIO = $id_user AND IP_MAILICIOSO = '$ip_malicioso'";
            $resultado = mysqli_query($conexion, $comprobador_query);

            if (mysqli_num_rows($resultado) > 0) {
                echo "</br></br></br></br></br></br>";
                echo "<center>";
                echo "<table style='background-color: white;'><tr><td>ERROR: La IP ya ha sido registrado.</td></tr></table>";
            } else {
                $insert_incidencia = "INSERT INTO incidencias (ID_USUARIO, TIPO_INC, IP_MAILICIOSO) VALUES ('$id_user', 'ip', '$ip_malicioso')";
            }
        
        }

    // Ejecutar la consulta de inserción si está definida
    if (isset($insert_incidencia) && mysqli_query($conexion, $insert_incidencia)) {
        echo "</br></br></br></br></br></br>";
        echo "<center>";
        echo "<table style='background-color: white;'><tr><td>Incidencia registrada exitosamente.</td></tr></table>";
    } elseif (!isset($insert_incidencia)) {
        // Ya se ha mostrado un mensaje de error específico
    } else {
        echo "</br></br></br></br></br></br>";
        echo "<center>";
        echo "<table style='background-color: white;'><tr><td>ERROR: No se pudo registrar la incidencia.</td></tr></table>";
        echo "Error: " . mysqli_error($conexion);
    }

        // Cerrar la conexión
        mysqli_close($conexion);
    
}
?>


<footer class="pie-pagina">
    <div class="copy">
        <small>&copy; 2024 <b>Verifind</b> - Todos los Derechos Reservados.</small>
    </div>
</footer>


</body>
</html>

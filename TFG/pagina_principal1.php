<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link rel="icon" type="image/x-icon" href="./favi.ico">
    <style>
        body {
            height: 10px;
            background-image:url('portada1.JPG');
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
            font-family:'Times New Roman', Times, serif Haettenschweiler, 'Arial Narrow Bold', sans-serif;
            position: relative;
            float: left;
            margin-top: 150px;
            left: 8%;
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
    </style>
</head>

<body>
<div class="menu">
    <a href="./pagina_principal1.php">Home</a>
    <a href="./pagina_explora.html">Explora</a>
    <a style="float:right"; href="./login.html">Iniciar Sesion | Registrarse</a>
</div>

<h1>VERIFIND</h1>


<div class="Buscador2">
    <form action="" method="post">
            <input type="text" name="buscador" style="width: 300px;"> 
            <input type="submit" name="BUSCAR" value="BUSCAR">
    </form>
</div>

<script>    
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
 }
</script>

<footer class="pie-pagina">
    <div class="copy">
        <small>&copy; 2024 <b>Verifind</b> - Todos los Derechos Reservados.</small>
    </div>
</footer>

<?php
if(isset($_POST['BUSCAR'])) {
    // Obtener el término de búsqueda del formulario
    $busqueda = $_POST['buscador'];

    // Conexión a la base de datos
    $conexion=mysqli_connect("localhost","root","","verifind");
    $consulta=mysqli_query($conexion,"SELECT * FROM REPORTES WHERE TIPO_INC LIKE '%$busqueda%'");
    // Verificar la conexión
    if (!$conexion) {
        die("Error: No se pudo conectar a la base de datos. " . mysqli_connect_error());
    }

    

    // Verificar si se encontraron resultados
    if (mysqli_num_rows($consulta) > 0) {
        // Mostrar los resultados en una tabla
        echo "</br></br></br></br></br></br>";
        echo "<center>";
        echo "<div class='table-container'>";
        echo "<table>";
        echo "<tr>";
        echo "  <th> ID_REPORTE </th>";
        echo "  <th> MAIL_MALICIOSO </th>";
        echo "  <th> TELEFONO_MALICIOSO </th>";
        echo "  <th> IP_MALICIOSO </th>";
        echo "  <th> NUM_REPORTE </th>";
        echo "  <th> TIPO_INC </th>";
        echo "</tr>";
        
        while ($row = mysqli_fetch_array($consulta)) {
            echo "<tr>";
            echo "<td>".$row['ID_REPORTE']."</td>";
            echo "<td>".$row['MAIL_MALICIOSO']."</td>";
            echo "<td>".$row['TELEFONO_MALICIOSO']."</td>";
            echo "<td>".$row['IP_MALICIOSO']."</td>";
            echo "<td>".$row['NUM_REPORTE']."</td>";
            echo "<td>".$row['TIPO_INC']."</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>"; // Cerramos el div table-container
    } else {
        echo "</br></br></br></br></br></br>";
        echo "<center>";
        echo "<table style='background-color: white;'><tr><td>No hay datos con las instrucciones pasadas</td></tr></table>";
    }
    
    // Cerrar la conexión
    mysqli_close($conexion);
}
?>

</body>

</html>
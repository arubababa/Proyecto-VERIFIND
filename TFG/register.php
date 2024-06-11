<?php
    require_once('./register.class.php');

    if (isset($_POST['nombre']) && isset($_POST['email']) && isset($_POST['pass'])) {
        $registro = new Register($_POST['nombre'], $_POST['email'], $_POST['telefono'], $_POST['pass']);
        $resultado = $registro->get_confirmation();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Registro</title>
    <link rel="icon" type="image/x-icon" href="./favi.ico"/>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('portada2.JPG');
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
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
        h1 {
            color: #AED6F1;
            text-align: center;
            font-size: 60px;
            font-family: 'Times New Roman', Times, serif, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
            margin-top: 150px;
            position: relative;
            margin-left: auto;
            margin-right: auto;
        }
        form {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin: auto;
        }
        .form-container {
            position: absolute;
            top: 60%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin: auto;
        }
        input[type="text"], input[type="password"] {
            padding: 10px;
            margin: 10px 0;
            width: 80%;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            background-color: #AED6F1;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #3498db;
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
        <a style="float:right;" href="./login.html">Iniciar Sesion | Registrarse</a>
    </div>

    <h1>Registrarse</h1>

    <?php
        if(isset($resultado)){
            echo $resultado;
        } else {
        ?>
            <div class="form-container">
                <form action="" method="post">
                    <label for="nombre">Nombre:</label><br>
                    <input type="text" id="nombre" name="nombre" required/><br>
                    <br>
                    <label for="email">Email:</label><br>
                    <input type="text" id="email" name="email" required/><br>
                    <br>
                    <label for="telefono">Teléfono:</label><br>
                    <input type="text" id="telefono" name="telefono"/><br>
                    <br>
                    <label for="pass">Contraseña:</label><br>
                    <small style="color:black">Debe tener entre 8 a 14 caracteres.</small>
                    <input type="password" id="pass" name="pass" minlength="8" maxlength="14" required/><br>
                    <br>
                    <input type="submit" name='ENVIAR' value="ENVIAR">
                </form>
                <p>¿Ya tienes una cuenta? <a href="./login.html">Iniciar Sesión</a></p>
            </div>
            <?php
        }
    ?>

    <footer class="pie-pagina">
        <div class="copy">
            <small>&copy; 2024 <b>Verifind</b> - Todos los Derechos Reservados.</small>
        </div>
    </footer>
</body>
</html>

<?php
    #Conexion a la base de datos
    function connectionBD(){

        $host = 'localhost';
        $dbUser = 'root';
        $dbPass = '';
        $dbName = 'verifind';
        $hostDB = 'mysql:host='.$host.';dbname='.$dbName.';';
        
        try {
            $conexion = new PDO($hostDB,$dbUser,$dbPass);
            $conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conexion;
        } catch(PDOException $e) {
            die('ERROR: '.$e->getMessage());
        }
    }

    #Filtro de seguridad de datos del formulario
    function secure_data($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    function hash_pass($pass){
        return password_hash($pass, PASSWORD_DEFAULT);
    }
?>
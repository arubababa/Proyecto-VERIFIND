<?php
    ob_start();
    session_start();

    if(!isset($_SESSION['valid'])){
        header('Location: pagina_principal2.php');
    }
?>
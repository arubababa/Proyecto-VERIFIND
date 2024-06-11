<?php
    require_once('./login.class.php');

    if(isset($_POST['email']) && isset($_POST['pass'])){
        $login = new Login($_POST['email'], $_POST['pass']);
    } else {
        header('Location: login.html');
    }
?>
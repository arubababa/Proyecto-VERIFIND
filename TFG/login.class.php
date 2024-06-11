<?php
    require_once('functions.php');

    class Login{
        private $email;
        private $pass;
        private $connectionDB;

        public function __construct($email, $pass)
        {
            $this->email = secure_data($email);
            $this->pass = secure_data($pass);
            $this->connectionDB = connectionBD();

            if($this->check_email_exists()){
                 $passInDB = $this->get_pass_in_db();
                 $auth = password_verify($this->pass,$passInDB);
                 if($auth){
                    ob_start();
                    session_start();
                    $_SESSION['email'] = $this->email;
                    $_SESSION['valid'] = true;
                    header('Location: pagina_principal2.php');
                 } else {
                    header('Location: login.html');
                 }
            } else {
                header('Location: login.html');
            }


        }

        private function check_email_exists(){
			$stmt = $this->connectionDB->prepare('SELECT email FROM USUARIOS WHERE email=:email');
			$stmt->bindParam(':email',$this->email);
			$stmt->execute();
			
			$result = $stmt->fetch();
	
			if(isset($result['email'])){
	            return true;
	        } else {
	            return false;
	        }
		}

        private function get_pass_in_db(){
            $stmt = $this->connectionDB->prepare('SELECT pass FROM USUARIOS WHERE email=:email');
            $stmt->bindParam(':email',$this->email);
            $stmt->execute();

            $result = $stmt->fetch();

            return $result['pass'];
        }
    }

?>
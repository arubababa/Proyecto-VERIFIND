<?php
    require_once('functions.php');

    class Register{
        private $nombre;
        private $email;
        private $telefono;
        private $pass;
        private $connectionDB;
        private $result_register;

        public function __construct($nombre, $email, $telefono, $pass){
            $this->nombre = secure_data($nombre);
            $this->email = secure_data($email);
            $this->telefono = secure_data($telefono);
            $this->pass = secure_data($pass);
            $this->pass = hash_pass($pass, PASSWORD_BCRYPT);
            $this->connectionDB = connectionBD();

            try {
                if($this->check_email_exists()){
                    $this->result_register = false;
                } else {
                    $this->create_user();
                    $this->result_register = true;
                }
            } catch (Exception $e) {
                die('ERROR: '. $e->getMessage());
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
	
		private function create_user(){
			$stmt = $this->connectionDB->prepare('INSERT INTO USUARIOS (nombre, email, tlf, pass) 
                VALUES (:nombre,:email,:telefono,:pass)');
			$stmt->bindParam(':nombre',$this->nombre);
            $stmt->bindParam(':email',$this->email);
            $stmt->bindParam(':telefono',$this->telefono);
			$stmt->bindParam(':pass',$this->pass);
			$stmt->execute();
		}

		public function get_confirmation(){
			if($this->result_register){
				return 'Usuario creado con éxito';
			} else {
				return 'El email ya existe en el sistema';
			}
		}
	}
?>
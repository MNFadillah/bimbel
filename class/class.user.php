<?php
	class User
	{
		private $db;
		function __construct()
		{
			$database = new Database();
			$db = $database->Connect();
			$this->db = $db;
		}

		function login($email, $password){
			try {
				$statement = $this->db->prepare("SELECT * FROM user_account where email = :email and password = md5(:password)");
				$statement->execute(array(':password'=>$password, ':email' => $email));
				$data = $statement->fetch(PDO::FETCH_ASSOC);
				if($statement->rowCount() == 1){
					$_SESSION['userData'] = $data['email'];
					return true;
				}else{
					return false;
				}
			} catch (Exception $e) {
				return false;
			}
		}

		function isLoggedIn(){
			if(isset($_SESSION['userData'])){
				return true;
			}
			return false;
		}

		function logOut(){
			session_destroy();
			header("location:" . base_url());
		}
	}
?>
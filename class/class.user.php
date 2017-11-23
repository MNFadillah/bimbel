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
		public function add($email, $password){
			try {
				$stmt = $this->db->prepare("INSERT INTO user_account(email, password) VALUES (:email, md5(:password))");
				$stmt->bindparam(":email", $email);
				$stmt->bindparam(":password", $password);
				$stmt->execute();
				return true;
			} catch (PDOException $e) {
				// echo $e->getMessage();
				// print_r($stmt->errorInfo());
				if($stmt->errorInfo()[1] == 1062){
					$this->errorText = 'Email sudah terdaftar';
				}else{
					$this->errorText = $stmt->errorInfo()[2];
				}
				return false;
			}
		}
		
		public function getDataById($id = 0){
			$stmt = $this->db->prepare("SELECT * FROM user_account where id = :id");
			$stmt->execute(array(':id'=>$id));
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			return $data;
		}

		public function getDataByEmail($email = ''){
			$stmt = $this->db->prepare("SELECT * FROM user_account where email = :email");
			$stmt->execute(array(':email'=>$email));
			if ($stmt->rowCount()>0) {
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$data = $row;
				}
			} else {
				$data = null;
			}
			return $data;
		}

		public function list(){
			$stmt = $this->db->prepare("SELECT * FROM user_account");
			$stmt->execute();
			if($stmt->rowCount() > 0){
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					echo "
					<tr>
						<td>
							<button type='button' data-toggle='modal' data-target='#addBookDialog' data-id='$row[id]' class='openDialog btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>
							<a href='?page=akun&action=delete&id=$row[id]'><button class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button></a>
						</td>
						<td class='id'>$row[id]</td>
						<td class='email'>$row[email]</td>
						<td class='create_at'>$row[created_at]</td>
					</tr>
					";	
				}
			}else{
				echo "
				<tr>
				<td colspan='5' align='center'><h3>Data Kosong</h3></td>
				</tr>
				";
			}
		}

		public function edit($id, $email, $password)
		{
			try {
				$stmt = $this->db->prepare("UPDATE user_account set email = :email, password = :password WHERE id = :id");
				$stmt->bindparam(':email', $email);
				$stmt->bindparam(':password', $password);
				$stmt->bindparam(':id', $id);
				$stmt->execute();
				return true;
			} catch (PDOException $e) {
				// echo $e->getMessage();
				die();
				return false;
			}
		}

		public function delete($id){
			$stmt = $this->db->prepare("DELETE FROM user_account where id = :id");
			$stmt->execute(array(':id'=>$id));
			return true;
		}
}
?>
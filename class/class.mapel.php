<?php
	class Mapel
	{
		private $db;
		public $errorText;
		function __construct()
		{
			$database = new Database();
			$this->db = $database->Connect();
		}

		public function add($nama, $waktu){
			try {
				$stmt = $this->db->prepare("INSERT INTO mapel (nama, waktu) VALUES (:nama, :waktu)");
				$stmt->bindparam(":nama", $nama);
				$stmt->bindparam(":waktu", $waktu);
				$stmt->execute();
				return true;
			} catch (PDOException $e) {
				// echo $e->getMessage();
				// print_r($stmt->errorInfo());
				
				return false;
			}
		}

		public function list(){
			$stmt = $this->db->prepare("SELECT * FROM mapel");
			$stmt->execute();
			$data = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$data[] = $row;
			}
			return $data;
		}

		public function edit($id, $nama, $waktu)
		{
			try {
				$stmt = $this->db->prepare("UPDATE mapel set nama = :nama, waktu = :waktu WHERE id = :id");
				$stmt->bindparam(':nama', $nama);
				$stmt->bindparam(':waktu', $waktu);
				$stmt->bindparam(':id', $id);
				$stmt->execute();
				return true;
			} catch (PDOException $e) {
				echo $e->getMessage();
				return false;
			}
		}

		public function delete($id){
			$stmt = $this->db->prepare("DELETE FROM mapel where id = :id");
			$stmt->execute(array(':id'=>$id));
			$stmt = $this->db->prepare("DELETE FROM mapel_per_kelas where id_mapel=:id");
			$stmt->execute(array(':id'=>$id));
			return true;
		}
		
		public function getDataById($id = 0){
			$stmt = $this->db->prepare("SELECT * FROM mapel where id = :id");
			$stmt->execute(array(':id'=>$id));
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			return $data;
		}

		public function getDataByNama($nama = ''){
			$stmt = $this->db->prepare("SELECT * FROM mapel where nama like :nama");
			$stmt->execute(array(':nama'=>"%" . $nama . "%"));
			if($stmt->rowCount() > 0){
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$data[] = $row;
				}
			}else{
				$data = null;
			}
			return $data;
		}

		public function getAll(){
			$stmt = $this->db->prepare("SELECT * FROM mapel");
			$stmt->execute();
			if($stmt->rowCount() > 0){
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$data[] = $row;
				}
			}else{
				$data = null;
			}
			return $data;
		}
		
		public function count(){
			$stmt = $this->db->prepare("SELECT * FROM mapel");
			$stmt->execute();
			return $stmt->rowCount();
		}
	}
?>
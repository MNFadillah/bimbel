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
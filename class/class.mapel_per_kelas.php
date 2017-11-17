<?php
	class Mapel_per_kelas
	{
		private $db;
		public $errorText;
		function __construct()
		{
			$database = new Database();
			$this->db = $database->Connect();
		}

		public function getDataById($id = 0){
			$stmt = $this->db->prepare("SELECT * FROM mapel_per_kelas where id = :id");
			$stmt->execute(array(':id'=>$id));
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			return $data;
		}

		public function getDataByKelas($id_kelas=''){
			$stmt = $this->db->prepare("SELECT * FROM mapel_per_kelas WHERE id_kelas = :id_kelas ORDER BY id ASC");
			$stmt->bindparam(':id_kelas', $id_kelas);
			$stmt->execute();
			$data = array();
			if($stmt->rowCount() > 0){
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$data[] = $row;
				}
			}else{
				$data = null;
			}
			return $data;
		}
	}
?>
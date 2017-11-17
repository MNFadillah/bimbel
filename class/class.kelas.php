<?php
	class Kelas
	{
		private $db;
		public $errorText;
		function __construct()
		{
			$database = new Database();
			$this->db = $database->Connect();
		}
		
		public function getAll(){
			$stmt = $this->db->prepare("SELECT * FROM kelas");
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
		
		public function getDataById($id = 0){
			$stmt = $this->db->prepare("SELECT * FROM kelas where id = :id");
			$stmt->execute(array(':id'=>$id));
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			return $data;
		}

		public function getDataByNama($keterangan = ''){
			$stmt = $this->db->prepare("SELECT * FROM kelas where keterangan like :keterangan");
			$stmt->execute(array(':keterangan'=>"%" . $keterangan . "%"));
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
			$stmt = $this->db->prepare("SELECT * FROM kelas");
			$stmt->execute();
			return $stmt->rowCount();
		}

		public function getSiswaCount(){
			$stmt = $this->db->prepare("SELECT *, (select count(*) from siswa where siswa.id_kelas = kelas.id) as siswa FROM kelas");
			$stmt->execute();
			if($stmt->rowCount() > 0){
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$row['color'] = $this->rand_color();
					$data[] = $row;
				}
			}else{
				$data = null;
			}
			return $data;
		}

		private function rand_color() {
		    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
		}
	}
?>
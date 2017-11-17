<?php
	class Nilai
	{
		private $db;
		public $errorText;
		function __construct()
		{
			$database = new Database();
			$this->db = $database->Connect();
		}

		public function add($id_siswa, $id_mapel_per_kelas, $nilai){
			try {
				$stmt = $this->db->prepare("INSERT INTO nilai (id_siswa, id_mapel_per_kelas, nilai) VALUES (:id_siswa, :id_mapel_per_kelas, :nilai)");
				$stmt->bindparam(":id_siswa", $id_siswa);
				$stmt->bindparam(":id_mapel_per_kelas", $id_mapel_per_kelas);
				$stmt->bindparam(":nilai", $nilai);
				$stmt->execute();
				return $this->db->lastInsertId();;
			} catch (PDOException $e) {
				$this->errorText = $stmt->errorInfo()[2];
				return 0;
			}
		}
		
		public function getDataById($id = 0){
			$stmt = $this->db->prepare("SELECT * FROM nilai where id = :id");
			$stmt->execute(array(':id'=>$id));
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			return $data;
		}

		public function deleteByIdSiswa($id_siswa){
			try {
				$stmt = $this->db->prepare("DELETE FROM nilai where id_siswa = $id_siswa");
				$stmt->execute();
				return true;
			} catch (Exception $e) {
				return false;
			}
		}
	}
?>
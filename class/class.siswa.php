<?php
	class Siswa
	{
		private $db;
		public $errorText;
		function __construct()
		{
			$database = new Database();
			$this->db = $database->Connect();
		}

		public function add($nama, $email, $alamat, $id_kelas)
		{
			try {
				$stmt = $this->db->prepare("INSERT INTO siswa (nama, alamat, email, id_kelas) VALUES (:nama, :alamat, :email, :id_kelas)");
				$stmt->bindparam(":nama", $nama);
				$stmt->bindparam(":alamat", $alamat);
				$stmt->bindparam(":email", $email);
				$stmt->bindparam(":id_kelas", $id_kelas);
				$stmt->execute();
				return $this->db->lastInsertId();
			} catch (PDOException $e) {
				if($stmt->errorInfo()[1] == 1062){
					$this->errorText = 'Email sudah terdaftar';
				}else{
					$this->errorText = $stmt->errorInfo()[2];
				}
				return false;
			}
		}

		public function count()
		{
			$stmt = $this->db->prepare("SELECT * FROM siswa");
			$stmt->execute();
			return $stmt->rowCount();
		}
		
		public function getDataById($id = 0)
		{
			$stmt = $this->db->prepare("SELECT * FROM siswa where id = :id");
			$stmt->execute(array(':id'=>$id));
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			return $data;
		}

		public function getDataByIdKelas($id_kelas = 0)
		{
			$stmt = $this->db->prepare("SELECT siswa.*, kelas.keterangan FROM siswa
				LEFT JOIN kelas on siswa.id_kelas = kelas.id where siswa.id_kelas = :id_kelas");
			$stmt->execute(array(':id_kelas'=>$id_kelas));
			$data = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$data[] = $row;
			}
			return $data;
		}

		public function getDataByIdJoinKelas($id = 0)
		{
			$stmt = $this->db->prepare("SELECT siswa.*, kelas.keterangan FROM siswa
				LEFT JOIN kelas on siswa.id_kelas = kelas.id where siswa.id = :id");
			$stmt->execute(array(':id'=>$id));
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			return $data;
		}

		public function getDataByNama($nama = '')
		{
			$stmt = $this->db->prepare("SELECT * FROM siswa where nama like :nama");
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
			try {
				$stmt = $this->db->prepare("SELECT * FROM siswa ORDER BY created_at");
				$stmt->execute();
				$data = array();
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				 	$data[] = $row;
				 }
				 return $data;
			} catch (PDOException $e) {
				echo $e->getMessage();
				return null;
			}
		}

		public function get($limit = 0, $offset = 0)
		{
			try {
				// echo $limit;
				$stmt = $this->db->prepare("SELECT * FROM siswa ORDER BY created_at DESC LIMIT :limits, :offset");
				$stmt->bindparam(':limits', $limit, PDO::PARAM_INT);
				$stmt->bindparam(':offset', $offset, PDO::PARAM_INT);
				$stmt->execute();
				$data = array();
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				 	$data[] = $row;
				 }
				 // print_r($data);
				 return $data;
			} catch (PDOException $e) {
				echo $e->getMessage();
				return null;
			}
		}

		public function list()
		{
			$stmt = $this->db->prepare("SELECT siswa.id id, siswa.nama nama, siswa.email email, siswa.alamat alamat, siswa.id_kelas id_kelas, kelas.keterangan keterangan, kelas.kuota kuota FROM siswa LEFT JOIN kelas ON siswa.id_kelas = kelas.id GROUP BY siswa.id");
			$stmt->execute();
			$data = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$data[] = $row;
			}
			return $data;
		}

		public function edit($id, $nama, $alamat, $email)
		{
			try {
				$stmt = $this->db->prepare("UPDATE siswa set nama = :nama, alamat = :alamat, email = :email WHERE id = :id");
				$stmt->bindparam(':nama', $nama);
				$stmt->bindparam(':email', $email);
				$stmt->bindparam(':alamat', $alamat);
				$stmt->bindparam(':id', $id);
				$stmt->execute();
				return true;
			} catch (PDOException $e) {
				echo $e->getMessage();
				return false;
			}
		}

		public function delete($id)
		{
			$stmt = $this->db->prepare("DELETE FROM siswa where id = :id");
			$stmt->execute(array(':id'=>$id));
			return true;
		}
	}
?>
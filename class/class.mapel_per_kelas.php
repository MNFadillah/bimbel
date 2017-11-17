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

		public function add($id_kelas, $id_mapel){
			try {
				$stmt = $this->db->prepare("INSERT INTO mapel_per_kelas (id_kelas, id_mapel) VALUES (:id_kelas, :id_mapel)");
				$stmt->bindparam(":id_kelas", $id_kelas);
				$stmt->bindparam(":id_mapel", $id_mapel);
				$stmt->execute();
				return true;
			} catch (PDOException $e) {
				$this->errorText = $stmt->errorInfo()[2];
				return false;
			}
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

		public function getDataByKelasJoinMapel($id_kelas=''){
			$stmt = $this->db->prepare("SELECT * FROM mapel_per_kelas a LEFT JOIN mapel b on a.id_mapel = b.id WHERE a.id_kelas = :id_kelas ORDER BY a.id ASC");
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

		public function getDataByKelasAndMapel($id_kelas, $id_mapel){
			$stmt = $this->db->prepare("SELECT * FROM mapel_per_kelas WHERE id_kelas = :id_kelas AND id_mapel = :id_mapel");
			$stmt->bindparam(':id_kelas', $id_kelas);
			$stmt->bindparam(':id_mapel', $id_mapel);
			$stmt->execute();
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			return $data;
		}

		public function getNilaiFromKelasAndSiswa($id_kelas, $id_siswa){
			$stmt2 = $this->db->prepare("SELECT a.id, a.id_siswa, b.id_kelas, c.nama, d.nama mapel, d.waktu, a.nilai FROM nilai a 
				LEFT JOIN mapel_per_kelas b on a.id_mapel_per_kelas = b.id 
				LEFT JOIN siswa c on a.id_siswa = c.id 
				LEFT JOIN mapel d on b.id_mapel = d.id 
				WHERE b.id_kelas = :id_kelas AND a.id_siswa = :id_siswa");

			$stmt2->bindparam(':id_kelas', $id_kelas);
			$stmt2->bindparam(':id_siswa', $id_siswa);
			$stmt2->execute();
			$data = array();
			if($stmt2->rowCount() > 0){
				while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
					$data[] = $row;
				}
			}else{
				// echo $stmt2->queryString . "<br>";
				// echo $id_kelas . " " . $id_siswa;
				$data = null;
			}
			return $data;
		}

		public function getNilaiFromSiswa($id_siswa){
			$stmt2 = $this->db->prepare("SELECT a.id, a.id_siswa, b.id_kelas, c.nama, d.nama mapel, d.waktu, a.nilai FROM nilai a 
				LEFT JOIN mapel_per_kelas b on a.id_mapel_per_kelas = b.id 
				LEFT JOIN siswa c on a.id_siswa = c.id 
				LEFT JOIN mapel d on b.id_mapel = d.id 
				WHERE a.id_siswa = :id_siswa");

			$stmt2->bindparam(':id_siswa', $id_siswa);
			$stmt2->execute();
			$data = array();
			if($stmt2->rowCount() > 0){
				while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
					$data[] = $row;
				}
			}else{
				// echo $stmt2->queryString . "<br>";
				// echo $id_kelas . " " . $id_siswa;
				$data = null;
			}
			return $data;
		}

		public function getSiswaFromKelas($id_kelas){
			$stmt = $this->db->prepare("SELECT a.id, a.id_siswa, b.id_kelas, c.nama FROM nilai a
			 LEFT join mapel_per_kelas b on a.id_mapel_per_kelas = b.id
			 LEFT JOIN siswa c on a.id_siswa = c.id 
			 WHERE b.id_kelas = :id_kelas 
			 GROUP BY a.id_siswa");

			$stmt->bindparam(':id_kelas', $id_kelas);
			$stmt->execute();
			$data = array();
			if($stmt->rowCount() > 0){
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$nilai = $this->getNilaiFromKelasAndSiswa($id_kelas, $row['id_siswa']);
					$i = 1;
					foreach ($nilai as $key => $value) {
						$row["nilai$i"] = $value['nilai'];
						$i++;
					}
					// print_r($nilai);
					// die();
					$data[] = $row;
				}
			}else{
				$data = null;
			}
			return $data;
		}

		public function list(){
			$stmt = $this->db->prepare("SELECT DISTINCT * FROM mapel_per_kelas group by id_kelas");
			$stmt->execute();
			if($stmt->rowCount() > 0){
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$mapel = $this->getMapel($row['id_kelas']);
					$mapelString = json_decode($mapel['nama']);
					$kelas = $this->getKelas($row['id_kelas']);
					echo "
					<tr>
						<td>
							<!--<button type='button' data-toggle='modal' data-target='#addBookDialog' data-id='$row[id]' data-Mapel='$mapel[nama]' data-MapelId='$mapel[id]' data-kelas='$row[id_kelas]' data-page='mapel-kelas' class='openDialog btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>-->
							<a href='?page=mapel-kelas&action=delete&id=$row[id]'><button class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button></a>
						</td>
						<td class='id_kelas'>$kelas</td>
						<td class='id_mapel'>$mapelString</td>
					</tr>
					";	
				}
			}else{
				echo "
				<tr>
				<td colspan='4' align='center'><h3>Data Kosong</h3></td>
				</tr>
				";
			}
		}

		public function edit($id, $id_kelas_old, $id_kelas, $id_mapel_old, $id_mapel){
			try {
				$stmt = $this->db->prepare("UPDATE mapel_per_kelas set id_kelas = :id_kelas, id_mapel = :id_mapel WHERE id_kelas = :id_kelas_old AND id_mapel = :id_mapel_old AND id=:id");
				$stmt->bindparam(':id_kelas', $id_kelas);
				$stmt->bindparam(':id_mapel', $id_mapel);
				$stmt->bindparam(':id_kelas_old', $id_kelas_old);
				$stmt->bindparam(':id_mapel_old', $id_mapel_old);
				$stmt->bindparam(':id', $id);
				$stmt->execute();
				return true;
			} catch (PDOException $e) {
				echo $e->getMessage();
				return false;
			}
		}

		public function delete($id){
			$stmt = $this->db->prepare("DELETE FROM mapel_per_kelas where id = :id");
			$stmt->execute(array(':id'=>$id));
			return true;
		}

		private function getKelas($id_kelas = 0){
			$stmt = $this->db->prepare("SELECT * FROM kelas where id = :id_kelas");
			$stmt->execute(array(':id_kelas'=>$id_kelas));
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			return $data['keterangan'];
		}

		private function getMapel($id_kelas = 0){
			$dataMapelNama = array();
			$dataMapelId = array();
			$stmt = $this->db->prepare("SELECT * FROM mapel_per_kelas where id_kelas = :id_kelas");
			$stmt->execute(array(':id_kelas'=>$id_kelas));
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$stmt2 = $this->db->prepare("SELECT * FROM mapel where id = :id_mapel");
				$stmt2->execute(array(':id_mapel'=>$row['id_mapel']));
				$data = $stmt2->fetch(PDO::FETCH_ASSOC);;
				$dataMapelNama[] = $data['nama'];
				$dataMapelId[] = $data['id'];
			}
			$dataReturn = array();
			
			$dataReturn['nama'] = json_encode(implode($dataMapelNama, ', '));
			$dataReturn['id'] = json_encode($dataMapelId);
			return $dataReturn;
		}

		public function getMapelNotId($id_kelas=0)
		{
			$id_kelas = (int)$id_kelas;
			$stmt = $this->db->prepare("SELECT * FROM mapel_per_kelas where id_kelas = :id_kelas");
			$stmt->execute(array(':id_kelas'=>$id_kelas));
			$id_mapel = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$id_mapel[] = $row['id_mapel'];
			}
			$id_mapel_string = "(" . implode(',', $id_mapel) . ")";
			$id_mapel = array();
			try {
				$stmt = $this->db->prepare("SELECT * FROM mapel where id NOT IN $id_mapel_string");
				$stmt->execute();
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$id_mapel[] = $row;
				}
			} catch (PDOException $e) {
				$this->errorText = $stmt->errorInfo();
				print_r($this->errorText);
			}
			return $id_mapel;
		}
	}
?>
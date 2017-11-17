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

		public function add($keterangan, $kuota){
			try {
				$stmt = $this->db->prepare("INSERT INTO kelas (keterangan, kuota) VALUES (:keterangan, :kuota)");
				$stmt->bindparam(":keterangan", $keterangan);
				$stmt->bindparam(":kuota", $kuota);
				$stmt->execute();
				return true;
			} catch (PDOException $e) {
				// echo $e->getMessage();
				// print_r($stmt->errorInfo());
				
				return false;
			}
		}

		public function list(){
			$stmt = $this->db->prepare("SELECT * FROM kelas");
			$stmt->execute();
			if($stmt->rowCount() > 0){
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					echo "
					<tr>
						<td>
							<button type='button' data-toggle='modal' data-target='#addBookDialog' data-id='$row[id]' data-page='kelas' class='openDialog btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>
							<a href='?page=kelas&action=delete&id=$row[id]'><button class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button></a>
						</td>
						<td class='id'>$row[id]</td>
						<td class='keterangan'>$row[keterangan]</td>
						<td class='kuota'>$row[kuota]</td>
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

		public function edit($id, $keterangan, $kuota)
		{
			try {
				$stmt = $this->db->prepare("UPDATE kelas set keterangan = :keterangan, kuota = :kuota WHERE id = :id");
				$stmt->bindparam(':keterangan', $keterangan);
				$stmt->bindparam(':kuota', $kuota);
				$stmt->bindparam(':id', $id);
				$stmt->execute();
				return true;
			} catch (PDOException $e) {
				echo $e->getMessage();
				return false;
			}
		}

		public function delete($id){
			$stmt = $this->db->prepare("DELETE FROM kelas where id = :id");
			$stmt->execute(array(':id'=>$id));
			return true;
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
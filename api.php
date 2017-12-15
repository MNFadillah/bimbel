<?php
require_once 'config/Database.php';

class Api
{
	var $limit  = 0;
	var $offset = 5;
	var $res 	= array();

	function __construct()
	{
		$this->res = array('message'=>'', 'status'=>true);
		if(isset($_GET["limit"])){
			$this->limit = (int)$_GET["limit"];
		}
		if(isset($_GET["offset"])){
			$this->offset = (int)$_GET["offset"];
		}
	}

	public function all()
	{
		include 'class/class.siswa.php';
		include 'class/class.kelas.php';
		include 'class/class.mapel_per_kelas.php';
		include 'class/class.mapel.php';
		include 'class/class.nilai.php';
		$siswa = new Siswa();
		$kelas = new Kelas();
		$mapel = new Mapel;
		$jumlahDataTiapModul = array("siswa"=>$siswa->count(), "kelas"=>$kelas->count(), "mapel"=>$mapel->count());
		$this->res["jumlah"] = $jumlahDataTiapModul;
	}

	public function siswa($fungsi)
	{
		include 'class/class.siswa.php';
		$siswa = new Siswa();
		if($fungsi == ""){
			$dataSiswa 	= $siswa->getAll();
			$jumlah 	= count($dataSiswa);
			$this->res = array("siswa"=>$dataSiswa, "jumlah"=>$jumlah);
		}else if($fungsi == "create"){
			$nama 		= $_POST["nama"]; 
			$email 		= $_POST["email"]; 
			$alamat 	= $_POST["alamat"];
			$id_kelas 	= $_POST["id_kelas"];

			$insertId 	= $siswa->add($nama, $email, $alamat, $id_kelas);
			if($insertId){
				$dataSiswa	= $siswa->getAll();

				$this->res = array('message'=>'Siswa berhasil ditambahkan', 'status'=>true, 'siswa'=>$dataSiswa);
			}else{
				$this->res = array('message'=>'Siswa gagal ditambahkan', 'status'=>false);
			}
		}else if($fungsi == "update"){
			$nama 	= $_POST['nama'];
			$email	= $_POST['email'];
			$alamat	= $_POST['alamat'];
			$id 	= $_POST['id'];

			$updateId = $siswa->edit($id, $nama, $alamat, $email);
			if($updateId){
				$dataSiswa	= $siswa->getDataById($id);
				$this->res = array('message'=>'Siswa berhasil diubah', 'status'=>true, 'siswa'=>$dataSiswa);
			}else{
				$this->res = array('message'=>'Siswa gagal diubah', 'status'=>false);
			}
		}else if($fungsi == "delete"){
			$id = $_POST['id'];

			$deleteId = $siswa->delete($id);
			if($deleteId){
				$dataSiswa = $siswa->getAll();
				$this->res = array('message'=>'Siswa berhasil dihapus', 'status'=>true, 'siswa'=>$dataSiswa);
			}else{
				$this->res = array('message'=>'Siswa gagal dihapus', 'status'=>false);
			}
		}else if($fungsi == "pagination"){
			// echo $this->limit;
			$dataSiswa = $siswa->get($this->limit, $this->offset);
			$jumlah = count($dataSiswa);
			$this->res = array("siswa"=>$dataSiswa, "jumlah"=>$jumlah);
		}else if($fungsi == "list"){
			$dataSiswa = $siswa->list();
			$jumlah = count($dataSiswa);
			$this->res = array("siswa"=>$dataSiswa, "jumlah"=>$jumlah);
		}
	}

	public function kelas($fungsi)
	{
		include 'class/class.kelas.php';
		$kelas = new Kelas();
		if($fungsi == ""){
			$dataKelas 	= $kelas->getAll();
			$jumlah 	= count($dataKelas);
			$this->res = array("siswa"=>$dataKelas, "jumlah"=>$jumlah);
		}else if($fungsi == "create"){
			$keterangan = $_POST["keterangan"];
			$kuota 		= $_POST["kuota"];

			$insertId 	= $kelas->add($keterangan, $kuota);
			if($insertId){
				$dataKelas	= $kelas->getDataById($id);
				$this->res 		= array('message'=>'Kelas berhasil ditambahkan', 'status'=>true, 'kelas'=>$dataKelas);
			}else{
				$this->res = array('message'=>'Kelas gagal ditambahkan', 'status'=>false);
			}
		}else if($fungsi == "update"){
			$id 		= $_POST['id'];
			$keterangan	= $_POST['keterangan'];
			$kuota		= $_POST['kuota'];

			$updateId = $kelas->edit($id, $keterangan, $kuota);
			if($updateId){
				$dataKelas	= $kelas->getDataById($id);
				$this->res = array('message'=>'Kelas berhasil diubah', 'status'=>true, 'kelas'=>$dataKelas);
			}else{
				$this->res = array('message'=>'Kelas gagal diubah', 'status'=>false);
			}
		}else if($fungsi == "delete"){
			$id = $_POST['id'];

			$deleteId = $kelas->delete($id);
			if($deleteId){
				$dataKelas = $kelas->getAll();
				$this->res = array('message'=>'Kelas berhasil dihapus', 'status'=>true, 'kelas'=>$dataKelas);
			}else{
				$this->res = array('message'=>'Kelas gagal dihapus', 'status'=>false);
			}
		}else if($fungsi == "pagination"){
			$dataKelas = $kelas->get($this->limit, $this->offset);
			$jumlah = count($dataKelas);
			$this->res = array("kelas"=>$dataKelas, "jumlah"=>$jumlah);
		}else if($fungsi == "get-jumlah-siswa-per-kelas"){
			$dataSiswaPerKelas = $kelas->getSiswaCount();
			$this->res = array("dataSiswaPerKelas"=>$dataSiswaPerKelas);
		}
	}
}

$modul = "";
if(isset($_GET["modul"])){
	$modul = $_GET["modul"];
}
$fungsi = "";
if(isset($_GET["fungsi"])){
	$fungsi = $_GET["fungsi"];
}

$res = array();
$api = new Api();

if($modul == "all"){
	$api->all();
}elseif($modul == "siswa"){
	$api->siswa($fungsi);
}else if($modul == "kelas"){
	$api->kelas($fungsi);
}
// echo $test;
header("Content-type: application/json");
echo json_encode($api->res);
die();
<?php
	require_once '../../config/Database.php';
  	require_once '../../class/class.kelas.php';
  	$kelas = new Kelas;
	$id_kelas = $_POST['id_kelas'];
	$data = $kelas->getDataById($id_kelas);
	$dataKelas = $kelas->getAll();
	foreach ($dataKelas as $key => $value) {
		if($value['id'] == $data['id']){
			echo "<option value='$value[id]' selected>$value[keterangan]</option>";
		}else{
			echo "<option value='$value[id]'>$value[keterangan]</option>";
		}
	}
?>
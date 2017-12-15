<?php
	require_once '../../config/Database.php';
  	require_once '../../class/class.kelas.php';
  	$kelas = new Kelas;
	$id_kelas = $_POST['id_kelas'];
	$data = $kelas->getDataById($id_kelas);
	$dataKelas = $kelas->getAll();
	foreach ($dataKelas as $key => $value) {
		echo "<tr>";
		echo "<td>$value[id]</td>";
		echo "<td>$value[keterangan]</td>";
		echo "<td>$value[kuota]</td>";
		echo "</tr>";
	}
?>
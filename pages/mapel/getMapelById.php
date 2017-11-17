<?php
	require_once '../../config/Database.php';
  	require_once '../../class/class.mapel.php';
  	require_once '../../class/class.mapel_per_kelas.php';
  	$mapel = new Mapel;
  	$mapel_kelas = new Mapel_per_kelas;
  	$mapelAll = $mapel->getAll();
	$mapelId = $_POST['id_mapel'];
	$kelasId = $_POST['id_kelas'];
	$mapelData = array();

	foreach ($mapelId as $key) {
		$mapelData[] = $mapel->getDataById($key);
	}
	$i=0;
	foreach ($mapelData as $key => $value) {
		$idMK = $mapel_kelas->getDataByKelasAndMapel($kelasId, $value['id']);
		echo "<input type='hidden' name='mapel[$i][idMK]' value='$idMK[id]'>";
		echo "<input type='hidden' name='mapel[$i][old]' value='$value[id]' />";
		echo "<select name='mapel[$i][new]' class='form-control' required>";
		foreach ($mapelAll as $field => $content) {
			if($value['id'] == $content['id']){
				echo "<option value='$content[id]' selected>$content[nama]</option>";
			}else{
				echo "<option value='$content[id]'>$content[nama]</option>";
			}
		}
		$i++;
		echo "</select><br />";
	}
	// print_r($mapelData);
?>
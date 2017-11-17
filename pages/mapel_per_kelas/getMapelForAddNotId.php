<?php
	require_once '../../config/Database.php';
	require_once '../../class/class.mapel_per_kelas.php';
	$mapel_kelas = new Mapel_per_kelas;
	$id_kelas = $_POST['id_kelas'];
	$dataMapel = $mapel_kelas->getMapelNotId($id_kelas);
  // print_r($dataMapel);
  // die();
  foreach ($dataMapel as $key => $value) {
?>
<option value="<?php echo $value['id'] ;?>">
  <?php echo $value['nama']; ?>
</option>
<?php 
  }
?>
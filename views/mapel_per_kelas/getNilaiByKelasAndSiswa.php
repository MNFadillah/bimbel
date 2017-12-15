<?php
	require_once '../../config/Database.php';
	require_once '../../class/class.mapel_per_kelas.php';
	require_once '../../class/class.siswa.php';
	$mapel_kelas = new Mapel_per_kelas;
	$id_kelas = $_POST['id_kelas'];
  $id_siswa = $_POST['id_siswa'];
	$dataNilai = $mapel_kelas->getNilaiFromKelasAndSiswa($id_kelas, $id_siswa);
  // print_r($dataNilai);
  // die();
  $i = 0;
	foreach ($dataNilai as $key => $value) {
?>
<div class="form-group">
  <label  for="inputNilai1" class="control-label col-md-3"><?php echo $value['mapel'];?></label>
  <div class="col-md-8">
    <input type="hidden" name="data[<?php echo $i;?>][id]" value="<?php echo $value['id'];?>">
    <input type="number" name="data[<?php echo $i;?>][nilai]" class="form-control" id="inputNilai1" required placeholder="Masukkan Nilai 1" value="<?php echo $value['nilai'];?>">
  </div>
</div>
<?php
  $i++;
  }
?>
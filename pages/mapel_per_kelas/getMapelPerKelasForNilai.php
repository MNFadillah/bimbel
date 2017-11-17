<?php
	require_once '../../config/Database.php';
  require_once '../../config/function.php';
  require_once '../../class/class.mapel_per_kelas.php';
  require_once '../../class/class.siswa.php';
  $mapel_kelas = new Mapel_per_kelas;
	$id_kelas = $_POST['id_kelas'];
	$dataMapel = $mapel_kelas->getDataByKelasJoinMapel($id_kelas);
	$dataSiswa = $mapel_kelas->getSiswaFromKelas($id_kelas);
	//$dataSiswa = $kelas->getAll();
?>
<thead>
  <tr>
    <th></th>
    <th>ID Siswa</th>
    <th>Nama Siswa</th>
    <?php
    	$i = 1;
    	foreach ($dataMapel as $key => $value) {
    		echo "<th>";
    		echo "$value[nama]";
    		// print_r($value);
    		echo "</th>";
    		$i++;
    	}
    ?>
  </tr>
</thead>
<tbody>
<?php
	foreach ($dataSiswa as $key => $value) {
    echo "<tr>";
    ?>
    <td>
      <button type='button' data-toggle='modal' data-target='#addBookDialog' class='editDialog btn btn-primary' data-id-siswa='<?php echo $value['id_siswa'];?>' data-nama-siswa='<?php echo $value['nama']; ?>' data-kelas='<?php echo $value['id_kelas'];?>' data-page='nilai' onclick='getNilai(this)'>
        <span class='fa fa-pencil'></span>
      </button>
      <button onclick='cetak(<?php echo $value['id_siswa'];?>)' type='button' class='btn btn-success'>
        <span class='fa fa-print'></span>
      </button>
    </td>
    <?php
    // echo "<td>$value[id_siswa]</td>";
		echo "<td>$value[id_siswa]</td>";
		echo "<td>$value[nama]</td>";
		for ($j=1; $j <$i ; $j++) { 
			$field = "nilai$j";
			echo "<td>$value[$field]</td>";
		}
    echo "</tr>";
	}
?>
</tbody>

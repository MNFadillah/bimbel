<?php
	require_once 'config/Database.php';
	require_once 'class/class.mapel_per_kelas.php';
	require_once 'class/class.siswa.php';
	require_once 'config/library/fpdf.php';
	$siswa = new Siswa;
	$mapel_kelas = new Mapel_per_kelas;
	$id_kelas = $_GET['id'];
	$dataSiswaAll = $siswa->getDataByIdKelas($id_kelas);

	$pdf = new FPDF();
	foreach ($dataSiswaAll as $key => $value) {
		$dataSiswa = $siswa->getDataByIdJoinKelas($value['id']);
		$dataNilai = $mapel_kelas->getNilaiFromSiswa( $value['id']);
		$tanggal = date('d F Y');
		// echo "Nama Siswa : " . $dataSiswa['nama'] . "<br>";
		// foreach ($dataNilai as $key => $value) {
		// 	echo $value['mapel'] . " : " . $value['nilai'] . "<br />";
		// }
		?>

		<?php
		$pdf->SetTopMargin(20);
		$pdf->SetLeftMargin(20);
		$pdf->AddPage('P','A4');
		$pdf->SetFont('times','B',14);
		$fullWidth = $pdf->GetPageWidth()-40; 
		$pdf->Cell($fullWidth,7,'DAFTAR NILAI',0,1,'C');
		$pdf->Cell($fullWidth,7,'HASIL EVALUASI BELAJAR LEMBAGA BIMBINGAN AMANAH',0,1,'C');
		$pdf->Cell($fullWidth,7,'TAHUN AJARAN 2017/2018',0,1,'C');
		$pdf->ln();
		$pdf->setX(40);
		$pdf->SetFont('times','',12);
		$pdf->Cell(25,7,'No. Induk ',0,0,'L');
		$pdf->Cell(5,7,' : ',0,0,'C');
		$pdf->Cell(100,7,$dataSiswa['id'],0,2,'L');
		$pdf->setX(40);
		$pdf->Cell(25,7,'Nama ',0,0,'L');
		$pdf->Cell(5,7,' : ',0,0,'C');
		$pdf->Cell(100,7,$dataSiswa['nama'],0,2,'L');
		$pdf->setX(40);
		$pdf->Cell(25,7,'Alamat ',0,0,'L');
		$pdf->Cell(5,7,' : ',0,0,'C');
		$pdf->Cell(100,7,$dataSiswa['alamat'],0,2,'L');
		$pdf->setX(40);
		$pdf->Cell(25,7,'Kelas ',0,0,'L');
		$pdf->Cell(5,7,' : ',0,0,'C');
		$pdf->Cell(100,7,$dataSiswa['keterangan'],0,1,'L');
		$pdf->ln(10);
		$pdf->Cell(100,7,'Daftar Nilai Mata Pelajaran yang diperoleh pada semester ini',0,1,'L');
		$pdf->Cell(25,7,'No. Urut',1,0,'C');
		$pdf->Cell(120,7,'Mata Pelajaran ',1,0,'C');
		$pdf->Cell(25,7,'Nilai ',1,1,'C');
		$i = 1;
		$total = 0;
		foreach ($dataNilai as $filed => $content) {
			$pdf->Cell(25,7,$i,1,0,'C');
			$pdf->Cell(120,7,$content['mapel'],1,0,'L');
			$pdf->Cell(25,7,$content['nilai'],1,1,'C');
			$total+=$content['nilai'];
			$i++;
		}
		$rata = round($total/($i-1));
		$pdf->Cell(145, 7, ' Total', 1, 0, 'L');
		$pdf->Cell(25,7,$total,1,1,'C');
		$pdf->Cell(145, 7, ' Rata-rata', 1, 0, 'L');
		$pdf->Cell(25,7,$rata,1,1,'C');
		$pdf->ln(20);
		$pdf->setX(110);
		$pdf->Cell(80,7,"Surabaya, $tanggal",0,2,'C');
		$pdf->Cell(80,7,"Wali Kelas $dataSiswa[keterangan]",0,2,'C');
		$pdf->ln(25);
		$pdf->setX(110);
		$pdf->SetFont('times','BU',12);
		$pdf->Cell(80,7,"Ir. Bambang Wahyudi S.Kom, M.Kom",0,1,'C');
		// $pdf->Cell($fullWidth,7,'HASIL EVALUASI BELAJAR LEMBAGA BIMBINGAN AMANAH',0,1,'C');
		// $pdf->Cell($fullWidth,7,'HASIL EVALUASI BELAJAR LEMBAGA BIMBINGAN AMANAH',0,1,'C');
	}
	$pdf->Output('I', 'test.pdf');
?>
<?php
  require_once 'class/class.siswa.php';
  require_once 'class/class.kelas.php';
  require_once 'class/class.mapel_per_kelas.php';
  require_once 'class/class.mapel.php';
  require_once 'class/class.nilai.php';
  $siswa = new Siswa;
  $kelas = new Kelas;
  $mapel = new Mapel;
  $mapel_kelas = new Mapel_per_kelas;
  $nilai = new Nilai;
  $jumlah = array('siswa' => $siswa->count(), 'kelas'=> $kelas->count(), 'mapel' => $mapel->count());

  $siswaBaru = $siswa->get(0,5);
  $jumlahSiswaKelas = $kelas->getSiswaCount();
  $jumlahSiswaPerKelas = json_encode($jumlahSiswaKelas);
?>
<div class="row">
	<div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Siswa</span>
          <span class="info-box-number"><?php echo $jumlah['siswa'];?></span>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-table"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Kelas</span>
          <span class="info-box-number"><?php echo $jumlah['kelas'];?></span>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-book"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Mata Pelajaran</span>
          <span class="info-box-number"><?php echo $jumlah['mapel'];?></span>
        </div>
      </div>
    </div>

</div>

<div class="row">
	<div class="col-md-8">
		<div class="box box-info">
	    <div class="box-header with-border">
	      <h3 class="box-title">Siswa Terbaru</h3>

	      <div class="box-tools pull-right">
	        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	        </button>
	        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
	      </div>
	    </div>
	    <!-- /.box-header -->
	    <div class="box-body">
	      <div class="table-responsive">
	        <table class="table no-margin">
	          <thead>
	          <tr>
	            <th>ID Siswa</th>
	            <th>Nama</th>
	            <th>Alamat</th>
	            <th>Dibuat pada</th>
	          </tr>
	          </thead>
	          <tbody>
	          	<?php 
	          		foreach ($siswaBaru as $key => $value) {
	          			echo "
	          				<tr>
	          					<td>$value[id]</td>
	          					<td>$value[nama]</td>
	          					<td>$value[alamat]</td>
	          					<td>$value[created_at]</td>
	          				</tr>
	          			";
	          		}
	          	?>
	          </tbody>
	        </table>
	      </div>
	      <!-- /.table-responsive -->
	    </div>
	    <!-- /.box-body -->
	    <div class="box-footer clearfix">
	      <a href="<?php echo base_url();?>?page=siswa" class="btn btn-sm btn-primary btn-flat pull-right">Lihat Semua Siswa</a>
	    </div>
	    <!-- /.box-footer -->
	  </div>
	</div>
	<div class="col-md-4">
		<div class="box box-danger">
      <div class="box-header with-border">
        <h3 class="box-title">Jumlah Siswa Per Kelas</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-8">
            <div class="chart-responsive">
              <canvas id="pieChart" height="150"></canvas>
            </div>
            <!-- ./chart-responsive -->
          </div>
          <!-- /.col -->
          <div class="col-md-4">
            <ul class="chart-legend clearfix">
            	<?php
            		foreach ($jumlahSiswaKelas as $key => $value) {
            			echo "<li><i class='fa fa-circle-o' style='color: $value[color]'></i> $value[keterangan]</li>";
            		}
            	?>
            </ul>
          </div>
        </div>
      </div>

      <!-- /.box-body -->
      <div class="box-footer no-padding">
        <ul class="nav nav-pills nav-stacked">
        	<?php
        		foreach ($jumlahSiswaKelas as $key => $value) {
        			echo "<li><a href='#'>$value[keterangan]<span class='pull-right' style='color: $value[color]'>$value[siswa] Siswa</span></a></li>";
        		}
        	?>
        </ul>
      </div>
    </div>
	</div>
</div>

<script>
	function getRandomColor() {
	  var letters = '0123456789ABCDEF';
	  var color = '#';
	  for (var i = 0; i < 6; i++) {
	    color += letters[Math.floor(Math.random() * 16)];
	  }
	  return color;
	}
    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var data = <?php echo $jumlahSiswaPerKelas;?>;
    var label = [];
    for (var i = 0; i < data.length; i++) {
    	let warna = data[i].color;
    	label[i] = {value:data[i].siswa, color:warna, highlight:warna, label:data[i].keterangan};
    }
    console.log(label);
    var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas);
    var PieData = label;
    var pieOptions = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke: true,
      //String - The colour of each segment stroke
      segmentStrokeColor: "#fff",
      //Number - The width of each segment stroke
      segmentStrokeWidth: 1,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps: 100,
      //String - Animation easing effect
      animationEasing: "easeOutBounce",
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate: true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale: false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: false,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>",
      //String - A tooltip template
      tooltipTemplate: "<%=label%>, siswa : <%=value %> "
    };
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions);
    //-----------------
    //- END PIE CHART -
    //-----------------
</script>
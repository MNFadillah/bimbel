<div id="block-dashboard">
  <div class="row">
  	<div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Siswa</span>
            <span class="info-box-number">{{ jumlahDataTiapModul.siswa }}</span>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-red"><i class="fa fa-table"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Kelas</span>
            <span class="info-box-number">{{ jumlahDataTiapModul.kelas }}</span>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-green"><i class="fa fa-book"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Mata Pelajaran</span>
            <span class="info-box-number">{{ jumlahDataTiapModul.mapel }}</span>
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
  	          <tbody v-for="siswa in dataSiswa">
        				<tr>
        					<td>{{ siswa.id }}</td>
        					<td>{{ siswa.nama }}</td>
        					<td>{{ siswa.alamat }}</td>
        					<td>{{ siswa.created_at }}</td>
        				</tr>
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
              <ul class="chart-legend clearfix" v-for="jumlahSiswa in dataJumlahSiswaPerKelas">
              	<li><i :style="{ color: jumlahSiswa.color }" class='fa fa-circle-o'></i> {{ jumlahSiswa.keterangan }}</li>
              </ul>
            </div>
          </div>
        </div>

        <!-- /.box-body -->
        <div class="box-footer no-padding">
          <ul class="nav nav-pills nav-stacked" v-for="jumlahSiswa in dataJumlahSiswaPerKelas">
          	<li><a href='#'>{{ jumlahSiswa.keterangan }}<span class='pull-right' :style="{ color: jumlahSiswa.color }">{{ jumlahSiswa.siswa }} Siswa</span></a></li>
          </ul>
        </div>
      </div>
  	</div>
  </div>
</div>
<script type="text/javascript">
  var dashboardApp = new Vue({
    el: "#block-dashboard",
    data: {
      dataSiswa: [],
      dataJumlahSiswaPerKelas: [],
      jumlahDataTiapModul:{siswa: 0, kelas:0, mapel:0},
    },
    mounted: function(){
      this.getSiswa();
      this.getJumlahSiswaPerKelas();
      this.getJumlahDataTiapModul();
    },
    methods: {
      getSiswa: function(){
        axios.get("<?php echo base_url();?>api.php?modul=siswa&fungsi=pagination")
        .then(function(response){
          if(!response.data.error){
            dashboardApp.dataSiswa = response.data.siswa;
          }
        });
      },
      getJumlahSiswaPerKelas: function(){
        axios.get("<?php echo base_url();?>api.php?modul=kelas&fungsi=get-jumlah-siswa-per-kelas")
        .then(function(response){
          if(!response.data.error){
            dashboardApp.dataJumlahSiswaPerKelas = response.data.dataSiswaPerKelas;
            initChart(dashboardApp.dataJumlahSiswaPerKelas);
          }
        });
      },
      getJumlahDataTiapModul: function(){
        axios.get("<?php echo base_url();?>api.php?modul=all")
        .then(function(response){
          if(!response.data.error){
            dashboardApp.jumlahDataTiapModul = response.data.jumlah;
          }
        });
      }
    }
  });
  // console.log(dashboardApp.dataJumlahSiswaPerKelas);

	function getRandomColor() {
	  var letters = '0123456789ABCDEF';
	  var color = '#';
	  for (var i = 0; i < 6; i++) {
	    color += letters[Math.floor(Math.random() * 16)];
	  }
	  return color;
	}

  function initChart(dataJumlahSiswaPerKelas){
    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var data = dataJumlahSiswaPerKelas;
    var label = [];
    for (var i = 0; i < data.length; i++) {
    	let warna = data[i].color;
    	label[i] = {value:data[i].siswa, color:warna, highlight:warna, label:data[i].keterangan};
    }
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
  }
</script>
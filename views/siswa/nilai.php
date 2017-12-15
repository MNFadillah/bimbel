<?php
  require_once 'class/class.siswa.php';
  require_once 'class/class.kelas.php';
  require_once 'class/class.nilai.php';
  $siswa = new Siswa;
  $kelas = new Kelas;
  $nilai = new Nilai;

  $dataKelas = $kelas->getAll();

  if(isset($_POST['btnEditNilai'])){
    $data = $_POST['data'];
    foreach ($data as $key => $value) {
      $nilai->edit($value['id'], $value['nilai']);
    }
  }
?>
<section class="content">
  <div class="row">
    <div class="col-lg-6">
      <div class="box box-solid bg-green">
        <div class="box-header">
          <!-- tools box -->
          <div class="pull-right box-tools">
            <button type="button" class="btn btn-success btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
              <i class="fa fa-minus"></i>
            </button>
          </div>
          <!-- /. tools -->

          <i class="fa fa-search"></i>

          <h3 class="box-title">
            Cari Kelas
          </h3>
        </div>
        <form role="form" id="formInput" class="form-horizontal" action="#" method="post">
          <div class="box-body border-radius-none">
            <div class="form-group">
              <label  for="inputKelas" class="control-label col-md-3">Kelas</label>
              <div class="col-md-8">
                <select class="form-control" name="id_kelas" id="inputKelas">
                  <?php 
                    foreach ($dataKelas as $key => $value) {
                      echo "<option value='$value[id]'>$value[keterangan]</option>'";
                    }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-11">
                <!-- Progress bars -->
                <div class="clearfix">
                  <button type="button" id="btnSearch" name="btnSearch" class="btn btn-success pull-right" style="background: white; color: green;"><i class="fa fa-search"></i> Search</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">Data Siswa</h3>
          <button class="btn btn-success pull-right" id="btnCetak" onclick="cetakAll(<?php if(isset($id_kelas)){echo $id_kelas;} ?>)"><span class="fa fa-print"></span> Cetak Nilai Kelas</button>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example" class="table table-bordered table-hover">
            
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="addBookDialog" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close" data-dismiss="modal">×</button>
        <h3>Edit Siswa</h3>
      </div>
      <form class="form-horizontal" action="" id="formEdit" method="post">
      <div class="modal-body">
        <input type="hidden" name="id_siswa" class="form-control" id="id_siswa">
        <div class="row">
          <div class="form-group">
            <label  for="inputNamaEdit" class="control-label col-md-3">Nama Siswa</label>
            <div class="col-md-8">
              <input type="text" name="nama" class="form-control" id="inputNamaEdit" required placeholder="Masukkan Nama Siswa" disabled>
            </div>
          </div>
        </div>
        <div class="row" id="nilai">
          <div class="form-group">
            <label  for="inputNilai1" class="control-label col-md-3">Nilai 1</label>
            <div class="col-md-8">
              <input type="number" name="nilai1" class="form-control" id="inputNilai1" required placeholder="Masukkan Nilai 1">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="btnEditNilai">Edit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>
<div class="row" id="printResult">
</div>

<script type="text/javascript">
	$('#btnSearch').click(function () {
		var kelas = $('#inputKelas').val();
		$.ajax({
          type: "POST",
          url: '<?php echo base_url();?>views/mapel_per_kelas/getMapelPerKelasForNilai.php',
          data: { id_kelas:kelas }, 
          success: function(result){
              $('#example').html(result);
              let cetak = "cetakAll(" + kelas + ")";
              $('#btnCetak').attr("onclick", cetak);
          },
          error: function(xhr, textStatus, errorThrown){}
      });
	});

  function getNilai(data) {
    var kelas = $(data).attr("data-kelas");
    var siswa = $(data).attr("data-id-siswa");
    var nama = $(data).attr("data-nama-siswa");
    $("#inputNamaEdit").val(nama);
    $.ajax({
      type: "POST",
      url:"<?php echo base_url();?>views/mapel_per_kelas/getNilaiByKelasAndSiswa.php",
      data: {id_kelas:kelas, id_siswa:siswa},
      success: function(data){
        $('#nilai').html(data);
      },
      error:function(xhr, textStatus, errorThrown){}
    });
  }

  function cetak(id){
    window.open('http://localhost/bimbel/?page=nilai&action=print&id='+id, '_blank');
    // $.ajax({
    //     type: "POST",
    //     url: '<?php echo base_url();?>views/siswa/cetak.php',
    //     data: { id_siswa:id }, 
    //     success: function(result){
    //       // $('iframe#printResult').contents().find("body").html(result);
    //         $('#printResult').html(result);
    //     },
    //     error: function(xhr, textStatus, errorThrown){}
    // });
  }
  function cetakAll(id){
    window.open('http://localhost/bimbel/?page=nilai&action=print_all&id='+id, '_blank');
  }
</script>
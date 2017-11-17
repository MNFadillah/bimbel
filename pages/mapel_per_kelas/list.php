<?php
  require_once 'class/class.mapel.php';
  require_once 'class/class.kelas.php';
  require_once 'class/class.mapel_per_kelas.php';
  $mapel = new Mapel;
  $kelas = new Kelas;
  $mapel_kelas = new Mapel_per_kelas;
  $dataKelas = $kelas->getAll();
  $dataMapel = $mapel->getAll();
  $sukses = ' ';
  $cariOutput = '';
  $aksi = '';
  if($action == 'delete'){
        $id = $_GET['id'];
        $mapel_kelas->delete($id);
        $sukses = true;
        $aksi = 'delete';
  }

  if(isset($_POST['btnSubmit'])){
    $id_mapel = htmlentities($_POST['id_mapel']);
    $id_kelas = htmlentities($_POST['id_kelas']);
    $insertId = $mapel_kelas->add($id_kelas, $id_mapel);
    if($insertId){
      $sukses = true;
      $aksi = 'add';
    }else{
      $sukses = false;
      $aksi = 'add';
    }
  }
  if(isset($_POST['btnCari'])){
    $id_kelas = htmlentities($_POST['id_kelas']);
    $dataSearch = $mapel_kelas->getDataByid_mapel($id_kelas);
    if($dataSearch != null){
      foreach ($dataSearch as $key => $value) {
        $cariOutput .= "<tr>";
        $cariOutput .= "<td>$value[id]</td>";
        $cariOutput .= "<td>$value[id_mapel]</td>";
        $cariOutput .= "<td>$value[id_kelas]</td>";
        $cariOutput .= "</tr>";
      }
    }else{
      $cariOutput = "<tr><td colspan='3' align='center'><h3>Tidak ditemukan</h3></td></tr>";
    }
  }
  if(isset($_POST['btnEdit'])){
    $id_kelas_old = htmlentities($_POST['id_kelas_old']);
    $id_kelas = htmlentities($_POST['id_kelas']);
    $mapelArray = $_POST['mapel'];
    foreach ($mapelArray as $key => $value) {
      $mapel_kelas->edit($value['idMK'], $id_kelas_old, $id_kelas, $value['old'], $value['new']);
    }
  }
?>
<section class="content">
  <div class="row">
    <?php
      if($sukses === true){
        if($aksi === 'add'){
            echo '
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
                  Berhasil menambahkan data mapel
                </div>';
        }else if($aksi === 'delete'){
            echo '
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
                  Berhasil menghapus data mapel
                </div>';
        }
      }else if($sukses === false && $aksi === 'add'){
        echo '
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
          Gagal menambahkan data mapel, ' . $mapel_kelas->errorText . '
        </div>
        ';
      }
    ?>
  </div>
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

          <i class="fa fa-plus"></i>

          <h3 class="box-title">
            Tambah Mata Pelajaran di Tiap Kelas
          </h3>
        </div>
        <form role="form" id="formInput" class="form-horizontal" action="" method="post">
          <div class="box-body border-radius-none">
            <div class="form-group">
              <label  for="inputkelas" class="control-label col-md-3">Kelas</label>
              <div class="col-md-8">
                <select name="id_kelas" class="form-control" id="inputkelas" required>
                  <?php
                    foreach ($dataKelas as $key => $value) {
                      echo "<option value='$value[id]'>$value[keterangan]</option>";
                    }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label  for="inputid_mapel" class="control-label col-md-3">Mata Pelajaran</label>
              <div class="col-md-8">
                <select class="form-control" id="inputid_mapel" name="id_mapel" required>
                  <?php
                    foreach ($dataMapel as $key => $value) {
                      echo "<option value='$value[id]'>$value[nama]</option>";
                    }
                  ?>
                </select>
              </div>
            </div>
          </div>
          <div class="box-footer text-black">
            <div class="row">
              <div class="col-sm-12">
                <!-- Progress bars -->
                <div class="clearfix">
                  <button type="submit" name="btnSubmit" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Tambah</button>
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
          <h3 class="box-title">Data mapel</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example2" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Action</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $mapel_kelas->list();
              ?>
            </tbody>
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
        <h3>Edit mapel</h3>
      </div>
      <div class="modal-body">
          <form class="form-horizontal" action="" id="formEdit" method="post">
              <input type="hidden" name="id_kelas_old" class="form-control" id="id_kelas_old" placeholder="Enter ID">
              <div class="form-group">
              <label  for="inputkelas" class="control-label col-md-3">Kelas</label>
              <div class="col-md-8">
                <select name="id_kelas" class="form-control" id="inputkelasEdit" required>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label  for="inputid_mapel" class="control-label col-md-3">Mata Pelajaran</label>
              <div class="col-md-8" id="blockInputMapelEdit">
              </div>
            </div>
              
              <div class="form-group"> 
                <label class="col-md-3"> </label>
                <div class="col-md-8">
                  <button type="submit" name="btnEdit" class="btn btn-primary">Edit</button>
                </div>
              </div>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
  $('.openDialog').click(function (evt) {
    var kelas = $(this).attr("data-kelas");
      var mapel = JSON.parse($(this).attr("data-MapelId"));
      $.ajax({
          type: "POST",
          url: '<?php echo base_url();?>pages/kelas/getKelasById.php',
          data: { id_kelas:kelas }, 
          success: function(data){
              $('#id_kelas_old').val( kelas );
              $('#inputkelasEdit').html(data);
          },
          error: function(xhr, textStatus, errorThrown){}
      });
      $.ajax({
          type: "POST",
          url: '<?php echo base_url();?>pages/mapel/getMapelById.php',
          data: { id_mapel:mapel, id_kelas:kelas }, 
          success: function(data){
              $('#blockInputMapelEdit').html(data);
          },
          error: function(xhr, textStatus, errorThrown){}
      });
  });

  $('#inputkelas').change(function (argument) {
    let idKelas = this.value;
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>pages/mapel_per_kelas/getMapelForAddNotId.php',
        data: { id_kelas:idKelas }, 
        success: function(data){
          $('#inputid_mapel').html(data);
        },
        error: function(xhr, textStatus, errorThrown){}
    });
  });
</script>
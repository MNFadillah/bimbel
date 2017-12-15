<?php
  require_once 'class/class.kelas.php';
  $kelas = new Kelas;
  $sukses = ' ';
  $cariOutput = '';
  $aksi = '';
  if($action == 'delete'){
        $id = $_GET['id'];
        $kelas->delete($id);
        $sukses = true;
        $pesan = "Berhasil menghapus kelas";
  }

  if(isset($_POST['btnSubmit'])){
    $keterangan = htmlentities($_POST['keterangan']);
    $kuota = htmlentities($_POST['kuota']);
    $insertId = $kelas->add($keterangan, $kuota);
    if($insertId){
      $sukses = true;
      $pesan = "Berhasil menambah kelas";
    }else{
      $sukses = false;
      $pesan = "Gagal menambah kelas";
    }
  }

  if(isset($_POST['btnEdit'])){
    $id = htmlentities($_POST['id']);
    $keterangan = htmlentities($_POST['keterangan']);
    $kuota = htmlentities($_POST['kuota']);
    $editStatus = $kelas->edit($id, $keterangan, $kuota);
    if($editStatus){
      $sukses = true;
      $pesan = "berhasil mengubah kelas";
    }else{
      $sukses = false;
      $pesan = "Gagal mengubah kelas";
    }
  }
?>
<section class="content">
  <div class="row">
    <?php
      if($sukses === true){
        echo '
            <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
              '.$pesan.'
            </div>';
      }else if($sukses === false){
        echo '
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
          '.$pesan.'
        </div>
        ';
      }
    ?>
  </div>
  <div class="row">
    <div class="col-lg-6">
      <div class="box box-solid bg-navy">
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
            Tambah kelas
          </h3>
        </div>
        <form role="form" id="formInput" class="form-horizontal" action="" method="post">
          <div class="box-body border-radius-none">
            <div class="form-group">
              <label  for="inputketerangan" class="control-label col-md-3">keterangan</label>
              <div class="col-md-8">
                <input type="text" name="keterangan" class="form-control" id="inputketerangan" required placeholder="Masukkan keterangan kelas">
              </div>
            </div>
            <div class="form-group">
              <label  for="inputkuota" class="control-label col-md-3">kuota</label>
              <div class="col-md-8">
                <input type="number" name="kuota" class="form-control" id="inputkuota" required placeholder="Masukkan kuota kelas" min="0">
              </div>
            </div>
           
          </div>
          <div class="box-footer text-black">
            <div class="row">
              <div class="col-sm-12">
                <!-- Progress bars -->
                <div class="clearfix">
                  <button type="submit" name="btnSubmit" class="btn btn-success pull-right" style="background-color: rgb(200,90,90);"><i class="fa fa-plus"></i> Tambah</button>
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
          <h3 class="box-title">Data kelas</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example2" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Action</th>
                <th>ID</th>
                <th>keterangan</th>
                <th>kuota</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $kelas->list();
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
        <h3>Edit kelas</h3>
      </div>
      <div class="modal-body">
          <form class="form-horizontal" action="" id="formEdit" method="post">
              <input type="hidden" name="id" class="form-control" id="idEdit" placeholder="Enter ID">
              <div class="form-group">
                <label  for="inputketeranganEdit" class="control-label col-md-3">keterangan</label>
                <div class="col-md-8">
                  <input type="text" name="keterangan" class="form-control" id="inputketeranganEdit" required placeholder="Masukkan keterangan kelas">
                </div>
              </div>
              <div class="form-group">
                <label  for="inputkuotaEdit" class="control-label col-md-3">kuota</label>
                <div class="col-md-8">
                  <input type="kuota" name="kuota" class="form-control" id="inputkuotaEdit" required placeholder="Masukkan kuota kelas">
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
  $('.openDialog').click(
  function (evt) {
    var id = $(this).attr("data-id");
    
    var keterangan = $(this).closest('tr').children('td.keterangan').text();
    var kuota= $(this).closest('tr').children('td.kuota').text();
    
    $("input#idEdit").val( id );
    $("input#inputketeranganEdit").val( keterangan );
    $("#inputkuotaEdit").val( kuota );
  });
</script>
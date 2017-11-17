<?php
  require_once 'class/class.siswa.php';
  require_once 'class/class.kelas.php';
  require_once 'class/class.mapel_per_kelas.php';
  require_once 'class/class.nilai.php';
  $siswa = new Siswa;
  $kelas = new Kelas;
  $mapel_kelas = new Mapel_per_kelas;
  $nilai = new Nilai;

  $dataKelas = $kelas->getAll();

  $sukses = ' ';
  $cariOutput = '';
  $aksi = '';
  if($action == 'delete'){
        $id = $_GET['id'];
        $deleteSiswa = $siswa->delete($id);
        if($deleteSiswa){
          $nilai->deleteByIdSiswa($id);
        }
        $sukses = true;
        $pesan = "Berhasil menghapus data siswa";
  }

  if(isset($_POST['btnSubmit'])){
    $nama = htmlentities($_POST['nama']);
    $email = htmlentities($_POST['email']);
    $alamat = htmlentities($_POST['alamat']);
    $id_kelas = htmlentities($_POST['id_kelas']);
    $insertId = $siswa->add($nama, $email, $alamat, $id_kelas);
    $pesan = "Berhasil menambah data siswa";
    if($insertId > 0){
      $dataMapelPerKelas = $mapel_kelas->getDataByKelas($id_kelas);
      foreach ($dataMapelPerKelas as $key => $value) {
        $nilai->add($insertId, $value['id'], 0);
      }
      $sukses = true;
    }else{
      $pesan = "Gagal menambah data siswa";
      $sukses = false;
    }
  }

  if(isset($_POST['btnEdit'])){
    $id = htmlentities($_POST['id']);
    $nama = htmlentities($_POST['nama']);
    $email = htmlentities($_POST['email']);
    $alamat = htmlentities($_POST['alamat']);
    $editStatus = $siswa->edit($id, $nama, $alamat, $email);
    $pesan = "Berhasil mengubah data siswa";
    if($editStatus){
      $sukses = true;
    }else{
      $pesan = "Gagal mengubah data siswa";
      $sukses = false;
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
                  '. $pesan .'
                </div>';
      }else if($sukses === false){
        echo '
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
          ' . $pesan . '
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
            Tambah Siswa
          </h3>
        </div>
        <form role="form" id="formInput" class="form-horizontal" action="" method="post">
          <div class="box-body border-radius-none">
            <div class="form-group">
              <label  for="inputNama" class="control-label col-md-3">Nama</label>
              <div class="col-md-8">
                <input type="text" name="nama" class="form-control" id="inputNama" required placeholder="Masukkan Nama Siswa">
              </div>
            </div>
            <div class="form-group">
              <label  for="inputEmail" class="control-label col-md-3">Email</label>
              <div class="col-md-8">
                <input type="email" name="email" class="form-control" id="inputEmail" required placeholder="Masukkan Email Siswa">
              </div>
            </div>
            <div class="form-group">
              <label  for="inputAlamat" class="control-label col-md-3">Alamat</label>
              <div class="col-md-8">
                <textarea class="form-control" name="alamat" id="inputAlamat">
                </textarea>
              </div>
            </div>
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
          </div>
          <div class="box-footer text-black">
            <div class="row">
              <div class="col-sm-12">
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
          <h3 class="box-title">Data Siswa</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example2" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Action</th>
                <th>ID</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Email</th>
                <th>Alamat</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $siswa->list();
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
        <h3>Edit Siswa</h3>
      </div>
      <div class="modal-body">
          <form class="form-horizontal" action="" id="formEdit" method="post">
              <input type="hidden" name="id" class="form-control" id="idEdit" placeholder="Enter ID">
              <div class="form-group">
                <label  for="inputNamaEdit" class="control-label col-md-3">Nama</label>
                <div class="col-md-8">
                  <input type="text" name="nama" class="form-control" id="inputNamaEdit" required placeholder="Masukkan Nama Siswa">
                </div>
              </div>
              <div class="form-group">
                <label  for="inputEmailEdit" class="control-label col-md-3">Email</label>
                <div class="col-md-8">
                  <input type="email" name="email" class="form-control" id="inputEmailEdit" required placeholder="Masukkan Email Siswa">
                </div>
              </div>
              <div class="form-group">
                <label  for="inputAlamatEdit" class="control-label col-md-3">Alamat</label>
                <div class="col-md-8">
                  <textarea class="form-control" name="alamat" id="inputAlamatEdit">
                    
                  </textarea>
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
    var nama = $(this).closest('tr').children('td.nama').text();
    var email = $(this).closest('tr').children('td.email').text();
    var alamat = $(this).closest('tr').children('td.alamat').text();
    
    $("input#idEdit").val( id );
    $("input#inputNamaEdit").val( nama );
    $("#inputEmailEdit").val( email );
    $("#inputAlamatEdit").html( alamat );
  });
</script>
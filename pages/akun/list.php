<?php
  require_once 'class/class.user.php';
  $user = new User;
  $sukses = ' ';
  $cariOutput = '';
  $aksi = '';
  if($action == 'delete'){
        $id = $_GET['id'];
        $user->delete($id);
        $sukses = true;
        $aksi = 'delete';
  }

  if(isset($_POST['btnSubmit'])){
    $email = htmlentities($_POST['email']);
    $password = htmlentities($_POST['password']);
    $insertId = $user->add($email, $password);
    if($insertId){
      $sukses = true;
      $aksi = 'add';
    }else{
      $sukses = false;
      $aksi = 'add';
    }
  }
/*  if(isset($_POST['btnCari'])){
    $email = htmlentities($_POST['email']);
    $dataSearch = $siswa->getDataByNama($email);
    if($dataSearch != null){
      foreach ($dataSearch as $key => $value) {
        $cariOutput .= "<tr>";
        $cariOutput .= "<td>$value[id]</td>";
        $cariOutput .= "<td>$value[email]</td>";
        $cariOutput .= "<td>$value[password]</td>";
        $cariOutput .= "<td>$value[created_at]</td>";
        $cariOutput .= "</tr>";
      }
    }else{
      $cariOutput = "<tr><td colspan='4' align='center'><h3>Tidak ditemukan</h3></td></tr>";
    }
  }
*/
  if(isset($_POST['btnEdit'])){
    $id = htmlentities($_POST['id']);
    $email= htmlentities($_POST['email']);
    $password = htmlentities($_POST['password']);
    $user->edit($id, $email, $password);
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
                  Berhasil menambahkan data user
                </div>';
        }else if($aksi === 'delete'){
            echo '
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
                  Berhasil menghapus data user
                </div>';
        }
      }else if($sukses === false && $aksi === 'add'){
        echo '
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
          Gagal menambahkan data user, ' . $user->errorText . '
        </div>
        ';
      }
    ?>
  </div>
  <div class="row">
    <div class="col-lg-6 col-sm-12" >
      <div class="box box-solid bg-green">
        <div class="box-header">
          <!-- tools box -->
          <div class="pull-right box-tools">
            <button type="button" class="btn btn-success btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
              <i class="fa fa-minus"></i>
            </button>
          </div>

          <i class="fa fa-plus"></i>

         <h3 class="box-title">
            Buat Akun Baru
          </h3>
        </div>
        <form role="form" id="formInput" class="form-horizontal" action="" method="post">
          <div class="box-body border-radius-none">

            <div class="form-group">
              <label  for="inputEmail" class="control-label col-md-3">Email</label>
              <div class="col-md-8">
                <input type="email" name="email" class="form-control" id="inputEmail" required placeholder="Masukkan Email">
              </div>
            </div>

            <div class="form-group">
              <label  for="inputPassword" class="control-label col-md-3">Password</label>
              <div class="col-md-8">
                <input type="password" name="password" class="form-control" id="inputPasword" required placeholder="Masukkan Email">
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
                <th>Email</th>
                <th>Dibuat pada</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $user->list();
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
        <h3>Edit Akun</h3>
      </div>
      <div class="modal-body">
          <form class="form-horizontal" action="" id="formEdit" method="post">
              <input type="hidden" name="id" class="form-control" id="idEdit" placeholder="Enter ID">
              <div class="form-group">
                <label  for="inputEmailEdit" class="control-label col-md-3">Email</label>
                <div class="col-md-8">
                  <input type="text" name="email" class="form-control" id="inputEmailEdit" required placeholder="Masukkan Email">
                </div>
              </div>
              <div class="form-group">
                <label  for="inputPasswordEdit" class="control-label col-md-3">Password</label>
                <div class="col-md-8">
                  <input type="password" name="password" class="form-control" id="inputPasswordEdit" required placeholder="Masukkan Password">
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
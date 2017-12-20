<?php
  require_once 'class/class.mapel.php';
  $mapel = new Mapel;
  $sukses = ' ';
  $cariOutput = '';
  $aksi = '';
  if($action == 'delete'){
        $id = $_GET['id'];
        $mapel->delete($id);
        $sukses = true;
        $aksi = 'delete';
  }

  if(isset($_POST['btnSubmit'])){
    $nama = htmlentities($_POST['nama']);
    $waktu = htmlentities($_POST['waktu']);
    $insertId = $mapel->add($nama, $waktu);
    if($insertId){
      $sukses = true;
      $aksi = 'add';
    }else{
      $sukses = false;
      $aksi = 'add';
    }
  }
  if(isset($_POST['btnCari'])){
    $nama = htmlentities($_POST['nama']);
    $dataSearch = $mapel->getDataBynama($nama);
    if($dataSearch != null){
      foreach ($dataSearch as $key => $value) {
        $cariOutput .= "<tr>";
        $cariOutput .= "<td>$value[id]</td>";
        $cariOutput .= "<td>$value[nama]</td>";
        $cariOutput .= "<td>$value[waktu]</td>";
        $cariOutput .= "</tr>";
      }
    }else{
      $cariOutput = "<tr><td colspan='3' align='center'><h3>Tidak ditemukan</h3></td></tr>";
    }
  }
  if(isset($_POST['btnEdit'])){
    $id = htmlentities($_POST['id']);
    $nama = htmlentities($_POST['nama']);
    $waktu = htmlentities($_POST['waktu']);
    $mapel->edit($id, $nama, $waktu);
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
          Gagal menambahkan data mapel, ' . $mapel->errorText . '
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
            Tambah mapel
          </h3>
        </div>
        <form role="form" id="formInput" class="form-horizontal" action="" method="post">
          <div class="box-body border-radius-none">
            <div class="form-group">
              <label  for="inputnama" class="control-label col-md-3">nama</label>
              <div class="col-md-8">
                <input type="text" name="nama" class="form-control" id="inputnama" required placeholder="Masukkan nama mapel">
              </div>
            </div>
            <div class="form-group">
              <label  for="inputwaktu" class="control-label col-md-3">waktu</label>
              <div class="col-md-8">
                <input type="waktu" name="waktu" class="form-control" id="inputwaktu" required placeholder="Masukkan waktu mapel">
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
                <th>ID</th>
                <th>nama</th>
                <th>waktu</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $dataMapel = $mapel->list();
                foreach ($dataMapel as $key => $row) { ?>
                  <tr>
                    <td>
                      <button type='button' data-toggle='modal' data-target='#addBookDialog' data-id='<?php echo $row["id"];?>' data-page='mapel' class='openDialog btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>
                      <button type="button" onclick="showAlert(<?php echo $row['id'];?>);" class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
                    </td>
                    <td class='id'><?php echo $row['id'];?></td>
                    <td class='nama'><?php echo $row['nama'];?></td>
                    <td class='waktu'><?php echo $row['waktu'];?></td>
                  </tr>
                <?php }
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
              <input type="hidden" name="id" class="form-control" id="idEdit" placeholder="Enter ID">
              <div class="form-group">
                <label  for="inputnamaEdit" class="control-label col-md-3">nama</label>
                <div class="col-md-8">
                  <input type="text" name="nama" class="form-control" id="inputnamaEdit" required placeholder="Masukkan nama mapel">
                </div>
              </div>
              <div class="form-group">
                <label  for="inputwaktuEdit" class="control-label col-md-3">waktu</label>
                <div class="col-md-8">
                  <input type="waktu" name="waktu" class="form-control" id="inputwaktuEdit" required placeholder="Masukkan waktu mapel">
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
    var waktu = $(this).closest('tr').children('td.waktu').text();
    
    $("input#idEdit").val( id );
    $("input#inputnamaEdit").val( nama );
    $("#inputwaktuEdit").val( waktu );
  });

  function showAlert(id) {
     swal({
          title: "Hapus data",
          text: "Anda yakin mau menghapus Mapel ini ?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, hapus!'
      }).then((result) => {
          if (result.value){
            location.href = "?page=mapel&action=delete&id=" + id;
          }
      });
  }
</script>
<?php
  require_once 'class/class.kelas.php';
  $kelas = new Kelas;

  $dataKelas = $kelas->getAll();
?>
<section class="content" id="siswa-container">
  <div class="row">
    <div class="col-lg-6">
      <div class="box box-solid bg-green">
        <div class="box-header">
          <div class="pull-right box-tools">
            <button type="button" class="btn btn-success btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
              <i class="fa fa-minus"></i>
            </button>
          </div>

          <i class="fa fa-plus"></i>

          <h3 class="box-title">
            Tambah Siswa
          </h3>
        </div>

        <form id="formInput" class="form-horizontal" action="#" method="post">
          <div class="box-body border-radius-none">
            <div class="form-group">
              <label  for="inputNama" class="control-label col-md-3">Nama</label>
              <div class="col-md-8">
                <input type="text" name="nama" class="form-control" id="inputNama" required placeholder="Masukkan Nama Siswa" v-model="newSiswa.nama">
              </div>
            </div>
            <div class="form-group">
              <label  for="inputEmail" class="control-label col-md-3">Email</label>
              <div class="col-md-8">
                <input type="email" name="email" class="form-control" id="inputEmail" required placeholder="Masukkan Email Siswa" v-model="newSiswa.email">
              </div>
            </div>
            <div class="form-group">
              <label  for="inputAlamat" class="control-label col-md-3">Alamat</label>
              <div class="col-md-8">
                <textarea class="form-control" name="alamat" id="inputAlamat" v-model="newSiswa.alamat"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label  for="inputKelas" class="control-label col-md-3">Kelas</label>
              <div class="col-md-8">
                <select class="form-control" name="id_kelas" id="inputKelas" v-model="newSiswa.kelas">
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
                  <button @click="addSiswa();" type="button" name="btnSubmit" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Tambah</button>
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
            <tbody v-for="row in siswa">
              <tr>
                <td>
                  <button type='button' data-toggle='modal' data-target='#editBookDialog' data-page='siswa' class='openDialog btn btn-primary btn-sm' @click="selectSiswa(row);">
                    <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                  </button>
                  <button class='btn btn-danger btn-sm' @click="selectSiswa(row);deleteSiswa();"><i class='fa fa-trash'></i></button>
                </td>
                <td class='id'>{{ row.id }}</td>
                <td class='nama'>{{ row.nama }}</td>
                <td class='kelas'>{{ row.keterangan }}</td>
                <td class='email'>{{ row.email }}</td>
                <td class='alamat'>{{ row.alamat }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="modal" id="editBookDialog" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button class="close" data-dismiss="modal">×</button>
          <h3>Edit Siswa</h3>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" action="#" id="formEdit" method="post">
                <input type="hidden" name="id" class="form-control" id="idEdit" placeholder="Enter ID" v-model="selectedSiswa.id">
                <div class="form-group">
                  <label  for="inputNamaEdit" class="control-label col-md-3">Nama</label>
                  <div class="col-md-8">
                    <input type="text" name="nama" class="form-control" id="inputNamaEdit" required placeholder="Masukkan Nama Siswa" v-model="selectedSiswa.nama">
                  </div>
                </div>
                <div class="form-group">
                  <label  for="inputEmailEdit" class="control-label col-md-3">Email</label>
                  <div class="col-md-8">
                    <input type="email" name="email" class="form-control" id="inputEmailEdit" required placeholder="Masukkan Email Siswa" v-model="selectedSiswa.email">
                  </div>
                </div>
                <div class="form-group">
                  <label  for="inputAlamatEdit" class="control-label col-md-3">Alamat</label>
                  <div class="col-md-8">
                    <textarea class="form-control" name="alamat" id="inputAlamatEdit" v-model="selectedSiswa.alamat">
                    </textarea>
                  </div>
                </div>
                <div class="form-group"> 
                  <label class="col-md-3"> </label>
                  <div class="col-md-8">
                    <button type="button" name="btnEdit" class="btn btn-primary" @click="updateSiswa();">Edit</button>
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
</section>


<script type="text/javascript">
  var siswaApp = new Vue({
    el:"#siswa-container",
    data: {
      siswa          : {id:0, nama:"", kelas:"",email:"",alamat:""},
      selectedSiswa  : {},
      newSiswa       : {nama:"", kelas:"",email:"",alamat:""},
      errorMessage   : "",
      successMessage : ""
    },
    mounted: function(){
      this.getSiswa();
    },
    methods: {
      getSiswa: function(){
        axios.get("<?php echo base_url();?>api.php?modul=siswa&fungsi=list")
        .then(function(response){
          if(!response.data.error){
            siswaApp.siswa = response.data.siswa;
          }
        });
      },

      selectSiswa: function(siswaSelected){
        siswaApp.selectedSiswa = JSON.parse(JSON.stringify(siswaSelected));
      },

      addSiswa: function(){
        let formData = siswaApp.toFormData(siswaApp.newSiswa);
        axios.post("<?php echo base_url();?>api.php?modul=siswa&fungsi=create", formData)
        .then(function(response){
          siswaApp.newSiswa = {};
          if(response.data.error){
            siswaApp.errorMessage = response.data.message;
            swal(
              'Gagal!',
              'Gagal menambbah siswa!',
              'error'
            );
          }else{
            siswaApp.successMessage = response.data.message;
            siswaApp.getSiswa();
            swal(
              'Berhasil!',
              'Berhasil menambah siswa!',
              'success'
            );
          }
        });
      },

      updateSiswa: function(){
        let formData = siswaApp.toFormData(siswaApp.selectedSiswa);
        axios.post("<?php echo base_url();?>api.php?modul=siswa&fungsi=update", formData)
        .then(function(response){
          siswaApp.selectedSiswa = {};
          if(response.data.error){
            siswaApp.errorMessage = response.data.message;
            swal(
              'Gagal!',
              'Gagal mengubah siswa!',
              'error'
            );
          }else{
            siswaApp.successMessage = response.data.message;
            $('#editBookDialog').modal('toggle');
            siswaApp.getSiswa();
            swal(
              'Berhasil!',
              'Berhasil mengubah siswa!',
              'success'
            );
          }
        });
      },

      deleteSiswa: function(){
        swal({
          title: "Hapus data",
          text: "Anda yakin mau menghapus siswa ini ?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
          if (result.value){
            let formData = siswaApp.toFormData(siswaApp.selectedSiswa);
            axios.post("<?php echo base_url();?>api.php?modul=siswa&fungsi=delete", formData)
            .then(function(response){
              siswaApp.selectedSiswa = {};
              if(response.data.error){
                siswaApp.errorMessage = response.data.message;
                swal(
                  'Gagal!',
                  'Oops, Gagal menghapus siswa!',
                  'error'
                );
              }else{
                siswaApp.successMessage = response.data.message;
                siswaApp.getSiswa();
                swal(
                  'Berhasil!',
                  'Anda berhasil menghapus siswa!',
                  'success'
                );
              }
            });
          }
        });
      },

      toFormData: function(obj){
        var form_data = new FormData();
        for (var key in obj) {
          form_data.append(key, obj[key]);
        }
        return form_data;
      }
    }
  });
</script>
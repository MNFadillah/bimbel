<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin LBB</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo assets_url();?>bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo assets_url();?>plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="<?php echo assets_url();?>dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo assets_url();?>dist/css/skins/skin-green.min.css">
  <!-- jQuery 2.2.3 -->
  <script src="<?php echo assets_url();?>plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="<?php echo assets_url();?>bootstrap/js/bootstrap.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo assets_url();?>dist/js/app.min.js"></script>
  <!-- DataTables -->
  <script src="<?php echo assets_url();?>plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo assets_url();?>plugins/datatables/dataTables.bootstrap.min.js"></script>
  <!-- ChartJS 1.0.1 -->
  <script src="<?php echo assets_url();?>plugins/chartjs/Chart.min.js"></script>
</head>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">
  <!-- Main Header -->
  <?php include 'pages/includes/header.php'; ?>
  <!-- Left side column. contains the logo and sidebar -->
  <?php include 'pages/includes/sidebar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php 
        $head = '';
        if($page == 'mapel'){
          $head = "Mata Pelajaran";
        } else if($page == 'mapel-kelas'){
          $head = "Mata Pelajartan Tiap Kelas";
        } else{
          $head = $page;
        }
        $head = "Halaman " . $head;
        echo ucwords($head);
        ?>
      </h1>
      <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol> -->
    </section>

    <!-- Main content -->
    <section class="content">

      <?php 
        if($page == '' || $page == 'dashboard'){
          include 'pages/dashboard.php';
        }else{
          echo 'not found'; 
        }
      ?>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <?php include 'pages/includes/footer.php'; ?>
</div>

<script>
  $(function () {
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true
    });
  });
</script>

</body>
</html>

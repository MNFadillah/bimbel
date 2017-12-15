  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATIONS</li>
        <li <?php if($menu == 'dashboard') echo "class='active'";?>>
          <a href="<?php echo base_url() . '?page=dashboard' ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
        </li>
        <li class="treeview <?php if($menu == 'siswa' || $menu == 'nilai'){echo 'active';}?>">
          <a href="#">
            <i class="fa fa-users"></i> <span>Siswa</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($menu == 'siswa') echo "class='active'";?>>
              <a href="<?php echo base_url() . '?page=siswa' ?>">
                <i class="fa fa-table"></i> <span>List Siswa</span>
              </a>
            </li>
            <li <?php if($menu == 'nilai') echo "class='active'";?>>
              <a href="<?php echo base_url() . '?page=nilai' ?>"><i class="fa fa-line-chart"></i> Nilai</a>
            </li>
          </ul>
        </li>
        <li class="<?php if($menu == 'mapel') echo 'active';?>">
          <a href="<?php echo base_url() . '?page=mapel' ?>">
            <i class="fa fa-book"></i> <span>Mata Pelajaran</span>
          </a>
        </li>
        <li class="<?php if($menu == 'kelas') echo 'active';?>">
          <a href="<?php echo base_url() . '?page=kelas' ?>">
            <i class="fa fa-building-o"></i> <span>Kelas</span>
          </a>
        </li>
        <li class="<?php if($menu == 'mapel-kelas') echo 'active';?>">
          <a href="<?php echo base_url() . '?page=mapel-kelas' ?>">
            <i class="fa fa-building-o"></i> <span>Mata Kuliah per Kelas</span>
          </a>
        </li>
        <!-- <li class="<?php if($menu == 'raport') echo 'active';?>">
          <a href="<?php echo base_url() . '?page=raport' ?>">
            <i class="fa fa-files-o"></i> <span>Raport Siswa</span>
          </a>
        </li> -->
        <li class="header">OTHER</li>
        <li class="<?php if($menu == 'akun') echo 'active';?>">
          <a href="<?php echo base_url() . '?page=akun' ?>">
            <i class="fa fa-users"></i> <span>Akun</span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>?action=logout"><i class="fa fa-key"></i> <span>Log Out</span></a>
        </li>
      </ul>
    </section>
  </aside>

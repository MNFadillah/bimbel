<?php
	require_once 'config/Database.php';
	require_once 'config/function.php';
	require_once 'class/class.user.php';
	$action = '';
	$page = '';
	if(isset($_GET['action'])){
		$action = $_GET['action'];
	}

	if(isset($_GET['page'])){
		$page = $_GET['page'];
	}
	$user = new User;
	$menu = 'dashboard';
	if($user->isLoggedIn()){
		if($action == 'logout'){
			$user->logout();
			include 'pages/login.php';
		}else if($action == 'print'){
			if($page == 'nilai'){
				include 'pages/siswa/cetak.php';
			}
		}else if($action == 'print_all'){
			if($page == 'nilai'){
				include 'pages/siswa/cetak-All.php';
			}
		}else{
			if($page == 'siswa'){
				$menu = 'siswa';
			}else if($page == 'mapel'){
				$menu = 'mapel';
			}else if($page == 'kelas'){
				$menu = 'kelas';
			}else if($page == 'nilai'){
				$menu = 'nilai';
			}else if($page == 'akun'){
				$menu = 'akun';
			}else if($page == 'mapel-kelas'){
				$menu = 'mapel-kelas';
			}else if($page == 'nilai'){
				$menu = 'nilai';
			}else if($page == '' || $page == 'dashboard'){
				$menu = 'dashboard';
			}else{

			}
			include 'pages/content.php';
		}
	}else{
		include 'pages/login.php';
	}
?>
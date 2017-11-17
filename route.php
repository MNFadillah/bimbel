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
		}else{
			if($page == '' || $page == 'dashboard'){
				$menu = 'dashboard';
			}
			include 'pages/content.php';
		}
	}else{
		include 'pages/login.php';
	}
?>
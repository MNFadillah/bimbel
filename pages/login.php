<?php
	if(isset($_POST['btnLogin'])){
		$email 		= htmlentities(strip_tags($_POST['email']));
		$password 	= htmlentities(strip_tags($_POST['password']));
		$loginResult = $user->login($email,$password);
		if($loginResult){
			header("location:".base_url());
		}else{

		}
	}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login</title>
  <link rel="stylesheet" href="<?php echo assets_url();?>bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo assets_url();?>dist/css/login.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
</head>
<body class="hold-transition skin-green sidebar-mini">
<div class="container">
    <div class="card card-container">
        <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
        <h2 id="login-title">SIM LBB</h2>
        <img id="profile-img" class="profile-img-card" src="<?php echo assets_url();?>img/avatar_2x.png" />
        <p id="profile-name" class="profile-name-card"></p>
        <form class="form-signin" method="post">
            <span id="reauth-email" class="reauth-email"></span>
            <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="btnLogin">Sign in</button>
        </form><!-- /form -->
    </div><!-- /card-container -->
</div><!-- /container -->
</body>
</html>

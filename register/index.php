<?php
	require '../inc/variables.php';
	require ('../steamauth/steamauth.php');  
	require_once('../google/gsettings.php');

$login_url = 'https://accounts.google.com/o/oauth2/v2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online';
?>
<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Sign Up | <?php echo $wsnname?></title>
  
  
  
      <link rel="stylesheet" href="../css/login.css">
	  <script src='https://www.google.com/recaptcha/api.js'></script>

  
</head>

<body>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
function openInNewTab(url) {
			var win = window.open(url, '_blank');
			win.focus();
			}
										
		function openTab(url) {
			var win = window.location.href = (url);
			win.focus();
		}
		
		<?php if (isset($_GET['passerror'])) {
		echo 'swal({
		  title: "Error!",
		  text: "The Password do not match.",
		  icon: "error",
		});';
		}?>
		
		<?php if (isset($_GET['emailerror'])) {
		echo 'swal({
		  title: "Error!",
		  text: "The Password do not match.",
		  icon: "error",
		});';
		}?>
		<?php if (isset($_GET['captchaerror'])) {
		echo 'swal({
		  title: "Error!",
		  text: "No or invalid ReCaptcha.",
		  icon: "error",
		});';
		}?>
		<?php if (isset($_GET['agerror'])) {
		echo 'swal({
		  title: "Error!",
		  text: "You are to young.",
		  icon: "error",
		});';
		}?>
		<?php if (isset($_GET['invcrederror'])) {
		echo 'swal({
		  title: "Error!",
		  text: "Username and/or E-Mail allready taken.",
		  icon: "error",
		});';
		}?>
		<?php if (isset($_GET['googleerror'])) {
		echo 'swal({
		  title: "Error!",
		  text: "Google has not transmitted your data. Please try again.",
		  icon: "error",
		});';
		}?>
		<?php if (isset($_GET['steamerror'])) {
		echo 'swal({
		  title: "Error!",
		  text: "Steam has not transmitted your data. Please try again.",
		  icon: "error",
		});';
		}?>
</script>

  <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>

<div class="register">
  <h2 class="nonactive" onclick="openTab('../login')"> sign in </h2>

  <h2 class="active"> sign up </h2>
  <form action="../register.php" method="post">
   
    

    <input type="text" class="text" name="username" id="username" required>
     <span>username</span>

    <br>
    
    <br>
	
	<input type="email" class="text" name="mail" id="email" required>
     <span>email</span>

    <br>
    
    <br>
	
	<input type="text" class="text" name="name" required>
     <span>Name</span>

    <br>
    
    <br>
	
	
	<input type="date" class="text" name="dateob" required>
     <span>date of birth</span>

    <br>
    
    <br>

    <input type="password" class="text" name="password" required>
    <span>password</span>
    <br>
	
	<br>
	
	<input type="password" class="text" name="password2" required>
    <span>re-enter password</span>
    <br>
	<br>
	<div class="g-recaptcha" data-sitekey="6LdFc0AUAAAAANrs7zgBDs5s2XzOKIOXm6dQzxNv" data-theme="dark"></div>
	
    
    <button class="signinbtn">
      Sign Up
    </button>
	
    <hr class="hrregister">
	</form>
	<div class="cusreg">
    <button class="signinbtn" onclick="openTab('<?php echo $login_url ?>')">
      Register with Google
    </button>
	<button class="signinbtn" onclick="openTab('<?php loginlinksteam();?>')">
      Register with Steam
    </button>
	<div>

</div>
  
  

    <script  src="../js/login.js"></script>
	<script src="../js/jquery-3.2.1.min.js"></script>
	<script src="../js/script.js"></script>




</body>

</html>

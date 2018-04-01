<?php
	require '../inc/variables.php';

	if (isset($_GET['key'])) {
	
	$con = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);
	if ($con->connect_error) {
		die("Connection failed: " . $con->connect_error);
	} 
	
	$key = $_GET['key'];
	
	$request = 'SELECT * FROM `user` WHERE `resetkey` = "'.$key.'"';
	
	$requestquery = mysqli_query($con, $request);
	
	$requestarray = mysqli_fetch_assoc($requestquery);
	
	if (empty($requestarray['resetkey'])) {
		header("Location: ./reset.php?tokenerror");
		die('ErrorEmpt');
	}
	
	if (mysqli_num_rows($requestquery) <= 0) {
		header("Location: ./reset.php?tokenerror");
			die("ErrorInvCode");
		}

	$userdata = mysqli_fetch_assoc($requestquery);
	
	if (!$userdata['resetable'] = 1) {
		header("Location: ./reset.php?error");
		die('ErrorNotAble');
	}
	
	if (isset($_POST['resetbtn'])) {
		$options = [
			'cost' => 7,
		];
				
				
		if ($_POST['password'] == $_POST['password2']) {
		}else{
			header("Location: ./reset.php?passerror");
			exit("Password confriamtion worong.");
		}
		$passhash = password_hash($_POST['password'], PASSWORD_BCRYPT, $options);
		$sql2 = 'UPDATE `user` SET `password`="'.$passhash.'",`resetable`="0",`resetkey`="" WHERE `resetkey` = "'.$key.'"';
		$query2 = mysqli_query($con, $sql2);
		$fin = true;
	}
	}else{
		$error106 = true;
	}
	
	?>
	
<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Reset Password | <?php echo $wsnname?></title>
  
  
  
      <link rel="stylesheet" href="../css/login.css">

  
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
		
		
		
		<?php if (isset($fin)) {
		echo 'swal({
		  title: "Success!",
		  text: "Password changed.",
		  icon: "success",
		});';
		}?>
		<?php if (isset($_GET['passerror'])) {
		echo 'swal({
		  title: "Error!",
		  text: "The Password do not match.",
		  icon: "error",
		});';
		}?>
		<?php if (isset($_GET['tokenerror'])) {
		echo 'swal({
		  title: "Error!",
		  text: "Invalid reset key, please try again.",
		  icon: "error",
		});';
		}?>
		<?php if (isset($_GET['error'])) {
		echo 'swal({
		  title: "Error!",
		  text: "Mayby you have allready resetet it.",
		  icon: "error",
		});';
		}?>
		<?php if (isset($error106)) {
		echo 'swal({
		  title: "Error!",
		  text: "Maybe you have allready resetet it.",
		  icon: "error",
		});';
		}?>
</script>

  <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>

<div class="respw3">
  <h2 class="active"> reset password </h2>

  <form action="" method="post">
   
    

    <input type="password" class="text" name="password" required>
     <span> New Password</span>

    <br /><br>
    
	<input type="password" class="text" name="password2" required>
     <span>Reenter new Password</span>
	
    <br>


    <button class="signinbtn" name="resetbtn">
      Reset
    </button>
	
    <hr class="hrlogin">

    <a href="../login" class="fp">Sign In</a>
  </form>

</div>
  
  

    <script  src="../js/login.js"></script>




</body>

</html>

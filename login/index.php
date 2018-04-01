<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
	require '../inc/variables.php';
	
$con = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}	
if (isset($_SESSION['id'])) {
	header("Location: ../");
}else{
	if (isset($_COOKIE["kmsi-hash"])) {
		$kmsisql = "SELECT * FROM `user` WHERE `hash` = '".$_COOKIE["kmsi-hash"]."'";
		$kmsiresults = mysqli_query($con, $kmsisql);
		if (mysqli_num_rows($kmsiresults) > 0) {
			$kmsirow = mysqli_fetch_assoc($kmsiresults);
			
			$salt = '123';
			$secsalt = '456';
			$username = $kmsirow['username'];
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}

			$unhashed = "".$salt.$username.$ip.$secsalt."";
			
			
			if (password_verify($unhashed, $kmsirow['hash'])) {
				$id = $kmsirow['id'];
				$name = $kmsirow['name'];
				$_SESSION['id'] = $id;
				$_SESSION['name'] = $name;
				header("Refresh:0");
			} else {
				//Why is that here? ~sh4dow
			}
		
		}
	}
}
	
?>
<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Login | <?php echo $wsnname?></title>
  
  
  
      <link rel="stylesheet" href="../css/login.css">
	  <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
<script>
window.addEventListener("load", function(){
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      "background": "#505050",
      "text": "#ffffff"
    },
    "button": {
      "background": "#1161ed",
      "text": "#ffffff"
    }
  },
  "theme": "edgeless",
  "content": {
    "message": "This website uses cookies to ensure you get the best experience on our website.",
    "dismiss": "Hide",
    "link": "Learn more"
  }
})});
</script>

  
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
		
		<?php if (isset($_GET['loger'])) {
		echo 'swal({
		  title: "Error!",
		  text: "The Username or Password is invalid.",
		  icon: "error",
		});';
		}?>
		<?php if (isset($_GET['sucreg'])) {
		echo 'swal({
		  title: "Successfuly,",
		  text: "registered, please Check your E-Mails for our E-Mail to verify you.",
		  icon: "success",
		});';
		}?>
		<?php if (isset($_GET['logout'])) {
		echo 'swal({
		  title: "Success!",
		  text: "Successful Logout!",
		  icon: "success",
		});';
		}?>
</script>

  <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>

<div class="login">
  <h2 class="active"> sign in </h2>

  <h2 class="nonactive" onclick="openTab('../register')"> sign up </h2>
  <form action="../login.php" method="post">
   
    

    <input type="text" class="text" name="username">
     <span>username/e-mail</span>

    <br>
    
    <br>

    <input type="password" class="text" name="password">
    <span>password</span>
    <br>

    <input type="checkbox" id="checkbox-1-1" name='kmsibox' value="true" class="custom-checkbox" />
    <label for="checkbox-1-1">Keep me Signed in</label>
    
    <button class="signinbtn">
      Sign In
    </button>
	
    <hr class="hrlogin">

    <a href="../resetpw" class="fp">Forgot Password?</a>
  </form>

</div>
  
  

    <script  src="../js/login.js"></script>




</body>

</html>

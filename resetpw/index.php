<?php

	require '../inc/variables.php';
	require "../recaptchalib.php";
	
	$con = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);
	if ($con->connect_error) {
		die("Connection failed: " . $con->connect_error);
	}
	
	function confirmidgen($length=8){
			$key = '';
			list($usec, $sec) = explode(' ', microtime());
			mt_srand((float) $sec + ((float) $usec * 100000));
			
			$inputs = array_merge(range('z','a'),range(0,9),range('A','Z'));

			for($i=0; $i<$length; $i++)
			{
				$key .= $inputs{mt_rand(0,61)};
			}
			return $key;
	}
	
	$secret = $captchaauthkey;

	$response = null;

	$reCaptcha = new ReCaptcha($secret);
	
	
	if (!isset($_GET['step1']) && !isset($_GET['step2'])) {
		$code = '<div class="respw1"><h2 class="active"> reset password </h2><form action="" method="get"><p class="iutext">I understand that for this Process, Placeholder will need my E-Mail and Password!</p><button class="signinbtn" name="step2">Reset</button><hr class="hrlogin"><a href="../login" class="fp">Sign In</a></form></div>';
	}
	if (isset($_GET['step1'])) {
		$code = '<div class="respw1"><h2 class="active"> reset password </h2><form action="" method="get"><p class="iutext">I understand that for this Process, Placeholder will need my E-Mail and Password!</p><button class="signinbtn" name="step2">Reset</button><hr class="hrlogin"><a href="../login" class="fp">Sign In</a></form></div>';
	}
	
	if (isset($_GET['step2'])) {
		$code = '<div class="respw2"><h2 class="active"> reset password </h2><form action="" method="post"><input type="text" class="text" name="username" required><span>username/e-mail</span><br><div class="g-recaptcha" data-sitekey="6LdFc0AUAAAAANrs7zgBDs5s2XzOKIOXm6dQzxNv" data-theme="dark"></div><br><button class="signinbtn" name="rstursg">Reset</button><hr class="hrlogin"><a href="../login" class="fp">Sign In</a></form></div>';
	}
	
	if (isset($_POST['rstursg'])) {
		if ($_POST["g-recaptcha-response"]) {
		$response = $reCaptcha->verifyResponse(
			$_SERVER["REMOTE_ADDR"],
			$_POST["g-recaptcha-response"]
		);
	  }
	  
	  if ($response != null && $response->success) {
	  }else{
		header("Location: ./index.php?step2&captchaerror");
		exit('No or invalid ReCaptcha. <a href="./index.php?step2" class="btn btn-info" role="button">Back</a>');
	  }
		$resetidgen = confirmidgen($verifyidlengh);
		
		$sql = "SELECT * FROM `user` WHERE `username` = '".$_POST['username']."' OR `email` = '".$_POST['mail']."'";
		$results = mysqli_query($con, $sql);

		if (mysqli_num_rows($results) > 0) {
			$resultarray = mysqli_fetch_assoc($results);
			$sql2 = "UPDATE `user` SET `resetable`='1',`resetkey`='".$resetidgen."' WHERE `id` = '".$resultarray['id']."'";
			$query2 = mysqli_query($con, $sql2);
			
			if ($usesmtp) {
				require_once "mail/Mail.php";

					$to = "".$resultarray['name']." <".$resultarray['email'].">";
					$subject = "Password reset request | ".$wsnname;
					$body = "Hello,\n\nsomebody (hopyfuly you) made a request to reset your Password on ".$wsnname."!,\nTo do that, press this link. <a href='".$domain."/resetpw/reset.php?key=".$resetidgen."'>Reset</a>";


					$headers = array ('From' => $smtpfrom,
					  'To' => $to,
					  'Subject' => $subject);
					$smtp = Mail::factory('smtp',
					  array ('host' => $smtp_host,
						'auth' => true,
						'username' => $smtp_username,
						'password' => $smtp_password));

					$mail = $smtp->send($to, $headers, $body);

					if (PEAR::isError($mail)) {
					  echo("<p>" . $mail->getMessage() . "</p>");
					 } else {
					  echo("<p>Message successfully sent!</p>");
					 }
			}else{
				$recive = $resultarray['email'];
				$betreff = "Password reset request | ".$wsnname;
				$nachricht = "Hello,\n\nsomebody (hopyfuly you) made a request to reset your Password on ".$wsnname."!,\nTo do that, press this link. <a href='".$domain."/resetpw/reset.php?key=".$resetidgen."'>Reset</a>";
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
				$headers .= "From: ".$verifyemail."" . "\r\n" .
							"X-Mailer: PHP/" . phpversion();
				mail($empfaenger, $betreff, $nachricht, $headers);
				
			}
			die("Finish");
		}else{
			header("Location: ./index.php?step2&invalidcred");
			exit('Wrong Username or E-Mail! <a href="./index.php?step2" class="btn btn-info" role="button">Back</a>');
		}
		
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
		
		<?php if (isset($_GET['captchaerror'])) {
		echo 'swal({
		  title: "Error!",
		  text: "No or invalid ReCaptcha.",
		  icon: "error",
		});';
		}?>
		<?php if (isset($_GET['invalidcred'])) {
		echo 'swal({
		  title: "Error!",
		  text: "Wrong Username or E-Mail!",
		  icon: "error",
		});';
		}?>
		
</script>

  <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>

<!--<div class="respw1">
  <h2 class="active"> reset password </h2>

  <form action="" method="get">
  
	<p class="iutext">I understand that for this Process, Placeholder will need my E-Mail and Password!</p>

    <button class="signinbtn" name="step2">
      Reset
    </button>
	
    <hr class="hrlogin">

    <a href="../login" class="fp">Sign In</a>
  </form>

</div>-->
<?php echo $code; ?>
  
  

    <script  src="../js/login.js"></script>




</body>

</html>

<?php
	require '../inc/variables.php';
	require_once('gsettings.php');
	require_once('google-login-api.php');
	
	
	if(isset($_GET['code'])) {
	try {
		$gapi = new GoogleLoginApi();
		$data = $gapi->GetAccessToken(CLIENT_ID, CLIENT_REDIRECT_URL, CLIENT_SECRET, $_GET['code']);
		$user_info = $gapi->GetUserProfileInfo($data['access_token']);
		
		$username = $user_info['displayName'];
		$emailsarray = $user_info['emails'];
		$email = $emailsarray['0'];
		$namearray = $user_info['name'];
		$image = $user_info['image'];
		}
	catch(Exception $e) {
		echo $e->getMessage();
		exit();
	}
}else{
	header("Location: ../register/index.php?googleerror");
	exit('Google has not transmitted your data. Please try again. <a href="../register" class="btn btn-info" role="button">Back</a>');
}
	
?>
<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Sign Up via Google | <?php echo $wsnname?></title>
  
  
  
      <link rel="stylesheet" href="../css/login.css">
	  <script src='https://www.google.com/recaptcha/api.js'></script>

  
</head>

<body>
<script>
function openInNewTab(url) {
			var win = window.open(url, '_blank');
			win.focus();
			}
										
		function openTab(url) {
			var win = window.location.href = (url);
			win.focus();
		}
</script>

  <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
  <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet' type='text/css'>

<div class="registerwgoogle">
  <h2 class="active"> sign up with google</h2>

  <form action="../register.php" method="post">
   
    

    <input type="text" class="text" name="username" value="<?php echo $username; ?>" required>
     <span>username</span>

    <br>
    
    <br>
	<input type="email" class="text mailbox" name="mail" value="<?php echo $email['value']; ?>" required>
     <span>email</span>

    <br>
    
    <br>
	
	<input type="text" class="text" name="name" value="<?php echo $namearray['givenName'].' '.$namearray['familyName']; ?>" required>
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
	
	<input type="hidden" name="avatarurl" value="<?php echo $image['url']; ?>">

    
    <button class="signinbtn">
      Sign Up
    </button>
	
  </form>
  

</div>

  <p class="textfooter">Powered by <i class="fa fa-google" aria-hidden="true"></i>oogle</p>
  
  

    <script  src="../js/login.js"></script>




</body>

</html>

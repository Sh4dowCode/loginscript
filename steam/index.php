<?php
	require '../inc/variables.php';
	require ('../steamauth/steamauth.php');
	if(isset($_SESSION['steamid'])) {
		include ('../steamauth/userInfo.php');
	}else{
		header("Location: register/index.php?steamerror");
		exit("Steam has not transmitted your data. Please try again. <a href='../register' class='btn btn-info' role='button'>Back</a>");
	}
?>
<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Sing Up via Steam | <?php echo $wsnname?></title>
  
  
  
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

<div class="registerwsteam">
  <h2 class="active"> sign up with steam</h2>

  <form action="../register.php" method="post">
   
    

    <input type="text" class="text" name="username" value="<?php echo $steamprofile['personaname'] ?>" required>
     <span>username</span>

    <br>
    
    <br>
	
	<input type="email" class="text" name="mail" required>
     <span>email</span>

    <br>
    
    <br>
	
	<input type="text" class="text" name="name" value="<?php echo $steamprofile['realname'] ?>" required>
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
	
	<input type="hidden" name="avatarurl" value="<?php echo $steamprofile['avatarfull'] ?>">

    
    <button class="signinbtn">
      Sign Up
    </button>
	
  </form>
  

</div>

  <p class="textfooter">Powered by Steam</p>
  
  

    <script  src="../js/login.js"></script>




</body>

</html>

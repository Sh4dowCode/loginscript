<?php
	require 'inc/variables.php';

	if (!isset($_GET['verify'])) {
		exit ('Error 45');
	}
	
	$con = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);
	if ($con->connect_error) {
		die("Connection failed: " . $con->connect_error);
	} 
	
	$key = $_GET['verify'];
	
	$request = 'SELECT * FROM `user` WHERE `verifyid` = "'.$key.'"';
	$requestquery = mysqli_query($con, $request);
	
	$requestarray = mysqli_fetch_assoc($requestquery);
	
	if (empty($requestarray['verifyid'])) {
		die('ErrorEmpt');
	}
	
	if (mysqli_num_rows($requestquery) <= 0) {
			die("ErrorInvCode");
		}

	if ($requestarray['verified'] == 1) {
		die('ErrorAllready');
	}
	
	$sql = "UPDATE user SET `verified`='1', `verifyid`='' WHERE `verifyid`='".$key."'";
	$sqlquery = mysqli_query($con, $sql);
	
	$fin = true;
	?>
	
	<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Confirm E-Mail | <?php echo $wsnname?></title>
  
  
  
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
		  text: "E-Mail Confirmed. You may now close that tab.",
		  icon: "success",
		});';
		}?>
		
</script>

  <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    <script  src="../js/login.js"></script>




</body>

</html>
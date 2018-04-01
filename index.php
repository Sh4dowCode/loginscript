<?php
	require 'inc/variables.php';
	if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
	$con = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);
	if ($con->connect_error) {
		die("Connection failed: " . $con->connect_error);
	} 
	
	if (!isset($_SESSION['id'])) {
		header("Location: login/");
		exit;
	}
	
	$sql1 = 'SELECT * FROM `user` WHERE `id` = "'.$_SESSION['id'].'"';
	$query1 = mysqli_query($con, $sql1);
	$array1 = mysqli_fetch_assoc($query1);
	
	$dobunix = strtotime( $array1['dob'] );
	$readabledate = date( 'd.m.Y', $dobunix );
?>
<!DOCTYPE HTML>
<!--
	Identity by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title><?php echo $wsnname?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<!--<script src="https://widget.battleforthenet.com/widget.js" async></script>-->
	</head>
	<body class="is-loading">
			<!-- Wrapper -->
			<div id="wrapper">

				<!-- Main -->
					<section id="main">
					<p class="logouttxt"><a href="logout.php">Logout</a></p>
						<header>
							<span class="avatar"><img src="<?php echo $array1['avatar'];?>" alt="" /></span>
							<h1>Username: <?php echo $array1['username'];?> <?php if($array1['verified'] == 1) {echo '<i class="fas fa-check" id="verp"></i><div id="verhi" style="display: none"><h5>Verified</h5></div>';}?></h1>
							<p>ID: <?php echo $_SESSION['id']; ?></p>
							<p>E-Mail: <?php echo $array1['email'];?></p>
							<p>Name: <?php echo $array1['name'];?></p>
							<p>Date of Bith: <?php echo $readabledate;?></p>
						</header>
					</section>

				<!-- Footer -->
					<footer id="footer">
						<ul class="copyright">
							<li>&copy; <?php echo $wsnname?></li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
						</ul>
					</footer>

			</div>

		<!-- Scripts -->
			<!--[if lte IE 8]><script src="assets/js/respond.min.js"></script><![endif]-->
			<script>
				if ('addEventListener' in window) {
					window.addEventListener('load', function() { document.body.className = document.body.className.replace(/\bis-loading\b/, ''); });
					document.body.className += (navigator.userAgent.match(/(MSIE|rv:11\.0)/) ? ' is-ie' : '');
				}
			</script>
			
			<script>
		var e = document.getElementById('verp');
		e.onmouseover = function() {
		  document.getElementById('verhi').style.display = 'block';
		}
		e.onmouseout = function() {
		  document.getElementById('verhi').style.display = 'none';
		}
	</script>

	</body>
</html>
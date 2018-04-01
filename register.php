 <?php
require 'inc/variables.php';
require "recaptchalib.php";
  
  function verifyidgen($length=8)
{
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
  
  
$secret = "	6LdFc0AUAAAAAA-NS8XCV4X4nEhs0kChf9VjrAgf";

$response = null;

$reCaptcha = new ReCaptcha($secret);

if ($_POST['password'] == $_POST['password2']) {
}else{
  header("Location: register/index.php?passerror");
exit("The first password do not match the seconnd. <a href='./register' class='btn btn-info' role='button'>Back</a>");
}
  
if ($_POST["g-recaptcha-response"]) {
    $response = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
    );
  }
   
   if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
     header("Location: register/index.php?emailerror");
  die("Invalid email format <a href='./register' class='btn btn-info' role='button'>Back</a>");
}

  
  
if ($response != null && $response->success) {
  }else{
    header("Location: register/index.php?captchaerror");
    exit('No or invalid ReCaptcha! <a href="./register" class="btn btn-info" role="button">Back</a>');
  }
  
  function validateAge($birthday, $age = 18)
{
    if(is_string($birthday)) {
        $birthday = strtotime($birthday);
    }

    if(time() - $birthday < $age * 31536000)  {
        return false;
    }

    return true;
}

$miniage = validateAge($_POST['dateob'], $minage);
if  (!$miniage = true) {
	header("Location: register/index.php?agerror");
    exit('Invaild Age <a href="./register" class="btn btn-info" role="button">Back</a>');
}

$verifyidgen = verifyidgen($verifyidlengh);
  
$con = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$options = [
    'cost' => 7,
];

$sql = "SELECT * FROM `user` WHERE `username` = '".$_POST['username']."' OR `email` = '".$_POST['mail']."'";
		$results = mysqli_query($con, $sql);

		if (mysqli_num_rows($results) > 0) {
			header("Location: register/index.php?invcrederror");
			exit('Username and/or E-Mail allready taken. <a href="./register" class="btn btn-info" role="button">Back</a>');
		}
		
$passhash = password_hash($_POST['password'], PASSWORD_BCRYPT, $options);

$countsql = "SELECT COUNT(*) FROM user LIMIT 1;";

$count = mysqli_query($con, $countsql);

$crow = mysqli_fetch_assoc($count);

$idadd = $crow['COUNT(*)'] + 1;

if (isset($_POST['avatarurl'])) {
	$avatarurl = $_POST['avatarurl'];
}else{
	$avatarurl = "./images/avatar.png";
}

$sql = "INSERT INTO `user` (`id`, `username`, `email`, `name`, `dob`, `password`, `avatar`, `verified`, `verifyid`) VALUES ('".$idadd."', '".$_POST['username']."', '".$_POST['mail']."', '".$_POST['name']."', '".$_POST['dateob']."', '".$passhash."', '".$avatarurl."', '0', '".$verifyidgen."');";

mysqli_query($con, $sql);

if ($usesmtp) {
	require_once "mail/Mail.php";

		$to = "".$_POST['name']." <".$_POST['mail'].">";
		$subject = "Verify your E-Mail | ".$wsnname;
		$body = "Hello,\n\nPlease verify your Account on ".$wsnname."!,\nTo do that, press this link. <a href='".$domain."/emailconfirm.php?verify=".$verifyidgen."'>Verify</a>";


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
$recive = $_POST['mail'];
$betreff = "Verify your E-Mail | ".$wsnname;
$nachricht = "Hello,\n\nPlease verify your Account on ".$wsnname."!,\nTo do that, press this link. <a href='".$domain."/emailconfirm.php?verify=".$verifyidgen."'>Verify</a>";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
$headers .= "From: ".$verifyemail."" . "\r\n" .
			"X-Mailer: PHP/" . phpversion();
mail($_POST['mail'], $betreff, $nachricht, $headers);
	
}

header("Location: login/index.php?sucreg");
exit('Successfuly registered, please check your E-Mails for our E-Mail to verify you.');
?>
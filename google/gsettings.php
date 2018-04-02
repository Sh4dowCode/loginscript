<?php
require '../inc/variables.php';
define('CLIENT_ID', $gsuiteid);

define('CLIENT_SECRET', $gsuiteauthkey);

define('CLIENT_REDIRECT_URL', ''.$domain.'/google/index.php');
?>
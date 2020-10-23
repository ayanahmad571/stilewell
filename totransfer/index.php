<?php 
include('include.php');

$uniqd = give_uniqid();
$sql = "INSERT INTO `ms_views`( `log_user_agent`, `log_dnt`, `log_hash`, `log_ip`) VALUES (
'".$conn->escape_string($_SERVER['HTTP_USER_AGENT'])."',
'".time()."',
'".$uniqd."',
'".$_SERVER['REMOTE_ADDR']."'
)";

if ($conn->query($sql) === TRUE) {
	session_regenerate_id();
	$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'] = $uniqd;
	session_write_close();
    header('Location: home.php');
} else {
   die('#ERRIND1');
}

  
?>
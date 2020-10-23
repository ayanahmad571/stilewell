<?php
if(strpos($_SERVER['PHP_SELF'],'page_that_has_to_be_included_for_every_user_visible_page.php')){
	header('Location: page_that_has_to_be_included_for_evary_user_visible_page.php');
}
?>
<?php

if(isset($_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID']) and trim($_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID']) != ''){
	if(ins_pgview($_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'],basename($_SERVER['PHP_SELF']),$conn)){
	}else{
		die('#ERRHOM1');
	}
}else{
	
	#newhash
	session_regenerate_id();
	$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'] = give_uniqid();
	session_write_close();
	if(ins_msview($_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'],$conn)){
	}else{
		die('#ERRHOM3');
	}
	#hash pgname 
if(ins_pgview($_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'],basename($_SERVER['PHP_SELF']),$conn)){
	}else{
		die('#ERRHOM4');
	}

}


if(isset($_SESSION['STWL_SESS_ID'])){
$login=1;
$_USER = array();
$_USER = make_user_ar($conn,$_SESSION['STWL_LUM_DB_ID'],$login);
	

}else{
	header('Location: login.php');
}



?>
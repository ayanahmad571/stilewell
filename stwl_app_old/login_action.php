<?php 
include('include.php');
?>

<?php
if(isset($_POST['usr_nm']) and isset($_POST['pw'])){
		$uid = $_POST['usr_nm'];
	
		$pw=$_POST['pw'];
	
	
	
	
	
	


$sql = "SELECT * FROM `sw_usrs_inf` where sw_username='".$uid."' and sw_password='".md5($pw)."' and sw_valid=1 ";
$result = $conn->query($sql);

if ($result->num_rows ==1) {
    // output data of each row

    foreach($row = $result->fetch_assoc() as $rk=>$rv) {
        session_regenerate_id();
		$_SESSION[strtoupper($rk)]=$rv;
		$_SESSION['SESS_IIID'] = 'I4';

}


if($_SESSION['SW_VALIDTILL'] == 0){
}else{
	if($_SESSION['SW_VALIDTILL'] < time()){
		session_destroy();
		die('you session has timed out');
	}
}

header('Location: home.php');
} else {
    header("Location: login.php?error=4");
}
	
	
	
	
	
	
	
	
	
}else{
	header('Location: login.php?msg=enterallfields');
}
?>
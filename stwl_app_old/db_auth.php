<?php 
include('include.php');

?>
<?php
 /*
foreach($_SESSION as $k => $vv){

echo 'if(!isset($_SESSION[\''.$k.'\'])){<br>
	header(\'Location: index.php\');<br>
}<br>';
}
 */ 
 if(!isset($_SESSION['SW_U_ID'])){
header('Location: index.php');
}
if(!isset($_SESSION['SW_USERNAME'])){
header('Location: index.php');
}
if(!isset($_SESSION['SW_PASSWORD'])){
header('Location: index.php');
}
if(!isset($_SESSION['SW_PREFIX_NAME'])){
header('Location: index.php');
}
if(!isset($_SESSION['SW_U_F_NAME'])){
header('Location: index.php');
}
if(!isset($_SESSION['SW_U_L_NAME'])){
header('Location: index.php');
}
if(!isset($_SESSION['SW_U_DOB'])){
header('Location: index.php');
}
if(!isset($_SESSION['SW_U_ACCESS'])){
header('Location: index.php');
}
if(!isset($_SESSION['SW_CONTC_NO'])){
header('Location: index.php');
}
if(!isset($_SESSION['SW_EMAIL'])){
header('Location: index.php');
}
if(!isset($_SESSION['SW_VALID'])){
header('Location: index.php');
}

 
?>
<?php
$checklevelsql = "SELECT * FROM sw_modules where mo_href sounds like '%".basename($_SERVER['PHP_SELF'])."%' and mo_valid=1";
$checklevelres = $conn->query($checklevelsql);
if ($checklevelres->num_rows == 1) {

    // output data of each row
    while($checklevelrw = $checklevelres->fetch_assoc()) {
		if($_SESSION['SW_U_ACCESS'] >= $checklevelrw['mo_min_level']){
		}else{
			die('You are not allowed to access this Page');
		}
    }
} else {
    
}
 ?> 
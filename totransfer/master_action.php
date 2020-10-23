<?php
if(include('include.php')){
}else{
die('##errMASTERofUSErERROR');
}

if((count($_POST) > 0)  or (count($_GET) > 0)){
	if((count($_POST) > 0)){
		if(isset($_SERVER['HTTP_REFERER'])){
		}else{
			die('Refferer Not Found');
		}
		if((strpos($_SERVER['HTTP_REFERER'],'http://stilewell.ddns.net') == '0') or (strpos($_SERVER['HTTP_HOST'],'http://localhost/') == '0') or (strpos($_SERVER['HTTP_REFERER'],'http://192.168.1.') == '0'))
	{
	  //only process operation here
	}else{
		die('Only tld process are allowed');
	}
	}

}else{
	
	die(header('Location: master-action.php'));
	
}

/*
var_dump($_POST);
var_dump($_FILES);

foreach($_POST as $pkey=>$pval){
	echo '
	#---------------------------------------<br>
		if(isset($_POST[\''.$pkey.'\'])){<br>
		&nbsp;&nbsp;if(!is_string($_POST[\''.$pkey.'\'])){<br>
		&nbsp;&nbsp;die(\'Invalid Characters used in '.$pkey.'\');
		&nbsp;&nbsp;}<br>
		&nbsp;&nbsp;else{}<br>
		}else{<br>
		&nbsp;&nbsp;die(\'Enter '.$pkey.'\');<br>
		}<br>
	';
}

*/if(isset($_POST['from_email']) and isset($_POST['from_name']) and isset($_POST['subj_ml']) and isset($_POST['message_ml'])){
	
	$email = $_POST['from_email'];
	$name = $_POST['from_name'];
	$subject = $_POST['subj_ml'];
	$message = $_POST['message_ml'];
	$hash = md5(sha1($_SERVER['REMOTE_ADDR']));
	$ip = $_SERVER['REMOTE_ADDR'];
	$timest = time();	
	
	
$sql = "INSERT INTO `mun_mails`(`ml_from_email`, `ml_from_name`, `ml_subject`, `ml_body`, `ml_hash`, `ml_from_ip`, `mun_time`) VALUES (
'".$email."',
'".$name."',
'".$subject."',
'".$message."',
'".$hash."',
'".$ip."',
'".$timest."'
)";

if ($conn->query($sql) === TRUE) {
    header('Location: home.php?mailsent');
} else {
  die('#ERRMASTACT1');
}

	
}
#
if(isset($_POST['ok'])){
if(!isset($_POST['usr_nm']) or !isset($_POST['usr_pass']) or !isset($_POST['usr_eml'])){
	die('Please Enter all the data');
}


$ip  = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
if(($ip=='::1') or (strpos($ip,'192.168.1.40') === true)){
	
}


$email = $_POST['usr_eml'];
$name =  $_POST['usr_nm'];
$pw = md5(md5(sha1($_POST['usr_pass'])));

########################################################################################################3
$ui = explode(' ',$name);
$fn = str_split($ui[0]);
$ln = str_split(end($ui));
$fncount = count($fn)-1;
$lncount = count($ln)-1;
$ujl=array();
for($sa=0;$sa<9;$sa++){
	$fr = rand(1,2);
	if($fr==1){
		$sr = rand(0,$fncount);
		$ujl[]=$fn[$sr];
	}else if($fr==2){
		$tr = rand(0,$lncount);
		$ujl[]=$ln[$tr];
	}else{
		die('ERROR#MA3');
	}
	
}
#######################################################################################################3


$usr = strtolower($ujl[0].$ujl[1].$ujl[3].$ujl[4].$ujl[5].$ujl[6].$ujl[7].$ujl[8].rand(1,10));

$iv = 1098541894 .rand(100000,999999);
$regtm = time();
$regip = $_SERVER['REMOTE_ADDR'];
$hash = gen_hash($pw,$email);
#pass and email and secret md5(sha1())


$sqla = "
INSERT INTO `sw_logins`(`lum_rel_tu_id`,`lum_email`, `lum_username`, `lum_password`, `lum_hash_mix`) VALUES (
'2',
'".$email."',
'".$usr."',
'".$pw."',
'".$hash."'
)
";


if ($conn->query($sqla) === TRUE) {
	
	$ltid = $conn->insert_id;
	$sqlb = "INSERT INTO `sb_users`(`usr_rel_sch_id`,`usr_name`, `usr_rel_lum_id`,  `usr_iv`, `usr_reg_dnt`, `usr_reg_ip`) VALUES (
'0',
'".$name."',
'".$ltid."',
'".$iv."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."'
)";

	if ($conn->query($sqlb) === TRUE) {
	
    header('Location: login.php');
} else {
    echo $conn->error."Error##ma55";
}
	
    } else {
    die($conn->error."Error###maa4");
}


}
#
if(isset($_POST['lo_eml']) and isset($_POST['lo_pass'])){
	
	$eml=$_POST['lo_eml'];
	$pas=md5(md5(sha1($_POST['lo_pass'])));
	$hash = gen_hash($pas,$eml);
	
	if(ctype_alnum($eml) or is_numeric($eml) or is_email($eml)){
	}else{
		die("Invalid Email");
	}
	 
	
	if(ctype_alnum($hash.$pas)){
	}else{
		die("Credentials Not valid");
	}
	
	
$selectusersfromdbsql = "SELECT * FROM sw_logins where 
lum_email= '".$eml."' and
lum_password = '".$pas."' and
lum_hash_mix= '".$hash."' and
lum_valid = 1

";
$usrres = $conn->query($selectusersfromdbsql);
if ($usrres->num_rows == 1) {
    // output data of each row
    while($usrrw = $usrres->fetch_assoc()) {
        session_regenerate_id();

			$selectusersdatafromdbsql = "
SELECT * FROM sw_users where 
usr_rel_lum_id = '".$usrrw['lum_id']."' and usr_valid =1";
echo $selectusersfromdbsql	;
$dataobbres = $conn->query($selectusersdatafromdbsql);

if ($dataobbres->num_rows == 1) {
    // output data of each row
    while($dataobbrw = $dataobbres->fetch_assoc()) {
		###
        session_regenerate_id();
		
		$_SESSION['STWL_SESS_ID'] = md5(sha1(md5(md5(sha1('SecrejtBall')).uniqid().time()).time()).uniqid());
		$_SESSION['STWL_LUM_DB_ID'] = $usrrw['lum_id'];
		$_SESSION['STWL_LUM_TU_ID'] = $usrrw['lum_rel_tu_id'];
		session_write_close();
			header('Location: home.php');
		
		###
	}
}else{
	die('User Mapping Not found, Please Ask Administrator for assistance');
}
		
		
		###big en
    }
} else {
	header('Location: login.php?notss');
    die();
}
	
		
}
#

	
	/**//**//**//**/ 
	#$serverdir = 'http://localhost/muncircuit/';
	$serverdir = 'http://stilewell.ddns.net/';
if(isset($_POST['ch_pw'])){
			 if(isset($_SESSION['STWL_LUM_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sw_logins where lum_id = ".$_SESSION['STWL_LUM_DB_ID']." and lum_valid = 1");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}


	
	if(!isset($_POST['pw'])){
		die('Enter all fields');
	}

	if(!isset($_POST['npw'])){
		die('Enter all fields');
	}
	
	if($_POST['pw'] == $_POST['npw']){
		$lum = getdatafromsql($conn,'select * from sw_logins where lum_id = '.$_SESSION['STWL_LUM_DB_ID']);
		if(is_string($lum)){
			die('#ERRRMA39UET05G8T');
		}
		$pw = md5(md5(sha1($_POST['pw'])));
		$hash = gen_hash($pw,trim($lum['lum_email']));
		
		
		if($pw== $lum['lum_password']){
			die('The new password cant be same as the old one!');
		}else{
			$upsql = "UPDATE `sw_logins` SET `lum_password`='".trim($pw)."',`lum_hash_mix`='".trim($hash)."' WHERE lum_id = ".$_SESSION['STWL_LUM_DB_ID'];
			if($conn->query($upsql)){
						##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['STWL_LUM_DB_ID'],'sw_logins','update', $upsql ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%wsrhizuTGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




				session_destroy();
				if(count($_SESSION)>0){
					header('Location: login.php');
				}else{
					die('ERRMASESSND');
				}
			}else{
				die("#ERRRKJIOJTOJHB");
			}
			
		}
		
		
		
	}else{
		die('Passwords Dont Match');
	}


}
if(isset($_POST['re_pw'])){
	if(isset($_POST['rec_eml'])){
		if(is_email($_POST['rec_eml'])){
			$validemail = getdatafromsql($conn,"select * from sw_logins where lum_email = '".trim($_POST['rec_eml'])."'");
			
			if(is_array($validemail)){
				$hasho = gen_hash_pw('oi4jg9v 5g858r hgh587rhg85rhgvu85rht9gi vj98rjg984he98t hj4 9v8r hb9uirhbu');
			  $hasht = gen_hash_pw_2($validemail['lum_id'],'984j5t8gj48 g8 5hg085hr988rt09g409rhj 9borjh09oj58r hj094jh 98obh498toeihg');
			  
			  
			  
				$ins_pwrc = "INSERT INTO `sw_recover`(`rv_rel_lum_id`, `rv_hash`, `rv_valid_till`, `rv_hash_2`) VALUES (
'".$validemail['lum_id']."',
'".$hasho."',
'".(time()+10810)."',				
'".$hasht."'
)";
if($conn->query($ins_pwrc)){
			##### Insert Logs ##################################################################VV3###
		if(preplogs($validemail,"0",'sw_recover','insert', $ins_pwrc,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGweafTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




	###eml
	$to = $validemail['lum_email'];
$subject = "Stilewell Password Recovery ";

$message = "
<html>
<head>
<title>Click on the Link below</title>
</head>
<body>
<h2>You have requested an option to recover your account's password</h2>
<p>You can either click on the link below or copy it and paste it in your browser to reset your accounts password</p>
<p>The link is only valid for 5hrs and is one time useable</p>
<a href='http://schoolvault.ddns.net/recover.php?id=".$hasho.$hasht."'>".$serverdir."recover.php?id=".$hasho.$hasht."</a>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <anonymous.code.anonymous@gmail.com>' . "\r\n";

if(mail($to,$subject,$message,$headers)){
header('Location: recover.php?newmade');
}else{
	die('#ERRMAjuigtuj');
}
	###eml
}else{
	die('#ERRMA9309399JG');
}
				
				
				
				
			}else{
				echo 'Dont know';
			}
			
		}else{
			die('Enter a Valid Email');
		}
	}else{
		die('Enter All fields');
	}
}
#
#
if(isset($_POST['rec_action_pw'])){
	if(isset($_POST['recover_npw']) and isset($_POST['rec_pw_u'])){
		if(ctype_alnum(trim(strtolower($_POST['rec_pw_u'])))){
			$usrh = $_POST['rec_pw_u'];
			$newp = $_POST['recover_npw'];
			$user_det = getdatafromsql($conn,"select * from sw_logins where md5(sha1(concat(lum_id,'3oijg9i3u8uh'))) = '".$usrh."' and lum_valid = 1");
			
			if(is_array($user_det)){
				$new_pw=md5(md5(sha1($newp)));
				$new_hash = gen_hash($new_pw,trim($user_det['lum_email']));

	


if($conn->query("update sw_logins set lum_password = '".$new_pw."', lum_hash_mix ='".$new_hash."' where lum_id = ".$user_det['lum_id']."")){




	session_destroy();
	header('Location: login.php');
	
}else{
	die("ERRMAUSRPWCHOI03J4");
}
	
			}else{
				die('Invalid User');
			}
		}else{
			die("Invalid hash");
		}
	}else{
		die("Enter all Values");
	}
}

if(isset($_POST['mod_add'])){
	if(isset($_SESSION['STWL_LUM_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sw_logins where lum_id = ".$_SESSION['STWL_LUM_DB_ID']." and lum_valid = 1 and lum_ad = 1");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}
	############################33333333
	if(isset($_POST['mod_a_long_name'])){
		$nm = $_POST['mod_a_long_name'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['mod_a_href'])){
		$href = $_POST['mod_a_href'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['mod_a_icon'])){
		$ico = $_POST['mod_a_icon'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['mod_a_for'])){
		$mofor = $_POST['mod_a_for'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['mod_a_sub_menu']) and is_numeric($_POST['mod_a_sub_menu'])){
		if(in_range($_POST['mod_a_sub_menu'],0,1,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 1');
		}
		$subm = $_POST['mod_a_sub_menu'];
	}else{
		die('Enter all Fields Correctly');
	}
	if(isset($_POST['mod_a_valid']) and is_numeric($_POST['mod_a_valid'])){
		if(in_range($_POST['mod_a_valid'],0,1,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 6');
		}
		$vali_s = $_POST['mod_a_valid'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333

	if($conn->query("INSERT INTO `sw_modules`(`mo_name`, `mo_href`, `mo_for`, `mo_icon`,  `mo_sub_mod`, `mo_valid`) VALUES (
	'".$nm."',
	'".$href."',
	'".$mofor."',
	'".$ico."',
	".$subm.",
	".$vali_s."
	)")){
				##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['STWL_LUM_DB_ID'],'sw_modules','insert', "INSERT INTO `sw_modules`(`mo_name`, `mo_href`, `mo_for`, `mo_icon`,  `mo_sub_mod`, `mo_valid`) VALUES (
	'".$nm."',
	'".$href."',
	'".$mofor."',
	'".$ico."',
	".$subm.",
	".$vali_s."
	)",$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




		header('Location: admin_mods.php');
	}else{
		die('ERRMAGRTBRHR%Y$T%HTIEB(FD');
	}
}
if(isset($_POST['add_user'])){
	if(isset($_SESSION['STWL_LUM_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sw_logins where lum_id = ".$_SESSION['STWL_LUM_DB_ID']." and lum_valid = 1 and lum_ad = 1 ");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}

	############################33333333
	if(isset($_POST['usr_f_name']) and trim($_POST['usr_f_name']) !== ''){
		$fnm = $_POST['usr_f_name'];
	}else{
		die('Enter usr_f_name Correctly1');
	}
	############################33333333
	if(isset($_POST['usr_l_name']) and trim($_POST['usr_l_name']) !== ''){
		$lnm = $_POST['usr_l_name'];
	}else{
		die('Enter usr_l_name Correctly1');
	}
	if(isset($_POST['usr_email'])){
		if(is_email($_POST['usr_email'])){
		$eml = $_POST['usr_email'];
		}else{
			die('Email not Valid');
		}
	}else{
		die('Enter Email Correctly');
	}
	############################33333333
	############################33333333
	if(isset($_POST['usr_type'])){
		if(is_numeric($_POST['usr_type']) and (($_POST['usr_type'] == 1) or ($_POST['usr_type'] == 2) or ($_POST['usr_type'] == 3))){
		$usr_type = $_POST['usr_type'];
		}else{
			die('User Type not Valid');
		}
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['usr_contact_no'])){
		if(is_numeric($_POST['usr_contact_no'])){
		$number = $_POST['usr_contact_no'];
		}else{
			die('Contact not Valid');
		}
	}else{
		die('Enter Contact Correctly');
	}
	############################33333333
	if(isset($_POST['usr_pw'])){
		$pw = md5(md5(sha1($_POST['usr_pw'])));
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['usr_dob']) and (strtotime($_POST['usr_dob']) == true)){
			$dob = $_POST['usr_dob'];
	}else{
		die('Enter DOB Correctly');
	}
	############################33333333
	if(isset($_POST['usr_validtill']) and is_numeric($_POST['usr_validtill'])){
		$vldtll = $_POST['usr_validtill'];
		if(trim($vldtll) == 0){
			$valid_till = 0;
			$defpw = '-';
		}else{
			$valid_till = (time()+ ($vldtll*60));
			$defpw=base64_encode($_POST['usr_pw']);
		}
	}else{
		die('Enter all Fields Correctly 1');
	}
	############################33333333


$usr = strtolower(rand(1,10).$fnm);
$hash = gen_hash($pw,$eml);

$checkusrnm = getdatafromsql($conn,"select * from sw_logins where lum_username = '".trim($usr)."'");
if(is_array($checkusrnm)){
	die("Please refresh the Page and resend the post values .");
}

#########################
	if($conn->query("INSERT INTO `sw_logins`(`lum_rel_tu_id`,`lum_email`, `lum_username`, `lum_password`, `lum_hash_mix`, `lum_ad`, `lum_ad_level`,`lum_pass_def`) VALUES 
	('".trim($usr_type)."','".trim($eml)."', '".trim($usr)."', '".trim($pw)."', '".trim($hash)."', '0', '0'
	,'".$_POST['usr_pw']."')")){





	##
		$ltid = $conn->insert_id;
		
						##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['STWL_LUM_DB_ID'],'sw_logins','insert', "INSERT INTO `sw_logins`(`lum_email`, `lum_username`, `lum_password`, `lum_hash_mix`, `lum_ad`, `lum_ad_level`) VALUES 
	('".trim($eml)."', '".trim($usr)."', '".trim($pw)."', '".trim($hash)."', '".trim($ad)."', '".trim($adlvl)."')" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###



	$sqlb = "INSERT INTO `sw_users`(`usr_fname`,`usr_lname`, `usr_dob`,`usr_contact_no`,`usr_rel_lum_id` , `usr_reg_dnt`, `usr_reg_ip`,`usr_validtill`) VALUES (
'".$fnm."',
'".$lnm."',
'".strtotime($dob)."',
'".$number."',
'".$ltid."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$valid_till."')";

	if ($conn->query($sqlb) === TRUE) {
				##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['STWL_LUM_DB_ID'],'sw_users','insert', $sqlb ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




	
    header('Location: admin_users.php');
} else {
    die($conn->error."Error##rujioma");
}
	

	##
	
	}else{
		die($conn->error.'ERRMAIGOTURG');
	}
}
#_______________________________START MODULES_______________________
if(isset($_POST['hash_ac']) and isset($_POST['tab_act'])){
	if(ctype_alnum(trim($_POST['hash_ac']))){
		$checkit = getdatafromsql($conn,"select * from sw_modules where md5(md5(sha1(sha1(md5(md5(concat(mo_id,'njhifverkof2njbivjwj bfurhib2jw'))))))) = '".$_POST['hash_ac']."' and mo_valid =0");
		
		if(is_array($checkit)){
			if($conn->query("update sw_modules set mo_valid =1 where mo_id= ".$checkit['mo_id']."")){
				##### Insert Logs ##################################################################VV3###
		if(preplogs($checkit,$_SESSION['STWL_LUM_DB_ID'],'sw_modules','update', "update sw_modules set mo_valid =1 where mo_id= ".$checkit['mo_id']."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###

								header('Location: admin_mods.php');
			}else{
				die('ERRRMA!JOIrfedNJFO');
			}
		}else{
			die("No Modules\'s Found");
		}
	}else{
		die('Invalid Entries');
	}
}
if(isset($_POST['hash_inc']) and isset($_POST['tab_inact'])){
	if(ctype_alnum(trim($_POST['hash_inc']))){
		$checkit = getdatafromsql($conn,"select * from sw_modules where md5(md5(sha1(sha1(md5(md5(concat(mo_id,'hbujeio03ir94urghnjefr 309i4wef'))))))) = '".$_POST['hash_inc']."' and mo_valid =1");
		
		if(is_array($checkit)){
			if($conn->query("update sw_modules set mo_valid =0 where mo_id= ".$checkit['mo_id']."")){				
##### Insert Logs ##################################################################VV3###
		if(preplogs($checkit,$_SESSION['STWL_LUM_DB_ID'],'sw_modules','update', "update sw_modules set mo_valid =0 where mo_id= ".$checkit['mo_id']."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###


								header('Location: admin_mods.php');
			}else{
				die('ERRRMAjn4rifJOINJFWFEAO');
			}
		}else{
			die("No Modules\'s Found");
		}
	}else{
		die('Invalid Entries');
	}
}
#_______________________________START USER_______________________
if(isset($_POST['yh_com']) and isset($_POST['usr_make_ac'])){
	if(ctype_alnum(trim($_POST['yh_com']))){
		$checkit = getdatafromsql($conn,"select * from sw_logins where 
		md5(md5(sha1(sha1(md5(md5(concat(lum_id,'hir39efnewsfejirjeofkvjrjdnjjenfkvkijonreij3nj'))))))) = '".$_POST['yh_com']."' and lum_valid = 0");
		
		if(is_array($checkit)){
			if($checkit['lum_email'] == 'ayanzcap@hotmail.com'){
				die('Super user can\'t be modified');
			}
			if($conn->query("update sw_logins set lum_valid =1 where lum_id= ".$checkit['lum_id']."")){
								
##### Insert Logs ##################################################################VV3###
		if(preplogs($checkit,$_SESSION['STWL_LUM_DB_ID'],'sw_logins','update', "update sw_logins set lum_valid =1 where lum_id= ".$checkit['lum_id']."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###

								header('Location: admin_users.php');
			}else{
				die('ERRMA3jonkj34oirvfingj');
			}
		}else{
			die("No User Found");
		}
	}else{
		die('Invalid Entries');
	}
}
#
if(isset($_POST['yh_com']) and isset($_POST['usr_make_inac'])){
	if(ctype_alnum(trim($_POST['yh_com']))){
		$checkit = getdatafromsql($conn,"select * from sw_logins where 
		md5(md5(sha1(sha1(md5(md5(concat(lum_id,'hir39efnewsfejirjrjdnjjenfkv ijfkorkvnkorvfk'))))))) = '".$_POST['yh_com']."' and lum_valid = 1");
		
		if(is_array($checkit)){
			if($checkit['lum_email'] == 'ayanzcap@hotmail.com'){
				die('Super user can\'t be deleted');
			}
			if($conn->query("update sw_logins set lum_valid =0 where lum_id= ".$checkit['lum_id']."")){
				
##### Insert Logs ##################################################################VV3###
		if(preplogs($checkit,$_SESSION['STWL_LUM_DB_ID'],'sw_logins','update', "update sw_logins set lum_valid =0 where lum_id= ".$checkit['lum_id']."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




				
								header('Location: admin_users.php');
			}else{
				die('ERRMA3joingj');
			}
		}else{
			die("No User Found");
		}
	}else{
		die('Invalid Entries');
	}
}
#
#_______________________________END USER_______________________
if(isset($_POST['edit_mod'])){
	if(isset($_SESSION['STWL_LUM_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sw_logins where lum_id = ".$_SESSION['STWL_LUM_DB_ID']." and lum_valid = 1 and lum_ad = 1");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}
	if(isset($_POST['hash_emmp__1i'])){
		if(ctype_alnum(trim($_POST['hash_emmp__1i']))){
			$editmun = getdatafromsql($conn,"select * from sw_modules where md5(md5(sha1(sha1(md5(md5(concat(mo_id,'lkoegnuifvh bnn njenjn'))))))) = '".$_POST['hash_emmp__1i']."'");
			#f0b9915082de5819bf562d53aa59b2d2
			
			if(is_string($editmun)){
				die('Hash Not Found');
			}
		}else{
			die('Invalid hash');
		}
	}else{
		die('Hash Not Valid');
	}
	############################33333333
	if(isset($_POST['edit_mod_lngnme'])){
		$nm = $_POST['edit_mod_lngnme'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['edit_mod_shrtnme'])){
		$href = $_POST['edit_mod_shrtnme'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['edit_mod_icon'])){
		$ico = $_POST['edit_mod_icon'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['edit_mod_for'])){
		$mofor = $_POST['edit_mod_for'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['edit_mod_sub']) and is_numeric($_POST['edit_mod_sub'])){
		if(in_range($_POST['edit_mod_sub'],0,1,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 1');
		}
		$subm = $_POST['edit_mod_sub'];
	}else{
		die('Enter all Fields Correctly');
	}
	
	if(1==0){
		#You have not been authorised by MUNCIURCUIT but by trustee so the user has to grant your changes #
		die("You have not been authorised by MUNCIURCUIT but by trustee so the user has to grant your changes ");
	}else{
		if($conn->query("UPDATE `sw_modules` SET 
`mo_name`= '".$nm."',
`mo_href`='".$href."',
`mo_for` = '".$mofor."',
`mo_icon`='".$ico."',
`mo_sub_mod`='".$subm."'
where mo_id = ".trim($editmun['mo_id'])."")){
	
	
	##### Insert Logs ##################################################################VV3###
		if(preplogs($editmun,$_SESSION['STWL_LUM_DB_ID'],'sw_modules','update',"UPDATE `sw_modules` SET 
`mo_name`= '".$nm."',
`mo_href`='".$href."',
`mo_for` = '".$mofor."',
`mo_icon`='".$ico."',
`mo_sub_mod`='".$subm."'
where mo_id = ".trim($editmun['mo_id'])."",$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




	header('Location: admin_mods.php');
		}else{
			die('ERRMAerskirore9njr3ei9jinj');
		}
	}

}
if(isset($_POST['edit_user'])){
	if(isset($_SESSION['STWL_LUM_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sw_logins where lum_id = ".$_SESSION['STWL_LUM_DB_ID']." and lum_valid = 1 and lum_ad = 1");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}
	if(isset($_POST['hash_chkr'])){
		if(ctype_alnum(trim($_POST['hash_chkr']))){
			$editmun = getdatafromsql($conn,"select * from sw_logins where md5(md5(sha1(sha1(md5(md5(concat(lum_id,'f2frbgbe 2fgtegrfr3gbter 24rfgr324frgtr3f 3gr32fgr32f4gr'))))))) = '".$_POST['hash_chkr']."'");
			#f0b9915082de5819bf562d53aa59b2d2
			
			if(is_string($editmun)){
				die('Hash Not Found');
			}
		}else{
			die('Invalid hash');
		}
	}else{
		die('Hash Not Valid');
	}
	
	if(isset($_POST['edit_f_nme'])){
		$fnm = trim($_POST['edit_f_nme']);
	}else{
		die('Enter  edit_f_nme');
	}
	if(isset($_POST['edit_l_nme'])){
		$lnm = trim($_POST['edit_l_nme']);
	}else{
		die('Enter  edit_l_nme');
	}
	if(isset($_POST['edit_us_contact']) and is_numeric($_POST['edit_us_contact'])  and (trim($_POST['edit_us_contact']) !=='')){
		$number = trim($_POST['edit_us_contact']);
	}else{
		die('Enter  edit_us_contact');
	}
	if(isset($_POST['edit_us_pw'])){
		$pt = trim($_POST['edit_us_pw']);
		if(trim($pt) == '-'){
			$pw = $editmun['lum_password'];
			$hash = $editmun['lum_hash_mix'];
		}else{
			$pw = md5(md5(sha1(trim($_POST['edit_us_pw']))));
			$hash = gen_hash($pw,trim($editmun['lum_email']));
		}
	}else{
		die('Enter  edit_us_pw');
	}
	
	if(isset($_POST['edit_us_adm']) and is_numeric($_POST['edit_us_adm'])){
		if(in_range($_POST['edit_us_adm'],0,1,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 1');
		}
		$admer = $_POST['edit_us_adm'];
	}else{
		die('Enter  edit_us_adm');
	}
	
	if(isset($_POST['edit_us_amdlvl']) and is_numeric($_POST['edit_us_amdlvl'])){
		if(in_range($_POST['edit_us_amdlvl'],0,10,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 1');
		}
		$admlvl = $_POST['edit_us_amdlvl'];
	}else{
		die('Enter  edit_us_amdlvl');
	}
	

	
	if(isset($_POST['edit_us_prfpic'])){
		$nprofpic = trim($_POST['edit_us_prfpic']);
	}else{
		die('Enter  edit_us_prfpic');
	}
	
	
	
	if(isset($_POST['edit_us_till'])){
		$startday =trim($_POST['edit_us_till']);
		if(($startday == '0') or ($startday == 0)){
			$usrtill = 0;
		}else{
			$usrtill = time() + (60*$_POST['edit_us_till']);
		}
	}else{
		die('Enter edit_us_till ');
	}
		
	if(1==0){
		#You have not been authorised by MUNCIURCUIT but by trustee so the user has to grant your changes #
		die("You have not been authorised by MUNCIURCUIT but by trustee so the user has to grant your changes ");
	}else{
		$querytobeinserted = "
UPDATE 
	`sw_logins` a,
	`sw_users` b 
SET 
	a.lum_password='".trim($pw)."',
	a.lum_hash_mix='".$hash."',
	a.lum_ad='".$admer."',
	a.lum_ad_level='".$admlvl."',
	b.usr_fname='".$fnm."',
	b.usr_lname='".$lnm."',
	b.usr_contact_no='".$number."',
	b.usr_prof_pic='".$nprofpic."',
	b.usr_back_pic = '".$nprofbg."',
	b.usr_validtill='".trim($usrtill)."'
WHERE
	a.lum_id = b.usr_rel_lum_id and 
	a.lum_id = ".trim($editmun['lum_id'])."";
		if($conn->query($querytobeinserted)){
		
##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['STWL_LUM_DB_ID'],'sw_logins','update',$querytobeinserted,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###

	header('Location: admin_users.php');
		}else{
			die('EmrfuRRMAers');
		}
	}

}
##--------------------------------------------------------------------------------------///------------------------------
/*-------------------------------------------------------------------*/
if(isset($_POST['add_snippet_product'])){
#---------------------------------------
#---------------------------------------
if(isset($_POST['add_snippet_product_name'])){
  if(!is_string($_POST['add_snippet_product_name'])){
  die('Invalid Characters used in add_snippet_product_name');   }
  else{}
}else{
  die('Enter add_snippet_product_name');
}
#---------------------------------------
if(isset($_POST['add_snippet_product_code'])){
  if(!is_string($_POST['add_snippet_product_code'])){
  die('Invalid Characters used in add_snippet_product_code');   }
  else{}
}else{
  die('Enter add_snippet_product_code');
}
#---------------------------------------
if(isset($_POST['add_snippet_product_type'])){
  if(!is_string($_POST['add_snippet_product_type'])){
  die('Invalid Characters used in add_snippet_product_type');   }
  else{}
}else{
  die('Enter add_snippet_product_type');
}
#---------------------------------------
if(isset($_POST['add_snippet_product_supplier'])){
  if(!is_string($_POST['add_snippet_product_supplier'])){
  die('Invalid Characters used in add_snippet_product_supplier');   }
  else{}
}else{
  die('Enter add_snippet_product_supplier');
}
#---------------------------------------
if(isset($_POST['add_snippet_product_qty'])){
  if(!is_string($_POST['add_snippet_product_qty'])){
  die('Invalid Characters used in add_snippet_product_qty');   }
  else{}
}else{
  die('Enter add_snippet_product_qty');
}
#---------------------------------------
if(isset($_POST['add_snippet_product_cost'])){
  if(!is_string($_POST['add_snippet_product_cost'])){
  die('Invalid Characters used in add_snippet_product_cost');   }
  else{}
}else{
  die('Enter add_snippet_product_cost');
}
#---------------------------------------
if(isset($_POST['add_snippet_product_desc'])){
  if(!is_string($_POST['add_snippet_product_desc'])){
  die('Invalid Characters used in add_snippet_product_desc');   }
  else{}
}else{
  die('Enter add_snippet_product_desc');
}
#---------------------------------------
if(isset($_POST['add_snippet_href'])){
  if(!is_string($_POST['add_snippet_href'])){
  die('Invalid Characters used in add_snippet_href');   }
  else{}
}else{
  die('Enter add_snippet_href');
}
#---------------------------------------

$getsupplierdetails = getdatafromsql($conn,"select * from sw_suppliers where md5(sha1(md5(concat('iuergeirjgvjioe',sup_id)))) = '".$_POST['add_snippet_product_supplier']."'");
if(!is_array($getsupplierdetails)){
	die('Supplier Not Found');
}

$getptypedetails = getdatafromsql($conn,"select * from sw_prod_types where md5(sha1(md5(concat('iuergejgvjioe',prty_id)))) = '".$_POST['add_snippet_product_type']."'");
if(!is_array($getptypedetails)){
	die('Product type Not Found');
}
$target_dir = "pr_imgs/";
if(isset($_FILES['add_snippet_product_img']) and ($_FILES['add_snippet_product_img']['size']==0)){
$target_file = $target_dir .'default.png';
$target_file_2 = $target_dir .'default.png';
$target_file_3 = $target_dir .'default.png';
}else if(isset($_FILES['add_snippet_product_img']) and ($_FILES['add_snippet_product_img']['size'] >0)){

					
					
$ext =  extension(basename($_FILES["add_snippet_product_img"]["name"]));
$fold_name =uniqid().'-'.$_POST['add_snippet_product_code'].$_POST['add_snippet_product_name'].$getptypedetails['prty_id'].'-'.$_POST['add_snippet_qty'].'/';
if(mkdir('pr_imgs/'.$fold_name)){
}

$target_file = $target_dir .$fold_name. $_POST['add_snippet_product_code'].''.$_POST['add_snippet_product_name'].'_1.'.$ext;
$target_file_2 = $target_dir .$fold_name. $_POST['add_snippet_product_code'].''.$_POST['add_snippet_product_name'].'_2.'.$ext;
$target_file_3 = $target_dir .$fold_name. $_POST['add_snippet_product_code'].''.$_POST['add_snippet_product_name'].'_3.'.$ext;

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["add_snippet_product_img"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["add_snippet_product_img"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    die("Sorry, your file was not uploaded.");
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["add_snippet_product_img"]["tmp_name"], $target_file) and
	    copy($target_file, $target_file_2) and  
		copy($target_file, $target_file_3) ) {
		

if(resize(120,$target_file_2,$target_file_2)){
	if(resize(300,$target_file_3,$target_file_3)){
}else{
		die('I c N R');
	}

}else{
	die('Images Could not be resized');
}

    } else {
        die( "Sorry, there was an error uploading your file.");
    }
}
}else{
$target_file = $target_dir .'default.png';
$target_file_2 = $target_dir .'default.png';
$target_file_3 = $target_dir .'default.png';	
}
$inssql = "INSERT INTO `sw_products_list`(`pr_rel_prty_id`,`pr_rel_sup_id`,`pr_code`,`pr_img`,`pr_img_2`,`pr_img_3`,`pr_name`, `pr_desc`, `pr_price`,`pr_qty`,`pr_dnt`) VALUES (
'".$getptypedetails['prty_id']."',
'".$getsupplierdetails['sup_id']."',
'".$_POST['add_snippet_product_code']."',
'".$target_file."',
'".$target_file_2."',
'".$target_file_3."',
'".$_POST['add_snippet_product_name']."',
'".$_POST['add_snippet_product_desc']."',
'".$_POST['add_snippet_product_cost']."',
'".$_POST['add_snippet_product_qty']."',
'".time()."'
)";



if ($conn->query($inssql) === TRUE) {
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track("message",$_SESSION['STWL_LUM_DB_ID'],'sw_products_list','INSERT',$inssql,$conn)){
}else{
	die("Only log not generated ");
}
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
	
			header('Location: '.$_POST['add_snippet_href']);
}else {
	die( "ERRMA(PA), Error Inserting Product");
}





}
/*-------------------------------------------------------------------*/
if(isset($_POST['add_client'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die("You Must Login to continue");
	}
#---------------------------------------
if(isset($_POST['add_client_name'])){
  if(!is_string($_POST['add_client_name'])){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter add_client_name');
}
#---------------------------------------
if(isset($_POST['add_client_bnkdet'])){
  if(!is_string($_POST['add_client_bnkdet'])){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter add_client_bnkdet');
}
#---------------------------------------
if(isset($_POST['add_client_tax_code'])){
  if(!is_string($_POST['add_client_tax_code'])){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter add_client_tax_code');
}
#---------------------------------------
if(isset($_POST['add_client_code'])){
  if(!is_string($_POST['add_client_code'])){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter add_client_code');
}
#---------------------------------------
if(isset($_POST['add_client_email'])){
  if(!is_email($_POST['add_client_email'])){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter add_client_email');
}
#---------------------------------------
if(isset($_POST['add_client_bill_addr'])){
  if(!is_string($_POST['add_client_bill_addr'])){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter add_client_bill_addr');
}
#---------------------------------------
if(isset($_POST['_wysihtml5_mode'])){
  if(!is_numeric($_POST['_wysihtml5_mode']) and ($_POST['_wysihtml5_mode'] !== 1) ){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter _wysihtml5_mode');
}
#---------------------------------------
if(isset($_POST['add_client_ship_addr'])){
  if(!is_string($_POST['add_client_ship_addr'])){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter add_client_ship_addr');
}
#---------------------------------------
if(isset($_POST['add_client_phone'])){
  if(!is_string($_POST['add_client_phone'])){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter add_client_phone');
}
#---------------------------------------
if(isset($_POST['add_client_desc'])){
  if(!is_string($_POST['add_client_desc'])){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter add_client_desc');
}
#---------------------------------------
if(isset($_POST['add_client_pyt'])){
  if(!is_string($_POST['add_client_pyt'])){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter add_client_pyt');
}
#---------------------------------------

$ins_sql = "INSERT INTO `sw_clients`( `cli_name`, `cli_bank_details`, `cli_tax_code`, `cli_code`, `cli_desc`, `cli_bill_addr`, `cli_ship_addr`, `cli_email`, `cli_contact_no`, `cli_pay_terms`, `cli_dnt`, `cli_ip`, `cli_added_rel_lum_id`) VALUES 
(
'".$_POST['add_client_name']."',
'".$_POST['add_client_bnkdet']."',
'".$_POST['add_client_tax_code']."',
'".$_POST['add_client_code']."',
'".$_POST['add_client_desc']."',
'".$_POST['add_client_bill_addr']."',
'".$_POST['add_client_ship_addr']."',
'".$_POST['add_client_email']."',
'".$_POST['add_client_phone']."',
'".$_POST['add_client_pyt']."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";

if($conn->query($ins_sql)){
	header('Location: sw_clients.php');
}else{
	die('ERRMA(#)TJ Inserting Client, Contact Admin');
}
	
}
if(isset($_POST['edit_client'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die("You Must Login to continue");
	}
#---------------------------------------
if(isset($_POST['edit_client_name'])){
  if(!is_string($_POST['edit_client_name'])){
  die('Invalid Characters used in edit_client_name');   }
  else{}
}else{
  die('Enter edit_client_name');
}
#---------------------------------------
if(isset($_POST['edit_client_txcd'])){
  if(!is_string($_POST['edit_client_txcd'])){
  die('Invalid Characters used in edit_client_txcd');   }
  else{}
}else{
  die('Enter edit_client_txcd');
}
#---------------------------------------
if(isset($_POST['edit_client_bkdet'])){
  if(!is_string($_POST['edit_client_bkdet'])){
  die('Invalid Characters used in edit_client_bkdet');   }
  else{}
}else{
  die('Enter edit_client_bkdet');
}
#---------------------------------------
if(isset($_POST['edit_client_desc'])){
  if(!is_string($_POST['edit_client_desc'])){
  die('Invalid Characters used in edit_client_desc');   }
  else{}
}else{
  die('Enter edit_client_desc');
}
#---------------------------------------
if(isset($_POST['edit_us_contact'])){
  if(!is_string($_POST['edit_us_contact'])){
  die('Invalid Characters used in edit_us_contact');   }
  else{}
}else{
  die('Enter edit_us_contact');
}
#---------------------------------------
if(isset($_POST['edit_client_email'])){
  if(!is_email($_POST['edit_client_email'])){
  die('Invalid Characters used in edit_client_email');   }
  else{}
}else{
  die('Enter edit_client_email');
}
#---------------------------------------
if(isset($_POST['edit_client_pay_terms'])){
  if(!is_string($_POST['edit_client_pay_terms'])){
  die('Invalid Characters used in edit_client_pay_terms');   }
  else{}
}else{
  die('Enter edit_client_pay_terms');
}
#---------------------------------------
if(isset($_POST['edit_client_bill_addr'])){
  if(!is_string($_POST['edit_client_bill_addr'])){
  die('Invalid Characters used in edit_client_bill_addr');   }
  else{}
}else{
  die('Enter edit_client_bill_addr');
}
#---------------------------------------
if(isset($_POST['_wysihtml5_mode'])){
  if(!is_numeric($_POST['_wysihtml5_mode'])){
  die('Invalid Characters used in _wysihtml5_mode');   }
  else{}
}else{
  die('Enter _wysihtml5_mode');
}
#---------------------------------------
if(isset($_POST['edit_client_ship_addr'])){
  if(!is_string($_POST['edit_client_ship_addr'])){
  die('Invalid Characters used in edit_client_ship_addr');   }
  else{}
}else{
  die('Enter edit_client_ship_addr');
}
#---------------------------------------
if(isset($_POST['edit_client_hash'])){
  if(!ctype_alnum(trim($_POST['edit_client_hash']))){
  die('Invalid Characters used in edit_client_hash');   }
  else{}
}else{
  die('Enter edit_client_hash');
}
#---------------------------------------
$getclient = getdatafromsql($conn,"select * from sw_clients  where cli_valid =1 and md5(md5(sha1(sha1(md5(md5(concat(cli_id,'kjwj 2fgtegrfr3gbter 24rfgr324frgtr3f 3gr32fgr32f4gr'))))))) = '".$_POST['edit_client_hash']."'");
if(is_array($getclient)){
}else{
	die('Client Not found');
}

$ins_sql = "UPDATE `sw_clients` SET 
`cli_name`='".$_POST['edit_client_name']."',
`cli_bank_details`='".$_POST['edit_client_bkdet']."',
`cli_tax_code`='".$_POST['edit_client_txcd']."',
`cli_desc`='".$_POST['edit_client_desc']."',
`cli_bill_addr`='".$_POST['edit_client_bill_addr']."',
`cli_ship_addr`='".$_POST['edit_client_ship_addr']."',
`cli_email`='".$_POST['edit_client_email']."',
`cli_contact_no`='".$_POST['edit_us_contact']."',
`cli_pay_terms`='".$_POST['edit_client_pay_terms']."',
`cli_added_rel_lum_id`=concat(`cli_added_rel_lum_id`,',".$_SESSION['STWL_LUM_DB_ID']."')
 WHERE cli_id = ".$getclient['cli_id']."
";

if($conn->query($ins_sql)){
	header('Location: sw_clients.php');
}else{
	die('ERRMA(#)TH Updating Client, Contact Admin');
}
	
}
/*-------------------------------------------------------------------*/
if(isset($_POST['add_supplier'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die("You Must Login to continue");
	}
#---------------------------------------
if(isset($_POST['add_supplier_name'])){
  if(!is_string($_POST['add_supplier_name'])){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter add_supplier_name');
}
#---------------------------------------
if(isset($_POST['add_supplier_tax_code'])){
  if(!is_string($_POST['add_supplier_tax_code'])){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter add_supplier_tax_code');
}
#---------------------------------------
if(isset($_POST['add_supplier_bnkdet'])){
  if(!is_string($_POST['add_supplier_bnkdet'])){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter add_supplier_bnkdet');
}
#---------------------------------------
if(isset($_POST['add_supplier_code'])){
  if(!is_string($_POST['add_supplier_code'])){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter add_supplier_code');
}
#---------------------------------------
if(isset($_POST['add_supplier_email'])){
  if(!is_email($_POST['add_supplier_email'])){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter add_supplier_email');
}
#---------------------------------------
if(isset($_POST['add_supplier_bill_addr'])){
  if(!is_string($_POST['add_supplier_bill_addr'])){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter add_supplier_bill_addr');
}
#---------------------------------------
if(isset($_POST['_wysihtml5_mode'])){
  if(!is_numeric($_POST['_wysihtml5_mode']) and ($_POST['_wysihtml5_mode'] !== 1) ){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter _wysihtml5_mode');
}
#---------------------------------------
if(isset($_POST['add_supplier_ship_addr'])){
  if(!is_string($_POST['add_supplier_ship_addr'])){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter add_supplier_ship_addr');
}
#---------------------------------------
if(isset($_POST['add_supplier_phone'])){
  if(!is_string($_POST['add_supplier_phone'])){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter add_supplier_phone');
}
#---------------------------------------
if(isset($_POST['add_supplier_desc'])){
  if(!is_string($_POST['add_supplier_desc'])){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter add_supplier_desc');
}
#---------------------------------------
if(isset($_POST['add_supplier_pyt'])){
  if(!is_string($_POST['add_supplier_pyt'])){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter add_supplier_pyt');
}
#---------------------------------------

$ins_sql = "INSERT INTO `sw_suppliers`( `sup_name`,`sup_bank_details`, `sup_tax_code`, `sup_code`, `sup_desc`, `sup_bill_addr`, `sup_ship_addr`, `sup_email`, `sup_contact_no`, `sup_pay_terms`, `sup_dnt`, `sup_ip`, `sup_added_rel_lum_id`) VALUES 
(
'".$_POST['add_supplier_name']."',
'".$_POST['add_supplier_bnkdet']."',
'".$_POST['add_supplier_tax_code']."',
'".$_POST['add_supplier_code']."',
'".$_POST['add_supplier_desc']."',
'".$_POST['add_supplier_bill_addr']."',
'".$_POST['add_supplier_ship_addr']."',
'".$_POST['add_supplier_email']."',
'".$_POST['add_supplier_phone']."',
'".$_POST['add_supplier_pyt']."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";

if($conn->query($ins_sql)){
	header('Location: sw_suppliers.php');
}else{
	die('ERRMA(#)TJ Inserting supplier, Contact Admin');
}
	
}
if(isset($_POST['edit_supplier'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die("You Must Login to continue");
	}
#---------------------------------------
if(isset($_POST['edit_supplier_name'])){
  if(!is_string($_POST['edit_supplier_name'])){
  die('Invalid Characters used in edit_supplier_name');   }
  else{}
}else{
  die('Enter edit_supplier_name');
}
#---------------------------------------
if(isset($_POST['edit_supplier_bkdet'])){
  if(!is_string($_POST['edit_supplier_bkdet'])){
  die('Invalid Characters used in edit_supplier_bkdet');   }
  else{}
}else{
  die('Enter edit_supplier_bkdet');
}
#---------------------------------------
if(isset($_POST['edit_supplier_txcd'])){
  if(!is_string($_POST['edit_supplier_txcd'])){
  die('Invalid Characters used in edit_supplier_txcd');   }
  else{}
}else{
  die('Enter edit_supplier_txcd');
}
#---------------------------------------
if(isset($_POST['edit_supplier_desc'])){
  if(!is_string($_POST['edit_supplier_desc'])){
  die('Invalid Characters used in edit_supplier_desc');   }
  else{}
}else{
  die('Enter edit_supplier_desc');
}
#---------------------------------------
if(isset($_POST['edit_us_contact'])){
  if(!is_string($_POST['edit_us_contact'])){
  die('Invalid Characters used in edit_us_contact');   }
  else{}
}else{
  die('Enter edit_us_contact');
}
#---------------------------------------
if(isset($_POST['edit_supplier_email'])){
  if(!is_email($_POST['edit_supplier_email'])){
  die('Invalid Characters used in edit_supplier_email');   }
  else{}
}else{
  die('Enter edit_supplier_email');
}
#---------------------------------------
if(isset($_POST['edit_supplier_pay_terms'])){
  if(!is_string($_POST['edit_supplier_pay_terms'])){
  die('Invalid Characters used in edit_supplier_pay_terms');   }
  else{}
}else{
  die('Enter edit_supplier_pay_terms');
}
#---------------------------------------
if(isset($_POST['edit_supplier_bill_addr'])){
  if(!is_string($_POST['edit_supplier_bill_addr'])){
  die('Invalid Characters used in edit_supplier_bill_addr');   }
  else{}
}else{
  die('Enter edit_supplier_bill_addr');
}
#---------------------------------------
if(isset($_POST['_wysihtml5_mode'])){
  if(!is_numeric($_POST['_wysihtml5_mode'])){
  die('Invalid Characters used in _wysihtml5_mode');   }
  else{}
}else{
  die('Enter _wysihtml5_mode');
}
#---------------------------------------
if(isset($_POST['edit_supplier_ship_addr'])){
  if(!is_string($_POST['edit_supplier_ship_addr'])){
  die('Invalid Characters used in edit_supplier_ship_addr');   }
  else{}
}else{
  die('Enter edit_supplier_ship_addr');
}
#---------------------------------------
if(isset($_POST['edit_supplier_hash'])){
  if(!ctype_alnum(trim($_POST['edit_supplier_hash']))){
  die('Invalid Characters used in edit_supplier_hash');   }
  else{}
}else{
  die('Enter edit_supplier_hash');
}
#---------------------------------------
$getsupplier = getdatafromsql($conn,"select * from sw_suppliers  where sup_valid =1 and md5(md5(sha1(sha1(md5(md5(concat(sup_id,'kiwi 2fgtegrfr3gbter 24rfgr324frgtr3f 3gr32fgr32f4gr'))))))) = '".$_POST['edit_supplier_hash']."'");
if(is_array($getsupplier)){
}else{
	die('supplier Not found');
}

$ins_sql = "UPDATE `sw_suppliers` SET 
`sup_name`='".$_POST['edit_supplier_name']."',
`sup_bank_details`='".$_POST['edit_supplier_bkdet']."',
`sup_tax_code`='".$_POST['edit_supplier_txcd']."',
`sup_desc`='".$_POST['edit_supplier_desc']."',
`sup_bill_addr`='".$_POST['edit_supplier_bill_addr']."',
`sup_ship_addr`='".$_POST['edit_supplier_ship_addr']."',
`sup_email`='".$_POST['edit_supplier_email']."',
`sup_contact_no`='".$_POST['edit_us_contact']."',
`sup_pay_terms`='".$_POST['edit_supplier_pay_terms']."',
`sup_added_rel_lum_id`=concat(`sup_added_rel_lum_id`,',".$_SESSION['STWL_LUM_DB_ID']."')
 WHERE sup_id = ".$getsupplier['sup_id']."
";

if($conn->query($ins_sql)){
	header('Location: sw_suppliers.php');
}else{
	die('ERRMA(#)TH Updating supplier, Contact Admin');
}
	
}
/*-------------------------------------------------------------------*/
if(isset($_POST['add_prod_type'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die("You Must Login to continue");
	}
#---------------------------------------
if(isset($_POST['add_prod_type_name'])){
  if(!is_string($_POST['add_prod_type_name'])){
  die('Invalid Characters used in add_prod_type_name');   }
  else{}
}else{
  die('Enter add_prod_type_name');
}
#---------------------------------------
if(isset($_POST['add_prod_type_unit'])){
  if(!is_string($_POST['add_prod_type_unit'])){
  die('Invalid Characters used in add_prod_type_unit');   }
  else{}
}else{
  die('Enter add_prod_type_unit');
}
#---------------------------------------
if(isset($_POST['add_prod_type_conv_unir'])){
  if(!is_string($_POST['add_prod_type_conv_unir'])){
  die('Invalid Characters used in add_prod_type_conv_unir');   }
  else{}
}else{
  die('Enter add_prod_type_conv_unir');
}
#---------------------------------------
if(isset($_POST['add_prod_type_formula'])){
  if(!is_numeric($_POST['add_prod_type_formula'])){
  die('Invalid Characters used in add_prod_type_formula');   }
  else{}
}else{
  die('Enter add_prod_type_formula');
}
#---------------------------------------


$ins_sql = "
INSERT INTO `sw_prod_types`( `prty_name`, `prty_unit`, `prty_conv_unit`, `prty_conv_formula`) VALUES
(
'".$_POST['add_prod_type_name']."',
'".$_POST['add_prod_type_unit']."',
'".$_POST['add_prod_type_conv_unir']."',
'".$_POST['add_prod_type_formula']."'
)";

if($conn->query($ins_sql)){
	header('Location: sw_prodtyps.php');
}else{
	die('ERRMA(#)AA Inserting Product Type, Contact Admin');
}
	
}
if(isset($_POST['edit_prod_type'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die("You Must Login to continue");
	}
#---------------------------------------
if(isset($_POST['edit_prod_type_name'])){
  if(!is_string($_POST['edit_prod_type_name'])){
  die('Invalid Characters used in edit_prod_type_name');   }
  else{}
}else{
  die('Enter edit_prod_type_name');
}
#---------------------------------------
if(isset($_POST['edit_prod_type_unit'])){
  if(!is_string($_POST['edit_prod_type_unit'])){
  die('Invalid Characters used in edit_prod_type_unit');   }
  else{}
}else{
  die('Enter edit_prod_type_unit');
}
#---------------------------------------
if(isset($_POST['edit_prod_type_conv_unit'])){
  if(!is_string($_POST['edit_prod_type_conv_unit'])){
  die('Invalid Characters used in edit_prod_type_conv_unit');   }
  else{}
}else{
  die('Enter edit_prod_type_conv_unit');
}
#---------------------------------------
if(isset($_POST['edit_prod_type_formula'])){
  if(!is_numeric($_POST['edit_prod_type_formula'])){
  die('Formula is not numeric');   }
  else{}
}else{
  die('Enter edit_prod_type_formula');
}
#---------------------------------------
if(isset($_POST['edit_prod_type_hash'])){
  if(!is_string($_POST['edit_prod_type_hash'])){
  die('Invalid Characters used in edit_prod_type_hash');   }
  else{}
}else{
  die('Enter edit_prod_type_hash');
}
#---------------------------------------
$getprty = getdatafromsql($conn,"select * from sw_prod_types where prty_valid =1 and 
md5(md5(sha1(sha1(md5(md5(concat(prty_id,'Lalpha 2fgtegrfr3gbter 24rfgr324frgtr3f 3gr32fgr32f4gr'))))))) = '".$_POST['edit_prod_type_hash']."'");
if(is_array($getprty)){
}else{
	die('Product Type Not found');
}

$ins_sql = "UPDATE `sw_prod_types` SET 
`prty_name`='".$_POST['edit_prod_type_name']."',
`prty_unit`='".$_POST['edit_prod_type_unit']."',
`prty_conv_unit`='".$_POST['edit_prod_type_conv_unit']."',
`prty_conv_formula`='".$_POST['edit_prod_type_formula']."'
 WHERE prty_id = ".$getprty['prty_id']."
";

if($conn->query($ins_sql)){
	header('Location: sw_prodtyps.php');
}else{
	die('ERRMA(#)AB Updating Prod Type, Contact Admin');
}
	
}
/*-------------------------------------------------------------------*/
if(isset($_POST['add_product'])){
if(isset($_SESSION['STWL_LUM_DB_ID']) and (trim($_SESSION['STWL_LUM_DB_ID']) !== '')){
}else{
	die('Login to Continue.');
}
#---------------------------------------
if(isset($_POST['add_product_name'])){
  if(!is_string($_POST['add_product_name'])){
  die('Invalid Characters used in add_product_name');   }
  else{}
}else{
  die('Enter add_product_name');
}
#---------------------------------------
if(isset($_POST['add_product_type'])){
  if(!ctype_alnum($_POST['add_product_type'])){
  die('Invalid Characters used in add_product_type');   }
  else{}
}else{
  die('Enter add_product_type');
}
#---------------------------------------
if(isset($_POST['add_product_supplier'])){
  if(!ctype_alnum($_POST['add_product_supplier'])){
  die('Invalid Characters used in add_product_supplier');   }
  else{}
}else{
  die('Enter add_product_supplier');
}
#---------------------------------------
if(isset($_POST['add_product_code'])){
  if(!is_string($_POST['add_product_code'])){
  die('Invalid Characters used in add_product_code');   }
  else{}
}else{
  die('Enter add_product_code');
}
#---------------------------------------
if(isset($_POST['add_product_desc'])){
  if(!is_string($_POST['add_product_desc'])){
  die('Invalid Characters used in add_product_desc');   }
  else{}
}else{
  die('Enter add_product_desc');
}
#---------------------------------------
if(isset($_POST['_wysihtml5_mode'])){
  if(!is_numeric($_POST['_wysihtml5_mode'])){
  die('Invalid Characters used in _wysihtml5_mode');   }
  else{}
}else{
  die('Enter _wysihtml5_mode');
}
#---------------------------------------
if(isset($_POST['add_product_cost'])){
  if(!is_numeric($_POST['add_product_cost'])){
  die('Invalid Characters used in add_product_cost');   }
  else{}
}else{
  die('Enter add_product_cost');
}
#---------------------------------------
if(isset($_POST['add_product_qty'])){
  if(!is_numeric($_POST['add_product_qty'])){
  die('Invalid Characters used in add_product_qty');   }
  else{}
}else{
  die('Enter add_product_qty');
}
#---------------------------------------

$getsupplierdetails = getdatafromsql($conn,"select * from sw_suppliers where md5(sha1(md5(concat('iuergeirjgvjioe',sup_id)))) = '".$_POST['add_product_supplier']."'");
if(!is_array($getsupplierdetails)){
	die('Supplier Not Found');
}

$getptypedetails = getdatafromsql($conn,"select * from sw_prod_types where md5(sha1(md5(concat('iuergejgvjioe',prty_id)))) = '".$_POST['add_product_type']."'");
if(!is_array($getptypedetails)){
	die('Product type Not Found');
}

if(isset($_FILES['add_product_img']) and ($_FILES['add_product_img']['size'] > 0) ){


					
					$target_dir = "pr_imgs/";
$ext =  extension(basename($_FILES["add_product_img"]["name"]));
$fold_name =uniqid().'-'.$_POST['add_product_code'].$_POST['add_product_name'].$getptypedetails['prty_id'].'-'.$_POST['add_product_qty'].'/';
if(mkdir('pr_imgs/'.$fold_name)){
}

$target_file = $target_dir .$fold_name. $_POST['add_product_code'].''.$_POST['add_product_name'].'_1.'.$ext;
$target_file_2 = $target_dir .$fold_name. $_POST['add_product_code'].''.$_POST['add_product_name'].'_2.'.$ext;
$target_file_3 = $target_dir .$fold_name. $_POST['add_product_code'].''.$_POST['add_product_name'].'_3.'.$ext;

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["add_product_img"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["add_product_img"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    die("Sorry, your file was not uploaded.");
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["add_product_img"]["tmp_name"], $target_file) and
	    copy($target_file, $target_file_2) and  
		copy($target_file, $target_file_3) ) {
		

if(resize(120,$target_file_2,$target_file_2)){
	if(resize(300,$target_file_3,$target_file_3)){
}else{
		die('I c N R');
	}

}else{
	die('Images Could not be resized');
}

    } else {
        die( "Sorry, there was an error uploading your file.");
    }
}

}else{
	$target_file = 'pr_imgs/default.png';
$target_file_2 ='pr_imgs/default.png';
$target_file_3 ='pr_imgs/default.png';


}


$inssql = "INSERT INTO `sw_products_list`(`pr_rel_prty_id`,`pr_rel_sup_id`,`pr_code`,`pr_img`,`pr_img_2`,`pr_img_3`,`pr_name`, `pr_desc`, `pr_price`,`pr_qty`,`pr_dnt`) VALUES (
'".$getptypedetails['prty_id']."',
'".$getsupplierdetails['sup_id']."',
'".$_POST['add_product_code']."',
'".$target_file."',
'".$target_file_2."',
'".$target_file_3."',
'".$_POST['add_product_name']."',
'".$_POST['add_product_desc']."',
'".$_POST['add_product_cost']."',
'".$_POST['add_product_qty']."',
'".time()."'
)";
if ($conn->query($inssql) === TRUE) {
	header('Location: inven.php');
}else {
	die( "ERRMA(PA), Error Inserting Product");
}

}
if(isset($_POST['edit_product'])){
if(isset($_SESSION['STWL_LUM_DB_ID']) and (trim($_SESSION['STWL_LUM_DB_ID']) !== '')){
}else{
	die('Login to Continue.');
}

#---------------------------------------
if(isset($_POST['edit_product_name'])){
  if(!is_string($_POST['edit_product_name'])){
  die('Invalid Characters used in edit_product_name');   }
  else{}
}else{
  die('Enter edit_product_name');
}
#---------------------------------------
if(isset($_POST['edit_product_desc'])){
  if(!is_string($_POST['edit_product_desc'])){
  die('Invalid Characters used in edit_product_desc');   }
  else{}
}else{
  die('Enter edit_product_desc');
}
#---------------------------------------
if(isset($_POST['_wysihtml5_mode'])){
  if(!is_numeric($_POST['_wysihtml5_mode'])){
  die('Invalid Characters used in _wysihtml5_mode');   }
  else{}
}else{
  die('Enter _wysihtml5_mode');
}
#---------------------------------------
if(isset($_POST['edit_product_cost'])){
  if(!is_numeric($_POST['edit_product_cost'])){
  die('Invalid Characters used in edit_product_cost');   }
  else{}
}else{
  die('Enter edit_product_cost');
}
#---------------------------------------
if(isset($_POST['edit_product_qty'])){
  if(!is_numeric($_POST['edit_product_qty'])){
  die('Invalid Characters used in edit_product_qty');   }
  else{}
}else{
  die('Enter edit_product_qty');
}
#---------------------------------------
if(isset($_POST['edit_product_hash'])){
  if(!ctype_alnum($_POST['edit_product_hash'])){
  die('Invalid Characters used in edit_product_hash');   }
  else{}
}else{
  die('Enter edit_product_hash');
}
#---------------------------------------

$getproduct = getdatafromsql($conn,"select * from sw_products_list where md5(md5(sha1(sha1(md5(md5(concat(pr_id,'f2fkjwiuef0rjigbter 24rfgr324frgtr3f 3gr32fgr32f4gr'))))))) = '".$_POST['edit_product_hash']."'");
if(!is_array($getproduct)){
	die('Product Not Found');
}


$inssql = "update `sw_products_list`
set `pr_name`='".$_POST['edit_product_name']."',
`pr_desc`='".$_POST['edit_product_desc']."',
`pr_price`='".$_POST['edit_product_cost']."',
`pr_qty`='".$_POST['edit_product_qty']."'
where pr_id = ".$getproduct['pr_id']."
";
if ($conn->query($inssql) === TRUE) {
	header('Location: inven.php');
}else {
	die($conn->error. "ERRMA(PB), Error Updating Product");
}

}
/*-------------------------------------------------------------------*/
if(isset($_POST['add_showroom'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die("You Must Login to continue");
	}
#---------------------------------------
if(isset($_POST['add_showroom_name'])){
  if(!is_string($_POST['add_showroom_name'])){
  die('Invalid Characters used in add_showroom_name');   }
  else{}
}else{
  die('Enter add_showroom_name');
}
#---------------------------------------
if(isset($_POST['add_showroom_address'])){
  if(!is_string($_POST['add_showroom_address'])){
  die('Invalid Characters used in add_showroom_address');   }
  else{}
}else{
  die('Enter add_showroom_address');
}
#---------------------------------------

$ins_sql = "INSERT INTO `sw_showrooms`( `shw_name`, `shw_address`) VALUES 
(
'".$_POST['add_showroom_name']."',
'".$_POST['add_showroom_address']."'
)";

if($conn->query($ins_sql)){
	header('Location: sw_showrooms.php');
}else{
	die('ERRMA(#)UJ Inserting Showroom, Contact Admin');
}
	
}
if(isset($_POST['edit_showroom'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die("You Must Login to continue");
	}
#---------------------------------------
if(isset($_POST['edit_showroom_name'])){
  if(!is_string($_POST['edit_showroom_name'])){
  die('Invalid Characters used in edit_showroom_name');   }
  else{}
}else{
  die('Enter edit_showroom_name');
}
#---------------------------------------
if(isset($_POST['edit_showroom_address'])){
  if(!is_string($_POST['edit_showroom_address'])){
  die('Invalid Characters used in edit_showroom_address');   }
  else{}
}else{
  die('Enter edit_showroom_address');
}
#---------------------------------------
if(isset($_POST['edit_showroom_hash'])){
  if(!ctype_alnum($_POST['edit_showroom_hash'])){
  die('Invalid Characters used in edit_showroom_hash');   }
  else{}
}else{
  die('Enter edit_showroom_hash');
}
#---------------------------------------

$getshow= getdatafromsql($conn,"select * from sw_showrooms where shw_valid =1 and 
md5(md5(sha1(sha1(md5(md5(concat(shw_id,'3895ur 2fgtegrfr3gbter 24rfgr324frgtr3f 3gr32fgr32f4gr'))))))) = '".$_POST['edit_showroom_hash']."'");
if(is_array($getshow)){
}else{
	die('Showroom Not found');
}

$ins_sql = "UPDATE `sw_showrooms` SET 
`shw_name`='".$_POST['edit_showroom_name']."',
`shw_address`='".$_POST['edit_showroom_address']."'
 WHERE shw_id = ".$getshow['shw_id']."
";

if($conn->query($ins_sql)){
	header('Location: sw_showrooms.php');
}else{
	die('ERRMA(#)UH Updating Showroom, Contact Admin');
}
	
}
/*-------------------------------------------------------------------*/
if(isset($_POST['edit_showroomproduct'])){
if(isset($_SESSION['STWL_LUM_DB_ID']) and (trim($_SESSION['STWL_LUM_DB_ID']) !== '')){
}else{
	die('Login to Continue.');
}

#---------------------------------------
if(isset($_POST['edit_showroomproduct_qty'])){
  if(!is_numeric($_POST['edit_showroomproduct_qty'])){
  die('Invalid Characters used in edit_showroomproduct_qty');   }
  else{}
}else{
  die('Enter edit_showroomproduct_qty');
}
#---------------------------------------
if(isset($_POST['edit_showroomproduct_hash'])){
  if(!ctype_alnum($_POST['edit_showroomproduct_hash'])){
  die('Invalid Characters used in edit_showroomproduct_hash');   }
  else{}
}else{
  die('Enter edit_showroomproduct_hash');
}
#---------------------------------------

$getproduct = getdatafromsql($conn,"select * from sw_products_list_show where md5(md5(sha1(sha1(md5(md5(concat(sh_id,'ws f2fkjwiuef0rjigbter 24rfgr324frgtr3f 3gr32fgr32f4gr'))))))) = '".$_POST['edit_showroomproduct_hash']."'");
if(!is_array($getproduct)){
	die('Show Product Not Found');
}


$inssql = "update `sw_products_list_show`
set `sh_qty`='".$_POST['edit_showroomproduct_qty']."'
where sh_id = ".$getproduct['sh_id']."
";
if ($conn->query($inssql) === TRUE) {
	header('Location: inven_show.php');
}else {
	die($conn->error. "ERRMA(EB), Error Updating Product Show");
}

}
if(isset($_POST['add_showroomproduct_old'])){
if(isset($_SESSION['STWL_LUM_DB_ID']) and (trim($_SESSION['STWL_LUM_DB_ID']) !== '')){
}else{
	die('Login to Continue.');
}
#---------------------------------------
if(isset($_POST['add_showroomproduct_old_pr_hash'])){
  if(!ctype_alnum($_POST['add_showroomproduct_old_pr_hash'])){
  die('Invalid Characters used in add_showroomproduct_old_pr_hash');   }
  else{}
}else{
  die('Enter add_showroomproduct_old_pr_hash');
}
#---------------------------------------
if(isset($_POST['add_showroomproduct_old_sh_hash'])){
  if(!ctype_alnum($_POST['add_showroomproduct_old_sh_hash'])){
  die('Invalid Characters used in add_showroomproduct_old_sh_hash');   }
  else{}
}else{
  die('Enter add_showroomproduct_old_sh_hash');
}
#---------------------------------------
if(isset($_POST['add_showroomproduct_old_qty'])){
  if(!is_numeric($_POST['add_showroomproduct_old_qty'])){
  die('Invalid Characters used in add_showroomproduct_old_qty');   }
  else{}
}else{
  die('Enter add_showroomproduct_old_qty');
}
#---------------------------------------

$getpprod= getdatafromsql($conn,"select * from sw_products_list where md5(sha1(md5(sha1(concat('0u9i4nuvt5859e-g',pr_id))))) = '".$_POST['add_showroomproduct_old_pr_hash']."'");
if(!is_array($getpprod)){
	die('Product Not Found');
}

$getshowroom  = getdatafromsql($conn,"SELECT * FROM sw_showrooms where shw_valid =1 and  md5(sha1(md5(sha1(concat('0u9i4nuvt5859f-g',shw_id))))) = '".$_POST['add_showroomproduct_old_sh_hash']."'");
if(!is_array($getshowroom )){
	die('Showroom Not Found');
}

$inssql = "
INSERT INTO `sw_products_list_show`( `sh_rel_pr_id`, `sh_rel_shw_id`, `sh_qty`, `sh_dnt`) 
VALUES (
'".$getpprod['pr_id']."',
'".$getshowroom['shw_id']."',
'".$_POST['add_showroomproduct_old_qty']."',
'".time()."'
)";
if ($conn->query($inssql) === TRUE) {
	header('Location: inven_show.php');
}else {
	die( "ERRMA(SA), Error Inserting Product");
}

}
if(isset($_POST['add_showroomproduct_new'])){
if(isset($_SESSION['STWL_LUM_DB_ID']) and (trim($_SESSION['STWL_LUM_DB_ID']) !== '')){
}else{
	die('Login to Continue.');
}
#---------------------------------------
if(isset($_POST['add_showroomproduct_pr_name'])){
  if(!is_string($_POST['add_showroomproduct_pr_name'])){
  die('Invalid Characters used in add_showroomproduct_pr_name');   }
  else{}
}else{
  die('Enter add_showroomproduct_pr_name');
}
#---------------------------------------
if(isset($_POST['add_showroomproduct_pr_type'])){
  if(!ctype_alnum($_POST['add_showroomproduct_pr_type'])){
  die('Invalid Characters used in add_showroomproduct_pr_type');   }
  else{}
}else{
  die('Enter add_showroomproduct_pr_type');
}
#---------------------------------------
if(isset($_POST['add_showroomproduct_pr_supplier'])){
  if(!ctype_alnum($_POST['add_showroomproduct_pr_supplier'])){
  die('Invalid Characters used in add_showroomproduct_pr_supplier');   }
  else{}
}else{
  die('Enter add_showroomproduct_pr_supplier');
}
#---------------------------------------
if(isset($_POST['add_showroomproduct_pr_showroom'])){
  if(!ctype_alnum($_POST['add_showroomproduct_pr_showroom'])){
  die('Invalid Characters used in add_showroomproduct_pr_showroom');   }
  else{}
}else{
  die('Enter add_showroomproduct_pr_showroom');
}
#---------------------------------------
if(isset($_POST['add_showroomproduct_pr_code'])){
  if(!is_string($_POST['add_showroomproduct_pr_code'])){
  die('Invalid Characters used in add_showroomproduct_pr_code');   }
  else{}
}else{
  die('Enter add_showroomproduct_pr_code');
}
#---------------------------------------
if(isset($_POST['add_showroomproduct_pr_desc'])){
  if(!is_string($_POST['add_showroomproduct_pr_desc'])){
  die('Invalid Characters used in add_showroomproduct_pr_desc');   }
  else{}
}else{
  die('Enter add_showroomproduct_pr_desc');
}
#---------------------------------------
if(isset($_POST['_wysihtml5_mode'])){
  if(!is_numeric($_POST['_wysihtml5_mode'])){
  die('Invalid Characters used in _wysihtml5_mode');   }
  else{}
}else{
  die('Enter _wysihtml5_mode');
}
#---------------------------------------
if(isset($_POST['add_showroomproduct_pr_cost'])){
  if(!is_numeric($_POST['add_showroomproduct_pr_cost'])){
  die('Invalid Characters used in add_showroomproduct_pr_cost');   }
  else{}
}else{
  die('Enter add_showroomproduct_pr_cost');
}
#---------------------------------------
if(isset($_POST['add_showroomproduct_pr_qty'])){
  if(!is_numeric($_POST['add_showroomproduct_pr_qty'])){
  die('Invalid Characters used in add_showroomproduct_pr_qty');   }
  else{}
}else{
  die('Enter add_showroomproduct_pr_qty');
}
#---------------------------------------

$getsupplierdetails = getdatafromsql($conn,"select * from sw_suppliers where md5(sha1(md5(concat('iuergeirjgvjioe',sup_id)))) = '".$_POST['add_showroomproduct_pr_supplier']."'");
if(!is_array($getsupplierdetails)){
	die('Supplier Not Found');
}

$getptypedetails = getdatafromsql($conn,"select * from sw_prod_types where md5(sha1(md5(concat('iuergejgvjioe',prty_id)))) = '".$_POST['add_showroomproduct_pr_type']."'");
if(!is_array($getptypedetails)){
	die('Product type Not Found');
}

$getshwrmdetails = getdatafromsql($conn,"select * from sw_showrooms where md5(sha1(md5(concat('iuergyugeirjgvjioe', shw_id)))) = '".$_POST['add_showroomproduct_pr_showroom']."'");
if(!is_array($getshwrmdetails)){
	die('Showroom Not Found');
}
if(!isset($_FILES['add_showroomproduct_pr_img']) or (trim($_FILES["add_showroomproduct_pr_img"]["name"]) == '')){
	$target_file = "pr_imgs/default.png";
	$target_file_2 = "pr_imgs/default.png";
	$target_file_3 = "pr_imgs/default.png";
}else{

					
	$target_dir = "pr_imgs/";
	$ext =  extension(basename($_FILES["add_showroomproduct_pr_img"]["name"]));
	$fold_name =uniqid().'-'.$_POST['add_showroomproduct_pr_code'].$_POST['add_showroomproduct_pr_name'].$getptypedetails['prty_id'].'-'.$_POST['add_showroomproduct_pr_qty'].'/';
	if(mkdir('pr_imgs/'.$fold_name)){
	}
	
	$target_file = $target_dir .$fold_name. $_POST['add_showroomproduct_pr_code'].''.$_POST['add_showroomproduct_pr_name'].'_1.'.$ext;
	$target_file_2 = $target_dir .$fold_name. $_POST['add_showroomproduct_pr_code'].''.$_POST['add_showroomproduct_pr_name'].'_2.'.$ext;
	$target_file_3 = $target_dir .$fold_name. $_POST['add_showroomproduct_pr_code'].''.$_POST['add_showroomproduct_pr_name'].'_3.'.$ext;
	
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
		$check = getimagesize($_FILES["add_showroomproduct_pr_img"]["tmp_name"]);
		if($check !== false) {
			$uploadOk = 1;
		} else {
			$uploadOk = 0;
		}
	// Check if file already exists
	if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}
	// Check file size
	if ($_FILES["add_showroomproduct_pr_img"]["size"] > 5000000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		die("Sorry, your file was not uploaded.");
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["add_showroomproduct_pr_img"]["tmp_name"], $target_file) and
			copy($target_file, $target_file_2) and  
			copy($target_file, $target_file_3) ) {
			
	
	if(resize(120,$target_file_2,$target_file_2)){
		if(resize(300,$target_file_3,$target_file_3)){
	}else{
			die('I c N R');
		}
	
	}else{
		die('Images Could not be resized');
	}
	
		} else {
			die( "Sorry, there was an error uploading your file.");
		}
	}
	}
$inssql = "INSERT INTO `sw_products_list`(`pr_rel_prty_id`,`pr_rel_sup_id`,`pr_code`,`pr_img`,`pr_img_2`,`pr_img_3`,`pr_name`, `pr_desc`, `pr_price`,`pr_qty`,`pr_dnt`,`pr_visible`) VALUES (
'".$getptypedetails['prty_id']."',
'".$getsupplierdetails['sup_id']."',
'".$_POST['add_showroomproduct_pr_code']."',
'".$target_file."',
'".$target_file_2."',
'".$target_file_3."',
'".$_POST['add_showroomproduct_pr_name']."',
'".$_POST['add_showroomproduct_pr_desc']."',
'".$_POST['add_showroomproduct_pr_cost']."',
'".$_POST['add_showroomproduct_pr_qty']."',
'".time()."', 1
)";
if ($conn->query($inssql) === TRUE) {
if(is_numeric($conn->insert_id)){
}else{
	die("Product could not be inserted");
}
	$ininnersql = "INSERT INTO `sw_products_list_show`(`sh_rel_pr_id`,`sh_rel_shw_id`,`sh_qty`,`sh_dnt`) VALUES (
	'".$conn->insert_id."',
	'".$getshwrmdetails['shw_id']."',
	'".$_POST['add_showroomproduct_pr_qty']."',
	'".time()."'
	)";
	if ($conn->query($ininnersql) === TRUE) {
		header('Location: inven_show.php');
	}else {
		die( "ERRMA(PdAkrmA), Error Inserting Product into Showroom");
	}

}else {
	die( "ERRMA(PkrmA), Error Inserting InVisible Product");
}

}
if(isset($_POST['prname']) and ctype_alnum(trim($_POST['prname']))){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die("Login to continue");
	}
	$getprod = getdatafromsql($conn,"select * from sw_products_list where md5(sha1(md5(sha1(concat('0u9i4nuvt5859e-g',pr_id))))) = '".$_POST['prname']."' 
	and pr_valid =1");
	if(is_array($getprod)){
		
		
		$showroommock =array();	
$clisql = "select *, sum(mock_qty) as qty  from sw_mockups 
left join sw_clients on mock_rel_cli_id = cli_id
left join sw_showrooms on mock_rel_shw_id = shw_id
left join sw_suppliers on mock_rel_sup_id = sup_id
where mock_rel_pr_id = ".$getprod['pr_id']." group by mock_rel_cli_id";
$clisql = $conn->query($clisql);
	$mqty = 0;
if ($clisql->num_rows > 0) {
    // output data of each row
	
    while($clisqlrow = $clisql->fetch_assoc()) {
		$mocksqty = $clisqlrow['qty'];
		
		
if($clisqlrow['mock_rel_shw_id'] > 0){
	if(isset($showroommock[$clisqlrow['mock_rel_shw_id']])){
		$showroommock[$clisqlrow['mock_rel_shw_id']] = $showroommock[$clisqlrow['mock_rel_shw_id']] + $clisqlrow['qty'];	
	}else{
		$showroommock[$clisqlrow['mock_rel_shw_id']] = $clisqlrow['qty'];	
	}
}

$mqty = $mqty +$mocksqty;
    }
} else {
}		

		
$shwsql = "select * , sum(sh_qty) as qty from sw_products_list_show left join sw_showrooms on sh_rel_shw_id = shw_id where sh_rel_pr_id = '".$getprod['pr_id']."' group by shw_id ";
$shwsql = $conn->query($shwsql);
	$shqty = 0;
if ($shwsql->num_rows > 0) {
    // output data of each row
    while($shwsqlrow = $shwsql->fetch_assoc()) {
				$showroomqty = $shwsqlrow['qty'];

	if(isset($showroommock[$shwsqlrow['sh_rel_shw_id']])){
		$showroomqty = $showroomqty - $showroommock[$shwsqlrow['sh_rel_shw_id']] ;	
	}
		$shqty = $shqty +$showroomqty;
    }
} else {
}		

 $totalbusy = $mqty + $shqty; 
  
 
 
		$t = array('qty'=>($getprod['pr_qty'] - $totalbusy),'prname'=>$getprod['pr_code'].'-'.$getprod['pr_name'].' ');
		echo json_encode($t);
	}else{
		$t = array('qty'=>0,'prname'=>'Product ');
		echo json_encode($t);
	}
}
if(isset($_POST['pr_nm']) and isset($_POST['sup_nm']) and ctype_alnum(trim($_POST['pr_nm'])) and ctype_alnum(trim($_POST['sup_nm']))){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die("Login to continue");
	}
	$getprod = getdatafromsql($conn,"select * from sw_products_list where md5(sha1(md5(sha1(concat('0u9i4nuvt5859e-g',pr_id))))) = '".$_POST['pr_nm']."' 
	and pr_valid =1");

	$getshow= getdatafromsql($conn,"select * from sw_showrooms where md5(sha1(md5(sha1(concat('0u9i4nuvt5859f-g',shw_id))))) = '".$_POST['sup_nm']."' 
	and shw_valid =1");

	if(is_array($getprod)){
	}else{
		die('Invalid Product');
	}
	if(is_array($getshow)){
	}else{
		die('Invalid Showroom');
	}
	$checkavail = getdatafromsql($conn,"select * from sw_products_list_show where sh_rel_pr_id = ".$getprod['pr_id']." and sh_rel_shw_id= ".$getshow['shw_id']." and sh_valid =1 "); 
	if(is_array($checkavail)){
		echo json_encode(array('a'=>'This product is already in the same showroom, try increasing the quantity from above'));
	}else{
		echo json_encode(array('a'=>'b'));
	}
}
/*--------------------------------------------------------------------*/
if(isset($_POST['edit_mock'])){
if(isset($_SESSION['STWL_LUM_DB_ID']) and (trim($_SESSION['STWL_LUM_DB_ID']) !== '')){
}else{
	die('Login to Continue.');
}

#---------------------------------------
if(isset($_POST['edit_mock_qty'])){
  if(!is_numeric($_POST['edit_mock_qty'])){
  die('Invalid Characters used in edit_mock_qty');   }
  else{}
}else{
  die('Enter edit_mock_qty');
}
#---------------------------------------
if(isset($_POST['edit_mock_returned'])){
  if(!is_numeric($_POST['edit_mock_returned'])){
  die('Invalid Characters used in edit_mock_returned');   }
  else{
	  if($_POST['edit_mock_returned'] === '0' or $_POST['edit_mock_returned'] === '1'){
	  }else{
		  die('Invalid Returned');
	  }
	  }
}else{
  die('Enter edit_mock_returned');
}
#---------------------------------------
if(isset($_POST['edit_mock_remarks'])){
  if(!is_string($_POST['edit_mock_remarks'])){
  die('Invalid Characters used in edit_mock_remarks');   }
  else{}
}else{
  die('Enter edit_mock_remarks');
}
#---------------------------------------
if(isset($_POST['edit_mock_hash'])){
  if(!ctype_alnum($_POST['edit_mock_hash'])){
  die('Invalid Characters used in edit_mock_hash');   }
  else{}
}else{
  die('Enter edit_mock_hash');
}
#---------------------------------------


$getproduct = getdatafromsql($conn,"select * from sw_mockups where md5(md5(sha1(sha1(md5(md5(concat(mock_id,'dedws f2fkjwiuef0rjigbter 24rfgr324frgtr3f 3gr32fgr32f4gr'))))))) = '".$_POST['edit_mock_hash']."' and mock_valid =1");
if(!is_array($getproduct)){
	die('Mock Product Not Found');
}

if(($getproduct['mock_returned'] === '0') and ($_POST['edit_mock_returned'] === '1')){
	$returndnt = time();
}else if(($getproduct['mock_returned'] === '0') and ($_POST['edit_mock_returned'] === '0')){
	$returndnt = 0;
}else if(($getproduct['mock_returned'] === '1') and ($_POST['edit_mock_returned'] === '0')){
	$returndnt = 0;
}else if(($getproduct['mock_returned'] === '1') and ($_POST['edit_mock_returned'] === '1')){
	$returndnt = $getproduct['mock_returned_dnt'];
}else{
	die('Invalid Case in Mockups');
}
$inssql = "update `sw_mockups`
set `mock_qty`='".$_POST['edit_mock_qty']."',
`mock_returned`='".$_POST['edit_mock_returned']."',
`mock_remarks`='".$_POST['edit_mock_remarks']."',
`mock_returned_dnt` = '".$returndnt."'
where mock_id = ".$getproduct['mock_id']."
";
if ($conn->query($inssql) === TRUE) {
	header('Location: mockup.php');
}else {
	die($conn->error. "ERRMA(FB), Error Updating Mockup");
}

}
if(isset($_POST['add_mockup_warehouse_old_client'])){
#---------------------------------------
if(isset($_POST['add_mockup_warehouse_old_product_hash'])){
  if(!ctype_alnum($_POST['add_mockup_warehouse_old_product_hash'])){
  die('Invalid Characters used in add_mockup_warehouse_old_product_hash');   }
  else{}
}else{
  die('Enter add_mockup_warehouse_old_product_hash');
}
#---------------------------------------
if(isset($_POST['add_mockup_warehouse_old_client_hash'])){
  if(!ctype_alnum($_POST['add_mockup_warehouse_old_client_hash'])){
  die('Invalid Characters used in add_mockup_warehouse_old_client_hash');   }
  else{}
}else{
  die('Enter add_mockup_warehouse_old_client_hash');
}
#---------------------------------------
if(isset($_POST['add_mockup_warehouse_old_qty'])){
  if(!is_numeric($_POST['add_mockup_warehouse_old_qty'])){
  die('Invalid Characters used in add_mockup_warehouse_old_qty');   }
  else{}
}else{
  die('Enter add_mockup_warehouse_old_qty');
}
#---------------------------------------

$product= getdatafromsql($conn,"select * from sw_products_list where pr_valid= 1 and md5(sha1(md5(concat('iueriowenejgvjioe',pr_id))))='".$_POST['add_mockup_warehouse_old_product_hash']."'");
if(!is_array($product)){
	die('Product not found');
}
$client = getdatafromsql($conn,"select * from sw_clients where cli_valid= 1 and md5(sha1(md5(concat('3oiwjf3oihegnr ikjn fm',cli_id))))='".$_POST['add_mockup_warehouse_old_client_hash']."'");
if(!is_array($client)){
	die('Client not found');
}

$insert = "INSERT INTO `sw_mockups`( `mock_rel_msf_id`, `mock_rel_pr_id`, `mock_rel_cli_id`, `mock_qty`, `mock_added_dnt`, `mock_rel_lum_id`) VALUES (
'1',
'".$product['pr_id']."',
'".$client['cli_id']."',
'".$_POST['add_mockup_warehouse_old_qty']."',
'".time()."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";

if($conn->query($insert)){
	header('Location: mockup.php');
}else{
	die("Could not insert query");
}

}
if(isset($_POST['add_mockup_warehouse_new'])){
#---------------------------------------
if(isset($_POST['add_mockup_warehouse_new_product_hash'])){
  if(!ctype_alnum($_POST['add_mockup_warehouse_new_product_hash'])){
  die('Invalid Characters used in add_mockup_warehouse_new_product_hash');   }
  else{}
}else{
  die('Enter add_mockup_warehouse_new_product_hash');
}
#---------------------------------------
if(isset($_POST['add_mockup_warehouse_new_qty'])){
  if(!is_numeric($_POST['add_mockup_warehouse_new_qty'])){
  die('Invalid Characters used in add_mockup_warehouse_new_qty');   }
  else{}
}else{
  die('Enter add_mockup_warehouse_new_qty');
}
#---------------------------------------
if(isset($_POST['add_mockup_warehouse_new_client_name'])){
  if(!is_string($_POST['add_mockup_warehouse_new_client_name'])){
  die('Invalid Characters used in add_mockup_warehouse_new_client_name');   }
  else{}
}else{
  die('Enter add_mockup_warehouse_new_client_name');
}
#---------------------------------------
if(isset($_POST['add_mockup_warehouse_new_client_code'])){
  if(!is_string($_POST['add_mockup_warehouse_new_client_code'])){
  die('Invalid Characters used in add_mockup_warehouse_new_client_code');   }
  else{}
}else{
  die('Enter add_mockup_warehouse_new_client_code');
}
#---------------------------------------
if(isset($_POST['add_mockup_warehouse_new_client_desc'])){
  if(!is_string($_POST['add_mockup_warehouse_new_client_desc'])){
  die('Invalid Characters used in add_mockup_warehouse_new_client_desc');   }
  else{}
}else{
  die('Enter add_mockup_warehouse_new_client_desc');
}
#---------------------------------------
if(isset($_POST['add_mockup_warehouse_new_client_email'])){
  if(!is_email($_POST['add_mockup_warehouse_new_client_email'])){
  die('Invalid Characters used in add_mockup_warehouse_new_client_email');   }
  else{}
}else{
  die('Enter add_mockup_warehouse_new_client_email');
}
#---------------------------------------
if(isset($_POST['add_mockup_warehouse_new_client_phone'])){
  if(!is_string($_POST['add_mockup_warehouse_new_client_phone'])){
  die('Invalid Characters used in add_mockup_warehouse_new_client_phone');   }
  else{}
}else{
  die('Enter add_mockup_warehouse_new_client_phone');
}
#---------------------------------------
if(isset($_POST['add_mockup_warehouse_new_client_bill_addr'])){
  if(!is_string($_POST['add_mockup_warehouse_new_client_bill_addr'])){
  die('Invalid Characters used in add_mockup_warehouse_new_client_bill_addr');   }
  else{}
}else{
  die('Enter add_mockup_warehouse_new_client_bill_addr');
}
#---------------------------------------
if(isset($_POST['_wysihtml5_mode'])){
  if(!is_numeric($_POST['_wysihtml5_mode'])){
  die('Invalid Characters used in _wysihtml5_mode');   }
  else{}
}else{
  die('Enter _wysihtml5_mode');
}
#---------------------------------------
if(isset($_POST['add_mockup_warehouse_new_client_ship_addr'])){
  if(!is_string($_POST['add_mockup_warehouse_new_client_ship_addr'])){
  die('Invalid Characters used in add_mockup_warehouse_new_client_ship_addr');   }
  else{}
}else{
  die('Enter add_mockup_warehouse_new_client_ship_addr');
}
#---------------------------------------
if(isset($_POST['add_mockup_warehouse_new_client_tax_code'])){
  if(!is_string($_POST['add_mockup_warehouse_new_client_tax_code'])){
  die('Invalid Characters used in add_mockup_warehouse_new_client_tax_code');   }
  else{}
}else{
  die('Enter add_mockup_warehouse_new_client_tax_code');
}
#---------------------------------------
if(isset($_POST['add_mockup_warehouse_new_client_bank_details'])){
  if(!is_string($_POST['add_mockup_warehouse_new_client_bank_details'])){
  die('Invalid Characters used in add_mockup_warehouse_new_client_bank_details');   }
  else{}
}else{
  die('Enter add_mockup_warehouse_new_client_bank_details');
}
#---------------------------------------
if(isset($_POST['add_mockup_warehouse_new_client_pay_terms'])){
  if(!is_string($_POST['add_mockup_warehouse_new_client_pay_terms'])){
  die('Invalid Characters used in add_mockup_warehouse_new_client_pay_terms');   }
  else{}
}else{
  die('Enter add_mockup_warehouse_new_client_pay_terms');
}
#---------------------------------------


$product= getdatafromsql($conn,"select * from sw_products_list where pr_valid= 1 and md5(sha1(md5(concat('iueriowenejgvjioe',pr_id))))='".$_POST['add_mockup_warehouse_new_product_hash']."'");
if(!is_array($product)){
	die('Product not found');
}

$ins_sql = "INSERT INTO `sw_clients`( `cli_name`, `cli_bank_details`, `cli_tax_code`, `cli_code`, `cli_desc`, `cli_bill_addr`, `cli_ship_addr`, `cli_email`, `cli_contact_no`, `cli_pay_terms`, `cli_dnt`, `cli_ip`, `cli_added_rel_lum_id`) VALUES 
(
'".$_POST['add_mockup_warehouse_new_client_name']."',
'".$_POST['add_mockup_warehouse_new_client_bank_details']."',
'".$_POST['add_mockup_warehouse_new_client_tax_code']."',
'".$_POST['add_mockup_warehouse_new_client_code']."',
'".$_POST['add_mockup_warehouse_new_client_desc']."',
'".$_POST['add_mockup_warehouse_new_client_bill_addr']."',
'".$_POST['add_mockup_warehouse_new_client_ship_addr']."',
'".$_POST['add_mockup_warehouse_new_client_email']."',
'".$_POST['add_mockup_warehouse_new_client_phone']."',
'".$_POST['add_mockup_warehouse_new_client_pay_terms']."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";

if($conn->query($ins_sql)){
	$clientid= $conn->insert_id;
}else{
	die('ERRMA(#)TJ Inserting Client, Contact Admin');
}
	





$insert = "INSERT INTO `sw_mockups`( `mock_rel_msf_id`, `mock_rel_pr_id`, `mock_rel_cli_id`, `mock_qty`, `mock_added_dnt`, `mock_rel_lum_id`) VALUES (
'1',
'".$product['pr_id']."',
'".$clientid."',
'".$_POST['add_mockup_warehouse_new_qty']."',
'".time()."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";

if($conn->query($insert)){
	header('Location: mockup.php');
}else{
	die("Could not insert query");
}

}
if(isset($_POST['add_mockup_showroom_old_client'])){
#---------------------------------------
if(isset($_POST['add_mockup_showwroom_old_product_hash'])){
  if(!is_string($_POST['add_mockup_showwroom_old_product_hash'])){
  die('Invalid Characters used in add_mockup_showwroom_old_product_hash');   }
  else{}
}else{
  die('Enter add_mockup_showwroom_old_product_hash');
}
#---------------------------------------
if(isset($_POST['add_mockup_showroom_old_client_hash'])){
  if(!is_string($_POST['add_mockup_showroom_old_client_hash'])){
  die('Invalid Characters used in add_mockup_showroom_old_client_hash');   }
  else{}
}else{
  die('Enter add_mockup_showroom_old_client_hash');
}
#---------------------------------------
if(isset($_POST['add_mockup_showroom_old_qty'])){
  if(!is_string($_POST['add_mockup_showroom_old_qty'])){
  die('Invalid Characters used in add_mockup_showroom_old_qty');   }
  else{}
}else{
  die('Enter add_mockup_showroom_old_qty');
}
#---------------------------------------

$product= getdatafromsql($conn,"SELECT * FROM `sw_products_list_show` s 
where md5(sha1(md5(concat('20i94joefwnd',sh_rel_pr_id))))='".$_POST['add_mockup_showwroom_old_product_hash']."'");
if(!is_array($product)){
	die('Product not found');
}
$client = getdatafromsql($conn,"select * from sw_clients where cli_valid= 1 and md5(sha1(md5(concat('2094uihwornjds ikjn fm',cli_id))))='".$_POST['add_mockup_showroom_old_client_hash']."'");
if(!is_array($client)){
	die('Client not found');
}

$insert = "INSERT INTO `sw_mockups`( `mock_rel_msf_id`, `mock_rel_pr_id`, `mock_rel_cli_id`, `mock_rel_shw_id`, `mock_qty`, `mock_added_dnt`, `mock_rel_lum_id`) VALUES (
'2',
'".$product['sh_rel_pr_id']."',
'".$client['cli_id']."',
'".$product['sh_rel_shw_id']."',
'".$_POST['add_mockup_showroom_old_qty']."',
'".time()."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";

if($conn->query($insert)){
	header('Location: mockup.php');
}else{
	die("Could not insert query");
}

}
if(isset($_POST['add_mockup_showroom_new'])){
#---------------------------------------
if(isset($_POST['add_mockup_showroom_new_product_hash'])){
  if(!ctype_alnum($_POST['add_mockup_showroom_new_product_hash'])){
  die('Invalid Characters used in add_mockup_showroom_new_product_hash');   }
  else{}
}else{
  die('Enter add_mockup_showroom_new_product_hash');
}
#---------------------------------------
if(isset($_POST['add_mockup_showroom_new_qty'])){
  if(!is_numeric($_POST['add_mockup_showroom_new_qty'])){
  die('Invalid Characters used in add_mockup_showroom_new_qty');   }
  else{}
}else{
  die('Enter add_mockup_showroom_new_qty');
}
#---------------------------------------
if(isset($_POST['add_mockup_showroom_new_client_name'])){
  if(!is_string($_POST['add_mockup_showroom_new_client_name'])){
  die('Invalid Characters used in add_mockup_showroom_new_client_name');   }
  else{}
}else{
  die('Enter add_mockup_showroom_new_client_name');
}
#---------------------------------------
if(isset($_POST['add_mockup_showroom_new_client_code'])){
  if(!is_string($_POST['add_mockup_showroom_new_client_code'])){
  die('Invalid Characters used in add_mockup_showroom_new_client_code');   }
  else{}
}else{
  die('Enter add_mockup_showroom_new_client_code');
}
#---------------------------------------
if(isset($_POST['add_mockup_showroom_new_client_desc'])){
  if(!is_string($_POST['add_mockup_showroom_new_client_desc'])){
  die('Invalid Characters used in add_mockup_showroom_new_client_desc');   }
  else{}
}else{
  die('Enter add_mockup_showroom_new_client_desc');
}
#---------------------------------------
if(isset($_POST['add_mockup_showroom_new_client_email'])){
  if(!is_email($_POST['add_mockup_showroom_new_client_email'])){
  die('Invalid Characters used in add_mockup_showroom_new_client_email');   }
  else{}
}else{
  die('Enter add_mockup_showroom_new_client_email');
}
#---------------------------------------
if(isset($_POST['add_mockup_showroom_new_client_phone'])){
  if(!is_string($_POST['add_mockup_showroom_new_client_phone'])){
  die('Invalid Characters used in add_mockup_showroom_new_client_phone');   }
  else{}
}else{
  die('Enter add_mockup_showroom_new_client_phone');
}
#---------------------------------------
if(isset($_POST['add_mockup_showroom_new_client_bill_addr'])){
  if(!is_string($_POST['add_mockup_showroom_new_client_bill_addr'])){
  die('Invalid Characters used in add_mockup_showroom_new_client_bill_addr');   }
  else{}
}else{
  die('Enter add_mockup_showroom_new_client_bill_addr');
}
#---------------------------------------
if(isset($_POST['_wysihtml5_mode'])){
  if(!is_numeric($_POST['_wysihtml5_mode'])){
  die('Invalid Characters used in _wysihtml5_mode');   }
  else{}
}else{
  die('Enter _wysihtml5_mode');
}
#---------------------------------------
if(isset($_POST['add_mockup_showroom_new_client_ship_addr'])){
  if(!is_string($_POST['add_mockup_showroom_new_client_ship_addr'])){
  die('Invalid Characters used in add_mockup_showroom_new_client_ship_addr');   }
  else{}
}else{
  die('Enter add_mockup_showroom_new_client_ship_addr');
}
#---------------------------------------
if(isset($_POST['add_mockup_showroom_new_client_tax_code'])){
  if(!is_string($_POST['add_mockup_showroom_new_client_tax_code'])){
  die('Invalid Characters used in add_mockup_showroom_new_client_tax_code');   }
  else{}
}else{
  die('Enter add_mockup_showroom_new_client_tax_code');
}
#---------------------------------------
if(isset($_POST['add_mockup_showroom_new_client_bank_details'])){
  if(!is_string($_POST['add_mockup_showroom_new_client_bank_details'])){
  die('Invalid Characters used in add_mockup_showroom_new_client_bank_details');   }
  else{}
}else{
  die('Enter add_mockup_showroom_new_client_bank_details');
}
#---------------------------------------
if(isset($_POST['add_mockup_showroom_new_client_pay_terms'])){
  if(!is_string($_POST['add_mockup_showroom_new_client_pay_terms'])){
  die('Invalid Characters used in add_mockup_showroom_new_client_pay_terms');   }
  else{}
}else{
  die('Enter add_mockup_showroom_new_client_pay_terms');
}
#---------------------------------------

$product= getdatafromsql($conn,"select * from sw_products_list_show where sh_valid= 1 and md5(sha1(md5(concat('0uijrwno0gj3iow',sh_rel_pr_id))))='".$_POST['add_mockup_showroom_new_product_hash']."'");
if(!is_array($product)){
	die('Product not found');
}

$ins_sql = "INSERT INTO `sw_clients`( `cli_name`, `cli_bank_details`, `cli_tax_code`, `cli_code`, `cli_desc`, `cli_bill_addr`, `cli_ship_addr`, `cli_email`, `cli_contact_no`, `cli_pay_terms`, `cli_dnt`, `cli_ip`, `cli_added_rel_lum_id`) VALUES 
(
'".$_POST['add_mockup_showroom_new_client_name']."',
'".$_POST['add_mockup_showroom_new_client_bank_details']."',
'".$_POST['add_mockup_showroom_new_client_tax_code']."',
'".$_POST['add_mockup_showroom_new_client_code']."',
'".$_POST['add_mockup_showroom_new_client_desc']."',
'".$_POST['add_mockup_showroom_new_client_bill_addr']."',
'".$_POST['add_mockup_showroom_new_client_ship_addr']."',
'".$_POST['add_mockup_showroom_new_client_email']."',
'".$_POST['add_mockup_showroom_new_client_phone']."',
'".$_POST['add_mockup_showroom_new_client_pay_terms']."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";

if($conn->query($ins_sql)){
	$clientid= $conn->insert_id;
}else{
	die('ERRMA(#)TJ Inserting Client, Contact Admin');
}
	





$insert = "INSERT INTO `sw_mockups`( `mock_rel_msf_id`, `mock_rel_pr_id`, `mock_rel_cli_id`,`mock_rel_shw_id`, `mock_qty`, `mock_added_dnt`, `mock_rel_lum_id`) VALUES (
'2',
'".$product['sh_rel_pr_id']."',
'".$clientid."',
'".$product['sh_rel_shw_id']."',
'".$_POST['add_mockup_showroom_new_qty']."',
'".time()."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";

if($conn->query($insert)){
	header('Location: mockup.php');
}else{
	die("Could not insert query");
}

}
if(isset($_POST['add_mockup_supplier_old'])){
#---------------------------------------
if(isset($_POST['add_mockup_supplier_old_client_hash'])){
  if(!ctype_alnum($_POST['add_mockup_supplier_old_client_hash'])){
  die('Invalid Characters used in add_mockup_supplier_old_client_hash');   }
  else{}
}else{
  die('Enter add_mockup_supplier_old_client_hash');
}
#---------------------------------------
if(isset($_POST['add_mockup_supplier_old_qty'])){
  if(!is_numeric($_POST['add_mockup_supplier_old_qty'])){
  die('Invalid Characters used in add_mockup_supplier_old_qty');   }
  else{}
}else{
  die('Enter add_mockup_supplier_old_qty');
}
#---------------------------------------
if(isset($_POST['add_mockup_supplier_old_product_name'])){
  if(!is_string($_POST['add_mockup_supplier_old_product_name'])){
  die('Invalid Characters used in add_mockup_supplier_old_product_name');   }
  else{}
}else{
  die('Enter add_mockup_supplier_old_product_name');
}
#---------------------------------------
if(isset($_POST['add_mockup_supplier_old_product_code'])){
  if(!is_string($_POST['add_mockup_supplier_old_product_code'])){
  die('Invalid Characters used in add_mockup_supplier_old_product_code');   }
  else{}
}else{
  die('Enter add_mockup_supplier_old_product_code');
}
#---------------------------------------
if(isset($_POST['add_mockup_supplier_old_product_type'])){
  if(!is_string($_POST['add_mockup_supplier_old_product_type'])){
  die('Invalid Characters used in add_mockup_supplier_old_product_type');   }
  else{}
}else{
  die('Enter add_mockup_supplier_old_product_type');
}
#---------------------------------------
if(isset($_POST['add_mockup_supplier_old_product_supplier'])){
  if(!is_string($_POST['add_mockup_supplier_old_product_supplier'])){
  die('Invalid Characters used in add_mockup_supplier_old_product_supplier');   }
  else{}
}else{
  die('Enter add_mockup_supplier_old_product_supplier');
}
#---------------------------------------
if(isset($_POST['add_mockup_supplier_old_product_desc'])){
  if(!is_string($_POST['add_mockup_supplier_old_product_desc'])){
  die('Invalid Characters used in add_mockup_supplier_old_product_desc');   }
  else{}
}else{
  die('Enter add_mockup_supplier_old_product_desc');
}
#---------------------------------------
if(isset($_POST['_wysihtml5_mode'])){
  if(!is_numeric($_POST['_wysihtml5_mode'])){
  die('Invalid Characters used in _wysihtml5_mode');   }
  else{}
}else{
  die('Enter _wysihtml5_mode');
}
#---------------------------------------
if(isset($_POST['add_mockup_supplier_old_product_cost'])){
  if(!is_numeric($_POST['add_mockup_supplier_old_product_cost'])){
  die('Invalid Characters used in add_mockup_supplier_old_product_cost');   }
  else{}
}else{
  die('Enter add_mockup_supplier_old_product_cost');
}
#---------------------------------------


$client = getdatafromsql($conn,"select * from sw_clients where cli_valid= 1 and md5(sha1(md5(concat('3oiwjf3oihegnr ikjn fm',cli_id))))='".$_POST['add_mockup_supplier_old_client_hash']."'");
if(!is_array($client)){
	die('Client not found');
}


$getsupplierdetails = getdatafromsql($conn,"select * from sw_suppliers where md5(sha1(md5(concat('iuergeirjgvjioe',sup_id)))) = '".$_POST['add_mockup_supplier_old_product_supplier']."'");
if(!is_array($getsupplierdetails)){
	die('Supplier Not Found');
}

$getptypedetails = getdatafromsql($conn,"select * from sw_prod_types where md5(sha1(md5(concat('iuergejgvjioe',prty_id)))) = '".$_POST['add_mockup_supplier_old_product_type']."'");
if(!is_array($getptypedetails)){
	die('Product type Not Found');
}
$target_dir = "pr_imgs/";
if(isset($_FILES['add_mockup_supplier_old_product_img']) and ($_FILES['add_mockup_supplier_old_product_img']['size']==0)){
$target_file = $target_dir .'default.png';
$target_file_2 = $target_dir .'default.png';
$target_file_3 = $target_dir .'default.png';
}else{

					
					
$ext =  extension(basename($_FILES["add_mockup_supplier_old_product_img"]["name"]));
$fold_name =uniqid().'-'.$_POST['add_mockup_supplier_old_product_code'].$_POST['add_mockup_supplier_old_product_name'].$getptypedetails['prty_id'].'-'.$_POST['add_mockup_supplier_old_qty'].'/';
if(mkdir('pr_imgs/'.$fold_name)){
}

$target_file = $target_dir .$fold_name. $_POST['add_mockup_supplier_old_product_code'].''.$_POST['add_mockup_supplier_old_product_name'].'_1.'.$ext;
$target_file_2 = $target_dir .$fold_name. $_POST['add_mockup_supplier_old_product_code'].''.$_POST['add_mockup_supplier_old_product_name'].'_2.'.$ext;
$target_file_3 = $target_dir .$fold_name. $_POST['add_mockup_supplier_old_product_code'].''.$_POST['add_mockup_supplier_old_product_name'].'_3.'.$ext;

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["add_mockup_supplier_old_product_img"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["add_mockup_supplier_old_product_img"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    die("Sorry, your file was not uploaded.");
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["add_mockup_supplier_old_product_img"]["tmp_name"], $target_file) and
	    copy($target_file, $target_file_2) and  
		copy($target_file, $target_file_3) ) {
		

if(resize(120,$target_file_2,$target_file_2)){
	if(resize(300,$target_file_3,$target_file_3)){
}else{
		die('I c N R');
	}

}else{
	die('Images Could not be resized');
}

    } else {
        die( "Sorry, there was an error uploading your file.");
    }
}
}
$inssql = "INSERT INTO `sw_products_list`(`pr_rel_prty_id`,`pr_rel_sup_id`,`pr_code`,`pr_img`,`pr_img_2`,`pr_img_3`,`pr_name`, `pr_desc`, `pr_price`,`pr_qty`,`pr_dnt`) VALUES (
'".$getptypedetails['prty_id']."',
'".$getsupplierdetails['sup_id']."',
'".$_POST['add_mockup_supplier_old_product_code']."',
'".$target_file."',
'".$target_file_2."',
'".$target_file_3."',
'".$_POST['add_mockup_supplier_old_product_name']."',
'".$_POST['add_mockup_supplier_old_product_desc']."',
'".$_POST['add_mockup_supplier_old_product_cost']."',
'".$_POST['add_mockup_supplier_old_qty']."',
'".time()."'
)";
if ($conn->query($inssql) === TRUE) {
		$insert = "INSERT INTO `sw_mockups`( `mock_rel_msf_id`, `mock_rel_pr_id`, `mock_rel_cli_id`, `mock_rel_sup_id`, `mock_qty`, `mock_added_dnt`, `mock_rel_lum_id`) VALUES (
		'3',
		'".$conn->insert_id."',
		'".$client['cli_id']."',
		'".$getsupplierdetails['sup_id']."',
		'".$_POST['add_mockup_supplier_old_qty']."',
		'".time()."',
		'".$_SESSION['STWL_LUM_DB_ID']."'
		)";
		
		if($conn->query($insert)){
			header('Location: mockup.php');
		}else{
			die("Could not insert query");
		}

}else {
	die( "ERRMA(PA), Error Inserting Product");
}





}
if(isset($_POST['add_mockup_supplier_new'])){
#---------------------------------------
if(isset($_POST['add_mockup_supplier_new_client_name'])){
  if(!is_string($_POST['add_mockup_supplier_new_client_name'])){
  die('Invalid Characters used in add_mockup_supplier_new_client_name');   }
  else{}
}else{
  die('Enter add_mockup_supplier_new_client_name');
}
#---------------------------------------
if(isset($_POST['add_mockup_supplier_new_client_code'])){
  if(!is_string($_POST['add_mockup_supplier_new_client_code'])){
  die('Invalid Characters used in add_mockup_supplier_new_client_code');   }
  else{}
}else{
  die('Enter add_mockup_supplier_new_client_code');
}
#---------------------------------------
if(isset($_POST['add_mockup_supplier_new_client_desc'])){
  if(!is_string($_POST['add_mockup_supplier_new_client_desc'])){
  die('Invalid Characters used in add_mockup_supplier_new_client_desc');   }
  else{}
}else{
  die('Enter add_mockup_supplier_new_client_desc');
}
#---------------------------------------
if(isset($_POST['add_mockup_supplier_new_client_email'])){
  if(!is_email($_POST['add_mockup_supplier_new_client_email'])){
  die('Invalid Characters used in add_mockup_supplier_new_client_email');   }
  else{}
}else{
  die('Enter add_mockup_supplier_new_client_email');
}
#---------------------------------------
if(isset($_POST['add_mockup_supplier_new_client_phone'])){
  if(!is_string($_POST['add_mockup_supplier_new_client_phone'])){
  die('Invalid Characters used in add_mockup_supplier_new_client_phone');   }
  else{}
}else{
  die('Enter add_mockup_supplier_new_client_phone');
}
#---------------------------------------
if(isset($_POST['add_mockup_supplier_new_client_bill_addr'])){
  if(!is_string($_POST['add_mockup_supplier_new_client_bill_addr'])){
  die('Invalid Characters used in add_mockup_supplier_new_client_bill_addr');   }
  else{}
}else{
  die('Enter add_mockup_supplier_new_client_bill_addr');
}
#---------------------------------------
if(isset($_POST['_wysihtml5_mode'])){
  if(!is_numeric($_POST['_wysihtml5_mode'])){
  die('Invalid Characters used in _wysihtml5_mode');   }
  else{}
}else{
  die('Enter _wysihtml5_mode');
}
#---------------------------------------
if(isset($_POST['add_mockup_supplier_new_client_ship_addr'])){
  if(!is_string($_POST['add_mockup_supplier_new_client_ship_addr'])){
  die('Invalid Characters used in add_mockup_supplier_new_client_ship_addr');   }
  else{}
}else{
  die('Enter add_mockup_supplier_new_client_ship_addr');
}
#---------------------------------------
if(isset($_POST['add_mockup_supplier_new_client_tax_code'])){
  if(!is_string($_POST['add_mockup_supplier_new_client_tax_code'])){
  die('Invalid Characters used in add_mockup_supplier_new_client_tax_code');   }
  else{}
}else{
  die('Enter add_mockup_supplier_new_client_tax_code');
}
#---------------------------------------
if(isset($_POST['add_mockup_supplier_new_client_bank_details'])){
  if(!is_string($_POST['add_mockup_supplier_new_client_bank_details'])){
  die('Invalid Characters used in add_mockup_supplier_new_client_bank_details');   }
  else{}
}else{
  die('Enter add_mockup_supplier_new_client_bank_details');
}
#---------------------------------------
if(isset($_POST['add_mockup_supplier_new_client_pay_terms'])){
  if(!is_string($_POST['add_mockup_supplier_new_client_pay_terms'])){
  die('Invalid Characters used in add_mockup_supplier_new_client_pay_terms');   }
  else{}
}else{
  die('Enter add_mockup_supplier_new_client_pay_terms');
}
#---------------------------------------
if(isset($_POST['add_mockup_supplier_new_qty'])){
  if(!is_numeric($_POST['add_mockup_supplier_new_qty'])){
  die('Invalid Characters used in add_mockup_supplier_new_qty');   }
  else{}
}else{
  die('Enter add_mockup_supplier_new_qty');
}
#---------------------------------------
if(isset($_POST['add_mockup_supplier_new_product_name'])){
  if(!is_string($_POST['add_mockup_supplier_new_product_name'])){
  die('Invalid Characters used in add_mockup_supplier_new_product_name');   }
  else{}
}else{
  die('Enter add_mockup_supplier_new_product_name');
}
#---------------------------------------
if(isset($_POST['add_mockup_supplier_new_product_code'])){
  if(!is_string($_POST['add_mockup_supplier_new_product_code'])){
  die('Invalid Characters used in add_mockup_supplier_new_product_code');   }
  else{}
}else{
  die('Enter add_mockup_supplier_new_product_code');
}
#---------------------------------------
if(isset($_POST['add_mockup_supplier_new_product_type'])){
  if(!ctype_alnum($_POST['add_mockup_supplier_new_product_type'])){
  die('Invalid Characters used in add_mockup_supplier_new_product_type');   }
  else{}
}else{
  die('Enter add_mockup_supplier_new_product_type');
}
#---------------------------------------
if(isset($_POST['add_mockup_supplier_new_product_supplier'])){
  if(!ctype_alnum($_POST['add_mockup_supplier_new_product_supplier'])){
  die('Invalid Characters used in add_mockup_supplier_new_product_supplier');   }
  else{}
}else{
  die('Enter add_mockup_supplier_new_product_supplier');
}
#---------------------------------------
if(isset($_POST['add_mockup_supplier_new_product_desc'])){
  if(!is_string($_POST['add_mockup_supplier_new_product_desc'])){
  die('Invalid Characters used in add_mockup_supplier_new_product_desc');   }
  else{}
}else{
  die('Enter add_mockup_supplier_new_product_desc');
}
#---------------------------------------
if(isset($_POST['add_mockup_supplier_new_product_cost'])){
  if(!is_numeric($_POST['add_mockup_supplier_new_product_cost'])){
  die('Invalid Characters used in add_mockup_supplier_new_product_cost');   }
  else{}
}else{
  die('Enter add_mockup_supplier_new_product_cost');
}
#---------------------------------------

$ins_sql = "INSERT INTO `sw_clients`( `cli_name`, `cli_bank_details`, `cli_tax_code`, `cli_code`, `cli_desc`, `cli_bill_addr`, `cli_ship_addr`, `cli_email`, `cli_contact_no`, `cli_pay_terms`, `cli_dnt`, `cli_ip`, `cli_added_rel_lum_id`) VALUES 
(
'".$_POST['add_mockup_supplier_new_client_name']."',
'".$_POST['add_mockup_supplier_new_client_bank_details']."',
'".$_POST['add_mockup_supplier_new_client_tax_code']."',
'".$_POST['add_mockup_supplier_new_client_code']."',
'".$_POST['add_mockup_supplier_new_client_desc']."',
'".$_POST['add_mockup_supplier_new_client_bill_addr']."',
'".$_POST['add_mockup_supplier_new_client_ship_addr']."',
'".$_POST['add_mockup_supplier_new_client_email']."',
'".$_POST['add_mockup_supplier_new_client_phone']."',
'".$_POST['add_mockup_supplier_new_client_pay_terms']."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";

if($conn->query($ins_sql)){
	$clientid= $conn->insert_id;
}else{
	die('ERRMA(#)TJ Inserting Client, Contact Admin');
}
	

$getsupplierdetails = getdatafromsql($conn,"select * from sw_suppliers where md5(sha1(md5(concat('iuergeirjgvjioe',sup_id)))) = '".$_POST['add_mockup_supplier_new_product_supplier']."'");
if(!is_array($getsupplierdetails)){
	die('Supplier Not Found');
}

$getptypedetails = getdatafromsql($conn,"select * from sw_prod_types where md5(sha1(md5(concat('iuergejgvjioe',prty_id)))) = '".$_POST['add_mockup_supplier_new_product_type']."'");
if(!is_array($getptypedetails)){
	die('Product type Not Found');
}

$target_dir = "pr_imgs/";
if(isset($_FILES['add_mockup_supplier_new_product_img']) and ($_FILES['add_mockup_supplier_new_product_img']['size']===0)){
$target_file = $target_dir .'default.png';
$target_file_2 = $target_dir .'default.png';
$target_file_3 = $target_dir .'default.png';
}else{

					
$ext =  extension(basename($_FILES["add_mockup_supplier_new_product_img"]["name"]));
$fold_name =uniqid().'-'.$_POST['add_mockup_supplier_new_product_code'].$_POST['add_mockup_supplier_new_product_name'].$getptypedetails['prty_id'].'-'.$_POST['add_mockup_supplier_new_qty'].'/';
if(mkdir('pr_imgs/'.$fold_name)){
}

$target_file = $target_dir .$fold_name. $_POST['add_mockup_supplier_new_product_code'].''.$_POST['add_mockup_supplier_new_product_name'].'_1.'.$ext;
$target_file_2 = $target_dir .$fold_name. $_POST['add_mockup_supplier_new_product_code'].''.$_POST['add_mockup_supplier_new_product_name'].'_2.'.$ext;
$target_file_3 = $target_dir .$fold_name. $_POST['add_mockup_supplier_new_product_code'].''.$_POST['add_mockup_supplier_new_product_name'].'_3.'.$ext;

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["add_mockup_supplier_new_product_img"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["add_mockup_supplier_new_product_img"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    die("Sorry, your file was not uploaded.");
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["add_mockup_supplier_new_product_img"]["tmp_name"], $target_file) and
	    copy($target_file, $target_file_2) and  
		copy($target_file, $target_file_3) ) {
		

if(resize(120,$target_file_2,$target_file_2)){
	if(resize(300,$target_file_3,$target_file_3)){
}else{
		die('I c N R');
	}

}else{
	die('Images Could not be resized');
}

    } else {
        die( "Sorry, there was an error uploading your file.");
    }
}
}
$inssql = "INSERT INTO `sw_products_list`(`pr_rel_prty_id`,`pr_rel_sup_id`,`pr_code`,`pr_img`,`pr_img_2`,`pr_img_3`,`pr_name`, `pr_desc`, `pr_price`,`pr_qty`,`pr_dnt`) VALUES (
'".$getptypedetails['prty_id']."',
'".$getsupplierdetails['sup_id']."',
'".$_POST['add_mockup_supplier_new_product_code']."',
'".$target_file."',
'".$target_file_2."',
'".$target_file_3."',
'".$_POST['add_mockup_supplier_new_product_name']."',
'".$_POST['add_mockup_supplier_new_product_desc']."',
'".$_POST['add_mockup_supplier_new_product_cost']."',
'".$_POST['add_mockup_supplier_new_qty']."',
'".time()."'
)";

if ($conn->query($inssql) === TRUE) {
		$insert = "INSERT INTO `sw_mockups`( `mock_rel_msf_id`, `mock_rel_pr_id`, `mock_rel_cli_id`, `mock_rel_sup_id`, `mock_qty`, `mock_added_dnt`, `mock_rel_lum_id`) VALUES (
		'3',
		'".$conn->insert_id."',
		'".$clientid."',
		'".$getsupplierdetails['sup_id']."',
		'".$_POST['add_mockup_supplier_new_qty']."',
		'".time()."',
		'".$_SESSION['STWL_LUM_DB_ID']."'
		)";
		
		if($conn->query($insert)){
			header('Location: mockup.php');
		}else{
			die("Could not insert query");
		}

}else {
	die( "ERRMA(PA), Error Inserting Product");
}





$insert = "INSERT INTO `sw_mockups`( `mock_rel_msf_id`, `mock_rel_pr_id`, `mock_rel_cli_id`, `mock_qty`, `mock_added_dnt`, `mock_rel_lum_id`) VALUES (
'1',
'".$product['pr_id']."',
'".$clientid."',
'".$_POST['add_mockup_supplier_new_qty']."',
'".time()."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";

if($conn->query($insert)){
	header('Location: mockup.php');
}else{
	die("Could not insert query");
}

}
/*-------------------------------------------------------------------*/
if(isset($_POST['add_cur'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die("You Must Login to continue");
	}
#---------------------------------------
if(isset($_POST['add_cur_name'])){
  if(!is_string($_POST['add_cur_name'])){
  die('Invalid Characters used in add_cur_name');   }
  else{}
}else{
  die('Enter add_cur_name');
}
#---------------------------------------
if(isset($_POST['add_cur_formula'])){
  if(!is_numeric($_POST['add_cur_formula'])){
  die('Invalid Characters used in add_cur_formula');   }
  else{}
}else{
  die('Enter add_cur_formula');
}
#---------------------------------------


$ins_sql = "
INSERT INTO `sw_currency`( `cur_name`, `cur_formula`) VALUES
(
'".$_POST['add_cur_name']."',
'".$_POST['add_cur_formula']."'
)";

if($conn->query($ins_sql)){
	header('Location: sw_currency.php');
}else{
	die('ERRMjir Inserting Currency, Contact Admin');
}
	
}
if(isset($_POST['edit_cur_type'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die("You Must Login to continue");
	}
#---------------------------------------
if(isset($_POST['edit_cur_name'])){
  if(!is_string($_POST['edit_cur_name'])){
  die('Invalid Characters used in edit_cur_name');   }
  else{}
}else{
  die('Enter edit_cur_name');
}
#---------------------------------------
if(isset($_POST['edit_cur_formula'])){
  if(!is_string($_POST['edit_cur_formula'])){
  die('Invalid Characters used in edit_cur_formula');   }
  else{}
}else{
  die('Enter edit_cur_formula');
}
#---------------------------------------
if(isset($_POST['edit_cur_hash'])){
  if(!is_string($_POST['edit_cur_hash'])){
  die('Invalid Characters used in edit_cur_hash');   }
  else{}
}else{
  die('Enter edit_cur_hash');
}
#---------------------------------------
$getprty = getdatafromsql($conn,"select * from sw_currency where 
md5(md5(sha1(sha1(md5(md5(cur_id)))))) = '".$_POST['edit_cur_hash']."'");
if(is_array($getprty)){
}else{
	die('Currency Not found');
}

$ins_sql = "UPDATE `sw_currency` SET 
`cur_name`='".$_POST['edit_cur_name']."',
`cur_formula`='".$_POST['edit_cur_formula']."'
 WHERE cur_id = ".$getprty['cur_id']."
";

if($conn->query($ins_sql)){
	header('Location: sw_currency.php');
}else{
	die('ERRMACUE Updating Currency, Contact Admin');
}
	
}
/* -------------------------------------------------------------------*/
if(isset($_POST['prid'])){
	$pr = array('cost'=>'0','desc'=>'Not Good');
	if(is_numeric($_POST['prid'])){
		$pro = getdatafromsql($conn,"select * from sw_products_list where pr_id=".$_POST['prid']." and pr_valid =1");	
		if(is_array($pro)){
			$pr['cost']=$pro['pr_price'];
			$pr['desc']=$pro['pr_desc'];
			echo json_encode($pr);
		}
	}
}
if(isset($_POST['add_revision'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die('Login');
	}
#---------------------------------------
if(isset($_POST['add_revision_quote_proj_name'])){
  if(!is_string($_POST['add_revision_quote_proj_name'])){
  die('Invalid Characters used in add_revision_quote_proj_name');   }
  else{}
}else{
  die('Enter add_revision_quote_proj_name');
}
#---------------------------------------
if(isset($_POST['add_revision_quote_subj'])){
  if(!is_string($_POST['add_revision_quote_subj'])){
  die('Invalid Characters used in add_revision_quote_subj');   }
  else{}
}else{
  die('Enter add_revision_quote_subj');
}
#---------------------------------------
if(isset($_POST['rev_nos'])){
  if(!is_numeric($_POST['rev_nos']) or ($_POST['rev_nos'] > 1000)){
  die('Invalid Characters used in rev_nos');   }
  else{}
}else{
  die('Enter rev_nos');
}
#---------------------------------------
if(isset($_POST['add_revision_q_hash'])){
  if(!ctype_alnum($_POST['add_revision_q_hash'])){
  die('Invalid Characters used in add_revision_q_hash');   }
  else{}
}else{
  die('Enter add_revision_q_hash');
}
#---------------------------------------

$getqo = getdatafromsql($conn,"select * from sw_quotes where md5(qo_id) = '".$_POST['add_revision_q_hash']."' and qo_valid =1");
if(!is_array($getqo)){
	die('Quote not found');
}

$getitems = getdatafromsql($conn,"select count(qi_id) as nom from sw_quotes_items where qi_rel_qo_id = ".$getqo['qo_id']." and qi_valid =1");
if(!is_array($getqo)){
	die('Items not found');
}
for($i = 1;$i < ($getitems['nom'] + 1);$i++){
	if(isset($_POST['add_revision_quote_product_already_'.$i])){
					  if(!ctype_alnum($_POST['add_revision_quote_product_already_'.$i])){
						  die('Invalid' .'add_revision_quote_product_already_'.$i);
					  }
						if(is_array(getdatafromsql($conn,"select * from sw_products_list where md5(pr_id)='".$_POST['add_revision_quote_product_already_'.$i]."' and pr_valid =1 "))){
						}else{
							die('Invalid Product');
						}
					
						#---------------------------------------
						if(isset($_POST['add_revision_quote_desc_already_'.$i])){
						  if(!is_string($_POST['add_revision_quote_desc_already_'.$i])){
						  die('Invalid Characters used in add_revision_quote_desc_already_'.$i);   }
						  else{}
						}else{
						  die('Enter add_revision_quote_desc_already_'.$i);
						}
						#---------------------------------------
						if(isset($_POST['add_revision_quote_cost_already_'.$i])){
						  if(!is_numeric($_POST['add_revision_quote_cost_already_'.$i])){
						  die('Invalid Characters used in add_revision_quote_cost_already_'.$i);   }
						  else{}
						}else{
						  die('Enter add_revision_quote_cost_already_'.$i);
						}
						#---------------------------------------
						if(isset($_POST['add_revision_quote_price_already_'.$i])){
						  if(!is_numeric($_POST['add_revision_quote_price_already_'.$i])){
						  die('Invalid Characters used in add_revision_quote_price_already_'.$i);   }
						  else{}
						}else{
						  die('Enter add_revision_quote_price_already_'.$i);
						}
						#---------------------------------------
						if(isset($_POST['add_revision_quote_qty_already_'.$i])){
						  if(!is_numeric($_POST['add_revision_quote_qty_already_'.$i])){
						  die('Invalid Characters used in add_revision_quote_qty_already_'.$i);   }
						  else{}
						}else{
						  die('Enter add_revision_quote_qty_already_'.$i);
						}
	}
}


for($c = 1;$c < ($_POST['rev_nos'] + 1);$c++){
	if($c == 1){
		$numi = '';
	}else{
		$numi = $c;
	}
				#---------------------------------------
				if(isset($_POST['add_revision_quote_product_a'.$numi])){
				  if(ctype_alnum($_POST['add_revision_quote_product_a'.$numi]) or ($_POST['add_revision_quote_product_a'.$numi] === '0') ){
					  
if($_POST['add_revision_quote_product_a'.$numi] === '0'){
	
}else{
						if(is_array(getdatafromsql($conn,"select * from sw_products_list where md5(pr_id)='".$_POST['add_revision_quote_product_a'.$numi]."' and pr_valid =1 "))){
						}else{
							die('Invalid Product');
						}
	
}

						
						
				  }else{
					  				  die('Invalid Characters used in add_revision_quote_product_a'.$numi);   
				  }
				}else{
				  die('Enter add_revision_quote_product_a'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_revision_quote_desc_a'.$numi])){
				  if(!is_string($_POST['add_revision_quote_desc_a'.$numi])){
				  die('Invalid Characters used in add_revision_quote_desc_a'.$numi);   }
				  else{}
				}else{
				  die('Enter add_revision_quote_desc_a'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_revision_quote_cost_a'.$numi])){
				  if(!is_numeric($_POST['add_revision_quote_cost_a'.$numi])){
				  die('Invalid Characters used in add_revision_quote_cost_a'.$numi);   }
				  else{}
				}else{
				  die('Enter add_revision_quote_cost_a'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_revision_quote_price_a'.$numi])){
				  if(!is_numeric($_POST['add_revision_quote_price_a'.$numi])){
				  die('Invalid Characters used in add_revision_quote_price_a'.$numi);   }
				  else{}
				}else{
				  die('Enter add_revision_quote_price_a'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_revision_quote_qty_a'.$numi])){
				  if(!is_numeric($_POST['add_revision_quote_qty_a'.$numi])){
				  die('Invalid Characters used in add_revision_quote_qty_a'.$numi);   }
				  else{}
				}else{
				  die('Enter add_revision_quote_qty_a'.$numi);
				}
				
}
$insertquote = "
INSERT INTO `sw_quotes`(`qo_rel_cli_id`, `qo_ref`, `qo_proj_name`, `qo_subj`, `qo_revision`, `qo_revision_id`, `qo_dnt`, `qo_ip`, `qo_rel_lum_id`) VALUES (
'".$getqo['qo_rel_cli_id']."',
'".$getqo['qo_ref'].'/'.(($getqo['qo_revision'] + 1))."',
'".$_POST['add_revision_quote_proj_name']."',
'".$_POST['add_revision_quote_subj']."',
'".($getqo['qo_revision'] + 1)."',
'".$getqo['qo_revision_id']."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";
if($conn->query($insertquote)){
	$quoteid = $conn->insert_id;
	
for($i = 1;$i < ($getitems['nom'] + 1);$i++){
	if(isset($_POST['add_revision_quote_product_already_'.$i])){
						$pr = getdatafromsql($conn,"select * from sw_products_list where md5(pr_id) = '".$_POST['add_revision_quote_product_already_'.$i]."'");
						if(!is_array($pr)){
							die("A big error has occured in product after quote insert");
						}
$insertqitem = "INSERT INTO `sw_quotes_items`(`qi_rel_qo_id`, `qi_rel_pr_id`, `qi_qty`, `qi_cost`, `qi_price`, `qi_desc`) VALUES 
(
'".$quoteid."',
'".$pr['pr_id']."',
'".$_POST['add_revision_quote_qty_already_'.$i]."',
'".$_POST['add_revision_quote_cost_already_'.$i]."',
'".$_POST['add_revision_quote_price_already_'.$i]."',
'".$_POST['add_revision_quote_desc_already_'.$i]."'
)";

if($conn->query($insertqitem)){
}else{
	die("Item Insertion Failed");
}
	}
}

for($c = 1;$c < ($_POST['rev_nos'] + 1);$c++){
	if($_POST['add_revision_quote_product_a'.$numi] !== '0'){
	if($c == 1){
		$numi = '';
	}else{
		$numi = $c;
	}
$pra = getdatafromsql($conn,"select * from sw_products_list where md5(pr_id) = '".$_POST['add_revision_quote_product_a'.$numi]."'");
if(!is_array($pra)){
die("A big error has occured in product-2  after quote insert");
}
$insertq2item = "INSERT INTO `sw_quotes_items`(`qi_rel_qo_id`, `qi_rel_pr_id`, `qi_qty`, `qi_cost`, `qi_price`, `qi_desc`) VALUES 
(
'".$quoteid."',
'".$pra['pr_id']."',
'".$_POST['add_revision_quote_qty_a'.$numi]."',
'".$_POST['add_revision_quote_cost_a'.$numi]."',
'".$_POST['add_revision_quote_price_a'.$numi]."',
'".$_POST['add_revision_quote_desc_a'.$numi]."'
)";


if($conn->query($insertq2item)){
}else{
	die("Item-2 Insertion Failed");
}
				
				
	}
				
}


	
}else{
	die($conn->error.'Could not insert Quote');
}

	header('Location: sw_quotes.php');

}
if(isset($_POST['add_quote'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die('Login');
	}
#---------------------------------------
if(isset($_POST['add_quote_currency'])){
  if(!ctype_alnum($_POST['add_quote_currency'])){
  die('Invalid Characters used in add_quote_currency');   }
  else{}
}else{
  die('Enter add_quote_currency');
}
#---------------------------------------
if(isset($_POST['add_quote_cur_rate'])){
  if(!is_numeric($_POST['add_quote_cur_rate'])){
  die('Invalid Characters used in add_quote_cur_rate');   }
  else{}
}else{
  die('Enter add_quote_cur_rate');
}
#---------------------------------------
if(isset($_POST['add_quote_client'])){
  if(!ctype_alnum($_POST['add_quote_client'])){
  die('Invalid Characters used in add_quote_client');   }
  else{}
}else{
  die('Enter add_quote_client');
}
#---------------------------------------
if(isset($_POST['add_quote_project_name'])){
  if(!is_string($_POST['add_quote_project_name'])){
  die('Invalid Characters used in add_quote_project_name');   }
  else{}
}else{
  die('Enter add_quote_project_name');
}
#---------------------------------------
if(isset($_POST['add_quote_subject_name'])){
  if(!is_string($_POST['add_quote_subject_name'])){
  die('Invalid Characters used in add_quote_subject_name');   }
  else{}
}else{
  die('Enter add_quote_subject_name');
}
#---------------------------------------
if(isset($_POST['qot_nos'])){
  if(!is_numeric($_POST['qot_nos'])){
  die('Invalid Characters used in qot_nos');   }
  else{
	  
if($_POST['qot_nos'] > 1000){
	die("Max Limit of products reached");
}

	  }
}else{
  die('Enter qot_nos');
}
#---------------------------------------

$getclient = getdatafromsql($conn,"select * from sw_clients where md5(cli_id) = '".$_POST['add_quote_client']."' and cli_valid =1");
if(!is_array($getclient)){
	die('Client not found');
}

$getcur = getdatafromsql($conn,"select * from sw_currency where md5(cur_id)= '".$_POST['add_quote_currency']."' ");
if(!is_array($getcur)){
	die('Invalid Currency');
}
for($c = 1;$c < ($_POST['qot_nos'] + 1);$c++){
	if($c == 1){
		$numi = '';
	}else{
		$numi = $c;
	}
				#---------------------------------------
				if(isset($_POST['add_quote_product'.$numi]) and !is_array($_POST['add_quote_product'.$numi])){
				  if(ctype_alnum($_POST['add_quote_product'.$numi]) or ($_POST['add_quote_product'.$numi] === '0') ){
					  
if($_POST['add_quote_product'.$numi] === '0'){
	die("No Product Selected");
}else{
						if(is_array(getdatafromsql($conn,"select * from sw_products_list where md5(pr_id)='".$_POST['add_quote_product'.$numi]."' and pr_valid =1 "))){
						}else{
							die('Invalid Product');
						}
	
}

						
						
				  }else{
					  				  die('Invalid Characters used in add_quote_product'.$numi);   
				  }
				}else{
				  die('Enter add_quote_product'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_quote_product_desc'.$numi])){
				  if(!is_string($_POST['add_quote_product_desc'.$numi])){
				  die('Invalid Characters used in add_quote_product_desc'.$numi);   }
				  else{}
				}else{
				  die('Enter add_quote_product_desc'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_quote_product_cost'.$numi])){
				  if(!is_numeric($_POST['add_quote_product_cost'.$numi])){
				  die('Invalid Characters used in add_quote_product_cost'.$numi);   }
				  else{}
				}else{
				  die('Enter add_quote_product_cost'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_quote_product_price'.$numi])){
				  if(!is_numeric($_POST['add_quote_product_price'.$numi])){
				  die('Invalid Characters used in add_quote_product_price'.$numi);   }
				  else{}
				}else{
				  die('Enter add_quote_product_price'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_quote_product_qty'.$numi])){
				  if(!is_numeric($_POST['add_quote_product_qty'.$numi])){
				  die('Invalid Characters used in add_quote_product_qty'.$numi);   }
				  else{}
				}else{
				  die('Enter add_quote_product_qty'.$numi);
				}
				
}


for($vc = 1;$vc < ($_POST['qot_nos'] + 1);$vc++){
if($vc == 1){
$numir = '';
}else{
$numir = $vc;
}

	for($av = 1;$av < (6);$av++){				#---------------------------------------
		if(isset($_FILES['add_quote_product_images_'.$av.'_a'.$numir])){
		if($_FILES['add_quote_product_images_'.$av.'_a'.$numir]['size'] > 0){	
			$check = getimagesize($_FILES["add_quote_product_images_".$av."_a".$numir]["tmp_name"]);
			if($check !== false) {
			} else {
			die("File is not an image.");}
		}
		}else{
		die('Not found add_quote_product_images_'.$av.'_a'.$numir);
		}
		
	}

}

$insertquote = "
INSERT INTO `sw_quotes`(`qo_rel_cli_id`, `qo_rel_cur_id`, `qo_cur_rate`, `qo_ref`, `qo_proj_name`, `qo_subj`, `qo_revision`, `qo_revision_id`, `qo_dnt`, `qo_ip`, `qo_rel_lum_id`) 
 VALUES (
'".$getclient['cli_id']."',
'".$getcur['cur_id']."',
'".$_POST['add_quote_cur_rate']."',
'SWQ00000',
'".$_POST['add_quote_project_name']."',
'".$_POST['add_quote_subject_name']."',
'0',
'0',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";
if($conn->query($insertquote)){
	$quoteid = $conn->insert_id;

$updatequote = "UPDATE `sw_quotes` SET 
`qo_ref`='SWQ".date('dmy',time()).$quoteid."',
`qo_revision_id`=".$quoteid."
WHERE qo_id = ".$quoteid;

if($conn->query($updatequote)){
}else{
	die('Error Updating Order Reference Id('.$quoteid.')');
}

unset($numi);
unset($c);
for($c = 1;$c < ($_POST['qot_nos'] + 1);$c++){
	$target_dir = "pr_imgs/";

	if($c == 1){
		$numi = '';
	}else{
		$numi = $c;
	}
	$tfiles = array('0','0','0','0','0');

	for($av = 1;$av < (6);$av++){				
#---------------------------------------

if($_FILES["add_quote_product_images_".$av."_a".$numi]["size"] >0){

				$target_file = $target_dir .rand(1,987654321).time().uniqid(). basename($_FILES["add_quote_product_images_".$av."_a".$numi]["name"]);
				$uploadOk = 1;
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
				// Check if file already exists
				if (file_exists($target_file)) {
					echo "Sorry, file already exists.";
					$uploadOk = 0;
				}
				// Check file size
				if ($_FILES["add_quote_product_images_".$av."_a".$numi]["size"] > 1000000) {
					echo "Sorry, your file is too large.";
					$uploadOk = 0;
				}
				// Allow certain file formats
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" ) {
					echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
					$uploadOk = 0;
				}
				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
					die( "Sorry, your file was not uploaded.");
				// if everything is ok, try to upload file
				} else {
					if (move_uploaded_file($_FILES["add_quote_product_images_".$av."_a".$numi]["tmp_name"], $target_file)) {
				$tfiles[($av-1)] = $target_file;
					} else {
						die( "Error:"."add_quote_product_images_".$av."_a".$numi);
					}
				}
				
				unset($target_file);
				unset($imageFileType);
}

/*------*/
}


$pra = getdatafromsql($conn,"select * from sw_products_list where md5(pr_id) = '".$_POST['add_quote_product'.$numi]."'");
if(!is_array($pra)){
die("A big error has occured in product-2  after quote insert");
}
$insertq2item = "INSERT INTO `sw_quotes_items`(`qi_rel_qo_id`, `qi_img_1`, `qi_img_2`, `qi_img_3`, `qi_img_4`, `qi_img_5`, `qi_rel_pr_id`, `qi_qty`, `qi_cost`, `qi_price`, `qi_desc`) VALUES 
(
'".$quoteid."',
'".$tfiles[0]."',
'".$tfiles[1]."',
'".$tfiles[2]."',
'".$tfiles[3]."',
'".$tfiles[4]."',
'".$pra['pr_id']."',
'".$_POST['add_quote_product_qty'.$numi]."',
'".$_POST['add_quote_product_cost'.$numi]."',
'".$_POST['add_quote_product_price'.$numi]."',
'".$_POST['add_quote_product_desc'.$numi]."'
)";


echo($insertq2item.'<br>');
if($conn->query($insertq2item)){
}else{
	die("Item-2 Insertion Failed");
}

unset($tfiles);
		
}

	
}else{
	die($conn->error.'Could not insert Quote');
}
	header('Location: sw_quotes.php');

}
if(isset($_POST['add_quote_gen'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die('Login');	
	}
#---------------------------------------
if(isset($_POST['add_quote_gen_hash'])){
  if(!ctype_alnum($_POST['add_quote_gen_hash'])){
  die('Invalid Characters used in add_quote_gen_hash');   }
  else{}
}else{
  die('Enter add_quote_gen_hash');
}
#---------------------------------------
if(isset($_POST['add_quote_gen_discount'])){
  if(!is_numeric($_POST['add_quote_gen_discount']) or ($_POST['add_quote_gen_discount'] > 100) or ($_POST['add_quote_gen_discount'] < 0)){
  die('Invalid Characters used in add_quote_gen_discount');   }
  else{}
}else{
  die('Enter add_quote_gen_discount');
}
#---------------------------------------
if(isset($_POST['add_quote_gen_vat'])){
  if(!is_numeric($_POST['add_quote_gen_vat'])){
  die('Invalid Characters used in add_quote_gen_vat');   }
  else{}
}else{
  die('Enter add_quote_gen_vat');
}
#---------------------------------------
if(isset($_POST['add_quote_extra_price'])){
  if(!is_numeric($_POST['add_quote_extra_price'])){
  die('Invalid Characters used in add_quote_extra_price');   }
  else{}
}else{
  die('Enter add_quote_extra_price');
}
#---------------------------------------
if(isset($_POST['add_quote_gen_extra'])){
  if(!is_string($_POST['add_quote_gen_extra'])){
  die('Invalid Characters used in add_quote_gen_extra');   }
  else{}
}else{
  die('Enter add_quote_gen_extra');
}
#---------------------------------------
if(isset($_POST['add_quote_regards'])){
  if(!is_string($_POST['add_quote_regards'])){
  die('Invalid Characters used in add_quote_regards');   }
  else{}
}else{
  die('Enter add_quote_regards');
}
#---------------------------------------
if(isset($_POST['add_quote_regards2'])){
  if(!is_string($_POST['add_quote_regards2'])){
  die('Invalid Characters used in add_quote_regards2');   }
  else{}
}else{
  die('Enter add_quote_regards2');
}
#---------------------------------------
if(isset($_POST['add_quote_address'])){
  if(!is_string($_POST['add_quote_address'])){
  die('Invalid Characters used in add_quote_address');   }
  else{}
}else{
  die('Enter add_quote_address');
}
#---------------------------------------
if(isset($_POST['_wysihtml5_mode'])){
  if(!is_numeric($_POST['_wysihtml5_mode'])){
  die('Invalid Characters used in _wysihtml5_mode');   }
  else{}
}else{
  die('Enter _wysihtml5_mode');
}
#---------------------------------------
if(isset($_POST['add_quote_gen_footer'])){
  if(!is_string($_POST['add_quote_gen_footer'])){
  die('Invalid Characters used in add_quote_gen_footer');   }
  else{}
}else{
  die('Enter add_quote_gen_footer');
}
#---------------------------------------
if(isset($_POST['before_head_nos'])){
  if(!is_numeric($_POST['before_head_nos'])){
  die('Invalid Characters used in before_head_nos');   }
  else{}
}else{
  die('Enter before_head_nos');
}
#---------------------------------------
if(isset($_POST['after_head_nos'])){
  if(!is_numeric($_POST['after_head_nos'])){
  die('Invalid Characters used in after_head_nos');   }
  else{}
}else{
  die('Enter after_head_nos');
}

$getquote = getdatafromsql($conn,"select * from sw_quotes where md5(md5(qo_id)) = '".$_POST['add_quote_gen_hash']."' and qo_valid =1");

if(is_array($getquote)){
}else{
	die("No quote Found");
}

for($c=1;$c < ($_POST['before_head_nos'] + 1) ;$c++){
	
if($c == 1){
	$numi = '';
}else{
	$numi = $c ;
}

		#---------------------------------------
		if(isset($_POST['add_quote_gen_bf_head'.$numi])){
		  if(!is_string($_POST['add_quote_gen_bf_head'.$numi])){
		  die('Invalid Characters used in add_quote_gen_bf_head'.$numi);   }
		  else{}
		}else{
		  die('Enter add_quote_gen_bf_head'.$numi);
		}
		#---------------------------------------
		if(isset($_POST['add_quote_gen_bf_head_val'.$numi])){
		  if(!is_string($_POST['add_quote_gen_bf_head_val'.$numi])){
		  die('Invalid Characters used in add_quote_gen_bf_head_val'.$numi);   }
		  else{}
		}else{
		  die('Enter add_quote_gen_bf_head_val'.$numi);
		}
		#---------------------------------------
}
/*------------------------*/
for($a=1; $a < ($_POST['after_head_nos'] + 1) ;$a++){
	
if($a == 1){
	$numi = '';
}else{
	$numi = $a ;
}

		#---------------------------------------
		if(isset($_POST['add_quote_gen_af_head'.$numi])){
		  if(!is_string($_POST['add_quote_gen_af_head'.$numi])){
		  die('Invalid Characters used in add_quote_gen_af_head'.$numi);   }
		  else{}
		}else{
		  die('Enter add_quote_gen_af_head'.$numi);
		}
		#---------------------------------------
		if(isset($_POST['add_quote_gen_af_head_val'.$numi])){
		  if(!is_string($_POST['add_quote_gen_af_head_val'.$numi])){
		  die('Invalid Characters used in add_quote_gen_af_head_val'.$numi);   }
		  else{}
		}else{
		  die('Enter add_quote_gen_af_head_val'.$numi);
		}
		#---------------------------------------
}

$beforetval = array();
$aftertval = array();



for($c=1;$c < ($_POST['before_head_nos'] + 1) ;$c++){
	
if($c == 1){
	$numi = '';
}else{
	$numi = $c ;
}

$beforetval[] = $_POST['add_quote_gen_bf_head'.$numi].'|=|=|=|=|=|'.$_POST['add_quote_gen_bf_head_val'.$numi];

}
/*------------------------*/
for($a=1; $a < ($_POST['after_head_nos'] + 1) ;$a++){
	
if($a == 1){
	$numi = '';
}else{
	$numi = $a ;
}
$aftertval[] = $_POST['add_quote_gen_af_head'.$numi].'|=|=|=|=|=|'.$_POST['add_quote_gen_af_head_val'.$numi];
#---------------------------------------
}

$after = implode('||||||||||.||||||||||',$aftertval);
$before = implode('||||||||||.||||||||||',$beforetval);
$_POST['add_quote_gen']=='';
$footer = $_POST['add_quote_gen_footer'].'

<div class="row">
	<div class="col-xs-6">
	<p class="pull-left">
	'.$_POST['add_quote_regards'].'
	</p>
	</div>
	<div class="col-xs-6">
	<p class="pull-right">
		'.$_POST['add_quote_regards2'].'
	</p>
	</div>
</div>



';
$insert = "INSERT INTO `sw_quotes_gen`(`qog_rel_qo_id`, `qog_discount`, `qog_vat`, `qog_extra`, `qog_address`, `qog_before_total`, `qog_after_total`,`qog_extra_price` ,`qog_footer`, `qog_dnt`, `qog_ip`, `qog_rel_lum_id`) VALUES (
'".$getquote['qo_id']."',
'".$_POST['add_quote_gen_discount']."',
'".$_POST['add_quote_gen_vat']."',
'".$_POST['add_quote_gen_extra']."',
'".$_POST['add_quote_address']."',
'".$before."',
'".$after."',
'".$_POST['add_quote_extra_price']."',
'".$footer."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";


if($conn->query($insert)){
	header('Location: sw_quote_print.php?id='.md5($conn->insert_id));
}else{
	die("Could Not Generate Quote Print View");
}

}
/*------------------*/
#logs only generated for the below commands
/*------------------*/
/*--------------------------------------------------------------------*/
if(isset($_POST['add_proforma_quotation'])){
	
if(!isset($_SESSION['STWL_LUM_DB_ID'])){
	die("Login");
}
	if(isset($_POST['add_proforma_quotation_hash']) and ctype_alnum($_POST['add_proforma_quotation_hash'])){
	}else{
		die("Invalid Hash");
	}
	$getquote = getdatafromsql($conn,"select * from sw_quotes where qo_valid =1 and md5(qo_id) = '".$_POST['add_proforma_quotation_hash']."'");
	
	if(is_array($getquote)){
	}else{
		die('Quote not found');
	}
	
	$checkprods = getdatafromsql($conn,"SELECT * FROM sw_quotes_items where qi_rel_qo_id = ".$getquote['qo_id']." and qi_valid =1");

if (!is_array($checkprods)) {
	die("No Products in quote");
}
	
$insert = "INSERT INTO `sw_proformas`(`po_rel_qo_id`, `po_rel_cli_id`, `po_rel_cur_id`, `po_cur_rate`, `po_ref`, `po_proj_name`, `po_subj`, `po_revision`, `po_revision_id`, `po_dnt`, `po_ip`, `po_rel_lum_id`) VALUES (
'".$getquote['qo_id']."',
'".$getquote['qo_rel_cli_id']."',
'".$getquote['qo_rel_cur_id']."',
'".$getquote['qo_cur_rate']."',
'0',
'".$getquote['qo_proj_name']."',
'".$getquote['qo_subj']."',
'0',
'0',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";
if($conn->query($insert)){
	$proid = $conn->insert_id;

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." added new proforma from quotation  with id =".$proid,$_SESSION['STWL_LUM_DB_ID'],'sw_proformas','INSERT',$insert,$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

$insert = "UPDATE `sw_proformas` set
`po_ref` = 'SWPI".date('dmy',time()).$proid."',
`po_revision_id`='".$proid."'
where `po_id`= '".$proid."'

";
	if($conn->query($insert)){
	
	}else{
		die("Unexpected Breakpoint at proforma updation");
	}
	
	
	$getcopyprods = "SELECT * FROM sw_quotes_items where qi_rel_qo_id = ".$getquote['qo_id']." and qi_valid =1";
$getcopyprods = $conn->query($getcopyprods);

if ($getcopyprods->num_rows > 0) {
    // output data of each row
    while($prod = $getcopyprods->fetch_assoc()) {
		if($conn->query("INSERT INTO `sw_proformas_items`( `pi_rel_po_id`, `pi_rel_pr_id`, `pi_qty`, `pi_cost`, `pi_price`, `pi_desc`) VALUES 
		('".$proid."',
		'".$prod['qi_rel_pr_id']."',
		'".$prod['qi_qty']."',
		'".$prod['qi_cost']."',
		'".$prod['qi_price']."',
		'".$prod['qi_desc']."')")){
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." added proforma with id = ".$proid." and added item with id =".$conn->insert_id,$_SESSION['STWL_LUM_DB_ID'],'sw_proformas_items',"insert","INSERT INTO `sw_proformas_items`( `pi_rel_po_id`, `pi_rel_pr_id`, `pi_qty`, `pi_cost`, `pi_price`, `pi_desc`) VALUES 
		('".$proid."',
		'".$prod['qi_rel_pr_id']."',
		'".$prod['qi_qty']."',
		'".$prod['qi_cost']."',
		'".$prod['qi_price']."',
		'".$prod['qi_desc']."')",$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

	
	}else{
		die("Unexpected Breakpoint at proforma product insertion");
	}
	
    }
} else {
    die("No Products");
}
	
	
}else{
	die($conn->error."Could Not Generate Proforma from Quote");
}
	
	header('Location: sw_proforma.php');
}
if(isset($_POST['add_revision_proforma'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die('Login');
	}
#---------------------------------------
if(isset($_POST['add_revision_proforma_proj_name'])){
  if(!is_string($_POST['add_revision_proforma_proj_name'])){
  die('Invalid Characters used in add_revision_proforma_proj_name');   }
  else{}
}else{
  die('Enter add_revision_proforma_proj_name');
}
#---------------------------------------
if(isset($_POST['add_revision_proforma_subj'])){
  if(!is_string($_POST['add_revision_proforma_subj'])){
  die('Invalid Characters used in add_revision_proforma_subj');   }
  else{}
}else{
  die('Enter add_revision_proforma_subj');
}
#---------------------------------------
if(isset($_POST['pro_nos'])){
  if(!is_numeric($_POST['pro_nos']) or ($_POST['pro_nos'] > 1000)){
  die('Invalid Characters used in pro_nos');   }
  else{}
}else{
  die('Enter pro_nos');
}
#---------------------------------------
if(isset($_POST['add_revision_p_hash'])){
  if(!ctype_alnum($_POST['add_revision_p_hash'])){
  die('Invalid Characters used in add_revision_p_hash');   }
  else{}
}else{
  die('Enter add_revision_p_hash');
}
#---------------------------------------

$getqo = getdatafromsql($conn,"select * from sw_proformas where md5(po_id) = '".$_POST['add_revision_p_hash']."' and po_valid =1");
if(!is_array($getqo)){
	die('proforma not found');
}

$getitems = getdatafromsql($conn,"select count(pi_id) as nom from sw_proformas_items where pi_rel_po_id = ".$getqo['po_id']." and pi_valid =1");
if(!is_array($getqo)){
	die('Items not found');
}
for($i = 1;$i < ($getitems['nom'] + 1);$i++){
	if(isset($_POST['add_revision_proforma_product_already_'.$i])){
					  if(!ctype_alnum($_POST['add_revision_proforma_product_already_'.$i])){
						  die('Invalid' .'add_revision_proforma_product_already_'.$i);
					  }
						if(is_array(getdatafromsql($conn,"select * from sw_products_list where md5(pr_id)='".$_POST['add_revision_proforma_product_already_'.$i]."' and pr_valid =1 "))){
						}else{
							die('Invalid Product');
						}
					
						#---------------------------------------
						if(isset($_POST['add_revision_proforma_desc_already_'.$i])){
						  if(!is_string($_POST['add_revision_proforma_desc_already_'.$i])){
						  die('Invalid Characters used in add_revision_proforma_desc_already_'.$i);   }
						  else{}
						}else{
						  die('Enter add_revision_proforma_desc_already_'.$i);
						}
						#---------------------------------------
						if(isset($_POST['add_revision_proforma_cost_already_'.$i])){
						  if(!is_numeric($_POST['add_revision_proforma_cost_already_'.$i])){
						  die('Invalid Characters used in add_revision_proforma_cost_already_'.$i);   }
						  else{}
						}else{
						  die('Enter add_revision_proforma_cost_already_'.$i);
						}
						#---------------------------------------
						if(isset($_POST['add_revision_proforma_price_already_'.$i])){
						  if(!is_numeric($_POST['add_revision_proforma_price_already_'.$i])){
						  die('Invalid Characters used in add_revision_proforma_price_already_'.$i);   }
						  else{}
						}else{
						  die('Enter add_revision_proforma_price_already_'.$i);
						}
						#---------------------------------------
						if(isset($_POST['add_revision_proforma_qty_already_'.$i])){
						  if(!is_numeric($_POST['add_revision_proforma_qty_already_'.$i])){
						  die('Invalid Characters used in add_revision_proforma_qty_already_'.$i);   }
						  else{}
						}else{
						  die('Enter add_revision_proforma_qty_already_'.$i);
						}
	}
}


for($c = 1;$c < ($_POST['pro_nos'] + 1);$c++){
	if($c == 1){
		$numi = '';
	}else{
		$numi = $c;
	}
				#---------------------------------------
				if(isset($_POST['add_revision_proforma_product_a'.$numi])){
				  if(ctype_alnum($_POST['add_revision_proforma_product_a'.$numi]) or ($_POST['add_revision_proforma_product_a'.$numi] === '0') ){
					  
if($_POST['add_revision_proforma_product_a'.$numi] === '0'){
	
}else{
						if(is_array(getdatafromsql($conn,"select * from sw_products_list where md5(pr_id)='".$_POST['add_revision_proforma_product_a'.$numi]."' and pr_valid =1 "))){
						}else{
							die('Invalid Product');
						}
	
}
						
						
				  }else{
					  				  die('Invalid Characters used in add_revision_proforma_product_a'.$numi);   
				  }
				}else{
				  die('Enter add_revision_proforma_product_a'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_revision_proforma_desc_a'.$numi])){
				  if(!is_string($_POST['add_revision_proforma_desc_a'.$numi])){
				  die('Invalid Characters used in add_revision_proforma_desc_a'.$numi);   }
				  else{}
				}else{
				  die('Enter add_revision_proforma_desc_a'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_revision_proforma_cost_a'.$numi])){
				  if(!is_numeric($_POST['add_revision_proforma_cost_a'.$numi])){
				  die('Invalid Characters used in add_revision_proforma_cost_a'.$numi);   }
				  else{}
				}else{
				  die('Enter add_revision_proforma_cost_a'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_revision_proforma_price_a'.$numi])){
				  if(!is_numeric($_POST['add_revision_proforma_price_a'.$numi])){
				  die('Invalid Characters used in add_revision_proforma_price_a'.$numi);   }
				  else{}
				}else{
				  die('Enter add_revision_proforma_price_a'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_revision_proforma_qty_a'.$numi])){
				  if(!is_numeric($_POST['add_revision_proforma_qty_a'.$numi])){
				  die('Invalid Characters used in add_revision_proforma_qty_a'.$numi);   }
				  else{}
				}else{
				  die('Enter add_revision_proforma_qty_a'.$numi);
				}
				
}
$insertproforma = "
INSERT INTO `sw_proformas`(`po_rel_qo_id`,`po_rel_cli_id`, `po_ref`, `po_proj_name`, `po_subj`, `po_revision`, `po_revision_id`, `po_dnt`, `po_ip`, `po_rel_lum_id`) VALUES (
'".$getqo['po_rel_qo_id']."',
'".$getqo['po_rel_cli_id']."',
'".$getqo['po_ref'].'/'.(($getqo['po_revision'] + 1))."',
'".$_POST['add_revision_proforma_proj_name']."',
'".$_POST['add_revision_proforma_subj']."',
'".($getqo['po_revision'] + 1)."',
'".$getqo['po_revision_id']."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";
if($conn->query($insertproforma)){
	$proformaid = $conn->insert_id;
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID'].' added new proforma revision with id ='.$proformaid,$_SESSION['STWL_LUM_DB_ID'],'sw_proformas','INSERT',$insertproforma,$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

	
for($i = 1;$i < ($getitems['nom'] + 1);$i++){
	if(isset($_POST['add_revision_proforma_product_already_'.$i])){
						$pr = getdatafromsql($conn,"select * from sw_products_list where md5(pr_id) = '".$_POST['add_revision_proforma_product_already_'.$i]."'");
						if(!is_array($pr)){
							die("A big error has occured in product after proforma insert");
						}
$insertqitem = "INSERT INTO `sw_proformas_items`(`pi_rel_po_id`, `pi_rel_pr_id`, `pi_qty`, `pi_cost`, `pi_price`, `pi_desc`) VALUES 
(
'".$proformaid."',
'".$pr['pr_id']."',
'".$_POST['add_revision_proforma_qty_already_'.$i]."',
'".$_POST['add_revision_proforma_cost_already_'.$i]."',
'".$_POST['add_revision_proforma_price_already_'.$i]."',
'".$_POST['add_revision_proforma_desc_already_'.$i]."'
)";

if($conn->query($insertqitem)){
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID'].' added proforma revision to id ='.$proformaid." and new product id =".$conn->insert_id,$_SESSION['STWL_LUM_DB_ID'],'sw_proformas_items','INSERT',$insertqitem,$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

}else{
	die("Item Insertion Failed");
}
	}
}

for($c = 1;$c < ($_POST['pro_nos'] + 1);$c++){
	if($_POST['add_revision_proforma_product_a'.$numi] !== '0'){
	if($c == 1){
		$numi = '';
	}else{
		$numi = $c;
	}
$pra = getdatafromsql($conn,"select * from sw_products_list where md5(pr_id) = '".$_POST['add_revision_proforma_product_a'.$numi]."'");
if(!is_array($pra)){
die("A big error has occured in product-2  after proforma insert");
}
$insertq2item = "INSERT INTO `sw_proformas_items`(`pi_rel_po_id`, `pi_rel_pr_id`, `pi_qty`, `pi_cost`, `pi_price`, `pi_desc`) VALUES 
(
'".$proformaid."',
'".$pra['pr_id']."',
'".$_POST['add_revision_proforma_qty_a'.$numi]."',
'".$_POST['add_revision_proforma_cost_a'.$numi]."',
'".$_POST['add_revision_proforma_price_a'.$numi]."',
'".$_POST['add_revision_proforma_desc_a'.$numi]."'
)";


if($conn->query($insertq2item)){
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID'].' added proforma revision to id ='.$proformaid." and new product id =".$conn->insert_id,$_SESSION['STWL_LUM_DB_ID'],'sw_proformas_items','INSERT',$insertq2item,$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

}else{
	die("Item-2 Insertion Failed");
}
				
				
	}
				
}


	
}else{
	die($conn->error.'Could not insert proforma');
}

	header('Location: sw_proforma.php');

}
if(isset($_POST['add_proforma'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die('Login');
	}
#---------------------------------------
if(isset($_POST['add_proforma_currency'])){
  if(!ctype_alnum($_POST['add_proforma_currency'])){
  die('Invalid Characters used in add_proforma_currency');   }
  else{}
}else{
  die('Enter add_proforma_currency');
}
#---------------------------------------
if(isset($_POST['add_proforma_cur_rate'])){
  if(!is_numeric($_POST['add_proforma_cur_rate'])){
  die('Invalid Characters used in add_proforma_cur_rate');   }
  else{}
}else{
  die('Enter add_proforma_cur_rate');
}
#---------------------------------------
if(isset($_POST['add_proforma_client'])){
  if(!ctype_alnum($_POST['add_proforma_client'])){
  die('Invalid Characters used in add_proforma_client');   }
  else{}
}else{
  die('Enter add_proforma_client');
}
#---------------------------------------
if(isset($_POST['add_proforma_project_name'])){
  if(!is_string($_POST['add_proforma_project_name'])){
  die('Invalid Characters used in add_proforma_project_name');   }
  else{}
}else{
  die('Enter add_proforma_project_name');
}
#---------------------------------------
if(isset($_POST['add_proforma_subject_name'])){
  if(!is_string($_POST['add_proforma_subject_name'])){
  die('Invalid Characters used in add_proforma_subject_name');   }
  else{}
}else{
  die('Enter add_proforma_subject_name');
}
#---------------------------------------
if(isset($_POST['per_nos'])){
  if(!is_numeric($_POST['per_nos'])){
  die('Invalid Characters used in per_nos');   }
  else{
	  
if($_POST['per_nos'] > 1000){
	die("Max Limit of products reached");
}

	  }
}else{
  die('Enter per_nos');
}
#---------------------------------------

$getclient = getdatafromsql($conn,"select * from sw_clients where md5(cli_id) = '".$_POST['add_proforma_client']."' and cli_valid =1");
if(!is_array($getclient)){
	die('Client not found');
}

$getcur = getdatafromsql($conn,"select * from sw_currency where md5(cur_id)= '".$_POST['add_proforma_currency']."' ");
if(!is_array($getcur)){
	die('Invalid Currency');
}
for($c = 1;$c < ($_POST['per_nos'] + 1);$c++){
	if($c == 1){
		$numi = '';
	}else{
		$numi = $c;
	}
				#---------------------------------------
				if(isset($_POST['add_proforma_product'.$numi]) and !is_array($_POST['add_proforma_product'.$numi])){
				  if(ctype_alnum($_POST['add_proforma_product'.$numi]) or ($_POST['add_proforma_product'.$numi] === '0') ){
					  
if($_POST['add_proforma_product'.$numi] === '0'){
	die("No Product Selected");
}else{
						if(is_array(getdatafromsql($conn,"select * from sw_products_list where md5(pr_id)='".$_POST['add_proforma_product'.$numi]."' and pr_valid =1"))){
						}else{
							die('Invalid Product');
						}
	
}

						
						
				  }else{
					  				  die('Invalid Characters used in add_proforma_product'.$numi);   
				  }
				}else{
				  die('Enter add_proforma_product'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_proforma_product_desc'.$numi])){
				  if(!is_string($_POST['add_proforma_product_desc'.$numi])){
				  die('Invalid Characters used in add_proforma_product_desc'.$numi);   }
				  else{}
				}else{
				  die('Enter add_proforma_product_desc'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_proforma_product_cost'.$numi])){
				  if(!is_numeric($_POST['add_proforma_product_cost'.$numi])){
				  die('Invalid Characters used in add_proforma_product_cost'.$numi);   }
				  else{}
				}else{
				  die('Enter add_proforma_product_cost'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_proforma_product_price'.$numi])){
				  if(!is_numeric($_POST['add_proforma_product_price'.$numi])){
				  die('Invalid Characters used in add_proforma_product_price'.$numi);   }
				  else{}
				}else{
				  die('Enter add_proforma_product_price'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_proforma_product_qty'.$numi])){
				  if(!is_numeric($_POST['add_proforma_product_qty'.$numi])){
				  die('Invalid Characters used in add_proforma_product_qty'.$numi);   }

				  else{}
				}else{
				  die('Enter add_proforma_product_qty'.$numi);
				}
				
}

$insertproforma = "
INSERT INTO `sw_proformas`(`po_rel_cli_id`, `po_rel_cur_id`, `po_cur_rate`, `po_ref`, `po_proj_name`, `po_subj`, `po_revision`, `po_revision_id`, `po_dnt`, `po_ip`, `po_rel_lum_id`) 
 VALUES (
'".$getclient['cli_id']."',
'".$getcur['cur_id']."',
'".$_POST['add_proforma_cur_rate']."',
'0',
'".$_POST['add_proforma_project_name']."',
'".$_POST['add_proforma_subject_name']."',
'0',
'0',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";
if($conn->query($insertproforma)){
	$proformaid = $conn->insert_id;
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." added proforma without quotation with id =".$proformaid,$_SESSION['STWL_LUM_DB_ID'],'sw_proformas','INSERT',$insertproforma,$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	


$updateproforma = "UPDATE `sw_proformas` SET 
`po_ref`='SWPI".date('dmy',time()).$proformaid."',
`po_revision_id`=".$proformaid."
WHERE po_id = ".$proformaid;

if($conn->query($updateproforma)){

}else{
	die('Error Updating Proforma Reference Id('.$proformaid.')');
}

for($c = 1;$c < ($_POST['per_nos'] + 1);$c++){
	if($c == 1){
		$numi = '';
	}else{
		$numi = $c;
	}
$pra = getdatafromsql($conn,"select * from sw_products_list where md5(pr_id) = '".$_POST['add_proforma_product'.$numi]."'");
if(!is_array($pra)){
die("A big error has occured in product-2  after proforma insert");
}
$insertq2item = "INSERT INTO `sw_proformas_items`(`pi_rel_po_id`, `pi_rel_pr_id`, `pi_qty`, `pi_cost`, `pi_price`, `pi_desc`) VALUES 
(
'".$proformaid."',
'".$pra['pr_id']."',
'".$_POST['add_proforma_product_qty'.$numi]."',
'".$_POST['add_proforma_product_cost'.$numi]."',
'".$_POST['add_proforma_product_price'.$numi]."',
'".$_POST['add_proforma_product_desc'.$numi]."'
)";


if($conn->query($insertq2item)){
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." added proforma without quotation with id =".$proformaid." and new item id=".$conn->insert_id,$_SESSION['STWL_LUM_DB_ID'],'sw_proformas_items','INSERT',$insertq2item,$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

}else{
	die("Item-2 Insertion Failed");
}
				
		
}


	
}else{
	die($conn->error.'Could not insert proforma');
}
	header('Location: sw_proforma.php');

}
if(isset($_POST['add_proforma_gen'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die('Login');	
	}
#---------------------------------------
if(isset($_POST['add_proforma_gen_hash'])){
  if(!ctype_alnum($_POST['add_proforma_gen_hash'])){
  die('Invalid Characters used in add_proforma_gen_hash');   }
  else{}
}else{
  die('Enter add_proforma_gen_hash');
}
#---------------------------------------
if(isset($_POST['add_proforma_gen_discount'])){
  if(!is_numeric($_POST['add_proforma_gen_discount']) or ($_POST['add_proforma_gen_discount'] > 100) or ($_POST['add_proforma_gen_discount'] < 0)){
  die('Invalid Characters used in add_proforma_gen_discount');   }
  else{}
}else{
  die('Enter add_proforma_gen_discount');
}
#---------------------------------------
if(isset($_POST['add_proforma_gen_vat'])){
  if(!is_numeric($_POST['add_proforma_gen_vat'])){
  die('Invalid Characters used in add_proforma_gen_vat');   }
  else{}
}else{
  die('Enter add_proforma_gen_vat');
}
#---------------------------------------
if(isset($_POST['add_proforma_extra_price'])){
  if(!is_numeric($_POST['add_proforma_extra_price'])){
  die('Invalid Characters used in add_proforma_extra_price');   }
  else{}
}else{
  die('Enter add_proforma_extra_price');
}
#---------------------------------------
if(isset($_POST['add_proforma_gen_lpo'])){
  if(!is_string($_POST['add_proforma_gen_lpo'])){
  die('Invalid Characters used in add_proforma_gen_lpo');   }
  else{}
}else{
  die('Enter add_proforma_gen_lpo');
}
#---------------------------------------
if(isset($_POST['add_proforma_gen_payment_t'])){
  if(!is_string($_POST['add_proforma_gen_payment_t'])){
  die('Invalid Characters used in add_proforma_gen_payment_t');   }
  else{}
}else{
  die('Enter add_proforma_gen_payment_t');
}
#---------------------------------------
if(isset($_POST['add_proforma_gen_extra'])){
  if(!is_string($_POST['add_proforma_gen_extra'])){
  die('Invalid Characters used in add_proforma_gen_extra');   }
  else{}
}else{
  die('Enter add_proforma_gen_extra');
}
#---------------------------------------
if(isset($_POST['add_proforma_regards'])){
  if(!is_string($_POST['add_proforma_regards'])){
  die('Invalid Characters used in add_proforma_regards');   }
  else{}
}else{
  die('Enter add_proforma_regards');
}
#---------------------------------------
if(isset($_POST['add_proforma_regards2'])){
  if(!is_string($_POST['add_proforma_regards2'])){
  die('Invalid Characters used in add_proforma_regards2');   }
  else{}
}else{
  die('Enter add_proforma_regards2');
}
#---------------------------------------
if(isset($_POST['add_proforma_address'])){
  if(!is_string($_POST['add_proforma_address'])){
  die('Invalid Characters used in add_proforma_address');   }
  else{}
}else{
  die('Enter add_proforma_address');
}

#---------------------------------------
if(isset($_POST['_wysihtml5_mode'])){
  if(!is_numeric($_POST['_wysihtml5_mode'])){
  die('Invalid Characters used in _wysihtml5_mode');   }
  else{}
}else{
  die('Enter _wysihtml5_mode');
}
#---------------------------------------
if(isset($_POST['add_proforma_gen_footer'])){
  if(!is_string($_POST['add_proforma_gen_footer'])){
  die('Invalid Characters used in add_proforma_gen_footer');   }
  else{}
}else{
  die('Enter add_proforma_gen_footer');
}
#---------------------------------------
if(isset($_POST['before_head_pro_nos'])){
  if(!is_numeric($_POST['before_head_pro_nos'])){
  die('Invalid Characters used in before_head_pro_nos');   }
  else{}
}else{
  die('Enter before_head_pro_nos');
}
#---------------------------------------
if(isset($_POST['after_head_pro_nos'])){
  if(!is_numeric($_POST['after_head_pro_nos'])){
  die('Invalid Characters used in after_head_pro_nos');   }
  else{}
}else{
  die('Enter after_head_pro_nos');
}
$getproforma = getdatafromsql($conn,"select * from sw_proformas where md5(md5(po_id)) = '".$_POST['add_proforma_gen_hash']."' and po_valid =1");

if(is_array($getproforma)){
}else{
	die("No proforma Found");
}

for($c=1;$c < ($_POST['before_head_pro_nos'] + 1) ;$c++){
	
if($c == 1){
	$numi = '';
}else{
	$numi = $c ;
}

		#---------------------------------------
		if(isset($_POST['add_proforma_gen_bf_head'.$numi])){
		  if(!is_string($_POST['add_proforma_gen_bf_head'.$numi])){
		  die('Invalid Characters used in add_proforma_gen_bf_head'.$numi);   }
		  else{}
		}else{
		  die('Enter add_proforma_gen_bf_head'.$numi);
		}
		#---------------------------------------
		if(isset($_POST['add_proforma_gen_bf_head_val'.$numi])){
		  if(!is_string($_POST['add_proforma_gen_bf_head_val'.$numi])){
		  die('Invalid Characters used in add_proforma_gen_bf_head_val'.$numi);   }
		  else{}
		}else{
		  die('Enter add_proforma_gen_bf_head_val'.$numi);
		}
		#---------------------------------------
}
/*------------------------*/
for($a=1; $a < ($_POST['after_head_pro_nos'] + 1) ;$a++){
	
if($a == 1){
	$numi = '';
}else{
	$numi = $a ;
}

		#---------------------------------------
		if(isset($_POST['add_proforma_gen_af_head'.$numi])){
		  if(!is_string($_POST['add_proforma_gen_af_head'.$numi])){
		  die('Invalid Characters used in add_proforma_gen_af_head'.$numi);   }
		  else{}
		}else{
		  die('Enter add_proforma_gen_af_head'.$numi);
		}
		#---------------------------------------
		if(isset($_POST['add_proforma_gen_af_head_val'.$numi])){
		  if(!is_string($_POST['add_proforma_gen_af_head_val'.$numi])){
		  die('Invalid Characters used in add_proforma_gen_af_head_val'.$numi);   }
		  else{}
		}else{
		  die('Enter add_proforma_gen_af_head_val'.$numi);
		}
		#---------------------------------------
}

$beforetval = array();
$aftertval = array();



for($c=1;$c < ($_POST['before_head_pro_nos'] + 1) ;$c++){
	
if($c == 1){
	$numi = '';
}else{
	$numi = $c ;
}

$beforetval[] = $_POST['add_proforma_gen_bf_head'.$numi].'|=|=|=|=|=|'.$_POST['add_proforma_gen_bf_head_val'.$numi];

}
/*------------------------*/
for($a=1; $a < ($_POST['after_head_pro_nos'] + 1) ;$a++){
	
if($a == 1){
	$numi = '';
}else{
	$numi = $a ;
}
$aftertval[] = $_POST['add_proforma_gen_af_head'.$numi].'|=|=|=|=|=|'.$_POST['add_proforma_gen_af_head_val'.$numi];
#---------------------------------------
}

$after = implode('||||||||||.||||||||||',$aftertval);
$before = implode('||||||||||.||||||||||',$beforetval);
$_POST['add_proforma_gen']=='';
$footer = $_POST['add_proforma_gen_footer'].'

<div class="row">
	<div class="col-xs-6">
	<p class="pull-left">
	'.$_POST['add_proforma_regards'].'
	</p>
	</div>
	<div class="col-xs-6">
	<p class="pull-right">
		'.$_POST['add_proforma_regards2'].'
	</p>
	</div>
</div>



';

$insert = "INSERT INTO `sw_proformas_gen`(`pog_rel_po_id`, `pog_discount`, `pog_vat`, `pog_extra`, `pog_address`, `pog_lpo`, `pog_payment_terms`, `pog_before_total`, `pog_after_total`,`pog_extra_price` ,`pog_footer`, `pog_dnt`, `pog_ip`, `pog_rel_lum_id`) VALUES (
'".$getproforma['po_id']."',
'".$_POST['add_proforma_gen_discount']."',
'".$_POST['add_proforma_gen_vat']."',
'".$_POST['add_proforma_gen_extra']."',
'".$_POST['add_proforma_address']."',
'".$_POST['add_proforma_gen_lpo']."',
'".$_POST['add_proforma_gen_payment_t']."',
'".$before."',
'".$after."',
'".$_POST['add_proforma_extra_price']."',
'".$footer."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";

if($conn->query($insert)){
		$pi = $conn->insert_id;

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." printed proforma with id =".$getproforma['po_id'],$_SESSION['STWL_LUM_DB_ID'],'sw_proformas_gen','INSERT',$insert,$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

	header('Location: sw_proforma_print.php?id='.md5($pi));
}else{
	die("Could Not Generate proforma Print View");
}

}
/*--------------------------------------------------------------------*/
if(isset($_POST['add_salesinvoice_proforma'])){
if(!isset($_SESSION['STWL_LUM_DB_ID'])){
	die("Login");
}
	if(isset($_POST['add_salesinvoice_proforma_hash']) and ctype_alnum($_POST['add_salesinvoice_proforma_hash'])){
	}else{
		die("Invalid Hash");
	}
	$getproforma = getdatafromsql($conn,"select * from sw_proformas where po_valid =1 and md5(po_id) = '".$_POST['add_salesinvoice_proforma_hash']."'");
	
	if(is_array($getproforma)){
	}else{
		die('proforma not found');
	}
	
	$checkprods = getdatafromsql($conn,"SELECT * FROM sw_proformas_items where pi_rel_po_id = ".$getproforma['po_id']." and pi_valid =1");

if (!is_array($checkprods)) {
	die("No Products in proforma");
}
	
$insert = "INSERT INTO `sw_salesinvoices`(`so_rel_po_id`, `so_rel_cli_id`, `so_rel_cur_id`, `so_cur_rate`, `so_ref`, `so_proj_name`, `so_subj`, `so_revision`, `so_revision_id`, `so_dnt`, `so_ip`, `so_rel_lum_id`) VALUES (
'".$getproforma['po_id']."',
'".$getproforma['po_rel_cli_id']."',
'".$getproforma['po_rel_cur_id']."',
'".$getproforma['po_cur_rate']."',
'0',
'".$getproforma['po_proj_name']."',
'".$getproforma['po_subj']."',
'0',
'0',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";
if($conn->query($insert)){
	$proid = $conn->insert_id;
	
$insert = "UPDATE `sw_salesinvoices` set
`so_ref` = 'SWI".date('dmy',time()).$proid."',
`so_revision_id`='".$proid."'
where `so_id`= '".$proid."'
";
	if($conn->query($insert)){
	
	}else{
		die("Unexpected Breakpoint at salesinvoice updation");
	}
	
	
	$getcopyprods = "SELECT * FROM sw_proformas_items where pi_rel_po_id = ".$getproforma['po_id']." and pi_valid =1";
$getcopyprods = $conn->query($getcopyprods);

if ($getcopyprods->num_rows > 0) {
    // output data of each row
    while($prod = $getcopyprods->fetch_assoc()) {
		if($conn->query("INSERT INTO `sw_salesinvoices_items`( `si_rel_so_id`, `si_rel_pr_id`, `si_qty`, `si_cost`, `si_price`, `si_desc`) VALUES 
		('".$proid."',
		'".$prod['pi_rel_pr_id']."',
		'".$prod['pi_qty']."',
		'".$prod['pi_cost']."',
		'".$prod['pi_price']."',
		'".$prod['pi_desc']."')")){
	
	}else{
		die("Unexpected Breakpoint at salesinvoice product insertion");
	}
	
    }
} else {
    die("No Products");
}
	
	
}else{
	die($conn->error."Could Not Generate salesinvoice from proforma");
}
	
	header('Location: sw_salesinvoice.php');
}
if(isset($_POST['add_revision_salesinvoice'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die('Login');
	}
#---------------------------------------
if(isset($_POST['add_revision_salesinvoice_proj_name'])){
  if(!is_string($_POST['add_revision_salesinvoice_proj_name'])){
  die('Invalid Characters used in add_revision_salesinvoice_proj_name');   }
  else{}
}else{
  die('Enter add_revision_salesinvoice_proj_name');
}
#---------------------------------------
if(isset($_POST['add_revision_salesinvoice_subj'])){
  if(!is_string($_POST['add_revision_salesinvoice_subj'])){
  die('Invalid Characters used in add_revision_salesinvoice_subj');   }
  else{}
}else{
  die('Enter add_revision_salesinvoice_subj');
}
#---------------------------------------
if(isset($_POST['si_nos'])){
  if(!is_numeric($_POST['si_nos']) or ($_POST['si_nos'] > 1000)){
  die('Invalid Characters used in pro_nos');   }
  else{}
}else{
  die('Enter pro_nos');
}
#---------------------------------------
if(isset($_POST['add_revision_s_hash'])){
  if(!ctype_alnum($_POST['add_revision_s_hash'])){
  die('Invalid Characters used in add_revision_s_hash');   }
  else{}
}else{
  die('Enter add_revision_s_hash');
}
#---------------------------------------

$getqo = getdatafromsql($conn,"select * from sw_salesinvoices where md5(so_id) = '".$_POST['add_revision_s_hash']."' and so_valid =1");
if(!is_array($getqo)){
	die('salesinvoice not found');
}

$getitems = getdatafromsql($conn,"select count(si_id) as nom from sw_salesinvoices_items where si_rel_so_id = ".$getqo['so_id']." and si_valid =1");
if(!is_array($getqo)){
	die('Items not found');
}
for($i = 1;$i < ($getitems['nom'] + 1);$i++){
	if(isset($_POST['add_revision_salesinvoice_product_already_'.$i])){
					  if(!ctype_alnum($_POST['add_revision_salesinvoice_product_already_'.$i])){
						  die('Invalid' .'add_revision_salesinvoice_product_already_'.$i);
					  }
						if(is_array(getdatafromsql($conn,"select * from sw_products_list where md5(pr_id)='".$_POST['add_revision_salesinvoice_product_already_'.$i]."' and pr_valid =1 "))){
						}else{
							die('Invalid Product');
						}
					
						#---------------------------------------
						if(isset($_POST['add_revision_salesinvoice_desc_already_'.$i])){
						  if(!is_string($_POST['add_revision_salesinvoice_desc_already_'.$i])){
						  die('Invalid Characters used in add_revision_salesinvoice_desc_already_'.$i);   }
						  else{}
						}else{
						  die('Enter add_revision_salesinvoice_desc_already_'.$i);
						}
						#---------------------------------------
						if(isset($_POST['add_revision_salesinvoice_cost_already_'.$i])){
						  if(!is_numeric($_POST['add_revision_salesinvoice_cost_already_'.$i])){
						  die('Invalid Characters used in add_revision_salesinvoice_cost_already_'.$i);   }
						  else{}
						}else{
						  die('Enter add_revision_salesinvoice_cost_already_'.$i);
						}
						#---------------------------------------
						if(isset($_POST['add_revision_salesinvoice_price_already_'.$i])){
						  if(!is_numeric($_POST['add_revision_salesinvoice_price_already_'.$i])){
						  die('Invalid Characters used in add_revision_salesinvoice_price_already_'.$i);   }
						  else{}
						}else{
						  die('Enter add_revision_salesinvoice_price_already_'.$i);
						}
						#---------------------------------------
						if(isset($_POST['add_revision_salesinvoice_qty_already_'.$i])){
						  if(!is_numeric($_POST['add_revision_salesinvoice_qty_already_'.$i])){
						  die('Invalid Characters used in add_revision_salesinvoice_qty_already_'.$i);   }
						  else{}
						}else{
						  die('Enter add_revision_salesinvoice_qty_already_'.$i);
						}
	}
}


for($c = 1;$c < ($_POST['si_nos'] + 1);$c++){
	if($c == 1){
		$numi = '';
	}else{
		$numi = $c;
	}
				#---------------------------------------
				if(isset($_POST['add_revision_salesinvoice_product_a'.$numi])){
				  if(ctype_alnum($_POST['add_revision_salesinvoice_product_a'.$numi]) or ($_POST['add_revision_salesinvoice_product_a'.$numi] === '0') ){
					  
if($_POST['add_revision_salesinvoice_product_a'.$numi] === '0'){
	
}else{
						if(is_array(getdatafromsql($conn,"select * from sw_products_list where md5(pr_id)='".$_POST['add_revision_salesinvoice_product_a'.$numi]."' and pr_valid =1 "))){
						}else{
							die('Invalid Product');
						}
	
}
						
						
				  }else{
					  				  die('Invalid Characters used in add_revision_salesinvoice_product_a'.$numi);   
				  }
				}else{
				  die('Enter add_revision_salesinvoice_product_a'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_revision_salesinvoice_desc_a'.$numi])){
				  if(!is_string($_POST['add_revision_salesinvoice_desc_a'.$numi])){
				  die('Invalid Characters used in add_revision_salesinvoice_desc_a'.$numi);   }
				  else{}
				}else{
				  die('Enter add_revision_salesinvoice_desc_a'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_revision_salesinvoice_cost_a'.$numi])){
				  if(!is_numeric($_POST['add_revision_salesinvoice_cost_a'.$numi])){
				  die('Invalid Characters used in add_revision_salesinvoice_cost_a'.$numi);   }
				  else{}
				}else{
				  die('Enter add_revision_salesinvoice_cost_a'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_revision_salesinvoice_price_a'.$numi])){
				  if(!is_numeric($_POST['add_revision_salesinvoice_price_a'.$numi])){
				  die('Invalid Characters used in add_revision_salesinvoice_price_a'.$numi);   }
				  else{}
				}else{
				  die('Enter add_revision_salesinvoice_price_a'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_revision_salesinvoice_qty_a'.$numi])){
				  if(!is_numeric($_POST['add_revision_salesinvoice_qty_a'.$numi])){
				  die('Invalid Characters used in add_revision_salesinvoice_qty_a'.$numi);   }
				  else{}
				}else{
				  die('Enter add_revision_salesinvoice_qty_a'.$numi);
				}
				
}
$insertsalesinvoice = "
INSERT INTO `sw_salesinvoices`(`so_rel_po_id`,`so_rel_cli_id`, `so_ref`, `so_proj_name`, `so_subj`, `so_revision`, `so_revision_id`, `so_dnt`, `so_ip`, `so_rel_lum_id`) VALUES (
'".$getqo['so_rel_po_id']."',
'".$getqo['so_rel_cli_id']."',
'".$getqo['so_ref'].'/'.(($getqo['so_revision'] + 1))."',
'".$_POST['add_revision_salesinvoice_proj_name']."',
'".$_POST['add_revision_salesinvoice_subj']."',
'".($getqo['so_revision'] + 1)."',
'".$getqo['so_revision_id']."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";
if($conn->query($insertsalesinvoice)){
	$salesinvoiceid = $conn->insert_id;
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." revised salesivoice id= ".$salesinvoiceid,$_SESSION['STWL_LUM_DB_ID'],'sw_salesinvoices','INSERT',$insertsalesinvoice,$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

	
for($i = 1;$i < ($getitems['nom'] + 1);$i++){
	if(isset($_POST['add_revision_salesinvoice_product_already_'.$i])){
						$pr = getdatafromsql($conn,"select * from sw_products_list where md5(pr_id) = '".$_POST['add_revision_salesinvoice_product_already_'.$i]."'");
						if(!is_array($pr)){
							die("A big error has occured in product after salesinvoice insert");
						}
$insertqitem = "INSERT INTO `sw_salesinvoices_items`(`si_rel_so_id`, `si_rel_pr_id`, `si_qty`, `si_cost`, `si_price`, `si_desc`) VALUES 
(
'".$salesinvoiceid."',
'".$pr['pr_id']."',
'".$_POST['add_revision_salesinvoice_qty_already_'.$i]."',
'".$_POST['add_revision_salesinvoice_cost_already_'.$i]."',
'".$_POST['add_revision_salesinvoice_price_already_'.$i]."',
'".$_POST['add_revision_salesinvoice_desc_already_'.$i]."'
)";

if($conn->query($insertqitem)){
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." revised salesivoice id= ".$salesinvoiceid." and added item with id=".$conn->insert_id,$_SESSION['STWL_LUM_DB_ID'],'sw_salesinvoices_items','INSERT',$insertqitem,$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

}else{
	die("Item Insertion Failed");
}
	}
}

for($c = 1;$c < ($_POST['si_nos'] + 1);$c++){
	if($_POST['add_revision_salesinvoice_product_a'.$numi] !== '0'){
	if($c == 1){
		$numi = '';
	}else{
		$numi = $c;
	}
$pra = getdatafromsql($conn,"select * from sw_products_list where md5(pr_id) = '".$_POST['add_revision_salesinvoice_product_a'.$numi]."'");
if(!is_array($pra)){
die("A big error has occured in product-2  after salesinvoice insert");
}
$insertq2item = "INSERT INTO `sw_salesinvoices_items`(`si_rel_so_id`, `si_rel_pr_id`, `si_qty`, `si_cost`, `si_price`, `si_desc`) VALUES 
(
'".$salesinvoiceid."',
'".$pra['pr_id']."',
'".$_POST['add_revision_salesinvoice_qty_a'.$numi]."',
'".$_POST['add_revision_salesinvoice_cost_a'.$numi]."',
'".$_POST['add_revision_salesinvoice_price_a'.$numi]."',
'".$_POST['add_revision_salesinvoice_desc_a'.$numi]."'
)";


if($conn->query($insertq2item)){
	/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." revised salesivoice id= ".$salesinvoiceid." and added item with id=".$conn->insert_id,$_SESSION['STWL_LUM_DB_ID'],'sw_salesinvoices_items','INSERT',$insertq2item,$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

}else{
	die("Item-2 Insertion Failed");
}
				
				
	}
				
}


	
}else{
	die($conn->error.'Could not insert salesinvoice');
}

	header('Location: sw_salesinvoice.php');

}
if(isset($_POST['add_salesinvoice_gen'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die('Login');	
	}
#---------------------------------------
if(isset($_POST['add_salesinvoice_gen_hash'])){
  if(!ctype_alnum($_POST['add_salesinvoice_gen_hash'])){
  die('Invalid Characters used in add_salesinvoice_gen_hash');   }
  else{}
}else{
  die('Enter add_salesinvoice_gen_hash');
}
#---------------------------------------
if(isset($_POST['add_salesinvoice_gen_discount'])){
  if(!is_numeric($_POST['add_salesinvoice_gen_discount']) or ($_POST['add_salesinvoice_gen_discount'] > 100) or ($_POST['add_salesinvoice_gen_discount'] < 0)){
  die('Invalid Characters used in add_salesinvoice_gen_discount');   }
  else{}
}else{
  die('Enter add_salesinvoice_gen_discount');
}
#---------------------------------------
if(isset($_POST['add_salesinvoice_gen_vat'])){
  if(!is_numeric($_POST['add_salesinvoice_gen_vat'])){
  die('Invalid Characters used in add_salesinvoice_gen_vat');   }
  else{}
}else{
  die('Enter add_salesinvoice_gen_vat');
}
#---------------------------------------
if(isset($_POST['add_salesinvoice_extra_price'])){
  if(!is_numeric($_POST['add_salesinvoice_extra_price'])){
  die('Invalid Characters used in add_salesinvoice_extra_price');   }
  else{}
}else{
  die('Enter add_salesinvoice_extra_price');
}
#---------------------------------------
if(isset($_POST['add_salesinvoice_gen_lpo'])){
  if(!is_string($_POST['add_salesinvoice_gen_lpo'])){
  die('Invalid Characters used in add_salesinvoice_gen_lpo');   }
  else{}
}else{
  die('Enter add_salesinvoice_gen_lpo');
}
#---------------------------------------
if(isset($_POST['add_salesinvoice_gen_payment_t'])){
  if(!is_string($_POST['add_salesinvoice_gen_payment_t'])){
  die('Invalid Characters used in add_salesinvoice_gen_payment_t');   }
  else{}
}else{
  die('Enter add_salesinvoice_gen_payment_t');
}
#---------------------------------------
if(isset($_POST['add_salesinvoice_gen_extra'])){
  if(!is_string($_POST['add_salesinvoice_gen_extra'])){
  die('Invalid Characters used in add_salesinvoice_gen_extra');   }
  else{}
}else{
  die('Enter add_salesinvoice_gen_extra');
}
#---------------------------------------
if(isset($_POST['add_salesinvoice_regards'])){
  if(!is_string($_POST['add_salesinvoice_regards'])){
  die('Invalid Characters used in add_salesinvoice_regards');   }
  else{}
}else{
  die('Enter add_salesinvoice_regards');
}
#---------------------------------------
if(isset($_POST['add_salesinvoice_regards2'])){
  if(!is_string($_POST['add_salesinvoice_regards2'])){
  die('Invalid Characters used in add_salesinvoice_regards2');   }
  else{}
}else{
  die('Enter add_salesinvoice_regards2');
}
#---------------------------------------
if(isset($_POST['add_salesinvoice_address'])){
  if(!is_string($_POST['add_salesinvoice_address'])){
  die('Invalid Characters used in add_salesinvoice_address');   }
  else{}
}else{
  die('Enter add_salesinvoice_address');
}
#---------------------------------------
if(isset($_POST['_wysihtml5_mode'])){
  if(!is_numeric($_POST['_wysihtml5_mode'])){
  die('Invalid Characters used in _wysihtml5_mode');   }
  else{}
}else{
  die('Enter _wysihtml5_mode');
}
#---------------------------------------
if(isset($_POST['add_salesinvoice_gen_footer'])){
  if(!is_string($_POST['add_salesinvoice_gen_footer'])){
  die('Invalid Characters used in add_salesinvoice_gen_footer');   }
  else{}
}else{
  die('Enter add_salesinvoice_gen_footer');
}
#---------------------------------------
if(isset($_POST['before_head_si_nos'])){
  if(!is_numeric($_POST['before_head_si_nos'])){
  die('Invalid Characters used in before_head_si_nos');   }
  else{}
}else{
  die('Enter before_head_si_nos');
}
#---------------------------------------
if(isset($_POST['after_head_si_nos'])){
  if(!is_numeric($_POST['after_head_si_nos'])){
  die('Invalid Characters used in after_head_si_nos');   }
  else{}
}else{
  die('Enter after_head_si_nos');
}
$getsalesinvoice = getdatafromsql($conn,"select * from sw_salesinvoices where md5(md5(so_id)) = '".$_POST['add_salesinvoice_gen_hash']."' and so_valid =1");

if(is_array($getsalesinvoice)){
}else{
	die("No salesinvoice Found");
}

for($c=1;$c < ($_POST['before_head_si_nos'] + 1) ;$c++){
	
if($c == 1){
	$numi = '';
}else{
	$numi = $c ;
}

		#---------------------------------------
		if(isset($_POST['add_salesinvoice_gen_bf_head'.$numi])){
		  if(!is_string($_POST['add_salesinvoice_gen_bf_head'.$numi])){
		  die('Invalid Characters used in add_salesinvoice_gen_bf_head'.$numi);   }
		  else{}
		}else{
		  die('Enter add_salesinvoice_gen_bf_head'.$numi);
		}
		#---------------------------------------
		if(isset($_POST['add_salesinvoice_gen_bf_head_val'.$numi])){
		  if(!is_string($_POST['add_salesinvoice_gen_bf_head_val'.$numi])){
		  die('Invalid Characters used in add_salesinvoice_gen_bf_head_val'.$numi);   }
		  else{}
		}else{
		  die('Enter add_salesinvoice_gen_bf_head_val'.$numi);
		}
		#---------------------------------------
}
/*------------------------*/
for($a=1; $a < ($_POST['after_head_si_nos'] + 1) ;$a++){
	
if($a == 1){
	$numi = '';
}else{
	$numi = $a ;
}

		#---------------------------------------
		if(isset($_POST['add_salesinvoice_gen_af_head'.$numi])){
		  if(!is_string($_POST['add_salesinvoice_gen_af_head'.$numi])){
		  die('Invalid Characters used in add_salesinvoice_gen_af_head'.$numi);   }
		  else{}
		}else{
		  die('Enter add_salesinvoice_gen_af_head'.$numi);
		}
		#---------------------------------------
		if(isset($_POST['add_salesinvoice_gen_af_head_val'.$numi])){
		  if(!is_string($_POST['add_salesinvoice_gen_af_head_val'.$numi])){
		  die('Invalid Characters used in add_salesinvoice_gen_af_head_val'.$numi);   }
		  else{}
		}else{
		  die('Enter add_salesinvoice_gen_af_head_val'.$numi);
		}
		#---------------------------------------
}

$beforetval = array();
$aftertval = array();



for($c=1;$c < ($_POST['before_head_si_nos'] + 1) ;$c++){
	
if($c == 1){
	$numi = '';
}else{
	$numi = $c ;
}

$beforetval[] = $_POST['add_salesinvoice_gen_bf_head'.$numi].'|=|=|=|=|=|'.$_POST['add_salesinvoice_gen_bf_head_val'.$numi];

}
/*------------------------*/
for($a=1; $a < ($_POST['after_head_si_nos'] + 1) ;$a++){
	
if($a == 1){
	$numi = '';
}else{
	$numi = $a ;
}
$aftertval[] = $_POST['add_salesinvoice_gen_af_head'.$numi].'|=|=|=|=|=|'.$_POST['add_salesinvoice_gen_af_head_val'.$numi];
#---------------------------------------
}

$after = implode('||||||||||.||||||||||',$aftertval);
$before = implode('||||||||||.||||||||||',$beforetval);
$_POST['add_salesinvoice_gen']=='';
$footer = $_POST['add_salesinvoice_gen_footer'].'

<div class="row">
	<div class="col-xs-6">
	<p class="pull-left">
	'.$_POST['add_salesinvoice_regards'].'
	</p>
	</div>
	<div class="col-xs-6">
	<p class="pull-right">
		'.$_POST['add_salesinvoice_regards2'].'
	</p>
	</div>
</div>



';

$insert = "INSERT INTO `sw_salesinvoices_gen`(`sog_rel_so_id`, `sog_discount`, `sog_vat`, `sog_extra`, `sog_address`, `sog_lpo`, `sog_payment_terms`, `sog_before_total`, `sog_after_total`,`sog_extra_price` ,`sog_footer`, `sog_dnt`, `sog_ip`, `sog_rel_lum_id`) VALUES (
'".$getsalesinvoice['so_id']."',
'".$_POST['add_salesinvoice_gen_discount']."',
'".$_POST['add_salesinvoice_gen_vat']."',
'".$_POST['add_salesinvoice_gen_extra']."',
'".$_POST['add_salesinvoice_address']."',
'".$_POST['add_salesinvoice_gen_lpo']."',
'".$_POST['add_salesinvoice_gen_payment_t']."',
'".$before."',
'".$after."',
'".$_POST['add_salesinvoice_extra_price']."',
'".$footer."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";


if($conn->query($insert)){
		$pi = $conn->insert_id;

	/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." printed sales invoice id ".$getsalesinvoice['so_id'],$_SESSION['STWL_LUM_DB_ID'],'sw_salesinvoices_gen','INSERT',$insert,$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

	header('Location: sw_salesinvoice_print.php?id='.md5($pi));
}else{
	die("Could Not Generate salesinvoice Print View");
}

}
/*--------------------------------------------------------------------*/
if(isset($_POST['add_deliveryorder_proforma'])){
if(!isset($_SESSION['STWL_LUM_DB_ID'])){
	die("Login");
}
	if(isset($_POST['add_deliveryorder_proforma_hash']) and ctype_alnum($_POST['add_deliveryorder_proforma_hash'])){
	}else{
		die("Invalid Hash");
	}
	$getproforma = getdatafromsql($conn,"select * from sw_proformas where po_valid =1 and md5(po_id) = '".$_POST['add_deliveryorder_proforma_hash']."' ");
	
	if(is_array($getproforma)){
	}else{
		die('proforma not found');
	}
	
	$checkprods = getdatafromsql($conn,"SELECT * FROM sw_proformas_items where pi_rel_po_id = ".$getproforma['po_id']." and pi_valid =1");

if (!is_array($checkprods)) {
	die("No Products in proforma");
}
	
$insert = "INSERT INTO `sw_deliveryorders`(`do_rel_po_id`, `do_rel_cli_id`, `do_rel_cur_id`, `do_cur_rate`, `do_ref`, `do_proj_name`, `do_subj`, `do_revision`, `do_revision_id`, `do_dnt`, `do_ip`, `do_rel_lum_id`) VALUES (
'".$getproforma['po_id']."',
'".$getproforma['po_rel_cli_id']."',
'".$getproforma['po_rel_cur_id']."',
'".$getproforma['po_cur_rate']."',
'0',
'".$getproforma['po_proj_name']."',
'".$getproforma['po_subj']."',
'0',
'0',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";

if($conn->query($insert)){
	$proid = $conn->insert_id;
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." added delivery order from proforma id = ".$proid,$_SESSION['STWL_LUM_DB_ID'],'sw_deliveryorders','INSERT',$inssql,$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
	

$insert = "UPDATE `sw_deliveryorders` set
`do_ref` = 'SWDO".date('dmy',time()).$proid."',
`do_revision_id`='".$proid."'
where `do_id`= '".$proid."'
";
	if($conn->query($insert)){
	
	}else{
		die("Unexpected Breakpoint at deliveryorder updation");
	}
	
	
	$getcopyprods = "SELECT * FROM sw_proformas_items where pi_rel_po_id = ".$getproforma['po_id']." and pi_valid =1";
$getcopyprods = $conn->query($getcopyprods);

if ($getcopyprods->num_rows > 0) {
    // output data of each row
    while($prod = $getcopyprods->fetch_assoc()) {
		if($conn->query("INSERT INTO `sw_deliveryorders_items`( `di_rel_do_id`, `di_rel_pr_id`, `di_qty`, `di_cost`, `di_price`, `di_desc`) VALUES 
		('".$proid."',
		'".$prod['pi_rel_pr_id']."',
		'".$prod['pi_qty']."',
		'".$prod['pi_cost']."',
		'".$prod['pi_price']."',
		'".$prod['pi_desc']."')")){
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." user added del_or item to delorid = ".$proid." and new item id =".$conn->insert_id,$_SESSION['STWL_LUM_DB_ID'],'sw_deliveryorders_items','INSERT',"INSERT INTO `sw_deliveryorders_items`( `di_rel_do_id`, `di_rel_pr_id`, `di_qty`, `di_cost`, `di_price`, `di_desc`) VALUES 
		('".$proid."',
		'".$prod['pi_rel_pr_id']."',
		'".$prod['pi_qty']."',
		'".$prod['pi_cost']."',
		'".$prod['pi_price']."',
		'".$prod['pi_desc']."')",$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

	
	}else{
		die("Unexpected Breakpoint at deliveryorder product insertion");
	}
	
    }
} else {
    die("No Products");
}
	
	
}else{
	die($conn->error."Could Not Generate deliveryorder from proforma");
}
	
	header('Location: sw_del_or.php');
}
if(isset($_POST['add_revision_deliveryorder'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die('Login');
	}
#---------------------------------------
if(isset($_POST['add_revision_deliveryorder_proj_name'])){
  if(!is_string($_POST['add_revision_deliveryorder_proj_name'])){
  die('Invalid Characters used in add_revision_deliveryorder_proj_name');   }
  else{}
}else{
  die('Enter add_revision_deliveryorder_proj_name');
}
#---------------------------------------
if(isset($_POST['add_revision_deliveryorder_subj'])){
  if(!is_string($_POST['add_revision_deliveryorder_subj'])){
  die('Invalid Characters used in add_revision_deliveryorder_subj');   }
  else{}
}else{
  die('Enter add_revision_deliveryorder_subj');
}
#---------------------------------------
if(isset($_POST['di_nos'])){
  if(!is_numeric($_POST['di_nos']) or ($_POST['di_nos'] > 1000)){
  die('Invalid Characters used in di_nos');   }
  else{}
}else{
  die('Enter di_nos');
}
#---------------------------------------
if(isset($_POST['add_revision_d_hash'])){
  if(!ctype_alnum($_POST['add_revision_d_hash'])){
  die('Invalid Characters used in add_revision_d_hash');   }
  else{}
}else{
  die('Enter add_revision_d_hash');
}
#---------------------------------------

$getqo = getdatafromsql($conn,"select * from sw_deliveryorders where md5(do_id) = '".$_POST['add_revision_d_hash']."' and do_valid =1");
if(!is_array($getqo)){
	die('deliveryorder not found');
}

$getitems = getdatafromsql($conn,"select count(di_id) as nom from sw_deliveryorders_items where di_rel_do_id = ".$getqo['do_id']." and di_valid =1");
if(!is_array($getqo)){
	die('Items not found');
}
for($i = 1;$i < ($getitems['nom'] + 1);$i++){

	if(isset($_POST['add_revision_deliveryorder_product_already_'.$i])){
					  if(!ctype_alnum($_POST['add_revision_deliveryorder_product_already_'.$i])){
						  die('Invalid' .'add_revision_deliveryorder_product_already_'.$i);
					  }
						if(is_array(getdatafromsql($conn,"select * from sw_products_list where md5(pr_id)='".$_POST['add_revision_deliveryorder_product_already_'.$i]."' and pr_valid =1 "))){
						}else{
							die('Invalid Product');
						}
					
						#---------------------------------------
						if(isset($_POST['add_revision_deliveryorder_desc_already_'.$i])){
						  if(!is_string($_POST['add_revision_deliveryorder_desc_already_'.$i])){
						  die('Invalid Characters used in add_revision_deliveryorder_desc_already_'.$i);   }
						  else{}
						}else{
						  die('Enter add_revision_deliveryorder_desc_already_'.$i);
						}
						#---------------------------------------
						if(isset($_POST['add_revision_deliveryorder_cost_already_'.$i])){
						  if(!is_numeric($_POST['add_revision_deliveryorder_cost_already_'.$i])){
						  die('Invalid Characters used in add_revision_deliveryorder_cost_already_'.$i);   }
						  else{}
						}else{
						  die('Enter add_revision_deliveryorder_cost_already_'.$i);
						}
						#---------------------------------------
						if(isset($_POST['add_revision_deliveryorder_price_already_'.$i])){
						  if(!is_numeric($_POST['add_revision_deliveryorder_price_already_'.$i])){
						  die('Invalid Characters used in add_revision_deliveryorder_price_already_'.$i);   }
						  else{}
						}else{
						  die('Enter add_revision_deliveryorder_price_already_'.$i);
						}
						#---------------------------------------
						if(isset($_POST['add_revision_deliveryorder_qty_already_'.$i])){
						  if(!is_numeric($_POST['add_revision_deliveryorder_qty_already_'.$i])){
						  die('Invalid Characters used in add_revision_deliveryorder_qty_already_'.$i);   }
						  else{}
						}else{
						  die('Enter add_revision_deliveryorder_qty_already_'.$i);
						}
	}
}


for($c = 1;$c < ($_POST['di_nos'] + 1);$c++){
	if($c == 1){
		$numi = '';
	}else{
		$numi = $c;
	}
				#---------------------------------------
				if(isset($_POST['add_revision_deliveryorder_product_a'.$numi])){
				  if(ctype_alnum($_POST['add_revision_deliveryorder_product_a'.$numi]) or ($_POST['add_revision_deliveryorder_product_a'.$numi] === '0') ){
					  
if($_POST['add_revision_deliveryorder_product_a'.$numi] === '0'){
	
}else{
						if(is_array(getdatafromsql($conn,"select * from sw_products_list where md5(pr_id)='".$_POST['add_revision_deliveryorder_product_a'.$numi]."' and pr_valid =1 "))){
						}else{
							die('Invalid Product');
						}
	
}
						
						
				  }else{
					  				  die('Invalid Characters used in add_revision_deliveryorder_product_a'.$numi);   
				  }
				}else{
				  die('Enter add_revision_deliveryorder_product_a'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_revision_deliveryorder_desc_a'.$numi])){
				  if(!is_string($_POST['add_revision_deliveryorder_desc_a'.$numi])){
				  die('Invalid Characters used in add_revision_deliveryorder_desc_a'.$numi);   }
				  else{}
				}else{
				  die('Enter add_revision_deliveryorder_desc_a'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_revision_deliveryorder_cost_a'.$numi])){
				  if(!is_numeric($_POST['add_revision_deliveryorder_cost_a'.$numi])){
				  die('Invalid Characters used in add_revision_deliveryorder_cost_a'.$numi);   }
				  else{}
				}else{
				  die('Enter add_revision_deliveryorder_cost_a'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_revision_deliveryorder_price_a'.$numi])){
				  if(!is_numeric($_POST['add_revision_deliveryorder_price_a'.$numi])){
				  die('Invalid Characters used in add_revision_deliveryorder_price_a'.$numi);   }
				  else{}
				}else{
				  die('Enter add_revision_deliveryorder_price_a'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_revision_deliveryorder_qty_a'.$numi])){
				  if(!is_numeric($_POST['add_revision_deliveryorder_qty_a'.$numi])){
				  die('Invalid Characters used in add_revision_deliveryorder_qty_a'.$numi);   }
				  else{}
				}else{
				  die('Enter add_revision_deliveryorder_qty_a'.$numi);
				}
				
}
$insertdeliveryorder = "
INSERT INTO `sw_deliveryorders`(`do_rel_po_id`,`do_rel_cli_id`, `do_ref`, `do_proj_name`, `do_subj`, `do_revision`, `do_revision_id`, `do_dnt`, `do_ip`, `do_rel_lum_id`) VALUES (
'".$getqo['do_rel_po_id']."',
'".$getqo['do_rel_cli_id']."',
'".$getqo['do_ref'].'/'.(($getqo['do_revision'] + 1))."',
'".$_POST['add_revision_deliveryorder_proj_name']."',
'".$_POST['add_revision_deliveryorder_subj']."',
'".($getqo['do_revision'] + 1)."',
'".$getqo['do_revision_id']."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";
if($conn->query($insertdeliveryorder)){
	$deliveryorderid = $conn->insert_id;
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." user revised delivery order id= ".$deliveryorderid,$_SESSION['STWL_LUM_DB_ID'],'sw_deliveryorders','INSERT',$insertdeliveryorder,$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

	
for($i = 1;$i < ($getitems['nom'] + 1);$i++){
	if(isset($_POST['add_revision_deliveryorder_product_already_'.$i])){
						$pr = getdatafromsql($conn,"select * from sw_products_list where md5(pr_id) = '".$_POST['add_revision_deliveryorder_product_already_'.$i]."'");
						if(!is_array($pr)){
							die("A big error has occured in product after deliveryorder insert");
						}
$insertqitem = "INSERT INTO `sw_deliveryorders_items`(`di_rel_do_id`, `di_rel_pr_id`, `di_qty`, `di_cost`, `di_price`, `di_desc`) VALUES 
(
'".$deliveryorderid."',
'".$pr['pr_id']."',
'".$_POST['add_revision_deliveryorder_qty_already_'.$i]."',
'".$_POST['add_revision_deliveryorder_cost_already_'.$i]."',
'".$_POST['add_revision_deliveryorder_price_already_'.$i]."',
'".$_POST['add_revision_deliveryorder_desc_already_'.$i]."'
)";

if($conn->query($insertqitem)){
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." revised delivery order  id=".$deliveryorderid." new item id =".$conn->insert_id,$_SESSION['STWL_LUM_DB_ID'],'sw_deliveryorders_items','INSERT',$insertqitem,$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

}else{
	die("Item Insertion Failed");
}
	}
}

for($c = 1;$c < ($_POST['di_nos'] + 1);$c++){
	if($_POST['add_revision_deliveryorder_product_a'.$numi] !== '0'){
	if($c == 1){
		$numi = '';
	}else{
		$numi = $c;
	}
$pra = getdatafromsql($conn,"select * from sw_products_list where md5(pr_id) = '".$_POST['add_revision_deliveryorder_product_a'.$numi]."'");
if(!is_array($pra)){
die("A big error has occured in product-2  after deliveryorder insert");
}
$insertq2item = "INSERT INTO `sw_deliveryorders_items`(`di_rel_do_id`, `di_rel_pr_id`, `di_qty`, `di_cost`, `di_price`, `di_desc`) VALUES 
(
'".$deliveryorderid."',
'".$pra['pr_id']."',
'".$_POST['add_revision_deliveryorder_qty_a'.$numi]."',
'".$_POST['add_revision_deliveryorder_cost_a'.$numi]."',
'".$_POST['add_revision_deliveryorder_price_a'.$numi]."',
'".$_POST['add_revision_deliveryorder_desc_a'.$numi]."'
)";


if($conn->query($insertq2item)){
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." user revised del_or item of del or id =".$deliveryorderid." item id =".$conn->insert_id ,$_SESSION['STWL_LUM_DB_ID'],'sw_deliveryorders_items','INSERT',$insertq2item,$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
	
}else{
	die("Item-2 Insertion Failed");
}
				
				
	}
				
}


	
}else{
	die($conn->error.'Could not insert deliveryorder');
}

	header('Location: sw_del_or.php');

}
if(isset($_POST['add_deliveryorder_gen'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die('Login');	
	}
#---------------------------------------
if(isset($_POST['add_deliveryorder_gen_hash'])){
  if(!ctype_alnum($_POST['add_deliveryorder_gen_hash'])){
  die('Invalid Characters used in add_deliveryorder_gen_hash');   }
  else{}
}else{
  die('Enter add_deliveryorder_gen_hash');
}
if(isset($_POST['add_deliveryorder_gen_lpo'])){
  if(!is_string($_POST['add_deliveryorder_gen_lpo'])){
  die('Invalid Characters used in add_deliveryorder_gen_lpo');   }
  else{}
}else{
  die('Enter add_deliveryorder_gen_lpo');
}
#---------------------------------------
if(isset($_POST['add_deliveryorder_gen_payment_t'])){
  if(!is_string($_POST['add_deliveryorder_gen_payment_t'])){
  die('Invalid Characters used in add_deliveryorder_gen_payment_t');   }
  else{}
}else{
  die('Enter add_deliveryorder_gen_payment_t');
}
#---------------------------------------
if(isset($_POST['add_deliveryorder_gen_extra'])){
  if(!is_string($_POST['add_deliveryorder_gen_extra'])){
  die('Invalid Characters used in add_deliveryorder_gen_extra');   }
  else{}
}else{
  die('Enter add_deliveryorder_gen_extra');
}
#---------------------------------------
if(isset($_POST['add_deliveryorder_regards'])){
  if(!is_string($_POST['add_deliveryorder_regards'])){
  die('Invalid Characters used in add_deliveryorder_regards');   }
  else{}
}else{
  die('Enter add_deliveryorder_regards');
}
#---------------------------------------
if(isset($_POST['add_deliveryorder_regards2'])){
  if(!is_string($_POST['add_deliveryorder_regards2'])){
  die('Invalid Characters used in add_deliveryorder_regards2');   }
  else{}
}else{
  die('Enter add_deliveryorder_regards2');
}
#---------------------------------------
if(isset($_POST['add_deliveryorder_address'])){
  if(!is_string($_POST['add_deliveryorder_address'])){
  die('Invalid Characters used in add_deliveryorder_address');   }
  else{}
}else{
  die('Enter add_deliveryorder_address');
}
#---------------------------------------
if(isset($_POST['_wysihtml5_mode'])){
  if(!is_numeric($_POST['_wysihtml5_mode'])){
  die('Invalid Characters used in _wysihtml5_mode');   }
  else{}
}else{
  die('Enter _wysihtml5_mode');
}
#---------------------------------------
if(isset($_POST['add_deliveryorder_gen_footer'])){
  if(!is_string($_POST['add_deliveryorder_gen_footer'])){
  die('Invalid Characters used in add_deliveryorder_gen_footer');   }
  else{}
}else{
  die('Enter add_deliveryorder_gen_footer');
}

$getdeliveryorder = getdatafromsql($conn,"select * from sw_deliveryorders where md5(md5(do_id)) = '".$_POST['add_deliveryorder_gen_hash']."' and do_valid =1");

if(is_array($getdeliveryorder)){
}else{
	die("No deliveryorder Found");
}

$footer = $_POST['add_deliveryorder_gen_footer'];

$insert = "INSERT INTO `sw_deliveryorders_gen`(`dog_rel_do_id`, `dog_extra`, `dog_address`, `dog_lpo`, `dog_payment_terms`,`dog_footer`, `dog_dnt`, `dog_ip`, `dog_rel_lum_id`) VALUES (
'".$getdeliveryorder['do_id']."',
'".$_POST['add_deliveryorder_gen_extra']."',
'".$_POST['add_deliveryorder_address']."',
'".$_POST['add_deliveryorder_gen_lpo']."',
'".$_POST['add_deliveryorder_gen_payment_t']."',
'".$footer."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";


if($conn->query($insert)){
	$pi = $conn->insert_id;
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." user printed delivery order id=".$getdeliveryorder['do_id'],$_SESSION['STWL_LUM_DB_ID'],'sw_deliveryorders_gen','INSERT',$insert,$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
	
	header('Location: sw_del_or_print.php?id='.md5($pi));
}else{
	die("Could Not Generate deliveryorder Print View");
}

}
/*--------------------------------------------------------------------*/
if(isset($_POST['add_purchaseorder_proforma'])){
if(!isset($_SESSION['STWL_LUM_DB_ID'])){
	die("Login");
}
	if(isset($_POST['add_purchaseorder_proforma_hash']) and ctype_alnum($_POST['add_purchaseorder_proforma_hash'])){
	}else{
		die("Invalid Hash");
	}
	$getproforma = getdatafromsql($conn,"select * from sw_proformas where po_valid =1 and md5(po_id) = '".$_POST['add_purchaseorder_proforma_hash']."'");
	
	if(is_array($getproforma)){
	}else{
		die('proforma not found');
	}
	
	$checkprods = getdatafromsql($conn,"SELECT * FROM sw_proformas_items where pi_rel_po_id = ".$getproforma['po_id']." and pi_valid =1");

if (!is_array($checkprods)) {
	die("No Products in proforma");
}
	
	if(isset($_POST['add_purchaseorder_proforma_cur']) and isset($_POST['add_purchaseorder_proforma_cur_rate']) and is_numeric($_POST['add_purchaseorder_proforma_cur_rate']) and ctype_alnum($_POST['add_purchaseorder_proforma_cur'])){
	}else{
		die('Invalid Currecy Details');
	}
	
	$getcur = getdatafromsql($conn,"select * from sw_currency where md5(cur_id) = '".$_POST['add_purchaseorder_proforma_cur']."'");
	
if(is_array($getcur)){
}else{
	die("Currency Not In database");
}

	
	
$getsups = "select distinct(pr_rel_sup_id) as supis  from sw_proformas_items i
left join sw_products_list p on i.pi_rel_pr_id = p.pr_id
where pi_rel_po_id = ".$getproforma['po_id']." and pi_valid =1 and p.pr_valid =1 ";
$getsups = $conn->query($getsups);

if ($getsups->num_rows > 0) {
    // output data of each row
    while($sups = $getsups->fetch_assoc()) {
/*-----------------------------------*/
	$insert = "INSERT INTO `sw_purchaseorders`(`pco_rel_po_id`, `pco_rel_sup_id`, `pco_rel_cur_id`, `pco_cur_rate`, `pco_ref`, `pco_proj_name`, `pco_subj`, `pco_revision`, `pco_revision_id`, `pco_dnt`, `pco_ip`, `pco_rel_lum_id`) VALUES (
	'".$getproforma['po_id']."',
	'".$sups['supis']."',
	'".$getcur['cur_id']."',
	'".$_POST['add_purchaseorder_proforma_cur_rate']."',
	'0',
	'".$getproforma['po_proj_name']."',
	'".$getproforma['po_subj']."',
	'0',
	'0',
	'".time()."',
	'".$_SERVER['REMOTE_ADDR']."',
	'".$_SESSION['STWL_LUM_DB_ID']."'
	)";
	if($conn->query($insert)){
		$proid = $conn->insert_id;
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." user added purchase order id = ".$proid,$_SESSION['STWL_LUM_DB_ID'],'sw_purchaseorders','INSERT',$insert,$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
		
		
	$insert = "UPDATE `sw_purchaseorders` set
	`pco_ref` = 'SWPO".date('dmy',time()).$proid."',
	`pco_revision_id`='".$proid."'
	where `pco_id`= '".$proid."'
	";
	
		if($conn->query($insert)){
		
		}else{
			die("Unexpected Breakpoint at purchaseorder updation");
		}
		

		$getcopyprods = "SELECT * FROM sw_proformas_items 
left join sw_products_list on pi_rel_pr_id = pr_id
where pi_rel_po_id = ".$getproforma['po_id']." and pi_valid =1 and pr_rel_sup_id =".$sups['supis']."";
	$getcopyprods = $conn->query($getcopyprods);
	
	if ($getcopyprods->num_rows > 0) {
		// output data of each row
		while($prod = $getcopyprods->fetch_assoc()) {
			if($conn->query("INSERT INTO `sw_purchaseorders_items`( `pci_rel_pco_id`, `pci_rel_pr_id`, `pci_qty`, `pci_cost`, `pci_desc`) VALUES 
			('".$proid."',
			'".$prod['pi_rel_pr_id']."',
			'".$prod['pi_qty']."',
			'".$prod['pi_cost']."',
			'".$conn->escape_string($prod['pi_desc'])."')")){
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." user added purchase order item id=".$conn->insert_id." for id=".$prod,$_SESSION['STWL_LUM_DB_ID'],'sw_purchaseorders_items','INSERT',"INSERT INTO `sw_purchaseorders_items`( `pci_rel_pco_id`, `pci_rel_pr_id`, `pci_qty`, `pci_cost`, `pci_desc`) VALUES 
			('".$proid."',
			'".$prod['pi_rel_pr_id']."',
			'".$prod['pi_qty']."',
			'".$prod['pi_cost']."',
			'".$conn->escape_string($prod['pi_desc'])."')",$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
				
		
		}else{
			die($conn->error."Unexpected Breakpoint at purchaseorder product insertion");
		}


		}
	} else {
		die("No Products");
	}
		
		
	}else{
		die($conn->error."Could Not Generate purchaseorder from proforma");
	}
/*-----------------------------------*/		

}
} else {
	die("No suppliers found");
}
	
	
	header('Location: sw_purchaseorder.php');
}
if(isset($_POST['add_revision_purchaseorder'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die('Login');
	}
#---------------------------------------
if(isset($_POST['add_revision_purchaseorder_proj_name'])){
  if(!is_string($_POST['add_revision_purchaseorder_proj_name'])){
  die('Invalid Characters used in add_revision_purchaseorder_proj_name');   }
  else{}
}else{
  die('Enter add_revision_purchaseorder_proj_name');
}
#---------------------------------------
if(isset($_POST['add_revision_purchaseorder_subj'])){
  if(!is_string($_POST['add_revision_purchaseorder_subj'])){
  die('Invalid Characters used in add_revision_purchaseorder_subj');   }
  else{}
}else{
  die('Enter add_revision_purchaseorder_subj');
}
#---------------------------------------
if(isset($_POST['pci_nos'])){
  if(!is_numeric($_POST['pci_nos']) or ($_POST['pci_nos'] > 1000)){
  die('Invalid Characters used in pro_nos');   }
  else{}
}else{
  die('Enter pro_nos');
}
#---------------------------------------
if(isset($_POST['add_revision_po_hash'])){
  if(!ctype_alnum($_POST['add_revision_po_hash'])){
  die('Invalid Characters used in add_revision_po_hash');   }
  else{}
}else{
  die('Enter add_revision_po_hash');
}
#---------------------------------------

$getqo = getdatafromsql($conn,"select * from sw_purchaseorders where md5(pco_id) = '".$_POST['add_revision_po_hash']."' and pco_valid =1");
if(!is_array($getqo)){
	die('purchaseorder not found');
}

$getitems = getdatafromsql($conn,"select count(pci_id) as nom from sw_purchaseorders_items where pci_rel_pco_id = ".$getqo['pco_id']." and pci_valid =1");
if(!is_array($getqo)){
	die('Items not found');
}
for($i = 1;$i < ($getitems['nom'] + 1);$i++){
	if(isset($_POST['add_revision_purchaseorder_product_already_'.$i])){
					  if(!ctype_alnum($_POST['add_revision_purchaseorder_product_already_'.$i])){
						  die('Invalid' .'add_revision_purchaseorder_product_already_'.$i);
					  }

						if(is_array(getdatafromsql($conn,"select * from sw_products_list where md5(pr_id)='".$_POST['add_revision_purchaseorder_product_already_'.$i]."' and pr_valid =1 "))){
						}else{
							die('Invalid Product');
						}
					
						#---------------------------------------
						if(isset($_POST['add_revision_purchaseorder_desc_already_'.$i])){
						  if(!is_string($_POST['add_revision_purchaseorder_desc_already_'.$i])){
						  die('Invalid Characters used in add_revision_purchaseorder_desc_already_'.$i);   }
						  else{}
						}else{
						  die('Enter add_revision_purchaseorder_desc_already_'.$i);
						}
						#---------------------------------------
						if(isset($_POST['add_revision_purchaseorder_cost_already_'.$i])){
						  if(!is_numeric($_POST['add_revision_purchaseorder_cost_already_'.$i])){
						  die('Invalid Characters used in add_revision_purchaseorder_cost_already_'.$i);   }
						  else{}
						}else{
						  die('Enter add_revision_purchaseorder_cost_already_'.$i);
						}
						#---------------------------------------
						if(isset($_POST['add_revision_purchaseorder_qty_already_'.$i])){
						  if(!is_numeric($_POST['add_revision_purchaseorder_qty_already_'.$i])){
						  die('Invalid Characters used in add_revision_purchaseorder_qty_already_'.$i);   }
						  else{}
						}else{
						  die('Enter add_revision_purchaseorder_qty_already_'.$i);
						}
	}
}


for($c = 1;$c < ($_POST['pci_nos'] + 1);$c++){
	if($c == 1){
		$numi = '';
	}else{
		$numi = $c;
	}
				#---------------------------------------
				if(isset($_POST['add_revision_purchaseorder_product_a'.$numi])){
				  if(ctype_alnum($_POST['add_revision_purchaseorder_product_a'.$numi]) or ($_POST['add_revision_purchaseorder_product_a'.$numi] === '0') ){
					  
if($_POST['add_revision_purchaseorder_product_a'.$numi] === '0'){
	
}else{
						if(is_array(getdatafromsql($conn,"select * from sw_products_list where md5(pr_id)='".$_POST['add_revision_purchaseorder_product_a'.$numi]."' and pr_valid =1 "))){
						}else{
							die('Invalid Product');


						}
	
}
						
						
				  }else{
					  				  die('Invalid Characters used in add_revision_purchaseorder_product_a'.$numi);   
				  }
				}else{
				  die('Enter add_revision_purchaseorder_product_a'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_revision_purchaseorder_desc_a'.$numi])){
				  if(!is_string($_POST['add_revision_purchaseorder_desc_a'.$numi])){
				  die('Invalid Characters used in add_revision_purchaseorder_desc_a'.$numi);   }
				  else{}
				}else{
				  die('Enter add_revision_purchaseorder_desc_a'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_revision_purchaseorder_cost_a'.$numi])){
				  if(!is_numeric($_POST['add_revision_purchaseorder_cost_a'.$numi])){
				  die('Invalid Characters used in add_revision_purchaseorder_cost_a'.$numi);   }
				  else{}
				}else{
				  die('Enter add_revision_purchaseorder_cost_a'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_revision_purchaseorder_qty_a'.$numi])){
				  if(!is_numeric($_POST['add_revision_purchaseorder_qty_a'.$numi])){
				  die('Invalid Characters used in add_revision_purchaseorder_qty_a'.$numi);   }
				  else{}
				}else{
				  die('Enter add_revision_purchaseorder_qty_a'.$numi);
				}
				
}
$insertpurchaseorder = "
INSERT INTO `sw_purchaseorders`(`pco_rel_po_id`,`pco_rel_sup_id`, `pco_ref`, `pco_proj_name`, `pco_subj`, `pco_revision`, `pco_revision_id`, `pco_dnt`, `pco_ip`, `pco_rel_lum_id`) VALUES (
'".$getqo['pco_rel_po_id']."',
'".$getqo['pco_rel_sup_id']."',
'".$getqo['pco_ref'].'/'.(($getqo['pco_revision'] + 1))."',
'".$_POST['add_revision_purchaseorder_proj_name']."',
'".$_POST['add_revision_purchaseorder_subj']."',
'".($getqo['pco_revision'] + 1)."',
'".$getqo['pco_revision_id']."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";
if($conn->query($insertpurchaseorder)){
	$purchaseorderid = $conn->insert_id;
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." user added purchase order id=".$purchaseorderid,$_SESSION['STWL_LUM_DB_ID'],'sw_purchaseorders','INSERT',$insertpurchaseorder,$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
	
for($i = 1;$i < ($getitems['nom'] + 1);$i++){
	if(isset($_POST['add_revision_purchaseorder_product_already_'.$i])){
						$pr = getdatafromsql($conn,"select * from sw_products_list where md5(pr_id) = '".$_POST['add_revision_purchaseorder_product_already_'.$i]."'");
						if(!is_array($pr)){
							die("A big error has occured in product after purchaseorder insert");
						}
$insertqitem = "INSERT INTO `sw_purchaseorders_items`(`pci_rel_pco_id`, `pci_rel_pr_id`, `pci_qty`, `pci_cost`, `pci_desc`) VALUES 
(
'".$purchaseorderid."',
'".$pr['pr_id']."',
'".$_POST['add_revision_purchaseorder_qty_already_'.$i]."',
'".$_POST['add_revision_purchaseorder_cost_already_'.$i]."',
'".$_POST['add_revision_purchaseorder_desc_already_'.$i]."'
)";

if($conn->query($insertqitem)){

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." user added puchase order item id=".$conn->insert_id.'for purchase order id='.$purchaseorderid,$_SESSION['STWL_LUM_DB_ID'],'sw_purchaseorders_items','INSERT',$insertqitem,$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

}else{
	die("Item Insertion Failed");
}
	}
}

for($c = 1;$c < ($_POST['pci_nos'] + 1);$c++){
	if($_POST['add_revision_purchaseorder_product_a'.$numi] !== '0'){
	if($c == 1){
		$numi = '';
	}else{
		$numi = $c;
	}
$pra = getdatafromsql($conn,"select * from sw_products_list where md5(pr_id) = '".$_POST['add_revision_purchaseorder_product_a'.$numi]."'");
if(!is_array($pra)){
die("A big error has occured in product-2  after purchaseorder insert");
}
$insertq2item = "INSERT INTO `sw_purchaseorders_items`(`pci_rel_pco_id`, `pci_rel_pr_id`, `pci_qty`, `pci_cost`, `pci_desc`) VALUES 
(
'".$purchaseorderid."',
'".$pra['pr_id']."',
'".$_POST['add_revision_purchaseorder_qty_a'.$numi]."',
'".$_POST['add_revision_purchaseorder_cost_a'.$numi]."',
'".$_POST['add_revision_purchaseorder_desc_a'.$numi]."'
)";


if($conn->query($insertq2item)){
}else{
	die("Item-2 Insertion Failed");
}
				
				
	}
				
}


	
}else{
	die($conn->error.'Could not insert purchaseorder');
}

	header('Location: sw_purchaseorder.php');

}
if(isset($_POST['add_purchaseorder_gen'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die('Login');	
	}
#---------------------------------------
if(isset($_POST['add_purchaseorder_gen_hash'])){
  if(!ctype_alnum($_POST['add_purchaseorder_gen_hash'])){
  die('Invalid Characters used in add_purchaseorder_gen_hash');   }
  else{}
}else{
  die('Enter add_purchaseorder_gen_hash');
}
#---------------------------------------
if(isset($_POST['add_purchaseorder_gen_discount'])){
  if(!is_numeric($_POST['add_purchaseorder_gen_discount']) or ($_POST['add_purchaseorder_gen_discount'] > 100) or ($_POST['add_purchaseorder_gen_discount'] < 0)){
  die('Invalid Characters used in add_purchaseorder_gen_discount');   }
  else{}
}else{
  die('Enter add_purchaseorder_gen_discount');
}
#---------------------------------------
if(isset($_POST['add_purchaseorder_gen_vat'])){
  if(!is_numeric($_POST['add_purchaseorder_gen_vat'])){
  die('Invalid Characters used in add_purchaseorder_gen_vat');   }
  else{}
}else{
  die('Enter add_purchaseorder_gen_vat');
}
#---------------------------------------
if(isset($_POST['add_purchaseorder_extra_price'])){
  if(!is_numeric($_POST['add_purchaseorder_extra_price'])){
  die('Invalid Characters used in add_purchaseorder_extra_price');   }
  else{}
}else{
  die('Enter add_purchaseorder_extra_price');
}
#---------------------------------------
if(isset($_POST['add_purchaseorder_gen_lpo'])){
  if(!is_string($_POST['add_purchaseorder_gen_lpo'])){
  die('Invalid Characters used in add_purchaseorder_gen_lpo');   }
  else{}
}else{
  die('Enter add_purchaseorder_gen_lpo');
}
#---------------------------------------
if(isset($_POST['add_purchaseorder_gen_payment_t'])){
  if(!is_string($_POST['add_purchaseorder_gen_payment_t'])){
  die('Invalid Characters used in add_purchaseorder_gen_payment_t');   }
  else{}
}else{
  die('Enter add_purchaseorder_gen_payment_t');
}
#---------------------------------------
if(isset($_POST['add_purchaseorder_gen_extra'])){
  if(!is_string($_POST['add_purchaseorder_gen_extra'])){
  die('Invalid Characters used in add_purchaseorder_gen_extra');   }
  else{}
}else{
  die('Enter add_purchaseorder_gen_extra');
}
#---------------------------------------
if(isset($_POST['add_purchaseorder_regards'])){
  if(!is_string($_POST['add_purchaseorder_regards'])){
  die('Invalid Characters used in add_purchaseorder_regards');   }
  else{}
}else{
  die('Enter add_purchaseorder_regards');
}
#---------------------------------------
if(isset($_POST['add_purchaseorder_regards2'])){
  if(!is_string($_POST['add_purchaseorder_regards2'])){
  die('Invalid Characters used in add_purchaseorder_regards2');   }
  else{}
}else{
  die('Enter add_purchaseorder_regards2');
}
#---------------------------------------
if(isset($_POST['add_purchaseorder_address'])){
  if(!is_string($_POST['add_purchaseorder_address'])){
  die('Invalid Characters used in add_purchaseorder_address');   }
  else{}
}else{
  die('Enter add_purchaseorder_address');
}
#---------------------------------------
if(isset($_POST['_wysihtml5_mode'])){
  if(!is_numeric($_POST['_wysihtml5_mode'])){
  die('Invalid Characters used in _wysihtml5_mode');   }
  else{}
}else{
  die('Enter _wysihtml5_mode');
}
#---------------------------------------
if(isset($_POST['add_purchaseorder_gen_footer'])){
  if(!is_string($_POST['add_purchaseorder_gen_footer'])){
  die('Invalid Characters used in add_purchaseorder_gen_footer');   }
  else{}
}else{
  die('Enter add_purchaseorder_gen_footer');
}
#---------------------------------------
if(isset($_POST['before_head_pci_nos'])){
  if(!is_numeric($_POST['before_head_pci_nos'])){
  die('Invalid Characters used in before_head_pci_nos');   }
  else{}
}else{
  die('Enter before_head_pci_nos');
}
#---------------------------------------
if(isset($_POST['after_head_pci_nos'])){
  if(!is_numeric($_POST['after_head_pci_nos'])){
  die('Invalid Characters used in after_head_pci_nos');   }
  else{}
}else{
  die('Enter after_head_pci_nos');
}
$getpurchaseorder = getdatafromsql($conn,"select * from sw_purchaseorders where md5(md5(pco_id)) = '".$_POST['add_purchaseorder_gen_hash']."' and pco_valid =1");

if(is_array($getpurchaseorder)){
}else{
	die("No purchaseorder Found");
}

for($c=1;$c < ($_POST['before_head_pci_nos'] + 1) ;$c++){
	
if($c == 1){
	$numi = '';
}else{
	$numi = $c ;
}

		#---------------------------------------
		if(isset($_POST['add_purchaseorder_gen_bf_head'.$numi])){
		  if(!is_string($_POST['add_purchaseorder_gen_bf_head'.$numi])){
		  die('Invalid Characters used in add_purchaseorder_gen_bf_head'.$numi);   }
		  else{}
		}else{
		  die('Enter add_purchaseorder_gen_bf_head'.$numi);
		}
		#---------------------------------------
		if(isset($_POST['add_purchaseorder_gen_bf_head_val'.$numi])){
		  if(!is_string($_POST['add_purchaseorder_gen_bf_head_val'.$numi])){
		  die('Invalid Characters used in add_purchaseorder_gen_bf_head_val'.$numi);   }
		  else{}
		}else{
		  die('Enter add_purchaseorder_gen_bf_head_val'.$numi);
		}
		#---------------------------------------
}
/*------------------------*/
for($a=1; $a < ($_POST['after_head_pci_nos'] + 1) ;$a++){
	
if($a == 1){
	$numi = '';
}else{
	$numi = $a ;
}

		#---------------------------------------
		if(isset($_POST['add_purchaseorder_gen_af_head'.$numi])){
		  if(!is_string($_POST['add_purchaseorder_gen_af_head'.$numi])){
		  die('Invalid Characters used in add_purchaseorder_gen_af_head'.$numi);   }
		  else{}
		}else{
		  die('Enter add_purchaseorder_gen_af_head'.$numi);
		}
		#---------------------------------------
		if(isset($_POST['add_purchaseorder_gen_af_head_val'.$numi])){
		  if(!is_string($_POST['add_purchaseorder_gen_af_head_val'.$numi])){
		  die('Invalid Characters used in add_purchaseorder_gen_af_head_val'.$numi);   }
		  else{}
		}else{
		  die('Enter add_purchaseorder_gen_af_head_val'.$numi);
		}
		#---------------------------------------
}

$beforetval = array();
$aftertval = array();



for($c=1;$c < ($_POST['before_head_pci_nos'] + 1) ;$c++){
	
if($c == 1){
	$numi = '';
}else{
	$numi = $c ;
}

$beforetval[] = $_POST['add_purchaseorder_gen_bf_head'.$numi].'|=|=|=|=|=|'.$_POST['add_purchaseorder_gen_bf_head_val'.$numi];

}
/*------------------------*/
for($a=1; $a < ($_POST['after_head_pci_nos'] + 1) ;$a++){
	
if($a == 1){
	$numi = '';
}else{
	$numi = $a ;
}
$aftertval[] = $_POST['add_purchaseorder_gen_af_head'.$numi].'|=|=|=|=|=|'.$_POST['add_purchaseorder_gen_af_head_val'.$numi];
#---------------------------------------
}

$after = implode('||||||||||.||||||||||',$aftertval);
$before = implode('||||||||||.||||||||||',$beforetval);
$_POST['add_purchaseorder_gen']=='';
$footer = $_POST['add_purchaseorder_gen_footer'].'

<div class="row">
	<div class="col-xs-6">
	<p class="pull-left">
	'.$_POST['add_purchaseorder_regards'].'
	</p>
	</div>
	<div class="col-xs-6">
	<p class="pull-right">
		'.$_POST['add_purchaseorder_regards2'].'
	</p>
	</div>
</div>



';

$insert = "INSERT INTO `sw_purchaseorders_gen`(`pcog_rel_pco_id`, `pcog_discount`, `pcog_vat`, `pcog_extra`, `pcog_address`, `pcog_lpo`, `pcog_payment_terms`, `pcog_before_total`, `pcog_after_total`,`pcog_extra_price` ,`pcog_footer`, `pcog_dnt`, `pcog_ip`, `pcog_rel_lum_id`) VALUES (
'".$getpurchaseorder['pco_id']."',
'".$_POST['add_purchaseorder_gen_discount']."',
'".$_POST['add_purchaseorder_gen_vat']."',
'".$_POST['add_purchaseorder_gen_extra']."',
'".$_POST['add_purchaseorder_address']."',
'".$_POST['add_purchaseorder_gen_lpo']."',
'".$_POST['add_purchaseorder_gen_payment_t']."',
'".$before."',
'".$after."',
'".$_POST['add_purchaseorder_extra_price']."',
'".$footer."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";


if($conn->query($insert)){
	$pi = $conn->insert_id;
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." user printed purchase order ".$getpurchaseorder['pco_id'],$_SESSION['STWL_LUM_DB_ID'],'sw_purchaseorders_gen','INSERT',$insert,$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

	header('Location: sw_purchaseorder_print.php?id='.md5($pi));
}else{
	die("Could Not Generate purchaseorder Print View");
}

}
/*----------------------------------------------------------------------------------------------------*/
if(isset($_POST['update_purchaseorder'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die("Login to continue");
	}
	#---------------------------------------
if(isset($_POST['update_purchaseorder_qty'])){
  if(!is_numeric($_POST['update_purchaseorder_qty'])){
  die('Invalid Characters used in update_purchaseorder_qty');   }
  else{}
}else{
  die('Enter update_purchaseorder_qty');
}
#---------------------------------------
if(isset($_POST['update_purchaseorder_pci_hash'])){
  if(!ctype_alnum($_POST['update_purchaseorder_pci_hash'])){
  die('Invalid Characters used in update_purchaseorder_pci_hash');   }
  else{}
}else{
  die('Enter update_purchaseorder_pci_hash');
}

$getpurchaseorderitem = getdatafromsql($conn,"select * from sw_purchaseorders_items where md5(pci_id) ='".$_POST['update_purchaseorder_pci_hash']."'");
if(!is_array($getpurchaseorderitem)){
	die("Product item not found");
}


$insert = "INSERT INTO `sw_purchaseorder_updation`( `pcu_rel_pco_id`, `pcu_rel_pci_id`, `pcu_qty`, `pcu_dnt`, `pcu_ip`) VALUES (
'".$getpurchaseorderitem['pci_rel_pco_id']."',
'".$getpurchaseorderitem['pci_id']."',
'".$_POST['update_purchaseorder_qty']."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."'
)";


if($conn->query($insert)){
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." user updated purchase order qty for purcahse id ".$getpurchaseorderitem['pci_rel_pco_id']." and purchase item ".$getpurchaseorderitem['pci_id']." to ".$_POST['update_purchaseorder_qty'],$_SESSION['STWL_LUM_DB_ID'],'sw_purchaseorder_updation','INSERT',$insert,$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

	header("Location: sw_purchaseorder_update.php");
}else{
	die("Could not insert");
}

}
if(isset($_POST['add_costing'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die("Login to continue");
	}
	#---------------------------------------
if(isset($_POST['costing_head'])){
  if(!is_string($_POST['costing_head'])){
  die('Invalid Characters used in costing_head');   }
  else{}
}else{
  die('Enter costing_head');
}
#---------------------------------------
if(isset($_POST['costing_value'])){
  if(!is_numeric($_POST['costing_value'])){
  die('Invalid Characters used in costing_value');   }
  else{}
}else{
  die('Enter costing_value');
}
#---------------------------------------
if(isset($_POST['costing_hash'])){
  if(!ctype_alnum($_POST['costing_hash'])){
  die('Invalid Characters used in costing_hash');   }
  else{}
}else{
  die('Enter costing_hash');
}

$getpro = getdatafromsql($conn,"select * from sw_proformas where md5(po_id) ='".$_POST['costing_hash']."' and po_valid =1");
if(!is_array($getpro)){
	die("Proforma not found");
}


$insert = "INSERT INTO `sw_costing`( `cost_rel_po_id`, `cost_name`, `cost_val`, `cost_dnt`, `cost_ip`) VALUES (
'".$getpro['po_id']."',
'".$_POST['costing_head']."',
'".$_POST['costing_value']."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."'
)";


if($conn->query($insert)){
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." user added ".$_POST['costing_value']." aed costing to  proforma id".$getpro['po_id'],$_SESSION['STWL_LUM_DB_ID'],'sw_costing','INSERT',$insert,$conn)){
}else{
	die("Only log not generated ");
}
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

	header("Location: sw_costing.php");
}else{
	die("Could not insert cost");
}

}
if(isset($_POST['payment_add'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die("Login to continue");
	}
#---------------------------------------
if(isset($_POST['payment_add_hash'])){
  if(!ctype_alnum($_POST['payment_add_hash'])){
  die('Invalid Characters used in payment_add_hash');   }
  else{}
}else{
  die('Enter payment_add_hash');
}
#---------------------------------------
if(isset($_POST['payment_add_method'])){
  if(!ctype_alnum($_POST['payment_add_method'])){
  die('Invalid Characters used in payment_add_method');   }
  else{}
}else{
  die('Enter payment_add_method');
}
#---------------------------------------
if(isset($_POST['payment_add_c_no'])){
  if(!is_string($_POST['payment_add_c_no'])){
  die('Invalid Characters used in payment_add_c_no');   }
  else{}
}else{
  die('Enter payment_add_c_no');
}
#---------------------------------------
if(isset($_POST['payment_add_date'])){
  if(!is_string($_POST['payment_add_date'])){
  die('Invalid Characters used in payment_add_date');   }
  else{}
}else{
  die('Enter payment_add_date');
}
#---------------------------------------
if(isset($_POST['payment_add_val'])){
  if(!is_numeric($_POST['payment_add_val'])){
  die('Invalid Characters used in payment_add_val');   }
  else{}
}else{
  die('Enter payment_add_val');
}
#---------------------------------------

$getpro = getdatafromsql($conn,"select * from sw_proformas where md5(po_id) ='".$_POST['payment_add_hash']."' and po_valid =1");
if(!is_array($getpro)){
	die("Proforma not found");
}

$getmethod = getdatafromsql($conn,"select * from sw_payments_methods where md5(method_id) ='".$_POST['payment_add_method']."'");
if(!is_array($getmethod)){
	die("Method not found");
}
if($getmethod['method_id'] === '2'){
	$obj_date= '0';
	$_POST['payment_add_c_no'] = '0';
}else{
$obj_date = strtotime($_POST['payment_add_date']);
if($obj_date === false){
	die('Invalid Date');
}
}
$pval = ($_POST['payment_add_val'] * $getpro['po_cur_rate']);
$insert1 = "INSERT INTO `sw_payments`( pt_rel_po_id	, `pt_rel_method_id`, `pt_cheque_number`, `pt_cheque_date`, `pt_val`, `pt_dnt`, `pt_ip`) VALUES (
'".$getpro['po_id']."',
'".$getmethod['method_id']."',
'".$_POST['payment_add_c_no']."',
'".$obj_date."',
'".$pval."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."'
)";

if($conn->query($insert1)){
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." user addded payment of amount: ".$pval." in favour of ".$getpro['po_id']." proforma",$_SESSION['STWL_LUM_DB_ID'],'sw_payments','INSERT',$insert1,$conn)){
}else{
	die("Only log not generated ");
}
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

	header("Location: sw_payments.php");
}else{
	die($conn->error."Could not insert Payment");
}

}
?>








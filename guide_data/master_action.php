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
		if((strpos($_SERVER['HTTP_REFERER'],'http://ahmadanonymous.ddns.net') == '0') or (strpos($_SERVER['HTTP_HOST'],'http://localhost/') == '0') or (strpos($_SERVER['HTTP_REFERER'],'http://192.168.1.') == '0'))
	{
	  //only process operation here
	}else{
		die('Only tld process are allowed');
	}
	}

}else{
	
	die(header('Location: master-action.php'));
	
}

if(isset($_POST['from_email']) and isset($_POST['from_name']) and isset($_POST['subj_ml']) and isset($_POST['message_ml'])){
	
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
INSERT INTO `sb_logins`(`lum_rel_tu_id`,`lum_email`, `lum_username`, `lum_password`, `lum_hash_mix`) VALUES (
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
#
if(isset($_POST['lo_eml']) and isset($_POST['lo_pass']) and isset($_POST['lo_school']) and isset($_POST['lo_type'])){
	
	$eml=$_POST['lo_eml'];
	$pas=md5(md5(sha1($_POST['lo_pass'])));
	$hash = gen_hash($pas,$eml);
	$usr_ty = $_POST['lo_type'];
	$school_id = $_POST['lo_school'];
	
	if(ctype_alnum($eml) or is_numeric($eml) or is_email($eml)){
	}else{
		die("Invalid Email");
	}
	 
	
	if(ctype_alnum($hash.$pas)){
	}else{
		die("Credentials Not valid");
	}
	
	if(!is_numeric($_POST['lo_school'])){
		die("Invalid School");
	}
	
	if(!is_numeric($_POST['lo_type'])){
		die("Invalid lo_type");
	}
	
	
$selectusersfromdbsql = "SELECT * FROM sb_logins where 
lum_rel_tu_id = ".$usr_ty." and
lum_rel_sch_id = ".$school_id." and
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

if($usr_ty == 1){#admin
			$selectusersdatafromdbsql = "
SELECT * FROM sb_users where 
usr_rel_lum_id = '".$usrrw['lum_id']."'";

}else if($usr_ty == 2){#teacher
			$selectusersdatafromdbsql = "
SELECT * FROM sb_teachers where 
th_rel_lum_id = '".$usrrw['lum_id']."'";

}else if($usr_ty == 3){#parent
			$selectusersdatafromdbsql = "
SELECT * FROM students_parents_info_rc where 
st_rel_lum_id = '".$usrrw['lum_id']."'";

}else if($usr_ty == 4){#others
			$selectusersdatafromdbsql = "
SELECT * FROM sb_users where 
usr_rel_lum_id = '".$usrrw['lum_id']."'";

}else{
	die('No user Mapping for user type found');
}


$dataobbres = $conn->query($selectusersdatafromdbsql);

if ($dataobbres->num_rows == 1) {
    // output data of each row
    while($dataobbrw = $dataobbres->fetch_assoc()) {
		###
        session_regenerate_id();
		
		$_SESSION['SCHVB_SESS_ID'] = md5(sha1(md5(md5(sha1('SecretBall')).uniqid().time()).time()).uniqid());
		$_SESSION['SCHVB_USR_DB_ID'] = $usrrw['lum_id'];
		$_SESSION['SCHVB_USR_TU_ID'] = $usrrw['lum_rel_tu_id'];
		$_SESSION['SCHVB_USR_SCH_ID'] = $usrrw['lum_rel_sch_id'];
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
#

	
	/**//**//**//**/ 
	#$serverdir = 'http://localhost/muncircuit/';
	$serverdir = 'http://schoolvault.ddns.net/';
if(isset($_POST['ch_img'])){
	 if(isset($_SESSION['SCHVB_USR_DB_ID'])){
		 
		 if(isset($_SESSION['SCHVB_SESS_ID'])){
$login=1;
$getdatus = array();
$getdatus = make_user_ar($conn,$_SESSION['SCHVB_USR_DB_ID'],$login);
	

}else{
	die('Login To Continue');
}

		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}
	 if(isset($_FILES['ch_imgg'])){
		 if(count($_FILES) == 1){
		 }else{
		 	die('Invalid Count');
		 }
		 ##
		 $target_dir = "img/prof_pics/";
$target_file = $target_dir .md5(time().uniqid().microtime()).'_'.
'P_'.sha1(time().uniqid()).uniqid().time(). basename($_FILES["ch_imgg"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["ch_img"])) {
    $check = getimagesize($_FILES["ch_imgg"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["ch_imgg"]["size"] > 3000000) {
	 
    die("Sorry, your file is too large only 3mb Allowed.");
    $uploadOk = 0;
}
// Allow certain file formats
if(strtolower($imageFileType) != "jpg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpeg"
&& strtolower($imageFileType) != "gif" ) {
die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    die( "<br>Sorry, your file was not uploaded.");
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["ch_imgg"]["tmp_name"], $target_file)) {
        
		
switch($_SESSION['SCHVB_USR_TU_ID']){
	case 1:
$sql = "UPDATE `sb_users` SET `usr_prof_pic`= '".$target_file."' 
WHERE usr_id=".$getdatus['usr_id'];
	break;
	case 2:
$sql = "UPDATE `sb_teachers` SET `th_prof_pic`= '".$target_file."' 
WHERE th_id=".$getdatus['th_id'];
	break;
	case 3:
$sql = "UPDATE `students_parents_info_rc` SET `st_prof_pic`= '".$target_file."' 
WHERE st_db_id=".$getdatus['st_db_id'];
	break;
	case 4:
$sql = "UPDATE `sb_users` SET `usr_prof_pic`= '".$target_file."' 
WHERE usr_id=".$getdatus['usr_id'];
	break;
	default:
	die('Couldn\'t find user type');
	
}

if ($conn->query($sql) === TRUE) {
			##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['SCHVB_USR_DB_ID'],'sb_users','update',$sql ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBdTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###



    header('Location: myca.php');
} else {
    die("ErrorMAA909") ;
}


		
		
    } else {
        die( "<br>Sorry, there was an error uploading your file.");
    }
}
		 ##
	 }
 }
#
if(isset($_POST['chng_latlng'])){
	 if(isset($_SESSION['SCHVB_USR_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sb_logins ml left join sb_users mu on ml.lum_id = mu.usr_rel_lum_id where ml.lum_id = ".$_SESSION['SCHVB_USR_DB_ID']." and ml.lum_valid = 1 and mu.usr_valid = 1");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}
	
	if(isset($_POST['usr_lat_new'])){
	}else{
		die("ERRRMAS54");
	}
	if(isset($_POST['usr_long_new'])){
	}else{
		die("ERRRMAS53");
	}
	
	$nlat = $_POST['usr_lat_new'];
	$nlng = $_POST['usr_long_new'];
	###
	$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($nlat).','.trim($nlng);
$json = file_get_contents($url);
$data= json_decode($json);
echo $data->results[0]->formatted_address;
	###
	die("$url");
	$sql = "UPDATE `sb_users` SET `usr_lat`= '".$nlat."', `usr_lat`='".$nlng."' 
WHERE usr_id=".$_SESSION['SCHVB_USR_DB_ID'];

if ($conn->query($sql) === TRUE) {
			##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['SCHVB_USR_DB_ID'],'sb_users','update', $sql ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TG$WESDF');
		}
##### Insert Logs ##################################################################VV3###




    header('Location: myca.php');
} else {
    die("ErrorMAA909") ;
}
	
}
#
#
if(isset($_POST['accept_like'])){
	if(ctype_alnum(trim($_POST['accept_like']))){
		if(!isset($_SESSION['SCHVB_USR_DB_ID'])){
			die('Login to Proceed');
		}
		$fakecheck = getdatafromsql($conn,"
		select * from tut_students where md5(sha1(md5(
		concat('aWdsfewrsdf2WS234ewfcd',st_id)))) = '".trim($_POST['accept_like'])."' and st_valid = 1 and st_rel_lum_id = ".$_SESSION['SCHVB_USR_DB_ID']."");
		
		
		
	
	if(!is_array($fakecheck)){
		die('Invlaid Student');
	}
	if(isset($_SESSION['SCHVB_SESS_ID'])){
		$usr_id = trim($_SESSION['SCHVB_USR_DB_ID']);
	}else{
		die('You Must be Logged in to add this mun');
	}
	

	
	$inssql = "UPDATE tut_students SET st_valid = 0  where st_id = ".$fakecheck['st_id']."";
	
	
	if($conn->query($inssql)){
		
			$inssql2 = "UPDATE tut_class_rec SET cl_valid = 0  where cl_rel_st_id = ".$fakecheck['st_id']."";
		if($conn->query($inssql2)){

			$inssql3 = "UPDATE tut_student_payment SET adv_valid = 0  where adv_rel_st_id = ".$fakecheck['st_id']."";
		if($conn->query($inssql3)){

				##### Insert Logs ##################################################################VV3###
		if(preplogs($fakecheck,$_SESSION['SCHVB_USR_DB_ID'],'tut_students','update', $inssql ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die("EsdzfwesRRP");
		}
		}else{
			die("ERRP");
		}
		
		
##### Insert Logs ##################################################################VV3###
}else{
			die('ERRweafINCMA%TGTBTR$WESDF');
		}



		header('Location: home.php');
		
		
	}else{
		die("###ERRMA3344");
	}
	
	
	}
}
#
#
#
#
if(isset($_POST['ch_det'])){
		 if(isset($_SESSION['SCHVB_USR_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sb_logins where lum_id = ".$_SESSION['SCHVB_USR_DB_ID']." and lum_valid = 1");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}


	if(!isset($_POST['ch_usr_name'])){
		die('Enter all fields');
	}
	
	$newusrnm = $_POST['ch_usr_name'];
	if(3 == 3){
		
$upsql = "update `sb_users` set `usr_name` = '".$newusrnm."' where usr_rel_lum_id = ".$_SESSION['SCHVB_USR_DB_ID'];

if($conn->query($upsql)){
			##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['SCHVB_USR_DB_ID'],'sb_users','update', $upsql ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




	header('Location: myca.php');
}else{
	die('#ERRPMAIjisjA1');
}
	}else{
		die('#ERRRMA99j4');
	}
	
}
#
#
if(isset($_POST['ch_pw'])){
			 if(isset($_SESSION['SCHVB_USR_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sb_logins where lum_id = ".$_SESSION['SCHVB_USR_DB_ID']." and lum_valid = 1");
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
		$lum = getdatafromsql($conn,'select * from sb_logins where lum_id = '.$_SESSION['SCHVB_USR_DB_ID']);
		if(is_string($lum)){
			die('#ERRRMA39UET05G8T');
		}
		$pw = md5(md5(sha1($_POST['pw'])));
		$hash = gen_hash($pw,trim($lum['lum_email']));
		
		
		if($pw== $lum['lum_password']){
			die('The new password cant be same as the old one!');
		}else{
			$upsql = "UPDATE `sb_logins` SET `lum_password`='".trim($pw)."',`lum_hash_mix`='".trim($hash)."' WHERE lum_id = ".$_SESSION['SCHVB_USR_DB_ID'];
			if($conn->query($upsql)){
						##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['SCHVB_USR_DB_ID'],'sb_logins','update', $upsql ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
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
#
#
if(isset($_POST['claim_mun'])){
	
		
			if(isset($_SESSION['SCHVB_USR_DB_ID'])){
	if(trim(ctype_alnum($_POST['claim_mun']))){
		$muner = getdatafromsql($conn,"select * from mun_rec where md5(sha1(md5(sha1(concat(mun_id,'creation983ygh8t4eg8t9hg9u4eh5thr9g48etjg894je8tdjg489ejtg894je589thj84h5teh'))))) = '".$_POST['claim_mun']."'");
		if(is_array($muner)){
	
	
	$checkdupes = getdatafromsql($conn,"SELECT * FROM `mun_claim_requests` WHERE `cl_rel_lum_id` = ".$_SESSION['SCHVB_USR_DB_ID']." and `cl_rel_mun_id`= ".$muner['mun_id']." and cl_valid = 1 order by cl_gen_time DESC");
	if(is_array($checkdupes)){
		if(($checkdupes['cl_gen_time'] + 86400) > time()){
			die('You have already requested to claim this mun.<br>
Come back After 24hrs');
		}
	}else{
	}
	
	
	
				$acc_usr_id = $_SESSION['SCHVB_USR_DB_ID'];
				$acc_mun_id = $muner['mun_id'];
				
		
				if($conn->query("INSERT INTO `mun_claim_requests`(`cl_rel_lum_id`, `cl_rel_mun_id`, `cl_mail_sent`, `cl_valid`) VALUES (
				'".$acc_usr_id."',
				'".$acc_mun_id."',
				'0',
				'0'
				
				)")){
					$donit = $conn->insert_id;
					$dading = getdatafromsql($conn,"select * from mun_claim_requests where cl_id = '".$donit."'");
					if(is_string($dading)){
						die('ERRMASJ3IOGJRTO3');
					}
					if($dading['cl_rel_lum_id'] == $_SESSION['SCHVB_USR_DB_ID']){
					}else{
						die('ERRMAIU3HG94UGHJRV94YUERG <br>
Go Back');
					}
				}else{
					die('ERRMA398UWR9835HERGU');
				}
		
				
	##
	$message = "
<html>
<head>
<title>Claim ".$muner['mun_shortname']." at MUNCIRCUIT</title>
</head>
<body>
<p>To ".ucwords($muner['mun_hostedat']).",<br>
If you have requested to Claim ".strtoupper($muner['mun_shortname'])."".$muner['mun_year']." at MUN Circuit, Click this link 
<a href='".$serverdir."munc/master_action.php?claimmun_from_id=".md5(md5(sha1(sha1(md5($dading['cl_id'].'jufjei90gtuj 3tg3gtgit hygt gut3 egt90ug09u3g 9u3ug90j4tej')))))."&cl_df=jugv9j0i3e09jni99824U98J'><i style='color:blue;'><u>".$serverdir."munc/master_action.php?claimmun_from_id=".md5(md5(sha1(sha1(md5($dading['cl_id'].'jufjei90gtuj 3tg3gtgit hygt gut3 egt90ug09u3g 9u3ug90j4tej')))))."&cl_df=jugv9j0i3e09jni99824U98J</u></i></a>

<hr>
or else you can ignore this message
<hr>
This link is only valid for 24hrs.<br>
 
Please do not reply to this email.</p>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <do-not-reply@munc.com>' . "\r\n";
$headers .= 'Bcc: com.aa.ay@gmail.com' . "\r\n";

if(mail($muner['mun_email'],'Claiming '." ".' '.strtoupper($muner['mun_shortname'])."".$muner['mun_year'].' at MUN circuit ',$message,$headers)){
	
	if($conn->query("UPDATE `mun_claim_requests` SET `cl_mail_sent`=1,`cl_valid`=1,`cl_gen_time` = ".time()." , cl_ip = '".$_SERVER['REMOTE_ADDR']."' WHERE `cl_id` = '".$donit."'")){
	header('Location: amun.php?mun='.md5(sha1($muner['mun_id'].'HGYURBVFRBRGWIOGRU92UWHFGOIWHTOGIUEO8HG384IWGOIRHWGIUHREJFGKN')));
	}else{
		die("EERRMAjhenrviui3ijg");
	}
	
}else{
	echo 'Mail not sent';
}

	
	##					
		}else{
			die('Hash Not Valid');
		}
	}else{
		die('Hash Invalid');
	}



				}else{	die('You must be Logged in to Claim an MUN');		}
}


/* #### make new table for the editable session and give temprorary id for the editing to happen andthen give an option to edit the content and then hit save to edit it aftewards make an admin panel pending tab# to appprove the changes ###

*/

if(isset($_POST['rep_mun'])){
	if(isset($_POST['rep_usr_nm']) and isset($_POST['rep_usr_eml']) and isset($_POST['rep_prob_dob'])){
	}else{
		die('Enter all fields');
	}
	
	if(!is_email($_POST['rep_usr_eml'])){
		die('Email is not Valid');
	}
	if(trim(ctype_alnum($_POST['rep_mun']))){
		$muner = getdatafromsql($conn,"select * from mun_rec where md5(sha1(sha1(sha1(concat(mun_id,'creation983ygh8t4eg8t9hg9u4eh5thr9g48etjg894jtg894je589thj84h5teh'))))) = '".$_POST['rep_mun']."'");
		if(is_array($muner)){
			
			$rptusrnm = $_POST['rep_usr_nm'];
			$rptusreml = $_POST['rep_usr_eml'];
			$rptprob = $_POST['rep_prob_dob'];
			$munif = $muner['mun_id'];
			
			
			$inssq = "INSERT INTO `mun_reports`(`rpt_usr_name`, `rpt_usr_email`, `rpt_usr_problem`, `rpt_usr_rel_mun_id`, `rpt_added_dnt`) VALUES (
'".$rptusrnm."',
'".$rptusreml."',
'".$rptprob."',
'".$munif."',
'".time()."'			)";
			
			if($conn->query($inssq)){
						##### Insert Logs ##################################################################VV3###
		if(preplogs($muner,$_SESSION['SCHVB_USR_DB_ID'],'mun_reports','insert', $inssq,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('Alps');
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




				header('Location: amun.php?mun='.md5(sha1($muner['mun_id'].'HGYURBVFRBRGWIOGRU92UWHFGOIWHTOGIUEO8HG384IWGOIRHWGIUHREJFGKN')));
			}else{
				die("ERRMASIEHGU35HGR");
			}
		}else{
			die('Hash Not Valid');
		}
	}else{
		die('Hash Invalid');
	}
}
##
if(isset($_POST['req_mun'])){
	if(trim(ctype_alnum($_POST['req_mun']))){
		$muner = getdatafromsql($conn,"select * from mun_rec where md5(md5(md5(sha1(concat(mun_id,'creation983ygh8t4eg8t9hg9u4eh5thr9g48etjg894je8tdjg489ejtg894je589th'))))) = '".$_POST['req_mun']."'");
		if(is_array($muner)){
			die('You are now going to be sent to a page which allows you to edit the changes ');
		}else{
			die('Hash Not Valid');
		}
	}else{
		die('Hash Invalid');
	}
}
##
##
if(isset($_POST['re_pw'])){
	if(isset($_POST['rec_eml'])){
		if(is_email($_POST['rec_eml'])){
			$validemail = getdatafromsql($conn,"select * from sb_logins where lum_email = '".trim($_POST['rec_eml'])."'");
			
			if(is_array($validemail)){
				$hasho = gen_hash_pw('oi4jg9v 5g858r hgh587rhg85rhgvu85rht9gi vj98rjg984he98t hj4 9v8r hb9uirhbu');
			  $hasht = gen_hash_pw_2($validemail['lum_id'],'984j5t8gj48 g8 5hg085hr988rt09g409rhj 9borjh09oj58r hj094jh 98obh498toeihg');
			  
			  
			  
				$ins_pwrc = "INSERT INTO `tut_recover`(`rv_rel_lum_id`, `rv_hash`, `rv_valid_till`, `rv_hash_2`) VALUES (
'".$validemail['lum_id']."',
'".$hasho."',
'".(time()+10810)."',				
'".$hasht."'
)";
if($conn->query($ins_pwrc)){
			##### Insert Logs ##################################################################VV3###
		if(preplogs($validemail,"0",'tut_recover','insert', $ins_pwrc,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGweafTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




	###eml
	$to = $validemail['lum_email'];
$subject = "School Vault Password Recovery ";

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
			$user_det = getdatafromsql($conn,"select * from sb_logins where md5(sha1(concat(lum_id,'3oijg9i3u8uh'))) = '".$usrh."' and lum_valid = 1");
			
			if(is_array($user_det)){
				$new_pw=md5(md5(sha1($newp)));
				$new_hash = gen_hash($new_pw,trim($user_det['lum_email']));

	


if($conn->query("update sb_logins set lum_password = '".$new_pw."', lum_hash_mix ='".$new_hash."' where lum_id = ".$user_det['lum_id']."")){




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
#
#
if(isset($_POST['resolves_report_s'])){
	if(isset($_POST['resolves_report_hash']) and ctype_alnum($_POST['resolves_report_hash'])){
	}else{
		die('Combination Invalid');
	}
	
	if(isset($_POST['report_resolved_text'])){
		
	}else{
		die('Invalid Combination');
	}
	
	$resolv = getdatafromsql($conn,"select * from mun_reports  WHERE md5(sha1(md5(md5(concat(rpt_id,'inyc54u569tyi47ct74wv74g57t y74e5yt734y5t98vr7nti5veni7i ytv5r y8'))))) = '".$_POST['resolves_report_hash']."' and rpt_resolved = 0 and rpt_valid =1");
	
	if(is_string($resolv)){
		die('Invalid Report');
	}else{
		$resolving_mun = getdatafromsql($conn,"select * from mun_rec where mun_id = ".$resolv['rpt_usr_rel_mun_id']." and mun_valid =1 ");
		$resolving_email = $resolv['rpt_usr_email'];
		$resolving_name = $resolv['rpt_usr_name'];
		$resolving_text = $_POST['report_resolved_text'];
		
		if(is_string($resolving_mun)){
			die('No MUN Found');	
		}
		
		#
		$message = "
<html>
<head>
<title>Complaint Resolved</title>
</head>
<body>
<p>Dear ".ucwords($resolving_name).",<br>
This email is to inform you about the status of your report against ".$resolving_mun['mun_shortname'].".
<br><br>

".$resolving_text."<br>
<br>

Please do not reply to this email.</p>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <anonymous.code.anonymous@gmail.com>' . "\r\n";
$headers .= 'Cc: com.aa.ay@gmail.com' . "\r\n";

if(mail($resolving_email,'MUN Report Status from MUN Circuit',$message,$headers)){
	
	if($conn->query("UPDATE `mun_reports` SET `rpt_resolved`= 1,`rpt_res_dnt`='".time()."' WHERE rpt_id = ".$resolv['rpt_id']." and rpt_valid =1 and rpt_resolved = 0")){
		
			
	
	
				##### Insert Logs ##################################################################VV3###
		if(preplogs($resolv,$_SESSION['SCHVB_USR_DB_ID'],'mun_reports','update', "UPDATE `mun_reports` SET `rpt_resolved`= 1,`rpt_res_dnt`='".time()."' WHERE rpt_id = ".$resolv['rpt_id']." and rpt_valid =1 and rpt_resolved = 0" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




	echo 'An email was sent to him <a href="reports.php"><button>Go Back</button></a> ';
	}
	
}else{
	echo 'Mail not sent';
}
		#
	}
}
##
##
if(isset($_POST['resolved_contact_t'])){
	if(isset($_POST['resolved_contact_hash']) and ctype_alnum(trim($_POST['resolved_contact_hash']))){
	}else{
		die('Hash Invalid');
	}
	
	if(isset($_POST['resolved_contact_text'])){
	}else{
		die('Fill out all fields');
	}
	
	$resolv = getdatafromsql($conn,"select * from mun_mails  WHERE 
	md5(sha1(md5(md5(concat(ml_id,'inyc54u569tyi47ct74wv74g57t y74e5yt734y5t98vr7nti5veni7i'))))) 
	= '".$_POST['resolved_contact_hash']."' and ml_read = 0 and ml_valid=1");
	
	if(is_string($resolv)){
		die('Invalid Enquiry');
	}else{
		$resolving_email = $resolv['ml_from_email'];
		$resolving_subject = $resolv['ml_subject'];
		$resolving_name = $resolv['ml_from_name'];
		$resolving_text = $_POST['resolved_contact_text'];
		
		
		
		#
		$message = "
<html>
<head>
<title>Re: ".$resolving_subject."</title>
</head>
<body>
<p>Dear ".ucwords($resolving_name).",<br>
This email is a reply of your Enquiry, on ".date('dS M, Y @ H:i:s',$resolv['mun_time']).".
<hr>
<h5 style='color:purple;'>
".$resolv['ml_body']."
</h5>
<hr>
<br><br>

".$resolving_text."<br>
<br>

Please do not reply to this email.</p>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <do-not-reply@munc.com>' . "\r\n";
$headers .= 'Bcc: com.aa.ay@gmail.com' . "\r\n";

if(mail($resolving_email,'Re: '.$resolving_subject.'',$message,$headers)){
	
	if($conn->query("UPDATE `mun_mails` SET `ml_read`= 1,`ml_resolved_dnt`='".time()."' WHERE ml_id = ".$resolv['ml_id']." and ml_valid =1 and ml_read = 0")){
		
		
				##### Insert Logs ##################################################################VV3###
		if(preplogs($editresolvmun,$_SESSION['SCHVB_USR_DB_ID'],'mun_mails','update', "UPDATE `mun_mails` SET `ml_read`= 1,`ml_resolved_dnt`='".time()."' WHERE ml_id = ".$resolv['ml_id']." and ml_valid =1 and ml_read = 0" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TsdGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




	echo 'An email was sent to the recipient <a href="enquire.php"><button>Go Back</button></a> ';
	}else{
		die("EERRMAjhenrviui3ijg");
	}
	
}else{
	echo 'Mail not sent';
}
		#
	}
	
	
	
	
	
	
}
##
#
if(isset($_GET['claimmun_from_id'])){
	if(isset($_SESSION['SCHVB_USR_DB_ID'])){
	}else{
		die('You Must be logged in to Claim the MUN with the account that the request was made through<br>
<a href="login.php"><button>Click to Login</button></a>');
	}
	$chi = $_GET['claimmun_from_id'];
	if(ctype_alnum($chi)){
		#md5(md5(sha1(sha1(md5(concat(cl_id,'jufjei90gtuj 3tg3gtgit hygt gut3 egt90ug09u3g 9u3ug90j4tej'))))))
		$cl = getdatafromsql($conn, "SELECT * FROM mun_claim_requests where md5(md5(sha1(sha1(md5(concat(cl_id,'jufjei90gtuj 3tg3gtgit hygt gut3 egt90ug09u3g 9u3ug90j4tej')))))) = '".$chi."' and cl_valid =1 and cl_granted= 0");
		if(is_array($cl)){
			if(time() < ($cl['cl_gen_time'] + 86401)){
				if($cl['cl_rel_lum_id'] == $_SESSION['SCHVB_USR_DB_ID']){
					if($conn->query("UPDATE `mun_claim_requests` SET `cl_granted`=1 ,
					`cl_ip`='".$_SERVER['REMOTE_ADDR']."'
					WHERE cl_id = ".$cl['cl_id']." and cl_valid =1")){
								##### Insert Logs ##################################################################VV3###
		if(preplogs($cl,$_SESSION['SCHVB_USR_DB_ID'],'mun_claim_requests','update', "UPDATE `mun_claim_requests` SET `cl_granted`=1 ,`cl_ip`='".$_SERVER['REMOTE_ADDR']."' WHERE cl_id = ".$cl['cl_id']." and cl_valid =1" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




						header('Location: instructions.php?claimedmun');
					}else{
						die('##ERRMAIU3HG79HURT8UH');
					}
				}else{
					die('<h1>FAILED</h1><br>
You must be logged in with the account you requested the MUN');
				}
			}else{
				die('<h1>Link Expired</h1>');
			}
		}else{
			die('No Request Found');
		}
	}else{
		die('Invalid Hash');
	}
	#
}
#
#
if(isset($_POST['mun_cl_ch'])){
	if(isset($_POST['mun_cl_ch'])){
		if(ctype_alnum(trim($_POST['mun_cl_ch_h']))){
			$editmun = getdatafromsql($conn,"select * from mun_claim_requests where md5(sha1(md5(concat(cl_id,'u4hbrjijnrn gjgbnnrggnbnrgioknjrgrijnbjrn jgjrngnbjjgrodfijg 45u hgoiu5trg1654851584135468 64 64 864684 354 8651 0410351054 6504 6840 864 0864')))) = '".$_POST['mun_cl_ch_h']."' and cl_valid =1");
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
	if(isset($_POST['mun_cl_ch_shrtname'])){
		$shortname = trim($_POST['mun_cl_ch_shrtname']);
	}else{
		die('Enter all Values 1');
	}
	
	if(isset($_POST['mun_cl_ch_lngnme'])){
		$longname = trim($_POST['mun_cl_ch_lngnme']);
	}else{
		die('Enter all Values 2');
	}
	
	if(isset($_POST['mun_cl_ch_hostat'])){
		$hostedat = trim($_POST['mun_cl_ch_hostat']);
	}else{
		die('Enter all Values 3');
	}
	
	if(isset($_POST['mun_cl_ch_hstdaddr'])){
		$hostedataddr = trim($_POST['mun_cl_ch_hstdaddr']);
	}else{
		die('Enter all Values 4');
	}
	
	if(isset($_POST['mun_cl_ch_website'])){
		$website = trim($_POST['mun_cl_ch_website']);
	}else{
		die('Enter all Values 5');
	}
	
	if(isset($_POST['mun_cl_ch_contc'])){
		$contc = trim($_POST['mun_cl_ch_contc']);
	}else{
		die('Enter all Values 55');
	}
	
	
	if(isset($_POST['mun_cl_ch_loc_lat'])){
		$newlat = trim($_POST['mun_cl_ch_loc_lat']);
	}else{
		die('Enter all Values 6');
	}
	
		if(isset($_POST['mun_cl_ch_loc_country'])){
		$country = trim($_POST['mun_cl_ch_loc_country']);
	}else{
		die('Enter all Values 66');
	}
	
	if(isset($_POST['mun_cl_ch_loc_long'])){
		$newlong = trim($_POST['mun_cl_ch_loc_long']);
	}else{
		die('Enter all Values 7');
	}
	
	if(isset($_POST['mun_cl_ch_start_day'])){
		$startday = dtots(trim($_POST['mun_cl_ch_start_day']));
	}else{
		die('Enter all Values 8');
	}
	
	if(isset($_POST['mun_cl_ch_end_day'])){
		$endday = dtots(trim($_POST['mun_cl_ch_end_day']));
	}else{
		die('Enter all Values 9');
	}
	if($editmun['cl_mail_sent'] == 0){
		#You have not been authorised by MUNCIURCUIT but by trustee so the user has to grant your changes #
		die("You have not been authorised by MUNCIURCUIT but by trustee so the user has to grant your changes ");
	}else{
		if($conn->query("UPDATE `mun_rec` SET 
`mun_shortname`= '".$shortname."',
`mun_year`='".date('Y',trim($startday))."',
`mun_fullname`='".$longname."',
`mun_hostedat`='".$hostedat."',
`mun_hosted_addr`='".$hostedataddr."',
`mun_website`='".$website."',
`mun_country`='".$country."',
`mun_lat`='".$newlat."',
`mun_long`='".$newlong."',
`mun_contact_no` = '".$contc."',
`mun_from`='".trim($startday)."',
`mun_till`='".trim($endday)."'
where mun_id = ".trim($editmun['cl_rel_mun_id'])."")){
			##### Insert Logs ##################################################################VV3###
		if(preplogs($editmun,$_SESSION['SCHVB_USR_DB_ID'],'mun_rec','update', "UPDATE `mun_rec` SET 
`mun_shortname`= '".$shortname."',
`mun_year`='".date('Y',trim($startday))."',
`mun_fullname`='".$longname."',
`mun_hostedat`='".$hostedat."',
`mun_hosted_addr`='".$hostedataddr."',
`mun_website`='".$website."',
`mun_country`='".$country."',
`mun_lat`='".$newlat."',
`mun_long`='".$newlong."',
`mun_contact_no` = '".$contc."',
`mun_from`='".trim($startday)."',
`mun_till`='".trim($endday)."'
where mun_id = ".trim($editmun['cl_rel_mun_id'])."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




	header('Location: mymuns.php');
		}else{
			die('ERRMAIUOHJ(I)(');
		}
	}

}
##
##
if(isset($_POST['mun_cl_ch_img'])){
	if(isset($_POST['mun_cl_ch_img_h']) and ctype_alnum($_POST['mun_cl_ch_img_h'])){
		##
$editmun = getdatafromsql($conn,"select * from mun_claim_requests where md5(sha1(md5(md5(concat(cl_id,'2415972129601522 65 65468 405405834 534086409844 8604y8r64hg68y 4t9jgnh5348t 5f3y4vj1n 89e4y6e4908t04 8tyj'))))) = '".$_POST['mun_cl_ch_img_h']."' and cl_valid =1");
	if(is_string($editmun)){
				die('Hash Not Found');
	}
	
	if((count($_FILES) == 0) and isset($_POST['mun_ch_text_url'])){
		if(strlen($_POST['mun_ch_text_url']) == 0){
			die('Nothing to Upload');
			}
	}
	
	if((count($_FILES['mun_ch_img']['tmp_name']) == 1) and (trim(strlen($_FILES['mun_ch_img']['tmp_name'])) > 2)){
	
	
	####################333
	$target_dir = "logos/";
	
$target_file = $target_dir .md5($_FILES["mun_ch_img"]["name"].$_FILES["mun_ch_img"]["tmp_name"].$_FILES["mun_ch_img"]["size"]).uniqid().'_'.md5(time()).'.'. extension($_FILES["mun_ch_img"]["name"]);
$uploadOk = 1;
$err_arr = array();

$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["cl_ch_img"])) {
    $check = getimagesize($_FILES["mun_ch_img"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $err_arr[]="File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    $err_arr[]= "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["mun_ch_img"]["size"] > 1200000) {
    $err_arr[]= "Sorry, your file is too large. (more than 1 mb)";
    $uploadOk = 0;
}
// Allow certain file formats
if(strtolower($imageFileType) != "jpg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpeg"
&& strtolower($imageFileType) != "gif" ) {
    $err_arr[]= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	foreach($err_arr as $err){
		echo $err.'<br>';
	}
    die("Sorry, your file was not uploaded.");

// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["mun_ch_img"]["tmp_name"], $target_file)) {
        #dbupdate
		if($conn->query("UPDATE `mun_rec` SET 
`mun_img_src`='".trim($target_file)."'
where mun_id = ".trim($editmun['cl_rel_mun_id'])."")){
			##### Insert Logs ##################################################################VV3###
		if(preplogs($editmun,$_SESSION['SCHVB_USR_DB_ID'],'mun_rec','update', "UPDATE `mun_rec` SET 
`mun_img_src`='".trim($target_file)."'
where mun_id = ".trim($editmun['cl_rel_mun_id'])."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




	header('Location: mymuns.php');
		}else{
			die('ERRMAIUOHJ(jnfI)(');
		}
		
		#dbupdate
		
    } else {
        die("Sorry, there was an error uploading your file.");
    }
}
	####################333
	}
	
	
	if(strlen($_POST['mun_ch_text_url']) > 0){


$ch = curl_init($_POST['mun_ch_text_url']);
$fp = fopen('logos/'.'.png', 'wb');
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
fclose($fp);


	}
	
	
##
	}else{
		die('Invalid Hash');
	}
	
	
	
}
#
#

if(isset($_POST['mod_add'])){
	if(isset($_SESSION['SCHVB_USR_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sb_logins where lum_id = ".$_SESSION['SCHVB_USR_DB_ID']." and lum_valid = 1 and lum_ad = 1");
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
	############################33333333
	if(isset($_POST['mod_a_ifadmin']) and is_numeric($_POST['mod_a_ifadmin'])){
		if(in_range($_POST['mod_a_ifadmin'],0,1,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 2');
		}
		$ifadm = $_POST['mod_a_ifadmin'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['mod_a_ifnotadmin']) and is_numeric($_POST['mod_a_ifnotadmin'])){
		if(in_range($_POST['mod_a_ifnotadmin'],0,1,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 3');
		}
		$ifnoadm = $_POST['mod_a_ifnotadmin'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['mod_a_ifnotlogin']) and is_numeric($_POST['mod_a_ifnotlogin'])){
		if(in_range($_POST['mod_a_ifnotlogin'],0,1,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 4');
		}
		$ifnlogin = $_POST['mod_a_ifnotlogin'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['mod_a_iflogin']) and is_numeric($_POST['mod_a_iflogin'])){
		if(in_range($_POST['mod_a_ifadmin'],0,1,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 5');
		}
		$iflogin = $_POST['mod_a_iflogin'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
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

	if($conn->query("INSERT INTO `sb_modules`(`mo_name`, `mo_href`, `mo_for`, `mo_icon`, `mo_ifadmin`, `mo_ifnoadmin`, `mo_if_no_log_in`, `mo_if_log_in`, `mo_sub_mod`, `mo_valid`) VALUES (
	'".$nm."',
	'".$href."',
	'".$mofor."',
	'".$ico."',
	".$ifadm.",
	".$ifnoadm.",
	".$ifnlogin.",
	".$iflogin.",
	".$subm.",
	".$vali_s."
	)")){
				##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['SCHVB_USR_DB_ID'],'sb_modules','insert', "INSERT INTO `sb_modules`(`mo_name`, `mo_href`, `mo_icon`, `mo_ifadmin`, `mo_ifnoadmin`, `mo_if_no_log_in`, `mo_if_log_in`, `mo_sub_mod`, `mo_valid`) VALUES (
	'".$nm."',
	'".$href."',
	'".$ico."',
	".$ifadm.",
	".$ifnoadm.",
	".$ifnlogin.",
	".$iflogin.",
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
##
##
if(isset($_POST['a_mun_add'])){
	if(isset($_SESSION['SCHVB_USR_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sb_logins where lum_id = ".$_SESSION['SCHVB_USR_DB_ID']." and lum_valid = 1 and lum_ad = 1");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}
	############################33333333
	if(isset($_POST['a_mun_shrtname'])){
		$shrnm = $_POST['a_mun_shrtname'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['a_mun_flnme'])){
		$flnm = $_POST['a_mun_flnme'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['a_mun_year'])){
		if(is_numeric($_POST['a_mun_year']) and 
		(in_range($_POST['a_mun_year'],
		(date('Y',time()) - 3),(date('Y',time()) +3),true))){
		$year = $_POST['a_mun_year'];
		}
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['a_mun_hosted'])){
		$hostedat = $_POST['a_mun_hosted'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['a_mun_hostedaddr'])){
		$hostedataddr = $_POST['a_mun_hostedaddr'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['a_mun_lat'])){
		$lat = $_POST['a_mun_lat'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['a_mun_long'])){
		$long = $_POST['a_mun_long'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['a_mun_website'])){
		$website = $_POST['a_mun_website'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['a_mun_email'])){
		if(is_email($_POST['a_mun_email'])){
		}else{
			die("Invalid email");
		}
		$email = $_POST['a_mun_email'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['a_mun_country'])){
		$country = $_POST['a_mun_country'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['a_mun_idenbg'])){
		$idenc = $_POST['a_mun_idenbg'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['a_mun_idenfnt'])){
		$fnt = $_POST['a_mun_idenfnt'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['a_mun_contctno']) and is_numeric($_POST['a_mun_contctno'])){
		
		$contcno = $_POST['a_mun_contctno'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['a_mun_stdt']) ){
		$startdate = strtotime($_POST['a_mun_stdt']);
		if(is_numeric($startdate)){
		}else{
			die("Invalid Start date");
		}
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['a_mun_etdt']) ){
		$enddate = strtotime($_POST['a_mun_etdt']);
		if(is_numeric($enddate)){
			if($startdate > $enddate){
				die("End date should always be in Future");
			}
		}else{
			die("Invalid End date");
		}
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['a_mun_valid']) and is_numeric($_POST['a_mun_valid'])){
		if(in_range($_POST['a_mun_valid'],0,1,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 6');
		}
		$vali_s = $_POST['a_mun_valid'];
	}else{
		die('Enter all Fields Correctly');
	}
	
	############################33333333
	if(isset($_FILES['mun_img'])){
		if(is_array($_FILES['mun_img']['name'])){
			
		}
	}else{
		die('Enter Please Upload an image too.');
	}
	############################33333333
	#####file upload
	
	
	$target_dir = "logos/";
	
$target_file = $target_dir .md5($_FILES["mun_img"]["name"].$_FILES["mun_img"]["tmp_name"].$_FILES["mun_img"]["size"]).uniqid().'_'.md5(time()).'.'. extension($_FILES["mun_img"]["name"]);
$uploadOk = 1;
$err_arr = array();

$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["a_mun_add"])) {
    $check = getimagesize($_FILES["mun_img"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $err_arr[]="File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    $err_arr[]= "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["mun_img"]["size"] > 1200000) {
    $err_arr[]= "Sorry, your file is too large. (more than 1 mb)";
    $uploadOk = 0;
}
// Allow certain file formats
if(strtolower($imageFileType) != "jpg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpeg"
&& strtolower($imageFileType) != "gif" ) {
    $err_arr[]= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	foreach($err_arr as $err){
		echo $err.'<br>';
	}
    die("Sorry, your file was not uploaded.");

// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["mun_img"]["tmp_name"], $target_file)) {
        #dbupdate
		if($conn->query("INSERT INTO `mun_rec`(`mun_shortname`, `mun_year`, `mun_img_src`, `mun_fullname`, `mun_hostedat`, `mun_hosted_addr`, `mun_website`, `mun_email`, `mun_country`, `mun_lat`, `mun_long`, `mun_from`, `mun_till`, `mun_contact_no`, `mun_iden_color`, `mun_text_color`, `mun_valid`) VALUES (
		'".$shrnm."','".$year."','".$target_file."','".$flnm."','".$hostedat."','".$hostedataddr."','".$website."','".$email."','".$country."','".$lat."','".$long."' ,'".$startdate."','".$enddate."','".$contcno."','".$idenc."','".$fnt."' , '".$vali_s."'	)
		")){
			
					##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['SCHVB_USR_DB_ID'],'mun_rec','insert', "INSERT INTO `mun_rec`(`mun_shortname`, `mun_year`, `mun_img_src`, `mun_fullname`, `mun_hostedat`, `mun_hosted_addr`, `mun_website`, `mun_email`, `mun_country`, `mun_lat`, `mun_long`, `mun_from`, `mun_till`, `mun_contact_no`, `mun_iden_color`, `mun_text_color`, `mun_valid`) VALUES (
		'".$shrnm."','".$year."','".$target_file."','".$flnm."','".$hostedat."','".$hostedataddr."','".$website."','".$email."','".$country."','".$lat."','".$long."' ,'".$startdate."','".$enddate."','".$contcno."','".$idenc."','".$fnt."' , '".$vali_s."'	)
		" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




	header('Location: admin_mun.php');
		}else{
			die('ERRMktjrgAIUOHJ(');
		}
		
		#dbupdate
		
    } else {
        die("Sorry, there was an error uploading your file.");
    }
}


	
	####file upload ends

}
##
##
if(isset($_POST['add_user'])){
	if(isset($_SESSION['SCHVB_USR_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sb_logins where lum_id = ".$_SESSION['SCHVB_USR_DB_ID']." and lum_valid = 1 and lum_ad = 1");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}

	############################33333333
	if(isset($_POST['usr_f_name']) and ctype_alnum(str_replace(" ","",strtolower($_POST['usr_f_name'])))){
		$nm = $_POST['usr_f_name'];
	}else{
		die('Enter all Fields Correctly1');
	}
	############################33333333
	if(isset($_POST['usr_email'])){
		if(is_email($_POST['usr_email'])){
		$eml = $_POST['usr_email'];
		}else{
			die('Email not Valid');
		}
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	############################33333333
	if(isset($_POST['usr_type'])){
		if(is_numeric($_POST['usr_type']) and (($_POST['usr_type'] == 1) or ($_POST['usr_type'] == 4))){
		$usr_type = $_POST['usr_type'];
		}else{
			die('User Type not Valid');
		}
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['usr_pw'])){
		$pw = md5(md5(sha1($_POST['usr_pw'])));
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['usr_acc']) and is_numeric($_POST['usr_acc'])){
		if(in_range($_POST['usr_acc'],0,1,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 2');
		}
		$ad = $_POST['usr_acc'];
	}else{
		die('Enter all Fields Correctly 3');
	}
	############################33333333
	if(isset($_POST['usr_acc_l']) and is_numeric($_POST['usr_acc_l'])){
		if(in_range($_POST['usr_acc_l'],0,10,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 4');
		}
		$adlvl = $_POST['usr_acc_l'];
	}else{
		die('Enter all Fields Correctly 2');
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
#########################
$ui = explode(' ',$nm);
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
$hash = gen_hash($pw,$eml);

$checkusrnm = getdatafromsql($conn,"select * from sb_logins where lum_username = '".trim($usr)."'");
if(is_array($checkusrnm)){
	die("Please refresh the Page and resend the post values .");
}
$iv = 1098541894 .rand(100000,999999);

#########################
	if($conn->query("INSERT INTO `sb_logins`(`lum_rel_tu_id`,`lum_email`, `lum_username`, `lum_password`, `lum_hash_mix`, `lum_ad`, `lum_ad_level`,`lum_pass_def`) VALUES 
	('".trim($usr_type)."','".trim($eml)."', '".trim($usr)."', '".trim($pw)."', '".trim($hash)."', '".trim($ad)."', '".trim($adlvl)."'
	,'".$defpw."')")){





	##
		$ltid = $conn->insert_id;
		
						##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['SCHVB_USR_DB_ID'],'sb_logins','insert', "INSERT INTO `sb_logins`(`lum_email`, `lum_username`, `lum_password`, `lum_hash_mix`, `lum_ad`, `lum_ad_level`) VALUES 
	('".trim($eml)."', '".trim($usr)."', '".trim($pw)."', '".trim($hash)."', '".trim($ad)."', '".trim($adlvl)."')" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###



	$sqlb = "INSERT INTO `sb_users`(`usr_name`, `usr_rel_lum_id`,  `usr_iv`, `usr_reg_dnt`, `usr_reg_ip`,`usr_validtill`) VALUES (
'".$nm."',
'".$ltid."',
'".$iv."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$valid_till."')";

	if ($conn->query($sqlb) === TRUE) {
				##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['SCHVB_USR_DB_ID'],'sb_users','insert', $sqlb ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
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
##
##
if(isset($_POST['add_sys_user'])){
	if(isset($_SESSION['SCHVB_USR_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sb_logins where lum_id = ".$_SESSION['SCHVB_USR_DB_ID']." and lum_valid = 1 and lum_ad = 1");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}
	############################33333333
	if(isset($_POST['sys_usr_acc']) and is_numeric($_POST['sys_usr_acc'])){
		if(in_range($_POST['sys_usr_acc'],0,10,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 4');
		}
		
		$adlvl = $_POST['sys_usr_acc'];
		if($adlvl == 0){
			$ad = 0;
		}else{
			$ad = 1;
		}
	}else{
		die('Enter all Fields Correctly 2');
	}
	############################33333333
	if(isset($_POST['sys_usr_validtill']) and is_numeric($_POST['sys_usr_validtill'])){
		$vldtll = $_POST['sys_usr_validtill'];
		if(trim($vldtll) == 0){
			$valid_till = 0;
		}else{
			$valid_till = (time()+ ($vldtll*60));
		}
	}else{
		die('Enter all Fields Correctly 1');
	}
#########################

$email = uniqid().rand(2342,23432).'@tut.man';
$pw = md5(md5(sha1('commonpassword')));
$usr = strtolower(md5(time().sha1(uniqid().time()).uniqid().rand(234531,5643534)));

$hash = gen_hash($pw,$email);

$checkusrnm = getdatafromsql($conn,"select * from sb_logins where lum_username = '".trim($usr)."'");
if(is_array($checkusrnm)){
	die("Please refresh the Page and resend the post values .");
}
$iv = 1098541894 .rand(100000,999999);

#########################
	if($conn->query("INSERT INTO `sb_logins`(`lum_email`, `lum_username`, `lum_password`, `lum_hash_mix`, `lum_ad`, `lum_ad_level`) VALUES 
	('".trim($email)."', '".trim($usr)."', '".trim($pw)."', '".trim($hash)."', '".trim($ad)."', '".trim($adlvl)."')")){
	##
	




		$ltid = $conn->insert_id;
					##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['SCHVB_USR_DB_ID'],'sb_logins','insert', "INSERT INTO `sb_logins`(`lum_email`, `lum_username`, `lum_password`, `lum_hash_mix`, `lum_ad`, `lum_ad_level`) VALUES 
	('".trim($email)."', '".trim($usr)."', '".trim($pw)."', '".trim($hash)."', '".trim($ad)."', '".trim($adlvl)."')" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###

	$sqlb = "INSERT INTO `sb_users`(`usr_name`, `usr_rel_lum_id`,  `usr_iv`, `usr_reg_dnt`, `usr_reg_ip`,`usr_validtill`) VALUES (
'School Vault User',
'".$ltid."',

'".$iv."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$valid_till."'
)";

	if ($conn->query($sqlb) === TRUE) {
			##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['SCHVB_USR_DB_ID'],'sb_users','insert', $sqlb ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###





    header('Location: admin_users.php');
} else {
    echo "Error##rujioma";
}
	

	##
	
	}else{
		die('ERRMAIGOTURG');
	}
}
#
#
#_______________________________START ADMINMUN_______________________
if(isset($_POST['hash_inc']) and isset($_POST['com_make_ac'])){
	if(ctype_alnum(trim($_POST['ha_com']))){
		$checkit = getdatafromsql($conn,"select * from mun_rec where md5(md5(sha1(sha1(md5(md5(concat(mun_id,'jijnfiirjfnirokijfkorkvnkorvfk'))))))) = '".$_POST['ha_com']."' and mun_valid =0");
		
		if(is_array($checkit)){
			if($conn->query("update mun_rec set mun_valid =1 where mun_id= ".$checkit['mun_id']."")){
								##### Insert Logs ##################################################################VV3###
		if(preplogs($checkit,$_SESSION['SCHVB_USR_DB_ID'],'mun_rec','update', "update mun_rec set mun_valid =1 where mun_id= ".$checkit['mun_id']."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###

								header('Location: admin_mun.php');
			}else{
				die('ERRRMA!JOINJFO');
			}
		}else{
			die("No Mun\'s Found");
		}
	}else{
		die('Invalid Entries');
	}
}
#
#
if(isset($_POST['ha_com']) and isset($_POST['com_make_inac'])){
	if(ctype_alnum(trim($_POST['ha_com']))){
		$checkit = getdatafromsql($conn,"select * from mun_rec where md5(md5(sha1(sha1(md5(md5(concat(mun_id,'egkjtnr newsdnjjenfkv ijfkorkvnkorvfk'))))))) = '".$_POST['ha_com']."' and mun_valid = 1");
		
		if(is_array($checkit)){
			if($conn->query("update mun_rec set mun_valid =0 where mun_id= ".$checkit['mun_id']."")){
				##### Insert Logs ##################################################################VV3###
		if(preplogs($checkit,$_SESSION['SCHVB_USR_DB_ID'],'mun_rec','update', "update mun_rec set mun_valid =0 where mun_id= ".$checkit['mun_id']."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###

								header('Location: admin_mun.php');
			}else{
				die('ERRRMA!JOINJFWFEAO');
			}
		}else{
			die("No Mun\'s Found");
		}
	}else{
		die('Invalid Entries');
	}
}
#
#_______________________________END ADMINMUN_______________________
#_______________________________START MODULES_______________________
if(isset($_POST['hash_ac']) and isset($_POST['tab_act'])){
	if(ctype_alnum(trim($_POST['hash_ac']))){
		$checkit = getdatafromsql($conn,"select * from sb_modules where md5(md5(sha1(sha1(md5(md5(concat(mo_id,'njhifverkof2njbivjwj bfurhib2jw'))))))) = '".$_POST['hash_ac']."' and mo_valid =0");
		
		if(is_array($checkit)){
			if($conn->query("update sb_modules set mo_valid =1 where mo_id= ".$checkit['mo_id']."")){
				##### Insert Logs ##################################################################VV3###
		if(preplogs($checkit,$_SESSION['SCHVB_USR_DB_ID'],'sb_modules','update', "update sb_modules set mo_valid =1 where mo_id= ".$checkit['mo_id']."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
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
#
#
if(isset($_POST['hash_inc']) and isset($_POST['tab_inact'])){
	if(ctype_alnum(trim($_POST['hash_inc']))){
		$checkit = getdatafromsql($conn,"select * from sb_modules where md5(md5(sha1(sha1(md5(md5(concat(mo_id,'hbujeio03ir94urghnjefr 309i4wef'))))))) = '".$_POST['hash_inc']."' and mo_valid =1");
		
		if(is_array($checkit)){
			if($conn->query("update sb_modules set mo_valid =0 where mo_id= ".$checkit['mo_id']."")){				
##### Insert Logs ##################################################################VV3###
		if(preplogs($checkit,$_SESSION['SCHVB_USR_DB_ID'],'sb_modules','update', "update sb_modules set mo_valid =0 where mo_id= ".$checkit['mo_id']."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
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
#
#_______________________________END MODULES_______________________
#_______________________________START USER_______________________
if(isset($_POST['yh_com']) and isset($_POST['usr_make_ac'])){
	if(ctype_alnum(trim($_POST['yh_com']))){
		$checkit = getdatafromsql($conn,"select * from sb_logins where 
		md5(md5(sha1(sha1(md5(md5(concat(lum_id,'hir39efnewsfejirjeofkvjrjdnjjenfkvkijonreij3nj'))))))) = '".$_POST['yh_com']."' and lum_valid = 0");
		
		if(is_array($checkit)){
			if($checkit['lum_email'] == 'ayanzcap@hotmail.com'){
				die('Super user can\'t be modified');
			}
			if($conn->query("update sb_logins set lum_valid =1 where lum_id= ".$checkit['lum_id']."")){
								
##### Insert Logs ##################################################################VV3###
		if(preplogs($checkit,$_SESSION['SCHVB_USR_DB_ID'],'sb_logins','update', "update sb_logins set lum_valid =1 where lum_id= ".$checkit['lum_id']."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
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
#
if(isset($_POST['yh_com']) and isset($_POST['usr_make_inac'])){
	if(ctype_alnum(trim($_POST['yh_com']))){
		$checkit = getdatafromsql($conn,"select * from sb_logins where 
		md5(md5(sha1(sha1(md5(md5(concat(lum_id,'hir39efnewsfejirjrjdnjjenfkv ijfkorkvnkorvfk'))))))) = '".$_POST['yh_com']."' and lum_valid = 1");
		
		if(is_array($checkit)){
			if($checkit['lum_email'] == 'ayanzcap@hotmail.com'){
				die('Super user can\'t be deleted');
			}
			if($conn->query("update sb_logins set lum_valid =0 where lum_id= ".$checkit['lum_id']."")){
				
##### Insert Logs ##################################################################VV3###
		if(preplogs($checkit,$_SESSION['SCHVB_USR_DB_ID'],'sb_logins','update', "update sb_logins set lum_valid =0 where lum_id= ".$checkit['lum_id']."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
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
##
##
if(isset($_POST['edit_com'])){
	if(isset($_SESSION['SCHVB_USR_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sb_logins where lum_id = ".$_SESSION['SCHVB_USR_DB_ID']." and lum_valid = 1 and lum_ad = 1");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}
	if(isset($_POST['h_com'])){
		if(ctype_alnum(trim($_POST['h_com']))){
			$editmun = getdatafromsql($conn,"select * from mun_rec where md5(md5(sha1(sha1(md5(md5(concat(mun_id,'9irbfheierifhe3 4r3r04 j49i4u49igrhru9git'))))))) = '".$_POST['h_com']."'");
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
	if(isset($_POST['mun_edit_shrtnme'])){
		$shortname = trim($_POST['mun_edit_shrtnme']);
	}else{
		die('Enter all Values 1');
	}
	
	if(isset($_POST['mun_edit_fullnme'])){
		$longname = trim($_POST['mun_edit_fullnme']);
	}else{
		die('Enter all Values 2');
	}
	
	if(isset($_POST['mun_edit_hosat'])){
		$hostedat = trim($_POST['mun_edit_hosat']);
	}else{
		die('Enter all Values 3');
	}
	
	if(isset($_POST['mun_edit_hosaddr'])){
		$hostedataddr = trim($_POST['mun_edit_hosaddr']);
	}else{
		die('Enter all Values 4');
	}
	
	if(isset($_POST['mun_edit_web'])){
		$website = trim($_POST['mun_edit_web']);
	}else{
		die('Enter all Values 5');
	}
	
	if(isset($_POST['mun_edit_eml'])){
		if(is_email($_POST['mun_edit_eml'])){
			$neml = trim($_POST['mun_edit_eml']);
		}else{
			die('Invalid Email');
		}
	}else{
		die('Enter all Values 5.3');
	}
	
	if(isset($_POST['mun_edit_contcno'])){
		$contc = trim($_POST['mun_edit_contcno']);
	}else{
		die('Enter all Values 55');
	}
	
	if(isset($_POST['mun_edit_country'])){
		$ncountry = trim($_POST['mun_edit_country']);
	}else{
		die('Enter all Values 5.,5');
	}
	
	
	if(isset($_POST['mun_edit_lat'])){
		$newlat = trim($_POST['mun_edit_lat']);
	}else{
		die('Enter all Values 6');
	}	
	if(isset($_POST['mun_edit_long'])){
		$newlong = trim($_POST['mun_edit_long']);
	}else{
		die('Enter all Values 6');
	}
	
	if(isset($_POST['mun_edit_idenbg'])){
		$newidenbg= trim($_POST['mun_edit_idenbg']);
	}else{
		die('Enter all Values 6');
	}
	
	
	if(isset($_POST['mun_edit_idenfc'])){
		$newidenfc= trim($_POST['mun_edit_idenfc']);
	}else{
		die('Enter all Values 6');
	}
	
	if(isset($_POST['mun_edit_startdate'])){
		$startday = dtots(trim($_POST['mun_edit_startdate']));
	}else{
		die('Enter all Values 8');
	}
	
	if(isset($_POST['mun_edit_enddate'])){
		$endday = dtots(trim($_POST['mun_edit_enddate']));
	}else{
		die('Enter all Values 9');
	}
	
	
	if(1==0){
		#You have not been authorised by MUNCIURCUIT but by trustee so the user has to grant your changes #
		die("You have not been authorised by MUNCIURCUIT but by trustee so the user has to grant your changes ");
	}else{
		if($conn->query("UPDATE `mun_rec` SET 
`mun_shortname`= '".$shortname."',
`mun_year`='".date('Y',trim($startday))."',
`mun_fullname`='".$longname."',
`mun_hostedat`='".$hostedat."',
`mun_hosted_addr`='".$hostedataddr."',
`mun_website`='".$website."',
`mun_country`='".$ncountry."',
`mun_email` = '".$neml."',
`mun_lat`='".$newlat."',
`mun_long`='".$newlong."',
`mun_contact_no` = '".$contc."',
`mun_from`='".trim($startday)."',
`mun_till`='".trim($endday)."',
`mun_iden_color`='".trim($newidenbg)."',
`mun_text_color`='".trim($newidenfc)."'
where mun_id = ".trim($editmun['mun_id'])."")){
		##### Insert Logs ##################################################################VV3###
		if(preplogs($editmun,$_SESSION['SCHVB_USR_DB_ID'],'mun_rec','update',"UPDATE `mun_rec` SET 
`mun_shortname`= '".$shortname."',
`mun_year`='".date('Y',trim($startday))."',
`mun_fullname`='".$longname."',
`mun_hostedat`='".$hostedat."',
`mun_hosted_addr`='".$hostedataddr."',
`mun_website`='".$website."',
`mun_country`='".$ncountry."',
`mun_email` = '".$neml."',
`mun_lat`='".$newlat."',
`mun_long`='".$newlong."',
`mun_contact_no` = '".$contc."',
`mun_from`='".trim($startday)."',
`mun_till`='".trim($endday)."',
`mun_iden_color`='".trim($newidenbg)."',
`mun_text_color`='".trim($newidenfc)."'
where mun_id = ".trim($editmun['mun_id'])."",$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###

	header('Location: admin_mun.php');
		}else{
			die('ERRMAers');
		}
	}

}
##
##
if(isset($_POST['edit_mod'])){
	if(isset($_SESSION['SCHVB_USR_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sb_logins where lum_id = ".$_SESSION['SCHVB_USR_DB_ID']." and lum_valid = 1 and lum_ad = 1");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}
	if(isset($_POST['hash_emmp__1i'])){
		if(ctype_alnum(trim($_POST['hash_emmp__1i']))){
			$editmun = getdatafromsql($conn,"select * from sb_modules where md5(md5(sha1(sha1(md5(md5(concat(mo_id,'lkoegnuifvh bnn njenjn'))))))) = '".$_POST['hash_emmp__1i']."'");
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
	############################33333333
	if(isset($_POST['edit_ifadmin']) and is_numeric($_POST['edit_ifadmin'])){
		if(in_range($_POST['edit_ifadmin'],0,1,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 2');
		}
		$ifadm = $_POST['edit_ifadmin'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['edit_ifnoadmin']) and is_numeric($_POST['edit_ifnoadmin'])){
		if(in_range($_POST['edit_ifnoadmin'],0,1,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 3');
		}
		$ifnoadm = $_POST['edit_ifnoadmin'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['edit_ifnologin']) and is_numeric($_POST['edit_ifnologin'])){
		if(in_range($_POST['edit_ifnologin'],0,1,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 4');
		}
		$ifnlogin = $_POST['edit_ifnologin'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['edit_iflogin']) and is_numeric($_POST['edit_iflogin'])){
		if(in_range($_POST['edit_iflogin'],0,1,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 5');
		}
		$iflogin = $_POST['edit_iflogin'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333

	
	if(1==0){
		#You have not been authorised by MUNCIURCUIT but by trustee so the user has to grant your changes #
		die("You have not been authorised by MUNCIURCUIT but by trustee so the user has to grant your changes ");
	}else{
		if($conn->query("UPDATE `sb_modules` SET 
`mo_name`= '".$nm."',
`mo_href`='".$href."',
`mo_for` = '".$mofor."',
`mo_icon`='".$ico."',
`mo_ifadmin`='".$ifadm."',
`mo_ifnoadmin`='".$ifnoadm."',
`mo_if_no_log_in`='".$ifnlogin."',
`mo_if_log_in`='".$iflogin."',
`mo_sub_mod`='".$subm."'
where mo_id = ".trim($editmun['mo_id'])."")){
	
	
	##### Insert Logs ##################################################################VV3###
		if(preplogs($editmun,$_SESSION['SCHVB_USR_DB_ID'],'sb_modules','update',"UPDATE `sb_modules` SET 
`mo_name`= '".$nm."',
`mo_href`='".$href."',
`mo_for` = '".$mofor."',
`mo_icon`='".$ico."',
`mo_ifadmin`='".$ifadm."',
`mo_ifnoadmin`='".$ifnoadm."',
`mo_if_no_log_in`='".$ifnlogin."',
`mo_if_log_in`='".$iflogin."',
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
##
##
if(isset($_POST['edit_user'])){
	if(isset($_SESSION['SCHVB_USR_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sb_logins where lum_id = ".$_SESSION['SCHVB_USR_DB_ID']." and lum_valid = 1 and lum_ad = 1");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}
	if(isset($_POST['hash_chkr'])){
		if(ctype_alnum(trim($_POST['hash_chkr']))){
			$editmun = getdatafromsql($conn,"select * from sb_logins where md5(md5(sha1(sha1(md5(md5(concat(lum_id,'f2frbgbe 2fgtegrfr3gbter 24rfgr324frgtr3f 3gr32fgr32f4gr'))))))) = '".$_POST['hash_chkr']."'");
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
	if(isset($_POST['edit_us_username'])){
		$unm = trim($_POST['edit_us_username']);
	}else{
		die('Enter all Values 1');
	}
	
	if(isset($_POST['edit_us_nme'])){
		$nm = trim($_POST['edit_us_nme']);
	}else{
		die('Enter all Values 2');
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
		die('Enter all Values 3');
	}
	
	if(isset($_POST['edit_us_adm']) and is_numeric($_POST['edit_us_adm'])){
		if(in_range($_POST['edit_us_adm'],0,1,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 1');
		}
		$admer = $_POST['edit_us_adm'];
	}else{
		die('Enter all Fields Correctly');
	}
	
	if(isset($_POST['edit_us_amdlvl']) and is_numeric($_POST['edit_us_amdlvl'])){
		if(in_range($_POST['edit_us_amdlvl'],0,10,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 1');
		}
		$admlvl = $_POST['edit_us_amdlvl'];
	}else{
		die('Enter all Fields Correctly');
	}
	

	
	if(isset($_POST['edit_us_prfpic'])){
		$nprofpic = trim($_POST['edit_us_prfpic']);
	}else{
		die('Enter all Values 5.,5');
	}
	
	
	if(isset($_POST['edit_us_prfbgpc'])){
		$nprofbg = trim($_POST['edit_us_prfbgpc']);
	}else{
		die('Enter all Values 6');
	}	
	
	if(isset($_POST['edit_us_till'])){
		$startday =trim($_POST['edit_us_till']);
		if(($startday == '0') or ($startday == 0)){
			$usrtill = 0;
		}else{
			$usrtill = time() + (60*$_POST['edit_us_till']);
		}
	}else{
		die('Enter all Values 8');
	}
		
	if(1==0){
		#You have not been authorised by MUNCIURCUIT but by trustee so the user has to grant your changes #
		die("You have not been authorised by MUNCIURCUIT but by trustee so the user has to grant your changes ");
	}else{
		$querytobeinserted = "
UPDATE 
	`sb_logins` a,
	`sb_users` b 
SET 
	a.lum_username= '".$unm."',
	a.lum_password='".trim($pw)."',
	a.lum_hash_mix='".$hash."',
	a.lum_ad='".$admer."',
	a.lum_ad_level='".$admlvl."',
	b.usr_name='".$nm."',
	b.usr_prof_pic='".$nprofpic."',
	b.usr_back_pic = '".$nprofbg."',
	b.usr_validtill='".trim($usrtill)."'
WHERE
	a.lum_id = b.usr_rel_lum_id and 
	a.lum_id = ".trim($editmun['lum_id'])."";
		if($conn->query($querytobeinserted)){
		
##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['SCHVB_USR_DB_ID'],'sb_logins','update',$querytobeinserted,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
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
##
##
#
if(isset($_POST['mun_admin_ch_img']) and ctype_alnum(trim($_POST['mun_admin_ch_img']))){
	if(isset($_SESSION['SCHVB_USR_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sb_logins where lum_id = ".$_SESSION['SCHVB_USR_DB_ID']." and lum_valid = 1 and lum_ad = 1");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}

	
	if(isset($_POST['mun_admin_ch_img_h']) and ctype_alnum($_POST['mun_admin_ch_img_h'])){
		##
$editmun = getdatafromsql($conn,"select * from mun_rec where md5(sha1(md5(md5(concat(mun_id,'2415972129601522 65 65468 405405834 534086409844 8604y8r64hg68y 4t9jgnh5348t 5f3y4vj1n 89e4y6e4908t04 8tyj'))))) = '".$_POST['mun_admin_ch_img_h']."'");
	if(is_string($editmun)){
				die('Hash Not Found');
	}
	
	if((count($_FILES) == 0)){
			die('Nothing to Upload');
	}
	
	if((count($_FILES['mun_admin_img_chd']['tmp_name']) == 1) and (trim(strlen($_FILES['mun_admin_img_chd']['tmp_name'])) > 2)){
	
	
	####################333
	$target_dir = "logos/";
	
$target_file = $target_dir .md5($_FILES["mun_admin_img_chd"]["name"].$_FILES["mun_admin_img_chd"]["tmp_name"].$_FILES["mun_admin_img_chd"]["size"]).uniqid().'_'.md5(time()).'.'. extension($_FILES["mun_admin_img_chd"]["name"]);
$uploadOk = 1;
$err_arr = array();

$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["mun_admin_ch_img"])) {
    $check = getimagesize($_FILES["mun_admin_img_chd"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $err_arr[]="File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    $err_arr[]= "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["mun_admin_img_chd"]["size"] > 1200000) {
    $err_arr[]= "Sorry, your file is too large. (more than 1 mb)";
    $uploadOk = 0;
}
// Allow certain file formats
if(strtolower($imageFileType) != "jpg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpeg"
&& strtolower($imageFileType) != "gif" ) {
    $err_arr[]= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	foreach($err_arr as $err){
		echo $err.'<br>';
	}
    die("Sorry, your file was not uploaded.");

// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["mun_admin_img_chd"]["tmp_name"], $target_file)) {
        #dbupdate
		if($conn->query("UPDATE `mun_rec` SET 
`mun_img_src`='".trim($target_file)."'
where mun_id = ".trim($editmun['mun_id'])."")){
			##### Insert Logs ##################################################################VV3###
		if(preplogs($editmun,$_SESSION['SCHVB_USR_DB_ID'],'mun_rec','update', "UPDATE `mun_rec` SET 
`mun_img_src`='".trim($target_file)."'
where mun_id = ".trim($editmun['mun_id'])."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




	header('Location: admin_mun.php');
		}else{
			die('ERRMAIUOHJ(jnfI)(');
		}
		
		#dbupdate
		
    } else {
        die("Sorry, there was an error uploading your file.");
    }
}
	####################333
	}
	
	
##
	}else{
		die('Invalid Hash');
	}
	
	
		#######
}
##
##
if(isset($_POST['u_add_m'])){
		if(isset($_SESSION['SCHVB_USR_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sb_logins where lum_id = ".$_SESSION['SCHVB_USR_DB_ID']." and lum_valid = 1");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}


	if(isset($_SESSION['SCHVB_USR_DB_ID'])){
		
	}else{
		die('Please login to continue <a href="index.php"><button>Login</button></a>');
	}
	
	if(count($_POST) == 14){
		if(isset($_POST['u_add_m'])){
		}else{
			die('Enter all Values 1');
		}
		
		if(isset($_POST['u_add_m_m_sn'])){
		}else{
			die('Enter all Values 2');
		}
		if(isset($_POST['u_add_m_m_ln'])){
		}else{
			die('Enter all Values 3');
		}
		if(isset($_POST['u_add_m_m_yr'])){
		}else{
			die('Enter all Values 4');
		}
		if(isset($_POST['u_add_m_m_eml'])){
		}else{
			die('Enter all Values 5');
		}
		if(isset($_POST['u_add_m_m_webs'])){
		}else{
			die('Enter all Values 6');
		}
		if(isset($_POST['u_add_m_m_mobs'])){
		}else{
			die('Enter all Values 7');
		}
		if(isset($_POST['u_add_m_m_hstdat'])){
		}else{
			die('Enter all Values 8');
		}
		if(isset($_POST['u_add_m_m_hstdadd'])){
		}else{
			die('Enter all Values 9');
		}
		if(isset($_POST['u_add_m_m_ins_lat'])){
		}else{
			die('Enter all Values 10');
		}
		if(isset($_POST['u_add_m_m_ins_lng'])){
		}else{
			die('Enter all Values 11');
		}
		if(isset($_POST['u_add_m_m_country'])){
		}else{
			die('Enter all Values 12');
		}
		if(isset($_POST['u_add_m_m_stdt'])){
		}else{
			die('Enter all Values 13');
		}
		if(isset($_POST['u_add_m_m_endt'])){
		}else{
			die('Enter all Values 14');
		}
		
	}else{
		die('Values Entered dont match field count');
	}
	
	if((count($_FILES) == 0)){
			die('Nothing to Upload');
	}
	if(isset($_FILES['u_add_m_m_lo'])){
	
	
	if((count($_FILES['u_add_m_m_lo']['tmp_name']) == 1) and (trim(strlen($_FILES['u_add_m_m_lo']['tmp_name'])) > 2)){
	}else{
		die('Only one image allowed to upload');
	}
	}
	else{
		die("Image to Upload not found");
	}
	if(is_numeric($_POST['u_add_m_m_yr'])){
		if(    (($_POST['u_add_m_m_yr'] -1 ) == date("Y",time()))  or (date("Y",time()) == date("Y",time())) or (date("Y",time()) > (date("Y",time()) -4) ) ){
		}else{
			die("Date can only be one year in future and 4 years in past");
		}
	}else{
		die('Invalid Year');
	}
	
	if(isset($_POST['u_add_m_m_stdt'])){
		$_POST['u_add_m_m_stdt'] = dtots(trim($_POST['u_add_m_m_stdt']));
	}else{
		die('Enter all Values 8');
	}
	
	if(isset($_POST['u_add_m_m_endt'])){
		$_POST['u_add_m_m_endt'] = dtots(trim($_POST['u_add_m_m_endt']));
	}else{
		die('Enter all Values 9');
	}
	
	
if(date("Y",$_POST['u_add_m_m_stdt']) == $_POST['u_add_m_m_yr']){
}else{
	die('Invalid Date and year combination');
}

if(date("Y",$_POST['u_add_m_m_endt']) <= $_POST['u_add_m_m_yr']){
}else{
	die('Invalid Date and year combination');
}
	
if($_POST['u_add_m_m_stdt'] >= $_POST['u_add_m_m_endt']){
	die('The Mun Should atleast last a day');
}
	
	
	###########3


		$target_dir = "logos/";
	
$target_file = $target_dir .md5($_FILES["u_add_m_m_lo"]["name"].$_FILES["u_add_m_m_lo"]["tmp_name"].$_FILES["u_add_m_m_lo"]["size"]).uniqid().'_'.md5(time()).'.'. extension($_FILES["u_add_m_m_lo"]["name"]);
$uploadOk = 1;
$err_arr = array();

$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["u_add_m"])) {
    $check = getimagesize($_FILES["u_add_m_m_lo"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $err_arr[]="File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    $err_arr[]= "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["u_add_m_m_lo"]["size"] > 1200000) {
    $err_arr[]= "Sorry, your file is too large. (more than 1 mb)";
    $uploadOk = 0;
}
// Allow certain file formats
if(strtolower($imageFileType) != "jpg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpeg"
&& strtolower($imageFileType) != "gif" ) {
    $err_arr[]= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	foreach($err_arr as $err){
		echo $err.'<br>';
	}
    die("Sorry, your file was not uploaded.");

// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["u_add_m_m_lo"]["tmp_name"], $target_file)) {
        #dbupdate
		if($conn->query("INSERT INTO `mun_rec`(`mun_shortname`, `mun_year`, `mun_img_src`, `mun_fullname`, `mun_hostedat`, `mun_hosted_addr`, `mun_website`, `mun_email`, `mun_country`, `mun_lat`, `mun_long`, `mun_from`, `mun_till`, `mun_contact_no`) VALUES (
		'".$_POST['u_add_m_m_sn']."',
		'".$_POST['u_add_m_m_yr']."',
		'".$target_file."',
		'".$_POST['u_add_m_m_ln']."',
		'".$_POST['u_add_m_m_hstdat']."',
		'".$_POST['u_add_m_m_hstdadd']."',
		'".$_POST['u_add_m_m_webs']."',
		'".$_POST['u_add_m_m_eml']."',
		'".$_POST['u_add_m_m_country']."',
		'".$_POST['u_add_m_m_ins_lat']."',
		'".$_POST['u_add_m_m_ins_lng']."',
		'".$_POST['u_add_m_m_stdt']."',
		'".$_POST['u_add_m_m_endt']."',
		'".$_POST['u_add_m_m_mobs']."'		)")){
					


			
			$mun_id = $conn->insert_id;
			##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['SCHVB_USR_DB_ID'],'mun_rec','insert', "INSERT INTO `mun_rec`(`mun_shortname`, `mun_year`, `mun_img_src`, `mun_fullname`, `mun_hostedat`, `mun_hosted_addr`, `mun_website`, `mun_email`, `mun_country`, `mun_lat`, `mun_long`, `mun_from`, `mun_till`, `mun_contact_no`) VALUES (
		'".$_POST['u_add_m_m_sn']."',
		'".$_POST['u_add_m_m_yr']."',
		'".$target_file."',
		'".$_POST['u_add_m_m_ln']."',
		'".$_POST['u_add_m_m_hstdat']."',
		'".$_POST['u_add_m_m_hstdadd']."',
		'".$_POST['u_add_m_m_webs']."',
		'".$_POST['u_add_m_m_eml']."',
		'".$_POST['u_add_m_m_country']."',
		'".$_POST['u_add_m_m_ins_lat']."',
		'".$_POST['u_add_m_m_ins_lng']."',
		'".$_POST['u_add_m_m_stdt']."',
		'".$_POST['u_add_m_m_endt']."',
		'".$_POST['u_add_m_m_mobs']."'		)" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###


			$editmun = getdatafromsql($conn,"select * from mun_rec where mun_id = '".$mun_id."'");

			
			if(is_string($editmun)){
				die('Hash Not Found');
			}
			
			if($conn->query("INSERT INTO `mun_claim_requests`(`cl_rel_lum_id`, `cl_rel_mun_id`, `cl_granted`, `cl_mail_sent`, `cl_gen_time`, `cl_ip`, `cl_mun_owned`, `cl_valid`) VALUES (
			'".$_SESSION['SCHVB_USR_DB_ID']."',
			'".$mun_id."',
			'1',
			'1',
			'".time()."',
			'".$_SERVER['REMOTE_ADDR']."',
			'1',
			'1')
			
			")){
						##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['SCHVB_USR_DB_ID'],'mun_claim_requests','insert', "INSERT INTO `mun_claim_requests`(`cl_rel_lum_id`, `cl_rel_mun_id`, `cl_granted`, `cl_mail_sent`, `cl_gen_time`, `cl_ip`, `cl_mun_owned`, `cl_valid`) VALUES (
			'".$_SESSION['SCHVB_USR_DB_ID']."',
			'".$mun_id."',
			'1',
			'1',
			'".time()."',
			'".$_SERVER['REMOTE_ADDR']."',
			'1',
			'1')
			
			" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###





			}else{
				die('Your Mun Could Not be Claimed ERRMAERDTGVERDTF');
			}
			
	header('Location: mymuns.php');
		}else{
			die('ERRMAIUOHJ(jnfI)(');
		}
		
		#dbupdate
		
    } else {
        die("Sorry, there was an error uploading your file.");
    }
}

	###########3
	
	
	
	
}
##
##claim
if(isset($_POST['edit_claim'])){
	if(isset($_SESSION['SCHVB_USR_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sb_logins where lum_id = ".$_SESSION['SCHVB_USR_DB_ID']." and lum_valid = 1 and lum_ad = 1");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}
	if(isset($_POST['hash_cl_d'])){
		if(ctype_alnum(trim($_POST['hash_cl_d']))){
			$editclaim = getdatafromsql($conn,"select * from mun_claim_requests where md5(md5(sha1(sha1(md5(md5(concat(cl_id,'lkoegnuifvh bnn njenjn'))))))) = '".$_POST['hash_cl_d']."'");
			
			
			if(is_string($editclaim)){
				die('Hash Not Found');
			}
		}else{
			die('Invalid hash');
		}
	}else{
		die('Hash Not Found');
	}

	if(isset($_POST['edit_claim_mun'])){
		if(ctype_alnum(trim($_POST['edit_claim_mun']))){
			$editmun = getdatafromsql($conn,"select * from mun_rec where md5(sha1(md5(md5(concat(mun_id,'i9ujhu3birfviok3iojrwoiugueioutdrgoiuevoisur09giwjrsgiuejisxrg veoidrijgoieshrgjredf'))))) = '".$_POST['edit_claim_mun']."'");
			
			
			if(is_string($editmun)){
				die('Mun Hash Not Found');
			}
		}else{
			die('Invalid mun hash ');
		}
	}else{
		die('Mun not found');
	}

if($editclaim['cl_rel_mun_id'] == $editmun['mun_id']){
}else{
	
			$checkvalid = getdatafromsql($conn,"select * from mun_claim_requests where cl_rel_mun_id = ".$editmun['mun_id']." and cl_rel_lum_id = ".$editclaim['cl_rel_lum_id']."");
			
			
			if(is_array($checkvalid)){
				die('This Mun has already been claimed by the user');
			}
		
}


if(isset($_POST['edit_claims_cl_granted_f'])){
	if(is_numeric($_POST['edit_claims_cl_granted_f'])){
		if(($_POST['edit_claims_cl_granted_f'] == 0 ) or ($_POST['edit_claims_cl_granted_f'] == 1)){
		}else{
			die('Only 1 or 0 are allowed for granted values');
		}
	}else{
		die('Invalid Granting Value');
	}
}else{
	die('Please enter all fields');
}

if(isset($_POST['edit_claim_mlsent'])){
	if(is_numeric($_POST['edit_claim_mlsent'])){
		if(($_POST['edit_claim_mlsent'] == 0 ) or ($_POST['edit_claim_mlsent'] == 1)){
		}else{
			die('Only 1 or 0 are allowed for Mail values');
		}
	}else{
		die('Invalid Mail Value');
	}
}else{
	die('Please enter all fields (Mail)');
}

if($conn->query("update mun_claim_requests set cl_rel_mun_id = '".$editmun['mun_id']."', cl_granted = '".$_POST['edit_claims_cl_granted_f']."',cl_mail_sent = '".$_POST['edit_claim_mlsent']."' where cl_id = ".$editclaim['cl_id']."")){
			##### Insert Logs ##################################################################VV3###
		if(preplogs($editclaim,$_SESSION['SCHVB_USR_DB_ID'],'mun_claim_requests','update', "update mun_claim_requests set cl_rel_mun_id = '".$editmun['mun_id']."', cl_granted = '".$_POST['edit_claims_cl_granted_f']."',cl_mail_sent = '".$_POST['edit_claim_mlsent']."' where cl_id = ".$editclaim['cl_id']."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




	header('Location: admin_claims.php');
}else{
	die('ERRMA(#HUTGBT(I#');
}

}
#
#
if(isset($_POST['add_adm_claim'])){
	##
	if(isset($_SESSION['SCHVB_USR_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sb_logins where lum_id = ".$_SESSION['SCHVB_USR_DB_ID']." and lum_valid = 1 and lum_ad = 1");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}

	if(isset($_POST['add_claim_munid'])){
		if(ctype_alnum(trim($_POST['add_claim_munid']))){
			$editmun = getdatafromsql($conn,"select * from mun_rec where md5(md5(sha1(md5(concat(mun_id,'huihnji0uiu4uewrgv3wsrd'))))) = '".$_POST['add_claim_munid']."'");
			
			
			if(is_string($editmun)){
				die('Mun Hash Not Found');
			}
		}else{
			die('Invalid mun hash ');
		}
	}else{
		die('Mun not found');
	}
	
	
	
		if(isset($_POST['add_claim_lumid'])){
		if(ctype_alnum(trim($_POST['add_claim_lumid']))){
			$useradding = getdatafromsql($conn,"select * from sb_logins 
			where md5(md5(sha1(md5(concat(lum_id,'ekrshuihnji0uiu4uewrgv3wsrd'))))) =
			 '".$_POST['add_claim_lumid']."'");
			
			
			if(is_string($useradding)){
				die('User  Hash Not Found');
			}
		}else{
			die('Invalid User  hash ');
		}
	}else{
		die('User not Entered');
	}
	
	
	

	
			$checkvalid = getdatafromsql($conn,"select * from mun_claim_requests where cl_rel_mun_id = ".$editmun['mun_id']." and cl_rel_lum_id = ".$useradding['lum_id']."");
			
			
			if(is_array($checkvalid)){
				die('This Mun has already been claimed by the user');
			}

if(isset($_POST['add_claim_granted'])){
	if(is_numeric($_POST['add_claim_granted'])){
		if(($_POST['add_claim_granted'] == 0 ) or ($_POST['add_claim_granted'] == 1)){
		}else{
			die('Only 1 or 0 are allowed for granted values');
		}
	}else{
		die('Invalid Granting Value');
	}
}else{
	die('Please enter all fields');
}

if(isset($_POST['add_claim_mlsnt'])){
	if(is_numeric($_POST['add_claim_mlsnt'])){
		if(($_POST['add_claim_mlsnt'] == 0 ) or ($_POST['add_claim_mlsnt'] == 1)){
		}else{
			die('Only 1 or 0 are allowed for Mail values');
		}
	}else{
		die('Invalid Mail Value');
	}
}else{
	die('Please enter all fields (Mail)');
}


if(isset($_POST['add_claim_owned'])){
	if(is_numeric($_POST['add_claim_owned'])){
		if(($_POST['add_claim_owned'] == 0 ) or ($_POST['add_claim_owned'] == 1)){
		}else{
			die('Only 1 or 0 are allowed for Owned values');
		}
	}else{
		die('Invalid owned Value');
	}
}else{
	die('Please enter all fields (owner)');
}

if($conn->query("INSERT INTO `mun_claim_requests`(`cl_rel_lum_id`, `cl_rel_mun_id`, `cl_granted`, `cl_mail_sent`, `cl_gen_time`, `cl_ip`, `cl_mun_owned`) VALUES (
'".$useradding['lum_id']."',
'".$editmun['mun_id']."',
'".$_POST['add_claim_granted']."',
'".$_POST['add_claim_mlsnt']."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_POST['add_claim_owned']."'
)

")){
			##### Insert Logs ##################################################################VV3###
		if(preplogs($useradding,$_SESSION['SCHVB_USR_DB_ID'],'mun_claim_requests','insert', "INSERT INTO `mun_claim_requests`(`cl_rel_lum_id`, `cl_rel_mun_id`, `cl_granted`, `cl_mail_sent`, `cl_gen_time`, `cl_ip`, `cl_mun_owned`) VALUES (
'".$useradding['lum_id']."',
'".$editmun['mun_id']."',
'".$_POST['add_claim_granted']."',
'".$_POST['add_claim_mlsnt']."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_POST['add_claim_owned']."'
)

" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




	
	
	header('Location: admin_claims.php');
}else{
	die('ERRMATGBT(I#');
}

##
	
}
#
#
if(isset($_POST['cl_mk_inac_ha']) and isset($_POST['cl_mk_inac'])){
	if(ctype_alnum(trim($_POST['cl_mk_inac_ha']))){
		$checkit = getdatafromsql($conn,"select * from mun_claim_requests where md5(md5(sha1(sha1(md5(md5(concat(cl_id,'egkjtnr newsdnjjenfkv ijfkorkvnkorvfk')))))))= '".$_POST['cl_mk_inac_ha']."' and cl_valid =1");
		
		if(is_array($checkit)){
			if($conn->query("update mun_claim_requests set cl_valid =0 where cl_id= ".$checkit['cl_id']."")){				
		##### Insert Logs ##################################################################VV3###
		if(preplogs($checkit,$_SESSION['SCHVB_USR_DB_ID'],'mun_claim_requests','update', "update mun_claim_requests set cl_valid =0 where cl_id= ".$checkit['cl_id']."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###





								header('Location: admin_claims.php');
			}else{
				die('ERRRMAj/we/ifJOINJFWFEAO');
			}
		}else{
			die("No Claims\'s Found");
		}
	}else{
		die('Invalid Entries');
	}
}
#
if(isset($_POST['cl_mk_ac_ha']) and isset($_POST['cl_mk_ac'])){
	if(ctype_alnum(trim($_POST['cl_mk_ac_ha']))){
		$checkit = getdatafromsql($conn,"select * from mun_claim_requests where md5(md5(sha1(sha1(md5(md5(concat(cl_id,'jijnfiirjfnirokijfkorkvnkorvfk')))))))= '".$_POST['cl_mk_ac_ha']."' and cl_valid =0");
		
		if(is_array($checkit)){
			if($conn->query("update mun_claim_requests set cl_valid =1 where cl_id= ".$checkit['cl_id']."")){				
		##### Insert Logs ##################################################################VV3###
		if(preplogs($checkit,$_SESSION['SCHVB_USR_DB_ID'],'mun_claim_requests','update', "update mun_claim_requests set cl_valid =1 where cl_id= ".$checkit['cl_id']."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###





								header('Location: admin_claims.php');
			}else{
				die('ERRRMAj/we/ifskhuizbJFWFEAO');
			}
		}else{
			die("No Claims\'s Found");
		}
	}else{
		die('Invalid Entries');
	}
}
##
##
if(isset($_POST['add_instruction'])){
				 if(isset($_SESSION['SCHVB_USR_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sb_logins where lum_id = ".$_SESSION['SCHVB_USR_DB_ID']." and lum_valid = 1");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}



	
	if(isset($_POST['add_ins_topic'])){
		$topic = $_POST['add_ins_topic'];
	}else{
		die('Couldn\'t Find topic');
	}
	
	if(isset($_POST['add_inr_inst'])){
	}else{
		die('Couldn\'t Find topic\'s instructions');
	}
	
	if(isset($_POST['add_inr_inst_ico'])){
	}else{
		die('Couldn\'t Find topic\'s instruction\'s icon');
	}
	
	if(isset($_FILES['add_inr_inst_img'])){
		$topic = $_POST['add_ins_topic'];
	}else{
		die('Couldn\'t Find topic\'s instruction\'s Image');
	}
	
	
	$loopnames = array('add_inr_inst','add_inr_inst_ico','add_inr_inst_img');
	$l1ar = array();
	$l2ar = array();
	$l3ar = array();
	for($i =1;$i <31;$i++){
		if($i == 1){
			$nu = '';
		}else{
			$nu= $i;
		}
		
		if(isset($_POST[$loopnames[0].$nu])){
			$l1ar[] = $nu;
		}else{
		}
	}

	for($h =1;$h <31;$h++){
		if($h == 1){
			$nuo = '';
		}else{
			$nuo= $h;
		}
		
		if(isset($_POST[$loopnames[1].$nuo])){
			$l2ar[] = $nuo;
		}else{
		}
	}

	for($hi =1;$hi <31;$hi++){
		if($hi == 1){
			$no = '';
		}else{
			$no= $hi;
		}
		
		if(isset($_FILES[$loopnames[2].$no])){
			$l3ar[] = $no;
		}else{
		}
	}



if((count($l1ar) == count($l3ar)) and (count($l1ar) == count($l2ar)) and (count($l2ar) == count($l3ar))){
	
}else{
	die('Number of instructions and number of images and number of icons Dont Match');
}


if((count($l1ar) + count($l2ar) + count($l3ar) + 2) ==( count($_POST) + count($_FILES))){
}else{
	die('Post and topic and instructions dont match');
}



$instopic = "INSERT INTO `mun_instrcs_master`(`in_name`) VALUES ('".$_POST['add_ins_topic']."')";
#count all post and match this

if($conn->query($instopic)){
			


	$topic_id = $conn->insert_id;
	##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['SCHVB_USR_DB_ID'],'mun_instrcs_master','insert', $instopic ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###


	$counterimage = array();
	foreach ($l3ar as $indexed=>$l3i){
		if($_FILES['add_inr_inst_img'.$l3i]['name'] == ''){
			$counterimage[$indexed] = NULL;
		}else{
			####UploadingStarts
$target_dir = "img/instruction_images/";
$target_file = $target_dir .md5($_FILES['add_inr_inst_img'.$l3i]["name"].$_FILES['add_inr_inst_img'.$l3i]["tmp_name"].$_FILES['add_inr_inst_img'.$l3i]["size"]).uniqid().'_'.md5(time()).'.'. extension($_FILES['add_inr_inst_img'.$l3i]["name"]);
$uploadOk = 1;
$err_arr = array();
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["add_instruction"])) {
    $check = getimagesize($_FILES['add_inr_inst_img'.$l3i]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $err_arr[] = "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    $err_arr[] = "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES['add_inr_inst_img'.$l3i]["size"] > 1200000) {
    $err_arr[] = "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if(strtolower($imageFileType) != "jpg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpeg"
&& strtolower($imageFileType) != "gif" ) {
    $err_arr[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	foreach($err_arr as $err){
		echo $err.'<br>';
	}
    die("Sorry, your file was not uploaded.");
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES['add_inr_inst_img'.$l3i]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES['add_inr_inst_img'.$l3i]["name"]). " has been uploaded.";
		$counterimage[$indexed] = $target_file;
		
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
			
			####Uploading ends
		}
	}
	
			#l1ar
			#l2ar
			#counterimage
			
			
			$instructionmaster = array();
			
			foreach($l1ar as $ol=>$ini){
				$instructionmaster[] = array($_POST['add_inr_inst'.$ini],$_POST['add_inr_inst_ico'.$ini],$counterimage[$ol]);
$sqlo = array();			}
foreach($instructionmaster as $instg){
	if(is_null($instg[2])){
	$sqlo[] = "INSERT INTO `mun_ins_rel`(`inr_rel_in_id`, `inr_text`, `inr_image_src`, `inr_link_icon`) VALUES (
	'".$topic_id."',
		'".$instg[0]."',
			NULL,
				'".$instg[1]."'
	)";
	}else{
			$sqlo[] = "INSERT INTO `mun_ins_rel`(`inr_rel_in_id`, `inr_text`, `inr_image_src`, `inr_link_icon`) VALUES (
	'".$topic_id."',
		'".$instg[0]."',
			'".$instg[2]."',
				'".$instg[1]."'
	)";

	}
	
	
}

$errdu =array();
foreach($sqlo as $sl){
	if($conn->query($sl)){
##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['SCHVB_USR_DB_ID'],'mun_ins_rel','insert', $sl,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




		
	}else{
		$errdu[] = '1';
	}
}

if(count($errdu) == 0){
	header('Location: admin_instructions.php');
}else{
	die('ERRMAIUHGE)UI)HUIBEF');
}
}
	
}
#__ins AcInac
if(isset($_POST['in_mk_inac_ha'])){
	#hash = egkjtnr newsdnjjenfkvijfkorkvnkorvfk
	if(ctype_alnum(trim($_POST['in_mk_inac_ha']))){
		$checkit = getdatafromsql($conn,"select * from mun_instrcs_master where md5(md5(sha1(sha1(md5(md5(concat(in_id,'egkjtnr newsdnjjenfkvijfkorkvnkorvfk')))))))= '".$_POST['in_mk_inac_ha']."' and in_valid =1");
		
		if(is_array($checkit)){
			if($conn->query("update mun_instrcs_master set in_valid =0 where in_id= ".$checkit['in_id']."")){				
		##### Insert Logs ##################################################################VV3###
		if(preplogs($checkit,$_SESSION['SCHVB_USR_DB_ID'],'mun_instrcs_master','update', "update mun_instrcs_master set in_valid =0 where in_id= ".$checkit['in_id']."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###





								header('Location: admin_instructions.php');
			}else{
				die('ERRRMAjjiorefjnrhbejif');
			}
		}else{
			die("No TL Instructions Found");
		}
	}else{
		die('Invalid Entries');
	}

}
#
if(isset($_POST['in_mk_ac_ha'])){
	#jijnfiirjfnirokijfkvnkorvfk
	if(ctype_alnum(trim($_POST['in_mk_ac_ha']))){
		$checkit = getdatafromsql($conn,"select * from mun_instrcs_master where md5(md5(sha1(sha1(md5(md5(concat(in_id,'jijnfiirjfnirokijfkvnkorvfk')))))))= '".$_POST['in_mk_ac_ha']."' and in_valid =0");
		
		if(is_array($checkit)){
			if($conn->query("update mun_instrcs_master set in_valid =1 where in_id= ".$checkit['in_id']."")){				
		##### Insert Logs ##################################################################VV3###
		if(preplogs($checkit,$_SESSION['SCHVB_USR_DB_ID'],'mun_instrcs_master','update', "update mun_instrcs_master set in_valid =1 where in_id= ".$checkit['in_id']."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###





								header('Location: admin_instructions.php');
			}else{
				die('ERRRMAjorefjnrhbejif');
			}
		}else{
			die("No TL Instructions Found");
		}
	}else{
		die('Invalid Entries');
	}
}
#__inrs AcInac
if(isset($_POST['inr_mk_inac_ha'])){
	#egkjtnr newsdnjjennjwhuirb3gjwfsn23qw@$%$Tfkvijwsardvnkorvfk
	if(ctype_alnum(trim($_POST['inr_mk_inac_ha']))){
		$checkit = getdatafromsql($conn,"select * from mun_ins_rel 
		where md5(md5(sha1(sha1(md5(md5(concat(inr_id,'egkjtnr newsdnjjennjwhuirb3gjwfsn23qw@$%Tfkvijwsardvnkorvfk')))))))= 
		'".$_POST['inr_mk_inac_ha']."' and inr_valid = 1");
		
		if(is_array($checkit)){
			if($conn->query("update mun_ins_rel set inr_valid =0 where inr_id= ".$checkit['inr_id']."")){				

		##### Insert Logs ##################################################################VV3###
		if(preplogs($checkit,$_SESSION['SCHVB_USR_DB_ID'],'mun_ins_rel','update', "update mun_ins_rel set inr_valid =0 where inr_id= ".$checkit['inr_id']."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




								header('Location: admin_instructions.php');
			}else{
				die('ERRRMeusjorefjnrhbejif');
			}
		}else{
			die("No TL rel Instructions Found");
		}
	}else{
		die('Invalid Entries');
	}
}
if(isset($_POST['inr_mk_ac_ha'])){
	#jijnfiirj3woi#esrgujrvoiejs4rijfkvnkorvfk
	if(ctype_alnum(trim($_POST['inr_mk_ac_ha']))){
		$checkit = getdatafromsql($conn,"select * from mun_ins_rel 
		where md5(md5(sha1(sha1(md5(md5(concat(inr_id,'jijnfiirj3woi#esrgujrvoiejs4rijfkvnkorvfk')))))))= 
		'".$_POST['inr_mk_ac_ha']."' and inr_valid = 0");
		
		if(is_array($checkit)){
			if($conn->query("update mun_ins_rel set inr_valid =1 where inr_id= ".$checkit['inr_id']."")){				
		##### Insert Logs ##################################################################VV3###
		if(preplogs($checkit,$_SESSION['SCHVB_USR_DB_ID'],'mun_ins_rel','update', "update mun_ins_rel set inr_valid =1 where inr_id= ".$checkit['inr_id']."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###





								header('Location: admin_instructions.php');
			}else{
				die('ERRRMAwhgieuk5sgrejnrhbejif');
			}
		}else{
			die("No TL rel in Instructions Found");
		}
	}else{
		die('Invalid Entries');
	}
}
##

##
if(isset($_POST['edit_instructions'])){
	if(isset($_SESSION['SCHVB_USR_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sb_logins where lum_id = ".$_SESSION['SCHVB_USR_DB_ID']." and lum_valid = 1 and lum_ad = 1");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}
	if(isset($_POST['hash_cl_d'])){
		if(ctype_alnum(trim($_POST['hash_cl_d']))){
			$editinst = getdatafromsql($conn,"select * from mun_instrcs_master where md5(md5(sha1(sha1(md5(md5(concat(in_id,'jhoubih4wiuheuf8rhbu8ifbnn njenjn'))))))) = '".$_POST['hash_cl_d']."'");
			
			
			if(is_string($editinst)){
				die('Hash Not Found');
			}
		}else{
			die('Invalid hash');
		}
	}else{
		die('Hash Not Found');
	}

#########3Loop Hole
if(isset($_POST['edit_ins_topic'])){
		$topic = $_POST['edit_ins_topic'];
	}else{
		die('Couldn\'t Find topic');
	}
	
	if(isset($_POST['edit_inr_inst'])){
	}else{
		die('Couldn\'t Find topic\'s instructions');
	}
	
	if(isset($_POST['edit_inr_inst_ico'])){
	}else{
		die('Couldn\'t Find topic\'s instruction\'s icon');
	}
	
	if(isset($_POST['edit_inr_inst_img'])){
	}else{
		die('Couldn\'t Find topic\'s instruction\'s Image');
	}
	
	
	$loopnames = array('edit_inr_inst','edit_inr_inst_ico','edit_inr_inst_img');
	$l1ar = array();
	$l2ar = array();
	$l3ar = array();
	for($i =1;$i <31;$i++){
		if($i == 1){
			$nu = '';
		}else{
			$nu= $i;
		}
		
		if(isset($_POST[$loopnames[0].$nu])){
			$l1ar[] = $nu;
		}else{
		}
	}

	for($h =1;$h <31;$h++){
		if($h == 1){
			$nuo = '';
		}else{
			$nuo= $h;
		}
		
		if(isset($_POST[$loopnames[1].$nuo])){
			$l2ar[] = $nuo;
		}else{
		}
	}

	for($hi =1;$hi <31;$hi++){
		if($hi == 1){
			$no = '';
		}else{
			$no= $hi;
		}
		
		if(isset($_POST[$loopnames[2].$no])){
			$l3ar[] = $no;
		}else{
		}
	}




if((count($l1ar) == count($l3ar)) and (count($l1ar) == count($l2ar)) and (count($l2ar) == count($l3ar))){
	
}else{
	die('Number of instructions and number of images and number of icons Dont Match');
}

#count all post and match this


if((count($l1ar) + count($l2ar) + count($l3ar) + 3) ==( count($_POST))){
}else{
	die('Post and topic and instructions dont match');
}

$delalll = "UPDATE `mun_ins_rel`
 SET `inr_valid`= 0 WHERE 
`inr_rel_in_id`= ".$editinst['in_id']."
";

if($conn->query($delalll)){
		##### Insert Logs ##################################################################VV3###
		if(preplogs($editinst,$_SESSION['SCHVB_USR_DB_ID'],'mun_ins_rel','update', $delalll ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###





}else{
	die('ERRMAIOBRE)GIOOIEJJ)W#JF)I');
}

$instopic = "UPDATE `mun_instrcs_master`
 SET `in_name`= '".$_POST['edit_ins_topic']."' WHERE 
`in_id`= ".$editinst['in_id']."
";
#count all post and match this

if($conn->query($instopic)){
			##### Insert Logs ##################################################################VV3###
		if(preplogs($editinst,$_SESSION['SCHVB_USR_DB_ID'],'mun_instrcs_master','update', $instopic ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




	$topic_id = $editinst['in_id'];
	
			#l1ar
			#l2ar
			#counterimage
			
			
			$instructionmaster = array();
			
			foreach($l1ar as $ol=>$ini){
				$instructionmaster[] = array($_POST['edit_inr_inst'.$ini],$_POST['edit_inr_inst_ico'.$ini],$_POST['edit_inr_inst_img'.$ini]);
$sqlo = array();			}
foreach($instructionmaster as $instg){
	if(($instg[2]) == 'NULL'){
	$sqlo[] = "INSERT INTO `mun_ins_rel`(`inr_rel_in_id`, `inr_text`, `inr_image_src`, `inr_link_icon`) VALUES (
	'".$topic_id."',
		'".$instg[0]."',
			NULL,
				'".$instg[1]."'
	)";
	}else{
			$sqlo[] = "INSERT INTO `mun_ins_rel`(`inr_rel_in_id`, `inr_text`, `inr_image_src`, `inr_link_icon`) VALUES (
	'".$topic_id."',
		'".$instg[0]."',
			'".$instg[2]."',
				'".$instg[1]."'
	)";

	}
	
	
}

$errdu =array();
foreach($sqlo as $sl){
	if($conn->query($sl)){
				##### Insert Logs ##################################################################VV3###
		if(preplogs($editinst,$_SESSION['SCHVB_USR_DB_ID'],'mun_ins_rel','insert', $sl ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




		
	}else{
		$errdu[] = '1';
	}
}

if(count($errdu) == 0){
	header('Location: admin_instructions.php');
}else{
	die('ERRMwsevelksmrvlkE)UI)HUIBEF');
}
}
	
#########3

}
###
###
if(isset($_POST['acrbeo'])){
	
	if(isset($_POST['class'])){
		$class = $_POST['class'];
	}else{
		$class = NULL;
	}

	if(isset($_POST['type'])){
		$type = $_POST['type'];
	}else{
		$type = NULL;
	}

	if(isset($_POST['outer'])){
		$outer = $_POST['outer'];
	}else{
		$outer = NULL;
	}

	if(isset($_POST['page'])){
		$page = $_POST['page'];
	}else{
		$page = NULL;
	}
	
	if(isset($_POST['href'])){
		$href = $_POST['href'];
	}else{
		$href = NULL;
	}
	
	
	
	
	$sql  = "INSERT INTO `pg_click`(`href_type`, `href_linkedto`, `href_page`, `href_dnt`, `href_hash`) VALUES ('".$class."|".$outer."|".$type."','".$href."','".$page."','".time()."','".$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID']."')";
	
	if($conn->query($sql)){
		echo 'erngf';
		
	}else{
		die("ERRMAIJNOUEIHG)");
	}
	
}
###
###
if(isset($_POST['add_student'])){
if(!isset($_SESSION['SCHVB_USR_DB_ID'])){
	die('You must login to proceed');
}
	if(count($_POST) == 53){
	}else{
		die('Enter all Fields Correctly');
	}
	
	if(!isset($_POST['tut_add_st_nm']) or !isset($_POST['tut_add_st_mob']) or !isset($_POST['tut_add_st_rpm'])){
		die('Fields are missing');
	}
	
	for($dsd =0;$dsd <7;$dsd++){
if(!isset($_POST['day_'.$dsd]) or !isset($_POST['day_'.$dsd.'_time_from_hours']) or !isset($_POST['day_'.$dsd.'_time_from_minutes'])or !isset($_POST['day_'.$dsd.'_time_from_ampm'])or !isset($_POST['day_'.$dsd.'_time_to_hours'])or !isset($_POST['day_'.$dsd.'_time_to_minutes'])or !isset($_POST['day_'.$dsd.'_time_to_ampm'])){
die('Fields are missing');
}
	}
	
for($dsd =0;$dsd <7;$dsd++){
if(!is_numeric($_POST['day_'.$dsd]) or 
!is_numeric($_POST['day_'.$dsd.'_time_from_hours']) or
 !is_numeric($_POST['day_'.$dsd.'_time_from_minutes'])or 
 is_numeric($_POST['day_'.$dsd.'_time_from_ampm'])or 
 !is_numeric($_POST['day_'.$dsd.'_time_to_hours'])or 
 !is_numeric($_POST['day_'.$dsd.'_time_to_minutes'])or 
 is_numeric($_POST['day_'.$dsd.'_time_to_ampm'])){
die('Fields are missing');
}
 if(!in_range($_POST['day_'.$dsd], 0, 7, TRUE)){
	 die("Incorrect Values for Day");
 }
 if(!in_range($_POST['day_'.$dsd.'_time_from_hours'], 0, 12, true)){
	 die("Incorrect Values for from hour ");
 }
 if(!in_range($_POST['day_'.$dsd.'_time_to_hours'], 0, 12, true)){
	 die("Incorrect Values for till hour");
 }

 if(!in_range(1*$_POST['day_'.$dsd.'_time_from_minutes'], 0, 45, true)){
	 die("Incorrect Values for from minute");
 }

 if(!in_range(1*$_POST['day_'.$dsd.'_time_to_minutes'], 0, 45, true)){
	 die("Incorrect Values for till minute");
 }

	}
	
	
	if(!is_mobno(trim($_POST['tut_add_st_mob'])) or !is_numeric(trim($_POST['tut_add_st_rpm']))){
		die('Invalid Characters ');
	}
$day_monday =array();#1
$day_monday['number'] = 0;
$day_monday['time_to'] = 0;
$day_monday['time_from'] = 0;

$day_tuesday =array();#2
$day_tuesday['number'] = 0;
$day_tuesday['time_to'] = 0;
$day_tuesday['time_from'] = 0;

$day_wednesday =array();#3
$day_wednesday['number'] = 0;
$day_wednesday['time_to'] = 0;
$day_wednesday['time_from'] = 0;

$day_thursday =array();#4
$day_thursday['number'] = 0;
$day_thursday['time_to'] = 0;
$day_thursday['time_from'] = 0;

$day_friday =array();#5
$day_friday['number'] = 0;
$day_friday['time_to'] = 0;
$day_friday['time_from'] = 0;

$day_saturday =array();#6
$day_saturday['number'] = 0;
$day_saturday['time_to'] = 0;
$day_saturday['time_from'] = 0;

$day_sunday =array();#7
$day_sunday['number'] = 0;
$day_sunday['time_to'] = 0;
$day_sunday['time_from'] = 0;

		
		#$_POST['day_'.$dssd.'_time_to_hours']
		#$_POST['day_'.$dssd.'_time_to_minutes']
		#$_POST['day_'.$dssd.'_time_to_ampm']
		
for($dssd =0;$dssd <7;$dssd++){
	if($_POST['day_'.$dssd] > 0){
		if($_POST['day_'.$dssd] == 1){
			$day_monday['number']= $day_monday['number']+1;
			if(trim($_POST['day_'.$dssd.'_time_from_ampm']) == 'am'){
				if(trim($_POST['day_'.$dssd.'_time_from_hours']) == 12){
					$day_monday['time_from'] = '00'.':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}else{
					$day_monday['time_from'] = $_POST['day_'.$dssd.'_time_from_hours'].':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}
			}else if(trim($_POST['day_'.$dssd.'_time_from_ampm']) == 'pm'){
				if(trim($_POST['day_'.$dssd.'_time_from_hours']) == 12){
					$day_monday['time_from'] = '12'.':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}else{
					$day_monday['time_from'] = (12+$_POST['day_'.$dssd.'_time_from_hours']).':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}
			}else{
				die('Incorrect AM/PM for from');
			}
/* end from*/


if(trim($_POST['day_'.$dssd.'_time_to_ampm']) == 'am'){
				if(trim($_POST['day_'.$dssd.'_time_to_hours']) == 12){
					$day_monday['time_to'] = '00'.':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}else{
					$day_monday['time_to'] = $_POST['day_'.$dssd.'_time_to_hours'].':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}
			}else if(trim($_POST['day_'.$dssd.'_time_to_ampm']) == 'pm'){
				if(trim($_POST['day_'.$dssd.'_time_to_hours']) == 12){
					$day_monday['time_to'] = '12'.':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}else{
					$day_monday['time_to'] = (12+$_POST['day_'.$dssd.'_time_to_hours']).':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}
			}else{
				die('Incorrect AM/PM for till');
			}
			
$day_any = 1;
		#monday
		}else if($_POST['day_'.$dssd] == 2){
			$day_tuesday['number']= $day_tuesday['number']+1;
			if(trim($_POST['day_'.$dssd.'_time_from_ampm']) == 'am'){
				if(trim($_POST['day_'.$dssd.'_time_from_hours']) == 12){
					$day_tuesday['time_from'] = '00'.':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}else{
					$day_tuesday['time_from'] = $_POST['day_'.$dssd.'_time_from_hours'].':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}
			}else if(trim($_POST['day_'.$dssd.'_time_from_ampm']) == 'pm'){
				if(trim($_POST['day_'.$dssd.'_time_from_hours']) == 12){
					$day_tuesday['time_from'] = '12'.':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}else{
					$day_tuesday['time_from'] = (12+$_POST['day_'.$dssd.'_time_from_hours']).':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}
			}else{
				die('Incorrect AM/PM for from');
			}
/* end from*/


if(trim($_POST['day_'.$dssd.'_time_to_ampm']) == 'am'){
				if(trim($_POST['day_'.$dssd.'_time_to_hours']) == 12){
					$day_tuesday['time_to'] = '00'.':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}else{
					$day_tuesday['time_to'] = $_POST['day_'.$dssd.'_time_to_hours'].':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}
			}else if(trim($_POST['day_'.$dssd.'_time_to_ampm']) == 'pm'){
				if(trim($_POST['day_'.$dssd.'_time_to_hours']) == 12){
					$day_tuesday['time_to'] = '12'.':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}else{
					$day_tuesday['time_to'] = (12+$_POST['day_'.$dssd.'_time_to_hours']).':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}
			}else{
				die('Incorrect AM/PM for till');
			}
			
$day_any = 1;
		#tuesday
		}else if($_POST['day_'.$dssd] == 3){
			$day_wednesday['number']= $day_wednesday['number']+1;
			if(trim($_POST['day_'.$dssd.'_time_from_ampm']) == 'am'){
				if(trim($_POST['day_'.$dssd.'_time_from_hours']) == 12){
					$day_wednesday['time_from'] = '00'.':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}else{
					$day_wednesday['time_from'] = $_POST['day_'.$dssd.'_time_from_hours'].':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}
			}else if(trim($_POST['day_'.$dssd.'_time_from_ampm']) == 'pm'){
				if(trim($_POST['day_'.$dssd.'_time_from_hours']) == 12){
					$day_wednesday['time_from'] = '12'.':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}else{
					$day_wednesday['time_from'] = (12+$_POST['day_'.$dssd.'_time_from_hours']).':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}
			}else{
				die('Incorrect AM/PM for from');
			}
/* end from*/


if(trim($_POST['day_'.$dssd.'_time_to_ampm']) == 'am'){
				if(trim($_POST['day_'.$dssd.'_time_to_hours']) == 12){
					$day_wednesday['time_to'] = '00'.':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}else{
					$day_wednesday['time_to'] = $_POST['day_'.$dssd.'_time_to_hours'].':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}
			}else if(trim($_POST['day_'.$dssd.'_time_to_ampm']) == 'pm'){
				if(trim($_POST['day_'.$dssd.'_time_to_hours']) == 12){
					$day_wednesday['time_to'] = '12'.':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}else{
					$day_wednesday['time_to'] = (12+$_POST['day_'.$dssd.'_time_to_hours']).':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}
			}else{
				die('Incorrect AM/PM for till');
			}
			
$day_any = 1;
		#tuesday
		}else if($_POST['day_'.$dssd] == 4){
			$day_thursday['number']= $day_thursday['number']+1;
			if(trim($_POST['day_'.$dssd.'_time_from_ampm']) == 'am'){
				if(trim($_POST['day_'.$dssd.'_time_from_hours']) == 12){
					$day_thursday['time_from'] = '00'.':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}else{
					$day_thursday['time_from'] = $_POST['day_'.$dssd.'_time_from_hours'].':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}
			}else if(trim($_POST['day_'.$dssd.'_time_from_ampm']) == 'pm'){
				if(trim($_POST['day_'.$dssd.'_time_from_hours']) == 12){
					$day_thursday['time_from'] = '12'.':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}else{
					$day_thursday['time_from'] = (12+$_POST['day_'.$dssd.'_time_from_hours']).':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}
			}else{
				die('Incorrect AM/PM for from');
			}
/* end from*/


if(trim($_POST['day_'.$dssd.'_time_to_ampm']) == 'am'){
				if(trim($_POST['day_'.$dssd.'_time_to_hours']) == 12){
					$day_thursday['time_to'] = '00'.':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}else{
					$day_thursday['time_to'] = $_POST['day_'.$dssd.'_time_to_hours'].':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}
			}else if(trim($_POST['day_'.$dssd.'_time_to_ampm']) == 'pm'){
				if(trim($_POST['day_'.$dssd.'_time_to_hours']) == 12){
					$day_thursday['time_to'] = '12'.':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}else{
					$day_thursday['time_to'] = (12+$_POST['day_'.$dssd.'_time_to_hours']).':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}
			}else{
				die('Incorrect AM/PM for till');
			}
			
$day_any = 1;
		#tuesday
		}else if($_POST['day_'.$dssd] == 5){
			$day_friday['number']= $day_friday['number']+1;
			if(trim($_POST['day_'.$dssd.'_time_from_ampm']) == 'am'){
				if(trim($_POST['day_'.$dssd.'_time_from_hours']) == 12){
					$day_friday['time_from'] = '00'.':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}else{
					$day_friday['time_from'] = $_POST['day_'.$dssd.'_time_from_hours'].':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}
			}else if(trim($_POST['day_'.$dssd.'_time_from_ampm']) == 'pm'){
				if(trim($_POST['day_'.$dssd.'_time_from_hours']) == 12){
					$day_friday['time_from'] = '12'.':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}else{
					$day_friday['time_from'] = (12+$_POST['day_'.$dssd.'_time_from_hours']).':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}
			}else{
				die('Incorrect AM/PM for from');
			}
/* end from*/


if(trim($_POST['day_'.$dssd.'_time_to_ampm']) == 'am'){
				if(trim($_POST['day_'.$dssd.'_time_to_hours']) == 12){
					$day_friday['time_to'] = '00'.':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}else{
					$day_friday['time_to'] = $_POST['day_'.$dssd.'_time_to_hours'].':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}
			}else if(trim($_POST['day_'.$dssd.'_time_to_ampm']) == 'pm'){
				if(trim($_POST['day_'.$dssd.'_time_to_hours']) == 12){
					$day_friday['time_to'] = '12'.':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}else{
					$day_friday['time_to'] = (12+$_POST['day_'.$dssd.'_time_to_hours']).':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}
			}else{
				die('Incorrect AM/PM for till');
			}
			
$day_any = 1;
		#tuesday
		}else if($_POST['day_'.$dssd] == 6){
			$day_saturday['number']= $day_saturday['number']+1;
			if(trim($_POST['day_'.$dssd.'_time_from_ampm']) == 'am'){
				if(trim($_POST['day_'.$dssd.'_time_from_hours']) == 12){
					$day_saturday['time_from'] = '00'.':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}else{
					$day_saturday['time_from'] = $_POST['day_'.$dssd.'_time_from_hours'].':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}
			}else if(trim($_POST['day_'.$dssd.'_time_from_ampm']) == 'pm'){
				if(trim($_POST['day_'.$dssd.'_time_from_hours']) == 12){
					$day_saturday['time_from'] = '12'.':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}else{
					$day_saturday['time_from'] = (12+$_POST['day_'.$dssd.'_time_from_hours']).':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}
			}else{
				die('Incorrect AM/PM for from');
			}
/* end from*/


if(trim($_POST['day_'.$dssd.'_time_to_ampm']) == 'am'){
				if(trim($_POST['day_'.$dssd.'_time_to_hours']) == 12){
					$day_saturday['time_to'] = '00'.':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}else{
					$day_saturday['time_to'] = $_POST['day_'.$dssd.'_time_to_hours'].':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}
			}else if(trim($_POST['day_'.$dssd.'_time_to_ampm']) == 'pm'){
				if(trim($_POST['day_'.$dssd.'_time_to_hours']) == 12){
					$day_saturday['time_to'] = '12'.':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}else{
					$day_saturday['time_to'] = (12+$_POST['day_'.$dssd.'_time_to_hours']).':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}
			}else{
				die('Incorrect AM/PM for till');
			}
			
$day_any = 1;
		#tuesday
		}else if($_POST['day_'.$dssd] == 7){
			$day_sunday['number']= $day_sunday['number']+1;
			if(trim($_POST['day_'.$dssd.'_time_from_ampm']) == 'am'){
				if(trim($_POST['day_'.$dssd.'_time_from_hours']) == 12){
					$day_sunday['time_from'] = '00'.':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}else{
					$day_sunday['time_from'] = $_POST['day_'.$dssd.'_time_from_hours'].':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}
			}else if(trim($_POST['day_'.$dssd.'_time_from_ampm']) == 'pm'){
				if(trim($_POST['day_'.$dssd.'_time_from_hours']) == 12){
					$day_sunday['time_from'] = '12'.':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}else{
					$day_sunday['time_from'] = (12+$_POST['day_'.$dssd.'_time_from_hours']).':'.trim($_POST['day_'.$dssd.'_time_from_minutes']);
				}
			}else{
				die('Incorrect AM/PM for from');
			}
/* end from*/


if(trim($_POST['day_'.$dssd.'_time_to_ampm']) == 'am'){
				if(trim($_POST['day_'.$dssd.'_time_to_hours']) == 12){
					$day_sunday['time_to'] = '00'.':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}else{
					$day_sunday['time_to'] = $_POST['day_'.$dssd.'_time_to_hours'].':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}
			}else if(trim($_POST['day_'.$dssd.'_time_to_ampm']) == 'pm'){
				if(trim($_POST['day_'.$dssd.'_time_to_hours']) == 12){
					$day_sunday['time_to'] = '12'.':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}else{
					$day_sunday['time_to'] = (12+$_POST['day_'.$dssd.'_time_to_hours']).':'.trim($_POST['day_'.$dssd.'_time_to_minutes']);
				}
			}else{
				die('Incorrect AM/PM for till');
			}
			
$day_any = 1;
		#tuesday
		}
		
		
		
		
		
		
	}
}

if($day_any == 0){
	die('Select at least one day');
}
$inspsql = "INSERT INTO `tut_students`( `st_name`, `st_day_mon`, `st_day_mon_from`, `st_day_mon_till`, `st_day_tue`, `st_day_tue_from`, `st_day_tue_till`, `st_day_wed`, `st_day_wed_from`, `st_day_wed_till`, `st_day_thurs`, `st_day_thurs_from`, `st_day_thurs_till`, `st_day_fri`, `st_day_fri_from`, `st_day_fri_till`, `st_day_sat`, `st_day_sat_from`, `st_day_sat_till`, `st_day_sun`, `st_day_sun_from`, `st_day_sun_till`, `st_rel_lum_id`, `st_rpm`, `st_contactno`, `st_ip`, `st_dnt`) VALUES 
(
'".trim($_POST['tut_add_st_nm'])."',
'".$day_monday['number']."',
'".$day_monday['time_from']."',
'".$day_monday['time_to']."',
'".$day_tuesday['number']."',
'".$day_tuesday['time_from']."',
'".$day_tuesday['time_to']."',
'".$day_wednesday['number']."',
'".$day_wednesday['time_from']."',
'".$day_wednesday['time_to']."',
'".$day_thursday['number']."',
'".$day_thursday['time_from']."',
'".$day_thursday['time_to']."',
'".$day_friday['number']."',
'".$day_friday['time_from']."',
'".$day_friday['time_to']."',
'".$day_saturday['number']."',
'".$day_saturday['time_from']."',
'".$day_saturday['time_to']."',
'".$day_sunday['number']."',
'".$day_sunday['time_from']."',
'".$day_sunday['time_to']."',
'".trim($_SESSION['SCHVB_USR_DB_ID'])."',
'".trim($_POST['tut_add_st_rpm'])."',
'".trim($_POST['tut_add_st_mob'])."',
'".$_SERVER['REMOTE_ADDR']."',
'".time()."'
)";
 if($conn->query($inspsql)){
	 header('Location: user_classes.php');
 }else{
	 die($conn->error.'#ERRMA4404');
 }

}
#
#
if(isset($_POST['tuths'])){
	if(!isset($_SESSION['SCHVB_USR_DB_ID'])){
	die('You must login to proceed');
}
	
	
	if(!isset( $_POST['tuths']) or !isset($_POST['usr_class_hrs']) or !isset($_POST['usr_class_mins'])){
	header('Location: dashboard.php?sent_var_no_valid');
}

if(!ctype_alnum(strtolower(trim($_POST['tuths']))) or !is_numeric($_POST['usr_class_hrs']) or !is_numeric($_POST['usr_class_mins'])){
	die('Invalid entries');
}

if(!in_range($_POST['usr_class_hrs'],1,12,true)){
	die("Invalid Hours");
}

if(!in_range((1*$_POST['usr_class_mins']),0,45,true)){
	die("Invalid Mins");
}

	
	$chksql = "SELECT * FROM tut_students st 
where
md5(sha1(concat('sdfwssssssssasdasfasfwersnfniesssssesgwrg',md5(concat('.asdqefwesf',st.st_id))))) ='".$_POST['tuths']."'
and
st.st_rel_lum_id = ".$_SESSION['SCHVB_USR_DB_ID']." 
and
st.st_valid =1 ";

$chksqli = getdatafromsql($conn,$chksql);
if(!is_array($chksqli)){
	die("No Student found");
}

#check if no suspiscious thing is going in the DB;

$tut_hs = $_POST['tuths'];

$ip = $_SERVER['REMOTE_ADDR'];

$h = $_POST['usr_class_hrs'];

$m = trim($_POST['usr_class_mins']);

if($m == '00'){
	$m= 0.00;
}else if($m=='15'){
	$m= 0.25;
}else if($m=='30'){
	$m= 0.5;
}else {
	$m= 0.75;
}


$hr = trim( $h + $m );
$sql = "

INSERT INTO `tut_class_rec`(`cl_rel_st_id`,`cl_rel_lum_id` ,`cl_hours`, `cl_ip`,`cl_dnt`) VALUES (
'".$chksqli['st_id']."',
'".$_SESSION['SCHVB_USR_DB_ID']."',
'".$hr."',
'".$_SERVER['REMOTE_ADDR']."',
'".time()."'
)
";

if ($conn->query($sql) === TRUE) {
	header('Location: user_classes.php?cl_added');
} else {
die('#ERRL4489');}


}
##
##
if(isset($_POST['adv_st'])){
if(isset($_POST['tut_adv']) and isset($_POST['adv_st'])){
	
	$advamt = $_POST['tut_adv'];
	$tuthsh = $_POST['adv_st'];


	if(!is_numeric($advamt) or !ctype_alnum($tuthsh)){
		die("Invalid Chars");
	}

if($advamt > 999999999){
	die('Too Large Payment');
}
		$chksql = "SELECT * FROM tut_students where md5(concat(st_id,st_name)) = '".trim($tuthsh)."' and st_valid =1 and st_rel_lum_id = ".$_SESSION['SCHVB_USR_DB_ID']." ";
				
				$resultchksql =getdatafromsql($conn,$chksql);
				
				if(is_array($resultchksql)){
				}else{
					die("Invalid Student");
				}
 
 
	
	
	$sqinsert = "INSERT INTO `tut_student_payment`(`adv_rel_lum_id`,`adv_rel_st_id`, `adv_value`,`adv_dnt`,`adv_ip`) VALUES (
	'".$_SESSION['SCHVB_USR_DB_ID']."',
	'".$resultchksql['st_id']."',
	'".$advamt."',
	'".time()."',
	'".$_SERVER['REMOTE_ADDR']."'
	)";




if ($conn->query($sqinsert) === TRUE) {

	header('Location: home.php');
} else {
    echo "3Error: ";
}



}

	
}
##
##
if(isset($_POST['add_students_all'])){
	if(!isset($_POST['add_st_name1'])){
		die('add_st_name1 not found');
	}else{
		if(!is_string(trim($_POST['add_st_name1']))){
			die("Invalid add_st_name");
		}
	}
/*------------------------------------------------------*/
if(!isset($_POST['add_st_name1'])){
   die('add_st_name1 not found');
}else{
   if(!is_string(trim($_POST['add_st_name1']))){
     die("Invalid add_st_name1");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['add_st_prfpic1'])){
   die('add_st_prfpic1 not found');
}else{
   if(!is_string(trim($_POST['add_st_prfpic1']))){
     die("Invalid add_st_prfpic1");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['add_st_prfbgpc1'])){
   die('add_st_prfbgpc1 not found');
}else{
   if(!is_string(trim($_POST['add_st_prfbgpc1']))){
     die("Invalid add_st_prfbgpc1");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['add_st_school'])){
   die('add_st_school1 not found');
}else{
   if(!ctype_alnum(trim($_POST['add_st_school']))){
     die("Invalid add_st_school");
    }else{
		$schooldata = getdatafromsql($conn,"select * from schools_listed where concat(sha1(concat('irjfowioirjoi3wrjgv',sch_id)),md5(sha1(concat(md5(sch_id),'keroiojeoiroiroinvior3oiiorjb3oo onornvoj roroj 3n o3gi24j04j 039g0jv0ij 09jr0gj0j g088j g0jg03gj0838gj88rjg8rgj0 rjg0 3jg 30 jg309g093j g304gj 30rgj308r8jg038g')))) = '".trim($_POST['add_st_school'])."'");
		if(is_string($schooldata)){
			die('School Not Found in Database');
		}
	}
}
/*------------------------------------------------------*/

if(!isset($_POST['add_st_class1'])){
   die('add_st_class1 not found');
}else{
   if(!is_numeric(trim($_POST['add_st_class1']))){
     die("Invalid add_st_class1");
    }else{
		if(is_string(getdatafromsql($conn,"select * from students_classes_mapping where cls_id=".trim($_POST['add_st_class1'])))){
			die('No Class found in Database');
		}
	}
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_us_section1'])){
   die('edit_us_section1 not found');
}else{
   if(!is_string(trim($_POST['edit_us_section1']))){
     die("Invalid edit_us_section1");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['add_st_class_teacher1'])){
   die('add_st_class_teacher1 not found');
}else{
   if(!is_numeric(trim($_POST['add_st_class_teacher1']))){
     die("Invalid add_st_class_teacher1");
    }else{
		if(is_string(getdatafromsql($conn,"select * from sb_teachers where th_id=".trim($_POST['add_st_class_teacher1'])." and th_valid =1 and 
		th_rel_sch_id = ".$schooldata['sch_id']))){
			die('No Teacher found in Database');
		}
	}
}
/*------------------------------------------------------*/

if(!isset($_POST['add_st_stype1'])){
   die('add_st_stype1 not found');
}else{
   if(!is_numeric(trim($_POST['add_st_stype1']))){
     die("Invalid add_st_stype1");
    }else{
		if(is_string(getdatafromsql($conn,"select * from student_types_all where styp_id = ".trim($_POST['add_st_stype1'])))){
			die('Student type not found in database');
		}
	}
}
/*------------------------------------------------------*/

if(!isset($_POST['add_st_admno1'])){
   die('add_st_admno1 not found');
}else{
   if(!is_string(trim($_POST['add_st_admno1']))){
     die("Invalid add_st_admno1");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['add_st_dob1'])){
   die('add_st_dob1 not found');
}else{
   if(!is_string(trim($_POST['add_st_dob1']))){
     die("Invalid add_st_dob1");
    }else{
		if(strtotime($_POST['add_st_dob1'])== true){
		}else{
			die("Invalid Date");
		}
	}
}
/*------------------------------------------------------*/

if(!isset($_POST['add_st_gender1'])){
   die('add_st_gender1 not found');
}else{
   if(is_string(trim($_POST['add_st_gender1']))){
	   if(trim($_POST['add_st_gender1']) == "M"){
	   }else if(trim($_POST['add_st_gender1']) == "F"){
	   }else if(trim($_POST['add_st_gender1']) == "Oth"){
	   }else{
		   die("Invalid add_st_gender1");
	   }
   }else{
		   die("Invalid add_st_gender1-2");
	   }
	}
/*------------------------------------------------------*/

if(!isset($_POST['add_st_house1'])){
   die('add_st_house1 not found');
}else{
   if(!is_string(trim($_POST['add_st_house1']))){
     die("Invalid add_st_house1");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['add_st_father_name1'])){
   die('add_st_father_name1 not found');
}else{
   if(!is_string(trim($_POST['add_st_father_name1']))){
     die("Invalid add_st_father_name1");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['add_st_mother_name1'])){
   die('add_st_mother_name1 not found');
}else{
   if(!is_string(trim($_POST['add_st_mother_name1']))){
     die("Invalid add_st_mother_name1");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['add_st_father_contc1'])){
   die('add_st_father_contc1 not found');
}else{
   if(!is_numeric(trim($_POST['add_st_father_contc1'])) or (strlen($_POST['add_st_father_contc1'])!=10)){
     die("Invalid add_st_father_contc1");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['add_st_mother_contc1'])){
   die('add_st_mother_contc1 not found');
}else{
   if(!is_numeric(trim($_POST['add_st_mother_contc1'])) or (strlen($_POST['add_st_mother_contc1'])!=10)){
     die("Invalid add_st_mother_contc1");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['add_st_father_email1'])){
   die('add_st_father_email1 not found');
}else{
   if(!is_email(trim($_POST['add_st_father_email1']))){
     die("Invalid add_st_father_email1");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['add_st_mother_email1'])){
   die('add_st_mother_email1 not found');
}else{
   if(!is_email(trim($_POST['add_st_mother_email1']))){
     die("Invalid add_st_mother_email1");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['add_st_address1'])){
   die('add_st_address1 not found');
}else{
   if(!is_string(trim($_POST['add_st_address1']))){
     die("Invalid add_st_address1");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['add_st_father_profession1'])){
   die('add_st_father_profession1 not found');
}else{
   if(!is_string(trim($_POST['add_st_father_profession1']))){
     die("Invalid add_st_father_profession1");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['add_st_mother_profession1'])){
   die('add_st_mother_profession1 not found');
}else{
   if(!is_string(trim($_POST['add_st_mother_profession1']))){
     die("Invalid add_st_mother_profession1");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['add_st_left_school1'])){
   die('add_st_left_school1 not found');
}else{
   if(!is_numeric(trim($_POST['add_st_left_school1'])) or !in_range($_POST['add_st_left_school1'],0,1,true)){
     die("Invalid add_st_left_school1");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['formval'])){
   die('formval not found');
}else{
   if(!is_string(trim($_POST['formval']))){
     die("Invalid formval");
    }
	$formval = $_POST['formval'];
}
/*------------------------------------------------------*/

if(!isset($_POST['add_st_father_sms_ok1'])){
   die('add_st_father_sms_ok1 not found');
}else{
   if(!is_numeric(trim($_POST['add_st_father_sms_ok1'])) or !in_range($_POST['add_st_father_sms_ok1'],0,1,true)){
     die("Invalid add_st_father_sms_ok1");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['add_st_mother_sms_ok1'])){
   die('add_st_mother_sms_ok1 not found');
}else{
   if(!is_numeric(trim($_POST['add_st_mother_sms_ok1'])) or !in_range($_POST['add_st_mother_sms_ok1'],0,1,true)){
     die("Invalid add_st_mother_sms_ok1");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['add_st_father_email_ok1'])){
   die('add_st_father_email_ok1 not found');
}else{
   if(!is_numeric(trim($_POST['add_st_father_email_ok1'])) or !in_range($_POST['add_st_father_email_ok1'],0,1,true)){
     die("Invalid add_st_father_email_ok1");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['add_st_mother_email_ok1'])){
   die('add_st_mother_email_ok1 not found');
}else{
   if(!is_numeric(trim($_POST['add_st_mother_email_ok1'])) or !in_range($_POST['add_st_mother_email_ok1'],0,1,true)){
     die("Invalid add_st_mother_email_ok1");
    }
}
/*------------------------------------------------------*/

$ins_qu="

INSERT INTO `students_parents_info_rc`(`st_rel_sch_id`, `st_rel_cls_id`, `st_rel_th_id`, `st_rel_styp_id`, `st_prof_pic`, `st_back_pic`, `st_cls_section`, `st_adm_no`, `st_name`, `st_dob`, `st_gender`, `st_house`, `st_father_name`, `st_mother_name`, `st_father_contact_no`, `st_mother_contact_no`, `st_father_email`, `st_mother_email`, `st_address`, `st_father_profession`, `st_mother_profession`, `st_mother_sms_ok`, `st_father_sms_ok`, `st_mother_email_ok`, `st_father_email_ok`, `st_left_school`, `st_added_dnt`, `st_added_ip`) VALUES (

'".$schooldata['sch_id']."',
'".$_POST['add_st_class1']."',
'".$_POST['add_st_class_teacher1']."',
'".$_POST['add_st_stype1']."',
'".$_POST['add_st_prfpic1']."',
'".$_POST['add_st_prfbgpc1']."',
'".$_POST['edit_us_section1']."',

'".$_POST['add_st_admno1']."',
'".$_POST['add_st_name1']."',

'".strtotime($_POST['add_st_dob1'])."',
'".$_POST['add_st_gender1']."',
'".$_POST['add_st_house1']."',
'".$_POST['add_st_father_name1']."',
'".$_POST['add_st_mother_name1']."',
'".$_POST['add_st_father_contc1']."',
'".$_POST['add_st_mother_contc1']."',

'".$_POST['add_st_father_email1']."',
'".$_POST['add_st_mother_email1']."',
'".$_POST['add_st_address1']."',
'".$_POST['add_st_father_profession1']."',
'".$_POST['add_st_mother_profession1']."',

'".$_POST['add_st_mother_sms_ok1']."',
'".$_POST['add_st_father_sms_ok1']."',
'".$_POST['add_st_mother_email_ok1']."',
'".$_POST['add_st_father_email_ok1']."',
'".$_POST['add_st_left_school1']."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."')
";
if($conn->query($ins_qu)){
	header("Location: admin_stu_logins.php?sti=".md5(sha1($schooldata['sch_id'].'HGYURBVFRBRGWIOGRU92UWHFGOIWHTOGIUEO8HG384IWGOIRHWGIUHREJFGKN')));
}else{
	die("#ErrorMAINSSTDT");
}
}
##--------------------------------------------------------------------------------------///------------------------------
##
if(isset($_POST['edit_st_user'])){
	if(!isset($_POST['edit_st_name'])){
		die('edit_st_name not found');
	}else{
		if(!is_string(trim($_POST['edit_st_name']))){
			die("Invalid edit_st_name");
		}
	}
/*------------------------------------------------------*/
if(!isset($_POST['edit_st_name'])){
   die('edit_st_name not found');
}else{
   if(!is_string(trim($_POST['edit_st_name']))){
     die("Invalid edit_st_name");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_st_prfpic'])){
   die('edit_st_prfpic not found');
}else{
   if(!is_string(trim($_POST['edit_st_prfpic']))){
     die("Invalid edit_st_prfpic");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_st_prfbgpc'])){
   die('edit_st_prfbgpc not found');
}else{
   if(!is_string(trim($_POST['edit_st_prfbgpc']))){
     die("Invalid edit_st_prfbgpc");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['st_hash'])){
   die('st_hash not found');
}else{
   if(!ctype_alnum(trim($_POST['st_hash']))){
     die("Invalid st_hash");
    }else{
		$student_data = getdatafromsql($conn,"select * from students_parents_info_rc where md5(md5(sha1(sha1(md5(md5(concat(st_db_id,'f2frbgbeeafs 2fgtegrfr3gbter 24rfgr324frgtr3f 3gr32fgr32f4gr'))))))) = '".trim($_POST['st_hash'])."' and st_valid=1");
		if(is_string($student_data)){
			die('Student Not Found in Database');
		}
	}
}
/*------------------------------------------------------*/
/*------------------------------------------------------*/

if(!isset($_POST['edit_st_school'])){
   die('edit_st_school not found');
}else{
   if(!ctype_alnum(trim($_POST['edit_st_school']))){
     die("Invalid edit_st_school");
    }else{
		$schooldata = getdatafromsql($conn,"select * from schools_listed where sch_id = '".trim($_POST['edit_st_school'])."'");
		if(is_string($schooldata)){
			die('School Not Found in Database');
		}
	}
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_st_class'])){
   die('edit_st_class not found');
}else{
   if(!is_numeric(trim($_POST['edit_st_class']))){
     die("Invalid edit_st_class");
    }else{
		if(is_string(getdatafromsql($conn,"select * from students_classes_mapping where cls_id=".trim($_POST['edit_st_class'])))){
			die('No Class found in Database');
		}
	}
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_st_section'])){
   die('edit_st_section not found');
}else{
   if(!is_string(trim($_POST['edit_st_section']))){
     die("Invalid edit_st_section");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_st_class_teacher'])){
   die('edit_st_class_teacher not found');
}else{
   if(!is_numeric(trim($_POST['edit_st_class_teacher']))){
     die("Invalid edit_st_class_teacher");
    }else{
		if(is_string(getdatafromsql($conn,"select * from sb_teachers where th_id=".trim($_POST['edit_st_class_teacher'])." and th_valid =1 and 
		th_rel_sch_id = ".$schooldata['sch_id']))){
			die('No Teacher found in Database');
		}
	}
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_st_stype'])){
   die('edit_st_stype not found');
}else{
   if(!is_numeric(trim($_POST['edit_st_stype']))){
     die("Invalid edit_st_stype");
    }else{
		if(is_string(getdatafromsql($conn,"select * from student_types_all where styp_id = ".trim($_POST['edit_st_stype'])))){
			die('Student type not found in database');
		}
	}
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_st_admno'])){
   die('edit_st_admno not found');
}else{
   if(!is_string(trim($_POST['edit_st_admno']))){
     die("Invalid edit_st_admno");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_st_dob'])){
   die('edit_st_dob not found');
}else{
   if(!is_string(trim($_POST['edit_st_dob']))){
     die("Invalid edit_st_dob");
    }else{
		if(strtotime($_POST['edit_st_dob'])==true){
		}else{
			die("Invalid Date");
		}
	}
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_st_gender'])){
   die('edit_st_gender not found');
}else{
   if(is_string(trim($_POST['edit_st_gender']))){
	   if(trim($_POST['edit_st_gender']) == "M"){
	   }else if(trim($_POST['edit_st_gender']) == "F"){
	   }else if(trim($_POST['edit_st_gender']) == "Oth"){
	   }else{
		   die("Invalid edit_st_gender");
	   }
   }else{
		   die("Invalid edit_st_gender-2");
	   }
	}
/*------------------------------------------------------*/

if(!isset($_POST['edit_st_hous'])){
   die('edit_st_hous not found');
}else{
   if(!is_string(trim($_POST['edit_st_hous']))){
     die("Invalid edit_st_hous");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_st_father_name'])){
   die('edit_st_father_name not found');
}else{
   if(!is_string(trim($_POST['edit_st_father_name']))){
     die("Invalid edit_st_father_name");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_st_mother_name'])){
   die('edit_st_mother_name not found');
}else{
   if(!is_string(trim($_POST['edit_st_mother_name']))){
     die("Invalid edit_st_mother_name");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_st_father_contc'])){
   die('edit_st_father_contc not found');
}else{
   if(!is_numeric(trim($_POST['edit_st_father_contc'])) or (strlen($_POST['edit_st_father_contc'])!=10)){
     die("Invalid edit_st_father_contc");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_st_mother_contc'])){
   die('edit_st_mother_contc not found');
}else{
   if(!is_numeric(trim($_POST['edit_st_mother_contc'])) or (strlen($_POST['edit_st_mother_contc'])!=10)){
     die("Invalid edit_st_mother_contc");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_st_father_email'])){
   die('edit_st_father_email not found');
}else{
   if(!is_email(trim($_POST['edit_st_father_email']))){
     die("Invalid edit_st_father_email");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_st_mother_email'])){
   die('edit_st_mother_email not found');
}else{
   if(!is_email(trim($_POST['edit_st_mother_email']))){
     die("Invalid edit_st_mother_email");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_st_address'])){
   die('edit_st_address not found');
}else{
   if(!is_string(trim($_POST['edit_st_address']))){
     die("Invalid edit_st_address");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_st_father_profession'])){
   die('edit_st_father_profession not found');
}else{
   if(!is_string(trim($_POST['edit_st_father_profession']))){
     die("Invalid edit_st_father_profession");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_st_mother_profession'])){
   die('edit_st_mother_profession not found');
}else{
   if(!is_string(trim($_POST['edit_st_mother_profession']))){
     die("Invalid edit_st_mother_profession");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_st_left_school'])){
   die('edit_st_left_school not found');
}else{
   if(!is_numeric(trim($_POST['edit_st_left_school'])) or !in_range($_POST['edit_st_left_school'],0,1,true)){
     die("Invalid edit_st_left_school");
    }
}
/*------------------------------------------------------*/


if(!isset($_POST['edit_st_father_sms_ok'])){
   die('edit_st_father_sms_ok not found');
}else{
   if(!is_numeric(trim($_POST['edit_st_father_sms_ok'])) or !in_range($_POST['edit_st_father_sms_ok'],0,1,true)){
     die("Invalid edit_st_father_sms_ok");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_st_mother_sms_ok'])){
   die('edit_st_mother_sms_ok not found');
}else{
   if(!is_numeric(trim($_POST['edit_st_mother_sms_ok'])) or !in_range($_POST['edit_st_mother_sms_ok'],0,1,true)){
     die("Invalid edit_st_mother_sms_ok");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_st_father_email_ok'])){
   die('edit_st_father_email_ok not found');
}else{
   if(!is_numeric(trim($_POST['edit_st_father_email_ok'])) or !in_range($_POST['edit_st_father_email_ok'],0,1,true)){
     die("Invalid edit_st_father_email_ok");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_st_mother_email_ok'])){
   die('edit_st_mother_email_ok not found');
}else{
   if(!is_numeric(trim($_POST['edit_st_mother_email_ok'])) or !in_range($_POST['edit_st_mother_email_ok'],0,1,true)){
     die("Invalid edit_st_mother_email_ok");
    }
}
/*------------------------------------------------------*/
$ins_qu="

UPDATE `students_parents_info_rc` SET 
`st_rel_sch_id`='".$schooldata['sch_id']."',
`st_rel_cls_id`='".$_POST['edit_st_class']."',

`st_rel_th_id`='".$_POST['edit_st_class_teacher']."',
`st_rel_styp_id`='".$_POST['edit_st_stype']."',
`st_prof_pic`='".$_POST['edit_st_prfpic']."',
`st_back_pic`='".$_POST['edit_st_prfbgpc']."',
`st_cls_section`='".$_POST['edit_st_section']."',
`st_adm_no`='".$_POST['edit_st_admno']."',
`st_name`='".$_POST['edit_st_name']."',
`st_dob`='".strtotime($_POST['edit_st_dob'])."',
`st_gender`='".$_POST['edit_st_gender']."',
`st_house`='".$_POST['edit_st_hous']."',
`st_father_name`='".$_POST['edit_st_father_name']."',
`st_mother_name`='".$_POST['edit_st_mother_name']."',
`st_father_contact_no`='".$_POST['edit_st_father_contc']."',
`st_mother_contact_no`='".$_POST['edit_st_mother_contc']."',
`st_father_email`='".$_POST['edit_st_father_email']."',
`st_mother_email`='".$_POST['edit_st_mother_email']."',
`st_address`='".$_POST['edit_st_address']."',
`st_father_profession`='".$_POST['edit_st_father_profession']."',
`st_mother_profession`='".$_POST['edit_st_mother_profession']."',
`st_mother_sms_ok`='".$_POST['edit_st_mother_sms_ok']."',
`st_father_sms_ok`='".$_POST['edit_st_father_sms_ok']."',
`st_mother_email_ok`='".$_POST['edit_st_mother_email_ok']."',
`st_father_email_ok`='".$_POST['edit_st_father_email_ok']."',
`st_left_school`='".$_POST['edit_st_left_school']."'

WHERE `st_db_id` = ".$student_data['st_db_id']."";


if(isset($_POST['edit_us_pw']) and trim($_POST['edit_us_pw']) !== '-'){
	if($student_data['st_rel_lum_id'] > 0){
		$lum = getdatafromsql($conn,'select * from sb_logins where lum_id = '.$student_data['st_rel_lum_id']);
		if(is_string($lum)){
		die('No Login Found');
		}
		$pw = md5(md5(sha1($_POST['edit_us_pw'])));
		$hash = gen_hash($pw,trim($_POST['edit_st_admno']));
		
		
		$upasql = "UPDATE `sb_logins` SET `lum_email`='".trim($_POST['edit_st_admno'])."', `lum_password`='".trim($pw)."',`lum_hash_mix`='".trim($hash)."' WHERE lum_id = ".$student_data['st_rel_lum_id'];			
		
		if($conn->query($upasql)){
		}else{
		die('ErrorUpdating Password');
		}
	}
}




if($conn->query($ins_qu)){
	header("Location: admin_stu_logins.php?sti=".md5(sha1($schooldata['sch_id'].'HGYURBVFRBRGWIOGRU92UWHFGOIWHTOGIUEO8HG384IWGOIRHWGIUHREJFGKN')));
}else{
	die("#ErrorMAINSSTDT".$conn->error);
}
}
##
##----login students
if(isset($_POST['actv_login_onesstu']) and isset($_POST['actv_login_onesstu_h'])){
	$h_c = trim($_POST['actv_login_onesstu_h']);
	if(!ctype_alnum($h_c)){
		die('Invalid hash');
	}
	$sql="select * from students_parents_info_rc where md5(md5(sha1(sha1(md5(md5(concat(st_db_id,'hir39efnewsfejirjeofkvjrjdnjjenfkvkijonreij3nj')))))))=
	'".$h_c."' and st_valid =1";
	$st_data= getdatafromsql($conn,$sql);
	if(is_array($st_data)){
		if($st_data['st_rel_lum_id'] ==0){
			#there is no previous login
							$email = $st_data['st_adm_no'];
							$pw_raw = $st_data['st_rel_sch_id'].uniqid().rand(1,40);
							$pw = md5(md5(sha1($pw_raw)));
							
							
							
							$usr =  md5(sha1('rrsger'.$st_data['st_rel_sch_id'].$st_data['st_adm_no'].time().rand(100000,999999)));
							
							$hash = gen_hash($pw,$email);
							#pass and email and secret md5(sha1())
							$lum_det = array('sch_id'=>$st_data['st_rel_sch_id'],
							'tu_id'=>3,
							'email'=>$st_data['st_adm_no'],
							'username'=>$usr,
							'pw'=>$pw,
							'hashmix'=>$hash,
							'pass_def'=>$pw_raw);
							
							$sqla = "
							INSERT INTO `sb_logins`(`lum_rel_sch_id`,`lum_rel_tu_id`,`lum_email`, `lum_username`, `lum_password`, `lum_hash_mix`,`lum_pass_def`) VALUES (
							'".$lum_det['sch_id']."',
							'".$lum_det['tu_id']."',
							'".$lum_det['email']."',
							'".$lum_det['username']."',
							'".$lum_det['pw']."',
							'".$lum_det['hashmix']."',
							'".$lum_det['pass_def']."'
							)
							";
							
							if($conn->query($sqla)){
							$lastid= $conn->insert_id;
							$updsql = "UPDATE `students_parents_info_rc` SET `st_rel_lum_id`= ".$lastid." where st_db_id = ".$st_data['st_db_id']." and st_valid =1";
							}else{
							die('Error Creating Login');
							}
							
							
							
		}else{
			##there is prev login
			$updsql = "update sb_logins set lum_valid=1 where lum_id = ".$st_data['st_rel_lum_id'];

		}
		
		
		if($conn->query($updsql)){
	header("Location: admin_stu_logins.php?sti=".md5(sha1($st_data['st_rel_sch_id'].'HGYURBVFRBRGWIOGRU92UWHFGOIWHTOGIUEO8HG384IWGOIRHWGIUHREJFGKN')));
		}else{
			die('Failed to Activate Login');
		}
	}else{
		die("Invalid Student");
	}
}
##----
if(isset($_POST['act_login_all_h']) and isset($_POST['act_login_all'])){
	if(!ctype_alnum($_POST['act_login_all_h'])){
		die('Invalid Hash');
	}
	$h=trim($_POST['act_login_all_h']);
$school_data = getdatafromsql($conn,"select * from schools_listed where md5(sha1(concat(sch_id,'eiugnioer30948t 4wuLJGRT.'))) = '".$h."'");
if(is_array($school_data)){
}else{
	die('No school Found');
}
	$sql = "SELECT * from students_parents_info_rc where st_valid=1 and st_rel_sch_id=".$school_data['sch_id'];
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		// output data of each row
		while($st_data = $result->fetch_assoc()) {
			/* /*****************************************************************************************************************************/
	if(1==1){
		if($st_data['st_rel_lum_id'] ==0){
			#there is no previous login
							$email = $st_data['st_adm_no'];
							$pw_raw = $st_data['st_rel_sch_id'].uniqid().rand(1,40);
							$pw = md5(md5(sha1($pw_raw)));
							
							
							
							$usr =  md5(sha1('rrsger'.$st_data['st_rel_sch_id'].$st_data['st_adm_no'].time().rand(100000,999999)));
							
							$hash = gen_hash($pw,$email);
							#pass and email and secret md5(sha1())
							$lum_det = array('sch_id'=>$st_data['st_rel_sch_id'],
							'tu_id'=>3,
							'email'=>$st_data['st_adm_no'],
							'username'=>$usr,
							'pw'=>$pw,
							'hashmix'=>$hash,
							'pass_def'=>$pw_raw);
							
							$sqla = "
							INSERT INTO `sb_logins`(`lum_rel_sch_id`,`lum_rel_tu_id`,`lum_email`, `lum_username`, `lum_password`, `lum_hash_mix`,`lum_pass_def`) VALUES (
							'".$lum_det['sch_id']."',
							'".$lum_det['tu_id']."',
							'".$lum_det['email']."',
							'".$lum_det['username']."',
							'".$lum_det['pw']."',
							'".$lum_det['hashmix']."',
							'".$lum_det['pass_def']."'
							)
							";
							
							if($conn->query($sqla)){
							$lastid= $conn->insert_id;
							$updsql = "UPDATE `students_parents_info_rc` SET `st_rel_lum_id`= ".$lastid." where st_db_id = ".$st_data['st_db_id']." and st_valid =1";
							}else{
							die('Error Creating Login');
							}
							
							
							
		}else{
			##there is prev login
			
			
			$updsql = "update sb_logins set lum_valid=1 where lum_id = ".$st_data['st_rel_lum_id'];

		}
		
		
		if($conn->query($updsql)){
	
		}else{
			die('Failed to Activate Login');
		}
	}else{
		die("Invalid Student");
	}
			/********************************************************************************************************************************/
		}
	} else {
		die('No Students found');
	}
header("Location: admin_stu_logins.php?sti=".md5(sha1($school_data['sch_id'].'HGYURBVFRBRGWIOGRU92UWHFGOIWHTOGIUEO8HG384IWGOIRHWGIUHREJFGKN')));
}
##
##--REM
if(isset($_POST['deactv_login_onesstu']) and isset($_POST['deactv_login_onesstu_h'])){
	$h_c = trim($_POST['deactv_login_onesstu_h']);
	if(!ctype_alnum($h_c)){
		die('Invalid hash');
	}
	$sql="select * from students_parents_info_rc where md5(md5(sha1(sha1(md5(md5(concat(st_db_id,'hir39efnewsfejirjeofkvj...rjdnjjenfkvkijonreij3nj')))))))=
	'".$h_c."' and st_valid =1";
	$st_data= getdatafromsql($conn,$sql);
	if(is_array($st_data)){
		if($st_data['st_rel_lum_id'] ==0){
	header("Location: admin_stu_logins.php?sti=".md5(sha1($st_data['st_rel_sch_id'].'HGYURBVFRBRGWIOGRU92UWHFGOIWHTOGIUEO8HG384IWGOIRHWGIUHREJFGKN')));
		die();
		}else{
			##there is prev login
			$updsql = "update sb_logins set lum_valid=0 where lum_id = ".$st_data['st_rel_lum_id'];

		}
		
		
		if($conn->query($updsql)){
	header("Location: admin_stu_logins.php?sti=".md5(sha1($st_data['st_rel_sch_id'].'HGYURBVFRBRGWIOGRU92UWHFGOIWHTOGIUEO8HG384IWGOIRHWGIUHREJFGKN')));
		}else{
			die('Failed to DeActivate Login');
		}
	}else{
		die("Invalid Student");
	}
}
##REMALL
##----
if(isset($_POST['deact_login_all_h']) and isset($_POST['deact_login_all'])){
	if(!ctype_alnum($_POST['deact_login_all_h'])){
		die('Invalid Hash');
	}
	$h=trim($_POST['deact_login_all_h']);
$school_data = getdatafromsql($conn,"select * from schools_listed where md5(sha1(concat(sch_id,'eiuersgergnioer.30948t 4wuLJGRT.'))) = '".$h."'");
if(is_array($school_data)){
}else{
	die('No school Found');
}
	$sql = "SELECT * from students_parents_info_rc where st_valid=1 and st_rel_sch_id=".$school_data['sch_id'];
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		// output data of each row
		while($st_data = $result->fetch_assoc()) {
			/* /*****************************************************************************************************************************/
	if(1==1){
		if($st_data['st_rel_lum_id'] ==0){
			#there is no previous login
	header("Location: admin_stu_logins.php?sti=".md5(sha1($st_data['st_rel_sch_id'].'HGYURBVFRBRGWIOGRU92UWHFGOIWHTOGIUEO8HG384IWGOIRHWGIUHREJFGKN')));
			die();				
		}else{
			##there is prev login
			
			
			$updsql = "update sb_logins set lum_valid=0 where lum_id = ".$st_data['st_rel_lum_id'];

		}
		
		
		if($conn->query($updsql)){
	
		}else{
			die('Failed to Activate Login');
		}
	}else{
		die("Invalid Student");
	}
			/********************************************************************************************************************************/
		}
	} else {
		die('No Students found');
	}
header("Location: admin_stu_logins.php?sti=".md5(sha1($school_data['sch_id'].'HGYURBVFRBRGWIOGRU92UWHFGOIWHTOGIUEO8HG384IWGOIRHWGIUHREJFGKN')));
}
####----login students ends

##
if(isset($_POST['school_add'])){
	if(!isset($_POST['add_school_name'])){
		die('School Name Not found');
	}
	if(!isset($_POST['add_school_shortname'])){
		die('School S-Name Not found');
	}
	if(!isset($_POST['add_school_address'])){
		die('School Address Not found');
	}
	if(!isset($_POST['add_school_pincode'])){
		die('School Pincode Not found');
	}else{
		if(!is_numeric($_POST['add_school_pincode'])){
			die('Invalid Pincode');
		}
	}
	if(!isset($_POST['add_school_city'])){
		die('School City Not found');
	}
	if(!isset($_POST['add_school_approxstu'])){
		die('School Stus Not found');
	}else{
		if(!is_numeric($_POST['add_school_approxstu'])){
			die('Invalid Students');
		}
	}
	if(!isset($_POST['add_school_clstill'])){
		die('School Class Till Not found');
	}else{
		if(!is_numeric($_POST['add_school_clstill']) and in_range($_POST['add_school_clstill'],0,12,true)){
			die('Invalid Class');
		}
	}
	if(!isset($_POST['add_school_avgfee'])){
		die('School Fee Not found');
	}else{
		if(!is_numeric($_POST['add_school_avgfee'])){
			die('Invalid Average Fee');
		}
	}
	if(!isset($_POST['add_school_contact'])){
		die('School Contact Not found');
	}else{
		if(!is_numeric($_POST['add_school_contact'])){
			die('Invalid Contact');
		}
	}
	if(!isset($_POST['add_school_email'])){
		die('School Email Not found');
	}else{
		if(!is_email($_POST['add_school_email'])){
			die('Invalid Email');
		}
	}
	
	
	$ins_q= "INSERT INTO `schools_listed`(`sch_name`, `sch_pincode`, `sch_city`, `sch_shortname`, `sch_address`, `sch_approx_stus`, `sch_class_till`, `sch_charge_per_student_per_month`, `sch_contact_no`, `sch_email`, `sch_added_dnt`, `sch_added_ip`) VALUES (
	'".$_POST['add_school_name']."',
	'".$_POST['add_school_pincode']."',
	'".$_POST['add_school_city']."',
	'".$_POST['add_school_shortname']."',
	'".$_POST['add_school_address']."',
	'".$_POST['add_school_approxstu']."',
	'".$_POST['add_school_clstill']."',
	'".$_POST['add_school_avgfee']."',
	'".$_POST['add_school_contact']."',
	'".$_POST['add_school_email']."',
	'".time()."',
	'".$_SERVER['REMOTE_ADDR']."'
	
	)";
	
	if($conn->query($ins_q)){
		header('Location: admin_schools.php');
		die();
	}else{
		die('Error Inserting School');
	}
	
}
#
#
if(isset($_POST['edit_schools'])){

	if(isset($_POST['hash_school_i'])){
		if(!ctype_alnum(trim($_POST['hash_school_i']))){
			die('Invalid Hash');
		}else{
			$checkschool=getdatafromsql($conn,"select * from schools_listed where md5(md5(sha1(sha1(md5(md5(concat(sch_id,'lkoegnuifvh bnn njenjnerjfioejgior .ekrjgvv'))))))) = '".$_POST['hash_school_i']."'");
			
			if(is_array($checkschool)){
			}else{
				die("Invalid School");
			}
		}
	}else{
		die('Hash Not Found');
	}
/* -------------------*/
	if(isset($_POST['edit_school_shrtnme'])){
		if(!is_string(trim($_POST['edit_school_shrtnme']))){
			die('Invalid edit_school_shrtnme');
		}
	}else{
		die('edit_school_shrtnme Not Found');
	}
/* -------------------*/
	if(isset($_POST['edit_school_address'])){
		if(!is_string(trim($_POST['edit_school_address']))){
			die('Invalid edit_school_address');
		}
	}else{
		die('edit_school_address Not Found');
	}
/* -------------------*/
	if(isset($_POST['edit_school_lngnme'])){
		if(!is_string(trim($_POST['edit_school_lngnme']))){
			die('Invalid edit_school_lngnme');
		}
	}else{
		die('edit_school_lngnme Not Found');
	}
/* -------------------*/
	if(isset($_POST['edit_school_lngnme'])){
		if(!is_string(trim($_POST['edit_school_lngnme']))){
			die('Invalid edit_school_lngnme');
		}
	}else{
		die('edit_school_lngnme Not Found');
	}
/* -------------------*/
	if(isset($_POST['edit_school_pincode'])){
		if(!is_numeric(trim($_POST['edit_school_pincode']))){
			die('Invalid edit_school_pincode');
		}
	}else{
		die('edit_school_pincode Not Found');
	}
/* -------------------*/
	if(isset($_POST['edit_school_city'])){
		if(!is_string(trim($_POST['edit_school_city']))){
			die('Invalid edit_school_city');
		}
	}else{
		die('edit_school_city Not Found');
	}
/* -------------------*/
	if(isset($_POST['edit_school_approx_stu'])){
		if(!is_numeric(trim($_POST['edit_school_approx_stu']))){
			die('Invalid edit_school_approx_stu');
		}
	}else{
		die('edit_school_approx_stu Not Found');
	}
/* -------------------*/
	if(isset($_POST['edit_school_avg_fee'])){
		if(!is_numeric(trim($_POST['edit_school_avg_fee']))){
			die('Invalid edit_school_avg_fee');
		}
	}else{
		die('edit_school_avg_fee Not Found');
	}
/* -------------------*/
	if(isset($_POST['edit_school_cls_till'])){
	if(!is_numeric(trim($_POST['edit_school_cls_till'])) or !in_range($_POST['edit_school_cls_till'],0,12,true)){
			die('Invalid edit_school_cls_till');
		}
	}else{
		die('edit_school_cls_till Not Found');
	}
/* -------------------*/
	if(isset($_POST['edit_school_contact_no'])){
		if(!is_numeric(trim($_POST['edit_school_contact_no'])) or (strlen($_POST['edit_school_contact_no'])>13)){
			die('Invalid edit_school_contact_no');
		}
	}else{
		die('edit_school_contact_no Not Found');
	}
/* -------------------*/
	if(isset($_POST['edit_school_email'])){
		if(!is_email(trim($_POST['edit_school_email']))){
			die('Invalid edit_school_email');
		}
	}else{
		die('edit_school_email Not Found');
	}
	
	$upd_q = "UPDATE `schools_listed` SET 
	`sch_name`='".$_POST['edit_school_lngnme']."',
	`sch_pincode`='".$_POST['edit_school_pincode']."',
	`sch_city`='".$_POST['edit_school_city']."',
	`sch_shortname`='".$_POST['edit_school_shrtnme']."',
	`sch_address`='".$_POST['edit_school_address']."',
	`sch_approx_stus`='".$_POST['edit_school_approx_stu']."',
	`sch_class_till`='".$_POST['edit_school_cls_till']."',
	`sch_charge_per_student_per_month`='".$_POST['edit_school_avg_fee']."',
	`sch_contact_no`='".$_POST['edit_school_contact_no']."',
	`sch_email`='".$_POST['edit_school_email']."'
 WHERE sch_id = ".$checkschool['sch_id'];

if($conn->query($upd_q)){
	header('Location: admin_schools.php');
}else{
	die("Couldn't Update, Contact administrator");
}
	
}
#
#
if(isset($_POST['hash_school_a']) and isset($_POST['school_act'])){
	if(ctype_alnum(trim($_POST['hash_school_a']))){
		$checkit = getdatafromsql($conn,"select * from schools_listed where md5(md5(sha1(sha1(md5(md5(concat(sch_id,'njhifverkof2njbjhwf.wf.wejwgfiuwrg.ivjwj bfurhib2jw'))))))) = '".$_POST['hash_school_a']."' and sch_valid =0");
		
		if(is_array($checkit)){
			if($conn->query("update schools_listed set sch_valid =1 where sch_id= ".$checkit['sch_id']."")){
								header('Location: admin_schools.php');
			}else{
				die('ERRRMA!rfeiuhdiuferugdNJFO');
			}
		}else{
			die("No School Found");
		}
	}else{
		die('Invalid Entry');
	}
}
#
#
if(isset($_POST['hash_school_ina']) and isset($_POST['school_inact'])){
	if(ctype_alnum(trim($_POST['hash_school_ina']))){
		$checkit = getdatafromsql($conn,"select * from schools_listed where 
		md5(md5(sha1(sha1(md5(md5(concat(sch_id,'hbujeio03ir94urghnje.eg.erf.wrg.rg.wgfr 309i4wef'))))))) = '".$_POST['hash_school_ina']."' and sch_valid =1");
		
		if(is_array($checkit)){
			if($conn->query("update schools_listed set sch_valid =0 where sch_id= ".$checkit['sch_id']."")){				
								header('Location: admin_schools.php');
			}else{
				die('ERRRkjrifJOINJFWFEAO');
			}
		}else{
			die("No School Found");
		}
	}else{
		die('Invalid Entries');
	}
}
####
####

/*------------------------------------------------------------------------------------------------------*/
if(isset($_POST['add_teacher'])){
	
	
		if(!isset($_POST['add_th_name'])){
		die('add_th_name not found');
	}else{
		if(!is_string(trim($_POST['add_th_name']))){
			die("Invalid add_th_name");
		}
	}
/*------------------------------------------------------*/

if(!isset($_POST['add_th_prof_pic'])){
   die('add_th_prof_pic not found');
}else{
   if(!is_string(trim($_POST['add_th_prof_pic']))){
     die("Invalid add_th_prof_pic");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['add_th_back_pic'])){
   die('add_th_back_pic not found');
}else{
   if(!is_string(trim($_POST['add_th_back_pic']))){
     die("Invalid add_th_back_pic");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['add_th_school'])){
   die('add_th_school not found');
}else{
   if(!ctype_alnum(trim($_POST['add_th_school']))){
     die("Invalid add_th_school");
    }else{
		$schooldata = getdatafromsql($conn,"select * from schools_listed where concat(sha1(concat('irjfowioirjoi3wrjgv',sch_id)),md5(sha1(concat(md5(sch_id),'jjriurjfwiugwiuf jwrrwiuurfnwiurvnwiurvn')))) =
		 '".trim($_POST['add_th_school'])."'");
		if(is_string($schooldata)){
			die('School Not Found in Database');
		}
	}
}
/*------------------------------------------------------*/

if(!isset($_POST['add_th_class_teach'])){
   die('add_th_class_teach not found');
}else{
   if(!is_string(trim($_POST['add_th_class_teach']))){
     die("Invalid add_th_class_teach");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['add_th_subject'])){
   die('add_th_subject not found');
}else{
   if(!is_string(trim($_POST['add_th_subject']))){
     die("Invalid add_th_subject");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['add_th_dob'])){
   die('add_th_dob not found');
}else{
   if(!is_string(trim($_POST['add_th_dob']))){
     die("Invalid add_th_dob");
    }else{
		if(strtotime($_POST['add_th_dob'])==true){
		}else{
			die("Invalid Date");
		}
	}
}
/*------------------------------------------------------*/

if(!isset($_POST['add_th_gender'])){
   die('add_th_gender not found');
}else{
   if(is_string(trim($_POST['add_th_gender']))){
	   if(trim($_POST['add_th_gender']) == "M"){
	   }else if(trim($_POST['add_th_gender']) == "F"){
	   }else if(trim($_POST['add_th_gender']) == "Oth"){
	   }else{
		   die("Invalid add_th_gender");
	   }
   }else{
		   die("Invalid add_th_gender-2");
	   }
	}

/*------------------------------------------------------*/

if(!isset($_POST['add_th_contact'])){
   die('add_th_contact not found');
}else{
   if(!is_numeric(trim($_POST['add_th_contact'])) or (strlen($_POST['add_th_contact'])!=10)){
     die("Invalid add_th_contact");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['add_th_email'])){
   die('add_th_email not found');
}else{
   if(!is_email(trim($_POST['add_th_email']))){
     die("Invalid add_th_email");
    }
}
	


$ins_qu="


INSERT INTO `sb_teachers`(`th_rel_sch_id`, `th_prof_pic`, `th_back_pic`, `th_teach_class`, `th_gender`, `th_subject`, `th_name`, `th_dob`, `th_contact_no`, `th_email`, `th_added_dnt`, `th_added_ip`) VALUES (

'".$schooldata['sch_id']."',
'".$_POST['add_th_prof_pic']."',
'".$_POST['add_th_back_pic']."',
'".$_POST['add_th_class_teach']."',
'".$_POST['add_th_gender']."',
'".$_POST['add_th_subject']."',
'".$_POST['add_th_name']."',
'".strtotime($_POST['add_th_dob'])."',
'".$_POST['add_th_contact']."',
'".$_POST['add_th_email']."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."')
";
echo $ins_qu;
if($conn->query($ins_qu)){
	header("Location: admin_teach_logins.php?sti=".md5(sha1($schooldata['sch_id'].'HGYURfij2490,,BVFRBRGWIOGRU92UWHFGOIWHTOGIUEO8HG384IWGOIRHWGIUHREJFGKN')));
}else{
	die($conn->error."#ErrorMAINSSTDT");
	}
}
#####
######
if(isset($_POST['edit_th_user'])){
	if(!isset($_POST['edit_th_name'])){
		die('edit_th_name not found');
	}else{
		if(!is_string(trim($_POST['edit_th_name']))){
			die("Invalid edit_th_name");
		}
	}
/*------------------------------------------------------*/

if(!isset($_POST['edit_th_prof_pic'])){
   die('edit_th_prof_pic not found');
}else{
   if(!is_string(trim($_POST['edit_th_prof_pic']))){
     die("Invalid edit_th_prof_pic");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_th_back_pic'])){
   die('edit_th_back_pic not found');
}else{
   if(!is_string(trim($_POST['edit_th_back_pic']))){
     die("Invalid edit_th_back_pic");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['th_hash'])){
   die('st_hash not found');
}else{
   if(!ctype_alnum(trim($_POST['th_hash']))){
     die("Invalid st_hash");
    }else{
		$th_data = getdatafromsql($conn,"select * from sb_teachers where md5(md5(sha1(sha1(md5(md5(concat(th_id,'f2frbgbter 24rfgr324frgtr3f 3gr32fgr32f4gr'))))))) = '".trim($_POST['th_hash'])."' and th_valid=1");
		if(is_string($th_data)){
			die('Student Not Found in Database');
		}
	}
}
/*------------------------------------------------------*/
/*------------------------------------------------------*/

if(!isset($_POST['edit_th_school'])){
   die('edit_th_school not found');
}else{
   if(!ctype_alnum(trim($_POST['edit_th_school']))){
     die("Invalid edit_th_school");
    }else{
		$schooldata = getdatafromsql($conn,"select * from schools_listed where sch_id = '".trim($_POST['edit_th_school'])."'");
		if(is_string($schooldata)){
			die('School Not Found in Database');
		}
	}
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_th_subject'])){
   die('edit_th_subject not found');
}else{
   if(!is_string(trim($_POST['edit_th_subject']))){
     die("Invalid edit_th_subject");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_th_teach_class'])){
   die('edit_th_teach_class not found');
}else{
   if(!is_string(trim($_POST['edit_th_teach_class']))){
     die("Invalid edit_th_teach_class");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_th_dob'])){
   die('edit_th_dob not found');
}else{
   if(!is_string(trim($_POST['edit_th_dob']))){
     die("Invalid edit_th_dob");
    }else{
		if(strtotime($_POST['edit_th_dob'])== true){
		}else{
			die("Invalid Date");
		}
	}
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_th_gender'])){
   die('edit_th_gender not found');
}else{
   if(is_string(trim($_POST['edit_th_gender']))){
	   if(trim($_POST['edit_th_gender']) == "M"){
	   }else if(trim($_POST['edit_th_gender']) == "F"){
	   }else if(trim($_POST['edit_th_gender']) == "Oth"){
	   }else{
		   die("Invalid edit_th_gender");
	   }
   }else{
		   die("Invalid edit_th_gender-2");
	   }
	}
/*------------------------------------------------------*/

if(!isset($_POST['edit_th_contact_no'])){
   die('edit_th_contact_no not found');
}else{
   if(!is_numeric(trim($_POST['edit_th_contact_no'])) or (strlen($_POST['edit_th_contact_no'])!=10)){
     die("Invalid edit_th_contact_no");
    }
}
/*------------------------------------------------------*/

if(!isset($_POST['edit_th_email'])){
   die('edit_th_email not found');
}else{
   if(!is_email(trim($_POST['edit_th_email']))){
     die("Invalid edit_th_email");
    }
}
/*------------------------------------------------------*/
	
$ins_qu="

UPDATE `sb_teachers` SET 
`th_rel_sch_id`='".$schooldata['sch_id']."',

`th_prof_pic`='".$_POST['edit_th_prof_pic']."',
`th_back_pic`='".$_POST['edit_th_back_pic']."',

`th_name`='".$_POST['edit_th_name']."',
`th_dob`='".strtotime($_POST['edit_th_dob'])."',
`th_gender`='".$_POST['edit_th_gender']."',

`th_teach_class`='".$_POST['edit_th_teach_class']."',
`th_subject`='".$_POST['edit_th_subject']."',

`th_contact_no`='".$_POST['edit_th_contact_no']."',
`th_email`='".$_POST['edit_th_email']."'


WHERE `th_id` = ".$th_data['th_id']."";

if(trim($_POST['edit_th_password']) !== '-'){
	if($th_data['th_rel_lum_id'] > 0){
		$lum = getdatafromsql($conn,'select * from sb_logins where lum_id = '.$th_data['th_rel_lum_id']);
		if(is_string($lum)){
		die('No Login Found');
		}
		$pw = md5(md5(sha1($_POST['edit_th_password'])));
		$hash = gen_hash($pw,trim($_POST['edit_th_email']));
		
		
		$upasql = "UPDATE `sb_logins` SET `lum_email`='".trim($_POST['edit_th_email'])."', `lum_password`='".trim($pw)."',`lum_hash_mix`='".trim($hash)."' WHERE lum_id = ".$th_data['th_rel_lum_id'];			
		
		if($conn->query($upasql)){
		}else{
		die('ErrorUpdating Password');
		}
	}
}



if($conn->query($ins_qu)){
header("Location: admin_teach_logins.php?sti=".md5(sha1($schooldata['sch_id'].'HGYURfij2490,,BVFRBRGWIOGRU92UWHFGOIWHTOGIUEO8HG384IWGOIRHWGIUHREJFGKN')));
}else{
	die("#ErrorMAINSSTDT".$conn->error);
}
}
##----login teachers
if(isset($_POST['actv_login_onesteach']) and isset($_POST['actv_login_oneteach_h'])){
	$h_c = trim($_POST['actv_login_oneteach_h']);
	if(!ctype_alnum($h_c)){
		die('Invalid hash');
	}
	$sql="select * from sb_teachers where md5(md5(sha1(sha1(md5(md5(concat(th_id,'hir39efnewsfejirjeokjd.fkvkijonreij3nj')))))))=
	'".$h_c."' and th_valid =1";
	$st_data= getdatafromsql($conn,$sql);
	if(is_array($st_data)){
		if($st_data['th_rel_lum_id'] ==0){
			#there is no previous login
							$email = $st_data['th_email'];
							$pw_raw = $st_data['th_rel_sch_id'].uniqid().rand(1,40);
							$pw = md5(md5(sha1($pw_raw)));
							
							
							
							$usr =  md5(sha1('rrsger'.$st_data['th_rel_sch_id'].$st_data['th_name'].time().rand(100000,999999)));
							
							$hash = gen_hash($pw,$email);
							#pass and email and secret md5(sha1())
							$lum_det = array('sch_id'=>$st_data['th_rel_sch_id'],
							'tu_id'=>2,
							'email'=>$st_data['th_email'],
							'username'=>$usr,
							'pw'=>$pw,
							'hashmix'=>$hash,
							'pass_def'=>$pw_raw);
							
							$sqla = "
							INSERT INTO `sb_logins`(`lum_rel_sch_id`,`lum_rel_tu_id`,`lum_email`, `lum_username`, `lum_password`, `lum_hash_mix`,`lum_pass_def`) VALUES (
							'".$lum_det['sch_id']."',
							'".$lum_det['tu_id']."',
							'".$lum_det['email']."',
							'".$lum_det['username']."',
							'".$lum_det['pw']."',
							'".$lum_det['hashmix']."',
							'".$lum_det['pass_def']."'
							)
							";
							
							if($conn->query($sqla)){
							$lastid= $conn->insert_id;
							$updsql = "UPDATE `sb_teachers` SET `th_rel_lum_id`= ".$lastid." where th_id = ".$st_data['th_id']." and th_valid =1";
							}else{
							die('Error Creating Login');
							}
							
							
							
		}else{
			##there is prev login
			$updsql = "update sb_logins set lum_valid=1 where lum_id = ".$st_data['th_rel_lum_id'];

		}
		
		
		if($conn->query($updsql)){
header("Location: admin_teach_logins.php?sti=".md5(sha1($st_data['th_rel_sch_id'].'HGYURfij2490,,BVFRBRGWIOGRU92UWHFGOIWHTOGIUEO8HG384IWGOIRHWGIUHREJFGKN')));
		}else{
			die('Failed to Activate Login');
		}
	}else{
		die("Invalid Student");
	}
}
##----
if(isset($_POST['act_login_all_th_h']) and isset($_POST['act_login_all_th'])){
	if(!ctype_alnum($_POST['act_login_all_th_h'])){
		die('Invalid Hash');
	}
	$h=trim($_POST['act_login_all_th_h']);
$school_data = getdatafromsql($conn,"select * from schools_listed where md5(sha1(concat(sch_id,'eiugnioer30948t kjrsgGRT.'))) = '".$h."'");
if(is_array($school_data)){
}else{
	die('No school Found');
}
	$sql = "SELECT * from sb_teachers  where th_valid=1 and th_rel_sch_id=".$school_data['sch_id'];
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		// output data of each row
		while($st_data = $result->fetch_assoc()) {
			/* /*****************************************************************************************************************************/
	if(1==1){
		if($st_data['th_rel_lum_id'] ==0){
			#there is no previous login
							$email = $st_data['th_email'];
							$pw_raw = $st_data['th_rel_sch_id'].uniqid().rand(1,40);
							$pw = md5(md5(sha1($pw_raw)));
							
							
							
							$usr =  md5(sha1('rrsger'.$st_data['th_rel_sch_id'].$st_data['th_name'].time().rand(100000,999999)));
							
							$hash = gen_hash($pw,$email);
							#pass and email and secret md5(sha1())
							$lum_det = array('sch_id'=>$st_data['th_rel_sch_id'],
							'tu_id'=>2,
							'email'=>$st_data['th_email'],
							'username'=>$usr,
							'pw'=>$pw,
							'hashmix'=>$hash,
							'pass_def'=>$pw_raw);
							
							$sqla = "
							INSERT INTO `sb_logins`(`lum_rel_sch_id`,`lum_rel_tu_id`,`lum_email`, `lum_username`, `lum_password`, `lum_hash_mix`,`lum_pass_def`) VALUES (
							'".$lum_det['sch_id']."',
							'".$lum_det['tu_id']."',
							'".$lum_det['email']."',
							'".$lum_det['username']."',
							'".$lum_det['pw']."',
							'".$lum_det['hashmix']."',
							'".$lum_det['pass_def']."'
							)
							";
							
							if($conn->query($sqla)){
							$lastid= $conn->insert_id;
							$updsql = "UPDATE `sb_teachers` SET `th_rel_lum_id`= ".$lastid." where th_id = ".$st_data['th_id']." and th_valid =1";
							}else{
							die('Error Creating Login');
							}
							
							
							
		}else{
			##there is prev login
			
			
			$updsql = "update sb_logins set lum_valid=1 where lum_id = ".$st_data['th_rel_lum_id'];

		}
		
		
		if($conn->query($updsql)){
	
		}else{
			die('Failed to Activate Login');
		}
	}else{
		die("Invalid Student");
	}
			/********************************************************************************************************************************/
		}
	} else {
		die('No Students found');
	}
header("Location: admin_teach_logins.php?sti=".md5(sha1($school_data['sch_id'].'HGYURfij2490,,BVFRBRGWIOGRU92UWHFGOIWHTOGIUEO8HG384IWGOIRHWGIUHREJFGKN')));
}
##
##--REM
if(isset($_POST['deactv_login_onesteach']) and isset($_POST['deactv_login_oneteach_h'])){
	$h_c = trim($_POST['deactv_login_oneteach_h']);
	if(!ctype_alnum($h_c)){
		die('Invalid hash');
	}
	$sql="select * from sb_teachers where md5(md5(sha1(sha1(md5(md5(concat(th_id,'hir39efnewjmvj...rjdnjjenfkkjsrgnkjrgsnvkijonreij3nj')))))))=
	'".$h_c."' and th_valid =1";
	$st_data= getdatafromsql($conn,$sql);
	if(is_array($st_data)){
		if($st_data['th_rel_lum_id'] ==0){
header("Location: admin_teach_logins.php?sti=".md5(sha1($st_data['th_rel_sch_id'].'HGYURfij2490,,BVFRBRGWIOGRU92UWHFGOIWHTOGIUEO8HG384IWGOIRHWGIUHREJFGKN')));
		die();
		}else{
			##there is prev login
			$updsql = "update sb_logins set lum_valid=0 where lum_id = ".$st_data['th_rel_lum_id'];

		}
		
		
		if($conn->query($updsql)){
header("Location: admin_teach_logins.php?sti=".md5(sha1($st_data['th_rel_sch_id'].'HGYURfij2490,,BVFRBRGWIOGRU92UWHFGOIWHTOGIUEO8HG384IWGOIRHWGIUHREJFGKN')));
		}else{
			die('Failed to DeActivate Login');
		}
	}else{
		die("Invalid Teacher");
	}
}
##REMALL
##----
if(isset($_POST['deact_login_all_th_h']) and isset($_POST['deact_login_all_th'])){
	if(!ctype_alnum($_POST['deact_login_all_th_h'])){
		die('Invalid Hash');
	}
	$h=trim($_POST['deact_login_all_th_h']);
$school_data = getdatafromsql($conn,"select * from schools_listed where md5(sha1(concat(sch_id,'eiuersgergnkjh;;,.48t 4wuLJGRT.'))) = '".$h."'");
if(is_array($school_data)){
}else{
	die('No school Found');
}
	$sql = "SELECT * from sb_teachers where th_valid=1 and th_rel_sch_id=".$school_data['sch_id'];
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		// output data of each row
		while($st_data = $result->fetch_assoc()) {
			/* /*****************************************************************************************************************************/
	if(1==1){
		if($st_data['th_rel_lum_id'] ==0){
			#there is no previous login
header("Location: admin_teach_logins.php?sti=".md5(sha1($st_data['th_rel_sch_id'].'HGYURfij2490,,BVFRBRGWIOGRU92UWHFGOIWHTOGIUEO8HG384IWGOIRHWGIUHREJFGKN')));
			die();				
		}else{
			##there is prev login
			
			
			$updsql = "update sb_logins set lum_valid=0 where lum_id = ".$st_data['th_rel_lum_id'];

		}
		
		
		if($conn->query($updsql)){
	
		}else{
			die('Failed to DeActivate Login');
		}
	}else{
		die("Invalid Student");
	}
			/********************************************************************************************************************************/
		}
	} else {
		die('No Students found');
	}
header("Location: admin_teach_logins.php?sti=".md5(sha1($school_data['sch_id'].'HGYURfij2490,,BVFRBRGWIOGRU92UWHFGOIWHTOGIUEO8HG384IWGOIRHWGIUHREJFGKN')));
}
####----login teachers ends
#
if(isset($_POST['student_edit_user'])){
	if(!isset($_POST['student_st_hash'])){
		die('Hash Not found');
	}else{
		if(!ctype_alnum(trim($_POST['student_st_hash']))){
			die('Invalid hash');
		}
	}
	if(!isset($_POST['student_edit_name'])){
		die('student_edit_name Not found');
	}else{
		if(!is_string(trim($_POST['student_edit_name']))){
			die('Invalid student_edit_name');
		}
	}

	if(!isset($_POST['student_edit_st_mother_profession'])){
		die('student_edit_st_mother_profession Not found');
	}else{
		if(!is_string(trim($_POST['student_edit_st_mother_profession']))){
			die('Invalid student_edit_st_mother_profession');
		}
	}

	if(!isset($_POST['student_edit_st_father_profession'])){
		die('student_edit_st_father_profession Not found');
	}else{
		if(!is_string(trim($_POST['student_edit_st_father_profession']))){
			die('Invalid student_edit_st_father_profession');
		}
	}

	if(!isset($_POST['student_edit_st_address'])){
		die('student_edit_st_address Not found');
	}else{
		if(!is_string(trim($_POST['student_edit_st_address']))){
			die('Invalid student_edit_st_address');
		}
	}

	if(!isset($_POST['student_edit_st_father_contc'])){
		die('student_edit_st_father_contc Not found');
	}else{
		if(!is_mobno(trim($_POST['student_edit_st_father_contc']))){
			die('Invalid student_edit_st_father_contc');
		}
	}

	if(!isset($_POST['student_edit_st_mother_contc'])){
		die('student_edit_st_mother_contc Not found');
	}else{
		if(!is_mobno(trim($_POST['student_edit_st_mother_contc']))){
			die('Invalid student_edit_st_mother_contc');
		}
	}

	if(!isset($_POST['student_edit_st_mother_email'])){
		die('student_edit_st_mother_email Not found');
	}else{
		if(!is_email(trim($_POST['student_edit_st_mother_email']))){
			die('Invalid student_edit_st_mother_email');
		}
	}

	if(!isset($_POST['student_edit_st_father_email'])){
		die('student_edit_st_father_email Not found');
	}else{
		if(!is_email(trim($_POST['student_edit_st_father_email']))){
			die('Invalid student_edit_st_father_email');
		}
	}

	if(!isset($_POST['student_edit_st_mother_name'])){
		die('student_edit_st_mother_name Not found');
	}else{
		if(!is_string(trim($_POST['student_edit_st_mother_name']))){
			die('Invalid student_edit_st_mother_name');
		}
	}

	if(!isset($_POST['student_edit_st_father_name'])){
		die('student_edit_st_father_name Not found');
	}else{
		if(!is_string(trim($_POST['student_edit_st_father_name']))){
			die('Invalid student_edit_st_father_name');
		}
	}
$getdatus = "select * from students_parents_info_rc s left join sb_logins l on s.st_rel_lum_id = l.lum_id 
where s.st_valid =1 and l.lum_valid =1 and s.st_left_school = 0 and l.lum_id = ".$_SESSION['SCHVB_USR_DB_ID'];
$getdatus = getdatafromsql($conn,$getdatus);

if(is_string($getdatus)){
	die('User Not Found');
}

$userdet = array('st_name'=>$_POST['student_edit_name'],
'st_father_profession'=>$_POST['student_edit_st_father_profession'],
'st_mother_profession'=>$_POST['student_edit_st_mother_profession'],
'st_address'=>$_POST['student_edit_st_address'],
'st_father_contact_no'=>$_POST['student_edit_st_father_contc'],
'st_mother_contact_no'=>$_POST['student_edit_st_mother_contc'],
'st_mother_email'=>$_POST['student_edit_st_mother_email'],
'st_father_email'=>$_POST['student_edit_st_father_email'],
'st_mother_name'=>$_POST['student_edit_st_mother_name'],
'st_father_name'=>$_POST['student_edit_st_father_name']);

$userdet_json = $conn->escape_string(json_encode($userdet));
$insql = "INSERT INTO `student_info_change_request`(`sicr_rel_tu_id`, `sicr_rel_sch_id`, `sicr_db_id`, `sicr_data`, `sicr_dnt`, `sicr_ip`) VALUES 
(
'".$_SESSION['SCHVB_USR_TU_ID']."',
'".$_SESSION['SCHVB_USR_SCH_ID']."',
'".$getdatus['st_db_id']."',
'".$userdet_json."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."'
)";

if($conn->query($insql)){
	header('Location: myca.php?rqssisid='.md5(time()));
}else{
	die('Could not send request');
}

}
#
if(isset($_POST['teacher_edit_user'])){
	if(!isset($_POST['teacher_change_hash'])){
		die('Hash Not found');
	}else{
		if(!ctype_alnum(trim($_POST['teacher_change_hash']))){
			die('Invalid hash');
		}
	}
	if(!isset($_POST['teacher_edit_th_name'])){
		die('teacher_edit_th_name Not found');
	}else{
		if(!is_string(trim($_POST['teacher_edit_th_name']))){
			die('Invalid teacher_edit_th_name');
		}
	}

	if(!isset($_POST['teacher_edit_th_subject'])){
		die('teacher_edit_th_subject Not found');
	}else{
		if(!is_string(trim($_POST['teacher_edit_th_subject']))){
			die('Invalid teacher_edit_th_subject');
		}
	}

	if(!isset($_POST['teacher_edit_th_teach_class'])){
		die('teacher_edit_th_teach_class Not found');
	}else{
		if(!is_string(trim($_POST['teacher_edit_th_teach_class']))){
			die('Invalid teacher_edit_th_teach_class');
		}
	}

	if(!isset($_POST['teacher_edit_th_contact_no'])){
		die('teacher_edit_th_contact_no Not found');
	}else{
		if(!is_mobno(trim($_POST['teacher_edit_th_contact_no']))){
			die('Invalid teacher_edit_th_contact_no');
		}
	}

$getdatus = "select * from sb_teachers s left join sb_logins l on s.th_rel_lum_id = l.lum_id 
where s.th_valid =1 and l.lum_valid =1 and l.lum_id = ".$_SESSION['SCHVB_USR_DB_ID'];
$getdatus = getdatafromsql($conn,$getdatus);
if(is_string($getdatus)){
	die('User Not Found');
}

$userdet = array('th_name'=>$_POST['teacher_edit_th_name'],
'th_subject'=>$_POST['teacher_edit_th_subject'],
'th_teach_class'=>$_POST['teacher_edit_th_teach_class'],
'th_contact_no'=>$_POST['teacher_edit_th_contact_no']);

$userdet_json = $conn->escape_string(json_encode($userdet));
$insql = "INSERT INTO `student_info_change_request`(`sicr_rel_tu_id`, `sicr_rel_sch_id`, `sicr_db_id`, `sicr_data`, `sicr_dnt`, `sicr_ip`) VALUES 
(
'".$_SESSION['SCHVB_USR_TU_ID']."',
'".$_SESSION['SCHVB_USR_SCH_ID']."',
'".$getdatus['th_id']."',
'".$userdet_json."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."'
)";

if($conn->query($insql)){
	header('Location: myca.php?rqssisid='.md5(time()));
}else{
	die('Could not send request');
}

}
var_dump($_POST);

?>








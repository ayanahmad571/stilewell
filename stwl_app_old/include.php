<?php 
  session_start();

	 
include ("db_auth_base.php");
foreach($_POST as $key=>$v){


	if(!is_array($_POST[$key])){
		if($key == 'invo_cl_addr'){
			$_POST[$key] = trim(($conn->escape_string($v)));
		}else{
		 $_POST[$key] = trim(strip_tags($conn->escape_string($v)));
		}
	}
	else if (is_array($_POST[$key])){
		foreach($_POST[$key] as $ke=>$vv){
		 $_POST[$key][$ke] = trim(strip_tags($conn->escape_string($vv)));
		}
	}


}




if (array_search('', $_POST) !== false){ die('Don\'t enter Blank Values');
}

if(basename($_SERVER['PHP_SELF']) !== 'login_action.php'){

if($_SESSION['SW_VALIDTILL'] == 0){
}else{
	if($_SESSION['SW_VALIDTILL'] < time()){
		session_destroy();
		die('Session timed out');
	}
}
}

function give_brand(){
	echo '<!-- brand -->
            <div class="logo">
                <a href="#" class="logo-expanded">
                    <i class=" ion-home"></i>
                    <span class="nav-label">StileWell</span>
                </a>
            </div>
            <!-- / brand -->';
}


		function get_modules($conn){
		##
		
		





####
		
		
		
		
		
		
		
		
		
		
		
			$sql = "SELECT * FROM `sw_modules` WHERE `mo_min_level`<=".$_SESSION['SW_U_ACCESS']." and mo_valid =1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	echo '<!-- Navbar Start -->
            <nav class="navigation">
                <ul class="list-unstyled">';
    while($row = $result->fetch_assoc()) {
		
		
		if($row['mo_sub_mod'] == 1){
			
			$actcswl = "SELECT * FROM `sw_submod` WHERE `sub_mo_rel_mo_id`= ".$row['mo_id']." and sub_valid=1 and sub_href='".trim(basename($_SERVER['PHP_SELF']))."'";
$act_res = $conn->query($actcswl);

if ($act_res->num_rows == 1) {
	$active_c = 'active';
	}else{
		$active_c = '';
	}
	
			if( $active_c == 'active' ){
		echo '
		<li class=" has-submen active"><a href="#"><i class="'.$row['mo_icon'].'"></i> <span class="nav-label">'.$row['mo_name'].'</span></a>
		
		';
			
		}else{
		echo '
		<li class=" has-submen"><a href="'.$row['mo_href'].'"><i class="'.$row['mo_icon'].'"></i> <span class="nav-label">'.$row['mo_name'].'</span></a>
		';
			
		}
    
	
	
	
	
	
	
	
	echo '<ul class="list-unstyled">
			';
			
			
			$submod = "SELECT * FROM `sw_submod` where sub_valid = 1 and sub_mo_rel_mo_id='".$row['mo_id']."'";
$subres = $conn->query($submod);

if ($subres->num_rows > 0) {
    // output data of each row
    while($subrow = $subres->fetch_assoc()) { 
	
	if( trim(basename($_SERVER['PHP_SELF'])) == trim(basename($subrow['sub_href'])) ){
echo '
	<li class="active"><a href="'.$subrow['sub_href'].'">'.$subrow['sub_name'].'</a></li>
	';
	
				
		}else{
echo  '
	<li class=""><a href="'.$subrow['sub_href'].'">'.$subrow['sub_name'].'</a></li>
	';			
		}
	
	
	
	
	}
}else{
}
			
		
			 
			 
			 
			 
			 
			 echo '</ul>';


echo '</li>';


###
	
			}else{
			
			
  if( trim(basename($_SERVER['PHP_SELF'])) == trim(basename($row['mo_href'])) ){
	  
		echo '
<li class="active"><a href="#"><i class="'.$row['mo_icon'].'"></i> <span class="nav-label">'.$row['mo_name'].'</span></a></li>';
			
		}else{
		echo '
<li ><a href="'.$row['mo_href'].'"><i class="'.$row['mo_icon'].'"></i> <span class="nav-label">'.$row['mo_name'].'</span></a></li>';
			
			}
		}
	
	}
	
	#wile end
	echo '</ul>
            </nav>';
			
			#big if end
} else {echo 'Error ##3';}









###


		}
?>


<?php

		function get_head(){
			echo ' <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <link rel="shortcut icon" href="img/favicon.jpg">

        <title>StileWell - Admin Dashboard </title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-reset.css" rel="stylesheet">

        <!--Animation css-->
        <link href="css/animate.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="assets/select2/select2.css" />

        <link href="assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

        <!--Icon-fonts css-->
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/ionicon/css/ionicons.min.css" rel="stylesheet" />

        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="assets/morris/morris.css">

        <!-- sweet alerts -->
        <link href="assets/sweet-alert/sweet-alert.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/helper.css" rel="stylesheet">
        


        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->';
}

function get_end_script(){

echo '
 <!-- js placed at the end of the document so the pages load faster -->
        <script src="js/jquery.js"></script>
		<script src="js/jquery.jeditable.js"></script>
		
        <script src="js/bootstrap.min.js"></script>
        <script src="js/modernizr.min.js"></script>
        <script src="js/pace.min.js"></script>
        <script src="js/wow.min.js"></script>
        <script src="js/jquery.scrollTo.min.js"></script>
        <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
        <script src="assets/chat/moment-2.2.1.js"></script>

        <!-- Counter-up -->
        <script src="js/waypoints.min.js" type="text/javascript"></script>
        <script src="js/jquery.counterup.min.js" type="text/javascript"></script>

        <!-- sweet alerts -->
        <script src="assets/sweet-alert/sweet-alert.min.js"></script>
        <script src="assets/sweet-alert/sweet-alert.init.js"></script>

        <script src="js/jquery.app.js"></script>
        <!-- Chat -->
        <script src="js/jquery.chat.js"></script>
        <!-- Dashboard -->
        <script src="assets/modal-effect/js/classie.js"></script>
        <script src="assets/modal-effect/js/modalEffects.js"></script>

        <!-- Todo -->
        <script src="js/jquery.todo.js"></script>
		<script src="assets/select2/select2.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="assets/jquery-multi-select/jquery.multi-select.js"></script>
        <script type="text/javascript" src="assets/jquery-multi-select/jquery.quicksearch.js"></script>
		<script src="assets/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/datatables/dataTables.bootstrap.js"></script>
        <script type="text/javascript">
        /* ==============================================
             Counter Up
             =============================================== */
            jQuery(document).ready(function($) {
                $(\'.counter\').counterUp({
                    delay: 100,
                    time: 1200
                });
            });
        </script>
    

';
}



function is_address($string){
	
	#address
$address = $string;
$address = str_replace(' ','',$address);
$address = str_replace('-','',$address);
$address = str_replace('/','',$address);
$address = str_replace("'",'\'',$address);
$address = str_replace('>','',$address);
$address = str_replace('<','',$address);

if(ctype_alnum($address) == true){
	return true;
}else{
	return false ;
}

	
	
}


function is_name($string,$int){
	# int 1 = remove blank 
	#int 0 = keep blank
	#int 2 = remove blank and check for alnum
	#int 3 = remove blank and check for alnum or alphabets
	if($int==1){
		$myVar = str_replace(' ','',$string);

				if(ctype_alpha($myVar)){
					return true;
				}else{
					return false;
				}
	}
	
	else if($int == 0){
		
		
		$myVar = $string;

				if(ctype_alpha($myVar)){
					return true;
				}else{
					return false;
				}
	}
	else if($int == 2){
		
		$myVar = str_replace(' ','',$string);
		$myVar = str_replace('_','',$string);

				if(ctype_alnum($myVar)){
					return true;
				}else{
					return false;
				}
		
	}
	else if($int == 3){
		
		$myVar = str_replace(' ','',$string);
		$myVar = str_replace('_','',$string);

				if(ctype_alpha($myVar) or ctype_alnum($myVar)){
					return true;
				}else{
					return false;
				}
		
	}
	
	return false;
}


function is_mobno($string){

	$mobNo = trim($string);
if(is_numeric($mobNo)){
	if(strlen($mobNo) == 10){
		return true;
	}else{
		return false;
		}
}else{
	return false;
}



}

function validate_email($email) {
				return (preg_match("/(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/", $email) || !preg_match("/^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/", $email)) ? false : true;
			}
			

function is_email($string){
	
				$email = $string;
				
				if(validate_email($email) == true){
					return true;
				}else{
						return false ;
				}
			
		
	
}


function is_date($dy,$mt,$yr){
	
		
				
				if(checkdate($mt,$dy,$yr) == true){
					return true;
				}else{
						return false ;
				}
			
		
	
}



function is_pincode($string){

$pincode = $string;
if(is_numeric($pincode)){
	if(strlen($pincode) == 6 and ($pincode > 100000 )){
		return true;
	}else{
		return false;
	}
}else{
	return false;
}



}

function is_strength($string){
	
	$delno = $string;

if(is_numeric($delno) && ($delno < 22)){
		return true;
}else{
		return false;
}


}




function is_writeup($string){
	$text = strtolower($string);
	$text =strip_tags($text);
	$text = str_replace(' ','',$text);
	$text = str_replace("'",'',$text);
	$text = str_replace('"','',$text);
	$text = str_replace(";",'',$text);
	$text = str_replace("",'',$text);
	$text = str_replace("\n",'',$text);
	$text = str_replace("\r",'',$text);
	$text = str_replace("\\",'',$text);
	$text = str_replace("/",'',$text);
	$text = str_replace("?",'',$text);
	$text = str_replace(".",'',$text);
	$text = str_replace(",",'',$text);

				if(ctype_alnum($text) or ctype_alpha($text)){
					return true;
				}else{
					return false;
				}
	
}


function is_numeric_array( $array){
  foreach( $array as $val){
    if( !is_numeric( $val)){
      return false;
    }
  }
  return true;
}



function array_has_dupes($array) {
   // streamline per @Felix
   return count($array) !== count(array_unique($array));
}

function extension($name){
	$img_name = explode('.',$name);
	$del =count($img_name) - 1;
	return($img_name[$del]);
}


function resize($newWidth, $targetFile, $originalFile) {

    $info = getimagesize($originalFile);
    $mime = ($info['mime']);

    switch ($mime) {
            case 'image/jpeg':
                    $image_create_func = 'imagecreatefromjpeg';
                    $image_save_func = 'imagejpeg';
                    $new_image_ext = 'jpg';
                    break;

            case 'image/png':
                    $image_create_func = 'imagecreatefrompng';
                    $image_save_func = 'imagepng';
                    $new_image_ext = 'png';
                    break;

            case 'image/gif':
                    $image_create_func = 'imagecreatefromgif';
                    $image_save_func = 'imagegif';
                    $new_image_ext = 'gif';
                    break;

            default: 
                    die('Unknown image type.');
    }

    $img = $image_create_func($originalFile);
    list($width, $height) = getimagesize($originalFile);
    $newHeight = ($height / $width) * $newWidth;
    $tmp = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    if (file_exists($targetFile)) {
            unlink($targetFile);
    }
    $image_save_func($tmp, $targetFile);
	return true;
}

?>



<?php
include('db_auth.php');
if(isset($_POST['add_inven'])){
  if(isset($_POST['pr_name'])){
    if(isset($_POST['pr_type'])){
      if(isset($_POST['pr_desc'])){
        if(isset($_POST['pr_price'])){
          if(isset($_POST['pr_qty'])){
          if(isset($_POST['pr_per'])){
         	 if(isset($_POST['pr_code'])){
         	 	if(isset($_FILES['prr_img'])){
					
					
					$target_dir = "pr_imgs/";
$ext =  extension(basename($_FILES["prr_img"]["name"]));
$fold_name =uniqid().'-'.$_POST['pr_code'].$_POST['pr_name'].$_POST['pr_type'].'-'.$_POST['pr_qty'].'/';
if(mkdir('pr_imgs/'.$fold_name)){
}

$target_file = $target_dir .$fold_name. $_POST['pr_code'].''.$_POST['pr_name'].'_1.'.$ext;
$target_file_2 = $target_dir .$fold_name. $_POST['pr_code'].''.$_POST['pr_name'].'_2.'.$ext;
$target_file_3 = $target_dir .$fold_name. $_POST['pr_code'].''.$_POST['pr_name'].'_3.'.$ext;

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["prr_img"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
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
if ($_FILES["prr_img"]["size"] > 5000000) {
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
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["prr_img"]["tmp_name"], $target_file) and
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
					
					
					
            if($_SESSION['SW_U_ACCESS'] < 2){
              die("Acess denied");
            }
			 $inssql = "INSERT INTO `sw_products_list`(`pr_code`,`pr_img`,`pr_img_2`,`pr_img_3`,`pr_name`, `pr_type`, `pr_desc`, `pr_price`,`pr_per`,`pr_qty`,`pr_dnt`) VALUES (
            '".$_POST['pr_code']."',
				'".$target_file."',
					'".$target_file_2."',
						'".$target_file_3."',
							'".$_POST['pr_name']."',
							  '".$_POST['pr_type']."',
								'".$_POST['pr_desc']."',
								  '".$_POST['pr_price']."',
								  '".$_POST['pr_per']."',
								  '".$_POST['pr_qty']."',
									'".time()."'
								)";
                    if ($conn->query($inssql) === TRUE) {
                      header('Location: inven.php');
                    }
            else {
              die( "Error: " . $sql . "<br>" . $conn->error);
            }
            /*
              if ($conn->query($inssql) === TRUE) {
                $last_id = $conn->insert_id;
                #
                $inssql = "INSERT INTO `sw_products_quantity_in`(`pq_pr_id_rel`, `pq_quant`) VALUES (
                ".$last_id.",
                  '".$_POST['pr_qty']."'
                  )";
                  if ($conn->query($inssql) === TRUE) {
                    header('Location: inven.php');
                  }
                else {
                  die( "Error: " . $sql . "<br>" . $conn->error);
                }
                #
              }
            else {
              die( "Error: " . $sql . "<br>" . $conn->error);
            }
            */ 
				 }
			 }
          }
        }
      }
    }
    }
  }
}
if(isset($_POST['edit_thing']) and isset($_POST['value_edited'])){
  if($_SESSION['SW_U_ACCESS'] < 3){
    die("Acess denied");
  }
  $x=array();
  if(substr($_POST['edit_thing'],32,-1) == '_prname'){
    $colnm = 'pr_name';
    $newval = trim(strip_tags($_POST['value_edited']));
  }
  else{
    $x[]=0;
  }
  if(substr($_POST['edit_thing'],32,-1) == '_prtype'){
    $colnm = 'pr_type';
    $newval = trim(strip_tags($_POST['value_edited']));
  }
  else{
    $x[]=0;
  }
  if(substr($_POST['edit_thing'],32,-1) == '_prdesc'){
    $colnm = 'pr_desc';
    $newval = trim(strip_tags($_POST['value_edited']));
  }
  else{
    $x[]=0;
  }
  if(substr($_POST['edit_thing'],32,-1) == '_prqty'){
    $colnm = 'pr_qty';
    $newval = trim(strip_tags($_POST['value_edited']));
  }
  else{
    $x[]=0;
  }
  if(substr($_POST['edit_thing'],32,-1) == '_prprice'){
    $colnm = 'pr_price';
    $newval = trim(strip_tags($_POST['value_edited']));
    if(!is_numeric($newval)){
      die('<i style="color:red">Price should be numeric</i>');
    }
  }
  else{
    $x[]=0;
  }
  # max error should be 4 as there are 5 fields and every time 1 should be true
  if(count($x) ==4){
    $updtsql = "
    UPDATE `sw_products_list` SET `".$colnm."`='".$newval."' WHERE md5(md5(sha1(md5(`pr_id`)))) = '".substr($_POST['edit_thing'],0,32)."';
    ";
    if ($conn->query($updtsql) === TRUE) {
      echo $newval;
    }
    else {
      echo "Error updating record: " . $conn->error;
    }
  }
}
if(isset($_POST['pr_delete']) and is_name(isset($_POST['hchk']),2)){
  if($_SESSION['SW_U_ACCESS'] < 4){
    die("Acess denied");
  }
  $delsql = "
  UPDATE `sw_products_list` SET `pr_valid`=0 WHERE md5(md5(sha1(md5(`pr_id`))))='".trim($_POST['hchk'])."'";
  if ($conn->query($delsql) === TRUE) {
    header('Location: inven.php');
  }
  else {
    die( "Error: " . $sql . "<br>" . $conn->error);
  }
}
if(isset($_POST['edit_thing_order']) and isset($_POST['value_edited_order'])){
  if($_SESSION['SW_U_ACCESS'] < 3){
    die("Acess denied");
  }
  $x=array();
  if(substr($_POST['edit_thing_order'],32,-1) == '_buyname'){
    $colnm = 'or_buy_name';
    $newval = trim(strip_tags($_POST['value_edited_order']));
  }
  else{
    $x[]=0;
  }
  # max error should be 0 as there is 1 field and every time 1 should be true
  if(count($x) ==0){
    $updtsql = "
    UPDATE `sw_orders` SET `".$colnm."`='".$newval."' WHERE md5(md5(sha1(md5(`or_id`)))) = '".substr($_POST['edit_thing_order'],0,32)."';
    ";
    if ($conn->query($updtsql) === TRUE) {
      echo $newval;
    }
    else {
      echo "Error updating record: " . $conn->error;
    }
  }
}
if(isset($_POST['add_order'])){
	die('not allowed');
  if(is_name(trim(strtolower($_POST['or_ref_name'])),3) && is_name(trim(strtolower($_POST['or_buy_name'])),1)){
    $inssql = "
    INSERT INTO `sw_orders`(`or_ref_name`, `or_datentime`, `or_buy_name`) VALUES (
      '".$_POST['or_ref_name']."',
      '".time()."',
      '".$_POST['or_buy_name']."'
    )";
    if ($conn->query($inssql) === TRUE) {
      #
      $last_id = $conn->insert_id;
      $modalhashsql = "SELECT * FROM sw_orders where or_id = ".$last_id;
      $modalhashres = $conn->query($modalhashsql);
      if ($modalhashres->num_rows > 0) {
        // output data of each row
        $modalhashrw = $modalhashres->fetch_assoc();
        header('Location: orders.php?hpmo='.md5($modalhashrw['or_id'].$modalhashrw['or_ref_name']));
      }
      else {
        echo "Error  inserted not found";
      }
      #
    }
    else {
      die( "Error: " . $inssql . "<br>" . $conn->error);
    }
  }
  else{
    die('Invalid Values');
  }
  
}
if(isset($_POST['or_delete'])){
	if(isset($_POST['hchk']) && ctype_alnum($_POST['hchk'])){
		$delor_sql = "UPDATE `sw_orders` SET `or_valid`=0 WHERE md5(md5(sha1(md5(or_id)))) = '".$_POST['hchk']."'";
		if($conn->query($delor_sql)){
			###
			
				$dellor_sql = "UPDATE `sw_order_items` SET `oi_valid`=0 WHERE md5(md5(sha1(md5(oi_rel_or_id)))) = '".$_POST['hchk']."'";
				if($conn->query($dellor_sql)){
					###
					
					$sqd ="SELECT oi_rel_pr_id, oi_qty from sw_order_items where md5(md5(sha1(md5(oi_rel_or_id)))) ='".$_POST['hchk']."' ";
					$sqres = $conn->query($sqd);
					if($sqres->num_rows > 0){
						$optin =1;
						while($ro = $sqres->fetch_assoc()){
							if($conn->query("update sw_products_list  set pr_qty = (pr_qty + ".$ro['oi_qty'].") where pr_id = ".$ro['oi_rel_pr_id']."")){
								
							}else{
								$optin = 0;
								die('error ###4');
							}
						}
						
						if($optin ==1){header('Location: orders.php');}
					}else{
					die("#4 error");	
					}
					
					###3
					
					
					
					
				
				}else{
				die($conn->error);
				}
			###
		}else{
			die($conn->error);
		}
	}else{
		die("Denied");
	}
}
if(isset($_POST['or_prs_add'])){
	
	
	if(isset($_POST['or_ids_no']) and is_numeric($_POST['or_ids_no'])){
	
		$prdord_sql = array();
		$prdord_del_sql = array();
		$pro = array();
		for($x = 1; $x<($_POST['or_ids_no']+1);$x++){
			if($x==1){
				$c ='';
			}else{
				$c = $x;
			}
				$ex  = explode('_0/',($_POST['pr_id'.$c]));
				
				$prs =openssl_decrypt($ex[1], 'AES-256-CBC','430ij5h0bujv3r0ifgoijte',0, '7t6h39kfb4hgsnv4');
				$or_id = $_POST['content_or___d'];
				var_dump($or_id);
				
				$pro[] = $prs;
				
				
		if(is_numeric($prs) and is_numeric($or_id)){
			$prdord_sql[] = "INSERT INTO `sw_order_items`(`oi_rel_pr_id`, `oi_rel_or_id`, `oi_qty`, `oi_price_for_one`) VALUES (
			'".$prs."',
			'".$or_id."',
			'".$_POST['or_pr_qty'.$c]."',
			'".$_POST['or_pr_ppp'.$c]."'
			)";
			
			
			$prdord_del_sql[] = "UPDATE `sw_products_list`
		set pr_qty = (pr_qty-".$_POST['or_pr_qty'.$c].") where pr_id = ".$prs."
			
			";
		}





		}
		if(array_has_dupes($pro)){
		die('A Product can\'t be selected more than once');	
		}
		

		
		$erorr_dump =array();
foreach($prdord_sql as $sql){
	if($conn->query($sql)){
		
	}else{
		$error_dump[] = 'one error';
	}
}
foreach($prdord_del_sql as $dsql){
	if($conn->query($dsql)){
		
	}else{
		$error_dump[] = $conn->error;
	}
}

if(count($error_dump) == 0){
	$redir_hash =  md5(md5(sha1(md5($or_id))));
	header('Location: orders.php?hpmo='.$redir_hash);
}else{
	
	die(var_dump($error_dump));
}
		
	}
}
if(isset($_POST['or_pr_del'])){
	if(isset($_POST['pr_or_delid']) && ctype_alnum($_POST['pr_or_delid'])){
		$del_or_pr_sql = "UPDATE sw_order_items set `oi_valid`=0 WHERE md5(sha1(md5(sha1(sha1(sha1(oi_id)))))) = '".$_POST['pr_or_delid']."'";
		if($conn->query($del_or_pr_sql)){
			#md5(md5(sha1(md5(or_id))))

			$getorid_s = "select * from sw_order_items ihy left join sw_orders ih on
			ihy.oi_rel_or_id = ih.or_id
			 where  md5(sha1(md5(sha1(sha1(sha1(oi_id)))))) = '".$_POST['pr_or_delid']."'";
			 $getorid_r = $conn->query($getorid_s);
			 
			 if($getorid_r->num_rows == 1){
				 $getor_rr = $getorid_r->fetch_assoc();
				 var_dump($getor_rr);
				 if($conn->query("update sw_products_list set pr_qty = (pr_qty+".$getor_rr['oi_qty'].") where pr_id = ".$getor_rr['oi_rel_pr_id']."")){
				 $redir_hash = md5(md5(sha1(md5($getor_rr['or_id']))));
			header('Location: edit_order.php?or_edit=h983h9ynh5346h&edihchk='.$redir_hash);
				 }else{
					 die($conn->error);
				 }
			 }
			 
			 
		}else{
			die($conn->error);
		}
		
	}else{die("Bad Hash");}
}
if(isset($_POST['pr_or_editid']) and isset($_POST['val_edtd'])){
	if(ctype_alnum(trim(strtolower(substr($_POST['pr_or_editid'],0,32))))){
	}else{
		die('Bad MD%');
	}
  if($_SESSION['SW_U_ACCESS'] < 3){
    die("Acess denied");
  }
  $x=array();
 
  if(substr($_POST['pr_or_editid'],32,-1) == '_prorpfo'){
    $colnm = 'oi_price_for_one';
    $newval = trim(strip_tags($_POST['val_edtd']));
    if(!is_numeric($newval)){
      die('<i style="color:red">Price should be numeric</i>');
    }
  }
  else{
    $x[]=0;
  }
  
  if(substr($_POST['pr_or_editid'],32,-1) == '_orprqt'){
    $colnm = 'oi_qty';
    $newval = trim(strip_tags($_POST['val_edtd']));
    if(!is_numeric($newval)){
      die('<i style="color:red">Qty should be numeric</i>');
    }
  }
  else{
    $x[]=0;
  }
  
   if(substr($_POST['pr_or_editid'],32,-1) == '_prorspcl'){
    $colnm = 'oi_pr_special';
    $newval = trim(strip_tags($_POST['val_edtd']));
  }
  else{
    $x[]=0;
  }
  # max error should be 2 as there are 3 fields and every time 1 should be true
  if(count($x) ==2){
	  if($colnm =='oi_qty'){ 
	 $sel = "select * from sw_order_items where md5(md5(sha1(md5(`oi_id`)))) = 
	  '".substr($_POST['pr_or_editid'],0,32)."'";
	  $selres = $conn->query($sel);
	  if($selres->num_rows ==1){
		  $ro =$selres->fetch_assoc();
			 
				   #old =5 > new =2 +
				   $nv = $ro['oi_qty'] - $newval;
				   
$ffewf ="update sw_products_list set pr_qty = (pr_qty + ".$nv.") where pr_id = ".$ro['oi_rel_pr_id']."";
				   if($conn->query($ffewf)){
				   }else{echo 'Error 4445';}
			 
			  
		  
	  }
	 }
	 
	 
	 $updtsql = "
    UPDATE `sw_order_items` SET `".$colnm."`='".$newval."' WHERE md5(md5(sha1(md5(`oi_id`)))) = '".substr($_POST['pr_or_editid'],0,32)."';
    ";
    if ($conn->query($updtsql) === TRUE) {
      
	 echo $newval;
    }
    else {
      echo "Error updating record: " . $conn->error;
    }
  }
}
if(isset($_POST['mockup_et']) and isset($_POST['mockup_et_val'])){
	if(ctype_alnum(trim(strtolower(substr($_POST['mockup_et'],0,32))))){
	}else{
		die('Bad MD%');
	}
  if($_SESSION['SW_U_ACCESS'] < 3){
    die("Acess denied");
  }
  $x=array();
 
  if(substr($_POST['mockup_et'],32,-1) == '_mkpname'){
    $colnm = 'mock_given_person_name';
    $newval = trim(strip_tags($_POST['mockup_et_val']));
    if(!ctype_alnum(str_replace(' ','',$newval))){
      die('<i style="color:red">Name be Alphabetic</i>');
    }
  }
  else{
    $x[]=0;
  }
  
  if(substr($_POST['mockup_et'],32,-1) == '_mkpnumber'){
    $colnm = 'mock_given_person_number';
    $newval = trim(strip_tags($_POST['mockup_et_val']));
    if(!is_numeric($newval)){
      die('<i style="color:red">Phone no. should be numeric</i>');
    }
  }
  else{
    $x[]=0;
  }
  
  
  if(substr($_POST['mockup_et'],32,-1) == '_mksf'){
    $colnm = 'mock_sent_from';
    $newval = trim(strip_tags($_POST['mockup_et_val']));
    if(!ctype_alpha($newval)){
      die('<i style="color:red">Location should be Alphabetic</i>');
    }
  }
  else{
    $x[]=0;
  }
  
    if(substr($_POST['mockup_et'],32,-1) == '_mkpadd'){
    $colnm = 'mock_given_person_address';
    $newval = trim(strip_tags($_POST['mockup_et_val']));
   
  }
  else{
    $x[]=0;
  }
  
  if(substr($_POST['mockup_et'],32,-1) == '_mkqty'){
    $colnm = 'mock_qty';
    $newval = trim(strip_tags($_POST['mockup_et_val']));
    if(!is_numeric($newval)){
      die('<i style="color:red">Qty should be numeric</i>');
    }
  }
  else{
    $x[]=0;
  }
  
  
    if(substr($_POST['mockup_et'],32,-1) == '_mkretrnd'){
    $colnm = 'mock_sample_returned';
    $newval = trim(strip_tags($_POST['mockup_et_val']));
    if($newval == 1 || $newval == 0){
      
    }else{die('<i style="color:red">Returned should be either 1 or 0</i>');}
  }
  else{
    $x[]=0;
  }
  
  if(substr($_POST['mockup_et'],32,-1) == '_remarks'){
    $colnm = 'mock_sample_remarks';
    $newval = trim(strip_tags($_POST['mockup_et_val']));
  }
  else{
    $x[]=0;
  }
  
 
  # max error should be 6 as there are 7 fields and every time 1 should be true
  if(count($x) ==6){
    $updtsql = "
    UPDATE `sw_mockup` SET `".$colnm."`='".$newval."' WHERE md5(md5(sha1(md5(`mock_id`)))) = '".substr($_POST['mockup_et'],0,32)."';
    ";
    if ($conn->query($updtsql) === TRUE) {
      echo $newval;
    }
    else {
      echo "Error updating record: " . $conn->error;
    }
  }
}
if(isset($_POST['shw_ed']) and isset($_POST['shw_val'])){
	if(ctype_alnum(trim(strtolower(substr($_POST['shw_ed'],0,32))))){
	}else{
		die('Bad MD%');
	}
  if($_SESSION['SW_U_ACCESS'] < 3){
    die("Acess denied");
  }
  $x=array();
 
 
  
    if(substr($_POST['shw_ed'],32,-1) == '_shlocated'){
    $colnm = 'sh_located';
    $newval = trim(strip_tags($_POST['shw_val']));
    if($newval == 1 || $newval == 0){
      
    }else{die('<i style="color:red">Returned should be either 1 or 0</i>');}
  }
  else{
    $x[]=0;
  }
  
  if(substr($_POST['shw_ed'],32,-1) == '_shqty'){
    $colnm = 'sh_qty';
    $newval = trim(strip_tags($_POST['shw_val']));
  }
  else{
    $x[]=0;
  }
  
 
  # max error should be 1 as there are 2 fields and every time 1 should be true
  if(count($x) ==1){
    $updtsql = "
    UPDATE `sw_products_list_show` SET `".$colnm."`='".$newval."' WHERE md5(md5(sha1(md5(sh_pr_id)))) = '".substr($_POST['shw_ed'],0,32)."';
    ";
    if ($conn->query($updtsql) === TRUE) {
      echo $newval;
    }
    else {
      echo "Error updating record: " . $conn->error;
    }
  }
}
if(isset($_POST['add_mk'])){
	$mkprid= base64_decode($_POST['mk_pr_id']);
	if(!is_numeric($mkprid)){
		die('Bad Hash');
	}
	if($_POST['mk_s_from']=='wh' || $_POST['mk_s_from'] == 'shr'){
		$frm = $_POST['mk_s_from'];
	}else{die('from not valid');}
	$name = stripslashes($_POST['mk_pers_nm']);
	if(is_numeric($_POST['mk_conct_no'])){
		$no = $_POST['mk_conct_no'];
	}else{die('Contact not valid');}
	$addrr = stripslashes($_POST['mk_pers_add']);
	if(is_numeric($_POST['mk_g_qty'])){
		$qt = $_POST['mk_g_qty'];
	}else{die('Qty not valid');}
	
	$inssql = "INSERT INTO `sw_mockup`(`mock_rel_pr_id`, `mock_sent_from`, `mock_given_person_name`, `mock_given_person_address`, `mock_given_person_number`, `mock_qty`, `mock_added_dnt`) VALUES (
	'".$mkprid."',
	'".$frm."',
	'".$name."',
	'".$addrr."',
	'".$no."',
	'".$qt."',
	'".time()."'
	)";
	
	
	if ($conn->query($inssql) === TRUE) {
      
      #
	  header('Location: mockup.php');
    }
    else {
      die( "Error: " . $inssql . "<br>" . $conn->error);
    }
  
	
	
}
if(isset($_POST['mk_delete']) and isset($_POST['checker']) and ctype_alnum(trim(strtolower($_POST['checker']))) and $_POST['mk_delete'] =="Delete"){
	$delor_sql = "UPDATE `sw_mockup` SET `mockup_valid`=0 WHERE md5(md5(sha1(md5(mock_id)))) = '".$_POST['checker']."'";
		if($conn->query($delor_sql)){
			header('Location: mockup.php');
		}else{
			die($conn->error);
		}
	
}
if(isset($_POST['add_inven_sh'])){
  if(isset($_POST['pr_sh_qty'])){
    if(isset($_POST['pr_sh_loc'])){
      if(isset($_POST['pr_sh_id'])){
            if($_SESSION['SW_U_ACCESS'] < 2){
              die("Acess denied");
            }
			if(!is_numeric($_POST['pr_sh_qty'])){
				die("Bad qty");
			}
			$qt = $_POST['pr_sh_qty'];
			$loc = stripslashes($_POST['pr_sh_loc']);
			$rel = base64_decode($_POST['pr_sh_id']);
			
			if(!is_numeric($rel)){
				die('Hash not valid');
			}
			
            $inssql = "INSERT INTO `sw_products_list_show`( `sh_pr_id_rel_pr_id`, `sh_qty`, `sh_located`, `sh_dnt`) VALUES (
			'".$rel."',
			'".$qt."',
			'".$loc."',
			'".time()."'
			);
			
			";
			$inssql .="UPDATE `sw_products_list` SET pr_qty = (pr_qty - ".$qt.") where pr_id =".$rel." "  ;
                    if ($conn->multi_query($inssql) === TRUE) {
						
						
                      header('Location: inven_show.php');
                    }
            else {
              die( "Error: " . $inssql. "<br>" . $conn->error);
            }
	  }
	}
  }
}
if(isset($_POST['pr_sh_delete']) and isset($_POST['cphk']) and ctype_alnum(trim(strtolower($_POST['cphk']))) and $_POST['pr_sh_delete'] =="Delete"){
	$delor_sql = "UPDATE `sw_products_list_show` SET `sh_valid`=0 WHERE md5(md5(sha1(md5(sh_pr_id)))) = '".$_POST['cphk']."'";
		if($conn->query($delor_sql)){
			header('Location: inven_show.php');
		}else{
			die($conn->error);
		}
	
}
if(isset($_POST['pw_edd']) and isset($_POST['val_edd'])){
	$pw = stripslashes($_POST['val_edd']);
	$uid = stripslashes($_POST['pw_edd']);
		$uu_sql = "UPDATE `sw_usrs_inf` SET `sw_password`='".md5($pw)."',`sw_pass_words`='".$pw."' WHERE md5(sha1(md5(sha1(sha1(sha1(sw_u_id)))))) = '".$uid."'";
	
	if($conn->query($uu_sql)){
			###
			
				
				echo $pw;
				
			###
		}else{
			die($conn->error);
		}
	
}
?>

<?php
include('db_auth.php');
if(isset($_POST['or_add']) and isset($_POST['o_or_ids_no'])){
	
  if(is_name(trim(strtolower($_POST['or_ref_name'])),3) && is_name(trim(strtolower($_POST['or_buy_name'])),1)){
    $inssql = "
    INSERT INTO `sw_orders`(`or_ref_name`, `or_datentime`, `or_buy_name`) VALUES (
      '".$_POST['or_ref_name']."',
      '".time()."',
      '".$_POST['or_buy_name']."'
    )";
	if ($conn->query($inssql) === TRUE) {
    
      $or_id = $conn->insert_id;
      
    }
    else {
      die( "Error: " . $inssql . "<br>" . $conn->error);
    }
  }
  else{
    die('Invalid Values');
  }
  
	
	
	if(isset($_POST['o_or_ids_no']) and is_numeric($_POST['o_or_ids_no'])){
	
		$prdord_sql = array();
		$prdord_del_sql = array();
		$pro = array();
		for($x = 1; $x<($_POST['o_or_ids_no']+1);$x++){
			if($x==1){
				$c ='';
			}else{
				$c = $x;
			}
				$ex  = explode('_0/',($_POST['pr_id'.$c]));
				
				$prs =openssl_decrypt($ex[1], 'AES-256-CBC','430ij5h0bujv3r0ifgoijte',0, '7t6h39kfb4hgsnv4');
				$pro[] = $prs;
				
				
		if(is_numeric($prs) and is_numeric($or_id)){
			$prdord_sql[] = "INSERT INTO `sw_order_items`(`oi_rel_pr_id`, `oi_rel_or_id`, `oi_qty`, `oi_price_for_one`, `oi_pr_special`) VALUES (
			'".$prs."',
			'".$or_id."',
			'".$_POST['or_pr_qty'.$c]."',
			'".$_POST['or_pr_ppp'.$c]."',
			'".$_POST['or_pr_spcl'.$c]."'
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
foreach($prdord_sql as $psql){
	if($conn->query($psql)){
		
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
	$redir_hash =  md5($or_id.$_POST['or_ref_name']);
	header('Location: orders.php?hpmo='.$redir_hash);
}else{
	
	die(var_dump($error_dump));
}
		
	}
}









if(isset($_POST['add_user'])){
	
	$valid_till_sec = $_POST['usr_valid_t'] * 60;
	
	if($valid_till_sec > 0){
	$valid_till = time() + $valid_till_sec;
		
	}else{
	
		$valid_till = 0;
}
	
	$cntc = str_replace(' ','',$_POST['usr_contcno']);
	$cntc = str_replace('(','',$cntc);
	$cntc = str_replace(')','',$cntc);
	$cntc = str_replace('-','',$cntc);
	$inssql = "INSERT INTO `sw_usrs_inf`(`sw_username`, `sw_password`, `sw_pass_words`, `sw_prefix_name`, `sw_u_f_name`, `sw_u_l_name`, `sw_u_dob`, `sw_u_access`, `sw_contc_no`, `sw_email`, `sw_validtill`) VALUES 
	(
'".trim($_POST['usr_usrnme'])."',
'".md5(trim($_POST['usr_pw']))."',
'".$_POST['usr_pw']."',
'".$_POST['usr_prefix']."',
'".$_POST['usr_fname']."',
'".$_POST['usr_lname']."',
'".$_POST['usr_dob']."',
'".$_POST['usr_acclvl']."',
'".$cntc."',
'".$_POST['usr_email']."',
'".$valid_till."'
	)";
	if($conn->query($inssql)){
		header('Location: users_main.php');
	}
}

?>
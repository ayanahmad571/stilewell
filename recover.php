<?php 

include('db_auth.php');
?>



<?php
if(isset($_SESSION['STWL_SESS_ID'])){
$login=1;
header('Location: home.php');
}else{
	$login=0;
	
}
?>
<?php 

if(isset($_GET['id'])){
	$id= str_replace('_','',$_GET['id']);
	if(ctype_alnum($id)){
		$id = $_GET['id'];
		$tim = time();
		$valchk = getdatafromsql($conn, "select * from sw_recover where concat(rv_hash,rv_hash_2)='".trim($id)."' and rv_used = 0 and rv_valid =1 and rv_valid_till > ".$tim."");
		
		if(is_array($valchk)){
			
			if($conn->query("UPDATE `sw_recover` SET `rv_used`= 1 where
			concat(rv_hash,rv_hash_2)='".trim($id)."' and rv_valid =1")){
				$new_pw_ac = 1;
			$new_pw_usr = $valchk['rv_rel_lum_id'];
			}else{
				die("#ERRRRCVRIJ");
			}
			
			
		}else{
			
			die('Link not Valid <a href="index.php"><button>Go back</button></a>');
			
		}
		
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

<?php get_head(); ?>
                 </head>


    <body>

       
        <div class="wrapper-page animated fadeInDown">
            <div class="panel panel-color panel-success">
                <div class="panel-heading"> 
                   <h3 class="text-center m-t-10"> Password Recovery </h3>
                </div> 

                <form class="form-horizontal m-t-40" action="master_action.php" method="post">
            	   <?php 
				   if(isset($new_pw_ac)){
					   ?>
                       
                       <label>New Password</label>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input name="recover_npw" class="form-control" type="text" required placeholder="Enter your New Password">
                        </div>
                    </div>
                
                  
                    <div class="form-group text-right">
                        <div class="col-xs-12">
                        <input type="hidden" name="rec_pw_u" value="<?php echo md5(sha1($new_pw_usr.'3oijg9i3u8uh')) ?>" />
                        <input type="hidden" name="rec_action_pw" value="<?php echo md5(time().uniqid()); ?>" />
                            <button class="btn btn-purple w-md" type="submit">Recover</button>
                        </div>
                    </div>

                   
                       <?php
					   
					   
				   }else{
					   ?>
                       
                       
                       <label>Enter your email address</label>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input name="rec_eml" class="form-control" type="email" required placeholder="Email">
                        </div>
                    </div>
                
                
                  
                    
                    <div class="form-group text-right">
                        <div class="col-xs-12">
                        <input type="hidden" name="re_pw" value="<?php echo md5(time().uniqid()); ?>" />
                            <button class="btn btn-purple w-md" type="submit">Recover</button>
                        </div>
                    </div>

                    <div class="form-group m-t-30">
                        <div class="col-sm-12 text-center">
                            <a href="login.php">Rember your password?</a>
                        </div>
                    </div>
                       <?php
					   
				   }
				   ?>
                    
                </form>                                  
                
            </div>
        </div>

        
      <?php  
	  get_end_script();
	  ?>
      
    </body>

</html>

<?php 

include('db_auth.php');
?>



<?php
if(isset($_SESSION['SCHVB_SESS_ID'])){
$login=1;
header('Location: home.php');
}else{
	$login=0;
	
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

<?php get_head(); ?>

                 </head>


    <body>
        <div class="wrapper-page animated fadeInDown">
            <div class="panel panel-color panel-primary">
                <div class="panel-heading"> 
                   <h3 class="text-center m-t-10"> Sign In to <strong>School Vault</strong> </h3>
                </div> 

                <form class="form-horizontal m-t-40" action="master_action.php" method="post">
                                                                 <?php 
if(isset($_GET['notss'])){
echo '<p style="color:red" align="center">No Match Found</p>';
}
?>                       
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input <?php if(isset($_GET['notss'])){echo 'style="border:red 1px solid" ';} ?> name="lo_eml" class="form-control" type="text" placeholder="Email or Adm No.">
                        </div>
                    </div>
                    <div class="form-group ">
                        
                        <div class="col-xs-12">
                            <input <?php if(isset($_GET['notss'])){echo 'style="border:red 1px solid" ';} ?> name="lo_pass" class="form-control" type="password" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group ">
                        
                        <div class="col-xs-12">
                            <select required name="lo_type" class="form-control">
                            	<?php
								$getusertypes = "SELECT * FROM sb_user_types order by tu_name asc";
$getusertypes = $conn->query($getusertypes);

if ($getusertypes->num_rows > 0) {
    // output data of each row
    while($usertypes = $getusertypes->fetch_assoc()) {
		if($usertypes['tu_default'] == 1){
		?>
        <option selected value="<?php echo $usertypes['tu_id'] ?>"><?php echo $usertypes['tu_name'] ?></option>
        <?php
		}else{
			?>
        <option value="<?php echo $usertypes['tu_id'] ?>"><?php echo $usertypes['tu_name'] ?></option>
            <?php
		}
    }
} else {
    echo "0 results";
}
								?>
                            </select>
                             
                        </div>
                    </div>
                    
                    <div class="form-group ">
                        
                        <div class="col-xs-12">
                            
                             <select required name="lo_school" class="form-control">
                             <option selected value="0" >Select your School</option>
                            	<?php
								$getusertypes = "SELECT sch_id,sch_name FROM `schools_listed` ";
$getusertypes = $conn->query($getusertypes);

if ($getusertypes->num_rows > 0) {
    // output data of each row
    while($usertypes = $getusertypes->fetch_assoc()) {
		?>
        <option value="<?php echo $usertypes['sch_id'] ?>"><?php echo $usertypes['sch_name'] ?></option>
            <?php
    }
} else {
    echo "0 results";
}
								?>
                            </select>
                        </div>
                    </div>

                   
                    
                    <div class="form-group text-right">
                        <div class="col-xs-12">
                            <button class="btn btn-purple w-md" type="submit">Log In</button>
                        </div>
                    </div>
                    <div class="form-group m-t-30">
                        <div class="col-sm-7">
                            <a href="recover.php"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                        </div>
                        <div class="col-sm-5 text-right">
                            <a href="register.php">Create an account</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    

  <?php  
	  get_end_script();
	  ?>
    
    </body>

<!-- the manlogin.htmlby ayan ahmad 07:31:29 GMT -->
</html>

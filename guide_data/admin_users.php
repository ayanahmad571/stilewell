<?php 

include('include.php');
?>
<?php 
include('page_that_has_to_be_included_for_every_user_visible_page.php');
?>

<?php

if($login == 1){
	if(trim($_USER['lum_ad']) == 1){
		$admin = 1;
	}else{
		$admin = 0;
	}
}else{
	$admin = 0;
	die('Login to View this page <a href="login.php"><button>Login</button></a>');
}


if($admin == 0){
	die('<h1>503 </h1><br>
Access Denied');
}
?>
<?php
$checkusereligibility = "SELECT * FROM `sb_modules` WHERE `mo_ifadmin`=1 and `mo_if_log_in`=1 and mo_valid =1 and FIND_IN_SET(".$_SESSION['SCHVB_USR_TU_ID'].", mo_for) > 0 and mo_href = '".trim(basename($_SERVER['PHP_SELF']))."'";
if(is_array(getdatafromsql($conn,$checkusereligibility))){
}else{
	die('<h1>503</h1><br>
Access Denied');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

<?php get_head(); ?>
        <link href="assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        
    </head>


    <body>

        <!-- Aside Start-->
        <aside class="left-panel">

            
        <?php
		give_brand();
		?>
            <?php 
			get_modules($conn,$login,$admin);
			?>
                
        </aside>
        <!-- Aside Ends-->


        <!--Main Content Start -->
        <section class="content">
            
            <!-- Header -->
            <header class="top-head container-fluid">
                <button type="button" class="navbar-toggle pull-left">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
                <!-- Left navbar -->
                <nav class=" navbar-default" role="navigation">
                    

                    <!-- Right navbar -->
                    <?php
                    if($login==1){
						include('ifloginmodalsection.php');
					}
					?>
                    
                    <!-- End right navbar -->
                </nav>
                
            </header>
            <!-- Header Ends -->


            <!-- Page Content Start -->
            <!-- ================== -->

            <div class="wraper container-fluid">
            <div class="page-title"> 
                    <h3 class="title">Welcome <?php echo ucwords($_USER['usr_name'])?> !</h3> 
                </div>



                 <!-- end row -->

                <div class="row">
                    

                    <div class="col-lg-12	">

                        <div class="panel panel-default"><!-- /primary heading -->
                            <div class="portlet-heading">
      
                            <div class="panel-heading">
                                <h3 class="panel-title">Admin/Other Users</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">
                                    <table id="datatable1" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Image</th>
                                                    <th>Email</th>
                                                    <th>Username</th>
                                            	    <th>Member Since</th>
                                                    <th>Admin</th>
                                                    <th>IP Registered</th>
                                                    <th>Expires</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
<?php

$boxsql = "SELECT * FROM `sb_logins` a left join sb_users b on a.lum_id = b.usr_rel_lum_id where lum_rel_tu_id in (1,4)";
$boxres = $conn->query($boxsql);

if ($boxres->num_rows > 0) {
    // output data of each row
	$cc =1;
    while($boxrw = $boxres->fetch_assoc()) {
		#firts loop begins
		if($boxrw['lum_valid'] == 1){
			$give = '
			<form action="master_action.php" method="post">
		<input name="yh_com" type="hidden" value="'.md5(md5(sha1(sha1(md5(md5($boxrw['lum_id'].'hir39efnewsfejirjrjdnjjenfkv ijfkorkvnkorvfk')))))).'" />
			<input type="submit" class="btn btn-danger m-t-20" name="usr_make_inac" value="Disable" />
';				}else{
			$give = '<form action="master_action.php" method="post">
		<input name="yh_com" type="hidden" value="'.md5(md5(sha1(sha1(md5(md5($boxrw['lum_id'].'hir39efnewsfejirjeofkvjrjdnjjenfkvkijonreij3nj')))))).'" />
			<input type="submit" class="btn btn-success m-t-20" name="usr_make_ac" value="Enable" />
			';
		}
		
		if($boxrw['usr_validtill'] == 0){
			$adm = 'Never ';
		}else{
			$adm = date("D d M ,Y H:i:s",$boxrw['usr_validtill']);
		}
		
		if($boxrw['lum_ad'] == 0){
			$admi_p = 'Not Admin';
		}else{
			$admi_p= 'Admin';
		}
		
		if(($boxrw['lum_id'] == $_SESSION['SCHVB_USR_DB_ID']) and ($boxrw['lum_id'] !== '1') ){
			$give .= '&nbsp;&nbsp;&nbsp;<a  data-toggle="tooltip" data-placement="top" title="You are logged in with this account. Log out to make any changes " class="btn btn-sm btn-danger m-t-20 ion-edit"></a></form>';
		}else{
			$give .= '&nbsp;&nbsp;&nbsp;<a data-toggle="modal" data-target="#'.md5(md5(sha1($boxrw['lum_id']))).'" class="btn btn-sm btn-warning m-t-20 ion-edit"></a></form>';
		}
		echo '
		<tr>
<td>'.$boxrw['usr_name'].'</td>
<td>'.$boxrw['usr_prof_pic'].'</td>
<td>'.$boxrw['lum_email'].'</td>
<td>'.$boxrw['lum_username'].'</td>
<td>'.date('M, Y',$boxrw['usr_reg_dnt']).'</td>
<td>'.$admi_p.'@'.$boxrw['lum_ad_level'].'</td>
<td>'.$boxrw['usr_reg_ip'].'</td>
<td>'.$adm.'</td>
<td>'.$give.'</td>
</tr>';
		

	
	
	
	
	
	
	
	
	
	

	
	$cc++;
	#first loop ends
	$stus = 'None';
    }
} else {
    echo "0 results";
}
 ?>                                                  
                                            </tbody>
                                        </table>
                                        <!-- -->

                               
 
 
                                        
                                 
                                        <!-- -->
                                    </div>
                                    <hr>
                                    <div class="row">
                                    <form action="master_action.php" method="post">
                                    <h4>&nbsp; Create Normal (Administrator or Other) Users</h4>
                                     <div class="col-md-12">
	<div class="panel panel-color panel-inverse">
            <div class="panel-heading"> 
                <h3 class="panel-title">Normal User</h3> 
        </div>

		<div class="panel-body"> 
<p>Name:<input required class="form-control "  name="usr_f_name" type="text" placeholder="First Name" /></p>
<p>Email: <input required  class="form-control" name="usr_email" type="email" placeholder="example@tut.man"  /></p> 
<p>Password: (Changable) <input required  class="form-control" name="usr_pw" type="text" placeholder="Password" value="<?php echo uniqid(); ?>"/></p> 
<p>Admin: <input  required  class="form-control" name="usr_acc" type="number" min="0" max="1" placeholder="1 or 0" /></p> 
<p>Access Level: <input required  class="form-control" name="usr_acc_l" type="number" min="0" max="10" placeholder="0 to 10"/></p> 
<p>Type: <input required  class="form-control" name="usr_type" type="number" min="0" max="4" placeholder='1(Admin) or 4(Others)' /></p> 
<p>Expires: <input required  class="form-control" name="usr_validtill" type="number" placeholder='Minutes from now, eg:10' /></p> 

<p><input class="btn btn-success " name="add_user" type="submit" value="Add User"/></p> 
		</div> 
	</div>
</div>

</form>


                                    </div>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    
                </div> <!-- End row -->


            </div> <!-- End row -->


            </div>
            <!-- Page Content Ends -->
            <!-- ================== -->

            <!-- Footer Start -->
            
       
 <?php
	$msql = "SELECT * FROM `sb_logins` a left join sb_users b on a.lum_id =  b.usr_rel_lum_id";
$mres = $conn->query($msql );

if ($mres->num_rows > 0) {
    // output data of each row

    while($mrw = $mres->fetch_assoc()) {
		#firts loop begins
		foreach($mrw as $me=>$m){
			$mrw[$me] = trim($m);
		}
		echo '
<div id="'.md5(md5(sha1($mrw['lum_id']))).'" class="modal fade" role="dialog">
  <div class="modal-full modal-dialog">

    <!-- Modal content-->
   <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Editing '.$mrw['usr_name'].'</h4>
      </div>
      <div class="modal-body">
        <form action="master_action.php" method="post">
		
<div class="form-group">
	<label>Email : </label>
	<input disabled type="email" class="form-control" value="'.$mrw['lum_email'].'"/>
</div>

<div class="form-group">
	<label>Username: </label>
	<input name="edit_us_username" type="text" class="form-control" value="'.$mrw['lum_username'].'"/>
</div>

<div class="form-group">
	<label>Password: (Leave Undisturbed for no Change)</label>
	<input name="edit_us_pw" type="text" class="form-control" value="-" placeholder="Leave undisturbed for no change"/>
</div>

<div class="form-group">
	<label>Admin: </label>
	<input name="edit_us_adm" type="number" min="0" max="1" class="form-control" value="'.$mrw['lum_ad'].'"/>
</div>

<div class="form-group">
	<label>Access Level: </label>
	<input name="edit_us_amdlvl" type="number" min="" max="10" class="form-control" value="'.$mrw['lum_ad_level'].'"/>
</div>

<div class="form-group">
	<label>User Name: </label>
	<input name="edit_us_nme" type="text" class="form-control" value="'.$mrw['usr_name'].'"/>
</div>

<div class="form-group">
	<label>Profile Picture (URL): </label>
	<input name="edit_us_prfpic" type="text" class="form-control" value="'.$mrw['usr_prof_pic'].'"/>
</div>

<div class="form-group">
	<label>Profile Background Picture (URL): </label>
	<input name="edit_us_prfbgpc" type="text" class="form-control" value="'.$mrw['usr_back_pic'].'"/>
</div>


<div class="form-group">
	<label>Valid Till: </label>
	<input name="edit_us_till" type="text" class="form-control" value="'.$mrw['usr_validtill'].'"/>
</div>







<div class="row">
	<div class="col-xs-6">
	<input type="hidden" value="'.md5(md5(sha1(sha1(md5(md5($mrw['lum_id'].'f2frbgbe 2fgtegrfr3gbter 24rfgr324frgtr3f 3gr32fgr32f4gr')))))).'" name="hash_chkr" />
		<input style="float:right" type="submit" class="btn btn-success" name="edit_user" value="Save">
	</div>
	<div class="col-xs-6">
		<button type="reset" class="btn btn-danger">Reset</button>
	</div>
</div>
	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>


  </div>
</div>
		
	';
	
	#first loop ends
    }
} else {
    echo "0 results";
}
 ?>             
                  <!-- Footer Start -->
            <footer class="footer">
<?php auto_copyright(); // Current year?>

  Aforty
            </footer>
            <!-- Footer Ends -->



        </section>
        <!-- Main Content Ends -->
  


      <?php  
	  get_end_script();
	  ?>   
    <script src="assets/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/datatables/dataTables.bootstrap.js"></script>


        <script type="text/javascript">
            $(document).ready(function() {
                $('#datatable1').dataTable();
            } );
        </script>
      
           </body>

</html>

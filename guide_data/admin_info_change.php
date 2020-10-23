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
?><?php
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
    <link href="assets/timepicker/bootstrap-timepicker.min.css" rel="stylesheet" />
        <link href="assets/timepicker/bootstrap-datepicker.min.css" rel="stylesheet" />

        
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
                                <h3 class="panel-title">Student/Teacher Information Updation Approval</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <!-- -->
                                         <?php

$boxsql = "select * from all_change_requests 
where sicr_valid =1
order by sicr_approved asc, sicr_dnt desc";
$boxres = $conn->query($boxsql);

if ($boxres->num_rows > 0) {
    // output data of each row
	$cc =1;
	$person = array('To Check');
	$personnewdet = array('Tos Check');
    while($boxrw = $boxres->fetch_assoc()) {
		#firts loop begins
		unset($person);
		unset($personsql);
		unset($personnewdet);
	if($boxrw['sicr_rel_tu_id'] == 3){
		$personsql = "select * from students_parents_info_rc s 
		left join schools_listed h on s.st_rel_sch_id = h.sch_id
		left join students_classes_mapping cl on s.st_rel_cls_id = cl.cls_id
		where st_db_id = ".$boxrw['sicr_db_id'];
	}else if($boxrw['sicr_rel_tu_id'] == 2){
		$personsql = "select * from sb_teachers t 
		left join schools_listed s on t.th_rel_sch_id = s.sch_id 
		where th_id = ".$boxrw['sicr_db_id'];
	}else{
		die('Invalid user type, fix before proceding');
	}
		$person = getdatafromsql($conn,$personsql);
		if(is_array($person)){
		}else{
			die('Invalid Sql Query|'.$conn->error.'|'.$personsql);
		}
		
		$personnewdet = json_decode($boxrw['sicr_data'],1);
		echo '
<div class="col-md-6">
	<div ';
			if($boxrw['sicr_valid']==1){
				echo '
style="border:5px solid green" ';
			}else{
				echo'
style="border:4px solid red" ';
			}
			echo' class="panel panel-color panel-inverse">
		<div class="panel-heading"> 
			<h3 class="panel-title">'.$boxrw['p_name'].', '.$boxrw['uid'].'</h3> 
		</div> 
		<div class="panel-body"> 
<p><strong>Type</strong>: ',($boxrw['sicr_rel_tu_id'] == 2 ? 'Teacher' :($boxrw['sicr_rel_tu_id'] == 3 ? 'Student' : 'No Idea') ).' </p>

<p><strong>Approved</strong>: ',
($boxrw['sicr_approved'] == 1 ? '<i style="font-size:15px;color:green">Yes</i>' : ($boxrw['sicr_approved'] == 0 ? '<i style="font-size:15px;color:#ffdb00">Pending</i>' : ($boxrw['sicr_approved'] == 2 ? '<i style="font-size:15px;color:red">No</i>' : 'Invalid'))).' </p>

			<p><strong>IP</strong>: '.$boxrw['sicr_ip'].'</p> 
			<p><strong>DNT</strong>: '.date('j-M-Y',$boxrw['sicr_dnt']).'</p> 

			<p>
			';
			if($boxrw['sicr_valid']==1){
				echo '
<hr style="border-bottom:6px solid green;border-radius:5px">';
			}else{
				echo'
<hr style="border-bottom:6px solid red;border-radius:5px">';
			}
			echo'
			</p>
			<hr>
			<div class="row">
				<div class="col-xs-12">
				';
			
foreach($personnewdet as $key=>$val){	
if(trim($person[$key]) !== trim($val)){				
echo '<p><strong>'.$key.': &nbsp;</strong> From <strong style="color:green;">'.$person[$key].'</strong> to <strong  style="color:red;">'.$val.'</strong></p>';
}else{
	echo '<p><strong>'.$key.': &nbsp;</strong> No Change</p>';
}
}
				echo'
				</div>
				</div>
				<hr>
			'; ?>
<div class="row">
	<div class="col-xs-6">
		<form action="master_action.php" method="post">
        	<input type="hidden"  name="usr_approve_change_sicr" value="<?php echo md5(sha1(md5(sha1(md5(sha1('38wghf3e5tyt084yt80vy487e5yt87yv58t7 y58y7t87y54nv8t7y480e0v5y4ne859dt.,.,.,'.$boxrw['sicr_id'])))))) ?>"/>
            <button type="submit" class=" btn btn-success">Approve</button>
        </form>
    </div>
	<div class="col-xs-6">
		<form action="master_action.php" method="post">
        	<input type="hidden"  name="usr_decline_change_sicr" value="<?php echo md5(sha1(md5(sha1(md5(sha1('h94283uhtu2ri943gu 240tu84u t0ut209 209utu24ut83g93uerihash.,.,.,'.$boxrw['sicr_id'])))))) ?>"/>
            <button type="submit" class="btn btn-danger">Decline</button>
        </form>
    </div>
</div>
				<?php 
				echo '
		</div> 
	</div>
</div>
                                        
	';
	if(($cc % 2) == 0){
		echo '</div><div class="row">';
	}
	$cc++;
	#first loop ends
    }
} else {
    echo "0 results";
}
 ?> 
                                 
                                        <!-- -->
                                    </div> </div>
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
       <script src="assets/timepicker/bootstrap-datepicker.js"></script>


<script>
$(document).ready(function() {
	$('.datepicker').datepicker();		
});
</script>
      
           </body>

</html>

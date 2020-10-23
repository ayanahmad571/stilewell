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
                                <h3 class="panel-title">Tabs / Modules</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <!-- -->
                                         <?php

$boxsql = "SELECT * FROM `schools_listed` ";
$boxres = $conn->query($boxsql);

if ($boxres->num_rows > 0) {
    // output data of each row
	$cc =1;
    while($boxrw = $boxres->fetch_assoc()) {
		#firts loop begins
		echo '
<div class="col-xs-12">
	<div ';
			if($boxrw['sch_valid']==1){
				echo '
style="border:5px solid green" ';
			}else{
				echo'
style="border:4px solid red" ';
			}
			echo' class="panel panel-color panel-inverse">
		<div class="panel-heading"> 
			<h3 class="panel-title">'.$boxrw['sch_name'].'<span style="float:right">
			<a data-toggle="modal" data-target="#'.md5(md5(sha1($boxrw['sch_id']))).'" style="color:white;" class="ion-edit"></a></span></h3> 
		</div> 
		<div class="panel-body"> 
			<p><strong>Shortname</strong>: '.$boxrw['sch_shortname'].'</p> 
			<p><strong>Address</strong>: <em style="color:blue">'.$boxrw['sch_address'].'</em></p> 
			<p><strong>Pincode</strong>: '.$boxrw['sch_pincode'].'</p> 
			<p><strong>City</strong>: '.$boxrw['sch_city'].'</p> 
			<p><strong>Students</strong>: '.$boxrw['sch_approx_stus'].'</p> 
			<p><strong>Class Till</strong>: '.$boxrw['sch_class_till'].'</p> 
			<p><strong>Average Fees</strong>: '.$boxrw['sch_charge_per_student_per_month'].'</p> 
			<p><strong>Contact Number</strong>: '.$boxrw['sch_contact_no'].'</p> 
			<p><strong>Email</strong>: '.$boxrw['sch_email'].'</p> 

			<p>
			';
			if($boxrw['sch_valid']==1){
				echo '
<hr style="border-bottom:6px solid green;border-radius:5px">';
			}else{
				echo'
<hr style="border-bottom:6px solid red;border-radius:5px">';
			}
			echo'
			</p>
			<p>
			';
			if($boxrw['sch_valid']==1){
				echo '
		<form action="master_action.php" method="post">
		<input name="hash_school_ina" type="hidden" value="'.md5(md5(sha1(sha1(md5(md5($boxrw['sch_id'].'hbujeio03ir94urghnje.eg.erf.wrg.rg.wgfr 309i4wef')))))).'" />
			<input type="submit" class="btn btn-danger" name="school_inact" value="Make InActive" />
		</form>
';
			}else{
				echo'
		<form action="master_action.php" method="post">
		<input name="hash_school_a" type="hidden" value="'.md5(md5(sha1(sha1(md5(md5($boxrw['sch_id'].'njhifverkof2njbjhwf.wf.wejwgfiuwrg.ivjwj bfurhib2jw')))))).'" />
		<input type="submit" class="btn btn-success" name="school_act" value="Make Active" />
		</form>';
			}
			echo'
			</p>
		</div> 
	</div>
</div>
                                        
	';
	if(($cc % 3) == 0){
		echo '</div><div class="row">';
	}
	$cc++;
	#first loop ends
    }
} else {
    echo "0 results";
}
 ?> 
 <form action="master_action.php" method="post" >
 <div class="col-xs-12">
	<div class="panel panel-color panel-inverse">
		<div class="panel-heading"> 
			<h3 class="panel-title"><input class="form-control"  required   name="add_school_name" type="text" placeholder="School Name" /></h3> 
		</div> 
		<div class="panel-body"> 
<p><strong>Shortname</strong>: <input class="form-control" required name="add_school_shortname" type="text" placeholder="EG ABC instead of Alpha Beta Corp." /></p> 
<p><strong>Address</strong>: <input class="form-control" required name="add_school_address" type="text" placeholder="Full Address" /></p> 
<p><strong>Pincode</strong>: <input class="form-control" required name="add_school_pincode" type="text" placeholder="201301" /></p> 
<p><strong>City</strong>: <input class="form-control" required name="add_school_city" type="text" placeholder="Delhi, Noida, etc" /></p> 
<p><strong>Approx Students</strong>: <input class="form-control" required name="add_school_approxstu" type="number" placeholder="1000" /></p> 
<p><strong>Class Till</strong>: <input class="form-control" required name="add_school_clstill" type="number" placeholder="12 or 10.." /></p> 
<p><strong>Average Fee per Month(1 stu)</strong>: <input class="form-control" required name="add_school_avgfee" type="number" placeholder="50000" /></p> 
<p><strong>Contact No</strong>: <input class="form-control" required name="add_school_contact" type="number" placeholder="01204561258" /></p> 
<p><strong>Email</strong>: <input class="form-control" required name="add_school_email" type="email" placeholder="info@institution.com" /></p> 

    
    		<p><input class="btn btn-success "   name="school_add" type="submit" value="Add Tab"/></p> 
		</div> 
	</div>
</div>
 </form>
 
                                        
                                 
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
            
            <!-- Footer Start -->
            
 <?php

$msql = "SELECT * FROM `schools_listed`  ";
$mres = $conn->query($msql );

if ($mres->num_rows > 0) {
    // output data of each row

    while($mrw = $mres->fetch_assoc()) {
		#firts loop begins
		echo '
<div id="'.md5(md5(sha1($mrw['sch_id']))).'" class="modal fade" role="dialog">
  <div class="modal-dialog modal-full">

    <!-- Modal content-->
   <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Editing '.$mrw['sch_name'].'</h4>
      </div>
      <div class="modal-body">
        <form action="master_action.php" method="post">
		
<div class="form-group">
	<label>Long Name : </label>
	<input type="text" name="edit_school_lngnme" class="form-control" value="'.$mrw['sch_name'].'">
</div>

<div class="form-group">
	<label>Short Name : </label>
	<input type="text" name="edit_school_shrtnme" class="form-control" value="'.$mrw['sch_shortname'].'">
</div>

<div class="form-group">
	<label>Address: </label>
	<input type="text" name="edit_school_address" class="form-control" value="'.$mrw['sch_address'].'">
</div>


<div class="form-group">
	<label>Pincode: </label>
	<input type="number" name="edit_school_pincode" class="form-control" value="'.$mrw['sch_pincode'].'">
</div>


<div class="form-group">
	<label>City : </label>
	<input type="text" name="edit_school_city" class="form-control" value="'.$mrw['sch_city'].'">
</div>

<div class="form-group">
	<label>Approx Students: </label>
	<input type="number" name="edit_school_approx_stu" class="form-control" value="'.$mrw['sch_approx_stus'].'">
</div>

<div class="form-group">
	<label>Avg Fee: </label>
	<input type="number" name="edit_school_avg_fee" class="form-control" value="'.$mrw['sch_charge_per_student_per_month'].'">
</div>

<div class="form-group">
	<label>Class Till: </label>
	<input type="text" name="edit_school_cls_till" class="form-control" value="'.$mrw['sch_class_till'].'">
</div>

<div class="form-group">
	<label>Contact Number: </label>
	<input type="number" name="edit_school_contact_no" class="form-control" value="'.$mrw['sch_contact_no'].'">
</div>

<div class="form-group">
	<label>Email: </label>
	<input type="email" name="edit_school_email" class="form-control" value="'.$mrw['sch_email'].'">
</div>






<div class="row">
	<div class="col-xs-6">
	<input type="hidden" name="hash_school_i" value="'.md5(md5(sha1(sha1(md5(md5($mrw['sch_id'].'lkoegnuifvh bnn njenjnerjfioejgior .ekrjgvv')))))).'"></input>
		<input name="edit_schools" style="float:right" type="submit" class="btn btn-success" value="Save" />
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
       <script src="assets/timepicker/bootstrap-datepicker.js"></script>


<script>
$(document).ready(function() {
	$('.datepicker').datepicker();		
});
</script>
      
           </body>

</html>

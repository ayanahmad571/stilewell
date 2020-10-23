<?php 

include('include.php');
?>
<?php 
include('page_that_has_to_be_included_for_every_user_visible_page.php');
?>

<?php

if($login == 1){
}else{
	die('Login to View this page <a href="login.php"><button>Login</button></a>');
}

?><?php
$checkusereligibility = "SELECT * FROM `sw_modules` WHERE `mo_if_log_in`=1 and mo_valid =1 and FIND_IN_SET(".$_SESSION['STWL_LUM_TU_ID'].", mo_for) > 0 and mo_href = '".trim(basename($_SERVER['PHP_SELF']))."'";
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
        <link rel="stylesheet" type="text/css" href="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
        <link rel="stylesheet" type="text/css" href="assets/jquery-multi-select/multi-select.css" />

        
    </head>


    <body>

        <!-- Aside Start-->
        <aside class="left-panel">

            
        <?php
		give_brand();
		?>
            <?php 
			get_modules($conn,$login);
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
                 <!-- end row -->
                <div class="row">
                    

                    <div class="col-lg-12	">

                        <div class="panel panel-default"><!-- /primary heading -->
                            <div class="portlet-heading">
      
                            <div class="panel-heading">
                                <h3 class="panel-title">Send Circular</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">
 <form action="master_action.php" method="post" >
 <div class="col-md-12">
	<div class="panel panel-color panel-inverse">
		<div class="panel-heading"> 
			<h3 class="panel-title">Send a Circular to parents</h3> 
		</div> 
		<div class="panel-body"> 
			<p>Title: <input class="form-control" required name="circular_title" type="text" placeholder="Stayback for Class 10" /></p> 
			<p>Notification For: <br>
				<div id="row">
                <div class="col-md-12">
                                            <select multiple="multiple" class="multi-select" id="my_multi_select2" name="circular_students[]">
                                            <?php
$sql = "select p.st_rel_cls_id,c.* from students_parents_info_rc p 
left join students_classes_mapping c on c.cls_id = p.st_rel_cls_id
where p.st_left_school=0 and p.st_valid =1 and p.st_rel_sch_id = ".$_SESSION['SCHVB_USR_SCH_ID']." group by p.st_rel_cls_id order by p.st_rel_cls_id asc ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo '
		 <optgroup label="Class '.$row['cls_words_some_num'].'">
			';
			
			$getstu = "SELECT * FROM students_parents_info_rc where st_left_school=0 and st_valid =1 and st_rel_cls_id = ".$row['cls_id']." and st_rel_sch_id = ".$_SESSION['SCHVB_USR_SCH_ID']." order by st_cls_section";
$getstu = $conn->query($getstu);

if ($getstu->num_rows > 0) {
    // output data of each row
    while($stuss = $getstu->fetch_assoc()) {
			    echo "<option value='".$stuss['st_db_id']."'>(".$stuss['st_adm_no'].")".$stuss['st_name']." Class ".$row['cls_words_some_num']."-".$stuss['st_cls_section']."</option>";

    }
} else {
    echo "<option>No Student</option>";
}


			echo'
		</optgroup>
		';
    }
} else {
    echo "No Class";
}
											?>
                                               

                                            </select>
                                        </div>
                </div>
            
            </p> 
            <br>

			<p>Content:
                                            <textarea name="circular_content" class="wysihtml5 form-control" rows="9"></textarea>
</p>
			<p><input class="btn btn-success"   name="circular_add" type="submit" value="Send Notification"/></p> 
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




<div class="row">
                    

                    <div class="col-lg-12	">

                        <div class="panel panel-default"><!-- /primary heading -->
                            <div class="portlet-heading">
      
                            <div class="panel-heading">
                                <h3 class="panel-title">Past Circulars</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <!-- -->
                                         <?php

$boxsql = "SELECT * FROM `sw_modules`";
$boxres = $conn->query($boxsql);

if ($boxres->num_rows > 0) {
    // output data of each row
	$cc =1;
    while($boxrw = $boxres->fetch_assoc()) {
		#firts loop begins
		echo '
<div class="col-md-12">
	<div class="panel panel-color panel-inverse">
		<div class="panel-heading"> 
			<h3 class="panel-title">'.$boxrw['mo_name'].'<span style="float:right">
			<a data-toggle="modal" data-target="#'.md5(md5(sha1($boxrw['mo_id']))).'" style="color:white;" class="ion-edit"></a></span></h3> 
		</div> 
		<div class="panel-body"> 
			<p>Linked to: <em style="color:blue">'.$boxrw['mo_href'].'</em></p> 
			<p>Icon: '.$boxrw['mo_icon'].' -> <i class=" '.$boxrw['mo_icon'].' "></i></p> 
			<p>Sub Menu: ' ; if($boxrw['mo_sub_mod'] == 1){echo '<i style="font-size:15px;color:green">Yes</i>';}else{echo '<i style=" font-size:15px;color:red">No</i>';} echo '</p> 
			<p>If Admin Login : '; if($boxrw['mo_ifadmin'] == 1){echo '<i style="font-size:15px;color:green">Visible</i>';}else{echo '<i style=" font-size:15px;color:red">In-Visible</i>';} echo' </p>
			<p>If Not-Admin Login : '; if($boxrw['mo_ifnoadmin'] == 1){echo '<i style="font-size:15px;color:green">Visible</i>';}else{echo '<i style=" font-size:15px;color:red">In-Visible</i>';} echo' </p>
			<p>If Not Logged in: '; if($boxrw['mo_if_no_log_in'] == 1){echo '<i style="font-size:15px;color:green">Visible</i>';}else{echo '<i style=" font-size:15px;color:red">In-Visible</i>';} echo' </p>
			<p>If Logged in : '; if($boxrw['mo_if_log_in'] == 1){echo '<i style="font-size:15px;color:green">Visible</i>';}else{echo '<i style=" font-size:15px;color:red">In-Visible</i>';} echo' </p>
			<p>Badge: '.$boxrw['mo_badge_info'].'</p> 
			<p>Allowed: '.$boxrw['mo_for'].'</p> 
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
                                        <!-- -->
                                    </div> </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    
                </div> <!-- End row -->


            </div>
            
            </div>
            <!-- Page Content Ends -->
            <!-- ================== -->

            <!-- Footer Start -->
            
            <!-- Footer Start -->
            
      
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
        <script type="text/javascript" src="assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
        <script type="text/javascript" src="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
        <script type="text/javascript" src="assets/jquery-multi-select/jquery.multi-select.js"></script>


        <script>

            $(document).ready(function(){
                $('.wysihtml5').wysihtml5();
                $('#my_multi_select2').multiSelect({
                    selectableOptgroup: true
                });
				
				});

				
			
			
        </script>


      
           </body>

</html>

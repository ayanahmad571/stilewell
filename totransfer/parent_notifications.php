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
                                <h3 class="panel-title">Send A Notification</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">
 <form action="master_action.php" method="post" >
 <div class="col-md-12">
	<div class="panel panel-color panel-inverse">
		<div class="panel-heading"> 
			<h3 class="panel-title">Add a Notification</h3> 
		</div> 
		<div class="panel-body"> 
			<p>Title: <input class="form-control" required name="noti_title" type="text" placeholder="Stayback for Class 10" /></p> 
			<p>Notification For: <br>
				<div id="row">
                <div class="col-md-12">
                                            <select multiple="multiple" class="multi-select" id="my_multi_select2" name="noti_students[]">
                                        <?php
											
$sql = "
select DISTINCT(concat(c.cls_words_some_rom,'-',p.st_cls_section)) as vall ,c.*,p.* from students_parents_info_rc p
left join students_classes_mapping c on p.st_rel_cls_id = c.cls_id 
where p.st_rel_sch_id =".$_SESSION['SCHVB_USR_SCH_ID']." and p.st_rel_th_id = ".$_USER['th_id']." and p.st_left_school = 0 and p.st_valid =1 
order by CAST( c.cls_numeric as unsigned), p.st_cls_section



";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo '
		 <optgroup label="Class '.$row['vall'].'">
			';
			
			$getstu = "SELECT * FROM students_parents_info_rc where st_left_school=0 and st_valid =1 and st_rel_cls_id = ".$row['cls_id']." and st_rel_th_id =".$_USER['th_id']." and st_rel_sch_id = ".$_SESSION['SCHVB_USR_SCH_ID']." and st_cls_section = '".trim($row['st_cls_section'])."' order  by st_cls_section";
			echo $getstu;
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
                                            <textarea name="noti_content" class="wysihtml5 form-control" rows="9"></textarea>
</p>
			<p><input class="btn btn-success"   name="noti_add" type="submit" value="Send Notification"/></p> 
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
                                <h3 class="panel-title">Past Notifications</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <!-- -->
                                         <?php

$boxsql = "SELECT  FROM `sw_modules`";
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
            
 <?php

$msql = "SELECT  FROM `sw_modules` ";
$mres = $conn->query($msql );

if ($mres->num_rows > 0) {
    // output data of each row

    while($mrw = $mres->fetch_assoc()) {
		#firts loop begins
		echo '
<div id="'.md5(md5(sha1($mrw['mo_id']))).'" class="modal fade" role="dialog">
  <div class="modal-dialog modal-full">

    <!-- Modal content-->
   <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Editing '.$mrw['mo_name'].'</h4>
      </div>
      <div class="modal-body">
        <form action="master_action.php" method="post">
		
<div class="form-group">
	<label>Long Name : </label>
	<input type="text" name="edit_mod_lngnme" class="form-control" value="'.$mrw['mo_name'].'">
</div>

<div class="form-group">
	<label>Identification Name/ Short Name (Linked to) : </label>
	<input type="text" name="edit_mod_shrtnme" class="form-control" value="'.$mrw['mo_href'].'">
</div>

<div class="form-group">
	<label>Icon : </label>
	<input type="text" name="edit_mod_icon" class="form-control" value="'.$mrw['mo_icon'].'">
</div>


<div class="form-group">
	<label>Sub Module: </label>
	<input type="text" name="edit_mod_sub" class="form-control" value="'.$mrw['mo_sub_mod'].'">
</div>
<div class="form-group">
	<label>For: </label>
	<input type="text" name="edit_mod_for" class="form-control" value="'.$mrw['mo_for'].'">
</div>


<div class="form-group">
	<label>If No Admin:</label>
	<input type="text" name="edit_ifnoadmin" class="form-control" value="'.$mrw['mo_ifnoadmin'].'">
</div>

<div class="form-group">
	<label>If Admin: </label>
	<input type="text" name="edit_ifadmin" class="form-control" value="'.$mrw['mo_ifadmin'].'">
</div>

<div class="form-group">
	<label>If Logged In: </label>
	<input type="text" name="edit_iflogin" class="form-control" value="'.$mrw['mo_if_log_in'].'">
</div>

<div class="form-group">
	<label>If not Logged out: </label>
	<input type="text" name="edit_ifnologin" class="form-control" value="'.$mrw['mo_if_no_log_in'].'">
</div>



<div class="row">
	<div class="col-xs-6">
	<input type="hidden" name="hash_emmp__1i" value="'.md5(md5(sha1(sha1(md5(md5($mrw['mo_id'].'lkoegnuifvh bnn njenjn')))))).'"></input>
		<input name="edit_mod" style="float:right" type="submit" class="btn btn-success" value="Save" />
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

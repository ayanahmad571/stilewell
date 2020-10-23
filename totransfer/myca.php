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
	
}

?>
<!DOCTYPE html>
<html lang="en">
    
<!-- the manprofile.htmlby ayan ahmad 07:31:23 GMT -->
<head>
        <?php get_head(); ?>
    <!-- Dropzone css -->
    <link href="assets/timepicker/bootstrap-timepicker.min.css" rel="stylesheet" />
        <link href="assets/timepicker/bootstrap-datepicker.min.css" rel="stylesheet" />

<style>
.mini-stat{
	border:1px solid black;
}
</style>
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
            
            <?php
			
			 $usertypeid =$_SESSION['STWL_LUM_TU_ID'] ; ?>
            <!-- ================== -->
<?php
switch ($usertypeid) {
    case "1":
$user_name= $_USER['usr_name'];
$user_profpic= $_USER['usr_prof_pic'];
$user_backpic= $_USER['usr_back_pic'];
$user_name= $_USER['usr_name'];

        break;
    case "2":
$user_name= $_USER['th_name'];
$user_profpic= $_USER['th_prof_pic'];
$user_backpic= $_USER['th_back_pic'];
$user_name= $_USER['th_name'];
        break;
    case "3":
$user_name= $_USER['st_name'];
$user_profpic= $_USER['st_prof_pic'];
$user_backpic= $_USER['st_back_pic'];
$user_name= $_USER['st_name'];
        break;
    case "4":
$user_name= $_USER['usr_name'];
$user_profpic= $_USER['usr_prof_pic'];
$user_backpic= $_USER['usr_back_pic'];
$user_name= $_USER['usr_name'];
        break;
    default:
die("Invalid Id");
}
?>

            <div class="wraper container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="bg-picture" style="background-image:url('<?php echo $user_backpic ?>')">
                          <span class="bg-picture-overlay"></span><!-- overlay -->
                          <!-- meta -->
                          <div class="box-layout meta bottom">
                            <div class="col-sm-6 clearfix">
                              <span class="img-wrapper pull-left m-r-15"><img src="<?php echo $user_profpic ?>" alt="" style="width:64px" class="br-radius"></span>
                              <div class="media-body">
                                <h3 class="text-white mb-2 m-t-10 ellipsis"><?php echo ucwords($user_name )?></h3>
 <?php if(($usertypeid==1) or ($usertypeid ==4)){ ?>  <h5 class="text-white"><?php echo $_USER['lum_username'] ?></h5><?php } ?>
 <?php if(($usertypeid==2)){ ?>  <h5 class="text-white"><?php $get_t_s =getdatafromsql($conn,"select concat(sch_name,', ',sch_city) as sch_nm from schools_listed where sch_id= ".$_USER['th_rel_sch_id']);
 if(is_array($get_t_s)){
	 echo $get_t_s['sch_nm'];
 }else{die("No School Found");}?></h5><?php } ?>
 
 <?php if(($usertypeid==3)){ ?>  <h5 class="text-white"><?php $get_t_s =getdatafromsql($conn,"select concat(sch_name,', ',sch_city) as sch_nm from schools_listed where sch_id= ".$_USER['st_rel_sch_id']);
 if(is_array($get_t_s)){
	 echo $get_t_s['sch_nm'];
 }else{die("No School Found");}?></h5><?php } ?>
                              </div>
                            </div>
                           <?php /*
 <div class="col-sm-6">

                              <div class="pull-right">
                                <div class="dropdown">
                                    <a data-toggle="dropdown" class="dropdown-toggle btn btn-primary" href="#"> Following <span class="caret"></span></a>
                                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                        <li><a href="#">Poke</a></li>
                                        <li><a href="#">Private message</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Unfollow</a></li>
                                    </ul>
                                </div>
                              </div>
                            </div> */ ?>

                          </div>
                          <!--/ meta -->
                        </div>
                    </div>
                </div>

                <div class="row m-t-30">
                    <div class="col-sm-12">
                        <div class="panel panel-default p-0">
                            <div class="panel-body p-0"> 
                                <ul class="nav nav-tabs profile-tabs">
                                    <li class="active"><a data-toggle="tab" href="#aboutme">About Me</a></li>
<?php if(($usertypeid==1) or ($usertypeid ==4)){ ?><li class=""><a data-toggle="tab" href="#user-activities">Current Activity</a></li><?php }?>
                                    <li class=""><a data-toggle="tab" href="#edit-profile">Settings</a></li>
<?php if(($usertypeid==2)){ ?><li class=""><a data-toggle="tab" href="#projects">Students Teaching</a></li><?php }?>
<?php if(($usertypeid==2)){ ?><li class=""><a data-toggle="tab" href="#payg">Payments Recieved</a></li><?php }?>
                                </ul>

                                <div class="tab-content m-0"> 

                                    <div id="aboutme" class="tab-pane active">
                                    <div class="profile-desk">
                                        <?php if(($usertypeid==1) or ($usertypeid ==4)){ ?>
                                        <h3><?php echo ucwords($user_name )?></h3>
                                        <span class="designation">Member Since <strong>
										<?php echo date('M, Y',$_USER['usr_reg_dnt'] )?></strong></span>
                                       <?php } ?>
                                       
                                        <table class="table table-condensed">
                                            <thead>
                                                <tr>
                                                    <th colspan="3"><h3> Information</h3></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                        <?php if(($usertypeid==1) or ($usertypeid ==4)){ ?>
                                                <tr>
                                                    <td><b>Full Name</b></td>
                                                    <td>
                                                        <?php echo ($_USER['usr_name'] )?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Email</b></td>
                                                    <td>
                                                        <?php echo ($_USER['lum_email'] )?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                      <td><strong>Username</strong></td>
                                                    <td>
                                                        <?php echo ($_USER['lum_username'] )?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Admin-Level</b></td>
                                                    <td>
                                                        <?php echo ($_USER['lum_ad_level'] )?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Defaut Password</b></td>
                                                    <td>
                                                        <?php echo ($_USER['lum_pass_def'] )?>
                                                    </td>
                                                </tr>
                                                 <?php } ?>
                                                 
                                                 
                                        <?php if(($usertypeid == 2)){ ?>
                                                <tr>
                                                    <td><b>Email</b></td>
                                                    <td>
                                                        <?php echo ($_USER['lum_email'] )?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                      <td><strong>Full Name</strong></td>
                                                    <td>
                                                   <?php echo ($_USER['th_name'] )?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Dob</b></td>
                                                    <td>
                                                        <?php echo (date('D-M-Y',$_USER['th_dob'] ))?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Contact Number</b></td>
                                                    <td>
                                                        <?php echo ($_USER['th_contact_no'] )?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Gender</b></td>
                                                    <td>
                                                        <?php echo ($_USER['th_gender'] )?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Subject</b></td>
                                                    <td>
                                                        <?php echo ($_USER['th_subject'] )?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Classes Teaching</b></td>
                                                    <td>
                                                        <?php echo ($_USER['th_teach_class'] )?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Default Password</b></td>
                                                    <td>
                                                        <?php echo ($_USER['lum_pass_def'] )?>
                                                    </td>
                                                </tr>
                                                

                                                 <?php } ?>
                                                 
                                                    <?php if(($usertypeid == 3)){ ?>
                                                <tr>
                                                    <td><b>Admission Number</b></td>
                                                    <td>
                                                        <?php echo ($_USER['st_adm_no'] )?>
                                                    </td>
                                                </tr>
                                                 <tr>
                                                      <td><strong>Full Name</strong></td>
                                                    <td>
                                                   <?php echo ($_USER['st_name'] )?>
                                                    </td>
                                                </tr>
												 <tr>
                                                    <td><b>House</b></td>
                                                    <td>
                                                        <?php echo ($_USER['st_house'] )?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Class</b></td>
                                                    <td>
                                                        <?php 
				$get_u_c = getdatafromsql($conn,"select * from students_classes_mapping where cls_id=".$_USER['st_rel_cls_id']);
													if(is_array($get_u_c)){
														echo $get_u_c['cls_words_some_rom'].'-'.$_USER['st_cls_section'];
													}else{
														echo ('No class Found');}?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Student Type</b></td>
                                                    <td>
<?php				$get_s_ty = getdatafromsql($conn,"select * from student_types_all where styp_id=".$_USER['st_rel_styp_id']);
													if(is_array($get_s_ty)){
														echo $get_s_ty['styp_name'];
													}else{
														echo ('No Type Found');}?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Gender</b></td>
                                                    <td>
                                                        <?php echo ($_USER['st_gender'] )?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Dob</b></td>
                                                    <td>
                                                        <?php echo (date('j-M-Y',$_USER['st_dob'] ))?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Father Details</b></td>
                                                    <td>
                                           <strong>Name</strong>: <u><?php echo ($_USER['st_father_name'] )?></u><br>
                                           <strong>Contact Number</strong>: <u><?php echo ($_USER['st_father_contact_no'] )?></u><br>
                                           <strong>Email</strong>:<u> <?php echo ($_USER['st_father_email'] )?></u><br>
                                           <strong>Profession</strong>: <u><?php echo ($_USER['st_father_profession'] )?></u><br>
                                           <strong>SMS Allowed</strong>:<u> <?php echo ($_USER['st_father_sms_ok'] == 1 ? 'Yes':"No")?></u><br>
                                           <strong>Email Allowed</strong>: <u><?php echo ($_USER['st_father_email_ok'] == 1 ? 'Yes':"No")?></u>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Mother Details</b></td>
                                                    <td>
                                           <strong>Name</strong>: <u><?php echo ($_USER['st_mother_name'] )?></u><br>
                                           <strong>Contact Number</strong>: <u><?php echo ($_USER['st_mother_contact_no'] )?></u><br>
                                           <strong>Email</strong>:<u> <?php echo ($_USER['st_mother_email'] )?></u><br>
                                           <strong>Profession</strong>: <u><?php echo ($_USER['st_mother_profession'] )?></u><br>
                                           <strong>SMS Allowed</strong>:<u> <?php echo ($_USER['st_mother_sms_ok'] == 1 ? 'Yes':"No")?></u><br>
                                           <strong>Email Allowed</strong>: <u><?php echo ($_USER['st_mother_email_ok'] == 1 ? 'Yes':"No")?></u>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Default Password</b></td>
                                                    <td>
                                                        <?php echo ($_USER['lum_pass_def'] )?>
                                                    </td>
                                                </tr>
                                                

                                                 <?php } ?>
                                                 
                                                 
                                                 
                                                 
                                                 
                                                 
                                                 
                                            </tbody>
                                        </table>
                                    </div> <!-- end profile-desk -->
                                </div> <!-- about-me -->


		<?php if(($usertypeid==1) or ($usertypeid ==4)){ ?>
    <!-- Activities -->
                                <div id="user-activities" class="tab-pane">
                                    <div class="timeline-2">
                                    
                                        <?php
$getlogssql = "SELECT * FROM page_views where pg_visit_hash = '".$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID']."' and 
pg_v_valid =1 order by pg_dnt desc";
$getlogsres= $conn->query($getlogssql);
if ($getlogsres->num_rows > 0) {
    // output data of each row
    while($getlogsrw = $getlogsres->fetch_assoc()) {
        echo '
		<div class="time-item">
                                            <div class="item-info">
                                                <div class="text-muted">'.
												time_elapsed_string($getlogsrw['pg_dnt']).'</div>
                                                <p>You visited <a href="#" class="text-info">'.$getlogsrw['pg_name'].'</a> .</p>
                                            </div>
											</div>

		';
    }
} else {
    
}
 ?> 
                                        
                                        
                                        
                                    </div>
                                </div>
                                <?php } ?>

                                <!-- settings -->
                                <div id="edit-profile" class="tab-pane">
                                    <div class="user-profile-content">
                                    
                                    
                                     <div class="row">
                                     
                                     
					<div class="col-md-4">
                        <div style="cursor:pointer" data-toggle="modal" data-target="#chDet" class="mini-stat clearfix">
                            <span class="mini-stat-icon bg-info"><i class="fa fa-list"></i></span>
                            <div class="mini-stat-info text-right">
                              <h3>  Change Details</h3>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div style="cursor:pointer" data-toggle="modal" data-target="#chPass" class="mini-stat clearfix">
                            <span class="mini-stat-icon bg-info"><i class="fa fa-asterisk "></i></span>
                            <div class="mini-stat-info text-right">
                             <h3> Change Password</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="cursor:pointer" data-toggle="modal" data-target="#chProfPic" class="mini-stat clearfix">
                            <span class="mini-stat-icon bg-info"><i class="fa fa-file-image-o"></i></span>
                            <div class="mini-stat-info text-right">
                              <h3>  Change Profile Picture</h3>
                            </div>
                        </div>
                    </div>
                   
                    
                </div> <!-- end row -->
                                    <script>
									function GotoPg( a){
										window.location = a;
									}
</script>
                                    
                                    
                                    
                                        
                                    </div>
                                </div>

		<?php if($usertypeid==2){ ?>

                                <!-- profile -->
                                <div id="projects" class="tab-pane">
                                    <div class="row m-t-10">
                                        <div class="col-md-12">
                                            <div class="portlet"><!-- /primary heading -->
                                                <div id="portlet2" class="panel-collapse collapse in">
                                                    <div class="portlet-body">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Class</th>
                                                                        <th>Section</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                   <?php
$getmunssql = "select DISTINCT c.cls_words_some_rom,p.st_cls_section  ,
cls_numeric from students_parents_info_rc p
left join students_classes_mapping c on p.st_rel_cls_id = c.cls_id 
where p.st_rel_sch_id =".$_SESSION['SCHVB_USR_SCH_ID']." and p.st_rel_th_id = ".$_USER['th_id']." and p.st_left_school = 0 and p.st_valid =1 
order by CAST( c.cls_numeric as unsigned), p.st_cls_section
";
$getmunsres= $conn->query($getmunssql);
if ($getmunsres->num_rows > 0) {
    // output data of each row
	$rrt = 1;
    while($getmunsrw = $getmunsres->fetch_assoc()) {
		
        echo '
<tr>
<td>'.$rrt.'</td>
<td>'.$getmunsrw['cls_words_some_rom'].'</td>
<td>'.$getmunsrw['st_cls_section'].'</td>
</tr>

		';
    
	$rrt++;}
} else {
    echo $conn->error;
}
 ?> 
                       
                                                                    
                                                                  
                                                                    
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- /Portlet -->
                                        </div>
                                    </div>
                                </div>
                                <?php }?>
                                <div id="payg" class="tab-pane">
                                    <div class="row m-t-10">
                                        <div class="col-md-12">
                                            <div class="portlet"><!-- /primary heading -->
                                                <div id="portlet2" class="panel-collapse collapse in">
                                                    <div class="portlet-body">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Student Name</th>
                                                                        <th>Amount</th>
                                                                        <th>Date</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                   <?php
$getmunssql = "SELECT p.*,s.st_name FROM `tut_student_payment` p left join tut_students s on p.adv_rel_st_id = s.st_id
where p.adv_valid =1 and p.adv_rel_lum_id = ".$_SESSION['STWL_LUM_DB_ID']." and s.st_valid = 1 and s.st_rel_lum_id= ".$_SESSION['STWL_LUM_DB_ID']." order by adv_dnt desc";
$getmunsres= $conn->query($getmunssql);
if ($getmunsres->num_rows > 0) {
    // output data of each row
	$rrt = 1;
	$moneyg = 0;
    while($getmunsrw = $getmunsres->fetch_assoc()) {
		
        echo '
		<tr>
                                                                        <td>'.$rrt.'</td>
                                                                        <td>'.$getmunsrw['st_name'].'</td>
                                                                        <td>'.$getmunsrw['adv_value'].'</td>
                                                                     <td> '.date('j-M, Y',$getmunsrw['adv_dnt']).'</td>
                                                                        
                                                                    </tr>

		';
    $moneyg = $moneyg + $getmunsrw['adv_value'];
	$rrt++;}
} else {
    
}
 ?> 
     <tr>
    <td colspan="6">
    <h4 align="right">Total:<?php echo $moneyg; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h4>
    </td>
    </tr>                     
                                                                    
                                                                  
                                                                    
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- /Portlet -->
                                        </div>
                                    </div>
                                </div>
                                
                                
                            </div>
             
                        </div> 
                    </div>
                </div>
            </div>

            

            


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
        

<div id="chDet" class="modal fade" role="dialog" >
                                    <div class="modal-dialog modal-full">
                                   
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" id="full-width-modalLabel">Change Details</h4>
                                            </div>
                                            <div class="modal-body">

<?php if(($usertypeid == 1) or ($usertypeid ==4)){ ?>
					<form action="master_action.php" method="post">
                                               
                                            <div class="form-group">
                                                <label for="unn">Full Name</label>
                                                <input type="text" value="<?php echo $_USER['usr_name'] ?>" id="unn" name="ch_usr_name" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="Email">Email</label>
                                                <input type="email" disabled value="<?php echo $_USER['lum_email'] ?>" id="Email" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="Username">Username</label>
                                                <input disabled type="text" value="<?php echo $_USER['lum_username'] ?>" id="Username" class="form-control">
                                            </div>
                                          
<input type="hidden" name="ch_det" value="<?php echo md5(sha1(time()).uniqid().md5('Hola')) ?>" />                                           
                       <div class="row">
	<div class="col-xs-6">
		<input required  style="float:right" type="submit" class="btn btn-success" name="student_edit_user" value="Save">
	</div>
	<div class="col-xs-6">
		<button type="reset" class="btn btn-danger">Reset</button>
	</div>
</div>                    
                                        </form>
                                        <?php } ?>
                                        
<?php if(($usertypeid == 3)){ 
												echo '
        <form action="master_action.php" method="post">
<div class="form-group">
	<label>Child Name: </label>
	<input required  name="student_edit_name" type="text" class="form-control" value="'.$_USER['st_name'].'"/>
</div>

<div class="form-group">
	<label>Father Name: </label>
	<input required  name="student_edit_st_father_name" type="text" class="form-control" value="'.$_USER['st_father_name'].'"/>
</div>


<div class="form-group">
	<label>Mother Name: </label>
	<input required  name="student_edit_st_mother_name" type="text" class="form-control" value="'.$_USER['st_mother_name'].'"/>
</div>

<div class="form-group">
	<label>Father Contact Number: </label>
	<input required  name="student_edit_st_father_contc" type="text" class="form-control" value="'.$_USER['st_father_contact_no'].'"/>
</div>


<div class="form-group">
	<label>Mother Contact Number: </label>
	<input required  name="student_edit_st_mother_contc" type="text" class="form-control" value="'.$_USER['st_mother_contact_no'].'"/>
</div>

<div class="form-group">
	<label>Father Email: </label>
	<input required  name="student_edit_st_father_email" type="text" class="form-control" value="'.$_USER['st_father_email'].'"/>
</div>

<div class="form-group">
	<label>Mother Email: </label>
	<input required  name="student_edit_st_mother_email" type="text" class="form-control" value="'.$_USER['st_mother_email'].'"/>
</div>



<div class="form-group">
	<label>Address: </label>
	<input required  name="student_edit_st_address" type="text" class="form-control" value="'.$_USER['st_address'].'"/>
</div>


<div class="form-group">
	<label>Father Profession: </label>
	<input required  name="student_edit_st_father_profession" type="text" class="form-control" value="'.$_USER['st_father_profession'].'"/>
</div>


<div class="form-group">
	<label>Mother Profession: </label>
	<input required  name="student_edit_st_mother_profession" type="text" class="form-control" value="'.$_USER['st_mother_profession'].'"/>
</div>

<div class="row">
	<div class="col-xs-6">
	<input required  type="hidden" value="'.md5(md5(sha1(sha1(md5(md5($_USER['st_db_id'].'jniuhediuwesvnijkisuvjd.24rfgr324frgtr3f 3gr32fgr32f4gr')))))).'" name="student_st_hash" />
		<input required  style="float:right" type="submit" class="btn btn-info" name="student_edit_user" value="Request Change">
	</div>
	<div class="col-xs-6">
		<button type="reset" class="btn btn-danger">Reset</button>
	</div>
</div>
	</form>
		
	';
										 } ?>                                        
										 
<?php if(($usertypeid == 2)){ 
												echo '
        <form action="master_action.php" method="post">
<div class="form-group">
	<label>Name: </label>
	<input required  name="teacher_edit_th_name" type="text" class="form-control" value="'.$_USER['th_name'].'"/>
</div>



<div class="form-group">
	<label>Subject: </label>
	<input required  name="teacher_edit_th_subject" type="text" class="form-control" value="'.$_USER['th_subject'].'"/>
</div>


<div class="form-group">
	<label>Classes: </label>
	<input required  name="teacher_edit_th_teach_class" type="text" class="form-control" value="'.$_USER['th_teach_class'].'"/>
</div>


<div class="form-group">
	<label>Contact Number: </label>
	<input required  name="teacher_edit_th_contact_no" type="numbers" class="form-control" value="'.$_USER['th_contact_no'].'"/>
</div>




<div class="row">
	<div class="col-xs-6">
	<input required  type="hidden" value="'.md5(md5(sha1(sha1(md5(md5($_USER['th_id'].'f2frboirsjfoeirhnowr...enjuvgr32fgr32f4gr')))))).'"
	 name="teacher_change_hash" />
		<input required  style="float:right" type="submit" class="btn btn-info" name="teacher_edit_user" value="Request Change">
	</div>
	<div class="col-xs-6">
		<button type="reset" class="btn btn-danger">Reset</button>
	</div>
</div>
	</form>
		
	';
	

										 }?>
                                        
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                                
                                
                                <div id="chPass" class="modal fade" role="dialog" >
                                    <div class="modal-dialog modal-full">
                                    <script type="text/javascript" language="JavaScript">
function checkMe(theForm) {
    if (theForm.pw.value != theForm.npw.value)
    {
        alert('Those passwords don\'t match!');
        return false;
    } else {
        return true;
    }
}
//-->

</script> 

                                      <form action="master_action.php" method="post" id="gromf" onsubmit="return checkMe(this);">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" id="full-width-modalLabel">Change Password</h4>
                                            </div>
                                            <div class="modal-body">
                                              
                                            
                                            <div class="form-group">
                                                <label for="Password">Password</label>
                                                <input name="pw" type="password" required placeholder="Enter new Password" id="Password" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="RePassword">Re-Password</label>
                                                <input name="npw" type="password" required placeholder="Re enter New Password" id="RePassword" class="form-control">
                                            </div>
                                       
                                            </div>
                                            <div class="modal-footer">
                                            <input type="hidden" name="ch_pw" value="<?php echo md5(uniqid().uniqid()) ?>"/>
                                                <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    
                                        </form>
                                    </div><!-- /.modal-dialog -->
                                </div>
                                
                                
                                <div id="chProfPic" class="modal fade" role="dialog" >
                                    <div class="modal-dialog modal-full">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" id="full-width-modalLabel">Profile Picture</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                    <div class="col-md-12 portlets">
                        <!-- Your awesome content goes here -->
                        <div class="m-b-30">
                            <form  action="master_action.php" method="post" enctype="multipart/form-data" >
                              <div class="fallback">
                                  <label class="btn btn-default btn-file">
        Browse <input name="ch_imgg" type="file" accept="image/*" onchange="loadFile(event)" style="display: none;">
    </label>
    
    <br><br>
<br>

<input id="upld_i" class="hidden btn btn-sucess" type="submit" name="ch_img" value="Click to Upload" />
    <div class="row">
        <div class="col-xs-offset-4 col-xs-4">
        	<img class="img-responsive" id="output"/>
        </div>
    </div>
    <script>
	  var loadFile = function(event) {
		var reader = new FileReader();
		reader.onload = function(){
		  var output = document.getElementById('output');
		  output.src = reader.result;
		};
		reader.readAsDataURL(event.target.files[0]);
		$('#upld_i').removeClass('hidden');
		
	  };
    </script>                           

			
                              </div>
                             
                              
                             
                            </form>
                        </div>
                    </div>
                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                                
                                
                                


   <?php  
	  get_end_script();
	  ?>
<?php /*
       <!-- google maps api -->
               <!-- Page Specific JS Libraries -->
           <script>
	
 function initMap() {


var myLatLng = {lat: <?php echo $_USER['usr_lat'] ?>, lng: <?php echo $_USER['usr_long'] ?>};

        var map = new google.maps.Map(document.getElementById('googleMap'), {
          zoom: 1,
          center: myLatLng
        });

       var marker = new google.maps.Marker({
    position: myLatLng,
    map: map,
    draggable:true,
    title:"Choose Location!"
});

//get marker position and store in hidden input
google.maps.event.addListener(marker, 'dragend', function (evt) {
    document.getElementById("latInput").value = evt.latLng.lat().toFixed(3);
    document.getElementById("lngInput").value = evt.latLng.lng().toFixed(3);
});

 }
</script>
        <script async defer src="http://maps.google.com/maps/api/js?key=AIzaSyBcrfT9j4-LebvmWHyc27iKL0d13EbBObQ&callback=initMap"></script>
        */
        ?>
      <script>
!function($) {
    "use strict";

    var SweetAlert = function() {};

    //examples 
    SweetAlert.prototype.init = function() {
        
<?php 

if(isset($_GET['rqssisid'])){
	
	echo ' $(document).ready(function(){
        swal("Request Sent!", "A request regarding updation of details has been sent. The details will be updated once they are confirmed.", "success")
    });';
}
?>
    //Success Message
   


    },
    //init
    $.SweetAlert = new SweetAlert, $.SweetAlert.Constructor = SweetAlert
}(window.jQuery),

//initializing 
function($) {
    "use strict";
    $.SweetAlert.init()
}(window.jQuery);
</script>

 
  </body>

<!-- the manprofile.htmlby ayan ahmad 07:31:23 GMT -->
</html>

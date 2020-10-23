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
                                <h3 class="panel-title"><?php if(isset($_GET['sti']) and ctype_alnum($_GET['sti'])){
									
									$get_school_t = getdatafromsql($conn,"select * from schools_listed where 
md5(sha1(concat(sch_id,'HGYURBVFRBRGWIOGRU92UWHFGOIWHTOGIUEO8HG384IWGOIRHWGIUHREJFGKN'))) ='".$_GET['sti']."' and  sch_valid=1 ");
if(is_array($get_school_t)){
	echo 'Student Logins'.' for '.$get_school_t['sch_name'].', '.$get_school_t['sch_city'];
}else{
	echo 'Select School';
}
 }else{echo 'Select School';}?></h3>
                            </div>
                            <?php if(!isset($_GET['sti']) or !ctype_alnum($_GET['sti'])){ 
							
							$getschoolssql = "select * from schools_listed";
$getschoolssqlresult = $conn->query($getschoolssql);

if ($getschoolssqlresult->num_rows > 0) {
    // output data of each row
	?>      <br>
  <div class="row">
                                    <table id="datatable1" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Shortname</th>
                                                    <th>Address</th>
                                                    <th>Valid</th>
                                            	    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody><?php
    while($getschoolssqlresultrow = $getschoolssqlresult->fetch_assoc()) {
        ?>

                                                
<?php
		echo '
		<tr>
<td>'.$getschoolssqlresultrow['sch_name'].'</td>
<td>'.$getschoolssqlresultrow['sch_shortname'].'</td>
<td>'.$getschoolssqlresultrow['sch_address'].'</td>
<td>';
if($getschoolssqlresultrow['sch_valid']==1){echo"<i class='fa fa-circle' style='color:green'></i>";}else{echo"<i class='fa fa-circle' style='color:red'></i>";}
echo '</td>
<td><form action="admin_stu_logins.php" method="get">
		<input required  name="sti" type="hidden" value="'.
md5(sha1($getschoolssqlresultrow['sch_id'].'HGYURBVFRBRGWIOGRU92UWHFGOIWHTOGIUEO8HG384IWGOIRHWGIUHREJFGKN')).'" />
			<input required  type="submit" class="btn btn-warning m-t-20" value="Select" /></form></td>
</tr>';
 ?>                                                  
        <?php
    }
	?>
                                                </tbody>
                                        </table>
                                        <!-- -->
                                    </div>

    <?php
} else {
    echo "0 results";
}
							}else{
$sti_iid = $_GET['sti'];
if(!ctype_alnum($sti_iid)){
	die('Invalid SchoolID');
}

$getschool_data_sql = "select * from schools_listed where 
md5(sha1(concat(sch_id,'HGYURBVFRBRGWIOGRU92UWHFGOIWHTOGIUEO8HG384IWGOIRHWGIUHREJFGKN'))) ='".$sti_iid."' and  sch_valid=1 ";

$school = array();
$getschool_data_res = $conn->query($getschool_data_sql);

if ($getschool_data_res->num_rows ==1) {
    // output data of each row
    while($getschool_data_rw = $getschool_data_res->fetch_assoc()) {
		foreach($getschool_data_rw as $sdl =>$sdr){
				 $school[$sdl] = trim($sdr);
			}
		
    }
} else {
   die('Invalid School');
}

?>

<div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">
                                    <table id="datatable2" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>AdmNo</th>
                                                    <th>Image</th>
                                                    <th>Class</th>
                                                    <th>Father Name</th>
                                            	    <th>Mother Name</th>
                                                    <th>DOB</th>
                                                    <th>Gender</th>
                                                    <th class="no-sort">Login</th>
                                                    <th class="no-sort"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
<?php
/*
$boxsql = "SELECT s.*,c.*,l.lum_valid,IFNULL(l.lum_pass_def,'None') as lum_pass_def  FROM `students_parents_info_rc` s
left join students_classes_mapping c on c.cls_id = s.st_rel_cls_id
left join sb_logins l on l.lum_id = s.st_rel_lum_id
where s.st_valid =1 and s.st_rel_sch_id = ".$school['sch_id'].'
LIMIT 10
';
$boxres = $conn->query($boxsql);

if ($boxres->num_rows > 0) {
    // output data of each row
	$cc =1;
    while($boxrw = $boxres->fetch_assoc()) {
		#firts loop begins
		if(($boxrw['st_rel_lum_id'] == 0) or (($boxrw['lum_valid']) == 0) and ($boxrw['st_rel_lum_id'] > 0)){
$give = '

<form action="master_action.php" method="post">
<input required  name="actv_login_onesstu_h" type="hidden" value="'.md5(md5(sha1(sha1(md5(md5($boxrw['st_db_id'].'hir39efnewsfejirjeofkvjrjdnjjenfkvkijonreij3nj')))))).'" />

<input required  type="submit" class="btn-sm btn btn-success" name="actv_login_onesstu" value="Create Login" />
</form>';
		}else{$give='

<form action="master_action.php" method="post">
<input required  name="deactv_login_onesstu_h" type="hidden" value="'.md5(md5(sha1(sha1(md5(md5($boxrw['st_db_id'].'hir39efnewsfejirjeofkvj...rjdnjjenfkvkijonreij3nj')))))).'" />

<input required  type="submit" class="btn-sm btn btn-danger " name="deactv_login_onesstu" value="Remove Login" />
</form>';
}
		
		
		echo '
		<tr>
<td>'.$boxrw['st_name'].'<br><button id="getUser" data-toggle="modal" data-target="#view-modal" data-id="'.md5(md5(sha1($boxrw['st_db_id']))).'" class="btn btn-sm btn-warning ion-edit"></button></td>
<td>'.$boxrw['st_adm_no'].'</td>
<td>'.$boxrw['st_prof_pic'].'</td>
<td>'.$boxrw['cls_numeric'].'-'.$boxrw['st_cls_section'].'</td>
<td>'.$boxrw['st_father_name'].'</td>
<td>'.$boxrw['st_mother_name'].'</td>
<td>'.date('d-M, Y',$boxrw['st_dob']).'</td>
<td>'.$boxrw['st_gender'].'</td>
<td >';
if($boxrw['st_rel_lum_id'] > 0){
	echo"<i class='fa fa-circle' style='color:green'></i><br>".$boxrw['lum_pass_def'];
	$getdefpass = "";
	
}else{
	echo"<i class='fa fa-circle' style='color:red'></i>".$boxrw['lum_pass_def'];
}

 echo'</td>
<td>'.$give.'</td>
</tr>';
		

	
	
	
	
	
	
	
	
	
	

	if(($cc % 1) == 0){
		echo '</div><div class="row">';
	}
	$cc++;
	#first loop ends
	$stus = 'None';
    }
} else {
    echo "0 results";
}
*/
 ?>                                                  
                                            </tbody>
                                        </table>
                                        <!-- -->

                               
 
 <div class="row">
 <div class="col-sm-6">
 					<script>
function theFunctionA() {
    var r = confirm("Are you sure you want to Deactivate all student logins for <?php echo $school['sch_name']; ?>?");
    if (r == true) {
        document.forms["remlog"].submit();
    }
}
</script>
		       
 <div align="right">
<form  method="post" action="master_action.php"><input type="hidden" value="<?php echo md5(sha1($school['sch_id']."eiugnioer30948t 4wuLJGRT.")) ?>" name="act_login_all_h" />
<input type="submit" name="act_login_all" value="Active All Student Logins" class="btn btn-success"/></form>
</div></div>
 <div class="col-sm-6">
	<form id="remlog" method="post" action="master_action.php"><input type="hidden" value="<?php echo md5(sha1($school['sch_id']."eiuersgergnioer.30948t 4wuLJGRT."))  ?>" name="deact_login_all_h" />
	<input name="deact_login_all" type="hidden" value="krijgnn" />
<input type="button" onClick="theFunctionA()" value="Deactive All Student Logins" class="btn btn-danger"/></form>';
 </div>
 </div>
                                        
                                 
                                        <!-- -->
                                    </div>
                                    <hr>
                                    
                                     </div>
                                </div>
                            </div>
<?php
							}
							?>
                            
                            
                        </div>
                    </div> <!-- end col -->

                    
                </div> <!-- End row -->


            </div> <!-- End row -->
<?php
if(isset($school)){
	?>
                                    <form action="master_action.php" method="post" class="form-horizontal" role="form">     

    <div id="employer_entry1" class="clonedInput1">
    <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"><h3 class="panel-title">Add Student(s) (Max:50)</h3></div>
                            <div class="panel-body">
                            
                                                              
<div class="form-group">
	<label>User Name: </label>
	<input required  placeholder="Full Name" name="add_st_name1" id="add_st_name1" type="text" class="add_st_name form-control" />
</div>


<div class="form-group">
	<label>Profile Picture (URL): </label>
	<input required  name="add_st_prfpic1" value="img/def_usr.png" id="add_st_prfpic1" type="text" class="add_st_prfpic form-control" />
</div>

<div class="form-group">
	<label>Profile Background Picture (URL): </label>
	<input required  name="add_st_prfbgpc1" value="img/circuit_def.png" id="add_st_prfbgpc1"  type="text" class="add_st_prfbgp form-control"/>
</div>

<div class="form-group">
	<label>School: </label>
	<input required value="<?php echo $school['sch_name'] ?>" disabled type="text" class="add_st_school form-control"/>
</div>
 <?php echo '

<div class="row">
		<div class="form-group">

	<div class="col-xs-6 ">
		<label>Class: </label>
		<select name="add_st_class1" id="add_st_class1"  class="add_st_class form-control">
		';
		$getclasses = "SELECT * from students_classes_mapping";
	$getclasses = $conn->query($getclasses);
	
	if ($getclasses->num_rows > 0) {
		// output data of each row
		while($getclassesrw = $getclasses->fetch_assoc()) {
				$extracl = '';
			echo '
			
			<option '.$extracl.' value="'.$getclassesrw['cls_id'].'">'.$getclassesrw['cls_words_some_num'].'</option>
			';
		}
	} else {
		echo "<option>No Classes</option>";
	}
	
		echo'
		</select>
	</div>
	<div class="col-xs-6 ">
			<label>Section: </label>
	<input required  name="edit_us_section1" id="edit_us_section1"  type="text" class="edit_us_section form-control" />

	</div>
</div>
</div>


<div class="form-group">
	<label>Class Teacher: </label>
	<select name="add_st_class_teacher1" id="add_st_class_teacher1"  class="add_st_class_teacher form-control">
	';
	$getteachers = "SELECT * from sb_teachers where th_valid =1 and th_rel_sch_id = ".$school['sch_id'];
$getteachers = $conn->query($getteachers);

if ($getteachers->num_rows > 0) {
    // output data of each row
    while($getteachersrw = $getteachers->fetch_assoc()) {
			$extrath = '';
		echo '
		
		<option '.$extrath.' value="'.$getteachersrw['th_id'].'">'.$getteachersrw['th_name'].'</option>
		';
    }
} else {
    echo "<option>No Teachers</option>";
}

	echo'
	</select>
</div>


<div class="form-group">
	<label>Student type: </label>
	<select name="add_st_stype1" id="add_st_stype1"  class="add_st_stype form-control">
	';
	$getsttypes = "SELECT * from student_types_all";
$getsttypes = $conn->query($getsttypes);

if ($getsttypes->num_rows > 0) {
    // output data of each row
    while($getsttypesrw = $getsttypes->fetch_assoc()) {
			$extrasty = '';
		echo '
		
		<option '.$extrasty.' value="'.$getsttypesrw['styp_id'].'">'.$getsttypesrw['styp_name'].'</option>
		';
    }
} else {
    echo "<option>No Types</option>";
}

?>	</select>
</div>


<div class="form-group">
	<label>Admission Number: </label>
	<input required name="add_st_admno1" id="add_st_admno1"  type="text" class="form-control add_st_admno" />
</div>




<div class="form-group">
	<label>Date of Birth: </label>
	<input required  name="add_st_dob1"  id="add_st_dob1" type="text" class="add_st_dob form-control" placeholder="dd-mm-yyyy"/>
</div>

<div class="form-group">
	<label>Gender: </label>
	<input required placeholder="M o F o Oth"  name="add_st_gender1" id="add_st_gender1"  type="text" class="add_st_gender form-control" />
</div>

<div class="form-group">
	<label>House: </label>
	<input required  name="add_st_house1" id="add_st_house1"  type="text" class="add_st_house form-control"/>
</div>

<div class="form-group">
	<label>Father Name: </label>
	<input required  name="add_st_father_name1" id="add_st_father_name1"  type="text" class="add_st_father_name form-control"/>
</div>


<div class="form-group">
	<label>Mother Name: </label>
	<input required  name="add_st_mother_name1" id="add_st_mother_name1"  type="text" class="add_st_mother_name form-control"/>
</div>

<div class="form-group">
	<label>Father Contact Number: </label>
	<input required placeholder="Without Code"  name="add_st_father_contc1" id="add_st_father_contc1"  type="text" class="add_st_father_contc form-control"/>
</div>


<div class="form-group">
	<label>Mother Contact Number: </label>
	<input required  placeholder="Without Code" name="add_st_mother_contc1" id="add_st_mother_contc1"  type="text" class="add_st_mother_contc form-control"/>
</div>

<div class="form-group">
	<label>Father Email: </label>
	<input required  name="add_st_father_email1" id="add_st_father_email1"  type="text" class="add_st_father_email form-control"/>
</div>

<div class="form-group">
	<label>Mother Email: </label>
	<input required  name="add_st_mother_email1" id="add_st_mother_email1"  type="text" class="add_st_mother_email form-control" />
</div>



<div class="form-group">
	<label>Address: </label>
	<input required  placeholder="Resedential Address" name="add_st_address1" id="add_st_address1"  type="text" class="add_st_address form-control" />
</div>


<div class="form-group">
	<label>Father Profession: </label>
	<input required  name="add_st_father_profession1" id="add_st_father_profession1"  type="text" class="add_st_father_profession form-control"/>
</div>


<div class="form-group">
	<label>Mother Profession: </label>
	<input required  name="add_st_mother_profession1"  id="add_st_mother_profession1"  type="text" class="add_st_mother_profession form-control"/>
</div>

<div class="form-group">
	<label>Left School: </label>
	<input required  name="add_st_left_school1" placeholder="0 or 1" value="0" id="add_st_left_school1"  type="number" min="0" max="1" class="add_st_left_school form-control"/>
</div>
<input required  name="formval" class="formval" id="formval"  type="hidden" value="0" />
<input required  name="add_st_school" value="<?php echo sha1("irjfowioirjoi3wrjgv".$school['sch_id']).md5(sha1(md5($school['sch_id']).'keroiojeoiroiroinvior3oiiorjb3oo onornvoj roroj 3n o3gi24j04j 039g0jv0ij 09jr0gj0j g088j g0jg03gj0838gj88rjg8rgj0 rjg0 3jg 30 jg309g093j g304gj 30rgj308r8jg038g')) ?>" id="add_st_school"  type="hidden" class="add_st_school form-control"/>


<div class="form-group">
	<label>Permissions: </label>

	<div class="row">
    <div class="col-xs-3"><label>Father SMS: </label>
	<input required  name="add_st_father_sms_ok1"  id="add_st_father_sms_ok1" type="number" class="add_st_father_sms_ok form-control" min="0" max="1" /></div>
	
    <div class="col-xs-3"><label>Mother SMS: </label>
	<input required  name="add_st_mother_sms_ok1" id="add_st_mother_sms_ok1"  type="number" class="add_st_mother_sms_ok form-control" min="0" max="1" /></div>
	
    <div class="col-xs-3"><label>Father Email: </label>
	<input required  name="add_st_father_email_ok1" id="add_st_father_email_ok1"  type="number" class="add_st_father_email_ok form-control" min="0" max="1" /></div>
	
    <div class="col-xs-3"><label>Mother Email: </label>
	<input required  name="add_st_mother_email_ok1"  id="add_st_mother_email_ok1" type="number" class="add_st_mother_email_ok form-control" min="0" max="1" /></div>
    
    </div>
</div>
                   
                               
                            </div> <!-- panel-body -->
                        </div> <!-- panel -->
                    </div> <!-- col -->
                </div>
                
                
                </div>
<div class="row"><div class="col-sm-12"><div class="panel panel-default"><div class="panel-body">
<div align="center" id="addDelButtons1">
<input required  type="button" id="btnAdd1" value="Add More" class="btn btn-success">
<input required  type="button" id="btnDel1" value="Remove" class="btn btn-danger">
</div>
</div></div></div></div>
<div align="center"><input required  type="submit" class="btn btn-info" name="add_students_all" value="Add Student(s)" /></div>
 </form>
    <?php
}
?>

            </div>
            <!-- Page Content Ends -->
            <!-- ================== -->

            <!-- Footer Start -->

<div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-full modal-dialog"> 
     <div class="modal-content">  
   
        <div class="modal-header"> 
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
           <h4 class="modal-title">
           <i class="glyphicon glyphicon-user"></i> Student Profile
           </h4> 
        </div> 
            
        <div class="modal-body">                     
           <div id="modal-loader" style="display: none; text-align: center;">
           <!-- ajax loader -->
           <img width="100px" src="img/ajax-loader.gif">
           </div>
                            
           <!-- mysql data will be load here -->                          
           <div id="dynamic-content"></div>
        </div> 
                        
        <div class="modal-footer"> 
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
        </div> 
                        
    </div> 
  </div>
</div>

         
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
	<script src="assets/clone/clone.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#datatable2').dataTable({
					"processing": true,
					"serverSide": true,
					"ajax": "page_that_gives_datatable_to_pages.php?school_id=<?php echo $school['sch_id']; ?>",
					 "columnDefs": [ {
						  "targets": 'no-sort',
						  "orderable": false,
					} ]
				});
            } );
        </script> 

                  <script>
$(document).ready(function(){

$(document).on('click', '#getUser', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content').html(''); // leave this div blank
     $('#modal-loader').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'admin_stu_logins='+uid,
          dataType: 'html'
     })
     .done(function(data){
          console.log(data); 
          $('#dynamic-content').html(''); // blank before load.
          $('#dynamic-content').html(data); // load here
          $('#modal-loader').hide(); // hide loader  
     })
     .fail(function(){
          $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
          $('#modal-loader').hide();
     });

    });
});
</script>
           </body>

</html>

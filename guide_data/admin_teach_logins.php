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
md5(sha1(concat(sch_id,'HGYURfij2490,,BVFRBRGWIOGRU92UWHFGOIWHTOGIUEO8HG384IWGOIRHWGIUHREJFGKN'))) ='".$_GET['sti']."' and  sch_valid=1 ");
if(is_array($get_school_t)){
	echo 'Teacher Logins'.' for '.$get_school_t['sch_name'].', '.$get_school_t['sch_city'];
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
<td><form action="admin_teach_logins.php" method="get">
		<input required  name="sti" type="hidden" value="'.
md5(sha1($getschoolssqlresultrow['sch_id'].'HGYURfij2490,,BVFRBRGWIOGRU92UWHFGOIWHTOGIUEO8HG384IWGOIRHWGIUHREJFGKN')).'" />
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
md5(sha1(concat(sch_id,'HGYURfij2490,,BVFRBRGWIOGRU92UWHFGOIWHTOGIUEO8HG384IWGOIRHWGIUHREJFGKN'))) ='".$sti_iid."' and  sch_valid=1 ";

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
                                                    <th>Teaching(sub and class)</th>
                                                    <th>Gender</th>
                                                    <th>DOB</th>
                                                    <th>Phone</th>
                                                    <th>Email</th>
                                                    <th class="no-sort">Login</th>
                                                    <th class="no-sort"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
<?php
/*
$boxsql = "SELECT s.*,l.lum_valid,IFNULL(l.lum_pass_def,'None') as lum_pass_def  FROM `sb_teachers` s
left join sb_logins l on l.lum_id = s.th_rel_lum_id
where s.th_valid =1 and s.th_rel_sch_id= ".$school['sch_id'];
$boxres = $conn->query($boxsql);

if ($boxres->num_rows > 0) {
    // output data of each row
	$cc =1;
    while($boxrw = $boxres->fetch_assoc()) {
		#firts loop begins
		if(($boxrw['th_rel_lum_id'] == 0) or (($boxrw['lum_valid']) == 0) and ($boxrw['th_rel_lum_id'] > 0)){
$give = '

<form action="master_action.php" method="post">
<input required  name="actv_login_oneteach_h" type="hidden" value="'.md5(md5(sha1(sha1(md5(md5($boxrw['th_id'].'hir39efnewsfejirjeokjd.fkvkijonreij3nj')))))).'" />

<input required  type="submit" class="btn-sm btn btn-success" name="actv_login_onesteach" value="Create Login" />
</form>';
		}else{$give='

<form action="master_action.php" method="post">
<input required  name="deactv_login_oneteach_h" type="hidden" value="'.md5(md5(sha1(sha1(md5(md5($boxrw['th_id'].'hir39efnewjmvj...rjdnjjenfkkjsrgnkjrgsnvkijonreij3nj')))))).'" />

<input required  type="submit" class="btn-sm btn btn-danger " name="deactv_login_onesteach" value="Remove Login" />
</form>';
}
		
		
		echo '
		<tr>
<td>'.$boxrw['th_name'].'<br><button id="getUser" data-toggle="modal" data-target="#view-modal" data-id="'.md5(md5(sha1($boxrw['th_id']))).'" class="btn btn-sm btn-warning ion-edit"></button></td>
<td>'.$boxrw['th_subject'].' to '.$boxrw['th_teach_class'].'</td>
<td>'.$boxrw['th_gender'].'</td>
<td>'.date('d-M, Y',$boxrw['th_dob']).'</td>
<td>'.$boxrw['th_contact_no'].'</td>
<td>'.$boxrw['th_email'].'</td>
<td>';
if($boxrw['th_rel_lum_id'] > 0){
	echo"<i class='fa fa-circle' style='color:green'></i><br>".$boxrw['lum_pass_def'];
	$getdefpass = "";
	
}else{
	echo $boxrw['lum_pass_def'];
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
*/ ?>                                                  
                                            </tbody>
                                        </table>
                                        <!-- -->

                               
 
 <div class="row">
 <div class="col-sm-6">
 					<script>
function theFunctionA() {
    var r = confirm("Are you sure you want to Deactivate all Teacher logins for <?php echo $school['sch_name']; ?>?");
    if (r == true) {
        document.forms["remlog"].submit();
    }
}
</script>
		       
 <?php 
 if(isset($cc)){
echo '<div align="right">
<form  method="post" action="master_action.php"><input type="hidden" value="'.md5(sha1($school['sch_id']."eiugnioer30948t kjrsgGRT.")).'" name="act_login_all_th_h" />
<input type="submit" name="act_login_all_th" value="Active All Teacher Logins" class="btn btn-success"/></form>
</div></div>
 <div class="col-sm-6">
	<form id="remlog" method="post" action="master_action.php"><input type="hidden" value="'.md5(sha1($school['sch_id']."eiuersgergnkjh;;,.48t 4wuLJGRT.")).'" name="deact_login_all_th_h" />
	<input name="deact_login_all_th" type="hidden" value="krijgnn" />
<input type="button" onClick="theFunctionA()" value="Deactive All Teacher Logins" class="btn btn-danger"/></form>';
 }
 ?>
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

    <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"><h3 class="panel-title">Add Teacher</h3></div>
                            <div class="panel-body">
                            
                                                              
<div class="form-group">
	<label>Name: </label>
	<input required  placeholder="Full Name" name="add_th_name"  type="text" class="form-control" />
</div>


<div class="form-group">
	<label>Profile Picture (URL): </label>
	<input required  name="add_th_prof_pic" value="img/def_usr.png" type="text" class=" form-control" />
</div>

<div class="form-group">
	<label>Profile Background Picture (URL): </label>
	<input required  name="add_th_back_pic" value="img/circuit_def.png"  type="text" class=" form-control"/>
</div>

<div class="form-group">
	<label>School: </label>
	<input required value="<?php echo $school['sch_name'] ?>" disabled type="text" class="form-control"/>
</div>

<div class="form-group">
	<label>Classes Teaching: </label>
	<input required name="add_th_class_teach" placeholder="eg: 8-12" type="text" class="form-control" />
</div>

<div class="form-group">
	<label>Gender: </label>
	<input required placeholder="M or F or Oth"  name="add_th_gender" type="text" class="form-control" />
</div>
<div class="form-group">
	<label>Subject: </label>
	<input required placeholder="At least One "  name="add_th_subject" type="text" class="form-control" />
</div>

<div class="form-group">
	<label>Date of Birth: </label>
	<input required  name="add_th_dob" type="text" class="form-control" placeholder="dd-mm-yyyy"/>
</div>
<div class="form-group">
	<label>Contact No: </label>
	<input required placeholder="Without Code"  name="add_th_contact" type="text" class="form-control" />
</div>
<div class="form-group">
	<label>Email: </label>
	<input required placeholder="Email"  name="add_th_email"  type="email" class="form-control" />
</div>



<input required  name="add_th_school" value="<?php echo sha1("irjfowioirjoi3wrjgv".$school['sch_id']).md5(sha1(md5($school['sch_id']).'jjriurjfwiugwiuf jwrrwiuurfnwiurvnwiurvn')) ?>"  type="hidden" class="form-control"/>



                   
                               
                            </div> <!-- panel-body -->
                        </div> <!-- panel -->
                    </div> <!-- col -->
                </div>
<div align="center"><input required  type="submit" class="btn btn-info" name="add_teacher" value="Add Teacher" /></div>
 </form>
    <?php
}
?>

            </div>
            <!-- Page Content Ends -->
            <!-- ================== -->

            <!-- Footer Start -->
            
       
 <?php
/* if(isset($school)){
	$msql = "SELECT * FROM `sb_teachers`
where th_valid =1 and  th_rel_sch_id = ".$school['sch_id'];
$mres = $conn->query($msql );

if ($mres->num_rows > 0) {
    // output data of each row

    while($mrw = $mres->fetch_assoc()) {
		#firts loop begins
		foreach($mrw as $me=>$m){
			$mrw[$me] = trim($m);
		}
		echo '
<div id="'.md5(md5(sha1($mrw['th_id']))).'" class="modal fade" role="dialog">
  <div class="modal-full modal-dialog">

    <!-- Modal content-->
   <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Editing '.$mrw['th_name'].'</h4>
      </div>
      <div class="modal-body">
        <form action="master_action.php" method="post">
	';
	if($mrw['th_rel_lum_id'] == 0){}else{ echo'	
<div class="form-group">
	<label>Password: (Leave Undisturbed for no Change)</label>
	<input required  name="edit_th_password" type="text" class="form-control" value="-" placeholder="Leave undisturbed for no change"/>
</div>
';}
echo '
<div class="form-group">
	<label>Name: </label>
	<input required  name="edit_th_name" type="text" class="form-control" value="'.$mrw['th_name'].'"/>
</div>


<div class="form-group">
	<label>Profile Picture (URL): </label>
	<input required  name="edit_th_prof_pic" type="text" class="form-control" value="'.$mrw['th_prof_pic'].'"/>
</div>

<div class="form-group">
	<label>Profile Background Picture (URL): </label>
	<input required  name="edit_th_back_pic" type="text" class="form-control" value="'.$mrw['th_back_pic'].'"/>
</div>

<div class="form-group">
	<label>Subject: </label>
	<input required  name="edit_th_subject" type="text" class="form-control" value="'.$mrw['th_subject'].'"/>
</div>


<div class="form-group">
	<label>Classes: </label>
	<input required  name="edit_th_teach_class" type="text" class="form-control" value="'.$mrw['th_teach_class'].'"/>
</div>


<div class="form-group">
	<label>School: </label>
	<select name="edit_th_school" class="form-control">
	';
	$getschools = "SELECT * from schools_listed";
$getschools = $conn->query($getschools);

if ($getschools->num_rows > 0) {
    // output data of each row
    while($getschoolsrw = $getschools->fetch_assoc()) {
		if($getschoolsrw['sch_id'] == $mrw['th_rel_sch_id']){
			$extrasc = 'selected';
		}else{
			$extrasc = '';
		}
		echo '
		
		<option '.$extrasc.' value="'.$getschoolsrw['sch_id'].'">'.$getschoolsrw['sch_valid'].'@'.$getschoolsrw['sch_name'].' '.$getschoolsrw['sch_city'].'</option>
		';
    }
} else {
    echo "<option>No Schools</option>";
}

	echo'
	</select>
</div>





<div class="form-group">
	<label>Date of Birth: </label>
	<input required  name="edit_th_dob" type="text" class="form-control" value="'.date('d-m-Y', $mrw['th_dob']).'"/>
</div>

<div class="form-group">
	<label>Gender: </label>
	<input required  name="edit_th_gender" type="text" class="form-control" value="'.$mrw['th_gender'].'"/>
</div>


<div class="form-group">
	<label>Contact Number: </label>
	<input required  name="edit_th_contact_no" type="numbers" class="form-control" value="'.$mrw['th_contact_no'].'"/>
</div>

<div class="form-group">
	<label>Email: </label>
	<input required  name="edit_th_email" type="text" class="form-control" value="'.$mrw['th_email'].'"/>
</div>











<div class="row">
	<div class="col-xs-6">
	<input required  type="hidden" value="'.md5(md5(sha1(sha1(md5(md5($mrw['th_id'].'f2frbgbter 24rfgr324frgtr3f 3gr32fgr32f4gr')))))).'" name="th_hash" />
		<input required  style="float:right" type="submit" class="btn btn-success" name="edit_th_user" value="Save">
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
 } 
 */
 ?>             
 <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-full modal-dialog"> 
     <div class="modal-content">  
   
        <div class="modal-header"> 
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
           <h4 class="modal-title">
           <i class="glyphicon glyphicon-user"></i> Teacher Profile</h4> 
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
					"ajax": "page_that_gives_datatable_to_pages.php?school_id_teach=<?php echo $school['sch_id']; ?>",
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
          data: 'admin_teach_logins='+uid,
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

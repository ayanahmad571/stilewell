<?php
include('include.php');
if(!isset($_SERVER['HTTP_REFERER'])){
	header('Location: page_that_gives_model_popups_to_pages.php');
}
?>
<?php

if(isset($_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID']) and trim($_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID']) != ''){
}else{
	die('Login to continue <a href="login.php">Login	</a>');
}
?><?php
if (isset($_POST['admin_stu_logins'])) {
	$msql = "SELECT * FROM `students_parents_info_rc` s
left join students_classes_mapping c on c.cls_id = s.st_rel_cls_id
left join sb_teachers t on t.th_id = s.st_rel_th_id
where s.st_valid =1 and t.th_valid =1 and md5(md5(sha1(s.st_db_id))) = '".$_POST['admin_stu_logins']."'";
$mres = $conn->query($msql );

if ($mres->num_rows > 0) {
    // output data of each row

    while($mrw = $mres->fetch_assoc()) {
		#firts loop begins
		foreach($mrw as $me=>$m){
			$mrw[$me] = trim($m);
		}
		echo '
        <form action="master_action.php" method="post">
	';
	if($mrw['st_rel_lum_id'] == 0){}else{ echo'	
<div class="form-group">
	<label>Password: (Leave Undisturbed for no Change)</label>
	<input required  name="edit_us_pw" type="text" class="form-control" value="-" placeholder="Leave undisturbed for no change"/>
</div>
';}
echo '
<div class="form-group">
	<label>User Name: </label>
	<input required  name="edit_st_name" type="text" class="form-control" value="'.$mrw['st_name'].'"/>
</div>


<div class="form-group">
	<label>Profile Picture (URL): </label>
	<input required  name="edit_st_prfpic" type="text" class="form-control" value="'.$mrw['st_prof_pic'].'"/>
</div>

<div class="form-group">
	<label>Profile Background Picture (URL): </label>
	<input required  name="edit_st_prfbgpc" type="text" class="form-control" value="'.$mrw['st_back_pic'].'"/>
</div>


<div class="form-group">
	<label>School: </label>
	<select name="edit_st_school" class="form-control">
	';
	$getschools = "SELECT * from schools_listed";
$getschools = $conn->query($getschools);

if ($getschools->num_rows > 0) {
    // output data of each row
    while($getschoolsrw = $getschools->fetch_assoc()) {
		if($getschoolsrw['sch_id'] == $mrw['st_rel_sch_id']){
			$extrasc = 'selected';
					echo '
		<option '.$extrasc.' value="'.$getschoolsrw['sch_id'].'">'.$getschoolsrw['sch_valid'].'@'.$getschoolsrw['sch_name'].' '.$getschoolsrw['sch_city'].'</option>

		';
	
		}
    }
} else {
    echo "<option>No Schools</option>";
}

	echo'
	</select>
</div>

<div class="row">
<div class="col-xs-6 form-group">
	<label>Class: </label>
	<select name="edit_st_class" class="form-control">
	';
	$getclasses = "SELECT * from students_classes_mapping";
$getclasses = $conn->query($getclasses);

if ($getclasses->num_rows > 0) {
    // output data of each row
    while($getclassesrw = $getclasses->fetch_assoc()) {
		if($getclassesrw['cls_id'] == $mrw['st_rel_cls_id']){
			$extracl = 'selected';
		}else{
			$extracl = '';
		}
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
	<div class="col-xs-6 form-group">
			<label>Section: </label>
	<input required  name="edit_st_section" type="text" class="form-control" value="'.$mrw['st_cls_section'].'" />

	</div>
</div>

<div class="form-group">
	<label>Class Teacher: </label>
	<select name="edit_st_class_teacher" class="form-control">
	';
	$getteachers = "SELECT * from sb_teachers where th_valid =1 and th_rel_sch_id = ".$mrw['st_rel_sch_id'];
$getteachers = $conn->query($getteachers);

if ($getteachers->num_rows > 0) {
    // output data of each row
    while($getteachersrw = $getteachers->fetch_assoc()) {
		if($getteachersrw['th_id'] == $mrw['st_rel_th_id']){
			$extrath = 'selected';
		}else{
			$extrath = '';
		}
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
	<select name="edit_st_stype" class="form-control">
	';
	$getsttypes = "SELECT * from student_types_all";
$getsttypes = $conn->query($getsttypes);

if ($getsttypes->num_rows > 0) {
    // output data of each row
    while($getsttypesrw = $getsttypes->fetch_assoc()) {
		if($getsttypesrw['styp_id'] == $mrw['st_rel_styp_id']){
			$extrasty = 'selected';
		}else{
			$extrasty = '';
		}
		echo '
		
		<option '.$extrasty.' value="'.$getsttypesrw['styp_id'].'">'.$getsttypesrw['styp_name'].'</option>
		';
    }
} else {
    echo "<option>No Types</option>";
}

	echo'
	</select>
</div>


<div class="form-group">
	<label>Admission Number: </label>
	<input required  name="edit_st_admno" type="text" class="form-control" value="'.$mrw['st_adm_no'].'"/>
</div>




<div class="form-group">
	<label>Date of Birth: </label>
	<input required  name="edit_st_dob" type="text" class="form-control" value="'.date('d-m-Y', $mrw['st_dob']).'"/>
</div>

<div class="form-group">
	<label>Gender: </label>
	<input required  name="edit_st_gender" type="text" class="form-control" value="'.$mrw['st_gender'].'"/>
</div>

<div class="form-group">
	<label>House: </label>
	<input required  name="edit_st_hous" type="text" class="form-control" value="'.$mrw['st_house'].'"/>
</div>

<div class="form-group">
	<label>Father Name: </label>
	<input required  name="edit_st_father_name" type="text" class="form-control" value="'.$mrw['st_father_name'].'"/>
</div>


<div class="form-group">
	<label>Mother Name: </label>
	<input required  name="edit_st_mother_name" type="text" class="form-control" value="'.$mrw['st_mother_name'].'"/>
</div>

<div class="form-group">
	<label>Father Contact Number: </label>
	<input required  name="edit_st_father_contc" type="text" class="form-control" value="'.$mrw['st_father_contact_no'].'"/>
</div>


<div class="form-group">
	<label>Mother Contact Number: </label>
	<input required  name="edit_st_mother_contc" type="text" class="form-control" value="'.$mrw['st_mother_contact_no'].'"/>
</div>

<div class="form-group">
	<label>Father Email: </label>
	<input required  name="edit_st_father_email" type="text" class="form-control" value="'.$mrw['st_father_email'].'"/>
</div>

<div class="form-group">
	<label>Mother Email: </label>
	<input required  name="edit_st_mother_email" type="text" class="form-control" value="'.$mrw['st_mother_email'].'"/>
</div>



<div class="form-group">
	<label>Address: </label>
	<input required  name="edit_st_address" type="text" class="form-control" value="'.$mrw['st_address'].'"/>
</div>


<div class="form-group">
	<label>Father Profession: </label>
	<input required  name="edit_st_father_profession" type="text" class="form-control" value="'.$mrw['st_father_profession'].'"/>
</div>


<div class="form-group">
	<label>Mother Profession: </label>
	<input required  name="edit_st_mother_profession" type="text" class="form-control" value="'.$mrw['st_mother_profession'].'"/>
</div>

<div class="form-group">
	<label>Left School: </label>
	<input required  name="edit_st_left_school" type="number" min="0" max="1" class="form-control" value="'.$mrw['st_left_school'].'"/>
</div>


<div class="form-group">
	<label>Permissions: </label>

	<div class="row">
    <div class="col-xs-3"><label>Father SMS: </label>
	<input required  name="edit_st_father_sms_ok" type="number" class="form-control" min="0" max="1" value="'.$mrw['st_father_sms_ok'].'"/></div>
	
    <div class="col-xs-3"><label>Mother SMS: </label>
	<input required  name="edit_st_mother_sms_ok" type="number" class="form-control" min="0" max="1" value="'.$mrw['st_mother_sms_ok'].'"/></div>
	
    <div class="col-xs-3"><label>Father Email: </label>
	<input required  name="edit_st_father_email_ok" type="number" class="form-control" min="0" max="1" value="'.$mrw['st_father_email_ok'].'"/></div>
	
    <div class="col-xs-3"><label>Mother Email: </label>
	<input required  name="edit_st_mother_email_ok" type="number" class="form-control" min="0" max="1" value="'.$mrw['st_mother_email_ok'].'"/></div>
    
    </div>
</div>









<div class="row">
	<div class="col-xs-6">
	<input required  type="hidden" value="'.md5(md5(sha1(sha1(md5(md5($mrw['st_db_id'].'f2frbgbeeafs 2fgtegrfr3gbter 24rfgr324frgtr3f 3gr32fgr32f4gr')))))).'" name="st_hash" />
		<input required  style="float:right" type="submit" class="btn btn-success" name="edit_st_user" value="Save">
	</div>
	<div class="col-xs-6">
		<button type="reset" class="btn btn-danger">Reset</button>
	</div>
</div>
	</form>
		
	';
	
	#first loop ends
    }
} else {
    echo "0 results";
}
}
if(isset($_POST['admin_teach_logins'])){
	$msql = "SELECT * FROM `sb_teachers`
where th_valid =1 and  md5(md5(sha1(th_id)))= '".$_POST['admin_teach_logins']."'";
$mres = $conn->query($msql );

if ($mres->num_rows > 0) {
    // output data of each row

    while($mrw = $mres->fetch_assoc()) {
		#firts loop begins
		foreach($mrw as $me=>$m){
			$mrw[$me] = trim($m);
		}
		echo '
        <form action="master_action.php" method="post">
	';
	if($mrw['th_rel_lum_id'] == 0){}else{ echo'	
<div class="form-group">
	<label>Password: (Leave Undisturbed for no Change)</label>
	<input required  name="edit_th_password" type="text" class="form-control" value="-" placeholder="Leave undisturbed for no change"/>
</div>
';}
/*==============================================================================================----____*/
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
		
	';
	
	#first loop ends
    }
} else {
    echo "0 results";
}
}
?>

<?php 
#$days = ($month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year %400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31));
include('include.php');
/*for($xtr = 0;$xtr<1000;$xtr++){

$sections = array('A','B','C','D','E');
$gender = array('Oth','M','F');
$house = array('Tejas','Bhanu','Bhaskar','Surya');
$ins_qu="

INSERT INTO `students_parents_info_rc`(`st_rel_sch_id`, `st_rel_cls_id`, `st_rel_th_id`, `st_rel_styp_id`, `st_prof_pic`, `st_back_pic`, `st_cls_section`, `st_adm_no`, `st_name`, `st_dob`, `st_gender`, `st_house`, `st_father_name`, `st_mother_name`, `st_father_contact_no`, `st_mother_contact_no`, `st_father_email`, `st_mother_email`, `st_address`, `st_father_profession`, `st_mother_profession`, `st_mother_sms_ok`, `st_father_sms_ok`, `st_mother_email_ok`, `st_father_email_ok`, `st_left_school`, `st_added_dnt`, `st_added_ip`) VALUES (

'1',
'".rand(1,15)."',
'".rand(1,2)."',
'1',
'img/def_usr.png',
'img/circuit_def.png',
'".$sections[rand(0,4)]."',

'".rand(1,50000)."',
'SbS ".rand(1,5000)." Student ".$xtr."',

'".strtotime(rand(1,29).'-'.rand(1,12).'-'.rand(1990,2016))."',
'".$gender[rand(0,2)]."',
'".$house[rand(0,3)]."',
'Father SbS ".rand(1,5000)." Student Father ".$xtr."',
'Mother SbS ".rand(1,5000)." Student Mother".$xtr."',
'".rand(9000000000,9999999999)."',
'".rand(9000000000,9999999999)."',

'FatherSbS".$xtr."@gmail.com',
'MotherSbS".$xtr."@gmail.com',
'".$sections[rand(0,3)]."-".rand(1,4000)."',
'FatherSbS".$xtr." Buisness',
'MotherSbS".$xtr." House',

'1',
'1',
'1',
'1',
'0',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."')
";
if($conn->query($ins_qu)){
	echo 'Created SbS-Student'.$xtr.'<br>';
}else{
	die("#ErrorMAINSSTDT");
}


}
die();
*/
var_dump($GLOBALS);

?>
<hr>
<?php 

var_dump($_SESSION);

?>
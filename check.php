<?php
if(include('include.php')){
}else{
die('##errMASTERofUSErERROR');
}


if(isset($_POST['check']) and ctype_alnum($_POST['check'])){
	$sql = "SELECT * FROM `ted_usr_reg` t
	where t.tur_valid =1 and t.tur_approved = 1 and 
 md5(md5(sha1(sha1(md5(concat(tur_id, tur_dnt))))))= '".substr($_POST['check'],1,32)."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		echo $row['tur_fname'];

	}
	
	
	
}else{
}

}

?>
	
	
<?php

include("include.php");

$sql = "SELECT * from sw_salesinvoices where so_revision = 0 and so_valid =1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        
		$getmax = getdatafromsql($conn, "SELECT * from sw_salesinvoices where so_revision_id = ".$row['so_id']." and so_valid =1 order by so_revision desc limit 1");
		$gen = getdatafromsql($conn, "select * from sw_salesinvoices_gen where sog_rel_so_id = ".$getmax['so_id']." and sog_valid =1 order by sog_id desc limit 1");
if(is_array($gen)){
		if($gen['sog_lpo'] == '-'){}else{
			echo $getmax['so_ref'].'='.$gen['sog_lpo']."<br>";
		}

		
		
		unset($getmax);
		unset($gen);
}
    }
} else {
    echo "0 results";
}
?>
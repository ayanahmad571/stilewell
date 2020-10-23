<?php
include("include.php");
$sql = "select * from sw_proformas_items";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        
		$sq = "SELECT * FROM sw_products_raw where pr_id = ".$row['pi_rel_pr_id']."";
$sq = $conn->query($sq);

if ($sq->num_rows > 0) {
    // output data of each row
    while($ro = $sq->fetch_assoc()) {
$conn->query("update sw_proformas_items set pi_rel_sup_id = ".$ro['pr_rel_sup_id']." where pi_id = ".$row['pi_id']."");

    }
} else {
    echo "0 results";
}
		
		
    }
} else {
    echo "0 results";
}

?>
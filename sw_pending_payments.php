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
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php get_head(); ?>
<link rel="stylesheet" type="text/css" href="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
<link href="assets/sweet-alert/sweet-alert.min.css" rel="stylesheet">
<link href="assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="assets/fullcalendar/fullcalendar.css" rel="stylesheet" />
</head>

<body>
  
  <!-- ================== -->
  
                                        <table id="datatable1" class=" table table-striped table-bordered">
                      <thead >
                        <tr>
                          <th>#</th>
                          <th>Invoice Ref</th>
                          <th>Client Name</th>
                          <th>AED <br>
                            Conversion<br>
                            Rate</th>
                          <th>Total Price <br>
                            (Including Vat and Discount and Extra)</th>
                          <th>Amount Paid</th>
                          <th>Amount Left</th>
                          <th>Installments</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody style="margin-top:500px;">

<?php 
$sql = "SELECT * from sw_salesinvoices
left join sw_proformas on so_rel_po_id = po_id
 where so_valid =1 and so_revision =0 and po_valid =1 order by so_ref asc";
 
$result = $conn->query($sql);
$con = 1;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
$getsales = getdatafromsql($conn, "
select * from `sw_salesinvoices` s
left join sw_clients c on s.so_rel_cli_id = c.cli_id
left join sw_currency cy on s.so_rel_cur_id = cy.cur_id
where so_valid=1 and so_revision_id = ".$row['so_id']." order by so_revision desc limit 1"); 
 
	$checkgen = getdatafromsql($conn,"select * from sw_salesinvoices_gen where sog_rel_so_id = ".$row['so_revision_id']." and sog_valid =1 order by sog_id desc limit 1 ");				
	if(is_array($checkgen)){
$cur_name = $getsales['cur_name'];
$cur_rate = $getsales['so_cur_rate'];
$cli_name = $getsales['cli_name'];

$gettotalprice = getdatafromsql($conn,"select sum(si_qty * si_price) as total from sw_salesinvoices_items 
left join sw_products_list on si_rel_pr_id = pr_id left join sw_prod_types on pr_rel_prty_id = prty_id where si_rel_so_id = ".$getsales['so_id']." and si_valid =1 and prty_pr_hidden = 0");

$gettotalpricegen = getdatafromsql($conn,"select sog_discount as sog_discount,
((sog_vat * (".$gettotalprice['total']." - sog_discount))/100) as sog_vat,
(sog_extra_price) from sw_salesinvoices_gen where sog_rel_so_id = ".$row['so_revision_id']." and sog_valid =1 order by sog_dnt desc limit 1");

$getamountpaid = getdatafromsql($conn,"select sum(pt_val) as total from sw_payments where pt_rel_po_id = ".$row['po_revision_id']." and pt_valid =1");
$getinstallments = getdatafromsql($conn,"select count(pt_id) as total from sw_payments where pt_rel_po_id = ".$row['po_revision_id']." and pt_valid =1");
$duedate = (time() > $row['so_due_date'] ? '<i style="color:red">'.date('d-M-Y',$row['so_due_date']).'</i>': date('d-M-Y',$row['so_due_date']));
$total = (($gettotalprice['total'] - $gettotalpricegen['sog_discount'] + $gettotalpricegen['sog_extra_price']+ $gettotalpricegen['sog_vat']) * $cur_rate);
$left = ($total - ($getamountpaid['total']) * $cur_rate);
if(($left > 5) and (time() > $row['so_due_date'])){
		  echo '
 <tr>
 <td>'.$con.'</td>
 <td>'.$getsales['so_ref'].'</td>
	<td>'.$cli_name.'</td>
	<td>'.$cur_rate.'</td>
	<td>'.$cur_name.' '.number_format($total ,2).'</td>
	<td>'.$cur_name.' '.number_format((($getamountpaid['total']  * $cur_rate)) ,2).'</td>
	<td>'.$cur_name.' '.number_format($left,2).'</td>
	<td>'.$getinstallments['total'].'</td>
	<td>'.$duedate.'</td>
 </tr>';

$con++;

}
}
    }
} else {
    echo "No Sales Invoice";
}

?>

                      </tbody>
                    </table>

                    </table>
                    
                    <hr>
                    <a href="home.php"><button class="btn btn-danger">Continue</button></a>

    </body>
</html>

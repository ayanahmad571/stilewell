<?php
if(include('include.php')){
}else{
die('##errMASTERofUSErERROR');
}
		?>




<!DOCTYPE html>
<html lang="en" >
    
<!-- the maninvoice.htmlby ayan ahmad 07:31:27 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="shortcut icon" href="img/logo.jpg">

        <title>Sales Report</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-reset.css" rel="stylesheet">

        <!--Animation css-->
        <link href="css/animate.css" rel="stylesheet">

        <!--Icon-fonts css-->
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/ionicon/css/ionicons.min.css" rel="stylesheet" />


        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/helper.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
<link href="assets/sweet-alert/sweet-alert.min.css" rel="stylesheet">
<link href="assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />  
        


        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
   <style>
   

   hr {
	   color:#000;
	   border-color:#000;
   }
   td {
	   padding:6px !important;
   }
   </style>

    </head>


    <body style="font-size:12px;">


                <div class="row">
                    

                    <div class="col-lg-12	">

                        <div class="panel panel-default"><!-- /primary heading -->
                            <div class="portlet-heading">
      
                            <div class="panel-heading">
                                <h3 class="panel-title">Sales</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div style=" overflow:auto;
 position:relative;" class="row">
                                    <table id="datatsble1" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Invoice Ref</th>
                                                    <th>Client</th>
                                                    <th>Items</th>
                                                    <th>Subtotal <br>Sales Price AED</th>
                                                    <th>Subtotal <br>Cost AED (only cost)</th>
                                                    <th>Additional Cost AED</th>
                                                    <th>Discount AED</th>
                                                    <th>Extra Price AED</th>
                                                    <th>Total Cost</th>
                                                    <th>Total Sales <br>Discount Included and extra price added</th>
                                                    <th>Markup</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
											$totalcost = 0;
											$totalsales = 0;
$productsql = "SELECT * FROM `sw_salesinvoices` 
left join sw_clients on so_rel_cli_id = cli_id
WHERE so_revision = 0 and so_valid=1
order by so_ref desc
";
$productres = $conn->query($productsql);

/*
select * from sw_purchaseorders where pco_valid =1 and pco_revision_id = '".$_POST['add_salesinvoice_proforma_hash']."' order by pco_revision desc limit 1 
*/
if ($productres->num_rows > 0) {
	//'.md5(md5(sha1(md5($productrw['pr_id'])))).'_primga output data of each row
	$con = 1;
	while($productrw = $productres->fetch_assoc()) {
	$getmax = getdatafromsql($conn,"
select * from sw_salesinvoices p
where so_valid =1 and so_revision_id = '".$productrw['so_id']."'  order by so_revision desc limit 1");

	$getmaxpo = getdatafromsql($conn,"
select po_revision_id from sw_proformas p
where po_valid =1 and po_id = '".$getmax['so_rel_po_id']."' ");
		$discount =0;
		$extraprice= 0;

$getcosttotal = getdatafromsql($conn,"select sum(si_qty * si_cost) as ctotal from sw_salesinvoices_items where si_rel_so_id = ".$getmax['so_id']." and si_valid =1");
$getacosttotal = getdatafromsql($conn,"select ifnull(sum(cost_val) ,0) as atotal from sw_costing where cost_rel_po_id = ".$getmaxpo['po_revision_id']." and cost_valid =1");
$getproformaprintview = getdatafromsql($conn,"select * from sw_salesinvoices_gen where sog_rel_so_id =".$getmax['so_revision_id']." and sog_valid=1");

		echo '<tr>
	<td>'.$con.'</td>
	<td>'.$getmax['so_ref'].'</td>
	<td>'.$productrw['cli_name'].'</td>
	<td>'; 
$innersql = "SELECT * from sw_salesinvoices_items i
left join sw_products_list p on i.si_rel_pr_id = p.pr_id
left join sw_prod_types t on p.pr_rel_prty_id = t.prty_id
where si_valid =1 and p.pr_valid = 1 and t.prty_valid =1 and si_rel_so_id = ".$getmax['so_id'];

$inneres = $conn->query($innersql);
$ttqty = 0;
if ($inneres->num_rows > 0) {
		// output data of each row
		echo '<table class="table-bordered">
		<thead>
			<tr>
			<th>Ref</th>
			<th>Cost</th>
			<th>Sale</th>
			<th>Qty</th>
			<th>Hidden</th>
			</tr>
		</thead>
		<tbody>';
		$indvsales = 0;
		while($innerw = $inneres->fetch_assoc()) {
					$inititit = round(($innerw['si_qty'] * $innerw['si_price'] * $getmax['so_cur_rate']),2);

			echo '<tr>';
					if($innerw['prty_pr_hidden'] == '1'){
					echo '<td style="color:red">'.$innerw['pr_code'].'<br>'.convert_desc($innerw['si_desc']).'</td>'; 
					echo '<td style="color:red">'.$innerw['si_cost'].'</td>';
					echo '<td style="color:red">'.$innerw['si_price'].'</td>';
					echo '<td style="color:red">'.$innerw['si_qty'].'</td>';
					echo '<td style="color:red">'.$innerw['prty_pr_hidden'].'</td>';
					}else{
					echo '<td>'.$innerw['pr_code'].'<br>'.convert_desc($innerw['si_desc']).'</td>'; 
					echo '<td>'.$innerw['si_cost'].'</td>';
					echo '<td>'.$innerw['si_price'].'</td>';
					echo '<td>'.$innerw['si_qty'].'</td>';
					echo '<td>'.$innerw['prty_pr_hidden'].'</td>';

					}
			echo '</tr>';
				if($innerw['prty_pr_hidden'] == '0'){
					$indvsales = $indvsales + $inititit;
	}

		}
		echo '</tbody></table>';
		
} else {
	
		echo "No Items";
}


	echo '</td>
	<td>'.number_format($indvsales['ptotal'] ,2).'</td>
	<td>'.number_format($getcosttotal['ctotal'] ,2).'</td>
	<td>'.number_format($getacosttotal['atotal'] ,2).'</td>';
	if(is_array($getproformaprintview)){
		$discount = $getproformaprintview['sog_discount'];
		$extraprice= $getproformaprintview['sog_extra_price'];
	echo'
	<td>'.$getproformaprintview['sog_discount'].'</td>
	<td>'.$getproformaprintview['sog_extra_price'].'</td>
';
	}else{
	echo'
	<td style="border-right:0 !important;">Generate Print View of Sales Invoice <strong>REF: '.$getmax['so_ref'].'</strong></td>
	<td></td>';
	}
	$cost =($getcosttotal['ctotal'] + $getacosttotal['atotal'])  ;
	$sales = ($indvsales -$discount + $extraprice);
	echo'
	<td>'.number_format( $cost,2).'</td>
	<td>'.number_format( $sales,2).'</td>
	<td>'.number_format( $sales/$cost,2).'</td>
	</tr>';

$totalcost = $totalcost + $cost;
$totalsales = $totalsales + $sales;

	$con++;
	}

} else {
}
?>
                        </tbody>
                                        </table>
                                        <!-- -->
<hr>
<div class="row">
	<div class="col-xs-12">
    	<p>Overall</p>
        <hr>
<h1>Sales: AED <?php echo number_format($totalsales) ?></h1>
    </div>
</div>



<p>The Above value not an estimate.<br>
This value is the sum of all Invoices' Total</p>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    
                </div> <!-- End row -->


            </div> <!-- End row -->

            </div>
            <!-- Page Content Ends -->
            <!-- ================== -->

            <!-- Footer Start -->
            


            
<!-- Footer Start -->
<footer class="footer">
	<?php auto_copyright(); // Current year?>

    Aforty
</footer>
<!-- Footer Ends -->




    </body>
      <?php  
	  get_end_script();
	  ?>   

<script src="assets/datatables/jquery.dataTables.min.js"></script>
<script src="assets/datatables/dataTables.bootstrap.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable1').dataTable();
    } );
</script>

</html>


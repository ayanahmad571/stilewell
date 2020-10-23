<?php
if(include('include.php')){
}else{
die('##errMASTERofUSErERROR');
}


if(isset($_GET['id']) and ctype_alnum($_GET['id'])){
	$sql = "SELECT * FROM `sw_proformas_gen` g
left join sw_proformas q on g.`pog_rel_po_id` = q.po_id
left join sw_currency c on q.po_rel_cur_id = c.cur_id
left join sw_clients ci on q.po_rel_cli_id = ci.cli_id

where md5(g.`pog_id`)= '".$_GET['id']."' and g.pog_valid = 1 and q.po_valid =1 and ci.cli_valid =1  ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
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

        <title>Stilewell Proforma Print View</title>

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
	   padding:3px !important;
   }
   </style>

    </head>


    <body style="font-size:12px; height:920px">

            <div >

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <!-- <div class="panel-heading">
                                <h4>Invoice</h4>
                            </div> -->
                            <div class="panel-body">
                                <div class="clearfix">
                                    <div class="pull-left">
                                        <h4 class="text-right"><img width="120px" src="<?php echo $stwl['img'] ?>" alt="StileWell General Trading LLC"></h4>
                                        
                                    </div>
                                    <div style="margin-left:10px" class="pull-right">
                                        <h5 align="right"><br>
                                            <strong><?php echo $stwl['addrarab'] ?> </strong>
                                        </h5>
                                    </div>
                                    <div class="pull-right">
                                        <h5 align="right"><br>
                                            <strong><?php echo $stwl['addr'] ?></strong>
                                        </h5>
                                    </div>
                                </div>
                                <hr>
                                <h4 align="center">
                                PROFORMA INVOICE الفاتورة الأولية
                                </h4>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        
                                        <div class="pull-left">
                                            <address>
                                              <strong><?php echo $row['cli_name'] ?></strong><br>
                                              
                                             <?php echo $row['pog_address'] ?>
                                              </address>
                                    <p><strong>Project: </strong> <?php echo $row['po_proj_name'] ?></p>
                                    <p class="m-t-10"><strong>Subject: </strong> <?php echo $row['po_subj'] ?></p>
                                    <p class="m-t-10"><?php echo $row['pog_extra'] ?></p>
                                        </div>
                                        <div class="pull-right">
                                            <p><strong>Date: </strong> <?php echo date('j/n/Y',$row['pog_dnt']) ?></p>
                                            <p class="m-t-10"><strong>Proforma Invoice Number: </strong> <?php echo $row['po_ref'] ?></p>
                                            <p class="m-t-10"><strong>Payment Terms: </strong> <?php echo $row['pog_payment_terms'] ?></p>
                                            <p class="m-t-10"><strong>LPO Reference: </strong> <?php echo $row['pog_lpo'] ?></p>
                                            <p class="m-t-10"><strong>Currency: </strong> <?php echo $row['cur_name'] ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr><th>#</th>
                                                    <th>Item Name</th>
                                                    <th>Quantity</th>
                                                    <th>Unit</th>
                                                    <th>Price(<?php echo $row['cur_name'] ?>)</th>
                                                    <th>Total(<?php echo $row['cur_name'] ?>)</th>
                                                </tr></thead>
                                                <tbody>
                                                
                                                <?php 
												
												
$productssql = "SELECT * from sw_proformas_items i
left join sw_products_list p on i.pi_rel_pr_id = p.pr_id
left join sw_prod_types t on p.pr_rel_prty_id = t.prty_id
where pi_valid =1 and p.pr_valid = 1 and t.prty_valid =1 and pi_rel_po_id = ".$row['po_id'];
$productsresult = $conn->query($productssql);

if ($productsresult->num_rows > 0) {
    // output data of each row
	$c = 1;
	$total = 0;
    while($productrow = $productsresult->fetch_assoc()) {
		$qty = ($productrow['pi_qty'] * $productrow['prty_conv_formula']);
		$price = (((1/$productrow['prty_conv_formula']) * $productrow['pi_price']) * $row['po_cur_rate']);
		$itotal = round(($qty * $price),2);

?>
                <tr>
                    <td><?php echo $c; ?></td>
                    <td><?php echo $productrow['pr_name']; ?></td>
                    <td><?php echo $qty; ?></td>
                    <td><?php echo $productrow['prty_conv_unit']; ?></td>
                    <td><?php echo number_format($price,2); ?></td>
                    <td><?php echo number_format($itotal,2); ?></td>
                </tr>
<?php
$total = $itotal + $total;
  $c++;  }
} else {
    echo "0 results";
}



$total = $total;
?>

        <tr><td colspan="6"><p class="text-right"><b>Sub-total:</b> <?php echo $row['cur_name'].' '.number_format(($total),2) ?></p></td></tr>
        <?php 
		
if($row['pog_discount'] == 0){
	$discount = 0;
}else{
	$discount = round((($row['pog_discount']/100) * $total),2);
	echo '<tr><td colspan="6"><p class="text-right"><strong>Discout ('.$row['pog_discount'].'%):</strong> '.$row['cur_name'].' '.number_format($discount,2).'</p></td></tr>';
	
}

		?>
		<?php 
		
if($row['pog_vat'] == 0){
	$vat = 0;
}else{
	$vat = round((($row['pog_vat']/100) * $total),2);
	echo '<tr><td colspan="6"><p class="text-right"><strong>Vat ('.$row['pog_vat'].'%):</strong> '.$row['cur_name'].' '.number_format($vat,2).'</p></td></tr>';
	
}

		?>
        
        <?php
		$beforearray = explode('||||||||||.||||||||||',$row['pog_before_total']); 
		foreach($beforearray as $beforea){
			$before = explode('|=|=|=|=|=|',$beforea);
			
if(trim($before[0]) == '-'){
}else{
			echo '<tr><td colspan="6"><p class="text-right"><strong>'.$before[0].'</strong>: '.$before[1].'</p></td></tr>';
}

		}
		?>
<tr>
<td colspan="5"><h5 style="margin-top: 0px;margin-bottom: 0px;" class="text-left"><?php echo $row['cur_name'].' '.strtoupper(convert_number_to_words(((($total + $vat  + $row['pog_extra_price']) -$discount)))).' ONLY'; ?></h5></td>
<td colspan="1"><h5 style="margin-top: 0px;margin-bottom: 0px;" class="text-right"><?php echo $row['cur_name'].' '.number_format((($total + $vat  + $row['pog_extra_price']) -$discount),2); ?></h5></td>
</tr>
               <?php
		$afterarray = explode('||||||||||.||||||||||',$row['pog_after_total']); 
		foreach($afterarray as $aftera){
			
			$after = explode('|=|=|=|=|=|',$aftera);
			
if(trim($after[0]) == '-'){
}else{
			echo '<tr><td colspan="6"><p class="text-right"><strong>'.$after[0].'</strong>: '.$after[1].'</p></td></tr>';
}

		}
		?>
        

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                    <p align="center">
                                            All Cheques to be in favour of <strong>STILE WELL GENERAL TRADING LLC</strong>
                                    </p>
                                </div>
                                <div style="border:solid black 1px" class="row">
									<div class="col-xs-6 pull-left"><br><br>
<br>

<br>

                                    	<p>____________________________________</p>
                                    </div>
									<div class="col-xs-6 pull-right"><br>
<br>
<br>
<br>

                                    	<p class="pull-right">_________________________________</p><br>
                                        <p class="pull-right">For Stile well General Trading LLC</p>
                                    </div>
                                </div>
                                <div class="row">
                                            <p><?php echo $row['pog_footer']; ?></p>
                                </div>

                                <div class="hidden-print">
                                    <div class="pull-right">
                                        <a onClick="window.print()" href="#" class="btn btn-inverse"><i class="fa fa-print"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>


    </body>

<!-- the maninvoice.htmlby ayan ahmad 07:31:28 GMT -->
</html>
        <?php
    }
} else {
    echo "0 results";
}
}else{
	die('Give Id');
}

?>
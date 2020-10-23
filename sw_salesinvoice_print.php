<?php
if(include('include.php')){
}else{
die('##errMASTERofUSErERROR');
}


if(isset($_GET['id']) and ctype_alnum($_GET['id'])){
	
	
	$sql = "SELECT * FROM `sw_salesinvoices_gen` g
left join sw_salesinvoices q on g.`sog_rel_so_id` = q.so_revision_id
left join sw_currency c on q.so_rel_cur_id = c.cur_id
left join sw_clients ci on q.so_rel_cli_id = ci.cli_id

where md5(g.`sog_id`)= '".$_GET['id']."' and g.sog_valid = 1 and q.so_valid =1 and ci.cli_valid =1 order by so_revision desc limit 1  ";
$result = $conn->query($sql);

if ($result->num_rows == '1') {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$getdateofbase = getdatafromsql($conn, "select * from sw_salesinvoices where so_id = ".$row['so_revision_id']." and so_valid =1");
		if(!is_array($getdateofbase)){
			die('Base of this not found');
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

        <title><?php echo $row['cli_name'].' - '.$row['so_ref'] ?></title>

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

body{ 
    zoom: 0.8; 
}    </style>
    </head>

<?php
$getpobase = getdatafromsql($conn, "select * from sw_proformas where po_id = ".$row['so_rel_po_id']." and po_valid =1");
$getdo = getdatafromsql($conn,"SELECT (
SELECT do_dnt FROM `sw_deliveryorders` d
left join sw_proformas p on d.do_rel_po_id = p.po_id
where p.po_valid =1  and d.do_valid =1 and p.po_revision_id = ".$getpobase['po_revision_id']."
order by d.do_revision asc limit 1) as do_dnt_base , d.*,p.po_revision_id FROM `sw_deliveryorders` d
left join sw_proformas p on d.do_rel_po_id = p.po_id
where p.po_valid =1  and d.do_valid =1 and p.po_revision_id = ".$getpobase['po_revision_id']."
order by d.do_revision desc");
?>
    <body style="font-size:12px;">

            <div >

                <div class="row">
                    <div class="col-md-12">
                        <div style="padding-left:70px !important;padding-right:70px !important" class="panel panel-default">
                            <!-- <div class="panel-heading">
                                <h4>Invoice</h4>
                            </div> -->
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-6" >
                                        <h4 class=" pull-left text-right"><img width="250px" src="<?php echo $stwl['img'] ?>" alt="StileWell General Trading LLC"></h4>
                                        
                                    </div>
                                    <div class="col-xs-6">
                                        <h2 align="right" style="line-height:20px"><br>
                                            <strong>TAX INVOICE</strong>
                                        </h2>
                                    </div>
                                </div>
                                <div class="row">
        
                                    <div class="col-xs-4" class="pull-left">
                                        <h5 align="left" style="margin-top:0"><br>
                                            <?php echo $stwl['addr'] ?>
                                        </h5>
                                    </div>
                                    <div class="col-xs-8">
                                    	<div class="row">
                                        	<div class="col-xs-12">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width:25%;text-align:center">Invoice Number</th>
                                                        <th style="width:25%;text-align:center">Date</th>
                                                        <th style="width:25%;text-align:center">DN#</th>
                                                        <th style="width:25%;text-align:center">DN Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                	<tr>
                                                    	<td style="text-align:center"><?php echo $row['so_ref'] ?></td>
                                                    	<td style="text-align:center"> <?php echo date('j/n/Y',$getdateofbase['so_dnt']) ?></td>
                                                    	<td style="text-align:center"><?php echo (is_array($getdo)?  $getdo['do_ref']  : '-' ); ?></td>
                                                    	<td style="text-align:center"> <?php echo  (is_array($getdo)?  date('j/n/Y',$getdo['do_dnt_base'])  : '-' ); ?></td>
                                                    </tr>
                                    </tbody>
                                            </table>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                        	<div class="col-xs-12">
                                            <table class="table table-bordered ">
                                                <thead>
                                                    <tr>
                                                        <th style="width:50%;text-align:center">LPO # and  Date</th>
                                                        <th style="width:25%;text-align:center">Payment terms</th>
                                                        <th style="width:25%;text-align:center">Currency</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                	<tr>
                                                    	<td style="text-align:center"><?php echo $row['sog_lpo'] ?></td>
                                                    	<td style="text-align:center"><?php echo $row['sog_payment_terms'] ?></td>
                                                    	<td style="text-align:center"><?php echo $row['cur_name'] ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                    </div>
								</div>
                                <br>
<div class="row">
<div class="col-xs-12">
<table class="table table-bordered ">
    <thead>
        <tr>
            <th style="width:50%;text-align:center">Bill to</th>
            <th style="width:50%;text-align:center">Ship to</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align:center"><strong style="font-size:22px"><?php echo $row['cli_name'] ?></strong><br>
                                              
                                             <?php echo $row['sog_address'] ?><br>
                                             VAT NO:<?php echo $row['cli_tax_code'] ?></td>
            <td style="text-align:center"><strong style="font-size:22px"><?php echo $row['cli_name'] ?></strong><br>
                                              
                                             <?php echo $row['sog_address'] ?><br>
                                             VAT NO:<?php echo $row['cli_tax_code'] ?></td>
        </tr>
    </tbody>
</table>
</div>
</div>
                                <div class="row">
                                    <div class="col-md-12">
                                        
                                        <div class="pull-left">
                                    <p style="margin:0"><strong>Project: </strong> <?php echo $row['so_proj_name'] ?></p>
                                    <p style="margin:0" ><strong>Subject: </strong> <?php echo $row['so_subj'] ?></p>
                                    <p style="margin:0"><?php echo $row['sog_extra'] ?></p>
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
                                                    <th style="width:10%">Quantity</th>
                                                    <th style="width:10%">Unit Price(<?php echo $row['cur_name'] ?>)</th>
                                                    <th style="width:10%">Amount(<?php echo $row['cur_name'] ?>)</th>
                                                    <th style="width:5%">Unit</th>
                                                    <th style="width:10%">Tax</th>
                                                    <th style="width:10%">Tax Amount</th>
                                                    <th style="width:10%">Total Amount(<?php echo $row['cur_name'] ?>)</th>
                                                </tr></thead>
                                                <tbody>
                                                
                                                <?php 
												
												
$productssql = "SELECT * from sw_salesinvoices_items i
left join sw_products_list p on i.si_rel_pr_id = p.pr_id
left join sw_prod_types t on p.pr_rel_prty_id = t.prty_id
where si_valid =1 and p.pr_valid = 1 and t.prty_valid =1 and si_rel_so_id = ".$row['so_id'];
$productsresult = $conn->query($productssql);

if ($productsresult->num_rows > 0) {
    // output data of each row
	$c = 1;
	$total = 0;
    while($productrow = $productsresult->fetch_assoc()) {
if($productrow['prty_pr_hidden'] == '0'){		
		$qty = ($productrow['si_qty'] * $productrow['prty_conv_formula']);
		$price = (((1/$productrow['prty_conv_formula']) * $productrow['si_price']) * $row['so_cur_rate']);
		$itotal = round(($qty * $price),2);

?>
                <tr>
                    <td><?php echo $c; ?></td>
                    <td><?php echo $productrow['pr_name']; ?>
                    <br><?php echo convert_desc($productrow['si_desc']); ?></td>
                    <td style="text-align:right"><?php echo $qty; ?></td>
                    <td style="text-align:right"><?php echo number_format($price,2); ?></td>
                    <td style="text-align:right"	><?php echo number_format($itotal,2); ?></td>
                    <td style="text-align:right"><?php echo $productrow['prty_conv_unit']; ?></td>
                    <td style="text-align:right"><?php echo $row['sog_vat'].'%' ?></td>
                    <td style="text-align:right"><?php echo number_format($itotal*($row['sog_vat']/100),2) ?></td>
                    <td style="text-align:right"><?php echo number_format((($row['sog_vat']/100)+1)*($itotal),2) ?></td>
                </tr>
<?php
$total = $itotal + $total;
  $c++;  }
  
}
} else {
    echo "0 results";
}



$total = $total;
?>

        <?php
		$beforearray = explode('||||||||||.||||||||||',$row['sog_before_total']); 
		foreach($beforearray as $beforea){
			$before = explode('|=|=|=|=|=|',$beforea);
			
if(trim($before[0]) == '-'){
}else{
	$total = $total + $before[1];
			?>
    <tr>
        	<td colspan="3" style="text-align:center;border:0;"></td>
            <td colspan="1">
            <strong><?php echo $before[0];?></strong>
            </td>
            <td style="text-align:right" colspan="1">
            <?php echo $before[1] ;?>
            </td>
            <td colspan="2"></td>
            <td colspan="1">
            </td>
            <td colspan="1">
            </td>
</tr>
        
            <?php
			
}

		}
		?>


		<tr>
        	<td colspan="3" style="text-align:center;border:0;"></td>
            <td colspan="1">
            <strong>SUBTOTAL</strong>
            </td>
            <td style="text-align:right" colspan="1">
            <?php echo number_format($total,2); ?>
            </td>
            <td colspan="2"></td>
            <td style="text-align:right" colspan="1">
            <?php echo number_format(($row['sog_vat']/100)*$total,2); ?>
            </td>
            <td style="text-align:right" colspan="1">
            <?php echo number_format((($row['sog_vat']/100)+1)*($total),2) ?>
            </td>
        </tr>

		<tr>
        	<td colspan="3" style="text-align:center; border:0;"></td>
            <td colspan="1">
            <strong>DISCOUNT</strong>
            </td>
            <td style="text-align:right" colspan="1">
            <?php echo number_format(round($row['sog_discount'],2),2); ?>
            </td>
            <td colspan="2"></td>
            <td style="text-align:right" colspan="1"><?php echo number_format(round($row['sog_discount'] * ($row['sog_vat']/100) ,2),2); ?></td>
            <td style="text-align:right" colspan="1"><?php echo number_format(round($row['sog_discount'] * (1+($row['sog_vat']/100)) ,2),2); ?></td>
        </tr>

		<tr>
        	<td colspan="3" style="text-align:center;border-top:0"></td>
            <td colspan="1">
            <strong>TOTAL</strong>
            </td>
            <td style="text-align:right" colspan="1">
            <?php echo number_format(($total - round($row['sog_discount'],2)),2); ?>
            </td>
            <td colspan="2"></td>
            <td style="text-align:right" colspan="1">
            <?php echo number_format(($row['sog_vat']/100)*($total - round($row['sog_discount'],2)),2); ?>
            </td>
            <td style="text-align:right" colspan="1">
             <strong style="font-size:17px"><?php echo number_format((($row['sog_vat']/100)+1)*(($total - round($row['sog_discount'],2))),2) ?></strong>
            </td>
        </tr>

        <?php 
		
if($row['sog_discount'] == 0){
	$discount = 0;
}else{
	$discount = round($row['sog_discount'],2);
	
}

		?>
		<?php 
		
if($row['sog_vat'] == 0){
	$vat = 0;
}else{
	$vat = round((($row['sog_vat']/100) * $total),2);
	
}

		?>
        
               <?php
		$afterarray = explode('||||||||||.||||||||||',$row['sog_after_total']); 
		foreach($afterarray as $aftera){
			
			$after = explode('|=|=|=|=|=|',$aftera);
			
if(trim($after[0]) == '-'){
}else{
			?>
    <tr>
        	<td colspan="3" style="text-align:center"></td>
            <td colspan="1">
            <strong><?php echo $after[0];?></strong>
            </td>
            <td colspan="1">
            <?php echo $after[1] ;?>
            </td>
            <td colspan="2"></td>
            <td colspan="1">
            </td>
            <td colspan="1">
            </td>
</tr>
        
            <?php
}

		}
		?>
        
        <tr>
<td colspan="9"><h5 style="margin-top: 0px;margin-bottom: 0px;" class="text-left"><?php echo $row['cur_name'].' '.strtoupper(convert_number_to_words( $row['sog_extra_price'] + (($row['sog_vat']/100)+1)*(($total - round($row['sog_discount'],2))))  ).' ONLY'; ?></h5></td>
</tr>

        

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
<br><div class="row">
    <div class="col-xs-4">
    Declaration: We declare that this invoice shows the
    actual price of goods described and that all
    particulars are true and correct.
    </div>
    
    <div class="col-xs-4">
    All Cheques to be in favour of <strong>STILE WELL GENERAL TRADING LLC</strong>
    </div>

    <div class="col-xs-4">
        <p align="center">
        For STILE WELL GENERAL TRADING LLC       
        </p>
    <br>
    <br>
    	<p align="center">Prepared by &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Authorised Signatory</p>
    </div>

</div>

<div class="row">
            <p><?php echo $row['sog_footer']; ?></p>
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
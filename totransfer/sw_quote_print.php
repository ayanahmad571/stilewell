<?php
if(include('include.php')){
}else{
die('##errMASTERofUSErERROR');
}


if(isset($_GET['id']) and ctype_alnum($_GET['id'])){
	$sql = "SELECT * FROM `sw_quotes_gen` g
left join sw_quotes q on g.`qog_rel_qo_id` = q.qo_id
left join sw_currency c on q.qo_rel_cur_id = c.cur_id
left join sw_clients ci on q.qo_rel_cli_id = ci.cli_id

where md5(g.`qog_id`)= '".$_GET['id']."' and g.qog_valid = 1 and q.qo_valid =1 and ci.cli_valid =1  ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		?>




<!DOCTYPE html>
<html lang="en">
    
<!-- the maninvoice.htmlby ayan ahmad 07:31:27 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="shortcut icon" href="img/logo.jpg">

        <title>Stilewell Quotation Print View</title>

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


    <body style="font-size:14px">

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
                                QUOTATION اقتباس
                                </h4>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        
                                        <div class="pull-left m-t-30">
                                            <address>
                                              <strong><?php echo $row['cli_name'] ?></strong><br>
                                              
                                             <?php echo $row['qog_address'] ?>
                                              </address>
                                        </div>
                                        <div class="pull-right m-t-30">
                                            <p><strong>Date: </strong> <?php echo date('j/n/Y',$row['qog_dnt']) ?></p>
                                            <p class="m-t-10"><strong>Quote REF: </strong> <?php echo $row['qo_ref'] ?></p>
                                            <p class="m-t-10"><strong>Currency: </strong> <?php echo $row['cur_name'] ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <p><strong>Project: </strong> <?php echo $row['qo_proj_name'] ?></p>
                                    <p class="m-t-10"><strong>Subject: </strong> <?php echo $row['qo_subj'] ?></p>
                                    <p class="m-t-10"><?php echo $row['qog_extra'] ?></p>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table m-t-30 table-bordered">
                                                <thead>
                                                    <tr><th>#</th>
                                                    <th>Item Image</th>
                                                    <th>Item Name</th>
                                                    <th>Quantity</th>
                                                    <th>Price(<?php echo $row['cur_name'] ?>)</th>
                                                    <th>Total(<?php echo $row['cur_name'] ?>)</th>
                                                </tr></thead>
                                                <tbody>
                                                
                                                <?php 
												
												
$productssql = "SELECT * from sw_quotes_items i
left join sw_products_list p on i.qi_rel_pr_id = p.pr_id
left join sw_prod_types t on p.pr_rel_prty_id = t.prty_id
where qi_valid =1 and p.pr_valid = 1 and t.prty_valid =1 and qi_rel_qo_id = ".$row['qo_id'];
$productsresult = $conn->query($productssql);

if ($productsresult->num_rows > 0) {
    // output data of each row
	$c = 1;
	$total = 0;
    while($productrow = $productsresult->fetch_assoc()) {
		$qty = ($productrow['qi_qty'] * $productrow['prty_conv_formula']);
		$price = (((1/$productrow['prty_conv_formula']) * $productrow['qi_price']) * $row['qo_cur_rate']);
		
		$itotal = round(($qty * $price ),2);

?>
                <tr>
                    <td><?php echo $c; ?></td>
                    <td><?php echo '<img width="100px" class="img-responsive" src="'.$productrow['pr_img'].'" />'; ?>
                    <p>*Images for illustrative purpose only<p></td>
                    <td><?php echo $productrow['pr_name']; ?></td>
                    <td><?php echo $qty.' '.$productrow['prty_conv_unit']; ?></td>
                    <td><?php echo number_format(round($price,2),2); ?></td>
                    <td><?php echo number_format($itotal,2); ?></td>
                </tr>
                
                <?php 
				
				if(($productrow['qi_img_1'] == '0') and ($productrow['qi_img_2'] == '0') and ($productrow['qi_img_3'] == '0') and ($productrow['qi_img_4'] == '0') and ($productrow['qi_img_5'] == '0') ){
}else{
	echo '<tr>
	<td>'.$c.'-Images</td>
';

for($i = 1; $i <6; $i++){
	if($productrow['qi_img_'.$i] !== '0'){ ?>
<td><img src="<?php echo  $productrow['qi_img_'.$i] ?>" class="img-responsive" width="200px" /><br>Image is for illustration purpose only</td>
	 <?php }else{
		 ?><td></td><?php
	 }

}
echo '
	
	</tr>';
}

				
				?>
<?php
$total = $itotal + $total;
  $c++;  }
} else {
    echo "0 results";
}



$total = $total;
?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
<div class="row" style="border-radius: 0px;">
    <div class="col-md-12 ">
        <p class="text-right"><b>Sub-total:</b> <?php echo $row['cur_name'].' '.number_format(($total),2) ?></p>
        
        <?php 
		
if($row['qog_discount'] == 0){
	$discount = 0;
}else{
	$discount = round((($row['qog_discount']/100) * $total),2);
	echo '<strong><td colspan="6"><p class="text-right"><strong>Discout ('.$row['qog_discount'].'%)</strong>: '.$row['cur_name'].' '.number_format($discount,2).'</p>';
	
}

		?>
		<?php 
		
if($row['qog_vat'] == 0){
	$vat = 0;
}else{
	$vat = round((($row['qog_vat']/100) * $total),2);
	echo '<strong><p class="text-right"><strong>Vat ('.$row['qog_vat'].'%)</strong>: '.$row['cur_name'].' '.number_format($vat,2).'</p>';
	
}

		?>
        <?php
		$beforearray = explode('||||||||||.||||||||||',$row['qog_before_total']); 
		foreach($beforearray as $beforea){
			$before = explode('|=|=|=|=|=|',$beforea);
			
if(trim($before[0]) == '-'){
}else{
			echo '<strong><p class="text-right">'.$before[0].'</strong>: '.$before[1].'</p>';
}

		}
		?>
        
                <hr>
<div class="row">
	<div class="col-xs-8">
        <h5 class="text-left"><?php echo $row['cur_name'].' '.strtoupper(convert_number_to_words(((($total + $vat  + $row['qog_extra_price']) -$discount)))).' ONLY'; ?></h5> 
    </div>
	<div class="col-xs-4">
    	<h5 class="text-right"><?php echo $row['cur_name'].' '.number_format((($total + $vat  + $row['qog_extra_price']) -$discount),2); ?></h5>
    </div>
</div>



               <?php
		$afterarray = explode('||||||||||.||||||||||',$row['qog_after_total']); 
		foreach($afterarray as $aftera){
			$after = explode('|=|=|=|=|=|',$aftera);
			
if(trim($after[0]) == '-'){
}else{
			echo '<strong><p class="text-right">'.$after[0].'</strong>: '.$after[1].'</p>';
}

		}
		?>
    </div>
</div>
                                <hr>
                                <div class="row">
                                    <p align="center">
                                            <p><?php echo $row['qog_footer']; ?></p>
                                    </p>
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
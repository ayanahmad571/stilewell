<?php
if(include('include.php')){
}else{
die('##errMASTERofUSErERROR');
}
		?>
<?php
if(!isset($_POST['rep_time_from'])){
	die('<h1>Could not find time from</h1>');
}
if(!isset($_POST['rep_time_till'])){
	die('<h1>Could not find time till</h1>');
}

if(!isset($_POST['rep_cli_hashes'])){
	die('<h1>No client Selected</h1>');
}

if(isset($_POST['rep_profit'])){
	$calcprofit = 1;
}else{
	$calcprofit = 0;
}

if(isset($_POST['rep_det'])){
	$calcdet= 1;
}else{
	$calcdet = 0;
}
?>

<?php

$fromraw = str_replace(".","-",$_POST['rep_time_from']);
$tillraw = str_replace(".","-",$_POST['rep_time_till']);

if((strtotime($fromraw) == true) and (strtotime($tillraw) == true)){
	
}else{
	die('Invalid Dates');}

$from = (strtotime($fromraw));
$till = (strtotime($tillraw));

?>

<!DOCTYPE html>
<html lang="en" >
    
<!-- the maninvoice.htmlby ayan ahmad 07:31:27 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="shortcut icon" href="img/logo.png">

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


    <body style="font-size:12px; overflow:auto;
 position:relative;background-color:#FFFFFF; margin-left:10px !important;margin-right:10px !important" >

<?php
$prty_array =array();
$total = array('sale'=>0);
$allsales = array();
$getprty = "SELECT * FROM sw_prod_types where prty_valid =1  order by prty_name asc";
$getprty = $conn->query($getprty);

if ($getprty->num_rows > 0) {
    // output data of each row
    while($getprtyrw = $getprty->fetch_assoc()) {
		$prty_array[$getprtyrw['prty_id']] = $getprtyrw['prty_name'];
		$total[$getprtyrw['prty_id']]=0; 
    }
} 

$totalisagoodboy = 0;
$totalcostisagoodboy = 0;
$totalmarkupisagoodboy = 0;
$totaladdcost = 0;
$totalprodcost = 0;
$getallsales = "SELECT * FROM `sw_salesinvoices` 
left join sw_clients on so_rel_cli_id = cli_id
left join sw_currency on so_rel_cur_id = cur_id
WHERE so_valid=1 and so_revision = 0 
and so_dnt <= ".($till +86400)." and so_dnt >= ".($from)." and so_rel_cli_id in (".implode(',',$_POST['rep_cli_hashes']).")
order by so_ref asc";
$getallsales = $conn->query($getallsales);

if ($getallsales->num_rows > 0) {
    // output data of each row
	
    while($getallsalesrow = $getallsales->fetch_assoc()) {
	$getmax = getdatafromsql($conn,"
select * from sw_salesinvoices p
where so_valid =1 and so_revision_id = '".$getallsalesrow['so_id']."'  order by so_revision desc limit 1");
if(!is_array($getmax)){
	die('ERRRPG1');
}
$allsales[$getmax['so_id']] =array();

foreach($prty_array as $prty_id=>$prty_val ){
	$allsales[$getmax['so_id']][$prty_id]=0;
}

		$totalindv = 0;

												
	$productssql = "
	SELECT i.*,t.*, SUM((si_qty*si_price)) as qxp FROM `sw_salesinvoices_items` i
left join sw_products_raw r on si_rel_pr_id = r.pr_id 
left join sw_prod_types t on r.pr_rel_prty_id = t.prty_id
where si_rel_so_id= ".$getmax['so_id']." and si_valid =1
and prty_valid =1 and pr_valid =1  
group by prty_id
ORDER BY `i`.`si_rel_so_id` ASC";
	$productsresult = $conn->query($productssql);
	
	if ($productsresult->num_rows > 0) {
		// output data of each row
		while($productrow = $productsresult->fetch_assoc()) {

			$allsales[$getmax['so_id']][$productrow['prty_id']] = $productrow['qxp'];
		
			if($productrow['prty_pr_hidden'] == '0'){
			$totalindv = $totalindv + $productrow['qxp'] ;
			}
		}
	} else {
		die('No items found in Si REF: '.$getmax['so_ref']);
	}

	$allsales[$getmax['so_id']]['cli'] = $getallsalesrow['cli_code'].' - '.$getallsalesrow['cli_name'];
	$allsales[$getmax['so_id']]['ref'] = $getmax['so_ref'];
	$allsales[$getmax['so_id']]['dnt'] = date('d-m-Y',$getallsalesrow['so_dnt']);
/*
*/
$getpoid = getdatafromsql($conn,'select po_revision_id from sw_proformas where po_id ='.$getmax['so_rel_po_id'].' and po_valid =1');
	$allsales[$getmax['so_id']]['po_base_id'] = $getpoid['po_revision_id'];

$getcosttotal = getdatafromsql($conn,"select sum(si_qty * si_cost) as ctotal from sw_salesinvoices_items where si_rel_so_id = ".$getmax['so_id']." and si_valid =1");
$getacosttotal = getdatafromsql($conn,"select ifnull(sum(cost_val) ,0) as atotal from sw_costing where cost_rel_po_id = ".$getpoid['po_revision_id']." and cost_valid =1");
	$allsales[$getmax['so_id']]['productcost'] = $getcosttotal['ctotal'];
	$allsales[$getmax['so_id']]['additionalcost'] = $getacosttotal['atotal'];
	$allsales[$getmax['so_id']]['totalcost'] = $getacosttotal['atotal'] + $getcosttotal['ctotal'] ;



	$checkgen = getdatafromsql($conn,"select * from sw_salesinvoices_gen where sog_rel_so_id = ".$getmax['so_revision_id']." and sog_valid =1 ");				
	 
	 if(is_array($checkgen)){

$gettotalprice = getdatafromsql($conn,"select sum(si_qty * si_price) as total from sw_salesinvoices_items 
left join sw_products_list on si_rel_pr_id = pr_id 
left join sw_prod_types on pr_rel_prty_id = prty_id 
where si_rel_so_id = ".$getmax['so_id']." and si_valid =1 and prty_pr_hidden = 0");

$gettotalpricegen = getdatafromsql($conn,"select sog_discount as sog_discount,
((sog_vat * ".$gettotalprice['total'].")/100) as sog_vat,
(sog_extra_price) from sw_salesinvoices_gen where sog_rel_so_id = ".$getmax['so_revision_id']." and sog_valid =1 order by sog_dnt desc limit 1");

				
		 	$allsales[$getmax['so_id']]['total'] =  (int)(($gettotalprice['total'] - $gettotalpricegen['sog_discount'] + $gettotalpricegen['sog_extra_price']+ $gettotalpricegen['sog_vat']));

		 
	 }else{
		 	$allsales[$getmax['so_id']]['total'] = (int)$totalindv;

	 }
	 
	 if(($getacosttotal['atotal'] + $getcosttotal['ctotal'])==0){
		 	$allsales[$getmax['so_id']]['markup'] = ($allsales[$getmax['so_id']]['total'])/1;

	 }else{
		 	$allsales[$getmax['so_id']]['markup'] = ($allsales[$getmax['so_id']]['total'])/($getcosttotal['ctotal'] + $getacosttotal['atotal']);

	 }
	 
/*
*/




    }
	
	
	
} else {
    die('No Match found');
}

/*

Make array with so_id as index
	Then make inside index another array with all prty_index with value of the total of those type of items
	allsales->
		121->(so_id)
   (prty_id)1->850
			2->0
			3->5
			4->80088
			25->0.25
		125->
			1->850
			2->0
			3->5
			4->80088
			25->0.25
*/
?>

<style>
#header-fixed { 
    position: fixed; 
    top: 0px; display:;
    background-color:white;
}
</style>                <div style="" class="">
                    

                    <div class="">

                        <div ><!-- /primary heading -->
                            <div class="">
                                <div class="">
                                    <div class="">
                                    <div style=" " class="">
                                    <table id="datatable1" class="  table table-striped table-bordered">
                                            <thead>
                                                <tr style="background-color:#F3EAB2" >
                                                    <th>#</th>
                                                    <th>Invoice Ref</th>
                                                    <th>Date</th>
                                                    <th>Client</th>
                                                    <th>Total</th>
                                                    
		  		      <?php if($calcprofit== '1'){ ?> <th>Cost Breakup</th> <?php } ?>
		  		      <?php if($calcprofit== '1'){ ?> <th>Total Cost</th> <?php } ?>
		  		      <?php if($calcprofit== '1'){ ?> <th>Markup</th> <?php } ?>
		  		      <?php if($calcdet == '1'){ ?> <th>Items</th> <?php } ?>
                      
                      								<th>
                                                    <?php 
													echo implode('</th><th>',$prty_array);
													?>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>

<?php
$counter =1;
foreach($allsales as $siid=>$sales){
	
	if(($counter % 5) == '0'){
		?>
                                                <tr style="background-color:#F3EAB2" >
                                                    <th>#</th>
                                                    <th>Invoice Ref</th>
                                                    <th>Date</th>
                                                    <th>Client</th>
                                                    <th>Total</th>
		  		      <?php if($calcprofit== '1'){ ?><th>Cost Breakup</th> <?php } ?>
		  		      <?php if($calcprofit== '1'){ ?> <th>Total Cost</th> <?php } ?>
		  		      <?php if($calcprofit== '1'){ ?> <th>Markup</th> <?php } ?>
		  		      <?php if($calcdet == '1'){ ?> <th>Items</th> <?php } ?>
                      								<th>
                                                    <?php 
													echo implode('</th><th>',$prty_array);
													?>
                                                    </th>
                                                </tr>

        <?php
	}
	echo '<tr>';
	echo '
	<td>'.$counter.'</td>
	<td>'.$sales['ref'].'</td>
	<td>'.$sales['dnt'].'</td>
	<td>'.$sales['cli'].'</td>
	<td><u><strong>'.number_format($sales['total'],2).'</strong></u></td>';
if($calcprofit== '1'){  echo '<td>Additional: '.number_format($sales['additionalcost'],2).' & Product: '.number_format($sales['productcost'],2).'</td>'; }
if($calcprofit== '1'){  echo '<td><u><strong>'.number_format($sales['totalcost'],2).'</strong></u></td> '; } 
if($calcprofit== '1'){  echo '<td><strong>'.round($sales['markup'],2).'</strong></td>'; }

	if($calcdet == '1'){ 
	echo '<td>';
	#Items Start
$innersql = "SELECT * from sw_salesinvoices_items i
left join sw_products_list p on i.si_rel_pr_id = p.pr_id
left join sw_prod_types t on p.pr_rel_prty_id = t.prty_id
where si_valid =1 and p.pr_valid = 1 and t.prty_valid =1 and si_rel_so_id = ".$siid;

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
			</tr>
		</thead>
		<tbody>';
		$indvsales = 0;
		while($innerw = $inneres->fetch_assoc()) {
			echo '<tr>';
					if($innerw['prty_pr_hidden'] == '1'){
					echo '<td style="color:red">'.$innerw['pr_code'].'<br>'.convert_desc($innerw['si_desc']).'</td>'; 
					echo '<td style="color:red">'.$innerw['si_cost'].'</td>';
					echo '<td style="color:red">'.$innerw['si_price'].'</td>';
					echo '<td style="color:red">'.$innerw['si_qty'].'</td>';
					}else{
					echo '<td>'.$innerw['pr_code'].'<br>'.convert_desc($innerw['si_desc']).'</td>'; 
					echo '<td>'.$innerw['si_cost'].'</td>';
					echo '<td>'.$innerw['si_price'].'</td>';
					echo '<td>'.$innerw['si_qty'].'</td>';

					}
			echo '</tr>';
		}
		echo '</tbody></table>';
		
} else {
	
		echo "No Items";
}

	#Items End
	echo '</td>';
	}
			$totalisagoodboy = $totalisagoodboy + $sales['total'];  
			$totalcostisagoodboy = $totalcostisagoodboy + $sales['totalcost'];  
			$totalmarkupisagoodboy = $totalmarkupisagoodboy + $sales['markup'];  
			$totaladdcost = $totaladdcost + $sales['additionalcost'];  
			$totalprodcost = $totalprodcost + $sales['productcost'];  

		foreach($prty_array as $prtyid=>$prtyname){
			echo '<td>'.number_format($sales[$prtyid],2).'</td>';
			$total[$prtyid] = $total[$prtyid] + $sales[$prtyid];  
		}
	echo '</tr>';
	$counter++;
}

?>

<tr>
	<th colspan="3"></th>
	<th colspan="1">Total</th>
	<th> <?php echo number_format($totalisagoodboy,2); ?></th>
<?php if($calcprofit== '1'){ ?> <th>Additional: <?php echo number_format($totaladdcost,2); ?><br>Product: <?php echo number_format($totalprodcost,2); ?></th> <?php } ?>
<?php if($calcprofit== '1'){ ?> <th><?php  echo number_format($totalcostisagoodboy,2) ?></th> <?php } ?>
<?php if($calcprofit== '1'){ ?> <th><?php echo round(($totalmarkupisagoodboy)/count($allsales),2) ?></th> <?php } ?>

  <?php if($calcdet == '1'){ ?> <th></th> <?php } ?>
    
    <?php
	foreach($prty_array as $prtylid=>$lprtyname){
			echo '	<th> '.number_format($total[$prtylid],2).'</th>';
	}
	?>
</tr>
                        </tbody>
                                        </table>
                                        <!-- -->
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

<!-- Footer Ends -->




    </body>
      <?php  
	  get_end_script();
	  ?>   


<script src="assets/datatables/jquery.dataTables.min.js"></script>
<script src="assets/datatables/dataTables.bootstrap.js"></script>


</html>


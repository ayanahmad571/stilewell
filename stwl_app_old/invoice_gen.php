<?php
if(isset($_POST['ha_g']) and isset($_POST['gen_inv']) and isset($_POST['hash_viewer']) and isset($_POST['_view_ino'])){
die('Simontanious');
}

if(isset($_POST['ha_g']) and isset($_POST['gen_inv'])){
?>

<style type="text/css" media="print">
@page {
    size: auto;   /* auto is the initial value */
    margin: 0;  /* this affects the margin in the printer settings */
}
</style>
<link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-reset.css" rel="stylesheet">

        <!--Animation css-->
        <link href="css/animate.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="assets/select2/select2.css" />

        <link href="assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

        <!--Icon-fonts css-->
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/ionicon/css/ionicons.min.css" rel="stylesheet" />

        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="assets/morris/morris.css">

        <!-- sweet alerts -->
        <link href="assets/sweet-alert/sweet-alert.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/helper.css" rel="stylesheet">
        

           <?php
include('db_auth.php');
#$sql = "SELECT distinct(oi_rel_or_id)as oid from sw_order_items where oi_rel_pr_id = 3 and oi_valid= 1 ";
$inovsql = "SELECT * FROM `sw_orders` where md5(md5(sha1(sha1(md5(sha1(or_id)))))) = '".$_POST['ha_g']."'";
$inovres= $conn->query($inovsql);
$dis = $_POST['invo_disc'];
$vat = $_POST['invo_vat'];
$pr_list = array();
$pr_qt = array();
$pr_pric = array();
$pr_sp = array();

if ($inovres->num_rows > 0) {
    // output data of each row
    while($inovrw = $inovres->fetch_assoc()) {
		$orid = $inovrw['or_id'];
		$inv_nm = $_POST['invo_num'].'-'.date('Y-m-d',time());
		#firts loop begins
		echo '
<div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <!-- <div class="panel-heading">
                                <h4>Invoice</h4>
                            </div> -->
                            <div class="panel-body">
                                <div class="clearfix">
                                    <div class="pull-left">
                                        <h4 class="text-right"><img width="100px" src="img/logo.jpg" alt="SW LOGO"></h4>
                                        
                                    </div>
                                    <div class="pull-right">
                                        <h4>Invoice # <br>
                                            <strong>'.$inv_nm.'</strong>
                                        </h4>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        
                                        <div class="pull-left m-t-30">
										From:
                                            <address>
                                              <strong>Stile Well General Trading LLC</strong><br>
                                              704 Tower 51, Buisness Bay<br>
                                              P.O Box 390325, Dubai UAE<br>
                                              <abbr title="Phone">tel:</abbr> (971) 4 424-0177, 421-4799<br>
                                              <abbr title="fax">fax:</abbr> (123) 421-4799
                                              </address>
                                        </div>
										<div class="col-xs-1">
										<br>
<br>

										</div>
										
										<div class="pull-left m-t-30">
										To:
                                            <address>
											<strong>
                                             '.$_POST['invo_cl_addr'].'
                                              </strong>
											  </address>
                                        </div>
										
                                        <div class="pull-right m-t-30">
<p class="m-t-10"><strong>LPO: </strong> '.$_POST['invo_lpo'].'</p>
<p><strong>Order Date: </strong> '.date('M d, Y',$inovrw['or_datentime']).'</p>
<p class="m-t-10"><strong>Order Name: </strong> '.$inovrw['or_ref_name'].'</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-h-50"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table m-t-30">
                                                <thead>
                                                    <tr>
													<th>#</th>
                                                    <th>Item</th>
                                                    <th>Description</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Cost</th>
                                                    <th>Total</th>
                                                </tr></thead>
                                                <tbody>
		
		';
		
			$innersql = "SELECT * from sw_order_items where oi_rel_or_id = ".$inovrw['or_id']." and oi_valid =1";
			$inneres = $conn->query($innersql);
		
			if ($inneres->num_rows > 0) {
			// output data of each row
			$placce = 1;
			$total_sum = array();
			while($innerw = $inneres->fetch_assoc()) {
			#2nd loop start
			
								/*second option= 
								SELECT * from sw_order_items left join pr_list_final on
oi_rel_pr_id = pr_id
where oi_rel_or_id = 1 and oi_valid =1 and pr_valid=1 and sh_valid =1
								
								
								*/
								$pr_qt[] = $innerw['oi_qty'];
							$pr_pric[] = $innerw['oi_price_for_one'];
							$pr_sp[] = $innerw['oi_pr_special'];
							$getorderdet = "SELECT * from sw_products_list where pr_id = ".$innerw['oi_rel_pr_id']." ";
							$getorderdetres = $conn->query($getorderdet);
							if ($getorderdetres->num_rows > 0) {
								
							// output data of each row
							
							while($getorderdetrw = $getorderdetres->fetch_assoc()) {
							#3rd loop begins	
							$pr_list[] = $getorderdetrw['pr_id'];
							
							
								echo '<tr>
                                                        <td>'.$placce.'</td>
                                                        <td>'.$getorderdetrw['pr_type'].'-'.$getorderdetrw['pr_code'].' '.$getorderdetrw['pr_name'].'</td>
                                                        <td>'.$getorderdetrw['pr_desc'].' .<br>'.$innerw['oi_pr_special'].'</td>
                                                        <td>'.$innerw['oi_qty'].'</td>
                                                        <td><strong>AED </strong>'.number_format($innerw['oi_price_for_one'], 2).'</td>
                                                        <td><strong>AED </strong>'.number_format($innerw['oi_price_for_one']*$innerw['oi_qty'], 2).'</td>
                                                    </tr>
                                                   ';
												   $total_sum[] = ($innerw['oi_price_for_one']*$innerw['oi_qty']);

						$placce++;
							#3rd loop ends
							}
						} else {

						}
		
			
			
		#2nd loop end	
			}
		} else {
			echo '<i style="color:red">No Products</i>';
		}
		
	
	echo '
	</tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="border-radius: 0px;">
                                    <div class="col-md-3 col-md-offset-9">
                                        <p class="text-right"><b>Sub-total:</b>'.number_format(array_sum($total_sum), 2).'</p>
                                        <p class="text-right">Discout: '.$dis.'%</p>
                                        <p class="text-right">VAT: '.$vat.'%</p>
                                        <hr>
                                        <h3 class="text-right">AED ';
$dis_calc =(array_sum($total_sum)*($dis/100));				
$vat_calc =(array_sum($total_sum)*($vat/100));				
$calc_a =(array_sum($total_sum)-$dis_calc);
$calc_b =number_format($calc_a+$vat_calc, 2);
echo $calc_b.'</h3>
                                    </div>
                                </div>
                                <hr>
								<div class="row">
										<p>'.$_POST['invo_ins'].'</p>
                                </div>
                                <div class="hidden-print">
                                    <div class="pull-right">
                                        <a href="" onClick="window.print()" class="btn btn-inverse"><i class="fa fa-print"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
	';
	
	#first loop ends
    }
} else {
    echo "";
}
 ?> 
 
 <?php 
 $inssql = "INSERT INTO `invoices_gen`(`inov_or_id`, `inov_pr_list`, `inov_pr_qt_pric`, `inov_bot_ins`, `inov_no_name`, `inov_dis`, `inov_cl_addr`, `inov_lpo`, `inov_vat`,`inov_gn_dnt`) VALUES
 (
 '".$orid."', 
 '".implode(',',$pr_list)."', 
 '".implode(',',$pr_qt)."|".implode(',',$pr_pric)."|".implode(',',$pr_sp)."', 
 '".$_POST['invo_ins']."', 
 '".$inv_nm."', 
 '".$dis."', 
 '".$_POST['invo_cl_addr']."', 
 '".$_POST['invo_lpo']."', 
 '".$_POST['invo_vat']."',
 '".time()."'
  )";
 if($conn->query($inssql)){
	 
 }else{
	 die('Problem');
 }
 ?>

 <?php	
}
?>
<?php

############################################################################################################################################################################################################################################################################################################################################################
############################################################################################################################################################################################################################################################################################################################################################
?>

 <?php
if(isset($_POST['hash_viewer']) and isset($_POST['_view_ino'])){
	?>
    
<style type="text/css" media="print">
@page {
    size: auto;   /* auto is the initial value */
    margin: 0;  /* this affects the margin in the printer settings */
}
</style>
<link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-reset.css" rel="stylesheet">

        <!--Animation css-->
        <link href="css/animate.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="assets/select2/select2.css" />

        <link href="assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

        <!--Icon-fonts css-->
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/ionicon/css/ionicons.min.css" rel="stylesheet" />

        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="assets/morris/morris.css">

        <!-- sweet alerts -->
        <link href="assets/sweet-alert/sweet-alert.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/helper.css" rel="stylesheet">
        

           <?php
include('db_auth.php');
#$sql = "SELECT distinct(oi_rel_or_id)as oid from sw_order_items where oi_rel_pr_id = 3 and oi_valid= 1 ";
$getsavedinvsql = "SELECT * FROM `invoices_gen` where inov_valid =1	and md5(md5(sha1(sha1(md5(sha1(inov_id)))))) = '".$_POST['hash_viewer']."'";
$sinres= $conn->query($getsavedinvsql);
if ($sinres->num_rows == 1) {
    // output data of each row
    $sinrw = $sinres->fetch_assoc();
	
}else{
	die('ID Conflict');
}


$inovsql = "SELECT * FROM `sw_orders` where or_id = '".$sinrw['inov_or_id']."'";
$inovres= $conn->query($inovsql);
$dis = $sinrw['inov_dis'];
$vat = $sinrw['inov_vat'];

$conf = explode('|',$sinrw['inov_pr_qt_pric']);
$prq = explode(',',$conf[0]);

$prpr = explode(',',$conf[1]);

$prsp = explode(',',$conf[2]);






if ($inovres->num_rows > 0) {
    // output data of each row
    while($inovrw = $inovres->fetch_assoc()) {
		$orid = $inovrw['or_id'];
		$inv_nm = $sinrw['inov_gn_dnt'].'-'.date('Y-m-d',time());
		#firts loop begins
		echo '
<div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <!-- <div class="panel-heading">
                                <h4>Invoice</h4>
                            </div> -->
                            <div class="panel-body">
                                <div class="clearfix">
                                    <div class="pull-left">
                                        <h4 class="text-right"><img width="100px" src="img/logo.jpg" alt="SW LOGO"></h4>
                                        
                                    </div>
                                    <div class="pull-right">
                                        <h4>Invoice # <br>
                                            <strong>'.$inv_nm.'</strong>
                                        </h4>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        
                                        <div class="pull-left m-t-30">
										From:
                                            <address>
                                              <strong>Stile Well General Trading LLC</strong><br>
                                              704 Tower 51, Buisness Bay<br>
                                              P.O Box 390325, Dubai UAE<br>
                                              <abbr title="Phone">tel:</abbr> (971) 4 424-0177, 421-4799<br>
                                              <abbr title="fax">fax:</abbr> (123) 421-4799
                                              </address>
                                        </div>
										<div class="col-xs-1">
										<br>
<br>

										</div>
										
										<div class="pull-left m-t-30">
										To:
                                            <address>
											<strong>
                                             '.$sinrw['inov_cl_addr'].'
                                              </strong>
											  </address>
                                        </div>
										
                                        <div class="pull-right m-t-30">
<p class="m-t-10"><strong>LPO: </strong> '.$sinrw['inov_lpo'].'</p>
<p><strong>Order Date: </strong> '.date('M d, Y',$inovrw['or_datentime']).'</p>
<p class="m-t-10"><strong>Order Name: </strong> '.$inovrw['or_ref_name'].'</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-h-50"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table m-t-30">
                                                <thead>
                                                    <tr>
													<th>#</th>
                                                    <th>Item</th>
                                                    <th>Description</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Cost</th>
                                                    <th>Total</th>
                                                </tr></thead>
                                                <tbody>
		
		';
		
			
								
								
							
			$total_sum = array();
							$getorderdet = "SELECT * from sw_products_list where pr_id in(".$sinrw['inov_pr_list'].") ";
							$getorderdetres = $conn->query($getorderdet);
							if ($getorderdetres->num_rows > 0) {
								$placce =0;
							// output data of each row
							
							while($getorderdetrw = $getorderdetres->fetch_assoc()) {
							#3rd loop begins	
							
								echo '<tr>
                                                        <td>'.($placce+1) .'</td>
                                                        <td>'.$getorderdetrw['pr_type'].'-'.$getorderdetrw['pr_code'].' '.$getorderdetrw['pr_name'].'</td>
                                                        <td>'.$getorderdetrw['pr_desc'].' .<br>'.$prsp[$placce].'</td>
                                                        <td>'.$prq[$placce].'</td>
                                                        <td><strong>AED </strong>'.number_format($prpr[$placce], 2).'</td>
                                                        <td><strong>AED </strong>'.number_format($prpr[$placce]*$prq[$placce], 2).'</td>
                                                    </tr>
                                                   ';
												   $total_sum[] = ($prpr[$placce]*$prq[$placce]);

						$placce++;
							#3rd loop ends
							}
						} else {

						}
		
			
			
	
	
	
	echo '
	</tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="border-radius: 0px;">
                                    <div class="col-md-3 col-md-offset-9">
                                        <p class="text-right"><b>Sub-total:</b>'.number_format(array_sum($total_sum), 2).'</p>
                                        <p class="text-right">Discout: '.$dis.'%</p>
                                        <p class="text-right">VAT: '.$vat.'%</p>
                                        <hr>
                                        <h3 class="text-right">AED ';
$dis_calc =(array_sum($total_sum)*($dis/100));				
$vat_calc =(array_sum($total_sum)*($vat/100));				
$calc_a =(array_sum($total_sum)-$dis_calc);
$calc_b =number_format($calc_a+$vat_calc, 2);
echo $calc_b.'</h3>
                                    </div>
                                </div>
                                <hr>
								<div class="row">
										<p>'.$sinrw['inov_bot_ins'].'</p>
                                </div>
                                <div class="hidden-print">
                                    <div class="pull-right">
                                        <a href="" onClick="window.print()" class="btn btn-inverse"><i class="fa fa-print"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
	';
	
	#first loop ends
    }
} else {
    echo "";
}
 ?> 
    
    <?php
}?>                                                   
                                                
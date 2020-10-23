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
<?php
$checkusereligibility = "SELECT * FROM `sw_modules` WHERE mo_valid =1 and FIND_IN_SET(".$_SESSION['STWL_LUM_TU_ID'].", mo_for) > 0 and mo_href = '".trim(basename($_SERVER['PHP_SELF']))."'";
if(is_array(getdatafromsql($conn,$checkusereligibility))){
}else{
	$cue1 = "SELECT * FROM `sw_submod` WHERE sub_valid =1 and sub_href = '".trim(basename($_SERVER['PHP_SELF']))."'";
	$cue1 = getdatafromsql($conn,$cue1);
	if(is_array($cue1)){
		$cue = "SELECT * FROM `sw_modules` WHERE mo_valid =1 and FIND_IN_SET(".$_SESSION['STWL_LUM_TU_ID'].", mo_for) > 0 and
		 mo_id = '".$cue1['sub_mo_rel_mo_id']."'";
		if(is_array(getdatafromsql($conn,$cue))){
		}else{
			die('<h1>503</h1><br>
			Access Denied');
		
		}
	}else{
		die('<h1>503</h1><br>
	Access Denied');
	}
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

<!-- Aside Start-->
<aside class="left-panel">
  <?php
		give_brand();
		?>
  <?php 
			get_modules($conn,$login,$admin);
			?>
</aside>
<!-- Aside Ends--> 

<!--Main Content Start -->
<section class="content"> 
  
  <!-- Header -->
  <header class="top-head container-fluid">
    <button type="button" class="navbar-toggle pull-left"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    
    <!-- Left navbar -->
    <nav class=" navbar-default" role="navigation"> 
      
      <!-- Right navbar -->
      <?php
                    if($login==1){
						include('ifloginmodalsection.php');
					}
					?>
      
      <!-- End right navbar --> 
    </nav>
  </header>
  <!-- Header Ends --> 
  
  <!-- Page Content Start --> 
  <!-- ================== -->
  
  <div class="wraper container-fluid">
    <div class="row">
      <div class="col-lg-12	">
        <div class="panel panel-default"><!-- /primary heading -->
          <div class="portlet-heading">
            <div class="panel-heading">
              <h3 class="panel-title">Payment Tracker</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div style=" overflow:auto;
 position:relative;" class="row">
                    <table id="datatable1" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Proforma Ref</th>
                          <th>Invoice Ref</th>
                          <th>Client Name</th>
                          <th>AED <br>
                            Conversion<br>
                            Rate</th>
                          <th>Total Price <br>
                            (Including Vat and Discout)</th>
                          <th>Amount Paid</th>
                          <th>Amount Left</th>
                          <th>Installments</th>
                          <th>Due Date</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
$productsql = "SELECT * FROM `sw_proformas` 
WHERE po_valid=1 and po_revision =0 order by po_ref desc
";
$productres = $conn->query($productsql);

/*
select * from sw_purchaseorders where pco_valid =1 and pco_revision_id = '".$_POST['add_salesinvoice_proforma_hash']."' order by pco_revision desc limit 1 
*/
if ($productres->num_rows > 0) {
	//'.md5(md5(sha1(md5($productrw['pr_id'])))).'_primga output data of each row
	$con = 1;
	while($productrw = $productres->fetch_assoc()) {
	$getmaxproforma = getdatafromsql($conn,"
select * from sw_proformas p
left join sw_clients c on p.po_rel_cli_id = c.cli_id
left join sw_currency cy on p.po_rel_cur_id = cy.cur_id
where po_valid =1 and cli_valid =1 and po_revision_id = '".$productrw['po_id']."' order by po_revision desc limit 1");
$getsales = getdatafromsql($conn, "
select * from `sw_salesinvoices` s
left join sw_proformas pk on s.so_rel_po_id = pk.po_id
 where po_valid=1 and so_valid =1 and po_revision_id = ".$productrw['po_id']." order by so_revision desc limit 1"); 
 
$cur_name = $getmaxproforma['cur_name'];
$cur_rate = $getmaxproforma['po_cur_rate'];
$cli_name = $getmaxproforma['cli_name'];
$duedate = '-(No Sales Invoice Yet)';
 if(is_array($getsales)){
	 $salesref = $getsales['so_ref'];
	$checkgen = getdatafromsql($conn,"select * from sw_salesinvoices_gen where sog_rel_so_id = ".$getsales['so_revision_id']." and sog_valid =1 
	order by sog_id desc limit 1");				
	 $checkgenerror ='Generate Sales invoice for Ref: <strong>'.$getsales['so_ref'].'</strong>';
	 
	 if(is_array($checkgen)){

$gettotalprice = getdatafromsql($conn,"select sum(si_qty * si_price) as total from sw_salesinvoices_items 
left join sw_products_list on si_rel_pr_id = pr_id left join sw_prod_types on pr_rel_prty_id = prty_id 
where si_rel_so_id = ".$getsales['so_id']." and si_valid =1 and prty_pr_hidden = 0");

$gettotalpricegen = getdatafromsql($conn,"select sog_discount as sog_discount,
((sog_vat * (".($gettotalprice['total'])." - sog_discount))/100) as sog_vat,
(sog_extra_price) from sw_salesinvoices_gen where sog_rel_so_id = ".$getsales['so_revision_id']." and sog_valid =1 order by sog_dnt desc limit 1");

$getamountpaid = getdatafromsql($conn,"select sum(pt_val) as total from sw_payments where pt_rel_po_id = ".$productrw['po_id']." and pt_valid =1");
$getinstallments = getdatafromsql($conn,"select count(pt_id) as total from sw_payments where pt_rel_po_id = ".$productrw['po_id']." and pt_valid =1");
$duedate = (time() > $getsales['so_due_date'] ? '<i style="color:red">'.date('d-M-Y',$getsales['so_due_date']).'</i>': date('d-M-Y',$getsales['so_due_date']));
				$total = (($gettotalprice['total'] - $gettotalpricegen['sog_discount'] + $gettotalpricegen['sog_extra_price']+ $gettotalpricegen['sog_vat']));

		 
	 }
}else{
	unset ($checkgen);
	 $salesref = '0';
	 	$checkgen = getdatafromsql($conn,"select * from sw_proformas_gen where pog_rel_po_id = ".$getmaxproforma['po_revision_id']." and pog_valid =1 
	order by pog_id desc limit 1");				
	 $checkgenerror ='Generate Proforma for Ref: <strong>'.$getmaxproforma['po_ref'].'</strong>';
	 
if(is_array($checkgen)){

$gettotalprice = getdatafromsql($conn,"select sum(pi_qty * pi_price) as total from sw_proformas_items 
left join sw_products_list on pi_rel_pr_id = pr_id left join sw_prod_types on pr_rel_prty_id = prty_id 
where pi_rel_po_id = ".$getmaxproforma['po_id']." and pi_valid =1 and prty_pr_hidden = 0");
$gettotalpricegen = getdatafromsql($conn,"select pog_discount as pog_discount,
((pog_vat * (".$gettotalprice['total']." - pog_discount)/100)) as pog_vat,
(pog_extra_price) from sw_proformas_gen where pog_rel_po_id = ".$getmaxproforma['po_revision_id']." and pog_valid =1 order by pog_dnt desc limit 1");

$getamountpaid = getdatafromsql($conn,"select sum(pt_val) as total from sw_payments where pt_rel_po_id = ".$productrw['po_id']." and pt_valid =1");
$getinstallments = getdatafromsql($conn,"select count(pt_id) as total from sw_payments where pt_rel_po_id = ".$productrw['po_id']." and pt_valid =1");
				$total = (($gettotalprice['total'] - $gettotalpricegen['pog_discount'] + $gettotalpricegen['pog_extra_price']+ $gettotalpricegen['pog_vat']));


	}
 }
if(is_array($checkgen)){
  echo '
 <tr>
 <td>'.$con.'</td>
 <td>'.$getmaxproforma['po_ref'].'</td>
 <td>'.$salesref.'</td>
	<td>'.$cli_name.'</td>
	<td>'.$cur_rate.'</td>
	<td>'.$cur_name.' '.number_format($total ,2).'</td>
	<td>'.$cur_name.' '.number_format((($getamountpaid['total']  * $cur_rate)) ,2).'</td>
	<td>'.$cur_name.' '.number_format(($total - ($getamountpaid['total']) * $cur_rate),2).'</td>
	<td>'.$getinstallments['total'].'</td>
	<td>'.$duedate.'</td>
 	<td>
<button id="getQty" data-toggle="modal" data-target="#view-modal" data-id="'.md5($productrw['po_id']).'" class="btn btn-sm btn-warning">View</button>
<button id="AddQty" data-toggle="modal" data-target="#view-modal" data-id="'.md5($productrw['po_id']).'" class="btn btn-sm btn-success">Add</button>
	</td>

 </tr>';
 }else{
	 echo '<tr>
	<td>	'.$con.'</td>
<td style="border-right-width: 0px;">'.$checkgenerror.' to Manage Payments</td>
	<td style="border-right-width: 0px;">	</td>
	<td style="border-right-width: 0px;">	</td>
	<td style="border-right-width: 0px;">	</td>
	<td style="border-right-width: 0px;">	</td>
	<td style="border-right-width: 0px;">	</td>
	<td style="border-right-width: 0px;">	</td>
	<td style="border-right-width: 0px;">	</td>
	<td style="border-right-width: 0px;">	</td>
	<td>	</td>
	</tr>';
 }
				$con++;

	}

} else {
}?>
                      </tbody>
                    </table>
                    <!-- -->
                    
                    <hr>
                    &nbsp;
                    <h4>Payment History</h4>
                    <table id="datatable2" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Proforma Ref</th>
                          <th>Client </th>
                          <th>Method</th>
                          <th>Cheque Number</th>
                          <th>Cheque Dated</th>
                          <th>Value</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
$bproductsql = "SELECT * FROM `sw_payments`
left join sw_payments_methods on pt_rel_method_id = method_id 
left join sw_proformas on pt_rel_po_id = po_id
left join sw_clients on po_rel_cli_id = cli_id
left join sw_currency on po_rel_cur_id = cur_id
WHERE po_valid=1 order by pt_dnt desc
";
$bproductsql = $conn->query($bproductsql);

/*
select * from sw_purchaseorders where pco_valid =1 and pco_revision_id = '".$_POST['add_salesinvoice_proforma_hash']."' order by pco_revision desc limit 1 
*/
if ($bproductsql->num_rows > 0) {
	//'.md5(md5(sha1(md5($productrw['pr_id'])))).'_primga output data of each row
	$con = 1;
	while($prodrow = $bproductsql->fetch_assoc()) {
		echo '<tr>
	<td>'.$con.'</td>
	<td>'.$prodrow['po_ref'].'</td>
	<td>'.$prodrow['cli_name'].'</td>
	<td>'.$prodrow['method_name'].'</td>
	<td>'.$prodrow['pt_cheque_number'].'</td>
	<td>'.($prodrow['pt_rel_method_id'] == '2' ? "-" : date('j-n-Y',$prodrow['pt_cheque_date'])).'</td>
	<td>'.$prodrow['cur_name'].' '.number_format(($prodrow['pt_val'] * $prodrow['po_cur_rate']),2).'</td>
	</tr>';
	$con++;
	}

} else {
}?>
                      </tbody>
                    </table>
                    <!-- --> 
                    
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
            <?php
			$foryesterday = getdatafromsql($conn,"SELECT ifnull(count(pt_id),0) as nos FROM 
sw_payments

WHERE pt_valid = 1 and
 ((from_unixtime(`pt_cheque_date`, '%d') *1 )  = ".(date('j',(time()-86400))).") and 
 ((from_unixtime(`pt_cheque_date`, '%m') *1 )  = ".(date('n',(time()-86400))).") and 
 ((from_unixtime(`pt_cheque_date`, '%Y') *1 )  = ".(date('Y',(time()-86400))).")");

			$fortoday = getdatafromsql($conn,"SELECT ifnull(count(pt_id),0) as nos FROM 
sw_payments

WHERE pt_valid = 1 and
 ((from_unixtime(`pt_cheque_date`, '%d') *1 )  = ".(date('j',(time()))).") and 
 ((from_unixtime(`pt_cheque_date`, '%m') *1 )  = ".(date('n',(time()))).") and 
 ((from_unixtime(`pt_cheque_date`, '%Y') *1 )  = ".(date('Y',(time()))).")");

			$fortom = getdatafromsql($conn,"SELECT ifnull(count(pt_id),0) as nos FROM 
sw_payments

WHERE pt_valid = 1 and
 ((from_unixtime(`pt_cheque_date`, '%d') *1 )  = ".(date('j',(time()+86400))).") and 
 ((from_unixtime(`pt_cheque_date`, '%m') *1 )  = ".(date('n',(time()+86400))).") and 
 ((from_unixtime(`pt_cheque_date`, '%Y') *1 )  = ".(date('Y',(time()+86400))).")");

			$fordayaftertom = getdatafromsql($conn,"SELECT ifnull(count(pt_id),0) as nos FROM 
sw_payments

WHERE pt_valid = 1 and
 ((from_unixtime(`pt_cheque_date`, '%d') *1 )  = ".(date('j',(time()+(86400*2)))).") and 
 ((from_unixtime(`pt_cheque_date`, '%m') *1 )  = ".(date('n',(time()+(86400*2)))).") and 
 ((from_unixtime(`pt_cheque_date`, '%Y') *1 )  = ".(date('Y',(time()+(86400*2)))).")");

			?>
  <div class="col-xs-12 col-md-4 col-xl-6 col-lg-5">
    <h3>Yesterday Cheques          (<?php echo date('j-n-Y',(time()-86400)); ?>)               :<button id="PastPay" data-toggle="modal" data-target="#view-modal" class="btn btn-sm btn-success"> <?php echo $foryesterday['nos'] ?></button></h3>
    <h3>Cheques for Today (<?php echo date('j-n-Y',time()); ?>)                           :<button id="TodayPay" data-toggle="modal" data-target="#view-modal" class="btn btn-sm btn-success">  <?php echo $fortoday['nos'] ?></button></h3>
    <h3>Cheques for Tomorrow (<?php echo date('j-n-Y',(time()+86400)); ?>)                :<button id="TomorrowPay" data-toggle="modal" data-target="#view-modal" class="btn btn-sm btn-success">  <?php echo $fortom['nos'] ?></button></h3>
    <h3>Cheques for Day After Tomorrow (<?php echo date('j-n-Y',(time()+(86400*2))); ?>)  :<button id="DATPay" data-toggle="modal" data-target="#view-modal" class="btn btn-sm btn-success">  <?php echo $fordayaftertom['nos'] ?></button></h3>
  </div>
              <div class="col-xs-12 col-md-8 col-xl-6 col-lg-7">
                <div id='calendar'></div>
              </div>
            </div>
          </div>
          <!-- end col --> 
          
        </div>
        <!-- End row --> 
        
      </div>
      <!-- End row --> 
      
    </div>
    <!-- Page Content Ends --> 
    <!-- ================== --> 
    
    <!-- Footer Start -->
    
    <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-full modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">Payment Tracker</h4>
          </div>
          <div class="modal-body">
            <div id="modal-loader-b" style="display: none; text-align: center;"> 
              <!-- ajax loader --> 
              <img width="100px" src="img/ajax-loader.gif"> </div>
            
            <!-- mysql data will be load here -->
            <div id="dynamic-content-b"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Footer Start -->
    <footer class="footer">
      <?php auto_copyright(); // Current year?>
      Aforty </footer>
    <!-- Footer Ends --> 
    
  </div>
</section>
<!-- Main Content Ends -->

<?php  
	  get_end_script();
	  ?>
<script src="assets/fullcalendar/moment.min.js"></script> 
<script src="assets/fullcalendar/fullcalendar.min.js"></script> 
<script src="assets/datatables/jquery.dataTables.min.js"></script> 
<script src="assets/datatables/dataTables.bootstrap.js"></script> 
<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable1').dataTable({
			 searchHighlight: true
			});
    } );
</script> 
<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable2').dataTable({
			 searchHighlight: true
			});
    } );
</script> 
<script>
$(document).ready(function(){

$(document).on('click', '#AddQty', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'payment_add='+uid,
          dataType: 'html'
     })
     .done(function(data){
          console.log(data); 
          $('#dynamic-content-b').html(''); // blank before load.
          $('#dynamic-content-b').html(data); // load here
          $('#modal-loader-b').hide(); // hide loader  
     })
     .fail(function(){
          $('#dynamic-content-b').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
          $('#modal-loader-b').hide();
     });

    });
});
</script> 



<script>
$(document).ready(function(){

$(document).on('click', '#PastPay', function(e){  
     e.preventDefault();
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'past_pay=1',
          dataType: 'html'
     })
     .done(function(data){
          console.log(data); 
          $('#dynamic-content-b').html(''); // blank before load.
          $('#dynamic-content-b').html(data); // load here
          $('#modal-loader-b').hide(); // hide loader  
     })
     .fail(function(){
          $('#dynamic-content-b').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
          $('#modal-loader-b').hide();
     });

    });
});
</script> 
<script>
$(document).ready(function(){

$(document).on('click', '#TodayPay', function(e){  
     e.preventDefault();
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'today_pay=1',
          dataType: 'html'
     })
     .done(function(data){
          console.log(data); 
          $('#dynamic-content-b').html(''); // blank before load.
          $('#dynamic-content-b').html(data); // load here
          $('#modal-loader-b').hide(); // hide loader  
     })
     .fail(function(){
          $('#dynamic-content-b').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
          $('#modal-loader-b').hide();
     });

    });
});
</script> 
<script>
$(document).ready(function(){

$(document).on('click', '#TomorrowPay', function(e){  
     e.preventDefault();
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'tomorrow_pay=1',
          dataType: 'html'
     })
     .done(function(data){
          console.log(data); 
          $('#dynamic-content-b').html(''); // blank before load.
          $('#dynamic-content-b').html(data); // load here
          $('#modal-loader-b').hide(); // hide loader  
     })
     .fail(function(){
          $('#dynamic-content-b').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
          $('#modal-loader-b').hide();
     });

    });
});
</script> 
<script>
$(document).ready(function(){

$(document).on('click', '#DATPay', function(e){  
     e.preventDefault();
  
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'dayaftertomorrow_pay=1',
          dataType: 'html'
     })
     .done(function(data){
          console.log(data); 
          $('#dynamic-content-b').html(''); // blank before load.
          $('#dynamic-content-b').html(data); // load here
          $('#modal-loader-b').hide(); // hide loader  
     })
     .fail(function(){
          $('#dynamic-content-b').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
          $('#modal-loader-b').hide();
     });

    });
});
</script> 



<script>
$(document).ready(function(){

$(document).on('click', '#getQty', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'payment_view='+uid,
          dataType: 'html'
     })
     .done(function(data){
          console.log(data); 
          $('#dynamic-content-b').html(''); // blank before load.
          $('#dynamic-content-b').html(data); // load here
          $('#modal-loader-b').hide(); // hide loader  
     })
     .fail(function(){
          $('#dynamic-content-b').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
          $('#modal-loader-b').hide();
     });

    });
});
</script> 
<script type="text/javascript" src="assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
<script type="text/javascript" src="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script> 
<script>
$(document).ready(function(){
		  $(".wysihtml5").wysihtml5();
});
</script>
<?php 
	$jsvar = array();	
			
$sql = "SELECT * FROM sw_payments where pt_valid =1 and pt_rel_method_id =1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	$jsvar[] ="    {
                        title: 'Ch: ".$row['pt_cheque_number']."',
                        start: new Date(".date('Y',trim($row['pt_cheque_date'])).", ".(date('n',trim($row['pt_cheque_date']))-1).", ".date('j',trim($row['pt_cheque_date'])).", 12, 5), 
                        end: new Date(".date('Y',trim($row['pt_cheque_date'])).", ".(date('n',trim($row['pt_cheque_date']))-1).", ".date('j',trim($row['pt_cheque_date'])).", 23 ,29)
                    }
					
					";
	}
} 
		

		?>
<script>


!function($) {
    "use strict";

    var CalendarPage = function() {};

    CalendarPage.prototype.init = function() {

        //checking if plugin is available
        if ($.isFunction($.fn.fullCalendar)) {
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek,basicDay'
                },
                events: [<?php 
echo implode(', ',$jsvar);?>]
            });
            
             /*Add new event*/
            // Form to add new event


        }
        else {
            alert("Calendar plugin is not installed");
        }
    },
    //init
    $.CalendarPage = new CalendarPage, $.CalendarPage.Constructor = CalendarPage
}(window.jQuery),

//initializing 
function($) {
    "use strict";
    $.CalendarPage.init()
}(window.jQuery);

		</script>
</body>
</html>

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
                <button type="button" class="navbar-toggle pull-left">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
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
                                <h3 class="panel-title">Costing</h3>
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
                                                    <th>Client</th>
                                                    <th>Subtotal <br>Sales Price AED</th>
                                                    <th>Subtotal <br>Cost AED (only cost)</th>
                                                    <th>Additional Cost AED</th>
                                                    <th>Discount AED</th>
                                                    <th>Extra Price AED</th>
                                                    <th>Vat AED</th>
                                                    <th>Total Cost</th>
                                                    <th>Markup</th>
													<th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
$productsql = "SELECT * FROM `sw_proformas` 
WHERE po_revision = 0 and po_valid=1
order by po_ref desc
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
$cli_name = $getmaxproforma['cli_name'];

 if(is_array($getsales)){
	 $salesref = $getsales['so_ref'];
	$checkgen = getdatafromsql($conn,"select * from sw_salesinvoices_gen where sog_rel_so_id = ".$getsales['so_revision_id']." and sog_valid =1 order by sog_id desc limit 1");				
	 $checkgenerror ='<td style="border-right:0 !important;">Generate Sales invoice for Ref: <strong>'.$getsales['so_ref'].'</strong></td>
	<td style="border-right:0 !important;"></td>
	<td></td>';
$getpricetotal = getdatafromsql($conn,"select sum(si_qty * si_price) as ptotal from sw_salesinvoices_items 
left join sw_products_list on si_rel_pr_id = pr_id
left join sw_prod_types on pr_rel_prty_id = prty_id
where si_rel_so_id = ".$getsales['so_id']." and si_valid =1 and prty_pr_hidden = 0");
$getcosttotal = getdatafromsql($conn,"select sum(si_qty * si_cost) as ctotal from sw_salesinvoices_items where si_rel_so_id = ".$getsales['so_id']." and si_valid =1");
$getacosttotal = getdatafromsql($conn,"select ifnull(sum(cost_val) ,0) as atotal from sw_costing where cost_rel_po_id = ".$productrw['po_id']." and cost_valid =1");

if(is_array($checkgen)){
$ifcheckgen = '<td>'.$checkgen['sog_discount'].'</td>
	<td>'.$checkgen['sog_extra_price'].'</td>
	<td>('.$checkgen['sog_vat'].'% of '.$getpricetotal['ptotal'].' - '.$checkgen['sog_discount'].')</td>';
		 
	 }
}else{
	 $salesref = '0';
	 	$checkgen = getdatafromsql($conn,"select * from sw_proformas_gen where pog_rel_po_id = ".$getmaxproforma['po_revision_id']." and pog_valid =1 order by pog_id desc limit 1");				
	 $checkgenerror ='<td style="border-right:0 !important;">Generate Proforma for Ref: <strong>'.$getmaxproforma['po_ref'].'</strong></td>
	<td style="border-right:0 !important;"></td>
	<td></td>';
	 
$getpricetotal = getdatafromsql($conn,"select sum(pi_qty * pi_price) as ptotal from sw_proformas_items
left join sw_products_list on pi_rel_pr_id = pr_id
left join sw_prod_types on pr_rel_prty_id = prty_id
where pi_rel_po_id = ".$getmaxproforma['po_id']." and pi_valid =1 and prty_pr_hidden =0");
$getcosttotal = getdatafromsql($conn,"select sum(pi_qty * pi_cost) as ctotal from sw_proformas_items where pi_rel_po_id = ".$getmaxproforma['po_id']." and pi_valid =1");
$getacosttotal = getdatafromsql($conn,"select ifnull(sum(cost_val) ,0) as atotal from sw_costing where cost_rel_po_id = ".$productrw['po_id']." and cost_valid =1");

if(is_array($checkgen)){
$ifcheckgen = '<td>'.$checkgen['pog_discount'].'</td>
	<td>'.$checkgen['pog_extra_price'].'</td>
	<td>'.$checkgen['pog_vat'].'</td>';

	}
 }
		echo '<tr>
	<td>'.$con.'</td>
	<td>'.$getmaxproforma['po_ref'].'</td>
	<td>'.$salesref.'</td>
	<td>'.$cli_name.'</td>
	<td>'.number_format($getpricetotal['ptotal'] ,2).'</td>
	<td>'.number_format($getcosttotal['ctotal'] ,2).'</td>
	<td>'.number_format($getacosttotal['atotal'] ,2).'</td>';
	if(is_array($checkgen)){ echo $ifcheckgen;}else{echo $checkgenerror;}
	echo'
	<td>'.number_format(($getcosttotal['ctotal'] + $getacosttotal['atotal']) ,2).'</td>
	<td>'.((($getcosttotal['ctotal'] + $getacosttotal['atotal']) == '0') ? 'Division by Zero' : number_format(($getpricetotal['ptotal']/($getcosttotal['ctotal'] + $getacosttotal['atotal'])) ,2)).'</td>
	<td>
<button id="getQty" data-toggle="modal" data-target="#view-modal" data-id="'.md5($productrw['po_id']).'" class="btn btn-sm btn-warning">View</button>
<button id="AddQty" data-toggle="modal" data-target="#view-modal" data-id="'.md5($productrw['po_id']).'" class="btn btn-sm btn-success">Add</button>
	</td>
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
                    </div> <!-- end col -->

                    
                </div> <!-- End row -->


            </div> <!-- End row -->

            </div>
            <!-- Page Content Ends -->
            <!-- ================== -->

            <!-- Footer Start -->
            


<div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-full modal-dialog"> 
     <div class="modal-content">  
   
        <div class="modal-header"> 
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
           <h4 class="modal-title">purchaseorder</h4> 
        </div> 
            
        <div class="modal-body">                     
           <div id="modal-loader-b" style="display: none; text-align: center;">
           <!-- ajax loader -->
           <img width="100px" src="img/ajax-loader.gif">
           </div>
                            
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

    Aforty
</footer>
<!-- Footer Ends -->


</div></section>
        <!-- Main Content Ends -->
  


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
          data: 'costing_add='+uid,
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
          data: 'costing_view='+uid,
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
           </body>

</html>

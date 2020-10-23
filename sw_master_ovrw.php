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
                                <h3 class="panel-title">Master Updation/Deletion</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div style=" overflow:auto;
 position:relative;" class="row">
                                    
                                    
                                    <?php
									
									if(!isset($_GET['sw_code']) and !isset($_GET['sw_delete']) and !isset($_GET['sw_edit'])){
										?>
                                        <p>Only delete PurchaseOrders/Quotations and Delivery orders from this panel. In the case of Sales Invoices revise them and make them void.</p>
                                        <form class="form-inline" action="sw_master_ovrw.php" method="get">
                                        <h3><strong>Enter Reference Number:</strong></h3>
                                        <p style="color:red">Enter without Revision</p><br>

                                        
                                        <input required style="border:1px solid black" class="input-lg form-control" type="text" name="sw_code" />
                                        <input class="btn btn-lg btn-info " type="submit" />
                                        
                                        </form>
                                        <?php
									}
									?>
                                    
                                    <?php
									
									
									if(isset($_GET['sw_code'])){
										$_GET['sw_code'] = trim(strtoupper($_GET['sw_code']));
										?>
                                       <h3><strong>REF: <?php echo $_GET['sw_code'] ?></strong></h3><br>
										
                                        <?php
										$type = '';
										if(is_numeric(strpos($_GET['sw_code'],'SWI'))){
											$type = 'Sales Invoice';
											$c = getdatafromsql($conn, "select * from sw_salesinvoices where so_valid =1 and so_ref like '".$_GET['sw_code']."'");
										}else if(is_numeric(strpos($_GET['sw_code'],'SWQ'))){
											$c = getdatafromsql($conn, "select * from sw_quotes where qo_valid =1 and qo_ref like '".$_GET['sw_code']."'");
											$type = 'Quote';
										}else if(is_numeric(strpos($_GET['sw_code'],'SWPO'))){
											$c = getdatafromsql($conn, "select * from  	sw_purchaseorders where pco_valid =1 and pco_ref like '".$_GET['sw_code']."'");
											$type = 'Purchase Order';
										}else if(is_numeric(strpos($_GET['sw_code'],'SWPI'))){
											$c = getdatafromsql($conn, "select * from sw_proformas where po_valid =1 and po_ref like '".$_GET['sw_code']."'");
											$type = 'Proforma Invoice';
										}else if(is_numeric(strpos($_GET['sw_code'],'SWDO'))){
											$c = getdatafromsql($conn, "select * from sw_deliveryorders where do_valid =1 and do_ref like '".$_GET['sw_code']."'");
											$type = 'Delivery Order';
										}else{
											echo '-';
										}
										if(!is_array($c)){
											die("Invalid REF");
										}
									
					?> 
					<h3><strong>Action for <?php echo $type; ?></strong></h3><br>
                    	<div class="col-sm-6">
							<form action="sw_master_ovrw.php" method="get">

This <?php echo $type; ?> can only be deleted if there is no other document linked to it.<br>

<input type="hidden" name="sw_delete" value="<?php echo $_GET['sw_code'] ?>" />
<input type="submit" class="btn btn-danger btn-lg" value="Delete" />
</form>
                        </div>




					<?php	
									}
									?>
                                    
                                    <?php
									if(isset($_GET['sw_delete'])){
										
										if(is_numeric(strpos($_GET['sw_delete'],'SWI'))){
											$type = 'Sales Invoice';
											$t = 5;
											$c = getdatafromsql($conn, "select * from sw_salesinvoices where so_valid =1 and so_ref like '".$_GET['sw_delete']."'");
if(!is_array($c)){
die("Invalid REF");
}

											
												?>
                                                <form action="master_action.php"  method="post">
                                                	<input required type="hidden" name="del_single" value="<?php echo ($c['so_ref']) ?>"/>
                                                    <input type="submit" class="btn btn-lg btn-danger" value="Permanently Delete" />
                                                </form>
                                                <?php
											
											
											
										}else if(is_numeric(strpos($_GET['sw_delete'],'SWQ'))){
											$c = getdatafromsql($conn, "select * from sw_quotes where qo_valid =1 and qo_ref like '".$_GET['sw_delete']."'");
											$t = 1;
											$type = 'Quote';
if(!is_array($c)){
die("Invalid REF");
}

											$checkprof = getdatafromsql($conn, "select * from sw_proformas left join sw_quotes on po_rel_qo_id = qo_id where qo_valid =1
											and qo_revision_id = ".$c['qo_id']." and po_valid =1 order by po_revision asc limit 1");
											if(is_array($checkprof)){
																								?>
This Quote can't be deleted. Link with Proforma (<?php echo $checkprof['po_ref'] ?>) found.                                                
                                                <?php
											}else{
											
											
												?>
                                                <form action="master_action.php"  method="post">
                                                	<input type="hidden" name="del_single" value="<?php echo ($c['qo_ref']) ?>"/>
                                                    <input type="submit" class="btn btn-lg btn-danger" value="Permanently Delete" />
                                                </form>
                                                <?php
											
											}
											
										}else if(is_numeric(strpos($_GET['sw_delete'],'SWPO'))){
											$c = getdatafromsql($conn, "select * from  	sw_purchaseorders where pco_valid =1 and pco_ref like '".$_GET['sw_delete']."'");
											$t = 4;
											$type = 'Purchase Order';
if(!is_array($c)){
die("Invalid REF");
}


											
												?>
                                                <form action="master_action.php"  method="post">
                                                	<input type="hidden" name="del_single" value="<?php echo ($c['pco_ref']) ?>"/>
                                                    <input type="submit" class="btn btn-lg btn-danger" value="Permanently Delete" />
                                                </form>
                                                <?php


										}else if(is_numeric(strpos($_GET['sw_delete'],'SWPI'))){
											$c = getdatafromsql($conn, "select * from sw_proformas where po_valid =1 and po_ref like '".$_GET['sw_delete']."'");
											$t = 2;
											$type = 'Proforma Invoice';

echo 'Proformas can not be deleted at this stage';
									
									if(!is_array($c)){
											die("Invalid REF");
										}
										}else if(is_numeric(strpos($_GET['sw_delete'],'SWDO'))){
											$c = getdatafromsql($conn, "select * from sw_deliveryorders where do_valid =1 and do_ref like '".$_GET['sw_delete']."'");
											$t = 3;
											$type = 'Delivery Order';
if(!is_array($c)){
die("Invalid REF");
}


											
												?>
                                                <form action="master_action.php"  method="post">
                                                	<input type="hidden" name="del_single" value="<?php echo ($c['do_ref']) ?>"/>
                                                    <input type="submit" class="btn btn-lg btn-danger" value="Permanently Delete" />
                                                </form>
                                                <?php
												
												
												
												
												
										}else{
											die( '-');
										}
			
									}
									?>
                                    <?php
									if(isset($_GET['sw_edit'])){
										echo 'wants to edit';
									}
									?>
                                    
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
            
            
            <div class="row">
                    

                    <div class="col-lg-12	">

                        <div class="panel panel-default"><!-- /primary heading -->
                            <div class="portlet-heading">
      
                            <div class="panel-heading">
                                <h3 class="panel-title">Master Quotation Record Change</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div style=" overflow:auto;
 position:relative;" class="row">
                                    
                                    


                    	<div class="col-sm-12">
<div style=" overflow:auto;
 position:relative;" class="row">
                                    <table id="datatable1" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width:5%">#</th>
                                                    <th style="width:15%">Ref</th>
                                                    <th style="width:15%">Client Name</th>
                                                
                                                    <th style="width:5%">Date</th>                                                    
													<th style="width:5%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php

	$productsql = "SELECT * FROM `sw_quotes` q
left join sw_clients c on q.qo_rel_cli_id = c.cli_id
left join sw_currency y on q.qo_rel_cur_id = y.cur_id
WHERE q.qo_revision = 0 and q.qo_valid =1 and c.cli_valid =1
order by qo_ref desc

";

$productres = $conn->query($productsql);

if ($productres->num_rows > 0) {
	//'.md5(md5(sha1(md5($productrw['pr_id'])))).'_primga output data of each row
	$con = 1;
	while($productrw = $productres->fetch_assoc()) {
		unset($getallrevisions);
		unset($getrevision);
		unset($getrevisions);

	$getallrevisions = getdatafromsql($conn,"SELECT count(qo_id) as revs FROM `sw_quotes` WHERE qo_revision_id =".$productrw['qo_id']." and qo_revision > 0");

		echo '<tr>
	<td>'.$con.'</td>
	<td>'.$productrw['qo_ref'].'</td>
	<td>'.$productrw['cli_code'].'-'.$productrw['cli_name'].'</td>';
	
echo'
	<td>'.date('d-M-Y',$productrw['qo_dnt']).'</td>
	<td>
	<form action="master_action.php" method="post">
	<input type="hidden" name="edit_quote" value="'.$productrw['qo_revision_id'].'" />
		'; ?>
		    <select class="form-control" name="edit_quote_user" required>
    	<?php
		$sql = "SELECT * FROM sw_logins l left join sw_users u on l.lum_id = u.usr_rel_lum_id  where lum_valid=1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		if($row['lum_id'] == $productrw['qo_rel_lum_id']){
				echo '<option selected value="'.$row['lum_id'].'">'.$row['lum_email'].' - '.$row['usr_fname'].'</option>';
		}else{
		echo '<option value="'.$row['lum_id'].'">'.$row['lum_email'].' - '.$row['usr_fname'].'</option>';
		}
    }
} else {
}
		?>
    </select>
    <hr>
<input class="btn btn-sm btn-success" name="edit_quote_user_s" type="submit" value="Edit User">

	<?php echo '
	</form>

	</td>
	</tr>';

	$con++;
	}

} else {
	echo "0 results";
}?>
                        </tbody>
                                        </table>
                                        <!-- -->

                               
 
 
                                        
                                 
                                        <!-- -->
                                    </div>
                        </div>

                                        <!-- -->

                                  </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    
                </div> <!-- End row -->


            </div> <!-- End row -->

            </div>
            
            
            


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

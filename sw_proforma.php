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
                                <h3 class="panel-title">Proformas</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div style=" overflow:auto;
 position:relative;" class="row">
                                    <table id="datatable1" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width:5%">#</th>
                                                    <th style="width:10%">Ref</th>
                                                    <th style="width:10%">Quote Ref</th>
                                                    <th style="width:20%">Client Name</th>
                                                    <th style="width:10%">Total</th>
                                                    <th style="width:15%">Client Contact </th>
                                                    <th style="width:5%">Detailed View</th>
                                                    <th style="width:5%">Print View(No Cost)</th>                                                    
                                                    <th style="width:5%">Date</th>                                                    
													<th style="width:15%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
$productsql = "SELECT p.* , c.*, y.* FROM `sw_proformas` p
left join sw_clients c on p.po_rel_cli_id = c.cli_id
left join sw_currency y on p.po_rel_cur_id = y.cur_id
WHERE p.po_revision = 0 and p.po_valid =1 and c.cli_valid =1 
order by po_ref desc
";
$productres = $conn->query($productsql);

if ($productres->num_rows > 0) {
	//'.md5(md5(sha1(md5($productrw['pr_id'])))).'_primga output data of each row
	$con = 1;
	while($productrw = $productres->fetch_assoc()) {
		unset($getallrevisions);
		unset($getrevision);
		unset($getrevisions);
$discount = 0;
$vat = 0;
$extraprice = 0;

	$getallrevisions = getdatafromsql($conn,"SELECT count(po_id) as revs FROM `sw_proformas` WHERE po_revision_id =".$productrw['po_id']." and po_revision > 0");
	$getqref = getdatafromsql($conn,"SELECT * FROM `sw_quotes` WHERE qo_id=".$productrw['po_rel_qo_id']." and qo_valid > 0");
	
if(is_string($getqref)){
	$qref = "-";
}else{
	$qref = $getqref['qo_ref'];
}
$getmax = getdatafromsql($conn, "select * from sw_proformas_max where po_revision_id = ".$productrw['po_id']);

$checkinggen = getdatafromsql($conn,"select * from sw_proformas_gen where pog_rel_po_id = ".$getmax['po_revision_id']." and pog_valid =1 order by pog_id desc limit 1 ");				

$getpricetotal = getdatafromsql($conn,"select sum(pi_qty * pi_price) as ptotal from sw_proformas_items 
left join sw_products_list on pi_rel_pr_id = pr_id
left join sw_prod_types on pr_rel_prty_id = prty_id
where pi_rel_po_id = ".$getmax['po_id']." and pi_valid =1 and prty_pr_hidden = 0");
if(is_array($checkinggen)){
	$discount = $checkinggen['pog_discount'];
	$vat =  ($checkinggen['pog_vat']/100)* ($getpricetotal['ptotal']-$discount);
	$extraprice = $checkinggen['pog_extra_price'];
		 
	 }
	 

		echo '<tr>
	<td>'.$con.'</td>
	<td>'.$productrw['po_ref'].'</td>
	<td>'.$qref.'</td>
	<td>'.$productrw['cli_code'].'-'.$productrw['cli_name'].'</td>
	<td>'.number_format(($getpricetotal['ptotal'] - $discount + $vat + $extraprice),2).'</td>
	<td>'.$productrw['cli_contact_no'].'<br>'.$productrw['cli_email'].'</td>
	<td>';
	$getrevisions = "SELECT * FROM sw_proformas where po_revision_id = ".$productrw['po_id']." and po_valid =1";
$getrevisions = $conn->query($getrevisions);

if ($getrevisions->num_rows > 0) {
    // output data of each row
    while($getrevision = $getrevisions->fetch_assoc()) {

if($getrevision['po_revision'] == 0){	echo'
<button id="getDetailedView" data-toggle="modal" data-target="#view-modal" data-id="'.md5($getrevision['po_id']).'" class="btn btn-sm btn-info">Main</button>
';}else{
	echo'
<hr>
<button id="getDetailedView" data-toggle="modal" data-target="#view-modal" data-id="'.md5($getrevision['po_id']).'" class="btn btn-sm btn-info">R'.$getrevision['po_revision'].' </button>
';
}

    }
} else {
    echo "Error";
}

	echo '</td>
	<td>';
	$getrevisions = "SELECT * FROM sw_proformas where po_revision_id = ".$productrw['po_id']." and po_valid =1";
$getrevisions = $conn->query($getrevisions);

if ($getrevisions->num_rows > 0) {
    // output data of each row
    while($getrevision = $getrevisions->fetch_assoc()) {


if($getrevision['po_revision'] == 0){	echo'
<button id="getPrintView" data-toggle="modal" data-target="#view-modal" data-id="'.md5($getrevision['po_id']).'" class="btn btn-sm btn-danger">Get Print View</button>
';}


    }
} else {
    echo "Error";
}

	echo '</td>	
	<td>'.date('d-M-Y',$productrw['po_dnt']).'</td>
	<td>
<button id="getPoEdit" data-toggle="modal" data-target="#view-modal" data-id="'.md5($productrw['po_id']).'" class="btn btn-sm btn-warning">Revise</button>
<hr>
<button id="getPoEditSup" data-toggle="modal" data-target="#view-modal" data-id="'.md5($productrw['po_revision_id']).'" class="btn btn-sm btn-success">Revise Latest Proforma Supplier(s)</button>
	</td>
	</tr>';

	$con++;
	}

} else {
}?>
                        </tbody>
                                        </table>
                                        <!-- -->

                               
 
 
                                        
                                 
                                        <!-- -->
                                    </div>
                                    <hr>
<div class="row">
    <div class="col-xs-3">
        <div class="col-xs-12"><h3 >&nbsp; Generate Proforma Invoice</h3></div>
        <div class="col-xs-12">
            <h4 align="center">From Inventory</h4><h5 align="center" style="color:#B8B4B4">*From Scratch</h5>
            <div class="col-xs-12">
    <div align="center" class="col-xs-12"><button data-toggle="modal" data-target="#view-modal" id="getModalForWarehouse" class="btn btn-warning" data-id="getit">Generate</button></div>
            </div>
        </div>
        <div class="col-xs-12">
            <h4 align="center">From Quotation</h4>
            <div class="col-xs-12">
    <div align="center" class="col-xs-12"><button data-toggle="modal" data-target="#view-modal" id="getModalForQuoteProAdd" class="btn btn-warning" data-id="getit">Generate</button></div>
            </div>
        </div>
        <div class="col-xs-12">
            <h4 align="center">From Existing Proforma </h4>
            <div class="col-xs-12">
    <div align="center" class="col-xs-12"><input type="text" class="form-control" id="transferval" /><br><button data-toggle="modal" data-target="#view-modal" id="getModalForProPro" class="btn btn-warning" data-id="getit">Generate</button></div>
            </div>
        </div>
        
    </div>
    <div class="col-xs-9">
        <div class="row"><h3 >&nbsp; Add Product</h3></div>
        <div class="row">
            <div class="row">
<?php 
/*--*/
?>

<form action="master_action.php" method="post" enctype="multipart/form-data">
<div class="row">
        <div class="form-group">
            <label>Product: </label>
		<div class="row">
			<div class="col-xs-2"><input type="file" name="add_snippet_product_img" accept="image/*"/></div>
		</div><br>
<div class="col-xs-4">

<div class="form-group">
	<label>Product Name: </label>
	<input required  name="add_snippet_product_name" type="text" class="form-control" placeholder="Name"/>
</div>
</div>
<div class="col-xs-4">
<div class="form-group">
	<label>Code: </label>
	<input required  name="add_snippet_product_code" type="text" class="form-control" placeholder="Code"/>
</div>
</div>
<div class="col-xs-4">
<div class="form-group">
	<label>Product Type: </label><br>
    <select class="form-control mobsel" name="add_snippet_product_type" required>
    <option>Select Product Type</option>
    	<?php
		$sql = "SELECT * FROM sw_prod_types where prty_valid =1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		echo '<option value="'.md5(sha1(md5('iuergejgvjioe'.$row['prty_id']))).'">'.$row['prty_name'].'</option>';
    }
} else {
}
		?>
    </select>
</div>
</div>
<div class="col-xs-4">
    <div class="form-group">
        <label>Supplier: </label><br>
        <select class="form-control mobsel" name="add_snippet_product_supplier" required>
        <option>Select Supplier</option>
            <?php
            $sql = "SELECT * FROM sw_suppliers where sup_valid =1";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo '<option value="'.md5(sha1(md5('iuergeirjgvjioe'.$row['sup_id']))).'">'.$row['sup_code'].'-'.$row['sup_name'].'</option>';
        }
    } else {
    }
            ?>
        </select>
    </div>
</div>


    <div class="col-xs-4">
        <div class="form-group">
            <label>Invoice Ref: </label>
            <input required  name="add_snippet_product_ref_qty" type="text" class="form-control" placeholder="Qty"/>
        </div>
	</div>
    <div class="col-xs-4">
        <div class="form-group">
            <label>Quantity: </label>
            <input required  name="add_snippet_product_qty" type="text" class="form-control" placeholder="Qty"/>
        </div>
	</div>
    <div class="col-xs-4">
        <div class="form-group">
		<label>Cost: </label>
		<input required  name="add_snippet_product_cost" type="text" class="form-control" placeholder="No Unit"/>
        </div>
	</div>
    


<div class="col-xs-12">
    <div class="form-group">
        <label>Description: </label>
        <textarea name="add_snippet_product_desc" class="form-control" rows="9">-</textarea>
    </div>
</div>


            
            
            
            
            
            
            
            
        </div>
</div>
		<input required  name="add_snippet_href" type="hidden" value="<?php echo htmlentities(basename(($_SERVER['PHP_SELF']))); ?>"/>

<div class="row">
	<div class="col-xs-6">
		<input required  style="float:right" type="submit" class="btn btn-success" name="add_snippet_product" value="Add Product">
	</div>
</div>
	</form>
<script type="text/javascript" src="assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>

<?php 
/* --*/
?>
            </div>
        </div>
        
    </div>
</div>
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
           <h4 class="modal-title">Proforma</h4> 
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



        </section>
        <!-- Main Content Ends -->
  


      <?php  
	  get_end_script();
	  ?>   
<script src="assets/datatables/jquery.dataTables.min.js"></script>
<script src="assets/datatables/dataTables.bootstrap.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
		$('.mobileSelectSpecial').mobileSelect({
			onClose: function(){
				var txt = $(this).val();
				$.post("master_action.php", {prname: txt}, function(result){
					result = $.parseJSON( result );
					$("#chageqty").html(result.qty);
					$("#chageprname").html(result.prname);
				});
			}
		});
    } );
</script>
<script type="text/javascript">
    $(document).ready(function() {
		$('.mobileSelect').mobileSelect();
    } );
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable1').dataTable();
    } );
</script>
<script>
$(document).ready(function(){

$(document).on('click', '#getModalForWarehouse', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'add_proforma_warehouse='+uid,
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

$(document).on('click', '#getModalForQuoteProAdd', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'add_proforma_quotation='+uid,
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

$(document).on('click', '#getModalForProPro', function(e){  
     e.preventDefault();
  
     var uid = $('#transferval').val(); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'add_proforma_proforma='+uid,
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

$(document).on('click', '#getPoEditSup', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'edit_proforma_supplier='+uid,
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

$(document).on('click', '#getPoEdit', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'proforma_edit='+uid,
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

$(document).on('click', '#getPrintView', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'proformas_print_view='+uid,
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

$(document).on('click', '#getDetailedView', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'proforma_detailed_view='+uid,
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
$(document).ready(function(e) {
    $('.thistoh').addClass('hidden');
	var iddf =$('#select_can').val();
	var pela =document.getElementById(iddf);
	$(pela).removeClass('hidden');
});
$('#select_can').change(function(e) {

	$('.thistoh').addClass('hidden');
	var ider = $(this).val();
	var pel =document.getElementById(ider);
	$(pel).removeClass('hidden');

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
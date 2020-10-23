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
                                <h3 class="panel-title">Samples sent for Approval</h3>
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
                                                    <th>Image</th>
                                                    <th>Product(All Det)</th>
                                                    <th>Product Price</th>
                                                    <th>Sent From </th>
                                                    <th>Client Name</th>
                                                    <th>Cient Number </th>
                                                    <th>Billing Address </th>
                                                    <th>Given Qty <i class="ion-edit"></i></th>
                                                    <th>Returned <i class="ion-edit"></i></th>
                                                    <th>Remarks <i class="ion-edit"></i></th>
                                                    <th>Date Sent</th>
                                                    <th>Date Recieved</th>                                                    
													<th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
$productsql = "(select mock_id, p.pr_img_2 as pr_img,
concat(p.pr_code,' - ',p.pr_name,'<br>',p.pr_desc) as pr_details, p.pr_price, concat('<b>',s.msf_name,'</b>') as sent_from, 
concat(c.cli_code,'-',c.cli_name) as client_name, concat(c.cli_contact_no,'<br>',c.cli_email) as client_details, c.cli_bill_addr, m.mock_qty, m.mock_returned, m.mock_remarks, m.mock_added_dnt, m.mock_returned_dnt 
from sw_mockups m 
left join sw_products_list p on m.mock_rel_pr_id = p.pr_id
left join sw_clients c on m.mock_rel_cli_id = c.cli_id
left join sw_mocks_sent_from_types s on m.mock_rel_msf_id = s.msf_id
where m.mock_rel_msf_id=1 and m.mock_valid =1 and p.pr_valid =1 and c.cli_valid =1)

UNION

(select mock_id, p.pr_img_2 as pr_img,
concat(p.pr_code,' - ',p.pr_name,'<br>',p.pr_desc) as pr_details, p.pr_price, 
concat('<b>',s.msf_name,'</b><br>',shs.shw_name,'<br>',shs.shw_address) as sent_from, 
concat(c.cli_code,'-',c.cli_name) as client_name, concat(c.cli_contact_no,'<br>',c.cli_email) as client_details, c.cli_bill_addr, m.mock_qty, m.mock_returned, m.mock_remarks, m.mock_added_dnt, m.mock_returned_dnt 
from sw_mockups m 
left join sw_products_list p on m.mock_rel_pr_id = p.pr_id
left join sw_clients c on m.mock_rel_cli_id = c.cli_id
left join sw_mocks_sent_from_types s on m.mock_rel_msf_id = s.msf_id
left join sw_showrooms shs on m.mock_rel_shw_id = shs.shw_id
where m.mock_rel_msf_id=2 and m.mock_valid =1 and p.pr_valid =1 and c.cli_valid =1)

UNION

(select mock_id, p.pr_img_2 as pr_img,
concat(p.pr_code,' - ',p.pr_name,'<br>',p.pr_desc) as pr_details, p.pr_price, 
concat('<b>',s.msf_name,'</b><br>',sus.sup_code,'-',sus.sup_name,'<br>',sus.sup_bill_addr) as sent_from, 
concat(c.cli_code,'-',c.cli_name) as client_name, concat(c.cli_contact_no,'<br>',c.cli_email) as client_details, c.cli_bill_addr, m.mock_qty, m.mock_returned, m.mock_remarks, m.mock_added_dnt, m.mock_returned_dnt 
from sw_mockups m 
left join sw_products_list p on m.mock_rel_pr_id = p.pr_id
left join sw_clients c on m.mock_rel_cli_id = c.cli_id
left join sw_mocks_sent_from_types s on m.mock_rel_msf_id = s.msf_id
left join sw_suppliers sus on m.mock_rel_sup_id = sus.sup_id
where m.mock_rel_msf_id=3 and m.mock_valid =1 and p.pr_valid =1 and c.cli_valid =1 and sus.sup_valid=1)
";
$productres = $conn->query($productsql);

if ($productres->num_rows > 0) {
	//'.md5(md5(sha1(md5($productrw['pr_id'])))).'_primga output data of each row
	
	$con = 1;
	while($productrw = $productres->fetch_assoc()) {
		echo '<tr>
	<td>'.$con.'</td>
	<td><img class="img-responsive" width="200px" src="'.$productrw['pr_img'].'" /></td>
	<td>'.$productrw['pr_details'].'</td>
	<td>'.$productrw['pr_price'].'</td>
	<td>'.$productrw['sent_from'].'</td>
	<td>'.$productrw['client_name'].'</td>
	<td>'.$productrw['client_details'].'</td>
	<td>'.$productrw['cli_bill_addr'].'</td>
	<td>'.$productrw['mock_qty'].'</td>
	<td>'.($productrw['mock_returned'] == 1 ? 'Yes' : 'No').'</td>
	<td>'.$productrw['mock_remarks'].'</td>
	<td>'.date('d-M, Y',$productrw['mock_added_dnt']).'</td>
	<td>'.($productrw['mock_returned_dnt'] == 0 ? 'Not Returned': date('d-M, Y',$productrw['mock_returned_dnt'])).'</td>
	<td>
<div class="row">
<button id="getMock" data-toggle="modal" data-target="#view-modal" data-id="'.md5($productrw['mock_id']).'" class="btn btn-sm btn-warning">Edit</button>
</div>
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
                                    <hr>
<div class="row">
    <div class="row"><h3>&nbsp; Add Products Sent to Clients for Approval</h4></div>
    <div class="row">
        <h4>From Warehouse Inventory</h4><h5 style="color:#B8B4B4">*Existing Product</h5>
        <div class="row">
<div class="col-xs-6"><button data-toggle="modal" data-target="#view-modal" id="getModalForOldClient" class="btn btn-warning" data-id="getit">For Existing Cient</button></div>
<div class="col-xs-6"><button data-toggle="modal" data-target="#view-modal" id="getModalForNewClient" class="btn btn-warning" data-id="getit">For New Cient</button></div>
        </div>
    </div>
<hr>
    <div class="row">
        <h4>From Showroom Inventory</h4><h5 style="color:#B8B4B4">*Existing Showroom Product</h5>
        <div class="row">
<div class="col-xs-6"><button data-toggle="modal" data-target="#view-modal" id="getModalForOldClientShowroom" class="btn btn-warning" data-id="getit">For Existing Cient</button></div>
<div class="col-xs-6"><button data-toggle="modal" data-target="#view-modal" id="getModalForNewClientShowroom" class="btn btn-warning" data-id="getit">For New Cient</button></div>
        </div>
    </div>
<hr>
    <div class="row">
        <h4>From Supplier</h4><h5 style="color:#B8B4B4">*New Product</h5>
        <div class="row">
<div class="col-xs-6"><button data-toggle="modal" data-target="#view-modal" id="getModalForOldClientSupplier" class="btn btn-warning" data-id="getit">For Existing Cient</button></div>
<div class="col-xs-6"><button data-toggle="modal" data-target="#view-modal" id="getModalForNewClientSupplier" class="btn btn-warning" data-id="getit">For New Cient</button></div>
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
           <h4 class="modal-title">
           <i class="glyphicon glyphicon-user"></i>Mockup Products</h4> 
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
		$('#add_showroomproduct_old').click(function(e) {
			e.preventDefault();
				var prn = $("#add_showroomproduct_old_pr_hash").val();
				var supn = $("#add_showroomproduct_old_sh_hash").val();
				$.post("master_action.php", {pr_nm: prn, sup_nm:supn}, function(result){
					result = $.parseJSON( result );

					if(result.a.trim() == 'b'){
						$("#addoldprtoshw").submit();

					}else{
						$("#changeonerror").html('<em id="chageqty" style="color:red">' + result.a + '</em>');
					}
				});
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

$(document).on('click', '#getMock', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'get_mock_modal='+uid,
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

$(document).on('click', '#getModalForOldClient', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'mockup_warehouse_old='+uid,
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

$(document).on('click', '#getModalForNewClient', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'mockup_warehouse_new='+uid,
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

$(document).on('click', '#getModalForOldClientShowroom', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'mockup_showroom_old='+uid,
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

$(document).on('click', '#getModalForNewClientShowroom', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'mockup_showroom_new='+uid,
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

$(document).on('click', '#getModalForOldClientSupplier', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'mockup_supplier_old='+uid,
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

$(document).on('click', '#getModalForNewClientSupplier', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'mockup_supplier_new='+uid,
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

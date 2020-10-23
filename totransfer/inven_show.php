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
                                <h3 class="panel-title">Showroom Inventory</h3>
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
                                                    <th>Code</th>
                                                    <th>Product Name</th>
                                                    <th>Showroom</th>
                                                    <th>Address</th>
                                                    <th>Qty</th>
                                                    <th>Date Added</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
$productsql = "SELECT * FROM `sw_products_list_show` sh left join sw_products_list pl on sh.sh_rel_pr_id = pl.pr_id left join sw_showrooms sw on sh.sh_rel_shw_id = sw.shw_id WHERE pl.pr_valid = 1 and sh.sh_valid=1 
 order by sh.sh_dnt desc";
$productres = $conn->query($productsql);

if ($productres->num_rows > 0) {
	//'.md5(md5(sha1(md5($productrw['pr_id'])))).'_primga output data of each row
	
	$con = 1;
	while($productrw = $productres->fetch_assoc()) {
		echo '<tr>
	<td>'.$con.'</td>
	<td>'.$productrw['pr_code'].'</td>
	<td>'.$productrw['pr_name'].'</td>
	<td>'.$productrw['shw_name'].'</td>
	<td>'.$productrw['shw_address'].'</td>
	<td>'.$productrw['sh_qty'].'</td>
	<td>'.date('d-M, Y',$productrw['sh_dnt']).'</td>
	<td>
<div class="row">
<button id="getProd" data-toggle="modal" data-target="#view-modal" data-id="'.md5($productrw['sh_id']).'" class="btn btn-sm btn-warning">Edit Qty</button>
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
    <h4>&nbsp; Add Products to Showroom</h4>
    <div class="row">
    <div class="col-md-4">
        <div class="panel panel-color panel-inverse">
            <form id="addoldprtoshw" action="master_action.php" method="post">
            <div class="panel-heading"> 
            From Warehouse
            </div>
            <div class="panel-body"> 
                <p>Product:<br>
<select class="form-control mobileSelectSpecial" id="add_showroomproduct_old_pr_hash" name="add_showroomproduct_old_pr_hash" >
                <?php 
$sql = "SELECT * FROM sw_products_list where pr_visible =1 and pr_valid =1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	echo '                <option>Select Product</option>
';
    while($row = $result->fetch_assoc()) {
        echo '<option value="'.md5(sha1(md5(sha1('0u9i4nuvt5859e-g'.$row['pr_id'])))).'">'.$row['pr_code'].'-'.$row['pr_name'].'</option>';
    }
} else {
	echo '                <option>No Products Found</option>
';
	
}
				?>
                </select></p>
<br>
                <p>Showroom:<br>
<select class="form-control mobileSelect" id="add_showroomproduct_old_sh_hash" name="add_showroomproduct_old_sh_hash" >
                <?php 
$sql = "SELECT * FROM sw_showrooms where shw_valid =1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	echo '                <option>Select Showroom</option>
';
    while($row = $result->fetch_assoc()) {
        echo '<option value="'.md5(sha1(md5(sha1('0u9i4nuvt5859f-g'.$row['shw_id'])))).'">'.$row['shw_name'].'|'.$row['shw_address'].'</option>';
    }
} else {
	echo '                <option>No Showrooms Found</option>
';
	
}
				?>
                </select></p>
<br>
                <p>Qty: <input required  class="form-control" name="add_showroomproduct_old_qty" type="number"  /></p> 
                <p><em id="chageqty" style="color:red">0</em> unit(s) of <em id="chageprname" style="color:red">Product</em> in warehouse</p> 
                <p id="changeonerror">Check Validity of Product by Submitting</p> 
                <p><input  name="add_showroomproduct_old" type="hidden" value="Add Product to Showroom"/></p> 
                <p><input class="btn btn-success" id="add_showroomproduct_old"  type="submit" value="Add Product to Showroom"/></p> 
            </div> 
            </form>
        </div>
    </div>
    <div class="col-md-8">
    <form action="master_action.php" method="post" enctype="multipart/form-data">
        <div class="panel panel-color panel-inverse">
            <div class="panel-heading"> 
            New Product </div>
            <div class="panel-body"> 
<div class="row">
    <div class="col-md-7">
        <div class="form-group">
            <label>Product Name: </label>
            <input required  name="add_showroomproduct_pr_name" type="text" class="form-control" placeholder="Name"/>
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label>Product Image: </label>
            <input name="add_showroomproduct_pr_img" type="file" accept="image/*"/>
        </div>
    </div>
</div>


<div class="form-group">
	<label>Product Type: </label><br>

    <select class="form-control mobileSelect" name="add_showroomproduct_pr_type" required>
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
    </select></div>

<div class="form-group">
	<label>Supplier: </label><br>

    <select class="form-control mobileSelect" name="add_showroomproduct_pr_supplier" required>
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

<div class="form-group">
	<label>Showroom: </label><br>

    <select class="form-control mobileSelect" name="add_showroomproduct_pr_showroom" required>
    <option>Select Showroom</option>
    	<?php
		$sql = "SELECT * FROM sw_showrooms where shw_valid =1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		echo '<option value="'.md5(sha1(md5('iuergyugeirjgvjioe'.$row['shw_id']))).'">'.$row['shw_name'].'|'.$row['shw_address'].'</option>';
    }
} else {
}
		?>
    </select>
</div>

<div class="form-group">
	<label>Product Code: </label>
	<input required  name="add_showroomproduct_pr_code" type="text" class="form-control" placeholder="Code"/>
</div>

<div class="form-group">
	<label>Product Description: </label>
	<textarea name="add_showroomproduct_pr_desc" class="wysihtml5 form-control" rows="9"></textarea>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Product Cost: </label>
            <input required  name="add_showroomproduct_pr_cost" type="number" class="form-control" placeholder="No Unit"/>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Showroom Quantity: </label>
            <input required  name="add_showroomproduct_pr_qty" type="number" class="form-control" placeholder="Added to Showroom"/>
        </div>
    </div>
</div>
                <p><input class="btn btn-success " name="add_showroomproduct_new" type="submit" value="Add New Product To Showroom"/></p> 
            </div> 
        </div>
    </form>
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
           <i class="glyphicon glyphicon-user"></i>Edit Product Quantity</h4> 
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

$(document).on('click', '#getProd', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'get_inv_show='+uid,
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

<?php 
include('db_auth.php');
?>
<!DOCTYPE html>
<html lang="en">
    
<head>
       <?php 
	   get_head();
	   ?>
                <link rel="stylesheet" type="text/css" href="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />

    </head>


    <body>

        <!-- Aside Start-->
        <aside class="left-panel">

           <?php 
		   give_brand();
		   ?> 
        
            <?php 
			get_modules($conn);
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
                    <ul class="nav navbar-nav navbar-right top-menu top-right-menu">  
                       
                        
                        <!-- user login dropdown start-->
                        <li class="dropdown text-center">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <img alt=""  class="img-circle profile-img thumb-sm">
                                <span class="username"><?php echo ucwords($_SESSION['SW_PREFIX_NAME']).'. '.ucwords($_SESSION['SW_U_F_NAME']) ?> </span> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu pro-menu fadeInUp animated" tabindex="5003" style="overflow: hidden; outline: none;">
                               
                                <li><a href="logout.php"><i class="fa fa-sign-out"></i> Log Out</a></li>
                            </ul>
                        </li>
                        <!-- user login dropdown end -->       
                    </ul>
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
                        <div class="row">

</div>
      
                            <div class="panel-heading">
                                <h3 class="panel-title">Orders</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <table id="datatable" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Order Ref Name</th>
                                                    <th>Order Placed Date</th>
                                                    <th>Buyer Name</th>
                                                    <th>Invoice</th>
                                                    <th>Order Details </th>
													<?php 
                                                    if($_SESSION['SW_U_ACCESS'] >= 3){
                                                    echo '<th>Action</th>';
                                                    }?> 
													<?php 
                                                    if($_SESSION['SW_U_ACCESS'] >= 4){
                                                    echo '<th>Delete</th>';
                                                    }?> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
$orderssql = "SELECT * FROM sw_orders where or_valid= 1 ";
$ordersres = $conn->query($orderssql);

if ($ordersres->num_rows > 0) {
	// output data of each row
	
	$con = 1;
	while($ordersrw = $ordersres->fetch_assoc()) {
		echo '<tr>';
		  echo '
<td>'.$con.'</td>
<td>'.$ordersrw['or_ref_name'].'</td>
<td>'.date('d M Y @ H:i:s',$ordersrw['or_datentime']).'</td>
<td class="orderedit" id="'.md5(md5(sha1(md5($ordersrw['or_id'])))).'_buynamea">'.$ordersrw['or_buy_name'].'</td>
<td><button type="button" class="btn btn-info" data-toggle="modal" data-target="#inv'.md5($ordersrw['or_id'].$ordersrw['or_ref_name']).'">Invoice</button></td>
<td><button type="button" class="btn btn-info" data-toggle="modal" data-target="#'.md5($ordersrw['or_id'].$ordersrw['or_ref_name']).'">#'.$con.' Details</button></td>
';                              

if($_SESSION['SW_U_ACCESS'] >= 3){
echo'	
<td>
<form action="edit_order.php" method="get" style="display:inline;">
						<input type="hidden" value="'.md5(md5(sha1(md5($ordersrw['or_id'])))).'" name="edihchk" />
						<input type="submit" class="btn btn-warning"  name="or_edit" value="Edit"/>
					</form>		
</td>					';
					
					}
if($_SESSION['SW_U_ACCESS'] >= 4){
echo '
<td>
<form action="master_action.php" method="post" style="display:inline;">
						<input type="hidden" value="'.md5(md5(sha1(md5($ordersrw['or_id'])))).'" name="hchk" />
						<input type="submit" class="btn btn-danger"  name="or_delete" value="Delete"/>
					</form> </td>';
}
					
		echo '</tr>';
	$con++;
	}

} else {
	echo "No orders";
}?>
                        </tbody>
                        </table>
                                             
                                                
                                          <?php  if($_SESSION['SW_U_ACCESS'] >= 2){ ?>
                                    <hr style="border-bottom:groove black solid" />
                                    <div class="row">
                                   
<div class="row ">
<br>
<br>
    <div align="center" >
      <a href="add_order.php"><button style="font-size:16px" class="btn btn-primary col-sm-6 col-sm-offset-3" >Add Order</button></a>
    </div>
</div>
</div>
<?php
									}


?>  
                                    </div>
                                                                 
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    
                </div> <!-- End row -->


            </div>
            <!-- Page Content Ends -->
            <!-- ================== -->

           <?php

#$sql = "SELECT distinct(oi_rel_or_id)as oid from sw_order_items where oi_rel_pr_id = 3 and oi_valid= 1 ";
$modalsql = "SELECT * FROM `sw_orders` where or_valid = 1";
$modalres = $conn->query($modalsql);

if ($modalres->num_rows > 0) {
    // output data of each row
    while($modalrw = $modalres->fetch_assoc()) {
		#firts loop begins
		echo '
<div id="'.md5($modalrw['or_id'].$modalrw['or_ref_name']).'" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">'.$modalrw['or_ref_name'].'</h4>
      </div>
      <div class="modal-body">
      <table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Product name</th>
				<th>Qty bought</th>
				<th>Cost price</th>
				<th>Selling Price</th>
				<th>Special</th>
				';
				if($_SESSION['SW_U_ACCESS'] >=3){echo'<th>Margin</th>';}
			echo '
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
		
		
		';
		
			$innersql = "SELECT * from sw_order_items where oi_rel_or_id = ".$modalrw['or_id']." and oi_valid =1";
			$inneres = $conn->query($innersql);
		
			if ($inneres->num_rows > 0) {
			// output data of each row
			$placce = 1;
			while($innerw = $inneres->fetch_assoc()) {
			#2nd loop start
			
								/*second option= 
								SELECT * from sw_order_items left join pr_list_final on
oi_rel_pr_id = pr_id
where oi_rel_or_id = 1 and oi_valid =1 and pr_valid=1 and sh_valid =1
								
								
								*/
							$getorderdet = "SELECT * from sw_products_list where pr_id = ".$innerw['oi_rel_pr_id']." ";
							$getorderdetres = $conn->query($getorderdet);
							if ($getorderdetres->num_rows > 0) {
								
							// output data of each row
							while($getorderdetrw = $getorderdetres->fetch_assoc()) {
							#3rd loop begins	
							
								echo '<tr>
								<td>'.$placce.'</td>
								<td>'.$getorderdetrw['pr_name'].'</td>
								<td>'.$innerw['oi_qty'].'</td>
								<td>'.$getorderdetrw['pr_price'].'</td>
								<td>'.$innerw['oi_price_for_one'].'</td>
								<td>'.$innerw['oi_pr_special'].'</td>
								';
								
								if($_SESSION['SW_U_ACCESS'] >=3){
									if($innerw['oi_price_for_one'] > $getorderdetrw['pr_price']){
										echo '<td><i style="color:green">'.($innerw['oi_price_for_one'] - $getorderdetrw['pr_price']).'</i></td>';
									}else{
										echo '<td><i style="color:red">'.($getorderdetrw['pr_price'] - $innerw['oi_price_for_one']).'</i></td>';
									}
								}
								echo'
								';
								if($getorderdetrw['pr_valid'] == 1){
									echo '<td><i class="ion-ionic" style="color:green"></i></td>';
								}else{
									echo '<td><i class="ion-ionic" style="color:red"></i></td>';
								}
								echo'
									</tr>';

						$placce++;
							#3rd loop ends
							}
						} else {
echo '<tr>
<td>'.$placce.'</td>
<td colspan="6"><i>----Deleted Product---- </i></td>
</tr>';
						}
		
			
			
		#2nd loop end	
			}
		} else {
			echo '<i style="color:red">No Products</i>';
		}
		
	
	echo '
	</tbody>
	</table>
<hr>	
	      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

#$sql = "SELECT distinct(oi_rel_or_id)as oid from sw_order_items where oi_rel_pr_id = 3 and oi_valid= 1 ";
$modalsql = "SELECT * FROM `sw_orders` where or_valid = 1";
$modalres = $conn->query($modalsql);

if ($modalres->num_rows > 0) {
    // output data of each row
    while($modalrw = $modalres->fetch_assoc()) {
		#firts loop begins
		echo '
<div id="inv'.md5($modalrw['or_id'].$modalrw['or_ref_name']).'" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:90%">

    <!-- Modal content-->
   <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Invoice of '.$modalrw['or_ref_name'].'</h4>
      </div>
      <div class="modal-body">
	 <table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Invoice Number</th>
				<th>Client Address</th>
				<th>LPO</th>
				<th>Date Generated</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		
		
		';
		
		
								/*second option= 
								SELECT * from sw_order_items left join pr_list_final on
oi_rel_pr_id = pr_id
where oi_rel_or_id = 1 and oi_valid =1 and pr_valid=1 and sh_valid =1
								
								
								*/
							$getorderdet = "SELECT * from invoices_gen where inov_or_id = ".$modalrw['or_id']."  and inov_valid=1";
							$getorderdetres = $conn->query($getorderdet);
							$plae = 1;
							if ($getorderdetres->num_rows > 0) {
								
							// output data of each row
							while($getorderdetrw = $getorderdetres->fetch_assoc()) {
							#3rd loop begins	
							
								echo '<tr>
								<td>'.$plae.'</td>
								<td>'.$getorderdetrw['inov_no_name'].'</td>
								<td>'.$getorderdetrw['inov_cl_addr'].'</td>
								<td>'.$getorderdetrw['inov_lpo'].'</td>
								<td>'.date('d D M, Y @ H:i:s',$getorderdetrw['inov_gn_dnt']).'</td>
								<td><form action="invoice_gen.php" method="post">
								<input type="hidden" value="'.md5(md5(sha1(sha1(md5(sha1($getorderdetrw['inov_id'])))))).'" name="hash_viewer" />
								<input type="submit" name="_view_ino" value="View" class="btn btn-success" />
								</form></td>
								';
								
								

						$plae++;
							#3rd loop ends
							}
						} else {
echo '<tr>
<td>'.$plae.'</td>
<td colspan="6"><i>----No Invoice Generated---- </i></td>
</tr>';
						}
		
			
			
	
	
	echo '
	</tbody>
	</table>
	<hr>
	<h6>Generate Invoice</h6>
	
        <form action="invoice_gen.php" method="post">

<div class="form-group">
	<label>Bottom Invoice Instructions: </label>
	<input required type="text" name="invo_ins" class="form-control" value="All cheques to be in favour of Stile Well General Trading LLC">
</div> 

<div class="form-group">
	<label>Invoice Number: </label>
	<input required type="text" name="invo_num" class="form-control" value="SWI00'.$modalrw['or_id'].'">
</div> 
 
<div class="form-group">
	<label>Discount %</label>
	<input required type="text" name="invo_disc" class="form-control" value="0">
</div> 

<div class="form-group">
	<label>Vat %</label>
	<input required type="text" name="invo_vat" class="form-control" value="0">
</div> 

<div class="form-group">
	<label>Client Address:</label>
	 <textarea class="form-control wysihtml5 "  name="invo_cl_addr"></textarea>    
</div>
 
  
<div class="form-group">
	<label>LPO No.</label>
	<input required type="text" name="invo_lpo" class="form-control" >
</div> 


		
<div class="form-group">
	<label>Complete or Pending: (1=complete 2=pending 0=canceled)</label>
	<input required type="number" name="invo_comp_p" class="form-control" min="0" max="2" value="1">
</div>


 



<input required type="hidden" name="ha_g" value="'.md5(md5(sha1(sha1(md5(sha1($modalrw['or_id'])))))).'" />


<div class="row">
	<div class="col-xs-6">
		<input name="gen_inv" style="float:right" type="submit" class="btn btn-success"  value="Generate Invoice"  />
	</div>
	<div class="col-xs-6">
		<button type="reset" class="btn btn-danger">Reset</button>
	</div>
</div>
	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
       
       
       
            <footer class="footer">
                Admin StileWell
            </footer>
            <!-- Footer Ends -->



        </section>
        <!-- Main Content Ends -->
      

<?php 
get_end_script();
?>
<?php 
 if($_SESSION['SW_U_ACCESS'] >= 3){
?>
<script>
$(document).ready(function() {
	$(".orderedit").editable("master_action.php", { 
			id: 'edit_thing_order',
			name : 'value_edited_order',
			
		  tooltip   : "Doubleclick to edit...",
		  event     : "dblclick",
		  style  : "inherit"
	});
});
 

</script>       
<?php 
	}	
?>
<?php 
if(isset($_GET['hpmo']) and ctype_alnum($_GET['hpmo'])){
	
    echo '<script type="text/javascript"> $(\'#'.$_GET['hpmo'].'\').modal(\'show\'); </script>';
    
}
?>

        <script type="text/javascript" src="assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
        <script type="text/javascript" src="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#datatable').dataTable();
            } );
        </script>
        <script type="text/javascript">
		 // Select2
            jQuery(document).ready(function(){
                $('.wysihtml5').wysihtml5();

               

            });
        </script>


    </body>

</html>

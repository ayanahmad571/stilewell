<?php 
include('db_auth.php');
?><!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from coderthemes.com/velonic_2.2/admin_3/invoice.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 10 May 2016 07:31:27 GMT -->
<head>
           <?php 
	   get_head();
	   ?>
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
                <?php 
				$prsql = "
SELECT pr_name,pr_code,pr_id FROM `sw_products_list` where pr_valid =1  ";
			
			
				$prsres = $conn->query($prsql);
				if($prsres->num_rows >0){
					$productsinin = array();
					while($prr = $prsres->fetch_assoc()){
						$productsinin[] = $prr;
					}

				}else{
					 $productsinin[] = array('pr_id'=> 00,'pr_name'=>'Add Products to Inventory');

				}
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
                
                
            </header>
            <!-- Header Ends -->
            

<div class="wraper container-fluid">
                <div class="row">
                    <div class="col-lg-12	">
                        <div class="panel panel-default"><!-- /primary heading -->
                            <div class="panel-heading">
                                <h3 class="panel-title">Generate Invoice</h3>
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
                                                    <th>Order Details </th>
													
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
<td>'.$ordersrw['or_buy_name'].'</td>
<td>
<form action="invoice_gen.php" method="post">
<input type="hidden" name="ha_g" value="'.md5(md5(sha1(sha1(md5(sha1($ordersrw['or_id'])))))).'" />
<input name="gen_inv" class="btn btn-info" type="submit" value="Generate Invoice" /></form></td>
';                              


					
		echo '</tr>';
	$con++;
	}

} else {
	echo "No orders";
}
?>     
                                 </tbody>
                        </table>
                                                 
                                    </div>
                                   
                                    
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    
                </div> <!-- End row -->


            </div>
            <!-- Page Content Start -->
            <!-- ================== -->

            <!-- Footer Start -->
            <footer class="footer">
                2015 © Velonic.
            </footer>
            <!-- Footer Ends -->


        </section>
        <!-- Main Content Ends -->


        <!-- js placed at the end of the document so the pages load faster -->
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/pace.min.js"></script>
        <script src="js/wow.min.js"></script>
        <script src="js/jquery.nicescroll.js" type="text/javascript"></script>


        <script src="js/jquery.app.js"></script>


    </body>

<!-- Mirrored from coderthemes.com/velonic_2.2/admin_3/invoice.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 10 May 2016 07:31:28 GMT -->
</html>

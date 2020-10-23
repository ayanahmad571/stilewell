<?php 
include('db_auth.php');
?>
<!DOCTYPE html>
<html lang="en">
    
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
                <div class="page-title"> 
                    <h3 class="title">Welcome <?php echo ucwords($_SESSION['SW_PREFIX_NAME']).'. '.ucwords($_SESSION['SW_U_F_NAME']).' '.ucwords($_SESSION['SW_U_L_NAME']) ?> !</h3> 
                </div>



                 <!-- end row -->



                <div class="row">
                    

                     <?php /*
<div class="col-lg-6">
                        <div class="portlet"><!-- /primary heading -->
                            <div class="portlet-heading">
                                <h3 class="portlet-title text-dark text-uppercase">
                                    Yearly Sales Report
                                </h3>
                                <div class="portlet-widgets">
                                    <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                                    <span class="divider"></span>
                                    <a data-toggle="collapse" data-parent="#accordion1" href="#portlet2"><i class="ion-minus-round"></i></a>
                                    <span class="divider"></span>
                                    <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div id="portlet2" class="panel-collapse collapse in">
                                <div class="portlet-body">
                                    <div id="morris-area-example" style="height: 320px;"></div>
                                    <div class="row text-center m-t-30 m-b-30">
                                        <div class="col-sm-3 col-xs-6">
                                            <h4>$ 126</h4>
                                            <small class="text-muted"> Today's Sales</small>
                                        </div>
                                        <div class="col-sm-3 col-xs-6">
                                            <h4>$ 967</h4>
                                            <small class="text-muted">This Week's Sales</small>
                                        </div>
                                        <div class="col-sm-3 col-xs-6">
                                            <h4>$ 4500</h4>
                                            <small class="text-muted">This Month's Sales</small>
                                        </div>
                                        <div class="col-sm-3 col-xs-6">
                                            <h4>$ 87,000</h4>
                                            <small class="text-muted">This Year's Sales</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- /Portlet -->
                        
                    </div>
					
					
					 <div class="col-lg-6">
                        <div class="portlet"><!-- /primary heading -->
                            <div class="portlet-heading">
                                <h3 class="portlet-title text-dark text-uppercase">
                                    Weekly Sales Report
                                </h3>
                                <div class="portlet-widgets">
                                    <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                                    <span class="divider"></span>
                                    <a data-toggle="collapse" data-parent="#accordion1" href="#portlet1"><i class="ion-minus-round"></i></a>
                                    <span class="divider"></span>
                                    <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div id="portlet1" class="panel-collapse collapse in">
                                <div class="portlet-body">
                                    <div id="morris-bar-example" style="height: 320px;"></div>

                                    <div class="row text-center m-t-30 m-b-30">
                                        <div class="col-sm-3 col-xs-6">
                                            <h4>$ 126</h4>
                                            <small class="text-muted"> Today's Sales</small>
                                        </div>
                                        <div class="col-sm-3 col-xs-6">
                                            <h4>$ 967</h4>
                                            <small class="text-muted">This Week's Sales</small>
                                        </div>
                                        <div class="col-sm-3 col-xs-6">
                                            <h4>$ 4500</h4>
                                            <small class="text-muted">This Month's Sales</small>
                                        </div>
                                        <div class="col-sm-3 col-xs-6">
                                            <h4>$ 87,000</h4>
                                            <small class="text-muted">This Year's Sales</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- /Portlet -->

                    </div> <!-- end col -->
 */ ?>
                   
                </div> <!-- End row -->



                <div class="row">
                    

                    <div class="col-lg-12	">

                        <div class="panel panel-default"><!-- /primary heading -->
                            <div class="portlet-heading">
      
                            <div class="panel-heading">
                                <h3 class="panel-title">Things at a Glance</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <table id="datatable" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Img </th>
                                                    <th>Product Name</th>
                                                    <th>Stored Qty</th>
                                                    <th>Sold Qty</th>
                                                    <th>Remaining Qty</th>
                                                    <th>Cost Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
$getmain = "SELECT *,ifnull(oi_valid,1) as oi_valid_no,ifnull(sumqtyorder,0) as sqoa ,(ifnull(pr_qty, 0)  +ifnull(sh_qty, 0) ) as 'total_sum' FROM pr_list_final pl left join order_sum_qty osq on pl.pr_id = osq.oi_rel_pr_id where pl.pr_valid =1 and ifnull(osq.oi_valid,1) = 1 
 ";
$getmainres = $conn->query($getmain);

if ($getmainres->num_rows > 0) {
	// output data of each row
	
	$con = 1;
	while($getmainrw = $getmainres->fetch_assoc()) {
		echo '<tr>';
		  echo '<td>'.$con.'</td>
				<td><img src="'.$getmainrw['pr_img_2'].'" class="img-responsive" /></td>
				<td>'.$getmainrw['pr_name'].'</td>
				<td>
				<button type="button" style="background-color:none;border:none;" data-toggle="modal" data-target="#'.md5(sha1(sha1($getmainrw['pr_id']))).'"><span class="label label-info">'.$getmainrw['total_sum'].'</span>
				</button>
				</td>
				
				<td><button type="button" style="background-color:none;border:none;" data-toggle="modal" data-target="#'.md5($getmainrw['pr_id'].$getmainrw['pr_name']).'"><span class="label label-info">'.$getmainrw['sqoa'].'</span>
				</button></td>
				<td>'.($getmainrw['total_sum']-$getmainrw['sumqtyorder']).'</td>
				<td>'.$getmainrw['pr_price'].'</td>';
		echo '</tr>';
	$con++;
	}

} else {
	echo "0 results";
}?>
                                             
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    
                </div> <!-- End row -->


            </div>
            </div>
            
            <!-- Page Content Ends -->
            <!-- ================== -->

            <!-- Footer Start -->
            
            <?php

#$sql = "SELECT distinct(oi_rel_or_id)as oid from sw_order_items where oi_rel_pr_id = 3 and oi_valid= 1 ";
$modalsql = "SELECT * FROM `sw_products_list` ";
$modalres = $conn->query($modalsql);

if ($modalres->num_rows > 0) {
    // output data of each row
    while($modalrw = $modalres->fetch_assoc()) {
		#firts loop begins
		echo '
<div id="'.md5($modalrw['pr_id'].$modalrw['pr_name']).'" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">'.$modalrw['pr_name'].' (in orders)</h4>
      </div>
      <div class="modal-body">
      <table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Order Ref Name</th>
				<th>Order Buyer\'s Name</th>
				<th>Order Date and Time</th>
				<th>Qty</th>
			</tr>
		</thead>
		<tbody>
		
		
		';
		
			$innersql = "SELECT distinct(oi_rel_or_id)as oid,oi_qty from sw_order_items where oi_rel_pr_id = ".$modalrw['pr_id']." and oi_valid= 1 ";
			$inneres = $conn->query($innersql);
		
			if ($inneres->num_rows > 0) {
			// output data of each row
			$placce = 1;
			while($innerw = $inneres->fetch_assoc()) {
			#2nd loop start
			
			
								
							$getorderdet = "SELECT * from sw_orders where or_id = ".$innerw['oid']." and or_valid= 1 ";
							$getorderdetres = $conn->query($getorderdet);
							if ($getorderdetres->num_rows > 0) {
								
							// output data of each row
							while($getorderdetrw = $getorderdetres->fetch_assoc()) {
							#3rd loop begins	
							
								echo '<tr>';
								echo '
								<td>'.$placce.'</td>
								<td>'.$getorderdetrw['or_ref_name'].'</td>
								<td>'.$getorderdetrw['or_buy_name'].'</td>
								<td>'.date('d M Y ',$getorderdetrw['or_datentime']).'</td>
								<td>'.$innerw['oi_qty'].'</td>
									';
								echo '</tr>';

						$placce++;
							#3rd loop ends
							}
						} else {
							echo "0 Res";
						}
		
			
			
		#2nd loop end	
			}
		} else {
			echo "No Orders";
		}
		
	
	echo '
	</tbody>
	</table>
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
    echo "0 results";
}
 ?> 
 
 
 <?php

#$sql = "SELECT distinct(oi_rel_or_id)as oid from sw_order_items where oi_rel_pr_id = 3 and oi_valid= 1 ";
$msql = "SELECT * FROM `pr_list_final`";
$mres = $conn->query($msql );

if ($mres->num_rows > 0) {
    // output data of each row
    while($mrw = $mres->fetch_assoc()) {
		#firts loop begins
		echo '
<div id="'.md5(sha1(sha1($mrw['pr_id']))).'" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">'.$mrw['pr_code'].' '.$mrw['pr_name'].'</h4>
      </div>
      <div class="modal-body">
      <table class="table">
		<thead>
			<tr>
				<th>Warehouse</th>
				<th>Showroom</th>
			</tr>
		</thead>
		<tbody>
		
		
		';
		
							
								echo '<tr>';
								echo '
								<td>'.$mrw['pr_qty'].'</td>
								<td>'; 
								if(is_null($mrw['sh_qty'])){
									echo '0';
								}else{
									echo $mrw['sh_qty'];
								}
								echo ' </td>';
								echo '</tr>';

	echo '
	</tbody>
	</table>
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
    echo "0 results";
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
       
        <script type="text/javascript">
            $(document).ready(function() {
                $('#datatable').dataTable();
            } );
        </script>

    </body>

</html>

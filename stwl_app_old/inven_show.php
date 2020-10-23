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
            <?php 
								$nopr = array();

			$notsql = "
SELECT sh_pr_id_rel_pr_id FROM `sw_products_list_show` where sh_valid =1 ";
				$notres = $conn->query($notsql);
				if($notres->num_rows >0){
					$nopr = array();
					while($nn = $notres->fetch_assoc()){
						$nopr[] = $nn['sh_pr_id_rel_pr_id'];
					}

				}else{
					 

				}
 
 
 			if(count($nopr) >1){
				$prsql = "
SELECT pr_name,pr_id,pr_code,pr_qty FROM `sw_products_list` where pr_valid =1 and not(pr_id = ".implode(' or pr_id =',$nopr).") ";
			}else if(count($nopr) == 1){
				$prsql = "
SELECT pr_name,pr_id,pr_code,pr_qty FROM `sw_products_list` where pr_valid =1 and not(pr_id = ".$nopr[0].")  ";
			}else{
				$prsql = "
SELECT pr_name,pr_id,pr_code,pr_qty FROM `sw_products_list` where pr_valid =1  ";
			}
			
			
				$prsres = $conn->query($prsql);
				if($prsres->num_rows >0){
					$productsinin = array();
					while($prr = $prsres->fetch_assoc()){
						$productsinin[] = $prr;
					}

				}else{
					 $productsinin[] = array('pr_id'=> '','pr_code'=> 00,'pr_qty'=> 00,'pr_name'=>'Add More Products to Inventory');

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
                            <div class="portlet-heading">
      
                            <div class="panel-heading">
                                <h3 class="panel-title">Showroom Inventory</h3><br>

                            <p style="font-size:10px">You can add an item in showroom only if it is in the warehouse. </p>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <table id="datatable" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Code</th>
                                                    <th>Product Name</th>
                                                    <th>Product Type</th>
                                                    <th>Desc</th>
                                                    <th>Located <i class="ion-edit"></i></th>
                                                    <th>Cost AED</th>
                                                    <th>Per</th>
                                                    <th> Qty <i class="ion-edit"></i> </th>
                                                    <th>Date</th>
													<?php 
                                                    if($_SESSION['SW_U_ACCESS'] >= 4){
                                                    /*
 echo '<th>Action</th>';
 */ 
                                                    }?> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
$productsql = "SELECT * FROM sw_products_list_show sh 
left join sw_products_list pl on 
pl.pr_id = sh.sh_pr_id_rel_pr_id 
where sh_valid= 1 and pr_valid=1";
$productres = $conn->query($productsql);

if ($productres->num_rows > 0) {
	// output data of each row
	
	$con = 1;
	while($productrw = $productres->fetch_assoc()) {
		echo '<tr>';
		  echo '<td>'.$con.'</td>
	<td>'.$productrw['pr_code'].'</td>
	<td>'.$productrw['pr_name'].'</td>
	<td>'.$productrw['pr_type'].'</td>
	<td>'.$productrw['pr_desc'].'</td>
	<td class="editable" id="'.md5(md5(sha1(md5($productrw['sh_pr_id'])))).'_shlocateda">'.$productrw['sh_located'].'</td>
	<td >'.$productrw['pr_price'].'</td>
	<td>'.$productrw['pr_per'].'</td>
	<td class="editable" id="'.md5(md5(sha1(md5($productrw['sh_pr_id'])))).'_shqtya">'.$productrw['sh_qty'].'</td>
	<td>'.date('D d M , Y',$productrw['sh_dnt']).'</td>

	
';                              
if($_SESSION['SW_U_ACCESS'] >= 4){
 /*
								echo '
								<td>
<form action="master_action.php" method="post">
						<input type="hidden" value="'.md5(md5(sha1(md5($productrw['sh_pr_id'])))).'" name="cphk" />
						<input type="submit" class="btn btn-danger"  name="pr_sh_delete" value="Delete"/>
					</form>';echo '
				</td>';
					

 */ 					}
					
		echo '</tr>';
	$con++;
	}

} else {
	echo "0 results";
}?>
                        </tbody>
                        </table>
                                             
                                                
                                           
                                    </div>
                                    <?php  if($_SESSION['SW_U_ACCESS'] >= 2){ ?>
                                    <hr style="border-bottom:groove black solid" />
                                     <div class="row"><div align="center"><h2>Add</h2></div></div>
                                   
<form action="master_action.php" method="post">



<div class="row">
<div class="col-xs-6">
	<label>Code and Pr Name</label>
</div>
<div class="col-xs-4">
	<label>Showroom Name</label>
</div>
<div class="col-xs-2">
	<label>Qty</label>
</div>

</div>



<div class="row">
<div class="form-group ">
    <div class="col-sm-6"><br>

 <select id="select_can" class="form-control " name="pr_sh_id">
        <?php
          
          foreach( $productsinin as $pr){
          	
          	echo '<option value="'.base64_encode($pr['pr_id']).'">
          	'.$pr['pr_code'].' '.ucwords($pr['pr_name']).'
          	</option>';
			
          }
          ?>
        </select>    </div>
</div>
<div class="form-group ">
    <div class="col-sm-4">
	    <input class="form-control" name="pr_sh_loc" value="Stilewell Showroom" type="text" placeholder="Located">
    </div>
</div>
<div class="form-group ">
    <div class="col-sm-2">
	    <input class="form-control" name="pr_sh_qty" type="number" placeholder="Qty">
    </div>
</div>

</div>
<div class="row"><div class="col-xs-4 pull-right">
<?php
 foreach( $productsinin as $pr){
          	
          	echo '
			<p class=" thistoh" id="'.base64_encode($pr['pr_id']).'">Current qty of <i>'.$pr['pr_name'].' '.$pr['pr_code'].'</i> in warehouse is <em style="color:red">'.$pr['pr_qty'].'</em></p>
			';
			
          }
?>
</div>
</div>
<!--end form -->

<div class="row ">
    <div  style="margin-top:10px;"  align="center" >
	    <input class=" btn btn-primary" value="Add to Showroom Inventory" name="add_inven_sh" type="submit" placeholder="Product Price">
    </div>
</div>
</form>

<?php
									}


?>
      
                                    
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    
                </div> <!-- End row -->


            </div>
            <!-- Page Content Ends -->
            <!-- ================== -->

           
            
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
	$(".editable").editable("master_action.php", { 
			id: 'shw_ed',
			name : 'shw_val',
			
		  tooltip   : "Doubleclick to edit...",
		  event     : "dblclick",
		  style  : "inherit"
	});
});
 

</script>
       
<?php 
	}	
?>
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
        <script type="text/javascript">
            $(document).ready(function() {
                $('#datatable').dataTable();
            } );
        </script>
    </body>

</html>

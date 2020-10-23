<?php 
include('db_auth.php');
?>
<?php 
if($_SESSION['SW_U_ACCESS'] >= 3){
	if(isset($_GET['or_edit'])){
		if(isset($_GET['edihchk'])){
			if(is_array($_GET['edihchk'])){die('Hey Folk\'s, <br> We dont need and array ');}
			if(ctype_alnum(trim(strtolower($_GET['edihchk'])))){
				#codestart md5(md5(sha1(md5(or_id))))
				?>
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                <?PHP
				$getcontentssql = "
SELECT * FROM `sw_orders` so 
left join sw_order_items si 
on so.or_id = si.oi_rel_or_id 
left join sw_products_list pl
on si.oi_rel_pr_id = pl.pr_id
where so.or_valid =1 and si.oi_valid =1 and pr_valid =1 and  md5(md5(sha1(md5(so.or_id))))= '".trim(strtolower($_GET['edihchk']))."'
				";
				$contentsres = $conn->query($getcontentssql);
				if($contentsres->num_rows >0  ){
					$products = array();
					while($content = $contentsres->fetch_assoc()){
						$or_id = $content['or_id'];
						$or_ref= $content['or_ref_name'];
						$or_dnt= $content['or_datentime'];
						$or_buynm= $content['or_buy_name'];
						$or_valid= $content['or_valid'];
						$products[] = $content;
					}
					?>
                    
 <?php 
 
 				$notsql = "
SELECT oi_rel_pr_id FROM `sw_order_items` where oi_valid =1 and oi_rel_or_id =".$or_id;
				$notres = $conn->query($notsql);
				if($notres->num_rows >0){
					$nopr = array();
					while($nn = $notres->fetch_assoc()){
						$nopr[] = $nn['oi_rel_pr_id'];
					}

				}else{
					 empty($nopr) ;

				}
 
 
 			if(count($nopr) >1){
				$prsql = "
SELECT pr_name,pr_id FROM `sw_products_list` where pr_valid =1 and not(pr_id = ".implode(' or pr_id =',$nopr).") ";
			}else if(count($nopr)){
				$prsql = "
SELECT pr_name,pr_id FROM `sw_products_list` where pr_valid =1 and not(pr_id = ".$nopr[0].")  ";
			}else{
				$prsql = "
SELECT pr_name,pr_id FROM `sw_products_list` where pr_valid =1  ";
			}
			
			
				$prsres = $conn->query($prsql);
				if($prsres->num_rows >0){
					$productsinin = array();
					while($prr = $prsres->fetch_assoc()){
						$productsinin[] = $prr;
					}

				}else{
					 $productsinin[] = array('pr_id'=> 00,'pr_name'=>'Add More Products to Inventory');

				}
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
                               <i class="ion-user"> </i>
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
                                <h3 class="panel-title">Edit Order <?php echo $or_ref ?></h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">

                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                    
                                         <table  class="table ">
                                            <thead>
                                                <tr>
                                                    <th>Order Placed Date</th>
                                                    <th>Buyer Name</th>
                                                    <th>Order Status </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                            <?php
											echo '
											<td>'.date('d M-Y H:i:s',$or_dnt).'</td>
											<td>'.$or_buynm.'</td>
											<td>';
											if($or_valid ==1){
												echo '<i class="ion-checkmark-circled" style="color:green"></i>';
											}else{
												echo '<i class="ion-close-circled" style="color:red"></i>';
											}
											echo'</td>
											';
											?>
                                            </tr>
                                            </tbody>
                                            </table>
                                            <hr>
                                            
                                             <table id="datatable" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Product Name</th>
                                                    <th>Product Qty</th>
                                                    <th>Price/pc</th>
                                                    <th>Special INS</th>
													<?php 
													if($_SESSION['SW_U_ACCESS'] >= 4){
														echo '<th>Action</th>';
													}
													?>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                            <?php
											$ids = 1;
											
											for($cv=0;$cv<count($products);$cv++){
												echo '
<tr>
	<td>'.$ids.'</td>
	<td>'.$products[$cv]['pr_name'].'</td>
	<td class="or_pr_edit" id="'.md5(md5(sha1(md5($products[$cv]['oi_id'])))).'_orprqta">'.$products[$cv]['oi_qty'].'</td>
		<td class="or_pr_edit"  id="'.md5(md5(sha1(md5($products[$cv]['oi_id'])))).'_prorpfoa">'.$products[$cv]['oi_price_for_one'].'</td>

<td class="or_pr_edit"  id="'.md5(md5(sha1(md5($products[$cv]['oi_id'])))).'_prorspcla">'.$products[$cv]['oi_pr_special'].'</td>

	';
	if($_SESSION['SW_U_ACCESS'] >= 4){
														
	echo '<td><form action="master_action.php" method="post">
	<input required type="hidden" name="pr_or_delid" value="'.md5(sha1(md5(sha1(sha1(sha1($products[$cv]['oi_id'])))))).'" />
	<input required type="submit" class="btn btn-danger" value="Delete" name="or_pr_del" />
	</form></td>
	';
	}
	echo '
</tr>';
												$ids++;
											}
											
											?>
                                             
                                            </tbody>
                                            </table>
                                            
<form action="master_action.php" method="post">                                     
<div id="add1" class="clonedInput">
    <div class="row">
  <div class="form-group ">
  <div class="col-sm-3">
    <label>Product </label>
    <select class="form-control pr_id" id="pr_id" name="pr_id">
        	<?php
			$iv ='6tghjmnbvcde45rf';

			foreach( $productsinin as $pr){
				
				echo '<option value="'.$iv.'_0/'.openssl_encrypt($pr['pr_id'],'AES-256-CBC','430ij5h0bujv3r0ifgoijte',0,'7t6h39kfb4hgsnv4').'_0/'.$or_id.'">
				'.ucwords($pr['pr_name']).'
				</option>';
			}
			?>
	</select>
    <input required name="content_or___d" type="hidden" value="<?php echo $or_id; ?>" />
  </div>
</div>
    	
        
<div class="form-group ">
  <div class="col-sm-3">
    <label>Special INS</label>
    <input required id="or_pr_spcl " class="or_pr_spcl form-control" type="text" name="or_pr_spcl"  />
  </div>
</div>
<div class="form-group ">
  <div class="col-sm-3">
    <label>Product Qty</label>
    <input required id="or_pr_qty " class="or_pr_qty form-control" type="number" name="or_pr_qty"  />
  </div>
</div>
<div class="form-group ">
	<div class="col-sm-3">
		<label>Selling Price</label>
		<input required id="or_pr_ppp" class="or_pr_ppp form-control" type="text" name="or_pr_ppp" />
	</div>
</div>
<input required style="display:none" value="1" id="or_ids_no " class="or_ids_no form-control" type="number" name="or_ids_no"  />

    </div>
</div><br>

<div class="row">
    <div align="left" class=" col-sm-4 ">
        <div id="addDelButtons">
          <input style="border-radius:10px" type="button" id="btnAdd" value="Add More" class="btn btn-success" >
          <input style="border-radius:10px" type="button" id="btnDel" value="Remove" class="btn btn-danger">
        </div> 
    </div>
</div> <br>
<br>
  
<div class="row">
    <div align="center" class="col-sm-4 col-sm-offset-4 ">
          <input type="submit" name="or_prs_add" value="Submit Changes" class="btn btn-lg btn-success" >
    </div>
</div>   


</form>
                                    </div>
                                                                 
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    
                </div> <!-- End row -->


            </div>
            <!-- Page Content Ends -->
            <!-- ================== -->

          
            
            
            <footer class="footer">
            **Note: All the above prices are Buyer quoted and not what you got them for<br>
                                   
Admin StileWell
            </footer>
            <!-- Footer Ends -->



        </section>
        <!-- Main Content Ends -->
      

<?php 
get_end_script();
?>
<script src="assets/clone/additional-methods.js"></script>

<script type="text/javascript"  src="assets/clone/clone-form-td.js"></script>
<?php 
 if($_SESSION['SW_U_ACCESS'] >= 3){
?>
<script>
$(document).ready(function() {
	$(".or_pr_edit").editable("master_action.php", { 
			id: 'pr_or_editid',
			name : 'val_edtd',
			
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
function myFunct(val) {
	if(val ==2){
		y = '';
	}else{
		y =(val-1);
	}
    var prev = document.getElementById("pr_id"+y);
	var lat = document.getElementById("pr_id"+val);
    lat.remove(prev.selectedIndex);
}
</script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#datatable').dataTable();
            } );
        </script>
        <script type="text/javascript">
		 // Select2
                jQuery(".select2").select2("destroy");
				$(".className").select2({               
                placeholder: "Example",
                alowClear:true,
				width:"100%"
            });
		</script>


    </body>

</html>

                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    <?php
				}else{
					echo 'Nothing found to edit';
				}
                ?>
                
				
				
				
				
				
				
				
				<?php
				#codeend
			}
		}
	}
}else{
	die('Access Denied');
}
?>
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
                <?php 
				$prsql = "
SELECT pr_name,pr_id FROM `sw_products_list` where pr_valid =1  ";
			
			
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
                                <h3 class="panel-title">Add Orders</h3>
                            </div>
                                            <form action="sub_action_add.php" method="post">

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <table id="datatable" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Order Name (this is not the same as Invoice Name)</th>
                                                    <th>Buyer Name</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                            	<td><input required  class="form-control col-sm-12" name="or_ref_name" type="text"></td>
                                                <td><input required  class="form-control col-sm-12" name="or_buy_name" type="text"></td>
                                            </tr>
                                            
                                            </tbody>
                                            </table>
                                            
                                                
<div id="make1" style="margin-top:10px" class="cloneddInput">
  

<div class="row">
  <div class="col-sm-3"><label>Product </label></div>
  <div class="col-sm-3"><label>Special INS</label></div>
  <div class="col-sm-3"><label>Product Qty</label></div>
  <div class="col-sm-3"><label>Selling Price</label></div>
</div>
<div class="row">
  <div class="col-sm-3">
    <div class="form-group ">
      <div class="col-sm-12">
        <select class="form-control pr_id" id="pr_id" name="pr_id">
        <?php
          $iv = mcrypt_create_iv(16, MCRYPT_RAND);
          
          foreach( $productsinin as $pr){
          	
          	echo '<option value="'.$iv.'_0/'.openssl_encrypt($pr['pr_id'],'AES-256-CBC','430ij5h0bujv3r0ifgoijte',0,'7t6h39kfb4hgsnv4').'">
          	'.ucwords($pr['pr_name']).'
          	</option>';
          }
          ?>
        </select>
      </div>
    </div>
  </div>
    <div class="col-sm-3">
    <div class="form-group ">
      <div class="col-sm-12">
        <input required  id="or_pr_spcl" value="-" class="or_pr_spcl form-control" type="text" name="or_pr_spcl" />
      </div>
    </div>
  </div>

  <div class="col-sm-3">
    <div class="form-group ">
      <div class="col-sm-12">
        <input required  id="or_pr_qty " class="or_pr_qty form-control" type="number" name="or_pr_qty"  />
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="form-group ">
      <div class="col-sm-12">
        <input required  id="or_pr_ppp" class="or_pr_ppp form-control" type="text" name="or_pr_ppp" />
      </div>
    </div>
  </div>
</div>


  
<input required  style="display:none" value="1" id="o_or_ids_no " class="o_or_ids_no form-control" type="number" name="o_or_ids_no"  />
    	


    </div>
    

<div class="row">
    <div align="left" class=" col-sm-4 ">
        <div id="addDelButtons2">
          <input   style="border-radius:10px" type="button" id="btnAdd2" value="Add More" class="btn btn-success" >
          <input   style="border-radius:10px" type="button" id="btnDel2" value="Remove" class="btn btn-danger">
        </div> 
    </div>
</div> 
  
<div class="row">
    <div align="center" class="col-sm-4 col-sm-offset-4 ">
          <input   type="submit" name="or_add" value="Add Order" class="btn btn-lg btn-success" >
    </div>
</div>   
                                    </div>
                                                                 
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    
                </div> <!-- End row -->


            </div>
            <!-- Page Content Ends -->
            <!-- ================== -->

                                                        </form>
            
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


     <script src="assets/clone/additional-methods.js"></script>

<script type="text/javascript"  src="assets/clone/clone-form-td.js"></script>


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


    </body>

</html>

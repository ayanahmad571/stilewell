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
                            <div class="panel-heading">
                                <h3 class="panel-title">Samples sent for Approval</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <table id="datatable-da" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Code</th>
                                                    <th>Product Name</th>
                                                    <th>Product Type</th>
                                                    <th>Sent From <i class="ion-edit"></i></th>
                                                    <th>Contact Person <i class="ion-edit"></i></th>
                                                    <th>Contact Number <i class="ion-edit"></i></th>
                                                    <th>Address <i class="ion-edit"></i></th>
                                                    <th>Price AED</th>
                                                    <th>Given Qty <i class="ion-edit"></i></th>
                                                    <th>Returned <i class="ion-edit"></i></th>
                                                    <th>Remarks <i class="ion-edit"></i></th>
													<?php 
                                                    if($_SESSION['SW_U_ACCESS'] >= 4){
                                                    echo '<th>Action</th>';
                                                    }?> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
$productsql = "SELECT * FROM sw_mockup mk 
left join sw_products_list pl on
pl.pr_id = mk.mock_rel_pr_id
  where mockup_valid= 1 and pl.pr_valid=1";
$productres = $conn->query($productsql);

if ($productres->num_rows > 0) {
	// output data of each row
	
	$con = 1;
	while($productrw = $productres->fetch_assoc()) {
		echo '<tr>
	<td>'.$con.'</td>
	<td>'.$productrw['pr_code'].'</td>
	<td>'.$productrw['pr_name'].'</td>
	<td>'.$productrw['pr_type'].'</td>
	<td class="editable_whshr" id="'.md5(md5(sha1(md5($productrw['mock_id'])))).'_mksfa">'.$productrw['mock_sent_from'].'</td>
	<td class="editable" id="'.md5(md5(sha1(md5($productrw['mock_id'])))).'_mkpnamea">'.$productrw['mock_given_person_name'].'</td>
	<td class="editable" id="'.md5(md5(sha1(md5($productrw['mock_id'])))).'_mkpnumbera">'.$productrw['mock_given_person_number'].'</td>
	<td class="editable" id="'.md5(md5(sha1(md5($productrw['mock_id'])))).'_mkpadda">'.$productrw['mock_given_person_address'].'</td>
	<td >'.$productrw['pr_price'].'</td>
	<td class="editable" id="'.md5(md5(sha1(md5($productrw['mock_id'])))).'_mkqtya">'.$productrw['mock_qty'].'</td>
	<td class="editable_select" id="'.md5(md5(sha1(md5($productrw['mock_id'])))).'_mkretrnda">'.$productrw['mock_sample_returned'].'</td>
	<td class="editable" id="'.md5(md5(sha1(md5($productrw['mock_id'])))).'_remarksa">'.$productrw['mock_sample_remarks'].'</td>
	';                              
if($_SESSION['SW_U_ACCESS'] >= 4){
								echo '<td>
<form action="master_action.php" method="post">
						<input required type="hidden" value="'.md5(md5(sha1(md5($productrw['mock_id'])))).'" name="checker" />
						<input  type="submit" class="btn btn-danger"  name="mk_delete" value="Delete"/>
					</form>';echo '
				
				</td>';
					
					}
					
		echo '</tr>';
	$con++;
	}

} else {
	;
}?>
                        </tbody>
                        </table>
                                             
                                                
                                           
                                    </div>
                                    <?php  if($_SESSION['SW_U_ACCESS'] >= 2){ ?>
                                    <hr style="border-bottom:groove black solid" />
                                     <div class="row"><div align="center"><h2>Add</h2></div></div>
<form action="master_action.php" method="post">



<div class="row">
<div class="col-xs-4">
	<label>Code and Pr Name</label>
</div>
<div class="col-xs-2">
	<label>From</label>
</div>
<div class="col-xs-3">
	<label>Given To</label>
</div>
<div class="col-xs-3">
	<label>Contact No.</label>
</div>
</div>




<div class="row">
<div class="form-group ">
    <div class="col-sm-4"><br>

 <select class="form-control " name="mk_pr_id">
        <?php
          
          foreach( $productsinin as $pr){
          	
          	echo '<option value="'.base64_encode($pr['pr_id']).'">
          	'.$pr['pr_code'].' '.ucwords($pr['pr_name']).'
          	</option>';
          }
          ?>
        </select>
            </div>
</div>
<div class="form-group ">
    <div class="col-sm-2">
 <select class="form-control" name="mk_s_from">
        <option  value="shr">Showroom</option>
        <option selected value="wh">Warehouse</option>
        </select>
            </div>
</div>
<div class="form-group ">
    <div class="col-sm-3">
	    <input required class="form-control" name="mk_pers_nm" type="text" placeholder="Person's Name">
    </div>
</div>
<div class="form-group ">
    <div class="col-sm-3">
	    <input required class="form-control" name="mk_conct_no" type="number" placeholder="Phone No.">
    </div>
</div>
</div>
<div class="row">
<div class="col-xs-11">
	<label>Address (Given)</label>
</div>
<div class="col-xs-1">
	<label>Qty</label>
</div>


</div>
<div class="row">
<div class="form-group ">
    <div class="col-sm-11"><br>

	    <input required class="form-control" name="mk_pers_add" type="text" placeholder="Address">
    </div>
</div>
<div class="form-group ">
    <div class="col-sm-1">
	    <input required class="form-control" name="mk_g_qty" value="1" type="number" placeholder="QTY">
    </div>
</div>



</div>

<!--end form -->
<div class="row ">
    <div  style="margin-top:10px;"  align="center" >
	    <input class=" btn btn-primary" value="Add Mockup" name="add_mk" type="submit" >
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
 <script type="text/javascript">
            $(document).ready(function() {
                $('#datatable-da').dataTable({
				 "scrollX": true	
				});
            } );
        </script>
<?php 
 if($_SESSION['SW_U_ACCESS'] >= 3){
?>
<script>
$(document).ready(function() {
	$(".editable").editable("master_action.php", { 
			id: 'mockup_et',
			name : 'mockup_et_val',
			
		  tooltip   : "Doubleclick to edit...",
		  event     : "dblclick",
		  style  : "inherit"
	});
	
	  $(".editable_select").editable("master_action.php", { 
id: 'mockup_et',
name : 'mockup_et_val',
tooltip   : "Doubleclick to edit...",
data   : "{'1':'Yes','0':'No'}",
type   : "select",
submit : "OK",
style  : "inherit",
submitdata : function() {
      return {id : 2};
    }
  });
  
    $(".editable_whshr").editable("master_action.php", { 
id: 'mockup_et',
name : 'mockup_et_val',
tooltip   : "Doubleclick to edit...",
data   : "{'wh':'Warehouse','shr':'Showroom'}",
type   : "select",
submit : "OK",
style  : "inherit"
  
  });
});
 
 

</script>
       
<?php 
	}	
?>
  
       
    </body>

</html>

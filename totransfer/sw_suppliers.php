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
                                <h3 class="panel-title">Manage Suppliers</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div style=" overflow:auto;
 position:relative;" class="row">
                                    <table id="datatable1" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Code</th>
                                                    <th>Bank</th>
                                                    <th>Tax Code</th>
                                                    <th>Billing Address</th>
                                                    <th>Shippping Address</th>
                                                    <th>Phone</th>
                                                    <th>Email</th>
                                                    <th>Payment Terms</th>
                                            	    <th>Client Since</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
<?php

$boxsql = "SELECT * FROM `sw_suppliers` where sup_valid =1 order by sup_name asc";
$boxres = $conn->query($boxsql);

if ($boxres->num_rows > 0) {
    // output data of each row
	$cc =1;
    while($boxrw = $boxres->fetch_assoc()) {
		#firts loop begins
		
			$give = '<a data-toggle="modal" data-target="#'.md5(md5(sha1($boxrw['sup_id']))).'" class="btn btn-sm btn-warning m-t-20 ion-edit"></a></form>';
		echo '
		<tr>
<td>'.$boxrw['sup_name'].'</td>
<td>'.$boxrw['sup_code'].'</td>
<td>'.$boxrw['sup_bank_details'].'</td>
<td>'.$boxrw['sup_tax_code'].'</td>
<td>'.$boxrw['sup_bill_addr'].'</td>
<td>'.$boxrw['sup_ship_addr'].'</td>
<td>'.$boxrw['sup_contact_no'].'</td>
<td>'.$boxrw['sup_email'].'</td>
<td>'.$boxrw['sup_pay_terms'].'</td>
<td>'.date('j-M, Y',$boxrw['sup_dnt']).'</td>
<td class="no-sort">'.$give.'</td>
</tr>';
	$cc++;
	#first loop ends
	$stus = 'None';
    }
} else {
    echo "0 results";
}
 ?>                                                  
                                            </tbody>
                                        </table>
                                        <!-- -->

                               
 
 
                                        
                                 
                                        <!-- -->
                                    </div>
                                    <hr>
                                    <div class="row">
                                    <form action="master_action.php" method="post">
                                    <h4>&nbsp; Add supplier</h4>
                                     <div class="col-md-12">
	<div class="panel panel-color panel-inverse">
            <div class="panel-heading"> 
        </div>

		<div class="panel-body"> 
<p>Name:<input required class="form-control "  name="add_supplier_name" type="text" placeholder="Alpha Beta" /></p>
<p>Code:<input required class="form-control "  name="add_supplier_code" type="text" placeholder="AB" /></p>
<p>Email: <input required  class="form-control" name="add_supplier_email" type="email" placeholder="abc@example.com"  /></p> 
<p>Billing Address: <textarea name="add_supplier_bill_addr" class="wysihtml5 form-control" rows="9"></textarea></p> 
<p>Shipping Address:<textarea name="add_supplier_ship_addr" class="wysihtml5 form-control" rows="9"></textarea></p>
<p>Tax Code:<input required class="form-control "  name="add_supplier_tax_code" type="text" placeholder="Code" /></p>
<p>Bank Details:<input required class="form-control "  name="add_supplier_bnkdet" type="text" placeholder="Details" /></p>
<p>Phone:<input required class="form-control "  name="add_supplier_phone" type="text" placeholder="With International Code and seperated with comma ," /></p>
<p>Desc: <textarea name="add_supplier_desc" class="form-control" rows="9"></textarea></p> 
<p>Payment Terms: <input required  class="form-control" name="add_supplier_pyt" type="text" placeholder='50,40,10' value="50,50" /></p> 

<p><input class="btn btn-success " name="add_supplier" type="submit" value="Add supplier"/></p> 
		</div> 
	</div>
</div>

</form>


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
            
       
 <?php
	$msql = "SELECT * FROM `sw_suppliers` where sup_valid =1 ";
$mres = $conn->query($msql );

if ($mres->num_rows > 0) {
    // output data of each row

    while($mrw = $mres->fetch_assoc()) {
		#firts loop begins
		foreach($mrw as $me=>$m){
			$mrw[$me] = trim($m);
		}
		echo '
<div id="'.md5(md5(sha1($mrw['sup_id']))).'" class="modal fade" role="dialog">
  <div class="modal-full modal-dialog">

    <!-- Modal content-->
   <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Editing '.$mrw['sup_name'].'</h4>
      </div>
      <div class="modal-body">
        <form action="master_action.php" method="post">
		
<div class="form-group">
	<label>Name : </label>
	<input name="edit_supplier_name" type="text" class="form-control" value="'.$mrw['sup_name'].'"/>
</div>
		
<div class="form-group">
	<label>Desc : </label>
	<input name="edit_supplier_desc" type="text" class="form-control" value="'.$mrw['sup_desc'].'"/>
</div>
		
<div class="form-group">
	<label>Code : </label>
	<input disabled type="text" class="form-control" value="'.$mrw['sup_code'].'"/>
</div>

<div class="form-group">
	<label>Bank Details : </label>
	<input name="edit_supplier_bkdet"  type="text" class="form-control" value="'.$mrw['sup_bank_details'].'"/>
</div>

<div class="form-group">
	<label>Tax Code : </label>
	<input name="edit_supplier_txcd"  type="text" class="form-control" value="'.$mrw['sup_tax_code'].'"/>
</div>
		
<div class="form-group">
	<label>Contact Number: </label>
	<input name="edit_us_contact" type="text" class="form-control" value="'.$mrw['sup_contact_no'].'"/>
</div>
		
<div class="form-group">
	<label>Email : </label>
	<input name="edit_supplier_email" type="email" class="form-control" value="'.$mrw['sup_email'].'"/>
</div>
		
<div class="form-group">
	<label>Payment Terms: </label>
	<input name="edit_supplier_pay_terms" type="text" class="form-control" value="'.$mrw['sup_pay_terms'].'"/>
</div>
		
<div class="form-group">
	<label>Billing Address : </label>
	<textarea name="edit_supplier_bill_addr" class="wysihtml5 form-control" rows="9">'.$mrw['sup_bill_addr'].'</textarea>
</div>
		
<div class="form-group">
	<label>Shipping Address : </label>
	<textarea name="edit_supplier_ship_addr" class="wysihtml5 form-control" rows="9">'.$mrw['sup_ship_addr'].'</textarea>
</div>

<div class="row">
	<div class="col-xs-6">
	<input type="hidden" value="'.md5(md5(sha1(sha1(md5(md5($mrw['sup_id'].'kiwi 2fgtegrfr3gbter 24rfgr324frgtr3f 3gr32fgr32f4gr')))))).'" name="edit_supplier_hash" />
		<input style="float:right" type="submit" class="btn btn-success" name="edit_supplier" value="Save">
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
    echo "0 results";
}
 ?>             
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
		        <script type="text/javascript" src="assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
        <script type="text/javascript" src="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script>
$(document).ready(function(){
		  $(".wysihtml5").wysihtml5();
});
</script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#datatable1').dataTable();
            } );
        </script>
      
           </body>

</html>

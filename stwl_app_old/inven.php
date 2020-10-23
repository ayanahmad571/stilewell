<?php 
include('db_auth.php');
?>
<!DOCTYPE html>
<html lang="en">
    
<head>
       <?php 
	   get_head();
	   ?>
       <?php 
get_end_script();
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
               



                <div class="row">
                    

                    <div class="col-lg-12	">

                        <div class="panel panel-default"><!-- /primary heading -->
                            <div class="portlet-heading">
      
                            <div class="panel-heading">
                                <h3 class="panel-title">Warehouse Inventory</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <table id="datatable" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Code</th>
                                                    <th>Img</th>
                                                    <th>Product Name <i class="ion-edit"></i></th>
                                                    <th>Product Type <i class="ion-edit"></i></th>
                                                    <th>Desc <i class="ion-edit"></i></th>
                                                    <th>Cost AED <i class="ion-edit"></i></th>
                                                    <th>Per</th>
                                                    <th>Qty <i class="ion-edit"></i></th>
                                                    <th>Date</th>
													<?php 
                                                    if($_SESSION['SW_U_ACCESS'] >= 4){
                                                    echo '<th>Action</th>';
                                                    }?> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
$productsql = "SELECT * FROM sw_products_list where pr_valid= 1 ";
$productres = $conn->query($productsql);

if ($productres->num_rows > 0) {
	//'.md5(md5(sha1(md5($productrw['pr_id'])))).'_primga output data of each row
	
	$con = 1;
	while($productrw = $productres->fetch_assoc()) {
		echo '<tr>';
		  echo '<td>'.$con.'</td>
	<td>'.$productrw['pr_code'].'</td>
	<td>
		<img data-toggle="modal" data-target="#'.md5($productrw['pr_id'].$productrw['pr_img']).'" width="120px" src="'.$productrw['pr_img_2'].'" class=" img-responsive" />
		
	</td>
	<td class="editable" id="'.md5(md5(sha1(md5($productrw['pr_id'])))).'_prnamea">'.$productrw['pr_name'].'</td>
	<td class="editable" id="'.md5(md5(sha1(md5($productrw['pr_id'])))).'_prtypea">'.$productrw['pr_type'].'</td>
	<td class="editable" id="'.md5(md5(sha1(md5($productrw['pr_id'])))).'_prdesca">'.$productrw['pr_desc'].'</td>
	<td class="editable" id="'.md5(md5(sha1(md5($productrw['pr_id'])))).'_prpricea">'.$productrw['pr_price'].'</td>
	<td>'.$productrw['pr_per'].'</td>
	<td class="editable" id="'.md5(md5(sha1(md5($productrw['pr_id'])))).'_prqtya">'.$productrw['pr_qty'].'</td>
	<td>'.date('D d M , Y',$productrw['pr_dnt']).'</td>
';                              
if($_SESSION['SW_U_ACCESS'] >= 4){
								echo '
								<td>
<form action="master_action.php" method="post">
						<input required  type="hidden" value="'.md5(md5(sha1(md5($productrw['pr_id'])))).'" name="hchk" />
						<input required  type="submit" class="btn btn-danger"  name="pr_delete" value="Delete"/>
					</form>';echo '
				</td>';
					
					}
					
		echo '</tr>';
		echo "
		<script>
		$(\".img_edit".$productrw['pr_id']."\").editable(\"img_change_inven.php\", { 
			id: 'img_go',
			name : 'vgbhk4d8jn4t__".md5(md5(sha1(md5($productrw['pr_id']))))."',
			
		    tooltip: \"Doubleclick to edit...\",
		    event : \"dblclick\",
			type  :'ajaxupload',
			submit : 'Upload',
			cancel : 'Cancel'
	});
	
		</script>
		";
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
                                   


<form action="master_action.php" method="post" enctype="multipart/form-data">
   <div class="row">
      <div class="col-xs-6">
         <div class="row">
            <div class="col-xs-4">
               <label>Code</label>
            </div>
            <div class="col-xs-4">
               <label>Pr Name</label>
            </div>
            <div class="col-xs-4">
               <label>Type</label>
            </div>
         </div>
         <div class="row">
            <div class="form-group ">
               <div class="col-sm-4"><br>

                  <input required  class="form-control" name="pr_code" type="text" placeholder="Code">
               </div>
            </div>
            <div class="form-group ">
               <div class="col-sm-4">
                  <input required  class="form-control" name="pr_name" type="text" placeholder="Product Name">
               </div>
            </div>
            <div class="form-group ">
               <div class="col-sm-4">
                  <input required  class="form-control" name="pr_type" type="text" placeholder="Product Type">
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-xs-12">
               <label>Desc</label>
            </div>
         </div>
         <div class="row">
            <div class="form-group ">
               <div class="col-sm-12">
                  <textarea class="form-control" name="pr_desc" type="text" placeholder="Description"></textarea>
               </div>
            </div>
         </div>
         <!-- ff-->
      </div>
      <div class="col-xs-6">
         <div class="row">
            <div class="col-xs-4">
               <label>Cost</label>
            </div>
            <div class="col-xs-4">
               <label>Per</label>
            </div>
            <div class="col-xs-4">
               <label>Qty</label>
            </div>
         </div>
         <div class="row">
            <div class="form-group ">
               <div class="col-sm-4"><br>

                  <input required  class="form-control" name="pr_price" type="text" placeholder="Cost">
               </div>
            </div>
            <div class="form-group ">
               <div class="col-sm-4">
                  <input required  required type="text" placeholder="sqm or pc or any" class="form-control" name="pr_per" />
               </div>
            </div>
            <div class="form-group ">
               <div class="col-sm-4">
                  <input required  class="form-control" name="pr_qty" type="number" min="0" placeholder="Qty">
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-xs-12">
               <label>Image</label>
            </div>
         </div>
         <div class="row">
            <div class="form-group ">
               <div class="col-sm-12">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
  <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
  <div>
    <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input  type="file" name="prr_img"  /></span>
    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
  </div>
</div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!--end form -->
   <div class="row ">
      <br>
      <br>
      <div  style="margin-top:10px;"  align="center" >
         <input class=" btn btn-primary" value="Add to Warehouse Inventory" name="add_inven" type="submit" />
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

            <?php

#$sql = "SELECT distinct(oi_rel_or_id)as oid from sw_order_items where oi_rel_pr_id = 3 and oi_valid= 1 ";
$modalsql = "SELECT * FROM `sw_products_list` where pr_valid = 1";
$modalres = $conn->query($modalsql);

if ($modalres->num_rows > 0) {
    // output data of each row
    while($modalrw = $modalres->fetch_assoc()) {
		#firts loop begins
		echo '
<div id="'.md5($modalrw['pr_id'].$modalrw['pr_img']).'" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">'.$modalrw['pr_name'].'</h4>
      </div>
      <div class="modal-body">
      
<img class="lazy_modal" data-original="'.$modalrw['pr_img'].'" width="500"/>
	      </div>
		  
		  <div>
		  <form action="img_change_inven.php" method="post" enctype="multipart/form-data">
		  <input type="hidden" name="inven_id" value="'.md5(md5(sha1(md5(sha1($modalrw['pr_id']))))).'"/>
		  <input type="file" name="filer"/>
		  <input type="submit" value="Update" name="updt_img" class="btn btn-danger" />
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
 if($_SESSION['SW_U_ACCESS'] >= 3){
?>
<script>
$(document).ready(function() {
	$(".editable").editable("master_action.php", { 
			id: 'edit_thing',
			name : 'value_edited',
			
		  tooltip   : "Doubleclick to edit...",
		  event     : "dblclick",
		  style  : "inherit"
	});
	
	
});
 

</script>
       
<?php 
	}	
?>
  
        <script type="text/javascript">
            $(document).ready(function() {
                $('#datatable').dataTable();
				$("img.lazy").lazyload();
				$("img.lazy_modal").lazyload({
					event : "mouseover"
				});
            } );
			
        </script>
    </body>

</html>

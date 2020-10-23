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
	header('Location: login.php');
	
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

<?php get_head(); ?>
               <link href="assets/fullcalendar/fullcalendar.css" rel="stylesheet" />
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
                <div class="page-title"> 
                    <h3 class="title">Welcome <?php echo ucwords($_USER['usr_fname']).' '.ucwords($_USER['usr_lname']); ?> !</h3> 
                </div>



                <div class="row">
                    

                    <div class="col-lg-12	">

                        <div class="panel panel-default"><!-- /primary heading -->
                            <div class="portlet-heading">
      
                            <div class="panel-heading">
                                <h3 class="panel-title">Things at a Glance</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                <p>Note: All data has been picked from proformas</p>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <table id="datatable" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Img </th>
                                                    <th>Product Name</th>
                                                    <th>Unit</th>
                                                    <th>Conversion Unit And Formula</th>
                                                    <th>Stock</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php

$getmain = "SELECT * from sw_products_list left join sw_prod_types on pr_rel_prty_id = prty_id where pr_valid = 1 
 ";
$getmainres = $conn->query($getmain);

if ($getmainres->num_rows > 0) {
	// output data of each row
	
	$con = 1;
	while($getmainrw = $getmainres->fetch_assoc()) {
		$getproformas = getdatafromsql($conn,"SELECT ifnull(sum(a.pi_qty),0) as tqty
FROM (select * from sw_proformas_items left join sw_proformas on pi_rel_po_id = po_id where po_valid =1 and pi_valid =1) a
LEFT OUTER JOIN (select * from sw_proformas_items left join sw_proformas on pi_rel_po_id = po_id where po_valid =1 and pi_valid =1) b
    ON a.po_revision_id = b.po_revision_id AND a.po_revision < b.po_revision
WHERE b.po_revision_id IS NULL
and a.pi_rel_pr_id =".$getmainrw['pr_id']);

if(is_array($getproformas)){
	$totalsold = $getproformas['tqty'];
}else{
	$totalsold = '0';
}
		
		
		echo '<tr>';
		  echo '<td>'.$con.'</td>
				<td><img src="'.$getmainrw['pr_img_2'].'" class="img-responsive" /></td>
				<td>'.$getmainrw['pr_code'].' '.$getmainrw['pr_name'].'</td>
				<td>'.$getmainrw['prty_unit'].'</td>
				<td>'.$getmainrw['prty_conv_unit'].' @ '.$getmainrw['prty_conv_formula'].'</td>
				<td>
				<button id="getStored" data-toggle="modal" data-target="#view-modal" data-id="'.md5('123'.$getmainrw['pr_id']).'" class="btn btn-sm btn-warning">View Breakup</button>
				</td>
				';
		echo '</tr>';
	$con++;
	}

} else {
	echo "0 results";
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
            </div>

 
            <!-- Page Content Ends -->
            <!-- ================== -->

            <!-- Footer Start -->
            <footer class="footer">
<?php auto_copyright(); // Current year?>

  Aforty.
            </footer>
            <!-- Footer Ends -->



        </section>
        <!-- Main Content Ends -->
  

<div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-full modal-dialog"> 
     <div class="modal-content">  
   
        <div class="modal-header"> 
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
           <h4 class="modal-title">Product Analysis</h4> 
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

      <?php  
	  get_end_script();
	  ?>
      
            
         <script src="assets/fullcalendar/moment.min.js"></script>
        <!--dragging calendar event-->
<script>
!function($) {
    "use strict";

    var SweetAlert = function() {};

    //examples 
    SweetAlert.prototype.init = function() {
        
<?php 

if(isset($_GET['mailsent'])){
	echo ' $(document).ready(function(){
        swal("Mail Sent!", "An Email regarding the issue has been sent . You will get a reply to the specified email within a few days", "success")
    });';
}
?>
    //Success Message
   


    },
    //init
    $.SweetAlert = new SweetAlert, $.SweetAlert.Constructor = SweetAlert
}(window.jQuery),

//initializing 
function($) {
    "use strict";
    $.SweetAlert.init()
}(window.jQuery);
</script>
       <script src="assets/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/datatables/dataTables.bootstrap.js"></script>


 <script>
$(document).ready(function(){

$(document).on('click', '#getStored', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'home_qty_stored='+uid,
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

        <script type="text/javascript">
            $(document).ready(function() {
                $('#datatable').dataTable();
            } );
        </script>



    </body>

</html>

<?php 

if(include('include.php')){
}else{
	die('ERrIN');
}
?>
<?php 

if(include('page_that_has_to_be_included_for_every_user_visible_page.php')){
}else{
	die('ERrPH');
}
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
        <link rel="stylesheet" type="text/css" href="assets/jquery-multi-select/multi-select.css" />
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
    <button type="button" class="navbar-toggle pull-left"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    
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
    <div class=""> </div>
    <!-- End row -->
    <div class="col-lg-12	">
      <div class="panel panel-default"><!-- /primary heading -->
        <div class="portlet-heading">
        </div>
        <div class="panel-body">
                <form role="form" action="rep_gen.php" method="post">
        
          <div class="col-md-6">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Time Period</h3>
              </div>
              <div class="panel-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">From</label>
                    <input name="rep_time_from" class="form-control" required placeholder="12.02.2017" type="text" value="<?php echo date('d.m.Y',(time()- 2592000)); ?>">
                  </div>
                  </div>
              <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Till</label>
                    <input name="rep_time_till" class="form-control" required placeholder="12.02.2017" type="text" value="<?php echo date('d.m.Y',(time())); ?>">
                  </div>
                </div>
              </div>
              <!-- panel-body --> 
            </div>
            <!-- panel --> 
          </div>

          <div class="col-md-6">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Client</h3>
              </div>
              <div class="panel-body">
<div class="col-md-12">
                                            <select multiple="multiple" class="multi-select" id="my_multi_select2" name="rep_cli_hashes[]">
                                            <?php
$sql = "select * from sw_clients where cli_valid =1 ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
			    echo "<option selected value='".$row['cli_id']."'>".$row['cli_code']." ".$row['cli_name']."</option>";
    }
} else {
    echo "No Class";
}
											?>
                                               

                                            </select>
                            </div>
              </div>
              <!-- panel-body --> 
            </div>
            <!-- panel --> 
          </div>
          
          <hr>
                <label class="cr-styled">
                    <input name="rep_profit" value="1" type="checkbox">
                    <i class="fa "></i> 
                    Show Profit and Markup
                </label><hr>
                <label class="cr-styled">
                    <input name="rep_det" value="1" type="checkbox">
                    <i class="fa "></i> 
                    Show Item Details in each order
                </label>
            
            <div align="center"><input type="submit" name="rep_gen" value="Generate Report" required class="btn btn-success btn-lg" style="font-size:20px; padding:15px" /></div>                
            </form>
          
        </div>
      </div>
    </div>
    <!-- end col --> 
    
  </div>
  <!-- End row -->
  
  </div>
  </div>
  
  <!-- Page Content Ends --> 
  <!-- ================== --> 
  
  <!-- Footer Start -->
  <footer class="footer">
    <?php auto_copyright(); // Current year?>
    Aforty. </footer>
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
          <img width="100px" src="img/ajax-loader.gif"> </div>
        
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
<script>
$(document).ready(function(){

$(document).on('click', '#getStoredSP', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'home_qty_stored_sp='+uid,
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
                <script type="text/javascript" src="assets/jquery-multi-select/jquery.multi-select.js"></script>
        <script>

            $(document).ready(function(){
                $('#my_multi_select2').multiSelect();
				
				});

				
			
			
        </script>
</body>
</html>

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

<!DOCTYPE html>
<html lang="en">
<head>
<?php get_head(); ?>
<link rel="stylesheet" type="text/css" href="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
<link href="assets/sweet-alert/sweet-alert.min.css" rel="stylesheet">
<link href="assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="assets/fullcalendar/fullcalendar.css" rel="stylesheet" />
</head>

<body>

<section > 
  
  
  <div class="wraper container-fluid">
    <div class="row">
      <div class="col-lg-12	">
        <div class="panel panel-default"><!-- /primary heading -->
          <div class="portlet-heading">
            <div class="row">
            <?php
			$foryesterday = getdatafromsql($conn,"SELECT ifnull(count(pt_id),0) as nos FROM 
sw_payments

WHERE pt_valid = 1 and
 ((from_unixtime(`pt_cheque_date`, '%d') *1 )  = ".(date('j',(time()-86400))).") and 
 ((from_unixtime(`pt_cheque_date`, '%m') *1 )  = ".(date('n',(time()-86400))).") and 
 ((from_unixtime(`pt_cheque_date`, '%Y') *1 )  = ".(date('Y',(time()-86400))).")");

			$fortoday = getdatafromsql($conn,"SELECT ifnull(count(pt_id),0) as nos FROM 
sw_payments

WHERE pt_valid = 1 and
 ((from_unixtime(`pt_cheque_date`, '%d') *1 )  = ".(date('j',(time()))).") and 
 ((from_unixtime(`pt_cheque_date`, '%m') *1 )  = ".(date('n',(time()))).") and 
 ((from_unixtime(`pt_cheque_date`, '%Y') *1 )  = ".(date('Y',(time()))).")");

			$fortom = getdatafromsql($conn,"SELECT ifnull(count(pt_id),0) as nos FROM 
sw_payments

WHERE pt_valid = 1 and
 ((from_unixtime(`pt_cheque_date`, '%d') *1 )  = ".(date('j',(time()+86400))).") and 
 ((from_unixtime(`pt_cheque_date`, '%m') *1 )  = ".(date('n',(time()+86400))).") and 
 ((from_unixtime(`pt_cheque_date`, '%Y') *1 )  = ".(date('Y',(time()+86400))).")");

			$fordayaftertom = getdatafromsql($conn,"SELECT ifnull(count(pt_id),0) as nos FROM 
sw_payments

WHERE pt_valid = 1 and
 ((from_unixtime(`pt_cheque_date`, '%d') *1 )  = ".(date('j',(time()+(86400*2)))).") and 
 ((from_unixtime(`pt_cheque_date`, '%m') *1 )  = ".(date('n',(time()+(86400*2)))).") and 
 ((from_unixtime(`pt_cheque_date`, '%Y') *1 )  = ".(date('Y',(time()+(86400*2)))).")");

			?>
  <div class="col-xs-6">
    <h3>Yesterday Cheques          (<?php echo date('j-n-Y',(time()-86400)); ?>)               :<button id="PastPay" data-toggle="modal" data-target="#view-modal" class="btn btn-sm btn-success"> <?php echo $foryesterday['nos'] ?></button></h3>
    <h3>Cheques for Today (<?php echo date('j-n-Y',time()); ?>)                           :<button id="TodayPay" data-toggle="modal" data-target="#view-modal" class="btn btn-sm btn-success">  <?php echo $fortoday['nos'] ?></button></h3>
    <h3>Cheques for Tomorrow (<?php echo date('j-n-Y',(time()+86400)); ?>)                :<button id="TomorrowPay" data-toggle="modal" data-target="#view-modal" class="btn btn-sm btn-success">  <?php echo $fortom['nos'] ?></button></h3>
    <h3>Cheques for Day After Tomorrow (<?php echo date('j-n-Y',(time()+(86400*2))); ?>)  :<button id="DATPay" data-toggle="modal" data-target="#view-modal" class="btn btn-sm btn-success">  <?php echo $fordayaftertom['nos'] ?></button></h3>
  </div>
  <div class="col-xs-6" align="right">
  	<a href="home.php"><button class="btn btn-lg btn-danger">Continue to Panel -></button></a>
  </div><br>
<br>

  <div class="col-xs-8 col-xs-offset-2">
                <div id='calendar'></div>
              </div>
            </div>
          </div>
          <!-- end col --> 
          
        </div>
        <!-- End row --> 
        
      </div>
      <!-- End row --> 
      
    </div>
    <!-- Page Content Ends --> 
    <!-- ================== --> 
    
    <!-- Footer Start -->
    
    <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-full modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">Payment Tracker</h4>
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
    
    <!-- Footer Start -->
    
  </div>
</section>
<!-- Main Content Ends -->

<?php  
	  get_end_script();
	  ?>
<script src="assets/fullcalendar/moment.min.js"></script> 
<script src="assets/fullcalendar/fullcalendar.min.js"></script> 
<script src="assets/datatables/jquery.dataTables.min.js"></script> 
<script src="assets/datatables/dataTables.bootstrap.js"></script> 
<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable1').dataTable({
			 searchHighlight: true
			});
    } );
</script> 
<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable2').dataTable({
			 searchHighlight: true
			});
    } );
</script> 
<script>
$(document).ready(function(){

$(document).on('click', '#AddQty', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'payment_add='+uid,
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

$(document).on('click', '#PastPay', function(e){  
     e.preventDefault();
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'past_pay=1',
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

$(document).on('click', '#TodayPay', function(e){  
     e.preventDefault();
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'today_pay=1',
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

$(document).on('click', '#TomorrowPay', function(e){  
     e.preventDefault();
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'tomorrow_pay=1',
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

$(document).on('click', '#DATPay', function(e){  
     e.preventDefault();
  
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'dayaftertomorrow_pay=1',
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

$(document).on('click', '#getQty', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'payment_view='+uid,
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
<script type="text/javascript" src="assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
<script type="text/javascript" src="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script> 
<script>
$(document).ready(function(){
		  $(".wysihtml5").wysihtml5();
});
</script>
<?php 
	$jsvar = array();	
			
$sql = "SELECT * FROM sw_payments where pt_valid =1 and pt_rel_method_id =1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	$jsvar[] ="    {
                        title: 'Ch: ".$row['pt_cheque_number']."',
                        start: new Date(".date('Y',trim($row['pt_cheque_date'])).", ".(date('n',trim($row['pt_cheque_date']))-1).", ".date('j',trim($row['pt_cheque_date'])).", 12, 5), 
                        end: new Date(".date('Y',trim($row['pt_cheque_date'])).", ".(date('n',trim($row['pt_cheque_date']))-1).", ".date('j',trim($row['pt_cheque_date'])).", 23 ,29)
                    }
					
					";
	}
} 
		

		?>
<script>


!function($) {
    "use strict";

    var CalendarPage = function() {};

    CalendarPage.prototype.init = function() {

        //checking if plugin is available
        if ($.isFunction($.fn.fullCalendar)) {
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek,basicDay'
                },
                events: [<?php 
echo implode(', ',$jsvar);?>]
            });
            
             /*Add new event*/
            // Form to add new event


        }
        else {
            alert("Calendar plugin is not installed");
        }
    },
    //init
    $.CalendarPage = new CalendarPage, $.CalendarPage.Constructor = CalendarPage
}(window.jQuery),

//initializing 
function($) {
    "use strict";
    $.CalendarPage.init()
}(window.jQuery);

		</script>
</body>
</html>

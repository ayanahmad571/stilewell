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
	
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

<?php get_head(); ?>
               <link href="assets/fullcalendar/fullcalendar.css" rel="stylesheet" />
  <link href="assets/sweet-alert/sweet-alert.min.css" rel="stylesheet">
        
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
                    <h2 class="title"><?php echo 1*date('d',time()).date('S M, Y',time()); ?></h2> 
                </div>

<?php if ($login == 1 ){?>


                
<div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="widget-panel widget-style-2 white-bg">
                            <h2 class="m-0 counter"><?php echo ($lsd) ?></h2>
                            <div>Last 7 days' hours</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="widget-panel widget-style-2 white-bg">
                            <h2 class="m-0 counter"><?php echo ($ht) ?></h2>
                            <div>Hours tought</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="widget-panel widget-style-2 white-bg">
                            <h2 class="m-0 counter"><?php echo ($stut) ?></h2>
                            <div>Students Teaching</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="widget-panel widget-style-2 white-bg">
                            <h2 class="m-0 counter"><?php echo ($pyc) ?></h2>
                            <div>Payment Collected</div>
                        </div>
                    </div>
                </div> <!-- end row -->
    <div class="row">
  <div id='calendar' class="col-xs-12"></div>
</div><br>
<br>


                 <!-- End row -->



                <div class="row">
                     <!-- end col -->


                                               
                                           

                    
                </div> <!-- End row -->

 <?php }else{ ?>
            
			<div class="row">
				
				<div >
					<h3>School Vault</h3>
					<p>Closing the gap between parents and teachers</p>
				</div>
	</div>
	
         
            <?php }?>
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
  


      <?php  
	  get_end_script();
	  ?>
      
            
         <script src="assets/fullcalendar/moment.min.js"></script>
        <script src="assets/fullcalendar/fullcalendar.min.js"></script>
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
				$days = ['mon','tue','wed','thurs','fri','sat','sun'];
				$daysrel =['mon'=>1,'tue'=>2,'wed'=>3,'thurs'=>4,'fri'=>5,'sat'=>6,'sun'=>0];
foreach($days as $day){
	$getstus = "SELECT * FROM tut_students where st_valid =1 and st_rel_lum_id = ".$_SESSION['SCHVB_USR_DB_ID']." and st_day_".$day." > 0";
	$getstus = $conn->query($getstus);
	
	if ($getstus->num_rows > 0) {
	// output data of each row
	$days = array();
		while($stus = $getstus->fetch_assoc()) {
		?>{
			  title:"<?php echo $stus['st_name'] ?>",
			  url:"<?php echo 'amun.php?sti='.md5(sha1($stus['st_id'].'HGYURBVFRBRGWIOGRU92UWHFGOIWHTOGIUEO8HG384IWGOIRHWGIUHREJFGKN')); ?>",
			  start: '<?php echo $stus['st_day_'.$day.'_from']; ?>', // a start time (10am in this example)
			  end: '<?php echo $stus['st_day_'.$day.'_till']; ?>', // an end time (6pm in this example)
		
			  dow: [ <?php echo $daysrel[$day]; ?> ] // Repeat monday and thursday
		  },<?php
		}	
	}
}
				
?>]
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

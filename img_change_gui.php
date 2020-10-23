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
        <link rel="stylesheet" type="text/css" href="assets/select2/select2.css" />
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
      <h4>Image Updation Panel</h4>
      <hr>
                  <form action="master_action.php" method="post" enctype="multipart/form-data">

      <div class="row">
      <div class="col-md-5" style="padding:20px">        
<select id="change" style="width:100%" name="pr_id">
<?php
$sql = "SELECT * FROM `sw_products_raw` where pr_valid =1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		?>
        <option value="<?php echo $row['pr_id']; ?>"><?php echo $row['pr_code'].'-'.$row['pr_name']; ?></option>
        <?php
    }
} else {

}
?>
        </select>
</div>
      <div class="col-md-4" style="padding:20px">
      
	<div class="imgcoming"></div>
        <br>
<input type="file" accept="image/*" name="ch_image"/>

      </div>
      
      
      <div class="col-md-3" style="padding:20px">
<input class="btn btn-success" type="submit" name="img_change_new" value="Change Image" />
      </div>
      
      

      </div>
      </form>
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


<?php  
	  get_end_script();
	  ?>
                <script type="text/javascript" src="assets/select2/select2.min.js"></script>
                <script>
				$('#change').select2({
  placeholder: 'Select an option',
  width: 'resolve'
});
				</script>
                <script>
				$('#change').on("change", function(e) { 
   // what you would like to happen
   

$.ajax({
    type: 'POST',
    // make sure you respect the same origin policy with this url:
    // http://en.wikipedia.org/wiki/Same_origin_policy
    url: 'master_action.php',
    data: { 
        'fetch_image_id': $("#change").val()
    },
    success: function(msg){
        $(".imgcoming").html("<img class='img-responsive' width='250px' src='" + msg + "' />");
    }
});

});
				</script>
</body>
</html>

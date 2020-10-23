<?php 

include('db_auth.php');
?>



<?php
if(isset($_SESSION['SCHVB_SESS_ID'])){
$login=1;
header('Location: home.php');
}else{
	$login=0;
	
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

<?php get_head(); ?>
        <link href="assets/timepicker/bootstrap-timepicker.min.css" rel="stylesheet" />
        <link href="assets/timepicker/bootstrap-datepicker.min.css" rel="stylesheet" />

                 </head>


    <body>

       
        <div class="wrapper-page animated fadeInDown">
            <div class="panel panel-color panel-primary">
                <div class="panel-heading"> 
                   <h3 class="text-center m-t-10">Add Listing of your School</h3>
                </div> 

                <form class="form-horizontal m-t-40" action="master_action.php" method="post">
            	    <div class="form-group ">
                        <div class="col-xs-12">
                            <input name="usr_nm" class="form-control " type="text" required placeholder="Full Name">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input name="usr_eml" class="form-control" type="email" required placeholder="Email">
                        </div>
                    </div>
                
                  
                    
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input name="usr_pass" class="form-control " type="password" required 
                            placeholder="Password">
                        </div>
                    </div>

                                <input type="hidden" value="90" name="ok">
                    
                    <div class="form-group text-right">
                        <div class="col-xs-12">
                            <button class="btn btn-purple w-md" type="submit">Register</button>
                        </div>
                    </div>

                    <div class="form-group m-t-30">
                        <div class="col-sm-12 text-center">
                            <a href="login.php">Already have account?</a>
                        </div>
                    </div>
                </form>                                  
                
            </div>
        </div>

        
      <?php  
	  get_end_script();
	  ?>
              <script src="assets/timepicker/bootstrap-datepicker.js"></script>

      <script>

            $(document).ready(function() {
                    
        
                $('#datepicker').datepicker({
    
});
				
				

			});
			
      </script>
           <!--form validation-->
        <script type="text/javascript" src="assets/jquery.validate/jquery.validate.min.js"></script>

        <!--form validation init-->
        <script src="assets/jquery.validate/form-validation-init.js"></script>
      
    </body>

</html>

<?php
session_start();

if(isset($_SESSION['SESS_IIID'])){
	if($_SESSION['SESS_IIID'] == 'I4'){
	header('Location: home.php');
	}
}else{
	session_destroy();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Stilewell admin panel">
        <meta name="author" content="Ayan Ahmad">

        <link rel="shortcut icon" href="img/favicon_1.ico">

        <title>Stilewell - Admin Dashboard Login</title>

        


        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-reset.css" rel="stylesheet">

        <!--Animation css-->
        <link href="css/animate.css" rel="stylesheet">

        <!--Icon-fonts css-->
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/ionicon/css/ionicons.min.css" rel="stylesheet" />

        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="assets/morris/morris.css">


        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/helper.css" rel="stylesheet">
        


    </head>


    <body>

        <div class="wrapper-page animated fadeInDown">
            <div class="panel panel-color panel-primary">
                <div class="panel-heading"> 
                   <h3 class="text-center m-t-10"> Sign In to <strong>StileWell Backend panel</strong> </h3>


                </div> 

                <form class="form-horizontal m-t-40" method="post" action="login_action.php">
                                      <?php 
if(isset($_GET['error'])){
echo '<p style="color:red" align="center">Wrong Username or Password</p>';
}
?>      
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input <?php if(isset($_GET['error'])){echo 'style="border:red 1px solid" ';} ?> class="form-control" name="usr_nm" type="text" placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input <?php if(isset($_GET['error'])){echo 'style="border:red 1px solid" ';} ?> class="form-control" name="pw" type="password" placeholder="Password">
                        </div>
                    </div>

                    <div class="form-group text-right">
                        <div class="col-xs-12">
                            <button class="btn btn-purple w-md" type="submit">Log In</button>
                        </div>
                    </div>
                    
                    <div class="form-group m-t-30">
                        <div class="col-sm-7">
                            <a href="recover.php?pass"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    


        <!-- js placed at the end of the document so the pages load faster -->
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/pace.min.js"></script>
        <script src="js/wow.min.js"></script>
        <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
            

        <!--common script for all pages-->
        <script src="js/jquery.app.js"></script>

    
    </body>

</html>

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
<link href="newupdates/css/webfonts/styles.css" type="text/css" rel="stylesheet" />
<link href="newupdates/css/webfonts/WEBFONT2/styles.css" type="text/css" rel="stylesheet" />
                 </head>


    <body>
    
    
    <div class="row visible-md visible-lg" style="height:100vh;">
        <div class="col-xs-6 text-center" style="background-color: #FFFFFF; color: #000000; height:100%; text-align:center">
            <strong style="font-size:10em; font-family:SilentReaction; top:40%; bottom:60%; position:inherit ">Stile Well</strong>
        </div>
        <div class="col-xs-6 text-center" style="background-color: #000000; color: #FFFFFF; height:100%; text-align:center">
            <div class="row" style=" height:100%; margin-right:10px; margin-left:0">
            	<div class="col-xs-12" style=" height:100%; top:30%;">
            <strong style="font-size:4em; font-family:BebasNeue; ">Stile Well SMS Login</strong>
                            <form class="text-middle form-horizontal m-t-40 " action="master_action.php" method="post">
                                                                 <?php 
if(isset($_GET['notss'])){
echo '<p style="color:red" align="center">No Match Found</p>';
}
?>                       
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control input-lg" required <?php if(isset($_GET['notss'])){echo 'style="border:red 1px solid" ';} ?> name="lo_eml" class="form-control" type="text" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group ">
                        
                        <div class="col-xs-12">
                            <input class="form-control input-lg" required <?php if(isset($_GET['notss'])){echo 'style="border:red 1px solid" ';} ?> name="lo_pass" class="form-control" type="password" placeholder="Password">
                        </div>
                    </div>
                    
                    <div class="form-group text-middle">
                        <div class="col-xs-12">
                            <button style="color: rgba(0,0,0,1.00);font-family:BebasNeue; " class="btn btn-white btn-lg" type="submit">Log In</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>

            
        </div>
    </div>
    
    
    
    
    <div class="row visible-sm visible-xs" style="height:100vh;">
            <div class="wrapper-page animated fadeInDown">
            <div class="panel panel-color panel-primary">
                <div class="panel-heading"> 
                   <h3 class="text-center m-t-10"> Sign In to <strong>StileWell Panel</strong> </h3>
                </div> 

                <form class="form-horizontal m-t-40" action="master_action.php" method="post">
                                                                 <?php 
if(isset($_GET['notss'])){
echo '<p style="color:red" align="center">No Match Found</p>';
}
?>                       
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input required <?php if(isset($_GET['notss'])){echo 'style="border:red 1px solid" ';} ?> name="lo_eml" class="form-control" type="text" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group ">
                        
                        <div class="col-xs-12">
                            <input required <?php if(isset($_GET['notss'])){echo 'style="border:red 1px solid" ';} ?> name="lo_pass" class="form-control" type="password" placeholder="Password">
                        </div>
                    </div>
                    
                    <div class="form-group text-right">
                        <div class="col-xs-12">
                            <button class="btn btn-purple w-md" type="submit">Log In</button>
                        </div>
                    </div>
                    <div class="form-group m-t-30">
                        <div class="col-sm-7">
                            <a href="recover.php"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>


    

  <?php  
	  get_end_script();
	  ?>
    
    </body>

<!-- the manlogin.htmlby ayan ahmad 07:31:29 GMT -->
</html>

<?php
if(strpos($_SERVER['PHP_SELF'],'ifloginmodalsection.php')){
	header('Location: ifloginmodelsection.php');
}
?> <ul class="nav navbar-nav navbar-right top-menu top-right-menu">  
                                               <!-- user login dropdown start-->
                                               
                        <li class="dropdown text-center">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <img alt="<?php echo $_USER[$touse.'_name'].' prof_pic' ?>" src="<?php echo $_USER[$touse.'_prof_pic'] ?>" class="img-circle profile-img thumb-sm">
                                <span class="username"><?php echo ucwords($_USER[$touse.'_name']) ?> </span> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu pro-menu fadeInUp animated" tabindex="5003" style="overflow: hidden; outline: none;">

                           <?php
						   if($_SESSION['SCHVB_USR_TU_ID'] == 1){
echo '                                <li><a href="myca.php"><i class="fa fa-briefcase"></i>Admin-My Account</a></li>
';							   
						   }else if(($_SESSION['SCHVB_USR_TU_ID'] == 2) or ($_SESSION['SCHVB_USR_TU_ID'] == 3)){
echo '                                <li><a href="myca.php"><i class="fa fa-briefcase"></i>My Account</a></li>
';							   

						   }else{
echo ' <hr>';							   

						   }
						   ?>

                   <li><a href="logout.php"><i class="fa fa-sign-out"></i> Log Out</a></li>
                            </ul>
                        </li>
                        <!-- user login dropdown end -->       
                    </ul>
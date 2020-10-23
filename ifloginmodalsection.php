<?php
if(strpos($_SERVER['PHP_SELF'],'ifloginmodalsection.php')){
	header('Location: ifloginmodelsection.php');
}
include_once('include.php');
?> <ul class="nav navbar-nav navbar-right top-menu top-right-menu">  
                                               <!-- user login dropdown start-->
                                               <?php
											   
											   
											   ?>
                        <li>
                            <a href="sw_pending_payments.php">
                                <i class="fa fa-money "></i>
                            </a>
                        </li>
                                               
                        <li class="dropdown text-center">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <img alt="<?php echo $_USER['usr_fname'].' prof_pic' ?>" src="<?php echo $_USER['usr_prof_pic'] ?>" class="img-circle profile-img thumb-sm">
                                <span class="username"><?php echo ucwords($_USER['usr_fname']) ?> </span> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu pro-menu fadeInUp animated" tabindex="5003" style="overflow: hidden; outline: none;">
                   <li><a href="logout.php"><i class="fa fa-sign-out"></i> Log Out</a></li>
                            </ul>
                        </li>
                        <!-- user login dropdown end -->       
                    </ul>
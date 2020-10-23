

<?php 
  include('db_auth.php');
  ?>
  <?php 
  if($_SESSION['SW_U_ACCESS'] < 5){
die("Access denied");	  
  }
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php 
      get_head();
      ?>
  </head>
  <body>
    <!-- Aside Start-->
    <aside class="left-panel">
      <?php 
        give_brand();
        ?> 
      <?php 
        get_modules($conn);
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
          <ul class="nav navbar-nav navbar-right top-menu top-right-menu">
            <!-- user login dropdown start-->
            <li class="dropdown text-center">
              <a data-toggle="dropdown" class="dropdown-toggle" href="#">
              <img alt=""  class="img-circle profile-img thumb-sm">
              <span class="username"><?php echo ucwords($_SESSION['SW_PREFIX_NAME']).'. '.ucwords($_SESSION['SW_U_F_NAME']) ?> </span> <span class="caret"></span>
              </a>
              <ul class="dropdown-menu pro-menu fadeInUp animated" tabindex="5003" style="overflow: hidden; outline: none;">
                <li><a href="logout.php"><i class="fa fa-sign-out"></i> Log Out</a></li>
              </ul>
            </li>
            <!-- user login dropdown end -->       
          </ul>
          <!-- End right navbar -->
        </nav>
      </header>
      <!-- Header Ends -->
      <!-- Page Content Start -->
      <!-- ================== -->
<div class="wraper container-fluid">
	<div class="row">
		<div class="col-lg-12	">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Users</h3>
				</div>
                <div class="panel-body">
	                <div class="row">
                		<div class="col-md-12 col-sm-12 col-xs-12">
							<form action="sub_action_add.php" method="post">
								<div class="panel-body"> 
									<div class="table-responsive" >
                                        <table id="tech-companies-1" class="table table-small-font table-bordered table-striped">
	                                        <thead>
                        <tr>
                          <th>#</th>
                          <th>Username</th>
                          <th>Password</th>
                          <th> Prefix</th>
                          <th>First name</th>
                          <th>Last Name</th>
                          <th>DOB</th>
                          <th>Access Level</th>
                          <th>Contact Number </th>
                          <th>Email</th>
                          <th>Valid Till</th>
                          <th>Status</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $usr_sql = "SELECT * FROM sw_usrs_inf";
                          $usr_res = $conn->query($usr_sql);
                          if ($usr_res->num_rows > 0) {
                            // output data of each row
                            $con = 1;
                            while($usrrw= $usr_res->fetch_assoc()) {
                              echo '<tr>';
                              echo '
<td>'.$con.'</td>
<td>'.$usrrw['sw_username'].'</td>
<td class="pw_edit" id="'.md5(sha1(md5(sha1(sha1(sha1($usrrw['sw_u_id'])))))).'">'.$usrrw['sw_pass_words'].'</td>
<td>'.ucwords($usrrw['sw_prefix_name']).'</td>
<td>'.ucwords($usrrw['sw_u_f_name']).'</td>
<td>'.ucwords($usrrw['sw_u_l_name']).'</td>
<td>'.$usrrw['sw_u_dob'].'</td>
<td>'.$usrrw['sw_u_access'].'</td>
<td>'.$usrrw['sw_contc_no'].'</td>
<td>'.$usrrw['sw_email'].'</td>';

if($usrrw['sw_validtill'] ==0){
	echo '<td>Never Expires</td>';
}else{
	echo '<td>'.date('d M Y @ H:i:s',$usrrw['sw_validtill']).'</td>';
}

if($usrrw['sw_valid'] ==1){
	echo '<td><i class="ion-ionic" style="color:green"></i></td>';
}else{
	echo '<td><i class="ion-ionic" style="color:red"></i></td>';
}
                            echo '</tr>';
                              $con++;
                            }
                          }
                          else {
                            echo "0 results";
                          }
						  echo '
<tr>
<td>+1</td>
<td><input class="" type="text" name="usr_usrnme" placeholder="Username"/></td>
<td><input type="text" name="usr_pw"  placeholder="Password" /></td>
<td><input type="text" name="usr_prefix"  placeholder="Name Prefix"  /></td>
<td><input type="text" name="usr_fname"   placeholder="First name" /></td>
<td><input type="text" name="usr_lname"   placeholder="Last Name" /></td>
<td><input type="text" name="usr_dob"  data-mask="99-99-9999"   placeholder="Dob" /></td>
<td><input type="text" name="usr_acclvl" max="5" min="1"    placeholder="Access Level 1-5" /></td>
<td><input type="text" name="usr_contcno" data-mask="(999) 999-9999-999"   placeholder="Contact Number"  /></td>
<td><input type="text" name="usr_email"   placeholder="email"  /></td>
<td><input type="number" name="usr_valid_t" value="0"   placeholder="In minutes(from now)"  /></td>
<td><i class="ion-ionic" style="color:green"></i></td>
</tr>
						  ';
                          ?>
                      </tbody>
                    </table>
                    
                  </div>
                </div>
                <input name="add_user" type="submit" class="col-sm-12 btn  btn-success" value="Add User" />
                    						  </form>

              </div>
            </div>
          </div>
          <!-- end col -->
        </div>
        <!-- End row -->
      </div>
      </div>
      </div>
      
      <!-- Page Content Ends -->
      <!-- ================== -->
      <footer class="footer">
        Admin StileWell
      </footer>
      <!-- Footer Ends -->
    </section>
    <!-- Main Content Ends -->
    <?php 
      get_end_script();
      ?>
      
      <script>
$(document).ready(function() {
	$(".pw_edit").editable("master_action.php", { 
			id: 'pw_edd',
			name : 'val_edd',
			
		  tooltip   : "Doubleclick to edit...",
		  event     : "dblclick",
		  style  : "inherit"
		  	});
});
 

</script>       
              <script src="assets/bootstrap-inputmask/bootstrap-inputmask.min.js" type="text/javascript"></script>

	  <script src="assets/responsive-table/rwd-table.min.js" type="text/javascript"></script>

  </body>
</html>


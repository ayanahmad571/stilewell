<?php
if(include('include.php')){
}else{
die('##errMASTERofUSErERROR');
}


if(isset($_GET['id']) and ctype_alnum($_GET['id'])){
	$sql = "SELECT * FROM `sw_deliveryorders_gen` g
left join sw_deliveryorders q on g.`dog_rel_do_id` = q.do_id
left join sw_currency c on q.do_rel_cur_id = c.cur_id
left join sw_clients ci on q.do_rel_cli_id = ci.cli_id

where md5(g.`dog_id`)= '".$_GET['id']."' and g.dog_valid = 1 and q.do_valid =1 and ci.cli_valid =1  ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		?>




<!DOCTYPE html>
<html lang="en" >
    
<!-- the maninvoice.htmlby ayan ahmad 07:31:27 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="shortcut icon" href="img/logo.jpg">

        <title>Stilewell Deliver Invoice Print View</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-reset.css" rel="stylesheet">

        <!--Animation css-->
        <link href="css/animate.css" rel="stylesheet">

        <!--Icon-fonts css-->
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/ionicon/css/ionicons.min.css" rel="stylesheet" />


        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/helper.css" rel="stylesheet">
        

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
   <style>
   

   hr {
	   color:#000;
	   border-color:#000;
   }
   td {
	   padding:6px !important;
   }
   </style>

    </head>


    <body style="font-size:12px; height:920px">

            <div >

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <!-- <div class="panel-heading">
                                <h4>Invoice</h4>
                            </div> -->
                            <div class="panel-body">
                                <div class="clearfix">
                                    <div class="pull-left">
                                        <h4 class="text-right"><img width="120px" src="<?php echo $stwl['img'] ?>" alt="StileWell General Trading LLC"></h4>
                                        
                                    </div>
                                    <div style="margin-left:10px" class="pull-right">
                                        <h5 align="right"><br>
                                            <strong><?php echo $stwl['addrarab'] ?> </strong>
                                        </h5>
                                    </div>
                                    <div class="pull-right">
                                        <h5 align="right"><br>
                                            <strong><?php echo $stwl['addr'] ?></strong>
                                        </h5>
                                    </div>
                                </div>
                                <hr>
                                <h4 align="center">
                                DELIVERY ORDER أمر التسليم
                                </h4>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        
                                        <div class="pull-left">
                                            <address>
                                              <strong><?php echo $row['cli_name'] ?></strong><br>
                                              
                                             <?php echo $row['dog_address'] ?>
                                              </address>
                                    <p><strong>Project: </strong> <?php echo $row['do_proj_name'] ?></p>
                                    <p class="m-t-10"><strong>Subject: </strong> <?php echo $row['do_subj'] ?></p>
                                    <p class="m-t-10"><?php echo $row['dog_extra'] ?></p>
                                        </div>
                                        <div class="pull-right">
                                            <p><strong>Date: </strong> <?php echo date('j/n/Y',$row['dog_dnt']) ?></p>
                                            <p class="m-t-10"><strong>D/O Number: </strong> <?php echo $row['do_ref'] ?></p>
                                            <p class="m-t-10"><strong>Payment Terms: </strong> <?php echo $row['dog_payment_terms'] ?></p>
                                            <p class="m-t-10"><strong>LPO Reference: </strong> <?php echo $row['dog_lpo'] ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr><th>#</th>
                                                    <th>Item Name</th>
                                                    <th>Item Desc</th>
                                                    <th>Quantity</th>
                                                    <th>Unit</th>
                                                </tr></thead>
                                                <tbody>
                                                
                                                <?php 
												
												
$productssql = "SELECT * from sw_deliveryorders_items i
left join sw_products_list p on i.di_rel_pr_id = p.pr_id
left join sw_prod_types t on p.pr_rel_prty_id = t.prty_id
where di_valid =1 and p.pr_valid = 1 and t.prty_valid =1 and di_rel_do_id = ".$row['do_id'];
$productsresult = $conn->query($productssql);

if ($productsresult->num_rows > 0) {
    // output data of each row
	$c = 1;
	$total = 0;
    while($productrow = $productsresult->fetch_assoc()) {
		$qty = ($productrow['di_qty'] * $productrow['prty_conv_formula']);

?>
                <tr>
                    <td><?php echo $c; ?></td>
                    <td><?php echo $productrow['pr_name']; ?></td>
                    <td><?php echo $productrow['di_desc']; ?></td>
                    <td><?php echo $qty; ?></td>
                    <td><?php echo $productrow['prty_conv_unit']; ?></td>
                </tr>
<?php
  $c++;  }
} else {
    echo "0 results";
}
?>


        

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                            <p><?php echo $row['dog_footer']; ?></p>
                                </div>

                                <div class="row">
                                    <p align="center">
                                            <strong>GOODS RECIEVED IN GOOD CONDITION</strong>
                                    </p>
                                </div>
                                <div style="border:solid black 1px" class="row">
									<div class="col-xs-4 pull-left">
<br>
<br>
<br>
<br>
                                    	<p class="pull-left">____________________________________</p><br>
                                        <p class="pull-left">For Client</p>
                                    </div>
                                    <div class="col-xs-4"><br>
<br>

                                    <p align="center">AUTH SIGNATORY</p>
                                    </div>
									<div class="col-xs-4 pull-right">
<br>
<br>
<br>
<br>
                                    	<p class="pull-right">_________________________________</p><br>
                                        <p class="pull-right">For Stile well General Trading LLC</p>
                                    </div>
                                </div>
                                <div class="hidden-print">
                                    <div class="pull-right">
                                        <a onClick="window.print()" href="#" class="btn btn-inverse"><i class="fa fa-print"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>


    </body>

<!-- the maninvoice.htmlby ayan ahmad 07:31:28 GMT -->
</html>
        <?php
    }
} else {
    echo "0 results";
}
}else{
	die('Give Id');
}

?>
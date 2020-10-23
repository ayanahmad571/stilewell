<?php
ob_start();
require_once('tcpdf/tcpdf.php');
require_once('include.php');

if(isset($_GET['id']) and ctype_alnum($_GET['id'])){
		$sql = "SELECT * FROM `sw_quotes_gen` g
left join sw_quotes q on g.`qog_rel_qo_id` = q.qo_revision_id
left join sw_currency c on q.qo_rel_cur_id = c.cur_id
left join sw_clients ci on q.qo_rel_cli_id = ci.cli_id

where md5(g.`qog_id`)= '".$_GET['id']."' and g.qog_valid = 1 and q.qo_valid =1 and ci.cli_valid =1 order by qo_revision desc limit 1  ";
$row = getdatafromsql($conn,$sql);

		

		$getdateofbase = getdatafromsql($conn, "select * from sw_quotes where qo_id = ".$row['qo_revision_id']." and qo_valid =1");
		if(!is_array($getdateofbase)){
			die('Base of this not found');
		}
		
}else{
	die("Give Valdi ID");
}
if($row['po_cancel'] == 1){
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		// Set font
		$this->SetFont('helvetica', 'B', 15);
		// Title
		$this->Cell(0, 15, 'Stilewell - VOID', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$this->SetFont('helvetica', 'B', 5);
		$this->WriteHtml('<h2><strong>GSTIN</strong>: 09AFHPS1459R1ZI</h2>');
		$this->SetFont('helvetica',  '', 5);
		$this->WriteHtml('<h2 align="center"></h2>');
		$this->SetFont('helvetica', '', 5);
		$this->WriteHtml('<h2 align="center"> Ghair Mardan Khan, Rampur UP 244901, State Code: 09 Tel: 9997380560</h2>');
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font	
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

}else{
	// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		// Set font
		$this->SetFont('helvetica', 'B', 15);
		// Title
		$this->Cell(0, 15, 'Stilewell', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$this->SetFont('helvetica', 'B', 5);
		$this->WriteHtml('<h2><strong>GSTIN</strong>: 09AFHPS1459R1ZI</h2>');
		$this->SetFont('helvetica', '', 5);
		$this->WriteHtml('<h2 align="center"> Manufacturer & Supplier of Corrugated Boxes (Packing Materials)</h2>');
		$this->SetFont('helvetica', '', 5);
		$this->WriteHtml('<h2 align="center"> Ghair Mardan Khan, Rampur UP 244901, State Code: 09 Tel: 9997380560</h2>');
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font	
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}
}
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Administrator');
$pdf->SetTitle($row['cli_name'].' - '.$row['po_ref']);
$pdf->SetSubject('Invoice Print');
$pdf->SetKeywords('Invoice Classic Industries');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(5, PDF_MARGIN_TOP, 5);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 8.5);

// add a page
$pdf->AddPage();

// set some text to print



if(1==1){

if (is_array($row)) {
    // output data of each row
		
		
		
$print =array('ORIGINAL / TRANSPORT / SUPPLIER'); 
foreach($print as $akjd){



/*$csss = array('css/bootstrap.min.css','css/bootstrap-reset.css','css/helper.css','css/style.css');
foreach($csss as $css){
	$txt.= file_get_contents($css);
}
*/
$txt='        
   <style type="text/css">
   table td {
	   padding:10px !important;
   }
</style>
    
                        <div style="background-color:white" >
                        
                            <div class="panel-body">
';




$txt .= '


<table cellpadding="3" border="1">
                                             
    <thead>
        <tr>
            <td colspan="2" ><strong>Invoice Number</strong>: &nbsp;&nbsp;'. $row['qo_ref'].'</td>
            <td colspan="2" ><strong>Invoice Date.</strong>:&nbsp;&nbsp;'. date('d-m-Y',$row['po_dnt']).'</td>

            <td colspan="2"><strong>Transportation Mode</strong>:&nbsp;&nbsp;'. $row['po_transport'].'</td>
            <td colspan="2"><strong>Vehicle No.</strong>:&nbsp;&nbsp;'. $row['po_vehicle'].'</td>
        </tr>

    </thead>
        <tbody>

        <tr>
        
            <td colspan="2"><strong>Reverse Charge</strong>:&nbsp;&nbsp;'. ($row['po_reverse_charge'] == '1' ? 'No' : 'Yes').'</td>
            <td colspan="2"><strong>Order Ref</strong>:&nbsp;&nbsp;'. $row['po_lpo'].'</td>
            
            <td colspan="4" ><strong>Date and Place of Supply</strong>:&nbsp;&nbsp;'. $row['po_dapos'] .'</td>
        </tr>
        <tr>
			<td colspan="4" style=" text-align:centre"><strong>Details of Reciever/ Billed to</strong></td>
			<td colspan="4" style=" text-align:centre"><strong>Details of Consignee/ Shipped to</strong></td>
        </tr>
        <tr>
            <td colspan="4" ><strong>Name</strong>:&nbsp;&nbsp;'. $row['po_bill_to_name'].'</td>
            
            <td colspan="4"  ><strong>Name</strong>:&nbsp;&nbsp;'. $row['po_ship_to_name'].'</td>
        </tr>
        <tr>
            <td colspan="4" ><strong>Address </strong>:&nbsp;&nbsp;'. $row['po_bill_to_addr1'].'</td>
            
            <td colspan="4" ><strong>Address </strong>:&nbsp;&nbsp;'. $row['po_ship_to_addr1'].'</td>
        </tr>
        <tr>
            <td colspan="4" >'. $row['po_bill_to_addr2'].'</td>
            <td colspan="4" >'. $row['po_ship_to_addr2'].'</td>
        </tr>
        <tr>
            <td colspan="2" >'. $row['po_bill_to_addr3'].'</td>
            <td  colspan="2"><strong>State</strong>:&nbsp;&nbsp;'. $row['po_bill_to_state'].'</td>

            <td colspan="2" >'. $row['po_ship_to_addr3'].'</td>
            <td colspan="2" ><strong>State</strong>:&nbsp;&nbsp;'. $row['po_ship_to_state'].'</td>

        </tr>
        <tr>
            <td colspan="2" ><strong>GSTIN</strong>:</td>
            <td colspan="2" >'. $row['po_bill_to_gstin'].'</td>
            <td colspan="2" ><strong>GSTIN</strong>:</td>
            <td colspan="2" >'. $row['po_ship_to_gstin'].'</td>
        </tr>
    </tbody>
</table>';
$txt .='
<br><hr>
<table cellpadding="4" border="1">
    <thead>
        <tr>
        <th style="text-align:centre"><strong>#</strong></th>
        <th colspan="3" style="text-align:centre"><strong>Item</strong></th>
        <th style="text-align:centre"><strong>HSN</strong></th>
        <th style="text-align:centre"><strong>Qty</strong></th>
        <th style="text-align:centre"><strong>Rate</strong></th>
        <th style="text-align:centre"><strong>Total</strong></th>
    </tr></thead>
    <tbody>';
                                                
												
												
$productssql = "SELECT * from sw_proformas_items i
left join sw_products_list p on i.pi_rel_pr_id = p.pr_id
where pi_valid =1  and pi_rel_po_id = ".$row['po_id'];
$productsresult = $conn->query($productssql);

if ($productsresult->num_rows > 0) {
    // output data of each row
	$c = 1;
	$total = 0;
    while($productrow = $productsresult->fetch_assoc()) {
		$qty = ($productrow['pi_qty']);
		$price = ($productrow['pi_price']);
		$itotal = round(($qty * $price),2);
$txt .= '
                <tr>
                    <td style="text-align:centre">'. $c .'</td>
                    <td style="" colspan="3">'. $productrow['pr_code'].'-'.$productrow['pr_name'] .' '. ($productrow['pi_desc'] == '-' ? '' : $productrow['pi_desc']).'</td>
                    <td style="text-align:center">'. $productrow['pi_hsn_code'].'</td>
                    <td style="text-align:right">'. 1*((int)$qty) .' </td>
                    <td style="text-align:right">'. number_format($price,2) .'</td>
                    <td style="text-align:right">'. number_format($itotal,2) .'</td>
                </tr>
                
';
$total = $itotal + $total;
  $c++;  }
} else {
    $txt .= "<tr><td colspan='7'>No Items</td></tr>";
}

$txt .= '</tbody></table>';

$total = $total;
/*		
if($row['pog_discount'] == 0){
	$discount = 0;
}else{
	$discount = round($row['pog_discount'],2);
	echo '<tr><td colspan="7"><p class="text-right"><strong>Discount :</strong> '.$row['cur_name'].' '.number_format($discount,2).'</p></td></tr>';
	
}
*/

$igstp = $row['po_igst'];
$cgstp = $row['po_cgst'] ;
$sgstp = $row['po_sgst'];
		
$igst = $igstp * $total * 0.01;
$cgst = $cgstp * $total * 0.01;
$sgst = $sgstp * $total * 0.01;
/*if($row['pog_vat'] == 0){
	$vat = 0;
}else{
	$vat = round((($row['pog_vat']/100) * $total),2);
	echo '<tr><td colspan="7"><p class="text-right"><strong>Vat ('.$row['pog_vat'].'%):</strong> '.$row['cur_name'].' '.number_format($vat,2).'</p></td></tr>';
	
}
*/
$txt .='  <br><hr>
<table border="1">
    <tbody >
	
	<tr>
	<td colspan="4">
	<strong>Total Amount in Words:</strong><br><u>'. 
		'Rs. '.strtoupper(getIndianCurrency(round((($total + $igst  + $cgst + $sgst )),2)))
		.'</u><br><br>
Bank Details:<br>
        Bank A/C: 066905001908 <br>
		Bank IFSC Code: ICIC0000669
<br>

	</td>
	<td style="text-align:right" colspan="2">
	<strong>Total Before Tax</strong>:'. ' '.number_format(($total),2) .'<br>
	<strong>CGST '. $cgstp .'%</strong>:'. ' '.number_format(($cgst),2) .'<br>
	<strong>SGST '. $sgstp .'%</strong>: '. ' '.number_format(($sgst),2).'<br>
	<strong>IGST '. $igstp .'%</strong>: '. ' '.number_format(($igst),2).'<br>
	<strong>Total Tax</strong>: '.number_format((( $igst  + $cgst + $sgst )),2).'<br>
	<strong>Grand Total</strong>: <u>'.'Rs. '.number_format((($total + $igst  + $cgst + $sgst )),2).'</u>

	</td>
	</tr>
	
	

<tr>
	    <td colspan="3" style="font-size:9px !important; text-align:left">
        	1. All disputes to be subject of Rampur Jurisdiction only<br>
            2. Goods once sold will not be replaced or taken back<br>
            3. An Interest @ 24% will be charged after 7 days<br>
			4. Certified that the particulars given are true and correct
		</td>
        <td colspan="3" style="text-align:center">
			For <strong>'.  $_COMPANY['cp_name'].'</strong>
<br><br><br>AUTH SIGNATORY
		</td>
</tr>

                                                </tbody>
                                            </table>
                            </div>
                        </div>
';
}
    }
 else {
    echo "0 results";
}
}else{
	die('Give Id');
}

ob_flush();
// print a block of text using Write()
$pdf->writeHTML($txt);

//Close and output PDF document
$pdf->Output('invoice.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>
<?php
if(include('include.php')){
}else{
die('##errMASTERofUSErERROR');
}


if(isset($_GET['id']) and ctype_alnum($_GET['id'])){
	$sql = "SELECT * FROM `sw_quotes_gen` g
left join sw_quotes q on g.`qog_rel_qo_id` = q.qo_revision_id
left join sw_currency c on q.qo_rel_cur_id = c.cur_id
left join sw_clients ci on q.qo_rel_cli_id = ci.cli_id

where md5(g.`qog_id`)= '".$_GET['id']."' and g.qog_valid = 1 and q.qo_valid =1 and ci.cli_valid =1 order by qo_revision desc limit 1 ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		

		$getdateofbase = getdatafromsql($conn, "select * from sw_quotes where qo_id = ".$row['qo_revision_id']." and qo_valid =1");
		if(!is_array($getdateofbase)){
			die('Base of this not found');
		}
		?>




<!DOCTYPE html>
<html lang="en">
    
<!-- the maninvoice.htmlby ayan ahmad 07:31:27 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="shortcut icon" href="img/logo.jpg">

        <title><?php echo $row['cli_name'].' - '.$row['qo_ref'] ?></title>

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
	   padding:3px !important;
   }
   </style>



    </head>


    <body style="font-size:14px">

            <div >

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <!-- <div class="panel-heading">
                                <h4>Invoice</h4>
                            </div> -->
                            <div class="panel-body">
                                <h4 align="center">
                                QUOTATION
                                </h4>
                                <hr>

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
                                <div class="row">
                                    <div class="col-md-12">
                                        
                                        <div class="pull-left m-t-30">
                                            <address>
                                              <strong><?php echo $row['cli_name'] ?></strong><br>
                                              
                                             <?php echo $row['qog_address'] ?>
                                              </address>
                                        </div>
                                        <div class="pull-right m-t-30">
                                            <p><strong>Date: </strong> <?php echo date('j/n/Y',$getdateofbase['qo_dnt']) ?><br>
                                            <strong>Quote REF: </strong> <?php echo $row['qo_ref'] ?><br>
                                            <strong>Currency: </strong> <?php echo $row['cur_name'] ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <p><strong>Project: </strong> <?php echo $row['qo_proj_name'] ?><br>
                                    <strong>Subject: </strong> <?php echo $row['qo_subj'] ?><br>
                                    &nbsp; <?php echo $row['qog_extra'] ?></p>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table m-t-30 table-bordered">
                                                <thead>
                                                    <tr><th>#</th>
                                                    <th>Item Image</th>
                                                    <th>Item Name</th>
                                                    <th>Quantity</th>
                                                    <th>Price(<?php echo $row['cur_name'] ?>)</th>
                                                    <th>Total(<?php echo $row['cur_name'] ?>)</th>
                                                </tr></thead>
                                                <tbody>
                                                
                                                <?php 
												
												
$productssql = "SELECT * from sw_quotes_items i
left join sw_products_list p on i.qi_rel_pr_id = p.pr_id
left join sw_prod_types t on p.pr_rel_prty_id = t.prty_id
where qi_valid =1 and p.pr_valid = 1 and t.prty_valid =1 and qi_rel_qo_id = ".$row['qo_id'];
$productsresult = $conn->query($productssql);

if ($productsresult->num_rows > 0) {
    // output data of each row
	$c = 1;
	$total = 0;
    while($productrow = $productsresult->fetch_assoc()) {
		if($productrow['prty_pr_hidden'] == '0'){		

		$qty = ($productrow['qi_qty'] * $productrow['prty_conv_formula']);
		$price = (((1/$productrow['prty_conv_formula']) * $productrow['qi_price']) * $row['qo_cur_rate']);
		
		$itotal = round(($qty * $price ),2);

?>
                <tr>
                    <td><?php echo $c; ?></td>
                    <td><?php echo '
					<img src="'.($productrow['qi_pr_main_img'] == '-' ? $productrow['pr_img'] : $productrow['qi_pr_main_img']).'" class="img-responsive" width="100px" />'; ?></td>
                    <td><?php echo $productrow['pr_name']; ?>
                    <br><?php echo convert_desc($productrow['qi_desc']); ?></td>
                    <td><?php echo $qty.' '.$productrow['prty_conv_unit']; ?></td>
                    <td><?php echo number_format(round($price,2),2); ?></td>
                    <td><?php echo number_format($itotal,2); ?></td>
                </tr>
                
                <?php 
				
				if(($productrow['qi_img_1'] == '0') and ($productrow['qi_img_2'] == '0') and ($productrow['qi_img_3'] == '0') and ($productrow['qi_img_4'] == '0') and ($productrow['qi_img_5'] == '0') ){
}else{
	$imageeco = 0;

for($i2 = 1; $i2 <6; $i2++){
	if($productrow['qi_img_'.$i2] !== '0'){ 
		 $imageeco = $imageeco + 1;
	 }
}

	echo '
<tr>
<td colspan="7">

<div style="">';

for($i = 1; $i <6; $i++){
	if($productrow['qi_img_'.$i] !== '0'){ ?>
<img src="<?php echo  $productrow['qi_img_'.$i] ?>" class="img-responsive pull-left m-r-15 " width="100px" />   &nbsp;&nbsp; 	
	 <?php 
	 }
}
echo '</div></td>';

echo '
	
	</tr>';
}

				
				?>
<?php
$total = $itotal + $total;
  $c++;  }
	}
} else {
    echo "0 results";
}



$total = $total;
?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
<div class="row" style="border-radius: 0px;">
    <div class="col-md-12 ">
        <p class="text-right"><b>Sub-total:</b> <?php echo $row['cur_name'].' '.number_format(($total),2) ?></p>
        
        <?php 
		
if($row['qog_discount'] == 0){
	$discount = 0;
}else{
	$discount = round($row['qog_discount'],2);
	echo '<strong><td colspan="6"><p class="text-right"><strong>Discount </strong>: '.$row['cur_name'].' '.number_format($discount,2).'</p></strong>';
	
}

		?>
		<?php 
		
if($row['qog_vat'] == 0){
	$vat = 0;
}else{
	$vat = round((($row['qog_vat']/100) * $total),2);
	echo '<strong><p class="text-right"><strong>Vat ('.$row['qog_vat'].'%)</strong>: '.$row['cur_name'].' '.number_format($vat,2).'</p></strong>';
	
}

		?>
        <?php
		$beforearray = explode('||||||||||.||||||||||',$row['qog_before_total']); 
		foreach($beforearray as $beforea){
			$before = explode('|=|=|=|=|=|',$beforea);
			
if(trim($before[0]) == '-'){
}else{
			echo '<strong><p class="text-right">'.$before[0].'</strong>: '.$before[1].'</p></strong>';
}

		}
		?>
        
<div class="row">
	<div class="col-xs-8">
        <h5 class="text-left"><?php echo $row['cur_name'].' '.strtoupper(convert_number_to_words(((($total + $vat  + $row['qog_extra_price']) -$discount)))).' ONLY'; ?></h5> 
    </div>
	<div class="col-xs-4">
    	<h5 class="text-right"><?php echo $row['cur_name'].' '.number_format((($total + $vat  + $row['qog_extra_price']) -$discount),2); ?></h5>
    </div>
</div>



               <?php
		$afterarray = explode('||||||||||.||||||||||',$row['qog_after_total']); 
		foreach($afterarray as $aftera){
			$after = explode('|=|=|=|=|=|',$aftera);
			
if(trim($after[0]) == '-'){
}else{
			echo '<strong><p class="text-right">'.$after[0].'</strong>: '.$after[1].'</p></strong>';
}

		}
		?>
    </div>
</div>
                                <div class="row">
                                    <p align="center">
                                            <p><?php echo $row['qog_footer']; ?></p>
                                    </p>
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
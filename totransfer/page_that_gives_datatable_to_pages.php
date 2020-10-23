<?php
include('include.php');
if(!isset($_SERVER['HTTP_REFERER'])){
	header('Location: page_that_gives_datatable_to_pagas.php');
}
?>
<?php

if(isset($_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID']) and trim($_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID']) != ''){
}else{
	die('Login to continue <a href="login.php">Login	</a>');
}
?>
<?php

if(isset($_REQUEST['school_id'])){

if(!is_numeric($_REQUEST['school_id'])){
	die('Invalid Id');
}
    $aColumns = array( 'st_name','st_adm_no', 'st_prof_pic', 'cls_numeric','st_father_name','st_mother_name','st_dob','st_gender','lum_pass_def',' ');
     
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "st_db_id";
     
    /* DB table to use */
    $sTable = "students_parents_info_rc";
     
     
    function fatal_error ( $sErrorMessage = '' )
    {
        header( $_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error' );
        die( $sErrorMessage );
    }
 
    /*
     * Paging
     */
    $sLimit = " limit 10";
    if ( isset( $_GET['start'] ) && $_GET['length'] != '-1' )
    {
        $sLimit = "LIMIT ".intval( $_GET['start'] ).", ".
            intval( $_GET['length'] );
    }
     
     
    /*
     * Ordering
     */
    $sOrder = "order by st_adm_no desc";
    if ( isset( $_GET['order'][0]) and ($_GET['order'][0]['column'] !==9) )
    {
        $sOrder = "ORDER BY  ". $aColumns[$_GET['order'][0]['column']]."
                    ".($_GET['order'][0]['dir']==='asc' ? 'asc' : 'desc') .", ";
         
        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" )
        {
            $sOrder = "";
        }
    }
     
     
     
    /*
     * Filtering
     */
    $sWhere = " where s.st_valid =1 and s.st_rel_sch_id = ".$_REQUEST['school_id'] ;
    if ( isset($_GET['search']) && $_GET['search']['value'] != "" )
    {
        $sWhere = "WHERE  s.st_valid =1 and s.st_rel_sch_id = ".$_REQUEST['school_id']." and (";
        for ( $i=0 ; $i<(count($aColumns)-1) ; $i++ )
        {
                $sWhere .= $aColumns[$i]." LIKE '%".$conn->escape_string( $_GET['search']['value'] )."%' OR ";
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ' )';
    }

    /* Individual column filtering 
    for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
        if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
        {
            if ( $sWhere == "" )
            {
                $sWhere = "WHERE ";
            }
            else
            {
                $sWhere .= " AND ";
            }
            $sWhere .= $aColumns[$i]." LIKE '%".$conn->escape_string($_GET['sSearch_'.$i])."%' ";
        }
    }*/
     
     
    /*
     * SQL queries
     * Get data to display
     */
    $sQuery = "
        SELECT SQL_CALC_FOUND_ROWS s.*,c.*,l.lum_valid,IFNULL(l.lum_pass_def,'None') as lum_pass_def  
		
		FROM   ".$sTable." s
				left join students_classes_mapping c on c.cls_id = s.st_rel_cls_id
left join sw_logins l on l.lum_id = s.st_rel_lum_id

		
        ".$sWhere."
        ".$sOrder."
        ".$sLimit."
    ";
#var_dump($_REQUEST).'<hr>';
#echo $sQuery.'<hr>';

    $rResult = $conn->query( $sQuery) or fatal_error( 'MySQL Error: ' . $conn->error);
     
    /* Data set length after filtering */
    $sQuery = "
        SELECT FOUND_ROWS()
    ";
    $rResultFilterTotal = $conn->query( $sQuery) or fatal_error( 'MySQL Error: ' . $conn->error() );
    $aResultFilterTotal = $rResultFilterTotal->fetch_assoc();
	
    $iFilteredTotal = $aResultFilterTotal['FOUND_ROWS()'];
     
    /* Total data set length */
    $sQuery = "
        SELECT COUNT(".$sIndexColumn.")
        FROM   ".$sTable." where st_rel_sch_id = ".$_REQUEST['school_id'];
    $rResultTotal = $conn->query( $sQuery) or fatal_error( 'MySQL Error: ' . $conn->error() );
    $aResultTotal = $rResultTotal->fetch_assoc();
    $iTotal = $aResultTotal["COUNT(".$sIndexColumn.")"];
     
     
    /*
     * Output
     */
    $output = array(
        "draw" => intval($_GET['draw']),
        "iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData" => array()
    );
     
    while ( $aRow = $rResult->fetch_assoc() )
    {
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            if ( $aColumns[$i] == "version" )
            {
                /* Special output formatting for 'version' column */
                $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
            }else if($i == 0){
				$row[]= $aRow['st_name'].'<br><button id="getUser" data-toggle="modal" data-target="#view-modal" data-id="'.md5(md5(sha1($aRow['st_db_id']))).'" class="btn btn-sm btn-warning ion-edit"></button>';
			}else if($i == 3){
				$row[]= $aRow['cls_words_some_rom'].'-'.$aRow['st_cls_section'];
			}else if($i == 6){
				$row[]= date('d-M, Y',$aRow['st_dob']);
			}else if($i == 8){
				
				if($aRow['st_rel_lum_id'] > 0){
	$row[] = "<i class='fa fa-circle' style='color:green'></i><br>".$aRow['lum_pass_def'];
	$getdefpass = "";
	
}else{
	$row[] ="<i class='fa fa-circle' style='color:red'></i>".$aRow['lum_pass_def'];
}
			}else if($i == 9){
				
				
		if(($aRow['st_rel_lum_id'] == 0) or (($aRow['lum_valid']) == 0) and ($aRow['st_rel_lum_id'] > 0)){
$row[] = '

<form action="master_action.php" method="post">
<input required  name="actv_login_onesstu_h" type="hidden" value="'.md5(md5(sha1(sha1(md5(md5($aRow['st_db_id'].'hir39efnewsfejirjeofkvjrjdnjjenfkvkijonreij3nj')))))).'" />

<input required  type="submit" class="btn-sm btn btn-success" name="actv_login_onesstu" value="Activate Login" />
</form>';
		}else{$row[]='

<form action="master_action.php" method="post">
<input required  name="deactv_login_onesstu_h" type="hidden" value="'.md5(md5(sha1(sha1(md5(md5($aRow['st_db_id'].'hir39efnewsfejirjeofkvj...rjdnjjenfkvkijonreij3nj')))))).'" />

<input required  type="submit" class="btn-sm btn btn-danger " name="deactv_login_onesstu" value="Remove Login" />
</form>';
}				
				
				
			}else if ( $aColumns[$i] !== ' ' )
            {
                /* General output */
                $row[] = $aRow[ $aColumns[$i] ];
            }else if ( $aColumns[$i] == ' ' ){
				$row[] = 'None';
			}
        }
        $output['aaData'][] = $row;
    }
     
    echo json_encode( $output );
	
}
if(isset($_REQUEST['school_id_teach'])){

if(!is_numeric($_REQUEST['school_id_teach'])){
	die('Invalid Id');
}
    $aColumns = array( 'th_name','th_teach_class', 'th_gender','th_dob', 'th_contact_no','th_email','lum_pass_def','th_subject',' ');
     
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "th_id";
     
    /* DB table to use */
    $sTable = "sb_teachers";
     
     
    function fatal_error ( $sErrorMessage = '' )
    {
        header( $_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error' );
        die( $sErrorMessage );
    }
 
    /*
     * Paging
     */
    $sLimit = " limit 10";
    if ( isset( $_GET['start'] ) && $_GET['length'] != '-1' )
    {
        $sLimit = "LIMIT ".intval( $_GET['start'] ).", ".
            intval( $_GET['length'] );
    }
     
     
    /*
     * Ordering
     */
    $sOrder = "order by th_name asc";
    if ( isset( $_GET['order'][0]) and ($_GET['order'][0]['column'] !==7) )
    {
        $sOrder = "ORDER BY  ". $aColumns[$_GET['order'][0]['column']]."
                    ".($_GET['order'][0]['dir']==='asc' ? 'asc' : 'desc') .", ";
         
        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" )
        {
            $sOrder = "";
        }
    }
     
     
     
    /*
     * Filtering
     */
    $sWhere = " where s.th_valid =1 and s.th_rel_sch_id =".$_REQUEST['school_id_teach'] ;
    if ( isset($_GET['search']) && $_GET['search']['value'] != "" )
    {
        $sWhere = "WHERE  s.th_valid =1 and s.th_rel_sch_id = ".$_REQUEST['school_id_teach']." and (";
        for ( $i=0 ; $i<(count($aColumns)-1) ; $i++ )
        {
                $sWhere .= $aColumns[$i]." LIKE '%".$conn->escape_string( $_GET['search']['value'] )."%' OR ";
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ' )';
    }

    /* Individual column filtering 
    for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
        if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
        {
            if ( $sWhere == "" )
            {
                $sWhere = "WHERE ";
            }
            else
            {
                $sWhere .= " AND ";
            }
            $sWhere .= $aColumns[$i]." LIKE '%".$conn->escape_string($_GET['sSearch_'.$i])."%' ";
        }
    }*/
     
     
    /*
     * SQL queries
     * Get data to display
     */
    $sQuery = "
        SELECT SQL_CALC_FOUND_ROWS s.*,l.lum_valid,IFNULL(l.lum_pass_def,'None') as lum_pass_def   
		
		FROM   ".$sTable." s
left join sw_logins l on l.lum_id = s.th_rel_lum_id

		
        ".$sWhere."
        ".$sOrder."
        ".$sLimit."
    ";
#var_dump($_REQUEST).'<hr>';
#echo $sQuery.'<hr>';

    $rResult = $conn->query( $sQuery) or fatal_error( 'MySQL Error: ' . $conn->error);
     
    /* Data set length after filtering */
    $sQuery = "
        SELECT FOUND_ROWS()
    ";
    $rResultFilterTotal = $conn->query( $sQuery) or fatal_error( 'MySQL Error: ' . $conn->error() );
    $aResultFilterTotal = $rResultFilterTotal->fetch_assoc();
	
    $iFilteredTotal = $aResultFilterTotal['FOUND_ROWS()'];
     
    /* Total data set length */
    $sQuery = "
        SELECT COUNT(".$sIndexColumn.")
        FROM   ".$sTable." where th_rel_sch_id = ".$_REQUEST['school_id_teach'];
    $rResultTotal = $conn->query( $sQuery) or fatal_error( 'MySQL Error: ' . $conn->error() );
    $aResultTotal = $rResultTotal->fetch_assoc();
    $iTotal = $aResultTotal["COUNT(".$sIndexColumn.")"];
     
     
    /*
     * Output
     */
    $output = array(
        "draw" => intval($_GET['draw']),
        "iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData" => array()
    );
     
    while ( $aRow = $rResult->fetch_assoc() )
    {
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            if ( $aColumns[$i] == "version" )
            {
                /* Special output formatting for 'version' column */
                $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
            }else if($i == 0){
				$row[]= $aRow['th_name'].'<br><button id="getUser" data-toggle="modal" data-target="#view-modal" data-id="'.md5(md5(sha1($aRow['th_id']))).'" class="btn btn-sm btn-warning ion-edit"></button>';
			}else if($i == 1){
				$row[]= ''.$aRow['th_subject'].' to '.$aRow['th_teach_class'].'';
			}else if($i == 3){
				$row[]= date('d-M, Y',$aRow['th_dob']);
			}else if($i == 7){
			}else if($i == 6){
				
				if($aRow['th_rel_lum_id'] > 0){
				$row[] = "<i class='fa fa-circle' style='color:green'></i><br>".$aRow['lum_pass_def'];
				$getdefpass = "";
				
			}else{
				$row[] ="<i class='fa fa-circle' style='color:red'></i>".$aRow['lum_pass_def'];
			}
			}else if($i == 8){
				
				
		if(($aRow['th_rel_lum_id'] == 0) or (($aRow['lum_valid']) == 0) and ($aRow['th_rel_lum_id'] > 0)){
$row[] = '

<form action="master_action.php" method="post">
<input required  name="actv_login_oneteach_h" type="hidden" value="'.md5(md5(sha1(sha1(md5(md5($aRow['th_id'].'hir39efnewsfejirjeokjd.fkvkijonreij3nj')))))).'" />

<input required  type="submit" class="btn-sm btn btn-success" name="actv_login_onesteach" value="Activate Login" />
</form>';
		}else{$row[]='

<form action="master_action.php" method="post">
<input required  name="deactv_login_oneteach_h" type="hidden" value="'.md5(md5(sha1(sha1(md5(md5($aRow['th_id'].'hir39efnewjmvj...rjdnjjenfkkjsrgnkjrgsnvkijonreij3nj')))))).'" />

<input required  type="submit" class="btn-sm btn btn-danger " name="deactv_login_onesteach" value="Remove Login" />
</form>';
}				
				
				
			}else if ( $aColumns[$i] !== ' ' )
            {
                /* General output */
                $row[] = $aRow[ $aColumns[$i] ];
            }else if ( $aColumns[$i] == ' ' ){
				$row[] = 'None';
			}
        }
        $output['aaData'][] = $row;
    }
     
    echo json_encode( $output );
	
}

?>
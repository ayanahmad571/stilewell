<?php 
include('include.php');
if(!isset($_POST['updt_img']) and !isset($_POST['inven_id'])){
	die();
}
$mdi = $_POST['inven_id'];
if(isset($_FILES['filer'])){
$k = 'filer'; 

if(!ctype_alnum($mdi)){
	die('Invalid product hash');
}

$chechprod = getdatafromsql($conn,"select * from sw_products_raw where md5(md5(sha1(md5(sha1(pr_id))))) = '".$mdi."' and pr_valid =1");		
		######
	
	if(!is_array($chechprod)){
		die('Product not found');
	}
	$target_dir = "pr_imgs/";
$ext =  extension(basename($_FILES[$k]["name"]));
$fold_name =uniqid().'-updated-'.time().'/';
if(mkdir('pr_imgs/'.$fold_name)){
	}

$target_file = $target_dir .$fold_name. '1.'.$ext;
$target_file_2 = $target_dir .$fold_name. '2.'.$ext;
$target_file_3 = $target_dir .$fold_name. '3.'.$ext;

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
    $check = getimagesize($_FILES[$k]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES[$k]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES[$k]["tmp_name"], $target_file) and
	    copy($target_file, $target_file_2) and  
		copy($target_file, $target_file_3) ) {
		

if(resize(120,$target_file_2,$target_file_2)){
	if(resize(300,$target_file_3,$target_file_3)){
}else{
		die('I c N R');
	}

}else{
	die('Images Could not be resized');
}

    } else {
        die( "Sorry, there was an error uploading your file.");
    }
}
					
					
			 $inssql = "UPDATE `sw_products_raw` SET 
			 `pr_img`='".$target_file."',
			 `pr_img_2`='".$target_file_2."',
			 `pr_img_3`='".$target_file_3."' 
			 where md5(md5(sha1(md5(sha1(pr_id))))) = '".$mdi."'
								";
                    if ($conn->query($inssql) === TRUE) {
header('Location: inven.php');                    }
            else {
              die( "Error: " . $inssql . "<br>" . $conn->error);
            }
			
			
			
			
			
			#####
		

}else{
		echo '<img src="pr_imgs/default.png" class="img-responsive" />';
}
?>
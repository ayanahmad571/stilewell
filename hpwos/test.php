<?php

	$getlatestref = 'No res found';
	if(is_array($getlatestref)){
		$latestrefstr = substr($getlatestref['so_ref'],3);
		if(is_numeric($latestrefstr)){
			$latestref = $latestrefstr * 1;
		}else{
			die('Latest Ref not numeric');
		}
	}else{
		$latestref = 1;
	}


var_dump($latestref);

?>
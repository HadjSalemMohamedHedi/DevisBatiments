<?php 
	
 

	$result=dirToArray('./');
	
	foreach ($result as $r => $d)
	{
	//echo "<br>".$r;
	
		$href="http://127.0.0.1/2017/sibec-tunisie.com/mb-test/back-office/admin/upload/images-products2/".$r."/";
		fopen($href,'rt'); 
	
	}
	
	//print_r($result);
 
	function dirToArray($dir) { 
		
		$result = array(); 
		
		$cdir = scandir($dir); 
		foreach ($cdir as $key => $value) 
		{ 
			if (!in_array($value,array(".",".."))) 
			{ 
				if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) 
				{ 
					$result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value); 
				} 
				else 
				{ 
					//$result[] = $value; 
				} 
			} 
		} 
		
		return $result; 
	}
	
	
	
 
	
	
?>
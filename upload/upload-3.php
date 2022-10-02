<?php
	include_once '../includes/config.inc.php';
	$db = db_connect();
	
	$id_product=$_SESSION['id_product'];
	//echo $id_product;
	if(!isset($_SESSION['User']['username'])) {
	die();
	}
	
	
	// Check options at: http://www.white-hat-web-design.co.uk/blog/resizing-images-with-php/ 
	include('class.img.php');
	
	
	
	$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp'); // valid extensions
	$path = 'images-products/'.$id_product.'/'; // upload directory
	$path_s = 'images-products/'.$id_product.'/s/'; // upload directory
	
	if (!file_exists($path)) {mkdir($path, 0777, true);}
	
	//$name_img = str_replace("images-products/".$v['id']."/", "images-products/".$v['id']."/s/50_", $product_images[0]['name']);
	
	
	if(isset($_FILES['image']))
	{
		$img = $_FILES['image']['name'];
		$tmp = $_FILES['image']['tmp_name'];
		
		// get uploaded file's extension
		$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
		
		// can upload same image using rand function
		$final_image = rand(1000,1000000).$img;
		
		// check's valid format
		if(in_array($ext, $valid_extensions)) 
		{					
			$path = $path.strtolower($final_image);	
			$img_s = $path.strtolower($final_image);	
			
			if(move_uploaded_file($tmp,$path)) 
			{
				//echo "<img src='$path' />";
				
				$_SESSION['images-product'][]=$path;
				
				
				$directory = "./";
				
				// Collection of extensions
				$exts = array('jpg','jpeg','png','gif');
				
				// Resized file pre
				$prefix = '50_';
				
				// Scale Percentage
				$new_width = 220;
				
				// ------------------------------------------------------------------------------------------
				$handle = opendir($directory);
				
				if (!file_exists($path_s)) {
					mkdir($path_s, 0777, true);
				}
				
			 
						$image = new Image();
						$image->load($path);
						$image->resize_to_width($new_width); 
						$image->save($path_s.$prefix.$final_image);
						
						
						$bg = imagecreatefromjpeg('bg/bg.jpg');
						$img = imagecreatefromjpeg($path_s.$prefix.$final_image);
						
						$data = getimagesize($path_s.$prefix.$final_image);
						$width = $data[0];
						$height = $data[1];
						
						$diff_height=220-$height;
						$height_to_add=$diff_height/2;
						
						
						imagecopymerge($bg, $img, 0, $height_to_add, 0, 0, imagesx($bg), imagesy($bg), 100);
						imagealphablending($bg, true);
						imagesavealpha($bg,true);
						imagejpeg($bg,$path_s.$prefix.$final_image); 
						
						
						$bg = imagecreatefromjpeg($path_s.$prefix.$final_image);
						$img = imagecreatefromjpeg('bg/bg.jpg');
						imagecopymerge($bg, $img, 0, 220-$height_to_add, 00, 0, imagesx($bg), imagesy($bg), 100);
						imagealphablending($bg, true);
						imagesavealpha($bg,true);
						imagejpeg($bg,$path_s.$prefix.$final_image);    
					 
				
				
				
				
				
				
				
			
				
				
				
				
				
			}
		} 
		else 
		{
			echo 'invalid image';
		}
		
		
		
		
		
		
	}
	
	if (isset ($_GET['delete'])){
		$k=0;
		foreach ($_SESSION['images-product'] as $img){
			if ($img===$_GET['delete']){
				unlink($_SESSION['images-product'][$k]);
				$_SESSION['images-product'][$k]='-1';
			}
			$k++;
		}
	}
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
<!doctype html>
<html style="    width: 99%;">
	<head>
		<meta charset="utf-8">
		
		<!-- Bootstrap styles -->
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<!-- Generic page styles -->
		<link rel="stylesheet" href="css/style.css">
		<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
		<link rel="stylesheet" href="css/jquery.fileupload.css">
		
		
	</head>
	
	
	<body>
		
		
		<form id="fileupload" action="" method="POST" enctype="multipart/form-data" style="padding: 10px;">
			
			<div class="row fileupload-buttonbar">
				<div class="col-lg-7">
					<!-- The fileinput-button span is used to style the file input field as button -->
					
					
					<input class="btn btn-success fileinput-button" style="    display: inline;" id="uploadImage" type="file" accept="image/*" name="image" />
					
					
					<button type="submit" class="btn btn-primary start"  style="    display: inline; float:right" >
						<i class="glyphicon glyphicon-upload"></i>
					<span>Démarrer l'upload</span>
					</button>
					
					<!-- The global file processing state -->
					<span class="fileupload-process"></span>
					</div>
					<!-- The global progress state -->
					
					
					<div class="col-lg-10" style="margin-top:10px;">
					
					<table class="table table-striped">
					
					<tbody>
					<?php foreach ($_SESSION['images-product'] as $img){ 
					//echo "<br>".$img;
					if ($img!='-1'){
					?>
					<tr>
					<th scope="row"></th>
					<td><img src="<?php echo $img?>" style="width:150px;"></td>
					
					<td><a href="?delete=<?php echo $img?>" style="    color: #F44336;    font-size: 12px;">supprimer</a></td>
					</tr>
					<?php   }} ?>
					
					
					
					</tbody>
					</table>
					</div>
					
					
					</div>
					<!-- The table listing the files available for upload/download -->
					<table role="presentation" class="table table-nomargin  dataTable table-striped table-hover"><tbody class="files"></tbody></table>
					</form>
					
					
					<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
					<!--[if (gte IE 8)&(lt IE 10)]>
					<script src="js/cors/jquery.xdr-transport.js"></script>
					<![endif]-->
					</body>
					</html>									
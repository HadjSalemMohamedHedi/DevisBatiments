<?php
	include_once '../includes/config.inc.php';
	$db = db_connect();
	
	$id_product=$_SESSION['id_product'];
	
	$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp'); // valid extensions
	$path = 'images-products/'.$id_product.'/'; // upload directory
	
	if (!file_exists($path)) {mkdir($path, 0777, true);}
	
	if(!isset($_SESSION['User']['username'])) {
	die();
	}
	
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
			
			if(move_uploaded_file($tmp,$path)) 
			{
				//echo "<img src='$path' />";
				
				$_SESSION['images-product'][]=$path;
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
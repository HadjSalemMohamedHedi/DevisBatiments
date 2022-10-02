<?php
include_once "includes/config.inc.php";
$db = db_connect();

if((isset($_POST['action'])) && ($_POST['action'] == "import") ){

if(file_exists("uploadcsv/uploaded_file.csv")){
	unlink("uploadcsv/uploaded_file.csv");
}

	if ( isset($_FILES["file"])) {



            //if there was an error uploading the file
		if ($_FILES["file"]["error"] > 0) {
			echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
		}
		else {
			$count_ = 0;
                    //Store file in directory "upload" with the name of "uploaded_file.csv"
			$storagename = "uploaded_file.csv";
			move_uploaded_file($_FILES["file"]["tmp_name"], "uploadcsv/" . $storagename);

			$row = 1;
			if (($handle = fopen("uploadcsv/uploaded_file.csv", "r")) !== FALSE) {
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
					$num = count($data);

					if($num ==1){
						$newData = str_replace('"', '', $data[0]);
						$data = explode(",", $newData);
					}

					$row++;
					$ab = array();

					

					if($row>2){
					 	echo($data[0]);
					 	echo "<br>";
						echo($data[1]);
						echo "<br>";
						echo($data[2]);
						echo "<br>";
						echo($data[3]);
						echo "<br>";
						echo($data[4]);
						echo "<br>";

						$sous_products_table = $db->get_row("SELECT * FROM sous_products_table WHERE code_article = ".$data[0]);

						//$ab['id_product'] = 2;
						$ab['code_article'] = $data[0]; 
						$ab['designation'] = $data[1];
						$ab['prix'] = $data[2];
						$ab['remise'] = $data[3];
						$ab['unite'] = $data[4];
						$ab['quantite'] = $data[5];

						if (empty($sous_products_table)) {
							$db->insert("sous_products_table", $ab);
						}else{
							$db->update('sous_products_table', $ab, $sous_products_table['id']);
						}
						
						$count_++;
					}
				}
				fclose($handle);
			}
			if(file_exists("uploadcsv/uploaded_file.csv")){
				unlink("uploadcsv/uploaded_file.csv");
			}
			 

			exit;

		}
	} else {
		echo "No file selected <br />";
	}

}

?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Import - Hydrex</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <!-- CSS 
    	========================= -->
    	<!--bootstrap min css-->
    	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
    	<!--owl carousel min css-->
    	<link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    	<!--slick min css-->
    	<link rel="stylesheet" href="assets/css/slick.css">
    	<!--magnific popup min css-->
    	<link rel="stylesheet" href="assets/css/magnific-popup.css">
    	<!--font awesome css-->
    	<link rel="stylesheet" href="assets/css/font.awesome.css">
    	<!--animate css-->
    	<link rel="stylesheet" href="assets/css/animate.css">
    	<!--jquery ui min css-->
    	<link rel="stylesheet" href="assets/css/jquery-ui.min.css">
    	<!--slinky menu css-->
    	<link rel="stylesheet" href="assets/css/slinky.menu.css">
    	<!--plugins css-->
    	<link rel="stylesheet" href="assets/css/plugins.css">
    	<!-- Main Style CSS -->
    	<link rel="stylesheet" href="assets/css/style.css">
    	<link rel="stylesheet" href="assets/css/site.css">
    	<!--modernizr min js here-->
    	<script src="assets/js/vendor/modernizr-3.7.1.min.js"></script>
    </head>
    <body>
    	<!--header area start-->
    	<?php include 'includes/header.php'; ?>
    	<!--header area end-->

    	<button type="button" class="btn btn-primary"   data-toggle="modal" data-target="#exampleModal">
    		Importer CSV
    	</button>

    	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    		<div class="modal-dialog" role="document">
    			<div class="modal-content">
    				<div class="modal-header">
    					<h5 class="modal-title" id="exampleModalLabel">Importer une liste des abonnements Platinum IPTV</h5>
    					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    						<span aria-hidden="true">&times;</span>
    					</button>
    				</div>
    				<form class="form-horizontal" action="" method="post" name="upload_excel" enctype="multipart/form-data">
    					<input type="hidden" name="action" value="import">
    					<div class="modal-body">
    						<div class="row">



    							<div class="form-group">
    								<label class="col-md-4 control-label" for="filebutton">Select File</label>
    								<div class="col-md-4">
    									<input type="file" name="file" id="file" class="input-large">
    								</div>
    							</div>





    						</div>
    					</div>
    					<div class="modal-footer">
    						<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
    						<button type="submit" class="btn btn-primary">Importer</button>
    					</div>
    				</form>
    			</div>
    		</div>
    	</div>

    	<!--footer area start-->
    	<?php include 'includes/footer.php'; ?>
    	<!--footer area end-->

<!-- JS
	============================================ -->
	<!--jquery min js-->
	<script src="assets/js/vendor/jquery-3.4.1.min.js"></script>
	<!--popper min js-->
	<script src="assets/js/popper.js"></script>
	<!--bootstrap min js-->
	<script src="assets/js/bootstrap.min.js"></script>
	<!--owl carousel min js-->
	<script src="assets/js/owl.carousel.min.js"></script>
	<!--slick min js-->
	<script src="assets/js/slick.min.js"></script>
	<!--magnific popup min js-->
	<script src="assets/js/jquery.magnific-popup.min.js"></script>
	<!--counterup min js-->
	<script src="assets/js/jquery.counterup.min.js"></script>
	<!--jquery countdown min js-->
	<script src="assets/js/jquery.countdown.js"></script>
	<!--jquery ui min js-->
	<script src="assets/js/jquery.ui.js"></script>
	<!--jquery elevatezoom min js-->
	<script src="assets/js/jquery.elevatezoom.js"></script>
	<!--isotope packaged min js-->
	<script src="assets/js/isotope.pkgd.min.js"></script>
	<!--slinky menu js-->
	<script src="assets/js/slinky.menu.js"></script>
	<!-- Plugins JS -->
	<script src="assets/js/plugins.js"></script>

	<!-- Main JS -->
	<script src="assets/js/main.js"></script>



</body>

</html>
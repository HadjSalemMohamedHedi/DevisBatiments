<?php include_once '../../includes/config.inc.php';
$id_categ = 1;
if (isset($_GET['id_categ'])) {
	$id_categ = $_GET['id_categ'];
}

$categs = $db->get_rows("SELECT categ.* FROM categ WHERE categ.deleted = 0 and categ.statut=1");
$id_categ = $categs[0]['id'];
$sub_categs = $db->get_rows("SELECT sub_categ.* FROM sub_categ WHERE sub_categ.deleted = 0 and sub_categ.statut=1 and id_categ=" . $id_categ);

$_SESSION['images-product'] = array();
$max_id_corp = $db->get_row("SELECT max(id) as max_id FROM products  ");
$id_product = $max_id_corp['max_id'];
$_SESSION['id_product'] = $id_product + 1;

$filter = " and id_sub_categ=" . $sub_categs[0]['id'];
$query = "SELECT products.* FROM products WHERE statut = 1 and deleted = 0 " . $filter;

$product_list = $db->get_rows($query);
$product_count = count($product_list); /**/
?>

<input type="hidden" name="statut" value="1">
<div class="row">
	<div class="col-md-5">
		<div class="form-group">
			<label for="username" class="control-label">Gamme *:</label>
			<select id="id_categ" name="id_categ" class="form-control">
				<?php foreach ($categs as $categ) { ?>
					<option value="<?php echo $categ['id']; ?>" <?php if ($id_categ == $categ['id']) {
																	echo "selected";
																} ?>><?php echo $categ['titre_fr']; ?></option>
				<?php } ?>


			</select>
		</div>
	</div>
	<div class="col-md-5">
		<div class="form-group">
			<label for="username" class="control-label">Catégorie *:</label>
			<select id="id_sub_categ" name="id_sub_categ" class="form-control">
				<?php foreach ($sub_categs as $sub_categ) { ?>
					<option value="<?php echo $sub_categ['id']; ?>" <?php if ($id_categ == $sub_categ['id']) {
																		echo "selected";
																	} ?>><?php echo $sub_categ['titre_fr']; ?></option>
				<?php } ?>


			</select>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-5">
		<div class="form-group">
			<label for="username" class="control-label">Titre (FR) *:</label>
			<div class="controls">
				<input type="text" class="form-control" id="titre_fr" name="titre_fr" required="required">
			</div>
		</div>
	</div>
	<div class="col-md-5">
		<div class="form-group">
			<label for="username" class="control-label">Titre (EN) *:</label>
			<div class="controls">
				<input type="text" class="form-control" id="titre_en" name="titre_en" required="required">
			</div>
		</div>
	</div>
</div>

<hr>
<div class="row">
	<br>
	<div class="col-md-3">
		<div class="form-group">
			<input type="radio" class="form-checkbox" name="type" value="ecommerce">
			<label for="Commerce" class="control-label">Produit E-Commerce</label>
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<input type="radio" class="form-checkbox" name="type" value="vitrine">
			<label for="Vitrine" class="control-label">Produit vitrine</label>
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<input type="radio" class="form-checkbox" name="type" value="Vitrine et ECommerce">
			<label for="Produit vitrine & E-Commerce" class="control-label">Produit vitrine & E-Commerce</label>
		</div>
	</div>
</div>
<hr>
<div class="row">
	<br>
	<!-- 	<div class="col-md-4">
			<div class="form-group">
				<label for="username" class="control-label">PROMOTIONS:</label>
				<input type="checkbox" class="form-checkbox" name="promotion" value="promo">
			</div>
		</div> -->
	<div class="col-md-4">
		<div class="form-group">
			<label for="username" class="control-label">INCONTOURNABLES:</label>
			<input type="checkbox" class="form-checkbox" name="incont" value="incont">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label for="username" class="control-label">NOUVEAUTÉS:</label>
			<input type="checkbox" class="form-checkbox" name="new" value="new">
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label for="username" class="control-label">DÉSTOCKAGE:</label>
			<input type="checkbox" class="form-checkbox" name="desk" value="desk">
		</div>
	</div>


	<div class="col-md-2" style="display: none;">
		<div class="form-group">
			<label for="username" class="control-label">Ordre *:</label>
			<div class="controls">
				<select id="product_order" name="rang" class="form-control">
					<?php for ($k = 1; $k <= ($product_count + 1); $k++) { ?>
						<option selected value="<?php echo $k; ?>"><?php echo $k; ?></option>
					<?php  } ?>
				</select>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">

		<ul class="nav nav-tabs transparent">
			<li class="active">
				<a href="#desc-fr" data-toggle="tab">
					Description FR
				</a>
			</li>
			<li>
				<a href="#desc-en" data-toggle="tab">
					Description EN
				</a>
			</li>

		</ul>

		<!-- version Beta  -->

		<div class="tab-content transparent">
			<div class="tab-pane fade in active" id="desc-fr">

				<textarea id="editorFr" name="description_fr" class="" placeholder="Entrer la description du produit ..."></textarea>

			</div>
			<div class="tab-pane fade" id="desc-en">

				<textarea id="editorEn" name="description_en" class="" placeholder="Enter the product description ..."></textarea>

			</div>
		</div>
	</div>

</div>


<div class="row" style="margin-top: 30px;">
	<div class="col-md-2">
		<div class="form-group">
			<label for="username" class="control-label">Fiche technique:</label>
		</div>
	</div>
	<div class="col-md-5">
		<div class="form-group">
			<label class="col-md-4 control-label" for="filebutton">
				<h4>Sélectionner un fichier</h4>
			</label>
			<div class="col-md-4">
				<input type="file" name="file" id="MyFile" class="input-large" style="margin-top: 16px;" onchange="uploadFile(event)">
			</div>
		</div>
	</div>
</div>


<div class="row" style="margin-top:5px;">

	<div class="col-md-12">
		<div class="form-group">
			<label for="username" class="control-label">Images :</label>
			<h6>Dimention image 600px X 600px</h6>
			<div class="controls">
				<iframe src="upload/upload.php" style="    width: 100%;height:250px;"></iframe>
				<!--<iframe src="file_uploaded/modele_upload.php"  style="border: 0; width:95%;height:400px"></iframe>-->

			</div>
		</div>


	</div>
</div>

<div class="row" style="margin-top:5px;">
	<div class="col-md-5">
		<div class="form-group">
			<label for="username" class="control-label">Meta description FR:</label>
			<div class="controls">
				<input type="text" class="form-control" name="meta_desc_fr">
			</div>
		</div>
	</div>
	<div class="col-md-5">
		<div class="form-group">
			<label for="username" class="control-label">Meta description EN:</label>
			<div class="controls">
				<input type="text" class="form-control" name="meta_desc_en">
			</div>
		</div>
	</div>
</div>



<input type="hidden" name="action" value="add" />
<script>
	const textareaFr = document.querySelector('#editorFr');
	const textareaEng = document.querySelector('#editorEn');

	ClassicEditor
		.create(textareaFr)
		.then(editorFr => {
			window.editorFr = editorFr
		});

	ClassicEditor
		.create(textareaEng)
		.then(editor => {
			window.editor = editor
		});

	document.getElementById('submit-add').onclick = () => {
		textareaFr.value = editorFr.getData();
		textareaEng.value = editor.getData();

	}
</script>




<script>
	var $regions = $('#id_categ');
	var $departements = $('#id_sub_categ');
	$regions.on('change', function() {
		var val = $(this).val();
		var id_selected_sub_categ = 0;
		if (val != '') {
			$departements.empty();
			$.ajax({
				url: 'module_ajax/categories/get_sub_categ.php',
				data: 'id_categ=' + val,
				success: function(json) {
					json = $.parseJSON(json);
					$.each(json, function(index, value) {
						if (id_selected_sub_categ == 0) {
							id_selected_sub_categ = index;
						}
						$departements.append('<option value="' + index + '">' + value + '</option>');
					});

					var $product_order = $('#product_order');

					if (id_selected_sub_categ != 0) {
						$product_order.empty();
						$.ajax({
							url: 'module_ajax/products/get_product_count.php',
							data: 'id_sub_categ=' + id_selected_sub_categ,
							success: function(json) {
								json = $.parseJSON(json);
								$.each(json, function(index, value) {
									$product_order.append('<option selected value="' + index + '">' + value + '</option>');
								});
							}
						});
					}

				}
			});
		}
	});


	var $id_sub_categ = $('#id_sub_categ');
	var $product_order = $('#product_order');
	$id_sub_categ.on('change', function() {
		var val = $(this).val();

		if (val != '') {
			$product_order.empty();
			$.ajax({
				url: 'module_ajax/products/get_product_count.php',
				data: 'id_sub_categ=' + val,
				success: function(json) {
					json = $.parseJSON(json);
					$.each(json, function(index, value) {
						$product_order.append('<option selected value="' + index + '">' + value + '</option>');
					});
				}
			});
		}
	});



	initSample('_fr');
	initSample('_en');



	function uploadFile(e) {
		console.log("uploadFile uploadFile");
		var fd = new FormData();
		var files = $('#file')[0].files[0];
		fd.append('file', e.target.files[0]);

		// AJAX request
		$.ajax({
			// url: 'module_ajax/products/validate.php',
			// type: 'post',
			// data: fd,
			contentType: false,
			processData: false,
			success: function(response) {
				if (response != 0) {
					// Show image preview
				} else {}
			}
		});
		return false;
		e.preventDefault();



	}
</script>
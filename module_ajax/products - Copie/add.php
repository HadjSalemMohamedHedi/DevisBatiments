<?php include_once '../../includes/config.inc.php';
	$id_categ=1;
	if (isset ($_GET['id_categ']))   { $id_categ=$_GET['id_categ'];}
	
	$categs = $db->get_rows("SELECT categ.* FROM categ WHERE categ.deleted = 0 and categ.statut=1");
	$id_categ=$categs[0]['id'];
	$sub_categs = $db->get_rows("SELECT sub_categ.* FROM sub_categ WHERE sub_categ.deleted = 0 and sub_categ.statut=1 and id_categ=".$id_categ);
	
	$_SESSION['images-product']=array();
	
	$max_id_corp = $db->get_row("SELECT max(id) as max_id FROM products  ");
	$id_product= $max_id_corp['max_id'];
	$_SESSION['id_product']=$id_product+1;
	
	
?>

<input type="hidden" name="statut" value ="1">

<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="username" class="control-label">Gamme *:</label>
			<select id="id_categ"  name="id_categ" class="form-control"  >
				<?php foreach ($categs as $categ){?>
					<option value="<?php echo $categ['id'];?>" <?php if ($id_categ == $categ['id']) {echo "selected";}?> ><?php echo $categ['titre_fr'];?></option>
				<?php }?>
				
				
			</select>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="username" class="control-label">Catégorie *:</label>
			<select id="id_sub_categ"  name="id_sub_categ" class="form-control"  >
				<?php foreach ($sub_categs as $sub_categ){?>
					<option value="<?php echo $sub_categ['id'];?>" <?php if ($id_categ == $sub_categ['id']) {echo "selected";}?> ><?php echo $sub_categ['titre_fr'];?></option>
				<?php }?>
				
				
			</select>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="username" class="control-label">Titre (FR) *:</label>
			<div class="controls">
				<input type="text" class="form-control" id="titre_fr" name="titre_fr" required="required" >
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="username" class="control-label">Titre (EN) *:</label>
			<div class="controls">
				<input type="text" class="form-control" id="titre_en" name="titre_en" required="required" >
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
		
		<div class="tab-content transparent">
			<div class="tab-pane fade in active" id="desc-fr">
				<div>
					<textarea name="description_fr" class="bootstrap-wysihtml5-textarea" placeholder="Entrer la description du produit ..." style="width: 100%; height: 150px; font-size: 14px; line-height: 23px;padding:15px;"></textarea>
				</div>
			</div>
			<div class="tab-pane fade" id="desc-en">
				<textarea name="description_en" class="bootstrap-wysihtml5-textarea" placeholder="Enter the product description ..." style="width: 100%; height: 150px; font-size: 14px; line-height: 23px;padding:15px;"></textarea>
			</div>
		</div>
	</div>
	
</div>
<div class="row" style="margin-top:5px;">
	
	<div class="col-md-12">
		<div class="form-group">
			<label for="username" class="control-label">Images :</label>
			<div class="controls">
				<iframe src="upload/upload.php" style="    width: 100%;height:250px;"></iframe>
				<!--<iframe src="file_uploaded/modele_upload.php"  style="border: 0; width:95%;height:400px"></iframe>-->
				
			</div>
		</div>
		
		
	</div>
</div>



<input type="hidden" name="action" value="add" />	

<script>
	$(document).ready(function() {
		
		var $regions = $('#id_categ');
		var $departements = $('#id_sub_categ');
 		$regions.on('change', function() {
			var val = $(this).val();  
			
			if(val != '') {
				$departements.empty();
				$.ajax({
					url: 'module_ajax/categories/get_sub_categ.php',
					data: 'id_categ='+ val,  
					success: function(json) {
						json = $.parseJSON(json);
						$.each(json, function(index, value) {
							$departements.append('<option value="'+ index +'">'+ value +'</option>');
						});
					}
				});
			}
		});
		
		
		
	});
	
</script>
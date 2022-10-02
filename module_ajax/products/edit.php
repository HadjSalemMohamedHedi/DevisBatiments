<?php include_once '../../includes/config.inc.php';
	$id_categ=1;
	//if (isset ($_GET['id_categ']))   { $id_categ=$_GET['id_categ'];}
	
	$_SESSION['images-product']=array();
	
	$product = $db->get_row("SELECT products.* FROM products WHERE products.id=".$_GET['id']);
 
	$id_sub_categ=$product['id_sub_categ'];
	//categorie  produit 
	$sub_categ = $db->get_row("SELECT * FROM `sub_categ` WHERE `id` =".$product['id_sub_categ']);	
	
	//gamme produit 
	$categ = $db->get_row("SELECT * FROM `categ` WHERE `id` =".$sub_categ['id_categ']);
	$id_categ=$categ['id'];
	
	$categs = $db->get_rows("SELECT categ.* FROM categ WHERE categ.deleted = 0 and categ.statut=1");
	
	$sub_categs = $db->get_rows("SELECT sub_categ.* FROM sub_categ WHERE sub_categ.deleted = 0 and sub_categ.statut=1 and id_categ=".$id_categ);
	
	$product_images = $db->get_rows("SELECT * FROM `product_images` WHERE `id_product` =".$_GET['id']);
	foreach ($product_images as $product_img){
		$_SESSION['images-product'][]=$product_img['name'];
	}
	
		$_SESSION['id_product']=$_GET['id'];

	
		 $filter=" and id_sub_categ=".$id_sub_categ;
	$query="SELECT products.* FROM products WHERE statut = 1 and deleted = 0 ".$filter;
		 
	
	$product_list = $db->get_rows($query);
	
		
	$product_count= count($product_list);
?>

<div class="row">
 
	<div class="col-md-5">
		<div class="form-group">
			<label for="username" class="control-label">Gamme *:</label>
			<select id="id_categ"  name="id_categ" class="form-control"  >
				<?php foreach ($categs as $categ){?>
					<option value="<?php echo $categ['id'];?>" <?php if ($id_categ == $categ['id']) {echo "selected";}?> ><?php echo $categ['titre_fr'];?></option>
				<?php }?>
				
				
				</select>
			</div>
	</div>
	<div class="col-md-5">
		<div class="form-group">
			<label for="username" class="control-label">Catégorie *:</label>
			<select id="id_sub_categ"  name="id_sub_categ" class="form-control"  >
				<?php foreach ($sub_categs as $sub_categ){?>
					<option value="<?php echo $sub_categ['id'];?>" <?php if ($id_sub_categ == $sub_categ['id']) {echo "selected";}?> ><?php echo $sub_categ['titre_fr'];?></option>
				<?php }?>
				
				
			</select>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-5">
		<div class="form-group">
			<label for="username" class="control-label">Titre (FR) *:</label>
			<div class="controls">
				<input type="text" class="form-control" id="titre_fr" name="titre_fr" required="required" value="<?php echo $product['titre_fr'];?>">
			</div>
		</div>
	</div>
	<div class="col-md-5">
		<div class="form-group">
			<label for="username" class="control-label">Titre (EN) *:</label>
			<div class="controls">
				<input type="text" class="form-control" id="titre_en" name="titre_en" required="required" value="<?php echo $product['titre_en'];?>" >
			</div>
		</div>
	</div>



	<input type="hidden" name="old_rang" value ="<?php echo $product['rang'];?>">
	<div class="col-md-2" style="display: none;">
		<div class="form-group">
			<label for="username" class="control-label">Ordre *:</label>
			<div class="controls">
				<select id="product_order"  name="rang" class="form-control"  >
					<?php   for($k=1;$k<= ($product_count ) ;$k++) {?>
					
						<option  value="<?php echo $k;?>" <?php if( $product['rang'] == $k) { echo "selected"; }?> ><?php echo $k;?></option>
					<?php  }?>
				</select>
			</div>
		</div>
	</div>
</div>

	<div class="col-md-5" style="display: none;">
		<div class="form-group">
			<label for="username" class="control-label">Prix *:</label>
			<div class="controls">
				<input type="text" class="form-control" name="price"  value="<?php echo $product['price'];?>">
			</div>
		</div>
	</div>
	<div class="col-md-5" style="display: none;">
		<div class="form-group">
			<label for="username" class="control-label">Prix promotion:</label>
			<div class="controls">
				<input type="text" class="form-control" name="promo" value="<?php echo $product['promo'];?>">
			</div>
		</div>
	</div>
	<br>
	<hr>
<div class="row">
		<br>
		<div class="col-md-3">
			<div class="form-group">
			<input type="radio"  <?php if ($product['type']=='ecommerce') echo "checked"; ?> class="form-checkbox" name="type" value="ecommerce">
				<label for="Commerce" class="control-label">Produit E-Commerce</label>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
			<input type="radio" <?php if ($product['type']=='vitrine') echo "checked"; ?>  class="form-checkbox" name="type" value="vitrine">
				<label for="Vitrine" class="control-label">Produit vitrine</label>
			</div>
		</div>

		<div class="col-md-4">
			<div class="form-group">
			<input type="radio" <?php if ($product['type']=='Vitrine et ECommerce') echo "checked"; ?>  class="form-checkbox" name="type" value="Vitrine et ECommerce">
				<label for="Vitrine" class="control-label">Produit vitrine & E-Commerce</label>
			</div>
		</div>
</div>
<hr>


	<div class="row">
		
		<div class="col-md-4">
			<div class="form-group">
				<label for="username" class="control-label">INCONTOURNABLES:</label>
				<?php
					$check = "";
					if ($product['incont'] == 'incont') {
						$check = "checked";
					}
				?>
				<input <?= $check; ?> type="checkbox" class="form-checkbox" name="incont" value="incont">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="username" class="control-label">NOUVEAUTÉS:</label>
				<?php
					$check = "";
					if ($product['new'] == 'new') {
						$check = "checked";
					}
				?>
				<input <?= $check; ?> type="checkbox" class="form-checkbox" name="new" value="new">
			</div>
		</div>

		<div class="col-md-4">
			<div class="form-group" >
				<label for="username" class="control-label">DÉSTOCKAGE:</label>
				<?php
					$check = "";
					if ($product['deskotage'] == 'desk') {
						$check = "checked";
					}
				?>
				<input <?= $check; ?> type="checkbox" class="form-checkbox" name="desk" value="desk">
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
	
 			<textarea  id="editorFr" name="description_fr" class="" placeholder="Entrer la description du produit ..."><?php echo $product['description_fr'];?></textarea>

			</div>
			<div class="tab-pane fade" id="desc-en">
			
				<textarea  id="editorEn" name="description_en" class="" placeholder="Enter the product description ..."><?php echo $product['description_en'];?></textarea>
					
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
			</div>
		</div>
	</div>
</div>





<input type="hidden" name="id" value="<?php echo $db->escape($_GET['id'])?>" />
<input type="hidden" name="action" value="edit" />



 <script>
 	
 	const textareaFr = document.querySelector( '#editorFr' );
 	const textareaEng = document.querySelector( '#editorEn' );

	ClassicEditor
	    .create( textareaFr )
	    .then( editorFr => { window.editorFr = editorFr } );
	    
	    ClassicEditor
	    .create( textareaEng )
	    .then( editor => { window.editor = editor } );

	document.getElementById('submit-edit').onclick = () => {
	    textareaFr.value = editorFr.getData();
	    textareaEng.value = editor.getData();
	
	}


	 
    </script>

<script>
	initSample('_fr');
	initSample('_en');
	
	
 var $regions = $('#id_categ');
	var $departements = $('#id_sub_categ');
	$regions.on('change', function() {
		var val = $(this).val();  
		var id_selected_sub_categ=0;
		if(val != '') {
			$departements.empty();
			$.ajax({
				url: 'module_ajax/categories/get_sub_categ.php',
				data: 'id_categ='+ val,  
				success: function(json) {
					json = $.parseJSON(json);
					$.each(json, function(index, value) {
					if(id_selected_sub_categ == 0){
					id_selected_sub_categ = index;
					}
						$departements.append('<option value="'+ index +'">'+ value +'</option>');
					});
					
					var $product_order = $('#product_order');
					
						if(id_selected_sub_categ != 0) {
							$product_order.empty();
			$.ajax({
				url: 'module_ajax/products/get_product_count.php',
				data: 'id_sub_categ='+ id_selected_sub_categ,  
				success: function(json) {
					json = $.parseJSON(json);
					$.each(json, function(index, value) {
						$product_order.append('<option selected value="'+ index +'">'+ value +'</option>');
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
		
		if(val != '') {
			$product_order.empty();
			$.ajax({
				url: 'module_ajax/products/get_product_count.php',
				data: 'id_sub_categ='+ val,  
				success: function(json) {
					json = $.parseJSON(json);
					$.each(json, function(index, value) {
						$product_order.append('<option selected value="'+ index +'">'+ value +'</option>');
					});
				}
			});
		}
	});
	
	
		
		
		
 		
	 
</script>
<?php include_once '../../includes/config.inc.php';
	$id_categ=1;
	if (isset ($_GET['id_categ']))   { $id_categ=$_GET['id_categ'];}
	
	$categs = $db->get_rows("SELECT categ.* FROM categ WHERE categ.deleted = 0 and categ.statut=1");
	
	
	
	$filter=" and id_categ=".$categs[0]['id'];
	$query="SELECT sub_categ.* FROM sub_categ WHERE statut = 1 and deleted = 0 ".$filter;
	$sub_categ_list = $db->get_rows($query);
	$sub_categ_count= count($sub_categ_list); 
?>

<input type="hidden" name="statut" value ="1">

<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			
			<select id="id_categ"  name="id_categ" class="form-control" required >
				<?php foreach ($categs as $categ){?>
					<option value="<?php echo $categ['id'];?>" <?php if ($id_categ == $categ['id']) {echo "selected";}?> ><?php echo $categ['titre_fr'];?></option>
				<?php }?>
				<!--<option value="1">Génie Climatique</option>
					<option value="2">Génie Éléctrique</option>
					<option value="3">Supportage Lourd</option>
				<option value="4">Autres Gammes</option>-->
				
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
	<div class="col-md-2" style="display: none;">
		<div class="form-group">
			<label for="username" class="control-label">Ordre *:</label>
			<div class="controls">
				<select id="sub_categ_count"  name="rang" class="form-control"  >
					<?php   for($k=1;$k<= ($sub_categ_count + 1) ;$k++) {?>
						<option selected value="<?php echo $k;?>"><?php echo $k;?></option>
					<?php  }?>
				</select>
			</div>
		</div>
	</div>
</div>

<input type="hidden" name="action" value="add" />



<script>
	var $regions = $('#id_categ');
 	$regions.on('change', function() {
		var id_selected_categ = $(this).val();  
		if(id_selected_categ != '') {
			 
			
			var $sub_categ_count = $('#sub_categ_count');
			
			 
				$sub_categ_count.empty();
				$.ajax({
					url: 'module_ajax/categories/get_sub_categ_count.php',
					data: 'id_categ='+ id_selected_categ,  
					success: function(json) {
						json = $.parseJSON(json);
						$.each(json, function(index, value) {
							$sub_categ_count.append('<option selected value="'+ index +'">'+ value +'</option>');
						});
					}
				});
			 
			
			
		}
	});
	
	
	
	
	
	
	
	
	
	
</script>

<?php include_once '../../includes/config.inc.php';
	if(!isset($_GET['id']) && !is_numeric($_GET['id']))exit;
	$sub_categ = $db->get_row("SELECT sub_categ.* FROM sub_categ WHERE sub_categ.id=".$db->escape($_GET['id']));
	$id_categ=$sub_categ['id_categ'];
	$categs = $db->get_rows("SELECT categ.* FROM categ WHERE categ.deleted = 0 and categ.statut=1");
	
	
	
	$filter=" and id_categ=".$categs[0]['id'];
	$query="SELECT sub_categ.* FROM sub_categ WHERE statut = 1 and deleted = 0 ".$filter;
	$sub_categ_list = $db->get_rows($query);
	$sub_categ_count= count($sub_categ_list); 
?>


<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			
			<select id="id_categ"  name="id_categ" class="form-control" required >
				<?php foreach ($categs as $categ){?>
					<option value="<?php echo $categ['id'];?>" <?php if ($id_categ == $categ['id']) {echo "selected";}?> ><?php echo $categ['titre_fr'];?></option>
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
				<input type="text" class="form-control" id="titre_fr" name="titre_fr" required="required" value="<?php echo $sub_categ['titre_fr']?>" >
			</div>
		</div>
	</div>
	<div class="col-md-5">
		<div class="form-group">
			<label for="username" class="control-label">Titre (EN) *:</label>
			<div class="controls">
				<input type="text" class="form-control" id="titre_en" name="titre_en" required="required" value="<?php echo $sub_categ['titre_en']?>" >
			</div>
		</div>
	</div>
	<input type="hidden" name="old_rang" value ="<?php echo $sub_categ['rang'];?>">
	<div class="col-md-2">
		<div class="form-group">
			<label for="username" class="control-label">Ordre *:</label>
			<div class="controls">
				<select id="product_order"  name="rang" class="form-control"  >
					<?php   for($k=1;$k<= ($sub_categ_count ) ;$k++) {?>
						<option  value="<?php echo $k;?>" <?php if( $sub_categ['rang'] == $k) { echo "selected"; }?> ><?php echo $k;?></option>
					<?php  }?>
				</select>
			</div>
		</div>
	</div>
</div>

<input type="hidden" name="id" value="<?php echo $db->escape($_GET['id'])?>" />
<input type="hidden" name="action" value="edit" />
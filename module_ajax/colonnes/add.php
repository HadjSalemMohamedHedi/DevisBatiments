<?php include_once '../../includes/config.inc.php';
	$colonnes_types = $db->get_rows("SELECT colonnes_types.* FROM colonnes_types WHERE statut=1 and deleted=0");
	
 
	$max_id_corp = $db->get_row("SELECT max(id) as max_id FROM colonnes  ");
	$id_colonne= $max_id_corp['max_id'];
	$_SESSION['id_colonne']=$id_colonne+1;
	
	?>

<input type="hidden" name="statut" value ="1">


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
<div class="row" style="display: none;">
	<div class="col-md-12">
		<div class="form-group">
		 	<label for="username" class="control-label">Type *:</label>
			<div class="controls">
			<select id="id_type"  name="id_type" class="form-control"  >
			<?php foreach ($colonnes_types as $type){?>
			<option value="<?php echo $type['id'];?>" ><?php echo $type['type'];?></option>
			<?php }?>
			</select>
		</div>
		</div>
	</div>
</div>
 
<input type="hidden" name="action" value="add" />	
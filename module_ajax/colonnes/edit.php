<?php include_once '../../includes/config.inc.php';
	if(!isset($_GET['id']) && !is_numeric($_GET['id']))exit;
	$colonnes = $db->get_row("SELECT colonnes.* FROM colonnes WHERE colonnes.id=".$db->escape($_GET['id']));
  $colonnes_types = $db->get_rows("SELECT colonnes_types.* FROM colonnes_types WHERE statut=1 and deleted=0");

  	$_SESSION['id_colonne']=$_GET['id'];
 	$_SESSION['icon-colonne']=array();
	if ($colonnes['icon'] != ""){
	$_SESSION['icon-colonne'][0]=$colonnes['icon'];
	}
?>


 

<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="username" class="control-label">Titre (FR) *:</label>
			<div class="controls">
				<input type="text" class="form-control" id="titre_fr" name="titre_fr" required="required" value="<?php echo $colonnes['titre_fr']?>" >
			</div>
		</div>
	</div>
		<div class="col-md-6">
		<div class="form-group">
			<label for="username" class="control-label">Titre (EN) *:</label>
			<div class="controls">
				<input type="text" class="form-control" id="titre_en" name="titre_en" required="required" value="<?php echo $colonnes['titre_en']?>" >
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
			<option value="<?php echo $type['id'];?>" <?php if ($colonnes['id_type'] == $type['id']) {echo "selected";}?>  ><?php echo $type['type'];?></option>
			<?php }?>
			</select>
		</div>
		</div>
	</div>
</div>
<div class="row" style="display: none;margin-top:5px;">
	<div class="col-md-12">
		<div class="form-group">
			<label for="username" class="control-label">Icone :</label>
			<div class="controls">
				<iframe src="upload/upload-icon.php" style="    width: 100%;height:150px;"></iframe>
			</div>
		</div>
	</div>
</div>


<input type="hidden" name="id" value="<?php echo $db->escape($_GET['id'])?>" />
<input type="hidden" name="action" value="edit" />
<?php include_once '../../includes/config.inc.php';
	if(!isset($_GET['id']) && !is_numeric($_GET['id']))exit;
	$demande = $db->get_row("SELECT demandes.* FROM demandes WHERE demandes.id=".$db->escape($_GET['id']));

?>

<style type="text/css">
	.infosc > label{
		color: #000;
		font-size: 15px;
	}
</style>
<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-5">
		<div class="form-group infosc">
			<label for="firstname" class="control-label">Référence</label>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="lastname" class="control-label"><?php echo $demande['ref']?></label>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-5">
		<div class="form-group infosc">
			<label for="lastname" class="control-label">Titre</label>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="lastname" class="control-label"><?php echo $demande['titre']?></label>
		</div>
	</div>
</div>

 

<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-5">
		<div class="form-group infosc">
			<label for="lastname" class="control-label">Date </label>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="lastname" class="control-label"><?php echo date("d/m/Y", strtotime($demande['date']));  ?></label>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-5">
		<div class="form-group infosc">
			<label for="lastname" class="control-label">Statut</label>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?php 
				if($demande['statut'] == 'validé'){
					print '<span class="badge badge-success">Expédiée</span>';
				}else{
					print '<span class="badge badge-warning">En attente</span>';
				}
			?>
			<label for="lastname" class="control-label"><?php echo $demande['phone']?></label>
		</div>
	</div>
</div>
 
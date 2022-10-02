<?php include_once '../../includes/config.inc.php';

	if(!isset($_GET['id']) && !is_numeric($_GET['id']))exit;
	$commandes = $db->get_row("SELECT ordered_hx.* FROM ordered_hx WHERE id=".$db->escape($_GET['id']));

	$list_commande = $db->get_rows("SELECT produit_commande.* FROM produit_commande WHERE id_commande=". $commandes['id']);

?>

<div class="row">
	<div class="col-md-12">
		<div class="table-responsive" data-pattern="priority-columns" style="margin-bottom: 0px;">
			<table cellspacing="0" id="table-product" class="table table-small-font table-bordered table-striped">
				<thead>
					<tr>
						<th>Code article</th>
						<th>Désignation</th>
						<th>Quantité</th>
						<th>Prix</th>
						<th>Unité</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($list_commande as $key => $commande) { 
						$sous_produit = $db->get_row("SELECT sous_products_table.* FROM sous_products_table WHERE id=". $commande['id_sub_produit']);
						?>
						<tr>
							<td><?= $sous_produit['code_article'] ?></td>
							<td><?= $sous_produit['designation'] ?></td>
							<td><?= $commande['quantite'] ?></td>
							<td><?= $sous_produit['prix_final'] ?></td>
							<td><?= $sous_produit['unite'] ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

	<div class="modal-footer"> 
	<div id="loader" style="display: inline;"></div>
	<button type="button" class="btn btn-white" data-dismiss="modal">Fermer</button> 
	</div>

<style type="text/css">
	.infosc > label{
		color: #000;
		font-size: 15px;
	}
</style><!--
<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-5">
		<div class="form-group infosc">
			<label for="firstname" class="control-label">Référence</label>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="lastname" class="control-label"><?php /*echo $demande['ref']?></label>
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
			<label for="lastname" class="control-label"><?php echo $demande['phone'] **/ ?></label>
		</div>
	</div>
</div>
 -->
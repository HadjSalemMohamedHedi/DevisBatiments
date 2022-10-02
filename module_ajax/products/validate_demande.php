<?php  include_once '../../includes/config.inc.php';

 
$demande = $db->get_row("SELECT demandes.* FROM demandes WHERE demandes.id = ".$_POST['id_demande']);
	
$values = array();

$values['statut'] = 'validé';

$db->update('demandes',$values,$_POST['id_demande']);


echo '<div class="alert alert-success alert-dismissible fade in">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				<strong>Success:</strong>Mise à jour effectué avec succès.</div>';
?>
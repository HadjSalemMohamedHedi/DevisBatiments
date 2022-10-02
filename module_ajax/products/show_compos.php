<?php include_once '../../includes/config.inc.php';
if(!isset($_GET['id']) && !is_numeric($_GET['id']))exit;

$id_demande=$_GET['id'];

$demande = $db->get_row("SELECT demandes.* FROM demandes WHERE demandes.id = ".$id_demande);

$composants = $db->get_rows("SELECT composants.* FROM composants WHERE composants.id_demande = ".$demande['id']);

 
?>

<input type="hidden" name="id_sub_categ" value ="<?php echo $id_categ;?>">

<div class="row">
	<div class="col-md-12">

		
		<div class="table-responsive" data-pattern="priority-columns" style="margin-bottom: 0px;">
			<table cellspacing="0" id="table-product" class="table table-small-font table-bordered table-striped">
				<thead>
					<tr>
						<th>Nom</th>
						<th>Quantite</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($composants as $key => $composant) { 
  						?>
						<tr>
							<td><?php echo $composant['nom_composant']; ?></td>
							<td><?php echo $composant['quantite']; ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			
		</div>

	</div>
	
</div>
	
	
	<input type="hidden" name="id" value="<?php echo $db->escape($_GET['id'])?>" />
	<input type="hidden" name="action" value="edit_column_table" />
	
	
	<div class="modal-footer"> 
	<div id="loader" style="display: inline;"></div>
	<button type="button" class="btn btn-white" data-dismiss="modal">Fermer</button>

	<?php if($demande['statut'] != 'validé'){ ?>
	<button type="button" onclick="validate_table('<?php echo $db->escape($_GET['id'])?>');"  id="submit-edit-column" class="btn btn-info">Valider</button>
<?php } ?>
	</div>
	
	
	<script>

	function validate_table(id_demande){
		var tab_elem=new Array;
		var elem=0;
		document.getElementById("loader").innerHTML='<img src="assets/images/loader1.gif" class="loader" />'; 
		jQuery.ajax({
			type: "POST",
			url: "module_ajax/products/validate_demande.php",
			data: { id_demande : id_demande },   
			success: function(response){
			
				$('#msg-edit-table').show().html( response );
				$('#msg-edit-table').slideDown();
				
				if(response.match('success') != null){
					document.getElementById("loader").innerHTML=''; 	
					
					window.setTimeout(function () {
					$('#ultraModal-edit-table').modal('hide');
					$('#msg-edit-table').hide();
					window.location.href = "";
					}, 1000);
				}
			}
		});
	}
	
	</script>
	
	
		
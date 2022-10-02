<?php include_once '../../includes/config.inc.php';
	if(!isset($_GET['id']) && !is_numeric($_GET['id']))exit;
	/* $sub_categ = $db->get_row("SELECT sub_categ.* FROM sub_categ WHERE sub_categ.id=".$db->escape($_GET['id']));
	$id_categ=$sub_categ['id']; */
	
	$id_categ=$_GET['id'];
	
	$colonnes = $db->get_rows("SELECT colonnes.* FROM colonnes WHERE colonnes.deleted = 0 and colonnes.statut=1");
	
	
	
	$sub_categ_column = $db->get_rows("SELECT  sub_categ_column.* FROM sub_categ_column WHERE sub_categ_column.id_sub_categ =".$id_categ);

	
 
?>

<input type="hidden" name="id_sub_categ" value ="<?php echo $id_categ;?>">

<div class="row">
	<div class="col-md-12">
		<h4>Liste des colonnes</h4>
		<select name="colonnes[]" class="multi-select" multiple="" id="my_multi_select3" >
			
			<?php foreach ($colonnes as $colonne){
				$selected="";
				if (exist_in_array($colonne['id'],$sub_categ_column,'id_colonnes')){
				$selected="selected";
				}
				?>
				<option value="<?php  echo $colonne['id'];?>" <?php echo $selected;?>><?php  echo $colonne['titre_fr'];?></option>
				
			<?php }?>
		</select>
		
		
	</div>
	
	</div>
	
	<input type="hidden" name="id" value="<?php echo $db->escape($_GET['id'])?>" />
	<input type="hidden" name="action" value="edit_column_table" />
	

<script>
	$('#my_multi_select3').multiSelect({
		selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='rechercher...'>",
		selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='rechercher...'>",
		afterInit: function(ms) {
			var that = this,
			$selectableSearch = that.$selectableUl.prev(),
			$selectionSearch = that.$selectionUl.prev(),
			selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
			selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';
			
			that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
			.on('keydown', function(e) {
				if (e.which === 40) {
					that.$selectableUl.focus();
					return false;
				}
			});
			
			that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
			.on('keydown', function(e) {
			if (e.which == 40) {
			that.$selectionUl.focus();
			return false;
			}
			});
			},
			afterSelect: function() {
			this.qs1.cache();
			this.qs2.cache();
			},
			afterDeselect: function() {
			this.qs1.cache();
			this.qs2.cache();
			}
			});
			
			</script>
						
<?php include_once '../../includes/config.inc.php';
	$countrys = $db->get_rows("SELECT * FROM country INNER JOIN country_lang ON country.id_country=country_lang.id_country WHERE  country_lang.id_lang='1'");
?> 


<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="titre_fr" class="control-label">Tag *:</label>
			<div class="controls">
				<input type="text" class="form-control" id="titre_fr" name="titre_fr" required="required" >
			</div>
		</div>
	</div>
</div>






 


 
<input type="hidden" name="action" value="add" />	
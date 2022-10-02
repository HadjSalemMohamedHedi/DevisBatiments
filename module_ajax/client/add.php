<?php include_once '../../includes/config.inc.php';
	$countrys = $db->get_rows("SELECT * FROM country INNER JOIN country_lang ON country.id_country=country_lang.id_country WHERE  country_lang.id_lang='1'");
?>
<!--<h3>Détail</h3>
<hr>-->




<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="lastname" class="control-label">Nom *:</label>
			<div class="controls">
				<input type="text" class="form-control" id="lastname" name="lastName" required="required" >
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="firstname" class="control-label">Prénom *:</label>
			<div class="controls">
				<input type="text" class="form-control" id="firstname" name="firstName" required="required" >
			</div>
		</div>
	</div>
</div>

<div class="row">
 
	<div class="col-md-6">
		<div class="form-group">
			<label for="email" class="control-label">Email :</label>
			<div class="controls">
				<input type="email" class="form-control" id="email" name="email">
			</div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="form-group">
			<label for="password" class="control-label">Mot de passe *:</label>
			<div class="controls">
				<input type="password" class="form-control" id="password" name="password" required="required" >
			</div>
		</div>
	</div>

</div>

 
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="phone" class="control-label">Téléphone :</label>
			<input type="text" class="form-control" id="phone" name="phone">
		</div>
	</div>
 	<div class="col-md-6">
		<div class="form-group">
			<label for="phone" class="control-label">Spécialité :</label>
			<input type="text" class="form-control" id="activity" name="activity">
		</div>
	</div>

</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="address" class="control-label">Adresse :</label>
			<input type="text" class="form-control" id="address" name="address">
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="adressliv" class="control-label">Adresse de livraison :</label>
			<input type="text" class="form-control" id="adressliv" name="adressliv">
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label for="country" class="control-label">Pays :</label>
			<input type="text" class="form-control" id="country" name="country">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label for="ville" class="control-label">Ville :</label>
			<input type="text" class="form-control" id="ville" name="ville">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label for="cplocalite" class="control-label">Code postal :</label>
			<input type="text" class="form-control" id="cplocalite" name="cplocalite">
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="societe" class="control-label">Société :</label>
			<input type="text" class="form-control" id="societe" name="societe">
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="activate" class="control-label">Statut:</label>
			<select class="form-control" id="activate" name="activate">
				<option value="1">Actif</option>
				<option value="0">Inactif</option>
			</select>
		</div>
	</div>
</div>

</div>
<input type="hidden" name="action" value="add" />	
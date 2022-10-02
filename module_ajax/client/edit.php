<?php include_once '../../includes/config.inc.php';
	if(!isset($_GET['id']) && !is_numeric($_GET['id']))exit;
	$client = $db->get_row("SELECT client.* FROM client WHERE client.id=".$db->escape($_GET['id']));
	$countrys = $db->get_rows("SELECT * FROM country INNER JOIN country_lang ON country.id_country=country_lang.id_country WHERE  country_lang.id_lang='1'");
?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="firstname" class="control-label">Nom*:</label>
			<div class="controls">
				<input type="text" class="form-control" id="firstname" name="firstname" required="required"  value="<?php echo $client['firstname']?>">
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="lastname" class="control-label">Prénom*:</label>
			<div class="controls">
				<input type="text" class="form-control" id="lastname" name="lastname" required="required" value="<?php echo $client['lastname']?>">
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="username" class="control-label">Nom d'utilisateur *:</label>
			<div class="controls">
				<input type="text" class="form-control" id="username" name="username" required="required" value="<?php echo $client['username']?>" >
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="email" class="control-label">Email :</label>
			<div class="controls">
				<input type="text" class="form-control" id="email" name="email" value="<?php echo $client['email']?>">
			</div>
		</div>
	</div>
	
</div>
	<label><input type="checkbox" id="change_pass"  name="change_pass" onclick="show_change_pass();">Changer le mot de passe</label>
	 
<div class="row" id="bloc_change_pass" style="display:none;">
	<div class="col-md-6">
		<div class="form-group">
			<label for="password" class="control-label">Mot de passe *:</label>
			<div class="controls">
				<input type="password" class="form-control" id="password" name="password" >
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="cpassword" class="control-label">Confirmation Mot de passe *:</label>
			<div class="controls">
				<input type="password" class="form-control" id="cpassword" name="cpassword" >
			</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="phone" class="control-label">Téléphone :</label>
			<input type="text" class="form-control" id="phone" name="phone" value="<?php echo $client['phone']?>">
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="mobile" class="control-label">Téléphone 2:</label>
			<input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $client['mobile']?>">
		</div>
	</div>
</div>


<div class="row">
	<div class="col-md-8">
		<div class="form-group">
			<label for="adresse" class="control-label">Adresse :</label>
			<input type="text" class="form-control" id="adresse" name="adresse" value="<?php echo $client['adresse']?>">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label for="zip_code" class="control-label">Code postal :</label>
			<input type="text" class="form-control" id="zip_code" name="zip_code" value="<?php echo $client['zip_code']?>">
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="form-group">
			<label for="id_country">Pays :</label>
			<select id="id_country"  name="id_country" class="form-control" required >
				<option value="">=======</option>
				<?php foreach($countrys as $k=>$v): ?>
				<option value="<?php echo $v['id_country'];?>" <?php if($v['id_country']==$client['id_country']){?> selected="selected" <?php }?>><?php echo $v['name'];?></option>
				<?php endforeach;?>
			</select>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="statut" class="control-label">Active:</label>
			<select class="form-control" id="statut" name="statut">
				<option value="1" <?php if('1'==$client['statut']){?> selected="selected" <?php }?>>Actif</option>
				<option value="0" <?php if('0'==$client['statut']){?> selected="selected" <?php }?>>Inactif</option>
			</select>
		</div>
	</div>
	
</div>
<input type="hidden" name="id" value="<?php echo $db->escape($_GET['id'])?>" />
<input type="hidden" name="action" value="edit" />
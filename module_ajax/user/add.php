<?php 
	include_once '../../includes/config.inc.php';
?>

<h3>paramètres de connexion</h3>
<hr>
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label for="id_responsible">Responsable: *</label>
      <select id="id_responsible"  name="id_responsible" class="form-control" required  <? if($_SESSION['User']['classe']=='4'){?>disabled="disabled" <? }?>>
        <option value="">=======</option>
        <?php foreach($responsibles as $x=>$y): ?>
        <option value="<?php echo $y['id'];?>" <? if($_SESSION['User']['classe']=='4' && $_SESSION['User']['id']==$y['id']){?> selected="selected"<? }?> ><?php echo $y['firstname'].' '.$y['lastname'];?></option>
        <?php endforeach;?>
      </select>
    </div>
  </div>
  <div class="col-md-12">
    <div class="form-group">
      <label for="username" class="control-label">Nom d'utilisateur*:</label>
      <div class="controls">
        <input type="text" class="form-control" id="username" name="username" required="required" >
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="password" class="control-label">Mot de passe: *</label>
      <div class="controls">
        <input type="password" class="form-control" id="password" name="password" required="required" >
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="cpassword" class="control-label">Confirmer mot de passe:*</label>
      <div class="controls">
        <input type="password" class="form-control" id="cpassword" name="cpassword" required="required" >
      </div>
    </div>
  </div>
</div>
<h3>Détail</h3>
<hr>
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="firstname" class="control-label">Nom*:</label>
      <div class="controls">
        <input type="text" class="form-control" id="firstname" name="firstname" required="required" >
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="lastname" class="control-label">Prénom*:</label>
      <div class="controls">
        <input type="text" class="form-control" id="lastname" name="lastname" required="required">
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label for="email" class="control-label">Email :</label>
      <div class="controls">
        <input type="text" class="form-control" id="email" name="email">
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
</div>
<div class="row">
  <div class="col-md-8">
    <div class="form-group">
      <label for="address" class="control-label">Adresse :</label>
      <input type="text" class="form-control" id="address" name="address">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label for="postcode" class="control-label">Code postal :</label>
      <input type="text" class="form-control" id="postcode" name="postcode">
    </div>
  </div>
  <div class="col-md-12">
    <div class="form-group">
      <label for="id_country">Pays :</label>
      <select id="id_country"  name="id_country" class="form-control" required >
        <option value="">=======</option>
        <?php foreach($countrys as $k=>$v): ?>
        <option value="<?php echo $v['id_country'];?>"><?php echo $v['name'];?></option>
        <?php endforeach;?>
      </select>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="status" class="control-label">Active:</label>
      <select class="form-control" id="status" name="status">
        <option value="1">Actif</option>
        <option value="0">Inactif</option>
      </select>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="form-label" for="daterange-1">Couleur</label>
      <div class="input-group"> <span class="input-group-addon"> <i class="sel-color" style="background-color:#fff;"></i> </span>
        <input type="text" class="form-control colorpicker" name="color" data-format="hex" value="" >
      </div>
    </div>
  </div>
</div>

<input type="hidden" name="action" value="add" />

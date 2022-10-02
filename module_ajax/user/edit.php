<?php 
	include_once './includes/config.inc.php';
	if(!isset($_GET['id']) && !is_numeric($_GET['id'])){
		exit;
	}
	$filter_add='';
	if($_SESSION['User']['classe']=='2'){$filter_add.=" AND id_contributor='".$_SESSION['User']['id']."'";}
	
	 $user = $db->get_row("SELECT users.* FROM users WHERE users.id=".$db->escape($_GET['id']));
     $countrys = $db->get_rows("SELECT * FROM country INNER JOIN country_lang ON country.id_country=country_lang.id_country WHERE  country_lang.id_lang='1'");
	 $responsibles = $db->get_rows("SELECT users.* FROM users WHERE users.id!=0 AND users.classe='4'  AND status !=0 AND deleted=0 $filter_add ORDER BY users.created");
?>

<h3>paramètres de connexion</h3><hr>
<div class="row">
<div class="col-md-12">
    <div class="form-group">
      <label for="id_responsible">Responsable: *</label>
      <select id="id_responsible"  name="id_responsible" class="form-control" required <? if($_SESSION['User']['classe']=='4'){?>disabled="disabled" <? }?>>
        <option value="">=======</option>
        <?php foreach($responsibles as $x=>$y): ?>
        <option value="<?php echo $y['id'];?>"  <?php if($y['id']==$user['id_responsible']){?> selected="selected" <?php }?>><?php echo $y['firstname'].' '.$y['lastname'];?></option>
        <?php endforeach;?>
      </select>
    </div>
  </div>
  <div class="col-md-12">
    <div class="form-group">
      <label for="username" class="control-label">Nom d'utilisateur*:</label>
      <div class="controls">
        <input type="text" class="form-control" id="username" name="username" required="required"  value="<?=$user['username']?>">
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="password" class="control-label">Mot de passe: *</label>
      <div class="controls">
        <input type="password" class="form-control" id="password" name="password" <? if($user['password']==''){ ?>required="required" <? }?>>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="cpassword" class="control-label">Confirmer mot de passe:*</label>
      <div class="controls">
        <input type="password" class="form-control" id="cpassword" name="cpassword" <? if($user['password']==''){ ?>required="required" <? }?> >
      </div>
    </div>
  </div>
</div>
<h3>Détail</h3><hr>
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="firstname" class="control-label">Nom*:</label>
      <div class="controls">
        <input type="text" class="form-control" id="firstname" name="firstname" required="required"  value="<?=$user['firstname']?>">
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="lastname" class="control-label">Prénom*:</label>
      <div class="controls">
        <input type="text" class="form-control" id="lastname" name="lastname" required="required" value="<?=$user['lastname']?>">
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label for="email" class="control-label">Email :</label>
      <div class="controls">
        <input type="text" class="form-control" id="email" name="email" value="<?=$user['email']?>">
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="phone" class="control-label">Téléphone :</label>
      <input type="text" class="form-control" id="phone" name="phone" value="<?=$user['phone']?>">
    </div>
  </div>
</div>


<div class="row">
 <div class="col-md-8">
    <div class="form-group">
      <label for="address" class="control-label">Adresse :</label>
      <input type="text" class="form-control" id="address" name="address" value="<?=$user['address']?>">
    </div>
  </div>
 <div class="col-md-4">
    <div class="form-group">
      <label for="postcode" class="control-label">Code postal :</label>
      <input type="text" class="form-control" id="postcode" name="postcode" value="<?=$user['postcode']?>">
    </div>
  </div>

  <div class="col-md-12">
    <div class="form-group">
      <label for="id_country">Pays :</label>
      <select id="id_country"  name="id_country" class="form-control" required >
        <option value="">=======</option>
        <?php foreach($countrys as $k=>$v): ?>
        <option value="<?php echo $v['id_country'];?>" <?php if($v['id_country']==$user['id_country']){?> selected="selected" <?php }?>><?php echo $v['name'];?></option>
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
      <div class="input-group"> <span class="input-group-addon"> <i class="sel-color" style="background-color:<?=$user['color']?>;"></i> </span>
        <input type="text" class="form-control colorpicker" name="color" data-format="hex" value="<?=$user['color']?>" >
      </div>
    </div>
  </div>
</div>
<input type="hidden" name="id" value="<?=$db->escape($_GET['id'])?>" />
<input type="hidden" name="classe" value="3" />
<input type="hidden" name="action" value="edit" />
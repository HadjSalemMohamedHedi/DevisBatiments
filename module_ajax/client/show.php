<?php include_once '../../includes/config.inc.php';
	if(!isset($_GET['id']) && !is_numeric($_GET['id']))exit;
	$client = $db->get_row("SELECT clients.* FROM clients WHERE clients.id=".$db->escape($_GET['id']));

?>

<style type="text/css">
	.infosc > label{
		color: #000;
		font-size: 15px;
	}
@import url("https://fonts.googleapis.com/css?family=Montserrat:200,300,400,400i,700");
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
}


.face__name{
	font-weight: 800;
	font-family: Montserrat, sans-serif;
	color: #123;
	 margin-left: -38%;
    margin-top: -6%;
}
.card{ 
  max-width: 100%;
  text-align: center;
  
  background: white;
}
.card header {
  background-image: url('../../assets/img/about/banniere-about-us-site-hydrex-international.jpg');
  height: 120px;
  
     margin-bottom: 89px;
}
.card header img {
  margin: 70px 40px 10px 40px;
  border-radius: 50%;
  height: 100px;
  width: 100px;
  border: 6px solid white;
  	margin-left: -67%;
}

.card_body{
  margin-top: 60px;
      box-shadow: -4px 10px 16px 13px #eee;
    width: 95%;
    margin: 3%;
    padding: 3%;
}
.card_body ul.social{
  display: flex;
  list-style: none;  
  margin-bottom: 40px;
  justify-content: space-around;
}
.card_body ul.social li{
  cursor: pointer;
}


.modal-body{
	padding: 0px!important;
}
.form-group{
	margin:2%;
}
</style>











<div class="card">
  <header>    
    <img src='https://hydrex-international.com/beta-hydrex/back-hydrex/images/avatar.png' alt=''>
    <p class="face__name"><?php echo $client['firstName']," ",$client['lastName'] ?></p>
  </header>
  <div class="card_body">




 

<div class="row">
	<div class="col-md-6">
		<div class="form-group infosc">
			<label for="lastname" class="control-label">E-mail</label>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="lastname" class="control-label"><?php echo $client['email']?></label>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group infosc">
			<label for="lastname" class="control-label">Numéro de téléphone</label>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="lastname" class="control-label"><?php echo $client['phone']?></label>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group infosc">
			<label for="lastname" class="control-label">Spécialité</label>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="lastname" class="control-label"><?php echo $client['activity']?></label>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group infosc">
			<label for="lastname" class="control-label">Société</label>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="lastname" class="control-label"><?php echo $client['societe']?></label>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group infosc">
			<label for="lastname" class="control-label">Adresse</label>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="lastname" class="control-label"><?php echo $client['address']?></label>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group infosc">
			<label for="lastname" class="control-label">Adresse de livraison</label>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="lastname" class="control-label"><?php echo $client['adressliv']?></label>
		</div>
	</div>
</div>

  </div>
</div>
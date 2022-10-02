<?php include_once '../../includes/config.inc.php'; 

	$_SESSION['images-actualite']=array();
	$max_id_corp = $db->get_row("SELECT max(id) as max_id FROM actualites  ");
	$id_actualite= $max_id_corp['max_id'];
	$_SESSION['id_actualite']=$id_actualite+1;
?>

<div class="row">
		<div class="col-md-6">
		<div class="form-group">
			<label for="username" class="control-label">Titre (FR) *:</label>
			<div class="controls">
				<input type="text" class="form-control" id="titre_fr" name="titre_fr" required="required" >
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="username" class="control-label">Titre (EN) *:</label>
			<div class="controls">
				<input type="text" class="form-control" id="titre_en" name="titre_en" required="required" >
			</div>
		</div>
	</div>
</div>

<div class="row">
 
	<div class="col-md-6">
		<div class="form-group">
			<label for="email" class="control-label">Date début :</label>
			<div class="controls">
				<input type="date" class="form-control" id="date_debut" name="date_debut">
			</div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="form-group">
			<label for="password" class="control-label">Date fin :</label>
			<div class="controls">
				<input type="date" class="form-control" id="date_fin" name="date_fin"  >
			</div>
		</div>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-12">
		<label for="phone" class="control-label">Brève description: </label>
		<ul class="nav nav-tabs transparent">
			<li class="active">
				<a href="#brevdesc-fr" data-toggle="tab">
				Description FR
				</a>
			</li>
			<li>
				<a href="#brevdesc-en" data-toggle="tab">
				Description EN 
				</a>
			</li>
		</ul>
		
		<div class="tab-content transparent">
			<div class="tab-pane fade in active" id="brevdesc-fr">
				<div>
					<textarea id="editor_fr2" name="brev_description" class="bootstrap-wysihtml5-textarea" placeholder="Brève description (max 130 caractères) ..." style="width: 100%; height: 150px; font-size: 14px; line-height: 23px;padding:15px;"></textarea>
				</div>
			</div>
			<div class="tab-pane fade" id="brevdesc-en">
				<textarea  id="editor_en2" name="brev_description_en" class="bootstrap-wysihtml5-textarea" placeholder="Brief description (max 130 characters) ..." style="width: 100%; height: 150px; font-size: 14px; line-height: 23px;padding:15px;"></textarea>
			</div>
		</div>
	</div>
	
</div>

<div class="row">
	<div class="col-md-12">
		<label for="phone" class="control-label">Description: </label>
		<ul class="nav nav-tabs transparent">
			<li class="active">
				<a href="#desc-fr" data-toggle="tab">
				Description FR
				</a>
			</li>
			<li>
				<a href="#desc-en" data-toggle="tab">
				Description EN 
				</a>
			</li>
			
		</ul>
		
		<div class="tab-content transparent">
			<div class="tab-pane fade in active" id="desc-fr">
				<div>
					<textarea  id="editor_fr" name="description" class="bootstrap-wysihtml5-textarea" placeholder="Description ..." style="width: 100%; height: 150px; font-size: 14px; line-height: 23px;padding:15px;"></textarea>
				</div>
			</div>
			<div class="tab-pane fade" id="desc-en">
				<textarea  id="editor_en" name="description_en" class="bootstrap-wysihtml5-textarea" placeholder="Description ..." style="width: 100%; height: 150px; font-size: 14px; line-height: 23px;padding:15px;"></textarea>
			</div>
		</div>
	</div>
	
</div>

<div class="row" style="margin-top:5px;">
	
	<div class="col-md-12">
		<div class="form-group">
			<label for="username" class="control-label">Images :</label>
			<div class="controls">
				<iframe src="upload/uploadact.php" style="width: 100%;height:250px;"></iframe>
			</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="activate" class="control-label">Statut:</label>
			<select class="form-control" id="activate" name="status">
				<option value="1">Actif</option>
				<option value="0">Inactif</option>
			</select>
		</div>
	</div>
</div>

</div>
<input type="hidden" name="action" value="add" />	
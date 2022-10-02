<?php include_once '../../includes/config.inc.php';
	if(!isset($_GET['id']) && !is_numeric($_GET['id']))exit;
	
	$id_product=$_GET['id'];
	$product = $db->get_row("SELECT products.* FROM products WHERE products.id = ".$id_product);
	
	//categorie  produit 
	$sub_categ = $db->get_row("SELECT * FROM `sub_categ` WHERE `id` =".$product['id_sub_categ']);	
	
	$sub_categ_columns = $db->get_rows("SELECT  sub_categ_column.* FROM sub_categ_column WHERE sub_categ_column.id_sub_categ =".$sub_categ['id']);
	
	
	$colonnes_boutons = $db->get_rows("SELECT  colonnes_boutons.* FROM colonnes_boutons WHERE statut = 1 and deleted = 0");

	
?>

<input type="hidden" name="id_sub_categ" value ="<?php echo $id_categ;?>">

<div class="row">
	<div class="col-md-12">
		<div class="btn-group dropdown-btn-group pull-right">
			<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">liste des colones<span class="caret"></span>
			</button>
			<ul class="dropdown-menu">
				<?php foreach ($sub_categ_columns as $sub_categ_column){
					
					$colonne = $db->get_row("SELECT * FROM `colonnes` WHERE `id` =".$sub_categ_column['id_colonnes']);	
				?>
				<li class="checkbox-row">
					<input type="checkbox" name="list-column" checked id="id-col-<?php echo $colonne['id'];?>"> 
					<label for="id-col-<?php echo $colonne['id'];?>"><?php echo $colonne['titre_fr'];?></label>
				</li>
				
				<?php }?>
				
				
				
			</ul>
		</div>
		<div class="table-responsive" data-pattern="priority-columns" style="margin-bottom: 0px;">
			<table cellspacing="0" id="table-product" class="table table-small-font table-bordered table-striped">
				<thead>
					<tr>
						<?php foreach ($sub_categ_columns as $sub_categ_column){
							$colonne = $db->get_row("SELECT * FROM `colonnes` WHERE `id` =".$sub_categ_column['id_colonnes']);	
						?>
						<th class="col-<?php echo $colonne['id'];?>"><?php echo $colonne['titre_fr'];?></th>
						<?php }?>
						<th></th>
					</tr>
				</thead>
				<tbody>
					
					
				</tbody>
			</table>
			
		</div>
		<span data-class="plus-square" style=" color: rgba(25, 150, 18, 0.83);">
			<i class="fa fa-plus-square"></i>
			<span onclick='show_bloc_add_line();' style="font-size: 14px;cursor:pointer;">Ajouter une ligne</span>
		</span>
	</div>
	
</div>
<div class="row new_line" style="box-shadow: 0px 5px 27px 10px #888888;display:none;">
	<button type="button" onclick='annuler();' class="close" style="margin:1%;"  >×</button>
	<div class="col-md-10">
		
		<div class="row">
			
			<?php foreach ($sub_categ_columns as $sub_categ_column){
				$colonne = $db->get_row("SELECT * FROM `colonnes` WHERE `id` =".$sub_categ_column['id_colonnes']);	
				$colonnes_type = $db->get_row("SELECT colonnes_types.* FROM colonnes_types WHERE id=".$colonne['id_type']);
			?>
			
			
			<div class="col-md-4 col-<?php echo $colonne['id'];?>">
				<div class="form-group">
					<label  class="control-label"><?php echo $colonne['titre_fr'];?> :</label>
					<div class="controls">
						<?php if ($colonnes_type['type'] == BUTTON_TYPE) {?>
							<select class="s2example-22"  id="col-<?php echo $colonne['id'];?>" name="col-<?php echo $colonne['id'];?>"  multiple>
								<?php foreach ($colonnes_boutons as $bouton){?>
									<option value="<?php echo $bouton['id'];?>" ><?php echo $bouton['titre_fr'];?></option>
								<?php }?>
							</select>
							<?php } else {?>
							<input type="text" class="form-control" id="col-<?php echo $colonne['id'];?>" name="col-<?php echo $colonne['id'];?>"  >
						<?php }?>
						
					</div>
				</div>
			</div>
			<?php }?>
			
		</div>
	</div>
	<div class="col-md-2"> 
	</div>
	<div class="col-md-12">
		<button type="button" class="btn btn-white" onclick='add_line();' style="     float: right; background-color: rgba(25, 150, 18, 0.83);color:white;font-size:13px;margin:2%; ">Ajouter la ligne</button>
		
	</div>
</div>





<input type="hidden" name="id" value="<?php echo $db->escape($_GET['id'])?>" />
<input type="hidden" name="action" value="edit_column_table" />


<div class="modal-footer"> 
	<div id="loader" style="display: inline;"></div>
	<button type="button" class="btn btn-white" data-dismiss="modal">Fermer</button>
	<button type="button" onclick="validate_table('<?php echo $db->escape($_GET['id'])?>');"  id="submit-edit-column" class="btn btn-info">Valider</button>
</div>



<script>
	
	var total_line=0;
	<?php foreach ($sub_categ_columns as $sub_categ_column){?>
		$('#id-col-<?php echo $sub_categ_column['id_colonnes'];?>').change(function() {
		if($(this).is(":checked")) {
		
		$(".col-<?php echo $sub_categ_column['id_colonnes'];?>").show();
		return;
		}
		$(".col-<?php echo $sub_categ_column['id_colonnes'];?>").hide();	
		});
		
		
	<?php }?>
	var colonnes_boutons_json = <?php echo json_encode($colonnes_boutons) ?>;	
	function show_bloc_add_line(){
	
	
	var tr='<tr id="line-'+total_line+'">';
	<?php foreach ($sub_categ_columns as $sub_categ_column){
		$colonne = $db->get_row("SELECT * FROM `colonnes` WHERE `id` =".$sub_categ_column['id_colonnes']);	
		$colonnes_type = $db->get_row("SELECT colonnes_types.* FROM colonnes_types WHERE id=".$colonne['id_type']);
	?>
	var input='';
	if($('#id-col-<?php echo $sub_categ_column['id_colonnes'];?>').is(":checked")) {
	<?php if ($colonnes_type['type'] == BUTTON_TYPE) {?>
		input+='<select class="s2example-'+total_line+'"  id="col-<?php echo $colonne['id'];?>-'+total_line+'" name="col-<?php echo $colonne['id'];?>-'+total_line+'"  multiple>';
		<?php foreach ($colonnes_boutons as $bouton){?>
			input+='<option value="<?php echo $bouton['id'];?>" ><?php echo $bouton['titre_fr'];?></option>';
		<?php }?>
		input+='</select>';
		<?php } else {?>
		input='<input type="text" class="form-control" id="col-<?php echo $colonne['id'];?>-'+total_line+'" name="col-<?php echo $colonne['id'];?>-'+total_line+'"  >';
	<?php }?>
	
	var th='<th class="col-<?php echo $colonne['id'];?>">'+input+'</th>';
	
	tr+=th;
	}
	<?php }?> 
	var col_id='col-<?php echo $colonne['id'];?>-';
	
	tr+='<th> <span onclick="validate_row( \''+total_line+'\' );" data-class="times" style="cursor:pointer"><i class="fa fa-check"></i></span> <span  onclick="delete_row( \''+total_line+'\' );" data-class="times" style="margin-left:4px;cursor:pointer"><i class="fa fa-remove"></i></span></th>';
	
	tr+='</tr>';
	$('#table-product tr:last').after(tr);
	
	$(".s2example-"+total_line).select2();
	
	total_line++;
	
	var vph = $(window).height();vph+=(35*total_line); $(".modal-backdrop").css({"height": vph+"px"});
	
	
	
	}
	function annuler(){
	
	$(".new_line").hide();
	resetAllValues();
	}
	
	
	function validate_row(line_id)
	
	{
	//alert(col_id+" ----- "+line_id);
	var tr='<tr id="line-'+line_id+'">';
	var v='';
	<?php foreach ($sub_categ_columns as $sub_categ_column){
		$colonne = $db->get_row("SELECT * FROM `colonnes` WHERE `id` =".$sub_categ_column['id_colonnes']);	
		$colonnes_type = $db->get_row("SELECT colonnes_types.* FROM colonnes_types WHERE id=".$colonne['id_type']);
	?>
	
	v=  $("#col-<?php echo $sub_categ_column['id_colonnes'];?>-"+line_id).val();	
	
	
	if($('#id-col-<?php echo $sub_categ_column['id_colonnes'];?>').is(":checked")) {
	
	<?php if ($colonnes_type['type'] == BUTTON_TYPE) {?>
		
		var count=$('.s2example-'+line_id).select2("val").length;
		var hidden_val="";
		var th='<th class="col-<?php echo $sub_categ_column['id_colonnes'];?>"  id="col-<?php echo $sub_categ_column['id_colonnes'];?>-'+line_id+'"  >';
		for(var i=0;i<count;i++)
		{
		var id_btn=$('.s2example-'+line_id).select2("val")[i];
		var btn="";
		
		var input_hidden="";
		for(var j=0;j<colonnes_boutons_json.length;j++)
		{
		if (colonnes_boutons_json[j]['id'] == id_btn )
		{
		btn+="<button type='button' class='btn btn-primary  btn-table' style='    margin: 2px;background-color:"+colonnes_boutons_json[j]['color']+"'>"+colonnes_boutons_json[j]['titre_fr']+"</button>";
		hidden_val+=id_btn+',';
		}  
		}  
		//var btn=colonnes_boutons_json[0]['titre_fr'];
		
		th+=btn;
		} 
		hidden_val = hidden_val.slice(0, -1);
		input_hidden='<input type="hidden" id="btn-val-'+line_id+'" value="'+hidden_val+'">';
		th+=input_hidden+'</th>';
		tr+=th; 
		<?php }else{?>
		tr+='	<th class="col-<?php echo $sub_categ_column['id_colonnes'];?>" id="col-<?php echo $sub_categ_column['id_colonnes'];?>-'+line_id+'" >'+v+'</th>';
	<?php }?>
	
	}else{
	tr+='<th style="display:none;" class="col-<?php echo $sub_categ_column['id_colonnes'];?>"></th>';
	}
	
	
	<?php }?>
	tr+='<th> <span onclick="edit_row( \''+line_id+'\' );" data-class="times" style="cursor:pointer"><i class="fa fa-pencil"></i></span> <span onclick="delete_row( \''+line_id+'\' );" data-class="times" style="margin-left:4px;cursor:pointer"><i class="fa fa-remove"></i></span></th>';
	
	tr+='</tr>';
	
	//$('#table-product tr:last').after(tr);
	
	$('#line-' + line_id).replaceWith(tr);
	
	
	
	
	}
	
	function edit_row(line_id)
	{
	
	
	var tr='<tr id="line-'+line_id+'">';
	<?php foreach ($sub_categ_columns as $sub_categ_column){
		$colonne = $db->get_row("SELECT * FROM `colonnes` WHERE `id` =".$sub_categ_column['id_colonnes']);	
		$colonnes_type = $db->get_row("SELECT colonnes_types.* FROM colonnes_types WHERE id=".$colonne['id_type']);
	?>
 	var input='';
	if($('#id-col-<?php echo $sub_categ_column['id_colonnes'];?>').is(":checked")) {
	<?php if ($colonnes_type['type'] == BUTTON_TYPE) {?>
		
		var id_btn_value="btn-val-"+line_id;
		var btn_value=  $("#"+id_btn_value).val(); 
		//alert(id_btn_value+' ==> '+btn_value);
		var btn_selected = btn_value.split(",");
		var selected="";
		input+='<select class="s2example-'+line_id+'"  id="col-<?php echo $colonne['id'];?>-'+line_id+'" name="col-<?php echo $colonne['id'];?>-'+line_id+'"  multiple>';
		<?php foreach ($colonnes_boutons as $bouton){?>
			selected="";
			if(btn_selected.indexOf("<?php echo $bouton['id'];?>") != -1){
			selected="selected";
			}
			
			input+='<option value="<?php echo $bouton['id'];?>" '+selected+'><?php echo $bouton['titre_fr'];?></option>';
		<?php }?>
		input+='</select>';
		<?php } else {?>
		var id_column_value="col-<?php echo $sub_categ_column['id_colonnes'];?>-"+line_id;
		var column_value=  $("#"+id_column_value).text();	
		//alert(id+' ==> '+column_value);
		input='<input type="text" class="form-control" id="col-<?php echo $colonne['id'];?>-'+line_id+'" name="col-<?php echo $colonne['id'];?>-'+line_id+'"  value ="'+column_value+'" >';
	<?php }?>
	
	var th='<th class="col-<?php echo $colonne['id'];?>">'+input+'</th>';
	
	tr+=th;
	}
	<?php }?> 
	var col_id='col-<?php echo $colonne['id'];?>-';
	
	tr+='<th> <span onclick="validate_row( \''+line_id+'\' );" data-class="times" style="cursor:pointer"><i class="fa fa-check"></i></span> <span  onclick="delete_row( \''+line_id+'\' );" data-class="times" style="margin-left:4px;cursor:pointer"><i class="fa fa-remove"></i></span></th>';
	
	tr+='</tr>';
	$('#line-' + line_id).replaceWith(tr);
	$(".s2example-"+line_id).select2();
	
	
	
	}
	
	function delete_row(line_id)
	{
 	$('#line-' + line_id).remove();
	}
	
	function add_line(){
	
	
	
	//alert("ee");
	$(".new_line").hide();
	$("#tr-default").hide();
	
	var v=0;
	var tr='<tr>';
	<?php foreach ($sub_categ_columns as $sub_categ_column){
		$colonne = $db->get_row("SELECT * FROM `colonnes` WHERE `id` =".$sub_categ_column['id_colonnes']);	
		$colonnes_type = $db->get_row("SELECT colonnes_types.* FROM colonnes_types WHERE id=".$colonne['id_type']);
	?>
	
	v=  $("#col-<?php echo $sub_categ_column['id_colonnes'];?>").val();	
	
	
	if($('#id-col-<?php echo $sub_categ_column['id_colonnes'];?>').is(":checked")) {
	
	<?php if ($colonnes_type['type'] == BUTTON_TYPE) {?>
		
		var count=$('.s2example-2').select2("val").length;
		
		var th='<th class="col-<?php echo $sub_categ_column['id_colonnes'];?>">';
		for(var i=0;i<count;i++)
		{
		var id_btn=$('.s2example-2').select2("val")[i];
		var btn="";
		for(var j=0;j<colonnes_boutons_json.length;j++)
		{
		if (colonnes_boutons_json[j]['id'] == id_btn )
		{
		btn+="<button type='button' class='btn btn-primary  btn-table' style='    margin: 2px;background-color:"+colonnes_boutons_json[j]['color']+"'>"+colonnes_boutons_json[j]['titre_fr']+"</button>";
		}  
		}  
		//var btn=colonnes_boutons_json[0]['titre_fr'];
		th+=btn;
		} 
		th+='</th>';
		tr+=th; 
		<?php }else{?>
		tr+='	<th class="col-<?php echo $sub_categ_column['id_colonnes'];?>">'+v+'</th>';
	<?php }?>
	
	}else{
	tr+='<th style="display:none;" class="col-<?php echo $sub_categ_column['id_colonnes'];?>"></th>';
	}
	
	
	<?php }?>
	tr+='<th> <span onclick="edit_row( \''+line_id+'\' );" data-class="times" style="cursor:pointer"><i class="fa fa-pencil"></i></span> <span data-class="times" style="margin-left:4px;cursor:pointer"><i class="fa fa-remove"></i></span></th>';
	
	tr+='</tr>';
	
	$('#table-product tr:last').after(tr);
	$('.perfect-scroll').height(notif_widget).perfectScrollbar({suppressScrollX: true});
	
	}
	function resetAllValues() {
	$('.new_line').find('input:text').val('');
	}
	/* $(".s2example-2").select2({
	placeholder: 'Choose your favorite US Countries',
	allowClear: true
	}).on('select2-open', function() {
	// Adding Custom Scrollbar
	$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
	}); */
	
	function validate_table(id_product)
	{
	var tab_elem=new Array;
	var elem=0;
	for (var line_id = 0 ; line_id < total_line; line_id++)
	{
	//alert(''+line_id);
	var tab=new Array;
	var k=0;
	
	
	<?php foreach ($sub_categ_columns as $sub_categ_column)
		{
			$colonne = $db->get_row("SELECT * FROM `colonnes` WHERE `id` =".$sub_categ_column['id_colonnes']);	
			$colonnes_type = $db->get_row("SELECT colonnes_types.* FROM colonnes_types WHERE id=".$colonne['id_type']);
		?>
		if($('#id-col-<?php echo $sub_categ_column['id_colonnes'];?>').is(":checked")) 
		{
		
		<?php if ($colonnes_type['type'] == BUTTON_TYPE) {?>
			
			
			
			var id_column="<?php echo $sub_categ_column['id_colonnes'];?>";
			
			
			var column_value=  $("#btn-val-"+line_id).val();	
			tab[k] = new Array();
			tab[k]['id_column']=id_column;
			tab[k]['type']='<?php echo $colonnes_type['type'];?>';
			
			tab[k]['value']=new Array();
			tab[k]['value']=column_value; 
			
			
			<?php } else {?>
			
			var id_column="<?php echo $sub_categ_column['id_colonnes'];?>";
			var id_column_value="col-<?php echo $sub_categ_column['id_colonnes'];?>-"+line_id;
			var column_value=  $("#"+id_column_value).text();	
			
			tab[k] = new Array();
			tab[k]['id_column']=id_column;
			tab[k]['value']=column_value;
			tab[k]['type']='<?php echo $colonnes_type['type'];?>';
			
			
			
			
		<?php }?>
		k++;
		}
	<?php }?>
	tab_elem[elem] = new Array();
	//tab = JSON.stringify(tab);
	tab_elem[elem] =tab;
	elem++;
}

// alert(tab_elem[0][0]['id_column']+' ==> ' + tab_elem[0][0]['value']);

var jsonString =new Array();
for (var j=0;j < tab_elem.length; j++)
{
		var a1 =new Array();
	for (var h=0;h < tab_elem[j].length; h++)
	{
		//alert("j= "+j+" h= "+h +"  "+tab_elem[j][h]['id_column']+' ==> ' + tab_elem[j][h]['value']);
		
		var a2 =new Array();
a2.push(tab_elem[j][h]['id_column']);
a2.push(tab_elem[j][h]['value']);

		
		a1.push(a2);
	}
	
	jsonString.push(a1);
	
}
 
 

 jsonString = JSON.stringify(jsonString);
document.getElementById("loader").innerHTML='<img src="assets/images/loader1.gif" class="loader" />'; 
jQuery.ajax({
	type: "POST",
	url: "module_ajax/products/validate_table.php",
	data: {data : jsonString, id_product : id_product, action : 'add'},   
	success: function(response)
	{
		/* alert(response);
		 */
		
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



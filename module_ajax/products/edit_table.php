<?php include_once '../../includes/config.inc.php';
	if(!isset($_GET['id']) && !is_numeric($_GET['id']))exit;
	
	$id_product=$_GET['id'];
	$product = $db->get_row("SELECT products.* FROM products WHERE products.id = ".$id_product);
	
	//categorie  produit 
	$sub_categ = $db->get_row("SELECT * FROM `sub_categ` WHERE `id` =".$product['id_sub_categ']);	
	
	$sub_categ_columns = $db->get_rows("SELECT  sub_categ_column.* FROM sub_categ_column WHERE sub_categ_column.id_sub_categ =".$sub_categ['id']);
	
	
	$colonnes_boutons = $db->get_rows("SELECT  colonnes_boutons.* FROM colonnes_boutons WHERE statut = 1 and deleted = 0");
	
	
	$product_column_table_fr = $db->get_rows("SELECT  product_column_table_fr.* FROM product_column_table_fr WHERE statut = 1 and id_product = ".$id_product." order by rang");
	$product_table_rows_fr = $db->get_rows("SELECT  product_table_fr.* FROM product_table_fr WHERE statut = 1 and id_product = ".$id_product."  group by rang");
	
	
	
	
	/* 	$id_col='7';
		if (exist_in_array($id_col,$product_column_table_fr,"id_column")){
		echo "true<br>";
		}
		
		echo "<pre>";
		print_r($product_table_fr);
		echo "</pre>";
	*/
	
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
					$checked="";
					if ( (count ($product_column_table_fr)) == 0 ){
						$checked="checked";
						}else{
						
						if (exist_in_array($colonne['id'],$product_column_table_fr,"id_column"))
						$checked="checked";
					}
					
					
				?>
				
				<li class="checkbox-row">
					<input type="checkbox" name="list-column" <?php echo $checked;?> id="id-col-<?php echo $colonne['id'];?>"> 
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
							$style="style='display:none'";
							if ( (count ($product_column_table_fr)) == 0 ){
								$style="";
								}else{
								if (exist_in_array($colonne['id'],$product_column_table_fr,"id_column"))
								$style="";
							}
						?>
						<th class="col-<?php echo $colonne['id'];?>" <?php echo $style;?>><?php echo $colonne['titre_fr'];?></th>
						<?php }?>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$all_table_rows=0;
						if (count($product_table_rows_fr) > 0) 
						{
							$all_table_rows=count($product_table_rows_fr);
							foreach ($product_table_rows_fr as $product_table_rows)
							{
								$row=$product_table_rows['rang'];
							?>
							<tr id="line-<?php echo $row;?>">
								<input type="hidden" id="delete-line-<?php echo $row;?>" value="0" >
								<?php foreach ($sub_categ_columns as $sub_categ_column){
									$colonne = $db->get_row("SELECT * FROM `colonnes` WHERE `id` =".$sub_categ_column['id_colonnes']);
									$product_table_rows_fr_val=$db->get_row('select * from product_table_fr where rang='.$row.' and id_product = '.$id_product.'  and id_column='.$colonne['id']);
									
									$style="style='display:none'";
									if ( (count ($product_column_table_fr)) == 0 ){
										$style="";
										}else{
										if (exist_in_array($colonne['id'],$product_column_table_fr,"id_column"))
										$style="";
									}
									$colonnes_type = $db->get_row("SELECT colonnes_types.* FROM colonnes_types WHERE id=".$colonne['id_type']);

									if ($colonnes_type['type']!= BUTTON_TYPE ){
										if( $colonnes_type['type'] == "checkbox"){ 
										?>
									<th class="col-<?php echo $colonne['id'];?>" <?php echo $style;?> id="col-<?php echo $sub_categ_column['id_colonnes'];?>-<?php echo $row;?>"><?php echo $product_table_rows_fr_val['value']; ?></th>
									<?php }else{ ?>
										<th class="col-<?php echo $colonne['id'];?>" <?php echo $style;?> id="col-<?php echo $sub_categ_column['id_colonnes'];?>-<?php echo $row;?>"><?php echo $product_table_rows_fr_val['value'];?></th>
									<?php } 
									} 
									else {
										$ids_btn=$product_table_rows_fr_val['value'];
										if ($ids_btn != "")
										{
											$pieces = explode(",", $ids_btn);
											$btn='';
											
											$color="";
											//foreach ($pieces as $j){
											if ( count ($pieces)  >0)
											{
												for ($j=0;$j< count ($pieces)   ; $j++)
												{
													$colonnes_btn = $db->get_row("SELECT  colonnes_boutons.* FROM colonnes_boutons WHERE id = ".$pieces[$j]);
													
													if ($pieces[$j] == '9'){
													$color="color: red;";
													}
													$btn.="<button type='button' class='btn btn-primary  btn-table' style=' ".$color."   margin: 2px;background-color:".$colonnes_btn['color']."'>".$colonnes_btn['titre_fr']."</button>";
												}
											}
										}
									?>
									<th class="col-<?php echo $colonne['id'];?>" <?php echo $style;?> id="col-<?php echo $sub_categ_column['id_colonnes'];?>-<?php echo $row;?>"  ><?php echo $btn;?></th>
									
									<input type="hidden" id="btn-val-<?php echo $row;?>" value="<?php echo $product_table_rows_fr_val['value'];?>">
									
								<?php }?>
								<?php }?>
								<th> <span onclick="edit_row( '<?php echo $row;?>' );" data-class="times" style="cursor:pointer"><i class="fa fa-pencil"></i></span> <span onclick="delete_row( '<?php echo $row;?>' );" data-class="times" style="margin-left:4px;cursor:pointer"><i class="fa fa-remove"></i></span></th> 
								
								
								
							</tr>      
						<?php }?>
					<?php }?>
				</tbody>
			</table>
			
			</div>
			<span data-class="plus-square" style=" color: rgba(25, 150, 18, 0.83);">
				<i class="fa fa-plus-square"></i>
				<span onclick='show_bloc_add_line();' style="font-size: 14px;cursor:pointer;">Ajouter une ligne</span>
			</span>
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
	
	var total_line=<?php echo $all_table_rows;?>;
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

	<?php if ($colonnes_type['type'] == BUTTON_TYPE) { ?>
	input+='<select class="s2example-'+total_line+'"  id="col-<?php echo $colonne['id'];?>-'+total_line+'" name="col-<?php echo $colonne['id'];?>-'+total_line+'"  multiple>';
	<?php foreach ($colonnes_boutons as $bouton){?>
	input+='<option value="<?php echo $bouton['id'];?>" ><?php echo $bouton['titre_fr'];?></option>';
	<?php }?>
	input+='</select>';
	<?php } else if ($colonnes_type['type'] != 'checkbox') {?>
	input='<input type="text" class="form-control" id="col-<?php echo $colonne['id'];?>-'+total_line+'" name="col-<?php echo $colonne['id'];?>-'+total_line+'"  >';
	<?php }?>
	
	<?php if ($colonnes_type['type'] == 'checkbox') {?>
		input='<input onclick="changecheck($(this));" type="checkbox" class="iswitch iswitch-md iswitch-primary" id="col-<?php echo $colonne['id'];?>-'+total_line+'" name="col-<?php echo $colonne['id'];?>-'+total_line+'" value="Invisible">';
	<?php } ?>

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
	var tr='<tr id="line-'+line_id+'">  <input type="hidden" id="delete-line-'+line_id+'" value="0" > ';
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
	console.log('ediit 802');
	
	var tr='<tr id="line-'+line_id+'"><input type="hidden" id="delete-line-'+line_id+'" value="0" >';
	<?php foreach ($sub_categ_columns as $sub_categ_column){
	$colonne = $db->get_row("SELECT * FROM `colonnes` WHERE `id` =".$sub_categ_column['id_colonnes']);	
	$colonnes_type = $db->get_row("SELECT colonnes_types.* FROM colonnes_types WHERE id=".$colonne['id_type']);
	?>
	var input='';
	if($('#id-col-<?php echo $sub_categ_column['id_colonnes'];?>').is(":checked")) {

		console.log('<?php echo $colonnes_type['type']; ?>');

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

	<?php } else if ($colonnes_type['type'] != 'checkbox') {?>
	var id_column_value="col-<?php echo $sub_categ_column['id_colonnes'];?>-"+line_id;
	var column_value=  $.trim($("#"+id_column_value).text());	
	//alert(id+' ==> '+column_value);
	input='<input type="text" class="form-control" id="col-<?php echo $colonne['id'];?>-'+line_id+'" name="col-<?php echo $colonne['id'];?>-'+line_id+'"  value ="'+column_value+'" >';
	<?php }?>
	

	<?php if ($colonnes_type['type'] == 'checkbox') {?>

		var id_column_value="col-<?php echo $sub_categ_column['id_colonnes'];?>-"+line_id;
		var column_value=  $.trim($("#"+id_column_value).text());

		$checked = "";
		if (column_value === 'Visible'){
			$checked = "checked";
		}

		input='<input onclick="changecheck($(this));" type="checkbox" class="iswitch iswitch-md iswitch-primary" id="col-<?php echo $colonne['id'];?>-'+line_id+'" name="col-<?php echo $colonne['id'];?>-'+line_id+'"  value ="'+column_value+'" '+$checked+'>';
	<?php } ?>

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
	
	function changecheck(elem){
		console.log('888');
		console.log(elem.val());
		if (elem.is(":checked")){
			elem.val('Visible');
		}else{
			elem.val('Invisible');
		}
	}

	function delete_row(line_id)
	{
	
	$('#delete-line-' + line_id).val('1');
	$('#line-' + line_id).remove();
	}
	
	function resetAllValues() {
	$('.new_line').find('input:text').val('');
	}
	
	
	
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
		
		console.log('I m herre 2 ');
console.log(column_value);

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
	var vv=$('#delete-line-'+j).val();
	if (vv == '0')
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
	/* 	var vv=$('#delete-line-'+j).val();
	alert(""+vv); */
	jsonString.push(a1);
	}
	}
	
	console.log(jsonString);
	
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
	
	
		
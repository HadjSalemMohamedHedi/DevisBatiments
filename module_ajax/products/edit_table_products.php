<style>
.form-control{
	padding: 1px 6px;
}
</style>
<?php include_once '../../includes/config.inc.php';
	if(!isset($_GET['id']) && !is_numeric($_GET['id']))exit;
	
	$id_product=$_GET['id'];
	$product = $db->get_row("SELECT products.* FROM products WHERE products.id = ".$id_product);
	
	//categorie  produit 
	$sub_categ = $db->get_row("SELECT * FROM `sub_categ` WHERE `id` =".$product['id_sub_categ']);	
	
	$sub_categ_columns = $db->get_rows("SELECT  sub_categ_column.* FROM sub_categ_column WHERE sub_categ_column.id_sub_categ =".$sub_categ['id']);
	
	$product_table_rows_fr = $db->get_rows("SELECT  sous_products_table.* FROM sous_products_table WHERE statut = 1 and id_product = ".$id_product." order by rang");
?>

<input type="hidden" name="id_sub_categ" value ="<?php echo $id_categ;?>">

<div class="row">
	<div class="col-md-12">
		<div class="table-responsive" data-pattern="priority-columns" style="margin-bottom: 0px;">
			<table cellspacing="0" id="table-product" class="table table-small-font table-bordered table-striped">
				<thead>
					<tr style="background-color: #0b58a5;color: #fff;">
						<th>Code Article</th>
						<th>Désignation</th>
						<th>Prix</th>
						<th>Tva</th>
						<th>Remise</th>
						<th>Unite de conditionnement</th>
						<th>Stock</th>
						<th>Stock sécurité</th>
					</tr>
				</thead>
				
				
				<tbody>
					<?php 
						$style="";
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
								
								<th class="col-l_mm" id="col-l_mm-<?php echo $row;?>"><?php echo $product_table_rows['code_article'];?></th>
								<th class="col-charge_1" id="col-charge_1-<?php echo $row;?>"><?php echo $product_table_rows['designation'];?></th>
								<th class="col-fleche_1" id="col-fleche_1-<?php echo $row;?>"><?php echo $product_table_rows['prix'];?> </th>
								<th class="col-tva_1" id="col-tva_1-<?php echo $row;?>"><?php echo $product_table_rows['tva'];?> </th>
								<th class="col-charge_2" id="col-charge_2-<?php echo $row;?>"><?php echo $product_table_rows['remise'];?> </th>
								<th class="col-fleche_2" id="col-fleche_2-<?php echo $row;?>"><?php echo $product_table_rows['unite'];?></th> 
								<th class="col-charge_3" id="col-charge_3-<?php echo $row;?>"><?php echo $product_table_rows['quantite'];?></th>
								<th class="col-fleche_3" id="col-fleche_3-<?php echo $row;?>"><?php echo $product_table_rows['stock_min'];?></th>

								<th> 

									<span onclick="edit_row( '<?php echo $row;?>' );" data-class="times" style="cursor:pointer"><i class="fa fa-pencil"></i></span> 

									<span onclick="delete_row( '<?php echo $row;?>' );" data-class="times" style="margin-left:4px;cursor:pointer"><i class="fa fa-remove"></i></span>





									<?php if($product_table_rows['showSousProduct'] == 1){?>
									<span onclick="HideOrShow_row( '<?php echo $product_table_rows['code_article'];?>',0 );" data-class="times" style="margin-left:4px;cursor:pointer" id="HideRow<?php echo $product_table_rows['code_article']; ?>"><i class="fa fa-eye"></i></span>

									<span onclick="HideOrShow_row( '<?php echo $product_table_rows['code_article'];?>',1 );" data-class="times" style="margin-left:4px;cursor:pointer;display: none;" id="ShowRow<?php echo $product_table_rows['code_article']; ?>" ><i class="fa fa-eye-slash"></i></span>

								<?php }else{
									?>
									<span onclick="HideOrShow_row( '<?php echo $product_table_rows['code_article'];?>',1 );" data-class="times" style="margin-left:4px;cursor:pointer" id="ShowRow<?php echo $product_table_rows['code_article']; ?>"><i class="fa fa-eye-slash"></i></span>

									<span onclick="HideOrShow_row( '<?php echo $product_table_rows['code_article'];?>',0 );" data-class="times" style="margin-left:4px;cursor:pointer;display: none;" id="HideRow<?php echo $product_table_rows['code_article']; ?>"><i class="fa fa-eye"></i></span>

									<?php
								} ?>

								</th> 
								
								

								
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
	
 	function show_bloc_add_line(){
		
		
		var tr='<tr id="line-'+total_line+'">';
		
		var input='';
		
		
		input='<input type="text" class="form-control" id="col-l_mm-'+total_line+'" name="col-l_mm-'+total_line+'"  >';
		var th='<th class="col-l_mm">'+input+'</th>';
		tr+=th;
		
		input='<input type="text" class="form-control" id="col-charge_1-'+total_line+'" name="col-charge_1-'+total_line+'"  >';
		var th='<th class="col-charge_1">'+input+'</th>';
		tr+=th;
		
		input='<input type="text" class="form-control" id="col-fleche_1-'+total_line+'" name="col-fleche_1-'+total_line+'"  >';
		var th='<th class="col-fleche_1">'+input+'</th>';
		tr+=th;
		
		input='<input type="text" class="form-control" id="col-tva_1-'+total_line+'" name="col-tva_1-'+total_line+'"  >';
		var th='<th class="col-tva_1">'+input+'</th>';
		tr+=th;


		input='<input type="text" class="form-control" id="col-charge_2-'+total_line+'" name="col-charge_2-'+total_line+'"  >';
		var th='<th class="col-charge_2">'+input+'</th>';
		tr+=th;
		
		input='<input type="text" class="form-control" id="col-fleche_2-'+total_line+'" name="col-fleche_2-'+total_line+'"  >';
		var th='<th class="col-fleche_2">'+input+'</th>';
		tr+=th;

		input='<input type="text" class="form-control" id="col-charge_3-'+total_line+'" name="col-charge_3-'+total_line+'"  >';
		var th='<th class="col-charge_3">'+input+'</th>';
		tr+=th;
		
		input='<input type="text" class="form-control" id="col-fleche_3-'+total_line+'" name="col-fleche_3-'+total_line+'"  >';
		var th='<th class="col-fleche_3">'+input+'</th>';
		tr+=th;

		
		tr+='<th> <span onclick="validate_row( \''+total_line+'\' );" data-class="times" style="cursor:pointer"><i class="fa fa-check"></i></span> <span  onclick="delete_row( \''+total_line+'\' );" data-class="times" style="margin-left:4px;cursor:pointer"><i class="fa fa-remove"></i></span></th>';
		
		
		
		
		tr+='</tr>';
		$('#table-product tr:last').after(tr);
		
		
		
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
	
	v=  $("#col-l_mm-"+line_id).val();	 
	tr+='	<th class="col-l_mm" id="col-l_mm-'+line_id+'" >'+v+'</th>';
	
	v=  $("#col-charge_1-"+line_id).val();	 
	tr+='	<th class="col-charge_1" id="col-charge_1-'+line_id+'" >'+v+'</th>';
	
	v=  $("#col-fleche_1-"+line_id).val();	 
	tr+='	<th class="col-fleche_1" id="col-fleche_1-'+line_id+'" >'+v+'</th>';
	
	v=  $("#col-tva_1-"+line_id).val();	 
	tr+='	<th class="col-tva_1" id="col-tva_1-'+line_id+'" >'+v+'</th>';
	
	
	
	v=  $("#col-charge_2-"+line_id).val();	 
	tr+='	<th class="col-charge_2" id="col-charge_2-'+line_id+'" >'+v+'</th>';
	
	v=  $("#col-fleche_2-"+line_id).val();	 
	tr+='	<th class="col-fleche_2" id="col-fleche_2-'+line_id+'" >'+v+'</th>';
	
	v=  $("#col-charge_3-"+line_id).val();	 
	tr+='	<th class="col-charge_3" id="col-charge_3-'+line_id+'" >'+v+'</th>';
	
	v=  $("#col-fleche_3-"+line_id).val();	 
	tr+='	<th class="col-fleche_3" id="col-fleche_3-'+line_id+'" >'+v+'</th>';

  
 
	tr+='<th> <span onclick="edit_row( \''+line_id+'\' );" data-class="times" style="cursor:pointer"><i class="fa fa-pencil"></i></span> <span onclick="delete_row( \''+line_id+'\' );" data-class="times" style="margin-left:4px;cursor:pointer"><i class="fa fa-remove"></i></span></th>';
	
	tr+='</tr>';
	
	//$('#table-product tr:last').after(tr);
	
	$('#line-' + line_id).replaceWith(tr);
	
	
	
	
	}
	
	function edit_row(line_id)
	{
	
	
	var tr='<tr id="line-'+line_id+'"><input type="hidden" id="delete-line-'+line_id+'" value="0" >';
	
	var input='';
	
	
	var id_column_value="col-l_mm-"+line_id;
	var column_value=  $("#"+id_column_value).text();	
	input='<input type="text" class="form-control" id="col-l_mm-'+line_id+'" name="col-l_mm-'+line_id+'"  value ="'+column_value+'" >';
	var th='<th class="col-l_mm">'+input+'</th>';
	tr+=th;
	
	var id_column_value="col-charge_1-"+line_id;
	var column_value=  $("#"+id_column_value).text();	
	input='<input type="text" class="form-control" id="col-charge_1-'+line_id+'" name="col-charge_1-'+line_id+'"  value ="'+column_value+'" >';
	var th='<th class="col-charge_1">'+input+'</th>';
	tr+=th;
	
	var id_column_value="col-fleche_1-"+line_id;
	var column_value=  $("#"+id_column_value).text();	
	input='<input type="text" class="form-control" id="col-fleche_1-'+line_id+'" name="col-fleche_1-'+line_id+'"  value ="'+column_value+'" >';
	var th='<th class="col-fleche_1">'+input+'</th>';
	tr+=th;
	

	var id_column_value="col-tva_1-"+line_id;
	var column_value=  $("#"+id_column_value).text();	
	input='<input type="text" class="form-control" id="col-tva_1-'+line_id+'" name="col-tva_1-'+line_id+'"  value ="'+column_value+'" >';
	var th='<th class="col-tva_1">'+input+'</th>';
	tr+=th;
	

	


	var id_column_value="col-charge_2-"+line_id;
	var column_value=  $("#"+id_column_value).text();	
	input='<input type="text" class="form-control" id="col-charge_2-'+line_id+'" name="col-charge_2-'+line_id+'"  value ="'+column_value+'" >';
	var th='<th class="col-charge_2">'+input+'</th>';
	tr+=th;
	
	var id_column_value="col-fleche_2-"+line_id;
	var column_value=  $("#"+id_column_value).text();	
	input='<input type="text" class="form-control" id="col-fleche_2-'+line_id+'" name="col-fleche_2-'+line_id+'"  value ="'+column_value+'" >';
	var th='<th class="col-fleche_2">'+input+'</th>';
	tr+=th;
 	
 	var id_column_value="col-charge_3-"+line_id;
	var column_value=  $("#"+id_column_value).text();	
	input='<input type="text" class="form-control" id="col-charge_3-'+line_id+'" name="col-charge_3-'+line_id+'"  value ="'+column_value+'" >';
	var th='<th class="col-charge_3">'+input+'</th>';
	tr+=th;
	
	var id_column_value="col-fleche_3-"+line_id;
	var column_value=  $("#"+id_column_value).text();	
	input='<input type="text" class="form-control" id="col-fleche_3-'+line_id+'" name="col-fleche_3-'+line_id+'"  value ="'+column_value+'" >';
	var th='<th class="col-fleche_3">'+input+'</th>';
	tr+=th;

	
	tr+='<th> <span onclick="validate_row( \''+line_id+'\' );" data-class="times" style="cursor:pointer"><i class="fa fa-check"></i></span> <span  onclick="delete_row( \''+line_id+'\' );" data-class="times" style="margin-left:4px;cursor:pointer"><i class="fa fa-remove"></i></span></th>';
	
	tr+='</tr>';
	$('#line-' + line_id).replaceWith(tr);
	$(".s2example-"+line_id).select2();
	
	
	}




	function HideOrShow_row(idArticle,NewVal){	
		let idCodeToHide="";
		let idCodeToshow="";
		idCodeToHide ="#HideRow"+idArticle;
		idCodeToshow ="#ShowRow"+idArticle;

			jQuery.ajax({
			url: "module_ajax/products/HideShowProduct.php?idArticle="+idArticle+"&NewVal="+NewVal,
				success: function(response)
				{			
					if(NewVal==0){
						$(idCodeToHide).hide();
						$(idCodeToshow).show();
					}else{
						$(idCodeToHide).show();
						$(idCodeToshow).hide();
					}		
					

				}
			});
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
	// alert(''+line_id);
	var tab=new Array;
	var k=0;
	
	//l_mm
	var id_column="l_mm";
	var id_column_value="col-l_mm-"+line_id;
	var column_value=  $("#"+id_column_value).text();	
	tab[k] = new Array();
	tab[k]['id_column']=id_column;
	tab[k]['value']=column_value;
	k++;
	
	//charge_1
	id_column="charge_1";
	id_column_value="col-charge_1-"+line_id;
	column_value=  $("#"+id_column_value).text();	
	tab[k] = new Array();
	tab[k]['id_column']=id_column;
	tab[k]['value']=column_value;
	k++;
	
	
	//fleche_1
	id_column="fleche_1";
	id_column_value="col-fleche_1-"+line_id;
	column_value=  $("#"+id_column_value).text();	
	tab[k] = new Array();
	tab[k]['id_column']=id_column;
	tab[k]['value']=column_value;
	k++;
	

	//tva_1
	id_column="tva_1";
	id_column_value="col-tva_1-"+line_id;
	column_value=  $("#"+id_column_value).text();	
	tab[k] = new Array();
	tab[k]['id_column']=id_column;
	tab[k]['value']=column_value;
	k++;

	
	
	//charge_2
	id_column="charge_2";
	id_column_value="col-charge_2-"+line_id;
	column_value=  $("#"+id_column_value).text();	
	tab[k] = new Array();
	tab[k]['id_column']=id_column;
	tab[k]['value']=column_value;
	k++;
	
	
	//fleche_2
	id_column="fleche_2";
	id_column_value="col-fleche_2-"+line_id;
	column_value=  $("#"+id_column_value).text();	
	tab[k] = new Array();
	tab[k]['id_column']=id_column;
	tab[k]['value']=column_value;
	k++;
	
	//charge_3
	id_column="charge_3";
	id_column_value="col-charge_3-"+line_id;
	column_value=  $("#"+id_column_value).text();	
	tab[k] = new Array();
	tab[k]['id_column']=id_column;
	tab[k]['value']=column_value;
	k++;
	
	
	//fleche_3
	id_column="fleche_3";
	id_column_value="col-fleche_3-"+line_id;
	column_value=  $("#"+id_column_value).text();	
	tab[k] = new Array();
	tab[k]['id_column']=id_column;
	tab[k]['value']=column_value;
	k++;
	
 
	
	
	tab_elem[elem] = new Array();
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
		
		jsonString.push(a1);
	}
}
/* alert('d');
alert(jsonString); */


/* 
	var jsonString = {};
	jsonString.couleur = 'rouge';
	jsonString.forme = 'carré';
	jsonString.contient = ['téléphone', 'clés de voiture2', 'clés de voiture3', 'clés de voiture4', 'clés de voiture5', 'clés de voiture6', 'clés de voiture7', 'clés de voiture89', 'clés de voiture', 'clés de voiture10', 'clés de voiture11', 'clés de voiture12', 'clés de voiture13', 'clés de voiture14', 'clés de voiture15', 'clés de voiture16'];
*/
jsonString = JSON.stringify(jsonString);

document.getElementById("loader").innerHTML='<img src="assets/images/loader1.gif" class="loader" />'; 

jQuery.ajax({
	type: "POST",
	url: "module_ajax/products/validate_sous_products.php",
	data: {data : jsonString, id_product : id_product, action : 'add'},   
	success: function(response)
	{
		 //  alert(response);  
		
		
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



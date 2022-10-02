<?php include_once '../../includes/config.inc.php';
	if(!isset($_GET['id']) && !is_numeric($_GET['id']))exit;
	
	$id_product=$_GET['id'];
 
	
	
	 
?>



<div class="row">
	<div class="col-md-12">
		<style>
			.div-type:hover{
			background-color:#eaeaea;
			}
		</style>	
		<div class="table-responsive div-type" data-pattern="priority-columns" onclick="edit_table_charge(<?php echo $_GET['id'];?>);" style="margin-bottom: 20px;cursor:pointer;">
			<label>TYPE 1 </label>
			<table cellspacing="0" id="table-product" class="table table-small-font table-bordered table-striped">
				<thead>
					<tr style="    background-color: #0b58a5;    color: white;">
						<th style="text-align: center!important;" colspan="5">Charges et flèches pour contrainte maximum</th>
						<th style="text-align: center!important;"  colspan="4">Charges maximum pour flèche L/200 et L360</th>
						
					</tr>
					<tr>
						<th rowspan="2" style="vertical-align: middle;">L (mm)</th>
						<th style="text-align: center!important;"  colspan="2">Poutre avec charge répartie</th>
						<th style="text-align: center!important;"  colspan="2">Poutre avec charge centrée</th>
						<th style="text-align: center!important;"  colspan="2">Poutre avec charge répartie</th>
						<th style="text-align: center!important;"  colspan="2">Poutre avec charge centrée</th>
						
					</tr>
					<tr style="    background: #eaeaea;">
						
						<th style="text-align: center!important;" >Charges(kg)</th>
						<th style="text-align: center!important;" >Flèhes(mm)</th>
						
						<th style="text-align: center!important;" >Charges(kg)</th>
						<th style="text-align: center!important;" >Flèhes(mm)</th>
						
						<th style="text-align: center!important;" >Charges(kg)</th>
						<th style="text-align: center!important;" >Flèhes(mm)</th>
						
						<th style="text-align: center!important;" >Charges(kg)</th>
						<th style="text-align: center!important;" >Flèhes(mm)</th>
						
					</tr>
				</thead>
				
				
				
			</table>
			
		</div>
		
		<div class="table-responsive div-type" data-pattern="priority-columns" onclick="edit_table_charge_type_2(<?php echo $_GET['id'];?>);" style="margin-bottom: 0px;cursor:pointer;">
			<label>TYPE 2 </label>
			<table cellspacing="0" id="table-product" class="table table-small-font table-bordered table-striped" style="width: 50%;">
				<thead>
					<tr style="    background-color: #0b58a5;    color: white;">
						<th style="text-align: center!important;" colspan="5">Charges et flèches pour contrainte maximum</th>
						
					</tr>
					<tr>
						<th rowspan="2" style="vertical-align: middle;">L (mm)</th>
						<th style="text-align: center!important;"  colspan="2">Poutre avec charge répartie</th>
						<th style="text-align: center!important;"  colspan="2">Poutre avec charge centrée</th>
						
					</tr>
					<tr style="    background: #eaeaea;">
						
						<th colspan="2" style="text-align: center!important;" >Charges(kg)</th>
						
						<th colspan="2" style="text-align: center!important;" >Charges(kg)</th>
						
						
					</tr>
				</thead>
				
				
				
			</table>
			
		</div>
	</div>
	
</div>








<div class="modal-footer"> 
 	<button type="button" class="btn btn-white" data-dismiss="modal">Fermer</button>
 </div>



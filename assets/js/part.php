<script type="text/javascript">


	
										function remove_contact(id_folder,id_contact,type){
											
											var a = confirm("Voulez-vous réellement retirer ce contact du dossier ?");
											if(a){
											document.location.href='?action='+ type +'&id_folder='+id_folder+'&id_contact='+id_contact+'&tab=parts';
											}
										
										}
										function remove_clt(id_folder,id_client){
											
											
											jQuery('#ultraModal-loading').modal('show', {backdrop: 'static'});
											jQuery.ajax({
														type: "POST",
														dataType: 'json',
                                                        url: "includes/verif-client.php?id_client="+id_client,
														 success: function(response)
                                                        {
															
															if(response['used']>0){
																
																alert("Ce client ne peut pas etre  supprimé");	
																
															}else{
															
																var a = confirm("Voulez-vous réellement retirer ce client du dossier ?");
																	if(a){
																	document.location.href='?action=remove_client&id_folder='+id_folder+'&id_client='+id_client+'&tab=parts';
																}
															}
															jQuery('#ultraModal-loading').modal('hide');
														}
											})
											
											
											
										
										}
										
jQuery(function($) {

    'use strict';
	
		<!--agenda-->
		
		
		<!--end agenda-->
		$("#con_contributor").select2({
															placeholder: 'Choisissez',
															allowClear: true
														}).on('select2-open', function() {
															// Adding Custom Scrollbar
															$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
														});
														<!---->
													$("#contributor").select2({
															placeholder: 'Choisissez',
															allowClear: true
														}).on('select2-open', function() {
															// Adding Custom Scrollbar
															$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
														});
														<!---->
													$("#con_adversary").select2({
															placeholder: 'Choisissez',
															allowClear: true
														}).on('select2-open', function() {
															// Adding Custom Scrollbar
															$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
														});
													<!---->
													 $("#adversary").select2({
															placeholder: 'Choisissez',
															allowClear: true
														}).on('select2-open', function() {
															// Adding Custom Scrollbar
															$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
														});
														<!---->
													 $("#corresponding").select2({
															placeholder: 'Choisissez',
															allowClear: true
														}).on('select2-open', function() {
															// Adding Custom Scrollbar
															$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
														});
														<!---->
													 $("#id_client").select2({
															placeholder: 'Choisissez',
															allowClear: true
														}).on('select2-open', function() {
															// Adding Custom Scrollbar
															$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
														});

				
				
												
	  });
	  
	</script> 
    
       <!-- client box modal start -->
      
        <div class="modal" id="clt-add" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
            <div class="modal-dialog animated bounceInDown">
                <div class="modal-content">
                	<form method="post" action="folder-detail.php?id_folder=<?php echo $_GET['id_folder'];?>">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Ajouter client au dossier: <strong><?php echo $folder['name'] ?></strong></h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                                                                    <label for="id_legal_form" class="control-label">Clients :</label>
                                                                    <div class="controls">
                                                                     <select class="" id="id_client" name="id_client[]" multiple>
                                                						<option>==========</option>
                                                                        <?php foreach($all_clients  as $k=>$n):?>
                                                                        <option value="<?php echo $n['id_client'] ?>" <? if(in_array($n['id_client'],$exist_clt)): echo 'selected'; endif;?>><?php echo $n['firstname'].' '.$n['lastname'] ?></option>
                                                                        <?php endforeach;?>
                                                
                                            						</select>
                                                                  	</div>
                                                                </div>

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Fermer</button>
                        <button type="submit" class="btn btn-success" name="folder_client">Valider</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- correspondant modal start -->
        
        <div class="modal" id="corr-add" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
            <div class="modal-dialog animated bounceInDown">
                <div class="modal-content">
                	<form method="post" action="folder-detail.php?id_folder=<?php echo $_GET['id_folder'];?>">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Ajouter Correspondant au dossier: <strong><?php echo $folder['name'] ?></strong></h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                                                                    <label for="id_legal_form" class="control-label">Contacts :</label>
                                                                    <div class="controls">
                                                                     <select class="" id="corresponding" name="corresponding[]" multiple>
                                                						<option>==========</option>
                                                                        <?php foreach($all_contacts  as $k=>$n):?>
                                                                        <option value="<?php echo $n['id_contact'] ?>" <? if(in_array($n['id_contact'],$exist_corr)): echo 'selected'; endif;?>><?php echo $n['firstname'].' '.$n['lastname'] ?></option>
                                                                        <?php endforeach;?>
                                                
                                            						</select>
                                                                  	</div>
                                                                </div>

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Fermer</button>
                        <button type="submit" class="btn btn-success"  name="folder_corresponding">Valider</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!--Adversaire-->
        <div class="modal" id="adv-add" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
            <div class="modal-dialog animated bounceInDown">
                <div class="modal-content">
                	<form method="post" action="folder-detail.php?id_folder=<?php echo $_GET['id_folder'];?>">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Ajouter des adversaires au dossier: <strong><?php echo $folder['name'] ?></strong></h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                                                                    <label for="id_legal_form" class="control-label">Contacts :</label>
                                                                    <div class="controls">
                                                                     <select class="" id="adversary" name="adversary[]" multiple>
                                                						<option>==========</option>
                                                                        <?php foreach($all_contacts  as $k=>$n):?>
                                                                        <option value="<?php echo $n['id_contact'] ?>" <? if(in_array($n['id_contact'],$exist_adv)): echo 'selected'; endif;?>><?php echo $n['firstname'].' '.$n['lastname'] ?></option>
                                                                        <?php endforeach;?>
                                                
                                            						</select>
                                                                  	</div>
                                                                </div>

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Fermer</button>
                        <button type="submit" class="btn btn-success" name="folder_adversary">Valider</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!--Conseil adversaire-->
        <div class="modal" id="con-adv-add" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
            <div class="modal-dialog animated bounceInDown">
                <div class="modal-content">
                	<form method="post" action="folder-detail.php?id_folder=<?php echo $_GET['id_folder'];?>">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Ajouter conseil adversaire au dossier: <strong><?php echo $folder['name'] ?></strong></h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                                                                    <label for="id_legal_form" class="control-label">Contacts :</label>
                                                                    <div class="controls">
                                                                     <select class="" id="con_adversary" name="con_adversary[]" multiple>
                                                						<option>==========</option>
                                                                        <?php foreach($all_contacts  as $k=>$n):?>
                                                                        <option value="<?php echo $n['id_contact'] ?>" <? if(in_array($n['id_contact'],$exist_con_adv)): echo 'selected'; endif;?>><?php echo $n['firstname'].' '.$n['lastname'] ?></option>
                                                                        <?php endforeach;?>
                                                
                                            						</select>
                                                                  	</div>
                                                                </div>

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Fermer</button>
                        <button type="submit" class="btn btn-success" name="folder_con_adversary">Valider</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!--contributor-->
        <div class="modal" id="contributor-add" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
            <div class="modal-dialog animated bounceInDown">
                <div class="modal-content">
                	<form method="post" action="folder-detail.php?id_folder=<?php echo $_GET['id_folder'];?>">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Ajouter des intervenants au dossier: <strong><?php echo $folder['name'] ?></strong></h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                                                                    <label for="id_legal_form" class="control-label">Contacts :</label>
                                                                    <div class="controls">
                                                                     <select class="" id="contributor" name="contributor[]" multiple>
                                                						<option>==========</option>
                                                                        <?php foreach($all_contacts  as $k=>$n):?>
                                                                        <option value="<?php echo $n['id_contact'] ?>" <? if(in_array($n['id_contact'],$exist_contributor)): echo 'selected'; endif;?>><?php echo $n['firstname'].' '.$n['lastname'] ?></option>
                                                                        <?php endforeach;?>
                                                
                                            						</select>
                                                                  	</div>
                                                                </div>

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Fermer</button>
                        <button type="submit" class="btn btn-success" name="folder_contributor">Valider</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>
        
        <!--Conseil intervenant-->
        <div class="modal" id="con-contributor-add" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
            <div class="modal-dialog animated bounceInDown">
                <div class="modal-content">
                	<form method="post" action="folder-detail.php?id_folder=<?php echo $_GET['id_folder'];?>">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Ajouter des Conseil intervenant au dossier: <strong><?php echo $folder['name'] ?></strong></h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                                                                    <label for="id_legal_form" class="control-label">Contacts :</label>
                                                                    <div class="controls">
                                                                     <select class="" id="con_contributor" name="con_contributor[]" multiple>
                                                						<option>==========</option>
                                                                        <?php foreach($all_contacts  as $k=>$n):?>
                                                                        <option value="<?php echo $n['id_contact'] ?>" <? if(in_array($n['id_contact'],$exist_con_contributor)): echo 'selected'; endif;?>><?php echo $n['firstname'].' '.$n['lastname'] ?></option>
                                                                        <?php endforeach;?>
                                                
                                            						</select>
                                                                  	</div>
                                                                </div>

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Fermer</button>
                        <button type="submit" class="btn btn-success" name="folder_con_contributor">Valider</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="ultraModal-loading">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
        
                                                                <div class="progress">
                                                                    <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                                        
                                                                    </div>
                                                                </div>    
                                
                                                            </div>
        
                                                            
                                                            
                                                        </div>
                                                    </div>
                                                </div>
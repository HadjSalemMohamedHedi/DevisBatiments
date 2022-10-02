<?php include_once './config.inc.php';
       include_once './BackupMySQL.php';     
     if(isset($_GET['backup_database'])) {
		  echo '<div id="etat_sauv">';
				  new BackupMySQL(array(
					  'host' => HOSTNAME,
					  'username' => DB_USERNAME,
					  'passwd' => DB_PASSWORD,
					  'dbname' => DB_NAME,
					  'dossier' => '../backup/'
					  )); 
			echo "</div><br>";	  
	
 foreach (glob("../backup/*.sql.gz") as $filename) {?>

                                       <div class="well">
                                         Sauvegarde prise le <?=substr($filename,22,2)."/".substr($filename,20,2)."/".substr($filename,16,4)." à ".substr($filename,25,2).":".substr($filename,27,2).":".substr($filename,29,2)?>                
                                         
                                        <a class="btn btn-danger btn-icon bottom15 right15" href="javascript:delFile('<?=$filename?>')" style="float: right;">
                                            <i class="fa fa fa-trash-o"></i> &nbsp; <span>Supprimer</span>
                                        </a>
                                         <a class="btn btn-success btn-icon bottom15 right15" href="<?=$filename?>" style="float: right;">
                                            <i class="fa fa fa-download"></i> &nbsp; <span>Télécharger</span>
                                        </a>
                                       
                                        </div>
																				
<? }
	  }
exit;

 ?>
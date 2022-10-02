<?php
	function listeDossier($dossier) // Fonction qui liste un dossier de façon récursive
	{
		if (is_dir($dossier))
		{
			if($dossierOuvert=opendir($dossier))
			{
				echo "<ul>";
				while(($fichier=readdir($dossierOuvert))!== false)
				{
					if ($fichier==".." || $fichier=="." || $fichier=="index.php")
					{
						continue;
					}
					else
					{
						
						if(is_dir("$dossier/$fichier"))
						{
						 
						  	if ($fichier  == "s") {
							echo "<li>$fichier</li>";
							}
							listeDossier("$dossier/$fichier");
						}
						else
						{
							 $rep= $dossier.'/'.$fichier;
							 $pos = strpos($rep,'/s/');
							 
						  	if ($pos !== false) {
								
								$new_name=$dossier.'/'.strtolower($fichier);
								echo "<li><a href='edit.php?fichier=$dossier/$fichier'>$fichier</a></li>";
								// echo "<li><a href='edit.php?fichier=$dossier/$fichier'>new --------- $new_name</a></li>";
								// rename($dossier.'/'.$fichier, $new_name);
								  
							}  
						}
					}
				}
				echo "</ul>";
			}
		}
		else
		{
			echo "Erreur, le paramètre précisé dans la fonction n'est pas un dossier!";
		}
	}
	
	
	listeDossier("images-products") ;
?>
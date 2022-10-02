<?php
include_once '../includes/config.inc.php';
	// Authenticate user login
//auth();

$user_role =$_SESSION['User']['role'];

$nb_Commande_Prep =GetCommandeEnprep();
$nb_Demandes =GetDemandes();

function GetCommandeEnprep(){
	$db = db_connect();
	$ordered_hx = $db->get_rows("SELECT count(id) as Count FROM `ordered_hx` WHERE state='En préparation'");
	return $ordered_hx[0]['Count'];
}

function GetDemandes(){
	$db = db_connect();
	$ordered_hx = $db->get_rows("SELECT count(id) as Count FROM `demandes`");
	return $ordered_hx[0]['Count'];
}




$stock_zeroo = get_stock_zeroo();
function get_stock_zeroo(){
	$db = db_connect();
	$query="SELECT count(*) as stock_zero FROM sous_products_table where stock_min = 0 and statut = 1";
	$stock_zero = $db->get_row($query);
	return $stock_zero;
}

?>





<div class="page-sidebar ">
	<style type="text/css">
		.plus-news{
			position: absolute;
		    font-size: 20px;
		    left: 5px;
		    bottom: 3px;
		}
	</style>
	
	<!-- MAIN MENU - START -->
	<div class="page-sidebar-wrapper" id="main-menu-wrapper"> 

		<?php if($_SESSION['User']['role'] == ""){ ?>
				<script type="text/javascript">
					window.location.replace("index.php");
				</script>
		<?php } ?>


														<!-- -->

		<? if($_SESSION['User']['role']=='blogger'): ?>
			<ul class='wraplist'>
				<li class="<?php if(strpos($_SERVER['REQUEST_URI'],'manage-blog.php') !== false){ echo "open";}?>">       <!-- PHP_SELF -->
					<a class="" href="manage-blog.php">
						<i class="fa fa-th-large" style="color: #020096!important"></i>
						<span class="title">Blogs</span></a>
				</li>
			</ul>
		<? endif;?>

														<!-- -->






	<?php if( ($user_role == "superadmin") && ($user_role !="")) { ?>
	<!-- USER INFO - END -->
	<ul class='wraplist'>	

		<li class="<?php if(strpos($_SERVER['PHP_SELF'],'dashboard.php') !== false){ echo "open";}?>" >
			<a href="dashboard.php" >
				<i class="ti-dashboard icon-dash icons"></i>
				<span class="title"> Tableau de bord </span>
			</a>
		</li>

		<li class="<?php if(strpos($_SERVER['PHP_SELF'],'manage-commandes.php') !== false){ echo "open";}?>" >
		<!-- 	<a href="manage-commandes.php" >
				<i class="ti-shopping-cart c-yellow icon-hx icons"></i>
				<span class="title"> Commandes </span>			</a> -->


					<a href="javascript:;">
						<i class="ti-shopping-cart c-yellow icon-hx icons"></i>
						<span class="title">Commandes <span class="NotifNumber"><?php echo $nb_Commande_Prep; ?> </span></span><span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li>
							<a class="<?php if(strpos($_SERVER['REQUEST_URI'],'manage-commandes.php') !== false){ echo "active";}?>" href="manage-commandes.php">
								<i class="fa fa-list c-red icon-hx icons"></i>
								<span class="title">Liste des commandes</span></a>
						</li>

						<li>
							<a class="<?php if(strpos($_SERVER['REQUEST_URI'],'manage-commandes.php?EnAtt') !== false){ echo "active";}?>"
							 href="manage-commandes.php?EnAtt&Action=En préparation">
								<i class="fa fa-circle-o-notch c-red icon-hx icons"></i> Commandes en préparation<span class="NotifNumber"><?php echo $nb_Commande_Prep; ?> </span> </a>
						</li>
						<li>
							<a class="<?php if(strpos($_SERVER['REQUEST_URI'],'manage-commandes.php?Expe') !== false){ echo "active";}?>"
								href="manage-commandes.php?Expe&Action=Expédié">
								<i class="fa fa-bullhorn c-red icon-hx icons" aria-hidden="true"></i>
								<span class="title">Commandes Expédiées</span>
							</a>
						</li>
						<li>
							<a href="manage-commandes.php?Liv&Action=Livrée" class="<?php if(strpos($_SERVER['REQUEST_URI'],'manage-commandes.php?Liv') !== false)
							{ echo "active";}?>" >
								<i class="fa fa-check-square-o c-red icon-hx" aria-hidden="true"></i> Commandes Livrées</a>
						</li>

					
						</ul>	


		</li>

	





<!-- 
		<li class="<?php if(strpos($_SERVER['REQUEST_URI'],'manage-products.php') !== false){ echo "open";}?>">
			<a class="" href="manage-products.php">
				<i class="ti-shopping-cart-full c-pink icon-hx icons"></i>
				<span class="title">Gestion des produits</span></a>
			</li> -->


			<li class="<?php if(
			(strpos($_SERVER['PHP_SELF'],'manage-products.php') !== false) || 
			(strpos($_SERVER['PHP_SELF'],'produits-en-stock-min.php') !== false) || 
			(strpos($_SERVER['PHP_SELF'],'repture-stocks.php') !== false)
			 ){ echo "open";}?>" >
	


					<a href="javascript:;">
						<i class="ti-shopping-cart-full c-pink icon-hx icons"></i>
						<span class="title">Gestion des produits </span><span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li>
							<a class="<?php if(strpos($_SERVER['REQUEST_URI'],'manage-products.php') !== false){ echo "active";}?>" href="manage-products.php">
								<i class="fa fa-list c-red icon-hx icons"></i>
								<span class="title">Liste des Produits </span></a>
						</li>

						<li>
							<a class="<?php if(strpos($_SERVER['REQUEST_URI'],'produits-en-stock-min.php') !== false){ echo "active";}?>"
							 href="produits-en-stock-min.php">
								<i class="fa fa-exclamation-triangle  c-red icon-hx icons"></i> Prouits en stock minimum  </a>
						</li>
						<li>
							<a class="<?php if(strpos($_SERVER['REQUEST_URI'],'repture-stocks.php') !== false){ echo "active";}?>"
								href="repture-stocks.php">
								<i class="fa fa-exclamation c-red icon-hx icons" aria-hidden="true"></i>
								<span class="title">Produits en rupture de stock <span class="NotifNumber"><?php  echo $stock_zeroo['stock_zero']; ?> </span></span>
							</a>
						</li>
				
					
						</ul>	


		</li>









			<li class="<?php if(strpos($_SERVER['REQUEST_URI'],'manage-categories.php') !== false){ echo "open";}?>">
				<a class="" href="manage-categories.php">
				<i class="ti-view-list-alt c-vertdeau icon-hx icons"></i>
				<span class="title">Gestion des catégories</span></a>
			</li>

			
				<li class="<?php if(strpos($_SERVER['PHP_SELF'],'liste-des-demandes.php') !== false){ echo "open";}?>" >
			<a href="liste-des-demandes.php" >
				 <i class="ti-layout-list-thumb-alt c-orange"></i>
				<span class="title">Packs personnalisés <span class="NotifNumber"><?php echo $nb_Demandes; ?> </span></span>
			</a>
		</li>
			<li style="display: none;" class="<?php if(!isset($_GET['trash']) && (strpos($_SERVER['REQUEST_URI'],'manage-page.php') !== false)
			|| (strpos($_SERVER['REQUEST_URI'],'manage-page.php') !== false)
			|| (strpos($_SERVER['REQUEST_URI'],'code-barre.php') !== false))
			{ echo "open";}?>">
		
			<a href="javascript:;">
				<i class="ti-files c-yellow icon-hx icons"></i>
				<span class="title">Gestion des pages</span><span class="arrow "></span>
			</a>
			<ul class="sub-menu" >

				<li>
					<a class="<?php if(strpos($_SERVER['REQUEST_URI'],'manage-products.php') !== false){ echo "active";}?>" href="manage-products.php">Accueil</a>
				</li>

				<li>
					<a class="<?php if(strpos($_SERVER['REQUEST_URI'],'page-qui-sommes-nous.php') !== false){ echo "active";}?>" href="page-qui-sommes-nous.php">Qui Somme Nous</a>
				</li>
				<li>
					<a class="<?php if(strpos($_SERVER['REQUEST_URI'],'code-barre.php') !== false){ echo "active";}?>" href="code-barre.php">Contact </a>
				</li>

			</ul>
		</li>


	
			

			<li class="<?php if(strpos($_SERVER['REQUEST_URI'],'manage-actualites.php') !== false){ echo "open";}?>">
				<a class="" href="manage-actualites.php"><i class="ti-layout-media-overlay-alt-2 c-pink icon-hx icons"></i>
					<span class="title">Gestion des actualités</span></a>
				</li> 

				<!--<li class="<?php if(strpos($_SERVER['REQUEST_URI'],'manage-blog.php') !== false){ echo "open";}?>">       
				<a class="" href="manage-blog.php"><i class="fa fa-th-large" style="color: #020096!important"></i>
					<span class="title">Blogs</span></a>
				</li>-->
				
				<li class="<?php if(strpos($_SERVER['REQUEST_URI'],'manage-tags.php') !== false){ echo "open";}?>">
					<a class="" href="manage-tags.php"><i class="ti-tag c-light-blue icon-dash icons"></i>
						<span class="title">Gestion des tags</span></a>
					</li> 
					<? if($_SESSION['User']['role']=='superadmin'): ?>

						<li class="<?php if(!isset($_GET['trash']) && (strpos($_SERVER['REQUEST_URI'],'manage-taille.php') !== false)
						|| (strpos($_SERVER['REQUEST_URI'],'manage-colonnes.php') !== false)

						|| (strpos($_SERVER['REQUEST_URI'],'manage-colonnes-types.php') !== false)

						)
						{ echo "open";}?>">
						<a href="javascript:;">
							<i class="ti-layout-list-thumb c-purple icon-hx icons"></i>
							<span class="title">Gestion des tableaux</span><span class="arrow "></span>
						</a>
						<ul class="sub-menu" >
							<li>
								<a class="<?php if(strpos($_SERVER['REQUEST_URI'],'manage-colonnes.php') !== false){ echo "active";}?>" href="manage-colonnes.php">Liste des colonnes</a>
							</li>
						</ul>
					</li> 

					<li class="<?php if(!isset($_GET['trash']) && (strpos($_SERVER['REQUEST_URI'],'manage-client.php') !== false)
					|| (strpos($_SERVER['REQUEST_URI'],'liste-des-inscrits.php') !== false)

					|| (strpos($_SERVER['REQUEST_URI'],'gestion-compte.php') !== false)

					)
					{ echo "open";}?>">

					<a href="javascript:;">
						<i class="ti-settings c-pink icon-hx icons"></i>
						<span class="title">Gestion des comptes</span><span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li>
							<a class="<?php if(strpos($_SERVER['REQUEST_URI'],'gestion-compte.php') !== false){ echo "active";}?>" href="gestion-compte.php"><i class="fa fa-users c-red icon-hx icons"></i>Gestion des administrateurs</a>
						</li>


						<li>
							<a class="<?php if(strpos($_SERVER['REQUEST_URI'],'liste-des-inscrits.php') !== false){ echo "active";}?>" href="liste-des-inscrits.php">
								<i class="fa fa-user c-red icon-hx icons" style="position: relative;">
									<span class="c-red plus-news">+</span>
								</i>
								<span class="title">Gestion des clients</span>
							</a>
						</li>
						<li>
							<a class="<?php if(strpos($_SERVER['REQUEST_URI'],'manage-client.php') !== false){ echo "active";}?>" href="manage-client.php"><i class="fa fa-user c-red icon-hx icons"></i>
								<span class="title">Liste des clients professionelle</span></a>
						</li>
					
						

						<!--<li>
							<a class="<?php /*if(strpos($_SERVER['REQUEST_URI'],'view-historiques.php') !== false){ echo "active";}?>" href="view-historiques.php">Historique</a>
						</li>
						<li>
							<a class="<?php if(strpos($_SERVER['REQUEST_URI'],'backup.php') !== false){ echo "active";} */ ?> " href="backup.php">Exporter les données</a>
						</li>-->

					</ul>
				</li>

			<? endif;?>



			<li class="<?php if(strpos($_SERVER['REQUEST_URI'],'manage-blog.php') !== false){ echo "open";}?>">       
				<a class="" href="manage-blog.php"><i class="fa fa-th-large" style="color: #020096!important"></i>
					<span class="title">Blogs</span></a>
				</li>

		</ul>
		<?php } ?>


		<?php if(($user_role != "superadmin") && ($user_role != "blogger") && ($user_role !="")) { ?>
			<!-- USER INFO - END -->
			<ul class='wraplist'>
				<li class="<?php if(strpos($_SERVER['PHP_SELF'],'liste-des-demandes.php') !== false){ echo "open";}?>" >
					<a href="liste-des-demandes.php" >
						<i class="ti-list c-purple icon-hx icons"></i>
						<span class="title"> Liste des demandes </span>
					</a>
				</li>
				
<li class="<?php if(strpos($_SERVER['REQUEST_URI'],'manage-client.php') !== false){ echo "open";}?>">
				<a class="" href="manage-client.php"><i class="ti-user c-red icon-hx icons"></i>
					<span class="title">Gestion des clients</span></a>
				</li>
			</ul>
		<?php } ?>	

	</div>
	<!-- MAIN MENU - END -->




	<div class="project-info" >
		<center>
			<span class='title'>Développé Par</span>
			<a href="http://www.mbdesign-tn.com/" target="_blank"><img src="images/logo-mb-design-66-x-24-px.png"></a>
		</center>
	</div>

</div>		

<div class='page-topbar '>
	  <div class='logo-area'>
	  	<img src="images/logo-hydrex-200.png" class="img-responsive img_logo logo-nav">
	  	<img src="images/icon-Hydrex.png" class="img-responsive img_logo logo-icon">
	  </div> 
	  
	<div class='quick-area'>   
		<div class='pull-left'>
			<ul class="info-menu left-links list-inline list-unstyled">
				<li class="">
					<a href="#" data-toggle="sidebar" class="sidebar_toggle">
					<i class="fa fa-bars"></i>
					</a>
				</li>
				
				
				<li class="hidden-sm hidden-xs searchform">
					<div class="input-group">
						<span class="input-group-addon input-focus">
							<i class="fa fa-search"></i>
						</span>
						<form method="post">
							<input type="text" class="form-control animated fadeIn" placeholder="Rechercher">
							<input type='submit' value="">
						</form>
					</div>
				</li>
			</ul>
		</div>		
		<div class='pull-right'>
			<ul class="info-menu right-links list-inline list-unstyled">
				<li class="profile">
					<a href="#" data-toggle="dropdown" class="toggle">
					<span class="hidden-xs"><?php echo $_SESSION['User']['firstname'].' '.$_SESSION['User']['lastname']; ?> <i class="fa fa-angle-down"></i></span>
					</a>
					<ul class="dropdown-menu profile animated fadeIn">
						<!--<li>
							<a href="#settings">
							<i class="fa fa-wrench"></i>
							Settings
							</a>
						</li>-->
						<li>
							<a href="users-edit.php?id=<?php echo $_SESSION['User']['id']; ?>">
							<i class="fa fa-user"></i>
							Mon compte
							</a>
						</li>
						<!--<li>
							<a href="#help">
							<i class="fa fa-info"></i>
							Help
							</a>
						</li>-->
						<li class="last">
							<a href="logout.php">
							<i class="fa fa-lock"></i>
							Déconnexion
							</a>
						</li>
					</ul>
				</li>
				
			</ul>			
		</div>		
	</div>
	
</div>
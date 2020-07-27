<div class="articles">
	<div class="article">
			<?php 
			
			if(isset($formOrgane)){
			    $formOrgane->afficherFormulaire();
			}?>
	</div>
	<hr class="separer">
	<div class="article">
		<div class="maladiePlante">
			<h3 class="titre">Maladies</h3>	
			<?php if(isset($leMenuMaladieOrgane)){ echo $leMenuMaladieOrgane;} ?>			
		</div>
		<div class="ravageurPlante">
			<h3 class="titre">Ravageurs</h3>
			<?php if(isset($leMenuMaladieRavageur)){ echo $leMenuMaladieRavageur; } ?>
		</div>
		<?php if(isset($leFormGererOrgane)){ echo $leFormGererOrgane;}?>
	</div>
</div>
<div class="articles">
	<div class="article">
			<?php 
			
			if(isset($formTraitement)){
			    $formTraitement->afficherFormulaire();
			}?>
	</div>
	<hr class="separer">
	<div class="article">
		<div class="maladiePlante">
			<h3 class="titre">Maladies</h3>	
			<?php if(isset($leMenuMaladieTraitement)){ echo $leMenuMaladieTraitement;} ?>			
		</div>
		<div class="ravageurPlante">
			<h3 class="titre">Ravageurs</h3>
			<?php if(isset($leMenuMaladieRavageur)){ echo $leMenuMaladieRavageur; } ?>
		</div>
		<?php if(isset($leFormGererTraitement)){ echo $leFormGererTraitement;}?>
	</div>
</div>
<div class="articles">
	<div class="article">
			<?php 
			
			if(isset($formPlante)){
			    $formPlante->afficherFormulaire();
			}?>
	</div>
	<hr class="separer">
	<div class="article">
		<div class="maladiePlante">
			<h3 class="titre">Maladies</h3>	
			<?php if(isset($leMenuMaladiePlante)){ echo $leMenuMaladiePlante;}?>	
		</div>
		<div class="ravageurPlante">
			<h3 class="titre">Ravageurs</h3>
			<?php if(isset($leMenuMaladieRavageur)){ echo $leMenuMaladieRavageur;}?>
		</div>
		<?php if(isset($leFormGererPlante)){ echo $leFormGererPlante;}?>
	</div>
</div>
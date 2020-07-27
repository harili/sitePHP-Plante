<div class="articles">
	<div class="article">
			<?php 
			if(isset($formRavageur)){
			    $formRavageur->afficherFormulaire();
			}?>
	</div>
	<hr class="separer">
	<div class="article">
		<div class="planteRavageur">
			<h3 class="titre">Plantes</h3>	
			<?php 
			if(isset($leMenuPlanteRavageur)){ echo $leMenuPlanteRavageur;} ?>			
		</div>
		<div class="organeRavageur">
			<h3 class="titre">Organes</h3>
			<?php 
			if(isset($leMenuOrganeRavageur)){ echo $leMenuOrganeRavageur; } ?>
		</div>
		<div class="traitementRavageur">
			<h3 class="titre">Traitements</h3>
			<?php 
			if(isset($leMenuTraitementRavageur)){ echo $leMenuTraitementRavageur; } ?>
		</div>
		<?php if(isset($formGererRavageur)){ $formGererRavageur->afficherFormulaire();}?>
	</div>
</div>
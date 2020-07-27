<div class="articles">
	<div class="article">
			<?php 
			if(isset($formMaladie)){
			    $formMaladie->afficherFormulaire();
			}?>
	</div>
	<hr class="separer">
	<div class="article">
		<div class="planteRavageur">
			<h3 class="titre">Plantes</h3>	
			<?php 
			if(isset($leMenuPlanteMaladie)){ echo $leMenuPlanteMaladie;} ?>			
		</div>
		<div class="organeRavageur">
			<h3 class="titre">Organes</h3>
			<?php 
			if(isset($leMenuOrganeMaladie)){ echo $leMenuOrganeMaladie; } ?>
		</div>
		<div class="traitementRavageur">
			<h3 class="titre">Traitements</h3>
			<?php 
			if(isset($leMenuTraitementMaladie)){ echo $leMenuTraitementMaladie; } ?>
		</div>
		<?php if(isset($formGererMaladie)){ $formGererMaladie->afficherFormulaire();}?>
	</div>
</div>
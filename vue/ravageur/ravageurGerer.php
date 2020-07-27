<div class="articles">
	<div class="article">
			<?php 
			if(isset($formPlanteRavageur)){
			    $formPlanteRavageur->afficherFormulaire();
			}
			if(isset($formOrganeRavageur)){
			    $formOrganeRavageur->afficherFormulaire();
			}
			if(isset($formTraitementRavageur)){
			    $formTraitementRavageur->afficherFormulaire();
			}
			
			
			if(isset($tabGererRavageur)){
			    $tabGererRavageur->afficherTableau();
			}
			
			?>
	</div>
</div>
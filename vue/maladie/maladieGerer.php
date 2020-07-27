<div class="articles">
	<div class="article">
			<?php 
			if(isset($formPlanteMaladie)){
			    $formPlanteMaladie->afficherFormulaire();
			}
			if(isset($formOrganeMaladie)){
			    $formOrganeMaladie->afficherFormulaire();
			}
			if(isset($formTraitementMaladie)){
			    $formTraitementMaladie->afficherFormulaire();
			}
			
			
			if(isset($tabGererMaladie)){
			    $tabGererMaladie->afficherTableau();
			}
			
			?>
	</div>
</div>
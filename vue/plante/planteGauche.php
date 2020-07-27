<nav class="menuGauche" id="menuPlantes">
	<?php echo $leMenuPlante;?>
</nav>
<?php 
    if(isset($formAjout)){
        $formAjout->afficherFormulaire();
    }?>
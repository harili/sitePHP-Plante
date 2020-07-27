<?php
if(isset($_SESSION['intervenant']) && $_SESSION['intervenant']->getCodeStatut() == "S01"){
    $formGestionCompte = new Formulaire("post", "index.php", "choixCompte", "choixCompte");
    
    $gest = $formGestionCompte->creerInputSubmit("gestion", "gestion", "Gestion des comptes");
    $compte = $formGestionCompte->creerInputSubmit("compte", "compte", "Mon compte");
    
    
    $formGestionCompte->ajouterComposantLigne($gest);
    $formGestionCompte->ajouterComposantTab();
    $formGestionCompte->ajouterComposantLigne($compte);
    $formGestionCompte->ajouterComposantTab();
    
    
    $formGestionCompte->creerFormulaire();
}

require_once 'vue/vueChoix.php' ;
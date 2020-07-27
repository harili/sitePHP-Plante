<?php

$formulaire = new Formulaire("post", "index.php", "identification", "connexion");
// Les labels
$labelLogin = $formulaire->creerLabelFor("login", "Login : ");
$labelMDP = $formulaire->creerLabelFor("mdp", "Mot de passe : ");
// La textbox du pseudo
$login = $formulaire->creerInputTexte("login", "login", "", 1, "", "");
$mdp = $formulaire->creerInputMdp("mdp", "mdp", 1, "", "");
// Les boutons
$envoyer = $formulaire->creerInputSubmit("submit", "submit", "Se connecter");
$effacer = $formulaire->creerInputReset("reset", "reset", "Effacer");

$formulaire->ajouterComposantLigne($labelLogin);
$formulaire->ajouterComposantLigne($login);
$formulaire->ajouterComposantTab();
$formulaire->ajouterComposantLigne($labelMDP);
$formulaire->ajouterComposantLigne($mdp);
$formulaire->ajouterComposantTab();
$formulaire->ajouterComposantLigne($envoyer);
$formulaire->ajouterComposantTab();

$form = $formulaire->creerFormulaire();

$menuInscription = new Menu('demandeInscription');
$menuInscription->ajouterComposant($menuInscription->creerItemLien('inscription','Créer un compte'));
$menuInscription = $menuInscription->creerMenu("", "inscription");

// Deconnexion
if(isset($_GET['ifra']) && isset($_SESSION['testAuthentification'])){
    if($_SESSION['testAuthentification']== 1 && $_GET['ifra'] == 'identification'){
        session_destroy();
        $_SESSION['testAuthentification']= 0;
        $_SESSION['ifra']="accueil";
        
    }
}

require_once 'vue/vueIdentification.php' ;
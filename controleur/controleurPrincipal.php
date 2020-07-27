<?php 
    require_once 'modele/accesDonnees.php';
    $idConnex = connexion($dsn, $user, $pass);
    
    
    // Authentification
    if(isset($_POST['login'])){
        $_SESSION['testAuthentification'] = authentification($idConnex, $_POST['login'], $_POST['mdp']);
        if($_SESSION['testAuthentification'] == "1"){
            $utilisateur = intervenant($idConnex, $_POST['login']);
            $unIntervenant = new Intervenant();
            $unIntervenant->hydrate($utilisateur);
            $_SESSION["intervenant"] = $unIntervenant;
            $_SESSION['ifra']="accueil";
        }
        else{
            $message =  "Identifiant et/ou mot de passe incorrect.";
            $_SESSION['ifra']="identification";
        }
    }
    
    // Deconnexion
    if(isset($_GET['ifra']) && isset($_SESSION['testAuthentification'])){
        if($_SESSION['testAuthentification']== 1 && $_GET['ifra'] == 'identification'){
            session_destroy();
            $_SESSION['testAuthentification']= 0;
            $_SESSION['ifra']="accueil";
            
        }
    }


    if(isset($_GET['ifra'])){
        $_SESSION['ifra']= $_GET['ifra'];
    }
    else
    {
        if(!isset($_SESSION['ifra'])){
            $_SESSION['ifra']="accueil";
        }
    }
    
    //*****************************************************************
    //       Redirection vers connexion / inscription.
    //*****************************************************************
    //Demande de connexion
    if(isset($_POST['identification'])){
        $_SESSION['ifra']= "identification";
        
    }
    //Demande d'inscription
    if(isset($_GET['inscription'])){
        $_SESSION['ifra']= "inscription";
    }

    //*****************************************************************
    //     FIN      -       Redirection vers connexion / inscription.
    //*****************************************************************
    
    //*****************************************************************
    //       Redirection vers mon compte / gestion compte.
    //*****************************************************************
    //Demande de connexion
    if(isset($_POST['gestion'])){
        $_SESSION['ifra']= "gestion";
        
    }
    //Demande d'inscription
    if(isset($_POST['compte'])){
        $_SESSION['ifra']= "compte";
    }
    
    //*****************************************************************
    //     FIN      -     Redirection vers mon compte / gestion compte.
    //*****************************************************************

    
    
    $menuPrincipal = new Menu("ifra");
    $menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien("accueil", "Accueil"));
    $menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien("plante", "Plante"));
    $menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien("organe", "Organe"));
    $menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien("maladie", "Maladie"));
    $menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien("ravageur", "Ravageur"));
    $menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien("traitement", "Traitement"));
    $menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien("epidemiologie", "Épidémiologie"));
    $menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien("contact", "Contact"));
    if(isset($_SESSION['testAuthentification'])){
        if($_SESSION['testAuthentification']== 1){
            if(isset($_SESSION['intervenant']) ){
                if($_SESSION['intervenant']->getCodeStatut() != "S01" ){
                    $menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien("compte", "Mon compte"));
                }
                else{
                    $menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien("choix", "Les comptes"));
                }
            }
            $menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien("identification", "Déconnexion"));
        }
        else{
            $menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien("identification", "Identification"));
        }
    }
    else{
        $menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien("identification", "Identification"));
    }
    $monMenu = $menuPrincipal->creerMenu($_SESSION['ifra'], "ifra");
    
    
    include_once dispatcher::dispatch($_SESSION['ifra']);
    //var_dump($_SESSION);
?>
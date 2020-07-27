<?php
// On recupère les traitements de la base de données
$listeTraitements = new Traitements(TraitementDAO::getTraitements());


if(isset($_SESSION['leTraitement'])){
    //         Ajouter traitement - 2eme partie
    if($_SESSION['traitement'] != 0 && isset($_POST['enregistrer'])){
        $traitementActif = new Traitement();
        
        $idTraitement = TraitementDAO::maxID()+1;
        $traitementActif->setIdTraitement($idTraitement);
        $traitementActif->setNomTraitement($_POST['nomTraitement']);
        $traitementActif->setDescriptifTraitement($_POST['descriptifTraitement']);
        TraitementDAO::ajouterTraitement($traitementActif);
        
        $listeTraitements = new Traitements(TraitementDAO::getTraitements());
        
        $_SESSION['traitement'] = $idTraitement;
        
    }
    //         Modifier traitement - deuxieme partie
    if($_SESSION['traitement'] != 0 && isset($_POST['modifier'])){
        $traitementActif = new Traitement();
        $traitementActif->setIdTraitement($_SESSION['leTraitement']->getIdTraitement());
        $traitementActif->setNomTraitement($_POST['nomTraitement']);
        $traitementActif->setDescriptifTraitement($_POST['descriptifTraitement']);
        TraitementDAO::modifierTraitement($traitementActif);
        
        $listeTraitements = new Traitements(TraitementDAO::getTraitements());
        
        
        
    }
    //         Supprimer traitement - 2eme partie
    if($_SESSION['traitement'] != 0 && isset($_POST['ouiSupprTraitement'])){
        $traitementActif = new Traitement();
        $traitementActif->setIdTraitement($_SESSION['leTraitement']->getIdTraitement());
        $traitementActif->setNomTraitement($_SESSION['leTraitement']->getNomTraitement());
        $traitementActif->setDescriptifTraitement($_SESSION['leTraitement']->getDescriptifTraitement());
        TraitementDAO::supprimerTraite($traitementActif);
        
        $_SESSION['traitement']= TraitementDAO::maxID();
        $listeTraitements = new Traitements(TraitementDAO::getTraitements());
        
    }
    
    //         Ajouter traiter - 2eme partie
    if($_SESSION['traitement'] != 0 && isset($_POST['boutonAjouterTraiter'])){
        $nomBioagresseur = $_POST['listeBioagresseur'];
        $listeBioagresseur = BioagresseurDAO::getBioAgresseurs();
        foreach($listeBioagresseur as $bioagresseur){
            if($bioagresseur->getNomBioagresseur() == $nomBioagresseur){
                TraitementDAO::ajouterTraiter($_SESSION['leTraitement'], $bioagresseur);
            }
        }
    }
    
    //         Supprimer affecter - 2eme partie
    if($_SESSION['traitement'] != 0 && isset($_POST['boutonSupprTraiter'])){
        TraitementDAO::supprimerTraitementTraiter($_SESSION['leTraitement'], $_POST['idBioagresseur']);
    }
}


// **********************************************
    //          Choix d'un Traitement
    // **********************************************
    
    
    // Si on a un Traitement choisi ou bien on prend le Traitement de base
    if(isset($_GET['traitement'])){
        $_SESSION['traitement']= $_GET['traitement'];
    }
    else
    {
        if(!isset($_SESSION['traitement'])){
            $_SESSION['traitement']=1;
        }
    }
    
    
    $menuTraitement = new Menu("menuTraitement");
    // Pour chaque plante on recupère le nom et on crée un lien vers leur page
    foreach ($listeTraitements->getTraitements() as $unTraitement){
        $menuTraitement->ajouterComposant($menuTraitement->creerItemLien($unTraitement->getIdTraitement(),$unTraitement->getNomTraitement()));
    }
    //On crée le menu avec toutes les plantes + liens
    $leMenuTraitement = $menuTraitement->creerMenu($_SESSION['traitement'], "ifra=traitement&traitement");
    
    
    //     Bouton ajout si on a les droits
    if(isset($_SESSION['intervenant']) && $_SESSION['intervenant']->getCodeStatut() == "S01"){
        $formAjout = new Formulaire("post", "index.php", "formAjoutTraitement", "formAjout");
        $formAjout->ajouterComposantLigne($formAjout->creerInputSubmit("boutonAjouter", "ajouterTraitement", "Ajouter"));
        $formAjout->ajouterComposantTab();
        $formAjout->creerFormulaire();
    }
    
    // **********************************************
    //        Affiche le Traitement
    // **********************************************
    
    foreach($listeTraitements->getTraitements() as $unTraitement){
        
        //         On recupere la plante choisie
        if($unTraitement->getIdTraitement() == $_SESSION['traitement']){
            $Traitement = TraitementDAO::lire($_SESSION['traitement']);
            $leTraitement = new Traitement();
            $leTraitement->hydrate($Traitement);
            //             On le passe en session
            $_SESSION['leTraitement']=$leTraitement;
            
            $formTraitement = new Formulaire("post", "index.php", "formPlante", "formPlante");
            $formTraitement->ajouterComposantLigne($formTraitement->creerTitreH3($leTraitement->getNomTraitement()));
            $formTraitement->ajouterComposantTab();
            $formTraitement->ajouterComposantLigne($formTraitement->creerCorps($leTraitement->getDescriptifTraitement()));
            $formTraitement->ajouterComposantTab();
            
            
            //                 Bouton modifier et suppression si on a les droits
            if(isset($_SESSION['intervenant']) && $_SESSION['intervenant']->getCodeStatut() == "S01"){
                $unComposant = $formTraitement->creerInputSubmit("boutonModifier", "modifierTraitement", "Modifier");
                $autreComposant = $formTraitement->creerInputSubmit("boutonSupprimer", "supprimerTraitement", "Supprimer");
                $formTraitement->ajouterComposantLigne($formTraitement->concactComposants($unComposant, $autreComposant));
                $formTraitement->ajouterComposantTab();
            }
            
            $formTraitement->creerFormulaire();
        }
    }
    
    if(isset($_SESSION['leTraitement'])){
        //         On recupere les maladies et ravageurs du traitement
        $listeMaladie = TraitementDAO::getLesMaladies($_SESSION['leTraitement']);
        $listeRavageur = TraitementDAO::getLesRavageurs($_SESSION['leTraitement']);
        
        // On crée la liste des maladies de la plante
        $menuMaladieTraitement = new Menu("menuMaladieTraitement");
        foreach ($listeMaladie as $uneMaladie){
            $menuMaladieTraitement->ajouterComposant($menuMaladieTraitement->creerItemLien($uneMaladie["idBioagresseur"],$uneMaladie["nomBioagresseur"]));
        }
        $leMenuMaladieTraitement = $menuMaladieTraitement->creerMenu("", "ifra=maladie&maladie");
        
        // On crée la liste des maladies de la plante
        $menuMaladieRavageur = new Menu("menuRavageurTraitement");
        foreach ($listeRavageur as $unRavageur){
            $menuMaladieRavageur->ajouterComposant($menuMaladieRavageur->creerItemLien($unRavageur["idBioagresseur"],$unRavageur["nomBioagresseur"]));
        }
        $leMenuMaladieRavageur = $menuMaladieRavageur->creerMenu("", "ifra=ravageur&ravageur");
        

    }
    
    //     Bouton gérer si on a les droits
    if(isset($_SESSION['intervenant']) && $_SESSION['intervenant']->getCodeStatut() == "S01"){
        $formGererTraitement = new Formulaire("post", "index.php", "formGererTraitement", "formGerer");
        $formGererTraitement->ajouterComposantLigne($formGererTraitement->creerInputSubmit("boutonGerer", "gererTraitement", "Gérer"));
        $formGererTraitement->ajouterComposantTab();
        $leFormGererTraitement = $formGererTraitement->creerFormulaire();
    }
    
    // **********************************************
    //        Fin - Affiche le Traitement
    // **********************************************
    // **********************************************
    //         Ajout / Modif / Suppr Traitement
    // **********************************************
    
    
    //             Ajouter un Traitement #1 - Premiere partie
    if($_SESSION['traitement'] != "0" && isset($_POST['boutonAjouter'])){
        $formAjoutTraitement = new Formulaire("post","index.php","formAjoutTraitement","formAjoutTraitement");
        $formAjoutTraitement->ajouterComposantLigne($formAjoutTraitement->creerTitreH3("Ajouter un Traitement"));
        $formAjoutTraitement->ajouterComposantTab();
        $formAjoutTraitement->ajouterComposantLigne($formAjoutTraitement->creerLabelFor("nomTraitement", "Nom du Traitement : "));
        $formAjoutTraitement->ajouterComposantLigne($formAjoutTraitement->creerInputTexte("nomTraitement", "nomTraitement", "", "" ,""  , "" , ""));
        $formAjoutTraitement->ajouterComposantTab();
        $formAjoutTraitement->ajouterComposantLigne($formAjoutTraitement->creerLabelFor("descriptifTraitement", "Descriptif du Traitement : "));
        $formAjoutTraitement->ajouterComposantLigne($formAjoutTraitement->creerInputTexte("descriptifTraitement", "descriptifTraitement", "", "" ,""  , "" , ""));
        $formAjoutTraitement->ajouterComposantTab();
        $formAjoutTraitement->ajouterComposantLigne($formAjoutTraitement->creerInputSubmit("enregistrer", "enregistrer", "Enregistrer"));
        $formAjoutTraitement->ajouterComposantTab();
        
        
        $formAjoutTraitement->creerFormulaire();
        
        
    }
    //              Modifier un traitement #1 - Premiere partie
    if($_SESSION['traitement'] != "0" && isset($_POST['boutonModifier'])){
        $formModifTraitement = new Formulaire("post","index.php","formModifTraitement","formModifTraitement");
        $formModifTraitement->ajouterComposantLigne($formModifTraitement->creerTitreH3("Modifier un traitement : " . $_SESSION['leTraitement']->getNomTraitement()));
        $formModifTraitement->ajouterComposantTab();
        $formModifTraitement->ajouterComposantLigne($formModifTraitement->creerLabelFor("nomTraitement", "Nom du Traitement : "));
        $formModifTraitement->ajouterComposantLigne($formModifTraitement->creerInputTexte("nomTraitement", "nomTraitement", $_SESSION['leTraitement']->getNomTraitement(), "" ,""  , "" , ""));
        $formModifTraitement->ajouterComposantTab();
        $formModifTraitement->ajouterComposantLigne($formModifTraitement->creerLabelFor("descriptifTraitement", "Descriptif du Traitement : "));
        $formModifTraitement->ajouterComposantLigne($formModifTraitement->creerInputTexte("descriptifTraitement", "descriptifTraitement", $_SESSION['leTraitement']->getDescriptifTraitement(), "" ,""  , "" , ""));
        $formModifTraitement->ajouterComposantTab();
        $formModifTraitement->ajouterComposantLigne($formModifTraitement->creerInputSubmit("modifier", "modifier", "Modifier"));
        $formModifTraitement->ajouterComposantTab();
        
        $formModifTraitement->creerFormulaire();
    }
    
    //              Supprimer un traitement #1 - Premiere partie
    if($_SESSION['traitement'] != "0" && isset($_POST['boutonSupprimer'])){
        $formSupprTraitement = new Formulaire("post","index.php","formSupprTraitement","formSupprTraitement");
        $formSupprTraitement->ajouterComposantLigne($formSupprTraitement->creerTitreH3("Supprimer un traitement : " . $_SESSION['leTraitement']->getNomTraitement()));
        $formSupprTraitement->ajouterComposantTab();
        $formSupprTraitement->ajouterComposantLigne($formSupprTraitement->creerLabelFor("nomTraitement", "Voulez vous vraiment supprimer ce traitement ? "));
        $formSupprTraitement->ajouterComposantLigne($formSupprTraitement->creerLabelId($_SESSION['leTraitement']->getNomTraitement(), "nomTraitement"));
        $formSupprTraitement->ajouterComposantTab();
        $unComposant = $formSupprTraitement->creerInputSubmit("ouiSupprTraitement", "ouiTraitement", "Supprimer");
        $autreComposant = $formSupprTraitement->creerInputSubmit("nomSupprTraitement", "nomTraitement", "Annuler");
        $formSupprTraitement->ajouterComposantLigne($formSupprTraitement->concactComposants($unComposant, $autreComposant));
        $formSupprTraitement->ajouterComposantTab();
        
        
        $formSupprTraitement->creerFormulaire();
    }
    // **********************************************
    //        Fin -  Ajout / Modif / Suppr le Traitement
    // **********************************************
    
    // **********************************************
    //        Gérer les maladies / ravageurs
    // **********************************************
    
    
    if($_SESSION['traitement'] != "0" && isset($_POST['boutonGerer'])){
        
        //     Ajouter un affecter - 1ere partie
        $lesBioagresseurs = TraitementDAO::getLesBioagresseursNOT($_SESSION['leTraitement']) ;
        
        $formBioagresseurTraitement = new Formulaire("post","index.php","formBioagresseurTraitement","formBioagresseurTraitement");
        $formBioagresseurTraitement->ajouterComposantLigne($formBioagresseurTraitement->creerTitreH3("Ajouter un bioagresseur : "));
        $formBioagresseurTraitement->ajouterComposantTab();
        $formBioagresseurTraitement->ajouterComposantLigne($formBioagresseurTraitement->creerLabel("<br/>"));
        $formBioagresseurTraitement->ajouterComposantTab();
        
        //         On vérifie que le Traitement à bien des bioagresseurs disponibles
        if(!empty($lesBioagresseurs)){
            $formBioagresseurTraitement->ajouterComposantLigne($formBioagresseurTraitement->creerLabelFor("listeBioagresseur", "Ajouter un bioagresseur au traitement : "));
            $formBioagresseurTraitement->ajouterComposantLigne($formBioagresseurTraitement->creerSelect("listeBioagresseur", "listeBioagresseur", "Les maladies : ", $lesBioagresseurs));
            $formBioagresseurTraitement->ajouterComposantLigne($formBioagresseurTraitement->creerInputSubmit("boutonAjouterAffecter", "boutonAjouterAffecter", "Ajouter"));
            $formBioagresseurTraitement->ajouterComposantTab();
        }
        else{
            $formBioagresseurTraitement->ajouterComposantLigne($formBioagresseurTraitement->creerLabel("Aucun bioagresseur trouvé."));
            $formBioagresseurTraitement->ajouterComposantTab();
        }
        
        $formBioagresseurTraitement->creerFormulaire();
        
        //         Supprimer un affecter - 1ere partie
        // On recupere les bioagresseurs du Traitement
        $lesBioagresseurs = TraitementDAO::getLesBioagresseurs($_SESSION['leTraitement']);
        if(!empty($lesBioagresseurs)){
            $tabBioagresseurTraitement = [];
            $i = 0;
            foreach($lesBioagresseurs as $bioagresseur){
                $tabBioagresseurTraitement[$i][0] = $bioagresseur['nomBioagresseur'];
                $tabBioagresseurTraitement[$i][1] = "<form method='post' action = 'index.php' name='formSupp'>".Fonctions::creerInputHidden("idBioagresseur", "idBioagresseur", $bioagresseur['idBioagresseur']).Fonctions::creerInputSubmit("boutonSupprAffecter", "boutonSupprAffecter", "Supprimer")."</form>";
                $i++;
            }
            $tabBioagresseurTraitement = new Tableau("tabBioagresseur", $tabBioagresseurTraitement);
            $tabBioagresseurTraitement->setTitreTab("Les bioagresseurs de ".$_SESSION['leTraitement']->getNomTraitement());
            $tabBioagresseurTraitement->setTitreCol(array("Bioagresseur", ""));
        }
        
    }
    
    
    // **********************************************
    //      Fin -   Gérer les maladies / ravageurs
    // **********************************************
    
    
    
    
    
    
    

require_once 'vue/vueSqueletteTraitement.php' ;
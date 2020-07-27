<?php

// Fonction pour upload une image
function upload(){
    if(!empty($_FILES['image']['name'])){
        $nomOrigine = $_FILES['image']['name'];
        $elementsChemin = pathinfo($nomOrigine);
        $extensionFichier = $elementsChemin['extension'];
        $extensionsAutorisees = array("jpg");
        if (!(in_array($extensionFichier, $extensionsAutorisees))) {
            $erreur = "Le fichier n'a pas l'extension attendue";
        } else {
            // Copie dans le repertoire du script avec un nom
            // incluant l'heure a la seconde pres
            $repertoire_upload_absolu   = 'images/';
            $repertoireDestination = $repertoire_upload_absolu;
            $nomDestination = strtolower($_POST['nomOrgane'].".jpg");
            
            if (move_uploaded_file($_FILES["image"]["tmp_name"],
                $repertoireDestination.$nomDestination)) {
                    $erreur = "Le fichier temporaire ".$_FILES["image"]["tmp_name"].
                    " a été déplacé vers ".$repertoireDestination.$nomDestination;
                } else {
                    $erreur = "Le fichier n'a pas été uploadé (trop gros ?) ou ".
                        "Le déplacement du fichier temporaire a échoué".
                        " vérifiez l'existence du répertoire ".$repertoireDestination;
                }
        }
    }
}

// On recupère les organes de la base de données
$listeOrganes = new Organes(OrganeDAO::getOrganes());


if(isset($_SESSION['lOrgane'])){
    //         Ajouter organe - 2eme partie
    if($_SESSION['organe'] != 0 && isset($_POST['enregistrer'])){
        $organeActive = new Organe();
        $idOrgane = OrganeDAO::maxID()+1;
        $organeActive->setIdOrgane($idOrgane);
        $organeActive->setNomOrgane($_POST['nomOrgane']);
        OrganeDAO::ajouterOrgane($organeActive);
        
        $listeOrganes = new Organes(OrganeDAO::getOrganes());
        
        $_SESSION['organe'] = $idOrgane;
        
        upload();
        
    }
    //         Modifier organe - deuxieme partie
    if($_SESSION['organe'] != 0 && isset($_POST['modifier'])){
        $organeActive = new Organe();
        $organeActive->setIdOrgane($_SESSION['lOrgane']->getIdOrgane());
        $organeActive->setNomOrgane($_POST['nomOrgane']);
        OrganeDAO::modifierOrgane($organeActive);
        
        $listeOrganes = new Organes(OrganeDAO::getOrganes());
        
        upload();
        
        
        
    }
    //         Supprimer organe - 2eme partie
    if($_SESSION['organe'] != 0 && isset($_POST['ouiSupprOrgane'])){
        $organeActive = new Organe();
        $organeActive->setIdOrgane($_SESSION['lOrgane']->getIdOrgane());
        $organeActive->setNomOrgane($_SESSION['lOrgane']->getNomOrgane());
        OrganeDAO::supprimerOrgane($organeActive);
        
        $_SESSION['organe']= OrganeDAO::maxID();
        $listeOrganes = new Organes(OrganeDAO::getOrganes());
        
        //             Supprimer photo dans le dossier
        $filename = './images/'.strtolower($organeActive->getNomOrgane()).'.jpg';
        if(file_exists($filename)){
            unlink ($filename );
        }
        
        
    }
    
    //         Ajouter affecter - 2eme partie
    if($_SESSION['organe'] != 0 && isset($_POST['boutonAjouterAffecter'])){
        $nomBioagresseur = $_POST['listeBioagresseur'];
        $listeBioagresseur = BioagresseurDAO::getBioAgresseurs();
        foreach($listeBioagresseur as $bioagresseur){
            if($bioagresseur->getNomBioagresseur() == $nomBioagresseur){
                OrganeDAO::ajouterAffecter($_SESSION['lOrgane'], $bioagresseur);
            }
        }
    }
    
    //         Supprimer affecter - 2eme partie
    if($_SESSION['organe'] != 0 && isset($_POST['boutonSupprAffecter'])){
        OrganeDAO::supprimerOrganeUnAffecter($_SESSION['lOrgane'], $_POST['idBioagresseur']);
    }
}

// **********************************************
//          Choix d'un Organe
// **********************************************


// Si on a un organe choisi ou bien on prend l'organe de base
if(isset($_GET['organe'])){
    $_SESSION['organe']= $_GET['organe'];
}
else
{
    if(!isset($_SESSION['organe'])){
        $_SESSION['organe']=1;
    }
}

// **********************************************
//         Menu de tout les Organes
// **********************************************


// On crée le menu à gauche pour tout les Organes
$menuOrgane = new Menu("menuOrgane");
// Pour chaque organe on recupère le nom et on crée un lien vers leur page
foreach ($listeOrganes->getLesOrganes() as $unOrgane){
    $menuOrgane->ajouterComposant($menuOrgane->creerItemLien($unOrgane->getIdOrgane(),$unOrgane->getNomOrgane()));
}
//On crée le menu avec tout les organes + liens
$leMenuOrgane = $menuOrgane->creerMenu($_SESSION['organe'], "ifra=organe&organe");

//     Bouton ajout si on a les droits
if(isset($_SESSION['intervenant']) && $_SESSION['intervenant']->getCodeStatut() == "S01"){
    $formAjout = new Formulaire("post", "index.php", "formAjoutOrgane", "formAjout");
    $formAjout->ajouterComposantLigne($formAjout->creerInputSubmit("boutonAjouter", "ajouterOrgane", "Ajouter"));
    $formAjout->ajouterComposantTab();
    $formAjout->creerFormulaire();
}

// **********************************************
//        Affiche l'Organe
// **********************************************
if($_SESSION['organe'] != 0){
    foreach($listeOrganes->getLesOrganes() as $unOrgane){
        
        //         On recupere la organe choisie
        if($unOrgane->getIdOrgane() == $_SESSION['organe']){
            $lOrgane = OrganeDAO::lire($_SESSION['organe']);
            $lOrgane = new Organe($lOrgane[0],$lOrgane[1]);
            //             On la passe en session
            $_SESSION['lOrgane']=$lOrgane;
            
            $formOrgane = new Formulaire("post", "index.php?ifra=organe", "formOrgane", "formOrgane");
            $formOrgane->ajouterComposantLigne($formOrgane->creerTitreH3($lOrgane->getNomOrgane()));
            $formOrgane->ajouterComposantTab();
            $filename = './images/'.strtolower($lOrgane->getNomOrgane()).'.jpg';
            if(file_exists($filename)){
                $formOrgane->ajouterComposantLigne($formOrgane->creerImage(strtolower($lOrgane->getNomOrgane()).".jpg", "Photograhie de ".$lOrgane->getNomOrgane()));
                $formOrgane->ajouterComposantTab();
            }
            $formOrgane->ajouterComposantLigne($formOrgane->creerLabel("<br/>"));
            $formOrgane->ajouterComposantTab();
            //                 Bouton modifier et suppression si on a les droits
            if(isset($_SESSION['intervenant']) && $_SESSION['intervenant']->getCodeStatut() == "S01"){
                $unComposant = $formOrgane->creerInputSubmit("boutonModifier", "modifierOrgane", "Modifier");
                $autreComposant = $formOrgane->creerInputSubmit("boutonSupprimer", "supprimerOrgane", "Supprimer");
                $formOrgane->ajouterComposantLigne($formOrgane->concactComposants($unComposant, $autreComposant));
                $formOrgane->ajouterComposantTab();
            }
            
            
            $formOrgane->creerFormulaire();
        }
    }
}

if(isset($_SESSION['lOrgane'])){
    //         On recupere les maladies et ravageurs de la plante
    $listeMaladie = OrganeDAO::getLesMaladies($_SESSION['lOrgane']);
    $listeRavageur = OrganeDAO::getLesRavageurs($_SESSION['lOrgane']);
    
    // On crée la liste des maladies de la plante
    $menuMaladieOrgane = new Menu("menuMaladieOrgane");
    foreach ($listeMaladie as $uneMaladie){
        $menuMaladieOrgane->ajouterComposant($menuMaladieOrgane->creerItemLien($uneMaladie["idBioagresseur"],$uneMaladie["nomBioagresseur"]));
    }
    $leMenuMaladieOrgane = $menuMaladieOrgane->creerMenu("", "ifra=maladie&maladie");
    
    // On crée la liste des maladies de la plante
    $menuMaladieRavageur = new Menu("menuRavageurOrgane");
    foreach ($listeRavageur as $unRavageur){
        $menuMaladieRavageur->ajouterComposant($menuMaladieRavageur->creerItemLien($unRavageur["idBioagresseur"],$unRavageur["nomBioagresseur"]));
    }
    $leMenuMaladieRavageur = $menuMaladieRavageur->creerMenu("", "ifra=ravageur&ravageur");
    
    
}
//     Bouton gérer si on a les droits
if(isset($_SESSION['intervenant']) && $_SESSION['intervenant']->getCodeStatut() == "S01"){
    $formGererOrgane = new Formulaire("post", "index.php", "formGererOrgane", "formGerer");
    $formGererOrgane->ajouterComposantLigne($formGererOrgane->creerInputSubmit("boutonGerer", "gererOrgane", "Gérer"));
    $formGererOrgane->ajouterComposantTab();
    $leFormGererOrgane = $formGererOrgane->creerFormulaire();
}

// **********************************************
//        Fin - Affiche l'Organe
// **********************************************
// **********************************************
//         Ajout / Modif / Suppr l'Organe
// **********************************************


//             Ajouter un organe #1 - Premiere partie
if($_SESSION['organe'] != "0" && isset($_POST['boutonAjouter'])){
    $formAjoutOrgane = new Formulaire("post","index.php","formAjoutOrgane","formAjoutOrgane");
    $formAjoutOrgane->ajouterComposantLigne($formAjoutOrgane->creerTitreH3("Ajouter un Organe"));
    $formAjoutOrgane->ajouterComposantTab();
    $formAjoutOrgane->ajouterComposantLigne($formAjoutOrgane->creerLabelFor("nomOrgane", "Nom de l'organe : "));
    $formAjoutOrgane->ajouterComposantLigne($formAjoutOrgane->creerInputTexte("nomOrgane", "nomOrgane", "", "" ,""  , "" , ""));
    $formAjoutOrgane->ajouterComposantTab();
    $formAjoutOrgane->ajouterComposantLigne($formAjoutOrgane->creerLabelFor("image", "Choisir une image : "));
    $formAjoutOrgane->ajouterComposantLigne($formAjoutOrgane->creerInputFile("image", "image"));
    $formAjoutOrgane->ajouterComposantTab();
    $formAjoutOrgane->ajouterComposantLigne($formAjoutOrgane->creerInputSubmit("enregistrer", "enregistrer", "Enregistrer"));
    $formAjoutOrgane->ajouterComposantTab();
    
    
    $formAjoutOrgane->creerFormulaire();
    
    
}
//              Modifier un organe #1 - Premiere partie
if($_SESSION['organe'] != "0" && isset($_POST['boutonModifier'])){
    $formModifOrgane = new Formulaire("post","index.php","formModifOrgane","formModifOrgane");
    $formModifOrgane->ajouterComposantLigne($formModifOrgane->creerTitreH3("Modifier un organe : " . $_SESSION['lOrgane']->getNomOrgane()));
    $formModifOrgane->ajouterComposantTab();
    $formModifOrgane->ajouterComposantLigne($formModifOrgane->creerLabelFor("nomOrgane", "Nom de l'Organe : "));
    $formModifOrgane->ajouterComposantLigne($formModifOrgane->creerInputTexte("nomOrgane", "nomOrgane", $_SESSION['lOrgane']->getNomOrgane(), "" ,""  , "" , ""));
    $formModifOrgane->ajouterComposantTab();
    $formModifOrgane->ajouterComposantLigne($formModifOrgane->creerLabelFor("image", "Choisir une image : "));
    $formModifOrgane->ajouterComposantLigne($formModifOrgane->creerInputFile("image", "image"));
    $formModifOrgane->ajouterComposantTab();
    $formModifOrgane->ajouterComposantLigne($formModifOrgane->creerInputSubmit("modifier", "modifier", "Modifier"));
    $formModifOrgane->ajouterComposantTab();
    
    $formModifOrgane->creerFormulaire();
}

//              Supprimer un organe #1 - Premiere partie
if($_SESSION['organe'] != "0" && isset($_POST['boutonSupprimer'])){
    $formSupprOrgane = new Formulaire("post","index.php","formSupprOrgane","formSupprOrgane");
    $formSupprOrgane->ajouterComposantLigne($formSupprOrgane->creerTitreH3("Supprimer un organe : " . $_SESSION['lOrgane']->getNomOrgane()));
    $formSupprOrgane->ajouterComposantTab();
    $formSupprOrgane->ajouterComposantLigne($formSupprOrgane->creerLabelFor("nomOrgane", "Voulez vous vraiment supprimer cette organe ? "));
    $formSupprOrgane->ajouterComposantLigne($formSupprOrgane->creerLabelId($_SESSION['lOrgane']->getNomOrgane(), "nomOrgane"));
    $formSupprOrgane->ajouterComposantTab();
    $unComposant = $formSupprOrgane->creerInputSubmit("ouiSupprOrgane", "ouiOrgane", "Supprimer");
    $autreComposant = $formSupprOrgane->creerInputSubmit("nomSupprOrgane", "nomOrgane", "Annuler");
    $formSupprOrgane->ajouterComposantLigne($formSupprOrgane->concactComposants($unComposant, $autreComposant));
    $formSupprOrgane->ajouterComposantTab();
    
    
    $formSupprOrgane->creerFormulaire();
}
// **********************************************
//        Fin -  Ajout / Modif / Suppr l'Organe
// **********************************************

// **********************************************
//        Gérer les maladies / ravageurs
// **********************************************


if($_SESSION['organe'] != "0" && isset($_POST['boutonGerer'])){
    
    //     Ajouter un affecter - 1ere partie
    $lesBioagresseurs = OrganeDAO::getLesBioagresseursNOT($_SESSION['lOrgane']) ;
    
    $formBioagresseurOrgane = new Formulaire("post","index.php","formBioagresseurOrgane","formBioagresseurOrgane");
    $formBioagresseurOrgane->ajouterComposantLigne($formBioagresseurOrgane->creerTitreH3("Ajouter un bioagresseur : "));
    $formBioagresseurOrgane->ajouterComposantTab();
    $formBioagresseurOrgane->ajouterComposantLigne($formBioagresseurOrgane->creerLabel("<br/>"));
    $formBioagresseurOrgane->ajouterComposantTab();
    
    //         On vérifie que l'organe à bien des bioagresseurs disponibles
    if(!empty($lesBioagresseurs)){
        $formBioagresseurOrgane->ajouterComposantLigne($formBioagresseurOrgane->creerLabelFor("listeBioagresseur", "Ajouter un bioagresseur à l'organe : "));
        $formBioagresseurOrgane->ajouterComposantLigne($formBioagresseurOrgane->creerSelect("listeBioagresseur", "listeBioagresseur", "Les maladies : ", $lesBioagresseurs));
        $formBioagresseurOrgane->ajouterComposantLigne($formBioagresseurOrgane->creerInputSubmit("boutonAjouterAffecter", "boutonAjouterAffecter", "Ajouter"));
        $formBioagresseurOrgane->ajouterComposantTab();
    }
    else{
        $formBioagresseurOrgane->ajouterComposantLigne($formBioagresseurOrgane->creerLabel("Aucun bioagresseur trouvé."));
        $formBioagresseurOrgane->ajouterComposantTab();
    }
    
    $formBioagresseurOrgane->creerFormulaire();
    
    //         Supprimer un affecter - 1ere partie
    // On recupere les bioagresseurs de l'organe
    $lesBioagresseurs = OrganeDAO::getLesBioagresseurs($_SESSION['lOrgane']);
    if(!empty($lesBioagresseurs)){
        $tabBioagresseurOrgane = [];
        $i = 0;
        foreach($lesBioagresseurs as $bioagresseur){
            $tabBioagresseurOrgane[$i][0] = $bioagresseur['nomBioagresseur'];
            $tabBioagresseurOrgane[$i][1] = "<form method='post' action = 'index.php' name='formSupp'>".Fonctions::creerInputHidden("idBioagresseur", "idBioagresseur", $bioagresseur['idBioagresseur']).Fonctions::creerInputSubmit("boutonSupprAffecter", "boutonSupprAffecter", "Supprimer")."</form>";
            $i++;
        }
        $tabBioagresseurOrgane = new Tableau("tabBioagresseur", $tabBioagresseurOrgane);
        $tabBioagresseurOrgane->setTitreTab("Les bioagresseurs de ".$_SESSION['lOrgane']->getNomOrgane());
        $tabBioagresseurOrgane->setTitreCol(array("Bioagresseur", ""));
    }
    
}


// **********************************************
//      Fin -   Gérer les maladies / ravageurs
// **********************************************






require_once 'vue/vueSqueletteOrgane.php' ;
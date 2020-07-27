<?php
// On recupere les Maladies
    $listeMaladies = new Maladies(MaladieDAO::getMaladies());

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
                $repertoire_upload_absolu   = 'images/';
                $repertoireDestination = $repertoire_upload_absolu;
                $nomDestination = strtolower($_POST['nomMaladie'].".jpg");
               
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
   
   
    if(isset($_SESSION['laMaladie'])){
        //         Ajouter Maladie - 2eme partie
        if($_SESSION['maladie'] != 0 && isset($_POST['enregistrer'])){
            $maladieActive = new Maladie();
            $idMaladie = BioagresseurDAO::maxID()+1;
            $maladieActive->setIdBioagresseur($idMaladie);
            $nomMaladie = $_POST['nomMaladie'];
            $signe = array("'");
            $bon = array("&apos;");
            $nomMaladie = str_replace($signe, $bon, $nomMaladie);
            $maladieActive->setNomBioagresseur($nomMaladie);
            $maladieActive->setPeriodeRisqueBioagresseur($_POST['periodeRisque']);
            $maladieActive->setConditionsFavorables($_POST['conditionsFavorables']);
            $maladieActive->setStadeSensibleBioagresseur($_POST['stadeSensible']);
            $maladieActive->setSymptomeBioagresseur($_POST['symptome']);
            MaladieDAO::ajouterMaladie($maladieActive);
           
            $listeMaladies = new Maladies(MaladieDAO::getMaladies());
           
            // **********************************************
            //       Upload une photo
            // **********************************************
            upload();
           
           
           
            // **********************************************
            //       Fin - Upload une photo
            // **********************************************
           
           
           
            $_SESSION['maladie'] = $idMaladie;
        }
       
        //         Supprimer Maladie - 2eme partie
        if($_SESSION['maladie'] != 0 && isset($_POST['ouiSupprMaladie'])){
            $maladieActive = new Maladie();
            $maladieActive->setIdBioagresseur($_SESSION['laMaladie']->getIdBioagresseur());
            $maladieActive->setNomBioagresseur($_SESSION['laMaladie']->getNomBioagresseur());
            $maladieActive->setPeriodeRisqueBioagresseur($_SESSION['laMaladie']->getPeriodeRisqueBioagresseur());
            $maladieActive->setConditionsFavorables($_SESSION['laMaladie']->getConditionsFavorables());
            $maladieActive->setStadeSensibleBioagresseur($_SESSION['laMaladie']->getStadeSensibleBioagresseur());
            $maladieActive->setSymptomeBioagresseur($_SESSION['laMaladie']->getSymptomeBioagresseur());
            MaladieDAO::supprimerMaladie($maladieActive);
           
            $_SESSION['maladie']= MaladieDAO::maxID();
            $listeMaladies = new Maladies(MaladieDAO::getMaladies());
           
            //             Supprimer photo dans le dossier
            $filename = './images/'.strtolower($maladieActive->getNomBioagresseur()).'.jpg';
            if(file_exists($filename)){
                unlink ($filename );
            }
           
           
        }
       
        //         Modifier maladie - deuxieme partie
        if($_SESSION['maladie'] != 0 && isset($_POST['modifier'])){
            $maladieActive = new Maladie();
            $maladieActive->setIdBioagresseur($_SESSION['laMaladie']->getIdBioagresseur());
            $maladieActive->setNomBioagresseur($_POST['nomMaladie']);
            $maladieActive->setPeriodeRisqueBioagresseur($_POST['periodeRisque']);
            $maladieActive->setStadeSensibleBioagresseur($_POST['stadeSensible']);
            $maladieActive->setSymptomeBioagresseur($_POST['symptome']);
            $maladieActive->setConditionsFavorables($_POST['conditionsFavorables']);
           
           
            MaladieDAO::modifierMaladie($maladieActive);
           
            $listeMaladies = new Maladies(MaladieDAO::getMaladies());
           
           
//             Nouvelle photo
            upload();
 
        }
       
        //         Ajouter sensible - 2eme partie
        if($_SESSION['maladie'] != 0 && isset($_POST['boutonAjouterSensible'])){
            $nomPlante = $_POST['listePlanteMaladie'];
            $listePlante = PlanteDAO::getPlantes();
            foreach($listePlante as $plante){
                if($plante->getNomPlante() == $nomPlante){
                    MaladieDAO::ajouterSensible($_SESSION['laMaladie'], $plante->getIdPlante());
                    break;
                }
            }
        }
        //         Ajouter affecter - 2eme partie
        if($_SESSION['maladie'] != 0 && isset($_POST['boutonAjouterAffecter'])){
            $nomOrgane = $_POST['listeOrganeMaladie'];
            $listeOrgane = OrganeDAO::getOrganes();
            foreach($listeOrgane as $organe){
                if($organe->getNomOrgane() == $nomOrgane){
                    MaladieDAO::ajouterAffecter($_SESSION['laMaladie'], $organe->getIdOrgane());
                    break;
                }
            }
        }
        //         Ajouter traiter - 2eme partie
        if($_SESSION['maladie'] != 0 && isset($_POST['boutonAjouterTraiter'])){
            $nomTraitement = $_POST['listeTraitement'];
            $listeTraitement = TraitementDAO::getTraitements();
            foreach($listeTraitement as $traitement){
                if($traitement->getNomTraitement() == $nomTraitement){
                    MaladieDAO::ajouterTraiter($_SESSION['laMaladie'], $traitement->getIdTraitement());
                    break;
                }
            }
        }
       
        //         Supprimer sensible - 2eme partie
        if($_SESSION['maladie'] != 0 && isset($_POST['boutonSupprSensible'])){
            MaladieDAO::supprimerUNSensible($_SESSION['laMaladie'], $_POST['idPlante']);
        }
       
        //         Supprimer affecter - 2eme partie
        if($_SESSION['maladie'] != 0 && isset($_POST['boutonSupprAffecter'])){
            MaladieDAO::supprimerUNAffecter($_SESSION['laMaladie'], $_POST['idOrgane']);
        }
       
        //         Supprimer traiter - 2eme partie
        if($_SESSION['maladie'] != 0 && isset($_POST['boutonSupprTraiter'])){
            MaladieDAO::supprimerUNTraiter($_SESSION['laMaladie'], $_POST['idTraitement']);
        }
   
       
    }
   
   
    // **********************************************
    //          Choix d'une maladie
    // **********************************************
   
   
    // Si on a un Maladie choisi ou bien on prend le Maladie de base
    if(isset($_GET['maladie'])){
        $_SESSION['maladie']= $_GET['maladie'];
    }
    else
    {
        if(!isset($_SESSION['maladie'])){
            $_SESSION['maladie']=4;
        }
    }
    // **********************************************
    //          Fin - Choix d'une maladie
    // **********************************************
    // **********************************************
    //         Menu de toutes les maladie
    // **********************************************
   
    // On crée le menu à gauche pour toutes les Plantes
    $menuMaladie = new Menu("menuMaladie");
    // Pour chaque plante on recupère le nom et on crée un lien vers leur page
    foreach ($listeMaladies->getLesMaladies() as $unMaladie){
        $menuMaladie->ajouterComposant($menuMaladie->creerItemLien($unMaladie->getIdBioagresseur(),$unMaladie->getNomBioagresseur()));
    }
    //On crée le menu avec toutes les plantes + liens
    $leMenuMaladie = $menuMaladie->creerMenu($_SESSION['maladie'], "ifra=maladie&maladie");
   
    //     Bouton ajout si on a les droits
    if(isset($_SESSION['intervenant']) && $_SESSION['intervenant']->getCodeStatut() == "S01"){
        $formAjout = new Formulaire("post", "index.php", "formAjoutMaladie", "formAjout");
        $formAjout->ajouterComposantLigne($formAjout->creerInputSubmit("boutonAjouter", "ajouterMaladie", "Ajouter"));
        $formAjout->ajouterComposantTab();
        $formAjout->creerFormulaire();
    }
    // **********************************************
    //         Menu de tous les Maladies
    // **********************************************
   
    // **********************************************
    //        Affiche le Maladie
    // **********************************************
   
    foreach($listeMaladies->getLesMaladies() as $unMaladie){
       
        //         On recupere la plante choisie
        if($unMaladie->getIdBioagresseur() == $_SESSION['maladie']){
            $maladie = MaladieDAO::lire($_SESSION['maladie']);
            $laMaladie = new Maladie();
            $laMaladie->hydrate($maladie);
            //             On le passe en session
            $_SESSION['laMaladie']=$laMaladie;
           
            $formMaladie = new Formulaire("post", "index.php", "formMaladie", "formMaladie");
            $formMaladie->ajouterComposantLigne($formMaladie->creerTitreH3($laMaladie->getNomBioagresseur()));
            $formMaladie->ajouterComposantTab();
            $filename = './images/'.strtolower($laMaladie->getNomBioagresseur()).'.jpg';
            if(file_exists($filename)){
                $formMaladie->ajouterComposantLigne($formMaladie->creerImage(strtolower($laMaladie->getNomBioagresseur()).".jpg", "Photograhie de ".$laMaladie->getNomBioagresseur()));
                $formMaladie->ajouterComposantTab();
            }
            $formMaladie->ajouterComposantLigne($formMaladie->creerLabel("<br/>"));
            $formMaladie->ajouterComposantTab();
            $formMaladie->ajouterComposantLigne($formMaladie->creerLabelFor("periodeRisqueBioagresseur", "Période risque : "));
            $formMaladie->ajouterComposantLigne($formMaladie->creerLabelId($laMaladie->getPeriodeRisqueBioagresseur(),"periodeRisqueBioagresseur"));
            $formMaladie->ajouterComposantTab();
            $formMaladie->ajouterComposantLigne($formMaladie->creerLabelFor("symptomeBioagresseur", "Symptome : "));
            $formMaladie->ajouterComposantLigne($formMaladie->creerLabelId($laMaladie->getSymptomeBioagresseur(),"symptomeBioagresseur"));
            $formMaladie->ajouterComposantTab();
            $formMaladie->ajouterComposantLigne($formMaladie->creerLabelFor("stadeSensibleBioagresseur", "Stade sensible : "));
            $formMaladie->ajouterComposantLigne($formMaladie->creerLabelId($laMaladie->getStadeSensibleBioagresseur(),"stadeSensibleBioagresseur"));
            $formMaladie->ajouterComposantTab();
            $formMaladie->ajouterComposantLigne($formMaladie->creerLabelFor("conditionsFavorables", "Conditions Favorables : "));
            $formMaladie->ajouterComposantLigne($formMaladie->creerLabelId($laMaladie->getConditionsFavorables(),"conditionsFavorables"));
            $formMaladie->ajouterComposantTab();
            $formMaladie->ajouterComposantLigne($formMaladie->creerLabel("<br/>"));
            $formMaladie->ajouterComposantTab();
            //                 Bouton modifier et suppression si on a les droits
            if(isset($_SESSION['intervenant']) && $_SESSION['intervenant']->getCodeStatut() == "S01"){
                $unComposant = $formMaladie->creerInputSubmit("boutonModifier", "modifierPlante", "Modifier");
                $autreComposant = $formMaladie->creerInputSubmit("boutonSupprimer", "supprimerPlante", "Supprimer");
                $formMaladie->ajouterComposantLigne($formMaladie->concactComposants($unComposant, $autreComposant));
                $formMaladie->ajouterComposantTab();
            }
           
            $formMaladie->creerFormulaire();
        }
    }
   
   
    if(isset($_SESSION['laMaladie'])){
        //         On recupere les maladies et maladies de la plante
        $listePlantes = MaladieDAO::getLesPlantes($_SESSION['laMaladie']);
        $listeOrganes = MaladieDAO::getLesOrganes($_SESSION['laMaladie']);
        $listeTraitements = MaladieDAO::getLesTraitements($_SESSION['laMaladie']);
       
            $menuPlanteMaladie = new Menu("menuPlanteMaladie");
            foreach ($listePlantes as $unePlante){
                $menuPlanteMaladie->ajouterComposant($menuPlanteMaladie->creerItemLien($unePlante["idPlante"],$unePlante["nomPlante"]));
            }
            $leMenuPlanteMaladie = $menuPlanteMaladie->creerMenu("", "ifra=plante&plante");
       
       
       
            $menuOrganeMaladie = new Menu("menuOrganeMaladie");
            foreach ($listeOrganes as $unOrgane){
                $menuOrganeMaladie->ajouterComposant($menuOrganeMaladie->creerItemLien($unOrgane["idOrgane"],$unOrgane["nomOrgane"]));
            }
            $leMenuOrganeMaladie = $menuOrganeMaladie->creerMenu("", "ifra=organe&organe");
       
       
            $menuTraitementMaladie = new Menu("menuTraitementMaladie");
            foreach ($listeTraitements as $unTraitement){
                $menuTraitementMaladie->ajouterComposant($menuTraitementMaladie->creerItemLien($unTraitement["idTraitement"],$unTraitement["nomTraitement"]));
            }
            $leMenuTraitementMaladie = $menuTraitementMaladie->creerMenu("", "ifra=traitement&traitement");
       
       
    }
   

   
    //     Bouton gérer si on a les droits
    if(isset($_SESSION['intervenant']) && $_SESSION['intervenant']->getCodeStatut() == "S01"){
        $formGererMaladie = new Formulaire("post", "index.php", "formGererPlante", "formGerer");
        $formGererMaladie->ajouterComposantLigne($formGererMaladie->creerInputSubmit("boutonGerer", "gererMaladie", "Gérer"));
        $formGererMaladie->ajouterComposantTab();
        $formGererMaladie->creerFormulaire();
    }
   
    // **********************************************
    //        Fin - Affiche la maladie
    // **********************************************
    // **********************************************
    //         Ajout / Modif / Suppr la maladie
    // **********************************************
   
    //             Ajouter une maladie #1 - Premiere partie
    if($_SESSION['maladie'] != "0" && isset($_POST['boutonAjouter'])){
        $formModifMaladie = new Formulaire("post","index.php","formAjoutMaladie","formAjoutMaladie");
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerTitreH3("Ajouter une maladie"));
        $formModifMaladie->ajouterComposantTab();
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerLabelFor("nomMaladie", "Nom d'une maladie : "));
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerInputTexte("nomMaladie", "nomMaladie", "", "" ,""  , "" , ""));
        $formModifMaladie->ajouterComposantTab();
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerLabelFor("periodeRisque", "Période risque : "));
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerInputTexte("periodeRisque", "periodeRisque", "", "" ,""  , "" , ""));
        $formModifMaladie->ajouterComposantTab();
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerLabelFor("symptome", "Symptome : "));
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerInputTexte("symptome", "symptome", "", "" ,""  , "" , ""));
        $formModifMaladie->ajouterComposantTab();
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerLabelFor("stadeSensible", "Stade sensible : "));
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerInputTexte("stadeSensible", "stadeSensible", "", "" ,""  , "" , ""));
        $formModifMaladie->ajouterComposantTab();
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerLabelFor("conditionsFavorables", "Conditions Favorables : "));
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerInputTexte("conditionsFavorables", "conditionsFavorables", "", "" ,""  , "" , ""));
        $formModifMaladie->ajouterComposantTab();
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerLabelFor("image", "Choisir une image : "));
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerInputFile("image", "image"));
        $formModifMaladie->ajouterComposantTab();
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerInputSubmit("enregistrer", "enregistrer", "Enregistrer"));
        $formModifMaladie->ajouterComposantTab();
       
        $formModifMaladie->creerFormulaire();
    }
   
    //              Modifier un Maladie #1 - Premiere partie
    if($_SESSION['maladie'] != "0" && isset($_POST['boutonModifier'])){
        $formModifMaladie = new Formulaire("post","index.php","formModifMaladie","formModifMaladie");
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerTitreH3("Modifier une maladie : ".$_SESSION['laMaladie']->getNomBioagresseur()));
        $formModifMaladie->ajouterComposantTab();
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerLabelFor("nomMaladie", "Nom de la maladie : "));
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerInputTexte("nomMaladie", "nomMaladie",$_SESSION['laMaladie']->getNomBioagresseur(), "" ,""  , "" , ""));
        $formModifMaladie->ajouterComposantTab();
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerLabelFor("periodeRisque", "Période risque : "));
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerInputTexte("periodeRisque", "periodeRisque", $_SESSION['laMaladie']->getPeriodeRisqueBioagresseur(), "" ,""  , "" , ""));
        $formModifMaladie->ajouterComposantTab();
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerLabelFor("symptome", "Symptome : "));
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerInputTexte("symptome", "symptome", $_SESSION['laMaladie']->getSymptomeBioagresseur(), "" ,""  , "" , ""));
        $formModifMaladie->ajouterComposantTab();
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerLabelFor("stadeSensible", "Stade sensible : "));
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerInputTexte("stadeSensible", "stadeSensible", $_SESSION['laMaladie']->getStadeSensibleBioagresseur(), "" ,""  , "" , ""));
        $formModifMaladie->ajouterComposantTab();
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerLabelFor("conditionsFavorables", "Conditions Favorables : "));
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerInputTexte("conditionsFavorables", "conditionsFavorables", $_SESSION['laMaladie']->getConditionsFavorables(), "" ,""  , "" , ""));
        $formModifMaladie->ajouterComposantTab();
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerLabelFor("image", "Choisir une image : "));
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerInputFile("image", "image"));
        $formModifMaladie->ajouterComposantTab();
        $formModifMaladie->ajouterComposantLigne($formModifMaladie->creerInputSubmit("modifier", "modifier", "Modifier"));
        $formModifMaladie->ajouterComposantTab();
       
        $formModifMaladie->creerFormulaire();
    }
   
    //              Supprimer un Maladie #1 - Premiere partie
    if($_SESSION['maladie'] != "0" && isset($_POST['boutonSupprimer'])){
        $formSupprMaladie = new Formulaire("post","index.php","formSupprMaladie","formSupprMaladie");
        $formSupprMaladie->ajouterComposantLigne($formSupprMaladie->creerTitreH3("Supprimer une maladie : " . $_SESSION['laMaladie']->getNomBioagresseur()));
        $formSupprMaladie->ajouterComposantTab();
        $formSupprMaladie->ajouterComposantLigne($formSupprMaladie->creerLabelFor("nomMaladie", "Voulez vous vraiment supprimer cette Maladie ? "));
        $formSupprMaladie->ajouterComposantLigne($formSupprMaladie->creerLabelId($_SESSION['laMaladie']->getNomBioagresseur(), "nomMaladie"));
        $formSupprMaladie->ajouterComposantTab();
        $unComposant = $formSupprMaladie->creerInputSubmit("ouiSupprMaladie", "ouiMaladie", "Supprimer");
        $autreComposant = $formSupprMaladie->creerInputSubmit("nomSupprMaladie", "nomMaladie", "Annuler");
        $formSupprMaladie->ajouterComposantLigne($formSupprMaladie->concactComposants($unComposant, $autreComposant));
        $formSupprMaladie->ajouterComposantTab();
       
       
        $formSupprMaladie->creerFormulaire();
    }
   
    // **********************************************
    //        Fin - Ajout / Modif / Suppr la maladie
    // **********************************************
    // **********************************************
    //     Gérer les organes / plantes / traitements
    // **********************************************
   
   
    if($_SESSION['maladie'] != "0" && isset($_POST['boutonGerer'])){
       
        //     ------------                Les plantes                ------------
        //     Ajouter un sensible plante - 1ere partie
        $lesPlantes = MaladieDAO::getLesPlantesNOT($_SESSION['laMaladie']) ;
       
        $formPlanteMaladie = new Formulaire("post","index.php","formPlanteMaladie","formPlanteMaladie");
        $formPlanteMaladie->ajouterComposantLigne($formPlanteMaladie->creerTitreH3("Ajouter une plante : "));
        $formPlanteMaladie->ajouterComposantTab();
        $formPlanteMaladie->ajouterComposantLigne($formPlanteMaladie->creerLabel("<br/>"));
        $formPlanteMaladie->ajouterComposantTab();
       
        //         On vérifie que la plante à bien des bioagresseurs disponibles
        if(!empty($lesPlantes)){
            $formPlanteMaladie->ajouterComposantLigne($formPlanteMaladie->creerLabelFor("listePlanteMaladie", "Ajouter une plante à la Maladie : "));
            $formPlanteMaladie->ajouterComposantLigne($formPlanteMaladie->creerSelect("listePlanteMaladie", "listePlanteMaladie", "Les plantes : ", $lesPlantes));
            $formPlanteMaladie->ajouterComposantLigne($formPlanteMaladie->creerInputSubmit("boutonAjouterSensible", "boutonAjouterSensible", "Ajouter"));
            $formPlanteMaladie->ajouterComposantTab();
        }
        else{
            $formPlanteMaladie->ajouterComposantLigne($formPlanteMaladie->creerLabel("Aucune plante trouvée."));
            $formPlanteMaladie->ajouterComposantTab();
        }
        $formPlanteMaladie->ajouterComposantLigne($formPlanteMaladie->creerLabel("<br/>"));
        $formPlanteMaladie->ajouterComposantTab();
       
        $formPlanteMaladie->creerFormulaire();

//     ------------              Fin -  Les plantes                ------------
//     ------------                Les organes                ------------
        //     Ajouter un sensible organe - 1ere partie
        $lesOrganes = MaladieDAO::getLesOrganesNOT($_SESSION['laMaladie']) ;
       
        $formOrganeMaladie = new Formulaire("post","index.php","formPlanteMaladie","formPlanteMaladie");
        $formOrganeMaladie->ajouterComposantLigne($formOrganeMaladie->creerTitreH3("Ajouter un organe : "));
        $formOrganeMaladie->ajouterComposantTab();
        $formOrganeMaladie->ajouterComposantLigne($formOrganeMaladie->creerLabel("<br/>"));
        $formOrganeMaladie->ajouterComposantTab();
       
        //         On vérifie que la plante à bien des bioagresseurs disponibles
        if(!empty($lesOrganes)){
            $formOrganeMaladie->ajouterComposantLigne($formOrganeMaladie->creerLabelFor("listeOrganeMaladie", "Ajouter un organe à la Maladie : "));
            $formOrganeMaladie->ajouterComposantLigne($formOrganeMaladie->creerSelect("listeOrganeMaladie", "listeOrganeMaladie", "Les organes : ", $lesOrganes));
            $formOrganeMaladie->ajouterComposantLigne($formOrganeMaladie->creerInputSubmit("boutonAjouterAffecter", "boutonAjouterAffecter", "Ajouter"));
            $formOrganeMaladie->ajouterComposantTab();
        }
        else{
            $formOrganeMaladie->ajouterComposantLigne($formOrganeMaladie->creerLabel("Aucun organe trouvé."));
            $formOrganeMaladie->ajouterComposantTab();
        }
        $formOrganeMaladie->ajouterComposantLigne($formOrganeMaladie->creerLabel("<br/>"));
        $formOrganeMaladie->ajouterComposantTab();
       
        $formOrganeMaladie->creerFormulaire();
       
//     ------------               Fin -  Les organes                ------------
//     ------------                Les traitements                ------------
//     Ajouter un sensible organe - 1ere partie
        $lesTraitements = MaladieDAO::getLesTraitementsNOT($_SESSION['laMaladie']) ;
       
        $formTraitementMaladie = new Formulaire("post","index.php","formPlanteMaladie","formPlanteMaladie");
        $formTraitementMaladie->ajouterComposantLigne($formTraitementMaladie->creerTitreH3("Ajouter un traitement : "));
        $formTraitementMaladie->ajouterComposantTab();
        $formTraitementMaladie->ajouterComposantLigne($formTraitementMaladie->creerLabel("<br/>"));
        $formTraitementMaladie->ajouterComposantTab();
       
        //         On vérifie que la plante à bien des bioagresseurs disponibles
        if(!empty($lesTraitements)){
            $formTraitementMaladie->ajouterComposantLigne($formTraitementMaladie->creerLabelFor("listeTraitement", "Ajouter un traitement à la maladie : "));
            $formTraitementMaladie->ajouterComposantLigne($formTraitementMaladie->creerSelect("listeTraitement", "listeTraitement", "Les traitements : ", $lesTraitements));
            $formTraitementMaladie->ajouterComposantLigne($formTraitementMaladie->creerInputSubmit("boutonAjouterTraiter", "boutonAjouterTraiter", "Ajouter"));
            $formTraitementMaladie->ajouterComposantTab();
        }
        else{
            $formTraitementMaladie->ajouterComposantLigne($formTraitementMaladie->creerLabel("Aucun traitement trouvé."));
            $formTraitementMaladie->ajouterComposantTab();
        }
        $formTraitementMaladie->ajouterComposantLigne($formTraitementMaladie->creerLabel("<br/>"));
        $formTraitementMaladie->ajouterComposantTab();
       
        $formTraitementMaladie->creerFormulaire();
        //     ------------               Fin -  Les traitements                ------------
       
       
       
       
//                 Supprimer un sensible - 1ere partie
//         On recupere les plantes du Maladie
                $lesPlantes = MaladieDAO::getLesPlantes($_SESSION['laMaladie']);
//          On recupere les organes
                $lesOrganes = MaladieDAO::getLesOrganes($_SESSION['laMaladie']);
//          On recupere les traitements
                $lesTraitements = MaladieDAO::getLesTraitements($_SESSION['laMaladie']);
                if(!empty($lesPlantes) || !empty($lesOrganes) || !empty($lesTraitements)){
                    $tabGererMaladie = [];
                   
                    if(!empty($lesPlantes)){
                        $i = 0;
                        foreach($lesPlantes as $plante){
                            $tabGererMaladie[$i][0] = $plante['nomPlante'];
                            $tabGererMaladie[$i][1] = "<form method='post' action = 'index.php' name='formSupp'>".Fonctions::creerInputHidden("idPlante", "idPlante", $plante['idPlante']).Fonctions::creerInputSubmit("boutonSupprSensible", "boutonSupprSensible", "Supprimer")."</form>";
                            $i++;
                        }
                    }
                    else{
                        $i = 0;
                        $tabGererMaladie[$i][0] = "";
                        $tabGererMaladie[$i][1] = "";
                    }
                    if(!empty($lesOrganes)){
                        $i = 0;
                        foreach($lesOrganes as $organe){
                            $tabGererMaladie[$i][2] = $organe['nomOrgane'];
                            $tabGererMaladie[$i][3] = "<form method='post' action = 'index.php' name='formSupp'>".Fonctions::creerInputHidden("idOrgane", "idOrgane", $organe['idOrgane']).Fonctions::creerInputSubmit("boutonSupprAffecter", "boutonSupprAffecter", "Supprimer")."</form>";
                            $i++;
                        }
                    }
                    else{
                        $i = 0;
                        $tabGererMaladie[$i][2] = "";
                        $tabGererMaladie[$i][3] = "";
                    }
                    if(!empty($lesTraitements)){
                        $i = 0;
                        foreach($lesTraitements as $traitement){
                            $tabGererMaladie[$i][4] = $traitement['nomTraitement'];
                            $tabGererMaladie[$i][5] = "<form method='post' action = 'index.php' name='formSupp'>".Fonctions::creerInputHidden("idTraitement", "idTraitement", $traitement['idTraitement']).Fonctions::creerInputSubmit("boutonSupprTraiter", "boutonSupprTraiter", "Supprimer")."</form>";
                            $i++;
                        }
                    }
                    else{
                        $i = 0;
                        $tabGererMaladie[$i][4] = "";
                        $tabGererMaladie[$i][5] = "";
                    }
                   

                    $tabGererMaladie = new Tableau("tabBioagresseur", $tabGererMaladie);
                    $tabGererMaladie->setTitreTab("Les plantes / organes / traitements de ".$_SESSION['laMaladie']->getNomBioagresseur());
                    $tabGererMaladie->setTitreCol(array("Plante :", "","Organe :", "","Traitement :", ""));
                }
       
    }
   
   
    // **********************************************
    // Fin - Gérer les organes / plantes / traitements
    // **********************************************
   

require_once 'vue/vueSqueletteMaladie.php' ;  
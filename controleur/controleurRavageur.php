<?php
// On recupere les ravageurs
    $listeRavageurs = new Ravageurs(RavageurDAO::getRavageurs());
    
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
                $nomDestination = strtolower($_POST['nomRavageur'].".jpg");
                
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
    
    
    if(isset($_SESSION['leRavageur'])){
        //         Ajouter ravageur - 2eme partie
        if($_SESSION['ravageur'] != 0 && isset($_POST['enregistrer'])){
            $ravageurActif = new Ravageur();
            $idRavageur = BioagresseurDAO::maxID()+1;
            $ravageurActif->setIdBioagresseur($idRavageur);
            $nomRavageur = $_POST['nomRavageur'];
            $signe = array("'");
            $bon = array("&apos;");
            $nomRavageur = str_replace($signe, $bon, $nomRavageur);
            $ravageurActif->setNomBioagresseur($nomRavageur);
            $ravageurActif->setPeriodeRisqueBioagresseur($_POST['periodeRisque']);
            $ravageurActif->setNbGeneration($_POST['nbGeneration']);
            $ravageurActif->setStadeActif($_POST['stadeActif']);
            $ravageurActif->setStadeSensibleBioagresseur($_POST['stadeSensible']);
            $ravageurActif->setSymptomeBioagresseur($_POST['symptome']);
            RavageurDAO::ajouterRavageur($ravageurActif);
            
            $listeRavageurs = new Ravageurs(RavageurDAO::getRavageurs());
            
            // **********************************************
            //       Upload une photo
            // **********************************************
            upload();
            
            
            
            // **********************************************
            //       Fin - Upload une photo
            // **********************************************
            
            
            
            $_SESSION['ravageur'] = $idRavageur;
        }
        
        //         Supprimer ravageur - 2eme partie
        if($_SESSION['ravageur'] != 0 && isset($_POST['ouiSupprRavageur'])){
            $ravageurActif = new Ravageur();
            $ravageurActif->setIdBioagresseur($_SESSION['leRavageur']->getIdBioagresseur());
            $ravageurActif->setNomBioagresseur($_SESSION['leRavageur']->getNomBioagresseur());
            $ravageurActif->setPeriodeRisqueBioagresseur($_SESSION['leRavageur']->getPeriodeRisqueBioagresseur());
            $ravageurActif->setNbGeneration($_SESSION['leRavageur']->getNbGeneration());
            $ravageurActif->setStadeActif($_SESSION['leRavageur']->getStadeActif());
            $ravageurActif->setStadeSensibleBioagresseur($_SESSION['leRavageur']->getStadeSensibleBioagresseur());
            $ravageurActif->setSymptomeBioagresseur($_SESSION['leRavageur']->getSymptomeBioagresseur());
            RavageurDAO::supprimerRavageur($ravageurActif);
            
            $_SESSION['ravageur']= RavageurDAO::maxID();
            $listeRavageurs = new Ravageurs(RavageurDAO::getRavageurs());
            
            //             Supprimer photo dans le dossier
            $filename = './images/'.strtolower($ravageurActif->getNomBioagresseur()).'.jpg';
            if(file_exists($filename)){
                unlink ($filename );
            }
            
            
        }
        
        //         Modifier ravageur - deuxieme partie
        if($_SESSION['ravageur'] != 0 && isset($_POST['modifier'])){
            $ravageurActif = new Ravageur();
            $ravageurActif->setIdBioagresseur($_SESSION['leRavageur']->getIdBioagresseur());
            $ravageurActif->setNomBioagresseur($_POST['nomRavageur']);
            $ravageurActif->setPeriodeRisqueBioagresseur($_POST['periodeRisque']);
            $ravageurActif->setNbGeneration($_POST['nbGeneration']);
            $ravageurActif->setStadeActif($_POST['stadeActif']);
            $ravageurActif->setStadeSensibleBioagresseur($_POST['stadeSensible']);
            $ravageurActif->setSymptomeBioagresseur($_POST['symptome']);
            
            
            RavageurDAO::modifierRavageur($ravageurActif);
            
            $listeRavageurs = new Ravageurs(RavageurDAO::getRavageurs());

//             Nouvelle photo
            upload();
 
        }
        
        //         Ajouter sensible - 2eme partie
        if($_SESSION['ravageur'] != 0 && isset($_POST['boutonAjouterSensible'])){
            $nomPlante = $_POST['listePlanteRavageur'];
            $listePlante = PlanteDAO::getPlantes();
            foreach($listePlante as $plante){
                if($plante->getNomPlante() == $nomPlante){
                    RavageurDAO::ajouterSensible($_SESSION['leRavageur'], $plante->getIdPlante());
                    break;
                }
            }
        }
        //         Ajouter affecter - 2eme partie
        if($_SESSION['ravageur'] != 0 && isset($_POST['boutonAjouterAffecter'])){
            $nomOrgane = $_POST['listeOrganeRavageur'];
            $listeOrgane = OrganeDAO::getOrganes();
            foreach($listeOrgane as $organe){
                if($organe->getNomOrgane() == $nomOrgane){
                    RavageurDAO::ajouterAffecter($_SESSION['leRavageur'], $organe->getIdOrgane());
                    break;
                }
            }
        }
        //         Ajouter traiter - 2eme partie
        if($_SESSION['ravageur'] != 0 && isset($_POST['boutonAjouterTraiter'])){
            $nomTraitement = $_POST['listeTraitement'];
            $listeTraitement = TraitementDAO::getTraitements();
            foreach($listeTraitement as $traitement){
                if($traitement->getNomTraitement() == $nomTraitement){
                    RavageurDAO::ajouterTraiter($_SESSION['leRavageur'], $traitement->getIdTraitement());
                    break;
                }
            }
        }
        
        //         Supprimer sensible - 2eme partie
        if($_SESSION['ravageur'] != 0 && isset($_POST['boutonSupprSensible'])){
            RavageurDAO::supprimerUNSensible($_SESSION['leRavageur'], $_POST['idPlante']);
        }
        
        //         Supprimer affecter - 2eme partie
        if($_SESSION['ravageur'] != 0 && isset($_POST['boutonSupprAffecter'])){
            RavageurDAO::supprimerUNAffecter($_SESSION['leRavageur'], $_POST['idOrgane']);
        }
        
        //         Supprimer traiter - 2eme partie
        if($_SESSION['ravageur'] != 0 && isset($_POST['boutonSupprTraiter'])){
            RavageurDAO::supprimerUNTraiter($_SESSION['leRavageur'], $_POST['idTraitement']);
        }
    
        
    }
    
    
    // **********************************************
    //          Choix d'un ravageur
    // **********************************************
    
    
    // Si on a un ravageur choisi ou bien on prend le ravageur de base
    if(isset($_GET['ravageur'])){
        $_SESSION['ravageur']= $_GET['ravageur'];
    }
    else
    {
        if(!isset($_SESSION['ravageur'])){
            $_SESSION['ravageur']=4;
        }
    }
    // **********************************************
    //          Fin - Choix d'un ravageur
    // **********************************************
    // **********************************************
    //         Menu de tous les Ravageurs
    // **********************************************
    
    // On crée le menu à gauche pour toutes les Plantes
    $menuRavageur = new Menu("menuRavageur");
    // Pour chaque plante on recupère le nom et on crée un lien vers leur page
    foreach ($listeRavageurs->getLesRavageurs() as $unRavageur){
        $menuRavageur->ajouterComposant($menuRavageur->creerItemLien($unRavageur->getIdBioagresseur(),$unRavageur->getNomBioagresseur()));
    }
    //On crée le menu avec toutes les plantes + liens
    $leMenuRavageur = $menuRavageur->creerMenu($_SESSION['ravageur'], "ifra=ravageur&ravageur");
    
    //     Bouton ajout si on a les droits
    if(isset($_SESSION['intervenant']) && $_SESSION['intervenant']->getCodeStatut() == "S01"){
        $formAjout = new Formulaire("post", "index.php", "formAjoutRavageur", "formAjout");
        $formAjout->ajouterComposantLigne($formAjout->creerInputSubmit("boutonAjouter", "ajouterRavageur", "Ajouter"));
        $formAjout->ajouterComposantTab();
        $formAjout->creerFormulaire();
    }
    // **********************************************
    //         Menu de tous les Ravageurs
    // **********************************************
    
    // **********************************************
    //        Affiche le ravageur
    // **********************************************
    
    foreach($listeRavageurs->getLesRavageurs() as $unRavageur){
        
        //         On recupere la plante choisie
        if($unRavageur->getIdBioagresseur() == $_SESSION['ravageur']){
            $ravageur = RavageurDAO::lire($_SESSION['ravageur']);
            $leRavageur = new Ravageur();
            $leRavageur->hydrate($ravageur);
            //             On le passe en session
            $_SESSION['leRavageur']=$leRavageur;
            
            $formRavageur = new Formulaire("post", "index.php", "formRavageur", "formRavageur");
            $formRavageur->ajouterComposantLigne($formRavageur->creerTitreH3($leRavageur->getNomBioagresseur()));
            $formRavageur->ajouterComposantTab();
            $filename = './images/'.strtolower($leRavageur->getNomBioagresseur()).'.jpg';
            if(file_exists($filename)){
                $formRavageur->ajouterComposantLigne($formRavageur->creerImage(strtolower($leRavageur->getNomBioagresseur()).".jpg", "Photograhie de ".$leRavageur->getNomBioagresseur()));
                $formRavageur->ajouterComposantTab();
            }
            $formRavageur->ajouterComposantLigne($formRavageur->creerLabel("<br/>"));
            $formRavageur->ajouterComposantTab();
            $formRavageur->ajouterComposantLigne($formRavageur->creerLabel("Période risque : "));
            $formRavageur->ajouterComposantLigne($formRavageur->creerLabelId($leRavageur->getPeriodeRisqueBioagresseur(),"periodeRisqueBioagresseur"));
            $formRavageur->ajouterComposantTab();
            $formRavageur->ajouterComposantLigne($formRavageur->creerLabel("Symptome : "));
            $formRavageur->ajouterComposantLigne($formRavageur->creerLabelId($leRavageur->getSymptomeBioagresseur(),"symptomeBioagresseur"));
            $formRavageur->ajouterComposantTab();
            $formRavageur->ajouterComposantLigne($formRavageur->creerLabel("Stade sensible : "));
            $formRavageur->ajouterComposantLigne($formRavageur->creerLabelId($leRavageur->getStadeSensibleBioagresseur(),"stadeSensibleBioagresseur"));
            $formRavageur->ajouterComposantTab();
            $formRavageur->ajouterComposantLigne($formRavageur->creerLabel("Stade actif : "));
            $formRavageur->ajouterComposantLigne($formRavageur->creerLabelId($leRavageur->getStadeActif(),"stadeActif"));
            $formRavageur->ajouterComposantTab();
            $formRavageur->ajouterComposantLigne($formRavageur->creerLabel( "Nombre de génération : "));
            $formRavageur->ajouterComposantLigne($formRavageur->creerLabelId($leRavageur->getNbGeneration(),"nbGeneration"));
            $formRavageur->ajouterComposantTab();
            $formRavageur->ajouterComposantLigne($formRavageur->creerLabel("<br/>"));
            $formRavageur->ajouterComposantTab();
            //                 Bouton modifier et suppression si on a les droits
            if(isset($_SESSION['intervenant']) && $_SESSION['intervenant']->getCodeStatut() == "S01"){
                $unComposant = $formRavageur->creerInputSubmit("boutonModifier", "modifierRavageur", "Modifier");
                $autreComposant = $formRavageur->creerInputSubmit("boutonSupprimer", "supprimerRavageur", "Supprimer");
                $formRavageur->ajouterComposantLigne($formRavageur->concactComposants($unComposant, $autreComposant));
                $formRavageur->ajouterComposantTab();
            }
            
            $formRavageur->creerFormulaire();
        }
    }
    
    
    if(isset($_SESSION['leRavageur'])){
        //         On recupere les maladies et ravageurs de la plante
        $listePlantes = RavageurDAO::getLesPlantes($_SESSION['leRavageur']);
        $listeOrganes = RavageurDAO::getLesOrganes($_SESSION['leRavageur']);
        $listeTraitements = RavageurDAO::getLesTraitements($_SESSION['leRavageur']);
        
            $menuPlanteRavageur = new Menu("menuPlanteRavageur");
            foreach ($listePlantes as $unePlante){
                $menuPlanteRavageur->ajouterComposant($menuPlanteRavageur->creerItemLien($unePlante["idPlante"],$unePlante["nomPlante"]));
            }
            $leMenuPlanteRavageur = $menuPlanteRavageur->creerMenu("", "ifra=plante&plante");
        
        
        
            $menuOrganeRavageur = new Menu("menuOrganeRavageur");
            foreach ($listeOrganes as $unOrgane){
                $menuOrganeRavageur->ajouterComposant($menuOrganeRavageur->creerItemLien($unOrgane["idOrgane"],$unOrgane["nomOrgane"]));
            }
            $leMenuOrganeRavageur = $menuOrganeRavageur->creerMenu("", "ifra=organe&organe");
        
        
            $menuTraitementRavageur = new Menu("menuTraitementRavageur");
            foreach ($listeTraitements as $unTraitement){
                $menuTraitementRavageur->ajouterComposant($menuTraitementRavageur->creerItemLien($unTraitement["idTraitement"],$unTraitement["nomTraitement"]));
            }
            $leMenuTraitementRavageur = $menuTraitementRavageur->creerMenu("", "ifra=traitement&traitement");
        
        
    }
    

    
    //     Bouton gérer si on a les droits
    if(isset($_SESSION['intervenant']) && $_SESSION['intervenant']->getCodeStatut() == "S01"){
        $formGererRavageur = new Formulaire("post", "index.php", "formGererPlante", "formGerer");
        $formGererRavageur->ajouterComposantLigne($formGererRavageur->creerInputSubmit("boutonGerer", "gererRavageur", "Gérer"));
        $formGererRavageur->ajouterComposantTab();
        $formGererRavageur->creerFormulaire();
    }
    
    // **********************************************
    //        Fin - Affiche le ravageur
    // **********************************************
    // **********************************************
    //         Ajout / Modif / Suppr le ravageur
    // **********************************************
    
    //             Ajouter un ravageur #1 - Premiere partie
    if($_SESSION['ravageur'] != "0" && isset($_POST['boutonAjouter'])){
        $formModifRavageur = new Formulaire("post","index.php","formAjoutRavageur","formAjoutRavageur");
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerTitreH3("Ajouter un ravageur"));
        $formModifRavageur->ajouterComposantTab();
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerLabelFor("nomRavageur", "Nom du ravageur : "));
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerInputTexte("nomRavageur", "nomRavageur", "", 1 ,""  , "" ));
        $formModifRavageur->ajouterComposantTab();
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerLabelFor("periodeRisque", "Période risque : "));
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerInputTexte("periodeRisque", "periodeRisque", "",1 ,""  , "" ));
        $formModifRavageur->ajouterComposantTab();
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerLabelFor("symptome", "Symptome : "));
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerInputTexte("symptome", "symptome", "", 1,""  , ""));
        $formModifRavageur->ajouterComposantTab();
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerLabelFor("stadeSensible", "Stade sensible : "));
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerInputTexte("stadeSensible", "stadeSensible", "", 1 ,""  , "" ));
        $formModifRavageur->ajouterComposantTab();
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerLabelFor("stadeActif", "Stade actif : "));
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerInputTexte("stadeActif", "stadeActif", "", 1 ,""  , ""));
        $formModifRavageur->ajouterComposantTab();
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerLabelFor("nbGeneration", "Nombre génération : "));
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerInputNumber("nbGeneration", "nbGeneration", "0", 1 ,"0"  ,"1"));
        $formModifRavageur->ajouterComposantTab();
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerLabelFor("image", "Choisir une image : "));
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerInputFile("image", "image"));
        $formModifRavageur->ajouterComposantTab();
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerInputSubmit("enregistrer", "enregistrer", "Enregistrer"));
        $formModifRavageur->ajouterComposantTab();
        
        $formModifRavageur->creerFormulaire();
    }
    
    //              Modifier un ravageur #1 - Premiere partie
    if($_SESSION['ravageur'] != "0" && isset($_POST['boutonModifier'])){
        $formModifRavageur = new Formulaire("post","index.php","formModifRavageur","formModifRavageur");
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerTitreH3("Modifier un ravageur : ".$_SESSION['leRavageur']->getNomBioagresseur()));
        $formModifRavageur->ajouterComposantTab();
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerLabelFor("nomRavageur", "Nom du ravageur : "));
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerInputTexte("nomRavageur", "nomRavageur",$_SESSION['leRavageur']->getNomBioagresseur(), 1 ,"" ,""));
        $formModifRavageur->ajouterComposantTab();
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerLabelFor("periodeRisque", "Nom du ravageur : "));
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerInputTexte("periodeRisque", "periodeRisque", $_SESSION['leRavageur']->getPeriodeRisqueBioagresseur(), "" ,""  , "" ));
        $formModifRavageur->ajouterComposantTab();
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerLabelFor("symptome", "Symptome : "));
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerInputTexte("symptome", "symptome", $_SESSION['leRavageur']->getSymptomeBioagresseur(), "" ,""  , "" , ""));
        $formModifRavageur->ajouterComposantTab();
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerLabelFor("stadeSensible", "Stade sensible : "));
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerInputTexte("stadeSensible", "stadeSensible", $_SESSION['leRavageur']->getStadeSensibleBioagresseur(), "" ,""  , "" ));
        $formModifRavageur->ajouterComposantTab();
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerLabelFor("stadeActif", "Stade actif : "));
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerInputTexte("stadeActif", "stadeActif", $_SESSION['leRavageur']->getStadeActif(), "" ,""  , "" ));
        $formModifRavageur->ajouterComposantTab();
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerLabelFor("nbGeneration", "Nombre génération : "));
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerInputNumber("nbGeneration", "nbGeneration", $_SESSION['leRavageur']->getNbGeneration(), "" ,""  , "1"));
        $formModifRavageur->ajouterComposantTab();
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerLabelFor("image", "Choisir une image : "));
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerInputFile("image", "image"));
        $formModifRavageur->ajouterComposantTab();
        $formModifRavageur->ajouterComposantLigne($formModifRavageur->creerInputSubmit("modifier", "modifier", "Modifier"));
        $formModifRavageur->ajouterComposantTab();
        
        $formModifRavageur->creerFormulaire();
    }
    
    //              Supprimer un ravageur #1 - Premiere partie
    if($_SESSION['ravageur'] != "0" && isset($_POST['boutonSupprimer'])){
        $formSupprRavageur = new Formulaire("post","index.php","formSupprRavageur","formSupprRavageur");
        $formSupprRavageur->ajouterComposantLigne($formSupprRavageur->creerTitreH3("Supprimer un ravageur : " . $_SESSION['leRavageur']->getNomBioagresseur()));
        $formSupprRavageur->ajouterComposantTab();
        $formSupprRavageur->ajouterComposantLigne($formSupprRavageur->creerLabel("Voulez vous vraiment supprimer ce ravageur ? "));
        $formSupprRavageur->ajouterComposantLigne($formSupprRavageur->creerLabelId($_SESSION['leRavageur']->getNomBioagresseur(), "nomRavageur"));
        $formSupprRavageur->ajouterComposantTab();
        $unComposant = $formSupprRavageur->creerInputSubmit("ouiSupprRavageur", "ouiRavageur", "Supprimer");
        $autreComposant = $formSupprRavageur->creerInputSubmit("nomSupprRavageur", "nonRavageur", "Annuler");
        $formSupprRavageur->ajouterComposantLigne($formSupprRavageur->concactComposants($unComposant, $autreComposant));
        $formSupprRavageur->ajouterComposantTab();
        
        
        $formSupprRavageur->creerFormulaire();
    }
    
    // **********************************************
    //        Fin - Ajout / Modif / Suppr le ravageur
    // **********************************************
    // **********************************************
    //     Gérer les organes / plantes / traitements
    // **********************************************
    
    
    if($_SESSION['ravageur'] != "0" && isset($_POST['boutonGerer'])){
        
        //     ------------                Les plantes                ------------
        //     Ajouter un sensible plante - 1ere partie
        $lesPlantes = RavageurDAO::getLesPlantesNOT($_SESSION['leRavageur']) ;
        
        $formPlanteRavageur = new Formulaire("post","index.php","formPlanteRavageur","formPlanteRavageur");
        $formPlanteRavageur->ajouterComposantLigne($formPlanteRavageur->creerTitreH3("Ajouter une plante : "));
        $formPlanteRavageur->ajouterComposantTab();
        $formPlanteRavageur->ajouterComposantLigne($formPlanteRavageur->creerLabel("<br/>"));
        $formPlanteRavageur->ajouterComposantTab();
        
        //         On vérifie que la plante à bien des bioagresseurs disponibles
        if(!empty($lesPlantes)){
            $formPlanteRavageur->ajouterComposantLigne($formPlanteRavageur->creerLabelFor("listePlanteRavageur", "Ajouter une plante au ravageur : "));
            $formPlanteRavageur->ajouterComposantLigne($formPlanteRavageur->creerSelect("listePlanteRavageur", "listePlanteRavageur", "Les plantes : ", $lesPlantes));
            $formPlanteRavageur->ajouterComposantLigne($formPlanteRavageur->creerInputSubmit("boutonAjouterSensible", "boutonAjouterSensible", "Ajouter"));
            $formPlanteRavageur->ajouterComposantTab();
        }
        else{
            $formPlanteRavageur->ajouterComposantLigne($formPlanteRavageur->creerLabel("Aucune plante trouvée."));
            $formPlanteRavageur->ajouterComposantTab();
        }
        $formPlanteRavageur->ajouterComposantLigne($formPlanteRavageur->creerLabel("<br/>"));
        $formPlanteRavageur->ajouterComposantTab();
        
        $formPlanteRavageur->creerFormulaire();

//     ------------              Fin -  Les plantes                ------------
//     ------------                Les organes                ------------
        //     Ajouter un sensible organe - 1ere partie
        $lesOrganes = RavageurDAO::getLesOrganesNOT($_SESSION['leRavageur']) ;
        
        $formOrganeRavageur = new Formulaire("post","index.php","formPlanteRavageur","formPlanteRavageur");
        $formOrganeRavageur->ajouterComposantLigne($formOrganeRavageur->creerTitreH3("Ajouter un organe : "));
        $formOrganeRavageur->ajouterComposantTab();
        $formOrganeRavageur->ajouterComposantLigne($formOrganeRavageur->creerLabel("<br/>"));
        $formOrganeRavageur->ajouterComposantTab();
        
        //         On vérifie que la plante à bien des bioagresseurs disponibles
        if(!empty($lesOrganes)){
            $formOrganeRavageur->ajouterComposantLigne($formOrganeRavageur->creerLabelFor("listeOrganeRavageur", "Ajouter un organe au ravageur : "));
            $formOrganeRavageur->ajouterComposantLigne($formOrganeRavageur->creerSelect("listeOrganeRavageur", "listeOrganeRavageur", "Les organes : ", $lesOrganes));
            $formOrganeRavageur->ajouterComposantLigne($formOrganeRavageur->creerInputSubmit("boutonAjouterAffecter", "boutonAjouterAffecter", "Ajouter"));
            $formOrganeRavageur->ajouterComposantTab();
        }
        else{
            $formOrganeRavageur->ajouterComposantLigne($formOrganeRavageur->creerLabel("Aucun organe trouvé."));
            $formOrganeRavageur->ajouterComposantTab();
        }
        $formOrganeRavageur->ajouterComposantLigne($formOrganeRavageur->creerLabel("<br/>"));
        $formOrganeRavageur->ajouterComposantTab();
        
        $formOrganeRavageur->creerFormulaire();
        
//     ------------               Fin -  Les organes                ------------
//     ------------                Les traitements                ------------
//     Ajouter un sensible organe - 1ere partie
        $lesTraitements = RavageurDAO::getLesTraitementsNOT($_SESSION['leRavageur']) ;
        
        $formTraitementRavageur = new Formulaire("post","index.php","formPlanteRavageur","formPlanteRavageur");
        $formTraitementRavageur->ajouterComposantLigne($formTraitementRavageur->creerTitreH3("Ajouter un traitement : "));
        $formTraitementRavageur->ajouterComposantTab();
        $formTraitementRavageur->ajouterComposantLigne($formTraitementRavageur->creerLabel("<br/>"));
        $formTraitementRavageur->ajouterComposantTab();
        
        //         On vérifie que la plante à bien des bioagresseurs disponibles
        if(!empty($lesTraitements)){
            $formTraitementRavageur->ajouterComposantLigne($formTraitementRavageur->creerLabelFor("listeTraitement", "Ajouter un traitement au ravageur : "));
            $formTraitementRavageur->ajouterComposantLigne($formTraitementRavageur->creerSelect("listeTraitement", "listeTraitement", "Les traitements : ", $lesTraitements));
            $formTraitementRavageur->ajouterComposantLigne($formTraitementRavageur->creerInputSubmit("boutonAjouterTraiter", "boutonAjouterTraiter", "Ajouter"));
            $formTraitementRavageur->ajouterComposantTab();
        }
        else{
            $formTraitementRavageur->ajouterComposantLigne($formTraitementRavageur->creerLabel("Aucun traitement trouvé."));
            $formTraitementRavageur->ajouterComposantTab();
        }
        $formTraitementRavageur->ajouterComposantLigne($formTraitementRavageur->creerLabel("<br/>"));
        $formTraitementRavageur->ajouterComposantTab();
        
        $formTraitementRavageur->creerFormulaire();
        //     ------------               Fin -  Les traitements                ------------
        
        
        
        
//                 Supprimer un sensible - 1ere partie
//         On recupere les plantes du ravageur
                $lesPlantes = RavageurDAO::getLesPlantes($_SESSION['leRavageur']);
//          On recupere les organes
                $lesOrganes = RavageurDAO::getLesOrganes($_SESSION['leRavageur']);
//          On recupere les traitements
                $lesTraitements = RavageurDAO::getLesTraitements($_SESSION['leRavageur']);
                if(!empty($lesPlantes) || !empty($lesOrganes) || !empty($lesTraitements)){
                    $tabGererRavageur = [];
                    
                    if(!empty($lesPlantes)){
                        $i = 0;
                        foreach($lesPlantes as $plante){
                            $tabGererRavageur[$i][0] = $plante['nomPlante'];
                            $tabGererRavageur[$i][1] = "<form method='post' action = 'index.php' name='formSupp'>".Fonctions::creerInputHidden("idPlante", "idPlante".$i, $plante['idPlante']).Fonctions::creerInputSubmit("boutonSupprSensible", "boutonSupprSensible".$i, "Supprimer")."</form>";
                            $i++;
                        }
                    }
                    else{
                        $i = 0;
                        $tabGererRavageur[$i][0] = "";
                        $tabGererRavageur[$i][1] = "";
                    }
                    if(!empty($lesOrganes)){
                        $i = 0;
                        foreach($lesOrganes as $organe){
                            $tabGererRavageur[$i][2] = $organe['nomOrgane'];
                            $tabGererRavageur[$i][3] = "<form method='post' action = 'index.php' name='formSupp'>".Fonctions::creerInputHidden("idOrgane", "idOrgane".$i, $organe['idOrgane']).Fonctions::creerInputSubmit("boutonSupprAffecter", "boutonSupprAffecter".$i, "Supprimer")."</form>";
                            $i++;
                        }
                    }
                    else{
                        $i = 0;
                        $tabGererRavageur[$i][2] = "";
                        $tabGererRavageur[$i][3] = "";
                    }
                    if(!empty($lesTraitements)){
                        $i = 0;
                        foreach($lesTraitements as $traitement){
                            $tabGererRavageur[$i][4] = $traitement['nomTraitement'];
                            $tabGererRavageur[$i][5] = "<form method='post' action = 'index.php' name='formSupp'>".Fonctions::creerInputHidden("idTraitement", "idTraitement".$i, $traitement['idTraitement']).Fonctions::creerInputSubmit("boutonSupprTraiter", "boutonSupprTraiter".$i, "Supprimer")."</form>";
                            $i++;
                        }
                    }
                    else{
                        $i = 0;
                        $tabGererRavageur[$i][4] = "";
                        $tabGererRavageur[$i][5] = "";
                    }
                   

                    $tabGererRavageur = new Tableau("tabBioagresseur", $tabGererRavageur);
                    $tabGererRavageur->setTitreTab("Les plantes / organes / traitements de ".$_SESSION['leRavageur']->getNomBioagresseur());
                    //$tabGererRavageur->setTitreCol(array("Plante :", "","Organe :", "","Traitement :", ""));
                }
        
    }
    
    
    // **********************************************
    // Fin - Gérer les organes / plantes / traitements
    // **********************************************
    

require_once 'vue/vueSqueletteRavageur.php' ;
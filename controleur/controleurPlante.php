<?php
    // On recupère les plantes de la base de données
    $listePlantes = new Plantes(PlanteDAO::getPlantes());

    
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
                $nomDestination = strtolower($_POST['nomPlante'].".jpg");
                
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


    if(isset($_SESSION['laPlante'])){
//         Ajouter plante - 2eme partie
        if($_SESSION['plante'] != 0 && isset($_POST['enregistrer'])){
            $signe = array("'","\"");
            $bon = array("&apos;", "&quot;");
            
            $planteActive = new Plante();
            $idPlante = PlanteDAO::maxID()+1;
            $planteActive->setIdPlante($idPlante);
            $descriptionPlante = $_POST['descriptionPlante'];
            $descriptionPlante = str_replace($signe, $bon, $descriptionPlante);
            $planteActive->setDescriptifPlante($descriptionPlante);
            $nomPlante = $_POST['nomPlante'];
            $nomPlante = str_replace($signe, $bon, $nomPlante);
            $planteActive->setNomPlante($nomPlante);
            PlanteDAO::ajouterPlante($planteActive);
                
             $listePlantes = new Plantes(PlanteDAO::getPlantes());
                
             $_SESSION['plante'] = $idPlante;

             upload();
                
        }
//         Modifier plante - deuxieme partie
        if($_SESSION['plante'] != 0 && isset($_POST['modifier'])){
            $signe = array("'","\"");
            $bon = array("&apos;", "&quot;");
            
            $planteActive = new Plante();
            $planteActive->setIdPlante($_SESSION['laPlante']->getIdPlante());
            $descriptionPlante =$_POST['descriptionPlante'];
            $descriptionPlante = str_replace($signe, $bon, $descriptionPlante);
            $planteActive->setDescriptifPlante($descriptionPlante);
            $nomPlante = $_POST['nomPlante'];
            $nomPlante = str_replace($signe, $bon, $nomPlante);
            $planteActive->setNomPlante($nomPlante);
            PlanteDAO::modifierPlante($planteActive);
            
            $listePlantes = new Plantes(PlanteDAO::getPlantes());
            
            
            //             Nouvelle photo
            upload();


            
            
        }
//         Supprimer plante - 2eme partie
        if($_SESSION['plante'] != 0 && isset($_POST['ouiSupprPlante'])){
            $signe = array("'","\"");
            $bon = array("&apos;", "&quot;");
            
            $planteActive = new Plante();
            $planteActive->setIdPlante($_SESSION['laPlante']->getIdPlante());
            $descriptionPlante =$_SESSION['laPlante']->getDescriptifPlante();
            $descriptionPlante = str_replace($signe, $bon, $descriptionPlante);
            $planteActive->setDescriptifPlante($descriptionPlante);
            $nomPlante = $_SESSION['laPlante']->getNomPlante();
            $nomPlante = str_replace($signe, $bon, $nomPlante);
            $planteActive->setNomPlante($nomPlante);
            PlanteDAO::supprimerPlante($planteActive);
            
            $_SESSION['plante']= PlanteDAO::maxID();
            $listePlantes = new Plantes(PlanteDAO::getPlantes());
            
//             Supprimer photo dans le dossier
            $filename = './images/'.strtolower($planteActive->getNomPlante()).'.jpg';
            if(file_exists($filename)){
                unlink($filename );
            }
            
            
        }
        
//         Ajouter sensible - 2eme partie
        if($_SESSION['plante'] != 0 && isset($_POST['boutonAjouterSensible'])){
            $nomBioagresseur = $_POST['listeBioagresseur'];
            $listeBioagresseur = BioagresseurDAO::getBioAgresseurs();
            foreach($listeBioagresseur as $bioagresseur){
                if($bioagresseur->getNomBioagresseur() == $nomBioagresseur){
                    PlanteDAO::ajouterSensible($_SESSION['laPlante'], $bioagresseur);
                }
            }
        }
        
        //         Supprimer sensible - 2eme partie
        if($_SESSION['plante'] != 0 && isset($_POST['boutonSupprSensible'])){
            PlanteDAO::supprimerPlanteUnSensible($_SESSION['laPlante'], $_POST['idBioagresseur']);
        }
    }

    
    // **********************************************
    //          Choix d'une plante
    // **********************************************
    
    
    // Si on a une plante choisi ou bien on prend la plante de base
    if(isset($_GET['plante'])){
        $_SESSION['plante']= $_GET['plante'];
    }
    else
    {
        if(!isset($_SESSION['plante'])){
            $_SESSION['plante']=1;
        }
    }
    // **********************************************
    //        Fin -   Choix d'une plante
    // **********************************************
    
    // **********************************************
    //         Menu de toutes les Plantes
    // **********************************************
    
    
    // On crée le menu à gauche pour toutes les Plantes
    $menuPlante = new Menu("menuPlante");
    // Pour chaque plante on recupère le nom et on crée un lien vers leur page
    foreach ($listePlantes->getLesPlantes() as $unePlante){
        $menuPlante->ajouterComposant($menuPlante->creerItemLien($unePlante->getIdPlante(),$unePlante->getNomPlante()));
    }
    //On crée le menu avec toutes les plantes + liens
    $leMenuPlante = $menuPlante->creerMenu($_SESSION['plante'], "ifra=plante&plante");
    
//     Bouton ajout si on a les droits
    if(isset($_SESSION['intervenant']) && $_SESSION['intervenant']->getCodeStatut() == "S01"){
        $formAjout = new Formulaire("post", "index.php", "formAjoutPlante", "formAjout");
        $formAjout->ajouterComposantLigne($formAjout->creerInputSubmit("boutonAjouter", "ajouterPlante", "Ajouter"));
        $formAjout->ajouterComposantTab();
        $formAjout->creerFormulaire();
    }
    
    // **********************************************
    //        Fin - Menu de toutes les Plantes
    // **********************************************
    // **********************************************
    //        Affiche la Plante
    // **********************************************
    if($_SESSION['plante'] != 0){
        foreach($listePlantes->getLesPlantes() as $unePlante){
            
            //         On recupere la plante choisie
            if($unePlante->getIdPlante() == $_SESSION['plante']){
                $laPlante = PlanteDAO::lire($_SESSION['plante']);
                $laPlante = new Plante($laPlante[0],$laPlante[1],$laPlante[2]);
                //             On la passe en session
                $_SESSION['laPlante']=$laPlante;
                
                $formPlante = new Formulaire("post", "index.php?ifra=plante", "formPlante", "formPlante");
                $formPlante->ajouterComposantLigne($formPlante->creerTitreH3($laPlante->getNomPlante()));
                $formPlante->ajouterComposantTab();
                
                $signe = array("'","\"");
                $bon = array("&apos;", "&quot;");
                $nomPlante = $laPlante->getNomPlante();
                $nomPlante = str_replace($bon, $signe, $nomPlante);

                $filename = './images/'.strtolower($nomPlante).'.jpg';
                if(file_exists($filename)){
                    $formPlante->ajouterComposantLigne($formPlante->creerImage(strtolower($laPlante->getNomPlante()).".jpg", "Photograhie de ".$laPlante->getNomPlante()));
                    $formPlante->ajouterComposantTab();
                }
                $formPlante->ajouterComposantLigne($formPlante->creerCorps($laPlante->getDescriptifPlante()));
                $formPlante->ajouterComposantTab();
                $formPlante->ajouterComposantLigne($formPlante->creerLabel("<br/>"));
                $formPlante->ajouterComposantTab();
//                 Bouton modifier et suppression si on a les droits
                if(isset($_SESSION['intervenant']) && $_SESSION['intervenant']->getCodeStatut() == "S01"){
                    $unComposant = $formPlante->creerInputSubmit("boutonModifier", "modifierPlante", "Modifier");
                    $autreComposant = $formPlante->creerInputSubmit("boutonSupprimer", "supprimerPlante", "Supprimer");
                    $formPlante->ajouterComposantLigne($formPlante->concactComposants($unComposant, $autreComposant));
                    $formPlante->ajouterComposantTab();
                }
                
                
                $formPlante->creerFormulaire();
            }
        }
    }
    
    if(isset($_SESSION['laPlante'])){
//         On recupere les maladies et ravageurs de la plante
        $listeMaladie = PlanteDAO::getLesMaladies($_SESSION['laPlante']);
        $listeRavageur = PlanteDAO::getLesRavageurs($_SESSION['laPlante']);
        
            // On crée la liste des maladies de la plante
            $menuMaladiePlante = new Menu("menuMaladiePlante");
            foreach ($listeMaladie as $uneMaladie){
                $menuMaladiePlante->ajouterComposant($menuMaladiePlante->creerItemLien($uneMaladie["idBioagresseur"],$uneMaladie["nomBioagresseur"]));
            }
            $leMenuMaladiePlante = $menuMaladiePlante->creerMenu("", "ifra=maladie&maladie");
        
            // On crée la liste des maladies de la plante
            $menuMaladieRavageur = new Menu("menuRavageurPlante");
            foreach ($listeRavageur as $unRavageur){
                $menuMaladieRavageur->ajouterComposant($menuMaladieRavageur->creerItemLien($unRavageur["idBioagresseur"],$unRavageur["nomBioagresseur"]));
            }
            $leMenuMaladieRavageur = $menuMaladieRavageur->creerMenu("", "ifra=ravageur&ravageur");


    }
    //     Bouton gérer si on a les droits
    if(isset($_SESSION['intervenant']) && $_SESSION['intervenant']->getCodeStatut() == "S01"){           
        $formGererPlante = new Formulaire("post", "index.php", "formGererPlante", "formGerer");
        $formGererPlante->ajouterComposantLigne($formGererPlante->creerInputSubmit("boutonGerer", "gererPlante", "Gérer"));
        $formGererPlante->ajouterComposantTab();
        $leFormGererPlante = $formGererPlante->creerFormulaire();
    }
    
    
    
    // **********************************************
    //        Fin - Affiche la Plante
    // **********************************************
    // **********************************************
    //         Ajout / Modif / Suppr la Plante
    // **********************************************
    
    
//             Ajouter une plante #1 - Premiere partie
    if($_SESSION['plante'] != "0" && isset($_POST['boutonAjouter'])){
        $formAjoutPlante = new Formulaire("post","index.php","formAjoutPlante","formAjoutPlante");
        $formAjoutPlante->ajouterComposantLigne($formAjoutPlante->creerTitreH3("Ajouter une plante"));
        $formAjoutPlante->ajouterComposantTab();
        $formAjoutPlante->ajouterComposantLigne($formAjoutPlante->creerLabelFor("nomPlante", "Nom de la plante : "));
        $formAjoutPlante->ajouterComposantLigne($formAjoutPlante->creerInputTexte("nomPlante", "nomPlante", "", 1,""  , ""));
        $formAjoutPlante->ajouterComposantTab();
        $formAjoutPlante->ajouterComposantLigne($formAjoutPlante->creerLabel("Description : "));
        $formAjoutPlante->ajouterComposantTab();
        $formAjoutPlante->ajouterComposantLigne($formAjoutPlante->creerTextArea("descriptionPlante", "", "descriptionPlante", 1, ""));
        $formAjoutPlante->ajouterComposantTab();
        $formAjoutPlante->ajouterComposantLigne($formAjoutPlante->creerLabelFor("image", "Choisir une image : "));
        $formAjoutPlante->ajouterComposantLigne($formAjoutPlante->creerInputFile("image", "image"));
        $formAjoutPlante->ajouterComposantTab();
        $formAjoutPlante->ajouterComposantLigne($formAjoutPlante->creerInputSubmit("enregistrer", "enregistrer", "Enregistrer"));
        $formAjoutPlante->ajouterComposantTab();
        
        
        $formAjoutPlante->creerFormulaire();   
        
       
    }
    //              Modifier une plante #1 - Premiere partie
    if($_SESSION['plante'] != "0" && isset($_POST['boutonModifier'])){
        $formModifPlante = new Formulaire("post","index.php","formModifPlante","formModifPlante");
        $formModifPlante->ajouterComposantLigne($formModifPlante->creerTitreH3("Modifier une plante : " . $_SESSION['laPlante']->getNomPlante()));
        $formModifPlante->ajouterComposantTab();
        $formModifPlante->ajouterComposantLigne($formModifPlante->creerLabelFor("nomPlante", "Nom de la plante : "));
        $formModifPlante->ajouterComposantLigne($formModifPlante->creerInputTexte("nomPlante", "nomPlante", $_SESSION['laPlante']->getNomPlante(), "" ,""  , "" , ""));
        $formModifPlante->ajouterComposantTab();
        $formModifPlante->ajouterComposantLigne($formModifPlante->creerLabel("Desription : "));
        $formModifPlante->ajouterComposantTab();
        $formModifPlante->ajouterComposantLigne($formModifPlante->creerTextArea("descriptionPlante", "", "descriptionPlante", 1,$_SESSION['laPlante']->getDescriptifPlante()));
        $formModifPlante->ajouterComposantTab();
        $formModifPlante->ajouterComposantLigne($formModifPlante->creerLabelFor("image", "Choisir une image : "));
        $formModifPlante->ajouterComposantLigne($formModifPlante->creerInputFile("image", "image"));
        $formModifPlante->ajouterComposantTab();
        $formModifPlante->ajouterComposantLigne($formModifPlante->creerInputSubmit("modifier", "modifier", "Modifier"));
        $formModifPlante->ajouterComposantTab();
        
        $formModifPlante->creerFormulaire();
    }
    
    //              Supprimer une plante #1 - Premiere partie
    if($_SESSION['plante'] != "0" && isset($_POST['boutonSupprimer'])){
        $formSupprPlante = new Formulaire("post","index.php","formSupprPlante","formSupprPlante");
        $formSupprPlante->ajouterComposantLigne($formSupprPlante->creerTitreH3("Supprimer une plante : " . $_SESSION['laPlante']->getNomPlante()));
        $formSupprPlante->ajouterComposantTab();
        $formSupprPlante->ajouterComposantLigne($formSupprPlante->creerLabel("Voulez vous vraiment supprimer cette plante ? "));
        $formSupprPlante->ajouterComposantLigne($formSupprPlante->creerLabelId($_SESSION['laPlante']->getNomPlante(), "nomPlante"));
        $formSupprPlante->ajouterComposantTab();
        $unComposant = $formSupprPlante->creerInputSubmit("ouiSupprPlante", "ouiPlante", "Supprimer");
        $autreComposant = $formSupprPlante->creerInputSubmit("nomSupprPlante", "nonPlante", "Annuler");
        $formSupprPlante->ajouterComposantLigne($formSupprPlante->concactComposants($unComposant, $autreComposant));
        $formSupprPlante->ajouterComposantTab();
        
        
        $formSupprPlante->creerFormulaire();
    }
    // **********************************************
    //        Fin -  Ajout / Modif / Suppr la Plante
    // **********************************************
    
    // **********************************************
    //        Gérer les maladies / ravageurs
    // **********************************************


    if($_SESSION['plante'] != "0" && isset($_POST['boutonGerer'])){
        
        //     Ajouter un sensible - 1ere partie
        $lesBioagresseurs = PlanteDAO::getLesBioagresseursNOT($_SESSION['laPlante']) ;
        
        $formBioagresseurPlante = new Formulaire("post","index.php?ifra=plante&plante=".$_SESSION['laPlante']->getIdPlante()."","formBioagresseurPlante","formBioagresseurPlante");
        $formBioagresseurPlante->ajouterComposantLigne($formBioagresseurPlante->creerTitreH3("Ajouter un bioagresseur : "));
        $formBioagresseurPlante->ajouterComposantTab();
        $formBioagresseurPlante->ajouterComposantLigne($formBioagresseurPlante->creerLabel("<br/>"));
        $formBioagresseurPlante->ajouterComposantTab();
        
//         On vérifie que la plante à bien des bioagresseurs disponibles
        if(!empty($lesBioagresseurs)){
            $formBioagresseurPlante->ajouterComposantLigne($formBioagresseurPlante->creerLabelFor("listeBioagresseur", "Ajouter un bioagresseur à la plante : "));
            $formBioagresseurPlante->ajouterComposantLigne($formBioagresseurPlante->creerSelect("listeBioagresseur", "listeBioagresseur", "Les maladies : ", $lesBioagresseurs));
            $formBioagresseurPlante->ajouterComposantLigne($formBioagresseurPlante->creerInputSubmit("boutonAjouterSensible", "boutonAjouterSensible", "Ajouter"));
            $formBioagresseurPlante->ajouterComposantTab();
        }
        else{
            $formBioagresseurPlante->ajouterComposantLigne($formBioagresseurPlante->creerLabel("Aucun bioagresseur trouvé."));
            $formBioagresseurPlante->ajouterComposantTab();
        }

        $formBioagresseurPlante->creerFormulaire();
        
//         Supprimer un sensible - 1ere partie
// On recupere les bioagresseurs de la plante
        $lesBioagresseurs = PlanteDAO::getLesBioagresseurs($_SESSION['laPlante']);
        if(!empty($lesBioagresseurs)){
            $tabBioagresseurPlante = [];
            $i = 0;
            foreach($lesBioagresseurs as $bioagresseur){
                $tabBioagresseurPlante[$i][0] = $bioagresseur['nomBioagresseur'];
                $tabBioagresseurPlante[$i][1] = "<form method='post' action = 'index.php' name='formSupp'>". Fonctions::creerInputHidden("idBioagresseur", "idBioagresseur".$i, $bioagresseur['idBioagresseur']). Fonctions::creerInputSubmit("boutonSupprSensible", "boutonSupprSensible".$i, "Supprimer")."</form>";
                $i++;
            }
            $tabBioagresseurPlante = new Tableau("tabBioagresseur", $tabBioagresseurPlante);
            $tabBioagresseurPlante->setTitreTab("Les bioagresseurs de ".$_SESSION['laPlante']->getNomPlante());
            //$tabBioagresseurPlante->setTitreCol(array("Bioagresseur", ""));
        }

    }
    
    
    // **********************************************
    //      Fin -   Gérer les maladies / ravageurs
    // **********************************************
    


    require_once 'vue/vueSquelettePlante.php' ;
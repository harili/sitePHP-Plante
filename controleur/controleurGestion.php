<?php
    
    // Les intervenants
    $listeIntervenants = new Intervenants();
    $listeIntervenants->setLesIntervenants(IntervenantDAO::getUtilisateurs());
    
    // Les status
//     $listeStatuts = new Statuts();
//     $listeStatuts->setStatuts(StatutDAO::getStatut());
    $listeStatuts = [];
    $listeStatuts[0][0]= 'S01';
    $listeStatuts[0][1]= 'Directeur des Ressources Humaines';
    $listeStatuts[1][0]= 'S02';
    $listeStatuts[1][1]= 'Salarié';
    $listeStatuts[2][0]= 'S03';
    $listeStatuts[2][1]= 'Observateur';
    
    
        //         Ajouter plante - 2eme partie
        if($_SESSION['intervenant'] != NULL && isset($_POST['enregistrer'])){
            $signe = array("'","\"");
            $bon = array("&apos;", "&quot;");
            
            $intervenantActif = new Intervenant();
            $idIntervenant = IntervenantDAO::maxID()+1;
            $intervenantActif->setIdIntervenant($idIntervenant);
            $nomIntervenant = $_POST['nom'];
            $nomIntervenant = str_replace($signe, $bon, $nomIntervenant);
            $intervenantActif->setNomIntervenant($nomIntervenant);
            $prenomIntervenant = $_POST['prenom'];
            $prenomIntervenant = str_replace($signe, $bon, $prenomIntervenant);
            $intervenantActif->setPrenomIntervenant($prenomIntervenant);
            $login = $_POST['loginIntervenant'];
            $login = str_replace($signe, $bon, $login);
            $intervenantActif->setLogin($login);
            $mdp = $_POST['mdpIntervenant'];
            $intervenantActif->setMdp($mdp);
            $codeStatut = $_POST['codeStatut'];
            $intervenantActif->setCodeStatut($codeStatut);
            
            IntervenantDAO::ajouterIntervenant($intervenantActif);
            
            $listeIntervenants = new intervenants(IntervenantDAO::getUtilisateurs());
        }
//         //         Modifier plante - deuxieme partie
//         if($_SESSION['plante'] != 0 && isset($_POST['modifier'])){
//             $signe = array("'","\"");
//             $bon = array("&apos;", "&quot;");
            
//             $planteActive = new Plante();
//             $planteActive->setIdPlante($_SESSION['laPlante']->getIdPlante());
//             $descriptionPlante =$_POST['descriptionPlante'];
//             $descriptionPlante = str_replace($signe, $bon, $descriptionPlante);
//             $planteActive->setDescriptifPlante($descriptionPlante);
//             $nomPlante = $_POST['nomPlante'];
//             $nomPlante = str_replace($signe, $bon, $nomPlante);
//             $planteActive->setNomPlante($nomPlante);
//             PlanteDAO::modifierPlante($planteActive);
            
//             $listePlantes = new Plantes(PlanteDAO::getPlantes());
            
            
//             //             Nouvelle photo
//             upload();
            
            
            
            
//         }
//         //         Supprimer plante - 2eme partie
//         if($_SESSION['plante'] != 0 && isset($_POST['ouiSupprPlante'])){
//             $signe = array("'","\"");
//             $bon = array("&apos;", "&quot;");
            
//             $planteActive = new Plante();
//             $planteActive->setIdPlante($_SESSION['laPlante']->getIdPlante());
//             $descriptionPlante =$_SESSION['laPlante']->getDescriptifPlante();
//             $descriptionPlante = str_replace($signe, $bon, $descriptionPlante);
//             $planteActive->setDescriptifPlante($descriptionPlante);
//             $nomPlante = $_SESSION['laPlante']->getNomPlante();
//             $nomPlante = str_replace($signe, $bon, $nomPlante);
//             $planteActive->setNomPlante($nomPlante);
//             PlanteDAO::supprimerPlante($planteActive);
            
//             $_SESSION['plante']= PlanteDAO::maxID();
//             $listePlantes = new Plantes(PlanteDAO::getPlantes());
            
//             //             Supprimer photo dans le dossier
//             $filename = './images/'.strtolower($planteActive->getNomPlante()).'.jpg';
//             if(file_exists($filename)){
//                 unlink($filename );
//             }
            
            
//         }
    
    
    // **********************************************
    //         Menu de tous les Intervenants
    // **********************************************
    
    
    // On crée le menu à gauche pour toutes les Plantes
    $menuIntervenant = new Menu("menuIntervenant");
    // Pour chaque plante on recupère le nom et on crée un lien vers leur page
    foreach ($listeIntervenants->getLesIntervenants() as $unIntervenant){
        $menuIntervenant->ajouterComposant($menuIntervenant->creerItemLien($unIntervenant->getIdIntervenant(),$unIntervenant->getNomIntervenant()));
    }
    //On crée le menu avec toutes les plantes + liens
    $menuIntervenant = $menuIntervenant->creerMenu($_SESSION['intervenant'], "#");
    
    $formAjout = new Formulaire("post", "index.php", "formAjoutPlante", "formAjout");
    $formAjout->ajouterComposantLigne($formAjout->creerInputSubmit("boutonAjouter", "ajouterPlante", "Ajouter"));
    $formAjout->ajouterComposantTab();
    $formAjout->creerFormulaire();
    
    // **********************************************
    //        Fin - Menu de tous les Intervenants
    // **********************************************
    // **********************************************
    //         Ajout / Modif / Suppr la Plante
    // **********************************************
    
    
    //             Ajouter une plante #1 - Premiere partie
    if($_SESSION['intervenant'] != NULL && isset($_POST['boutonAjouter'])){
        $prenom = "";
        $nom ="";
        $login ="";
        
        $obligatoire = "<span class='obligatoire'>* </span>";
        
        $formulaireInscription = new Formulaire('post', 'index.php', 'fInscription', 'formAjoutIntervenant');
        $formulaireInscription->ajouterComposantLigne($formulaireInscription->creerTitre('Créer un compte'));
        $formulaireInscription->ajouterComposantTab();
        if(!empty($message)){
            $formulaireInscription->ajouterComposantLigne($formulaireInscription->creerLabelId($message,"message"));
            $formulaireInscription->ajouterComposantTab();
        }
        $formulaireInscription->ajouterComposantLigne($formulaireInscription->creerInputTexte('obligatoire', 'obligatoire', 'Champs obligatoires *', 1, '', ''));
        $formulaireInscription->ajouterComposantTab();
        $formulaireInscription->ajouterComposantLigne($formulaireInscription->creerLabel('Prénom : '.$obligatoire));
        $formulaireInscription->ajouterComposantTab();
        $formulaireInscription->ajouterComposantLigne($formulaireInscription->creerInputTexte('prenom', 'prenom', $prenom, 1, '', ''));
        $formulaireInscription->ajouterComposantTab();
        $formulaireInscription->ajouterComposantLigne($formulaireInscription->creerLabel('Nom : '.$obligatoire));
        $formulaireInscription->ajouterComposantTab();
        $formulaireInscription->ajouterComposantLigne($formulaireInscription->creerInputTexte('nom', 'nom', $nom, 1, '', ''));
        $formulaireInscription->ajouterComposantTab();
        $formulaireInscription->ajouterComposantLigne($formulaireInscription->creerLabel('Login : '.$obligatoire));
        $formulaireInscription->ajouterComposantTab();
        $formulaireInscription->ajouterComposantLigne($formulaireInscription->creerInputTexte('loginIntervenant', 'loginIntervenant', $login, 1, ' Il vous sera utile lors de votre connexion.', ''));
        $formulaireInscription->ajouterComposantTab();
        $formulaireInscription->ajouterComposantLigne($formulaireInscription->creerLabel('Mot de passe : '.$obligatoire));
        $formulaireInscription->ajouterComposantTab();
        $formulaireInscription->ajouterComposantLigne($formulaireInscription->creerInputMdp('mdpIntervenant', 'mdpIntervenant',  1, ' Entre 8 et 16 caractères.', ''));
        $formulaireInscription->ajouterComposantTab();
        $formulaireInscription->ajouterComposantLigne($formulaireInscription->creerLabel('Statut : '.$obligatoire));
        $formulaireInscription->ajouterComposantTab();
        $formulaireInscription->ajouterComposantLigne($formulaireInscription->creerSelectIndicé("codeStatut", "codeStatut", "".$obligatoire, $listeStatuts));
        $formulaireInscription->ajouterComposantTab();

        
        $formulaireInscription->ajouterComposantLigne($formulaireInscription-> creerInputSubmit('enregistrer', 'enregistrer', 'Créer un compte'));
        $formulaireInscription->ajouterComposantTab();
        
        $formulaireInscription->ajouterComposantLigne($formulaireInscription->creerMessage(''));
        $formulaireInscription->ajouterComposantTab();
        
        $formulaireInscription->creerFormulaire();
        
        
    }
    
    
    
    //              Modifier une plante #1 - Premiere partie
//     if($_SESSION['plante'] != "0" && isset($_POST['boutonModifier'])){
//         $formModifPlante = new Formulaire("post","index.php","formModifPlante","formModifPlante");
//         $formModifPlante->ajouterComposantLigne($formModifPlante->creerTitreH3("Modifier une plante : " . $_SESSION['laPlante']->getNomPlante()));
//         $formModifPlante->ajouterComposantTab();
//         $formModifPlante->ajouterComposantLigne($formModifPlante->creerLabelFor("nomPlante", "Nom de la plante : "));
//         $formModifPlante->ajouterComposantLigne($formModifPlante->creerInputTexte("nomPlante", "nomPlante", $_SESSION['laPlante']->getNomPlante(), "" ,""  , "" , ""));
//         $formModifPlante->ajouterComposantTab();
//         $formModifPlante->ajouterComposantLigne($formModifPlante->creerLabel("Desription : "));
//         $formModifPlante->ajouterComposantTab();
//         $formModifPlante->ajouterComposantLigne($formModifPlante->creerTextArea("descriptionPlante", "", "descriptionPlante", 1,$_SESSION['laPlante']->getDescriptifPlante()));
//         $formModifPlante->ajouterComposantTab();
//         $formModifPlante->ajouterComposantLigne($formModifPlante->creerLabelFor("image", "Choisir une image : "));
//         $formModifPlante->ajouterComposantLigne($formModifPlante->creerInputFile("image", "image"));
//         $formModifPlante->ajouterComposantTab();
//         $formModifPlante->ajouterComposantLigne($formModifPlante->creerInputSubmit("modifier", "modifier", "Modifier"));
//         $formModifPlante->ajouterComposantTab();
        
//         $formModifPlante->creerFormulaire();
//     }
    
//     //              Supprimer une plante #1 - Premiere partie
//     if($_SESSION['plante'] != "0" && isset($_POST['boutonSupprimer'])){
//         $formSupprPlante = new Formulaire("post","index.php","formSupprPlante","formSupprPlante");
//         $formSupprPlante->ajouterComposantLigne($formSupprPlante->creerTitreH3("Supprimer une plante : " . $_SESSION['laPlante']->getNomPlante()));
//         $formSupprPlante->ajouterComposantTab();
//         $formSupprPlante->ajouterComposantLigne($formSupprPlante->creerLabel("Voulez vous vraiment supprimer cette plante ? "));
//         $formSupprPlante->ajouterComposantLigne($formSupprPlante->creerLabelId($_SESSION['laPlante']->getNomPlante(), "nomPlante"));
//         $formSupprPlante->ajouterComposantTab();
//         $unComposant = $formSupprPlante->creerInputSubmit("ouiSupprPlante", "ouiPlante", "Supprimer");
//         $autreComposant = $formSupprPlante->creerInputSubmit("nomSupprPlante", "nonPlante", "Annuler");
//         $formSupprPlante->ajouterComposantLigne($formSupprPlante->concactComposants($unComposant, $autreComposant));
//         $formSupprPlante->ajouterComposantTab();
        
        
//         $formSupprPlante->creerFormulaire();
//     }
    // **********************************************
    //        Fin -  Ajout / Modif / Suppr la Plante
    // **********************************************
    
    
    require_once 'vue/vueSqueletteGestion.php' ;
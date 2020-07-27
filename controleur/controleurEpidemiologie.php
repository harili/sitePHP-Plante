<?php
// On recupère les observations de la base de données
$listeObservations = new Observations(ObservationDAO::getObservations());

// **********************************************
//          Choix d'une observation
// **********************************************



// Si on a une observation choisi ou bien on prend l'observation de base
if(isset($_GET['epidemiologie'])){
    $_SESSION['epidemiologie']= $_GET['epidemiologie'];
}
else
{
    if(!isset($_SESSION['epidemiologie'])){
        $_SESSION['epidemiologie']=1;
    }
}

// **********************************************
//         Menu de toutes les Observations
// **********************************************


// On crée le menu à gauche pour toutes les Observations
$menuObservation = new Menu("menuObservation");
// Pour chaque observation on recupère le nom et on crée un lien vers leur page
foreach ($listeObservations->getLesObservations() as $uneObservation){
    $menuObservation->ajouterComposant($menuObservation->creerItemLien($uneObservation->getIdObservation(),"Observation : ".$uneObservation->getIdObservation()));
}
//On crée le menu avec toutes les observations + liens
$leMenuObservation = $menuObservation->creerMenu($_SESSION['epidemiologie'], "ifra=epidemiologie&epidemiologie");

// **********************************************
//        Affiche l'Observation
// **********************************************
if($_SESSION['epidemiologie'] != 0){
    foreach($listeObservations->getLesObservations() as $uneObservation){
        
        //         On recupere l'observation choisie
        if($uneObservation->getIdObservation() == $_SESSION['epidemiologie']){
            $observationTout = ObservationDAO::lireTout($_SESSION['epidemiologie']);
            $laObservation = new Observation();
            $laObservation->hydrate($observationTout);
            //             On la passe en session
            $_SESSION['laEpidemiologie']=$laObservation;
            
            $formObservation = new Formulaire("post", "index.php", "formEpidemiologie", "formEpidemiologie");
            
            
            $formObservation->ajouterComposantLigne($formObservation->creerTitreH3("Observation numéro : " .$observationTout['idObservation']));
            $formObservation->ajouterComposantTab();
            $formObservation->ajouterComposantLigne($formObservation->creerLabel("Le nom de l'intervenant : "));
            $formObservation->ajouterComposantLigne($formObservation->creerLabel($observationTout['nomIntervenant']));
            $formObservation->ajouterComposantTab();
            $formObservation->ajouterComposantLigne($formObservation->creerLabel("Le libellé de l'observation : "));
            $formObservation->ajouterComposantLigne($formObservation->creerLabel($observationTout['libelleObservation']));
            $formObservation->ajouterComposantTab();
            $formObservation->ajouterComposantLigne($formObservation->creerLabel("La date de l'observation : "));
            $formObservation->ajouterComposantLigne($formObservation->creerLabel($observationTout['dateObservation']));
            $formObservation->ajouterComposantTab();
            $formObservation->ajouterComposantLigne($formObservation->creerLabel("Les coordonée de l'observation : "));
            $formObservation->ajouterComposantLigne($formObservation->creerLabel($observationTout['coordoneeObservation']));
            $formObservation->ajouterComposantTab();
            
            list($long, $lat) = explode(",",$observationTout['coordoneeObservation']);
            
            $formObservation->ajouterComposantLigne($formObservation->creerMap($long,$lat));
            $formObservation->ajouterComposantTab();
            $formObservation->ajouterComposantLigne($formObservation->creerLabel("Le nom du bioagresseur : "));
            $formObservation->ajouterComposantLigne($formObservation->creerLabel($observationTout['nomBioagresseur']));
            $formObservation->ajouterComposantTab();
            $formObservation->ajouterComposantLigne($formObservation->creerLabel("Le nom de la plante : "));
            $formObservation->ajouterComposantLigne($formObservation->creerLabel($observationTout['nomPlante']));
            $formObservation->ajouterComposantTab();
            
            if(isset($_SESSION['intervenant']) && $_SESSION['intervenant']->getCodeStatut() == "S03"){
            $formObservation->ajouterComposantLigne($formObservation->creerInputSubmit("boutonModifier", "modifierObservation","Modifier"));
            $formObservation->ajouterComposantLigne($formObservation->creerInputSubmit("boutonSupprimer", "supprimerObservation","Supprimer"));
            $formObservation->ajouterComposantTab();
            }
            
            $formObservation->creerFormulaire();
            
        }
    }
}


//             Ajouter une Observation #1 - Premiere partie
/*if($_SESSION['epidemiologie'] != "0" && isset($_POST['boutonAjouter'])){
    $formAjoutObservation = new Formulaire("post","index.php","formAjoutObservation","formAjoutObservation");
    $formAjoutObservation->ajouterComposantLigne($formAjoutObservation->creerTitreH3("Ajouter une observation"));
    $formAjoutObservation->ajouterComposantTab();
    $formAjoutObservation->ajouterComposantLigne($formAjoutObservation->creerLabelFor("nomIntervenant", "Nom de l'intervenant : "));
    $formAjoutObservation->ajouterComposantLigne($formAjoutObservation->creerInputTexte("nomIntervenant", "nomIntervenant", "", "" ,""  , "" , ""));
    $formAjoutObservation->ajouterComposantTab();
    $formAjoutObservation->ajouterComposantLigne($formAjoutObservation->creerLabel("Libelle : "));
    $formAjoutObservation->ajouterComposantTab();
    $formAjoutObservation->ajouterComposantLigne($formAjoutObservation->creerTextArea("libObservation", "", "libObservation", 1, ""));
    $formAjoutObservation->ajouterComposantTab();
    $formAjoutObservation->ajouterComposantLigne($formAjoutObservation->creerLabelFor("dateObservation", "Date de l'observation : "));
    $formAjoutObservation->ajouterComposantLigne($formAjoutObservation->creerInputTexte("dateObservation", "dateObservation", "", "" ,""  , "" , ""));
    $formAjoutObservation->ajouterComposantTab();
    $formAjoutObservation->ajouterComposantLigne($formAjoutObservation->creerLabelFor("coordoneeObservation", "Coordonée de l'observation : "));
    $formAjoutObservation->ajouterComposantLigne($formAjoutObservation->creerInputTexte("coordoneeObservation", "coordoneeObservation", "", "" ,""  , "" , ""));
    $formAjoutObservation->ajouterComposantTab();
    $formAjoutObservation->ajouterComposantLigne($formAjoutObservation->creerLabelFor("nomBioagresseur", "Nom du bioagresseur: "));
    $formAjoutObservation->ajouterComposantLigne($formAjoutObservation->creerInputTexte("nomBioagresseur", "nomBioagresseur", "", "" ,""  , "" , ""));
    $formAjoutObservation->ajouterComposantTab();
    $formAjoutObservation->ajouterComposantLigne($formAjoutObservation->creerLabelFor("nomIntervenant", "Nom de l'intervenant : "));
    $formAjoutObservation->ajouterComposantLigne($formAjoutObservation->creerInputTexte("nomIntervenant", "nomIntervenant", "", "" ,""  , "" , ""));
    $formAjoutObservation->ajouterComposantTab();
    
    $formAjoutObservation->ajouterComposantLigne($formAjoutObservation->creerInputSubmit("enregistrer", "enregistrer", "Enregistrer"));
    $formAjoutObservation->ajouterComposantTab();
    
    
    $formAjoutPlante->creerFormulaire();
    
    
}*/
//              Modifier une observation #1 - Premiere partie


if($_SESSION['epidemiologie'] != "0" && isset($_POST['boutonModifier'])){

    $formModifObservation =  new Formulaire("post","index.php","formModifObservation","formModifObservation");

    
    $formModifObservation->ajouterComposantLigne($formModifObservation->creerTitreH3("Observation : " . $_SESSION['laEpidemiologie']->getIdObservation()));
    $formModifObservation->ajouterComposantTab();
    $formModifObservation->ajouterComposantLigne($formModifObservation->creerLabelFor("nomIntervenant", "Nom de l'intervenant : "));
    //$tabIntervenant = ObservationDAO::getNomIntervenant($_SESSION['laEpidemiologie']->getIdIntervenant());
    $tabIntervenant = ObservationDAO::getIntervenantNomId();
    $formModifObservation->ajouterComposantLigne($formModifObservation->creerSelect2("nomIntervenant", "nomIntervenant", $tabIntervenant));
    $formModifObservation->ajouterComposantTab();
    $formModifObservation->ajouterComposantLigne($formModifObservation->creerLabel("Le libellé de l'observation : "));
    $formModifObservation->ajouterComposantTab();
    $formModifObservation->ajouterComposantLigne($formModifObservation->creerTextArea("libelleObservation", "", "libelleObservation", 1,ObservationDAO::getLibObsIntervenant($_SESSION['laEpidemiologie']->getIdIntervenant())));
    $formModifObservation->ajouterComposantTab();
    $formModifObservation->ajouterComposantLigne($formModifObservation->creerLabelFor("dateObservation", "Date de l'observation : "));
    $formModifObservation->ajouterComposantLigne($formModifObservation->creerInputTexte("dateObservation", "dateObservation", ObservationDAO::getDateObsIntervenant($_SESSION['laEpidemiologie']->getIdIntervenant()), "" ,""  , "" , ""));
    $formModifObservation->ajouterComposantTab();
    $formModifObservation->ajouterComposantLigne($formModifObservation->creerLabelFor("coordonneeObservation", "Coordonnée de l'observation : "));
    $formModifObservation->ajouterComposantLigne($formModifObservation->creerInputTexte("coordonneeObservation", "coordonneeObservation", ObservationDAO::getCoordoneeObsIntervenant($_SESSION['laEpidemiologie']->getIdIntervenant()), "" ,""  , "" , ""));
    $formModifObservation->ajouterComposantTab();
    $formModifObservation->ajouterComposantLigne($formModifObservation->creerLabelFor("nomBioagresseur", "Nom du bioagresseur : "));
    //$tabBioagresseur = ObservationDAO::getBioagresseurObservation($_SESSION['laEpidemiologie']->getIdObservation());
    $tabBioagresseur = ObservationDAO::getBioagresseurNomId();
    $formModifObservation->ajouterComposantLigne($formModifObservation->creerSelect2("nomBioagresseur", "nomBioagresseur", $tabBioagresseur));
    $formModifObservation->ajouterComposantTab();
    $formModifObservation->ajouterComposantLigne($formModifObservation->creerLabelFor("nomPlante", "Nom de la plante : "));
    //$tabPlante = ObservationDAO::getPlanteIntervenant($_SESSION['laEpidemiologie']->getIdObservation());
    $tabPlante = ObservationDAO::getPlanteNomId();
    $formModifObservation->ajouterComposantLigne($formModifObservation->creerSelect2("nomPlante", "nomPlante", $tabPlante));
    $formModifObservation->ajouterComposantTab();
    
    $formModifObservation->ajouterComposantLigne($formModifObservation->creerInputSubmit("btnValidModif", "btnValidModif", "Valider"));
    $formModifObservation->ajouterComposantTab();
    
    $formModifObservation->creerFormulaire();
    
    
}

//              Modifier une observation #1 - Deuxième partie

if($_SESSION['epidemiologie'] != "0" && isset($_POST['btnValidModif'])){
    $observationActive = new Observation();
    $observationActive->setIdObservation($_SESSION['laEpidemiologie']->getIdObservation());
    $observationActive->setIdIntervenant($_POST['nomIntervenant']);
    $observationActive->setIdPlante($_POST['nomPlante']);
    $observationActive->setLibelleObservation($_POST['libelleObservation']);
    $observationActive->setDateObservation($_POST['dateObservation']);
    $observationActive->setCoordoneeObservation($_POST['coordonneeObservation']);
    $observationActive->setIdBioAgresseur($_POST['nomBioagresseur']);
    
    ObservationDAO::modifierObservation3($observationActive);
    
    $listeObservations = new Observations(ObservationDAO::getObservations());
}







//            Supprimer une Observation #1 - Premiere partie
if($_SESSION['epidemiologie'] != "0" && isset($_POST['boutonSupprimer'])){
    $formSupprObservation = new Formulaire("post","index.php","formSupprObservation","formSupprObservation");
    $formSupprObservation->ajouterComposantLigne($formSupprObservation->creerTitreH3("Supprimer de l'Observation : " . $_SESSION['laEpidemiologie']->getIdObservation()));
    $formSupprObservation->ajouterComposantTab();
    $formSupprObservation->ajouterComposantLigne($formSupprObservation->creerLabelFor("nomObservation", "Voulez vous vraiment supprimer cette observation ? "));
    $formSupprObservation->ajouterComposantLigne($formSupprObservation->creerLabelId($_SESSION['laEpidemiologie']->getIdObservation(), "idObservation"));
    $formSupprObservation->ajouterComposantTab();
    $unComposant = $formSupprObservation->creerInputSubmit("ouiSupprObservation", "ouiObservation", "Supprimer");
    $autreComposant = $formSupprObservation->creerInputSubmit("nomSupprObvservation", "nomObservation", "Annuler");
    $formSupprObservation->ajouterComposantLigne($formSupprObservation->concactComposants($unComposant, $autreComposant));
    $formSupprObservation->ajouterComposantTab();
    
    
    $formSupprObservation->creerFormulaire();
}

//         Supprimer observation - 2eme partie
if($_SESSION['epidemiologie'] != 0 && isset($_POST['ouiSupprObservation'])){
    $observationActive = new Observation();
    $observationActive->setIdObservation($_SESSION['laEpidemiologie']->getIdObservation());
    ObservationDAO::supprimerObservation($observationActive);
    
    $_SESSION['epidemiologie']= ObservationDAO::maxID();
    $listeObservations = new Observation(ObservationDAO::getObservations());
}
// **********************************************
//        Fin -  Ajout / Modif / Suppr l'observation
// **********************************************

// **********************************************
//        Gérer les maladies / ravageurs
// **********************************************

/*
if($_SESSION['epidemiologie'] != "0" && isset($_POST['boutonGerer'])){
    
    //     Ajouter un sensible - 1ere partie
    $lesBioagresseurs = PlanteDAO::getLesBioagresseursNOT($_SESSION['laPlante']) ;
    
    $formBioagresseurPlante = new Formulaire("post","index.php","formBioagresseurPlante","formBioagresseurPlante");
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
            $tabBioagresseurPlante[$i][1] = "<form method='post' action = 'index.php' name='formSupp'>".Fonctions::creerInputHidden("idBioagresseur", "idBioagresseur", $bioagresseur['idBioagresseur']).Fonctions::creerInputSubmit("boutonSupprSensible", "boutonSupprSensible", "Supprimer")."</form>";
            $i++;
        }
        $tabBioagresseurPlante = new Tableau("tabBioagresseur", $tabBioagresseurPlante);
        $tabBioagresseurPlante->setTitreTab("Les bioagresseurs de ".$_SESSION['laPlante']->getNomPlante());
        $tabBioagresseurPlante->setTitreCol(array("Bioagresseur", ""));
    }
    
}

*/
// **********************************************
//      Fin -   Gérer les maladies / ravageurs
// **********************************************



require_once 'vue/vueSqueletteEpidemiologie.php' ;
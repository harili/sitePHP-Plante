<?php

    $unFormulaireContact = new Formulaire('post','action="mailto:jbourtereau.ge@gmail.com"','contact','formContact');
    
    $labelMail = $unFormulaireContact->creerLabel('Votre mail :');
    $inputMail = $unFormulaireContact->creerInputTexte('mail', 'inpMail', '' ,'required','' , "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/");
    
    $labelNom = $unFormulaireContact->creerLabel('Votre nom :');
    $inputNom = $unFormulaireContact->creerInputTexte('nom', 'inpNom', '' ,'required','' , "[a-zA-ZàâæçéèêëîïôœùûüÿÀÂÆÇnÉÈÊËÎÏÔŒÙÛÜŸ-]+");
    
    
    
    $email = $unFormulaireContact->concactComposants($labelMail, $inputMail);
    $nom = $unFormulaireContact->concactComposants($labelNom, $inputNom);
    
    $submit = $unFormulaireContact->creerInputSubmit('btnSendMail', 'sendmail', 'Envoyer');
   
    $unFormulaireContact->ajouterComposantLigne($unFormulaireContact->creerLabel('<br/>'));
    $unFormulaireContact->ajouterComposantTab();
    $unFormulaireContact->ajouterComposantLigne($unFormulaireContact->creerLabel('<br/>'));
    $unFormulaireContact->ajouterComposantTab();
    $unFormulaireContact->ajouterComposantLigne($email);
    $unFormulaireContact->ajouterComposantLigne($unFormulaireContact->creerLabel('<br/>'));
    $unFormulaireContact->ajouterComposantTab();
    $unFormulaireContact->ajouterComposantLigne($unFormulaireContact->creerLabel('<br/>'));
    $unFormulaireContact->ajouterComposantTab();
    $unFormulaireContact->ajouterComposantLigne($nom);
    $unFormulaireContact->ajouterComposantTab();
    $unFormulaireContact->ajouterComposantLigne($unFormulaireContact->creerLabel('<br/>'));
    $unFormulaireContact->ajouterComposantTab();
    $unFormulaireContact->ajouterComposantLigne($unFormulaireContact->creerLabelFor('lblMessage' , 'Message :'));
    $unFormulaireContact->ajouterComposantTab();
    $unFormulaireContact->ajouterComposantLigne($unFormulaireContact->creerLabel('<br/>'));
    $unFormulaireContact->ajouterComposantTab();
    $unFormulaireContact->ajouterComposantLigne($unFormulaireContact->creerTextArea('message', '', 'message', 'required',''));
    $unFormulaireContact->ajouterComposantLigne($unFormulaireContact->creerLabel('<br/>'));
    $unFormulaireContact->ajouterComposantTab();
    $unFormulaireContact->ajouterComposantLigne($unFormulaireContact->creerLabel('<br/>'));
    $unFormulaireContact->ajouterComposantTab();
    $unFormulaireContact->ajouterComposantLigne($submit);
    $unFormulaireContact->ajouterComposantTab();
    
    $unFormulaireContact->creerFormulaire();


require_once 'vue/vueContact.php' ;
?>
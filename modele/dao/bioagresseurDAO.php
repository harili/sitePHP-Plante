<?php
class BioagresseurDAO{

    // recupere tout les bioAgresseurs
    public static function getBioAgresseurs()
    {        
    	$result = [];
        $sql = "select * from bioagresseur";       
        $liste = DBConnex::getInstance()->query($sql); 
		$liste = $liste->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($liste)){
            foreach($liste as $bioAgresseur){
            	$objet = new Bioagresseur();
            	$objet->hydrate($bioAgresseur);
            	$result[] = $objet;            	
            }
        }
        return $result;
    }
    
    public static function maxID(){
        $sql = "select MAX(idBioagresseur) from bioagresseur";
        $res = DBConnex::getInstance()->query($sql);
        $resultat = $res->fetch();
        return $resultat[0];
    }
    
    // recupere tout les bioAgresseurs Ravageurs dans bioagresseur
    public static function getBioAgresseursRav()
    {        
    	$result = [];
        $sql = "select * from bioagresseur where idBioagresseur in (select idBioagresseur from ba_ravageur)"; 
        $liste = DBConnex::getInstance()->query($sql); 
		$liste = $liste->fetchAll(PDO::FETCH_ASSOC);        
		if(!empty($liste)){
            foreach($liste as $bioAgresseur){
            	$objet = new Bioagresseur();
            	$objet->hydrate($bioAgresseur);
            	$result[] = $objet;            	
            }
        }
        
        return $result;
    }
    
    
    //ajoute un bioagresseur dans la base de donnée
    public static function ajouterBioagresseur (Bioagresseur $unBioagresseur) {
        $sql = "insert into bioagresseur (idBioagresseur, nomBioagresseur, periodeRisqueBioagresseur, symptomeBioagresseur, stadeSensibleBioagresseur) 
            values ('".$unBioagresseur->getIdBioagresseur()."'
            , '".$unBioagresseur->getNomBioagresseur()."'
            ,'".$unBioagresseur->getPeriodeRisqueBioagresseur()."'
            ,  '".$unBioagresseur->getSymptomeBioagresseur()."'
            , '".$unBioagresseur->getStadeSensibleBioagresseur()."');";
        
        return DBConnex::getInstance()->exec($sql);
    }
    
    
    //modifer un bioagresseur dans la base de donnée
    public static function modifierBioagresseur (BioAgresseur $unBioagresseur) {
        $id = $unBioagresseur->getIdBioagresseur();
        $nom = $unBioagresseur->getNomBioagresseur();
        $perio = $unBioagresseur->getPeriodeRisqueBioagresseur();
        $sympt = $unBioagresseur->getSymptomeBioagresseur();
        $stadesens = $unBioagresseur->getStadeSensibleBioagresseur();
        
        $sql = "update bioagresseur 
        set nomBioagresseur = '".$nom."',
         periodeRisqueBioagresseur = '".$perio."',
         symptomeBioagresseur = '".$sympt."',
         stadeSensibleBioagresseur = '".$stadesens."' where idBioagresseur = ".$id.";";

        
        return DBConnex::getInstance()->exec($sql);
    }
    
    //supprimer un bioagresseur dans la base de données
    public static function supprimerBioagresseur (BioAgresseur $unBioagresseur) {
    //         On supprimer le bioagresseur dans les autres tables avant de le supprimer lui
        BioagresseurDAO::supprimerBioagresseurAffecter($unBioagresseur);
        BioagresseurDAO::supprimerBioagresseurObservation($unBioagresseur);
        BioagresseurDAO::supprimerBioagresseurSensible($unBioagresseur);
        BioagresseurDAO::supprimerBioagresseurTraiter($unBioagresseur);
        
        $sql = "delete from bioagresseur where idBioagresseur = :id;";
        $req = dBConnex::getInstance()->prepare($sql);
        $id = $unBioagresseur->getIdBioagresseur();
        $req->bindParam(":id", $id);
  
        $req->execute();
        $req->fetch();
    }
    
    
    // recupere tout les bioAgresseurs Maladies dans bioagresseur
    public static function getBioAgresseursMal()
    {        
    	$result = [];
        $sql = "select * from bioagresseur where idBioagresseur in (select idBioagresseur from ba_maladie)"; 
        $liste = DBConnex::getInstance()->query($sql); 
		$liste = $liste->fetchAll(PDO::FETCH_ASSOC);
		if(!empty($liste)){
            foreach($liste as $bioAgresseur){
            	$objet = new Bioagresseur();
            	$objet->hydrate($bioAgresseur);
            	$result[] = $objet;            	
            }
        }
        return $result;
    }

    public static function lire($idBio){
        $sql = "select * from bioagresseur where idBioagresseur = :idBio";
        $req = dBConnex::getInstance()->prepare($sql);
        $req->bindParam(":idBio", $idBio);
        $req->execute();
        return $req->fetch();
    }
    
    //     Supprimer le bioagresseur dans traiter
    public static function supprimerBioagresseurTraiter (BioAgresseur $unBioagresseur) {
        $sql = "delete from traiter where idBioagresseur = :id;";
        $req = dBConnex::getInstance()->prepare($sql);
        $id = $unBioagresseur->getIdBioagresseur();
        $req->bindParam(":id", $id);
        
        $req->execute();
        $req->fetch();
    }
    //     Supprimer le bioagresseur dans sensible
    public static function supprimerBioagresseurSensible (BioAgresseur $unBioagresseur) {
        $sql = "delete from sensible where idBioagresseur = :id;";
        $req = dBConnex::getInstance()->prepare($sql);
        $id = $unBioagresseur->getIdBioagresseur();
        $req->bindParam(":id", $id);
        
        $req->execute();
        $req->fetch();
    }
    
    //     Supprimer le bioagresseur dans affecter
    public static function supprimerBioagresseurAffecter (BioAgresseur $unBioagresseur) {
        $sql = "delete from affecter where idBioagresseur = :id;";
        $req = dBConnex::getInstance()->prepare($sql);
        $id = $unBioagresseur->getIdBioagresseur();
        $req->bindParam(":id", $id);
        
        $req->execute();
        $req->fetch();
    }
    
    //     Supprimer le bioagresseur dans observation
    public static function supprimerBioagresseurObservation (BioAgresseur $unBioagresseur) {
        $sql = "delete from observation where idBioagresseur = :id;";
        $req = dBConnex::getInstance()->prepare($sql);
        $id = $unBioagresseur->getIdBioagresseur();
        $req->bindParam(":id", $id);
        
        $req->execute();
        $req->fetch();
    }
}
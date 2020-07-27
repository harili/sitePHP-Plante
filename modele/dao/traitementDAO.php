<?php

class TraitementDAO{
    public static function getTraitements()
    {        
    	$result = [];
        $sql = "select * from traitement"; 
        $liste = DBConnex::getInstance()->query($sql); 
		$liste = $liste->fetchAll(PDO::FETCH_ASSOC);
		if(!empty($liste)){
            foreach($liste as $traitement){
            	$objet = new Traitement();
            	$objet->hydrate($traitement);
            	$result[] = $objet;            	
            }
        }  
        return $result;
    }
    
    public static function lire($idTraitement){
        $sql = "select * from traitement where idTraitement = :idTraitement";
        $req = dBConnex::getInstance()->prepare($sql);
        $req->bindParam(":idTraitement", $idTraitement);
        $req->execute();
        return $req->fetch();
    }
    
    //Ajoute un organe dans la base de données
    public static function ajouterTraitement(Traitement $unTraitement){
        $sql = "insert into traitement values (
                ". $unTraitement->getIdTraitement() .",
                '".$unTraitement->getNomTraitement()."',
                '".$unTraitement->getDescriptifTraitement()."')";
        return DBConnex::getInstance()->exec($sql);
    }
    
    
    
    // Ajoute une occurence dans traiter
    public static function ajouterTraiter(Traitement $unTraitement, BioAgresseur $unBioagresseur){
    	$sql = "insert into traiter (idTraitement, idBioagresseur) values (:id, :bio);";
        $req = dBConnex::getInstance()->prepare($sql);
        $id = $unTraitement->getIdTraitement();
        $bio = $unBioagresseur->getIdBioagresseur();
        $req->bindParam(":id", $id);
        $req->bindParam(":bio", $bio);
        
        $req->execute();
        return $req->fetch();
    }
    
    public static function supprimerTraitementTraiter(Traitement $unTraitement)
    {
        $sql = "delete from traiter where idTraitement = :id";
        $req = dBConnex::getInstance()->prepare($sql);
        $id = $unTraitement->getIdTraitement();
        $req->bindParam(":id", $id);
        $req->execute();
        return $req->fetch();
    }   
    
    //Supprime un traitement
    public static function supprimerTraite(Traitement $unTraitement)
    {
        TraitementDAO::supprimerTraitementTraiter($unTraitement);
        
        $sql = "delete from traitement where IDTRAITEMENT = :id";
        $req = dBConnex::getInstance()->prepare($sql);
        $id = $unTraitement->getIdTraitement();
        $req->bindParam(":id", $id);
        $req->execute();
        return $req->fetch();
    }    
    
    //recupere l'id traitement maximum
    public static function maxID(){
        $sql = "select MAX(idTraitement) from traitement";
        $res = DBConnex::getInstance()->query($sql);
        $resultat = $res->fetch();
        return $resultat[0];
    }
    



    public static function modifierTraitement(Traitement $unTraitement){
    	$sql = "update traitement SET nomTraitement = :nom, descriptifTraitement = :desc WHERE idTraitement= :id";
        $req = dBConnex::getInstance()->prepare($sql);
        $id = $unTraitement->getIdTraitement();
        $nom = $unTraitement->getNomTraitement();
        $desc = $unTraitement->getDescriptifTraitement();
        $req->bindParam(":id", $id);
    	$req->bindParam(":nom", $nom);
        $req->bindParam(":desc", $desc);
        
        $req->execute();
        return $req->fetch();
    }
    
    public static function getLesRavageurs(Traitement $unTraitement){
        $sql = "select *
                from bioagresseur, ba_ravageur, traiter
                where (bioagresseur.idBioagresseur = ba_ravageur.idBioagresseur
                and bioagresseur.idBioagresseur = traiter.idBioagresseur)
                and idTraitement = :idTraitement";
        $req = dBConnex::getInstance()->prepare($sql);
        $idTraitement = $unTraitement->getIdTraitement();
        $req->bindParam(":idTraitement", $idTraitement);
        $req->execute();
        
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //     Retourne les bioagresseurs qui ne sont PAS en relation avec l'organe mis en parametre
    public static function getLesBioagresseursNOT(Traitement $unTraitement){
        $sql = "SELECT idBioagresseur , nomBioagresseur
                FROM bioagresseur
                WHERE idBioagresseur NOT IN ( SELECT idBioagresseur
                                             FROM traiter
                                             WHERE idTraitement = :idTraitement)
                ORDER BY nomBioagresseur ASC";
        $req = dBConnex::getInstance()->prepare($sql);
        $idTraitement = $unTraitement->getIdTraitement();
        $req->bindParam(":idTraitement", $idTraitement);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_BOTH);
    }
    
    
    //     Retourne les bioagresseurs qui SONT en relation avec l'organe mis en parametre
    public static function getLesBioagresseurs(Traitement $unTraitement){
        $sql = "SELECT bioagresseur.idBioagresseur , nomBioagresseur
                FROM bioagresseur, traiter
                WHERE bioagresseur.idBioagresseur = traiter.idBioagresseur
                AND idTraitement = :idTraitement
                ORDER BY nomBioagresseur ASC";
        $req = dBConnex::getInstance()->prepare($sql);
        $idTraitement = $unTraitement->getIdTraitement();
        $req->bindParam(":idTraitement", $idTraitement);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_BOTH);
    }
    
    
    public static function  getLesMaladies(Traitement $unTraitement){
        $sql = "select *
                from bioagresseur, ba_maladie, traiter
                where (bioagresseur.idBioagresseur = ba_maladie.idBioagresseur
                and bioagresseur.idBioagresseur = traiter.idBioagresseur)
                and idTraitement = :idTraitement";
        $req = dBConnex::getInstance()->prepare($sql);
        $idTraitement = $unTraitement->getIdTraitement();
        $req->bindParam(":idTraitement", $idTraitement);
        $req->execute();
        
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }


}

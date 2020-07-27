<?php

class RavageurDAO{
    public static function getRavageurs()
    {        
    	$result = [];
        $sql = "select * from ba_ravageur, bioagresseur where ba_ravageur.idBioagresseur = bioagresseur.idBioagresseur order by nomBioagresseur"; 
        $liste = DBConnex::getInstance()->query($sql); 
		$liste = $liste->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($liste)){
            foreach($liste as $ravageur){
            	$objet = new Ravageur();
            	$objet->hydrate($ravageur);
            	$result[] = $objet;            	
            }
        }
        return $result;
    }

    public static function lire($idBioagresseur){
        $sql = "select * from bioagresseur, ba_ravageur where bioagresseur.idBioagresseur = ba_ravageur.idBioagresseur and ba_ravageur.idBioagresseur = ". $idBioagresseur."";
        $res = DBConnex::getInstance()->query($sql);
        $resultat = $res->fetch();
        return $resultat;
    }

    public static function ajouterRavageur(Ravageur $unRavageur){
        BioagresseurDAO::ajouterBioagresseur($unRavageur);
        
        $sql = "insert into ba_ravageur (idBioagresseur, stadeActif, nbGeneration) 
        values ('".$unRavageur->getIdBioagresseur()."'
        , '".$unRavageur->getStadeActif()."'
        , '".$unRavageur->getNbGeneration()."');";
        return DBConnex::getInstance()->exec($sql);
    }
    
    //supprime le ravageur de la base de données
    public static function supprimerRavageur(Ravageur $unRavageur)
    {
        $sql = "delete from ba_ravageur where idBioagresseur = :id";
        $req = dBConnex::getInstance()->prepare($sql);
        $id = $unRavageur->getIdBioagresseur();
        $req->bindParam(":id", $id);

        $req->execute();
        $req->fetch();
        
        
        BioagresseurDAO::supprimerBioagresseur($unRavageur);
    }  

    public static function maxID(){
        $sql = "select MAX(idBioagresseur) from ba_ravageur";
        $req = dBConnex::getInstance()->prepare($sql);
        $req->execute();
        return $req->fetch();
    }

    //Modifie une maladie dans la base de donnée
    public static function modifierRavageur(Ravageur $unRavageur){
        $sql = "update ba_ravageur SET nbGeneration = :nbGeneration, stadeActif = :stadeActif where idBioagresseur = :id";
        $req = dBConnex::getInstance()->prepare($sql);
        $id = $unRavageur->getIdBioagresseur();
        $stadeActif = $unRavageur->getStadeActif();
        $nbGeneration = $unRavageur->getNbGeneration();
        $req->bindParam(":id", $id);
        $req->bindParam(":stadeActif", $stadeActif);
        $req->bindParam(":nbGeneration", $nbGeneration);
        $req->execute();
        
        BioagresseurDAO::modifierBioagresseur($unRavageur);
        
        return $req->fetch();
    }
    
    public static function getLesPlantesNOT(Ravageur $unRavageur){
        $sql = "select idPlante, nomPlante
                from plante
                where idPlante NOT IN (select idPlante
                                        from sensible
                                        where idBioagresseur = :idRavageur)
                ORDER BY nomPlante ASC";
        $req = dBConnex::getInstance()->prepare($sql);
        $idRavageur = $unRavageur->getIdBioagresseur();
        $req->bindParam(":idRavageur", $idRavageur);
        $req->execute();
        
        return $req->fetchAll();
    }
    
    public static function getLesPlantes(Ravageur $unRavageur){
        $sql = "select *
                from plante, sensible
                where plante.idPlante = sensible.idPlante
                and idBioagresseur = :idRavageur";
        $req = dBConnex::getInstance()->prepare($sql);
        $idRavageur = $unRavageur->getIdBioagresseur();
        $req->bindParam(":idRavageur", $idRavageur);
        $req->execute();
        
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function getLesOrganesNOT(Ravageur $unRavageur){
        $sql = "select idOrgane, nomOrgane
                from organe
                where idOrgane NOT IN(select idOrgane 
                                      from affecter
                                      where idBioagresseur = :idRavageur)
                ORDER BY nomOrgane ASC";
        $req = dBConnex::getInstance()->prepare($sql);
        $idRavageur = $unRavageur->getIdBioagresseur();
        $req->bindParam(":idRavageur", $idRavageur);
        $req->execute();
        
        return $req->fetchAll();
    }
    
    
    public static function getLesOrganes(Ravageur $unRavageur){
        $sql = "select *
                from organe, affecter
                where organe.idOrgane = affecter.idOrgane
                and idBioagresseur = :idRavageur";
        $req = dBConnex::getInstance()->prepare($sql);
        $idRavageur = $unRavageur->getIdBioagresseur();
        $req->bindParam(":idRavageur", $idRavageur);
        $req->execute();
        
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function getLesTraitementsNOT(Ravageur $unRavageur){
        $sql = "select idTraitement, nomTraitement
                from traitement
                where idTraitement NOT IN(select idTraitement  
                                          from traiter 
                                          where idBioagresseur = :idRavageur)
                ORDER BY nomTraitement ASC";
        $req = dBConnex::getInstance()->prepare($sql);
        $idRavageur = $unRavageur->getIdBioagresseur();
        $req->bindParam(":idRavageur", $idRavageur);
        $req->execute();
        
        return $req->fetchAll();
    }
    
    
    public static function getLesTraitements(Ravageur $unRavageur){
        $sql = "select *
                from traitement, traiter
                where traitement.idTraitement = traiter.idTraitement
                and idBioagresseur = :idRavageur";
        $req = dBConnex::getInstance()->prepare($sql);
        $idRavageur = $unRavageur->getIdBioagresseur();
        $req->bindParam(":idRavageur", $idRavageur);
        $req->execute();
        
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function ajouterSensible(Ravageur $unRavageur, $idPlante)
    {
        $sql = "insert into sensible values(".$idPlante.",".$unRavageur->getIdBioagresseur().")";
        return DBConnex::getInstance()->exec($sql);
        
    }
    public static function supprimerUNSensible(Ravageur $unRavageur, $idPlante)
    {
        $sql = "delete from sensible where idPlante =".$idPlante." 
                and idBioagresseur = '".$unRavageur->getIdBioagresseur()."'";
        return DBConnex::getInstance()->exec($sql);
        
    } 
    
    public static function ajouterAffecter(Ravageur $unRavageur, $idOrgane)
    {
        $sql = "insert into affecter values(
        ".$idOrgane." , ".$unRavageur->getIdBioagresseur().")";
        return DBConnex::getInstance()->exec($sql);
        
    } 
    
    public static function supprimerUNAffecter(Ravageur $unRavageur, $idOrgane)
    {
        $sql = "delete from affecter where idOrgane =".$idOrgane."
                and idBioagresseur = '".$unRavageur->getIdBioagresseur()."'";
        return DBConnex::getInstance()->exec($sql);
        
    } 
    
    public static function ajouterTraiter(Ravageur $unRavageur, $idTraitement)
    {
        $sql = "insert into traiter (`idTraitement`, `idBioagresseur`) values (
        ".$idTraitement." , ".$unRavageur->getIdBioagresseur().")";
        return DBConnex::getInstance()->exec($sql);
        
    }
    
    
    public static function supprimerUNTraiter(Ravageur $unRavageur, $idTraitement)
    {
        $sql = "delete from traiter where idTraitement =".$idTraitement."
                and idBioagresseur = '".$unRavageur->getIdBioagresseur()."'";
        return DBConnex::getInstance()->exec($sql);
        
    } 
    
    
}
<?php

class MaladieDAO{
    
    public static function getMaladies()
    {        
    	$result = [];
        $sql = "select * from ba_maladie, bioagresseur where bioagresseur.idBioagresseur = ba_maladie.idBioagresseur"; 
        $liste = DBConnex::getInstance()->query($sql); 
		$liste = $liste->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($liste)){
            foreach($liste as $maladie){   
            	$objet = new Maladie();
            	$objet->hydrate($maladie);
            	$result[] = $objet;            	
            }
        }
        return $result;
    }

    public static function lire($idBioagresseur){
        $sql = "select * from bioagresseur, ba_maladie where bioagresseur.idBioagresseur = ba_maladie.idBioagresseur and bioagresseur.idBioagresseur = '". $idBioagresseur."'";
        $res = DBConnex::getInstance()->query($sql);
        $resultat = $res->fetch();
        return $resultat;
    }
    
    //ajoute une maladie dans bioagresseur_maladie dans la base de données
    public static function ajouterMaladie(Maladie $uneMaladie){
        BioagresseurDAO::ajouterBioagresseur($uneMaladie);
        
        $sql1 = "insert into ba_maladie (idBioagresseur, conditionsFavorables) values (:id, :cond);";
        $req1 = dBConnex::getInstance()->prepare($sql1);
        $id = $uneMaladie->getIdBioagresseur();
        $cond = $uneMaladie->getConditionsFavorables();
        $req1->bindParam(":id", $id);;
        $req1->bindParam(":cond", $cond);
        $req1->execute();
        $req1->fetch();
    }
    
    //supprime la maladie de la base de données
    public static function supprimerMaladie(Maladie $uneMaladie)
    {
        $sql = "delete from ba_maladie where idBioagresseur = :id";
        $req = dBConnex::getInstance()->prepare($sql);
        $id = $uneMaladie->getIdBioagresseur();
        $req->bindParam(":id", $id);
        $req->execute();
        $req->fetch();
        
        BioagresseurDAO::supprimerBioagresseur($uneMaladie);
    }    

    //trouve le dernier numéro de maladie
    public static function maxID(){
        $sql = "select MAX(idBioagresseur) from ba_maladie";
        $req = dBConnex::getInstance()->prepare($sql);
        $req->execute();
        return $req->fetch();
    }

    //Modifie une maladie dans la base de donnée
    public static function modifierMaladie(Maladie $uneMaladie){
        BioagresseurDAO::modifierBioagresseur($uneMaladie);
        
    	$sql = "update ba_maladie SET conditionsFavorables = :cond";
        $req = dBConnex::getInstance()->prepare($sql);
        $cond = $uneMaladie->getConditionsFavorables();
        $req->bindParam(":cond", $cond);
        $req->execute();
        return $req->fetch();
        

    }
    
    public static function getLesPlantes(Maladie $uneMaladie){
        $sql = "select *
                from plante, sensible
                where plante.idPlante = sensible.idPlante
                and idBioagresseur = :idMaladie";
        $req = dBConnex::getInstance()->prepare($sql);
        $idMaladie = $uneMaladie->getIdBioagresseur();
        $req->bindParam(":idMaladie", $idMaladie);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function getLesOrganes(Maladie $uneMaladie){
        $sql = "select *
                from organe, affecter
                where organe.idOrgane = affecter.idOrgane
                and idBioagresseur = :idMaladie";
        $req = dBConnex::getInstance()->prepare($sql);
        $idMaladie = $uneMaladie->getIdBioagresseur();
        $req->bindParam(":idMaladie", $idMaladie);
        $req->execute();
        
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function getLesTraitements(Maladie $uneMaladie){
        $sql = "select *
                from traitement, traiter
                where traitement.idTraitement = traiter.idTraitement
                and idBioagresseur = :idMaladie";
        $req = dBConnex::getInstance()->prepare($sql);
        $idMaladie = $uneMaladie->getIdBioagresseur();
        $req->bindParam(":idMaladie", $idMaladie);
        $req->execute();
        
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function ajouterSensible(Maladie $uneMaladie, $idPlante)
    {
        $sql = "insert into sensible values(".$idPlante.",".$uneMaladie->getIdBioagresseur().")";
        return DBConnex::getInstance()->exec($sql);
        
    }
    public static function supprimerUNSensible(Maladie $uneMaladie, $idPlante)
    {
        $sql = "delete from sensible where idPlante =".$idPlante."
                and idBioagresseur = '".$uneMaladie->getIdBioagresseur()."'";
        return DBConnex::getInstance()->exec($sql);
        
    }
    
    public static function ajouterAffecter(Maladie $uneMaladie, $idOrgane)
    {
        $sql = "insert into affecter values(
        ".$idOrgane." , ".$uneMaladie->getIdBioagresseur().")";
        return DBConnex::getInstance()->exec($sql);
        
    }
    
    public static function supprimerUNAffecter(Maladie $uneMaladie, $idOrgane)
    {
        $sql = "delete from affecter where idOrgane =".$idOrgane."
                and idBioagresseur = '".$uneMaladie->getIdBioagresseur()."'";
        return DBConnex::getInstance()->exec($sql);
        
    }
    
    public static function ajouterTraiter(Maladie $uneMaladie, $idTraitement)
    {
        $sql = "insert into traiter (`idTraitement`, `idBioagresseur`) values (
        ".$idTraitement." , ".$uneMaladie->getIdBioagresseur().")";
        return DBConnex::getInstance()->exec($sql);
        
    }
    
    
    public static function supprimerUNTraiter(Maladie $uneMaladie, $idTraitement)
    {
        $sql = "delete from traiter where idTraitement =".$idTraitement."
                and idBioagresseur = '".$uneMaladie->getIdBioagresseur()."'";
        return DBConnex::getInstance()->exec($sql);
        
    }
    
    public static function getLesPlantesNOT(Maladie $uneMaladie){
        $sql = "select idPlante, nomPlante
                from plante
                where idPlante NOT IN (select idPlante
                                        from sensible
                                        where idBioagresseur = :idMaladie)
                ORDER BY nomPlante ASC";
        $req = dBConnex::getInstance()->prepare($sql);
        $idMaladie = $uneMaladie->getIdBioagresseur();
        $req->bindParam(":idMaladie", $idMaladie);
        $req->execute();
        
        return $req->fetchAll();
    }
    
    public static function getLesOrganesNOT(Maladie $uneMaladie){
        $sql = "select idOrgane, nomOrgane
                from organe
                where idOrgane NOT IN(select idOrgane
                                      from affecter
                                      where idBioagresseur = :idMaladie)
                ORDER BY nomOrgane ASC";
        $req = dBConnex::getInstance()->prepare($sql);
        $idMaladie = $uneMaladie->getIdBioagresseur();
        $req->bindParam(":idMaladie", $idMaladie);
        $req->execute();
        
        return $req->fetchAll();
    }
    
    public static function getLesTraitementsNOT(Maladie $uneMaladie){
        $sql = "select idTraitement, nomTraitement
                from traitement
                where idTraitement NOT IN(select idTraitement
                                          from traiter
                                          where idBioagresseur = :idMaladie)
                ORDER BY nomTraitement ASC";
        $req = dBConnex::getInstance()->prepare($sql);
        $idMaladie = $uneMaladie->getIdBioagresseur();
        $req->bindParam(":idMaladie", $idMaladie);
        $req->execute();
        
        return $req->fetchAll();
    }

}
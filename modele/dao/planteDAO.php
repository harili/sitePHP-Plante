<?php
class PlanteDAO{

    // recupere toutes les informations de toutes les plantes
    public static function getPlantes()
    {        
    	$result = [];
        $sql = "select * from plante order by nomPlante"; 
       
        $liste = DBConnex::getInstance()->query($sql); 
		$liste = $liste->fetchAll(PDO::FETCH_ASSOC);
        
        if(count($liste)> 0){
            foreach($liste as $plante){
                
            	$objet = new Plante();
            	$objet->hydrate($plante);
            	
            	$result[] = $objet;            	
            }
        }
        
        return $result;
    }

    public static function lire($idPlante){
        $sql = "select * from plante where idPlante = :idPlante";
        $req = dBConnex::getInstance()->prepare($sql);
        $req->bindParam(":idPlante", $idPlante);
        $req->execute();
        return $req->fetch();
    }

    //recupere le la plante dont on met l'id en paramètre
    public static function getNomPlanteId($idPlante){
        $sql = "select * from plante where IDPLANTE = :idPlante";
        $req = dBConnex::getInstance()->prepare($sql);
        $req->bindParam(":idPlante", $idPlante);
        $req->execute();
        return $req->fetch();
    }



    //recupère l'id le plus élévé dans la table plante
    public static function maxID(){
        $sql = "select MAX(idPlante) from plante";
        $res = DBConnex::getInstance()->query($sql);
        $resultat = $res->fetch();
        return $resultat[0];
    }
    

    //Ajoute une plante dans la base de données
    public static function ajouterPlante(Plante $unePlante){
        $sql = "insert into plante values (
                ". $unePlante->getIdPlante() .",
                '".$unePlante->getNomPlante()."',
                '" . $unePlante->getDescriptifPlante()."')";
        return DBConnex::getInstance()->exec($sql);
    }


    public static function supprimerPlante(Plante $unePlante)
    {
        PlanteDAO::supprimerPlanteSensible($unePlante);
        
        $sql = "delete from plante where idPlante = ".$unePlante->getIdPlante();
        return DBConnex::getInstance()->exec($sql);
    } 
    
//     Retourne les bioagresseurs qui ne sont PAS en relation avec la plante mis en parametre
    public static function getLesBioagresseursNOT(Plante $unePlante){
        $sql = "SELECT idBioagresseur , nomBioagresseur
                FROM bioagresseur
                WHERE idBioagresseur NOT IN ( SELECT idBioagresseur 
                                             FROM sensible 
                                             WHERE idPlante = :idPlante)
                ORDER BY nomBioagresseur ASC";
        $req = dBConnex::getInstance()->prepare($sql);
        $idPlante = $unePlante->getIdPlante();
        $req->bindParam(":idPlante", $idPlante);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_BOTH);
    }
    
    //     Retourne les bioagresseurs qui SONT en relation avec la plante mis en parametre
    public static function getLesBioagresseurs(Plante $unePlante){
        $sql = "SELECT bioagresseur.idBioagresseur , nomBioagresseur
                FROM bioagresseur, sensible
                WHERE bioagresseur.idBioagresseur = sensible.idBioagresseur
                AND idPlante = :idPlante
                ORDER BY nomBioagresseur ASC";
        $req = dBConnex::getInstance()->prepare($sql);
        $idPlante = $unePlante->getIdPlante();
        $req->bindParam(":idPlante", $idPlante);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_BOTH);
    }
    
    //ajoute une plante et le bio agresseur dont elle est sensible dans la table sensible
    public static function ajouterSensible(Plante $unePlante ,BioAgresseur $unBioagresseur){
    	$sql = "insert into sensible (idPlante, idBioagresseur) values (:idPlante, :idBioagresseur);";
        $req = dBConnex::getInstance()->prepare($sql);
        $idPlante = $unePlante->getIdPlante();
        $idBioagresseur = $unBioagresseur->getIdBioagresseur();
        $req->bindParam(":idPlante", $idPlante);
        $req->bindParam(":idBioagresseur", $idBioagresseur);
        
        $req->execute();
        return $req->fetch();
    }



    public static function supprimerPlanteSensible(Plante $unePlante)
    {
        $sql = "delete from sensible where idPlante = 
        ".$unePlante->getIdPlante();
        return DBConnex::getInstance()->exec($sql);
    } 
    
    public static function supprimerPlanteUnSensible(Plante $unePlante, $idBioagresseur)
    {
        $sql = "delete from sensible where idPlante =
        ".$unePlante->getIdPlante()." and idBioagresseur = ".$idBioagresseur;
        return DBConnex::getInstance()->exec($sql);
    } 

    public static function modifierPlante(Plante $unePlante){
    	$sql = "update plante SET nomPlante = 
        '".$unePlante->getNomPlante()."', descriptifPlante = 
        '".$unePlante->getDescriptifPlante()."' WHERE idPlante= 
        ".$unePlante->getIdPlante();

    	return DBConnex::getInstance()->exec($sql);
    }
    
    
   
    public static function getLesRavageurs(Plante $unePlante){
        $sql = "select *
                from bioagresseur, ba_ravageur, sensible
                where (bioagresseur.idBioagresseur = ba_ravageur.idBioagresseur
                and bioagresseur.idBioagresseur = sensible.idBioagresseur)
                and idPlante = :idPlante
                order by nomBioagresseur ASC";
        $req = dBConnex::getInstance()->prepare($sql);
        $idPlante = $unePlante->getIdPlante();
        $req->bindParam(":idPlante", $idPlante);
        $req->execute();
        
        return $req->fetchAll(PDO::FETCH_BOTH);
    }
    
    
    public static function  getLesMaladies(Plante $unePlante){
        $sql = "select *
                from bioagresseur, ba_maladie, sensible
                where (bioagresseur.idBioagresseur = ba_maladie.idBioagresseur
                and bioagresseur.idBioagresseur = sensible.idBioagresseur)
                and idPlante = ". $unePlante->getIdPlante()."
                order by nomBioagresseur ASC";
        $res = DBConnex::getInstance()->query($sql);
        $resultat = $res->fetchAll(PDO::FETCH_BOTH);
        return $resultat;
    }
    
    
    
    
    
    
    
    
    
}
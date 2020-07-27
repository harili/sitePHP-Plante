<?php
class ObservationDAO{
    
    /*****************************************************/
    /*     Récupère un tableau d'observations            */
    /*****************************************************/
    public static function getObservations()
    {
        $result = [];
        $sql = "select * from observation";
        
        $liste = DBConnex::getInstance()->query($sql);
        $liste = $liste->fetchAll(PDO::FETCH_ASSOC);
        
        if(count($liste)> 0){
            foreach($liste as $observer){
                
                $objet = new Observation();
                $objet->hydrate($observer);
                
                $result[] = $objet;
            }
        }
        
        return $result;
    }
    
    /******************************************************************************************************/
    /*     Récupère un tableau d'observations avec un Id utilisateur rentré en paramètres                 */
    /******************************************************************************************************/
    
    public static function getObservationsIntervenant($idutil)
    {
        $result = [];
        $sql = "select * from observer where idIntervenant='".$idutil."'";
        
        $liste = dBConnex::getInstance()->query($sql);
        $liste = $liste->fetchAll(PDO::FETCH_ASSOC);
        
        if(count($liste)> 0){
            foreach($liste as $observer){
                
                $objet = new Observation();
                $objet->hydrate($observer);
                
                $result[] = $objet;
            }
        }
        
        return $result;
    }
    
    /**********************************************************************************/
    /*     Permet d'ajouter une observation dans la base de donnnées                  */
    /**********************************************************************************/
    
    public static function ajouterObservation(Observation $uneObservation){
        $sql = "insert into observation (idObservation,idPlante, idIntervenant, idBioagresseur, dateObservation, libelleObservation, coordoneeObservation) values (:idObservation, :idPlante, :idIntervenant, :idBioagresseur, :dateObservation, :libelleObservation, :coordoneesObservations);";
        $req = DBConnex::getInstance()->prepare($sql);
        $idObservation = $uneObservation->getIdObservation();
        $idBioagresseur = $uneObservation->getIdBioAgresseur();
        $idPlante = $uneObservation->getIdPlante();
        $idIntervant = $uneObservation->getIdIntervenant();
        $dateObservation = $uneObservation->getDate();
        $libelleObservation = $uneObservation->getLibObservation();
        $coordoneesObservations = $uneObservation->getCoordonneesObservations();
        $req->bindParam(":idObservation", $idObservation);
        $req->bindParam(":idBioagresseur", $idBioagresseur);
        $req->bindParam(":idPlante", $idPlante);
        $req->bindParam(":idIntervenant", $idIntervant);
        $req->bindParam(":dateObservation", $dateObservation);
        $req->bindParam(":libelleObservation", $libelleObservation);
        $req->bindParam(":coordoneesObservations", $coordoneesObservations);
        
        $req->execute();
        return $req->fetch();
    }
    
    /**********************************************************************************/
    /*     Permet de supprimer une observation dans la base de données                */
    /**********************************************************************************/
    
    public static function supprimerObservation(Observation $uneObservation){
        $sql = "delete from observation idObservation = :idObservation;";
        $req = DBConnex::getInstance()->prepare($sql);
        $idObservation = $uneObservation->getIdObservation();
        $req->bindParam(":idObservation", $idObservation);
        $req->execute();
        return $req->fetch();
    }
    
    /***********************************************************************************/
    /*     Permet de modifier une observation dans la base de données                  */
    /***********************************************************************************/
    
    public static function modifierObservation(Observation $uneObservation){
        $sql = "update observation SET coordoneeObservation = :coordoneeObservation, libelleObservation = :libelleObservation WHERE  idObservation = :idObservation";
        $req = dBConnex::getInstance()->prepare($sql);
        $idObservation = $uneObservation->getIdObservation();
        $libelleObservation = $uneObservation->getLibObservation();
        $coordoneesObservations = $uneObservation->getCoordonneesObservations();
        $req->bindParam(":idObservation", $idObservation);
        $req->bindParam(":libelleObservation", $libelleObservation);
        $req->bindParam(":coordoneesObservations", $coordoneesObservations);
        
        $req->execute();
        return $req->fetch();
    }
    
    public static function modifierObservation2($uneObservation, $uneIdPlante,
        $unIdIntervenant, $unIdBioagresseur, $uneDateObservation, $unLibelleObservation, $uneCoordoneeObservation){
            $sql = "update observation SET idPlante = ".$uneIdPlante." , idintervenant = ".$unIdIntervenant.",
idBioagresseur = ".$unIdBioagresseur.", dateObservation = ".$uneDateObservation.
" , libelleObservation = ".$unLibelleObservation." , coordoneeObservation = ".$uneCoordoneeObservation."
   WHERE  idObservation =".$uneObservation;
            $res = DBConnex::getInstance()->query($sql);
            $resultat = $res->fetch(PDO::FETCH_BOTH);
            return $resultat;
    }
    
    public static function modifierObservation3(Observation $uneObservation){
        $sql = "update observation SET idPlante =: idPlante , idIntervenant =: idIntervenant , idBioagresseur =: idBioagresseur, dateObservation =: dateObservation , coordoneeObservation = :coordoneeObservation, libelleObservation = :libelleObservation WHERE  idObservation = :idObservation";
        $req = dBConnex::getInstance()->prepare($sql);
        $idObservation = $uneObservation->getIdObservation();
        $idPlante = $uneObservation->getIdPlante();
        $idIntervenant = $uneObservation->getIdIntervenant();
        $idBioagresseur = $uneObservation->getIdBioAgresseur();
        $idObservation = $uneObservation->getIdObservation();
        $dateObservation = $uneObservation->getDateObservation();
        $libelleObservation = $uneObservation->getLibelleObservation();
        $coordoneeObservation = $uneObservation->getCoordoneeObservation();
        $req->bindParam(":idPlante", $idPlante);
        $req->bindParam(":idIntervenant", $idIntervenant);
        $req->bindParam(":idBioagresseur", $idBioagresseur);
        $req->bindParam(":dateObservation", $dateObservation);
        $req->bindParam(":idObservation", $idObservation);
        $req->bindParam(":libelleObservation", $libelleObservation);
        $req->bindParam(":coordoneeObservation", $coordoneeObservation);
        
        $req->execute();
        return $req->fetch();
    }
    
    public static function lire($idObservation){
        $sql = "select * from observation where idObservation = :idObservation";
        $req = dBConnex::getInstance()->prepare($sql);
        $req->bindParam(":idObservation", $idObservation);
        $req->execute();
        return $req->fetch();
    }
    
    public static function lireTout($idObservation){
        $sql = "select observation.* , nomBioagresseur, nomPlante, nomIntervenant
                FROM observation,plante,intervenant,bioagresseur
                WHERE observation.idIntervenant = intervenant.idIntervenant
                AND observation.idBioagresseur = bioagresseur.idBioagresseur
                AND plante.idPlante = observation.idPlante
                AND idObservation = :idObservation";
        $req = dBConnex::getInstance()->prepare($sql);
        $req->bindParam(":idObservation", $idObservation);
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
    
    public static function getLesRavageurs(Organe $unOrgane){
        $sql = "select *
                from bioagresseur, ba_ravageur, affecter
                where (bioagresseur.idBioagresseur = ba_ravageur.idBioagresseur
                and bioagresseur.idBioagresseur = affecter.idBioagresseur)
                and idOrgane = :idOrgane";
        $req = dBConnex::getInstance()->prepare($sql);
        $idOrgane = $unOrgane->getIdOrgane();
        $req->bindParam(":idOrgane", $idOrgane);
        $req->execute();
        
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    public static function  getLesMaladies(Organe $unOrgane){
        $sql = "select *
                from bioagresseur, ba_maladie, affecter
                where (bioagresseur.idBioagresseur = ba_maladie.idBioagresseur
                and bioagresseur.idBioagresseur = affecter.idBioagresseur)
                and idOrgane = ". $unOrgane->getIdOrgane();
        $res = DBConnex::getInstance()->query($sql);
        $resultat = $res->fetchAll(PDO::FETCH_ASSOC);
        return $resultat;
    }
    
    
    public static function getNomIntervenant($idIntervenant){
        $sql = "select nomIntervenant
                from intervenant
                where idIntervenant = ". $idIntervenant;
        $res = DBConnex::getInstance()->query($sql);
        $resultat = $res->fetch(PDO::FETCH_BOTH);
        return $resultat[0];
    }
    
    public static function getLibObsIntervenant($idIntervenant){
        $sql = "select libelleObservation
                from observation
                where idIntervenant = ". $idIntervenant;
        $res = DBConnex::getInstance()->query($sql);
        $resultat = $res->fetch(PDO::FETCH_BOTH);
        return $resultat[0];
    }
    
    public static function getDateObsIntervenant($idIntervenant){
        $sql = "select dateObservation
                from observation
                where idIntervenant = ". $idIntervenant;
        $res = DBConnex::getInstance()->query($sql);
        $resultat = $res->fetch(PDO::FETCH_BOTH);
        return $resultat[0];
    }
    
    public static function getCoordoneeObsIntervenant($idIntervenant){
        $sql = "select coordoneeObservation
                from observation
                where idIntervenant = ". $idIntervenant;
        $res = DBConnex::getInstance()->query($sql);
        $resultat = $res->fetch(PDO::FETCH_BOTH);
        return $resultat[0];
    }
    
    
    //public static function getLesUtilisateurs()
    
    public static function getBioagresseurObservation($idObservation){
        $sql = "select nomBioagresseur
                from bioagresseur, observation
                where observation.idBioagresseur = bioagresseur.idBioagresseur
                and idObservation = ". $idObservation;
        $res = DBConnex::getInstance()->query($sql);
        $resultat = $res->fetch(PDO::FETCH_BOTH);
        return $resultat[0];
    }
    
    public static function getPlanteIntervenant($idObservation){
        $sql = "select nomPlante
                from plante, observation
                where observation.idPlante = plante.idPlante
                and idObservation = ". $idObservation;
        $res = DBConnex::getInstance()->query($sql);
        $resultat = $res->fetch(PDO::FETCH_BOTH);
        return $resultat[0];
    }
    
    public static function getIntervenantNomId(){
        $sql = "select idIntervenant, nomIntervenant
                from intervenant";
        $res = DBConnex::getInstance()->query($sql);
        $resultat = $res->fetchAll(PDO::FETCH_BOTH);
        return $resultat;
    }
    public static function getBioagresseurNomId(){
        $sql = "select idBioagresseur, nomBioagresseur
                from bioagresseur";
        $res = DBConnex::getInstance()->query($sql);
        $resultat = $res->fetchAll(PDO::FETCH_BOTH);
        return $resultat;
    }
    public static function getPlanteNomId(){
        $sql = "select idPlante, nomPlante
                from plante";
        $res = DBConnex::getInstance()->query($sql);
        $resultat = $res->fetchAll(PDO::FETCH_BOTH);
        return $resultat;
    }
    
    public static function setIdIntervenantByNom($un){
        
    }
}
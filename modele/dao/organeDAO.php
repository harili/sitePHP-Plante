<?php
class OrganeDAO{
    
    // recupere toutes les informations de tout les organes
    public static function getOrganes()
    {
        $result = [];
        $sql = "select * from organe order by nomOrgane";
        $liste = DBConnex::getInstance()->query($sql);
        $liste = $liste->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($liste)){
            foreach($liste as $organe){
                $objet = new Organe();
                $objet->hydrate($organe);
                $result[] = $objet;
            }
        }
        return $result;
    }
    
    public static function lire($idOrgane){
        $sql = "select * from organe where idOrgane = :idOrgane";
        $req = dBConnex::getInstance()->prepare($sql);
        $req->bindParam(":idOrgane", $idOrgane);
        $req->execute();
        return $req->fetch();
    }
    
    //recupere le l'organe dont on met l'id en paramètre
    public static function getNomOrganeId($idOrgane){
        $sql = "select * from organe where idOrgane = :idOrgane";
        $req = dBConnex::getInstance()->prepare($sql);
        $req->bindParam(":idOrgane", $idOrgane);
        $req->execute();
        return $req->fetch();
    }
    
    
    
    //recupère l'id le plus élévé dans la table organe
    public static function maxID(){
        $sql = "select MAX(idOrgane) from organe";
        $res = DBConnex::getInstance()->query($sql);
        $resultat = $res->fetch();
        return $resultat[0];
    }
    
    
    //Ajoute un organe dans la base de données
    public static function ajouterOrgane(Organe $unOrgane){
        $sql = "insert into organe values (
                ". $unOrgane->getIdOrgane() .",
                '".$unOrgane->getNomOrgane()."')";
        return DBConnex::getInstance()->exec($sql);
    }
    
    
    public static function supprimerOrgane(Organe $unOrgane)
    {
        OrganeDAO::supprimerOrganeAffecter($unOrgane);
        
        $sql = "delete from organe where idOrgane = ".$unOrgane->getIdOrgane();
        return DBConnex::getInstance()->exec($sql);
    }
    
    //     Retourne les bioagresseurs qui ne sont PAS en relation avec l'organe mis en parametre
    public static function getLesBioagresseursNOT(Organe $unOrgane){
        $sql = "SELECT idBioagresseur , nomBioagresseur
                FROM bioagresseur
                WHERE idBioagresseur NOT IN ( SELECT idBioagresseur
                                             FROM affecter
                                             WHERE idOrgane = :idOrgane)
                ORDER BY nomBioagresseur ASC";
        $req = dBConnex::getInstance()->prepare($sql);
        $idOrgane = $unOrgane->getIdOrgane();
        $req->bindParam(":idOrgane", $idOrgane);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_BOTH);
    }
    
    //     Retourne les bioagresseurs qui SONT en relation avec l'organe mis en parametre
    public static function getLesBioagresseurs(Organe $unOrgane){
        $sql = "SELECT bioagresseur.idBioagresseur , nomBioagresseur
                FROM bioagresseur, affecter
                WHERE bioagresseur.idBioagresseur = affecter.idBioagresseur
                AND idOrgane = :idOrgane
                ORDER BY nomBioagresseur ASC";
        $req = dBConnex::getInstance()->prepare($sql);
        $idOrgane = $unOrgane->getIdOrgane();
        $req->bindParam(":idOrgane", $idOrgane);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_BOTH);
    }
    
    //ajoute un organe et le bio agresseur dont il appartient dans la table affecter
    public static function ajouterAffecter(Organe $unOrgane ,BioAgresseur $unBioagresseur){
        $sql = "insert into affecter (idOrgane, idBioagresseur) values (:idOrgane, :idBioagresseur);";
        $req = dBConnex::getInstance()->prepare($sql);
        $idOrgane = $unOrgane->getIdOrgane();
        $idBioagresseur = $unBioagresseur->getIdBioagresseur();
        $req->bindParam(":idOrgane", $idOrgane);
        $req->bindParam(":idBioagresseur", $idBioagresseur);
        
        $req->execute();
        return $req->fetch();
    }
    
    
    //supprime un bioagresseur de l'organe
    public static function supprimerOrganeAffecter(Organe $unOrgane)
    {
        $sql = "delete from affecter where idOrgane =
        ".$unOrgane->getIdOrgane();
        return DBConnex::getInstance()->exec($sql);
    }
    
    public static function supprimerOrganeUnAffecter(Organe $unOrgane, $idBioagresseur)
    {
        $sql = "delete from affecter where idOrgane =
        ".$unOrgane->getIdOrgane()." and idBioagresseur = ".$idBioagresseur;
        return DBConnex::getInstance()->exec($sql);
    } 
    
    public static function modifierOrgane(Organe $unOrgane){
        $sql = "update organe SET nomOrgane =
        '".$unOrgane->getNomOrgane()."' WHERE idOrgane=
        ".$unOrgane->getIdOrgane();
        
        return DBConnex::getInstance()->exec($sql);
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
    
    
    
    
    
    
    
    
    
}
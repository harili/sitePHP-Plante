<?php
class StatutDAO{
    
    public static function getStatut()
    {
        $result = [];
        $sql = "select * from statut ";
        $liste = DBConnex::getInstance()->query($sql);
        $liste = $liste->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($liste)){
            foreach($liste as $statut){
                $objet = new Statut();
                $objet->hydrate($statut);
                $result[] = $objet;
            }
        }
        return $result;
    }
    
    
    
    //recupere le libelle du statut dont on met le code en paramètre
    public static function getLibelleStatut($codeStatut){
        $sql = "select libelleStatut from statut where codeStatut= ':code'";
        $req = dBConnex::getInstance()->prepare($sql);
        $req->bindParam(":code", $codeStatut);
        $req->execute();
        return $req->fetch();
    }
    
    //recupere l'id du statut dont on met le nom en paramètre
    public static function getCodeStatut($libelle){
        $sql = "select codeStatut from statut where libelleStatut= ':libelle'";
        $req = dBConnex::getInstance()->prepare($sql);
        $req->bindParam(":libelle", $libelle);
        $req->execute();
        return $req->fetch();
    }
    
    //recupère l'id le plus élévé dans la table statut
    public static function maxID(){
        $sql = "select MAX(codeStatut) from statut";
        $req = dBConnex::getInstance()->prepare($sql);
        $req->execute();
        return $req->fetch();
    }
}
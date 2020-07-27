<?php

class IntervenantDAO{

    public static function identification(Intervenant $unIntervenant)
    {
        $sql = "select idIntervenant,libelleStatut,login,mdp from intervenant, statut where intervenant.codeStatut = statut.codeStatut login = :login and mdp= :mdp";
        $req = dBConnex::getInstance()->prepare($sql);
        $login = $unIntervenant->getLogin();
        $mdp = $unIntervenant->getMdp();
        $req->bindParam(":login", $login);
        $req->bindParam(":mdp", $mdp);
        
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }



    // recupere tout les intervenants
    public static function getUtilisateurs()
    {        
    	$result = [];
        $sql = "select * from intervenant order by nomIntervenant"; 
        $liste = DBConnex::getInstance()->query($sql); 
		$liste = $liste->fetchAll(PDO::FETCH_ASSOC);
		if(!empty($liste)){
            foreach($liste as $utilisateur){
            	$objet = new Intervenant();
            	$objet->hydrate($utilisateur);
            	$result[] = $objet;            	
            }
        }
        return $result;  
    }

    public static function maxID(){
        $sql = "select MAX(idIntervenant) from intervenant";
        $res = DBConnex::getInstance()->query($sql);
        $resultat = $res->fetch();
        return $resultat[0];
    }
    
    
    public static function checkLogin(Intervenant $intervenant)
    {
        $sql = "select count(*) from intervenant where login = :login";
        $req = dBConnex::getInstance()->prepare($sql);
        $login = $intervenant->getLogin();
        $req->bindParam(":login", $login);
        
        $req->execute();
        return $req->fetch()[0];
    }

    public static function ajouterIntervenant(Intervenant $unIntervenant){
    	$sql = "insert into intervenant (idIntervenant, login, mdp, codeStatut, prenomIntervenant, nomIntervenant) 
        values ('".$unIntervenant->getIdIntervenant()."'
        , '".$unIntervenant->getLogin()."'
        , '".md5($unIntervenant->getMdp())."'
        , '".$unIntervenant->getCodeStatut()."'
        , '".$unIntervenant->getNomIntervenant()."'
        , '".$unIntervenant->getPrenomIntervenant()."');";
        $req = dBConnex::getInstance()->prepare($sql);
        $req->execute();
        return $req->fetch();
    }
    
    //Supprime un utilisateur
    public static function supprimerIntervenant(Intervenant $unIntervenant)
    {
        $sql = "delete from intervenant where idIntervenant = :id";
        $req = dBConnex::getInstance()->prepare($sql);
        $id = $unIntervenant->getIdUtilisateur();
        $req->bindParam(":id", $id);
        $req->execute();
        return $req->fetch();
    }


    public static function modifierIntervenant(Intervenant $unIntervenant){
    	$sql = "update intervenant SET login = :login, mdp = :mdp, codeStatut = :codeStatut WHERE idIntervenant = :id";
        $req = dBConnex::getInstance()->prepare($sql);
        $id = $unIntervenant->getIdUtilisateur();
        $login = $unIntervenant->getLogin();
        $mdp = $unIntervenant->getMdp();
        $codeStatut = $unIntervenant->getCodeStatut();
        $req->bindParam(":id", $id);
        $req->bindParam(":login", $login);
        $req->bindParam(":mdp", $mdp);
        $req->bindParam(":codeStatut", $codeStatut);
        
        $req->execute();
        return $req->fetch();
    }
}

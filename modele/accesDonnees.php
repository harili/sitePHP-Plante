<?php 

    require_once 'configs/param.php';

    function connexion($dsn,$user, $pass) {
        try{
           $uneConnex = new PDO($dsn,$user, $pass);
           return $uneConnex;
        }catch (PDOException $e) {
            die("erreur de connexion ! " );
       }
    }

    function authentification($uneConnex, $unUtilisateur, $unMotDePasse){
        $sql = "select count(*) from intervenant where login ='". $unUtilisateur. "' and mdp ='".md5($unMotDePasse)."'";
        $result = $uneConnex->query($sql);
        $authentification = $result->fetchAll(PDO::FETCH_BOTH);
        return $authentification[0][0];
    }
    
    function intervenant($uneConnex, $unUtilisateur){
        $sql = "select * from intervenant where login ='". $unUtilisateur. "';";
        $result = $uneConnex->query($sql);
        $intervenant = $result->fetch(PDO::FETCH_BOTH);
        return $intervenant;
    }
    
?>
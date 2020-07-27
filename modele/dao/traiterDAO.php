<?php
class TraiterDAO{
    
    public static function getTraiter()
    {
        $result = [];
        $sql = "select * from traiter ";
        $liste = DBConnex::getInstance()->query($sql);
        $liste = $liste->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($liste)){
            foreach($liste as $traiter){
                $objet = new Traiter();
                $objet->hydrate($traiter);
                $result[] = $objet;
            }
        }
        return $result;
    }
}
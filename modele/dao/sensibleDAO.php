<?php
class SensibleDAO{
    
    public static function getSensible()
    {
        $result = [];
        $sql = "select * from sensible ";
        $liste = DBConnex::getInstance()->query($sql);
        $liste = $liste->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($liste)){
            foreach($liste as $sensible){
                $objet = new Sensible();
                $objet->hydrate($sensible);
                $result[] = $objet;
            }
        }
        return $result;
    }
}
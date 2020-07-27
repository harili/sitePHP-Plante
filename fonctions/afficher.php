<?php 
Class Afficher{
    public static function article($unStyle, $unTitre, $unContenu){
        $res ="<br/>";
        $res .= "
<div class='".$unStyle."'>";
        $res .="<div class='corps'>";
        $res .="<div class='elements'>";
        if(is_array($unContenu)){
            for($i = 0 ; $i < count($unContenu) ; $i++){
                $res .= $unContenu[$i];
            }
        }
        else {
            $res .= $unContenu;
        }
        $res .= "</div></div></div>";
        return $res;
    }
    
}
?>
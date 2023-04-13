<?php

class Helper {
    public static function surligneUneExpression ($expression, $chaine) {
        $pos1 = stripos($chaine, $expression);
        if ($pos1 !== false) {
            $pos2 = $pos1 + strlen("<mark>") + strlen($expression);
            $chaine = substr_replace($chaine, "<mark>", $pos1, 0);
            $chaine = substr_replace($chaine, "</mark>", $pos2, 0);
            return $chaine;
        } else {
            return $chaine;
        }
    }
}

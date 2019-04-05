<?php

declare(strict_types=1);

namespace App\Generator;

class PasswordGenerator {

    /**
     * @param int $nbChar Le nombre de caractères que l'on souhaite obtenir
     * @param float $numerals La proportion de caractères numériques (<= 1)
     * @param float $specials La proportion de caractères spéciaux (<= 1)
     * @return string
     */
    public function generate(int $nbChar, float $numerals, float $specials): string {
        // On utilise un tableau pour stocker les caractères de notre mot de passe
        $password = [];

        // On s'occupe d'abord des caractères numériques
        // On calcule le nombre de caractères
        $nbNum = intval($nbChar * $numerals);
        // On crée un tableau contenant les caractères possibles
        $tabNum = range(0, 9);

        for ($i = 0; $i < $nbNum; $i++) {
            // On tire un caractère au hazard dans le tableau
            $password[] = $tabNum[rand(0, count($tabNum) - 1)];
        }

        // On s'occupe ensuite des caractères spéciaux
        // Même méthode que précédemment
        $nbSpe = intval($nbChar * $specials);
        $tabSpe = ['&', '-', '@', '_', '+', ':'];

        for ($i = 0; $i < $nbSpe; $i++) {
            $password[] = $tabSpe[rand(0, count($tabSpe) - 1)];
        }

        // On s'occupe enfin des caractères alphabétiques
        $nbAlpha = $nbChar - $nbSpe - $nbNum;
        $tabAlpha = range('a', 'z') + range('A', 'Z');

        for ($i = 0; $i < $nbAlpha; $i++) {
            $password[] = $tabAlpha[rand(0, count($tabAlpha) - 1)];
        }

        // On mélange le tableau
        shuffle($password);

        // On concatène tous les caractères du tableau pour obtenir une chaîne
        return implode('', $password);
    }

}

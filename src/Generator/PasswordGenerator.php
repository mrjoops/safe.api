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

        // On remplace la boucle "for" par l'appel à la méthode "filler"
        $password = array_merge($password, $this->filler($nbNum, $tabNum));

        // On s'occupe ensuite des caractères spéciaux
        // Même méthode que précédemment
        $nbSpe = intval($nbChar * $specials);
        $tabSpe = ['&', '-', '@', '_', '+', ':'];

        $password = array_merge($password, $this->filler($nbSpe, $tabSpe));

        // On s'occupe enfin des caractères alphabétiques
        $nbAlpha = $nbChar - $nbSpe - $nbNum;
        $tabAlpha = range('a', 'z') + range('A', 'Z');

        $password = array_merge($password, $this->filler($nbAlpha, $tabAlpha));

        // On mélange le tableau
        shuffle($password);

        // On concatène tous les caractères du tableau pour obtenir une chaîne
        return implode('', $password);
    }

    /**
     * @param int $nb Le nombre de caractères à tirer au hazard
     * @param array $chars Les caractères possibles
     * @return array Un tableau de caractères tirés au hazard
     */
    private function filler(int $nb, array $chars): array {
        $result = [];

        for ($i = 0; $i < $nb; $i++) {
            $result[] = $chars[rand(0, count($chars) - 1)];
        }

        return $result;
    }

}

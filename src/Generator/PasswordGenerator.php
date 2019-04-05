<?php

declare(strict_types=1);

namespace App\Generator;

class PasswordGenerator {

    /**
     * @param int $nb Le nombre de caractères ou de mots que l'on souhaite obtenir
     * @param bool $pronunceable Si le mot de passe doit être prononçable
     * @param float $numerals La proportion de caractères numériques (<= 1)
     * @param float $specials La proportion de caractères spéciaux (<= 1)
     * @return string
     */
    public function generate(int $nb, bool $pronunceable, float $numerals, float $specials): string {
        if ($pronunceable) {
            return $this->generatePronunceable($nb);
        } else {
            return $this->generateNonPronunceable($nb, $numerals, $specials);
        }
    }

    /**
     * @param int $nbChar Le nombre de caractères que l'on souhaite obtenir
     * @param float $numerals La proportion de caractères numériques (<= 1)
     * @param float $specials La proportion de caractères spéciaux (<= 1)
     * @return string
     */
    private function generateNonPronunceable(int $nbChar, float $numerals, float $specials): string {
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
     * @param int $nbWord Le nombre de de mots que l'on souhaite obtenir
     * @return string
     */
    private function generatePronunceable(int $nbWord): string {
        // Un mot prononçable est dans notre algo un mot alternant consonnes et voyelles
        $tabVowels = ['a', 'e', 'i', 'o', 'u', 'y'];
        $tabConsonants = ['z', 'r', 't', 'p', 'q', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'w', 'x', 'c', 'v', 'b', 'n'];
        $tabNum = range(0, 9);
        $tabSpe = ['&', '-', '@', '_', '+', ':'];
        // On fera passer cette variable alternativement de true à false
        $switch = true;
        $password = '';

        for ($i = 0; $i < $nbWord; $i++) {
            // Les mots seront composés aléatoirement de 4 à 10 caractères
            $length = rand(4, 10);
            $word = [];

            for ($a = 0; $a < $length; $a++) {
                if ($switch) {
                    $word[] = $tabVowels[rand(0, count($tabVowels) - 1)];
                    // Cette manipulation permet de faire passer $switch de true à false...
                    $switch = false;
                } else {
                    $word[] = $tabConsonants[rand(0, count($tabConsonants) - 1)];
                    // ...et vice-versa
                    $switch = true;
                }
            }

            // On décide d'ajouter à chaque mot un caractère numérique et un caractère spécial
            $realWord = implode('', $word) . $this->filler(1, $tabNum)[0] . $this->filler(1, $tabSpe)[0];
            $password = $password . $realWord;
        }

        return $password;
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

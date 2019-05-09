<?php

declare(strict_types=1);

namespace App\Generator;

class PasswordGenerator
{
    /**
     * @param int   $count        Le nombre de caractères ou de mots que l'on souhaite obtenir
     * @param bool  $pronunceable Si le mot de passe doit être prononçable
     * @param float $numerals     La proportion de caractères numériques (<= 1)
     * @param float $specials     La proportion de caractères spéciaux (<= 1)
     *
     * @return string
     */
    public function generate(int $count, bool $pronunceable, float $numerals, float $specials): string
    {
        if ($pronunceable) {
            return $this->generatePronunceable($count);
        }

        return $this->generateNonPronunceable($count, $numerals, $specials);
    }

    /**
     * @param int   $nbChar   Le nombre de caractères que l'on souhaite obtenir
     * @param float $numerals La proportion de caractères numériques (<= 1)
     * @param float $specials La proportion de caractères spéciaux (<= 1)
     *
     * @return string
     */
    private function generateNonPronunceable(int $nbChar, float $numerals, float $specials): string
    {
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
     *
     * @return string
     */
    private function generatePronunceable(int $nbWord): string
    {
        // Un mot prononçable est dans notre algo un mot alternant consonnes et voyelles
        $tabVowels = ['a', 'e', 'i', 'o', 'u', 'y'];
        $tabConsonants = ['z', 'r', 't', 'p', 'q', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'w', 'x', 'c', 'v', 'b', 'n'];
        $tabNum = range(0, 9);
        $tabSpe = ['&', '-', '@', '_', '+', ':'];
        $password = '';

        for ($i = 0; $i < $nbWord; ++$i) {
            // Les mots seront composés aléatoirement de 4 à 10 caractères
            $length = rand(4, 10);
            $word = [];

            for ($a = 0; $a < $length; ++$a) {
                $word[] = $this->pickRandomChar(0 === $a % 2 ? $tabVowels : $tabConsonants);
            }

            // On décide d'ajouter à chaque mot un caractère numérique et un caractère spécial
            $realWord = implode('', $word).$this->pickRandomChar($tabNum).$this->pickRandomChar($tabSpe);
            $password = $password.$realWord;
        }

        return $password;
    }

    /**
     * @param int   $count Le nombre de caractères à tirer au hazard
     * @param array $chars Les caractères possibles
     *
     * @return array Un tableau de caractères tirés au hazard
     */
    private function filler(int $count, array $chars): array
    {
        $result = [];

        for ($i = 0; $i < $count; ++$i) {
            $result[] = $this->pickRandomChar($chars);
        }

        return $result;
    }

    /**
     * @param array $chars Les caractères possibles
     *
     * @return string Un caractère tiré au hazard
     */
    private function pickRandomChar(array $chars): string
    {
        return strval($chars[rand(0, count($chars) - 1)]);
    }
}

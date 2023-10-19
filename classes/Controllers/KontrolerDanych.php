<?php

namespace Pilkanozna\Controller;

class KontrolerDanych
{

    public static function getMetoda(string $slowo)
    {

        if (isset($_GET[$slowo])) return $_GET[$slowo];
        else return "";
    }

    // POBIERA ID Z LINKU
    public static function getID(): int
    {

        if (isset($_GET['id'])) return $_GET['id'];
        else return 0;
    }



    // POBIERA POLE Z FORMULARZA
    public function getPOST(string $nazwa): string
    {
        if(isset($_POST[$nazwa])) return $_POST[$nazwa];
        else return "";
    }

    // POBIERA I USTAWIA POLA Z FORMULARZA DO NOWEJ TABLICY
    public function setPOST(array $lista): array
    {
        $setPOST = array();
        foreach($lista as $element)
        {
            $setPOST[$element] = $this->getPOST($element);
        }

        return $setPOST;

    }

    // WYSWIETLA OBIEKT/FUNKCJE TESTOWO W PRZYSTEPNY SPOSOB
    public static function Testowanie($x): void
    {
        echo "<pre>";
        print_r($x);
        echo "</pre>";

    }
}


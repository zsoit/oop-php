<?php

namespace Pilkanozna\Controller;


interface IKontrolerDanych
{
    public static function getMetoda(string $slowo); // POBIERA POLE Z FORMULARZA METODĄ GET
    public static function getID(): int;  // POBIERA ID Z LINKU
    public function getPOST(string $nazwa): string; // POBIERA POLE Z FORMULARZA METODĄ POST
    public function setPOST(array $lista): array;  // POBIERA I USTAWIA POLA Z FORMULARZA DO NOWEJ TABLICY

}


class KontrolerDanych implements IKontrolerDanych
{

    public static function getMetoda(string $slowo)
    {
        return (isset($_GET[$slowo])) ? $_GET[$slowo] :  "";
    }

   
    public static function getID(): int
    {
        return (isset($_GET['id'])) ? $_GET['id'] : 0;
    }

    
    public function getPOST(string $nazwa): string
    {
        return (isset($_POST[$nazwa])) ? $_POST[$nazwa] : "";

    }

    
    public function setPOST(array $lista): array
    {
        $setPOST = array();

        foreach($lista as $element) 
            $setPOST[$element] = $this->getPOST($element);

        return $setPOST;

    }
}


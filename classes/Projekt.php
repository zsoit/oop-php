<?php
// klasa do uruchamnia projektu

namespace Pilkanozna;


include_once "./classes/Controllers/KontrolerStrony.php";
include_once "./classes/Views/StronaHtml.php";


class Projekt
{
    public static function Uruchom(): void
    {
        $Aplikacja = new KontrolerStrony;
        $Strona = new StronaHtml;
        
        
        $Strona->Head();
        $Strona->Header();
        $Aplikacja->Routing();
        $Strona->Footer();
    }


}
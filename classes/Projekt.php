<?php
// klasa do uruchamnia projektu
namespace Pilkanozna;

use Pilkanozna\Controllers\KontrolerStrony;
use Pilkanozna\Views\StronaHtml;

final class Projekt
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
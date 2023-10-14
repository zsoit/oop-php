<?php
use Pilkanozna\Projekt;


include_once 'classes/FileLoader.php';
include_once './classes/Projekt.php';

// kolejnosc ladowania - nie zmieniac

Fl::Models("BazaDanych");
Fl::Models("ZapytaniaSql");
Fl::Models("Aplikacja");

Fl::Controllers("KontrolerDanych");
Fl::Controllers("Autoryzacja");
Fl::Controllers("KontrolerStrony");

Fl::Views("SzablonHtml");
Fl::Views("StronaHtml");


Projekt::Uruchom();





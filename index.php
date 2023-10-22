<?php
use Pilkanozna\Projekt;


include_once './classes/FileLoader.php';
include_once './classes/Projekt.php';

// kolejnosc ladowania - nie zmieniac

Fl::Controllers("PilkarzPost");
Fl::Models("BazaDanych");
Fl::Helpers("BazaDanychHelper");
Fl::Models("FiltrowanieSql");
Fl::Models("ZapytaniaSql");
Fl::Helpers("FormularzHelper");

Fl::Controllers("ZarzadzaniePilkarzami");
Fl::Models("WyswietlaniePilkarzy");
Fl::Models("OperacjePilkarzy");

Fl::Models("Aplikacja");

Fl::Controllers("KontrolerDanych");
Fl::Controllers("Autoryzacja");
Fl::Controllers("KontrolerStrony");


Fl::Models("PobieraczObrazowWikipedia");
Fl::Views("SzablonHtml");
Fl::Views("StronaHtml");


Projekt::Uruchom();





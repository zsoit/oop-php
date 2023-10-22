<?php

namespace Pilkanozna\Models;


use Pilkanozna\Views\SzablonHtml;
use Pilkanozna\Models\WyswietlaniePilkarzy;
use Pilkanozna\Models\OperacjePilkarzy;


class Aplikacja 
{

    private object $Operacja;
    private object $Wyswietalnie;

    private object $SzablonHtml;

    private $naglowek;
    private $zawodnik;
    private $potwierdzUsuniecie;



    public function __construct()
    {

        $this->Operacja = new OperacjePilkarzy();
        $this->Wyswietalnie = new WyswietlaniePilkarzy();
        $this->SzablonHtml = new SzablonHtml();

        $this->naglowek = [$this->SzablonHtml, 'Naglowek'];
        $this->zawodnik = [$this->SzablonHtml, 'Zawodnik'];
        $this->potwierdzUsuniecie = [$this->SzablonHtml, 'PotwierdzUsuniecie'];

    }

    protected function Wyswietl(): void
    {
        $this->Wyswietalnie->WyswietlPilkarzy($this->naglowek,$this->zawodnik);      
    }

    protected function Usun(): void
    {
        $this->Operacja->UsunPilkarza($this->naglowek,$this->potwierdzUsuniecie);
    }

    protected function Edytuj(): void
    {
        $this->SzablonHtml->Naglowek("EDYCJA");
        $this->Wyswietalnie->WyswietlFomularzEdycji();
    }

    protected function Zapisz(): void
    {
        $this->Operacja->ZapiszPilkarza($this->naglowek);
        header( "refresh:1;url=/" );
        $this->Wyswietl();
    }


    protected function Formularz_Dodaj(): void
    {
        $this->SzablonHtml->Naglowek("Dodawanie");
        $this->Wyswietalnie->WyswietlFormularzDodawania();
    }

    protected function Dodaj(): void
    {
 
        $this->Operacja->DodajPilkarza($this->naglowek);
        header( "refresh:1;url=/" );
        $this->Wyswietl();
      
    }


    private function Filtry(): void
    {
        $this->SzablonHtml->Naglowek("Filtry");
        $this->Operacja->FiltrujPilkarzy();
        $this->SzablonHtml->Naglowek("Wyniki wyszukiwania:  <b id='szukanypilkarz'></b>");
    }


    protected function Szukaj(): void
    {
        $this->Filtry();
        $this->Wyswietalnie->WyswietlFiltrowanychPilkarzy($this->naglowek, $this->zawodnik);
    
    }


    protected function Zaloguj(): void
    {

        $this->SzablonHtml->Naglowek("Zaloguj się");
        $this->SzablonHtml->FormularzLogowania();

    }

    protected function Error404(): void
    {
        $this->SzablonHtml->Naglowek("404 - Strona nie istnieje! ");
    }


}

